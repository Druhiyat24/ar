<?php
/* ===========================================================================
   Invoice Manual - PDF desain baru.

   Tampilannya disamakan dengan cetakan invoice biasa
   (arnag/reportinvoice_v2.php): kop surat + logo CARING, judul merah, tabel
   abu bergaris tipis, blok pembayaran, dan kaki halaman bergelombang.

   Kolom tanda tangan tiga petak diganti stempel APPROVED, juga mengikuti
   invoice biasa: yang menyatakan invoice ini sah adalah statusnya di
   aplikasi, bukan tanda tangan yang dibubuhkan sesudah dicetak.

   Isi & angkanya persis sama dengan cetakan lama - yang berubah hanya
   tampilannya.

   Dirender mPDF: tidak ada flex/grid, semua tata letak memakai tabel.
   Dari controller (Arnag::report_invoice4):
     $data_invoice, $data_invoice_detail, $data_invoice_pot,
     $group_bppb_number, $group_so_number, $group_curr, $group_user,
     $status_invoice
   =========================================================================== */
ini_set('pcre.backtrack_limit', '3000000');

$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};
$inv = $data_invoice;
$pot = $data_invoice_pot ? $data_invoice_pot : array();
$gbr = FCPATH . 'assets/build/img/';

$ambil = function ($sumber, $kunci, $bawaan = '') {
    return isset($sumber[$kunci]) && trim((string) $sumber[$kunci]) !== '' ? $sumber[$kunci] : $bawaan;
};

// Tanggal dicetak gaya Inggris - "22 Sep 2026", bukan 22-09-2026 - supaya
// urutan hari & bulannya tidak rancu waktu invoice dibaca penerimanya.
// Sumbernya bisa dua bentuk: d-m-Y (sudah diformat model) atau Y-m-d.
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

// Mata uang invoice. Satu invoice satu mata uang, jadi dipakai di judul kolom
// angka - tidak perlu diulang di tiap baris seperti cetakan lama. Barisnya
// dipakai sebagai cadangan: group_curr tidak selalu terisi.
$curr = strtoupper((string) $ambil(isset($group_curr) && $group_curr ? $group_curr : array(), 'curr',
    $ambil(isset($data_invoice_detail[0]) ? $data_invoice_detail[0] : array(), 'curr',
        $ambil($inv, 'curr'))));

// Nomor SJ (BPPB) & SO ditulis berderet dipisah koma, bukan diakhiri koma
// menggantung seperti cetakan lama.
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

// Jumlah qty seluruh baris (angkanya sudah bilangan biasa dari database).
$total_qty = 0;
foreach ((array) $data_invoice_detail as $baris) {
    $total_qty += (float) str_replace(',', '', (string) $ambil($baris, 'qty', 0));
}
$total_qty_tampil = rtrim(rtrim(number_format($total_qty, 2, '.', ','), '0'), '.');

// Stempel APPROVED dicetak kalau invoice-nya sudah disetujui penuh -
// aturannya sama dengan invoice biasa. Kolom tanda tangan tidak dipakai lagi.
$sudah_approve = in_array(
    strtoupper(trim((string) (isset($status_invoice) ? $status_invoice : $ambil($inv, 'status')))),
    array('SECOND APPROVED', 'APPROVED'),
    true
);

// Baris rekap: potongan yang nilainya nol tetap ditampilkan supaya susunannya
// sama dengan invoice biasa. Advance belum punya kolom di invoice manual -
// dicetak nol, bukan dilewati, supaya susunan barisnya tidak berbeda.
$rekap = array(
    array('Total', $ambil($pot, 'total', '0.00'), false),
    array('Discount', $ambil($pot, 'discount', '0.00'), false),
    array('Down Payment', $ambil($pot, 'dp', '0.00'), false),
    array('Advance', $ambil($pot, 'dp_cbd', '0.00'), false),
    array('Return', $ambil($pot, 'retur', '0.00'), false),
    array('Total Before Value Added Tax', $ambil($pot, 'twot', '0.00'), false),
    array('Value Added Tax', $ambil($pot, 'vat', '0.00'), false),
    array('Grand Total', $ambil($pot, 'grand_total', '0.00'), true),
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice <?= $esc($ambil($inv, 'no_invoice')); ?></title>
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
        .nama-pt { font-size: 24px; font-weight: bold; }
        .alamat-pt { font-size: 12px; line-height: 1.4; margin-top: 4px; }

        /* ---- Judul ---- */
        .judul { text-align: center; font-size: 25px; font-weight: bold; color: #e2231a; margin-top: 13px; }
        .nomor { text-align: center; font-size: 15px; font-weight: bold; margin-top: 2px; }

        /* ---- Keterangan invoice ---- */
        .info { width: 100%; font-size: 11.5px; margin-top: 15px; }
        .info td { padding: 2px 0; vertical-align: top; }
        .info .label { width: 116px; }
        .info .titik { width: 10px; }

        /* ---- Tabel rincian ---- */
        .rincian { width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 14px; }
        .rincian th { background: #f5f6f7; border: 1px solid #dcdcdc; padding: 4px 6px; font-weight: bold; text-align: center; }
        .rincian td { border: 1px solid #dcdcdc; padding: 4px 6px; vertical-align: top; }
        .rincian .angka { text-align: right; }
        .rincian .tengah { text-align: center; }
        .rincian .jumlah td { background: #fafafa; font-weight: bold; }

        /* ---- Rekap angka ---- */
        .rekap { width: 100%; border-collapse: collapse; font-size: 11px; }
        .rekap td { border: 1px solid #dcdcdc; padding: 4px 8px; }
        .rekap .ket { text-align: left; }
        .rekap .mata { text-align: center; width: 32px; }
        .rekap .nilai { text-align: right; width: 94px; }
        .rekap .akhir td { font-weight: bold; background: #fdeef0; }

        /* ---- Pembayaran & stempel ----
           Jaraknya paling lebar di antara blok lain: ini pindah "bab", dari
           angka tagihan ke cara membayarnya. */
        .bayar { width: 100%; margin-top: 30px; }
        .bayar td { vertical-align: top; }
        .judul-bayar { font-size: 13px; font-weight: bold; padding-left: 9px; border-left: 3px solid #e2231a; }
        .rek { width: 100%; font-size: 11.5px; margin-top: 9px; }
        .rek td { padding: 2px 0; vertical-align: top; }
        .rek .lbl { width: 116px; font-weight: bold; }
        .rek .titik { width: 10px; }
        .sekat { border-left: 1px solid #e6e6e6; padding-left: 16px; }

        /* ---- Catatan ---- */
        .catatan { width: 100%; font-size: 10.5px; margin-top: 22px; color: #555555; }
        .catatan td { padding: 1px 0; }
        .catatan .lbl { width: 116px; font-weight: bold; color: #222222; }
        .catatan .titik { width: 10px; }

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
                <!-- Nomor halaman seperti cetakan lama ({PAGENO}/{nbpg} diganti mPDF). -->
                <td class="hal" width="20%">{PAGENO} / {nbpg}</td>
                <td class="kanan" width="40%">Caring &#8212;</td>
            </tr>
        </table>
    </htmlpagefooter>

    <table class="kepala" width="100%">
        <tr>
            <!-- Lebar kolom ditulis dalam mm, bukan persen: kolom nama dipas-kan
                 dengan panjang tulisannya supaya yang rata tengah itu tidak
                 mengambang jauh dari logo (32 + 130 + 32 = 194mm = lebar isi). -->
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

    <table class="info">
        <tr>
            <td class="label">Date</td>
            <td class="titik">:</td>
            <td><?= $esc($tanggal($ambil($inv, 'tgl_inv'))); ?></td>
        </tr>
        <tr>
            <td class="label">To</td>
            <td class="titik">:</td>
            <td><?= $esc($ambil($inv, 'customer')); ?></td>
        </tr>
        <tr>
            <td class="label">Address</td>
            <td class="titik">:</td>
            <td><?= nl2br($esc($ambil($inv, 'alamat', '-'))); ?></td>
        </tr>
        <tr>
            <td class="label">Telp.</td>
            <td class="titik">:</td>
            <td><?= $esc($ambil($inv, 'phone', '-')); ?></td>
        </tr>
        <tr>
            <td class="label">Terms Of Payment</td>
            <td class="titik">:</td>
            <td><?= $esc($ambil($inv, 'top', '-')); ?> Days</td>
        </tr>
        <tr>
            <td class="label">BPPB#</td>
            <td class="titik">:</td>
            <td><?= $daftar(isset($group_bppb_number) ? $group_bppb_number : array(), 'bppb_number'); ?></td>
        </tr>
        <tr>
            <td class="label">Sales Order#</td>
            <td class="titik">:</td>
            <td><?= $daftar(isset($group_so_number) ? $group_so_number : array(), 'so_number'); ?></td>
        </tr>
    </table>

    <table class="rincian">
        <thead>
            <tr>
                <th width="18%">Style</th>
                <th width="14%">Color</th>
                <th width="25%">Product Item</th>
                <th width="9%">Qty</th>
                <th width="7%">UOM</th>
                <th width="13%">Unit Price<?= $curr !== '' ? ' ' . $esc($curr) : ''; ?></th>
                <th width="14%">Total<?= $curr !== '' ? ' ' . $esc($curr) : ''; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ((array) $data_invoice_detail as $baris) :
                $ukuran = trim((string) $ambil($baris, 'size'));
            ?>
                <tr>
                    <td><?= $esc($ambil($baris, 'styleno', '-')); ?></td>
                    <td><?= $esc($ambil($baris, 'color', '-')); ?></td>
                    <td><?= $esc($ambil($baris, 'product_item', '-')); ?><?= $ukuran !== '' ? ' (' . $esc($ukuran) . ')' : ''; ?></td>
                    <td class="angka"><?= $esc($ambil($baris, 'qty', '0')); ?></td>
                    <td class="tengah"><?= $esc($ambil($baris, 'uom', '-')); ?></td>
                    <td class="angka"><?= $esc($ambil($baris, 'unit_price', '0.00')); ?></td>
                    <td class="angka"><?= $esc($ambil($baris, 'total_price', '0.00')); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="jumlah">
                <td colspan="3">Total Quantity</td>
                <td class="angka"><?= $esc($total_qty_tampil); ?></td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

    <!-- Rekap angka ditaruh rata kanan supaya barisnya mudah dibaca dari atas
         ke bawah, dan Grand Total-nya diberi latar seperti di invoice biasa. -->
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
                <!-- Spasinya harus &nbsp;: spasi biasa di awal baris dibuang HTML,
                     dan padding-left diabaikan mPDF untuk blok di dalam sel tabel -
                     jadi garis merahnya nempel ke huruf. -->
                <div class="judul-bayar">&nbsp;&nbsp;Please Transfer The Payment To:</div>
                <table class="rek">
                    <tr>
                        <td class="lbl">Banker</td>
                        <td class="titik">:</td>
                        <td><?= $esc($ambil($inv, 'nama_bank', '-')); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Bank Address</td>
                        <td class="titik">:</td>
                        <td><?= nl2br($esc($ambil($inv, 'v_bankaddress', '-'))); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Account Number</td>
                        <td class="titik">:</td>
                        <td><?= $esc($ambil($inv, 'no_rek', '-')); ?></td>
                    </tr>
                    <?php if (trim((string) $ambil($inv, 'v_company')) !== '') : ?>
                        <!-- Atas nama rekening - cetakan lama memajangnya sebagai
                             "Attn", dan penerima invoice memakainya waktu transfer. -->
                        <tr>
                            <td class="lbl">Attn</td>
                            <td class="titik">:</td>
                            <td><?= $esc($ambil($inv, 'v_company')); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </td>
            <td width="46%" class="sekat">
                <?php if ($sudah_approve) : ?>
                    <!-- Seluruh panel (kotak, ikon, teks) dibikin satu SVG - sama
                         seperti invoice biasa. mPDF tidak mengecat latar/garis blok
                         yang ada di dalam sel tabel dengan benar, hasilnya belang
                         per baris teks. -->
                    <img src="<?= $gbr; ?>dn_approved.svg" width="260">
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <!-- Catatan penutup cetakan lama tetap dibawa: nomor invoice & grand total
         diulang di bawah supaya mudah dirujuk waktu pembayarannya dicocokkan. -->
    <table class="catatan">
        <tr>
            <td class="lbl">Invoice Number</td>
            <td class="titik">:</td>
            <td><?= $esc($ambil($inv, 'no_invoice')); ?></td>
        </tr>
        <tr>
            <td class="lbl">Grand Total</td>
            <td class="titik">:</td>
            <td><?= $esc($curr); ?> <?= $esc($ambil($pot, 'grand_total', '0.00')); ?></td>
        </tr>
    </table>

</body>

</html>
