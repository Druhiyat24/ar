<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=11">
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

	<div class="header_title">
		ALOKASI <br />
		<?= $data_alokasi['no_alk']; ?>
	</div>
	<br />
	<table style="width:100%;font-size:10px;" >
		<tr>
			<td class="position_top" colspan="8">
				&nbsp;
			</td>
			<td class="position_top">

			</td>
			<td class="position_top">

			</td>
			<td colspan="3" class="position_top" style="width: 60%;">

			</td>
		</tr>

		<!-- <tr>
			<td class="position_top" colspan="8">
				&nbsp;
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
			<td class="position_top" style="text-align:right">
				Date
			</td>
			<td class="position_top">
				:
			</td>
			<td colspan="3" class="position_top" style="text-align:right">
					</td>
		</tr> -->

		<tr>
			<td class="position_top">

			</td>

			<td class="position_top">

			</td>

			<td class="position_top">

			</td>

			<td class="position_top">

			</td>

			<td class="position_top">

			</td>

			<td colspan="3" class="position_top">

			</td>

			<td class="position_top">

			</td>

			<td class="position_top">

			</td>

			<td colspan="3" class="position_top">

			</td>
		</tr>

		<tr>
			<td style="width: 20%">
				Alokasi Date
			</td>
			<td>
				:
			</td>
			<td colspan="3">
				<?= $data_alokasi['tgl_alk']; ?>
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
			<td>
				Customer
			</td>
			<td>
				:
			</td>
			<td colspan="3">
				<?= $data_alokasi['supplier']; ?>
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

		<!-- <tr>
			<td>
				Address
			</td>
			<td class="position_top">
				:
			</td>
			<td class="position_top" colspan="3">
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
		</tr> -->

		<!-- <tr>
			<td>
				Telp.
			</td>
			<td>
				:
			</td>
			<td colspan="3">			</td>
			<td>
			</td>
			<td>
			</td>
			<td colspan="7">
			</td>
		</tr> -->

		<tr>
			<td>
				Document Number
			</td>
			<td>
				:
			</td>
			<td colspan="3">
				<?= $data_alokasi['doc_number']; ?>
			</td>
			<td>
			</td>
			<td>
			</td>
			<td colspan="7">
			</td>
		</tr>

		<tr>
			<td>
				Bank
			</td>
			<td>
				:
			</td>

			<td>
				<?= $data_alokasi['bank']; ?>
			</td>
		</tr>

		<tr>
			<td>
				Account
			</td>
			<td>
				:
			</td>
			<td>
				<?= $data_alokasi['account']; ?>
			</td>
		</tr>
	</table>

	<br />

	

	<table style="width:100%;font-size:10px;" border="1">
		<tr align="center">
			<th>COA</th>
			<th>Cost Center</th>
			<th>Ref Number</th>
			<th>Ref Date</th>
			<th>Due Date</th>
			<th>Total</th>
			<th>Amount</th>
			<th>Outstanding</th>
		</tr>

		<?php
		$my_tot = 0;
		$my_tot1 = 0;
		foreach ($data_alokasi_detail as $alok_det) : ?>
			<!-- <?= $my_tot +=  $alok_det['total']; ?>
			<?= $my_tot1 +=  $alok_det['eqp_idr']; ?> -->
		?>
			<tr>
				<td style="width: 15%; text-align: center;"><?= $alok_det['coa_name']; ?></td>
				<td style="width: 15%; text-align: center;"><?= $alok_det['cost_name']; ?></td>
				<td style="width: 14%; text-align: center;"><?= $alok_det['no_ref']; ?></td>
				<td style="width: 8%; text-align: center;"><?= $alok_det['ref_date']; ?></td>
				<td style="width: 8%; text-align: center;"><?= $alok_det['due_date']; ?></td>
				<td style="width: 8%; text-align: right;"><?= $alok_det['curr']; ?> <?= $alok_det['total']; ?></td>
				<td style="width: 8%; text-align: right;"><?= $alok_det['curr']; ?> <?= $alok_det['amount']; ?></td>
				<td style="width: 8%; text-align: right;"><?= $alok_det['ost']; ?></td>
			</tr>
		<?php endforeach; ?>



		<tr>
			<td colspan='7'></td>
			<td align='right'><?= $my_tot; ?></td>
		</tr>

		<tr>
			<td colspan='7'>Total Amount</td>
			<td align='right'><?= $my_tot; ?></td>
		</tr>

		<tr>
			<td colspan='7'>Rate</td>
			<td align='right'><?= $alok_det['rate']; ?></td>
		</tr>

		<tr>
			<td colspan='7'>Equivalent IDR</td>
			<td align='right'><?= $my_tot1; ?></td>
		</tr>

	</table>

	<br />

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
				<td>ALOKASI NUMBER : <?= $data_alokasi['no_alk']; ?></td>
			</tr>
			<tr>
				<td>GRAND TOTAL : <?= $alok_det['curr']; ?> <?= $my_tot; ?></td>
			</tr>
		</table>

	</div>