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
			<td><?= ucwords(strtolower("TEEJAY MAURITIUS PRIVATE LIMITED")) ?></td>
		</tr>
		<tr>

			<td style="white-space: pre-line;">
				<?= nl2br(preg_replace('/\. ?/', ".\n", ucwords(strtolower("ROGERS CAPITAL CORPORATE. SERVICES LIMITED, 3RD FLOOR, ROGERS HOUSE. NO.5 PRESIDENT JOHN,
				KENNEDY STREET. PORT LOUIS, MAURITIUS")))) ?>
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
			<th>
				Invoice Date
			</th>
			<th>
				Product Item
			</th>
			<th>
				Style/Color
			</th>
			<th>
				PO
			</th>
			<th style="width: 100px">
				Qty
			</th>
			<th>
				Price
			</th>
			<th style="width: 100px">
				Total
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
				<td>-</td>
				<td align='right'><?= $inv_det['qty']; ?></td>
				<td align='right' style="width: 100px"><?= $inv_det['unit_price']; ?></td>
				<td align='right'><?= $inv_det['total_price']; ?></td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<th style="text-align: center" colspan='6'>Grand Total</th>
			<th align='right'><?= $mata_uang ?> <?= $data_invoice_pot['grand_total']; ?></th>
		</tr>

	</table>

	<br />

	<table style="font-size:10px;" border="0">
		<tr>
			<td style="text-align:right">Bank</td>
			<td>:</td>
			<td>No Rek : <?= $data_invoice['no_rek']; ?></td>
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
			<td><?= $data_invoice['nama_bank']; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?= $data_invoice['v_bankaddress']; ?></td>
			<!--  -->
			<!-- <td>JL.ASIA AFRIKA NO.122-124, PALEDANG,KEC.LENGKONG,KOTA BANDUNG,JAWA
			BARAT 40261</td> -->
		</tr>
	</table>

	<br />

</div>