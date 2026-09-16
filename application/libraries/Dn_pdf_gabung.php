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
            } catch (\Exception $e) {
                $dilewati[] = array('nama' => $nama, 'alasan' => 'could not be read');
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
