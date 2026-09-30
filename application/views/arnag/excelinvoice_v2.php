<?php
/* ===========================================================================
   Invoice (lokal) - versi Excel dari cetakan PDF desain baru
   (arnag/reportinvoice_v2.php). Susunan & isinya sengaja dibuat sama persis
   dengan PDF-nya: kop, judul merah, blok keterangan, tabel rincian, rekap
   angka, blok pembayaran, lalu keterangan APPROVED.

   Bentuknya HTML yang dikirim sebagai berkas Excel - sama seperti ekspor
   Excel yang sudah ada di menu ini (arnag/excelinvoice.php), jadi tidak perlu
   pustaka tambahan dan bisa dibuka Excel maupun LibreOffice.

   Data dari controller (Arnag::export_excel_invoice_v2) sama persis dengan
   yang dipakai cetakan PDF-nya.
   =========================================================================== */
$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};
$inv = $data_invoice;
$pot = $data_invoice_pot ? $data_invoice_pot : array();

$ambil = function ($sumber, $kunci, $bawaan = '') {
    return isset($sumber[$kunci]) && trim((string) $sumber[$kunci]) !== '' ? $sumber[$kunci] : $bawaan;
};
$curr = strtoupper((string) $ambil(isset($group_curr) && $group_curr ? $group_curr : array(), 'curr',
    $ambil(isset($data_invoice_detail[0]) ? $data_invoice_detail[0] : array(), 'curr')));

// Nomor SJ (BPPB) & SO ditulis berderet dipisah koma - sama dengan PDF-nya.
$daftar = function ($baris, $kunci) use ($esc) {
    $isi = array();
    foreach ((array) $baris as $b) {
        $nilai = trim((string) (isset($b[$kunci]) ? $b[$kunci] : ''));
        if ($nilai !== '' && !in_array($nilai, $isi, true)) {
            $isi[] = $nilai;
        }
    }
    return $isi ? $esc(implode(', ', $isi)) : '-';
};

// Tanggal gaya Inggris ("22 Sep 2026"), sama dengan cetakan PDF.
$tanggal = function ($nilai) {
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
};

$total_qty = 0;
foreach ((array) $data_invoice_detail as $baris) {
    $total_qty += (float) str_replace(',', '', (string) $ambil($baris, 'qty', 0));
}
$total_qty_tampil = rtrim(rtrim(number_format($total_qty, 2, '.', ','), '0'), '.');

$sudah_approve = in_array(
    strtoupper(trim((string) (isset($status_invoice) ? $status_invoice : ''))),
    array('SECOND APPROVED', 'APPROVED'),
    true
);

$rekap = array(
    array('Total', $ambil($pot, 'total', '0.00'), false),
    array('Discount', $ambil($pot, 'discount', '0.00'), false),
    array('Down Payment', $ambil($pot, 'dp', '0.00'), false),
    array('Return', $ambil($pot, 'retur', '0.00'), false),
    array('Total Before Value Added Tax', $ambil($pot, 'twot', '0.00'), false),
    array('Value Added Tax', $ambil($pot, 'vat', '0.00'), false),
    array('Grand Total', $ambil($pot, 'grand_total', '0.00'), true),
);

$nama_berkas = 'INV_' . preg_replace('/[^A-Za-z0-9._-]/', '_', (string) $ambil($inv, 'no_invoice')) . '.xls';
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $nama_berkas . '"');
header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?= $esc($ambil($inv, 'no_invoice')); ?></title>
    <style>
        table { border-collapse: collapse; }
        td, th { font-family: Arial, sans-serif; font-size: 10pt; vertical-align: top; }
        .nama-pt { font-size: 15pt; font-weight: bold; text-align: center; }
        .alamat-pt { font-size: 9pt; text-align: center; }
        .judul { font-size: 16pt; font-weight: bold; text-align: center; color: #e2231a; }
        .nomor { font-size: 11pt; font-weight: bold; text-align: center; }
        .label { width: 130px; }
        .sel { border: 1px solid #b0b0b0; }
        .kepala { border: 1px solid #b0b0b0; background: #f5f6f7; font-weight: bold; text-align: center; }
        .angka { text-align: right; }
        .tengah { text-align: center; }
        .tebal { font-weight: bold; }
        .abu { background: #fafafa; font-weight: bold; }
        .grand { background: #fdeef0; font-weight: bold; }
        .judul-bagian { font-weight: bold; font-size: 11pt; }
        .catatan { font-size: 9pt; color: #555555; }
    </style>
</head>
<body>

<table>
    <!-- ===== Kop surat ===== -->
    <tr><td colspan="7" class="nama-pt">PT. NIRWANA ALABARE GARMENT</td></tr>
    <tr><td colspan="7" class="alamat-pt">Jl. Raya Rancaekek &#8211; Majalaya No. 289 Desa Solokan Jeruk</td></tr>
    <tr><td colspan="7" class="alamat-pt">Kecamatan Solokan Jeruk, Kabupaten Bandung 40382</td></tr>
    <tr><td colspan="7" class="alamat-pt">Telp. 022-85962081</td></tr>
    <tr><td colspan="7">&nbsp;</td></tr>

    <!-- ===== Judul & nomor ===== -->
    <tr><td colspan="7" class="judul"><?= $esc(strtoupper((string) $ambil($inv, 'type'))); ?> INVOICE</td></tr>
    <tr><td colspan="7" class="nomor"><?= $esc($ambil($inv, 'no_invoice')); ?></td></tr>
    <tr><td colspan="7">&nbsp;</td></tr>

    <!-- ===== Keterangan invoice ===== -->
    <tr><td class="label">Date</td><td>:</td><td colspan="5"><?= $esc($tanggal($ambil($inv, 'tgl_inv'))); ?></td></tr>
    <tr><td class="label">To</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'customer')); ?></td></tr>
    <tr><td class="label">Address</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'alamat', '-')); ?></td></tr>
    <tr><td class="label">Telp.</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'phone', '-')); ?></td></tr>
    <tr><td class="label">Terms Of Payment</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'top', '-')); ?> Days</td></tr>
    <tr><td class="label">BPPB#</td><td>:</td><td colspan="5"><?= $daftar(isset($group_bppb_number) ? $group_bppb_number : array(), 'bppb_number'); ?></td></tr>
    <tr><td class="label">Sales Order#</td><td>:</td><td colspan="5"><?= $daftar(isset($group_so_number) ? $group_so_number : array(), 'so_number'); ?></td></tr>
    <tr><td colspan="7">&nbsp;</td></tr>

    <!-- ===== Rincian ===== -->
    <tr>
        <td class="kepala">Style</td>
        <td class="kepala">Color</td>
        <td class="kepala">Product Item</td>
        <td class="kepala">Qty</td>
        <td class="kepala">UOM</td>
        <td class="kepala">Unit Price<?= $curr !== '' ? ' ' . $esc($curr) : ''; ?></td>
        <td class="kepala">Total<?= $curr !== '' ? ' ' . $esc($curr) : ''; ?></td>
    </tr>
    <?php foreach ((array) $data_invoice_detail as $baris) :
        $ukuran = trim((string) $ambil($baris, 'size'));
    ?>
        <tr>
            <td class="sel"><?= $esc($ambil($baris, 'styleno', '-')); ?></td>
            <td class="sel"><?= $esc($ambil($baris, 'color', '-')); ?></td>
            <td class="sel"><?= $esc($ambil($baris, 'product_item', '-')); ?><?= $ukuran !== '' ? ' (' . $esc($ukuran) . ')' : ''; ?></td>
            <td class="sel angka"><?= $esc($ambil($baris, 'qty', '0')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($baris, 'uom', '-')); ?></td>
            <td class="sel angka"><?= $esc($ambil($baris, 'unit_price', '0.000')); ?></td>
            <td class="sel angka"><?= $esc($ambil($baris, 'total_price', '0.00')); ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td class="sel abu" colspan="3">Total Quantity</td>
        <td class="sel abu angka"><?= $esc($total_qty_tampil); ?></td>
        <td class="sel abu"></td>
        <td class="sel abu"></td>
        <td class="sel abu"></td>
    </tr>
    <tr><td colspan="7">&nbsp;</td></tr>

    <!-- ===== Rekap angka ===== -->
    <?php foreach ($rekap as $r) : ?>
        <tr>
            <td colspan="4"></td>
            <td class="sel <?= $r[2] ? 'grand' : ''; ?>"><?= $esc($r[0]); ?></td>
            <td class="sel tengah <?= $r[2] ? 'grand' : ''; ?>"><?= $esc($curr); ?></td>
            <td class="sel angka <?= $r[2] ? 'grand' : 'tebal'; ?>"><?= $esc($r[1]); ?></td>
        </tr>
    <?php endforeach; ?>
    <tr><td colspan="7">&nbsp;</td></tr>

    <!-- ===== Pembayaran ===== -->
    <tr><td colspan="7" class="judul-bagian">Please Transfer The Payment To:</td></tr>
    <tr><td class="label">Name Of The Bank</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'nama_bank', '-')); ?></td></tr>
    <tr><td class="label">Bank Account Number</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'no_rek', '-')); ?></td></tr>
    <tr><td class="label">Bank Address</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'v_bankaddress', '-')); ?></td></tr>
    <tr><td class="label">Account Currency</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'curr', '-')); ?></td></tr>
    <?php if (trim((string) $ambil($inv, 'v_swiftcode')) !== '') : ?>
        <tr><td class="label">SWIFT Code</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'v_swiftcode')); ?></td></tr>
    <?php endif; ?>

    <?php if ($sudah_approve) : ?>
        <tr><td colspan="7">&nbsp;</td></tr>
        <tr><td colspan="7" class="judul-bagian">ELECTRONICALLY ISSUED &#8211; APPROVED</td></tr>
        <tr><td colspan="7" class="catatan">This document was electronically issued through the authorized system of PT Nirwana Alabare Garment. No manual signature is required.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
