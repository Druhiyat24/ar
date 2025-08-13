<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=kartu_ar_detail.xls");
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kartu AR Detail</title>
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
    font-size: 11pt;
}
</style>
</head>

<body>
    <div class="header_title">
        KARTU AR DETAIL
        <br />
        Period : <?= $periode_dari; ?> To <?= $periode_sampai; ?>
    </div>
    <br />
    <table style="width:100%;font-size:11pt;" border="1">
        <tr align="center">
            <th rowspan="2" style="text-align: center;">
                Customer
            </th>
            <th rowspan="2" style="text-align: center;">
                No Invoice
            </th>
            <th rowspan="2" style="text-align: center;">
                Invoice Date
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

            echo'
            <tr>
            <td align="center">'.$dli['customer'].'</td>
            <td align="center">'.$dli['no_invoice'].'</td>
            <td align="center">'.$dli['inv_date'].'</td>
            <td align="center">'.$dli['duedate'].'</td>
            <td align="center">'.$dli['top'].'</td>
            <td align="center">'.$dli['curr'].'</td>
            <td align="center">'.$dli['rate'].'</td>
            <td align="center">'.$dli['sal_awl'].'</td>                
            <td align="center">'.$dli['tambah'].'</td>
            <td align="center">'.$dli['bayar'].'</td>
            <td align="right">'.$dli['total'].'</td>
            <td align="right">'.$dli['eqv_idr'].'</td>
            <td align="right">'.$dli['amt_aging_0'].'</td>
            <td align="right">'.$dli['amt_aging_1'].'</td>
            <td align="right">'.$dli['amt_aging_2'].'</td>
            <td align="right">'.$dli['amt_aging_3'].'</td>
            <td align="right">'.$dli['amt_aging_4'].'</td>
            <td align="right">'.$dli['amt_aging_5'].'</td>
            <td align="right">'.$dli['amt_aging_6'].'</td>
            <td align="right">'.$dli['amt_aging_7'].'</td>
            <td align="right">'.$dli['tot_aging'].'</td>
            <td align="right"></td>
            <td align="right">'.$dli['readydue'].'</td>
            <td align="right">'.$dli['hasil_bln1'].'</td>
            <td align="right">'.$dli['hasil_bln2'].'</td>
            <td align="right">'.$dli['hasil_bln3'].'</td>
            <td align="right">'.$dli['hasil_bln4'].'</td>
            <td align="right">'.$dli['hasil_bln5'].'</td>
            <td align="right">'.$dli['hasil_bln6'].'</td>
            <td align="right">'.$dli['tot_jatem'].'</td>
            </tr>';
        
        ?>
    <?php endforeach; ?>

</table>