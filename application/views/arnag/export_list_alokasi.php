<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=list_alokasi.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Alokasi</title>
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
        LIST ALOKASI
        <br />
        Period : <?= $periode_dari; ?> To <?= $periode_sampai; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th>
                No Alokasi
            </th>
            <th>
                Alokasi Date
            </th>
            <th>
                Customer
            </th>
            <th>
                Document Number
            </th>
            <th>
                Bank
            </th>
            <th>
                Account
            </th>
            <th>
                Curr
            </th>
            <th>
               No Reference
            </th>            
            <th>
                Reference Date
            </th>
            <th>
                Total
            </th>
            <th>
                Rate
            </th>
            <th>
                Equivalent IDR
            </th>
            <th>
                Amount Alokasi
            </th>
            <th>
                Description
            </th>
            <th>
                Create Date
            </th>
            <th>
                Create By
            </th>
            <th>
                Status
            </th>
        </tr>

        <?php foreach ($data_list_alokasi as $dli) : ?>
            <tr>
                <td align="center">
                    <?= $dli['no_alk']; ?>
                </td>
                <td align="center">
                    <?= $dli['tgl_alk']; ?>
                </td>
                <td align="center">
                    <?= $dli['Supplier']; ?>
                </td>
                <td align="center">
                    <?= $dli['doc_number']; ?>
                </td>
                <td align="center">
                    <?= $dli['nama_bank']; ?>
                </td>
                <td align="center">
                    <?= $dli['no_rek']; ?>
                </td>
                <td align="center">
                    <?= $dli['curr']; ?>
                </td>                
                <td align="center">
                    <?= $dli['no_ref']; ?>
                </td>
                <td align="center">
                    <?= $dli['ref_date']; ?>
                </td>
                <td align="right">
                    <?= $dli['total']; ?>
                </td>
                <td align="right">
                    <?= $dli['rate']; ?>
                </td>
                <td align="right">
                    <?= $dli['eqp_idr']; ?>
                </td>
                <td align="right">
                    <?= $dli['amount']; ?>
                </td>
                <td align="center">
                    <?= $dli['keterangan']; ?>
                </td>
                <td align="center">
                    <?= $dli['tanggal_input']; ?>
                </td>
                <td align="center">
                    <?= $dli['nama']; ?>
                </td>
                <td align="center">
                    <?= $dli['status']; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>