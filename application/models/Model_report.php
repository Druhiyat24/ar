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
        $str = " AND b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND (a.status = 'POST' OR a.status = 'APPROVED')  ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }else{
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status = 'APPROVED') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }

    $hasil = $this->db->query("(SELECT b.id,c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
      b.shipp_number as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.ws AS material,b.styleno, concat(b.product_item, ' ', '(',b.size,')') as produk,
      b.qty, b.qty qty_ship, b.uom, b.uom uom_ship, FORMAT(b.unit_price, 2) AS unit_price, FORMAT(b.unit_price, 2) AS unit_price_ship,             
      a.shipp AS type_,  d.type AS inv_type, '' AS order_type, b.curr,
      FORMAT(b.total_price, 2) AS total_price, FORMAT(b.total_price, 2) AS total_price_ship, if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1) as rate, FORMAT(b.total_price * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2, FORMAT(b.total_price * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2_ship,a.type_so,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur
      FROM tbl_book_invoice AS a INNER JOIN 
      tbl_invoice_detail AS b ON a.id = b.id_book_invoice INNER JOIN      
      mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
      tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
      tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
      tbl_master_top AS f ON a.id_top = f.id 
            WHERE a.profit_center = 'NAG' $str GROUP BY b.id ORDER BY a.no_invoice asc) union

(SELECT b.id,c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
      b.shipp_number as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.ws AS material,b.styleno, concat(b.product_item, ' ', '(',b.size,')') as produk,
      b.qty, b.qty_ship, b.uom, b.uom_ship, FORMAT(b.unit_price, 2) AS unit_price, FORMAT(b.unit_price_ship, 2) AS unit_price_ship,             
      a.shipp AS type_,  d.type AS inv_type, '' AS order_type, b.curr,
      FORMAT(b.total_price, 2) AS total_price, FORMAT(b.total_price_ship, 2) AS total_price_ship, if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1) as rate, FORMAT(b.total_price * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2, FORMAT(b.total_price_ship * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2_ship,a.type_so,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur
      FROM tbl_book_invoice AS a INNER JOIN 
      tbl_invoice_detail_knitting AS b ON a.id = b.id_book_invoice INNER JOIN      
      mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
      tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
      tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN
            tbl_invoice_pot_knitting AS g ON a.id = g.id_book_invoice INNER JOIN 
      tbl_master_top AS f ON a.id_top = f.id 
            WHERE a.profit_center = 'NAK' $str GROUP BY b.id ORDER BY a.no_invoice asc) union
            
      (SELECT b.id,c.Supplier AS customer,a.no_inv as no_invoice,DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, b.no_shipp,DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date,'' AS grp,b.no_ws AS material,b.no_style, concat(b.prod_item, ' ', '(',if(b.size = '','-',b.size),')') as produk, b.qty, b.qty qty_ship, b.uom, b.uom uom_ship,  FORMAT(b.unit_price, 2) AS unit_price,  FORMAT(b.unit_price, 2) AS unit_price_ship, a.shipp AS type_,  d.type AS inv_type, '' AS order_type, b.curr, FORMAT(b.total, 2) AS total_price, FORMAT(b.total, 2) AS total_price_ship, if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1) as rate, FORMAT(b.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2, FORMAT(b.total * if(b.curr = 'USD',(select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'Pajak' and tanggal = b.sj_date limit 1),1), 2) AS total2_ship, a.type_so,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur
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


function cari_aging_jatem($id_customer, $start_date, $end_date)
{

    if($id_customer == 'All' ){
        $where = "";
    }else{
        $where = " WHERE id_customer = '$id_customer' ";
    }

    $hasil = $this->db->query("select kode_customer, '-' id_customer_show, id_customer, customer, top, sum(eqv_idr) total, sum(hasil_bln6) hasil_bln6, sum(hasil_bln5) hasil_bln5, sum(hasil_bln4) hasil_bln4, sum(hasil_bln3) hasil_bln3, sum(hasil_bln2) hasil_bln2, sum(hasil_bln1) hasil_bln1, sum(readydue) readydue, IF(sum(if(curr != 'IDR',tambah * rate,tambah)) = 0,'No Sales',round(IF(sal_awl = 0 and eqv_idr = 0,'0',(365 / ((sum(if(curr != 'IDR',tambah * rate,tambah)) * 12) / ((sum(if(curr != 'IDR', sal_awl * rate, sal_awl)) + sum(eqv_idr)) / 2)))),2)) ar_day, sum(amt_aging_0 + amt_aging_1) jatem1, sum(amt_aging_2) jatem31, sum(amt_aging_3) jatem61, sum(amt_aging_4 + amt_aging_5 + amt_aging_6 + amt_aging_7) jatem91 from (select no_invoice, kode_customer,customer, inv_date, shipp, duedate, top, curr, rate, sal_awl, tambah, bayar,  total, eqv_idr,amt_aging_0,amt_aging_1,amt_aging_2,amt_aging_3,amt_aging_4,amt_aging_5,amt_aging_6,amt_aging_7, tot_aging, readydue, hasil_bln1, hasil_bln2, hasil_bln3, hasil_bln4, hasil_bln5, hasil_bln6, tot_aging2, id_customer from (select a.*, 
        CASE WHEN jml_bln1 > 0 AND DATE(duedate) > '$end_date' THEN eqv_idr ELSE 0 END AS hasil_bln1,
        CASE WHEN jml_bln2 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln2,
        CASE WHEN jml_bln3 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln3,
        CASE WHEN jml_bln4 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln4,
        CASE WHEN jml_bln5 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln5,
        CASE WHEN jml_bln6 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln6,
        CASE WHEN total <= 0 THEN 0 WHEN DATE(duedate) <= '$end_date' THEN eqv_idr ELSE 0 END AS readydue,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top <= 0 THEN eqv_idr ELSE 0 END AS amt_aging_0,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 0 AND diff_top <= 30 THEN eqv_idr ELSE 0 END AS amt_aging_1,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 30 AND diff_top <= 60 THEN eqv_idr ELSE 0 END AS amt_aging_2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 60 AND diff_top <= 90 THEN eqv_idr ELSE 0 END AS amt_aging_3,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 90 AND diff_top <= 120 THEN eqv_idr ELSE 0 END AS amt_aging_4,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 120 AND diff_top <= 180 THEN eqv_idr ELSE 0 END AS amt_aging_5,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 180 AND diff_top <= 360 THEN eqv_idr ELSE 0 END AS amt_aging_6,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 360 THEN eqv_idr ELSE 0 END AS amt_aging_7,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging
        from (select a.*, ((sal_awl + tambah) - bayar) total, IF(curr = 'USD',((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0)) * rate,((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0))) eqv_idr from (select no_invoice, kode_customer, customer, inv_date, id_customer, curr, top, amount1, duedate, bayar, bayar2, rate, shipp, diff_top, ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, IF(inv_date >= '$start_date',0,COALESCE(amount1,0) - COALESCE(bayar2,0)) sal_awl, IF(inv_date >= '$start_date',COALESCE(amount1,0) - COALESCE(bayar2,0),0) tambah from (SELECT no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,kode_customer,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$end_date',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$end_date','%m') fil_bln1,LPAD(DATE_FORMAT('$end_date','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$end_date','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$end_date','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$end_date','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$end_date','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$end_date','%Y') fil_thn, IF(duedate <= '$end_date',amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
        FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice
        where a.sj_date between '2022-05-01' and '$end_date'
        union
        SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
        FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
        FROM  tbl_invoice_nb AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
        tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
        tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_inv
        where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$end_date'
        union                                                                     
        select no_invoice, customer, UPPER(b.supplier_code) kode_customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar a INNER JOIN mastersupplier AS b ON a.id_customer = b.id_supplier where no_invoice not like '%DN/%') inv LEFT JOIN
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$start_date' and '$end_date' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$start_date' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$end_date') != '',(SELECT rate FROM masterrate WHERE v_codecurr = (SELECT IF((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'HARIAN') is null,'PAJAK','HARIAN')) AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'HARIAN'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK')))),(SELECT rate FROM masterrate WHERE v_codecurr = 'PAJAK' AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'PAJAK'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK'))))) rate) rt) a) a) a) a) a) a WHERE sal_awl > 0 OR tambah > 0 OR bayar > 0 OR total > 0) a $where GROUP BY customer, top order by customer asc");
return $hasil->result_array();
}


function cari_mut_ar($id_customer, $start_date, $end_date)
{

    if($id_customer == 'All' ){
        $where = "";
    }else{
        $where = " WHERE id_customer = '$id_customer' ";
    }

    $hasil = $this->db->query("select kode_customer, id_customer_show, id_customer, customer, top, sum(sal_awl) sal_awl, sum(tambah) tambah, sum(tambah_ll) tambah_ll, sum(pelunasan) pelunasan, sum(retur) retur, sum(pph_23) pph_23, sum(other) other, sum(sal_akhir) sal_akhir, IF(sum(tambah) = 0,'No Sales',round(IF(sal_awl = 0 and sal_akhir = 0,'0',(365 / ((sum(tambah) * 12) / ((sum(sal_awl) + sum(sal_akhir)) / 2)))),2)) ar_day from (select kode_customer, id_customer_show, id_customer, customer, top, sal_awl, tambah, tambah_ll, pelunasan, retur, pph_23, round(others,2) other, round(sal_awl + (tambah + tambah_ll) - (pelunasan + retur + pph_23 + others),2) sal_akhir from (select kode_customer, '-' id_customer_show, id_customer, customer, top, eqv_idr, sal_awl, tambah, tambah_ll, pelunasan, retur,  - pph_23 pph_23, IF(pelunasan > 0,- ((eqv_idr) - (sal_awl + (tambah + tambah_ll) - (pelunasan + retur + (- pph_23)))),0) others from (select no_invoice, kode_customer, id_customer, customer, top,curr, if (curr = 'IDR', sal_awl, (sal_awl * rate)) sal_awl, if(curr = 'IDR', tambah, (tambah * rate_inv)) tambah, 0 tambah_ll, IF(bayar > 0,if (curr = 'IDR', (total + others), ((total + others) * rate_alk)),0) pelunasan, 0 retur, IF(bayar > 0,if(curr = 'IDR', pph, (pph * rate_alk)),0) pph_23 , eqv_idr from (select a.*, ((sal_awl + tambah) - bayar) total_ending, IF(curr = 'USD',((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0)) * rate_alk,((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0))) eqv_idr from (select no_invoice, kode_customer, customer, inv_date, id_customer, curr, top, amount1, duedate, bayar, bayar2, rate, shipp, diff_top, IF(inv_date >= '$start_date',0,COALESCE(amount1,0) - COALESCE(bayar2,0)) sal_awl, IF(inv_date >= '$start_date',COALESCE(amount1,0) - COALESCE(bayar2,0),0) tambah, grand_total, dpp, ppn, pph, total, others, COALESCE(rate_alk,0) rate_alk, IF(curr = 'IDR',1,rate_inv) rate_inv from (SELECT no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top, grand_total, dpp, ppn, pph, total, others, rate_alk, rate_inv from (SELECT no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, grand_total, dpp, ppn, pph, total, others, rate_alk, rate_inv from (SELECT no_invoice,kode_customer,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$end_date',duedate) diff_top, grand_total, dpp, ppn, pph, total, others, rate_alk, rate_inv from 
        (select a.*, round(dpp + ppn + pph,2) total, round(grand_total - round(dpp + ppn + pph,2) + pph,2) others from (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top, FORMAT((d.grand_total), 2) AS amount, round((d.grand_total), 2) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp, d.grand_total, d.total AS dpp, d.vat AS ppn, CASE WHEN a.pph = 'PPh 23' THEN - round(d.total * 0.02,2) ELSE 0 END AS pph
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice
        where a.sj_date between '2022-05-01' and '$end_date') a
        union
        select a.*, round(dpp + ppn + pph,2) total, round(grand_total - round(dpp + ppn + pph,2) + pph,2) others from (SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
        FORMAT((d.grand_total), 2) AS amount, round((d.grand_total), 2) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp, d.grand_total, d.total AS dpp, d.vat AS ppn, CASE WHEN a.pph = 'PPh 23' THEN - round(d.total * 0.02,2) ELSE 0 END AS pph
        FROM  tbl_invoice_nb AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
        tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
        tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_inv
        where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$end_date') a
        union                                                                     
        select a.*, round(dpp + ppn + pph,2) total, round(grand_total - round(dpp + ppn + pph,2) + pph,2) others from (select no_invoice, customer, UPPER(b.supplier_code) kode_customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, round((grand_total), 2) AS amount1, due_date,shipp, a.grand_total, a.grand_total AS dpp, 0 ppn, 0 pph from saldoawal_ar a INNER JOIN mastersupplier AS b ON a.id_customer = b.id_supplier where no_invoice not like '%DN/%') a) inv LEFT JOIN
        (select b.rate rate_alk, a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$start_date' and '$end_date' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$start_date' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN
        (select tanggal, rate rate_inv from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) rt_inv on rt_inv.tanggal = inv.inv_date
        JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = DATE_SUB('$start_date', INTERVAL 1 DAY)) != '',(SELECT rate FROM masterrate WHERE v_codecurr = (SELECT IF((SELECT tanggal FROM masterrate WHERE tanggal = DATE_SUB('$start_date', INTERVAL 1 DAY) AND v_codecurr = 'HARIAN') is null,'PAJAK','HARIAN')) AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = DATE_SUB('$start_date', INTERVAL 1 DAY) AND v_codecurr = 'HARIAN'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK')))),(SELECT rate FROM masterrate WHERE v_codecurr = 'PAJAK' AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = DATE_SUB('$start_date', INTERVAL 1 DAY) AND v_codecurr = 'PAJAK'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK'))))) rate) rt) a) a) a) a) a) a where round(sal_awl,0) > 0 OR tambah > 0 OR pelunasan > 0) a) a $where GROUP BY customer, top
        ");
return $hasil->result_array();
}

}
