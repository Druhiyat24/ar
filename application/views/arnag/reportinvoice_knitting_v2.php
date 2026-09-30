<?php
/* ===========================================================================
   Invoice Knitting - PDF desain baru.

   Pasangan dari arnag/reportinvoice_v2.php: knitting (NAK) memang punya DUA
   cetakan - invoice biasa untuk customer booking, dan cetakan ini untuk
   konsumen knitting-nya (PO, style/color, qty per unit knitting).

   Isi & angkanya sama persis dengan cetakan lama (arnag/pdf_invoice_knitting),
   yang berubah hanya tampilannya: kop + logo CARING, tabel abu bergaris tipis,
   blok pembayaran, kaki halaman bergelombang - seragam dengan Debit Note.

   Dirender mPDF: tidak ada flex/grid, semua tata letak memakai tabel.
   Dari controller (Arnag::print_invoice_knitting_v2 / preview_invoice_v2):
     $data_invoice, $data_konsumen, $data_invoice_detail, $data_invoice_pot,
     $group_curr, $status_invoice
   =========================================================================== */
ini_set('pcre.backtrack_limit', '3000000');

$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};
$inv = $data_invoice;
$pot = $data_invoice_pot ? $data_invoice_pot : array();
$konsumen = isset($data_konsumen) && $data_konsumen ? $data_konsumen : array();
$gbr = FCPATH . 'assets/build/img/';

$ambil = function ($sumber, $kunci, $bawaan = '') {
    return isset($sumber[$kunci]) && trim((string) $sumber[$kunci]) !== '' ? $sumber[$kunci] : $bawaan;
};

// Tanggal dicetak gaya Inggris - "22 Sep 2026", bukan 22-09-2026 - supaya
// urutan hari & bulannya tidak rancu waktu invoice dibaca penerimanya.
// Sumbernya bisa dua bentuk: d-m-Y (sudah diformat model, cetakan tersimpan)
// atau Y-m-d (kolom tanggal apa adanya, dipakai pratinjau).
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

// Mata uang & satuan dipakai di judul kolom - satu invoice satu mata uang.
$grup = isset($group_curr) && $group_curr ? $group_curr : array();
$curr = strtoupper((string) $ambil($grup, 'curr',
    $ambil(isset($data_invoice_detail[0]) ? $data_invoice_detail[0] : array(), 'curr')));
$uom = (string) $ambil($grup, 'uom',
    $ambil(isset($data_invoice_detail[0]) ? $data_invoice_detail[0] : array(), 'uom'));

// Nama & alamat konsumen ditulis seperti cetakan lama: huruf kapital di awal
// kata, dan alamatnya dipecah per kalimat supaya tidak jadi satu baris panjang.
$rapi = function ($teks) {
    return ucwords(strtolower(trim((string) $teks)));
};
$nama_konsumen = $rapi($ambil($konsumen, 'supplier', $ambil($inv, 'customer', '-')));
$alamat_konsumen = preg_replace('/\. ?/', ".\n", $rapi($ambil($konsumen, 'alamat', $ambil($inv, 'alamat', '-'))));

// Stempel APPROVED menggantikan kolom tanda tangan - aturannya sama dengan
// cetakan invoice biasa & Debit Note.
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice Knitting <?= $esc($ambil($inv, 'no_invoice')); ?></title>
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
        .kepala .tengah { text-align: center; }
        .nama-pt { font-size: 24px; font-weight: bold; }
        .alamat-pt { font-size: 12px; line-height: 1.4; margin-top: 4px; }

        /* ---- Judul ---- */
        .judul { text-align: center; font-size: 25px; font-weight: bold; color: #e2231a; margin-top: 13px; }
        .nomor { text-align: center; font-size: 15px; font-weight: bold; margin-top: 2px; }

        /* ---- Penerima & tanggal ---- */
        .kepada { width: 100%; font-size: 11.5px; margin-top: 15px; }
        .kepada td { vertical-align: top; padding: 0; }
        .kepada .label { font-size: 11px; font-weight: bold; letter-spacing: .4px; color: #64748b; }
        .kepada .nama { font-size: 13px; font-weight: bold; margin-top: 3px; }
        .kepada .alamat { margin-top: 2px; line-height: 1.45; }
        .kepada .kanan { text-align: right; }
        .kepada .kanan .isi { margin-top: 3px; }

        /* ---- Tabel rincian ---- */
        .rincian { width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 14px; }
        .rincian th { background: #f5f6f7; border: 1px solid #dcdcdc; padding: 4px 6px; font-weight: bold; text-align: center; }
        .rincian td { border: 1px solid #dcdcdc; padding: 4px 6px; vertical-align: top; }
        .rincian .angka { text-align: right; }
        .rincian .jumlah td { background: #fafafa; font-weight: bold; }

        /* ---- Rekap angka ---- */
        .rekap { width: 100%; border-collapse: collapse; font-size: 11px; }
        .rekap td { border: 1px solid #dcdcdc; padding: 4px 8px; }
        .rekap .ket { text-align: left; }
        .rekap .mata { text-align: center; width: 32px; }
        .rekap .nilai { text-align: right; width: 94px; }
        .rekap .akhir td { font-weight: bold; background: #fdeef0; }

        /* ---- Pembayaran & stempel ---- */
        .bayar { width: 100%; margin-top: 30px; }
        .bayar td { vertical-align: top; }
        .judul-bayar { font-size: 13px; font-weight: bold; padding-left: 9px; border-left: 3px solid #e2231a; }
        .rek { width: 100%; font-size: 11.5px; margin-top: 9px; }
        .rek td { padding: 2px 0; vertical-align: top; }
        .rek .lbl { width: 150px; font-weight: bold; }
        .rek .titik { width: 10px; }
        .sekat { border-left: 1px solid #e6e6e6; padding-left: 16px; }
        .atas-nama { font-size: 11.5px; margin-bottom: 9px; }
        .atas-nama b { font-size: 12.5px; }

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
        <img src="<?= $gbr; ?>dn_footer_wave.svg" style="width: 194mm; height: 16mm;">
        <table class="kaki">
            <tr>
                <td class="kiri" width="40%">PT NIRWANA ALABARE GARMENT</td>
                <td class="hal" width="20%">{PAGENO} / {nbpg}</td>
                <td class="kanan" width="40%">Caring &#8212;</td>
            </tr>
        </table>
    </htmlpagefooter>

    <table class="kepala" width="100%">
        <tr>
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

    <div class="judul"><?= $esc(strtoupper((string) $ambil($inv, 'type'))); ?> INVOICE</div>
    <div class="nomor"><?= $esc($ambil($inv, 'no_invoice')); ?></div>

    <table class="kepada">
        <tr>
            <td width="60%">
                <div class="label">TO:</div>
                <div class="nama"><?= $esc($nama_konsumen); ?></div>
                <div class="alamat"><?= nl2br($esc($alamat_konsumen)); ?></div>
            </td>
            <td width="40%" class="kanan">
                <div class="label">INVOICE DATE</div>
                <div class="isi"><?= $esc($tanggal($ambil($inv, 'tgl_inv'))); ?></div>
            </td>
        </tr>
    </table>

    <table class="rincian">
        <thead>
            <tr>
                <th width="13%">Invoice Date</th>
                <th width="25%">Product Item</th>
                <th width="16%">Style/Color</th>
                <th width="16%">PO</th>
                <th width="11%">Qty<?= $uom !== '' ? ' (' . $esc($uom) . ')' : ''; ?></th>
                <th width="9%">Price<?= $curr !== '' ? ' (' . $esc($curr) . ')' : ''; ?></th>
                <th width="10%">Total<?= $curr !== '' ? ' (' . $esc($curr) . ')' : ''; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_qty = 0;
            foreach ((array) $data_invoice_detail as $baris) :
                $total_qty += (float) str_replace(',', '', (string) $ambil($baris, 'qty', 0));
            ?>
                <tr>
                    <td><?= $esc($tanggal($ambil($inv, 'tgl_inv'))); ?></td>
                    <td><?= $esc($ambil($baris, 'product_item', '-')); ?></td>
                    <td><?= $esc($ambil($baris, 'color', '-')); ?></td>
                    <td><?= $esc($ambil($baris, 'po_konsumen', '-')); ?></td>
                    <td class="angka"><?= $esc($ambil($baris, 'qty', '0')); ?></td>
                    <td class="angka"><?= $esc($ambil($baris, 'unit_price', '0.000')); ?></td>
                    <td class="angka"><?= $esc($ambil($baris, 'total_price', '0.00')); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="jumlah">
                <td colspan="4">Total Quantity</td>
                <td class="angka"><?= $esc(rtrim(rtrim(number_format($total_qty, 2, '.', ','), '0'), '.')); ?></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <table width="100%" style="margin-top: 12px;">
        <tr>
            <td width="52%"></td>
            <td width="48%">
                <table class="rekap">
                    <?php foreach ($rekap as $baris) : ?>
                        <tr<?= $baris[2] ? ' class="akhir"' : ''; ?>>
                            <td class="ket"><?= $esc($baris[0]); ?></td>
                            <td class="mata"><?= $esc($curr); ?></td>
                            <td class="nilai"><?= $esc($baris[1]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    </table>

    <table class="bayar">
        <tr>
            <td width="54%">
                <div class="atas-nama">Shipping On Behalf Of<br><b>PT Nirwana Alabare Garment</b></div>
                <!-- Spasinya harus &nbsp;: spasi biasa di awal baris dibuang HTML,
                     dan padding-left diabaikan mPDF untuk blok di dalam sel tabel. -->
                <div class="judul-bayar">&nbsp;&nbsp;Please Transfer The Payment To:</div>
                <table class="rek">
                    <tr>
                        <td class="lbl">Payment Terms</td>
                        <td class="titik">:</td>
                        <td>Within <?= $esc($ambil($inv, 'top', '-')); ?> days of invoice date</td>
                    </tr>
                    <tr>
                        <td class="lbl">Name Of The Bank</td>
                        <td class="titik">:</td>
                        <td><?= $esc(ucwords(strtolower((string) $ambil($inv, 'nama_bank', '-')))); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Bank Account Number</td>
                        <td class="titik">:</td>
                        <td><?= $esc($ambil($inv, 'no_rek', '-')); ?></td>
                    </tr>
                    <?php if (trim((string) $ambil($inv, 'v_swiftcode')) !== '') : ?>
                        <tr>
                            <td class="lbl">SWIFT Code</td>
                            <td class="titik">:</td>
                            <td><?= $esc($ambil($inv, 'v_swiftcode')); ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="lbl">Account Currency</td>
                        <td class="titik">:</td>
                        <td><?= $esc($ambil($inv, 'curr', $curr)); ?></td>
                    </tr>
                </table>
            </td>
            <td width="46%" class="sekat">
                <?php if ($sudah_approve) : ?>
                    <!-- Seluruh panel dibikin satu SVG - sama seperti Debit Note.
                         mPDF tidak mengecat latar blok di dalam sel tabel dengan
                         benar, hasilnya belang per baris teks. -->
                    <img src="<?= $gbr; ?>dn_approved.svg" width="260">
                <?php endif; ?>
            </td>
        </tr>
    </table>

</body>

</html>
