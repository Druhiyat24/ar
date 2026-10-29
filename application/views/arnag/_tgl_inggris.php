<?php
/* ==========================================================================
   Penolong tanggal untuk cetakan.

   Tanggal ditulis gaya Inggris - "15 Oct 2026", bukan 15-10-2026 - supaya
   urutan hari & bulannya tidak rancu waktu dokumennya dibaca penerima dari
   negara lain. Dipakai cetakan Proforma Invoice (PDF & Excel).

   Sumbernya bisa dua bentuk: Y-m-d (kolom tanggal apa adanya) atau d-m-Y
   (sudah diformat model). Yang tidak masuk akal dibiarkan apa adanya - lebih
   baik kelihatan aneh daripada berubah jadi tanggal yang salah.

   Dimuat lewat $this->load->view('arnag/_tgl_inggris') di awal view.
   ========================================================================== */
if (!function_exists('tgl_inggris')) {
    /**
     * @param  string $nilai 2026-10-15 atau 15-10-2026 (pemisah '-' atau '/')
     * @return string "15 Oct 2026", atau nilai aslinya kalau bukan tanggal
     */
    function tgl_inggris($nilai)
    {
        $nilai = trim((string) $nilai);
        $pecah = explode('-', str_replace('/', '-', $nilai));
        if (count($pecah) !== 3) {
            return $nilai;
        }
        $awal_tahun = strlen($pecah[0]) === 4;
        $th = (int) ($awal_tahun ? $pecah[0] : $pecah[2]);
        $bl = (int) $pecah[1];
        $hr = (int) ($awal_tahun ? $pecah[2] : $pecah[0]);
        if (!$th || !$bl || !$hr) {
            return $nilai;
        }
        return date('d M Y', mktime(0, 0, 0, $bl, $hr, $th));
    }
}
