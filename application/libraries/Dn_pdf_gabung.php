<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Menggabungkan PDF Debit Note dengan supporting document-nya jadi satu file.
 *
 * mPDF (pembuat PDF Debit Note) tidak bisa mengimpor halaman dari PDF lain,
 * jadi penggabungannya memakai FPDI + TCPDF yang sudah ada di proyek ini:
 *   - vendor/setasign/fpdi        (composer)
 *   - application/libraries/tcpdf (bundled)
 *
 * Sengaja dipisah dari controller supaya bisa diuji tanpa CodeIgniter &
 * database (lihat _tes_gabung_pdf.php waktu dikembangkan).
 */
class Dn_pdf_gabung
{
    /**
     * Lampiran boleh sampai ratusan MB (tidak ada batas waktu upload), tapi
     * menggabungkannya butuh memori beberapa kali ukuran filenya. Daripada
     * cetaknya mati di tengah jalan, lampiran yang kebesaran dilewati dan
     * diberitahukan di halaman terakhir.
     */
    const BATAS_FILE  = 26214400;   // 25 MB per lampiran
    const BATAS_TOTAL = 62914560;   // 60 MB untuk semua lampiran

    /**
     * @param string $pdf_utama Path PDF Debit Note (hasil mPDF).
     * @param array  $lampiran  Daftar array('path' => ..., 'nama' => ...).
     * @param string $tujuan    Path file hasil gabungan.
     * @param string $judul     Judul dokumen (nomor DN).
     * @return array array('dilewati' => array(array('nama','alasan'), ...))
     */
    public function gabung($pdf_utama, array $lampiran, $tujuan, $judul = '')
    {
        require_once APPPATH . 'libraries/tcpdf/tcpdf.php';

        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false);
        $pdf->SetCreator('NAG');
        if ($judul !== '') {
            $pdf->SetTitle($judul);
        }

        $this->sambung_pdf($pdf, $pdf_utama);

        // Lampiran yang tidak ikut tergabung dicatat, bukan dibiarkan hilang
        // diam-diam - user perlu tahu mana yang harus dibuka terpisah.
        $dilewati = array();
        $total = 0;

        foreach ($lampiran as $file) {
            $path = isset($file['path']) ? $file['path'] : '';
            $nama = isset($file['nama']) ? $file['nama'] : basename((string) $path);
            $ext  = strtolower(pathinfo((string) $path, PATHINFO_EXTENSION));

            if (!$path || !is_file($path)) {
                $dilewati[] = array('nama' => $nama, 'alasan' => 'file is missing on the server');
                continue;
            }

            $ukuran = (int) filesize($path);
            if ($ukuran > self::BATAS_FILE || ($total + $ukuran) > self::BATAS_TOTAL) {
                $dilewati[] = array('nama' => $nama, 'alasan' => 'too large to merge (' . $this->ukuran_terbaca($ukuran) . ')');
                continue;
            }

            try {
                if ($ext === 'pdf') {
                    $this->sambung_pdf($pdf, $path);
                } else {
                    $this->sambung_gambar($pdf, $path, $ext);
                }
                $total += $ukuran;
            } catch (\Throwable $e) {
                // PDF 1.5+ yang daftar objeknya dimampatkan tidak bisa dibaca
                // FPDI gratis. Dicoba dikonversi dulu ke bentuk lama; kalau
                // tetap gagal, baru dilewati seperti biasa.
                if ($ext === 'pdf' && $this->coba_lewat_konverter($pdf, $path, $e, dirname($tujuan))) {
                    $total += $ukuran;
                    continue;
                }
                // Alasan aslinya JANGAN dibuang: tanpa ini, semua kegagalan
                // tampil sama ("could not be read") dan penyebabnya tidak bisa
                // ditelusuri dari server.
                $dilewati[] = array('nama' => $nama, 'alasan' => $this->alasan_gagal($e));
                $this->catat_gagal($nama, $path, $e);
            }
        }

        if ($dilewati) {
            $this->halaman_catatan($pdf, $dilewati);
        }

        // Ditulis ke file, bukan dikembalikan sebagai string: hasil gabungan
        // bisa puluhan MB dan pemanggilnya cukup membacanya bertahap.
        $pdf->Output($tujuan, 'F');
        return array('dilewati' => $dilewati);
    }

    /**
     * Upaya terakhir untuk PDF 1.5+ yang daftar objeknya dimampatkan: file
     * disusun ulang ke bentuk xref klasik lalu dicoba lagi.
     *
     * Hasil konversi TIDAK langsung ditempel. Semua halamannya diuji baca
     * dulu di dokumen terpisah; kalau ada satu saja yang bermasalah, konversi
     * dianggap gagal dan lampiran dilewati seperti biasa. Ini yang menjaga
     * supaya PDF gabungan tidak pernah jadi setengah-setengah.
     *
     * @return bool true kalau lampiran berhasil ditempel lewat jalur ini.
     */
    private function coba_lewat_konverter($pdf, $path, \Throwable $e, $folder)
    {
        if ((int) $e->getCode() !== \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException::COMPRESSED_XREF) {
            return false;
        }

        require_once APPPATH . 'libraries/Dn_pdf_klasik.php';

        $sementara = rtrim($folder, "/\\") . DIRECTORY_SEPARATOR . 'konversi_' . md5($path . microtime(true)) . '.pdf';
        $bersih = function () use ($sementara) {
            if (is_file($sementara)) { @unlink($sementara); }
        };

        try {
            $konv = new \Dn_pdf_klasik();
            if (!$konv->ubah($path, $sementara) || !is_file($sementara)) {
                $bersih();
                return false;
            }
            if (!$this->semua_halaman_terbaca($sementara)) {
                $bersih();
                return false;
            }
            $this->sambung_pdf($pdf, $sementara);
        } catch (\Throwable $e2) {
            $bersih();
            return false;
        }

        $bersih();
        $this->catat_pulih($path);
        return true;
    }

    /** Uji baca seluruh halaman di dokumen terpisah - tidak menyentuh hasil. */
    private function semua_halaman_terbaca($file)
    {
        try {
            $uji = new \setasign\Fpdi\Tcpdf\Fpdi();
            $jml = $uji->setSourceFile($file);
            if ($jml < 1) {
                return false;
            }
            for ($i = 1; $i <= $jml; $i++) {
                $uji->importPage($i);
            }
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function catat_pulih($path)
    {
        if (function_exists('log_message')) {
            log_message('info', 'Dn_pdf_gabung: lampiran "' . $path
                . '" dikonversi dulu dari cross-reference stream ke xref klasik, lalu berhasil digabung.');
        }
    }

    /**
     * Alasan yang bisa dimengerti user, dari error FPDI.
     *
     * Dua penyebab yang paling sering ketemu di lapangan - keduanya tetap
     * kebuka normal di browser, jadi user bingung kenapa ditolak:
     *   - PDF diproteksi password/izin (hasil "Protect" di Acrobat, scanner
     *     kantor, atau invoice dari pihak lain)
     *   - PDF memakai compressed cross-reference (PDF 1.5+ terbitan sebagian
     *     scanner & Word). Parser bawaan FPDI yang gratis tidak membacanya.
     */
    private function alasan_gagal(\Throwable $e)
    {
        $kode = (int) $e->getCode();

        if ($kode === \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException::ENCRYPTED) {
            return 'password-protected - remove the protection, then re-upload';
        }
        if ($kode === \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException::COMPRESSED_XREF) {
            return 'unsupported PDF format - re-save it as PDF 1.4, then re-upload';
        }
        if ($kode === \setasign\Fpdi\PdfParser\PdfParserException::FILE_HEADER_NOT_FOUND) {
            return 'not a valid PDF file';
        }

        return 'could not be read';
    }

    /** Error aslinya ditulis ke log supaya bisa ditelusuri dari server. */
    private function catat_gagal($nama, $path, \Throwable $e)
    {
        if (!function_exists('log_message')) {
            return;
        }
        log_message('error', 'Dn_pdf_gabung: lampiran "' . $nama . '" (' . $path . ') gagal digabung - '
            . get_class($e) . ' kode=0x' . dechex((int) $e->getCode()) . ' - ' . $e->getMessage());
    }

    /** Semua halaman sebuah PDF, ukuran & orientasi halaman asalnya diikuti. */
    private function sambung_pdf($pdf, $file)
    {
        $jml = $pdf->setSourceFile($file);
        for ($i = 1; $i <= $jml; $i++) {
            $tpl  = $pdf->importPage($i);
            $ukur = $pdf->getTemplateSize($tpl);
            $pdf->AddPage($ukur['orientation'], array($ukur['width'], $ukur['height']));
            $pdf->useTemplate($tpl);
        }
    }

    /**
     * Lampiran gambar: 1 halaman A4, gambarnya dimuat di dalam margin dengan
     * proporsi asli (fitbox), bukan dipaksa memenuhi halaman.
     */
    private function sambung_gambar($pdf, $file, $ext)
    {
        $tipe = array('jpg' => 'JPEG', 'jpeg' => 'JPEG', 'png' => 'PNG', 'gif' => 'GIF', 'webp' => 'WEBP');
        $pdf->AddPage('P', 'A4');
        $pdf->Image(
            $file, 10, 10, 190, 277,
            isset($tipe[$ext]) ? $tipe[$ext] : '',
            '', '', true, 300, '', false, false, 0, 'LT'
        );
    }

    /** Halaman terakhir: daftar lampiran yang tidak ikut digabung + alasannya. */
    private function halaman_catatan($pdf, array $dilewati)
    {
        $pdf->AddPage('P', 'A4');
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 8, 'Supporting document(s) not included', 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, 'Please open these files from the application:', 0, 1);
        $pdf->Ln(2);
        foreach ($dilewati as $i => $d) {
            $pdf->Cell(0, 6, ($i + 1) . '. ' . $d['nama'] . ' - ' . $d['alasan'], 0, 1);
        }
    }

    private function ukuran_terbaca($byte)
    {
        if ($byte < 1048576) {
            return round($byte / 1024) . ' KB';
        }
        return round($byte / 1048576, 1) . ' MB';
    }
}
