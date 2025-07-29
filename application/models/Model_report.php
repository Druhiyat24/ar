<?php

class Model_report extends CI_Model
{

    //Sales Report
    function sales_report($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so)
    {

        if($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All' ){
            $str = " AND b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND d.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND d.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND d.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
             $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND d.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND d.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND d.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND d.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND d.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }else{
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND d.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') GROUP BY a.id, a.no_inv";
        }


        $hasil = $this->db->query("(SELECT a.no_invoice, c.Supplier AS customer, a.shipp, a.doc_type, a.doc_number,  
                                          d.type, a.type_so, a.pph, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, b.curr,
                                          FORMAT(SUM(b.qty), 2) AS qty,
                                                                                    FORMAT(SUM(b.qty), 2) AS qty_ship,
                                          FORMAT(SUM(b.unit_price), 2) AS unit_price, 
                                          FORMAT(e.total, 2) AS total, 
                                                                                    FORMAT(e.total, 2) AS total_ship, 
                                          FORMAT(e.discount, 2) AS discount, 
                                          FORMAT(e.dp, 2) AS dp, 
                                          FORMAT(e.retur, 2) AS retur, 
                                          FORMAT(e.twot, 2) AS twot, 
                                          FORMAT(e.vat, 2) AS vat, 
                                          FORMAT(e.grand_total, 2) AS grand_total, f.top,if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1) as rate, FORMAT(e.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2,  FORMAT(e.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2_ship, if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur
                                  FROM tbl_book_invoice AS a INNER JOIN 
                                          tbl_invoice_detail AS b ON a.id = b.id_book_invoice INNER JOIN      
                                          mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
                                          tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
                                          tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
                                          tbl_master_top AS f ON a.id_top = f.id 
                                          WHERE a.no_invoice like '%NAG%' $str) 
                                                                                    UNION
                                                                                    (SELECT a.no_invoice, c.Supplier AS customer, a.shipp, a.doc_type, a.doc_number,  
                                          d.type, a.type_so, a.pph, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, b.curr,
                                          FORMAT(SUM(b.qty), 2) AS qty,
                                                                                    FORMAT(SUM(b.qty_ship), 2) AS qty_ship,
                                          FORMAT(SUM(b.unit_price), 2) AS unit_price, 
                                          FORMAT(g.total, 2) AS total, 
                                                                                    FORMAT(e.total, 2) AS total_ship, 
                                          FORMAT(e.discount, 2) AS discount, 
                                          FORMAT(e.dp, 2) AS dp, 
                                          FORMAT(e.retur, 2) AS retur, 
                                          FORMAT(e.twot, 2) AS twot, 
                                          FORMAT(e.vat, 2) AS vat, 
                                          FORMAT(e.grand_total, 2) AS grand_total, f.top,if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1) as rate, FORMAT(g.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2,  FORMAT(e.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2_ship, if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur
                                  FROM tbl_book_invoice AS a INNER JOIN 
                                          tbl_invoice_detail_knitting AS b ON a.id = b.id_book_invoice INNER JOIN      
                                          mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
                                          tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
                                          tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
                                          tbl_master_top AS f ON a.id_top = f.id INNER JOIN
                                                                                    tbl_invoice_pot_knitting AS g ON a.id = g.id_book_invoice 
                                          WHERE a.no_invoice like '%NAK%' $str) 
                                                                                    UNION
                                                                                    (SELECT a.no_inv as no_invoice, c.Supplier AS customer, a.shipp, a.doc_type, a.doc_number,  
                                          a.type, a.type_so, a.pph, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, b.curr,
                                          FORMAT(SUM(b.qty), 2) AS qty,
                                                                                    FORMAT(SUM(b.qty), 2) AS qty_ship,
                                          FORMAT(SUM(b.unit_price), 2) AS unit_price, 
                                          FORMAT(e.total, 2) AS total,
                                                                                    FORMAT(e.total, 2) AS total_ship, 
                                          FORMAT(e.diskon, 2) AS discount, 
                                          FORMAT(e.dp, 2) AS dp, 
                                          FORMAT(e.retur, 2) AS retur, 
                                          FORMAT(e.twot, 2) AS twot, 
                                          FORMAT(e.vat, 2) AS vat, 
                                          FORMAT(e.grand_total, 2) AS grand_total, a.top,if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date),1) as rate, FORMAT(e.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date),1), 2) AS total2, FORMAT(e.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date),1), 2) AS total2_ship, if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur
                                  FROM tbl_invoice_nb AS a INNER JOIN 
                                          tbl_invoice_nb_detail AS b ON a.no_inv = b.no_inv INNER JOIN      
                                          mastersupplier AS c ON a.customer = c.Id_Supplier INNER JOIN 
                                          tbl_invoice_nb_pot AS e ON a.no_inv = e.no_inv INNER JOIN
                                            tbl_type as d on d.type = a.type $str2) ");
        return $hasil->result_array();
    }

    function tot_unit($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so)
    {

        if($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All' ){
            $str = " WHERE b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND (a.status = 'POST' OR a.status = 'APPROVED')  ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }else{
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        }
        $hasil = $this->db->query("SELECT FORMAT(SUM(b.qty), 2) AS qty
                                  FROM tbl_book_invoice AS a INNER JOIN 
                                       tbl_invoice_detail AS b ON a.id = b.id_book_invoice 
                                  $str ");
        return $hasil->row_array();
    }

    //Sales Report / Material
    function sales_report_material($periode_dari_mt, $periode_sampai_mt, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt)
    {

        if($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All' ){
            $str = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND (a.status = 'POST' OR a.status = 'APPROVED')  ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }else{
            $str = " WHERE  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
        }

        $hasil = $this->db->query("(SELECT b.id,c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
                                          b.shipp_number as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.ws AS material,b.styleno, concat(b.product_item, ' ', '(',b.size,')') as produk,
                                          b.qty, b.uom,  FORMAT(b.unit_price, 2) AS unit_price,             
                                          a.shipp AS type_,  d.type AS inv_type, '' AS order_type, b.curr,
                                          FORMAT(b.total_price, 2) AS total_price,if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1) as rate, FORMAT(b.total_price * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2,a.type_so,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur
                                  FROM tbl_book_invoice AS a INNER JOIN 
                                          tbl_invoice_detail AS b ON a.id = b.id_book_invoice INNER JOIN      
                                          mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
                                          tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
                                          tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
                                          tbl_master_top AS f ON a.id_top = f.id $str GROUP BY b.id ORDER BY a.no_invoice asc) union
                                                                                                                                                                                                                                
(SELECT b.id,c.Supplier AS customer,a.no_inv as no_invoice,DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, b.no_shipp,DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date,'' AS grp,b.no_ws AS material,b.no_style, concat(b.prod_item, ' ', '(',if(b.size = '','-',b.size),')') as produk, b.qty, b.uom,  FORMAT(b.unit_price, 2) AS unit_price, a.shipp AS type_,  d.type AS inv_type, '' AS order_type, b.curr,
                                          FORMAT(b.total, 2) AS total_price,if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1) as rate, FORMAT(b.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2,a.type_so,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur
                                  FROM tbl_invoice_nb AS a INNER JOIN 
                                          tbl_invoice_nb_detail AS b ON a.no_inv = b.no_inv INNER JOIN      
                                          mastersupplier AS c ON a.customer = c.Id_Supplier INNER JOIN 
                                          tbl_invoice_nb_pot AS e ON a.no_inv = e.no_inv INNER JOIN
                                            tbl_type as d on d.type = a.type $str2) ");
        return $hasil->result_array();
    }

    function tot_unit_material()
    {
        $hasil = $this->db->query("SELECT FORMAT(SUM(b.qty), 2) AS qty
                                   FROM tbl_book_invoice AS a INNER JOIN 
                                        tbl_invoice_detail AS b ON a.id = b.id_book_invoice 
                                   WHERE a.status = 'POST' ");
        return $hasil->row_array();
    }

    //Report Outstanding PI
    function report_outstanding_pi($periode_dari_pi, $periode_sampai_pi)
    {
        $hasil = $this->db->query("SELECT c.Supplier AS customer, a.no_proforma_invoice, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS tgl_proforma_inv, 
                                          a.shipp, a.type_barang, e.top, CASE WHEN a.status = 'POST' THEN DATE_ADD(DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d'), INTERVAL e.top DAY) 
                                          END AS duedate, b.curr, FORMAT(SUM(b.total_price), 2) AS total_price    
                                   FROM tbl_invoice_proforma AS a INNER JOIN 
                                          tbl_invoice_proforma_detail AS b ON a.no_proforma_invoice = b.no_invoice_proforma INNER JOIN      
                                          mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
                                          tbl_type AS d ON a.id_type = d.id_type INNER JOIN       
                                          tbl_master_top AS e ON a.id_top = e.id 
                                   WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$periode_dari_pi' AND '$periode_sampai_pi' 
                                   GROUP BY a.no_proforma_invoice");
        return $hasil->result_array();
    }
}
