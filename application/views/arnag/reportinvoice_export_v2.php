<?php
/* ===========================================================================
   Commercial Invoice EXPORT - bentuk dokumennya mengikuti cetakan Invoice
   Export (versi CM) di menu Invoice EXIM, yang memang jadi acuan tim EXIM:
   kop, pihak-pihak (SHIP FROM / PURCHASER-INVOICE TO / ULTIMATE CONSIGNEE / SHIP TO), blok Shipment
   Details, Invoice Summary per warna, Invoice Notes & Manufacturer
   Information, lalu tanda tangan.

   Invoice export tidak dicetak dari baris SJ-nya seperti invoice local -
   isinya sudah disiapkan waktu booking di menu Invoice EXIM dan tersimpan di
   database AR (tbl_book_invoice_exim_export_h / _ship / _det). Yang dibaca di
   sini cuma versi CM, yaitu harga yang ditagih AR.

   Dirender mPDF: tidak ada flex/grid, semua tata letak memakai tabel.
   Dari controller (Arnag::report_invoice_v2 / preview_invoice_v2):
     $data_cetak  hasil Model_nag::data_cetak_export()
     $rekap       angka rekap yang dipakai (tersimpan di AR, atau dari layar
                  waktu pratinjau): total, discount, dp, dp_cbd, retur, twot,
                  vat, grand
   =========================================================================== */
ini_set('pcre.backtrack_limit', '3000000');

$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};
$gbr = FCPATH . 'assets/build/img/';

$inv     = isset($data_cetak['header']) ? $data_cetak['header'] : array();
$kirim   = isset($data_cetak['kirim']) ? $data_cetak['kirim'] : array();
$summary = isset($data_cetak['summary']) ? $data_cetak['summary'] : array();
$ada_set = !empty($data_cetak['ada_set']);
$sub_qty = isset($data_cetak['sub_qty']) ? (float) $data_cetak['sub_qty'] : 0;
$sub_total = isset($data_cetak['sub_total']) ? (float) $data_cetak['sub_total'] : 0;
$vat_persen = isset($data_cetak['vat_persen']) ? (float) $data_cetak['vat_persen'] : 0;

$ambil = function ($sumber, $kunci, $bawaan = '') {
    return isset($sumber[$kunci]) && trim((string) $sumber[$kunci]) !== '' ? $sumber[$kunci] : $bawaan;
};
$angka_rekap = function ($kunci) use ($rekap) {
    return isset($rekap[$kunci])
        ? (float) str_replace(',', '', (string) $rekap[$kunci]) : 0.0;
};

/* ------------------------------- angka ------------------------------- */
$uang = function ($n) {
    $n = (float) $n;
    return ($n < 0 ? '- ' : '') . number_format(abs($n), 2, '.', ',');
};
// Qty & karton: tanpa desimal kalau bulat.
$bulat = function ($n) {
    $n = (float) $n;
    return floor($n) == $n
        ? number_format($n, 0, '.', ',')
        : rtrim(rtrim(number_format($n, 2, '.', ','), '0'), '.');
};
$berat = function ($n) { return number_format((float) $n, 3, '.', ','); };
// Unit cost: minimal 2, maksimal 4 desimal (0.76 / 1,142.8571).
$unit = function ($n) {
    $t = rtrim(number_format((float) $n, 4, '.', ','), '0');
    $des = strlen(substr(strrchr($t, '.'), 1));
    return $t . str_repeat('0', max(0, 2 - $des));
};
$ada_nilai = function ($n) { return abs((float) $n) >= 0.005; };

/**
 * Alamat ditulis huruf besar di awal kata saja ("Jl. Raya Rancaekek"), bukan
 * kapital semua - datanya di master memang tersimpan kapital semua dan itu
 * melelahkan dibaca sebanyak ini.
 *
 * Yang DIBIARKAN kapital: singkatan badan usaha & kode negara (PT, CV, PTE,
 * LTD, LLC, ...) dan kode wilayah dua huruf yang diikuti kode pos (mis.
 * "CA 94105", "TN 37066") - kalau ikut dikecilkan malah jadi "Ca"/"Tn".
 *
 * Kalau nanti dirasa lebih cocok kapital semua, cukup ganti isi fungsi ini
 * dengan mb_strtoupper(); pemakainya tidak perlu diubah.
 */
$rapikan_alamat = function ($teks) use ($esc) {
    $teks = trim((string) $teks);
    if ($teks === '') {
        return '';
    }

    $tetap_kapital = array('PT', 'CV', 'PTE', 'LTD', 'LLC', 'INC', 'CO', 'TBK',
        'US', 'USA', 'UK', 'UAE', 'EPZ', 'RT', 'RW');
    // Kata sambung tetap huruf kecil kalau bukan kata pertama - "United States
    // of America", bukan "United States Of America".
    $kata_kecil = array('of', 'the', 'and', 'for', 'in', 'on', 'at', 'to', 'de', 'da', 'del');

    // Dipecah berikut spasinya supaya jarak aslinya tidak berubah.
    $bagian = preg_split('/(\s+)/u', $teks, -1, PREG_SPLIT_DELIM_CAPTURE);
    $jml = count($bagian);
    for ($i = 0; $i < $jml; $i += 2) {
        $kata = $bagian[$i];
        if ($kata === '' || $kata !== mb_strtoupper($kata, 'UTF-8')) {
            // Sudah ada huruf kecilnya - biarkan apa adanya.
            $bagian[$i] = $kata;
            continue;
        }
        $huruf = strtoupper(preg_replace('/[^A-Za-z]/', '', $kata));
        $sesudahnya = isset($bagian[$i + 2]) ? $bagian[$i + 2] : '';
        $diikuti_kode_pos = (bool) preg_match('/^\d{4,6}[.,]?$/', $sesudahnya);

        if ($huruf !== '' && in_array($huruf, $tetap_kapital, true)) {
            continue;
        }
        if (strlen($huruf) === 2 && $diikuti_kode_pos) {
            continue;
        }
        $kecil = mb_strtolower($kata, 'UTF-8');
        $bagian[$i] = ($i > 0 && in_array($kecil, $kata_kecil, true))
            ? $kecil
            : mb_convert_case($kecil, MB_CASE_TITLE, 'UTF-8');
    }

    return $esc(implode('', $bagian));
};

/* ------------------------------ tanggal ------------------------------ */
// Ditulis gaya Inggris - "22 Sep 2026" - sama dengan cetakan invoice AR yang lain.
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

$curr = strtoupper((string) $ambil($inv, 'curr'));
$simbol = $curr === 'USD' ? '$' : $curr;
$judul = strtoupper((string) $ambil($inv, 'type', 'COMMERCIAL')) . ' INVOICE';
// Satu nomor saja: Invoice Number #2 kalau diisi (buyer minta penomoran
// sendiri), selain itu nomor sistem.
$no_cetak = $ambil($inv, 'no_invoice_2', $ambil($inv, 'no_invoice'));
$tgl_cetak = $tanggal($ambil($inv, 'tgl_invoice', $ambil($inv, 'tgl_inv')));

/* ---------------------------- pihak-pihak ---------------------------- */
// Nama + alamat jadi daftar baris cetak; baris kosong dibuang.
$baris_alamat = function ($nama, $alamat) {
    $out = array();
    if (trim((string) $nama) !== '') {
        $out[] = trim((string) $nama);
    }
    foreach (preg_split('/\r\n|\r|\n/', (string) $alamat) as $b) {
        if (trim($b) !== '') {
            $out[] = trim($b);
        }
    }
    return $out;
};
$pihak = array(
    array('SHIP FROM', $baris_alamat($ambil($inv, 'shipper_nama'), $ambil($inv, 'shipper_alamat')),
        trim((string) $ambil($inv, 'shipper_nama')) !== ''),
    // Labelnya saja yang berbeda; isinya tetap dari kolom yang sama -
    // disamakan dengan cetakan di menu Invoice EXIM.
    array('PURCHASER / INVOICE TO', $baris_alamat($ambil($inv, 'seller_nama'), $ambil($inv, 'seller_alamat')),
        trim((string) $ambil($inv, 'seller_nama')) !== ''),
    array('ULTIMATE CONSIGNEE', $baris_alamat($ambil($inv, 'purchaser_nama'), $ambil($inv, 'purchaser_alamat')),
        trim((string) $ambil($inv, 'purchaser_nama')) !== ''),
    array('SHIP TO', $baris_alamat($ambil($inv, 'receiver_nama'), $ambil($inv, 'receiver_alamat')),
        trim((string) $ambil($inv, 'receiver_nama')) !== ''),
);

// Alamat Manufacturer Information cukup 2 baris.
$alamat_pabrik = array_values(array_filter(array_map('trim',
    preg_split('/\r\n|\r|\n/', (string) $ambil($inv, 'manufacturer_alamat'))), 'strlen'));
if (count($alamat_pabrik) > 2) {
    $alamat_pabrik = array($alamat_pabrik[0], implode(' ', array_slice($alamat_pabrik, 1)));
}

/* ------------------------------- rekap ------------------------------- */
// Cuma baris yang memang ada isinya yang ditulis. Cetakan EXIM menyediakan
// "Total Dozens" & "Hard Tag Cost" untuk buyer yang memakainya; di AR dua-duanya
// tidak pernah terisi, dan selama tidak ada hard tag cost "Gross Invoice Sub
// total" isinya sama persis dengan Sub Total - jadi barisnya tidak diulang.
$rekap_baris = array(
    array('Sub Total', $sub_qty, $sub_total, true),
);
$potongan = array(
    'discount' => 'Discount',
    'dp'       => 'Down Payment',
    'dp_cbd'   => 'DP/CBD from Invoice',
    'retur'    => 'Return',
);
foreach ($potongan as $k => $label) {
    if ($ada_nilai($angka_rekap($k))) {
        $rekap_baris[] = array($label, null, -$angka_rekap($k), false);
    }
}
if ($ada_nilai($angka_rekap('vat'))) {
    $rekap_baris[] = array('VAT (' . (0 + $vat_persen) . '%)', null, $angka_rekap('vat'), false);
}

// Stempel APPROVED dicetak kalau invoice-nya sudah disetujui penuh - aturannya
// sama dengan cetakan invoice lokal & Debit Note. Kolom tanda tangan basah
// tidak dipakai lagi.
$sudah_approve = in_array(
    strtoupper(trim((string) (isset($status_invoice) ? $status_invoice : ''))),
    array('SECOND APPROVED', 'APPROVED'),
    true
);

$kop = array(
    'nama'   => 'PT. NIRWANA ALABARE GARMENT',
    'alamat' => array(
        'Jl. Raya Rancaekek &#8211; Majalaya No. 289 Desa Solokan Jeruk, Kecamatan Solokan Jeruk,',
        'Kabupaten Bandung 40382 Jawa Barat - Indonesia',
    ),
    'telp'   => 'Phone : +62 22 8596 2076 / +62 22 8596 2081',
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $esc($no_cetak); ?></title>
    <style>
        /* Kaki halaman didaftarkan lewat @page supaya ikut di semua halaman. */
        @page {
            odd-footer-name: html_kaki;
            even-footer-name: html_kaki;
        }

        body { font-family: sans-serif; font-size: 11px; color: #222222; }
        table { border-collapse: collapse; width: 100%; }
        td, th { vertical-align: top; }

        /* ---- Kop surat ---- */
        .kepala td { vertical-align: top; padding: 0; }
        .kepala .tengah { text-align: center; }
        .nama-pt { font-size: 23px; font-weight: bold; }
        .alamat-pt { font-size: 11px; line-height: 1.35; margin-top: 2px; }

        /* ---- Judul ---- */
        .judul { text-align: center; font-size: 24px; font-weight: bold; color: #e2231a; margin-top: 8px; }
        .nomor { text-align: center; font-size: 13.5px; font-weight: bold; margin-top: 1px; }
        .nomor .tanggal { font-weight: normal; color: #555555; }

        /* ---- Blok berjudul garis merah (pihak, notes, manufacturer) ---- */
        .blok { font-size: 11.5px; }
        .blok td { padding: 0; }
        .blok td.garis { width: 3px; }
        .blok td.garis.merah { background: #e2231a; }
        .blok td.judul-blok { font-size: 12.5px; font-weight: bold; padding: 1px 0 1px 8px; }
        .blok td.isi { padding: 3px 0 0 8px; line-height: 1.35; }
        /* Nama pihaknya yang ditonjolkan; alamatnya lebih kecil & huruf kapital
           semua supaya blok-bloknya enak dibaca sekilas. Pindah barisnya pakai
           <br>, bukan display:block - mPDF tidak menuruti display pada elemen
           inline di dalam sel tabel, hasilnya alamatnya nempel ke namanya. */
        .blok td.isi .alamat { font-size: 9.5px; line-height: 1.45; }
        .blok td.sekat { width: 14px; border-right: 1px solid #e6e6e6; }
        .blok td.sela { width: 14px; }

        /* ---- Tabel bergaris tipis (shipment & summary) ---- */
        .grid { font-size: 10.5px; }
        .grid th { background: #f5f6f7; border: 1px solid #dcdcdc; padding: 3px 5px; font-weight: bold; text-align: center; vertical-align: middle; line-height: 1.25; }
        .grid td { border: 1px solid #dcdcdc; padding: 3px 5px; text-align: center; vertical-align: middle; }
        .grid .kiri { text-align: left; }
        .grid .ket-produk { background: #f5f6f7; font-weight: bold; }
        .ringkas .simbol { border-right: none; text-align: left; padding-right: 0; }
        .ringkas .nilai { border-left: none; text-align: right; }
        .ringkas .tebal { font-weight: bold; }
        .ringkas .total-nilai { font-weight: bold; background: #fdeef0; }
        .grid td.tanpa-atas { border-top: none; }

        .jarak { height: 10px; }
        .tengah { text-align: center; }

        /* ---- Blok penutup ----
           Kiri: Invoice Notes lalu Manufacturer Information + REFF.
           Kanan: pernyataan kebenaran data lalu stempel APPROVED - tidak ada
           kolom tanda tangan basah, sama seperti cetakan invoice lokal AR.
           Semuanya satu tabel supaya kolomnya sejajar dan garis tipis
           pemisahnya lurus dari atas sampai bawah. */
        .blok tr.blok-lanjutan td { padding-top: 14px; }
        .blok td.penutup-kanan .janji { margin-bottom: 12px; }
        .blok .reff { width: auto; margin-top: 6px; }
        .blok .reff td { padding: 2px 0; }
        .blok .reff .lbl { width: 62px; font-weight: bold; }
        .blok .reff .titik { width: 10px; }

        /* ---- Kaki halaman ---- */
        .kaki { width: 100%; font-size: 8.5px; border-top: 1px solid #f0cbcf; }
        .kaki .kiri { color: #8a8a8a; letter-spacing: 1.6px; padding-top: 4px; }
        .kaki .hal { color: #8a8a8a; text-align: center; font-size: 9px; padding-top: 4px; }
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

    <!-- ===== Kop surat ===== -->
    <table class="kepala">
        <tr>
            <td width="32mm"><img src="<?= FCPATH; ?>nag_logo3.jpg" width="96"></td>
            <td width="130mm" class="tengah">
                <div class="nama-pt"><?= $kop['nama']; ?></div>
                <div class="alamat-pt">
                    <?php foreach ($kop['alamat'] as $i => $b) : ?>
                        <?= $i ? '<br>' : ''; ?><?= $b; ?>
                    <?php endforeach; ?>
                    <br><?= $kop['telp']; ?>
                </div>
            </td>
            <td width="32mm" align="right"><img src="<?= $gbr; ?>dn_caring.svg" width="92"></td>
        </tr>
    </table>

    <!-- ===== Judul, nomor & tanggal ===== -->
    <div class="judul"><?= $esc($judul); ?></div>
    <div class="nomor">INVOICE NO : <?= $esc($no_cetak); ?>
        <span class="tanggal">&nbsp;&nbsp;|&nbsp;&nbsp;DATE : <?= $esc($tgl_cetak); ?></span></div>

    <!-- ===== Pihak-pihak: SHIP FROM | PURCHASER / INVOICE TO, lalu ULTIMATE CONSIGNEE | SHIP TO ===== -->
    <?php foreach (array(array($pihak[0], $pihak[1]), array($pihak[2], $pihak[3])) as $pasang) : ?>
        <div class="jarak"></div>
        <table class="blok">
            <tr>
                <td class="garis merah"></td>
                <td class="judul-blok" width="46%"><?= $esc($pasang[0][0]); ?></td>
                <td class="sekat"></td>
                <td class="sela"></td>
                <td class="garis merah"></td>
                <td class="judul-blok"><?= $esc($pasang[1][0]); ?></td>
            </tr>
            <tr>
                <?php foreach ($pasang as $j => $p) : ?>
                    <?php if ($j === 1) : ?>
                        <td class="sekat"></td>
                        <td class="sela"></td>
                    <?php endif; ?>
                    <td class="garis"></td>
                    <td class="isi">
                        <?php
                        // Baris pertama = nama pihaknya (kalau memang diisi),
                        // sisanya alamat: huruf kecilnya dikapitalkan semua dan
                        // ukurannya lebih kecil dari namanya.
                        $mulai = 0;
                        if ($p[2] && isset($p[1][0])) {
                            echo '<b>' . $esc($p[1][0]) . '</b>';
                            $mulai = 1;
                        }
                        $alamat = array_slice($p[1], $mulai);
                        if ($alamat) {
                            echo ($mulai ? '<br>' : '') . '<span class="alamat">'
                                . implode('<br>', array_map($rapikan_alamat, $alamat)) . '</span>';
                        }
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
    <?php endforeach; ?>

    <!-- ===== Shipment Details - satu blok per baris Shipment ===== -->
    <?php foreach ($kirim as $k) : ?>
        <div class="jarak"></div>
        <table class="grid">
            <tr>
                <th style="width:11%">Dest Purchase</th>
                <th style="width:13%">Style NO</th>
                <th style="width:11%">Brand</th>
                <th style="width:11%">Chanel Description</th>
                <th style="width:13%">Currency</th>
                <th style="width:13%">Payment Term</th>
                <th style="width:13%">Final Destination</th>
                <th style="width:15%">Country of origin</th>
            </tr>
            <tr>
                <td><?= $esc($ambil($k, 'dest_purchase')); ?></td>
                <td><?= $esc($ambil($k, 'style_no')); ?></td>
                <td><?= $esc($ambil($k, 'brand')); ?></td>
                <td><?= $esc($ambil($k, 'chanel_description')); ?></td>
                <td><?= $esc($ambil($k, 'currency')); ?></td>
                <td><?= $esc($ambil($k, 'payment_term')); ?></td>
                <td><?= $esc($ambil($k, 'final_destination')); ?></td>
                <td><?= $esc($ambil($k, 'country_origin')); ?></td>
            </tr>
            <tr>
                <th>Ship Mode</th>
                <th>Term of Sale</th>
                <th>Transfer Point</th>
                <th>Port Of Loading</th>
                <th>Total Gross<br>Weight(KGS)</th>
                <th>Total Net<br>Weight(KGS)</th>
                <th>Total Net Net<br>Weight(KGS)</th>
                <th>Total Carton</th>
            </tr>
            <tr>
                <td><?= $esc($ambil($k, 'ship_mode')); ?></td>
                <td><?= $esc($ambil($k, 'term_of_sale')); ?></td>
                <td><?= $esc($ambil($k, 'transfer_point')); ?></td>
                <td><?= $esc($ambil($k, 'port_of_loading')); ?></td>
                <td><?= $esc($berat($ambil($k, 'total_gross_weight', 0))); ?></td>
                <td><?= $esc($berat($ambil($k, 'total_net_weight', 0))); ?></td>
                <td><?= $esc($berat($ambil($k, 'total_net_net_weight', 0))); ?></td>
                <td><?= $esc($bulat($ambil($k, 'total_carton', 0))); ?></td>
            </tr>
            <tr>
                <td class="ket-produk">Product Description</td>
                <td colspan="7" class="kiri"><?= $esc($ambil($k, 'product_description')); ?></td>
            </tr>
        </table>
    <?php endforeach; ?>

    <!-- ===== Invoice Summary ===== -->
    <div class="jarak"></div>
    <table class="blok">
        <tr>
            <td class="garis merah"></td>
            <td class="judul-blok">Invoice Summary</td>
        </tr>
    </table>
    <table class="grid ringkas" style="margin-top: 6px">
        <!-- Kolom Total Pieces cuma dicetak kalau ada baris SET: untuk satuan
             asli angkanya sama persis dengan Quantity Invoiced. -->
        <tr>
            <th style="width:12%">Color Code</th>
            <th style="width:<?= $ada_set ? 17 : 27; ?>%">Color Name</th>
            <?php if ($ada_set) : ?>
                <th style="width:20%">Total Pieces (SET)</th>
            <?php endif; ?>
            <th style="width:<?= $ada_set ? 20 : 30; ?>%">Quantity Invoiced (Each)</th>
            <th style="width:10%">Unit Cost</th>
            <th style="width:21%" colspan="2">Extended Line Total</th>
        </tr>
        <?php foreach ($summary as $r) : ?>
            <tr>
                <td class="kiri"><?= $esc($r['color_code']); ?></td>
                <td class="kiri"><?= $esc($r['color_name']); ?></td>
                <?php if ($ada_set) : ?>
                    <td><?= $r['satuan'] === 'SET' && $r['total_pieces'] ? $esc($bulat($r['total_pieces'])) : ''; ?></td>
                <?php endif; ?>
                <td><?= $esc($bulat($r['qty'])); ?></td>
                <td><?= $esc($unit($r['unit_cost'])); ?></td>
                <td class="simbol" style="width:4%"><?= $esc($simbol); ?></td>
                <td class="nilai" style="width:17%"><?= $esc($uang($r['extended'])); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Rekap: tabel sendiri, dijaga utuh & tanpa kepala kolom. Lebar kolomnya
         sama dengan tabel di atas. autosize="1" supaya mPDF tidak mengecilkan
         hurufnya demi muat - lebih baik pindah halaman utuh. -->
    <table class="grid ringkas" style="page-break-inside: avoid" autosize="1">
        <?php foreach ($rekap_baris as $i => $r) : ?>
            <?php $atas = $i === 0 ? 'tanpa-atas' : ''; ?>
            <tr>
                <td class="kiri <?= $atas; ?> <?= $r[3] ? 'tebal' : ''; ?>"<?= $i === 0 ? ' style="width:' . ($ada_set ? 29 : 39) . '%"' : ''; ?>><?= $esc($r[0]); ?></td>
                <?php if ($ada_set) : ?>
                    <td class="<?= $atas; ?>"<?= $i === 0 ? ' style="width:20%"' : ''; ?>></td>
                <?php endif; ?>
                <td class="<?= $atas; ?> <?= $r[3] ? 'tebal' : ''; ?>"<?= $i === 0 ? ' style="width:' . ($ada_set ? 20 : 30) . '%"' : ''; ?>><?= $r[1] === null ? '' : $esc($bulat($r[1])); ?></td>
                <td class="<?= $atas; ?>"<?= $i === 0 ? ' style="width:10%"' : ''; ?>></td>
                <td class="simbol <?= $atas; ?> <?= $r[3] ? 'tebal' : ''; ?>"<?= $i === 0 ? ' style="width:4%"' : ''; ?>><?= $r[2] === null ? '' : $esc($simbol); ?></td>
                <td class="nilai <?= $atas; ?> <?= $r[3] ? 'tebal' : ''; ?>"<?= $i === 0 ? ' style="width:17%"' : ''; ?>><?= $r[2] === null ? '' : $esc($uang($r[2])); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td class="kiri tebal" colspan="<?= $ada_set ? 4 : 3; ?>">Net Invoice Total</td>
            <td class="simbol total-nilai"><?= $esc($simbol); ?></td>
            <td class="nilai total-nilai"><?= $esc($uang($angka_rekap('grand'))); ?></td>
        </tr>
    </table>

    <!-- ===== Penutup: kiri Invoice Notes + Manufacturer Information + REFF,
                       kanan pernyataan lalu stempel =====
         Satu tabel saja supaya kolom kiri-kanannya pasti sejajar dan garis
         tipis pemisahnya lurus dari atas sampai bawah. Kolom kanan memakai
         rowspan: isinya satu kesatuan (pernyataan + stempel) yang menemani
         seluruh blok di kiri. -->
    <div class="jarak"></div>
    <table class="blok" style="page-break-inside: avoid" autosize="1">
        <tr>
            <td class="garis merah"></td>
            <td class="judul-blok" width="46%">Invoice Notes</td>
            <td class="sekat"></td>
            <td class="sela"></td>
            <td class="garis" rowspan="4"></td>
            <td class="isi penutup-kanan" rowspan="4">
                <div class="janji">I hereby certify that all information provided is true and correct.</div>
                <?php if ($sudah_approve) : ?>
                    <!-- Seluruh panel (kotak, ikon, teks) satu SVG - sama seperti
                         invoice lokal & Debit Note. mPDF tidak mengecat latar blok
                         di dalam sel tabel dengan benar. -->
                    <img src="<?= $gbr; ?>dn_approved.svg" width="260">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td class="garis"></td>
            <td class="isi"><?= nl2br($esc($ambil($inv, 'invoice_notes'))); ?>&nbsp;</td>
            <td class="sekat"></td>
            <td class="sela"></td>
        </tr>
        <tr class="blok-lanjutan">
            <td class="garis merah"></td>
            <td class="judul-blok">Manufacturer Information</td>
            <td class="sekat"></td>
            <td class="sela"></td>
        </tr>
        <tr>
            <td class="garis"></td>
            <td class="isi">
                <b><?= $esc($ambil($inv, 'manufacturer_nama')); ?></b>
                <?php if ($alamat_pabrik) : ?>
                    <br><span class="alamat"><?= implode('<br>', array_map($rapikan_alamat, $alamat_pabrik)); ?></span>
                <?php endif; ?>
                <?php if (trim((string) $ambil($inv, 'reference')) !== '') : ?>
                    <table class="reff">
                        <tr>
                            <td class="lbl">REFF</td>
                            <td class="titik">:</td>
                            <td><?= $esc($ambil($inv, 'reference')); ?></td>
                        </tr>
                    </table>
                <?php endif; ?>
            </td>
            <td class="sekat"></td>
            <td class="sela"></td>
        </tr>
    </table>

</body>
</html>
