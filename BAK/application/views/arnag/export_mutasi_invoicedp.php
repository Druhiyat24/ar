<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=mutasi-incoice-dp-cbd.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MUTASI INVOICE DP & CBD</title>
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
        MUTASI INVOICE DP & CBD
        <br />
        Periode : <?= $periode_dari; ?> To <?= $periode_sampai; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th  style="text-align: center;">
                Customer
            </th>
            <th style="text-align: center;">
                No Invoice
            </th>
            <th style="text-align: center;">
                Invoice Date
            </th>
            <th style="text-align: center;">
                Due Date
            </th>
            <th style="text-align: center;">
                TOP
            </th>
            <th style="text-align: center;">
                Curr
            </th>
            <th style="text-align: center;">
                Beginning Balance
            </th>
            <th style="text-align: center;">
                Addition
            </th>
            <th style="text-align: center;">
                Deduction
            </th>
            <th style="text-align: center;">
                Ending Balance
            </th>
        </tr>

        <?php foreach ($data_kartu_ar2 as $dli) : ?>
            <?php 
            $bayar2 = isset($dli['bayar2']) ? $dli['bayar2'] : 0;
            $tanggal = $dli['inv_date'];
                if($tanggal >= $periode_dari){
                $sal_awl = 0;
            }   
            else{
                $sal_awl = $dli['amount1'] - $bayar2;
            }

            if($tanggal >= $periode_dari){
                $tambah = $dli['amount1'] - $bayar2 ;
            }   
            else{
                $tambah = 0;
            }

            $bayar = isset($dli['bayar']) ? $dli['bayar'] : 0;

            $total = ($sal_awl + $tambah) - $bayar;
          
                  ?>

                <?php
                echo'
            <tr>
                <td align="center">
                    '.$dli['customer'].'
                </td>
               <td align="center">
                    '.$dli['no_invoice'].'
                </td>
                <td align="center">
                    '.$dli['inv_date'].'
                </td>
                 <td align="center">
                    '.$dli['duedate'].'
                </td>
                <td align="center">
                    '.$dli['top'].'
                </td>
                <td align="center">
                    '.$dli['curr'].'
                </td>
                <td align="center">
                    '.$sal_awl.'
                </td>                
                <td align="center">
                    '.$tambah.'
                </td>
                <td align="center">
                    '.$bayar.'
                </td>
                <td align="right">
                    '.$total.'
                </td>
            </tr>';
        
        ?>
        <?php endforeach; ?>

    </table>