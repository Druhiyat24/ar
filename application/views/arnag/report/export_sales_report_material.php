<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=sales_report_material.xls");
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
        SALES REPORT / MATERIAL
        <br />
        Period : <?= $periode_dari_mt; ?> To <?= $periode_sampai_mt; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center" style="text-align: center;">
            <th rowspan="2">Customer</th>
            <th rowspan="2">Invoice</th>
            <th rowspan="2">Invoice Date</th>
            <th rowspan="2">Shipp Number</th>
            <th rowspan="2">Shipp Date</th>
            <th rowspan="2">Group</th>
            <th rowspan="2">WS</th>
            <th rowspan="2">Style</th>
            <th rowspan="2">Product Item</th>
            <th colspan="2">Qty</th>
            <th colspan="2">Uom</th>
            <th colspan="2">Unit Price</th>
            <th rowspan="2">Shipp</th>
            <th rowspan="2">Inv Type</th>
            <th rowspan="2">Order Type</th>
            <th rowspan="2">Currency</th>
            <th rowspan="2">Rate</th>
            <th colspan="2">Original Value</th>
            <th colspan="2">Equiv Value</th>
            <th rowspan="2">No Faktur</th>
            <th rowspan="2">Tgl Faktur</th>
        </tr>
        <tr align="center" style="text-align: center;">
            <th>Billing</th>
            <th>Shipment</th>
            <th>Billing</th>
            <th>Shipment</th>
            <th>Billing</th>
            <th>Shipment</th>
            <th>Billing</th>
            <th>Shipment</th>
            <th>Billing</th>
            <th>Shipment</th>
        </tr>



        <?php foreach ($sales_report_material as $srm) : ?>
            <tr>
                <td align="center"><?= $srm['customer']; ?></td>
                <td align="center"><?= $srm['no_invoice']; ?></td>
                <td align="center"><?= $srm['tgl_inv']; ?></td>
                <td align="center"><?= $srm['bppb_number']; ?></td>
                <td align="center"><?= $srm['sj_date']; ?></td>
                <td align="center"></td>
                <td align="center"><?= $srm['material']; ?></td>
                <td align="center"><?= $srm['styleno']; ?></td>
                <td align="center"><?= $srm['produk']; ?></td>
                <td align="right"><?= $srm['qty']; ?></td>
                <td align="right"><?= $srm['qty_ship']; ?></td>
                <td align="center"><?= $srm['uom']; ?></td>
                <td align="center"><?= $srm['uom_ship']; ?></td>
                <td align="right"><?= $srm['unit_price']; ?></td>
                <td align="right"><?= $srm['unit_price_ship']; ?></td>
                <td align="center"><?= $srm['type_']; ?></td>
                <td align="center"><?= $srm['inv_type']; ?></td>
                <td align="center"><?= $srm['type_so']; ?></td>
                <td align="center"><?= $srm['curr']; ?></td>
                <td align="right"><?= $srm['rate']; ?></td>
                <td align="right"><?= $srm['total_price']; ?></td>
                <td align="right"><?= $srm['total_price_ship']; ?></td>
                <td align="right"><?= $srm['total2']; ?></td>
                <td align="right"><?= $srm['total2_ship']; ?></td>
                <td align="left"><?= $srm['no_faktur']; ?></td>
                <td align="center"><?= $srm['tgl_faktur']; ?></td>
            </tr>

        <?php endforeach; ?>

        <!-- <tr>
            <td colspan='3'></td>
            <td align='right'><?= $tot_unit_material['qty']; ?></td>
            <td colspan="10"></td>
        </tr> -->

    </table>