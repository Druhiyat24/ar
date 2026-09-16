<?php
/* ===========================================================================
   Debit Note - PDF desain baru.
   Dipakai untuk DN yang tanggalnya mulai Arnag::DN_PDF_DESAIN_BARU_SEJAK; DN
   sebelum tanggal itu tetap memakai template lama supaya dokumen yang sudah
   beredar tidak berubah tampilannya.
   Dirender mPDF, jadi tidak ada flex/grid - tata letaknya pakai tabel. Semua
   lingkaran (nilai CARING & tanda centang approve) memakai SVG karena
   border-radius pada elemen inline tidak didukung mPDF.
   Dari controller: $data_debit_note, $data_debit_note_det,
   $data_debit_note_det2, $alamat_bank.
   =========================================================================== */
ini_set('pcre.backtrack_limit', '3000000');

$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};
$dn = $data_debit_note;
$alamat_bank = isset($alamat_bank) ? $alamat_bank : $dn['bank_address'];
$gbr = FCPATH . 'assets/build/img/';

// Kolom tambahan (Header 1-5) hanya muncul kalau namanya diisi waktu input.
// Header 4-5 baru terbaca setelah migrations/20260911_debitnote_header4_header5.sql
// dijalankan; sebelum itu isset()-nya gagal dan kolomnya cuma tidak muncul.
$kolom_header = array();
for ($h = 1; $h <= 5; $h++) {
    $nama = isset($dn['header' . $h]) ? trim((string) $dn['header' . $h]) : '';
    if ($nama !== '') {
        $kolom_header[$h] = $nama;
    }
}

// Satu baris detail bisa punya beberapa nilai per kolom tambahan, jadi
// nilainya dikumpulkan dulu supaya di tabel tinggal ditumpuk ke bawah.
$isi_header = array();
foreach ($data_debit_note_det as $baris_det) {
    foreach ($kolom_header as $h => $nama_kolom) {
        $nilai = isset($baris_det['header' . $h]) ? trim((string) $baris_det['header' . $h]) : '';
        if ($nilai === '') {
            continue;
        }
        $isi_header[$baris_det['id_det']][$h][] = $esc($nilai);
    }
}

// Tanda "APPROVED" hanya dicetak kalau DN-nya sudah lolos second approval.
$sudah_second_approve = strtoupper(trim((string) (isset($dn['status']) ? $dn['status'] : ''))) === 'SECOND APPROVED';
// Kolom Supplier & Supplier Invoice bawaan tidak dipakai lagi - isinya sudah
// ditulis lewat kolom tambahan (Header 1-5), jadi setelah Description
// langsung kolom tambahan.
$jml_kolom = 4 + count($kolom_header);

// Lebar kolom dipatok semua (persen). Kalau kolom tambahan dibiarkan auto,
// mPDF memberi sisa ruang yang terlalu sempit sehingga isinya patah di
// tengah kata.
// Kolom Description dipersempit kalau kolom tambahannya banyak, supaya yang
// tambahan tidak jadi terlalu sempit dan isinya patah di tengah kata.
$lebar_deskripsi = count($kolom_header) >= 4 ? 17 : 22;
$lebar_nilai = 12;
$lebar_rate = 9;
$lebar_header_kolom = count($kolom_header)
    ? round((100 - $lebar_deskripsi - (2 * $lebar_nilai) - $lebar_rate) / count($kolom_header), 2)
    : 0;

// Keterangan cukup diisi di baris pertama satu kelompok: baris di bawahnya yang
// keterangannya dikosongkan ikut keterangan di atasnya. Selnya disambung dengan
// menghapus garis antar-baris di kolom Description - bukan rowspan, karena
// rowspan di mPDF tidak bisa terpotong saat tabel pindah halaman.
// Contoh 10 baris, keterangan di baris 1 dan 6: baris 1-5 satu sel, 6-10 satu sel.
$baris_rincian = array_values($data_debit_note_det2);
$lanjutan = array();   // true = keterangan baris ini ikut baris di atasnya
$ada_induk = false;
foreach ($baris_rincian as $i => $baris) {
    $kosong = trim((string) $baris['deskripsi']) === '';
    $lanjutan[$i] = $kosong && $ada_induk;
    if (!$kosong) {
        $ada_induk = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Debit Note <?= $esc($dn['no_dn']); ?></title>
    <style>
        /* Kaki halaman didaftarkan lewat @page; kalau hanya mengandalkan tag
           sethtmlpagefooter, kakinya cuma ikut di halaman pertama. */
        @page {
            margin: 7mm 8mm 30mm 8mm;
            odd-footer-name: html_kaki;
            even-footer-name: html_kaki;
        }

        body { font-family: sans-serif; font-size: 11px; color: #222222; }

        /* ---- Kop surat ---- */
        .kepala td { vertical-align: top; padding: 0; }
        /* text-align ditaruh di sel-nya: mPDF tidak selalu menuruti text-align
           pada div yang ada di dalam sel tabel. */
        .kepala .tengah { text-align: center; }
        .nama-pt { font-size: 27px; font-weight: bold; }
        .alamat-pt { font-size: 14px; line-height: 1.5; margin-top: 4px; }

        /* ---- Judul ---- */
        .judul { text-align: center; font-size: 30px; font-weight: bold; color: #e2231a; margin-top: 18px; }
        .nomor { text-align: center; font-size: 16px; font-weight: bold; margin-top: 2px; }

        /* ---- Keterangan DN ---- */
        .info { width: 100%; font-size: 12px; margin-top: 20px; }
        .info td { padding: 2px 0; vertical-align: top; }
        .info .label { width: 104px; }
        .info .titik { width: 11px; }

        /* ---- Tabel rincian ---- */
        .rincian { width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 18px; }
        .rincian th { background: #f5f6f7; border: 1px solid #dcdcdc; padding: 7px 6px; font-weight: bold; text-align: center; }
        .rincian td { border: 1px solid #dcdcdc; padding: 7px 6px; vertical-align: top; }
        .rincian .angka { text-align: right; }
        /* Sel Description yang disambung dengan baris di atas/bawahnya. */
        .rincian td.sambung-atas { border-top: none; }
        .rincian td.sambung-bawah { border-bottom: none; }
        .rincian .total-label { text-align: center; font-weight: bold; }
        .rincian .total-nilai { text-align: right; font-weight: bold; background: #fdeef0; }

        /* ---- Pembayaran & tanda approve ---- */
        .bayar { width: 100%; margin-top: 30px; }
        .bayar td { vertical-align: top; }
        .judul-bayar { font-size: 13.5px; font-weight: bold; padding-left: 9px; border-left: 3px solid #e2231a; }
        .rek { width: 100%; font-size: 11.5px; margin-top: 9px; }
        .rek td { padding: 2px 0; vertical-align: top; }
        .rek .lbl { width: 118px; font-weight: bold; }
        .rek .titik { width: 11px; }
        .catatan-bayar { font-size: 12px; margin-top: 2px; }
        .sekat { border-left: 1px solid #e6e6e6; padding-left: 16px; }

        /* ---- Kaki halaman ---- */
        .kaki { width: 100%; font-size: 8.5px; border-top: 1px solid #f0cbcf; }
        .kaki .kiri { color: #8a8a8a; letter-spacing: 1.6px; padding-top: 4px; }
        .kaki .hal { color: #8a8a8a; text-align: center; font-size: 9px; padding-top: 4px; }
        /* Dancing Script didaftarkan di Arnag::_dn_mpdf_baru(). */
        .kaki .kanan { text-align: right; color: #e2231a; font-family: dancingscript; font-size: 22px; }
    </style>
</head>

<body>

    <htmlpagefooter name="kaki">
        <!-- Tingginya dipatok supaya kaki halaman tidak makan banyak ruang;
             SVG-nya memang preserveAspectRatio="none" jadi aman dilebarkan. -->
        <img src="<?= $gbr; ?>dn_footer_wave.svg" style="width: 194mm; height: 16mm;">
        <table class="kaki">
            <tr>
                <td class="kiri" width="40%">PT NIRWANA ALABARE GARMENT</td>
                <!-- Nomor halaman seperti template lama ({PAGENO}/{nbpg} diganti mPDF). -->
                <td class="hal" width="20%">{PAGENO} / {nbpg}</td>
                <td class="kanan" width="40%">Caring &#8212;</td>
            </tr>
        </table>
    </htmlpagefooter>

    <table class="kepala" width="100%">
        <tr>
            <!-- Lebar kolom ditulis dalam mm, bukan persen: kolom nama dipas-kan
                 dengan panjang tulisannya supaya yang rata tengah itu tidak
                 mengambang jauh dari logo. Lebarnya juga diatur supaya titik
                 tengah kolom nama jatuh di tengah halaman: 32 + 130/2 = 97mm
                 (32 + 130 + 32 = 194mm = lebar isi). -->
            <td width="32mm"><img src="<?= FCPATH; ?>nag_logo3.jpg" width="112"></td>
            <td width="130mm" class="tengah">
                <div class="nama-pt">PT. NIRWANA ALABARE GARMENT</div>
                <div class="alamat-pt">
                    Jl. Raya Rancaekek &#8211; Majalaya No. 289 Desa Solokan Jeruk<br>
                    Kecamatan Solokan Jeruk, Kabupaten Bandung 40382<br>
                    Telp. 022-85962081
                </div>
            </td>
            <td width="32mm" align="right"><img src="<?= $gbr; ?>dn_caring.svg" width="105"></td>
        </tr>
    </table>

    <div class="judul">DEBIT NOTE</div>
    <div class="nomor"><?= $esc($dn['no_dn']); ?></div>

    <table class="info">
        <tr>
            <td class="label">Date</td>
            <td class="titik">:</td>
            <td><?= $esc($dn['tgl_dn']); ?></td>
        </tr>
        <tr>
            <td class="label">Consignee</td>
            <td class="titik">:</td>
            <td><?= $esc($dn['customer']); ?></td>
        </tr>
        <tr>
            <td class="label">Address</td>
            <td class="titik">:</td>
            <td><?= nl2br($esc($dn['alamat'])); ?></td>
        </tr>
        <tr>
            <td class="label">Attn</td>
            <td class="titik">:</td>
            <td><?= $esc($dn['attn']); ?></td>
        </tr>
    </table>

    <table class="rincian">
        <thead>
            <tr>
                <th width="<?= $lebar_deskripsi; ?>%">Description</th>
                <?php foreach ($kolom_header as $nama_kolom) : ?>
                    <th width="<?= $lebar_header_kolom; ?>%"><?= $esc($nama_kolom); ?></th>
                <?php endforeach; ?>
                <th width="<?= $lebar_nilai; ?>%">Value <?= $esc($dn['from_curr']); ?></th>
                <th width="<?= $lebar_rate; ?>%">Rate</th>
                <th width="<?= $lebar_nilai; ?>%">Value <?= $esc($dn['to_curr']); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($baris_rincian as $i => $baris) :
                $kelas_ket = trim(($lanjutan[$i] ? 'sambung-atas' : '') . ' ' . (!empty($lanjutan[$i + 1]) ? 'sambung-bawah' : ''));
            ?>
                <tr>
                    <td<?= $kelas_ket !== '' ? ' class="' . $kelas_ket . '"' : ''; ?>><?= $lanjutan[$i] ? '' : $esc($baris['deskripsi']); ?></td>
                    <?php foreach ($kolom_header as $h => $nama_kolom) : ?>
                        <td><?= isset($isi_header[$baris['id_det']][$h]) ? implode('<br>', $isi_header[$baris['id_det']][$h]) : ''; ?></td>
                    <?php endforeach; ?>
                    <td class="angka"><?= $esc($baris['amount']); ?></td>
                    <td class="angka"><?= $esc($baris['rate']); ?></td>
                    <td class="angka"><?= $esc($baris['amount2']); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="total-label" colspan="<?= $jml_kolom - 1; ?>">Grand Total</td>
                <td class="total-nilai"><?= $esc($dn['eqv_curr']); ?></td>
            </tr>
        </tbody>
    </table>

    <table class="bayar">
        <tr>
            <td width="54%">
                <!-- Spasinya harus &nbsp;: spasi biasa di awal baris dibuang HTML,
                     dan padding-left diabaikan mPDF untuk blok di dalam sel tabel -
                     jadi garis merahnya nempel ke huruf. -->
                <div class="judul-bayar">&nbsp;&nbsp;Please T/T The Payment To:</div>
                <table class="rek">
                    <tr>
                        <td class="lbl">Account Name</td>
                        <td class="titik">:</td>
                        <td><?= $esc($dn['beneficiary_name']); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Banker</td>
                        <td class="titik">:</td>
                        <td><?= $esc($dn['bank_name']); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Bank Address</td>
                        <td class="titik">:</td>
                        <td><?= nl2br($esc($alamat_bank)); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Account Number</td>
                        <td class="titik">:</td>
                        <td><?= $esc($dn['bank_account']); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Swift Code</td>
                        <td class="titik">:</td>
                        <td><?= $esc($dn['swift_code']); ?></td>
                    </tr>
                </table>
                <br>
                <div class="catatan-bayar">Please pay at full net Amount</div>
            </td>
            <td width="46%" class="sekat">
                <?php if ($sudah_second_approve) : ?>
                    <!-- Seluruh panel (kotak, ikon, teks) dibikin satu SVG. mPDF tidak
                         mengecat latar/garis blok yang berada di dalam sel tabel dengan
                         benar - hasilnya belang per baris teks. -->
                    <img src="<?= $gbr; ?>dn_approved.svg" width="285">
                <?php endif; ?>
            </td>
        </tr>
    </table>

</body>

</html>
