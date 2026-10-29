<?php
// Unduhan laporan Report Proforma Invoice.
// Isinya dari Model_nag::mutasi_pi_dpcbd() - sumber yang sama dengan layarnya,
// jadi angka di layar dan di berkas ini tidak mungkin berbeda.
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=report-proforma-invoice.xls');

$angka = function ($v) {
    return number_format((float) $v, 2, '.', ',');
};

// Jumlah per mata uang - sama seperti baris total di layarnya.
$total = array();
foreach ($baris as $b) {
    $curr = $b['curr'] === '' ? 'IDR' : $b['curr'];
    if (!isset($total[$curr])) {
        $total[$curr] = array('beginning' => 0, 'addition' => 0, 'deduction' => 0, 'ending' => 0);
    }
    foreach (array('beginning', 'addition', 'deduction', 'ending') as $k) {
        $total[$curr][$k] += (float) $b[$k];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>REPORT PROFORMA INVOICE</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
        th, td { border: 1px solid #94a3b8; padding: 4px 7px; }
        th { background: #1e3a5f; color: #fff; text-align: center; }
        .angka { mso-number-format: "\#\,\#\#0\.00"; text-align: right; }
        .judul { font-size: 14pt; font-weight: bold; border: none; }
        .periode { border: none; }
        .total td { font-weight: bold; background: #eef2f7; }
    </style>
</head>
<body>
    <!-- width ditulis dua kali: Excel menurut pada atributnya, browser
         pada CSS-nya. -->
    <table width="100%">
        <tr><td class="judul" colspan="10">REPORT PROFORMA INVOICE</td></tr>
        <tr><td class="periode" colspan="10">Periode <?= htmlspecialchars($periode_dari); ?> s/d <?= htmlspecialchars($periode_sampai); ?></td></tr>
        <tr><td class="periode" colspan="10"></td></tr>
        <tr>
            <th>No Invoice</th>
            <th>Invoice Date</th>
            <th>Type Document</th>
            <th>Customer</th>
            <th>Billed To</th>
            <th>Curr</th>
            <th>Beginning Balance</th>
            <th>Addition</th>
            <th>Deduction</th>
            <th>Ending Balance</th>
        </tr>
        <?php foreach ($baris as $b) : ?>
        <tr>
            <td><?= htmlspecialchars($b['no_invoice']); ?></td>
            <td><?= htmlspecialchars($b['inv_date']); ?></td>
            <td><?= htmlspecialchars($b['type_pi']); ?></td>
            <td><?= htmlspecialchars($b['customer']); ?></td>
            <td><?= htmlspecialchars($b['billed_to']); ?></td>
            <td><?= htmlspecialchars($b['curr']); ?></td>
            <td class="angka"><?= $angka($b['beginning']); ?></td>
            <td class="angka"><?= $angka($b['addition']); ?></td>
            <td class="angka"><?= $angka($b['deduction']); ?></td>
            <td class="angka"><?= $angka($b['ending']); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($baris)) : ?>
        <tr><td colspan="10">No data for this period.</td></tr>
        <?php endif; ?>
        <?php foreach ($total as $curr => $t) : ?>
        <tr class="total">
            <td colspan="5">TOTAL</td>
            <td><?= htmlspecialchars($curr); ?></td>
            <td class="angka"><?= $angka($t['beginning']); ?></td>
            <td class="angka"><?= $angka($t['addition']); ?></td>
            <td class="angka"><?= $angka($t['deduction']); ?></td>
            <td class="angka"><?= $angka($t['ending']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
