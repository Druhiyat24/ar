<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Penulis berkas .xlsx seadanya - beberapa lembar dalam satu berkas.
 *
 * KENAPA DITULIS SENDIRI
 *   Unduhan lain di aplikasi ini mengirim HTML dengan tipe
 *   application/vnd.ms-excel. Cara itu cuma sanggup SATU lembar, padahal
 *   laporan realisasi AR harus keluar empat lembar sekaligus.
 *
 *   PHPExcel memang masih ada di application/third_party, tapi sudah tidak
 *   jalan di PHP 8: Shared/String.php memakai $teks{0} - sintaks kurung
 *   kurawal yang dicabut sejak PHP 8.0 - jadi berkasnya fatal error begitu
 *   dimuat. Menggantinya dengan PhpSpreadsheet berarti menambah dependensi
 *   baru ke composer; untuk kebutuhan sesederhana ini tidak sepadan.
 *
 *   Sebuah .xlsx sendiri cuma ZIP berisi beberapa berkas XML, dan ZipArchive
 *   sudah menyala di server ini. Yang ditulis di sini bagian paling kecil
 *   yang Excel terima: tanpa sharedStrings (teksnya ditulis langsung di
 *   selnya), tanpa rumus, tanpa gambar.
 *
 * CARA PAKAI
 *   $x = new Xlsx_ringkas();
 *   $x->lembar('Executive Summary', $baris, array(34, 22, 40), 5);
 *   $x->kirim('AR Collection Realization.xlsx');
 *
 *   $baris  array baris; tiap baris array sel
 *   sel     nilai biasa, atau array('v' => nilai, 's' => gaya, 't' => jenis)
 *           jenis: 'n' angka, 's' teks, 'd' tanggal (Y-m-d), '' tebak sendiri
 *   gaya    lihat daftar GAYA di bawah
 *   lebar   lebar kolom, dalam satuan karakter
 *   beku    berapa baris kepala yang dibekukan (0 = tidak)
 */
class Xlsx_ringkas
{
    /**
     * Daftar gaya selnya. Urutannya PENTING: nomor urut di sini yang ditulis
     * ke atribut s="" tiap sel, dan dipasangkan ke cellXfs di styles.xml.
     */
    private static $GAYA = array(
        '',             // 0 biasa
        'judul',        // 1 tebal, besar
        'kepala',       // 2 kepala tabel: tebal, berlatar, bergaris, di tengah
        'tebal',        // 3
        'tengah',       // 4
        'angka',        // 5 #,##0.00
        'angka0',       // 6 #,##0
        'persen',       // 7 0.00%
        'tanggal',      // 8 dd mmm yyyy
        'tebal_angka',  // 9
        'kepala_hijau', // 10 kepala kelompok Projection
        'kepala_biru',  // 11 kepala kelompok Realization
        'kepala_kuning',// 12 kepala kelompok Result
    );

    private $lembar = array();

    /**
     * @param string $nama  nama tab-nya di Excel
     * @param array  $baris array baris, tiap baris array sel
     * @param array  $lebar lebar kolom berurutan dari kolom A
     * @param int    $beku  jumlah baris kepala yang dibekukan
     * @param array  $gabung daftar rentang yang digabung, mis. array('A1:C1')
     */
    public function lembar($nama, $baris, $lebar = array(), $beku = 0, $gabung = array())
    {
        $this->lembar[] = array(
            'nama'   => $this->nama_aman($nama),
            'baris'  => $baris,
            'lebar'  => $lebar,
            'beku'   => (int) $beku,
            'gabung' => $gabung,
        );
        return $this;
    }

    /** Berkasnya dikirim langsung ke peramban sebagai unduhan. */
    public function kirim($nama_berkas)
    {
        $tmp = tempnam(sys_get_temp_dir(), 'xlsx');
        $this->simpan($tmp);

        if (ob_get_length()) { ob_end_clean(); }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $nama_berkas . '"');
        header('Content-Length: ' . filesize($tmp));
        header('Cache-Control: max-age=0');
        readfile($tmp);
        @unlink($tmp);
    }

    public function simpan($berkas)
    {
        if (!$this->lembar) { $this->lembar('Sheet1', array()); }

        $zip = new ZipArchive();
        @unlink($berkas);
        if ($zip->open($berkas, ZipArchive::CREATE) !== true) {
            throw new RuntimeException('tidak bisa membuat berkas xlsx: ' . $berkas);
        }

        $zip->addFromString('[Content_Types].xml', $this->xml_tipe());
        $zip->addFromString('_rels/.rels', $this->xml_rels_akar());
        $zip->addFromString('xl/workbook.xml', $this->xml_buku());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->xml_rels_buku());
        $zip->addFromString('xl/styles.xml', $this->xml_gaya());
        foreach ($this->lembar as $i => $l) {
            $zip->addFromString('xl/worksheets/sheet' . ($i + 1) . '.xml', $this->xml_lembar($l));
        }
        $zip->close();
        return $berkas;
    }

    /* ------------------------------------------------------------------ */

    /**
     * Nama lembar yang Excel terima: maksimal 31 huruf, dan tujuh tanda baca
     * ini dilarang. Nama yang melanggar bikin berkasnya ditolak sama sekali,
     * bukan sekadar dibetulkan sendiri.
     */
    private function nama_aman($nama)
    {
        $nama = str_replace(array('\\', '/', '?', '*', '[', ']', ':'), '-', (string) $nama);
        return mb_substr($nama, 0, 31);
    }

    private function esc($t)
    {
        return htmlspecialchars((string) $t, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    /** Nomor kolom (1 = A) jadi hurufnya. */
    public static function huruf_kolom($n)
    {
        $s = '';
        while ($n > 0) {
            $sisa = ($n - 1) % 26;
            $s = chr(65 + $sisa) . $s;
            $n = (int) (($n - $sisa - 1) / 26);
        }
        return $s;
    }

    /**
     * Tanggal 'Y-m-d' jadi angka hari ala Excel.
     * Titik nolnya 1899-12-30, dan dihitung di UTC supaya tidak bergeser
     * sehari gara-gara zona waktu server.
     */
    private function hari_excel($tgl)
    {
        $t = strtotime($tgl . ' 00:00:00 UTC');
        if ($t === false) { return null; }
        return (int) floor($t / 86400) + 25569;
    }

    private function nomor_gaya($nama)
    {
        $i = array_search((string) $nama, self::$GAYA, true);
        return $i === false ? 0 : $i;
    }

    private function xml_lembar($l)
    {
        $x = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
           . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';

        if ($l['beku'] > 0) {
            $x .= '<sheetViews><sheetView workbookViewId="0">'
                . '<pane ySplit="' . $l['beku'] . '" topLeftCell="A' . ($l['beku'] + 1) . '"'
                . ' activePane="bottomLeft" state="frozen"/>'
                . '</sheetView></sheetViews>';
        }

        if ($l['lebar']) {
            $x .= '<cols>';
            foreach ($l['lebar'] as $i => $w) {
                $x .= '<col min="' . ($i + 1) . '" max="' . ($i + 1) . '"'
                    . ' width="' . (float) $w . '" customWidth="1"/>';
            }
            $x .= '</cols>';
        }

        $x .= '<sheetData>';
        foreach ($l['baris'] as $nb => $baris) {
            $nomor = $nb + 1;
            $x .= '<row r="' . $nomor . '">';
            foreach ((array) $baris as $nk => $sel) {
                $x .= $this->xml_sel(self::huruf_kolom($nk + 1) . $nomor, $sel);
            }
            $x .= '</row>';
        }
        $x .= '</sheetData>';

        if ($l['gabung']) {
            $x .= '<mergeCells count="' . count($l['gabung']) . '">';
            foreach ($l['gabung'] as $g) { $x .= '<mergeCell ref="' . $this->esc($g) . '"/>'; }
            $x .= '</mergeCells>';
        }

        return $x . '</worksheet>';
    }

    private function xml_sel($ref, $sel)
    {
        $gaya = 0; $jenis = ''; $nilai = $sel;
        if (is_array($sel)) {
            $nilai = isset($sel['v']) ? $sel['v'] : '';
            $gaya  = $this->nomor_gaya(isset($sel['s']) ? $sel['s'] : '');
            $jenis = isset($sel['t']) ? $sel['t'] : '';
        }

        $s = $gaya ? ' s="' . $gaya . '"' : '';

        if ($nilai === null || $nilai === '') { return '<c r="' . $ref . '"' . $s . '/>'; }

        if ($jenis === 'd') {
            $hari = $this->hari_excel($nilai);
            if ($hari === null) { $jenis = 's'; }
            else { return '<c r="' . $ref . '"' . $s . '><v>' . $hari . '</v></c>'; }
        }

        if ($jenis === 'n' || ($jenis === '' && is_numeric($nilai) && !is_string($nilai))) {
            // INF/NAN tidak boleh masuk - Excel menolak seluruh berkasnya.
            if (!is_finite((float) $nilai)) { $nilai = 0; }
            return '<c r="' . $ref . '"' . $s . '><v>' . rtrim(rtrim(sprintf('%.6F', $nilai), '0'), '.') . '</v></c>';
        }

        return '<c r="' . $ref . '"' . $s . ' t="inlineStr"><is><t xml:space="preserve">'
             . $this->esc($nilai) . '</t></is></c>';
    }

    private function xml_tipe()
    {
        $x = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
           . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
           . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
           . '<Default Extension="xml" ContentType="application/xml"/>'
           . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
           . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>';
        foreach ($this->lembar as $i => $l) {
            $x .= '<Override PartName="/xl/worksheets/sheet' . ($i + 1) . '.xml"'
                . ' ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
        }
        return $x . '</Types>';
    }

    private function xml_rels_akar()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
             . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
             . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
             . '</Relationships>';
    }

    private function xml_buku()
    {
        $x = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
           . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"'
           . ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets>';
        foreach ($this->lembar as $i => $l) {
            $x .= '<sheet name="' . $this->esc($l['nama']) . '" sheetId="' . ($i + 1)
                . '" r:id="rId' . ($i + 1) . '"/>';
        }
        return $x . '</sheets></workbook>';
    }

    private function xml_rels_buku()
    {
        $x = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
           . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
        foreach ($this->lembar as $i => $l) {
            $x .= '<Relationship Id="rId' . ($i + 1) . '"'
                . ' Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet"'
                . ' Target="worksheets/sheet' . ($i + 1) . '.xml"/>';
        }
        $x .= '<Relationship Id="rIdGaya"'
            . ' Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles"'
            . ' Target="styles.xml"/>';
        return $x . '</Relationships>';
    }

    /**
     * styles.xml. Urutan cellXfs di sini HARUS sama dengan urutan $GAYA -
     * nomor itulah yang ditulis di atribut s="" tiap selnya.
     */
    private function xml_gaya()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<numFmts count="1"><numFmt numFmtId="164" formatCode="dd mmm yyyy"/></numFmts>'
            . '<fonts count="3">'
            . '<font><sz val="10"/><name val="Calibri"/></font>'              // 0 biasa
            . '<font><b/><sz val="10"/><name val="Calibri"/></font>'          // 1 tebal
            . '<font><b/><sz val="13"/><name val="Calibri"/></font>'          // 2 judul
            . '</fonts>'
            . '<fills count="5">'
            . '<fill><patternFill patternType="none"/></fill>'                // 0
            . '<fill><patternFill patternType="gray125"/></fill>'             // 1 (wajib ada)
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFFFE4C4"/><bgColor indexed="64"/></patternFill></fill>' // 2 krem
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFD9EAD3"/><bgColor indexed="64"/></patternFill></fill>' // 3 hijau
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFD6E4F0"/><bgColor indexed="64"/></patternFill></fill>' // 4 biru
            . '</fills>'
            . '<borders count="2">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border><left style="thin"/><right style="thin"/><top style="thin"/><bottom style="thin"/><diagonal/></border>'
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="13">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'                                                                   // 0 biasa
            . '<xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1"/>'                                                     // 1 judul
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>' // 2 kepala
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"/>'                                                     // 3 tebal
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment horizontal="center"/></xf>'            // 4 tengah
            . '<xf numFmtId="4" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1"/>'                                             // 5 angka
            . '<xf numFmtId="3" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1"/>'                                             // 6 angka0
            . '<xf numFmtId="10" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1"/>'                                            // 7 persen
            . '<xf numFmtId="164" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1" applyAlignment="1"><alignment horizontal="center"/></xf>' // 8 tanggal
            . '<xf numFmtId="4" fontId="1" fillId="0" borderId="0" xfId="0" applyNumberFormat="1" applyFont="1"/>'                               // 9 tebal_angka
            . '<xf numFmtId="0" fontId="1" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>' // 10 kepala hijau
            . '<xf numFmtId="0" fontId="1" fillId="4" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>' // 11 kepala biru
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>' // 12 kepala kuning
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }
}
