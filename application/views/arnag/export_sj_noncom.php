<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=sj not yet.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Invoice</title>
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
        DATA SJ NOT YET INVOICE
        <br />
        Periode : <?= $periode_dari_book; ?> To <?= $periode_sampai_book; ?>
      <!--   <br />
        Status : <?= $status_book; ?>
 -->    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th>Customer</th>
            <th>No SO</th>
            <th>SO Date</th>
            <th>No SJ</th>
            <th>SJ Date</th>
            <th>No Inv</th>
            <th>Styleno</th>
            <th>Product Group</th>
            <th>Product Item</th>
            <th>Color</th>
            <th>Size</th>
            <th>Curr</th>
            <th>QTY</th>
            <th>UOM</th>
            <th>Price</th>
            <th>Total</th>
            <th>Total IDR</th>
            <th>QTY Shipment</th>
            <th>UOM Shipment</th>
            <th>Price Shipment</th>
            <th>Total Shipment</th>
            <th>Total IDR Shipment</th>
            <th>Status</th>
        </tr>

        <?php foreach ($data_sj_noncom as $dli) : ?>
            <tr>
                <td align="center">
                    <?= $dli['supplier']; ?>
                </td>
                <td align="center">
                    <?= $dli['no_so']; ?>
                </td>
                <td align="center">
                    <?= $dli['so_date']; ?>
                </td>
                <td align="center">
                    <?= $dli['shipping_number']; ?>
                </td>
                <td align="center">
                    <?= $dli['bppbdate']; ?>
                </td>
                <td align="center">
                    <?= $dli['invno']; ?>
                </td>
                <td align="center">
                    <?= $dli['styleno']; ?>
                </td>
                <td align="center">
                    <?= $dli['product_group']; ?>
                </td>
                <td align="center">
                    <?= $dli['product_item']; ?>
                </td>
                <td align="right">
                    <?= $dli['color']; ?>
                </td>
                <td align="center">
                    <?= $dli['size']; ?>
                </td>
                <td align="center">
                    <?= $dli['curr']; ?>
                </td>
                <td align="center">
                    <?= $dli['qty']; ?>
                </td>
                <td align="center">
                    <?= $dli['uom']; ?>
                </td>
                <td align="center">
                    <?= $dli['unit_price']; ?>
                </td>
                <td align="center">
                    <?= $dli['total']; ?>
                </td>
                <td align="right">
                    <?= $dli['total_price2']; ?>
                </td>
                <td align="center">
                    <?= $dli['qty_ship']; ?>
                </td>
                <td align="center">
                    <?= $dli['uom_ship']; ?>
                </td>
                <td align="center">
                    <?= $dli['unit_price_ship']; ?>
                </td>
                <td align="center">
                    <?= $dli['total_ship']; ?>
                </td>
                <td align="right">
                    <?= $dli['total_price2_ship']; ?>
                </td>
                <td align="center">
                    Not Yet
                </td>
            </tr>
        <?php endforeach; ?>

    </table>