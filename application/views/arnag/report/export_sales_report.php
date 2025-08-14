<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=sales_report.xls");
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
            font-size: 11pt;
        }
    </style>
</head>

<body>
    <div class="header_title">
        SALES REPORT
        <br />
        Period : <?= $periode_dari; ?> To <?= $periode_sampai; ?>
    </div>
    <br />
    <table style="width:100%;font-size:11pt;" border="1">
        <tr>
            <th style="background-color: #FFE4C4;" rowspan="2">No</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Customer</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Invoice</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Invoice Date</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Group</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Relationship</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Profit Center</th>
            <th style="background-color: #FFE4C4;" rowspan="2">TOP</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Order Type</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Shipp</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Inv Type</th>
            <th style="background-color: #FFE4C4;" rowspan="2">VAT Number</th>
            <th style="background-color: #FFE4C4;" rowspan="2">VAT Date</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Currency</th>
            <th style="background-color: #FFE4C4;" rowspan="2">Rate</th>
            <th style="background-color: #90EE90;" colspan="8">Billing Invoice (Original Currency)</th>
            <th style="background-color: #90EE90;" colspan="8">Billing Invoice (Equivalent IDR)</th>
            <th style="background-color: #87CEFA;" colspan="8">Shipping Invoice (Original Currency)</th>
            <th style="background-color: #87CEFA;" colspan="8">Shipping Invoice (Equivalent IDR)</th>
            <th style="width:50px;background-color: #FFFFFF;border-top:1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;" rowspan="2"></th>
            <th style="width:120px;background-color: #FFDAB9;" rowspan="2">Net Sales</th>
            <th style="width:120px;background-color: #FFDAB9;" rowspan="2">VAT</th>
            <th style="width:120px;background-color: #FFDAB9;" rowspan="2">Total</th>
        </tr>
        <tr>
            <th style="width:120px;background-color: #90EE90;">Qty</th>
            <th style="width:120px;background-color: #90EE90;">Gross Sales</th>
            <th style="width:120px;background-color: #90EE90;">Others Sales</th>
            <th style="width:120px;background-color: #90EE90;">Discount</th>
            <th style="width:120px;background-color: #90EE90;">Down Payment</th>
            <th style="width:120px;background-color: #90EE90;">Net Sales</th>
            <th style="width:120px;background-color: #90EE90;">VAT</th>
            <th style="width:120px;background-color: #90EE90;">Total</th>

            <th style="width:120px;background-color: #90EE90;">Qty</th>
            <th style="width:120px;background-color: #90EE90;">Gross Sales</th>
            <th style="width:120px;background-color: #90EE90;">Others Sales</th>
            <th style="width:120px;background-color: #90EE90;">Discount</th>
            <th style="width:120px;background-color: #90EE90;">Down Payment</th>
            <th style="width:120px;background-color: #90EE90;">Net Sales</th>
            <th style="width:120px;background-color: #90EE90;">VAT</th>
            <th style="width:120px;background-color: #90EE90;">Total</th>

            <th style="width:120px;background-color: #87CEFA;">Qty</th>
            <th style="width:120px;background-color: #87CEFA;">Gross Sales</th>
            <th style="width:120px;background-color: #87CEFA;">Others Sales</th>
            <th style="width:120px;background-color: #87CEFA;">Discount</th>
            <th style="width:120px;background-color: #87CEFA;">Down Payment</th>
            <th style="width:120px;background-color: #87CEFA;">Net Sales</th>
            <th style="width:120px;background-color: #87CEFA;">VAT</th>
            <th style="width:120px;background-color: #87CEFA;">Total</th>

            <th style="width:120px;background-color: #87CEFA;">Qty</th>
            <th style="width:120px;background-color: #87CEFA;">Gross Sales</th>
            <th style="width:120px;background-color: #87CEFA;">Others Sales</th>
            <th style="width:120px;background-color: #87CEFA;">Discount</th>
            <th style="width:120px;background-color: #87CEFA;">Down Payment</th>
            <th style="width:120px;background-color: #87CEFA;">Net Sales</th>
            <th style="width:120px;background-color: #87CEFA;">VAT</th>
            <th style="width:120px;background-color: #87CEFA;">Total</th>
        </tr>

        <?php $no = 1; foreach ($sales_report as $sr) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $sr['customer']; ?></td>
                <td><?= $sr['no_invoice']; ?></td>
                <td><?= $sr['tgl_inv']; ?></td>
                <td><?= $sr['relasi']; ?></td>
                <td><?= $sr['cus_ctg']; ?></td>
                <td><?= $sr['nama_pc']; ?></td>
                <td><?= $sr['top']; ?></td>
                <td><?= $sr['type_so']; ?></td>
                <td><?= $sr['shipp']; ?></td>
                <td><?= $sr['type']; ?></td>
                <td><?= $sr['no_faktur']; ?></td>
                <td><?= $sr['tgl_faktur']; ?></td>
                <td><?= $sr['curr']; ?></td>
                <td style="text-align:right"><?= number_format($sr['rate'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['qty_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['total_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['other_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['diskon_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['dp_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['twot_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['vat_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['grand_total_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['qty_bill'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['total_bill_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['other_bill_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['diskon_bill_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['dp_bill_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['twot_bill_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['vat_bill_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['grand_total_bill_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['qty_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['total_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['other_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['diskon_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['dp_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['twot_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['vat_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['grand_total_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['qty_ship'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['total_ship_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['other_ship_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['diskon_ship_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['dp_ship_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['twot_ship_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['vat_ship_idr'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['grand_total_ship_idr'],2); ?></td>
                <td style="width:50px;background-color:#FFFFFF;border-top:1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;"></td>
                <td style="text-align:right"><?= number_format($sr['net_sales'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['vat_sales'],2); ?></td>
                <td style="text-align:right"><?= number_format($sr['grand_total_sales'],2); ?></td>

            </tr>
        <?php endforeach; ?>

        <!-- <tr>
            <td colspan='10'></td>
            <td align='right'><?= $tot_unit['qty']; ?></td>
            <td colspan="5"></td>
        </tr> -->

    </table>