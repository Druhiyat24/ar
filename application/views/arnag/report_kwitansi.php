<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Report Kwitansi</title>
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

		.table {
			border-collapse: collapse;
			width: 40%;
			font-size: 12px;
		}

		.table1 {
			border-collapse: collapse;
			width: 100%;
			font-size: 12px;
		}

		.table2 {
			width: 100%;
			font-size: 12px;
			align-content : left;
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
			font-size: 18px;
		}

		.headertitle {
			width: 100%;
			height: auto;
			text-align: center;
			font-size: 12px;
		}

		.headertitle1 {
			width: 100%;
			height: auto;
			text-align: left;
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
		Receipt <br />
	</div>

	<div class="headertitle">
		<table class="table">
			<tr>
				<td>Document Number</td>
				<td>:</td>
				<td><?= $data_kwitansi['no_kwt']; ?></td>
			</tr>
			<br />
			<tr>
				<td>Document Date</td>
				<td>:</td>
				<td><?= $data_kwitansi['tgl_kwt']; ?></td>
			</tr>
		</table>
	</div>
	<br />
	<br />
		<table class="table1" width="100%">
			<tr>
				<td style=" vertical-align: top;width:20%" >Telah Diterima Dari</td>
				<td style=" vertical-align: top;width:1%">:</td>
				<td style=" vertical-align: top;"><?= $data_kwitansi['Supplier']; ?></td>
			</tr>
			<br />
			<br />
			<br />
			<tr>
				<td style=" vertical-align: top;">Uang Sejumlah</td>
				<td style=" vertical-align: top;">:</td>
				<td style=" vertical-align: top;"><?= $data_kwitansi['terbilang']; ?></td>
			</tr>
			<br />
			<br />
			<br />
			<tr>
				<td style=" vertical-align: top;">Untuk Pembayaran</td>
				<td style=" vertical-align: top;">:</td>
				<td style=" vertical-align: top;"><?php foreach ($data_kwitansi2 as $dk) : ?>
					<?= $dk['style']; ?><br />
				<?php endforeach; ?></td>
			</tr>
		</table>
		<br />
			<br />


		<table class="table1" width="100%" style="font-size: 14px">
			<tr>
				<td style="width: 5%;"></td>
				<td style="width: 5%;border: solid; text-align: center; border-right: none;">RP</td>
				<td style="width: 15%;border: solid; text-align: right; border-left: none;"><?= $data_kwitansi['total']; ?></td>
				<td style="width: 75%; border-top: none; border-right: none; border-bottom: none;"></td>
			</tr>
		</table>

			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
		<table  width="100%">
			<tr>
				<td style="width: 10%;"></td>
				<td style="width: 30%;border-top: none; border-right: none; border-bottom: none;"></td>
				<td style="width: 30%;border-top: none; border-right: none; border-bottom: none;"></td>
				<td style="width: 30%; border-top: none; border-right: none; border-bottom: solid;"></td>
			</tr>
			<tr>
				<td style="width: 10%;"></td>
				<td style="width: 30%;border-top: none; border-right: none; border-bottom: none;"></td>
				<td style="width: 30%;border-top: none; border-right: none; border-bottom: none;"></td>
				<td style="width: 30%;font-size: 11px; border-top: none; border-right: none; border-bottom: none; text-align: center;">PT. NIRWANA ALABARE GARMENT</td>
			</tr>
			<br />
			<br />
			<br />
			<tr>
				<td COLspan="4" style="width: 100%; border-top: none; border-right: none; border-bottom: solid;"></td>
			</tr>
			<tr>
				<td COLspan="4" style="width: 100%;font-size: 11px; border-top: none; border-right: none; border-bottom: none; text-align: center;">PT. NIRWANA ALABARE GARMENT - JL. RAYA MAJALAYA - RANCAEKEK NO.289, KABUPATEN BANDUNG</td>
			</tr>
		</table>


	<br />
	<br />
	<br />
	<br />
	<br />
	<br />

	