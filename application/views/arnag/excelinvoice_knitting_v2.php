<?php
/* ===========================================================================
   Invoice Knitting - versi Excel dari cetakan PDF desain baru
   (arnag/reportinvoice_knitting_v2.php). Susunan & isinya sama persis dengan
   PDF-nya: kop, judul merah, blok TO (konsumen) + tanggal, tabel rincian
   (Invoice Date / Product Item / Style-Color / PO / Qty / Price / Total),
   rekap angka, "Shipping On Behalf Of", blok pembayaran, lalu keterangan
   APPROVED.

   Sama seperti PDF-nya, knitting punya DUA berkas: invoice biasa
   (excelinvoice_v2.php) dan berkas ini.
   =========================================================================== */
$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};
$inv = $data_invoice;
$pot = $data_invoice_pot ? $data_invoice_pot : array();
$konsumen = isset($data_konsumen) && $data_konsumen ? $data_konsumen : array();

$ambil = function ($sumber, $kunci, $bawaan = '') {
    return isset($sumber[$kunci]) && trim((string) $sumber[$kunci]) !== '' ? $sumber[$kunci] : $bawaan;
};
$grup = isset($group_curr) && $group_curr ? $group_curr : array();
$curr = strtoupper((string) $ambil($grup, 'curr',
    $ambil(isset($data_invoice_detail[0]) ? $data_invoice_detail[0] : array(), 'curr')));
$uom = (string) $ambil($grup, 'uom',
    $ambil(isset($data_invoice_detail[0]) ? $data_invoice_detail[0] : array(), 'uom'));

// Nama & alamat konsumen ditulis seperti cetakan PDF: huruf kapital di awal kata.
$rapi = function ($teks) {
    return ucwords(strtolower(trim((string) $teks)));
};
$nama_konsumen = $rapi($ambil($konsumen, 'supplier', $ambil($inv, 'customer', '-')));
$alamat_konsumen = $rapi($ambil($konsumen, 'alamat', $ambil($inv, 'alamat', '-')));

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
$tgl_inv = $tanggal($ambil($inv, 'tgl_inv'));

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
    array('Total Before Value Added Tax', $ambil($pot, 'twot', '0.00'), false),
    array('Value Added Tax', $ambil($pot, 'vat', '0.00'), false),
    array('Other Charges', $ambil($pot, 'total_other', '0.00'), false),
    array('Grand Total', $ambil($pot, 'grand_total', '0.00'), true),
);

$nama_berkas = 'INV_KNITTING_' . preg_replace('/[^A-Za-z0-9._-]/', '_',
    (string) $ambil($inv, 'no_invoice')) . '.xls';
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $nama_berkas . '"');
header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Knitting <?= $esc($ambil($inv, 'no_invoice')); ?></title>
    <style>
        table { border-collapse: collapse; }
        td, th { font-family: Arial, sans-serif; font-size: 10pt; vertical-align: top; }
        .nama-pt { font-size: 15pt; font-weight: bold; text-align: center; }
        .alamat-pt { font-size: 9pt; text-align: center; }
        .judul { font-size: 16pt; font-weight: bold; text-align: center; color: #e2231a; }
        .nomor { font-size: 11pt; font-weight: bold; text-align: center; }
        .label-kecil { font-size: 8pt; color: #888888; }
        .nama-konsumen { font-weight: bold; }
        .label { width: 130px; }
        .sel { border: 1px solid #b0b0b0; }
        .kepala { border: 1px solid #b0b0b0; background: #f5f6f7; font-weight: bold; text-align: center; }
        .angka { text-align: right; }
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

    <!-- ===== Penerima & tanggal ===== -->
    <tr>
        <td colspan="5" class="label-kecil">TO:</td>
        <td colspan="2" class="label-kecil angka">INVOICE DATE</td>
    </tr>
    <tr>
        <td colspan="5" class="nama-konsumen"><?= $esc($nama_konsumen); ?></td>
        <td colspan="2" class="angka"><?= $esc($tgl_inv); ?></td>
    </tr>
    <tr><td colspan="5"><?= $esc($alamat_konsumen); ?></td><td colspan="2"></td></tr>
    <tr><td colspan="7">&nbsp;</td></tr>

    <!-- ===== Rincian ===== -->
    <tr>
        <td class="kepala">Invoice Date</td>
        <td class="kepala">Product Item</td>
        <td class="kepala">Style/Color</td>
        <td class="kepala">PO</td>
        <td class="kepala">Qty<?= $uom !== '' ? ' (' . $esc($uom) . ')' : ''; ?></td>
        <td class="kepala">Price<?= $curr !== '' ? ' (' . $esc($curr) . ')' : ''; ?></td>
        <td class="kepala">Total<?= $curr !== '' ? ' (' . $esc($curr) . ')' : ''; ?></td>
    </tr>
    <?php foreach ((array) $data_invoice_detail as $baris) : ?>
        <tr>
            <td class="sel"><?= $esc($tgl_inv); ?></td>
            <td class="sel"><?= $esc($ambil($baris, 'product_item', '-')); ?></td>
            <td class="sel"><?= $esc($ambil($baris, 'color', '-')); ?></td>
            <td class="sel"><?= $esc($ambil($baris, 'po_konsumen', '-')); ?></td>
            <td class="sel angka"><?= $esc($ambil($baris, 'qty', '0')); ?></td>
            <td class="sel angka"><?= $esc($ambil($baris, 'unit_price', '0.000')); ?></td>
            <td class="sel angka"><?= $esc($ambil($baris, 'total_price', '0.00')); ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td class="sel abu" colspan="4">Total Quantity</td>
        <td class="sel abu angka"><?= $esc($total_qty_tampil); ?></td>
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

    <!-- ===== Pengirim & pembayaran ===== -->
    <tr><td colspan="7">Shipping On Behalf Of</td></tr>
    <tr><td colspan="7" class="tebal">PT Nirwana Alabare Garment</td></tr>
    <tr><td colspan="7">&nbsp;</td></tr>
    <tr><td colspan="7" class="judul-bagian">Please Transfer The Payment To:</td></tr>
    <tr><td class="label">Payment Terms</td><td>:</td><td colspan="5">Within <?= $esc($ambil($inv, 'top', '-')); ?> days of invoice date</td></tr>
    <tr><td class="label">Name Of The Bank</td><td>:</td><td colspan="5"><?= $esc(ucwords(strtolower((string) $ambil($inv, 'nama_bank', '-')))); ?></td></tr>
    <tr><td class="label">Bank Account Number</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'no_rek', '-')); ?></td></tr>
    <?php if (trim((string) $ambil($inv, 'v_swiftcode')) !== '') : ?>
        <tr><td class="label">SWIFT Code</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'v_swiftcode')); ?></td></tr>
    <?php endif; ?>
    <tr><td class="label">Account Currency</td><td>:</td><td colspan="5"><?= $esc($ambil($inv, 'curr', $curr)); ?></td></tr>

    <?php if ($sudah_approve) : ?>
        <tr><td colspan="7">&nbsp;</td></tr>
        <tr><td colspan="7" class="judul-bagian">ELECTRONICALLY ISSUED &#8211; APPROVED</td></tr>
        <tr><td colspan="7" class="catatan">This document was electronically issued through the authorized system of PT Nirwana Alabare Garment. No manual signature is required.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
