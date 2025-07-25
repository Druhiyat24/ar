<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=list_invoice.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Data</title>
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
        MASTER OTHER CHARGE
    </div>
    <br />
    <table style="width:60%;font-size:10px;" border="1">
        <tr align="center">
            <th style="width: 10%">
                ID
            </th>
            <th style="width: 35%">
                Nama Kategori
            </th>
            <th style="width: 15%">
                Status
            </th>
        </tr>

        <?php foreach ($data_other_charge as $data) : ?>
            <tr>
                <td align="center">
                    <?= $data['id']; ?>
                </td>
                <td align="center">
                    <?= $data['nama_pilihan']; ?>
                </td>
                <td align="center">
                    <?= $data['status_show']; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>