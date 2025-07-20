<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=11">
	<title>Pdf Reverse</title>
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
		REVERSE <?= $reverse_header['type_doc']; ?> <br />
		<?= $reverse_header['rvs_number']; ?>
	</div>
	<br />
	<table style="width:100%;font-size:11px;">
		<tr>
			<td class="position_top" colspan="8">
				&nbsp;
			</td>
			<td class="position_top">

			</td>
			<td class="position_top">

			</td>
			<td colspan="3" class="position_top">

			</td>
		</tr>

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
		<td>
			Date
		</td>
		<td>
			:
		</td>
		<td colspan="3">
			<?= $reverse_header['rvs_date']; ?>
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
			To
		</td>
		<td>
			:
		</td>
		<td colspan="3">
			<?= $reverse_header['deskripsi']; ?>
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

</table>

<br />

<table style="width:100%;font-size:11px;" border="1">
	<tr align="center">
		<th>
			Document Number
		</th>
		<th>
			Document Date
		</th>
		<th>
			Customer
		</th>
		<th>
			Curr
		</th>
		<th style="width: 80px">
			Total
		</th>
		<th style="width: 130px">
			Description
		</th>
	</tr>

	<?php
	$my_tot_unit = 0;
	foreach ($reverse_detail as $data_det) : ?>
		<tr>
			<td><?= $data_det['doc_number']; ?></td>
			<td><?= $data_det['doc_date']; ?></td>
			<td><?= $data_det['customer']; ?></td>
			<td align='center' style="width: 35px"><?= $data_det['curr']; ?></td>
			<td align='right'><?= $data_det['total']; ?></td>
			<td align='left'><?= $data_det['deskripsi']; ?></td>
		</tr>
	<?php endforeach; ?>

</table>

<br />

<table style="font-size:11px;" border="0">
	<tr>
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
</table>

<br />
<br />
<br />
<br />
<br />
<br />

<!-- <div style="margin-bottom: 2.54cm;"> -->
	<div style="margin-bottom: 2.54cm; display: flex; justify-content: center; page-break-inside: avoid;">
    <table style="page-break-inside: avoid;" cellpadding="0" cellspacing="0" border="1" width="70%">
			<tr>
				<th style="font-size: 12px; width: 40%">Created By :</th>
				<th style="font-size: 12px; width: 40%">Approved By :</th>
			</tr>
			<tr><td class="td1">&nbsp;</td><td class="td1">&nbsp;</td></tr>
			<tr><td class="td1">&nbsp;</td><td class="td1">&nbsp;</td></tr>
			<tr><td class="td1">&nbsp;</td><td class="td1">&nbsp;</td></tr>
			<tr style="border-bottom: none;"><td class="td1">&nbsp;</td><td class="td1">&nbsp;</td></tr>
			<tr style="border-collapse: collapse; border-top: none;">
				<td style="font-size:12px;text-align:center;text-decoration:underline">
					(<?= $reverse_header['created_by']; ?>)
				</td>
				<td style="font-size:12px;text-align:center;text-decoration:underline">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td style="text-align:center;font-size:12px">AR Staff</td>
				<td style="text-align:center;font-size:12px">Finance Manager</td>
			</tr>
		</table>
	</div>


</div>