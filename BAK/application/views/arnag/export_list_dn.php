<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=list debitnote.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Debitnote</title>
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
        LIST DEBITNOTE
        <br />
        Period : <?= $periode_dari; ?> To <?= $periode_sampai; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th>
                No Debitnote
            </th>
            <th>
                Date
            </th>
            <th>
                Type Debitnote
            </th>
            <th>
                Attn
            </th>
            <th>
                Consignee
            </th>
            <th>
                Supplier
            </th>
            <th>
                Suppllier Invoice
            </th>
            <th>
                From Curr
            </th>
            <th>
                To Curr
            </th>
            <th>
                Value
            </th>
            <th>
                Rate
            </th>
            <th>
                Equivalent Curr
            </th>
            <th>
                Description
            </th>
            <th>
                Status
            </th>
        </tr>

        <?php foreach ($data_list_dn as $data_dn) : ?>
            <tr>
                <td align="center">
                    <?= $data_dn['no_dn']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['tgl_dn']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['type_dn']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['attn']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['consignee']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['supplier']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['supplier_invoice']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['from_curr']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['to_curr']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['amount']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['rate']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['eqv_idr']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['deskripsi']; ?>
                </td>
                <td align="center">
                    <?= $data_dn['status']; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>