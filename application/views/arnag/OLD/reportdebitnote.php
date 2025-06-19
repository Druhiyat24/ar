<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Debit Note</title>
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
                    <img src="<?= base_url('vendors/Invoice_Template/nag_logo2.png'); ?>" width="15%">
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
        DEBIT NOTE <br />
        <?= $data_debit_note['no_dn']; ?>
    </div>
    <br />
    <table style="width:100%;font-size:10px;">
        <tr>
            <td style="width: 100px">
                Date
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_debit_note['tgl_dn']; ?>
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
            <td style="width: 100px">
                Consignee
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_debit_note['customer']; ?>
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
            <td style="width: 100px">
                Address
            </td>
            <td class="position_top">
                :
            </td>
            <td class="position_top" colspan="3">
                <?= $data_debit_note['alamat']; ?>
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
            <td style="width: 100px">
                Attn
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_debit_note['attn']; ?>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td colspan="7">
            </td>
        </tr>

        <!-- <tr>
            <td style="width: 100px">
                No Faktur Pajak
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_proforma_invoice_cbd['no_faktur_pajak']; ?>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td colspan="7">
            </td>
        </tr>

        <tr>
            <td style="width: 100px">
                Shipp
            </td>
            <td>
                :
            </td>
            <td colspan="3">
                <?= $data_proforma_invoice_cbd['shipp']; ?>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td colspan="7">
            </td>
        </tr> -->
    </table>

    <br />

    <table style="width:100%;font-size:10px;" border="1">
        <tr align="center">
            <th>
                Description
            </th>
            <th>
                Supplier
            </th>
            <th>
                Supplier Invoice
            </th>
            <?php
            $my_tot1 =  $data_debit_note['data1'] + $data_debit_note['data2'] + $data_debit_note['data3'] + 3;
                if ($data_debit_note['header1'] != '') {
                    
                echo '<th style="width: 100px">'.$data_debit_note['header1'].'</th>';
                }else{
                }
                if ($data_debit_note['header2'] != '') {
                    
                echo '<th style="width: 100px">'.$data_debit_note['header2'].'</th>';
                }else{
                }

                if ($data_debit_note['header3'] != '') {
                    
                echo '<th style="width: 100px">'.$data_debit_note['header3'].'</th>';
                }else{
                }
                ?>
            <th >
                Value <?= $data_debit_note['from_curr']; ?>
            </th>
            <th>
                Rate
            </th>
            <th style="width: 100px">
                Value <?= $data_debit_note['to_curr']; ?>
            </th>
        </tr>

        <?php
        $qty = 0;
        foreach ($data_debit_note_det as $prof_inv_det) : ?>
            <tr>
                <td align='center'><?= $prof_inv_det['deskripsi']; ?></td>
                <td align='center'><?= $prof_inv_det['supplier']; ?></td>
                <td align='center'><?= $prof_inv_det['supplier_invoice']; ?></td>
                <?php
                if ($prof_inv_det['header1'] != '') {
                    
                echo '<td align="center">'.$prof_inv_det['header1'].'</td>';
                }else{
                }
                if ($prof_inv_det['header2'] != '') {
                    
                echo '<td align="center">'.$prof_inv_det['header2'].'</td>';
                }else{
                }
                if ($prof_inv_det['header3'] != '') {
                    
                echo '<td align="center">'.$prof_inv_det['header3'].'</td>';
                }else{
                }

            ?>
                <td align='right'><?= $prof_inv_det['amount']; ?></td>
                <td align='right'><?= $prof_inv_det['rate']; ?></td>
                <td align='right' style="width: 100px"><?= $prof_inv_det['amount2']; ?></td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <?php
            $my_tot1 =  $data_debit_note['data1'] + $data_debit_note['data2'] + $data_debit_note['data3'] + 6;
                  
                echo '<td style="text-align: center;height: 10px" colspan="'.$my_tot1.'"></td>';
                ?>
            
        </tr>

        <tr>
            <?php
            $my_tot1 =  $data_debit_note['data1'] + $data_debit_note['data2'] + $data_debit_note['data3'] + 5;
                  
                echo '<td style="text-align: center" colspan="'.$my_tot1.'"><b>Grand Total</b></td>';
                ?>
        
            <td align='right'><?= $data_debit_note['eqv_curr'];; ?></td>
        </tr>
        <!-- <tr>
            <td colspan="5">Discount</td>
            <td align='right'><?= number_format($data_proforma_diskon_cbd['diskon'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="5">Total Without Tax</td>
            <td align='right'><?= number_format($data_proforma_invoice_grandtotal_cbd['twot'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="5">Tax</td>
            <td align='right'><?= number_format($data_proforma_invoice_grandtotal_cbd['ppn'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="5">Grand Total</td>
            <td align='right'><?= number_format($data_proforma_invoice_grandtotal_cbd['total'], 2); ?></td>
        </tr> -->

    </table>

    <br />

    <!-- <table style="font-size:10px;" border="0">
        <tr>
            <td style="text-align:right">Bank</td>
            <td>:</td>
            <td>No Rek : <?= $data_proforma_invoice_cbd['no_rek']; ?></td>
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
            <td><?= $data_proforma_invoice_cbd['nama_bank']; ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?= $data_proforma_invoice_cbd['v_bankaddress']; ?></td>
        </tr>
    </table> -->

    <br />
    <br />
    <br />
    <br />
    <br />
    <br />

    <!-- <div style="margin-bottom: 2.54cm;"> -->
    <div style="margin-bottom: 2.54cm; page-break-inside: avoid;">
        <table style="page-break-inside: avoid;" cellpadding="0" cellspacing="0" border="1" width="600px">
            <tr >
                <td style="font-size: 11px; width: 280px;border-bottom: none;">Please T/T The Payment To: </td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="font-size: 11px; width: 200px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
            </tr>
            <tr style="font-size:12px;">
                <td style="font-size:12px;border-bottom: none;border-top: none;" ><b>Account Name:</b> <?= $data_debit_note['beneficiary_name']; ?></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;" ></td>
            </tr>
            <tr style="font-size:12px;">
                <td style="font-size:12px;border-bottom: none;border-top: none;"><b>Banker:</b> <?= $data_debit_note['bank_name']; ?></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
            </tr>
            <tr style="font-size:12px;">
                <td style="font-size:12px;border-bottom: none;border-top: none;"><b>Bank Adress:</b> <?= $data_debit_note['beneficiary_address']; ?></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"> </td>
            </tr>
            <tr style="font-size:12px;">
                <td style="font-size:12px;border-bottom: none;border-top: none;"><b>Account Number:</b> <?= $data_debit_note['bank_account']; ?></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"> </td>
            </tr>
            <tr style="border-bottom: none;border-top: none; font-size:12px;">
                <td style="font-size:12px;border-bottom: none;border-top: none;"><b>Swift Code:</b> <?= $data_debit_note['swift_code']; ?></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;text-align:center;text-decoration:underline;"><?= "Willy Fernandez" ?></td>
            </tr>
            <tr style="border-top: none;">
<!--                 <td style="font-size:12px;text-align:center;text-decoration:underline"> </td>			
			         <td style="font-size:12px;text-align:center">(________________________) </td>
			         <td style="font-size:12px;text-align:center">(________________________) </td> -->
                 <td style="font-size:11px;border-top: none;">Please pay at full net Amount</td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="font-size:12px;text-align:center;border-top: none;border-bottom: none;border-right: none;border-left: none;">Finance Accounting Manager</td>
            </tr>
            <tr>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
                <td style="text-align:center;font-size:12px;border-top: none;border-bottom: none;border-right: none;border-left: none;"></td>
            </tr>
        </table> 
        <br />

        <!-- <table style="page-break-inside: avoid; font-size:10px;" border="0">
            <tr>
                <td style="font-weight: bold">NOTE :</td>
            </tr>
            <tr>
                <td>INVOICE NUMBER : <?= $data_proforma_invoice_cbd['no_pi']; ?></td>
            </tr>
            <tr>
                <td>GRAND TOTAL : <?= $data_proforma_invoice_total_cbd['curr']; ?> <?= number_format($data_proforma_invoice_grandtotal_cbd['total'], 2); ?></td>
            </tr>
        </table> -->

    </div>