<?php
/* ===========================================================================
   Invoice EXPORT - versi Excel dari cetakan PDF-nya
   (arnag/reportinvoice_export_v2.php), yang bentuknya mengikuti Invoice
   Export versi CM di menu Invoice EXIM.

   Susunannya sama persis dengan PDF: kop, judul + nomor & tanggal,
   pihak-pihak (SHIP FROM / SELLER / PURCHASER / SHIP TO), Shipment Details,
   Invoice Summary per warna, rekap sampai Net Invoice Total, lalu Invoice
   Notes + Manufacturer Information + REFF di kiri dan pernyataan + keterangan
   APPROVED di kanan.

   Data dari controller (Arnag::export_excel_invoice_v2) sama dengan yang
   dipakai cetakan PDF-nya: $data_cetak + $rekap (+ $status_invoice).
   =========================================================================== */
$esc = function ($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
};

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
    return isset($rekap[$kunci]) ? (float) str_replace(',', '', (string) $rekap[$kunci]) : 0.0;
};

/* ------------------------------- angka ------------------------------- */
$uang = function ($n) {
    $n = (float) $n;
    return ($n < 0 ? '- ' : '') . number_format(abs($n), 2, '.', ',');
};
$bulat = function ($n) {
    $n = (float) $n;
    return floor($n) == $n
        ? number_format($n, 0, '.', ',')
        : rtrim(rtrim(number_format($n, 2, '.', ','), '0'), '.');
};
$berat = function ($n) { return number_format((float) $n, 3, '.', ','); };
$unit = function ($n) {
    $t = rtrim(number_format((float) $n, 4, '.', ','), '0');
    $des = strlen(substr(strrchr($t, '.'), 1));
    return $t . str_repeat('0', max(0, 2 - $des));
};
$ada_nilai = function ($n) { return abs((float) $n) >= 0.005; };

/* ---- alamat: huruf besar di awal kata, aturannya sama dengan PDF ---- */
$rapikan_alamat = function ($teks) use ($esc) {
    $teks = trim((string) $teks);
    if ($teks === '') {
        return '';
    }
    $tetap_kapital = array('PT', 'CV', 'PTE', 'LTD', 'LLC', 'INC', 'CO', 'TBK',
        'US', 'USA', 'UK', 'UAE', 'EPZ', 'RT', 'RW');
    $kata_kecil = array('of', 'the', 'and', 'for', 'in', 'on', 'at', 'to', 'de', 'da', 'del');

    $bagian = preg_split('/(\s+)/u', $teks, -1, PREG_SPLIT_DELIM_CAPTURE);
    $jml = count($bagian);
    for ($i = 0; $i < $jml; $i += 2) {
        $kata = $bagian[$i];
        if ($kata === '' || $kata !== mb_strtoupper($kata, 'UTF-8')) {
            continue;
        }
        $huruf = strtoupper(preg_replace('/[^A-Za-z]/', '', $kata));
        $sesudahnya = isset($bagian[$i + 2]) ? $bagian[$i + 2] : '';
        if ($huruf !== '' && in_array($huruf, $tetap_kapital, true)) {
            continue;
        }
        if (strlen($huruf) === 2 && preg_match('/^\d{4,6}[.,]?$/', $sesudahnya)) {
            continue;
        }
        $kecil = mb_strtolower($kata, 'UTF-8');
        $bagian[$i] = ($i > 0 && in_array($kecil, $kata_kecil, true))
            ? $kecil
            : mb_convert_case($kecil, MB_CASE_TITLE, 'UTF-8');
    }
    return $esc(implode('', $bagian));
};

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
$no_cetak = $ambil($inv, 'no_invoice_2', $ambil($inv, 'no_invoice'));
$tgl_cetak = $tanggal($ambil($inv, 'tgl_invoice', $ambil($inv, 'tgl_inv')));

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
    array('SELLER', $baris_alamat($ambil($inv, 'seller_nama'), $ambil($inv, 'seller_alamat')),
        trim((string) $ambil($inv, 'seller_nama')) !== ''),
    array('PURCHASER', $baris_alamat($ambil($inv, 'purchaser_nama'), $ambil($inv, 'purchaser_alamat')),
        trim((string) $ambil($inv, 'purchaser_nama')) !== ''),
    array('SHIP TO', $baris_alamat($ambil($inv, 'receiver_nama'), $ambil($inv, 'receiver_alamat')),
        trim((string) $ambil($inv, 'receiver_nama')) !== ''),
);

$alamat_pabrik = array_values(array_filter(array_map('trim',
    preg_split('/\r\n|\r|\n/', (string) $ambil($inv, 'manufacturer_alamat'))), 'strlen'));
if (count($alamat_pabrik) > 2) {
    $alamat_pabrik = array($alamat_pabrik[0], implode(' ', array_slice($alamat_pabrik, 1)));
}

$rekap_baris = array(array('Sub Total', $sub_qty, $sub_total, true));
foreach (array('discount' => 'Discount', 'dp' => 'Down Payment',
    'dp_cbd' => 'DP/CBD from Invoice', 'retur' => 'Return') as $k => $label) {
    if ($ada_nilai($angka_rekap($k))) {
        $rekap_baris[] = array($label, null, -$angka_rekap($k), false);
    }
}
if ($ada_nilai($angka_rekap('vat'))) {
    $rekap_baris[] = array('VAT (' . (0 + $vat_persen) . '%)', null, $angka_rekap('vat'), false);
}

$sudah_approve = in_array(
    strtoupper(trim((string) (isset($status_invoice) ? $status_invoice : ''))),
    array('SECOND APPROVED', 'APPROVED'),
    true
);

// Jumlah kolom tabel: 8 (sama dengan blok Shipment Details di PDF).
$kolom = 8;

$nama_berkas = 'INV_' . preg_replace('/[^A-Za-z0-9._-]/', '_', (string) $no_cetak) . '.xls';
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $nama_berkas . '"');
header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $esc($no_cetak); ?></title>
    <style>
        table { border-collapse: collapse; }
        td, th { font-family: Arial, sans-serif; font-size: 10pt; vertical-align: top; }
        .nama-pt { font-size: 15pt; font-weight: bold; text-align: center; }
        .alamat-pt { font-size: 9pt; text-align: center; }
        .judul { font-size: 16pt; font-weight: bold; text-align: center; color: #e2231a; }
        .nomor { font-size: 11pt; font-weight: bold; text-align: center; }
        .judul-blok { font-weight: bold; font-size: 10.5pt; }
        .alamat { font-size: 9pt; color: #555555; }
        .sel { border: 1px solid #b0b0b0; }
        .kepala { border: 1px solid #b0b0b0; background: #f5f6f7; font-weight: bold; text-align: center; }
        .angka { text-align: right; }
        .tengah { text-align: center; }
        .tebal { font-weight: bold; }
        .grand { background: #fdeef0; font-weight: bold; }
        .catatan { font-size: 9pt; color: #555555; }
    </style>
</head>
<body>

<table>
    <!-- ===== Kop surat ===== -->
    <tr><td colspan="<?= $kolom; ?>" class="nama-pt">PT. NIRWANA ALABARE GARMENT</td></tr>
    <tr><td colspan="<?= $kolom; ?>" class="alamat-pt">Jl. Raya Rancaekek - Majalaya No. 289 Desa Solokan Jeruk, Kecamatan Solokan Jeruk,</td></tr>
    <tr><td colspan="<?= $kolom; ?>" class="alamat-pt">Kabupaten Bandung 40382 Jawa Barat - Indonesia</td></tr>
    <tr><td colspan="<?= $kolom; ?>" class="alamat-pt">Phone : +62 22 8596 2076 / +62 22 8596 2081</td></tr>
    <tr><td colspan="<?= $kolom; ?>">&nbsp;</td></tr>

    <!-- ===== Judul, nomor & tanggal ===== -->
    <tr><td colspan="<?= $kolom; ?>" class="judul"><?= $esc($judul); ?></td></tr>
    <tr><td colspan="<?= $kolom; ?>" class="nomor">INVOICE NO : <?= $esc($no_cetak); ?>&nbsp;&nbsp;|&nbsp;&nbsp;DATE : <?= $esc($tgl_cetak); ?></td></tr>
    <tr><td colspan="<?= $kolom; ?>">&nbsp;</td></tr>

    <!-- ===== Pihak-pihak: SHIP FROM | SELLER, lalu PURCHASER | SHIP TO ===== -->
    <?php foreach (array(array($pihak[0], $pihak[1]), array($pihak[2], $pihak[3])) as $pasang) : ?>
        <tr>
            <td colspan="4" class="judul-blok"><?= $esc($pasang[0][0]); ?></td>
            <td colspan="4" class="judul-blok"><?= $esc($pasang[1][0]); ?></td>
        </tr>
        <?php
        $tinggi = max(count($pasang[0][1]), count($pasang[1][1]));
        for ($b = 0; $b < $tinggi; $b++) :
        ?>
            <tr>
                <?php foreach ($pasang as $p) : ?>
                    <td colspan="4" class="<?= ($b === 0 && $p[2]) ? 'tebal' : 'alamat'; ?>">
                        <?php
                        if (!isset($p[1][$b])) {
                            echo '';
                        } elseif ($b === 0 && $p[2]) {
                            echo $esc($p[1][$b]);
                        } else {
                            echo $rapikan_alamat($p[1][$b]);
                        }
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor; ?>
        <tr><td colspan="<?= $kolom; ?>">&nbsp;</td></tr>
    <?php endforeach; ?>

    <!-- ===== Shipment Details - satu blok per baris shipment ===== -->
    <?php foreach ($kirim as $k) : ?>
        <tr>
            <td class="kepala">Dest Purchase</td>
            <td class="kepala">Style NO</td>
            <td class="kepala">Brand</td>
            <td class="kepala">Chanel Description</td>
            <td class="kepala">Currency</td>
            <td class="kepala">Payment Term</td>
            <td class="kepala">Final Destination</td>
            <td class="kepala">Country of origin</td>
        </tr>
        <tr>
            <td class="sel tengah"><?= $esc($ambil($k, 'dest_purchase')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'style_no')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'brand')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'chanel_description')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'currency')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'payment_term')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'final_destination')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'country_origin')); ?></td>
        </tr>
        <tr>
            <td class="kepala">Ship Mode</td>
            <td class="kepala">Term of Sale</td>
            <td class="kepala">Transfer Point</td>
            <td class="kepala">Port Of Loading</td>
            <td class="kepala">Total Gross Weight(KGS)</td>
            <td class="kepala">Total Net Weight(KGS)</td>
            <td class="kepala">Total Net Net Weight(KGS)</td>
            <td class="kepala">Total Carton</td>
        </tr>
        <tr>
            <td class="sel tengah"><?= $esc($ambil($k, 'ship_mode')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'term_of_sale')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'transfer_point')); ?></td>
            <td class="sel tengah"><?= $esc($ambil($k, 'port_of_loading')); ?></td>
            <td class="sel angka"><?= $esc($berat($ambil($k, 'total_gross_weight', 0))); ?></td>
            <td class="sel angka"><?= $esc($berat($ambil($k, 'total_net_weight', 0))); ?></td>
            <td class="sel angka"><?= $esc($berat($ambil($k, 'total_net_net_weight', 0))); ?></td>
            <td class="sel angka"><?= $esc($bulat($ambil($k, 'total_carton', 0))); ?></td>
        </tr>
        <tr>
            <td class="kepala">Product Description</td>
            <td class="sel" colspan="7"><?= $esc($ambil($k, 'product_description')); ?></td>
        </tr>
        <tr><td colspan="<?= $kolom; ?>">&nbsp;</td></tr>
    <?php endforeach; ?>

    <!-- ===== Invoice Summary ===== -->
    <tr><td colspan="<?= $kolom; ?>" class="judul-blok">Invoice Summary</td></tr>
    <tr>
        <td class="kepala">Color Code</td>
        <td class="kepala" colspan="2">Color Name</td>
        <?php if ($ada_set) : ?>
            <td class="kepala">Total Pieces (SET)</td>
        <?php endif; ?>
        <td class="kepala"<?= $ada_set ? '' : ' colspan="2"'; ?>>Quantity Invoiced (Each)</td>
        <td class="kepala">Unit Cost</td>
        <td class="kepala" colspan="2">Extended Line Total</td>
    </tr>
    <?php foreach ($summary as $r) : ?>
        <tr>
            <td class="sel"><?= $esc($r['color_code']); ?></td>
            <td class="sel" colspan="2"><?= $esc($r['color_name']); ?></td>
            <?php if ($ada_set) : ?>
                <td class="sel angka"><?= $r['satuan'] === 'SET' && $r['total_pieces'] ? $esc($bulat($r['total_pieces'])) : ''; ?></td>
            <?php endif; ?>
            <td class="sel angka"<?= $ada_set ? '' : ' colspan="2"'; ?>><?= $esc($bulat($r['qty'])); ?></td>
            <td class="sel angka"><?= $esc($unit($r['unit_cost'])); ?></td>
            <td class="sel tengah"><?= $esc($simbol); ?></td>
            <td class="sel angka"><?= $esc($uang($r['extended'])); ?></td>
        </tr>
    <?php endforeach; ?>

    <!-- Rekap: menyambung tabel Invoice Summary, tanpa kepala kolom lagi. -->
    <?php foreach ($rekap_baris as $r) : ?>
        <tr>
            <td class="sel <?= $r[3] ? 'tebal' : ''; ?>" colspan="3"><?= $esc($r[0]); ?></td>
            <?php if ($ada_set) : ?>
                <td class="sel"></td>
            <?php endif; ?>
            <td class="sel angka <?= $r[3] ? 'tebal' : ''; ?>"<?= $ada_set ? '' : ' colspan="2"'; ?>><?= $r[1] === null ? '' : $esc($bulat($r[1])); ?></td>
            <td class="sel"></td>
            <td class="sel tengah <?= $r[3] ? 'tebal' : ''; ?>"><?= $r[2] === null ? '' : $esc($simbol); ?></td>
            <td class="sel angka <?= $r[3] ? 'tebal' : ''; ?>"><?= $r[2] === null ? '' : $esc($uang($r[2])); ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td class="sel grand" colspan="<?= $ada_set ? 5 : 5; ?>">Net Invoice Total</td>
        <td class="sel grand"></td>
        <td class="sel grand tengah"><?= $esc($simbol); ?></td>
        <td class="sel grand angka"><?= $esc($uang($angka_rekap('grand'))); ?></td>
    </tr>
    <tr><td colspan="<?= $kolom; ?>">&nbsp;</td></tr>

    <!-- ===== Penutup: kiri Notes + Manufacturer + REFF, kanan pernyataan & stempel ===== -->
    <tr>
        <td colspan="4" class="judul-blok">Invoice Notes</td>
        <td colspan="4"><?= $esc('I hereby certify that all information provided is true and correct.'); ?></td>
    </tr>
    <tr>
        <td colspan="4"><?= nl2br($esc($ambil($inv, 'invoice_notes'))); ?></td>
        <td colspan="4" class="tebal"><?= $sudah_approve ? 'ELECTRONICALLY ISSUED &#8211; APPROVED' : ''; ?></td>
    </tr>
    <tr>
        <td colspan="4" class="judul-blok">Manufacturer Information</td>
        <td colspan="4" class="catatan"><?= $sudah_approve
            ? 'This document was electronically issued through the authorized system of PT Nirwana Alabare Garment. No manual signature is required.'
            : ''; ?></td>
    </tr>
    <tr>
        <td colspan="4" class="tebal"><?= $esc($ambil($inv, 'manufacturer_nama')); ?></td>
        <td colspan="4"></td>
    </tr>
    <?php foreach ($alamat_pabrik as $b) : ?>
        <tr><td colspan="4" class="alamat"><?= $rapikan_alamat($b); ?></td><td colspan="4"></td></tr>
    <?php endforeach; ?>
    <?php if (trim((string) $ambil($inv, 'reference')) !== '') : ?>
        <tr>
            <td class="tebal">REFF</td>
            <td colspan="3"><?= $esc($ambil($inv, 'reference')); ?></td>
            <td colspan="4"></td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
