<?php
// Unduhan Sub Ledger - Uang Muka Penjualan.
//
// Isinya dari Model_nag::subledger_uang_muka() - sumber yang sama dengan
// layarnya, jadi angka di layar dan di berkas ini tidak mungkin berbeda.
//
// TAMPILANNYA mengikuti lembar kerja tim AR: keterangan akun di pojok kiri
// atas, kepala kolom & baris jumlah berwarna krem, isinya putih, dan nol
// ditulis "-" supaya mata tidak tenggelam di angka nol.
//
// DUA HAL YANG MEMBUATNYA TERBACA BENAR DI EXCEL
//
//   1. Tiap sel angka membawa x:num berisi angkanya TANPA pemisah ribuan.
//      Tanpa itu Excel membaca teks "1,234.56" menurut setelan Windows-nya -
//      di Indonesia koma adalah pemisah desimal - jadi angkanya masuk sebagai
//      teks: tidak bisa dijumlah, tidak bisa diurutkan.
//   2. Sel teks diberi format "@" supaya nomor dokumen dan tanggalnya tidak
//      ditafsirkan jadi tanggal atau pecahan (0003/D/E/NAG/0926).
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=subledger-uang-muka-penjualan-' . date('Ymd') . '.xls');

// Keterangan filternya boleh tidak dikirim - berkasnya tetap terbentuk.
$f_coa      = isset($filter_coa) ? (array) $filter_coa : array();
$f_customer = isset($filter_customer) ? trim((string) $filter_customer) : '';

$kolom_angka = array('beginning', 'beginning_idr', 'addition', 'addition_idr',
                     'deduction_invoice', 'deduction_invoice_idr',
                     'deduction_gm', 'deduction_gm_idr', 'ending', 'ending_idr',
                     'aging_1_30', 'aging_31_60', 'aging_61_90', 'aging_91_120',
                     'aging_121_180', 'aging_181_360', 'aging_lebih_360');

/* ---------------------------- selnya ---------------------------- */

// Satu sel angka. Nol ditulis "-" seperti lembar kerjanya - sebagai TEKS,
// bukan nol berformat: format bertingkat belum tentu terbaca semua program,
// sedangkan tampilannya harus sama di Excel maupun di LibreOffice. Angka yang
// bukan nol tetap angka sungguhan, jadi tetap bisa dijumlah di Excel.
$sel_angka = function ($v, $kelas = '') {
    $n = round((float) $v, 2);
    $k = trim('angka ' . $kelas);
    if ($n == 0) {
        return '<td class="' . $k . ' nol">-</td>';
    }
    return '<td class="' . $k . '" x:num="' . number_format($n, 2, '.', '') . '">'
         . number_format($n, 2, '.', ',') . '</td>';
};

$sel_teks = function ($v, $kelas = '') {
    $v = trim((string) $v);
    return '<td class="' . trim('teks ' . $kelas) . '">'
         . htmlspecialchars($v === '' ? '-' : $v) . '</td>';
};

/* --------------------------- jumlahnya -------------------------- */

// Per mata uang (baris TOTAL) dan per profit center (ringkasan di bawahnya) -
// dua-duanya dihitung dari baris yang sama, jadi tidak mungkin berbeda.
$kosong = array_fill_keys($kolom_angka, 0);
$total  = array();
$per_pc = array();
$pc_ada = array();
foreach ($baris as $b) {
    $curr = trim((string) $b['curr']) === '' ? 'IDR' : trim((string) $b['curr']);
    $pc   = trim((string) $b['profit_center']);
    if ($pc === '') { $pc = '-'; }
    $kunci = $pc . '|' . $curr;
    $pc_ada[$pc] = TRUE;

    if (!isset($total[$curr])) { $total[$curr] = $kosong; }
    if (!isset($per_pc[$kunci])) {
        $per_pc[$kunci] = array_merge($kosong, array('pc' => $pc, 'curr' => $curr));
    }
    foreach ($kolom_angka as $k) {
        $total[$curr][$k]   += (float) $b[$k];
        $per_pc[$kunci][$k] += (float) $b[$k];
    }
}
ksort($per_pc);

// Satu baris jumlah - bentuknya sama persis dengan baris datanya supaya
// angkanya jatuh tepat di bawah kolomnya.
$baris_jumlah = function ($label, $curr, $t, $kelas) use ($sel_angka, $kolom_angka) {
    $s = '<tr class="' . $kelas . '">';
    $s .= '<td class="teks label-jumlah">' . htmlspecialchars($label) . '</td>';
    $s .= str_repeat('<td></td>', 10);
    $s .= '<td class="teks tengah">' . htmlspecialchars($curr) . '</td>';
    $s .= $sel_angka($t['beginning']) . $sel_angka($t['beginning_idr']);
    $s .= $sel_angka($t['addition']) . $sel_angka($t['addition_idr']);
    $s .= '<td></td>' . $sel_angka($t['deduction_invoice']) . $sel_angka($t['deduction_invoice_idr']);
    $s .= '<td></td>' . $sel_angka($t['deduction_gm']) . $sel_angka($t['deduction_gm_idr']);
    $s .= $sel_angka($t['ending']) . $sel_angka($t['ending_idr']);
    foreach (array_slice($kolom_angka, 10) as $k) { $s .= $sel_angka($t[$k]); }
    return $s . '</tr>';
};

/* ------------------ keterangan di kepala berkas ----------------- */

$tgl_panjang = function ($v) {
    $v = trim((string) $v);
    $t = $v === '' ? FALSE : strtotime($v);
    return $t === FALSE ? $v : date('j F Y', $t);
};
$periode = ($periode_dari === '' && $periode_sampai === '')
    ? 'All history'
    : (($periode_dari === '' ? 'Beginning' : $tgl_panjang($periode_dari)) . ' to '
        . ($periode_sampai === '' ? 'Today' : $tgl_panjang($periode_sampai)));

$akun_no   = isset($f_coa['no_coa']) && trim((string) $f_coa['no_coa']) !== ''
    ? trim((string) $f_coa['no_coa']) : 'All';
$akun_nama = isset($f_coa['nama_coa']) && trim((string) $f_coa['nama_coa']) !== ''
    ? trim((string) $f_coa['nama_coa']) : 'All advance accounts';
$cust      = $f_customer === '' ? 'All' : $f_customer;
?>
<!DOCTYPE html>
<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <meta charset="UTF-8">
    <title>SUB LEDGER - UANG MUKA PENJUALAN</title>
    <!-- Hanya dibaca Excel: nama lembarnya & kepala tabel yang ikut
         tertahan waktu digulung ke bawah. Program lain mengabaikannya. -->
    <!--[if gte mso 9]><xml>
     <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
      <x:Name>Uang Muka Penjualan</x:Name>
      <x:WorksheetOptions>
       <x:FreezePanes/>
       <x:FrozenNoSplit/>
       <x:SplitHorizontalPosition>8</x:SplitHorizontalPosition>
       <x:TopRowBottomPane>8</x:TopRowBottomPane>
       <x:ActivePane>2</x:ActivePane>
       <x:Selected/>
      </x:WorksheetOptions>
     </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook>
    </xml><![endif]-->
    <style>
        /* Warna & bentuknya mengikuti lembar kerja tim AR: krem untuk kepala
           kolom dan baris jumlah, isinya putih, garisnya hitam tipis seperti
           tabel Excel pada umumnya.

           .5pt itu tebal yang ditulis Excel sendiri untuk garis tipis - sama
           dengan hasil menekan All Borders. "1px" sama dengan 0.75pt, jatuh di
           antara tipis dan sedang, dan Excel membulatkannya ke SEDANG. */
        table { width: 100%; border-collapse: collapse;
                font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
        td, th { border: .5pt solid #000000; mso-border-alt: solid #000000 .5pt;
                 padding: 3px 6px; vertical-align: middle; white-space: nowrap; }
        th { background: #ffffcc; color: #000000; font-weight: bold;
             text-align: center; }
        th.kiri { text-align: left; }
        /* Nama kelompok kolom (Beginning Balance dst). Selnya TIDAK digabung -
           sel gabungan membuat kolomnya tidak bisa disaring & diurutkan di
           Excel - jadi namanya ditulis di sel pertama kelompoknya, rata kiri,
           dan meluber ke sel kosong di sebelahnya. */
        th.grup, th.grup-isi {
            text-align: left;
            /* Garis antar sel DI DALAM satu kelompok dihapus supaya judulnya
               terbaca menyatu - kelihatan seperti sel yang digabung, padahal
               selnya tetap terpisah. mso-border-alt dimatikan dulu sebagai
               satu kesatuan, baru sisi yang masih perlu dipasang lagi:
               "border: none" saja tidak mematikannya. */
            border: none; mso-border-alt: none;
            border-top: .5pt solid #000000;    mso-border-top-alt: solid #000000 .5pt;
            border-bottom: .5pt solid #000000; mso-border-bottom-alt: solid #000000 .5pt;
        }
        /* Garis kiri cuma di sel pertama tiap kelompok - itulah yang
           memisahkan satu kelompok dari kelompok sebelahnya. */
        th.grup { border-left: .5pt solid #000000; mso-border-left-alt: solid #000000 .5pt; }
        /* Sel paling kanan menutup tepi tabelnya. */
        th.grup-akhir { border-right: .5pt solid #000000; mso-border-right-alt: solid #000000 .5pt; }
        /* Keterangan akun di pojok kiri atas - tanpa garis, seperti contohnya. */
        .info { width: auto; }
        .info td { border: none; mso-border-alt: none; padding: 1px 4px; }
        .info .pt { font-weight: bold; }
        .info .label { font-weight: bold; white-space: nowrap; }
        .angka { text-align: right; mso-number-format: "\#\,\#\#0\.00"; }
        .teks { mso-number-format: "\@"; }
        .nol { mso-number-format: "\@"; }
        .tengah { text-align: center; }
        /* Baris jumlah & judul blok - krem & tebal, sama seperti contohnya. */
        .total td, .judul-blok td { background: #ffffcc; font-weight: bold; }
        .label-jumlah { white-space: nowrap; }
        .kosong td { border: none; mso-border-alt: none; }
    </style>
</head>
<body>
    <!-- Keterangan akunnya. Ditulis per sel, BUKAN sel gabungan: sel gabungan
         membuat kolom di bawahnya tidak bisa disaring & diurutkan di Excel. -->
    <table class="info">
        <tr><td class="pt" colspan="2">PT. NIRWANA ALABARE GARMENT</td></tr>
        <tr><td class="label">Account No.</td><td>: <?= htmlspecialchars($akun_no); ?></td></tr>
        <tr><td class="label">Account Name</td><td>: <?= htmlspecialchars($akun_nama); ?></td></tr>
        <tr><td class="label">Customer</td><td>: <?= htmlspecialchars($cust); ?></td></tr>
        <tr><td class="label">Period</td><td>: <?= htmlspecialchars($periode); ?></td></tr>
    </table>

    <!-- width ditulis dua kali: Excel menurut pada atributnya, browser
         pada CSS-nya.

         TIDAK ADA SEL GABUNGAN di kepala tabelnya - baik mendatar (nama
         kelompok) maupun menurun. Begitu ada sel gabungan, Excel menolak
         menyaring & mengurutkan kolom di bawahnya. Nama kelompoknya ditulis
         di sel pertama kelompoknya dan meluber ke kanan.

         Lebar kolom angkanya dilonggarkan: angka rupiah sembilan digit
         (294,692,514.45) harus muat tanpa berubah jadi ###. -->
    <table width="100%">
        <tr>
            <th class="kiri" style="width:95px">Coa Number</th>
            <th class="kiri" style="width:230px">Coa Name</th>
            <th style="width:190px">Profit Center</th>
            <th class="kiri" style="width:150px">PI No</th>
            <th style="width:85px">PI Date</th>
            <th class="kiri" style="width:160px">BM No</th>
            <th style="width:85px">BM Date</th>
            <th class="kiri" style="width:150px">Allocation No</th>
            <th style="width:95px">Allocation Date</th>
            <th class="kiri" style="width:230px">Customer Name</th>
            <th class="kiri" style="width:230px">Payer</th>
            <th class="grup">Beginning Balance</th>
            <th class="grup-isi"></th>
            <th class="grup-isi"></th>
            <th class="grup">Addition</th>
            <th class="grup-isi"></th>
            <th class="grup">Deduction - Invoice</th>
            <th class="grup-isi"></th>
            <th class="grup-isi"></th>
            <th class="grup">Deduction - Memorial</th>
            <th class="grup-isi"></th>
            <th class="grup-isi"></th>
            <th class="grup">Ending Balance</th>
            <th class="grup-isi"></th>
            <th class="grup">Aging</th>
            <th class="grup-isi"></th>
            <th class="grup-isi"></th>
            <th class="grup-isi"></th>
            <th class="grup-isi"></th>
            <th class="grup-isi"></th>
            <th class="grup-isi grup-akhir"></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="width:70px">Currency</th>
            <th style="width:135px">Amount</th>
            <th style="width:160px">Eqv IDR</th>
            <th style="width:135px">Amount</th>
            <th style="width:160px">Eqv IDR</th>
            <th class="kiri" style="width:150px">Doc No</th>
            <th style="width:135px">Amount</th>
            <th style="width:160px">Eqv IDR</th>
            <th class="kiri" style="width:150px">Doc No</th>
            <th style="width:135px">Amount</th>
            <th style="width:160px">Eqv IDR</th>
            <th style="width:135px">Amount</th>
            <th style="width:160px">Eqv IDR</th>
            <th style="width:135px">1-30</th>
            <th style="width:135px">31-60</th>
            <th style="width:135px">61-90</th>
            <th style="width:135px">91-120</th>
            <th style="width:135px">121-180</th>
            <th style="width:135px">181-360</th>
            <th style="width:135px">&gt; 360</th>
        </tr>
        <?php foreach ($baris as $b) : ?>
        <tr>
            <?= $sel_teks($b['no_coa']); ?>
            <?= $sel_teks($b['nama_coa']); ?>
            <?= $sel_teks($b['profit_center'], 'tengah'); ?>
            <?= $sel_teks($b['no_pi']); ?>
            <?= $sel_teks($b['tgl_pi'], 'tengah'); ?>
            <?= $sel_teks($b['no_bm']); ?>
            <?= $sel_teks($b['tgl_bm'], 'tengah'); ?>
            <?= $sel_teks($b['no_alokasi']); ?>
            <?= $sel_teks($b['tgl_alokasi'], 'tengah'); ?>
            <?= $sel_teks($b['customer']); ?>
            <?= $sel_teks($b['payer']); ?>
            <?= $sel_teks($b['curr'], 'tengah'); ?>
            <?= $sel_angka($b['beginning']); ?>
            <?= $sel_angka($b['beginning_idr']); ?>
            <?= $sel_angka($b['addition']); ?>
            <?= $sel_angka($b['addition_idr']); ?>
            <?= $sel_teks($b['doc_deduction']); ?>
            <?= $sel_angka($b['deduction_invoice']); ?>
            <?= $sel_angka($b['deduction_invoice_idr']); ?>
            <?= $sel_teks($b['doc_deduction_gm']); ?>
            <?= $sel_angka($b['deduction_gm']); ?>
            <?= $sel_angka($b['deduction_gm_idr']); ?>
            <?= $sel_angka($b['ending']); ?>
            <?= $sel_angka($b['ending_idr']); ?>
            <?= $sel_angka($b['aging_1_30']); ?>
            <?= $sel_angka($b['aging_31_60']); ?>
            <?= $sel_angka($b['aging_61_90']); ?>
            <?= $sel_angka($b['aging_91_120']); ?>
            <?= $sel_angka($b['aging_121_180']); ?>
            <?= $sel_angka($b['aging_181_360']); ?>
            <?= $sel_angka($b['aging_lebih_360']); ?>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($baris)) : ?>
        <tr><td colspan="31">No data for this filter.</td></tr>
        <?php endif; ?>
        <?php foreach ($total as $curr => $t) : ?>
        <?= $baris_jumlah('TOTAL ' . $curr, $curr, $t, 'total'); ?>
        <?php endforeach; ?>

        <?php if (count($pc_ada) > 1) : ?>
        <!-- Ringkasan per profit center - bagian yang sama ada di lembar kerja
             tim AR. Ditulis di TABEL YANG SAMA supaya angkanya lurus di bawah
             kolomnya; tabel tersendiri punya lebar kolomnya sendiri. Tidak
             ditulis kalau profit centernya cuma satu: barisnya akan sama
             persis dengan baris TOTAL-nya, cuma mengulang. -->
        <tr class="kosong"><td colspan="31">&nbsp;</td></tr>
        <tr class="judul-blok"><td colspan="31">SUMMARY PROFIT CENTER</td></tr>
        <?php foreach ($per_pc as $t) : ?>
        <?= $baris_jumlah($t['pc'], $t['curr'], $t, 'rincian-pc'); ?>
        <?php endforeach; ?>
        <?php foreach ($total as $curr => $t) : ?>
        <?= $baris_jumlah('TOTAL ' . $curr, $curr, $t, 'total'); ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>
