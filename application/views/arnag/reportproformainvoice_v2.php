<?php
/* ===========================================================================
   Proforma Invoice - PDF desain baru.

   Bentuknya mengikuti Commercial Invoice desain baru
   (arnag/reportinvoice_v2.php): kop surat + logo CARING, judul merah, tabel
   abu bergaris tipis, blok pembayaran, stempel APPROVED, dan kaki halaman
   bergelombang. Isi & angkanya sama dengan cetakan lama
   (arnag/reportproformainvoice.php) - yang berubah tampilannya.

   Yang dipajang di blok penerima itu pihak yang DITAGIH (Billed To). Proforma
   boleh ditagihkan ke pihak lain - mis. kantor pusat buyer - sementara SO-nya
   milik customer. Billed To dikosongkan berarti sama dengan customernya.

   Dirender mPDF: tidak ada flex/grid, semua tata letak memakai tabel.
   Dari controller (Arnag::report_proforma_invoice):
     $data_proforma_invoice, $data_proforma_invoice_detail,
     $data_proforma_invoice_total, $data_proforma_invoice_grandtotal,
     $data_proforma_diskon
   =========================================================================== */
ini_set('pcre.backtrack_limit', '3000000');

$this->load->view('arnag/_tgl_inggris');

$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};
$ambil = function ($sumber, $kunci, $bawaan = '') {
    return isset($sumber[$kunci]) && trim((string) $sumber[$kunci]) !== ''
        ? $sumber[$kunci] : $bawaan;
};

$pi     = isset($data_proforma_invoice) ? (array) $data_proforma_invoice : array();
$baris  = isset($data_proforma_invoice_detail) ? (array) $data_proforma_invoice_detail : array();
$jumlah = isset($data_proforma_invoice_grandtotal) ? (array) $data_proforma_invoice_grandtotal : array();
$potong = isset($data_proforma_diskon) ? (array) $data_proforma_diskon : array();
$gbr    = FCPATH . 'assets/build/img/';

/* ---- Siapa yang ditagih ----
   Billed To kalau diisi, kalau tidak customer pemilik SO-nya. Alamat &
   telponnya ikut yang sama supaya satu blok tidak campur dua pihak. */
$ditagih_nama   = $ambil($pi, 'billed_to_nama', $ambil($pi, 'customer', '-'));
$pakai_billed   = trim((string) $ambil($pi, 'billed_to_nama')) !== '';
$ditagih_alamat = $pakai_billed
    ? $ambil($pi, 'billed_to_alamat', '-') : $ambil($pi, 'alamat', '-');
$ditagih_telp   = $pakai_billed
    ? $ambil($pi, 'billed_to_phone', '-') : $ambil($pi, 'phone', '-');

$curr = strtoupper((string) $ambil($pi, 'curr',
    $ambil(isset($baris[0]) ? $baris[0] : array(), 'curr')));

/* Nomor SO ditulis berderet dipisah koma, tanpa dobel. */
$so = array();
foreach ($baris as $b) {
    $n = trim((string) (isset($b['no_so']) ? $b['no_so'] : ''));
    if ($n !== '' && !in_array($n, $so, true)) { $so[] = $n; }
}

/* Jumlah qty seluruh baris - angkanya sudah diformat model, komanya dibuang
   dulu sebelum dijumlah. */
$total_qty = 0;
foreach ($baris as $b) {
    $total_qty += (float) str_replace(',', '', (string) $ambil($b, 'qty', 0));
}
$total_qty_tampil = rtrim(rtrim(number_format($total_qty, 2, '.', ','), '0'), '.');

/* ---- Baris rekap ----
   Susunannya sama dengan cetakan lama: nilai sebelum pajak, diskon, pajak,
   lalu Grand Total; DP dicetak di bawahnya karena itu bagian yang ditagih
   lebih dulu, bukan pengurang nilai proformanya. */
$angka = function ($nilai) {
    $n = (float) str_replace(',', '', (string) $nilai);
    return number_format($n, 2, '.', ',');
};
$rekap = array(
    array('Total', $angka($ambil($jumlah, 'twot', 0) + (float) str_replace(',', '', (string) $ambil($potong, 'diskon', 0))), false),
    array('Discount', $angka($ambil($potong, 'diskon', 0)), false),
    array('Total Without Tax', $angka($ambil($jumlah, 'twot', 0)), false),
    array('Taxes', $angka($ambil($jumlah, 'ppn', 0)), false),
    array('Grand Total', $angka($ambil($jumlah, 'total', 0)), true),
);
// Down Payment cuma dicetak kalau memang ada - baris nol cuma bikin
// pembaca bertanya-tanya, dan proforma biasa memang tidak punya DP.
$dp_nilai = (float) str_replace(',', '', (string) $ambil($jumlah, 'dp', 0));
if ($dp_nilai > 0) {
    $rekap[] = array('Down Payment', $angka($dp_nilai), false);
}

/* ---- DP / CBD ----
   Cetakan ini dipakai juga untuk proforma DP & CBD. Yang membedakan cuma
   jenisnya di judul dan satu baris nilai yang ditagih di muka; sisanya
   sama persis, jadi tidak perlu cetakan tersendiri. */
$dpcbd = isset($data_invoice_dpcbd) ? (array) $data_invoice_dpcbd : array();
$jenis = strtoupper(trim((string) $ambil($dpcbd, 'type')));
$nilai_muka = $ambil($dpcbd, 'amount', '');

/* Stempel APPROVED dicetak kalau proformanya sudah disetujui penuh -
   aturannya sama dengan cetakan invoice. */
$sudah_approve = in_array(
    strtoupper(trim((string) $ambil($pi, 'status'))),
    array('SECOND APPROVED', 'APPROVED'),
    true
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Proforma Invoice <?= $esc($ambil($pi, 'no_pi')); ?></title>
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

        /* ---- Keterangan ---- */
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

        /* ---- Pembayaran & stempel ---- */
        .bayar { width: 100%; margin-top: 30px; }
        .bayar td { vertical-align: top; }
        .judul-bayar { font-size: 13px; font-weight: bold; padding-left: 9px; border-left: 3px solid #e2231a; }
        .rek { width: 100%; font-size: 11.5px; margin-top: 9px; }
        .rek td { padding: 2px 0; vertical-align: top; }
        .rek .lbl { width: 116px; font-weight: bold; }
        .rek .titik { width: 10px; }
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

    <div class="judul">PROFORMA INVOICE<?= $jenis !== '' ? ' ' . $esc($jenis) : ''; ?></div>
    <div class="nomor"><?= $esc($ambil($pi, 'no_pi')); ?></div>

    <table class="info">
        <tr>
            <td class="label">Date</td>
            <td class="titik">:</td>
            <td><?= $esc(tgl_inggris($ambil($pi, 'date_pi'))); ?></td>
        </tr>
        <tr>
            <td class="label"><?= $pakai_billed ? 'Billed To' : 'To'; ?></td>
            <td class="titik">:</td>
            <td><?= $esc($ditagih_nama); ?></td>
        </tr>
        <tr>
            <td class="label">Address</td>
            <td class="titik">:</td>
            <td><?= nl2br($esc($ditagih_alamat)); ?></td>
        </tr>
        <tr>
            <td class="label">Telp.</td>
            <td class="titik">:</td>
            <td><?= $esc($ditagih_telp); ?></td>
        </tr>
        <!-- <tr>
            <td class="label">Tax Invoice No</td>
            <td class="titik">:</td>
            <td><?= $esc($ambil($pi, 'no_faktur_pajak', '-')); ?></td>
        </tr>
        <tr>
            <td class="label">Shipment</td>
            <td class="titik">:</td>
            <td><?= $esc($ambil($pi, 'shipp', '-')); ?></td>
        </tr>
        <tr>
            <td class="label">PEB#</td>
            <td class="titik">:</td>
            <td><?= $esc($ambil($pi, 'peb', '-')); ?></td>
        </tr> -->
        <tr>
            <td class="label">Sales Order#</td>
            <td class="titik">:</td>
            <td><?= $so ? $esc(implode(', ', $so)) : '-'; ?></td>
        </tr>
    </table>

    <table class="rincian">
        <thead>
            <tr>
                <th width="22%">SO Number</th>
                <th width="34%">Product Item</th>
                <th width="11%">Qty</th>
                <th width="8%">UOM</th>
                <th width="12%">Unit Price<?= $curr !== '' ? ' ' . $esc($curr) : ''; ?></th>
                <th width="13%">Total<?= $curr !== '' ? ' ' . $esc($curr) : ''; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($baris as $b) : ?>
                <tr>
                    <td><?= $esc($ambil($b, 'no_so', '-')); ?></td>
                    <td><?= $esc($ambil($b, 'produk_detail', '-')); ?></td>
                    <td class="angka"><?= $esc($ambil($b, 'qty', '0')); ?></td>
                    <td class="tengah"><?= $esc($ambil($b, 'uom', '-')); ?></td>
                    <td class="angka"><?= $esc($ambil($b, 'unit_price', '0')); ?></td>
                    <td class="angka"><?= $esc($ambil($b, 'total_price', '0.00')); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="jumlah">
                <td colspan="2">Total Quantity</td>
                <td class="angka"><?= $esc($total_qty_tampil); ?></td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

    <table width="100%" style="margin-top: 12px;">
        <tr>
            <td width="52%"></td>
            <td width="48%">
                <table class="rekap">
                    <?php foreach ($rekap as $r) : ?>
                        <tr<?= $r[2] ? ' class="akhir"' : ''; ?>>
                            <td class="ket"><?= $esc($r[0]); ?></td>
                            <td class="mata"><?= $esc($curr); ?></td>
                            <td class="nilai"><?= $esc($r[1]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($jenis !== '' && trim((string) $nilai_muka) !== '') : ?>
                        <!-- Yang benar-benar ditagih lewat proforma ini: nilai DP-nya,
                             atau seluruhnya untuk CBD. -->
                        <tr class="akhir">
                            <td class="ket"><?= $esc($jenis); ?> Amount</td>
                            <td class="mata"><?= $esc($curr); ?></td>
                            <td class="nilai"><?= $esc($nilai_muka); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
    </table>

    <table class="bayar">
        <tr>
            <td width="54%">
                <!-- Spasinya harus &nbsp;: spasi biasa di awal baris dibuang HTML,
                     dan padding-left diabaikan mPDF untuk blok di dalam sel tabel. -->
                <div class="judul-bayar">&nbsp;&nbsp;Please Transfer The Payment To:</div>
                <table class="rek">
                    <tr>
                        <td class="lbl">Banker</td>
                        <td class="titik">:</td>
                        <td><?= $esc($ambil($pi, 'nama_bank', '-')); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Bank Address</td>
                        <td class="titik">:</td>
                        <td><?= nl2br($esc($ambil($pi, 'v_bankaddress', '-'))); ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Account Number</td>
                        <td class="titik">:</td>
                        <td><?= $esc($ambil($pi, 'no_rek', '-')); ?></td>
                    </tr>
                    <?php if (trim((string) $ambil($pi, 'v_swiftcode')) !== '') : ?>
                        <tr>
                            <td class="lbl">Swift Code</td>
                            <td class="titik">:</td>
                            <td><?= $esc($ambil($pi, 'v_swiftcode')); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </td>
            <td width="46%" class="sekat">
                <?php if ($sudah_approve) : ?>
                    <!-- Seluruh panel (kotak, ikon, teks) satu SVG - mPDF tidak
                         mengecat latar/garis blok di dalam sel tabel dengan
                         benar, hasilnya belang per baris teks. -->
                    <img src="<?= $gbr; ?>dn_approved.svg" width="260">
                <?php endif; ?>
            </td>
        </tr>
    </table>

</body>

</html>
