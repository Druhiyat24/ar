<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Summary_Receivable.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Summary Receivable</title>
    <style>
        /* @page {
			margin-top: 1.54cm;
			margin-bottom: 1.54cm;
			margin-left: 3.175cm;
			margin-right: 3.175cm;
		} */

        table {
            margin: auto;
            font-size: 12px;
        }

        td,
        th {
            padding: 1px;
            text-align: left;
            font-size: 12px;
        }

        h1 {
            text-align: center
        }

        th {
            text-align: center;
            padding: 10px;
            font-size: 12px;
        }

        .footer {
            width: 100%;
            height: 30px;
            margin-top: 50px;
            text-align: right;
        }

        .text {
          mso-number-format: "\@";
          /*force text*/
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

<?php 
$tot_foreign_a = 0;
$tot_eqv_a = 0;
$tot_notdue_a = 0;
$tot_aging1_a = 0;
$tot_aging2_a = 0;
$tot_aging3_a = 0;
$tot_aging4_a = 0;
$tot_aging5_a = 0;
$tot_aging6_a = 0;
$tot_aging7_a = 0;
$tot_sumaging_a = 0;
$tot_readydue_a = 0;
$tot_bln1_a = 0;
$tot_bln2_a = 0;
$tot_bln3_a = 0;
$tot_bln4_a = 0;
$tot_bln5_a = 0;
$tot_bln6_a = 0;
$tot_sumaging2_a = 0;

$tot_foreign_b = 0;
$tot_eqv_b = 0;
$tot_notdue_b = 0;
$tot_aging1_b = 0;
$tot_aging2_b = 0;
$tot_aging3_b = 0;
$tot_aging4_b = 0;
$tot_aging5_b = 0;
$tot_aging6_b = 0;
$tot_aging7_b = 0;
$tot_sumaging_b = 0;
$tot_readydue_b = 0;
$tot_bln1_b = 0;
$tot_bln2_b = 0;
$tot_bln3_b = 0;
$tot_bln4_b = 0;
$tot_bln5_b = 0;
$tot_bln6_b = 0;
$tot_sumaging2_b = 0;

$tot_foreign_c = 0;
$tot_eqv_c = 0;
$tot_notdue_c = 0;
$tot_aging1_c = 0;
$tot_aging2_c = 0;
$tot_aging3_c = 0;
$tot_aging4_c = 0;
$tot_aging5_c = 0;
$tot_aging6_c = 0;
$tot_aging7_c = 0;
$tot_sumaging_c = 0;
$tot_readydue_c = 0;
$tot_bln1_c = 0;
$tot_bln2_c = 0;
$tot_bln3_c = 0;
$tot_bln4_c = 0;
$tot_bln5_c = 0;
$tot_bln6_c = 0;
$tot_sumaging2_c = 0;

$tot_foreign_d = 0;
$tot_eqv_d = 0;
$tot_notdue_d = 0;
$tot_aging1_d = 0;
$tot_aging2_d = 0;
$tot_aging3_d = 0;
$tot_aging4_d = 0;
$tot_aging5_d = 0;
$tot_aging6_d = 0;
$tot_aging7_d = 0;
$tot_sumaging_d = 0;
$tot_readydue_d = 0;
$tot_bln1_d = 0;
$tot_bln2_d = 0;
$tot_bln3_d = 0;
$tot_bln4_d = 0;
$tot_bln5_d = 0;
$tot_bln6_d = 0;
$tot_sumaging2_d = 0;
?>


<body>
    <div class="header_title">
        SUMMARY RECEIVABLE
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
                Curr
            </th>
            <th colspan="2" style="text-align: center;">
                Receivable Balance
            </th>
            <th rowspan="2" style="text-align: center;width: 60px;">
                Remarks
            </th>
            <th rowspan="2" style="border-top: none;border-bottom: none;width: 30px;">
            </th>
            <th colspan="9" style="text-align: center;">
                Receivable Aging Based on Due Date
            </th>
            <th rowspan="2" style="border-top: none;border-bottom: none;width: 30px;"></th>
            <th colspan="8" style="text-align: center;">
                Receivable Due Date Projection
            </th>
        </tr>
        <tr>
            <th style="text-align: center;">
                 Foreign Curr
            </th>
             <th style="text-align: center;">
                 Equivalent IDR
            </th>
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
        <tr>
            <th colspan="5">Account Receivable</th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="5">Local Sales</th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>

        <?php foreach ($data_sales as $dsa) : ?>
            <?php $foreign_curr =  isset($dsa['foreign_curr']) ? $dsa['foreign_curr'] : 0; 
                  $eqv_idr =  isset($dsa['eqv_idr']) ? $dsa['eqv_idr'] : 0; 

                  ?>
                <?php
            if ($foreign_curr <= 0 && $eqv_idr <= 0) {
                    echo '';
            }else{
                if ($dsa['shipp'] == 'Local') {
                    $tot_foreign_a += $dsa['foreign_curr'];
                    $tot_eqv_a += $dsa['eqv_idr'];
                    $tot_notdue_a += $dsa['not_due'];
                    $tot_aging1_a += $dsa['amt_aging_1'];
                    $tot_aging2_a += $dsa['amt_aging_2'];
                    $tot_aging3_a += $dsa['amt_aging_3'];
                    $tot_aging4_a += $dsa['amt_aging_4'];
                    $tot_aging5_a += $dsa['amt_aging_5'];
                    $tot_aging6_a += $dsa['amt_aging_6'];
                    $tot_aging7_a += $dsa['amt_aging_7'];
                    $tot_sumaging_a += $dsa['tot_aging'];
                    $tot_readydue_a += $dsa['ready_due'];
                    $tot_bln1_a += $dsa['jml_bln1'];
                    $tot_bln2_a += $dsa['jml_bln2'];
                    $tot_bln3_a += $dsa['jml_bln3'];
                    $tot_bln4_a += $dsa['jml_bln4'];
                    $tot_bln5_a += $dsa['jml_bln5'];
                    $tot_bln6_a += $dsa['jml_bln6'];
                    $tot_sumaging2_a += $dsa['tot_aging2'];
                echo'
            <tr>
                <td align="center">'.$dsa['customer'].'</td>
                <td align="center">'.$dsa['curr'].'</td>
                <td style="text-align: right;">'.number_format($dsa['foreign_curr'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['eqv_idr'],2).'</td>
                <td align="center"></td>
                <td style="border-top: none;border-bottom: none;"></td>
                <td style="text-align: right;">'.number_format($dsa['not_due'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['amt_aging_1'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['amt_aging_2'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['amt_aging_3'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['amt_aging_4'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['amt_aging_5'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['amt_aging_6'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['amt_aging_7'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['tot_aging'],2).'</td>
                <td style="border-top: none;border-bottom: none;"></td>
                <td style="text-align: right;">'.number_format($dsa['ready_due'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['jml_bln1'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['jml_bln2'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['jml_bln3'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['jml_bln4'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['jml_bln5'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['jml_bln6'],2).'</td>
                <td style="text-align: right;">'.number_format($dsa['tot_aging2'],2).'</td>
            </tr>';
            }
        }
        ?>
        <?php endforeach; ?>
        <?php
        echo'
            <tr>
                <th colspan="2" align="center">Total Account Receivable Local</th>
                <th style="text-align: right;">'.number_format($tot_foreign_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_eqv_a,2).'</th>
                <th align="center"></th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format($tot_notdue_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging1_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging2_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging3_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging4_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging5_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging6_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging7_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_sumaging_a,2).'</th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format($tot_readydue_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln1_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln2_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln3_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln4_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln5_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln6_a,2).'</th>
                <th style="text-align: right;">'.number_format($tot_sumaging2_a,2).'</th>
            </tr>
            <tr>
            <th colspan="5"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="5">Export Sales</th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>';
        ?>

        <?php foreach ($data_sales as $dsb) : ?>
            <?php $foreign_curr_b =  isset($dsb['foreign_curr']) ? $dsb['foreign_curr'] : 0; 
                  $eqv_idr_b =  isset($dsb['eqv_idr']) ? $dsb['eqv_idr'] : 0; 

                  ?>
                <?php
            if ($foreign_curr_b <= 0 && $eqv_idr_b <= 0) {
                    echo '';
            }else{
                if ($dsb['shipp'] == 'Export') {
                    $tot_foreign_b += $dsb['foreign_curr'];
                    $tot_eqv_b += $dsb['eqv_idr'];
                    $tot_notdue_b += $dsb['not_due'];
                    $tot_aging1_b += $dsb['amt_aging_1'];
                    $tot_aging2_b += $dsb['amt_aging_2'];
                    $tot_aging3_b += $dsb['amt_aging_3'];
                    $tot_aging4_b += $dsb['amt_aging_4'];
                    $tot_aging5_b += $dsb['amt_aging_5'];
                    $tot_aging6_b += $dsb['amt_aging_6'];
                    $tot_aging7_b += $dsb['amt_aging_7'];
                    $tot_sumaging_b += $dsb['tot_aging'];
                    $tot_readydue_b += $dsb['ready_due'];
                    $tot_bln1_b += $dsb['jml_bln1'];
                    $tot_bln2_b += $dsb['jml_bln2'];
                    $tot_bln3_b += $dsb['jml_bln3'];
                    $tot_bln4_b += $dsb['jml_bln4'];
                    $tot_bln5_b += $dsb['jml_bln5'];
                    $tot_bln6_b += $dsb['jml_bln6'];
                    $tot_sumaging2_b += $dsb['tot_aging2'];
                echo'
            <tr>
                <td align="center">'.$dsb['customer'].'</td>
                <td align="center">'.$dsb['curr'].'</td>
                <td style="text-align: right;">'.number_format($dsb['foreign_curr'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['eqv_idr'],2).'</td>
                <td align="center"></td>
                <td style="border-top: none;border-bottom: none;"></td>
                <td style="text-align: right;">'.number_format($dsb['not_due'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['amt_aging_1'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['amt_aging_2'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['amt_aging_3'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['amt_aging_4'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['amt_aging_5'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['amt_aging_6'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['amt_aging_7'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['tot_aging'],2).'</td>
                <td style="border-top: none;border-bottom: none;"></td>
                <td style="text-align: right;">'.number_format($dsb['ready_due'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['jml_bln1'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['jml_bln2'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['jml_bln3'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['jml_bln4'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['jml_bln5'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['jml_bln6'],2).'</td>
                <td style="text-align: right;">'.number_format($dsb['tot_aging2'],2).'</td>
            </tr>';
            }
        }
        ?>
        <?php endforeach; ?>
        <?php
        echo'
            <tr>
                <th colspan="2" align="center">Total Account Receivable Export</th>
                <th style="text-align: right;">'.number_format($tot_foreign_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_eqv_b,2).'</th>
                <th align="center"></th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format($tot_notdue_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging1_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging2_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging3_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging4_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging5_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging6_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging7_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_sumaging_b,2).'</th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format($tot_readydue_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln1_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln2_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln3_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln4_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln5_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln6_b,2).'</th>
                <th style="text-align: right;">'.number_format($tot_sumaging2_b,2).'</th>
            </tr>
        <tr>
            <th colspan="5"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>
            <tr>
                <th colspan="3" align="center">Total Account Receivable</th>
                <th style="text-align: right;">'.number_format(($tot_eqv_b + $tot_eqv_a),2).'</th>
                <th align="center"></th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format(($tot_notdue_b + $tot_notdue_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging1_b + $tot_aging1_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging2_b + $tot_aging2_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging3_b + $tot_aging3_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging4_b + $tot_aging4_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging5_b + $tot_aging5_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging6_b + $tot_aging6_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging7_b + $tot_aging7_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_sumaging_b + $tot_sumaging_a),2).'</th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format(($tot_readydue_b + $tot_readydue_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln1_b + $tot_bln1_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln2_b + $tot_bln2_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln3_b + $tot_bln3_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln4_b + $tot_bln4_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln5_b + $tot_bln5_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln6_b + $tot_bln6_a),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_sumaging2_b + $tot_sumaging2_a),2).'</th>
            </tr>
            <tr>
            <th colspan="5"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="5">Other Receivable (Debit Note)</th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="5">Local Debit Note</th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>';
        ?>

        <?php foreach ($data_debitnote as $dsc) : ?>
            <?php $foreign_curr_c =  isset($dsc['foreign_curr']) ? $dsc['foreign_curr'] : 0; 
                  $eqv_idr_c =  isset($dsc['eqv_idr']) ? $dsc['eqv_idr'] : 0; 

                  ?>
                <?php
            if ($foreign_curr_c <= 0 && $eqv_idr_c <= 0) {
                    echo '';
            }else{
                if ($dsc['from_curr'] == 'IDR') {
                    $tot_foreign_c += $dsc['foreign_curr'];
                    $tot_eqv_c += $dsc['eqv_idr'];
                    $tot_notdue_c += $dsc['not_due'];
                    $tot_aging1_c += $dsc['amt_aging_1'];
                    $tot_aging2_c += $dsc['amt_aging_2'];
                    $tot_aging3_c += $dsc['amt_aging_3'];
                    $tot_aging4_c += $dsc['amt_aging_4'];
                    $tot_aging5_c += $dsc['amt_aging_5'];
                    $tot_aging6_c += $dsc['amt_aging_6'];
                    $tot_aging7_c += $dsc['amt_aging_7'];
                    $tot_sumaging_c += $dsc['tot_aging'];
                    $tot_readydue_c += $dsc['ready_due'];
                    $tot_bln1_c += $dsc['jml_bln1'];
                    $tot_bln2_c += $dsc['jml_bln2'];
                    $tot_bln3_c += $dsc['jml_bln3'];
                    $tot_bln4_c += $dsc['jml_bln4'];
                    $tot_bln5_c += $dsc['jml_bln5'];
                    $tot_bln6_c += $dsc['jml_bln6'];
                    $tot_sumaging2_c += $dsc['tot_aging2'];
                echo'
            <tr>
                <td align="center">'.$dsc['customer'].'</td>
                <td align="center">'.$dsc['from_curr'].'</td>
                <td style="text-align: right;">'.number_format($dsc['foreign_curr'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['eqv_idr'],2).'</td>
                <td align="center"></td>
                <td style="border-top: none;border-bottom: none;"></td>
                <td style="text-align: right;">'.number_format($dsc['not_due'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['amt_aging_1'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['amt_aging_2'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['amt_aging_3'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['amt_aging_4'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['amt_aging_5'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['amt_aging_6'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['amt_aging_7'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['tot_aging'],2).'</td>
                <td style="border-top: none;border-bottom: none;"></td>
                <td style="text-align: right;">'.number_format($dsc['ready_due'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['jml_bln1'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['jml_bln2'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['jml_bln3'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['jml_bln4'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['jml_bln5'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['jml_bln6'],2).'</td>
                <td style="text-align: right;">'.number_format($dsc['tot_aging2'],2).'</td>
            </tr>';
            }
        }
        ?>
        <?php endforeach; ?>
        <?php
        echo'
            <tr>
                <th colspan="2" align="center">Total Other Receivable Local</th>
                <th style="text-align: right;">'.number_format($tot_foreign_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_eqv_c,2).'</th>
                <th align="center"></th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format($tot_notdue_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging1_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging2_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging3_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging4_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging5_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging6_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging7_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_sumaging_c,2).'</th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format($tot_readydue_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln1_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln2_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln3_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln4_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln5_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln6_c,2).'</th>
                <th style="text-align: right;">'.number_format($tot_sumaging2_c,2).'</th>
            </tr>
            <tr>
            <th colspan="5"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="5">Export Debit Note</th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>';
        ?>

        <?php foreach ($data_debitnote as $dsd) : ?>
            <?php $foreign_curr_d =  isset($dsd['foreign_curr']) ? $dsd['foreign_curr'] : 0; 
                  $eqv_idr_d =  isset($dsd['eqv_idr']) ? $dsd['eqv_idr'] : 0; 

                  ?>
                <?php
            if ($foreign_curr_d <= 0 && $eqv_idr_d <= 0) {
                    echo '';
            }else{
                if ($dsd['from_curr'] == 'USD') {
                    $tot_foreign_d += $dsd['foreign_curr'];
                    $tot_eqv_d += $dsd['eqv_idr'];
                    $tot_notdue_d += $dsd['not_due'];
                    $tot_aging1_d += $dsd['amt_aging_1'];
                    $tot_aging2_d += $dsd['amt_aging_2'];
                    $tot_aging3_d += $dsd['amt_aging_3'];
                    $tot_aging4_d += $dsd['amt_aging_4'];
                    $tot_aging5_d += $dsd['amt_aging_5'];
                    $tot_aging6_d += $dsd['amt_aging_6'];
                    $tot_aging7_d += $dsd['amt_aging_7'];
                    $tot_sumaging_d += $dsd['tot_aging'];
                    $tot_readydue_d += $dsd['ready_due'];
                    $tot_bln1_d += $dsd['jml_bln1'];
                    $tot_bln2_d += $dsd['jml_bln2'];
                    $tot_bln3_d += $dsd['jml_bln3'];
                    $tot_bln4_d += $dsd['jml_bln4'];
                    $tot_bln5_d += $dsd['jml_bln5'];
                    $tot_bln6_d += $dsd['jml_bln6'];
                    $tot_sumaging2_d += $dsd['tot_aging2'];
                echo'
            <tr>
                <td align="center">'.$dsd['customer'].'</td>
                <td align="center">'.$dsd['from_curr'].'</td>
                <td style="text-align: right;">'.number_format($dsd['foreign_curr'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['eqv_idr'],2).'</td>
                <td align="center"></td>
                <td style="border-top: none;border-bottom: none;"></td>
                <td style="text-align: right;">'.number_format($dsd['not_due'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['amt_aging_1'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['amt_aging_2'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['amt_aging_3'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['amt_aging_4'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['amt_aging_5'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['amt_aging_6'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['amt_aging_7'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['tot_aging'],2).'</td>
                <td style="border-top: none;border-bottom: none;"></td>
                <td style="text-align: right;">'.number_format($dsd['ready_due'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['jml_bln1'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['jml_bln2'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['jml_bln3'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['jml_bln4'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['jml_bln5'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['jml_bln6'],2).'</td>
                <td style="text-align: right;">'.number_format($dsd['tot_aging2'],2).'</td>
            </tr>';
            }
        }
        ?>
        <?php endforeach; ?>
        <?php
        echo'
            <tr>
                <th colspan="2" align="center">Total Other Receivable Export</th>
                <th style="text-align: right;">'.number_format($tot_foreign_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_eqv_d,2).'</th>
                <th align="center"></th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format($tot_notdue_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging1_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging2_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging3_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging4_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging5_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging6_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_aging7_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_sumaging_d,2).'</th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format($tot_readydue_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln1_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln2_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln3_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln4_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln5_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_bln6_d,2).'</th>
                <th style="text-align: right;">'.number_format($tot_sumaging2_d,2).'</th>
            </tr>
            <tr>
            <th colspan="5"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>
        <tr>
                <th colspan="3" align="center">Total Other Receivable</th>
                <th style="text-align: right;">'.number_format(($tot_eqv_c + $tot_eqv_d),2).'</th>
                <th align="center"></th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format(($tot_notdue_c + $tot_notdue_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging1_c + $tot_aging1_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging2_c + $tot_aging2_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging3_c + $tot_aging3_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging4_c + $tot_aging4_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging5_c + $tot_aging5_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging6_c + $tot_aging6_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging7_c + $tot_aging7_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_sumaging_c + $tot_sumaging_d),2).'</th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format(($tot_readydue_c + $tot_readydue_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln1_c + $tot_bln1_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln2_c + $tot_bln2_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln3_c + $tot_bln3_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln4_c + $tot_bln4_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln5_c + $tot_bln5_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln6_c + $tot_bln6_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_sumaging2_c + $tot_sumaging2_d),2).'</th>
            </tr>
            <tr>
            <th colspan="5"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="9"></th>
            <th style="border-top: none;border-bottom: none;">
            <th colspan="8"></th>
        </tr>
        <tr>
                <th colspan="3" align="center">Total Other Receivable</th>
                <th style="text-align: right;">'.number_format(($tot_eqv_c + $tot_eqv_d + $tot_eqv_a + $tot_eqv_b),2).'</th>
                <th align="center"></th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format(($tot_notdue_c + $tot_notdue_d + $tot_notdue_a + $tot_notdue_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging1_c + $tot_aging1_d + $tot_aging1_a + $tot_aging1_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging2_c + $tot_aging2_d + $tot_aging2_a + $tot_aging2_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging3_c + $tot_aging3_d + $tot_aging3_a + $tot_aging3_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging4_c + $tot_aging4_d + $tot_aging4_a + $tot_aging4_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging5_c + $tot_aging5_d + $tot_aging5_a + $tot_aging5_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging6_c + $tot_aging6_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_aging7_c + $tot_aging7_d),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_sumaging_c + $tot_sumaging_d),2).'</th>
                <th style="border-top: none;border-bottom: none;"></th>
                <th style="text-align: right;">'.number_format(($tot_readydue_c + $tot_readydue_d + $tot_readydue_a + $tot_readydue_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln1_c + $tot_bln1_d + $tot_bln1_a + $tot_bln1_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln2_c + $tot_bln2_d + $tot_bln2_a + $tot_bln2_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln3_c + $tot_bln3_d + $tot_bln3_a + $tot_bln3_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln4_c + $tot_bln4_d + $tot_bln4_a + $tot_bln4_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln5_c + $tot_bln5_d + $tot_bln5_a + $tot_bln5_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_bln6_c + $tot_bln6_d + $tot_bln6_a + $tot_bln6_b),2).'</th>
                <th style="text-align: right;">'.number_format(($tot_sumaging2_c + $tot_sumaging2_d + $tot_sumaging2_a + $tot_sumaging2_b),2).'</th>
            </tr>';
        ?>

    </table>
</div>
</div>
</body>
</html>