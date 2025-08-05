<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Aging Piutang Dagang.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aging Report</title>
    <style>
        /* @page {
			margin-top: 1.54cm;
			margin-bottom: 1.54cm;
			margin-left: 3.175cm;
			margin-right: 3.175cm;
		} */

        table {
            margin: auto;
        }

        td,
        th {
            padding: 1px;
            text-align: left
        }

        h1 {
            text-align: center
        }

        th {
            text-align: center;
            padding: 10px;
        }

        .footer {
            width: 100%;
            height: 30px;
            margin-top: 50px;
            text-align: right;
        }

        /*
CSS HEADER
*/
        .header {
            width: 100%;
            height: 20px;
            padding-top: 0;
            margin-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: left;
            margin-top: -90px;
        }


        .horizontal {
            height: 0;
            width: 100%;
            border: 1px solid #000000;
        }

        .position_top {
            vertical-align: top;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .td1 {
            border: 1px solid black;
            border-top: none;
            border-bottom: none;
        }

        .header_title {
            width: 100%;
            height: auto;
            text-align: left;
            font-weight: bold;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="header_title">
        PT. NIRWANA ALABARE GARMENT
        <br>
        AGING PIUTANG DAGANG - BULANAN
        <br />
        <?php
        $bulan = [
            '01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET',
            '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI',
            '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER',
            '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'
        ];

        $tgl = explode('-', $periode_dari);
        $bulanTahun = $bulan[$tgl[1]] . ' ' . $tgl[0];
        ?>
        PER : <?= $bulanTahun; ?>
    </div>
    <br />
    <table style="width:100%;font-size:13px;" border="1">
        <tr>
            <th style="text-align: center;" rowspan="2">No</th>
            <th style="text-align: center;" colspan="3">Konsumen</th>
            <th style="text-align: center;" rowspan="2">Top</th>
            <th style="text-align: center;" rowspan="2">Total</th>
            <th style="text-align: center;" rowspan="2">M - > 6</th>
            <th style="text-align: center;" rowspan="2">M - 5</th>
            <th style="text-align: center;" rowspan="2">M - 4</th>
            <th style="text-align: center;" rowspan="2">M - 3</th>
            <th style="text-align: center;" rowspan="2">M - 2</th>
            <th style="text-align: center;" rowspan="2">M - 1</th>
            <th style="text-align: center;" rowspan="2">Bulan Berjalan</th>
            <th style="text-align: center;" rowspan="2">AR Days</th>
            <th style="text-align: center;border: none;" rowspan="2"></th>
            <th style="text-align: center;" colspan="4">Jatuh Tempo Piutang</th>
        </tr>
        <tr>
            <th style="text-align: center;">Coa</th>
            <th style="text-align: center;">Id</th>
            <th style="text-align: center;">Nama</th>
            <th style="text-align: center;">1 - 30 H</th>
            <th style="text-align: center;">31 - 60 H</th>
            <th style="text-align: center;">61 - 90 H</th>
            <th style="text-align: center;">> 90 H</th>
        </tr>

        <?php 
        $no = 1;

        $total_all = $bln6 = $bln5 = $bln4 = $bln3 = $bln2 = $bln1 = $readydue = $jatem1 = $jatem31 = $jatem61 = $jatem91 = 0;

        foreach ($aging_jatem as $sr) :
        // Akumulasi nilai total
            $total_all += $sr['total'];
            $bln6 += $sr['hasil_bln6'];
            $bln5 += $sr['hasil_bln5'];
            $bln4 += $sr['hasil_bln4'];
            $bln3 += $sr['hasil_bln3'];
            $bln2 += $sr['hasil_bln2'];
            $bln1 += $sr['hasil_bln1'];
            $readydue += $sr['readydue'];
            $jatem1 += $sr['jatem1'];
            $jatem31 += $sr['jatem31'];
            $jatem61 += $sr['jatem61'];
            $jatem91 += $sr['jatem91'];
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td style="width:75px;"><?= $sr['kode_customer']; ?></td>
                <td style="width:50px;"><?= $sr['id_customer_show']; ?></td>
                <td style="width:250px;"><?= $sr['customer']; ?></td>
                <td style="text-align:right;width:50px;"><?= $sr['top']; ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['total'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['hasil_bln6'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['hasil_bln5'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['hasil_bln4'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['hasil_bln3'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['hasil_bln2'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['hasil_bln1'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['readydue'],2); ?></td>
                <td style="width:70px;"><?= $sr['ar_day']; ?></td>
                <td style="width: 10px; border: none;"></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['jatem1'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['jatem31'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['jatem61'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['jatem91'],2); ?></td>
            </tr>
        <?php endforeach; ?>

        <tr style="border: 2px double #000;font-weight: bold; background-color: #f2f2f2;">
            <td colspan="5" style="text-align:center;">TOTAL</td>
            <td style="text-align:right;"><?= number_format($total_all,2); ?></td>
            <td style="text-align:right;"><?= number_format($bln6,2); ?></td>
            <td style="text-align:right;"><?= number_format($bln5,2); ?></td>
            <td style="text-align:right;"><?= number_format($bln4,2); ?></td>
            <td style="text-align:right;"><?= number_format($bln3,2); ?></td>
            <td style="text-align:right;"><?= number_format($bln2,2); ?></td>
            <td style="text-align:right;"><?= number_format($bln1,2); ?></td>
            <td style="text-align:right;"><?= number_format($readydue,2); ?></td>
            <td></td>
            <td style="width: 10px; border: none;"></td>
            <td style="text-align:right;"><?= number_format($jatem1,2); ?></td>
            <td style="text-align:right;"><?= number_format($jatem31,2); ?></td>
            <td style="text-align:right;"><?= number_format($jatem61,2); ?></td>
            <td style="text-align:right;"><?= number_format($jatem91,2); ?></td>
        </tr>

    </table>