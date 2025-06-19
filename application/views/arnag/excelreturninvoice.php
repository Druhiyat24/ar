<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=return_invoice.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Invoice</title>
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
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            margin-top: -90px;
        }


        .horizontal {
            height: 0;
            width: 100%;
            border: 3px solid #000000;
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
        <?= $data_return_invoice['type_']; ?> INVOICE <br />
        <?= $data_return_invoice['no_return']; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;">
        <tr>
            <td style="width: 100px">
                Date
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_return_invoice['date_return']; ?>
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
        </tr>

        <tr>
            <td style="width: 100px">
                To
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_return_invoice['customer']; ?>
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
        </tr>

        <tr>
            <td style="width: 100px">
                Address
            </td>
            <td class="position_top">
                :
            </td>
            <td class="position_top" colspan="3">
                <?= $data_return_invoice['alamat']; ?>
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
            <td class="position_top" colspan="8">
                &nbsp;
            </td>
        </tr>

        <tr>
            <td style="width: 100px">
                Telp.
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_return_invoice['phone']; ?>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td colspan="7">
            </td>
        </tr>

        <tr>
            <td style="width: 100px">
                Nrp
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_return_invoice['nrp']; ?>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td colspan="7">
            </td>
        </tr>

        <tr>
            <td style="width: 100px">
                Shipp
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_return_invoice['shipp']; ?>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td colspan="7">
            </td>
        </tr>
    </table>

    <br />

    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th>
                BPB Number
            </th>
            <th>
                Currency
            </th>
            <th style="width: 100px">
                Quantity
            </th>
            <th>
                Unit Price
            </th>
            <th style="width: 100px">
                Total
            </th>
        </tr>

        <?php
        $qty = 0;
        foreach ($data_return_invoice_detail as $rtn_inv_det) : ?>
            <tr>
                <td align='center'><?= $rtn_inv_det['bpb_number']; ?></td>
                <td align='center'><?= $rtn_inv_det['curr']; ?></td>
                <td align='right'><?= $rtn_inv_det['qty']; ?></td>
                <td align='right'><?= $rtn_inv_det['price']; ?></td>
                <td align='right' style="width: 100px"><?= $rtn_inv_det['total_price']; ?></td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <td colspan="2">Total</td>
            <td align='right'><?= number_format($data_return_invoice_total['qty'], 2); ?></td>
            <td align='right'><?= number_format($data_return_invoice_total['price'], 2); ?></td>
            <td align='right'><?= number_format($data_return_invoice_total['total_price'], 2); ?></td>
        </tr>

    </table>

    <br />

    <table style="font-size:10px;" border="0">
        <tr>
            <td style="text-align:right">Bank</td>
            <td>:</td>
            <td>No Rek : <?= $data_return_invoice['no_rek']; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?= $data_return_invoice['nama_bank']; ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?= $data_return_invoice['v_bankaddress']; ?></td>
        </tr>
    </table>

    <br />
    <br />
    <br />
    <br />
    <br />
    <br />

    <!-- <div style="margin-bottom: 2.54cm;"> -->
    <div style="margin-bottom: 2.54cm; page-break-inside: avoid;">
        <table style="page-break-inside: avoid;" cellpadding="0" cellspacing="0" border="1" width="600px">
            <tr>
                <th style="font-size: 11px; width: 200px">Created By : </th>
                <th style="font-size: 11px; width: 200px">Checked By : </th>
                <th style="font-size: 11px; width: 200px">Approved By : </th>
            </tr>
            <tr>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp;</td>
            </tr>
            <tr>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp; </td>
            </tr>
            <tr>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp; </td>
            </tr>
            <tr>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp; </td>
            </tr>
            <tr style="border-bottom: none;">
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp;</td>
                <td class="td1">&nbsp; </td>
            </tr>
            <tr style="border-collapse: collapse; border-top: none;">
                <!-- <td style="font-size:12px;text-align:center;text-decoration:underline">(<?= $username ?>) </td>			
			         <td style="font-size:12px;text-align:center">(________________________) </td>
			         <td style="font-size:12px;text-align:center">(________________________) </td> -->
                <!--  -->
                <td style="font-size:12px;text-align:center;text-decoration:underline">(<?= "Oktora" ?>)</td>
                <td style="font-size:12px;text-align:center;text-decoration:underline">(<?= "Willy Fernandez" ?>)</td>
                <td style="font-size:12px;text-align:center;text-decoration:underline">(<?= "Syenni Santosa" ?>)</td>
            </tr>
            <tr>
                <td style="text-align:center;font-size:12px">AR Staff</td>
                <td style="text-align:center;font-size:12px">Finance Accounting Manager</td>
                <td style="text-align:center;font-size:12px">Director</td>
            </tr>
        </table>

        <br />

        <table style="page-break-inside: avoid; font-size:10px;" border="0">
            <tr>
                <td style="font-weight: bold">NOTE :</td>
            </tr>
            <tr>
                <td>INVOICE NUMBER : <?= $data_return_invoice['no_return']; ?></td>
            </tr>
            <tr>
                <td>GRAND TOTAL : <?= $data_return_invoice_total['curr']; ?> <?= number_format($data_return_invoice_total['total_price'], 2); ?></td>
            </tr>
        </table>

    </div>