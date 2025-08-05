<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Mutasi Piutang Dagang.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>mutasi ar Report</title>
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
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="header_title">
        PT. NIRWANA ALABARE GARMENT
        <br>
        MUTASI PIUTANG DAGANG
        <br />
        <?php
        $bulan = [
            '01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET',
            '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI',
            '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER',
            '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'
        ];

        $tgl = explode('-', $periode_dari);
        $bulanTahun = $bulan[$tgl[1]] . ' ' . $tgl[0];
        ?>
        PER : <?= $bulanTahun; ?>
    </div>
    <br />
    <table style="width:100%;font-size:13px;" border="1">
        <tr>
            <th style="text-align: center;" rowspan="2">No</th>
            <th style="text-align: center;" style="width:450px;" colspan="3">Konsumen</th>
            <th style="text-align: center;" style="width:75px;" rowspan="2">Top</th>
            <th style="text-align: center;" style="width:180px;" rowspan="2">Saldo Awal</th>
            <th style="text-align: center;" style="width:180px;" colspan="2">Penambahan</th>
            <th style="text-align: center;" style="width:180px;" colspan="4">Pengurangan</th>
            <th style="text-align: center;" style="width:180px;" rowspan="2">Saldo Akhir</th>
            <th style="text-align: center;" style="width:90px;" rowspan="2">AR Days</th>
        </tr>
        <tr>
            <th style="text-align: center;" style="width:100px;">Coa</th>
            <th style="text-align: center;" style="width:50px;">Id</th>
            <th style="text-align: center;" style="width:300px;">Nama</th>
            <th style="text-align: center;" style="width:180px;">Penjualan</th>
            <th style="text-align: center;" style="width:180px;">Lain-lain</th>
            <th style="text-align: center;" style="width:180px;">Pelunasan</th>
            <th style="text-align: center;" style="width:180px;">Retur</th>
            <th style="text-align: center;" style="width:180px;">Pph 23</th>
            <th style="text-align: center;" style="width:180px;">Lain-lain</th>
        </tr>

        <?php 
        $no = 1;

        $sal_awl = $tambah = $tambah_ll = $pelunasan = $retur = $pph_23 = $other = $sal_akhir = 0;

        foreach ($mut_ar as $sr) :
        // Akumulasi nilai total
            $sal_awl += $sr['sal_awl'];
            $tambah += $sr['tambah'];
            $tambah_ll += $sr['tambah_ll'];
            $pelunasan += $sr['pelunasan'];
            $retur += $sr['retur'];
            $pph_23 += $sr['pph_23'];
            $other += $sr['other'];
            $sal_akhir += $sr['sal_akhir'];
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td style="width:75px;"><?= $sr['kode_customer']; ?></td>
                <td style="width:50px;"><?= $sr['id_customer_show']; ?></td>
                <td style="width:250px;"><?= $sr['customer']; ?></td>
                <td style="text-align:right;width:50px;"><?= $sr['top']; ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['sal_awl'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['tambah'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['tambah_ll'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['pelunasan'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['retur'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['pph_23'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['other'],2); ?></td>
                <td style="text-align:right;width:120px;"><?= number_format($sr['sal_akhir'],2); ?></td>
                <td style="width:70px;"><?= $sr['ar_day']; ?></td>
            </tr>
        <?php endforeach; ?>

        <tr style="border: 2px double #000;font-weight: bold; background-color: #f2f2f2;">
            <td colspan="5" style="text-align:center;">TOTAL</td>
            <td style="text-align:right;"><?= number_format($sal_awl,2); ?></td>
            <td style="text-align:right;"><?= number_format($tambah,2); ?></td>
            <td style="text-align:right;"><?= number_format($tambah_ll,2); ?></td>
            <td style="text-align:right;"><?= number_format($pelunasan,2); ?></td>
            <td style="text-align:right;"><?= number_format($retur,2); ?></td>
            <td style="text-align:right;"><?= number_format($pph_23,2); ?></td>
            <td style="text-align:right;"><?= number_format($other,2); ?></td>
            <td style="text-align:right;"><?= number_format($sal_akhir,2); ?></td>
        </tr>

    </table>