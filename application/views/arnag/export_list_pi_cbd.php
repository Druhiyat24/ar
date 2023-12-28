<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=list_pi_dp&cbd.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Proforma Invoice DP & CBD</title>
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
        LIST PROFORMA INVOICE DP AND CBD
        <br />
        Period : <?= $periode_dari; ?> To <?= $periode_sampai; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th>
                No Prof Inv
            </th>
            <th>
                Date
            </th>
            <th>
                Customer
            </th>
            <th>
                Shipp
            </th>
            <th>
                Peb
            </th>
            <th>
                Type
            </th>
            <th>
                Status
            </th>
            <th>
                Faktur Pajak
            </th>
            <th>
                Amount
            </th>
        </tr>

        <?php foreach ($data_list_pi as $data_pi) : ?>
            <tr>
                <td align="center">
                    <?= $data_pi['no_pi']; ?>
                </td>
                <td align="center">
                    <?= $data_pi['date_pi']; ?>
                </td>
                <td align="center">
                    <?= $data_pi['customer']; ?>
                </td>
                <td align="center">
                    <?= $data_pi['shipp']; ?>
                </td>
                <td align="center">
                    <?= $data_pi['peb']; ?>
                </td>
                <td align="center">
                    <?= $data_pi['type']; ?>
                </td>
                <td align="center">
                    <?= $data_pi['status']; ?>
                </td>
                <td align="center">
                    <?= $data_pi['no_faktur_pajak']; ?>
                </td>
                <td align="center">
                    <?= $data_pi['amount']; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>