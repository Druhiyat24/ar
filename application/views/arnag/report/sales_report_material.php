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
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <table width="100%">
            <tr>
                <td style="width: 70px">
                    <img src="<?= base_url('vendors/Invoice_Template/nag_logo2.png'); ?>" width="5%">
                </td>
                <td class="title">
                    SALES REPORT / MATERIAL
                    <div style="font-size:13px;line-height:9">
                        Period : <?= $periode_dari_mt; ?> To <?= $periode_sampai_mt; ?>
                    </div>
                </td>
            </tr>
        </table>
        &nbsp;
        <div class="horizontal">
        </div>
    </div>

    <table style="width:100%;font-size:9px;" border="1">
        <tr align="center">
            <th>
                Customer
            </th>
            <th>
                Invoice
            </th>
            <th>
                Invoice Date
            </th>
            <th>
                Shipp Number
            </th>
            <th>
                Shipp Date
            </th>
            <th>
                Group
            </th>
            <th>
                WS
            </th>
            <th>
                Style
            </th>
            <th>
                Product Item
            </th>
            <th>
                Qty
            </th>
            <th>
                Uom
            </th>
            <th>
                Unit Price
            </th>
            <th>
                Shipp
            </th>
            <th>
                Inv Type
            </th>
            <th>
                Order Type
            </th>
            <th>
                Currency
            </th>
            <th>
                Rate
            </th>
            <th>
                Original Value
            </th>
            <th>
                Equiv Value
            </th>
            <th>
                Total
            </th>
        </tr>

        <?php foreach ($sales_report_material as $srm) : ?>
            <tr>
                <td align="center">
                    <?= $srm['customer']; ?>
                </td>
                <td align="center">
                    <?= $srm['no_invoice']; ?>
                </td>
                <td align="center">
                    <?= $srm['tgl_inv']; ?>
                </td>
                <td align="center">
                    <?= $srm['bppb_number']; ?>
                </td>
                <td align="center">
                    <?= $srm['sj_date']; ?>
                </td>
                <td align="center">

                </td>
                <td align="center">
                    <?= $srm['material']; ?>
                </td>
                <td align="center">
                    <?= $srm['styleno']; ?>
                </td>
                <td align="center">
                    <?= $srm['produk']; ?>
                </td>
                <td align="right">
                    <?= $srm['qty']; ?>
                </td>
                <td align="center">
                    <?= $srm['uom']; ?>
                </td>
                <td align="right">
                    <?= $srm['unit_price']; ?>
                </td>
                <td align="center">
                    <?= $srm['type_']; ?>
                </td>
                <td align="center">
                    <?= $srm['inv_type']; ?>
                </td>
                <td align="center">

                </td>
                <td align="center">
                    <?= $srm['curr']; ?>
                </td>
                <td align="right">

                </td>
                <td align="right">
                    <?= $srm['total_price']; ?>
                </td>
                <td align="right">

                </td>
                <td align="right">

                </td>
            </tr>

        <?php endforeach; ?>

        <!-- <tr>
            <td colspan='3'></td>
            <td align='right'><?= $tot_unit_material['qty']; ?></td>
            <td colspan="10"></td>
        </tr> -->

    </table>