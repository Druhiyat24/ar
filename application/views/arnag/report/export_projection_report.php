<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=projection_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

/*
|--------------------------------------------------------------------------
| GENERATE TANGGAL PROJECTION
|--------------------------------------------------------------------------
*/
$start = new DateTime($periode_dari_mt);
$end   = new DateTime($periode_sampai_mt);

$end->modify('+1 day');

$interval = new DateInterval('P1D');
$period   = new DatePeriod($start, $interval, $end);

$dates = [];

foreach ($period as $dt) {
    $dates[] = $dt->format("Y-m-d");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Projection Report</title>

    <style>
        table{
            border-collapse: collapse;
            width: 100%;
            font-family: Calibri;
            font-size: 11pt;
        }

        th, td{
            padding: 4px 8px;
            vertical-align: middle;
        }

        th{
            text-align: center;
            font-weight: bold;
        }

        .header-title{
            font-family: Calibri;
            font-size: 12pt;
            font-weight: bold;
        }

        .header-title-sub{
            font-family: Calibri;
            font-size: 11pt;
            font-weight: bold;
        }

        .text-center{ text-align: center; }
        .text-right { text-align: right;  }

        .bg-header{
            background-color: #FFE4C4;
        }

        .bg-projection{
            background-color: #90EE90;
        }

        .number{
            mso-number-format: '\#\,\#\#0\.00';
            text-align: right;
        }

        .date{
            text-align: center;
        }
    </style>
</head>

<body>

<div class="header-title">
    PROJECTION REPORT
</div>

<br>
<div class="header-title-sub">
    Period : <?= date('d M Y', strtotime($periode_dari_mt)); ?> To <?= date('d M Y', strtotime($periode_sampai_mt)); ?>
</div>

<table border="1">

    <thead>

        <tr>
            <th class="bg-header" rowspan="2">No</th>

            <th class="bg-header" rowspan="2" style="width: 300px;">
                Customer
            </th>

            <th class="bg-header" rowspan="2" style="width: 200px;">
                Invoice No
            </th>

            <th class="bg-header" rowspan="2">
                Invoice Date
            </th>

            <th class="bg-header" rowspan="2">
                Destination
            </th>

            <th class="bg-header" rowspan="2">
                Order Type
            </th>

            <th class="bg-header" rowspan="2">
                Due Date
            </th>

            <th class="bg-header" rowspan="2">
                Expected Collection Date
            </th>

            <th class="bg-header" rowspan="2">
                Payment Term
            </th>

            <th class="bg-header" rowspan="2">
                Currency
            </th>

            <th class="bg-header" rowspan="2" style="width: 130px;">
                Invoice Amount
            </th>

            <th class="bg-header" rowspan="2" style="width: 130px;">
                Rate
            </th>

            <th class="bg-header" colspan="5" style="width: 130px; text-align:left; vertical-align:top;">
                Receivable Amount
            </th>

            <th class="bg-projection"
                colspan="<?= count($dates); ?>">
                Projected Cash Inflow from Accounts Receivable
            </th>

            <!-- Diminta tim AR 5 Nov 2026. Urutannya disamakan dengan layar
                 Projection Report: dua kolom terakhir, sesudah kolom tanggal. -->
            <th class="bg-header" rowspan="2" style="width: 110px;">
                Type
            </th>

            <th class="bg-header" rowspan="2" style="width: 220px;">
                Bank &amp; Acc No
            </th>
        </tr>

        <tr>

            <th class="bg-header" style="width: 130px;">Tax Base</th>
            <th class="bg-header" style="width: 130px;">VAT</th>
            <th class="bg-header" style="width: 130px;">Total Invoice</th>
            <th class="bg-header" style="width: 130px;">Income Tax Art 23</th>
            <th class="bg-header" style="width: 130px;">Collection Amount</th>

            <?php foreach($dates as $dt): ?>

                <th class="bg-projection">
                    <?= date('d M Y', strtotime($dt)); ?>
                </th>

            <?php endforeach; ?>

        </tr>

    </thead>

    <tbody>

    <?php
    $no = 1;

    $grand_total = 0;

    foreach ($projection as $sr):

        $grand_total += (float)$sr['amount_idr'];
    ?>

        <tr>

            <td class="text-center">
                <?= $no++; ?>
            </td>

            <td>
                <?= $sr['customer']; ?>
            </td>

            <td>
                <?= $sr['no_invoice']; ?>
            </td>

            <td class="date">
                <?= date('d M Y', strtotime($sr['inv_date'])); ?>
            </td>

            <td>
                <?= $sr['shipp']; ?>
            </td>

            <td class="text-center">
                <?= $sr['type_so'] ?: '-'; ?>
            </td>

            <td class="date">
                <?= date('d M Y', strtotime($sr['duedate'])); ?>
            </td>

            <td class="date">

                <?php
                if($sr['duedate_update'] != '' &&
                   $sr['duedate_update'] != '0000-00-00'){
                    echo date(
                        'd M Y',
                        strtotime($sr['duedate_update'])
                    );
                }
                ?>

            </td>

            <td class="text-center">
                <?= $sr['top']; ?>
            </td>

            <td class="text-center">
                <?= $sr['curr']; ?>
            </td>

            <td class="number">
                <?= number_format((float)$sr['amount'], 2); ?>
            </td>

            <td class="number">
                <?= number_format((float)$sr['rate'], 2); ?>
            </td>

            <td class="number">
                <?= number_format((float)$sr['tax_base'], 2); ?>
            </td>

            <td class="number">
                <?= number_format((float)$sr['tax_vat'], 2); ?>
            </td>

            <td class="number">
                <?= number_format((float)$sr['total_invoice'], 2); ?>
            </td>

            <td class="number">
                <?= number_format((float)$sr['income_tax_23'], 2); ?>
            </td>

            <td class="number">
                <?= number_format((float)$sr['collection_amount'], 2); ?>
            </td>

            <?php foreach($dates as $key => $dt): ?>

                <?php
                $field = 'data' . ($key + 1);
                ?>

                <td class="number" style="width: 130px;">
                    <?php
                    $val = isset($sr[$field]) ? (float)$sr[$field] : 0;
                    echo $val != 0 ? number_format($val, 2) : 0;
                    ?>
                </td>

            <?php endforeach; ?>

            <td class="text-center">
                <?= $sr['doc_type'] ?: '-'; ?>
            </td>

            <td>
                <?= $sr['bank_acc'] ?: '-'; ?>
            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>

    <!-- Baris TOTAL. Dulu dimatikan dan susunannya pun sudah ketinggalan
         (colspan 11, lalu satu angka) - itu susunan sebelum kelompok
         Receivable Amount ada. Dihidupkan lagi dan ditulis ulang atas
         permintaan tim AR 5 Nov 2026, sama persis dengan baris TOTAL di
         layar Projection Report.

         Dua belas kolom keterangan di depan disatukan jadi label TOTAL -
         Invoice Amount & Rate sengaja TIDAK dijumlahkan: isinya campur mata
         uang asli (IDR dan USD), jadi jumlahnya tidak berarti apa pun.
         Yang dijumlahkan hanya kolom yang sudah dalam IDR. -->
    <tfoot>

        <tr>

            <td class="bg-header" colspan="12"
                style="text-align:center; font-weight:bold;">
                TOTAL
            </td>

            <?php
            $jml = array('tax_base' => 0, 'tax_vat' => 0, 'total_invoice' => 0,
                         'income_tax_23' => 0, 'collection_amount' => 0);
            foreach($projection as $row){
                foreach($jml as $k => $v){
                    $jml[$k] = $v + (isset($row[$k]) ? (float)$row[$k] : 0);
                }
            }
            ?>

            <?php foreach($jml as $v): ?>
                <td class="bg-header number" style="font-weight:bold;">
                    <?= number_format($v, 2); ?>
                </td>
            <?php endforeach; ?>

            <?php foreach($dates as $key => $dt): ?>

                <?php
                $field    = 'data' . ($key + 1);
                $subtotal = 0;
                foreach($projection as $row){
                    $subtotal += isset($row[$field]) ? (float)$row[$field] : 0;
                }
                ?>

                <td class="bg-projection number"
                    style="font-weight:bold;">
                    <?= number_format($subtotal, 2); ?>
                </td>

            <?php endforeach; ?>

            <!-- Type & Bank & Acc No tidak ada yang bisa dijumlahkan, tapi
                 selnya tetap ada supaya garis tabelnya tidak putus. -->
            <td class="bg-header"></td>
            <td class="bg-header"></td>

        </tr>

    </tfoot>

</table>

</body>
</html>