<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=projection_history_" . $header['doc_number'] . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Generate dates from periode_dari to periode_sampai
$start    = new DateTime($header['periode_dari']);
$end      = new DateTime($header['periode_sampai']);
$end->modify('+1 day');
$interval = new DateInterval('P1D');
$period   = new DatePeriod($start, $interval, $end);

$dates = [];
foreach ($period as $dt) {
    $dates[] = $dt->format('Y-m-d');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Projection History <?= $header['doc_number']; ?></title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial;
            font-size: 11pt;
        }
        th, td { padding: 4px 8px; }
        th { text-align: center; font-weight: bold; }
        .header-title { font-family: Arial; font-size: 12pt; font-weight: bold; }
        .header-sub   { font-family: Arial; font-size: 11pt; }
        .text-center  { text-align: center; }
        .number       { text-align: right; mso-number-format: '\#\,\#\#0\.00'; }
        .bg-header    { background-color: #FFE4C4; }
        .bg-proj      { background-color: #90EE90; }
    </style>
</head>
<body>

<div class="header-title">PROJECTION REPORT — HISTORY</div>
<div class="header-sub">Doc Number : <?= $header['doc_number']; ?></div>
<div class="header-sub">Period     : <?= date('d M Y', strtotime($header['periode_dari'])); ?> s/d <?= date('d M Y', strtotime($header['periode_sampai'])); ?></div>
<!-- <p class="header-sub">Saved By   : <?= $header['created_by']; ?> &nbsp;|&nbsp; <?= $header['created_at']; ?></p>
 -->
<table border="1">
    <thead>
        <tr>
            <th class="bg-header" rowspan="2">No</th>
            <th class="bg-header" rowspan="2" style="width:300px;">Customer</th>
            <th class="bg-header" rowspan="2" style="width:200px;">Reff Number</th>
            <th class="bg-header" rowspan="2">Reff Date</th>
            <th class="bg-header" rowspan="2">Category</th>
            <th class="bg-header" rowspan="2">Due Date</th>
            <th class="bg-header" rowspan="2">Due Date Update</th>
            <th class="bg-header" rowspan="2">TOP</th>
            <th class="bg-header" rowspan="2">Curr</th>
            <th class="bg-header" rowspan="2" style="width:130px;">Total</th>
            <th class="bg-header" rowspan="2" style="width:130px;">Rate</th>
            <th class="bg-header" rowspan="2" style="width:130px;">Total IDR</th>
            <th class="bg-proj" colspan="<?= count($dates); ?>">Duedate Projection</th>
        </tr>
        <tr>
            <?php foreach ($dates as $dt): ?>
            <th class="bg-proj" style="width:130px;"><?= date('d M Y', strtotime($dt)); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>

    <tbody>
    <?php
    $no          = 1;
    $grand_total = 0;

    foreach ($detail as $r):
        $grand_total += (float)$r['amount_idr'];
    ?>
        <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td><?= htmlspecialchars($r['customer']); ?></td>
            <td><?= htmlspecialchars($r['no_invoice']); ?></td>
            <td class="text-center"><?= $r['inv_date'] ? date('d M Y', strtotime($r['inv_date'])) : ''; ?></td>
            <td class="text-center"><?= htmlspecialchars($r['shipp']); ?></td>
            <td class="text-center"><?= $r['duedate'] ? date('d M Y', strtotime($r['duedate'])) : ''; ?></td>
            <td class="text-center">
                <?= (!empty($r['duedate_update']) && $r['duedate_update'] !== '0000-00-00')
                    ? date('d M Y', strtotime($r['duedate_update'])) : ''; ?>
            </td>
            <td class="text-center"><?= $r['top']; ?></td>
            <td class="text-center"><?= htmlspecialchars($r['curr']); ?></td>
            <td class="number"><?= number_format((float)$r['amount'], 2); ?></td>
            <td class="number"><?= number_format((float)$r['rate'], 2); ?></td>
            <td class="number"><?= number_format((float)$r['amount_idr'], 2); ?></td>

            <?php foreach ($dates as $dt):
                $val = ($r['duedate_update'] === $dt) ? (float)$r['amount_idr'] : 0;
            ?>
            <td class="number"><?= $val != 0 ? number_format($val, 2) : 0; ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>

   <!--  <tfoot>
        <tr>
            <td class="bg-header" colspan="11" style="text-align:center; font-weight:bold;">TOTAL</td>
            <td class="bg-header number" style="font-weight:bold;"><?= number_format($grand_total, 2); ?></td>
            <?php foreach ($dates as $dt):
                $sub = 0;
                foreach ($detail as $r) {
                    if ($r['duedate_update'] === $dt) $sub += (float)$r['amount_idr'];
                }
            ?>
            <td class="bg-proj number" style="font-weight:bold;"><?= $sub != 0 ? number_format($sub, 2) : 0; ?></td>
            <?php endforeach; ?>
        </tr>
    </tfoot> -->
</table>

</body>
</html>
