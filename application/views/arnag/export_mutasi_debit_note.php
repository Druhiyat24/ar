<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=mutasi-debit-note.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MUTASI DEBIT NOTE</title>
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

        .text {
          mso-number-format: "\@";
          /*force text*/
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

        th.text {
          mso-number-format: "\@";
          /*force text*/
        }
    </style>
</head>

<body>
    <div class="header_title">
        MUTASI DEBIT NOTE
        <br />
        Periode : <?= $periode_dari; ?> To <?= $periode_sampai; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th rowspan="2" style="text-align: center;">
                Customer
            </th>
            <th rowspan="2" style="text-align: center;">
                No Debit Note
            </th>
            <th rowspan="2" style="text-align: center;">
                Debit Note Date
            </th>
            <th rowspan="2" style="text-align: center;">
                Vendor
            </th>
            <th rowspan="2" style="text-align: center;">
                Attn
            </th>
            <th rowspan="2" style="text-align: center;">
                Due Date
            </th>
            <th rowspan="2" style="text-align: center;">
                TOP
            </th>
            <th rowspan="2" style="text-align: center;">
                Curr
            </th>
            <th rowspan="2" style="text-align: center;">
                Rate
            </th>
            <th rowspan="2" style="text-align: center;">
                Beginning Balance
            </th>
            <th rowspan="2" style="text-align: center;">
                Addition
            </th>
            <th rowspan="2" style="text-align: center;">
                Deduction
            </th>
            <th rowspan="2" style="text-align: center;">
                Ending Balance
            </th>
            <th rowspan="2" style="text-align: center;">
                Equivalent IDR
            </th>
            <th colspan="9" style="text-align: center;">
                Receivable Aging Based on Due Date
            </th>
            <th rowspan="2" style="text-align: center;width: 20px;"></th>
            <th colspan="8" style="text-align: center;">
                Receivable Due Date Projection
            </th>
        </tr>
        <tr>
            <th style="text-align: center;">
                 Not Due
            </th>
           <th class="text" style="text-align: center;">
                 <p class="text">01-30</p>
            </th>
            <th style="text-align: center;">
                 31-60
            </th>
            <th style="text-align: center;">
                 61-90
            </th>
            <th style="text-align: center;">
                 91-120
            </th>
            <th style="text-align: center;">
                 121-180
            </th>
            <th style="text-align: center;">
                 181-360
            </th>
            <th style="text-align: center;">
                 >360
            </th>
            <th style="text-align: center;">
                 Total            
            </th>
            <th style="text-align: center;">
                 Already Due
            </th>
            <th style="text-align: center;">
                 <?= $bln1.'-'.$thn1 ?>
            </th>
            <th style="text-align: center;">
                 <?= $bln2.'-'.$thn2 ?>
            </th>
            <th style="text-align: center;">
                 <?= $bln3.'-'.$thn3 ?>
            </th>
            <th style="text-align: center;">
                 <?= $bln4.'-'.$thn4 ?>
            </th>
            <th style="text-align: center;">
                 <?= $bln5.'-'.$thn5 ?>
            </th>
            <th style="text-align: center;">
                 <?= $bln6.'-'.$thn6 ?>
            </th>
            <th style="text-align: center;">
                 Total            
            </th>
        </tr>

        <?php foreach ($data_kartu_ar2 as $dli) : ?>
            <?php 
            $bayar2 = isset($dli['bayar2']) ? $dli['bayar2'] : 0;
            $tanggal = $dli['inv_date'];
            $duedate = $dli['duedate'];
            $curr = $dli['from_curr'];
            $rates = $dli['rate'];
            $diff_top = $dli['diff_top'];
            $jmlbln1 = isset($dli['jml_bln1']) ? $dli['jml_bln1'] : 0;
            $jmlbln2 = isset($dli['jml_bln2']) ? $dli['jml_bln2'] : 0;
            $jmlbln3 = isset($dli['jml_bln3']) ? $dli['jml_bln3'] : 0;
            $jmlbln4 = isset($dli['jml_bln4']) ? $dli['jml_bln4'] : 0;
            $jmlbln5 = isset($dli['jml_bln5']) ? $dli['jml_bln5'] : 0;
            $jmlbln6 = isset($dli['jml_bln6']) ? $dli['jml_bln6'] : 0;
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

            $eqv_idr =(($sal_awl + $tambah) - $bayar) * $rates;
            $rate = $rates;


            if ($jmlbln1 > 0 && $duedate >= $periode_sampai) {
                $jml_bln1 = $eqv_idr;
            }else{
                $jml_bln1 = 0;
            }
            if ($jmlbln2 <= 0) {
                $jml_bln2 = 0;
            }else{
                $jml_bln2 = $eqv_idr;
            }
            if ($jmlbln3 <= 0) {
                $jml_bln3 = 0;
            }else{
                $jml_bln3 = $eqv_idr;
            }
            if ($jmlbln4 <= 0) {
                $jml_bln4 = 0;
            }else{
                $jml_bln4 = $eqv_idr;
            }
            if ($jmlbln5 <= 0) {
                $jml_bln5 = 0;
            }else{
                $jml_bln5 = $eqv_idr;
            }
            if ($jmlbln6 <= 0) {
                $jml_bln6 = 0;
            }else{
                $jml_bln6 = $eqv_idr;
            }

            if ($total <= '0') {
                $amt_aging_0 = 0;
                $amt_aging_1 = 0;
                $amt_aging_2 = 0;
                $amt_aging_3 = 0;
                $amt_aging_4 = 0;
                $amt_aging_5 = 0;
                $amt_aging_6 = 0;
                $amt_aging_7 = 0;
                $tot_aging = 0;
                $tot_aging2 = 0;
                $readydue = 0;

            }else{
                if($duedate < $periode_sampai){
                    $readydue = $eqv_idr;
                }else{
                    $readydue = 0;
                }  
                $tot_aging2 = $eqv_idr;
                if ($diff_top <= 0) {
                    $amt_aging_0 = $eqv_idr;
                    $amt_aging_1 = 0;
                    $amt_aging_2 = 0;
                    $amt_aging_3 = 0;
                    $amt_aging_4 = 0;
                    $amt_aging_5 = 0;
                    $amt_aging_6 = 0;
                    $amt_aging_7 = 0;
                    $tot_aging = $eqv_idr;
                }

                if ($diff_top > 0 && $diff_top <= 30) {
                    $amt_aging_0 = 0;
                    $amt_aging_1 = $eqv_idr;
                    $amt_aging_2 = 0;
                    $amt_aging_3 = 0;
                    $amt_aging_4 = 0;
                    $amt_aging_5 = 0;
                    $amt_aging_6 = 0;
                    $amt_aging_7 = 0;
                    $tot_aging = $eqv_idr;
                }

                if ($diff_top > 30 && $diff_top <= 60) {
                    $amt_aging_0 = 0;
                    $amt_aging_1 = 0;
                    $amt_aging_2 = $eqv_idr;
                    $amt_aging_3 = 0;
                    $amt_aging_4 = 0;
                    $amt_aging_5 = 0;
                    $amt_aging_6 = 0;
                    $amt_aging_7 = 0;
                    $tot_aging = $eqv_idr;
                }

                if ($diff_top > 60 && $diff_top <= 90) {
                    $amt_aging_0 = 0;
                    $amt_aging_1 = 0;
                    $amt_aging_2 = 0;
                    $amt_aging_3 = $eqv_idr;
                    $amt_aging_4 = 0;
                    $amt_aging_5 = 0;
                    $amt_aging_6 = 0;
                    $amt_aging_7 = 0;
                    $tot_aging = $eqv_idr;
                }

                if ($diff_top > 90 && $diff_top <= 120) {
                    $amt_aging_0 = 0;
                    $amt_aging_1 = 0;
                    $amt_aging_2 = 0;
                    $amt_aging_3 = 0;
                    $amt_aging_4 = $eqv_idr;
                    $amt_aging_5 = 0;
                    $amt_aging_6 = 0;
                    $amt_aging_7 = 0;
                    $tot_aging = $eqv_idr;
                }

                if ($diff_top > 120 && $diff_top <= 180) {
                    $amt_aging_0 = 0;
                    $amt_aging_1 = 0;
                    $amt_aging_2 = 0;
                    $amt_aging_3 = 0;
                    $amt_aging_4 = 0;
                    $amt_aging_5 = $eqv_idr;
                    $amt_aging_6 = 0;
                    $amt_aging_7 = 0;
                    $tot_aging = $eqv_idr;
                }

                if ($diff_top > 180 && $diff_top <= 360) {
                    $amt_aging_0 = 0;
                    $amt_aging_1 = 0;
                    $amt_aging_2 = 0;
                    $amt_aging_3 = 0;
                    $amt_aging_4 = 0;
                    $amt_aging_5 = 0;
                    $amt_aging_6 = $eqv_idr;
                    $amt_aging_7 = 0;
                    $tot_aging = $eqv_idr;
                }

                if ($diff_top > 360) {
                    $amt_aging_0 = 0;
                    $amt_aging_1 = 0;
                    $amt_aging_2 = 0;
                    $amt_aging_3 = 0;
                    $amt_aging_4 = 0;
                    $amt_aging_5 = 0;
                    $amt_aging_6 = 0;
                    $amt_aging_7 = $eqv_idr;
                    $tot_aging = $eqv_idr;
                }

            }
          
                  ?>

                <?php
                if ($sal_awl <= 0 && $tambah <= 0 && $bayar <= 0 && $total <= 0) {

                }   else{
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
                    '.$dli['supplier'].'
                </td>
                <td align="center">
                    '.$dli['attn'].'
                </td>
                <td align="center">
                    '.$dli['duedate'].'
                </td>
                <td align="center">
                    '.$dli['top'].'
                </td>
                <td align="center">
                    '.$dli['from_curr'].'
                </td>
                <td align="center">
                    '.$rate.'
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
                <td align="right">
                    '.$eqv_idr.'
                </td>
                <td align="right">
                    '.$amt_aging_0.'
                </td>
                <td align="right">
                    '.$amt_aging_1.'
                </td>
                <td align="right">
                    '.$amt_aging_2.'
                </td>
                <td align="right">
                    '.$amt_aging_3.'
                </td>
                <td align="right">
                    '.$amt_aging_4.'
                </td>
                <td align="right">
                    '.$amt_aging_5.'
                </td>
                <td align="right">
                    '.$amt_aging_6.'
                </td>
                <td align="right">
                    '.$amt_aging_7.'
                </td>
                <td align="right">
                    '.$tot_aging.'
                </td>
                <td align="right">
                   
                </td>
                <td align="right">
                    '.$readydue.'
                </td>
                <td align="right">
                    '.$jml_bln1.'
                </td>
                <td align="right">
                    '.$jml_bln2.'
                </td>
                <td align="right">
                    '.$jml_bln3.'
                </td>
                <td align="right">
                    '.$jml_bln4.'
                </td>
                <td align="right">
                    '.$jml_bln5.'
                </td>
                <td align="right">
                    '.$jml_bln6.'
                </td>
                <td align="right">
                    '.$tot_aging2.'
                </td>
            </tr>';
        }
        
        ?>
        <?php endforeach; ?>

    </table>