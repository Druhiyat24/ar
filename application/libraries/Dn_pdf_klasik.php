<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Mengubah PDF ber-cross-reference STREAM (PDF 1.5+) menjadi PDF dengan
 * cross-reference TABEL klasik, supaya bisa dibaca FPDI versi gratis.
 *
 * Kenapa perlu: sejak PDF 1.5 daftar objek boleh disimpan sebagai stream
 * terkompresi (dan objeknya sendiri boleh ditumpuk di dalam "object stream").
 * Parser bawaan FPDI yang gratis tidak membaca bentuk itu, padahal file-nya
 * normal-normal saja dibuka di browser. Banyak invoice dari pihak luar
 * (scanner kantor, Word, Acrobat) berbentuk begini.
 *
 * Yang dilakukan: isi file dibaca ulang, semua objek dikeluarkan apa adanya
 * (byte-nya disalin, TIDAK ditulis ulang), lalu disusun kembali dengan tabel
 * xref klasik. Karena badan objek tidak pernah diutak-atik, isi halaman tidak
 * berubah - yang berubah cuma cara objeknya didaftarkan.
 *
 * PENTING: kelas ini tidak menjamin berhasil untuk semua PDF. Pemanggilnya
 * WAJIB memverifikasi hasilnya (buka dengan FPDI, cocokkan jumlah halaman) dan
 * kalau gagal kembali ke perilaku lama - lihat Dn_pdf_gabung.
 */
class Dn_pdf_klasik
{
    /** Di atas ini tidak dikonversi: butuh memori beberapa kali ukuran file. */
    const BATAS_BYTE = 31457280; // 30 MB

    /** Penjaga supaya file rusak tidak bikin loop /Prev tak berujung. */
    const MAKS_XREF = 64;

    private $isi = '';
    private $xref = array();      // nomor => array('tipe', 'a', 'b')
    private $trailer = array();
    private $sudah = array();     // offset xref yang sudah dibaca

    /**
     * @param  string $sumber Path PDF asal.
     * @param  string $tujuan Path hasil konversi.
     * @return bool   true kalau file hasil berhasil ditulis.
     */
    public function ubah($sumber, $tujuan)
    {
        if (!is_file($sumber) || filesize($sumber) > self::BATAS_BYTE) {
            return false;
        }

        $this->isi = (string) file_get_contents($sumber);
        $this->xref = array();
        $this->trailer = array();
        $this->sudah = array();

        if ($this->isi === '' || strpos($this->isi, '%PDF-') !== 0) {
            return false;
        }

        // PDF terenkripsi tidak ditangani: badan objeknya perlu didekripsi dulu,
        // dan itu di luar lingkup konverter ini.
        if (preg_match('/\/Encrypt\s/', $this->isi)) {
            return false;
        }

        $awal = $this->offset_startxref();
        if ($awal === null || !$this->baca_xref($awal)) {
            return false;
        }
        if (empty($this->xref) || !isset($this->trailer['root'])) {
            return false;
        }

        $badan = $this->kumpulkan_objek();
        if (!$badan) {
            return false;
        }

        return $this->tulis($badan, $tujuan);
    }

    // ---------------------------------------------------------------- xref --

    /** Offset xref terakhir, dari "startxref" paling belakang. */
    private function offset_startxref()
    {
        $pos = strrpos($this->isi, 'startxref');
        if ($pos === false) {
            return null;
        }
        if (!preg_match('/startxref\s+(\d+)/', substr($this->isi, $pos, 64), $m)) {
            return null;
        }
        return (int) $m[1];
    }

    /**
     * Membaca satu cross-reference stream, lalu mengikuti rantai /Prev
     * (berkas yang pernah disimpan ulang punya beberapa xref bertingkat).
     * Entri yang dibaca duluan menang - itu versi objek yang paling baru.
     */
    private function baca_xref($offset)
    {
        if ($offset <= 0 || $offset >= strlen($this->isi)) {
            return false;
        }
        if (isset($this->sudah[$offset]) || count($this->sudah) >= self::MAKS_XREF) {
            return true;
        }
        $this->sudah[$offset] = true;

        $objek = $this->objek_di($offset);
        if ($objek === null) {
            return false;
        }
        list($dict, $stream) = $objek;

        if (strpos($dict, '/XRef') === false) {
            return false; // xref klasik: tidak perlu dikonversi
        }

        if (!preg_match('/\/W\s*\[\s*(\d+)\s+(\d+)\s+(\d+)\s*\]/', $dict, $m)) {
            return false;
        }
        $w = array((int) $m[1], (int) $m[2], (int) $m[3]);
        $lebar = $w[0] + $w[1] + $w[2];
        if ($lebar <= 0) {
            return false;
        }

        $data = $this->buka_stream($dict, $stream);
        if ($data === null) {
            return false;
        }
        $data = $this->lepas_predictor($dict, $data, $lebar);
        if ($data === null) {
            return false;
        }

        if (preg_match('/\/Size\s+(\d+)/', $dict, $m) && !isset($this->trailer['size'])) {
            $this->trailer['size'] = (int) $m[1];
        }
        if (preg_match('/\/Root\s+(\d+)\s+(\d+)\s+R/', $dict, $m) && !isset($this->trailer['root'])) {
            $this->trailer['root'] = $m[1] . ' ' . $m[2];
        }
        if (preg_match('/\/Info\s+(\d+)\s+(\d+)\s+R/', $dict, $m) && !isset($this->trailer['info'])) {
            $this->trailer['info'] = $m[1] . ' ' . $m[2];
        }

        // /Index menentukan nomor objek mana saja yang didaftar di stream ini.
        $indeks = array();
        if (preg_match('/\/Index\s*\[([\d\s]+)\]/', $dict, $m)) {
            $angka = preg_split('/\s+/', trim($m[1]));
            for ($i = 0; $i + 1 < count($angka); $i += 2) {
                $indeks[] = array((int) $angka[$i], (int) $angka[$i + 1]);
            }
        } else {
            $indeks[] = array(0, isset($this->trailer['size']) ? $this->trailer['size'] : 0);
        }

        $p = 0;
        $panjang = strlen($data);
        foreach ($indeks as $bagian) {
            list($mulai, $jumlah) = $bagian;
            for ($i = 0; $i < $jumlah; $i++) {
                if ($p + $lebar > $panjang) {
                    break 2;
                }
                $baris = substr($data, $p, $lebar);
                $p += $lebar;

                $tipe = $w[0] === 0 ? 1 : $this->angka(substr($baris, 0, $w[0]));
                $a    = $this->angka(substr($baris, $w[0], $w[1]));
                $b    = $this->angka(substr($baris, $w[0] + $w[1], $w[2]));

                $no = $mulai + $i;
                if ($no > 0 && !isset($this->xref[$no]) && ($tipe === 1 || $tipe === 2)) {
                    $this->xref[$no] = array('tipe' => $tipe, 'a' => $a, 'b' => $b);
                }
            }
        }

        if (preg_match('/\/Prev\s+(\d+)/', $dict, $m)) {
            $this->baca_xref((int) $m[1]);
        }

        return true;
    }

    /** Bilangan big-endian dari sejumlah byte. */
    private function angka($bytes)
    {
        $n = 0;
        $len = strlen($bytes);
        for ($i = 0; $i < $len; $i++) {
            $n = ($n << 8) + ord($bytes[$i]);
        }
        return $n;
    }

    // --------------------------------------------------------------- objek --

    /**
     * Objek pada suatu offset, dipecah jadi array(dict, stream).
     * Panjang stream diambil dari /Length (kalau nilainya tidak langsung,
     * dicari ke objek yang dirujuk), bukan dari mencari kata "endstream" -
     * data biner bisa saja mengandung kata itu.
     */
    private function objek_di($offset)
    {
        if ($offset < 0 || $offset >= strlen($this->isi)) {
            return null;
        }
        $cuil = substr($this->isi, $offset, 64);
        if (!preg_match('/^\s*(\d+)\s+(\d+)\s+obj/', $cuil, $m)) {
            return null;
        }
        $mulai = $offset + strlen($m[0]);

        $posStream = strpos($this->isi, 'stream', $mulai);
        $posEnd    = strpos($this->isi, 'endobj', $mulai);
        if ($posEnd === false) {
            return null;
        }

        // Tidak ada stream: seluruh badan objek adalah dict/nilai biasa.
        if ($posStream === false || $posStream > $posEnd) {
            return array(rtrim(substr($this->isi, $mulai, $posEnd - $mulai)), null);
        }

        $dict = rtrim(substr($this->isi, $mulai, $posStream - $mulai));
        $awalData = $posStream + 6;
        // Setelah kata "stream" boleh ada CRLF atau LF (spec PDF 7.3.8.1).
        if (substr($this->isi, $awalData, 2) === "\r\n") {
            $awalData += 2;
        } elseif (substr($this->isi, $awalData, 1) === "\n" || substr($this->isi, $awalData, 1) === "\r") {
            $awalData += 1;
        }

        $panjang = $this->panjang_stream($dict);
        if ($panjang === null) {
            $posAkhir = strpos($this->isi, 'endstream', $awalData);
            if ($posAkhir === false) {
                return null;
            }
            $panjang = $posAkhir - $awalData;
        }

        return array($dict, substr($this->isi, $awalData, $panjang));
    }

    /** Nilai /Length, termasuk kalau bentuknya rujukan ke objek lain. */
    private function panjang_stream($dict)
    {
        if (preg_match('/\/Length\s+(\d+)\s+(\d+)\s+R/', $dict, $m)) {
            $no = (int) $m[1];
            if (isset($this->xref[$no]) && $this->xref[$no]['tipe'] === 1) {
                $cuil = substr($this->isi, $this->xref[$no]['a'], 128);
                if (preg_match('/^\s*\d+\s+\d+\s+obj\s*(\d+)/', $cuil, $mm)) {
                    return (int) $mm[1];
                }
            }
            return null;
        }
        if (preg_match('/\/Length\s+(\d+)/', $dict, $m)) {
            return (int) $m[1];
        }
        return null;
    }

    /** Membuka stream ber-FlateDecode (satu-satunya yang dipakai xref/ObjStm). */
    private function buka_stream($dict, $stream)
    {
        if ($stream === null) {
            return null;
        }
        if (strpos($dict, '/FlateDecode') === false) {
            return $stream;
        }
        $hasil = @gzuncompress($stream);
        if ($hasil === false) {
            $hasil = @gzinflate($stream);           // sebagian penulis PDF tidak pakai header zlib
        }
        if ($hasil === false) {
            $hasil = @gzinflate(substr($stream, 1)); // jaga-jaga byte pertama rusak
        }
        return $hasil === false ? null : $hasil;
    }

    /** Melepas PNG predictor kalau stream memakainya. */
    private function lepas_predictor($dict, $data, $lebar)
    {
        if (!preg_match('/\/Predictor\s+(\d+)/', $dict, $m)) {
            return $data;
        }
        $predictor = (int) $m[1];
        if ($predictor < 10) {
            return $data;
        }
        $kolom = preg_match('/\/Columns\s+(\d+)/', $dict, $mm) ? (int) $mm[1] : $lebar;
        if ($kolom <= 0) {
            return null;
        }

        $hasil = '';
        $sebelum = str_repeat("\x00", $kolom);
        $langkah = $kolom + 1;
        $panjang = strlen($data);

        for ($p = 0; $p + $langkah <= $panjang; $p += $langkah) {
            $jenis = ord($data[$p]);
            $baris = substr($data, $p + 1, $kolom);
            $keluar = '';
            for ($i = 0; $i < $kolom; $i++) {
                $x  = ord($baris[$i]);
                $a  = $i > 0 ? ord($keluar[$i - 1]) : 0;
                $b  = ord($sebelum[$i]);
                $c  = $i > 0 ? ord($sebelum[$i - 1]) : 0;
                switch ($jenis) {
                    case 0: $nilai = $x; break;
                    case 1: $nilai = $x + $a; break;
                    case 2: $nilai = $x + $b; break;
                    case 3: $nilai = $x + (int) (($a + $b) / 2); break;
                    case 4:
                        $p0 = $a + $b - $c;
                        $pa = abs($p0 - $a);
                        $pb = abs($p0 - $b);
                        $pc = abs($p0 - $c);
                        $nilai = $x + (($pa <= $pb && $pa <= $pc) ? $a : ($pb <= $pc ? $b : $c));
                        break;
                    default: return null;
                }
                $keluar .= chr($nilai & 0xFF);
            }
            $hasil .= $keluar;
            $sebelum = $keluar;
        }

        return $hasil;
    }

    /**
     * Semua objek beserta badannya: yang biasa disalin dari file, yang
     * terkompresi dikeluarkan dulu dari object stream-nya.
     * @return array nomor => array('gen' => int, 'badan' => string)
     */
    private function kumpulkan_objek()
    {
        $hasil = array();
        $cacheObjStm = array();
        $lewati = array();   // ObjStm & XRef tidak perlu ikut di file hasil

        foreach ($this->xref as $no => $e) {
            if ($e['tipe'] === 1) {
                $objek = $this->objek_di($e['a']);
                if ($objek === null) {
                    continue;
                }
                list($dict, $stream) = $objek;
                if (strpos($dict, '/ObjStm') !== false || strpos($dict, '/XRef') !== false) {
                    $lewati[$no] = true;
                    continue;
                }
                $badan = $stream === null
                    ? $dict
                    : $dict . "\nstream\n" . $stream . "\nendstream";
                $hasil[$no] = array('gen' => $e['b'], 'badan' => $badan);
            } elseif ($e['tipe'] === 2) {
                $indukNo = $e['a'];
                if (!isset($cacheObjStm[$indukNo])) {
                    $cacheObjStm[$indukNo] = $this->isi_objstm($indukNo);
                }
                $isiStm = $cacheObjStm[$indukNo];
                if (isset($isiStm[$no])) {
                    // Objek di dalam object stream selalu bergenerasi 0.
                    $hasil[$no] = array('gen' => 0, 'badan' => $isiStm[$no]);
                }
            }
        }

        foreach ($lewati as $no => $_) {
            unset($hasil[$no]);
        }

        return $hasil;
    }

    /**
     * Membongkar sebuah object stream jadi nomor => badan objek.
     * Bentuknya: /First byte pertama berisi pasangan "nomor offset", sisanya
     * badan objek yang ditempel berurutan.
     */
    private function isi_objstm($no)
    {
        if (!isset($this->xref[$no]) || $this->xref[$no]['tipe'] !== 1) {
            return array();
        }
        $objek = $this->objek_di($this->xref[$no]['a']);
        if ($objek === null) {
            return array();
        }
        list($dict, $stream) = $objek;
        if (strpos($dict, '/ObjStm') === false) {
            return array();
        }

        $data = $this->buka_stream($dict, $stream);
        if ($data === null) {
            return array();
        }
        if (!preg_match('/\/N\s+(\d+)/', $dict, $mN) || !preg_match('/\/First\s+(\d+)/', $dict, $mF)) {
            return array();
        }
        $jumlah = (int) $mN[1];
        $first  = (int) $mF[1];
        if ($first > strlen($data)) {
            return array();
        }

        $kepala = substr($data, 0, $first);
        $angka = preg_split('/\s+/', trim($kepala));
        if (count($angka) < $jumlah * 2) {
            return array();
        }

        $pasangan = array();
        for ($i = 0; $i < $jumlah; $i++) {
            $pasangan[] = array((int) $angka[$i * 2], (int) $angka[$i * 2 + 1]);
        }

        $hasil = array();
        for ($i = 0; $i < $jumlah; $i++) {
            $mulai = $first + $pasangan[$i][1];
            $akhir = ($i + 1 < $jumlah) ? $first + $pasangan[$i + 1][1] : strlen($data);
            if ($mulai >= strlen($data) || $akhir <= $mulai) {
                continue;
            }
            $hasil[$pasangan[$i][0]] = trim(substr($data, $mulai, $akhir - $mulai));
        }

        return $hasil;
    }

    // --------------------------------------------------------------- tulis --

    /** Menyusun ulang jadi PDF 1.4 dengan tabel xref klasik. */
    private function tulis(array $badan, $tujuan)
    {
        ksort($badan);
        $maks = max(array_keys($badan));
        $size = $maks + 1;

        $keluar = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offset = array();

        foreach ($badan as $no => $o) {
            $offset[$no] = strlen($keluar);
            $keluar .= $no . ' ' . $o['gen'] . " obj\n" . $o['badan'] . "\nendobj\n";
        }

        $awalXref = strlen($keluar);
        $keluar .= "xref\n0 " . $size . "\n";
        $keluar .= "0000000000 65535 f \n";
        for ($no = 1; $no < $size; $no++) {
            if (isset($offset[$no])) {
                $keluar .= sprintf("%010d %05d n \n", $offset[$no], $badan[$no]['gen']);
            } else {
                $keluar .= "0000000000 65535 f \n";
            }
        }

        $trailer = "trailer\n<</Size " . $size . "/Root " . $this->trailer['root'] . ' R';
        if (isset($this->trailer['info'])) {
            $trailer .= '/Info ' . $this->trailer['info'] . ' R';
        }
        $trailer .= ">>\nstartxref\n" . $awalXref . "\n%%EOF\n";

        return @file_put_contents($tujuan, $keluar . $trailer) !== false;
    }
}
