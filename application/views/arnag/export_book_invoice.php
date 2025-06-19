<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=book_invoice.xls");
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
        BOOK INVOICE
        <br />
        Period : <?= $periode_dari_book; ?> To <?= $periode_sampai_book; ?>
      <!--   <br />
        Status : <?= $status_book; ?>
 -->    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th>
                Inv Number
            </th>
            <th>
                Customer
            </th>
            <th>
                Shipp
            </th>
            <th>
                Book Date
            </th>
            <th>
                Type
            </th>
            <th>
                Status
            </th>
            <th>
                Doc Type
            </th>
            <th>
                Doc Number
            </th>
            <th>
                Value
            </th>
        </tr>

        <?php foreach ($data_book_invoice as $dli) : ?>
            <tr>
                <td align="center">
                    <?= $dli['no_invoice']; ?>
                </td>
                <td align="center">
                    <?= $dli['customer']; ?>
                </td>
                <td align="center">
                    <?= $dli['shipp']; ?>
                </td>
                <td align="center">
                    <?= $dli['tanggal']; ?>
                </td>
                <td align="center">
                    <?= $dli['type']; ?>
                </td>
                <td align="center">
                    <?= $dli['status']; ?>
                </td>
                <td align="center">
                    <?= $dli['doc_type']; ?>
                </td>
                <td align="center">
                    <?= $dli['doc_number']; ?>
                </td>
                <td align="right">
                    <?= $dli['value']; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>