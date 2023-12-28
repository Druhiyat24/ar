<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report_out_pi.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Report</title>
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
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header_title">
        REPORT OUTSTANDING PI
        <br />
        Period : <?= $periode_dari_pi; ?> To <?= $periode_sampai_pi; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th>
                Customer
            </th>
            <th>
                No PI
            </th>
            <th>
                Date
            </th>
            <th>
                Shipp
            </th>
            <th>
                Material Type
            </th>
            <th>
                TOP
            </th>
            <th>
                DueDate
            </th>
            <th>
                Currency
            </th>
            <th>
                Amount
            </th>
        </tr>

        <?php foreach ($report_outstanding_pi as $out_pi) : ?>
            <tr>
                <td align="center">
                    <?= $out_pi['customer']; ?>
                </td>
                <td align="center">
                    <?= $out_pi['no_proforma_invoice']; ?>
                </td>
                <td align="center">
                    <?= $out_pi['tgl_proforma_inv']; ?>
                </td>
                <td align="center">
                    <?= $out_pi['shipp']; ?>
                </td>
                <td align="center">
                    <?= $out_pi['type_barang']; ?>
                </td>
                <td align="center">
                    <?= $out_pi['top']; ?>
                </td>
                <td align="center">
                    <?= $out_pi['duedate']; ?>
                </td>
                <td align="center">
                    <?= $out_pi['curr']; ?>
                </td>
                <td align="right">
                    <?= $out_pi['total_price']; ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <!-- <tr>
            <td colspan='3'></td>
            <td align='right'><?= $tot_unit_pi['qty']; ?></td>
            <td colspan="10"></td>
        </tr> -->

    </table>