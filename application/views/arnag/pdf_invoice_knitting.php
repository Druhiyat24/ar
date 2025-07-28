<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=11">
	<title>Invoice Knitting</title>
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
				<td>
					<img src="nag_logo3.jpg" width="15%">
				</td>
				<td class="title">
					PT.NIRWANA ALABARE GARMENT
					<div style="font-size:12px;line-height:9">
						Jl. Raya Rancaekek – Majalaya No. 289 Desa Solokan Jeruk Kecamatan Solokan Jeruk, <br />Kabupaten Bandung 40382 <br />Telp. 022-85962081
					</div>
				</td>
			</tr>
		</table>
		&nbsp;
		<div class="horizontal">

		</div>
	</div>

	<table style="font-size:10px;" border="0">
		<tr>
			<td><b>TO:</b></td>
		</tr>
		<tr>
			<td><?= ucwords(strtolower($data_konsumen['supplier'])) ?></td>
		</tr>
		<tr>

			<td style="white-space: pre-line;">
				<?= nl2br(preg_replace('/\. ?/', ".\n", ucwords(strtolower($data_konsumen['alamat'])))) ?>
			</td>
			<!--  -->
			<!-- <td>JL.ASIA AFRIKA NO.122-124, PALEDANG,KEC.LENGKONG,KOTA BANDUNG,JAWA
			BARAT 40261</td> -->
		</tr>
	</table>

	<div class="header_title" style="margin-bottom: 5px;">
		<?= $data_invoice['no_invoice']; ?>
	</div>
	
	<table style="width:100%;font-size:10px;" border="1">
		<tr align="center">
			<th style="width: 13%">
				Invoice Date
			</th>
			<th style="width: 25%">
				Product Item
			</th>
			<th style="width: 15%">
				Style/Color
			</th>
			<th style="width: 15%">
				PO
			</th>
			<th style="width: 12%">
				Qty (<?= $group_curr['uom']; ?>)
			</th>
			<th style="width: 10%">
				Price (<?= $group_curr['curr']; ?>)
			</th>
			<th style="width: 10%">
				Total (<?= $group_curr['curr']; ?>)
			</th>
		</tr>

		<?php
		$my_tot_unit = 0;
		foreach ($data_invoice_detail as $inv_det) : ?>
			<?= $my_tot_unit +=  $inv_det["qty"]; ?>
			<?= $mata_uang = $inv_det['curr']; ?>
			<tr>
				<td><?= $data_invoice['tgl_inv']; ?></td>
				<td><?= $inv_det['product_item']; ?></td>
				<td><?= $inv_det['color']; ?></td>
				<td><?= $inv_det['po_konsumen']; ?></td>
				<td align='right'><?= $inv_det['qty']; ?></td>
				<td align='right' style="width: 100px"><?= $inv_det['unit_price']; ?></td>
				<td align='right'><?= $inv_det['total_price']; ?></td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td style="text-align: center" colspan='6'><b>Grand Total</b></td>
			<td align='right'><b><?= $data_invoice_pot['grand_total']; ?></b></td>
		</tr>

	</table>

	<br />

	<table style="font-size:10px;" border="0">
		<tr>
			<td>Shipping On Behalf Of</td>
		</tr>
		<tr>
			<td><b>PT Nirwana Alabare Garment</b></td>
		</tr>
		<tr>
			<td>Payment Terms : <b>Within <?= $data_invoice['top']; ?> days of Invoice date</b></td>
		</tr>
		<tr>
			<td>Name Of The Bank : <b><?= ucwords(strtolower($data_invoice['nama_bank'])) ?></b></td>
		</tr>
		<tr>
			<td>Bank Account Number : <b><?= $data_invoice['no_rek']; ?></b></td>
		</tr>
		<tr>
			<td>SWIFT Code : <b><?= $data_invoice['v_swiftcode']; ?></b></td>
		</tr>
		<tr>
			<td>Bank Account Currency : <b><?= $data_invoice['curr']; ?></b></td>
		</tr>
	</table>

	<br />

	<div style="margin-bottom: 2.54cm; page-break-inside: avoid;">
		<table style="page-break-inside: avoid;" cellpadding="0" cellspacing="0" border="0" width="600px">
			<tr>
				<th style="font-size: 11px; width: 25%;"></th>
				<th style="font-size: 11px; width: 25%;"></th>
				<th style="font-size: 11px; width: 25%;"></th>
				<th style="font-size: 11px; width: 25%;">Approved By, </th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp; </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp; </td>
			</tr>
			<tr style="border-collapse: collapse; border-top: none;">
				<td style="font-size:12px;text-align:center;text-decoration:underline"></td>
				<td style="font-size:12px;text-align:center;text-decoration:underline"></td>
				<td style="font-size:12px;text-align:center;text-decoration:underline"></td>
				<td style="font-size:12px;text-align:center;text-decoration:underline"><u><?= "Willy Fernandez" ?></u></td>
			</tr>
			<tr>
				<td style="text-align:center;font-size:12px"></td>
				<td style="text-align:center;font-size:12px"></td>
				<td style="text-align:center;font-size:12px"></td>
				<td style="text-align:center;font-size:12px">Finance Manager</td>
			</tr>
		</table>

</div>