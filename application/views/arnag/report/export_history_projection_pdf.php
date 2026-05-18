<?php
$start    = new DateTime($header['periode_dari']);
$end      = new DateTime($header['periode_sampai']);
$end->modify('+1 day');
$interval = new DateInterval('P1D');
$period   = new DatePeriod($start, $interval, $end);

// Semua tanggal dalam range
$all_dates = [];
foreach ($period as $dt) {
    $all_dates[] = $dt->format('Y-m-d');
}

// Hanya tampilkan tanggal yang benar-benar ada data di detail
$dates_with_data = [];
foreach ($all_dates as $dt) {
    foreach ($detail as $r) {
        if ($r['duedate_update'] === $dt) {
            $dates_with_data[] = $dt;
            break;
        }
    }
}

$total_days = count($all_dates);
$show_dates = $dates_with_data; // kolom yang ditampilkan (sparse)
?>
<style>
    body  { font-family: Arial; font-size: 7.5pt; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 0.5pt solid #888; padding: 2px 4px; }
    th { text-align: center; font-weight: bold; }
    .bg-header { background-color: #FFE4C4; }
    .bg-proj   { background-color: #90EE90; }
    .text-center { text-align: center; }
    .text-right  { text-align: right; }
    .report-title { font-size: 11pt; font-weight: bold; margin-bottom: 2px; }
    .report-sub   { font-size: 7.5pt; margin-bottom: 1px; }
    .note         { font-size: 7pt; color: #666; margin-bottom: 4px; }
</style>

<p class="report-title">PROJECTION REPORT — HISTORY</p>
<p class="report-sub">Doc Number &nbsp;: <?= $header['doc_number']; ?></p>
<p class="report-sub">Period &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= date('d M Y', strtotime($header['periode_dari'])); ?> s/d <?= date('d M Y', strtotime($header['periode_sampai'])); ?></p>
<!-- <p class="report-sub">Saved By &nbsp;&nbsp;&nbsp;: <?= $header['created_by']; ?> &nbsp;|&nbsp; <?= $header['created_at']; ?></p>
 -->
<?php if ($total_days > count($show_dates)): ?>
<p class="note">
    * Menampilkan <?= count($show_dates); ?> dari <?= $total_days; ?> hari dalam periode
    (hanya tanggal yang memiliki data duedate update).
</p>
<?php endif; ?>

<br>

<table>
    <thead>
        <tr>
            <th class="bg-header" rowspan="2" style="width:18pt;">No</th>
            <th class="bg-header" rowspan="2" style="width:90pt;">Customer</th>
            <th class="bg-header" rowspan="2" style="width:70pt;">Reff Number</th>
            <th class="bg-header" rowspan="2" style="width:42pt;">Reff Date</th>
            <th class="bg-header" rowspan="2" style="width:35pt;">Category</th>
            <th class="bg-header" rowspan="2" style="width:42pt;">Due Date</th>
            <th class="bg-header" rowspan="2" style="width:45pt;">Due Date Update</th>
            <th class="bg-header" rowspan="2" style="width:20pt;">TOP</th>
            <th class="bg-header" rowspan="2" style="width:20pt;">Curr</th>
            <th class="bg-header" rowspan="2" style="width:55pt;">Amount</th>
            <th class="bg-header" rowspan="2" style="width:40pt;">Rate</th>
            <th class="bg-header" rowspan="2" style="width:60pt;">Amount IDR</th>
            <?php if (!empty($show_dates)): ?>
            <th class="bg-proj" colspan="<?= count($show_dates); ?>">Duedate Projection</th>
            <?php endif; ?>
        </tr>
        <tr>
            <?php foreach ($show_dates as $dt): ?>
            <th class="bg-proj" style="width:52pt;"><?= date('d M Y', strtotime($dt)); ?></th>
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
            <td class="text-right"><?= number_format((float)$r['amount'], 2); ?></td>
            <td class="text-right"><?= number_format((float)$r['rate'], 2); ?></td>
            <td class="text-right"><?= number_format((float)$r['amount_idr'], 2); ?></td>

            <?php foreach ($show_dates as $dt):
                $val = ($r['duedate_update'] === $dt) ? (float)$r['amount_idr'] : 0;
            ?>
            <td class="text-right"><?= $val != 0 ? number_format($val, 2) : ''; ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>

    <tfoot>
        <tr>
            <td class="bg-header text-center" colspan="11" style="font-weight:bold;">TOTAL</td>
            <td class="bg-header text-right" style="font-weight:bold;"><?= number_format($grand_total, 2); ?></td>
            <?php foreach ($show_dates as $dt):
                $sub = 0;
                foreach ($detail as $r) {
                    if ($r['duedate_update'] === $dt) $sub += (float)$r['amount_idr'];
                }
            ?>
            <td class="bg-proj text-right" style="font-weight:bold;"><?= $sub != 0 ? number_format($sub, 2) : ''; ?></td>
            <?php endforeach; ?>
        </tr>
    </tfoot>
</table>
