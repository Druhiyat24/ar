<?php

class Model_report extends CI_Model
{

    //Sales Report
    function sales_report($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so)
    {

        if($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All' ){
            $str = " AND b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice ";
            $str2 = " WHERE b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv ";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND d.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND d.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND d.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND d.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND d.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND d.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND d.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND d.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND d.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }else{
            $str = " AND  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_invoice";
            $str2 = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.customer = '$id_customer' AND a.shipp = '$shipp' AND d.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') GROUP BY a.id, a.no_inv";
        }


        $hasil = $this->db->query("SELECT a.*, IFNULL(rate,1) rate, (total_bill * IFNULL(rate,1)) total_bill_idr, (other_bill * IFNULL(rate,1)) other_bill_idr, (diskon_bill * IFNULL(rate,1)) diskon_bill_idr, (dp_bill * IFNULL(rate,1)) dp_bill_idr, (twot_bill * IFNULL(rate,1)) twot_bill_idr, (vat_bill * IFNULL(rate,1)) vat_bill_idr, (grand_total_bill * IFNULL(rate,1)) grand_total_bill_idr, (total_ship * IFNULL(rate,1)) total_ship_idr, (other_ship * IFNULL(rate,1)) other_ship_idr, (diskon_ship * IFNULL(rate,1)) diskon_ship_idr, (dp_ship * IFNULL(rate,1)) dp_ship_idr, (twot_ship * IFNULL(rate,1)) twot_ship_idr, (vat_ship * IFNULL(rate,1)) vat_ship_idr, (grand_total_ship * IFNULL(rate,1)) grand_total_ship_idr, (twot_bill * IFNULL(rate,1)) net_sales, ((twot_bill * persen_vat/100) * IFNULL(rate,1)) vat_sales, ((twot_bill + (twot_bill * persen_vat/100)) * IFNULL(rate,1)) grand_total_sales
         from ((SELECT c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, UPPER(coa.relasi) relasi, UPPER(coa.cus_ctg) cus_ctg, pc.nama_pc, f.top, a.type_so, a.shipp, d.type, if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, SUM(b.qty) qty_bill, e.total total_bill, 0 other_bill, e.discount diskon_bill, e.dp dp_bill, (e.total - e.discount) twot_bill, e.vat vat_bill, e.grand_total grand_total_bill, SUM(b.qty) qty_ship, e.total total_ship, 0 other_ship, e.discount diskon_ship, e.dp dp_ship, (e.total - e.discount) twot_ship, e.vat vat_ship, e.grand_total grand_total_ship, ROUND((e.vat/e.twot) * 100,0) persen_vat
             FROM tbl_book_invoice AS a INNER JOIN 
             tbl_invoice_detail AS b ON a.id = b.id_book_invoice INNER JOIN      
             mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
             tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
             tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
             tbl_master_top AS f ON a.id_top = f.id LEFT JOIN
             mastercoa_v2 coa on coa.no_coa = a.no_coa LEFT JOIN
             master_pc pc on pc.kode_pc = a.profit_center
             WHERE a.profit_center = 'NAG' $str)       
         UNION
         (SELECT c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, UPPER(coa.relasi) relasi, UPPER(coa.cus_ctg) cus_ctg, pc.nama_pc, f.top, a.type_so, a.shipp, d.type, if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, SUM(b.qty) qty_bill, g.total total_bill, g.total_other other_bill, g.discount diskon_bill, g.dp dp_bill, (g.total + g.total_other - g.discount) twot_bill, g.vat vat_bill, g.grand_total grand_total_bill, SUM(b.qty_ship) qty_ship, e.total total_ship, 0 other_ship, e.discount diskon_ship, e.dp dp_ship, (e.total - e.discount) twot_ship, e.vat vat_ship, e.grand_total grand_total_ship, ROUND((e.vat/e.twot) * 100,0) persen_vat
             FROM tbl_book_invoice AS a INNER JOIN 
             tbl_invoice_detail_knitting AS b ON a.id = b.id_book_invoice INNER JOIN      
             mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
             tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
             tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
             tbl_master_top AS f ON a.id_top = f.id INNER JOIN
             tbl_invoice_pot_knitting AS g ON a.id = g.id_book_invoice LEFT JOIN
             mastercoa_v2 coa on coa.no_coa = a.no_coa LEFT JOIN
             master_pc pc on pc.kode_pc = a.profit_center
             WHERE a.profit_center = 'NAK' $str)
         UNION
         (SELECT c.Supplier AS customer, a.no_inv, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, UPPER(coa.relasi) relasi, UPPER(coa.cus_ctg) cus_ctg, 'NIRWANA ALABARE GARMENT' nama_pc, a.top, a.type_so, a.shipp, a.type, if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, SUM(b.qty) qty_bill, e.total total_bill, 0 other_bill, e.diskon diskon_bill, e.dp dp_bill, (e.total - e.diskon) twot_bill, e.vat vat_bill, e.grand_total grand_total_bill, SUM(b.qty) qty_ship, e.total total_ship, 0 other_ship, e.diskon diskon_ship, e.dp dp_ship, (e.total - e.diskon) twot_ship, e.vat vat_ship, e.grand_total grand_total_ship, ROUND((e.vat/e.twot) * 100,0) persen_vat
             FROM tbl_invoice_nb AS a INNER JOIN 
             tbl_invoice_nb_detail AS b ON a.no_inv = b.no_inv INNER JOIN      
             mastersupplier AS c ON a.customer = c.Id_Supplier INNER JOIN 
             tbl_invoice_nb_pot AS e ON a.no_inv = e.no_inv INNER JOIN
             tbl_type as d on d.type = a.type LEFT JOIN
             mastercoa_v2 coa on coa.no_coa = a.no_coa $str2)) a left join (select tanggal, curr, rate FROM masterrate where v_codecurr = 'Pajak' GROUP BY tanggal, curr) b on b.curr= a.curr AND b.tanggal = a.tgl_inv");
return $hasil->result_array();
}

function tot_unit($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so)
{

    if($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All' ){
        $str = " WHERE b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND (a.status = 'POST' OR a.status like '%APPROVED%')  ";
    }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr == 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp == 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.type_so = '$type_so' AND a.id_type = '$type' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so == 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp != 'All' and $type != 'All' and $curr == 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp != 'All' and $type == 'All' and $curr != 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer != 'All' and $shipp == 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }elseif($id_customer == 'All' and $shipp != 'All' and $type != 'All' and $curr != 'All' and $type_so != 'All'){
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
    }else{
        $str = " WHERE  b.sj_date BETWEEN '$periode_dari' AND '$periode_sampai' AND a.id_customer = '$id_customer' AND a.shipp = '$shipp' AND a.id_type = '$type' AND b.curr = '$curr' AND a.type_so = '$type_so' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
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
        $str = " AND b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%')  ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }else{
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }

    $hasil = $this->db->query("SELECT a.*, IFNULL(rate,1) rate, (total_bill * IFNULL(rate,1)) total_bill_idr, (total_ship * IFNULL(rate,1)) total_ship_idr FROM ((SELECT b.id,c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
      b.shipp_number as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.ws ,b.styleno, concat(b.product_item, ' ', '(',b.size,')') as produk, a.type_so, a.shipp ,  d.type AS inv_type,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, b.qty qty_bill, b.uom uom_bill, b.unit_price price_bill, b.total_price total_bill, b.qty qty_ship, b.uom uom_ship, b.unit_price price_ship, b.total_price total_ship
      FROM tbl_book_invoice AS a INNER JOIN 
      tbl_invoice_detail AS b ON a.id = b.id_book_invoice INNER JOIN      
      mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
      tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
      tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
      tbl_master_top AS f ON a.id_top = f.id 
      WHERE a.profit_center = 'NAG' $str GROUP BY b.id ORDER BY a.no_invoice asc)
    UNION
    (SELECT b.id,c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
      b.shipp_number as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.ws ,b.styleno, concat(b.product_item, ' ', '(',b.size,')') as produk, a.type_so, a.shipp ,  d.type AS inv_type,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, b.qty qty_bill, b.uom uom_bill, b.unit_price price_bill, b.total_price total_bill, b.qty_ship qty_ship, b.uom_ship uom_ship, b.unit_price_ship price_ship, b.total_price_ship total_ship
      FROM tbl_book_invoice AS a INNER JOIN 
      tbl_invoice_detail_knitting AS b ON a.id = b.id_book_invoice INNER JOIN      
      mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
      tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
      tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
      tbl_master_top AS f ON a.id_top = f.id 
      WHERE a.profit_center = 'NAK' $str GROUP BY b.id ORDER BY a.no_invoice asc)   
    UNION
    (SELECT b.id,c.Supplier AS customer, a.no_inv, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
      b.no_shipp as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.no_ws ,b.no_style, concat(b.prod_item, ' ', '(',b.size,')') as produk, a.type_so, a.shipp, d.type AS inv_type,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, b.qty qty_bill, b.uom uom_bill, b.unit_price price_bill, b.total total_bill, b.qty qty_ship, b.uom uom_ship, b.unit_price price_ship, b.total total_ship
      FROM tbl_invoice_nb AS a INNER JOIN 
      tbl_invoice_nb_detail AS b ON a.no_inv = b.no_inv INNER JOIN      
      mastersupplier AS c ON a.customer = c.Id_Supplier INNER JOIN 
      tbl_invoice_nb_pot AS e ON a.no_inv = e.no_inv INNER JOIN
      tbl_type as d on d.type = a.type $str2)) a left join (select tanggal, curr, rate FROM masterrate where v_codecurr = 'Pajak' GROUP BY tanggal, curr) b on b.curr= a.curr AND b.tanggal = a.tgl_inv ");
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
        $where = " AND id_customer = '$id_customer' ";
    }

    $hasil = $this->db->query("select kode_customer, '-' id_customer_show, id_customer, customer, top, sum(eqv_idr) total, sum(if(ym_inv_date <= ym_filter6, eqv_idr, 0)) hasil_bln6, sum(if(ym_inv_date = ym_filter5, eqv_idr, 0)) hasil_bln5, sum(if(ym_inv_date = ym_filter4, eqv_idr, 0)) hasil_bln4, sum(if(ym_inv_date = ym_filter3, eqv_idr, 0)) hasil_bln3, sum(if(ym_inv_date = ym_filter2, eqv_idr, 0)) hasil_bln2, sum(if(ym_inv_date = ym_filter1, eqv_idr, 0)) hasil_bln1, sum(if(ym_inv_date = ym_filter0, eqv_idr, 0)) readydue, IF(sum(if(curr != 'IDR',tambah * rate,tambah)) = 0,'No Sales',round(IF(sal_awl = 0 and eqv_idr = 0,'0',(365 / ((sum(if(curr != 'IDR',tambah * rate,tambah)) * 12) / ((sum(if(curr != 'IDR', sal_awl * rate, sal_awl)) + sum(eqv_idr)) / 2)))),2)) ar_day, sum(jatuh_tempo_1) jatem1, sum(jatuh_tempo_2) jatem31, sum(jatuh_tempo_3) jatem61, sum(jatuh_tempo_4) jatem91 from (select DATE_FORMAT(inv_date,'%y%m') ym_inv_date,DATE_FORMAT(duedate,'%y%m') ym_duedate, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 0 MONTH), '%y%m') AS ym_filter0, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 1 MONTH), '%y%m') ym_filter1, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 2 MONTH), '%y%m') ym_filter2, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 3 MONTH), '%y%m') ym_filter3, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 4 MONTH), '%y%m') ym_filter4, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 5 MONTH), '%y%m') ym_filter5, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 6 MONTH), '%y%m') ym_filter6, id_customer, kode_customer, customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awl, tambah, bayar,  total, eqv_idr,amt_aging_0,amt_aging_1,amt_aging_2,amt_aging_3,amt_aging_4,amt_aging_5,amt_aging_6,amt_aging_7, tot_aging, readydue, hasil_bln1, hasil_bln2, hasil_bln3, hasil_bln4, hasil_bln5, hasil_bln6, tot_aging tot_jatem, jatuh_tempo_1, jatuh_tempo_2, jatuh_tempo_3, jatuh_tempo_4 from (select a.*, CASE WHEN jml_bln1 > 0 AND Date(duedate) > '$end_date' THEN eqv_idr ELSE 0 END AS hasil_bln1,
        CASE WHEN jml_bln2 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln2,
        CASE WHEN jml_bln3 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln3,
        CASE WHEN jml_bln4 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln4,
        CASE WHEN jml_bln5 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln5,
        CASE WHEN jml_bln6 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln6,
        CASE WHEN total <= 0 THEN 0 WHEN Date(duedate) <= '$end_date' THEN eqv_idr ELSE 0 END AS readydue,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top <= 0 THEN eqv_idr ELSE 0 END AS amt_aging_0,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 0  AND diff_top <= 30  THEN eqv_idr ELSE 0 END AS amt_aging_1,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 30 AND diff_top <= 60  THEN eqv_idr ELSE 0 END AS amt_aging_2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 60 AND diff_top <= 90  THEN eqv_idr ELSE 0 END AS amt_aging_3,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 90 AND diff_top <= 120 THEN eqv_idr ELSE 0 END AS amt_aging_4,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 120 AND diff_top <= 180 THEN eqv_idr ELSE 0 END AS amt_aging_5,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 180 AND diff_top <= 360 THEN eqv_idr ELSE 0 END AS amt_aging_6,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 360 THEN eqv_idr ELSE 0 END AS amt_aging_7,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging,
        CASE WHEN total <= 0 THEN 0 WHEN duedate_int <= 30 THEN eqv_idr ELSE 0 END AS jatuh_tempo_1,
        CASE WHEN total <= 0 THEN 0 WHEN duedate_int > 30 AND duedate_int <= 60 THEN eqv_idr ELSE 0 END AS jatuh_tempo_2,
        CASE WHEN total <= 0 THEN 0 WHEN duedate_int > 60 AND duedate_int <= 90 THEN eqv_idr ELSE 0 END AS jatuh_tempo_3,
        CASE WHEN total <= 0 THEN 0 WHEN duedate_int > 90 THEN eqv_idr ELSE 0 END AS jatuh_tempo_4
        from (select a.*, ((sal_awl + tambah) - bayar) total, IF(curr = 'USD',((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0)) * rate,((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0))) eqv_idr from (select no_invoice, kode_customer, customer, inv_date, id_customer, curr, top, amount1, duedate, bayar, bayar2, rate, shipp, diff_top, duedate_int, ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, IF(inv_date >= '$start_date',0,COALESCE(amount1,0) - COALESCE(bayar2,0)) sal_awl, IF(inv_date >= '$start_date',COALESCE(amount1,0) - COALESCE(bayar2,0),0) tambah from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top, duedate_int, ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, duedate_int, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT profit_center, no_invoice,kode_customer,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,CASE WHEN bayar > 0 AND profit_center = 'NAK' THEN amount1 ELSE bayar END bayar,no_invoice2, CASE WHEN bayar2 > 0 AND profit_center = 'NAK' THEN amount1 ELSE bayar2 END bayar2,rate,shipp,DATEDIFF('$end_date',duedate) diff_top,DATEDIFF(duedate,'$end_date') duedate_int, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$end_date','%m') fil_bln1,LPAD(DATE_FORMAT('$end_date','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$end_date','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$end_date','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$end_date','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$end_date','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$end_date','%Y') fil_thn, IF(duedate <= '$end_date',amount1,0) ready_due from 
        (SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
        FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice
        where a.sj_date between '2022-05-01' and '$end_date' and a.profit_center = 'NAG'
        UNION
        SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
        FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice
        where a.sj_date between '2022-05-01' and '$end_date' and a.profit_center = 'NAK'
        UNION
        SELECT distinct 'NAG' profit_center, a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
        FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
        FROM  tbl_invoice_nb AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
        tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
        tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_inv
        where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$end_date'
        union                                                                     
        select 'NAG' profit_center, no_invoice, customer, UPPER(b.supplier_code) kode_customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar a INNER JOIN mastersupplier AS b ON a.id_customer = b.id_supplier where no_invoice not like '%DN/%') inv LEFT JOIN
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$start_date' and '$end_date' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$start_date' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$end_date') != '',(SELECT rate FROM masterrate WHERE v_codecurr = (SELECT IF((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'HARIAN' AND curr = 'USD') is null,'PAJAK','HARIAN')) AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'HARIAN' AND curr = 'USD'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD')))),(SELECT rate FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD' AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'PAJAK' AND curr = 'USD'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD'))))) rate) rt) a) a) a) a) a) a WHERE sal_awl > 0 OR tambah > 0 OR bayar > 0 OR total > 0) a WHERE total > 0 $where GROUP BY customer, top order by customer asc");
return $hasil->result_array();
}


function cari_mut_ar($id_customer, $start_date, $end_date)
{

    if($id_customer == 'All' ){
        $where = "";
    }else{
        $where = " WHERE a.id_customer = '$id_customer' ";
    }

    $hasil = $this->db->query("select a.kode_customer, a.id_customer_show, a.id_customer, a.customer, a.top, round(a.sal_awl,2) sal_awl, a.tambah, a.tambah_ll, COALESCE(d.pelunasan,0) pelunasan, a.retur, COALESCE(c.pph_23,0) pph_23, - (b.total - (round(a.sal_awl,2) + a.tambah + a.tambah_ll) + (COALESCE(d.pelunasan,0) + a.retur + COALESCE(c.pph_23,0))) other, b.total sal_akhir, b.ar_day from (select kode_customer, id_customer_show, id_customer, customer, top, sum(sal_awl) sal_awl, sum(tambah) tambah, sum(tambah_ll) tambah_ll, sum(pelunasan) pelunasan, sum(retur) retur, sum(pph_23) pph_23, sum(other) other, sum(sal_akhir) sal_akhir, IF(sum(tambah) = 0,'No Sales',round(IF(sal_awl = 0 and sal_akhir = 0,'0',(365 / ((sum(tambah) * 12) / ((sum(sal_awl) + sum(sal_akhir)) / 2)))),4)) ar_day from (select kode_customer, id_customer_show, id_customer, customer, top, sal_awl, tambah, tambah_ll, pelunasan, retur, pph_23, round(others,4) other, round(sal_awl + (tambah + tambah_ll) - (pelunasan + retur + pph_23 + others),4) sal_akhir from (select kode_customer, '-' id_customer_show, id_customer, customer, top, eqv_idr, sal_awl, tambah, tambah_ll, pelunasan, retur,  - pph_23 pph_23, IF(pelunasan > 0,- ((eqv_idr) - (sal_awl + (tambah + tambah_ll) - (pelunasan + retur + (- pph_23)))),0) others from (select no_invoice, kode_customer, id_customer, customer, top,curr, if (curr = 'IDR', sal_awl, (sal_awl * rate)) sal_awl, if(curr = 'IDR', tambah, (tambah * rate_inv)) tambah, if(curr = 'IDR', tambah_ll, (tambah_ll * rate_inv)) tambah_ll, IF(bayar > 0,if (curr = 'IDR', (total + others), ((total + others) * rate_alk)),0) pelunasan, 0 retur, IF(bayar > 0,if(curr = 'IDR', pph, (pph * rate_alk)),0) pph_23 , eqv_idr from (select a.*, ((sal_awl + tambah) - bayar) total_ending, IF(curr = 'USD',((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0)) * rate_alk,((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0))) eqv_idr from (select no_invoice, kode_customer, customer, inv_date, id_customer, curr, top, amount1, duedate, bayar, bayar2, rate, shipp, diff_top, IF(inv_date >= '$start_date',0,COALESCE(amount1,0) - COALESCE(bayar2,0)) sal_awl, IF(inv_date >= '$start_date',COALESCE(total_netsales,0) - COALESCE(bayar2,0),0) tambah, grand_total, dpp, ppn, pph, total, others, COALESCE(rate_alk,0) rate_alk, IF(curr = 'IDR',1,rate_inv) rate_inv, IF(inv_date >= '$start_date',COALESCE(tambah_ll,0),0) tambah_ll from (SELECT no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top, grand_total, dpp, ppn, pph, total, others, rate_alk, rate_inv, total_netsales, tambah_ll from (SELECT no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, grand_total, dpp, ppn, pph, total, others, rate_alk, rate_inv, total_netsales, tambah_ll from (SELECT no_invoice,kode_customer,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$end_date',duedate) diff_top, grand_total, dpp, ppn, pph, total, others, rate_alk, rate_inv, total_netsales, tambah_ll from 
        (select a.*, round(dpp + ppn_dpp + pph,4) total, round(dpp + ppn_dpp - (discount + ppn_discount),4) total_netsales, round(grand_total - round(dpp + ppn_dpp + pph,4) + pph,4) others from (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top, FORMAT((d.grand_total),4) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp, d.grand_total, d.total AS dpp, d.vat AS ppn, ROUND((d.vat/d.twot) * 100,0) ppn_int, CASE WHEN a.pph = 'PPh 23' THEN - round(d.total * 0.02,4) ELSE 0 END AS pph, d.dp, d.discount, ROUND(IF(d.vat != 0,(d.total * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_dpp, ROUND(IF(d.vat != 0,(d.dp * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_dp, ROUND(IF(d.vat != 0,(d.discount * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_discount, 0 tambah_ll
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice
        where a.sj_date between '2022-05-01' and '$end_date' and a.profit_center = 'NAG'
        UNION
        SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top, FORMAT((d.grand_total),4) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp, d.grand_total, d.total AS dpp, d.vat AS ppn, ROUND((d.vat/d.twot) * 100,0) ppn_int, CASE WHEN a.pph = 'PPh 23' THEN - round(d.total * 0.02,4) ELSE 0 END AS pph, d.dp, d.discount, ROUND(IF(d.vat != 0,(d.total * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_dpp, ROUND(IF(d.vat != 0,(d.dp * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_dp, ROUND(IF(d.vat != 0,(d.discount * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_discount, d.total_other tambah_ll
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice
        where a.sj_date between '2022-05-01' and '$end_date' and a.profit_center = 'NAK'
        
        ) a
        union
        select a.*, round(dpp + ppn_dpp + pph,4) total, round(dpp + ppn_dpp - (discount + ppn_discount),4) total_netsales, round(grand_total - round(dpp + ppn_dpp + pph,4) + pph,4) others from (SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
        FORMAT((d.grand_total),4) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp, d.grand_total, d.total AS dpp, d.vat AS ppn, ROUND((d.vat/d.twot) * 100,0) ppn_int, CASE WHEN a.pph = 'PPh 23' THEN - round(d.total * 0.02,4) ELSE 0 END AS pph, d.dp, d.diskon discount, ROUND(IF(d.vat != 0,(d.total * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_dpp, ROUND(IF(d.vat != 0,(d.dp * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_dp, ROUND(IF(d.vat != 0,(d.diskon * (ROUND((d.vat / d.twot) * 100, 0) / 100)),0),4) AS ppn_discount, 0 tambah_ll
        FROM  tbl_invoice_nb AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
        tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
        tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_inv
        where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$end_date') a
        union                                                                     
        select a.*, round(dpp + ppn + pph,4) total, round(dpp + ppn,4) total_netsales, round(grand_total - round(dpp + ppn + pph,4) + pph,4) others from (select no_invoice, customer, UPPER(b.supplier_code) kode_customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total),4) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp, a.grand_total, a.grand_total AS dpp, 0 ppn, 0 ppn_int, 0 pph, 0 dp, 0 discount, 0 ppn_dpp, 0 ppn_dp, 0 ppn_discount, 0 tambah_ll from saldoawal_ar a INNER JOIN mastersupplier AS b ON a.id_customer = b.id_supplier where no_invoice not like '%DN/%') a) inv LEFT JOIN
        (select b.rate rate_alk, a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$start_date' and '$end_date' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$start_date' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN
        (select tanggal, rate rate_inv from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) rt_inv on rt_inv.tanggal = inv.inv_date
        JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = DATE_SUB('$start_date', INTERVAL 1 DAY)) != '',(SELECT rate FROM masterrate WHERE v_codecurr = (SELECT IF((SELECT tanggal FROM masterrate WHERE tanggal = DATE_SUB('$start_date', INTERVAL 1 DAY) AND v_codecurr = 'HARIAN' AND curr = 'USD') is null,'PAJAK','HARIAN')) AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = DATE_SUB('$start_date', INTERVAL 1 DAY) AND v_codecurr = 'HARIAN' AND curr = 'USD'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD')))),(SELECT rate FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD' AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = DATE_SUB('$start_date', INTERVAL 1 DAY) AND v_codecurr = 'PAJAK' AND curr = 'USD'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD'))))) rate) rt) a) a) a) a) a) a where round(sal_awl,0) > 0 OR tambah > 0 OR pelunasan > 0) a) a GROUP BY customer, top) a INNER JOIN
        (select kode_customer, '-' id_customer_show, id_customer, customer, top, sum(eqv_idr) total, sum(if(ym_inv_date <= ym_filter6, eqv_idr, 0)) hasil_bln6, sum(if(ym_inv_date = ym_filter5, eqv_idr, 0)) hasil_bln5, sum(if(ym_inv_date = ym_filter4, eqv_idr, 0)) hasil_bln4, sum(if(ym_inv_date = ym_filter3, eqv_idr, 0)) hasil_bln3, sum(if(ym_inv_date = ym_filter2, eqv_idr, 0)) hasil_bln2, sum(if(ym_inv_date = ym_filter1, eqv_idr, 0)) hasil_bln1, sum(if(ym_inv_date = ym_filter0, eqv_idr, 0)) readydue, IF(sum(if(curr != 'IDR',tambah * rate,tambah)) = 0,'No Sales',round(IF(sal_awl = 0 and eqv_idr = 0,'0',(365 / ((sum(if(curr != 'IDR',tambah * rate,tambah)) * 12) / ((sum(if(curr != 'IDR', sal_awl * rate, sal_awl)) + sum(eqv_idr)) / 2)))),2)) ar_day, sum(jatuh_tempo_1) jatem1, sum(jatuh_tempo_2) jatem31, sum(jatuh_tempo_3) jatem61, sum(jatuh_tempo_4) jatem91 from (select DATE_FORMAT(inv_date,'%y%m') ym_inv_date,DATE_FORMAT(duedate,'%y%m') ym_duedate, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 0 MONTH), '%y%m') AS ym_filter0, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 1 MONTH), '%y%m') ym_filter1, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 2 MONTH), '%y%m') ym_filter2, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 3 MONTH), '%y%m') ym_filter3, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 4 MONTH), '%y%m') ym_filter4, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 5 MONTH), '%y%m') ym_filter5, DATE_FORMAT(DATE_SUB('$end_date', INTERVAL 6 MONTH), '%y%m') ym_filter6, id_customer, kode_customer, customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awl, tambah, bayar,  total, eqv_idr,amt_aging_0,amt_aging_1,amt_aging_2,amt_aging_3,amt_aging_4,amt_aging_5,amt_aging_6,amt_aging_7, tot_aging, readydue, hasil_bln1, hasil_bln2, hasil_bln3, hasil_bln4, hasil_bln5, hasil_bln6, tot_aging tot_jatem, jatuh_tempo_1, jatuh_tempo_2, jatuh_tempo_3, jatuh_tempo_4 from (select a.*, CASE WHEN jml_bln1 > 0 AND Date(duedate) > '$end_date' THEN eqv_idr ELSE 0 END AS hasil_bln1,
        CASE WHEN jml_bln2 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln2,
        CASE WHEN jml_bln3 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln3,
        CASE WHEN jml_bln4 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln4,
        CASE WHEN jml_bln5 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln5,
        CASE WHEN jml_bln6 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln6,
        CASE WHEN total <= 0 THEN 0 WHEN Date(duedate) <= '$end_date' THEN eqv_idr ELSE 0 END AS readydue,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top <= 0 THEN eqv_idr ELSE 0 END AS amt_aging_0,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 0  AND diff_top <= 30  THEN eqv_idr ELSE 0 END AS amt_aging_1,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 30 AND diff_top <= 60  THEN eqv_idr ELSE 0 END AS amt_aging_2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 60 AND diff_top <= 90  THEN eqv_idr ELSE 0 END AS amt_aging_3,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 90 AND diff_top <= 120 THEN eqv_idr ELSE 0 END AS amt_aging_4,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 120 AND diff_top <= 180 THEN eqv_idr ELSE 0 END AS amt_aging_5,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 180 AND diff_top <= 360 THEN eqv_idr ELSE 0 END AS amt_aging_6,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 360 THEN eqv_idr ELSE 0 END AS amt_aging_7,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging,
        CASE WHEN total <= 0 THEN 0 WHEN duedate_int <= 30 THEN eqv_idr ELSE 0 END AS jatuh_tempo_1,
        CASE WHEN total <= 0 THEN 0 WHEN duedate_int > 30 AND duedate_int <= 60 THEN eqv_idr ELSE 0 END AS jatuh_tempo_2,
        CASE WHEN total <= 0 THEN 0 WHEN duedate_int > 60 AND duedate_int <= 90 THEN eqv_idr ELSE 0 END AS jatuh_tempo_3,
        CASE WHEN total <= 0 THEN 0 WHEN duedate_int > 90 THEN eqv_idr ELSE 0 END AS jatuh_tempo_4
        from (select a.*, ((sal_awl + tambah) - bayar) total, IF(curr = 'USD',((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0)) * rate,((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0))) eqv_idr from (select no_invoice, kode_customer, customer, inv_date, id_customer, curr, top, amount1, duedate, bayar, bayar2, rate, shipp, diff_top, duedate_int, ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, IF(inv_date >= '$start_date',0,COALESCE(amount1,0) - COALESCE(bayar2,0)) sal_awl, IF(inv_date >= '$start_date',COALESCE(amount1,0) - COALESCE(bayar2,0),0) tambah from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top, duedate_int, ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, duedate_int, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT profit_center, no_invoice,kode_customer,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,CASE WHEN bayar > 0 AND profit_center = 'NAK' THEN amount1 ELSE bayar END bayar,no_invoice2, CASE WHEN bayar2 > 0 AND profit_center = 'NAK' THEN amount1 ELSE bayar2 END bayar2,rate,shipp,DATEDIFF('$end_date',duedate) diff_top,DATEDIFF(duedate,'$end_date') duedate_int, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$end_date','%m') fil_bln1,LPAD(DATE_FORMAT('$end_date','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$end_date','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$end_date','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$end_date','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$end_date','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$end_date','%Y') fil_thn, IF(duedate <= '$end_date',amount1,0) ready_due from 
        (SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
        FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice
        where a.sj_date between '2022-05-01' and '$end_date' and a.profit_center = 'NAG'
        UNION
        SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
        FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice
        where a.sj_date between '2022-05-01' and '$end_date' and a.profit_center = 'NAK'
        UNION
        SELECT distinct 'NAG' profit_center, a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
        FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
        FROM  tbl_invoice_nb AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
        tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
        tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_inv
        where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$end_date'
        union                                                                     
        select 'NAG' profit_center, no_invoice, customer, UPPER(b.supplier_code) kode_customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar a INNER JOIN mastersupplier AS b ON a.id_customer = b.id_supplier where no_invoice not like '%DN/%') inv LEFT JOIN
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$start_date' and '$end_date' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$start_date' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$end_date') != '',(SELECT rate FROM masterrate WHERE v_codecurr = (SELECT IF((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'HARIAN' AND curr = 'USD') is null,'PAJAK','HARIAN')) AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'HARIAN' AND curr = 'USD'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD')))),(SELECT rate FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD' AND tanggal = (SELECT IFNULL((SELECT tanggal FROM masterrate WHERE tanggal = '$end_date' AND v_codecurr = 'PAJAK' AND curr = 'USD'),(SELECT MAX(tanggal) FROM masterrate WHERE v_codecurr = 'PAJAK' AND curr = 'USD'))))) rate) rt) a) a) a) a) a) a WHERE sal_awl > 0 OR tambah > 0 OR bayar > 0 OR total > 0) a  GROUP BY customer, top order by customer asc) b on b.id_customer = a.id_customer LEFT JOIN
        (select id_supplier, buyer, sum(debit_idr - credit_idr) pph_23 from tbl_list_journal a INNER JOIN (select * from mastersupplier where tipe_sup = 'C') b on b.supplier = a.buyer where tgl_journal BETWEEN '$start_date' and '$end_date' and type_journal = 'Alokasi' and no_coa = '1.52.02' GROUP BY buyer) c on c.id_supplier = a.id_customer LEFT JOIN
        (select id_supplier, supplier, SUM(amount_idr) pelunasan from (select d.id_supplier,d.supplier, c.no_coa, c.nama_coa, b.no_ref, a.curr, a.rate, b.amount, (b.amount * a.rate) amount_idr from tbl_alokasi a INNER JOIN tbl_alokasi_detail b on b.no_alk = a.no_alk INNER JOIN mastercoa_v2 c on c.no_coa  = b.coa INNER JOIN mastersupplier d on d.id_supplier = a.customer where a.tgl_alk BETWEEN '$start_date' and '$end_date' and (nama_coa like '%UTANG USAHA%' OR nama_coa like '%PPH PASAL 23%')
        UNION
        select d.id_supplier,d.supplier, c.no_coa, c.nama_coa, b.no_ref, a.curr, a.rate, b.amount, (b.amount * a.rate) amount_idr from tbl_alokasi a INNER JOIN tbl_alokasi_detail b on b.no_alk = a.no_alk INNER JOIN mastercoa_v2 c on c.no_coa  = b.coa INNER JOIN mastersupplier d on d.id_supplier = a.customer where a.tgl_alk BETWEEN '$start_date' and '$end_date' and no_ref like '%INM/%') a GROUP BY id_supplier ORDER BY supplier asc) d on d.id_supplier = a.id_customer $where
        ");
return $hasil->result_array();
}


function sales_report_detail_material($periode_dari_mt, $periode_sampai_mt, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt)
{

    if($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All' ){
        $str = " AND b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%')  ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.type_so = '$type_so_mt' AND a.id_type = '$type_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt == 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt == 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt != 'All' and $type_mt == 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt != 'All' and $shipp_mt == 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }elseif($id_customer_mt == 'All' and $shipp_mt != 'All' and $type_mt != 'All' and $curr_mt != 'All' and $type_so_mt != 'All'){
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }else{
        $str = " AND  b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' AND a.id_customer = '$id_customer_mt' AND a.shipp = '$shipp_mt' AND a.id_type = '$type_mt' AND b.curr = '$curr_mt' AND a.type_so = '$type_so_mt' AND (a.status = 'POST' OR a.status like '%APPROVED%') ";
        $str2 = " WHERE b.sj_date BETWEEN '$periode_dari_mt' AND '$periode_sampai_mt' and a.status != 'Cancel' ";
    }

    $hasil = $this->db->query("SELECT a.*, IFNULL(rate,1) rate, (price_bill * IFNULL(rate,1)) price_bill_idr, (gross_bill * IFNULL(rate,1)) gross_bill_idr, (other_bill * IFNULL(rate,1)) other_bill_idr, (diskon_bill * IFNULL(rate,1)) diskon_bill_idr, (net_bill * IFNULL(rate,1)) net_bill_idr, (dp_bill * IFNULL(rate,1)) dp_bill_idr, (vat_bill * IFNULL(rate,1)) vat_bill_idr, (total_bill * IFNULL(rate,1)) total_bill_idr, (price_ship * IFNULL(rate,1)) price_ship_idr, (gross_ship * IFNULL(rate,1)) gross_ship_idr, (other_ship * IFNULL(rate,1)) other_ship_idr, (diskon_ship * IFNULL(rate,1)) diskon_ship_idr, (net_ship * IFNULL(rate,1)) net_ship_idr, (dp_ship * IFNULL(rate,1)) dp_ship_idr, (vat_ship * IFNULL(rate,1)) vat_ship_idr, (total_ship * IFNULL(rate,1)) total_ship_idr FROM 
(
(select id, customer, no_invoice, tgl_inv, bppb_number, sj_date, grp, ws, styleno, produk, type_so, shipp, inv_type, no_faktur, tgl_faktur,curr, qty_bill, uom_bill, price_bill, total_bill gross_bill, other_bill, diskon_bill, (total_bill + other_bill - diskon_bill) net_bill, dp_bill, vat_bill, ((total_bill + other_bill - diskon_bill) - dp_bill + vat_bill) total_bill, qty_ship, uom_ship, price_ship, total_ship gross_ship, other_ship, diskon_ship, (total_ship + other_ship - diskon_ship) net_ship, dp_ship, vat_ship, ((total_ship + other_ship - diskon_ship) - dp_ship + vat_ship) total_ship from (SELECT b.id,c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
      b.shipp_number as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.ws ,b.styleno, concat(b.product_item, ' ', '(',b.size,')') as produk, a.type_so, a.shipp ,  d.type AS inv_type,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, b.qty qty_bill, b.uom uom_bill, b.unit_price price_bill, b.total_price total_bill, 0 other_bill, ROUND((e.discount / qty_all) * b.qty,4) diskon_bill, ROUND((e.dp / qty_all) * b.qty,4) dp_bill, ROUND((e.vat / qty_all) * b.qty,4) vat_bill, b.qty qty_ship, b.uom uom_ship, b.unit_price price_ship, b.total_price total_ship, 0 other_ship, ROUND((e.discount / qty_all) * b.qty,4) diskon_ship, ROUND((e.dp / qty_all) * b.qty,4) dp_ship, ROUND((e.vat / qty_all) * b.qty,4) vat_ship
      FROM tbl_book_invoice AS a INNER JOIN 
      tbl_invoice_detail AS b ON a.id = b.id_book_invoice INNER JOIN      
      mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
      tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
      tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
      tbl_master_top AS f ON a.id_top = f.id INNER JOIN
            (select id_book_invoice, sum(qty) qty_all from tbl_invoice_detail GROUP BY id_book_invoice) g on a.id = g.id_book_invoice
      WHERE a.profit_center = 'NAG' $str GROUP BY b.id ORDER BY a.no_invoice asc) a)
            
    UNION
        
    (select id, customer, no_invoice, tgl_inv, bppb_number, sj_date, grp, ws, styleno, produk, type_so, shipp, inv_type, no_faktur, tgl_faktur,curr, qty_bill, uom_bill, price_bill, total_bill gross_bill, other_bill, diskon_bill, (total_bill + other_bill - diskon_bill) net_bill, dp_bill, vat_bill, ((total_bill + other_bill - diskon_bill) - dp_bill + vat_bill) total_bill, qty_ship, uom_ship, price_ship, total_ship gross_ship, other_ship, diskon_ship, (total_ship + other_ship - diskon_ship) net_ship, dp_ship, vat_ship, ((total_ship + other_ship - diskon_ship) - dp_ship + vat_ship) total_ship from (SELECT b.id,c.Supplier AS customer, a.no_invoice, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
      b.shipp_number as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.ws ,b.styleno, concat(b.product_item, ' ', '(',b.size,')') as produk, a.type_so, a.shipp ,  d.type AS inv_type,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, b.qty qty_bill, b.uom uom_bill, b.unit_price price_bill, b.total_price total_bill, ROUND((h.total_other / qty_all_bill) * b.qty,4) other_bill, ROUND((h.discount / qty_all_bill) * b.qty,4) diskon_bill, ROUND((h.dp / qty_all_bill) * b.qty,4) dp_bill, ROUND((h.vat / qty_all_bill) * b.qty,4) vat_bill, b.qty_ship, b.uom_ship, b.unit_price_ship price_ship, b.total_price_ship total_ship, 0 other_ship, ROUND((e.discount / qty_all_ship) * b.qty,4) diskon_ship, ROUND((e.dp / qty_all_ship) * b.qty,4) dp_ship, ROUND((e.vat / qty_all_ship) * b.qty,4) vat_ship
      FROM tbl_book_invoice AS a INNER JOIN 
      tbl_invoice_detail_knitting AS b ON a.id = b.id_book_invoice INNER JOIN      
      mastersupplier AS c ON a.id_customer = c.Id_Supplier INNER JOIN 
      tbl_type AS d ON a.id_type = d.id_type INNER JOIN 
      tbl_invoice_pot AS e ON a.id = e.id_book_invoice INNER JOIN 
      tbl_invoice_pot_knitting AS h ON a.id = h.id_book_invoice INNER JOIN 
      tbl_master_top AS f ON a.id_top = f.id INNER JOIN
            (select id_book_invoice, sum(qty) qty_all_bill, sum(qty_ship) qty_all_ship from tbl_invoice_detail_knitting GROUP BY id_book_invoice) g on a.id = g.id_book_invoice
      WHERE a.profit_center = 'NAK' $str GROUP BY b.id ORDER BY a.no_invoice asc) a)
                 
    UNION
        
    (select id, customer, no_inv, tgl_inv, bppb_number, sj_date, grp, no_ws, no_style, produk, type_so, shipp, inv_type, no_faktur, tgl_faktur,curr, qty_bill, uom_bill, price_bill, total_bill gross_bill, other_bill, diskon_bill, (total_bill + other_bill - diskon_bill) net_bill, dp_bill, vat_bill, ((total_bill + other_bill - diskon_bill) - dp_bill + vat_bill) total_bill, qty_ship, uom_ship, price_ship, total_ship gross_ship, other_ship, diskon_ship, (total_ship + other_ship - diskon_ship) net_ship, dp_ship, vat_ship, ((total_ship + other_ship - diskon_ship) - dp_ship + vat_ship) total_ship from (SELECT b.id,c.Supplier AS customer, a.no_inv, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS tgl_inv, 
      b.no_shipp as bppb_number, DATE_FORMAT(b.sj_date, '%Y-%m-%d') AS sj_date, '' AS grp, b.no_ws ,b.no_style, concat(b.prod_item, ' ', '(',b.size,')') as produk, a.type_so, a.shipp, d.type AS inv_type,if(a.no_faktur is null,'-',CONCAT(MID(a.no_faktur,1,3),'.',MID(a.no_faktur,4,3),'-',MID(a.no_faktur,7,2),'.',MID(a.no_faktur,9))) no_faktur,if(a.tgl_faktur is null, '-',a.tgl_faktur) tgl_faktur, b.curr, b.qty qty_bill, b.uom uom_bill, b.unit_price price_bill, b.total total_bill, 0 other_bill, ROUND((e.diskon / qty_all) * b.qty,4) diskon_bill, ROUND((e.dp / qty_all) * b.qty,4) dp_bill, ROUND((e.vat / qty_all) * b.qty,4) vat_bill, b.qty qty_ship, b.uom uom_ship, b.unit_price price_ship, b.total total_ship, 0 other_ship, ROUND((e.diskon / qty_all) * b.qty,4) diskon_ship, ROUND((e.dp / qty_all) * b.qty,4) dp_ship, ROUND((e.vat / qty_all) * b.qty,4) vat_ship
      FROM tbl_invoice_nb AS a INNER JOIN 
      tbl_invoice_nb_detail AS b ON a.no_inv = b.no_inv INNER JOIN      
      mastersupplier AS c ON a.customer = c.Id_Supplier INNER JOIN 
      tbl_invoice_nb_pot AS e ON a.no_inv = e.no_inv INNER JOIN
      tbl_type as d on d.type = a.type INNER JOIN
            (select no_inv, sum(qty) qty_all from tbl_invoice_nb_detail GROUP BY no_inv) g on a.no_inv = g.no_inv $str2) a
    )
            ) a left join (select tanggal, curr, rate FROM masterrate where v_codecurr = 'Pajak' GROUP BY tanggal, curr) b on b.curr= a.curr AND b.tanggal = a.tgl_inv ");
    return $hasil->result_array();
}


// ── Helper: ambil rate HARIAN invoice dari masterrate berdasarkan type ──
// Daily   : kurs HARIAN hari ini
// Weekly  : kurs HARIAN di hari Jumat (= $end_date - 1 hari, karena periode Minggu s/d Sabtu)
// Monthly : kurs HARIAN di $end_date (= akhir bulan periode)
// Fallback: rate HARIAN terdekat sebelum tanggal referensi jika belum diinput
private function _rate_invoice($type, $end_date = null)
{
    if ($type === 'daily') {
        $tgl = date('Y-m-d');
    } elseif ($type === 'monthly') {
        // Akhir bulan SEBELUM periode filter (bukan akhir bulan filter itu sendiri)
        $tgl = date('Y-m-t', strtotime($end_date . ' -1 month'));
    } else {
        // weekly — periode Minggu s/d Sabtu, rate diambil dari Jumat (sehari sebelum $end_date)
        $tgl = date('Y-m-d', strtotime($end_date . ' -8 day'));
    }
    $tgl = $this->db->escape_str($tgl);
    $r   = $this->db->query("SELECT rate FROM masterrate WHERE v_codecurr = 'HARIAN' AND curr = 'USD' AND tanggal = '$tgl' LIMIT 1")->row();
    return ($r && $r->rate) ? (float)$r->rate : 1;
}

// ── Helper: ganti acuan CURRENT_DATE() pada query invoice (sj_date/tgl_dn)
// dan alokasi/pembayaran (tgl_alk) supaya data yang ditarik mengikuti periode
// filter ($start/$end), bukan tanggal hari ini:
//   - sj_date / tgl_dn  → batas atas pakai $end
//   - tgl_alk           → pakai $start (tgl_alk < $start)
// Hanya berlaku untuk type weekly & monthly — daily tetap pakai CURRENT_DATE().
// Bagian rate, aging, readydue, dll TIDAK ikut diganti (tetap CURRENT_DATE()).
private function _apply_end_date_filter($sql, $start, $end, $type)
{
    if ($type === 'daily' || $type === 'weekly') {
        return $sql;
    }

    $start_lit = "''" . $this->db->escape_str($start) . "''";
    $end_lit   = "''" . $this->db->escape_str($end) . "''";

    $sql = str_replace(
        "sj_date between ''2022-05-01'' and CURRENT_DATE()",
        "sj_date between ''2022-05-01'' and " . $end_lit,
        $sql
    );
    $sql = str_replace(
        "tgl_dn between ''2022-05-01'' and CURRENT_DATE()",
        "tgl_dn between ''2022-05-01'' and " . $end_lit,
        $sql
    );
    $sql = str_replace(
        "tgl_alk between CURRENT_DATE() and CURRENT_DATE()",
        "tgl_alk < " . $start_lit,
        $sql
    );
    $sql = str_replace(
        "tgl_alk < CURRENT_DATE()",
        "tgl_alk < ''2000-01-01''",
        $sql
    );

    return $sql;
}

// ── Helper: ambil rate HARIAN debit note dari ap_masterrate berdasarkan type ──
private function _rate_dn($type, $end_date = null)
{
    if ($type === 'daily') {
        $tgl = date('Y-m-d');
    } elseif ($type === 'monthly') {
        $tgl = date('Y-m-t', strtotime($end_date . ' -1 month'));
    } else {
        // weekly — periode Minggu s/d Sabtu, rate diambil dari Jumat (sehari sebelum $end_date)
        $tgl = date('Y-m-d', strtotime($end_date . ' -8 day'));
    }
    $tgl = $this->db->escape_str($tgl);
    $r   = $this->db->query("SELECT rate FROM ap_masterrate WHERE v_codecurr = 'HARIAN' AND tanggal = '$tgl' LIMIT 1")->row();
    return ($r && $r->rate) ? (float)$r->rate : 1;
}

public function cari_projection_report($id_customer, $start, $end, $type = 'daily')
{
    // supaya GROUP_CONCAT panjang
    $this->db->query("SET SESSION group_concat_max_len = 1000000");

    // Ambil rate sesuai type — $end sebagai tanggal referensi untuk weekly/monthly
    $rate_inv = $this->_rate_invoice($type, $end);
    $rate_dn  = $this->_rate_dn($type, $end);

    // set parameter
    $this->db->query("SET @start = '$start'");
    $this->db->query("SET @end   = '$end'");

    // =========================
    // GENERATE KOLOM DINAMIS
    // =========================
    $sqlCols = "
    WITH RECURSIVE dates AS (
    SELECT @start AS tgl, 1 AS urut
    UNION ALL
    SELECT DATE_ADD(tgl, INTERVAL 1 DAY), urut + 1
    FROM dates
    WHERE tgl < @end
)

SELECT 
GROUP_CONCAT(
    CONCAT(
        'SUM(CASE WHEN COALESCE(b.duedate_update,a.duedate) = ''',
        tgl,
        ''' THEN (COALESCE(b.amount,total) * a.rate) ELSE 0 END) AS data',
        urut
    )
) INTO @cols
FROM dates
    ";
    $this->db->query($sqlCols);

    // =========================
    // QUERY UTAMA (PAKAI CTE)
    // =========================
    $sqlMain = "
    SET @sql = CONCAT('WITH
invoice as (select * from (select id_customer, customer, no_invoice, inv_date, shipp, ''-'' vendor, ''-'' attn, duedate, top, curr, rate, total, eqv_idr from (select  id_customer, customer, no_invoice, inv_date, shipp, duedate, top, curr, if(curr = ''IDR'', 1, rate) rate, sal_awl, tambah, bayar,  total, eqv_idr,amt_aging_0,amt_aging_1,amt_aging_2,amt_aging_3,amt_aging_4,amt_aging_5,amt_aging_6,amt_aging_7, tot_aging, readydue, hasil_bln1, hasil_bln2, hasil_bln3, hasil_bln4, hasil_bln5, hasil_bln6, tot_aging tot_jatem from (select a.*, CASE WHEN jml_bln1 > 0 AND Date(duedate) >= CURRENT_DATE() THEN eqv_idr ELSE 0 END AS hasil_bln1,
        CASE WHEN jml_bln2 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln2,
        CASE WHEN jml_bln3 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln3,
        CASE WHEN jml_bln4 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln4,
        CASE WHEN jml_bln5 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln5,
        CASE WHEN jml_bln6 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln6,
        CASE WHEN total <= 0 THEN 0 WHEN Date(duedate) < CURRENT_DATE() THEN eqv_idr ELSE 0 END AS readydue,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top <= 0 THEN eqv_idr ELSE 0 END AS amt_aging_0,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 0  AND diff_top <= 30  THEN eqv_idr ELSE 0 END AS amt_aging_1,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 30 AND diff_top <= 60  THEN eqv_idr ELSE 0 END AS amt_aging_2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 60 AND diff_top <= 90  THEN eqv_idr ELSE 0 END AS amt_aging_3,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 90 AND diff_top <= 120 THEN eqv_idr ELSE 0 END AS amt_aging_4,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 120 AND diff_top <= 180 THEN eqv_idr ELSE 0 END AS amt_aging_5,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 180 AND diff_top <= 360 THEN eqv_idr ELSE 0 END AS amt_aging_6,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 360 THEN eqv_idr ELSE 0 END AS amt_aging_7,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging
        from (select a.*, ((sal_awl + tambah) - bayar) total, IF(curr = ''USD'',((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0)) * rate,((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0))) eqv_idr from (select no_invoice, kode_customer, customer, inv_date, id_customer, curr, top, amount1, duedate, bayar, bayar2, rate, shipp, diff_top, ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, IF(inv_date >= CURRENT_DATE(),0,COALESCE(amount1,0) - COALESCE(bayar2,0)) sal_awl, IF(inv_date >= CURRENT_DATE(),COALESCE(amount1,0) - COALESCE(bayar2,0),0) tambah from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,''0'') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,''0'') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,''0'') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,''0'') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,''0'') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,''0'') jml_bln6 from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT profit_center, no_invoice,kode_customer,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,CASE WHEN bayar > 0 AND profit_center = ''NAK'' THEN amount1 ELSE bayar END bayar,no_invoice2, CASE WHEN bayar2 > 0 AND profit_center = ''NAK'' THEN amount1 ELSE bayar2 END bayar2,rate,shipp,DATEDIFF(CURRENT_DATE(),duedate) diff_top, DATE_FORMAT(duedate,''%m'') bln_due, DATE_FORMAT(duedate,''%Y'') thn_due,DATE_FORMAT(CURRENT_DATE(),''%m'') fil_bln1,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 5,2,0) fil_bln6, DATE_FORMAT(CURRENT_DATE(),''%Y'') fil_thn, IF(duedate <= CURRENT_DATE(),amount1,0) ready_due from 
            (SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
                FORMAT((d.grand_total), 2) AS amount, if(a.curr = ''IDR'',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, ''%Y-%m-%d''), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
                FROM  tbl_book_invoice AS a INNER JOIN 
                mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
                tbl_master_top AS f ON a.id_top = f.id left join 
                tbl_duedate AS h ON a.id = h.id_invoice
                where a.sj_date between ''2022-05-01'' and CURRENT_DATE() and a.profit_center = ''NAG''
                UNION
                SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
                FORMAT((d.grand_total), 2) AS amount, if(a.curr = ''IDR'',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, ''%Y-%m-%d''), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
                FROM  tbl_book_invoice AS a INNER JOIN 
                mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN
                tbl_master_top AS f ON a.id_top = f.id left join 
                tbl_duedate AS h ON a.id = h.id_invoice
                where a.sj_date between ''2022-05-01'' and CURRENT_DATE() and a.profit_center = ''NAK''
                UNION
                SELECT distinct ''NAG'' profit_center, a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,DATE_FORMAT(e.sj_date, ''%Y-%m-%d'') AS inv_date,DATE_FORMAT(e.sj_date, ''%Y-%m-%d'') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
                FORMAT((d.grand_total), 2) AS amount, if(e.curr = ''IDR'',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, ''%Y-%m-%d''), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, ''%Y-%m-%d''), INTERVAL a.top DAY)) AS duedate,a.shipp
                FROM  tbl_invoice_nb AS a INNER JOIN 
                mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
                tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
                tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
                tbl_duedate AS h ON a.id = h.id_invoice left join
                saldoawal_ar as g on g.no_invoice = a.no_inv
                where g.no_invoice is null and a.status != ''CANCEL'' and e.sj_date between ''2022-05-01'' and CURRENT_DATE()
                union                                                                     
                select ''NAG'' profit_center, no_invoice, customer, UPPER(b.supplier_code) kode_customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = ''IDR'',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar a INNER JOIN mastersupplier AS b ON a.id_customer = b.id_supplier where no_invoice not like ''%DN/%'') inv LEFT JOIN
            (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != ''CANCEL'' and b.tgl_alk between CURRENT_DATE() and CURRENT_DATE() and a.total != ''0'' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
            (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != ''CANCEL'' and b.tgl_alk < CURRENT_DATE() and a.total != ''0'' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
            (select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '''',(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN''),(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''PAJAK'')) rate) rt) a) a) a) a) a) a WHERE sal_awl > 0 OR tambah > 0 OR bayar > 0 OR total > 0) a
                        UNION
select id_customer, customer, no_invoice, inv_date, ''-'' shipp, supplier vendor, attn, duedate, top, from_curr curr, rate, ((amount1 - IFNULL(bayar2,0)) - IFNULL(bayar,0)) AS total, ((amount1 - IFNULL(bayar2,0)) - IFNULL(bayar,0)) * IFNULL(rate,1) AS eqv_idr from (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,''0'') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,''0'') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,''0'') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,''0'') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,''0'') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,''0'') jml_bln6 FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,COALESCE(amount1,0) amount1, duedate, no_invoice1,COALESCE(bayar,0) bayar, no_invoice2,COALESCE(bayar2,0) bayar2, COALESCE(amount,0) amount,IF(supplier is null,''-'',supplier) supplier,IF(from_curr = ''IDR'',''1'',rate) rate,DATEDIFF(CURRENT_DATE(),duedate) diff_top, DATE_FORMAT(duedate,''%m'') bln_due, DATE_FORMAT(duedate,''%Y'') thn_due,DATE_FORMAT(CURRENT_DATE(),''%m'') fil_bln1,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 5,2,0) fil_bln6, DATE_FORMAT(CURRENT_DATE(),''%Y'') fil_thn, IF(duedate <= CURRENT_DATE(),amount1,0) ready_due  from 
        (
            SELECT distinct a.no_dn AS no_invoice, UPPER(b.supplier) AS customer, a.attn,DATE_FORMAT(a.tgl_dn, ''%Y-%m-%d'') AS inv_date,DATE_FORMAT(a.tgl_dn, ''%Y-%m-%d'') AS tgl_inv, b.Id_Supplier AS id_customer, a.to_curr as from_curr,DATEDIFF(a.due_date,a.tgl_dn) top,
            FORMAT(a.eqv_curr, 2) AS amount, if(a.to_curr = ''USD'',a.eqv_curr,round(a.eqv_curr, 2)) AS amount1,a.due_date duedate
            FROM  tbl_debitnote_h AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier left join
            saldoawal_ar as g on g.no_invoice = a.no_dn
            where g.no_invoice is null and a.status != ''CANCEL'' and a.tgl_dn between ''2022-05-01'' and CURRENT_DATE()
            union

            select no_invoice, customer, '''' attn, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = ''IDR'',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar where no_invoice like ''%DN/%''
            ) inv LEFT JOIN
        
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != ''CANCEL'' and b.tgl_alk between CURRENT_DATE() and CURRENT_DATE() and a.total != ''0'' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != ''CANCEL'' and b.tgl_alk >= ''2022-05-01'' and b.tgl_alk < CURRENT_DATE() and a.total != ''0'' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN

        (select no_dn dnno,GROUP_CONCAT(DISTINCT supplier SEPARATOR '' | '') supplier from tbl_debitnote_det where supplier != ''-'' AND supplier != '''' GROUP BY no_dn
            ) l_supp on l_supp.dnno = inv.no_invoice JOIN

        (select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '''',(select rate from ap_masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN''),(select rate from ap_masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN'')) rate) rate) a) a order by no_invoice asc) a ) a),
                
                duedate as (SELECT b.no_invoice, b.duedate_update, b.amount FROM tbl_duedate_update_det b INNER JOIN tbl_duedate_update_h a ON a.doc_number = b.doc_number
INNER JOIN (SELECT d.no_invoice, MAX(d.id) AS max_id FROM tbl_duedate_update_det d INNER JOIN tbl_duedate_update_h h ON h.doc_number = d.doc_number WHERE d.status = ''Y'' AND h.status <> ''CANCEL'' GROUP BY d.no_invoice ) x ON b.id = x.max_id)
                
                select a.id_customer, a.customer, a.no_invoice, a.inv_date, a.shipp, a.duedate, COALESCE(b.duedate_update,a.duedate) duedate_update, top, curr, rate, total, eqv_idr, COALESCE(b.amount,total) amount, (COALESCE(b.amount,total) * rate) amount_idr, ', @cols, ' from invoice a LEFT JOIN duedate b on b.no_invoice  = a.no_invoice where COALESCE(b.duedate_update,a.duedate) BETWEEN ''',@start,''' and ''',@end,''' GROUP BY a.no_invoice')";

                // a.duedate_update BETWEEN ''',@start,''' and ''',@end,''' and

    // Inject nilai rate yang sudah dihitung berdasarkan type (daily/weekly/monthly)
    // Ganti subquery rate invoice → literal nilai PHP
    $sqlMain = str_replace(
        "(select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '''',(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN''),(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''PAJAK'')) rate) rt",
        "(SELECT " . $rate_inv . " rate) rt",
        $sqlMain
    );
    // Ganti subquery rate debit note → literal nilai PHP (ap_masterrate)
    $sqlMain = str_replace(
        "(select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '''',(select rate from ap_masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN''),(select rate from ap_masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN'')) rate) rate)",
        "(SELECT " . $rate_dn . " rate) rate)",
        $sqlMain
    );

    // Ganti acuan CURRENT_DATE() pada query invoice (sj_date/tgl_dn) dan
    // alokasi/pembayaran (tgl_alk) supaya data yang ditarik mengikuti periode filter.
    $sqlMain = $this->_apply_end_date_filter($sqlMain, $start, $end, $type);

    $this->db->query($sqlMain);

    // =========================
    // EXECUTE
    // =========================
    $this->db->query("PREPARE stmt FROM @sql");
    $query = $this->db->query("EXECUTE stmt");
    $this->db->query("DEALLOCATE PREPARE stmt");

    return $query->result_array();
}


public function cari_projection_report_export($id_customer, $start, $end, $type = 'daily')
{
    // supaya GROUP_CONCAT panjang
    $this->db->query("SET SESSION group_concat_max_len = 1000000");

    // Ambil rate sesuai type — $end sebagai tanggal referensi untuk weekly/monthly
    $rate_inv = $this->_rate_invoice($type, $end);
    $rate_dn  = $this->_rate_dn($type, $end);

    // set parameter
    $this->db->query("SET @start = '$start'");
    $this->db->query("SET @end   = '$end'");

    // =========================
    // GENERATE KOLOM DINAMIS
    // =========================
    $sqlCols = "
    WITH RECURSIVE dates AS (
    SELECT @start AS tgl, 1 AS urut
    UNION ALL
    SELECT DATE_ADD(tgl, INTERVAL 1 DAY), urut + 1
    FROM dates
    WHERE tgl < @end
)

SELECT 
GROUP_CONCAT(
    CONCAT(
        'SUM(CASE WHEN COALESCE(b.duedate_update,a.duedate) = ''',
        tgl,
        ''' THEN (COALESCE(b.amount,total) * a.rate) ELSE 0 END) AS data',
        urut
    )
) INTO @cols
FROM dates
    ";
    $this->db->query($sqlCols);

    // =========================
    // QUERY UTAMA (PAKAI CTE)
    // =========================
    $sqlMain = "
    SET @sql = CONCAT('WITH
invoice as (select * from (select id_customer, customer, no_invoice, inv_date, shipp, ''-'' vendor, ''-'' attn, duedate, top, curr, rate, total, eqv_idr from (select  id_customer, customer, no_invoice, inv_date, shipp, duedate, top, curr, if(curr = ''IDR'', 1, rate) rate, sal_awl, tambah, bayar,  total, eqv_idr,amt_aging_0,amt_aging_1,amt_aging_2,amt_aging_3,amt_aging_4,amt_aging_5,amt_aging_6,amt_aging_7, tot_aging, readydue, hasil_bln1, hasil_bln2, hasil_bln3, hasil_bln4, hasil_bln5, hasil_bln6, tot_aging tot_jatem from (select a.*, CASE WHEN jml_bln1 > 0 AND Date(duedate) >= CURRENT_DATE() THEN eqv_idr ELSE 0 END AS hasil_bln1,
        CASE WHEN jml_bln2 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln2,
        CASE WHEN jml_bln3 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln3,
        CASE WHEN jml_bln4 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln4,
        CASE WHEN jml_bln5 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln5,
        CASE WHEN jml_bln6 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln6,
        CASE WHEN total <= 0 THEN 0 WHEN Date(duedate) < CURRENT_DATE() THEN eqv_idr ELSE 0 END AS readydue,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top <= 0 THEN eqv_idr ELSE 0 END AS amt_aging_0,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 0  AND diff_top <= 30  THEN eqv_idr ELSE 0 END AS amt_aging_1,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 30 AND diff_top <= 60  THEN eqv_idr ELSE 0 END AS amt_aging_2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 60 AND diff_top <= 90  THEN eqv_idr ELSE 0 END AS amt_aging_3,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 90 AND diff_top <= 120 THEN eqv_idr ELSE 0 END AS amt_aging_4,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 120 AND diff_top <= 180 THEN eqv_idr ELSE 0 END AS amt_aging_5,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 180 AND diff_top <= 360 THEN eqv_idr ELSE 0 END AS amt_aging_6,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 360 THEN eqv_idr ELSE 0 END AS amt_aging_7,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging
        from (select a.*, ((sal_awl + tambah) - bayar) total, IF(curr = ''USD'',((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0)) * rate,((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0))) eqv_idr from (select no_invoice, kode_customer, customer, inv_date, id_customer, curr, top, amount1, duedate, bayar, bayar2, rate, shipp, diff_top, ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, IF(inv_date >= CURRENT_DATE(),0,COALESCE(amount1,0) - COALESCE(bayar2,0)) sal_awl, IF(inv_date >= CURRENT_DATE(),COALESCE(amount1,0) - COALESCE(bayar2,0),0) tambah from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,''0'') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,''0'') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,''0'') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,''0'') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,''0'') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,''0'') jml_bln6 from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT profit_center, no_invoice,kode_customer,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,CASE WHEN bayar > 0 AND profit_center = ''NAK'' THEN amount1 ELSE bayar END bayar,no_invoice2, CASE WHEN bayar2 > 0 AND profit_center = ''NAK'' THEN amount1 ELSE bayar2 END bayar2,rate,shipp,DATEDIFF(CURRENT_DATE(),duedate) diff_top, DATE_FORMAT(duedate,''%m'') bln_due, DATE_FORMAT(duedate,''%Y'') thn_due,DATE_FORMAT(CURRENT_DATE(),''%m'') fil_bln1,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 5,2,0) fil_bln6, DATE_FORMAT(CURRENT_DATE(),''%Y'') fil_thn, IF(duedate <= CURRENT_DATE(),amount1,0) ready_due from 
            (SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
                FORMAT((d.grand_total), 2) AS amount, if(a.curr = ''IDR'',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, ''%Y-%m-%d''), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
                FROM  tbl_book_invoice AS a INNER JOIN 
                mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
                tbl_master_top AS f ON a.id_top = f.id left join 
                tbl_duedate AS h ON a.id = h.id_invoice
                where a.sj_date between ''2022-05-01'' and CURRENT_DATE() and a.profit_center = ''NAG''
                UNION
                SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
                FORMAT((d.grand_total), 2) AS amount, if(a.curr = ''IDR'',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, ''%Y-%m-%d''), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
                FROM  tbl_book_invoice AS a INNER JOIN 
                mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN
                tbl_master_top AS f ON a.id_top = f.id left join 
                tbl_duedate AS h ON a.id = h.id_invoice
                where a.sj_date between ''2022-05-01'' and CURRENT_DATE() and a.profit_center = ''NAK''
                UNION
                SELECT distinct ''NAG'' profit_center, a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,DATE_FORMAT(e.sj_date, ''%Y-%m-%d'') AS inv_date,DATE_FORMAT(e.sj_date, ''%Y-%m-%d'') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
                FORMAT((d.grand_total), 2) AS amount, if(e.curr = ''IDR'',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, ''%Y-%m-%d''), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, ''%Y-%m-%d''), INTERVAL a.top DAY)) AS duedate,a.shipp
                FROM  tbl_invoice_nb AS a INNER JOIN 
                mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
                tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
                tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
                tbl_duedate AS h ON a.id = h.id_invoice left join
                saldoawal_ar as g on g.no_invoice = a.no_inv
                where g.no_invoice is null and a.status != ''CANCEL'' and e.sj_date between ''2022-05-01'' and CURRENT_DATE()
                union                                                                     
                select ''NAG'' profit_center, no_invoice, customer, UPPER(b.supplier_code) kode_customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = ''IDR'',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar a INNER JOIN mastersupplier AS b ON a.id_customer = b.id_supplier where no_invoice not like ''%DN/%'') inv LEFT JOIN
            (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != ''CANCEL'' and b.tgl_alk between CURRENT_DATE() and CURRENT_DATE() and a.total != ''0'' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
            (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != ''CANCEL'' and b.tgl_alk < CURRENT_DATE() and a.total != ''0'' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
            (select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '''',(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN''),(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''PAJAK'')) rate) rt) a) a) a) a) a) a WHERE sal_awl > 0 OR tambah > 0 OR bayar > 0 OR total > 0) a
                        UNION
select id_customer, customer, no_invoice, inv_date, ''-'' shipp, supplier vendor, attn, duedate, top, from_curr curr, rate, ((amount1 - IFNULL(bayar2,0)) - IFNULL(bayar,0)) AS total, ((amount1 - IFNULL(bayar2,0)) - IFNULL(bayar,0)) * IFNULL(rate,1) AS eqv_idr from (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,''0'') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,''0'') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,''0'') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,''0'') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,''0'') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,''0'') jml_bln6 FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,COALESCE(amount1,0) amount1, duedate, no_invoice1,COALESCE(bayar,0) bayar, no_invoice2,COALESCE(bayar2,0) bayar2, COALESCE(amount,0) amount,IF(supplier is null,''-'',supplier) supplier,IF(from_curr = ''IDR'',''1'',rate) rate,DATEDIFF(CURRENT_DATE(),duedate) diff_top, DATE_FORMAT(duedate,''%m'') bln_due, DATE_FORMAT(duedate,''%Y'') thn_due,DATE_FORMAT(CURRENT_DATE(),''%m'') fil_bln1,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(CURRENT_DATE(),''%m'') + 5,2,0) fil_bln6, DATE_FORMAT(CURRENT_DATE(),''%Y'') fil_thn, IF(duedate <= CURRENT_DATE(),amount1,0) ready_due  from 
        (
            SELECT distinct a.no_dn AS no_invoice, UPPER(b.supplier) AS customer, a.attn,DATE_FORMAT(a.tgl_dn, ''%Y-%m-%d'') AS inv_date,DATE_FORMAT(a.tgl_dn, ''%Y-%m-%d'') AS tgl_inv, b.Id_Supplier AS id_customer, a.to_curr as from_curr,DATEDIFF(a.due_date,a.tgl_dn) top,
            FORMAT(a.eqv_curr, 2) AS amount, if(a.to_curr = ''USD'',a.eqv_curr,round(a.eqv_curr, 2)) AS amount1,a.due_date duedate
            FROM  tbl_debitnote_h AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier left join
            saldoawal_ar as g on g.no_invoice = a.no_dn
            where g.no_invoice is null and a.status != ''CANCEL'' and a.tgl_dn between ''2022-05-01'' and CURRENT_DATE()
            union

            select no_invoice, customer, '''' attn, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = ''IDR'',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar where no_invoice like ''%DN/%''
            ) inv LEFT JOIN
        
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != ''CANCEL'' and b.tgl_alk between CURRENT_DATE() and CURRENT_DATE() and a.total != ''0'' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != ''CANCEL'' and b.tgl_alk >= ''2022-05-01'' and b.tgl_alk < CURRENT_DATE() and a.total != ''0'' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN

        (select no_dn dnno,GROUP_CONCAT(DISTINCT supplier SEPARATOR '' | '') supplier from tbl_debitnote_det where supplier != ''-'' AND supplier != '''' GROUP BY no_dn
            ) l_supp on l_supp.dnno = inv.no_invoice JOIN

        (select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '''',(select rate from ap_masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN''),(select rate from ap_masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN'')) rate) rate) a) a order by no_invoice asc) a WHERE ((amount1 - IFNULL(bayar2,0)) - IFNULL(bayar,0)) > 0) a),
                
                duedate as (SELECT b.no_invoice, b.duedate_update, b.amount FROM tbl_duedate_update_det b INNER JOIN tbl_duedate_update_h a ON a.doc_number = b.doc_number
INNER JOIN (SELECT d.no_invoice, MAX(d.id) AS max_id FROM tbl_duedate_update_det d INNER JOIN tbl_duedate_update_h h ON h.doc_number = d.doc_number WHERE d.status = ''Y'' AND h.status <> ''CANCEL'' GROUP BY d.no_invoice ) x ON b.id = x.max_id)
                
                select a.id_customer, a.customer, a.no_invoice, a.inv_date, a.shipp, a.duedate, COALESCE(b.duedate_update,a.duedate) duedate_update, top, curr, rate, total, eqv_idr, COALESCE(b.amount,total) amount, (COALESCE(b.amount,total) * rate) amount_idr, ', @cols, ' from invoice a LEFT JOIN duedate b on b.no_invoice  = a.no_invoice where COALESCE(b.duedate_update,a.duedate) BETWEEN ''',@start,''' and ''',@end,''' GROUP BY a.no_invoice')";

    // Inject rate sesuai type ke sqlMain export
    $sqlMain = str_replace(
        "(select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '''',(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN''),(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''PAJAK'')) rate) rt",
        "(SELECT " . $rate_inv . " rate) rt",
        $sqlMain
    );
    $sqlMain = str_replace(
        "(select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '''',(select rate from ap_masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN''),(select rate from ap_masterrate where tanggal = CURRENT_DATE() and v_codecurr = ''HARIAN'')) rate) rate)",
        "(SELECT " . $rate_dn . " rate) rate)",
        $sqlMain
    );

    // Ganti acuan CURRENT_DATE() pada query invoice (sj_date/tgl_dn) dan
    // alokasi/pembayaran (tgl_alk) supaya data yang ditarik mengikuti periode filter.
    $sqlMain = $this->_apply_end_date_filter($sqlMain, $start, $end, $type);

    $this->db->query($sqlMain);

    $getSql = $this->db->query("SELECT @sql AS sqlku")->row_array();
    $sqlFix = $getSql['sqlku'];
    $query  = $this->db->query($sqlFix);

    return $query->result_array();
}


public function save_history_projection_report($id_customer, $from, $to, $created_by, $type = 'daily')
{
    // 1. Generate doc_number format PR/MMYY/NNNNN (reset tiap bulan)
    $mmyy = date('my', strtotime($from)); // e.g. "0625" untuk Juni 2025

    $q = $this->db->query("
        SELECT IFNULL(MAX(CAST(SUBSTRING(doc_number, 9, 5) AS UNSIGNED)), 0) + 1 AS next_no
        FROM tbl_history_projection_h
        WHERE doc_number LIKE 'PR/$mmyy/%'
    ");
    $next_no    = (int)($q->row()->next_no ?? 1);
    $doc_number = 'PR/' . $mmyy . '/' . str_pad($next_no, 5, '0', STR_PAD_LEFT);

    // 2. Insert log/header
    $this->db->insert('tbl_history_projection_h', [
        'doc_number'     => $doc_number,
        'periode_dari'   => $from,
        'periode_sampai' => $to,
        'id_customer'    => $id_customer,
        'type'           => $type,
        'created_by'     => $created_by,
        'created_at'     => date('Y-m-d H:i:s'),
    ]);

    // 3. INSERT...SELECT detail dari hasil projection (pakai rate sesuai type)
    $rows = $this->cari_projection_report_export($id_customer, $from, $to, $type);

    if (!empty($rows)) {
        $batch = [];
        foreach ($rows as $r) {
            $batch[] = [
                'doc_number'     => $doc_number,
                'id_customer'    => $r['id_customer'],
                'customer'       => $r['customer'],
                'no_invoice'     => $r['no_invoice'],
                'inv_date'       => $r['inv_date'],
                'shipp'          => $r['shipp'],
                'duedate'        => $r['duedate'],
                'duedate_update' => $r['duedate_update'],
                'top'            => $r['top'],
                'curr'           => $r['curr'],
                'amount'         => $r['amount'],
                'rate'           => $r['rate'],
                'amount_idr'     => $r['amount_idr'],
            ];
        }
        $this->db->insert_batch('tbl_history_projection_det', $batch);
    }

    return $doc_number;
}


public function get_history_projection_list($from, $to)
{
    $hasil = $this->db->query("
        SELECT h.doc_number, h.periode_dari, h.periode_sampai, h.id_customer,
               h.created_by, h.created_at, h.type,
               COUNT(d.id)        AS total_invoice,
               SUM(d.amount_idr)  AS total_amount_idr
        FROM tbl_history_projection_h h
        LEFT JOIN tbl_history_projection_det d ON d.doc_number = h.doc_number
        WHERE DATE(h.created_at) BETWEEN '$from' AND '$to'
        GROUP BY h.doc_number
        ORDER BY h.created_at DESC
    ");
    return $hasil->result_array();
}


public function cancel_history_projection_report($doc_number)
{
    $doc_number = $this->db->escape_str($doc_number);

    // Pastikan tabel _cancel sudah ada (buat sekali jika belum)
    $this->db->query("CREATE TABLE IF NOT EXISTS tbl_history_projection_h_cancel   LIKE tbl_history_projection_h");
    $this->db->query("CREATE TABLE IF NOT EXISTS tbl_history_projection_det_cancel LIKE tbl_history_projection_det");

    // Copy data ke tabel _cancel sebelum dihapus
    $this->db->query("INSERT IGNORE INTO tbl_history_projection_h_cancel   SELECT * FROM tbl_history_projection_h   WHERE doc_number = '$doc_number'");
    $this->db->query("INSERT IGNORE INTO tbl_history_projection_det_cancel SELECT * FROM tbl_history_projection_det WHERE doc_number = '$doc_number'");

    // Hapus dari tabel asli
    $this->db->query("DELETE FROM tbl_history_projection_det WHERE doc_number = '$doc_number'");
    $this->db->query("DELETE FROM tbl_history_projection_h   WHERE doc_number = '$doc_number'");

    return $this->db->affected_rows() >= 0;
}

public function get_history_projection_detail($doc_number)
{
    $doc_number = $this->db->escape_str($doc_number);

    $header = $this->db->get_where('tbl_history_projection_h', ['doc_number' => $doc_number])->row_array();
    $detail = $this->db->get_where('tbl_history_projection_det', ['doc_number' => $doc_number])->result_array();

    return ['header' => $header, 'detail' => $detail];
}


}
