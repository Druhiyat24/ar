<?php

use SebastianBergmann\Environment\Console;

class Model_nag extends CI_Model
{
    function cari_customer()
    {
        $hasil = $this->db->query("SELECT DISTINCT alamat,Id_Supplier, UPPER(Supplier) As Supplier FROM mastersupplier WHERE tipe_sup = 'C' and id_supplier != '1006' order by supplier asc");
        return $hasil->result_array();
    }

    function cari_status()
    {
        $hasil = $this->db->query("SELECT DISTINCT status from tbl_book_invoice");
        return $hasil->result_array();
    }


    function cari_profit_center()
    {
        $hasil = $this->db->query("SELECT kode_pc, nama_pc from master_pc GROUP BY id_pc");
        return $hasil->result_array();
    }

    //ubah desember
    function getcoa2($type_so,$shipp,$cust_ctg)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and inv_type like '%INM_debit%' ");
        return $hasil->row();
    }

    //ubah desember
    function getcoa3($cust_ctg)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where cus_ctg like '%$cust_ctg%' and inv_type like '%debitnote%' ");
        return $hasil->row();
    }

    //ubah desember
    function getcoa($type_so,$shipp,$cust_ctg,$grade,$kode_pc)
    {
        if ($kode_pc == 'NAG') {
            $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and grade like '%$grade%' and inv_type like '%INV_debit%' ");
        }else{
            $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and grade like '%$grade%' and inv_type like '%INV_debit%' ");
        }
        return $hasil->row();
    }


    //ubah desember
    function getcoa_credit($type_so,$shipp,$cust_ctg,$grade,$kode_pc)
    {

        if ($kode_pc == 'NAG') {
            $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and grade like '%$grade%' and inv_type like '%INV_credit%' ");
        }else{
            $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and grade like '%$grade%' and inv_type like '%NAK_credit%' ");
        }
        return $hasil->row();
    }

    //ubah desember
    function getcoa_credit2($type_so,$shipp,$cust_ctg)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and inv_type like '%INM_credit%' LIMIT 1 ");
        return $hasil->row();
    }

    //ubah desember
    function getcoa_dp($type_so,$shipp,$cust_ctg,$grade,$kode_pc)
    {
        if ($kode_pc == 'NAG') {
            $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and inv_type like '%DP%' ");
        }else{
            $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and inv_type like '%DP%' ");
        }
        return $hasil->row();
    }

    //ubah desember
    function getcoa_dp2($type_so,$shipp,$cust_ctg)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and inv_type like '%DP%' ");
        return $hasil->row();
    }

    //ubah desember
    function getcoa_ppn($type_so,$shipp,$cust_ctg,$grade, $kode_pc)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where inv_type like '%PPN INV%' ");
        return $hasil->row();
    }

    //ubah desember
    function getcoa_ppn2($type_so,$shipp,$cust_ctg)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where inv_type like '%PPN INV%' ");
        return $hasil->row();
    }

    //ubah desember
    function getcoa_pot($type_so,$shipp,$cust_ctg,$grade, $kode_pc)
    {
        if ($kode_pc == 'NAG') {
            $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and grade like '%$grade%' and inv_type like '%INV_pot%' ");
        }else{
            $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and grade like '%$grade%' and inv_type like '%NAK_pot%' ");
        }
        return $hasil->row();
    }

    //ubah akhir
    function getbuyer($id_cust)
    {
        $hasil = $this->db->query("SELECT DISTINCT alamat,Id_Supplier, UPPER(Supplier) As Supplier FROM mastersupplier WHERE tipe_sup = 'C' and Id_Supplier = '$id_cust'");
        return $hasil->row();
    }

    //ubah desember
    function getcoa_pot2($type_so,$shipp,$cust_ctg)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and so_tipe like '%$type_so%' and cus_ctg like '%$cust_ctg%' and inv_type like '%INM_pot%' Limit 1");
        return $hasil->row();
    }

     //ubah desember
    function getcoa4($shipp)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where shipp_tipe = '$shipp' and inv_type like '%DP/CBD%' ");
        return $hasil->row();
    }
//ubah desember
    function getcoa_ppn4($shipp)
    {
        $hasil = $this->db->query("SELECT no_coa, nama_coa from mastercoa_v2 where inv_type like '%PPN INV%' ");
        return $hasil->row();
    }

    //ubah desember
    function getrate($inv_date)
    {
        $hasil = $this->db->query("SELECT rate,tanggal from masterrate where v_codecurr = 'PAJAK' and tanggal = '$inv_date'");
        return $hasil->row();
    }

    //ubah desember
    function at_debit_inv($data)
    {
        $this->db->insert_batch('tbl_list_journal', $data);
        return $this->db->insert_id();
    }

        //ubah desember
    function at_pot_inv($data)
    {
        $this->db->insert_batch('tbl_list_journal', $data);
        return $this->db->insert_id();
    }

    //ubah desember
    function at_dp_inv($data)
    {
        $this->db->insert_batch('tbl_list_journal', $data);
        return $this->db->insert_id();
    }

    //ubah desember
    function at_credit_inv($data)
    {
        $this->db->insert_batch('tbl_list_journal', $data);
        return $this->db->insert_id();
    }
    //ubah desember
    function at_credit_dpcbd($data)
    {
        $this->db->insert_batch('jurnal_invoice_dpcbd', $data);
        return $this->db->insert_id();
    }

    //ubah desember
    function at_dp_dpcbd($data)
    {
        $this->db->insert_batch('jurnal_invoice_dpcbd', $data);
        return $this->db->insert_id();
    }

    //ubah desember
    function at_ppn_inv($data)
    {
        $this->db->insert_batch('tbl_list_journal', $data);
        return $this->db->insert_id();
    }

    //ubah desember
    function cari_dpcbd_invoice_post($dt_dari_inv, $dt_sampai_inv)
    {
        $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
          c.type, a.status, a.no_faktur_pajak,  FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',(a.total * (a.dp/100)),a.dp)), 2) AS amount
          FROM tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
          tbl_invoice_proforma_detail_dp_cbd AS d ON a.no_proforma_invoice = d.no_invoice_proforma
          WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
          GROUP BY a.no_proforma_invoice");
        return $hasil->result_array();
    }

    //ubah september
    function cari_supplier()
    {
        $hasil = $this->db->query("SELECT DISTINCT Id_Supplier, UPPER(Supplier) As Supplier FROM mastersupplier WHERE tipe_sup = 'S' order by Supplier ASC");
        return $hasil->result_array();
    }

    function cari_buyer()
    {
        $hasil = $this->db->query("SELECT DISTINCT Id_Supplier, UPPER(Supplier) As Supplier FROM mastersupplier WHERE tipe_sup = 'C' order by supplier ASC ");
        return $hasil->result_array();
    }        

    function master_top()
    {
        $hasil = $this->db->query("SELECT a.supplier AS customer, b.type, b.top, b.id, b.status FROM mastersupplier AS a INNER JOIN 
           tbl_master_top AS b ON a.Id_Supplier = b.id_customer ");
        return $hasil->result_array();
    }

    function simpan_master_top($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function edit_master_top($id, $status)
    {
        $hasil = $this->db->query("UPDATE tbl_master_top SET status = '$status' WHERE id = '$id' ");
        return $hasil;
    }

    function get_kode_book_invoice($kode_inv)
    {
        // $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) AND 
        //                        MONTH(tanggal) = MONTH(CURRENT_DATE())");
        //
        // $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) AND 
        //                        MONTH(tanggal) = MONTH(CURRENT_DATE()) AND status <> 'POST' AND status <> 'CANCEL' ");
        //
        $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tgl_book_inv) = YEAR(CURRENT_DATE()) AND 
          MONTH(tgl_book_inv) = MONTH(CURRENT_DATE()) AND status <> 'CANCEL' ");
        //
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return $kd . "/$kode_inv/NAG/" . date('my');
    }

    function simpan_booking_invoice($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function loadbookinvoice($dt_dari, $dt_sampai, $id_customer, $status)
    {
        // if ($id_customer == "all_customer" and $status == "All") {
        //     $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, 
        //                                   DATE_FORMAT(a.tgl_book_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, 
        //                                   FORMAT(a.value, 2) AS value, a.doc_type, a.doc_number
        //                            FROM tbl_book_invoice AS a INNER JOIN 
        //                                   mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        //                                   tbl_type AS c ON a.id_type = c.id_type
        //                            WHERE  a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' ");
        //     return $hasil->result_array();
        // } else if ($id_customer != "all_customer" and $status != "All") {
        //     $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, 
        //                                   DATE_FORMAT(a.tgl_book_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, 
        //                                   FORMAT(a.value, 2) AS value, a.doc_type, a.doc_number
        //                            FROM tbl_book_invoice AS a INNER JOIN 
        //                                   mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        //                                   tbl_type AS c ON a.id_type = c.id_type
        //                            WHERE  a.status =  '$status' AND a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' AND a.id_customer = '$id_customer' ");
        //     return $hasil->result_array();
        // } else if ($id_customer != "all_customer" and $status == "All") {
        //     $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, 
        //                                   DATE_FORMAT(a.tgl_book_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, 
        //                                   FORMAT(a.value, 2) AS value, a.doc_type, a.doc_number
        //                               FROM tbl_book_invoice AS a INNER JOIN 
        //                                     mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        //                                     tbl_type AS c ON a.id_type = c.id_type
        //                               WHERE a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' AND a.id_customer = '$id_customer' ");
        //     return $hasil->result_array();
        // } else if ($id_customer == "all_customer" and $status != "All") {
        //     $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, 
        //                                   DATE_FORMAT(a.tgl_book_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, 
        //                                   FORMAT(a.value, 2) AS value, a.doc_type, a.doc_number
        //                               FROM tbl_book_invoice AS a INNER JOIN 
        //                                     mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        //                                     tbl_type AS c ON a.id_type = c.id_type
        //                               WHERE a.status =  '$status' AND a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' ");
        //     return $hasil->result_array();
        // }        
        //
        //Query With Condition
        if ($id_customer == "all_customer" and $status == "All") {
            $str = "WHERE a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' ";
        } else if ($id_customer != "all_customer" and $status != "All") {
            $str = "WHERE a.status =  '$status' AND a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' AND a.id_customer = '$id_customer' ";
        } else if ($id_customer != "all_customer" and $status == "All") {
            $str = "WHERE a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' AND a.id_customer = '$id_customer' ";
        } else if ($id_customer == "all_customer" and $status != "All") {
            $str = "WHERE a.status =  '$status' AND a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' ";
        }
        //
        $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, 
           DATE_FORMAT(a.tgl_book_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, 
           FORMAT(a.value, 2) AS value, a.doc_type, a.doc_number
           FROM tbl_book_invoice AS a INNER JOIN 
           mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
           tbl_type AS c ON a.id_type = c.id_type
           $str ");
        return $hasil->result_array();
    }

    function edit_booking_invoice($id, $doc_number, $id_type, $doc_type, $amount, $no_invoice, $id_customer, $profit_center, $shipp)
    {
        $hasil = $this->db->query("UPDATE tbl_book_invoice SET no_invoice = '$no_invoice', id_customer = '$id_customer', profit_center = '$profit_center', shipp = '$shipp', doc_number = '$doc_number', id_type = '$id_type', value = '$amount', doc_type = '$doc_type' WHERE id = '$id' ");
        return $hasil;
    }

    function cancel_booking_invoice($id)
    {
        $hasil = $this->db->query("UPDATE tbl_book_invoice SET status = 'CANCEL' WHERE id = '$id' ");
        return $hasil;
    }
    

    function copy_invoice($id)
    {
        $hasil = $this->db->query("insert into tplog_batalinvoice select * from tbl_book_invoice where id = '$id' ");
        return $hasil;
    }

    function copy_pot($id)
    {
        $hasil = $this->db->query("insert into tplog_batalinvoice_pot select * from tbl_invoice_pot where id_book_invoice = '$id' ");
        return $hasil;
    }
    function copy_detail($id)
    {
        $hasil = $this->db->query("insert into tplog_batalinvoice_detail select * from tbl_invoice_detail where id_book_invoice = '$id' ");
        return $hasil;
    }

    function cancel_invoice($id)
    {
        $hasil = $this->db->query("UPDATE tbl_book_invoice SET status = 'DRAFT', pph = null, tgl_inv = null, id_top = null, id_bank = null, type_so = null, no_duedate = null WHERE id = '$id' ");
        return $hasil;
    }
    function delete_pot($id)
    {
        $hasil = $this->db->query("delete from tbl_invoice_pot WHERE id_book_invoice = '$id' ");
        return $hasil;
    }

    function delete_detail($id)
    {
        $hasil = $this->db->query("delete from tbl_invoice_detail WHERE id_book_invoice = '$id' ");
        return $hasil;
    }


    function update_bppb($id)
    {

        $db_nag = $this->load->database('db_nag', TRUE);
        $hasil1 = $db_nag->query("UPDATE bppb SET stat_inv = '0', id_invoice_ar = null WHERE id_invoice_ar = '$id'");

        return $hasil1;
    }

    function log_booking_invoice($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function getType($id)
    {
        $hasil = $this->db->query("SELECT b.id, b.id_type, b.doc_number, a.type, b.no_invoice, b.value, b.doc_type, id_customer, profit_center, shipp
            FROM tbl_type AS a INNER JOIN tbl_book_invoice AS b ON a.id_type = b.id_type 
            WHERE b.id = '$id' ");
        return $hasil->row();
    }

    function cari_book_inv($dt_dari, $dt_sampai)
    {
        $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
          DATE_FORMAT(a.tgl_book_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, 
          FORMAT(VALUE, 2) AS amount, profit_center
          FROM  tbl_book_invoice AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type WHERE a.status = 'DRAFT' 
          AND a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' ");
        return $hasil->result_array();
    }

    //ubah september
    function cari_bi($dt_dari, $dt_sampai)
    {
        // $hasil = $this->db->query("SELECT a.doc_num,a.date,c.Id_Supplier,a.customer,b.id as id_bank,a.bank,a.akun,a.curr,a.amount,a.rate,a.eqv_idr from tbl_bankin_arcollection a inner join masterbank b on b.no_rek = a.akun left join mastersupplier c on c.Supplier = a.customer where a.ref_data = 'AR Collection' and a.status = 'Approved' and c.tipe_sup = 'C' 
        //                                   AND a.date BETWEEN '$dt_dari' AND '$dt_sampai' ");

        $hasil = $this->db->query("SELECT *from (SELECT a.doc_num,a.date,c.Id_Supplier,a.customer,b.id as id_bank,a.bank,a.akun,a.curr,
            if(a.curr = 'USD',if(((a.amount) - (select DISTINCT sum((k.eqp_idr - k.sisa) /k.rate) from tbl_alokasi k left join tbl_bankin_arcollection d on d.doc_num = k.doc_number where k.doc_number = a.doc_num)) is null,a.amount,Round((a.amount) - (select DISTINCT sum((k.eqp_idr - k.sisa) /k.rate) from tbl_alokasi k left join tbl_bankin_arcollection d on d.doc_num = k.doc_number where k.doc_number = a.doc_num),2)),if(((a.amount) - (select DISTINCT sum(k.eqp_idr - k.sisa) from tbl_alokasi k left join tbl_bankin_arcollection d on d.doc_num = k.doc_number where k.doc_number = a.doc_num)) is null,a.amount,((a.amount) - (select DISTINCT sum(k.eqp_idr - k.sisa) from tbl_alokasi k left join tbl_bankin_arcollection d on d.doc_num = k.doc_number where k.doc_number = a.doc_num)))) as amount,
                a.rate,
            if((a.eqv_idr - (select DISTINCT sum(k.eqp_idr - k.sisa) from tbl_alokasi k left join tbl_bankin_arcollection d on d.doc_num = k.doc_number where k.doc_number = a.doc_num)) is null,a.eqv_idr,(a.eqv_idr - (select DISTINCT sum(k.eqp_idr - k.sisa) from tbl_alokasi k left join tbl_bankin_arcollection d on d.doc_num = k.doc_number where k.doc_number = a.doc_num)))as eqv_idr 
                from tbl_bankin_arcollection a inner join masterbank b on b.no_rek = a.akun left join mastersupplier c on c.Supplier = a.customer where a.ref_data = 'AR Collection' and a.status = 'Approved' and c.tipe_sup = 'C') a where a.amount > 0  
        AND a.date BETWEEN '$dt_dari' AND '$dt_sampai'
        UNION select * from (select no_journal,tgl_journal,id_supplier,nama_supp, id_bank,bank,akun,curr, (credit - COALESCE(alk_credit,0)) amount,rate,sum(credit_idr - COALESCE(alk_credit_idr,0)) amount_idr from (select no_journal,tgl_journal,id_supplier,a.buyer nama_supp,'' id_bank,'' bank ,'' akun,curr,sum(credit) credit,rate,sum(credit_idr) credit_idr  from tbl_list_journal a left join mastersupplier b on b.supplier = a.buyer where no_journal like '%GM/%' and tgl_journal BETWEEN '$dt_dari' AND '$dt_sampai' and  no_coa = '1.90.02' and reff_doc != ''  and b.tipe_sup = 'C' GROUP BY no_journal) a left JOIN
            (select doc_number,sum(amount) alk_credit,SUM(eqp_idr) alk_credit_idr from tbl_alokasi where doc_number like '%GM/%' and status != 'Cancel' GROUP BY doc_number) b on b.doc_number = a.no_journal) a where a.amount > 0  ");
        return $hasil->result_array();
    }

    function cari_top($id)
    {
        $hasil = $this->db->query("SELECT a.supplier AS customer, b.type, b.top, b.id, b.status, a.Id_Supplier
           FROM mastersupplier AS a INNER JOIN 
           tbl_master_top AS b ON a.Id_Supplier = b.id_customer
           WHERE b.status = 'Active' AND a.Id_Supplier = '$id' ");
        return $hasil->result_array();
    }

    function cari_so($dt_dari_so, $dt_sampai_so, $id_customer, $buyer, $profit_center)
    {
        //Database SignalBit
        $db_nag = $this->load->database('db_nag', TRUE);
        $db_pgsql = $this->load->database('db_pgsql', TRUE);
        $hasil  = [];
        $supplier = $db_nag->query("
            SELECT knitting_code from mastersupplier where tipe_sup = 'C' and Id_Supplier = '$buyer'
            ")->row();

        $knitting_code = $supplier ? $supplier->knitting_code : '';

        if ($profit_center == 'NAG') {
            $hasil = $db_nag->query("SELECT DISTINCT a.so_no, a.so_date, c.supplier, a.buyerno, a.so_type, b.id_so
             FROM  so_det AS b INNER JOIN so AS a 
             ON (b.id_so = a.id) INNER JOIN 
             act_costing AS d ON (a.id_cost = d.id) INNER JOIN 
             mastersupplier AS c ON (c.Id_Supplier = d.id_buyer) INNER JOIN 
             bppb AS e ON (e.id_so_det = b.id) 
             WHERE c.Id_Supplier = '$buyer' AND a.so_date BETWEEN '$dt_dari_so' AND '$dt_sampai_so' AND c.tipe_sup = 'C' ");
            
        }else{

            if (!empty($knitting_code)) {
                $hasil = $db_pgsql->query("SELECT kode_so so_no, so_date, nama_konsumen supplier, '-' buyerno, '-' so_type, a.id id_so from sales_orders a inner join master_konsumen b on b.id = a.konsumen_id where status_so != 'cancel' and kode_konsumen = '$knitting_code' AND a.so_date BETWEEN '$dt_dari_so' AND '$dt_sampai_so' order by a.id asc");
            }
        }

        return $hasil->result_array();
    }

    

    //ubah september
    function cari_sj($id_sj, $profit_center)
    {
        //Database SignalBit
        $db_nag = $this->load->database('db_nag', TRUE);
        $db_pgsql = $this->load->database('db_pgsql', TRUE);
        $hasil  = [];
        if ($profit_center == 'NAG') {
            $hasil = $db_nag->query("SELECT a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
                d.styleno, e.product_group, e.product_item, b.color, b.size,  
                c.curr, c.unit AS uom, c.qty, Round(c.price,4) AS unit_price,  
                ROUND(c.qty * Round(c.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,c.grade,if(c.grade = 'GRADE A','A','B') as grade
                FROM so AS a INNER JOIN 
                so_det AS b ON a.id = b.id_so INNER JOIN 
                bppb AS c ON b.id = c.id_so_det INNER JOIN 
                act_costing AS d ON a.id_cost = d.id INNER JOIN 
                masterproduct AS e ON d.id_product = e.id               
                WHERE b.id_so = '$id_sj' and c.id_supplier != '1038' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0')
                ORDER BY c.bppbno ");
        }else{
            $hasil = $db_pgsql->query("SELECT kode_so no_so, kode_out sj, tgl_pengeluaran bppbdate, kode_out shipping_number, '-' ws, lab_dip styleno, '-' product_group, nama_kain product_item, warna color, '-' size,  currency curr, nama_unit uom, qty_meter qty, Round(coalesce(harga_shipment,0),4) AS unit_price, ROUND(qty_meter * Round(coalesce(harga_shipment,0),4), 4) AS total_price,  a.no_so id_so, a.id AS id_bppb, 'GRADE A' grade,'A' grade from official_out_h a inner join official_out_barcode b on b.id_official = a.id inner join master_kain c on c.id = b.kain_id LEFT JOIN master_kain_detail d on d.id = b.detail_kain_id INNER JOIN detail_so e on e.id = b.detail_so_id INNER JOIN sales_orders f on f.id = e.sales_order_id left join master_unit g on g.id = e.id_unit_sales_order_shipment where a.status_inv is null and a.tipe_pengeluaran = 'Penjualan' and a.no_so = '$id_sj' ORDER BY kode_out asc ");
        }

        return $hasil->result_array();
    }
    

    //ubah september
    function cari_dataso($id_so,$tipe)
    {
        if ($tipe == 'CBD') {
         $db_nag = $this->load->database('db_nag', TRUE);
         $hasil = $db_nag->query("SELECT so.so_no,so_det.id as id_sodet,supplier, so.so_date, 
            so_det.dest, so_det.color, so_det.size, so_det.qty, so_det.unit, 
            act_costing.deldate, act_costing.curr, masterproduct.product_item, masterproduct.product_group, 
            ROUND(so_det.price,2) AS price, act_costing.styleno ,mastersupplier.Phone,
            ROUND(so_det.price * so_det.qty,2) AS hasilkali,so.tax 
            from 
            so_det INNER JOIN so ON so_det.id_so = so.id
            INNER JOIN act_costing ON so.id_cost = act_costing.id
            INNER JOIN masterproduct ON act_costing.id_product = masterproduct.id
            INNER JOIN mastersupplier on act_costing.id_buyer = mastersupplier.Id_Supplier
            WHERE so_det.cancel='N' and so_det.id_so = '$id_so' and so_det.no_pi_cbd is null ");
         return $hasil->result_array();
     }else{
        $db_nag = $this->load->database('db_nag', TRUE);
        $hasil = $db_nag->query("SELECT so.so_no,so_det.id as id_sodet,supplier, so.so_date, 
            so_det.dest, so_det.color, so_det.size, so_det.qty, so_det.unit, 
            act_costing.deldate, act_costing.curr, masterproduct.product_item, masterproduct.product_group, 
            ROUND(so_det.price,2) AS price, act_costing.styleno ,mastersupplier.Phone,
            ROUND(so_det.price * so_det.qty,2) AS hasilkali,so.tax 
            from 
            so_det INNER JOIN so ON so_det.id_so = so.id
            INNER JOIN act_costing ON so.id_cost = act_costing.id
            INNER JOIN masterproduct ON act_costing.id_product = masterproduct.id
            INNER JOIN mastersupplier on act_costing.id_buyer = mastersupplier.Id_Supplier
            WHERE so_det.cancel='N' and so_det.id_so = '$id_so' ");
        return $hasil->result_array();
    }
}

function update_status_invoice($id_inv, $pph, $tanggal_input, $id_top, $id_bank, $type_so, $no_coa, $nama_coa)
{
    $hasil = $this->db->query("UPDATE tbl_book_invoice 
       SET status  = 'POST', 
       pph     = '$pph', 
       tgl_inv = '$tanggal_input',
       id_top  = '$id_top', 
       id_bank =  '$id_bank', 
       type_so = '$type_so',
       no_coa =  '$no_coa', 
       nama_coa = '$nama_coa'
       WHERE id = '$id_inv' ");
    return $hasil;
}

function update_status_bppb($id, $shipp)
{
        //Database Localhost / SB2
        // $hasil = $this->db->query("UPDATE bppb SET stat_inv = '1' WHERE id = '$id' ");
        // return $hasil;
        //
        //Database SignalBit
    $db_nag = $this->load->database('db_nag', TRUE);
    $db_pgsql = $this->load->database('db_pgsql', TRUE);
    $hasil = $db_nag->query("UPDATE bppb SET stat_inv = '1', id_invoice_ar = '$shipp' WHERE id = '$id' ");
    $hasil2 = $db_pgsql->query("UPDATE official_out_h SET status_inv = '1' WHERE id = '$id' ");
    return [
        'nag' => $hasil1,
        'pgsql' => $hasil2
    ];
}

    //ubah september
function update_currency($curr, $shipp)
{
    $db_nag = $this->load->database('db_nag', TRUE);
    $hasil = $db_nag->query("UPDATE tbl_book_invoice SET curr = '$curr' WHERE id = '$shipp' ");
    return $hasil;
}

    //ubah september
function update_pi_sodet($id_sodet, $no_pi)
{
        //Database Localhost / SB2
        // $hasil = $this->db->query("UPDATE bppb SET stat_inv = '1' WHERE id = '$id' ");
        // return $hasil;
        //
        //Database SignalBit
    $db_nag = $this->load->database('db_nag', TRUE);
    $hasil = $db_nag->query("UPDATE so_det SET no_pi = '$no_pi' WHERE id = '$id_sodet' ");
    return $hasil;
}

     //ubah september
function update_pi_sodet_cbd($id_sodet, $no_pi)
{
        //Database Localhost / SB2
        // $hasil = $this->db->query("UPDATE bppb SET stat_inv = '1' WHERE id = '$id' ");
        // return $hasil;
        //
        //Database SignalBit
    $db_nag = $this->load->database('db_nag', TRUE);
    $hasil = $db_nag->query("UPDATE so_det SET no_pi_cbd = '$no_pi' WHERE id = '$id_sodet' ");
    return $hasil;
}


function simpan_invoice_detail($data)
{
    $this->db->insert_batch('tbl_invoice_detail', $data);
    return $this->db->insert_id();
}

function simpan_invoice_pot($data)
{
    $this->db->insert_batch('tbl_invoice_pot', $data);
    return $this->db->insert_id();
}

function simpan_invoice_detail_temporary($data)
{
    $this->db->insert_batch('tbl_invoice_detail_temp', $data);
    return $this->db->insert_id();
}

function load_invoice_detail_temporary()
{
    $hasil = $this->db->query("SELECT id_bppb, so_number, bppb_number, sj_date, shipp_number, ws, styleno, product_group, product_item, color, size, curr, uom,
      qty, unit_price, disc, total_price
      FROM tbl_invoice_detail_temp");
    return $hasil->result_array();
}

function delete_invoice_detail_temporary()
{
    $hasil = $this->db->query("DELETE FROM tbl_invoice_detail_temp");
    $hasil2 = $this->db->query("DELETE FROM tbl_invoice_detail_knitting_temp");
    return $hasil;
}

function cari_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer, $status)
{

    if ($id_customer != "all_customer") {
        $where = " AND a.id_customer = '$id_customer'";
    }else{
        $where = "";
    }

    if ($status != "all_status") {
        $where2 = " AND a.status = '$status'";
    }else{
        $where2 = "";
    }

    $hasil = $this->db->query("SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, 
      DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS tgl_inv, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, 
      FORMAT((d.grand_total), 2) AS amount
      FROM  tbl_book_invoice AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN
      tbl_invoice_pot AS d ON a.id = d.id_book_invoice  INNER JOIN
      tbl_invoice_detail as e on a.id=e.id_book_invoice      
      WHERE e.sj_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' $where $where2
      ORDER BY a.id ");
    return $hasil->result_array();
    
}

function cari_inv_detail($id)
{
    $hasil = $this->db->query("SELECT a.no_invoice, b.so_number, b.bppb_Number, b.shipp_number, b.ws, b.styleno, b.product_group, 
      b.product_item, b.color, b.size, b.curr, b.uom, b.qty, b.unit_price, b.disc, FORMAT(b.total_price, 2) AS total_price
      FROM tbl_book_invoice AS a INNER JOIN 
      tbl_invoice_detail AS b ON a.id = b.id_book_invoice
      WHERE a.id = '$id' ");
    return $hasil->result_array();
}

function cari_inv_pot($id)
{
    $hasil = $this->db->query("SELECT id_book_invoice, FORMAT(total,2) AS total, FORMAT(discount,2) AS discount, FORMAT(dp,2) AS dp, FORMAT(retur,2) AS retur, FORMAT(twot,2) AS twot, FORMAT(vat,2) AS vat, FORMAT(grand_total,2) AS grand_total
       FROM tbl_invoice_pot
       WHERE id_book_invoice = '$id' ");
    return $hasil->result_array();
}

function report_invoice($id)
{
    $hasil = $this->db->query("SELECT distinct a.no_invoice, LEFT(b.Supplier, 30) AS customer,
      IFNULL(b.alamat, '-') alamat, IFNULL(b.Phone, '-') AS phone, IFNULL(b.Email, '-') AS email,
      DATE_FORMAT(f.sj_date,'%d-%m-%Y') AS tgl_inv, UPPER(c.type) AS type, a.shipp, d.type AS type_top, d.top,
      e.no_rek, e.nama_bank, e.v_bankaddress, e.curr
      FROM tbl_book_invoice AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
      tbl_master_top AS d ON a.id_top = d.id  INNER JOIN 
      masterbank AS e ON a.id_bank = e.id  INNER join
      tbl_invoice_detail as f on a.id=f.id_book_invoice
      WHERE a.id = '$id' ");
    return $hasil->row_array();
}

function report_invoice_detail($id)
{
    $hasil = $this->db->query("SELECT styleno, product_group, product_item, color, size, qty, format(round(unit_price,3),3) unit_price, disc, FORMAT(total_price, 2) AS total_price, uom, curr, id_bppb
       FROM tbl_invoice_detail
       WHERE id_book_invoice = '$id' ORDER BY id_bppb asc ");
    return $hasil->result_array();
}

function report_invoice_pot($id)
{
    $hasil = $this->db->query("SELECT id, id_book_invoice, FORMAT(total, 2) AS total, FORMAT(discount, 2) AS discount, FORMAT(dp, 2) AS dp, 
      FORMAT(retur, 2) AS retur, FORMAT(twot, 2) AS twot, FORMAT(vat, 2) AS vat, FORMAT(grand_total, 2) AS grand_total 
      FROM tbl_invoice_pot 
      WHERE id_book_invoice = '$id' ");
    return $hasil->row_array();
}

function group_bppb_number($id)
{
    $hasil = $this->db->query("SELECT DISTINCT shipp_number as bppb_number
       FROM tbl_invoice_detail
       WHERE id_book_invoice = '$id' ");
    return $hasil->result_array();
}

function group_so_number($id)
{
    $hasil = $this->db->query("SELECT DISTINCT so_number
       FROM tbl_invoice_detail
       WHERE id_book_invoice = '$id' ");
    return $hasil->result_array();
}

function group_curr($id)
{
    $hasil = $this->db->query("SELECT DISTINCT curr
       FROM tbl_invoice_detail
       WHERE id_book_invoice = '$id' ");
    return $hasil->row_array();
}

function load_bank()
{
    $hasil = $this->db->query("SELECT id, kode_bank, nama_bank, curr, no_rek, nama_rek, id_coa, v_company, 
      v_companyaddress, v_branch, v_bankaddress, v_swiftcode
      FROM masterbank ");
    return $hasil->result_array();
}
    //ubah september
function load_ppn()
{
    $hasil = $this->db->query("SELECT idtax, kriteria, percentage, GROUP_CONCAT(kriteria,' (',percentage,'%)') as kriteria2 from mtax where category_tax = 'PPN'  GROUP BY idtax ");
    return $hasil->result_array();
}


function cari_bank($id)
{
    $hasil = $this->db->query("SELECT id, kode_bank, nama_bank, curr, no_rek, nama_rek, id_coa, v_company, 
      v_companyaddress, v_branch, v_bankaddress, v_swiftcode
      FROM masterbank WHERE id = '$id' ");
    return $hasil->row_array();
}

function cari_invoice_post($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT DISTINCT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
      DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer , CONCAT(e.curr, ' ', FORMAT(grand_total,2)) total
      FROM  tbl_book_invoice AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type left JOIN
      tbl_invoice_detail as e on a.id=e.id_book_invoice left JOIN
      tbl_invoice_pot as f on a.id=f.id_book_invoice 
      WHERE a.status = 'POST' AND e.sj_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' ORDER BY a.id asc");
    return $hasil->result_array();
        //
        //With Duedate Query
        //
        // $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
        //                                   DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS tanggal, DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d') AS tanggal_kontrabon, 
        //                                   d.top, CASE WHEN e.status = 'DONE' THEN DATE_ADD(DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d'), INTERVAL d.top DAY) 
        //                                   ELSE DATE_ADD(DATE_FORMAT(a.tgl_inv, '%Y-%m-%d'), INTERVAL d.top DAY) END AS duedate,
        //                                   c.type, a.status, a.id AS id_inv, e.id_invoice AS id_inv_dd, e.status AS status_duedate
        //                            FROM  tbl_book_invoice AS a INNER JOIN 
        //                                   mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        //                                   tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
        //                                   tbl_master_top AS d ON a.id_top = d.id LEFT JOIN
        //                                   tbl_duedate AS e ON a.id = e.id_invoice
        //                            WHERE a.status = 'POST' AND a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' ");
        // return $hasil->result_array();
}


    //ubah september
function cari_proforma_invoice_post($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
      c.type, a.status, a.no_faktur_pajak,  FORMAT(a.total, 2) AS amount
      FROM tbl_invoice_proforma AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
      tbl_invoice_proforma_detail_so AS d ON a.no_proforma_invoice = d.no_invoice_proforma
      WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
      GROUP BY a.no_proforma_invoice");
    return $hasil->result_array();
}

    //ubah september
function cari_debitnote_post($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT a.id,a.no_dn,a.tgl_dn,b.Supplier,a.attn,a.from_curr,a.to_curr,a.amount,a.eqv_curr,a.status from tbl_debitnote_h a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer
       WHERE a.status = 'POST' AND a.tgl_dn BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
       GROUP BY a.no_dn");
    return $hasil->result_array();
}


function cari_invoice_appv($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT DISTINCT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
      DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer
      FROM  tbl_book_invoice AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type left JOIN
      tbl_invoice_detail as e on a.id=e.id_book_invoice 
      WHERE a.status = 'APPROVED' AND e.sj_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' ORDER BY a.id asc");
    return $hasil->result_array();
        //
        //With Duedate Query
        //
        // $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
        //                                   DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS tanggal, DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d') AS tanggal_kontrabon, 
        //                                   d.top, CASE WHEN e.status = 'DONE' THEN DATE_ADD(DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d'), INTERVAL d.top DAY) 
        //                                   ELSE DATE_ADD(DATE_FORMAT(a.tgl_inv, '%Y-%m-%d'), INTERVAL d.top DAY) END AS duedate,
        //                                   c.type, a.status, a.id AS id_inv, e.id_invoice AS id_inv_dd, e.status AS status_duedate
        //                            FROM  tbl_book_invoice AS a INNER JOIN 
        //                                   mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        //                                   tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
        //                                   tbl_master_top AS d ON a.id_top = d.id LEFT JOIN
        //                                   tbl_duedate AS e ON a.id = e.id_invoice
        //                            WHERE a.status = 'POST' AND a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' ");
        // return $hasil->result_array();
}

function approve_invoice($id)
{
    $hasil = $this->db->query("UPDATE tbl_book_invoice SET status = 'APPROVED' WHERE id = '$id' ");

    $query = $this->db->query("SELECT no_invoice FROM tbl_book_invoice WHERE id = '$id'");
    $row = $query->row();
    $no_invoice = $row->no_invoice;

    if (strpos($no_invoice, 'NAK') !== false) {
        $inv_pot = 'NAK_pot';
        $inv_credit = 'NAK_credit';
    } else {
        $inv_pot = 'INV_pot';
        $inv_credit = 'INV_credit';
    }

    $this->db->query("insert into tbl_list_journal select '', a.* from (select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, no_coa, nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, grand_total debit, 0 credit, (grand_total * COALESCE(rate,1)) debit_idr, 0 credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '' approve_by,'' approve_date,'' cancel_by,'' cancel_date,'' created_at,'' updated_at, a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a INNER JOIN (SELECT no_coa, nama_coa, shipp_tipe, so_tipe, cus_ctg, grade from mastercoa_v2 where inv_type like '%INV_debit%') b on b.shipp_tipe = a.shipp and b.so_tipe LIKE CONCAT('%', a.type_so, '%') and b.cus_ctg LIKE CONCAT('%', a.supplier_ctg, '%') and b.grade LIKE CONCAT('%', a.grade, '%') LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr
        UNION
        select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, no_coa, nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, discount debit, 0 credit, (discount * COALESCE(rate,1)) debit_idr, 0 credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '','','','','','', a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a INNER JOIN (SELECT no_coa, nama_coa, shipp_tipe, so_tipe, cus_ctg, grade from mastercoa_v2 where inv_type like '%$inv_pot%') b on b.shipp_tipe = a.shipp and b.so_tipe LIKE CONCAT('%', a.type_so, '%') and b.cus_ctg LIKE CONCAT('%', a.supplier_ctg, '%') and b.grade LIKE CONCAT('%', a.grade, '%') LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr
        UNION
        select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, no_coa, nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, dp debit, 0 credit, (dp * COALESCE(rate,1)) debit_idr, 0 credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '','','','','','', a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a INNER JOIN (SELECT no_coa, nama_coa, shipp_tipe, so_tipe, cus_ctg, grade from mastercoa_v2 where inv_type like '%DP%') b on b.shipp_tipe = a.shipp  LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr
        UNION
        select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, no_coa, nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, 0 debit, total credit, 0 debit_idr, (total * COALESCE(rate,1)) credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '','','','','','', a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a INNER JOIN (SELECT no_coa, nama_coa, shipp_tipe, so_tipe, cus_ctg, grade from mastercoa_v2 where inv_type like '%$inv_credit%') b on b.shipp_tipe = a.shipp and b.so_tipe LIKE CONCAT('%', a.type_so, '%') and b.cus_ctg LIKE CONCAT('%', a.supplier_ctg, '%') and b.grade LIKE CONCAT('%', a.grade, '%') LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr
        UNION
        select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, '2.53.01' no_coa, 'PPN KELUARAN' nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, 0 debit, vat credit, 0 debit_idr, (vat * COALESCE(rate,1)) credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '','','','','','', a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr) a where debit > 0 OR credit > 0");
return $hasil;
}

    //ubah september
function approve_profinvoice($id)
{
    $hasil = $this->db->query("UPDATE tbl_invoice_proforma SET status = 'APPROVED' WHERE id = '$id' ");
    return $hasil;
}

    //ubah september
function approve_debitnote($id)
{
    $hasil = $this->db->query("UPDATE tbl_debitnote_h SET status = 'APPROVED' WHERE id = '$id' ");
    return $hasil;
}

    //DueDate

function get_kode_duedate()
{
    $q = $this->db->query("SELECT MAX(RIGHT(no_duedate, 4)) AS kd_max 
       FROM tbl_duedate
       WHERE YEAR(input_date) = YEAR(CURRENT_DATE()) ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
    } else {
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return "AD/NAG/" . date('my') . "/" . $kd;
}

function cari_invoice_duedate($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
        //Old
        // $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, 
        //                                   DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, d.top, 
        //                                   DATE_ADD(a.tgl_inv, INTERVAL d.top DAY) AS duedate, e.no_duedate, e.id_invoice
        //                            FROM  tbl_book_invoice AS a INNER JOIN 
        //                                    mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        //                                    tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
        //                                    tbl_master_top AS d ON a.id_top = d.id LEFT JOIN 
        //                                    tbl_duedate AS e ON a.no_duedate = e.no_duedate
        //                             WHERE a.status = 'APPROVED' AND a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
        //                                    AND a.id_customer = '$id_customer' AND (ISNULL(a.no_duedate) OR a.no_duedate = '' OR e.status = 'CANCEL')");
        // return $hasil->result_array();

    $hasil = $this->db->query("SELECT DISTINCT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, 
      DATE_FORMAT(f.sj_date, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, d.top, 
      DATE_ADD(a.tgl_inv, INTERVAL d.top DAY) AS duedate, e.no_duedate, e.id_invoice
      FROM  tbl_book_invoice AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
      tbl_master_top AS d ON a.id_top = d.id LEFT JOIN 
      tbl_duedate AS e ON a.no_duedate = e.no_duedate left JOIN
      tbl_invoice_detail as f on a.id = f.id_book_invoice
      WHERE a.status = 'APPROVED' AND f.sj_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
      AND a.id_customer = '$id_customer' AND (ISNULL(a.no_duedate) OR a.no_duedate = '' OR e.status = 'CANCEL') group by a.no_invoice ORDER BY a.id asc");
    return $hasil->result_array();
}

function save_duedate($data)
{
    $this->db->insert_batch('tbl_duedate', $data);
    return $this->db->insert_id();
}

function update_duedate_bookinvoice($id_inv, $no_duedate)
{
    $hasil = $this->db->query("UPDATE tbl_book_invoice SET no_duedate  = '$no_duedate' WHERE id = '$id_inv' ");
    return $hasil;
}

function load_duedate_invoice()
{
    $hasil = $this->db->query("SELECT distinct e.id, e.no_duedate, DATE_FORMAT(f.sj_date, '%Y-%m-%d') AS invoice_date, 
      DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d') AS kontrabon_date, d.top, DATE_ADD(DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d'), INTERVAL d.top DAY) AS duedate,
      a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, c.type,  a.status, e.status
      FROM  tbl_book_invoice AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
      tbl_master_top AS d ON a.id_top = d.id INNER JOIN 
      tbl_duedate AS e ON a.id = e.id_invoice INNER JOIN
      tbl_invoice_detail as f on a.id = f.id_book_invoice
      WHERE a.status = 'APPROVED' ");
    return $hasil->result_array();
}

function cancel_duedate($id)
{
    $hasil = $this->db->query("UPDATE tbl_duedate SET status = 'CANCEL' WHERE id = '$id' ");
    return $hasil;
}

    //Proforma Invoice

function get_kode_proforma_invoice($kode_inv)
{
    $q = $this->db->query("SELECT no_proforma_invoice, MAX(LEFT(no_proforma_invoice, 4)) AS kd_max 
       FROM tbl_invoice_proforma 
       WHERE YEAR(tgl_proforma_inv) = YEAR(CURRENT_DATE()) AND MONTH(tgl_proforma_inv) = MONTH(CURRENT_DATE()) AND STATUS <> 'CANCEL' ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
    } else {
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return $kd . "/$kode_inv/NAG/" . date('my');
}

    //ubah september
function get_kode_proforma_invoice_cbd($kode_inv,$type)
{
    $q = $this->db->query("SELECT no_proforma_invoice, MAX(LEFT(no_proforma_invoice, 4)) AS kd_max 
       FROM tbl_invoice_proforma_dp_cbd 
       WHERE YEAR(tgl_proforma_inv) = YEAR(CURRENT_DATE()) AND MONTH(tgl_proforma_inv) = MONTH(CURRENT_DATE()) AND STATUS <> 'CANCEL' ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
    } else {
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    if($type == 'CBD'){
       return $kd . "/C/$kode_inv/NAG/" . date('my'); 
   }elseif($type == 'DP'){
       return $kd . "/D/$kode_inv/NAG/" . date('my'); 
   }else{
    return $kd . "//$kode_inv/NAG/" . date('my');
}
}

    //ubah september
function get_kode_cbd($kode)
{
    $q = $this->db->query("SELECT no_proforma_invoice, MAX(LEFT(no_proforma_invoice, 4)) AS kd_max 
       FROM tbl_invoice_proforma_dp_cbd 
       WHERE YEAR(tgl_proforma_inv) = YEAR(CURRENT_DATE()) AND MONTH(tgl_proforma_inv) = MONTH(CURRENT_DATE()) AND STATUS <> 'CANCEL' ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
    } else {
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return $kd . "/$kode//NAG/" . date('my');
}


    //ubah september
function cari_so_proforma($dt_dari_so_prof, $dt_sampai_so_prof, $id_customer)
{
        //Database Localhost / SB2  
        // $hasil = $this->db->query("SELECT a.so_no, a.so_date, c.Supplier, a.buyerno, e.curr,
        //                                   FORMAT(SUM(b.qty), 2) AS qty, FORMAT(SUM(e.price), 2) AS unit_price, FORMAT(SUM(b.qty) * SUM(e.price), 2) AS total_price, b.id_so
        //                            FROM so_det AS b INNER JOIN so AS a 
        //                                   ON (b.id_so = a.id) INNER JOIN 
        //                                   act_costing AS d ON (a.id_cost = d.id) INNER JOIN 
        //                                   mastersupplier AS c ON (c.Id_Supplier = d.id_buyer) INNER JOIN 
        //                                   bppb AS e ON (e.id_so_det = b.id) 
        //                            WHERE c.Id_Supplier = '$id_customer' AND a.so_date BETWEEN '$dt_dari_so_prof' AND '$dt_sampai_so_prof' AND c.tipe_sup = 'C'
        //                            GROUP BY b.id_so
        //                            ORDER BY b.id_so ");
        // return $hasil->result_array();
        //
        //Database SignalBit
    $db_nag = $this->load->database('db_nag', TRUE);
    $hasil = $db_nag->query("SELECT * from (SELECT a.so_no, a.so_date, c.Supplier, a.buyerno, a.curr,
       FORMAT(sum(b.qty), 2) AS qty, FORMAT(b.price, 2) AS unit_price, FORMAT(sum(b.qty * b.price), 2) AS total_price, b.id_so
       FROM so_det AS b INNER JOIN so AS a 
       ON (b.id_so = a.id) INNER JOIN 
       act_costing AS d ON (a.id_cost = d.id) INNER JOIN 
       mastersupplier AS c ON (c.Id_Supplier = d.id_buyer)
       WHERE c.Id_Supplier = '$id_customer' AND a.so_date BETWEEN '$dt_dari_so_prof' AND '$dt_sampai_so_prof' AND c.tipe_sup = 'C'
       GROUP BY b.id_so
       ORDER BY b.id_so) so_cbd inner join
    (Select so_no as sono,COUNT(so_no) as jml from (SELECT so.so_no,so_det.id as id_sodet,supplier, so.so_date, 
       so_det.dest, so_det.color, so_det.size, so_det.qty, so_det.unit, 
       act_costing.deldate, act_costing.curr, masterproduct.product_item, masterproduct.product_group, 
       ROUND(so_det.price,2) AS price, act_costing.styleno ,mastersupplier.Phone,
       ROUND(so_det.price * so_det.qty,2) AS hasilkali,so.tax
       from 
       so_det INNER JOIN so ON so_det.id_so = so.id
       INNER JOIN act_costing ON so.id_cost = act_costing.id
       INNER JOIN masterproduct ON act_costing.id_product = masterproduct.id
       INNER JOIN mastersupplier on act_costing.id_buyer = mastersupplier.Id_Supplier
       WHERE so_det.cancel='N' and so_det.no_pi is null) a group by a.so_no) sj_cbd on sj_cbd.sono = so_cbd.so_no ");
    return $hasil->result_array();
}

function cari_so_proforma_cbd($dt_dari_so_prof, $dt_sampai_so_prof, $id_customer)
{
    $db_nag = $this->load->database('db_nag', TRUE);
    $hasil = $db_nag->query("SELECT * from (SELECT a.so_no, a.so_date, c.Supplier, a.buyerno, a.curr,
       FORMAT(sum(b.qty), 2) AS qty, FORMAT(b.price, 2) AS unit_price, FORMAT(sum(b.qty * b.price), 2) AS total_price, b.id_so
       FROM so_det AS b INNER JOIN so AS a 
       ON (b.id_so = a.id) INNER JOIN 
       act_costing AS d ON (a.id_cost = d.id) INNER JOIN 
       mastersupplier AS c ON (c.Id_Supplier = d.id_buyer)
       WHERE c.Id_Supplier = '$id_customer' AND a.so_date BETWEEN '$dt_dari_so_prof' AND '$dt_sampai_so_prof' AND c.tipe_sup = 'C'
       GROUP BY b.id_so
       ORDER BY b.id_so) so_cbd inner join
    (Select so_no as sono,COUNT(so_no) as jml from (SELECT so.so_no,so_det.id as id_sodet,supplier, so.so_date, 
       so_det.dest, so_det.color, so_det.size, so_det.qty, so_det.unit, 
       act_costing.deldate, act_costing.curr, masterproduct.product_item, masterproduct.product_group, 
       ROUND(so_det.price,2) AS price, act_costing.styleno ,mastersupplier.Phone,
       ROUND(so_det.price * so_det.qty,2) AS hasilkali,so.tax
       from 
       so_det INNER JOIN so ON so_det.id_so = so.id
       INNER JOIN act_costing ON so.id_cost = act_costing.id
       INNER JOIN masterproduct ON act_costing.id_product = masterproduct.id
       INNER JOIN mastersupplier on act_costing.id_buyer = mastersupplier.Id_Supplier
       WHERE so_det.cancel='N') a group by a.so_no) sj_cbd on sj_cbd.sono = so_cbd.so_no ");
    return $hasil->result_array();
}

function simpan_invoice_detail_proforma_temporary($data)
{
    $this->db->insert_batch('tbl_invoice_proforma_detail_temp', $data);
    return $this->db->insert_id();
}

    //ubah september
function simpan_so_detail_proforma_temporary($data)
{
    $this->db->insert_batch('tbl_so_det_proforma_temp', $data);
    return $this->db->insert_id();
}

function load_invoice_detail_proforma_temporary()
{
    $hasil = $this->db->query("SELECT id_so, so_no, DATE_FORMAT(so_date, '%Y-%m-%d') AS so_date, buyerno, curr, FORMAT(qty, 2) AS qty, 
      FORMAT(unit_price, 2) AS unit_price, FORMAT(total_price, 2) AS total_price 
      FROM tbl_invoice_proforma_detail_temp");
    return $hasil->result_array();
}

    //ubah september
function load_so_detail_proforma_temporary()
{
    $hasil = $this->db->query("SELECT id_so_det, no_so, produk_det, curr, FORMAT(qty, 2) AS qty, uom,
      FORMAT(price, 2) AS unit_price, FORMAT(total, 2) AS total_price 
      FROM tbl_so_det_proforma_temp");
    return $hasil->result_array();
}

function sum_grandtotal_proforma()
{
    $hasil = $this->db->query("SELECT Round(SUM(total), 2) AS grand_total
       FROM tbl_so_det_proforma_temp");
    return $hasil->result_array();
}

function delete_invoice_detail_proforma_temporary()
{
    $hasil = $this->db->query("DELETE FROM tbl_invoice_proforma_detail_temp");
    return $hasil;
}

    //ubah september
function delete_so_detail_proforma_temporary()
{
    $hasil = $this->db->query("DELETE FROM tbl_so_det_proforma_temp");
    return $hasil;
}

function simpan_proforma_invoice_header($data)
{
    $this->db->insert_batch('tbl_invoice_proforma', $data);
    return $this->db->insert_id();
}
    //ubah september
function simpan_proforma_invoice_header_cbd($data)
{
    $this->db->insert_batch('tbl_invoice_proforma_dp_cbd', $data);
    return $this->db->insert_id();
}

function simpan_proforma_invoice_detail($data)
{
    $this->db->insert_batch('tbl_invoice_proforma_detail', $data);
    return $this->db->insert_id();
}

    //ubah september
function simpan_proforma_invoice_detail_cbd($data)
{
    $this->db->insert_batch('tbl_invoice_proforma_detail_dp_cbd', $data);
    return $this->db->insert_id();
}

    //ubah september
function simpan_proforma_invoice_detail_so($data)
{
    $this->db->insert_batch('tbl_invoice_proforma_detail_so', $data);
    return $this->db->insert_id();
}

    //ubah september
function simpan_proforma_invoice_detail_so_cbd($data)
{
    $this->db->insert_batch('tbl_invoice_proforma_detail_so_dp_cbd', $data);
    return $this->db->insert_id();
}

function cari_proforma_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
{

    if ($id_customer == "all_customer") {
        $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
          c.type, a.status, a.no_faktur_pajak,  FORMAT(a.total, 2) AS amount
          FROM tbl_invoice_proforma AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
          tbl_invoice_proforma_detail_so AS d ON a.no_proforma_invoice = d.no_invoice_proforma
          WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
          GROUP BY a.no_proforma_invoice ");
        return $hasil->result_array();
    } else {
        $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
          c.type, a.status, a.no_faktur_pajak,  FORMAT(a.total, 2) AS amount
          FROM tbl_invoice_proforma AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
          tbl_invoice_proforma_detail_so AS d ON a.no_proforma_invoice = d.no_invoice_proforma
          WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND a.id_customer = '$id_customer' 
          GROUP BY a.no_proforma_invoice ");
        return $hasil->result_array();
    }
}

    //ubah september
function cari_proforma_invoice_cbd($dt_dari_inv, $dt_sampai_inv, $id_customer)
{

    if ($id_customer == "all_customer") {
        $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
          c.type, a.status, a.no_faktur_pajak,  FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',(a.total * (a.dp/100)),a.dp)), 2) AS amount
          FROM tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
          tbl_invoice_proforma_detail_dp_cbd AS d ON a.no_proforma_invoice = d.no_invoice_proforma
          WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
          GROUP BY a.no_proforma_invoice ");
        return $hasil->result_array();
    } else {
        $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
          c.type, a.status, a.no_faktur_pajak, FORMAT(IF(a.dp = '0',a.total,a.dp), 2) AS amount
          FROM tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
          tbl_invoice_proforma_detail_dp_cbd AS d ON a.no_proforma_invoice = d.no_invoice_proforma
          WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND a.id_customer = '$id_customer' 
          GROUP BY a.no_proforma_invoice ");
        return $hasil->result_array();
    }
}


    //ubah september
function cari_debit_note($dt_dari_inv, $dt_sampai_inv, $id_customer)
{

    if ($id_customer == "all_customer") {
        $hasil = $this->db->query("SELECT * FROM (SELECT a.id,a.no_dn,a.tgl_dn,b.Supplier,a.attn,a.from_curr,a.to_curr,a.amount,a.eqv_curr,a.status from tbl_debitnote_h a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer
           WHERE a.tgl_dn BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
           GROUP BY a.no_dn) a left join
        (SELECT no_dn nodn,IF(nodn is null,'OTHER','MEMO') type_dn from (select DISTINCT a.no_dn,b.no_dn nodn from tbl_debitnote_det a left join memo_det b on a.no_dn = b.no_dn) a) b on b.nodn = a.no_dn ");
        return $hasil->result_array();
    } else {
        $hasil = $this->db->query("SELECT * FROM (SELECT a.id,a.no_dn,a.tgl_dn,b.Supplier,a.attn,a.from_curr,a.to_curr,a.amount,a.eqv_curr,a.status from tbl_debitnote_h a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer
           WHERE a.tgl_dn BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND a.customer = '$id_customer' 
           GROUP BY a.no_dn ) a left join
        (SELECT no_dn nodn,IF(nodn is null,'OTHER','MEMO') type_dn from (select DISTINCT a.no_dn,b.no_dn nodn from tbl_debitnote_det a left join memo_det b on a.no_dn = b.no_dn) a) b on b.nodn = a.no_dn");
        return $hasil->result_array();
    }
}


function update_faktur_pajak($id, $faktur_pjk)
{
    $hasil = $this->db->query("UPDATE tbl_invoice_proforma SET no_faktur_pajak = '$faktur_pjk' WHERE id = '$id' ");
    return $hasil;
}

function update_faktur_pajak_cbd($id, $faktur_pjk)
{
    $hasil = $this->db->query("UPDATE tbl_invoice_proforma_dp_cbd SET no_faktur_pajak = '$faktur_pjk' WHERE id = '$id' ");
    return $hasil;
}

function report_proforma_invoice($id)
{
    $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
      UPPER(c.type) AS type, a.status, a.no_faktur_pajak, LEFT(IFNULL(b.alamat, '-'), 27) AS alamat, 
      IFNULL(b.Phone, '-') AS phone, d.no_rek, d.nama_bank, d.v_bankaddress, d.curr
      FROM tbl_invoice_proforma AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
      masterbank AS d ON a.id_bank = d.id
      WHERE a.id = '$id' ");
    return $hasil->row_array();
}
    //ubah september
function report_proforma_invoice_cbd($id)
{
    $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
      UPPER(c.type) AS type, a.status, a.no_faktur_pajak, LEFT(IFNULL(b.alamat, '-'), 27) AS alamat, 
      IFNULL(b.Phone, '-') AS phone, d.no_rek, d.nama_bank, d.v_bankaddress, d.curr
      FROM tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
      masterbank AS d ON a.id_bank = d.id
      WHERE a.id = '$id' ");
    return $hasil->row_array();
}
    //ubah september
function report_proforma_invoice_tot_dp($id)
{
    $hasil = $this->db->query("SELECT IF(a.dp = '0','CBD','DP') as type ,FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',(a.total * (a.dp/100)),a.dp)), 2) AS amount
       FROM tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
       mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
       tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
       tbl_invoice_proforma_detail_dp_cbd AS d ON a.no_proforma_invoice = d.no_invoice_proforma where a.id = '$id' GROUP BY a.no_proforma_invoice ");
    return $hasil->row_array();
}


    //ubah september
function report_debit_note($id)
{
    $hasil = $this->db->query("SELECT a.id, a.no_dn, DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS tgl_dn, b.supplier AS customer, a.attn,a.alamat,header1,header2,header3,IF(header1 != '',1,0) as data1, IF(header2 != '',1,0) as data2, IF(header3 != '',1,0) as data3,from_curr,to_curr,FORMAT(a.amount,2) as amount2,FORMAT(a.eqv_curr,2) as eqv_curr, c.beneficiary_name,c.bank_name,c.beneficiary_address,bank_account,c.swift_code, c.bank_address
       FROM tbl_debitnote_h AS a INNER JOIN 
       mastersupplier AS b ON a.customer = b.Id_Supplier inner join
       b_masterbank c on c.bank_account = a.akun  
       WHERE a.id = '$id'");
    return $hasil->row_array();
}
    //ubah september
    // function report_debit_note_det($id)
    // {
    //     $hasil = $this->db->query("SELECT b.id, a.deskripsi, a.supplier, a.supplier_invoice, a.header1, a.header2, a.header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2
    //                                FROM tbl_debitnote_det AS a INNER JOIN 
    //                                       tbl_debitnote_h AS b ON a.no_dn = b.no_dn 
    //                                WHERE b.id = '$id'");
    //     return $hasil->result_array();
    // }
    //ubah september
function report_debit_note_det($id)
{
    $hasil = $this->db->query("SELECT *
        FROM (
            SELECT 
            b.id,
            a.id AS id_det,
            a.deskripsi,
            a.supplier,
            a.supplier_invoice,
            SPLIT_STRING(a.header1, ',', n.n) AS header1,
            SPLIT_STRING(a.header2, ',', n.n) AS header2,
            SPLIT_STRING(a.header3, ',', n.n) AS header3,
            FORMAT(a.value, 2) AS amount,
            FORMAT(a.rate, 2) AS rate,
            FORMAT(a.amount, 2) AS amount2,
            n.n AS nomor
            FROM tbl_debitnote_det AS a
            INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn
            JOIN (
                WITH RECURSIVE numbers AS (
                    SELECT 1 AS n
                    UNION ALL
                    SELECT n + 1 FROM numbers WHERE n < 70
                    )
                SELECT * FROM numbers) AS n
            WHERE b.id = '$id'
            ) AS hasil
        WHERE hasil.header1 != '' OR hasil.header2 != '' OR hasil.header3 != ''
        ORDER BY hasil.id_det, hasil.supplier_invoice, hasil.nomor ASC;
        ");
    return $hasil->result_array();
}

    //,c.supplier_invoice,c.nomor

    //ubah kini2
function report_debit_note_det2($id)
{
    $hasil = $this->db->query("SELECT id_det,deskripsi,supplier,supplier_invoice,amount,rate,amount2,COUNT(header1) as jumlah,header1,header2,header3 FROM (SELECT * FROM (SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',1) header1, SPLIT_STRING(a.header2,',',1) header2, SPLIT_STRING(a.header3,',',1) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,1 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',2) header1, SPLIT_STRING(a.header2,',',2) header2, SPLIT_STRING(a.header3,',',2) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,2 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',3) header1, SPLIT_STRING(a.header2,',',3) header2, SPLIT_STRING(a.header3,',',3) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,3 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',4) header1, SPLIT_STRING(a.header2,',',4) header2, SPLIT_STRING(a.header3,',',4) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,4 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',5) header1, SPLIT_STRING(a.header2,',',5) header2, SPLIT_STRING(a.header3,',',5) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,5 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',6) header1, SPLIT_STRING(a.header2,',',6) header2, SPLIT_STRING(a.header3,',',6) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,6 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',7) header1, SPLIT_STRING(a.header2,',',7) header2, SPLIT_STRING(a.header3,',',7) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,7 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',8) header1, SPLIT_STRING(a.header2,',',8) header2, SPLIT_STRING(a.header3,',',8) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,8 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',9) header1, SPLIT_STRING(a.header2,',',9) header2, SPLIT_STRING(a.header3,',',9) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,9 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',10) header1, SPLIT_STRING(a.header2,',',10) header2, SPLIT_STRING(a.header3,',',10) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,10 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',11) header1, SPLIT_STRING(a.header2,',',11) header2, SPLIT_STRING(a.header3,',',11) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,11 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',12) header1, SPLIT_STRING(a.header2,',',12) header2, SPLIT_STRING(a.header3,',',12) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,12 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',13) header1, SPLIT_STRING(a.header2,',',13) header2, SPLIT_STRING(a.header3,',',13) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,13 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',14) header1, SPLIT_STRING(a.header2,',',14) header2, SPLIT_STRING(a.header3,',',14) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,14 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',15) header1, SPLIT_STRING(a.header2,',',15) header2, SPLIT_STRING(a.header3,',',15) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,15 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',16) header1, SPLIT_STRING(a.header2,',',16) header2, SPLIT_STRING(a.header3,',',16) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,16 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',17) header1, SPLIT_STRING(a.header2,',',17) header2, SPLIT_STRING(a.header3,',',17) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,17 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',18) header1, SPLIT_STRING(a.header2,',',18) header2, SPLIT_STRING(a.header3,',',18) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,18 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',19) header1, SPLIT_STRING(a.header2,',',19) header2, SPLIT_STRING(a.header3,',',19) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,19 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',20) header1, SPLIT_STRING(a.header2,',',20) header2, SPLIT_STRING(a.header3,',',20) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,20 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',21) header1, SPLIT_STRING(a.header2,',',21) header2, SPLIT_STRING(a.header3,',',21) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,21 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',22) header1, SPLIT_STRING(a.header2,',',22) header2, SPLIT_STRING(a.header3,',',22) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,22 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',23) header1, SPLIT_STRING(a.header2,',',23) header2, SPLIT_STRING(a.header3,',',23) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,23 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',24) header1, SPLIT_STRING(a.header2,',',24) header2, SPLIT_STRING(a.header3,',',24) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,24 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',25) header1, SPLIT_STRING(a.header2,',',25) header2, SPLIT_STRING(a.header3,',',25) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,25 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',26) header1, SPLIT_STRING(a.header2,',',26) header2, SPLIT_STRING(a.header3,',',26) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,26 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',27) header1, SPLIT_STRING(a.header2,',',27) header2, SPLIT_STRING(a.header3,',',27) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,27 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',28) header1, SPLIT_STRING(a.header2,',',28) header2, SPLIT_STRING(a.header3,',',28) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,28 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',29) header1, SPLIT_STRING(a.header2,',',29) header2, SPLIT_STRING(a.header3,',',29) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,29 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',30) header1, SPLIT_STRING(a.header2,',',30) header2, SPLIT_STRING(a.header3,',',30) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,30 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',31) header1, SPLIT_STRING(a.header2,',',31) header2, SPLIT_STRING(a.header3,',',31) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,31 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',32) header1, SPLIT_STRING(a.header2,',',32) header2, SPLIT_STRING(a.header3,',',32) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,32 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',33) header1, SPLIT_STRING(a.header2,',',33) header2, SPLIT_STRING(a.header3,',',33) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,33 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',34) header1, SPLIT_STRING(a.header2,',',34) header2, SPLIT_STRING(a.header3,',',34) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,34 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',35) header1, SPLIT_STRING(a.header2,',',35) header2, SPLIT_STRING(a.header3,',',35) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,35 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',36) header1, SPLIT_STRING(a.header2,',',36) header2, SPLIT_STRING(a.header3,',',36) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,36 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',37) header1, SPLIT_STRING(a.header2,',',37) header2, SPLIT_STRING(a.header3,',',37) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,37 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',38) header1, SPLIT_STRING(a.header2,',',38) header2, SPLIT_STRING(a.header3,',',38) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,38 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',39) header1, SPLIT_STRING(a.header2,',',39) header2, SPLIT_STRING(a.header3,',',39) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,39 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',40) header1, SPLIT_STRING(a.header2,',',40) header2, SPLIT_STRING(a.header3,',',40) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,40 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',41) header1, SPLIT_STRING(a.header2,',',41) header2, SPLIT_STRING(a.header3,',',41) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,41 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',42) header1, SPLIT_STRING(a.header2,',',42) header2, SPLIT_STRING(a.header3,',',42) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,42 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',43) header1, SPLIT_STRING(a.header2,',',43) header2, SPLIT_STRING(a.header3,',',43) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,43 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',44) header1, SPLIT_STRING(a.header2,',',44) header2, SPLIT_STRING(a.header3,',',44) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,44 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',45) header1, SPLIT_STRING(a.header2,',',45) header2, SPLIT_STRING(a.header3,',',45) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,45 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',46) header1, SPLIT_STRING(a.header2,',',46) header2, SPLIT_STRING(a.header3,',',46) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,46 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',47) header1, SPLIT_STRING(a.header2,',',47) header2, SPLIT_STRING(a.header3,',',47) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,47 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',48) header1, SPLIT_STRING(a.header2,',',48) header2, SPLIT_STRING(a.header3,',',48) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,48 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',49) header1, SPLIT_STRING(a.header2,',',49) header2, SPLIT_STRING(a.header3,',',49) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,49 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',50) header1, SPLIT_STRING(a.header2,',',50) header2, SPLIT_STRING(a.header3,',',50) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,50 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',51) header1, SPLIT_STRING(a.header2,',',51) header2, SPLIT_STRING(a.header3,',',51) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,51 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',52) header1, SPLIT_STRING(a.header2,',',52) header2, SPLIT_STRING(a.header3,',',52) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,52 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',53) header1, SPLIT_STRING(a.header2,',',53) header2, SPLIT_STRING(a.header3,',',53) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,53 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id' union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',54) header1, SPLIT_STRING(a.header2,',',54) header2, SPLIT_STRING(a.header3,',',54) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,54 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn where b.id = '$id') b ) c GROUP BY c.id_det ORDER BY c.id_det asc");
return $hasil->result_array();
}

//     function report_debit_note_det_memo($id)
//     {
//         $hasil = $this->db->query("SELECT id_det,deskripsi,supplier,supplier_invoice,amount,rate,amount2,COUNT(header1) as jumlah,header1,header2,header3 FROM (SELECT * FROM (SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',1) header1, SPLIT_STRING(a.header2,',',1) header2, SPLIT_STRING(a.header3,',',1) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,1 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',2) header1, SPLIT_STRING(a.header2,',',2) header2, SPLIT_STRING(a.header3,',',2) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,2 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',3) header1, SPLIT_STRING(a.header2,',',3) header2, SPLIT_STRING(a.header3,',',3) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,3 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',4) header1, SPLIT_STRING(a.header2,',',4) header2, SPLIT_STRING(a.header3,',',4) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,4 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',5) header1, SPLIT_STRING(a.header2,',',5) header2, SPLIT_STRING(a.header3,',',5) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,5 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',6) header1, SPLIT_STRING(a.header2,',',6) header2, SPLIT_STRING(a.header3,',',6) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,6 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',7) header1, SPLIT_STRING(a.header2,',',7) header2, SPLIT_STRING(a.header3,',',7) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,7 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',8) header1, SPLIT_STRING(a.header2,',',8) header2, SPLIT_STRING(a.header3,',',8) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,8 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',9) header1, SPLIT_STRING(a.header2,',',9) header2, SPLIT_STRING(a.header3,',',9) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,9 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',10) header1, SPLIT_STRING(a.header2,',',10) header2, SPLIT_STRING(a.header3,',',10) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,10 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',11) header1, SPLIT_STRING(a.header2,',',11) header2, SPLIT_STRING(a.header3,',',11) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,11 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',12) header1, SPLIT_STRING(a.header2,',',12) header2, SPLIT_STRING(a.header3,',',12) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,12 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',13) header1, SPLIT_STRING(a.header2,',',13) header2, SPLIT_STRING(a.header3,',',13) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,13 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',14) header1, SPLIT_STRING(a.header2,',',14) header2, SPLIT_STRING(a.header3,',',14) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,14 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',15) header1, SPLIT_STRING(a.header2,',',15) header2, SPLIT_STRING(a.header3,',',15) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,15 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',16) header1, SPLIT_STRING(a.header2,',',16) header2, SPLIT_STRING(a.header3,',',16) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,16 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',17) header1, SPLIT_STRING(a.header2,',',17) header2, SPLIT_STRING(a.header3,',',17) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,17 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',18) header1, SPLIT_STRING(a.header2,',',18) header2, SPLIT_STRING(a.header3,',',18) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,18 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',19) header1, SPLIT_STRING(a.header2,',',19) header2, SPLIT_STRING(a.header3,',',19) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,19 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',20) header1, SPLIT_STRING(a.header2,',',20) header2, SPLIT_STRING(a.header3,',',20) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,20 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',21) header1, SPLIT_STRING(a.header2,',',21) header2, SPLIT_STRING(a.header3,',',21) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,21 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',22) header1, SPLIT_STRING(a.header2,',',22) header2, SPLIT_STRING(a.header3,',',22) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,22 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',23) header1, SPLIT_STRING(a.header2,',',23) header2, SPLIT_STRING(a.header3,',',23) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,23 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',24) header1, SPLIT_STRING(a.header2,',',24) header2, SPLIT_STRING(a.header3,',',24) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,24 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',25) header1, SPLIT_STRING(a.header2,',',25) header2, SPLIT_STRING(a.header3,',',25) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,25 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',26) header1, SPLIT_STRING(a.header2,',',26) header2, SPLIT_STRING(a.header3,',',26) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,26 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',27) header1, SPLIT_STRING(a.header2,',',27) header2, SPLIT_STRING(a.header3,',',27) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,27 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',28) header1, SPLIT_STRING(a.header2,',',28) header2, SPLIT_STRING(a.header3,',',28) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,28 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',29) header1, SPLIT_STRING(a.header2,',',29) header2, SPLIT_STRING(a.header3,',',29) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,29 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',30) header1, SPLIT_STRING(a.header2,',',30) header2, SPLIT_STRING(a.header3,',',30) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,30 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',31) header1, SPLIT_STRING(a.header2,',',31) header2, SPLIT_STRING(a.header3,',',31) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,31 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',32) header1, SPLIT_STRING(a.header2,',',32) header2, SPLIT_STRING(a.header3,',',32) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,32 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',33) header1, SPLIT_STRING(a.header2,',',33) header2, SPLIT_STRING(a.header3,',',33) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,33 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',34) header1, SPLIT_STRING(a.header2,',',34) header2, SPLIT_STRING(a.header3,',',34) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,34 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',35) header1, SPLIT_STRING(a.header2,',',35) header2, SPLIT_STRING(a.header3,',',35) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,35 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',36) header1, SPLIT_STRING(a.header2,',',36) header2, SPLIT_STRING(a.header3,',',36) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,36 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',37) header1, SPLIT_STRING(a.header2,',',37) header2, SPLIT_STRING(a.header3,',',37) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,37 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',38) header1, SPLIT_STRING(a.header2,',',38) header2, SPLIT_STRING(a.header3,',',38) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,38 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',39) header1, SPLIT_STRING(a.header2,',',39) header2, SPLIT_STRING(a.header3,',',39) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,39 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',40) header1, SPLIT_STRING(a.header2,',',40) header2, SPLIT_STRING(a.header3,',',40) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,40 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',41) header1, SPLIT_STRING(a.header2,',',41) header2, SPLIT_STRING(a.header3,',',41) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,41 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',42) header1, SPLIT_STRING(a.header2,',',42) header2, SPLIT_STRING(a.header3,',',42) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,42 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',43) header1, SPLIT_STRING(a.header2,',',43) header2, SPLIT_STRING(a.header3,',',43) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,43 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',44) header1, SPLIT_STRING(a.header2,',',44) header2, SPLIT_STRING(a.header3,',',44) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,44 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',45) header1, SPLIT_STRING(a.header2,',',45) header2, SPLIT_STRING(a.header3,',',45) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,45 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',46) header1, SPLIT_STRING(a.header2,',',46) header2, SPLIT_STRING(a.header3,',',46) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,46 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',47) header1, SPLIT_STRING(a.header2,',',47) header2, SPLIT_STRING(a.header3,',',47) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,47 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',48) header1, SPLIT_STRING(a.header2,',',48) header2, SPLIT_STRING(a.header3,',',48) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,48 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',49) header1, SPLIT_STRING(a.header2,',',49) header2, SPLIT_STRING(a.header3,',',49) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,49 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
// SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',50) header1, SPLIT_STRING(a.header2,',',50) header2, SPLIT_STRING(a.header3,',',50) header3, FORMAT(a.value,2) as amount, FORMAT(a.rate,2) as rate, FORMAT(a.amount,2) as amount2 ,50 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn) b ) c where c.id = '$id' GROUP BY c.id_det ORDER BY c.id_det,c.supplier_invoice asc");
//         return $hasil->result_array();
//     }


function report_debit_note_det_memo($id)
{
    $hasil = $this->db->query("SELECT * from (SELECT id,id_det,supplier,supplier_invoice,FORMAT(sum(amount),2) amount,format(rate,2) rate,FORMAT(sum(amount2),2) amount2, jumlah,header1,header2,header3 FROM (SELECT id,id_det,deskripsi,supplier,supplier_invoice,amount,rate,amount2,COUNT(header1) as jumlah,header1,header2,header3 FROM (SELECT * FROM (SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',1) header1, SPLIT_STRING(a.header2,',',1) header2, SPLIT_STRING(a.header3,',',1) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,1 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',2) header1, SPLIT_STRING(a.header2,',',2) header2, SPLIT_STRING(a.header3,',',2) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,2 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',3) header1, SPLIT_STRING(a.header2,',',3) header2, SPLIT_STRING(a.header3,',',3) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,3 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',4) header1, SPLIT_STRING(a.header2,',',4) header2, SPLIT_STRING(a.header3,',',4) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,4 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',5) header1, SPLIT_STRING(a.header2,',',5) header2, SPLIT_STRING(a.header3,',',5) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,5 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',6) header1, SPLIT_STRING(a.header2,',',6) header2, SPLIT_STRING(a.header3,',',6) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,6 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',7) header1, SPLIT_STRING(a.header2,',',7) header2, SPLIT_STRING(a.header3,',',7) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,7 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',8) header1, SPLIT_STRING(a.header2,',',8) header2, SPLIT_STRING(a.header3,',',8) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,8 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',9) header1, SPLIT_STRING(a.header2,',',9) header2, SPLIT_STRING(a.header3,',',9) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,9 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',10) header1, SPLIT_STRING(a.header2,',',10) header2, SPLIT_STRING(a.header3,',',10) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,10 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',11) header1, SPLIT_STRING(a.header2,',',11) header2, SPLIT_STRING(a.header3,',',11) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,11 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',12) header1, SPLIT_STRING(a.header2,',',12) header2, SPLIT_STRING(a.header3,',',12) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,12 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',13) header1, SPLIT_STRING(a.header2,',',13) header2, SPLIT_STRING(a.header3,',',13) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,13 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',14) header1, SPLIT_STRING(a.header2,',',14) header2, SPLIT_STRING(a.header3,',',14) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,14 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',15) header1, SPLIT_STRING(a.header2,',',15) header2, SPLIT_STRING(a.header3,',',15) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,15 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',16) header1, SPLIT_STRING(a.header2,',',16) header2, SPLIT_STRING(a.header3,',',16) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,16 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',17) header1, SPLIT_STRING(a.header2,',',17) header2, SPLIT_STRING(a.header3,',',17) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,17 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',18) header1, SPLIT_STRING(a.header2,',',18) header2, SPLIT_STRING(a.header3,',',18) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,18 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',19) header1, SPLIT_STRING(a.header2,',',19) header2, SPLIT_STRING(a.header3,',',19) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,19 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',20) header1, SPLIT_STRING(a.header2,',',20) header2, SPLIT_STRING(a.header3,',',20) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,20 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',21) header1, SPLIT_STRING(a.header2,',',21) header2, SPLIT_STRING(a.header3,',',21) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,21 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',22) header1, SPLIT_STRING(a.header2,',',22) header2, SPLIT_STRING(a.header3,',',22) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,22 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',23) header1, SPLIT_STRING(a.header2,',',23) header2, SPLIT_STRING(a.header3,',',23) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,23 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',24) header1, SPLIT_STRING(a.header2,',',24) header2, SPLIT_STRING(a.header3,',',24) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,24 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',25) header1, SPLIT_STRING(a.header2,',',25) header2, SPLIT_STRING(a.header3,',',25) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,25 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',26) header1, SPLIT_STRING(a.header2,',',26) header2, SPLIT_STRING(a.header3,',',26) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,26 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',27) header1, SPLIT_STRING(a.header2,',',27) header2, SPLIT_STRING(a.header3,',',27) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,27 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',28) header1, SPLIT_STRING(a.header2,',',28) header2, SPLIT_STRING(a.header3,',',28) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,28 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',29) header1, SPLIT_STRING(a.header2,',',29) header2, SPLIT_STRING(a.header3,',',29) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,29 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',30) header1, SPLIT_STRING(a.header2,',',30) header2, SPLIT_STRING(a.header3,',',30) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,30 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',31) header1, SPLIT_STRING(a.header2,',',31) header2, SPLIT_STRING(a.header3,',',31) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,31 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',32) header1, SPLIT_STRING(a.header2,',',32) header2, SPLIT_STRING(a.header3,',',32) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,32 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',33) header1, SPLIT_STRING(a.header2,',',33) header2, SPLIT_STRING(a.header3,',',33) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,33 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',34) header1, SPLIT_STRING(a.header2,',',34) header2, SPLIT_STRING(a.header3,',',34) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,34 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',35) header1, SPLIT_STRING(a.header2,',',35) header2, SPLIT_STRING(a.header3,',',35) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,35 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',36) header1, SPLIT_STRING(a.header2,',',36) header2, SPLIT_STRING(a.header3,',',36) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,36 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',37) header1, SPLIT_STRING(a.header2,',',37) header2, SPLIT_STRING(a.header3,',',37) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,37 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',38) header1, SPLIT_STRING(a.header2,',',38) header2, SPLIT_STRING(a.header3,',',38) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,38 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',39) header1, SPLIT_STRING(a.header2,',',39) header2, SPLIT_STRING(a.header3,',',39) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,39 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',40) header1, SPLIT_STRING(a.header2,',',40) header2, SPLIT_STRING(a.header3,',',40) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,40 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',41) header1, SPLIT_STRING(a.header2,',',41) header2, SPLIT_STRING(a.header3,',',41) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,41 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',42) header1, SPLIT_STRING(a.header2,',',42) header2, SPLIT_STRING(a.header3,',',42) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,42 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',43) header1, SPLIT_STRING(a.header2,',',43) header2, SPLIT_STRING(a.header3,',',43) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,43 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',44) header1, SPLIT_STRING(a.header2,',',44) header2, SPLIT_STRING(a.header3,',',44) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,44 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',45) header1, SPLIT_STRING(a.header2,',',45) header2, SPLIT_STRING(a.header3,',',45) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,45 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',46) header1, SPLIT_STRING(a.header2,',',46) header2, SPLIT_STRING(a.header3,',',46) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,46 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',47) header1, SPLIT_STRING(a.header2,',',47) header2, SPLIT_STRING(a.header3,',',47) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,47 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',48) header1, SPLIT_STRING(a.header2,',',48) header2, SPLIT_STRING(a.header3,',',48) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,48 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',49) header1, SPLIT_STRING(a.header2,',',49) header2, SPLIT_STRING(a.header3,',',49) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,49 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn union
        SELECT b.id,a.id as id_det, a.deskripsi, a.supplier, a.supplier_invoice,SPLIT_STRING(a.header1,',',50) header1, SPLIT_STRING(a.header2,',',50) header2, SPLIT_STRING(a.header3,',',50) header3, Round(a.value,2) as amount, Round(a.rate,2) as rate, Round(a.amount,2) as amount2 ,50 as nomor FROM tbl_debitnote_det AS a INNER JOIN tbl_debitnote_h AS b ON a.no_dn = b.no_dn) b ) c where c.id = '$id' GROUP BY c.id_det ORDER BY c.id_det,c.supplier_invoice asc) a GROUP BY supplier_invoice) a left JOIN
(select b.id iddn,a.supplier_invoice,a.no_dn,a.deskripsi from tbl_debitnote_det a inner join tbl_debitnote_h b on b.no_dn = a.no_dn where deskripsi != '' GROUP BY a.supplier_invoice,b.id) b on b.supplier_invoice = a.supplier_invoice and b.iddn = a.id");
return $hasil->result_array();
}

function report_proforma_invoice_detail($id)
{
    $hasil = $this->db->query("SELECT b.id, a.no_invoice_proforma, a.no_so, a.produk_detail, a.curr, FORMAT(a.qty, 2) AS qty, 
      FORMAT(a.unit_price, 2) AS unit_price, 
      FORMAT(a.total_price, 2) AS total_price
      FROM tbl_invoice_proforma_detail_so AS a INNER JOIN 
      tbl_invoice_proforma AS b ON a.no_invoice_proforma = b.no_proforma_invoice
      WHERE b.id = '$id' ");
    return $hasil->result_array();
}

    //ubah september
function report_proforma_invoice_detail_cbd($id)
{
    $hasil = $this->db->query("SELECT b.id, a.no_invoice_proforma, a.no_so, a.produk_detail, a.curr, FORMAT(a.qty, 2) AS qty, 
      FORMAT(a.unit_price, 2) AS unit_price, 
      FORMAT(a.total_price, 2) AS total_price
      FROM tbl_invoice_proforma_detail_so_dp_cbd AS a INNER JOIN 
      tbl_invoice_proforma_dp_cbd AS b ON a.no_invoice_proforma = b.no_proforma_invoice
      WHERE b.id = '$id' ");
    return $hasil->result_array();
}
    //ubah september
function report_proforma_invoice_total($id)
{
    $hasil = $this->db->query("SELECT a.curr,
      SUM(a.qty) AS qty, 
      SUM(a.unit_price) AS unit_price, 
      SUM(a.total_price) AS total_price
      FROM tbl_invoice_proforma_detail_so AS a INNER JOIN 
      tbl_invoice_proforma AS b ON a.no_invoice_proforma = b.no_proforma_invoice
      WHERE b.id = '$id' ");
    return $hasil->row_array();
}


    //ubah september
function report_proforma_invoice_total_cbd($id)
{
    $hasil = $this->db->query("SELECT a.curr,
      SUM(a.qty) AS qty, 
      SUM(a.unit_price) AS unit_price, 
      SUM(a.total_price) AS total_price
      FROM tbl_invoice_proforma_detail_so_dp_cbd AS a INNER JOIN 
      tbl_invoice_proforma_dp_cbd AS b ON a.no_invoice_proforma = b.no_proforma_invoice
      WHERE b.id = '$id' ");
    return $hasil->row_array();
}
    //ubah september
function report_proforma_invoice_grandtotal($id)
{
    $hasil = $this->db->query("SELECT type_diskon,diskon,twot,ppn,total from tbl_invoice_proforma where id = '$id'");
    return $hasil->row_array();
}

    //ubah september
function report_proforma_diskon($id)
{
    $hasil = $this->db->query("SELECT if(type_diskon = '%',sum(a.total_price) * diskon/100,diskon) as diskon from tbl_invoice_proforma_detail_so a inner join tbl_invoice_proforma b ON a.no_invoice_proforma = b.no_proforma_invoice where b.id = '$id'");
    return $hasil->row_array();
}


    //ubah september
function report_proforma_invoice_grandtotal_cbd($id)
{
    $hasil = $this->db->query("SELECT type_diskon,diskon,twot,ppn,total from tbl_invoice_proforma_dp_cbd where id = '$id'");
    return $hasil->row_array();
}

    //ubah september
function report_proforma_diskon_cbd($id)
{
    $hasil = $this->db->query("SELECT if(type_diskon = '%',sum(a.total_price) * diskon/100,diskon) as diskon from tbl_invoice_proforma_detail_so_dp_cbd a inner join tbl_invoice_proforma_dp_cbd b ON a.no_invoice_proforma = b.no_proforma_invoice where b.id = '$id'");
    return $hasil->row_array();
}

    //Return Invoice

function get_kode_return_invoice($kode_inv)
{

    $q = $this->db->query("SELECT MAX(RIGHT(no_return_invoice, 4)) AS kd_max 
      FROM tbl_invoice_return
      WHERE YEAR(tgl_return_inv) = YEAR(CURRENT_DATE()) AND MONTH(tgl_return_inv) = MONTH(CURRENT_DATE()) AND STATUS <> 'CANCEL' ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
    } else {
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return "IR/" . "$kode_inv/NAG/" . date('my') . "/" . $kd;
}

function cari_sjbpb_return($dt_dari, $dt_sampai, $id_customer)
{
        //Database Localhost/SB2
        // $hasil = $this->db->query("SELECT id, id_supplier, bpbno_int AS bpb_number, bppbno AS sj_number, bpbdate, curr, 
        //                                   FORMAT(qty, 2) AS qty, FORMAT(price, 2) AS price, FORMAT(qty * price, 2) AS total_price
        //                            FROM bpb 
        //                            WHERE bpbno_int LIKE 'FG/RI%' AND id_supplier = '$id_customer' AND bpbdate BETWEEN '$dt_dari' AND '$dt_sampai' ");
        // return $hasil->result_array();
        //
        //Database SignalBit
    $db_nag = $this->load->database('db_nag', TRUE);
    $hasil = $db_nag->query("SELECT id, id_supplier, bpbno_int AS bpb_number, bppbno AS sj_number, bpbdate, curr, 
        FORMAT(qty, 2) AS qty, FORMAT(price, 2) AS price, FORMAT(qty * price, 2) AS total_price
        FROM bpb 
        WHERE bpbno_int LIKE 'FG/RI%' AND id_supplier = '$id_customer' AND bpbdate BETWEEN '$dt_dari' AND '$dt_sampai' ");
    return $hasil->result_array();
}

function simpan_invoice_detail_return_temporary($data)
{
    $this->db->insert_batch('tbl_invoice_return_detail_temp', $data);
    return $this->db->insert_id();
}

function load_invoice_detail_return_temporary()
{
    $hasil = $this->db->query("SELECT id_bpb, bpb_number, sj_number, DATE_FORMAT(bpbdate, '%Y-%m-%d') AS bpbdate, curr,
      FORMAT(qty, 2) AS qty, FORMAT(price, 2) AS price, FORMAT(total_price, 2) AS total_price
      FROM tbl_invoice_return_detail_temp");
    return $hasil->result_array();
}

function delete_invoice_detail_return_temporary()
{
    $hasil = $this->db->query("DELETE FROM tbl_invoice_return_detail_temp");
    return $hasil;
}

function simpan_return_invoice_header($data)
{
    $this->db->insert_batch('tbl_invoice_return', $data);
    return $this->db->insert_id();
}

function simpan_return_invoice_detail($data)
{
    $this->db->insert_batch('tbl_invoice_return_detail', $data);
    return $this->db->insert_id();
}

function cari_return_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    if ($id_customer == "all_customer") {
        $hasil = $this->db->query("SELECT a.id, a.no_return_invoice, DATE_FORMAT(a.tgl_return_inv, '%Y-%m-%d') AS tgl_return_inv, b.supplier AS customer, a.shipp, a.peb,
          c.type, a.status, a.nrp, a.no_invoice_asal, FORMAT(SUM(d.total_price), 2) AS amount
          FROM tbl_invoice_return AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
          tbl_invoice_return_detail AS d ON a.no_return_invoice = d.no_invoice_return     
          WHERE a.status = 'POST' AND a.tgl_return_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
          GROUP BY a.no_return_invoice ");
        return $hasil->result_array();
    } else {
        $hasil = $this->db->query("SELECT a.id, a.no_return_invoice, DATE_FORMAT(a.tgl_return_inv, '%Y-%m-%d') AS tgl_return_inv, b.supplier AS customer, a.shipp, a.peb,
          c.type, a.status, a.nrp, a.no_invoice_asal, FORMAT(SUM(d.total_price), 2) AS amount
          FROM tbl_invoice_return AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
          tbl_invoice_return_detail AS d ON a.no_return_invoice = d.no_invoice_return  
          WHERE a.status = 'POST' AND a.tgl_return_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND a.id_customer = '$id_customer' 
          GROUP BY a.no_return_invoice ");
        return $hasil->result_array();
    }
}

function report_return_invoice($id)
{
    $hasil = $this->db->query("SELECT a.id, a.no_return_invoice AS no_return, DATE_FORMAT(a.tgl_return_inv, '%Y-%m-%d') AS date_return, b.supplier AS customer, a.shipp, a.peb,
      UPPER(c.type) AS type_, a.status, a.nrp, a.no_invoice_asal, LEFT(IFNULL(b.alamat, '-'), 27) AS alamat, 
      IFNULL(b.Phone, '-') AS phone, d.no_rek, d.nama_bank, d.v_bankaddress, d.curr
      FROM tbl_invoice_return AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
      masterbank AS d ON a.id_bank = d.id
      WHERE a.id = '$id' ");
    return $hasil->row_array();
}

function report_return_invoice_detail($id)
{
    $hasil = $this->db->query("SELECT b.id, a.no_invoice_return, a.bpb_number, a.curr, FORMAT(a.qty, 2) AS qty, 
      FORMAT(a.price, 2) AS price, 
      FORMAT(a.total_price, 2) AS total_price
      FROM tbl_invoice_return_detail AS a INNER JOIN 
      tbl_invoice_return AS b ON a.no_invoice_return = b.no_return_invoice
      WHERE b.id = '$id' ");
    return $hasil->result_array();
}

function report_return_invoice_total($id)
{
    $hasil = $this->db->query("SELECT a.curr,
      SUM(a.qty) AS qty, 
      SUM(a.price) AS price, 
      SUM(a.total_price) AS total_price
      FROM tbl_invoice_return_detail AS a INNER JOIN 
      tbl_invoice_return AS b ON a.no_invoice_return = b.no_return_invoice
      WHERE b.id = '$id' ");
    return $hasil->row_array();
}

    //ubah september


    //Debit Note
    //ubah september
function get_kode_debitnote()
{
    $query = $this->db->query("SELECT CONCAT('DN/NAG/',DATE_FORMAT(CURRENT_DATE(), '%m%y'),'/',LPAD((COALESCE(max(SUBSTR(no_dn,13)),0) + 1),4,0)) nomor from tbl_debitnote_h WHERE YEAR(tgl_dn) = YEAR (CURRENT_DATE())");
        //
    $kd = "";
    if ($query->result()) {            
        foreach ($query->result() as $data) {
            $hasil = ($data->nomor);
        }
    } else {
        $hasil = 0;
    }

    return $hasil;
}

    // //ubah september
    // function ubahnomor_dn($kode)
    // {
    //     $q = $this->db->query("SELECT MAX(RIGHT(a.no_dn, 4)) AS kd_max 
    //                            FROM tbl_debitnote_h a inner join tbl_log b
    //                            WHERE YEAR(b.tanggal_input) = YEAR('$kode') AND MONTH(b.tanggal_input) = MONTH('$kode') ");
    //     //
    //     $kd = "";
    //     $nomor = "";
    //     if ($q->num_rows() > 0) {
    //         foreach ($q->result() as $k) {
    //             $tmp = ((int)$k->kd_max) + 1;
    //             $kd = sprintf("%04s", $tmp);
    //         }
    //     } else {
    //         $kd = "0001";
    //     }
    //     date_default_timezone_set('Asia/Jakarta');
    //     $nomor = "DN/NAG/" . date('my') . "/" . $kd;
    //     return $nomor;
    // }

function get_kode_kwt()
{
        // $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) AND 
        //                        MONTH(tanggal) = MONTH(CURRENT_DATE())");
        //
        // $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) AND 
        //                        MONTH(tanggal) = MONTH(CURRENT_DATE()) AND status <> 'POST' AND status <> 'CANCEL' ");
        //
    $q = $this->db->query("SELECT no_kwt, MAX(LEFT(no_kwt, 4)) AS kd_max FROM tbl_kwitansi WHERE YEAR(tgl_kwt) = YEAR(CURRENT_DATE()) ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
    } else {
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return $kd . "/INV/NAG/" . date('Y') . "/KWT";
}

function save_debitnote($data)
{
    $this->db->insert_batch('tbl_debitnote', $data);
    return $this->db->insert_id();
}

function load_debitnote()
{
    $hasil = $this->db->query("SELECT a.id, a.no_debitnote, b.supplier AS customer, DATE_FORMAT(a.doc_date, '%Y-%m-%d') AS doc_date, 
      a.coa, FORMAT(a.value, 2) AS value_, a.description, a.duedate, a.status
      FROM tbl_debitnote AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.Id_Supplier
      WHERE a.status = 'DONE' ");
    return $hasil->result_array();
}

function cancel_debitnote($id)
{
    $hasil = $this->db->query("UPDATE tbl_debitnote SET status = 'CANCEL' WHERE id = '$id' ");
    return $hasil;
}

    //User Role 

function load_user()
{
    $hasil = $this->db->query("SELECT username, fullname FROM userpassword ORDER BY username ASC ");
    return $hasil->result_array();
}

function load_menu()
{
    $hasil = $this->db->query("SELECT menu, base_url, id FROM tbl_user_role");
    return $hasil->result_array();
}

function delete_before_userrole($user)
{
    $hasil = $this->db->query("DELETE FROM tbl_user_access WHERE user = '$user' ");
    return $hasil;
}

function delete_userrole($id)
{
    $this->db->query("DELETE FROM tbl_user_access WHERE id = '$id' ");
        // $this->db->delete('tbl_user_access', ['id' => $id]);
    return $db;
}    

function save_userrole($data)
{
    $this->db->insert_batch('tbl_user_access', $data);
    return $this->db->result_array();
}

function load_user_access()
{
    $hasil = $this->db->query("SELECT b.id,b.user, a.menu, b.base_url
       FROM tbl_user_role AS a INNER JOIN tbl_user_access AS b ON a.id = b.menu_id");
    return $hasil->result_array();
}

function load_user_access_1($user)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.base_url, a.menu_status
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu_status = 'main_menu_1' ");
    return $hasil->result_array();
}

function load_user_access_2($user)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.base_url, a.menu_status
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu_status = 'main_menu_2' ");
    return $hasil->result_array();
}

function load_user_access_3($user)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.base_url, a.menu_status
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu_status = 'report' ");
    return $hasil->result_array();
}

function load_user_access_4($user)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.base_url, a.menu_status
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu_status = 'main_menu_3' ");
    return $hasil->result_array();
}
function load_user_access_5($user)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.base_url, a.menu_status
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu_status = 'kwitansi' ");
    return $hasil->result_array();
}

function load_user_access_6($user)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.base_url, a.menu_status
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu_status = 'alokasi' ");
    return $hasil->result_array();
}

function load_user_access_7($user)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.base_url, a.menu_status
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu_status = 'master' ");
    return $hasil->result_array();
}

function load_user_access_reverse($user)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.base_url, a.menu_status
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu_status = 'doc_reverse' ");
    return $hasil->result_array();
}

function cari_usercancel($user)
{
    $hasil = $this->db->query("SELECT ar_calcelinv as cancel from userpassword where username = '$user' ");
    return $hasil->result_array();
}

function block_page($user, $menu_name)
{
    $hasil = $this->db->query("SELECT b.user, a.menu, b.menu_id
       FROM tbl_user_role AS a INNER JOIN 
       tbl_user_access AS b ON a.id = b.menu_id
       WHERE b.user = '$user' AND a.menu = '$menu_name' ");
    return $hasil->row_array();
}


function cari_invoice_kwt($dt_dari_invkwt, $dt_sampai_invkwt, $id_customer)
{

 $hasil = $this->db->query("(SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, e.curr,
  DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, 
  FORMAT((d.grand_total), 2) AS amount, round(d.grand_total,0) AS amount1
  FROM  tbl_book_invoice AS a INNER JOIN 
  mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
  tbl_type AS c ON a.id_type = c.id_type INNER JOIN
  tbl_invoice_pot AS d ON a.id = d.id_book_invoice  INNER JOIN
  tbl_invoice_detail as e on a.id=e.id_book_invoice      
  WHERE e.sj_date BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.id_customer = '$id_customer' and a.status = 'APPROVED' and a.no_kwt is null  and e.curr = 'IDR'
  ORDER BY a.id) union                                                                      

  (SELECT distinct  f.no_inv AS no_invoice, UPPER(g.supplier) AS customer, f.shipp,                                     f.doc_type, f.doc_number,i.curr, 
  DATE_FORMAT(i.sj_date, '%Y-%m-%d') AS inv_date, f.type, f.status,f.id, f.type_so, g.Id_Supplier AS id_customer,
  FORMAT((h.grand_total), 2) AS amount,round(h.grand_total,0) AS amount1
  FROM  tbl_invoice_nb AS f INNER JOIN 
  mastersupplier AS g ON f.customer = g.id_supplier INNER JOIN 
  tbl_invoice_nb_pot AS h ON f.no_inv = h.no_inv INNER JOIN
  tbl_invoice_nb_detail as i on f.no_inv=i.no_inv      
  WHERE i.sj_date BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND f.customer = '$id_customer' and f.status = 'APPROVED' and f.no_kwt is null  and i.curr = 'IDR'
  ORDER BY f.id) ");

 return $hasil->result_array();

}

function cari_kwitansi($dt_dari_kwt, $dt_sampai_kwt, $customer)
{

    if ($customer == "all_customer") {

     $hasil = $this->db->query("SELECT * from ((SELECT a.id, a.no_kwt, DATE_FORMAT(a.tgl_kwt, '%Y-%m-%d') as tgl_kwt, UPPER(b.supplier) AS supp, FORMAT((a.total), 2) as total, a.terbilang as bilang, a.status, c.curr from tbl_kwitansi a inner join mastersupplier AS b ON a.supp = b.id_supplier inner join tbl_kwitansi_detail f on f.no_kwitansi = a.no_kwt inner join tbl_book_invoice d on f.no_invoice = d.no_invoice inner JOIN tbl_invoice_detail c on d.id = c.id_book_invoice  where a.tgl_kwt BETWEEN '$dt_dari_kwt' AND '$dt_sampai_kwt'  GROUP BY a.id) union
        (SELECT a.id, a.no_kwt, DATE_FORMAT(a.tgl_kwt, '%Y-%m-%d') as tgl_kwt, UPPER(b.supplier) AS supp, FORMAT((a.total), 2) as total, a.terbilang as bilang, a.status, c.curr from tbl_kwitansi a inner join mastersupplier AS b ON a.supp = b.id_supplier inner join tbl_kwitansi_detail f on f.no_kwitansi = a.no_kwt inner JOIN tbl_invoice_nb_detail c on f.no_invoice = c.no_inv  where a.tgl_kwt BETWEEN '$dt_dari_kwt' AND '$dt_sampai_kwt' GROUP BY a.id)) a ");

     return $hasil->result_array();
 } else {
    $hasil = $this->db->query("SELECT * from ((SELECT a.id, a.no_kwt, DATE_FORMAT(a.tgl_kwt, '%Y-%m-%d') as tgl_kwt, UPPER(b.supplier) AS supp, FORMAT((a.total), 2) as total, a.terbilang as bilang, a.status, c.curr from tbl_kwitansi a inner join mastersupplier AS b ON a.supp = b.id_supplier inner join tbl_kwitansi_detail f on f.no_kwitansi = a.no_kwt inner join tbl_book_invoice d on f.no_invoice = d.no_invoice inner JOIN tbl_invoice_detail c on d.id = c.id_book_invoice  where a.tgl_kwt BETWEEN '$dt_dari_kwt' AND '$dt_sampai_kwt' AND a.supp = '$customer' GROUP BY a.id) union
        (SELECT a.id, a.no_kwt, DATE_FORMAT(a.tgl_kwt, '%Y-%m-%d') as tgl_kwt, UPPER(b.supplier) AS supp, FORMAT((a.total), 2) as total, a.terbilang as bilang, a.status, c.curr from tbl_kwitansi a inner join mastersupplier AS b ON a.supp = b.id_supplier inner join tbl_kwitansi_detail f on f.no_kwitansi = a.no_kwt inner JOIN tbl_invoice_nb_detail c on f.no_invoice = c.no_inv  where a.tgl_kwt BETWEEN '$dt_dari_kwt' AND '$dt_sampai_kwt' AND a.supp = '$customer' GROUP BY a.id)) a");
    return $hasil->result_array();
}

}

function cari_view_kwitansi($no_kwt)
{

 $hasil = $this->db->query("SELECT DISTINCT d.id, a.id as id_detail,a.no_invoice, a.invoice_date, a.customer, a.shipp, a.doc_type, a.doc_number, a.type, FORMAT(SUM(c.total_price), 2) as total, c.curr, a.style from tbl_kwitansi_detail a inner join tbl_book_invoice b on b.no_invoice = a.no_invoice inner JOIN tbl_invoice_detail c on b.id = c.id_book_invoice inner join tbl_kwitansi d on d.no_kwt = a.no_kwitansi where d.id = '$no_kwt' GROUP BY a.no_invoice");

 return $hasil->result_array();

}

function getType3($no_kwt)
{
    $hasil = $this->db->query("SELECT no_kwt, tgl_kwt, supp, total, terbilang, status from tbl_kwitansi where no_kwt = '$no_kwt' ");
    return $hasil->row();
}

    //ubah september
function get_alamat($kode)
{

    $hasil = $this->db->query("SELECT Id_Supplier,Supplier,alamat from mastersupplier where Id_Supplier = '$kode' ");
    return $hasil->row();
}

    //ubah september
function ubahnomor_dn($kode)
{

        // $hasil = $this->db->query("SELECT kata,concat(kata,nomor) as nomor from (select kata, if(LENGTH(nomor) >= 3, if(LENGTH(nomor) = 3,CONCAT('0',nomor),nomor),  if(LENGTH(nomor) = 1,CONCAT('000',nomor),CONCAT('00',nomor))) as nomor from (select kata,SUBSTR(nomor,13,4) +1 as nomor from (SELECT concat('DN/NAG/',if(MONTH('$kode') >=10,MONTH('$kode'),CONCAT('0',MONTH('$kode'))),substr(YEAR('$kode'),3,2),'/') as kata, ifnull(max(a.no_dn),0) AS nomor
        //                         FROM tbl_debitnote_h a inner join tbl_log b
        //                       WHERE YEAR(a.tgl_dn) = YEAR('$kode') AND MONTH(a.tgl_dn) = MONTH('$kode')) a) b) c ");

    $hasil = $this->db->query("SELECT CONCAT('DN/NAG/',DATE_FORMAT('$kode', '%m%y'),'/',LPAD((COALESCE(max(SUBSTR(no_dn,13)),0) + 1),4,0)) nomor from tbl_debitnote_h WHERE YEAR(tgl_dn) = YEAR ('$kode') ");
    return $hasil->row();
}

    //ubah september
function ubahnomor_alo($kode)
{

    $hasil = $this->db->query("SELECT kata,concat(nomor,kata) as nomor from (select kata, if(LENGTH(nomor) >= 3, if(LENGTH(nomor) = 3,CONCAT('0',nomor),nomor),  if(LENGTH(nomor) = 1,CONCAT('000',nomor),CONCAT('00',nomor))) as nomor from (select kata,SUBSTR(nomor,1,4) +1 as nomor from (SELECT concat('/ALK/NAG/',if(MONTH('$kode') >=10,MONTH('$kode'),CONCAT('0',MONTH('$kode'))),substr(YEAR('$kode'),3,2)) as kata, ifnull(max(a.no_alk),0) AS nomor
        FROM tbl_alokasi a 
        WHERE YEAR(a.tgl_alk) = YEAR('$kode') AND MONTH(a.tgl_alk) = MONTH('$kode')) a) b) c");
    return $hasil->row();
}


    //ubah september tahun
function ubahnomor_kwt($kode)
{

    $hasil = $this->db->query("SELECT kata,concat(nomor,kata) as nomor from (select kata, if(LENGTH(nomor) >= 3, if(LENGTH(nomor) = 3,CONCAT('0',nomor),nomor),  if(LENGTH(nomor) = 1,CONCAT('000',nomor),CONCAT('00',nomor))) as nomor from (select kata,SUBSTR(nomor,1,4) +1 as nomor from (SELECT concat('/INV/NAG/',YEAR('$kode'),'/KWT') as kata, ifnull(max(a.no_kwt),0) AS nomor
        FROM tbl_kwitansi a 
        WHERE YEAR(a.tgl_kwt) = YEAR('$kode')) a) b) c");
    return $hasil->row();
}

    // //ubah september bln/thn
    // function ubahnomor_kwt($kode)
    // {

    //     $hasil = $this->db->query("SELECT kata,concat(nomor,kata) as nomor from (select kata, if(LENGTH(nomor) >= 3, if(LENGTH(nomor) = 3,CONCAT('0',nomor),nomor),  if(LENGTH(nomor) = 1,CONCAT('000',nomor),CONCAT('00',nomor))) as nomor from (select kata,SUBSTR(nomor,1,4) +1 as nomor from (SELECT concat('/INV/NAG/',if(MONTH('$kode') >=10,MONTH('$kode'),CONCAT('0',MONTH('$kode'))),substr(YEAR('$kode'),3,2),'/KWT') as kata, ifnull(max(a.no_kwt),0) AS nomor
    //                             FROM tbl_kwitansi a 
    //                           WHERE YEAR(a.tgl_kwt) = YEAR('$kode') AND MONTH(a.tgl_kwt) = MONTH('$kode')) a) b) c");
    //     return $hasil->row();
    // }

function cari_data_kwitansi($id)
{
    $hasil = $this->db->query("SELECT DISTINCT a.id, a.no_kwt, DATE_FORMAT(a.tgl_kwt, '%d %M %Y') as tgl_kwt, format(round(a.total,0),0) as total, a.terbilang, c.curr, d.Supplier from tbl_kwitansi a inner join tbl_book_invoice b on a.no_kwt = b.no_kwt INNER JOIN tbl_invoice_detail c on b.id = c.id_book_invoice INNER JOIN mastersupplier d ON b.id_customer = d.Id_Supplier where a.id = '$id'
        union
        SELECT DISTINCT a.id, a.no_kwt, DATE_FORMAT(a.tgl_kwt, '%d %M %Y') as tgl_kwt, format(round(a.total,0),0) as total, a.terbilang, c.curr, d.Supplier from tbl_kwitansi a inner join tbl_kwitansi_detail b on a.no_kwt = b.no_kwitansi INNER JOIN tbl_invoice_nb_detail c on b.no_invoice = c.no_inv INNER JOIN tbl_invoice_nb e on e.no_inv = c.no_inv INNER JOIN mastersupplier d ON e.customer = d.Id_Supplier where a.id = '$id'");
    return $hasil->row_array();
}

function cari_data_kwitansi2($id)
{
    $hasil = $this->db->query("SELECT DISTINCT a.id, a.no_kwt, b.no_invoice, b.style from tbl_kwitansi a inner join tbl_kwitansi_detail b on a.no_kwt = b.no_kwitansi where a.id = '$id' and b.amount is null group by b.style ");
    return $hasil->result_array();
}

function update_tbl_kwitansi($id, $bilang)
{
    $hasil = $this->db->query("UPDATE tbl_kwitansi SET terbilang = '$bilang' WHERE no_kwt = '$id' ");
    return $hasil;
}

function cancel_kwitansi($id)
{
    $hasil = $this->db->query("UPDATE tbl_kwitansi SET status = 'Cancel' WHERE no_kwt = '$id' ");
    return $hasil;
}

    //ubah september
function cancel_debnote($id)
{
    $hasil = $this->db->query("UPDATE tbl_debitnote_h set status = 'Cancel' WHERE no_dn = '$id' ");
    return $hasil;
}

function update_inv_kwt($id)
{
    $hasil = $this->db->query("UPDATE tbl_book_invoice SET no_kwt = null WHERE no_kwt = '$id' ");
    return $hasil;
}

function delete_kwt_detail_temporary()
{
    $hasil = $this->db->query("DELETE FROM tbl_kwt_temp");
    return $hasil;
}

    //ubah september
function get_rate()
{

    $query = $this->db->query("SELECT rate FROM masterrate WHERE id IN (SELECT MAX(id) FROM masterrate where v_codecurr = 'HARIAN')");
    foreach ($query->result() as $data) {
        $hasil = ($data->rate);
        $hasil2 = '1';
        if ($query->num_rows() > 0) {
            return $hasil;
        }else{
            return $hasil2;
        }
    }
}

function simpan_kwt_detail_temporary($data)
{
    $this->db->insert_batch('tbl_kwt_temp', $data);
    return $this->db->insert_id();
}

function load_kwt_detail_temporary()
{
    $hasil = $this->db->query(" (SELECT DISTINCT a.no_invoice, a.invoice_date, a.customer, a.shipp, a.doc_type, a.doc_number, a.type, a.amount, c.styleno AS tipestyle, c.styleno, c.color FROM tbl_kwt_temp a inner join tbl_book_invoice b on b.no_invoice = a.no_invoice inner join tbl_invoice_detail c on c.id_book_invoice = b.id group by a.no_invoice) union 
        (SELECT DISTINCT a.no_invoice, a.invoice_date, a.customer, a.shipp, a.doc_type, a.doc_number, a.type, a.amount, c.no_style AS tipestyle, c.no_style, c.color FROM tbl_kwt_temp a inner join tbl_invoice_nb_detail c on c.no_inv = a.no_invoice group by a.no_invoice)");
    return $hasil->result_array();
}

function update_style($id, $style)
{
    $hasil = $this->db->query("UPDATE tbl_kwitansi_detail SET style = '$style' WHERE id = '$id' ");
    return $hasil;
}


function simpan_kwt_detail($data)
{
    $this->db->insert_batch('tbl_kwitansi_detail', $data);
    return $this->db->insert_id();
}

function update_status_kwt_inv($no_invoice, $no_kwt)
{
    $this->db->query("UPDATE tbl_book_invoice SET no_kwt = '$no_kwt' WHERE no_invoice = '$no_invoice' ");
    return $hasil;
}

function update_status_kwt_inv2($no_invoice, $no_kwt)
{
    $this->db->query("UPDATE tbl_invoice_nb SET no_kwt = '$no_kwt' WHERE no_inv = '$no_invoice' ");
    return $hasil;
}

function simpankwitansi($data)
{
    $this->db->insert_batch('tbl_kwitansi', $data);
    return $this->db->insert_id();
}

function get_kode_inv_nb()
{
        // $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) AND 
        //                        MONTH(tanggal) = MONTH(CURRENT_DATE())");
        //
        // $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) AND 
        //                        MONTH(tanggal) = MONTH(CURRENT_DATE()) AND status <> 'POST' AND status <> 'CANCEL' ");
        //
        // $q = $this->db->query("SELECT no_inv, MAX(LEFT(no_inv, 4)) AS kd_max FROM tbl_invoice_nb WHERE YEAR(inv_date) = YEAR(CURRENT_DATE()) AND 
        //                           MONTH(inv_date) = MONTH(CURRENT_DATE()) ");
    $q = $this->db->query("SELECT no_inv, MAX(LEFT(no_inv, 4)) AS kd_max FROM tbl_invoice_nb a inner join tbl_log b on b.doc_number = a.no_inv WHERE YEAR(tanggal_input) = YEAR(CURRENT_DATE()) AND 
      MONTH(tanggal_input) = MONTH(CURRENT_DATE()) ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
    } else {
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return $kd . "/INM/NAG/" . date('my');
}

function simpan_invoice_nb_detail($data)
{
    $this->db->insert_batch('tbl_invoice_nb_detail', $data);
    return $this->db->insert_id();
}

function report_invoice_nb($id)
{
    $hasil = $this->db->query("SELECT distinct a.no_inv as no_invoice, LEFT(b.Supplier, 30) AS customer,
      LEFT(IFNULL(b.alamat, '-'), 27) AS alamat, IFNULL(b.Phone, '-') AS phone, IFNULL(b.Email, '-') AS email,
      DATE_FORMAT(f.sj_date,'%d-%m-%Y') AS tgl_inv, UPPER(a.type) AS type, a.shipp, a.top_type AS type_top, a.top,
      e.no_rek, e.nama_bank,e.v_company, e.v_bankaddress, e.curr
      FROM tbl_invoice_nb AS a INNER JOIN 
      mastersupplier AS b ON a.customer = b.Id_Supplier INNER JOIN
      masterbank AS e ON a.bank = e.id  INNER join
      tbl_invoice_nb_detail as f on a.no_inv=f.no_inv
      WHERE a.id = '$id' ");
    return $hasil->row_array();
}

function report_invoice_detail_nb($id)
{
    $hasil = $this->db->query("SELECT a.no_style as styleno, a.prod_grup as product_group,a.prod_item as  product_item, a.color, a.size, a.qty, format(round(a.unit_price,2),2) unit_price,a.diskon as disc, FORMAT(a.total, 2) AS total_price, a.uom, a.curr, a.id_bppb
       FROM tbl_invoice_nb_detail a inner join 
       tbl_invoice_nb b on b.no_inv = a.no_inv
       WHERE b.id = '$id' ORDER BY a.id_bppb asc ");
    return $hasil->result_array();
}

function report_invoice_pot_nb($id)
{
    $hasil = $this->db->query("SELECT b.id, b.no_inv as id_book_invoice, FORMAT(a.total, 2) AS total, FORMAT(a.diskon, 2) AS discount, FORMAT(a.dp, 2) AS dp, 
      FORMAT(a.retur, 2) AS retur, FORMAT(a.twot, 2) AS twot, FORMAT(a.vat, 2) AS vat, FORMAT(a.grand_total, 2) AS grand_total 
      FROM tbl_invoice_nb_pot a inner join 
      tbl_invoice_nb b on b.no_inv = a.no_inv
      WHERE b.id = '$id' ");
    return $hasil->row_array();
}

function group_bppb_number_nb($id)
{
    $hasil = $this->db->query("SELECT DISTINCT a.no_shipp as bppb_number
       FROM tbl_invoice_nb_detail a inner join 
       tbl_invoice_nb b on b.no_inv = a.no_inv
       WHERE b.id = '$id' ");
    return $hasil->result_array();
}

function group_so_number_nb($id)
{
    $hasil = $this->db->query("SELECT DISTINCT a.no_so as so_number
       FROM tbl_invoice_nb_detail a inner join 
       tbl_invoice_nb b on b.no_inv = a.no_inv
       WHERE b.id = '$id' ");
    return $hasil->result_array();
}
function group_curr_nb($id)
{
    $hasil = $this->db->query("SELECT DISTINCT a.curr as curr
       FROM tbl_invoice_nb_detail a inner join 
       tbl_invoice_nb b on b.no_inv = a.no_inv
       WHERE a.id = '$id' ");
    return $hasil->row_array();
}

function group_user($id)
{
    $hasil = $this->db->query("Select concat(UCASE(left(a.nama,1)),LCASE(SUBSTRING(a.nama,2))) as nama from tbl_log a inner join tbl_book_invoice b on b.no_invoice = a.doc_number where a.activity = 'Create invoice' and b.id = '$id' ");
    return $hasil->row_array();
}

function simpan_invoice_nb_pot($data)
{
    $this->db->insert_batch('tbl_invoice_nb_pot', $data);
    return $this->db->insert_id();
}

function simpan_invoice_nb($data)
{
    $this->db->insert_batch('tbl_invoice_nb', $data);
    return $this->db->insert_id();
}

function cari_invoice_nb($dt_dari_inv, $dt_sampai_inv, $id_customer)
{

    if ($id_customer == "all_customer") {
            // $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, 
            //                               DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer,
            //                               FORMAT((d.grand_total), 2) AS amount
            //                        FROM  tbl_book_invoice AS a INNER JOIN 
            //                               mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            //                               tbl_type AS c ON a.id_type = c.id_type INNER JOIN
            //                                tbl_invoice_pot AS d ON a.id = d.id_book_invoice       
            //                        WHERE a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
            //                        ORDER BY a.id ");

     $hasil = $this->db->query("SELECT distinct  f.no_inv AS no_invoice, UPPER(g.supplier) AS customer, f.shipp,                                     f.doc_type, f.doc_number, 
      DATE_FORMAT(i.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(f.create_date, '%Y-%m-%d') AS tgl_inv, f.type, f.status,f.id, f.type_so, g.Id_Supplier AS id_customer,
      FORMAT((h.grand_total), 2) AS amount
      FROM  tbl_invoice_nb AS f INNER JOIN 
      mastersupplier AS g ON f.customer = g.id_supplier INNER JOIN 
      tbl_invoice_nb_pot AS h ON f.no_inv = h.no_inv INNER JOIN
      tbl_invoice_nb_detail as i on f.no_inv=i.no_inv      
      WHERE i.sj_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
      ORDER BY f.id ");

     return $hasil->result_array();
 } else {
    $hasil = $this->db->query("SELECT distinct  f.no_inv AS no_invoice, UPPER(g.supplier) AS customer, f.shipp,                                     f.doc_type, f.doc_number, 
      DATE_FORMAT(i.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(f.create_date, '%Y-%m-%d') AS tgl_inv, f.type, f.status,f.id, f.type_so, g.Id_Supplier AS id_customer,
      FORMAT((h.grand_total), 2) AS amount
      FROM  tbl_invoice_nb AS f INNER JOIN 
      mastersupplier AS g ON f.customer = g.id_supplier INNER JOIN 
      tbl_invoice_nb_pot AS h ON f.no_inv = h.no_inv INNER JOIN
      tbl_invoice_nb_detail as i on f.no_inv=i.no_inv      
      WHERE i.sj_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND f.customer = '$id_customer'
      ORDER BY f.id ");
    return $hasil->result_array();
}

}

function cari_inv_detail_nb($id)
{
    $hasil = $this->db->query("SELECT a.no_inv as no_invoice, b.no_so as so_number, b.no_bppb as bppb_Number, b.no_shipp as shipp_number, b.no_ws as ws, b.no_style as styleno, b.prod_grup as product_group, 
      b.prod_item as product_item, b.color, b.size, b.curr, b.uom, b.qty, b.unit_price, b.diskon as disc, FORMAT(b.total, 2) AS total_price
      FROM tbl_invoice_nb AS a INNER JOIN 
      tbl_invoice_nb_detail AS b ON a.no_inv = b.no_inv
      WHERE a.id = '$id' ");
    return $hasil->result_array();
}

function cancel_invoice_nb($id)
{
    $hasil = $this->db->query("UPDATE tbl_invoice_nb a inner join tbl_invoice_nb_detail b on a.no_inv = b.no_inv set a.status = 'CANCEL', b.status = 'CANCEL' where a.no_inv = '$id' ");
    return $hasil;
}

function cancel_invoice_manual($id)
{
    $hasil = $this->db->query("UPDATE tbl_invoice_nb a inner join tbl_invoice_nb_detail b on a.no_inv = b.no_inv set a.status = 'CANCEL', b.status = 'CANCEL' where a.no_inv = '$id' ");
    return $hasil;
}

function get_kode_id_nb()
{

    $q = $this->db->query("SELECT no_inv, MAX(id) AS kd_max FROM tbl_invoice_nb WHERE status <> 'CANCEL' ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
        }
    } else {
        $tmp = "1";
    }
    date_default_timezone_set('Asia/Jakarta');
    return $tmp;
}

function get_kode_top_nb()
{
    $hasil = $this->db->query("SELECT DISTINCT type from tbl_master_top where status = 'Active' ");
    return $hasil->result_array();
}

function cari_cost()
{
    $hasil = $this->db->query("SELECT id, no_cc as code_cost,cc_name as cost_name from b_master_cc where status = 'Active' ");
    return $hasil->result_array();
}

function cari_coa()
{
    $hasil = $this->db->query("SELECT no_coa as id_coa, nama_coa as coa_name from mastercoa_v2 ");
    return $hasil->result_array();
}

function get_kode_alokasi()
{
        // $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) AND 
        //                        MONTH(tanggal) = MONTH(CURRENT_DATE())");
        //
        // $q = $this->db->query("SELECT no_invoice, MAX(LEFT(no_invoice, 4)) AS kd_max FROM tbl_book_invoice WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) AND 
        //                        MONTH(tanggal) = MONTH(CURRENT_DATE()) AND status <> 'POST' AND status <> 'CANCEL' ");
        //
    $q = $this->db->query("SELECT a.no_alk, MAX(LEFT(a.no_alk, 4)) AS kd_max FROM tbl_alokasi a inner join tbl_log b on b.doc_number = a. no_alk WHERE YEAR(b.tanggal_doc) = YEAR(CURRENT_DATE()) AND 
      MONTH(b.tanggal_doc) = MONTH(CURRENT_DATE()) AND status <> 'CANCEL' ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
    } else {
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return $kd . "/ALK/NAG/" . date('my');
}
    //ubah september
function cari_invoice_alo($dt_dari_invkwt, $dt_sampai_invkwt, $id_customer, $rate, $pwith)
{


    if ($rate == '1' and $pwith == 'IDR') {
        $hasil = $this->db->query("(SELECT DISTINCT a.no_proforma_invoice AS no_invoice, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS inv_date, f.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL f.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
          a.status, a.id, if(h.amount is null,format(IF(a.value_dp = '0',a.total,a.value_dp), 0), format(((IF(a.value_dp = '0',a.total,a.value_dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) AS amount, if(h.amount is null,round((IF(a.value_dp = '0',a.total,a.value_dp)), 0),round(((IF(a.value_dp = '0',a.total,a.value_dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) as amountrate, if(h.amount is null,format((IF(a.value_dp = '0',a.total,a.value_dp)), 0),format(((IF(a.value_dp = '0',a.total,a.value_dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) as amountrate1, if(h.amount is null,round(IF(a.value_dp = '0',a.total,a.value_dp), 0), round(((IF(a.value_dp = '0',a.total,a.value_dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) AS amount1
          FROM  tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN
          tbl_invoice_proforma_detail_dp_cbd as e on a.no_proforma_invoice=e.no_invoice_proforma left JOIN 
          tbl_master_top AS f ON a.id_top = f.id left JOIN 
          tbl_duedate AS g ON a.id = g.id_invoice left join
          tbl_alokasi_detail as h on a.no_proforma_invoice = h.no_ref left join
          tbl_alokasi as i on h.no_alk = i.no_alk 
          WHERE a.tgl_proforma_inv BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.id_customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(IF(a.value_dp = '0',a.total,a.value_dp), 0), round(((IF(a.value_dp = '0',a.total,a.value_dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) != '0' and e.curr = 'IDR' ORDER BY a.id) union
          (SELECT DISTINCT a.no_dn AS no_invoice, DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date, DATEDIFF(a.due_date,a.tgl_dn) as top, a.due_date AS duedate, UPPER(b.supplier) AS customer, a.to_curr, a.status, a.id, if(h.amount is null,format(a.eqv_curr, 0), format(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) AS amount, if(h.amount is null,round((a.eqv_curr), 0),round(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) as amountrate, if(h.amount is null,format((a.eqv_curr), 0),format(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) as amountrate1, if(h.amount is null,round(a.eqv_curr, 0), round(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) AS amount1
          FROM  tbl_debitnote_h AS a INNER JOIN 
          mastersupplier AS b ON a.customer = b.id_supplier left JOIN 
          tbl_alokasi_detail as h on a.no_dn = h.no_ref left join
          tbl_alokasi as i on h.no_alk = i.no_alk 
          WHERE a.tgl_dn BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(a.eqv_curr, 0), round(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) != '0' and a.to_curr = 'IDR' ORDER BY a.id) union
          (SELECT DISTINCT a.no_invoice AS no_invoice, DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, f.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL f.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
          a.status, a.id, if(h.amount is null,format(d.grand_total, 0), format(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) AS amount, if(h.amount is null,round((d.grand_total), 0),round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) as amountrate, if(h.amount is null,format((d.grand_total), 0),format(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) as amountrate1, if(h.amount is null,round(d.grand_total, 0), round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) AS amount1
          FROM  tbl_book_invoice AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN
          tbl_invoice_pot AS d ON a.id = d.id_book_invoice  INNER JOIN
          tbl_invoice_detail as e on a.id=e.id_book_invoice left JOIN 
          tbl_master_top AS f ON a.id_top = f.id left JOIN 
          tbl_duedate AS g ON a.id = g.id_invoice left join
          tbl_alokasi_detail as h on a.no_invoice = h.no_ref left join
          tbl_alokasi as i on h.no_alk = i.no_alk left join 
          saldoawal_ar as o on o.no_invoice = a.no_invoice
          WHERE o.no_invoice is null and e.sj_date BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.id_customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(d.grand_total, 0), round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) != '0' and e.curr = 'IDR' ORDER BY a.id )
          union (SELECT DISTINCT a.no_inv AS no_invoice, DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, a.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
          a.status, a.id, if(h.amount is null,format(d.grand_total, 0), format(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)) AS amount, if(h.amount is null,round((d.grand_total), 0),round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)) as amountrate, if(h.amount is null,format((d.grand_total), 0),format(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)) as amountrate1, if(h.amount is null,round(d.grand_total, 0), round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)) AS amount1
          FROM  tbl_invoice_nb AS a INNER JOIN 
          mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
          tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv  INNER JOIN
          tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
          tbl_duedate AS g ON a.id = g.id_invoice left join
          tbl_alokasi_detail as h on a.no_inv = h.no_ref left join
          tbl_alokasi as i on h.no_alk = i.no_alk left join 
          saldoawal_ar as o on o.no_invoice = a.no_inv
          WHERE o.no_invoice is null and e.sj_date BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(d.grand_total, 0), round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)) != '0' and e.curr = 'IDR' ORDER BY a.id )
          union (select a.no_invoice, a.sj_date, a.top, a.due_date, a.customer, a.curr, a.status, a.id,

          if(h.amount is null,format(a.grand_total, 0), format(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) AS amount, 
          if(h.amount is null,round((a.grand_total), 0),round(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) as amountrate,
          if(h.amount is null,format((a.grand_total), 0),format(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) as amountrate1,
          if(h.amount is null,round(a.grand_total, 0), round(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) AS amount1
          from saldoawal_ar a left join tbl_alokasi_detail as h on a.no_invoice = h.no_ref left join tbl_alokasi as i on h.no_alk = i.no_alk  
          WHERE a.id_customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(a.grand_total, 0), round(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)) != '0' and a.curr = 'IDR' ORDER BY a.id) ");

return $hasil->result_array();
}elseif ($rate != '1' and $pwith == 'USD') {
    $hasil = $this->db->query(" (SELECT DISTINCT a.no_proforma_invoice AS no_invoice, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS inv_date, f.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL f.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
      a.status, a.id, if(h.amount is null,format(IF(a.dp = '0',a.total,a.dp), 0), format(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) AS amount, if(h.amount is null,round((IF(a.dp = '0',a.total,a.dp)), 0),round(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) as amountrate, if(h.amount is null,format((IF(a.dp = '0',a.total,a.dp)), 0),format(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) as amountrate1, if(h.amount is null,round(IF(a.dp = '0',a.total,a.dp), 0), round(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) AS amount1
      FROM  tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN
      tbl_invoice_proforma_detail_dp_cbd as e on a.no_proforma_invoice=e.no_invoice_proforma left JOIN 
      tbl_master_top AS f ON a.id_top = f.id left JOIN 
      tbl_duedate AS g ON a.id = g.id_invoice left join
      tbl_alokasi_detail as h on a.no_proforma_invoice = h.no_ref left join
      tbl_alokasi as i on h.no_alk = i.no_alk 
      WHERE a.tgl_proforma_inv BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.id_customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(IF(a.dp = '0',a.total,a.dp), 0), round(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) != '0' and e.curr = 'USD' ORDER BY a.id) union
      (SELECT DISTINCT a.no_dn AS no_invoice, DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date, DATEDIFF(a.due_date,a.tgl_dn) as top, a.due_date AS duedate, UPPER(b.supplier) AS customer, a.to_curr, a.status, a.id, if(h.amount is null,format(a.eqv_curr, 2), format(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 2)) AS amount, if(h.amount is null,round((a.eqv_curr * '$rate'), 2),round(((a.eqv_curr * '$rate') - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j where no_ref = a.no_dn)), 2)) as amountrate, if(h.amount is null,format((a.eqv_curr * '$rate'), 2),format(((a.eqv_curr * '$rate') - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j where no_ref = a.no_dn)), 2)) as amountrate1, if(h.amount is null,round(a.eqv_curr, 2), round(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 2)) AS amount1
      FROM  tbl_debitnote_h AS a INNER JOIN 
      mastersupplier AS b ON a.customer = b.id_supplier left JOIN 
      tbl_alokasi_detail as h on a.no_dn = h.no_ref left join
      tbl_alokasi as i on h.no_alk = i.no_alk 
      WHERE a.tgl_dn BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(a.eqv_curr, 2), round(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 2)) != '0' and a.to_curr = 'USD' ORDER BY a.id) union
      (SELECT DISTINCT a.no_invoice AS no_invoice, DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, f.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL f.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
      a.status, a.id, if(h.amount is null,format(d.grand_total, 2),format((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2)) AS amount, if(h.amount is null,round((d.grand_total  * '$rate'), 2),round(((d.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice))), 0)) as amountrate, if(h.amount is null,format((d.grand_total  * '$rate'), 2),format(((d.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice))), 0)) as amountrate1, if(h.amount is null,round(d.grand_total, 2),round((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2)) AS amount1
      FROM  tbl_book_invoice AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type INNER JOIN
      tbl_invoice_pot AS d ON a.id = d.id_book_invoice  INNER JOIN
      tbl_invoice_detail as e on a.id=e.id_book_invoice left JOIN 
      tbl_master_top AS f ON a.id_top = f.id left JOIN 
      tbl_duedate AS g ON a.id = g.id_invoice left join
      tbl_alokasi_detail as h on a.no_invoice = h.no_ref left join
      tbl_alokasi as i on h.no_alk = i.no_alk left join 
      saldoawal_ar as o on o.no_invoice = a.no_invoice
      WHERE o.no_invoice is null and e.sj_date BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.id_customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(d.grand_total, 2),round((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2)) != '0' and e.curr = 'USD' ORDER BY a.id) 
      union
      (SELECT DISTINCT a.no_inv AS no_invoice, DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, a.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
      a.status, a.id, if(h.amount is null,format(d.grand_total, 2),format((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv)), 2)) AS amount, if(h.amount is null,round((d.grand_total  * '$rate'), 2),round(((d.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv))), 0)) as amountrate, if(h.amount is null,format((d.grand_total  * '$rate'), 2),format(((d.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv))), 0)) as amountrate1, if(h.amount is null,round(d.grand_total, 2),round((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv)), 2)) AS amount1
      FROM  tbl_invoice_nb AS a INNER JOIN 
      mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
      tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv  INNER JOIN
      tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
      tbl_duedate AS g ON a.id = g.id_invoice left join
      tbl_alokasi_detail as h on a.no_inv = h.no_ref left join
      tbl_alokasi as i on h.no_alk = i.no_alk left join 
      saldoawal_ar as o on o.no_invoice = a.no_inv
      WHERE o.no_invoice is null and e.sj_date BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(d.grand_total, 2),round((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv)), 2)) != '0' and e.curr = 'USD' ORDER BY a.id) 
      union
      (select a.no_invoice, a.sj_date, a.top, a.due_date, a.customer, a.curr, a.status, a.id,

      if(h.amount is null,format(a.grand_total, 2),format((a.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2)) AS amount, 
      if(h.amount is null,round((a.grand_total  * '$rate'), 2),round(((a.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice))), 0)) as amountrate,
      if(h.amount is null,format((a.grand_total  * '$rate'), 2),format(((a.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice))), 0)) as amountrate1,
      if(h.amount is null,round(a.grand_total, 2),round((a.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2)) AS amount1
      from saldoawal_ar a left join tbl_alokasi_detail as h on a.no_invoice = h.no_ref left join tbl_alokasi as i on h.no_alk = i.no_alk  
      WHERE a.id_customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(a.grand_total, 2),round((a.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2)) != '0' and a.curr = 'USD' ORDER BY a.id) ");

return $hasil->result_array();
}else{

 $hasil = $this->db->query("(SELECT DISTINCT a.no_proforma_invoice AS no_invoice, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS inv_date, f.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL f.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
  a.status, a.id, if(h.amount is null,format(IF(a.dp = '0',a.total,a.dp), 0), format(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) AS amount, if(h.amount is null,round((IF(a.dp = '0',a.total,a.dp)), 0),round(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) as amountrate, if(h.amount is null,format((IF(a.dp = '0',a.total,a.dp)), 0),format(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) as amountrate1, if(h.amount is null,round(IF(a.dp = '0',a.total,a.dp), 0), round(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) AS amount1
  FROM  tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
  mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
  tbl_type AS c ON a.id_type = c.id_type INNER JOIN
  tbl_invoice_proforma_detail_dp_cbd as e on a.no_proforma_invoice=e.no_invoice_proforma left JOIN 
  tbl_master_top AS f ON a.id_top = f.id left JOIN 
  tbl_duedate AS g ON a.id = g.id_invoice left join
  tbl_alokasi_detail as h on a.no_proforma_invoice = h.no_ref left join
  tbl_alokasi as i on h.no_alk = i.no_alk 
  WHERE a.tgl_proforma_inv BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.id_customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(IF(a.dp = '0',a.total,a.dp), 0), round(((IF(a.dp = '0',a.total,a.dp)) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_proforma_invoice)), 0)) != '0' and e.curr = 'IDR' ORDER BY a.id) union
  (SELECT DISTINCT a.no_dn AS no_invoice, DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date, DATEDIFF(a.due_date,a.tgl_dn) as top, a.due_date AS duedate, UPPER(b.supplier) AS customer, a.to_curr, a.status, a.id, if(h.amount is null,format(a.eqv_curr, 0), format(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) AS amount, if(h.amount is null,round((a.eqv_curr), 0),round(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) as amountrate, if(h.amount is null,format((a.eqv_curr), 0),format(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) as amountrate1, if(h.amount is null,round(a.eqv_curr, 0), round(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) AS amount1
  FROM  tbl_debitnote_h AS a INNER JOIN 
  mastersupplier AS b ON a.customer = b.id_supplier left JOIN 
  tbl_alokasi_detail as h on a.no_dn = h.no_ref left join
  tbl_alokasi as i on h.no_alk = i.no_alk 
  WHERE a.tgl_dn BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.customer = '$id_customer' and a.status = 'APPROVED' and if(h.amount is null,round(a.eqv_curr, 0), round(((a.eqv_curr) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_dn)), 0)) != '0' and a.to_curr = 'IDR' ORDER BY a.id) union
  (SELECT DISTINCT a.no_invoice AS no_invoice, DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, f.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL f.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
  a.status, a.id, if(e.curr = 'IDR',if(h.amount is null,format(d.grand_total, 0), format(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,format(d.grand_total, 2),format((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2))) AS amount, IF(e.curr = 'IDR',if(h.amount is null,round((d.grand_total), 0),round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,round((d.grand_total  * '$rate'), 2),round(((d.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice))), 0))) as amountrate, IF(e.curr = 'IDR',if(h.amount is null,format((d.grand_total), 0),format(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,format((d.grand_total  * '$rate'), 2),format(((d.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice))), 0))) as amountrate1, if(e.curr = 'IDR',if(h.amount is null,round(d.grand_total, 0), round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,round(d.grand_total, 2),round((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2))) AS amount1
  FROM  tbl_book_invoice AS a INNER JOIN 
  mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
  tbl_type AS c ON a.id_type = c.id_type INNER JOIN
  tbl_invoice_pot AS d ON a.id = d.id_book_invoice  INNER JOIN
  tbl_invoice_detail as e on a.id=e.id_book_invoice left JOIN 
  tbl_master_top AS f ON a.id_top = f.id left JOIN 
  tbl_duedate AS g ON a.id = g.id_invoice left join
  tbl_alokasi_detail as h on a.no_invoice = h.no_ref left join
  tbl_alokasi as i on h.no_alk = i.no_alk left join 
  saldoawal_ar as o on o.no_invoice = a.no_invoice
  WHERE o.no_invoice is null and e.sj_date BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.id_customer = '$id_customer' and e.curr = 'IDR' and a.status = 'APPROVED' and if(e.curr = 'IDR',if(h.amount is null,round(d.grand_total, 0), round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,round(d.grand_total, 2),round((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2))) != '0' ORDER BY a.id) union 

  (SELECT DISTINCT a.no_inv AS no_invoice, DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, a.top, if(g.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(g.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate, UPPER(b.supplier) AS customer, e.curr,
  a.status, a.id, if(e.curr = 'IDR',if(h.amount is null,format(d.grand_total, 0), format(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)),if(h.amount is null,format(d.grand_total, 2),format((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv)), 2))) AS amount, IF(e.curr = 'IDR',if(h.amount is null,round((d.grand_total), 0),round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)),if(h.amount is null,round((d.grand_total  * '$rate'), 2),round(((d.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv))), 0))) as amountrate, IF(e.curr = 'IDR',if(h.amount is null,format((d.grand_total), 0),format(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)),if(h.amount is null,format((d.grand_total  * '$rate'), 2),format(((d.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv))), 0))) as amountrate1, if(e.curr = 'IDR',if(h.amount is null,round(d.grand_total, 0), round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)),if(h.amount is null,round(d.grand_total, 2),round((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv)), 2))) AS amount1
  FROM  tbl_invoice_nb AS a INNER JOIN 
  mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
  tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv  INNER JOIN
  tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
  tbl_duedate AS g ON a.id = g.id_invoice left join
  tbl_alokasi_detail as h on a.no_inv = h.no_ref left join
  tbl_alokasi as i on h.no_alk = i.no_alk left join 
  saldoawal_ar as o on o.no_invoice = a.no_inv
  WHERE o.no_invoice is null and e.sj_date BETWEEN '$dt_dari_invkwt' AND '$dt_sampai_invkwt' AND a.customer = '$id_customer' and e.curr = 'IDR' and a.status = 'APPROVED' and if(e.curr = 'IDR',if(h.amount is null,round(d.grand_total, 0), round(((d.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_inv)), 0)),if(h.amount is null,round(d.grand_total, 2),round((d.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_inv)), 2))) != '0' ORDER BY a.id)
  union
  (select a.no_invoice, a.sj_date, a.top, a.due_date, a.customer, a.curr, a.status, a.id,

  if(a.curr = 'IDR',if(h.amount is null,format(a.grand_total, 0), format(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,format(a.grand_total, 2),format((a.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2))) AS amount, 
  IF(a.curr = 'IDR',if(h.amount is null,round((a.grand_total), 0),round(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,round((a.grand_total  * '$rate'), 2),round(((a.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice))), 0))) as amountrate,
  IF(a.curr = 'IDR',if(h.amount is null,format((a.grand_total), 0),format(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,format((a.grand_total  * '$rate'), 2),format(((a.grand_total  * '$rate' - (select sum(j.amount) * '$rate' from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice))), 0))) as amountrate1,
  if(a.curr = 'IDR',if(h.amount is null,round(a.grand_total, 0), round(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,round(a.grand_total, 2),round((a.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2))) AS amount1
  from saldoawal_ar a left join tbl_alokasi_detail as h on a.no_invoice = h.no_ref left join tbl_alokasi as i on h.no_alk = i.no_alk  
  WHERE a.id_customer = '$id_customer' and a.curr = 'IDR' and a.status = 'APPROVED' and if(a.curr = 'IDR',if(h.amount is null,round(a.grand_total, 0), round(((a.grand_total) - (select sum(j.amount) from tbl_alokasi_detail j where no_ref = a.no_invoice)), 0)),if(h.amount is null,round(a.grand_total, 2),round((a.grand_total- (select sum(j.amount) from tbl_alokasi_detail j left join tbl_alokasi as k on j.no_alk = k.no_alk where no_ref = a.no_invoice)), 2))) != '0' ORDER BY a.id)");

return $hasil->result_array();

}

}

function delete_invoice_detail_alo()
{
    $hasil = $this->db->query("DELETE FROM tbl_alokasi_temp");
    return $hasil;
}


function simpan_invoice_detail_alo($data)
{
    $this->db->insert_batch('tbl_alokasi_temp', $data);
    return $this->db->insert_id();
}

    //ubah desember
function load_invoice_detail_alo()
{
    $hasil = $this->db->query("SELECT a.ref_number, DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, if(a.due_date = '0000-00-00', '-',DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, a.total, a.curr, a.eqp_idr, a.amount,b.no_coa,b.nama_coa,concat(b.no_coa,' ',b.nama_coa) as coa, b.profit_center
       FROM tbl_alokasi_temp a INNER JOIN
       tbl_book_invoice b on b.no_invoice = a.ref_number
       union                                                                    
       SELECT a.ref_number, DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, if(a.due_date = '0000-00-00', '-',DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, a.total, a.curr, a.eqp_idr, a.amount,b.no_coa,b.nama_coa,concat(b.no_coa,' ',b.nama_coa) as coa, 'NAG' profit_center
       FROM tbl_alokasi_temp a INNER JOIN
       tbl_invoice_nb b on b.no_inv = a.ref_number
       union                                                                    
       select ref_number, ref_date, due_date, (total- COALESCE(total_alk,0)) total, curr, (eqp_idr - COALESCE(total_alk,0)) eqv_idr, round(amount / jumlah_baris,2) amount, no_coa, nama_coa, a.coa,profit_center from (SELECT a.ref_number, DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, if(a.due_date = '0000-00-00', '-',DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, sum(b.amount) total, a.curr, sum(b.amount) eqp_idr, a.amount,b.no_coa,c.nama_coa,concat(c.no_coa,' ',c.nama_coa) as coa, COUNT(*) OVER(PARTITION BY a.ref_number) AS jumlah_baris, COALESCE(d.profit_center,'NAG') profit_center FROM tbl_alokasi_temp a INNER JOIN tbl_debitnote_det b on b.no_dn = a.ref_number  INNER JOIN tbl_debitnote_h d ON d.no_dn = a.ref_number inner join mastercoa_v2 c on c.no_coa = b.no_coa GROUP BY b.no_coa,a.ref_number) a left join (select no_ref, coa, sum(amount) total_alk from tbl_alokasi_detail GROUP BY no_ref, coa) b on b.no_ref = a.ref_number and b.coa = a.no_coa
       union
       SELECT a.ref_number, DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, if(a.due_date = '0000-00-00', '-',DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, a.total, a.curr, a.eqp_idr, a.amount, b.no_coa,b.nama_coa,concat(b.no_coa,' ',b.nama_coa) as coa, 'NAG' profit_center FROM tbl_alokasi_temp a INNER JOIN saldoawal_ar b on b.no_invoice = a.ref_number
       union                                                                    
       SELECT a.ref_number, DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, if(a.due_date = '0000-00-00', '-',DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, b.total, a.curr, b.total eqp_idr, b.total amount,b.no_coa,b.nama_coa,concat(b.no_coa,' ',b.nama_coa) as coa, 'NAG' profit_center
       FROM tbl_alokasi_temp a INNER JOIN
       jurnal_invoice_dpcbd b on b.no_inv = a.ref_number

       ");
    return $hasil->result_array();
}

/*function load_invoice_detail_alo()
{
    $hasil = $this->db->query("SELECT a.ref_number, 
     DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, 
     IF(a.due_date = '0000-00-00', '-', DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, 
     a.total, a.curr, a.eqp_idr, a.amount,
     b.no_coa, b.nama_coa, CONCAT(b.no_coa, ' ', b.nama_coa) AS coa, b.profit_center
     FROM tbl_alokasi_temp a 
     INNER JOIN tbl_book_invoice b ON b.no_invoice = a.ref_number

     UNION

     SELECT a.ref_number, 
     DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, 
     IF(a.due_date = '0000-00-00', '-', DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, 
     a.total, a.curr, a.eqp_idr, a.amount,
     b.no_coa, b.nama_coa, CONCAT(b.no_coa, ' ', b.nama_coa) AS coa, 'NAG' profit_center
     FROM tbl_alokasi_temp a 
     INNER JOIN tbl_invoice_nb b ON b.no_inv = a.ref_number

     UNION

     SELECT 
     x.ref_number, x.ref_date, x.due_date,
     (x.total - COALESCE(y.total_alk, 0)) AS total,
     x.curr,
     (x.eqp_idr - COALESCE(y.total_alk, 0)) AS eqv_idr,
     ROUND(x.amount / x.jumlah_baris, 2) AS amount,
     x.no_coa, x.nama_coa, x.coa, x.profit_center
     FROM (
        SELECT a.ref_number, 
        DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, 
        IF(a.due_date = '0000-00-00', '-', DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date,
        SUM(b.amount) AS total, 
        a.curr,
        SUM(b.amount) AS eqp_idr,
        a.amount,
        b.no_coa,
        c.nama_coa,
        CONCAT(c.no_coa, ' ', c.nama_coa) AS coa,
        (
         SELECT COUNT(*) 
         FROM tbl_debitnote_det z 
         WHERE z.no_dn = a.ref_number
         ) AS jumlah_baris, COALESCE(d.profit_center,'NAG') profit_center
        FROM tbl_alokasi_temp a
        INNER JOIN tbl_debitnote_det b ON b.no_dn = a.ref_number
                INNER JOIN tbl_debitnote_h d ON d.no_dn = a.ref_number
        INNER JOIN mastercoa_v2 c ON c.no_coa = b.no_coa
        GROUP BY a.ref_number, b.no_coa
    ) x
     LEFT JOIN (
        SELECT no_ref, coa, SUM(amount) AS total_alk 
        FROM tbl_alokasi_detail 
        GROUP BY no_ref, coa
    ) y ON y.no_ref = x.ref_number AND y.coa = x.no_coa

     UNION

     SELECT a.ref_number, 
     DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, 
     IF(a.due_date = '0000-00-00', '-', DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, 
     a.total, a.curr, a.eqp_idr, a.amount,
     b.no_coa, b.nama_coa, CONCAT(b.no_coa, ' ', b.nama_coa) AS coa, 'NAG' profit_center
     FROM tbl_alokasi_temp a 
     INNER JOIN saldoawal_ar b ON b.no_invoice = a.ref_number

     UNION

     SELECT a.ref_number, 
     DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, 
     IF(a.due_date = '0000-00-00', '-', DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, 
     b.total, a.curr, b.total AS eqp_idr, b.total AS amount,
     b.no_coa, b.nama_coa, CONCAT(b.no_coa, ' ', b.nama_coa) AS coa, 'NAG' profit_center
     FROM tbl_alokasi_temp a 
     INNER JOIN jurnal_invoice_dpcbd b ON b.no_inv = a.ref_number;


     ");
    return $hasil->result_array();
}*/

//SELECT a.ref_number, DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, if(a.due_date = '0000-00-00', '-',DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, a.total, a.curr, a.eqp_idr, a.amount,b.no_coa,c.nama_coa,concat(c.no_coa,' ',c.nama_coa) as coa FROM tbl_alokasi_temp a INNER JOIN tbl_debitnote_det b on b.no_dn = a.ref_number inner join mastercoa_v2 c on c.no_coa = b.no_coa GROUP BY b.no_coa,a.ref_number

    //SELECT a.ref_number, DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, if(a.due_date = '0000-00-00', '-',DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, round(sum(b.amount),2) total, a.curr, round(sum((b.amount) * a.rate),2) eqp_idr, round(sum(b.amount),2) amount,b.no_coa,c.nama_coa,concat(c.no_coa,' ',c.nama_coa) as coa FROM tbl_alokasi_temp a INNER JOIN tbl_debitnote_det b on b.no_dn = a.ref_number inner join mastercoa_v2 c on c.no_coa = b.no_coa GROUP BY b.no_coa,a.ref_number

    //SELECT a.ref_number, DATE_FORMAT(a.ref_date, '%Y-%m-%d') AS ref_date, if(a.due_date = '0000-00-00', '-',DATE_FORMAT(a.due_date, '%Y-%m-%d')) AS due_date, a.total, a.curr, a.eqp_idr, a.amount,b.no_coa,c.nama_coa,concat(c.no_coa,' ',c.nama_coa) as coa FROM tbl_alokasi_temp a INNER JOIN tbl_debitnote_det b on b.no_dn = a.ref_number inner join mastercoa_v2 c on c.no_coa = b.no_coa GROUP BY b.no_coa,a.ref_number


    //ubah desember
function update_coaname()
{
    $hasil = $this->db->query("UPDATE tbl_list_journal INNER JOIN mastercoa_v2 ON mastercoa_v2.no_coa = tbl_list_journal. no_coa SET tbl_list_journal.nama_coa = mastercoa_v2.nama_coa WHERE tbl_list_journal.nama_coa = '-' ");
    return $hasil;
}

    //ubah desember
function approve_invoicedp($id)
{
    $hasil = $this->db->query("UPDATE tbl_invoice_proforma_dp_cbd SET status = 'APPROVED' WHERE id = '$id' ");
    return $hasil;
}

function simpanalokasi($data)
{
    $this->db->insert_batch('tbl_alokasi', $data);
    return $this->db->insert_id();
}

    //ubah september
function simpandn_h($data)
{
    $this->db->insert_batch('tbl_debitnote_h', $data);
    return $this->db->insert_id();
}

    //ubah september
function simpandn_det($data)
{
    $this->db->insert_batch('tbl_debitnote_det', $data);
    return $this->db->insert_id();
}

function simpan_alokasi_detail($data)
{
    $this->db->insert_batch('tbl_alokasi_detail', $data);
    return $this->db->insert_id();
}

function cari_alokasi($dt_dari_kwt, $dt_sampai_kwt, $customer)
{

    if ($customer == "all_customer") {

     $hasil = $this->db->query("SELECT a.id, a.no_alk,a.tgl_alk,a.customer,b.supplier,a.doc_number,c.nama_bank as bank,a.account,a.curr,if(rate = '0', '-',format(a.rate,0)) as rate,if(a.curr = 'IDR',format(a.amount, 0), format(a.amount, 2)) as amount,format(a.eqp_idr, 0) as eqp_idr,a.status,DATE_FORMAT(d.tanggal_input, '%Y-%m-%d') as tanggal_input,d.nama from tbl_alokasi AS a INNER JOIN mastersupplier AS b ON a.customer = b.id_supplier inner join masterbank c on c.id = a.bank left join tbl_log d on d.doc_number = a.no_alk where a.tgl_alk BETWEEN '$dt_dari_kwt' AND '$dt_sampai_kwt' GROUP BY a.id ");

     return $hasil->result_array();
 } else {
    $hasil = $this->db->query("SELECT a.id, a.no_alk,a.tgl_alk,a.customer,b.supplier,a.doc_number,c.nama_bank as bank,a.account,a.curr,if(rate = '0', '-',format(a.rate,0)) as rate,if(a.curr = 'IDR',format(a.amount, 0), format(a.amount, 2)) as amount,format(a.eqp_idr, 0) as eqp_idr,a.status,DATE_FORMAT(d.tanggal_input, '%Y-%m-%d') as tanggal_input,d.nama from tbl_alokasi AS a INNER JOIN mastersupplier AS b ON a.customer = b.id_supplier inner join masterbank c on c.id = a.bank left join tbl_log d on d.doc_number = a.no_alk where a.tgl_alk BETWEEN '$dt_dari_kwt' AND '$dt_sampai_kwt' AND a.customer = '$customer' GROUP BY a.id ");
    return $hasil->result_array();
}

}

function get_bank()
{
    $hasil = $this->db->query("SELECT bank_account as akun,CONCAT(bank_name,' (',bank_account,') ') as nama from b_masterbank");
    return $hasil->result_array();
}

function cari_alokasi_report($dt_dari_kwt, $dt_sampai_kwt, $id_customer)
{

    if ($id_customer == "all_customer") {

     $hasil = $this->db->query("SELECT a.no_alk, a.tgl_alk, c.Supplier,a.doc_number,d.nama_bank,d.no_rek,a.curr,b.no_ref,b.ref_date,b.total,IF(a.rate = '0','1',a.rate) as rate,b.eqp_idr,b.amount,b.keterangan,b.status,DATE_FORMAT(e.tanggal_input, '%Y-%m-%d') as tanggal_input,e.nama from tbl_alokasi a inner join tbl_alokasi_detail b on b.no_alk = a.no_alk left join masterbank d on d.id = a.bank left join mastersupplier c on c.Id_Supplier = a.customer left join tbl_log e on e.doc_number = a.no_alk where a.tgl_alk BETWEEN '$dt_dari_kwt' AND '$dt_sampai_kwt' ");

     return $hasil->result_array();
 } else {
    $hasil = $this->db->query("SELECT a.no_alk, a.tgl_alk, c.Supplier,a.doc_number,d.nama_bank,d.no_rek,a.curr,b.no_ref,b.ref_date,b.total,IF(a.rate = '0','1',a.rate) as rate,b.eqp_idr,b.amount,b.keterangan,b.status,DATE_FORMAT(e.tanggal_input, '%Y-%m-%d') as tanggal_input,e.nama from tbl_alokasi a inner join tbl_alokasi_detail b on b.no_alk = a.no_alk left join masterbank d on d.id = a.bank left join mastersupplier c on c.Id_Supplier = a.customer left join tbl_log e on e.doc_number = a.no_alk where a.tgl_alk BETWEEN '$dt_dari_kwt' AND '$dt_sampai_kwt' AND a.customer = '$id_customer' ");
    return $hasil->result_array();
}

}

function cari_view_alokasi($no_kwt)
{

 $hasil = $this->db->query("SELECT a.no_alk, a.coa,IFNULL(c.nama_coa,'-') as coa_name, a.cost_center, IFNULL(d.cost_name,'-') as cost_name, a.no_ref, a.ref_date, a.due_date, b.curr, if(b.curr = 'IDR',format(a.total, 0), format(a.total, 2)) as total, format(a.eqp_idr,0) as eqp_idr,format(a.amount, 0) as amount,format(round(a.eqp_idr,0) - round(a.amount, 0),0) as ost, a.keterangan,e.supplier from tbl_alokasi_detail a left join 
     mastercoa_v2 c on a.coa=c.no_coa LEFT JOIN 
     tbl_alokasi b on a.no_alk = b.no_alk left join
     mastersupplier AS e ON b.customer = e.id_supplier left join
     tbl_cost_center d on a.cost_center = d.code_cost where b.id = '$no_kwt' GROUP BY a.id");

 return $hasil->result_array();

}

function report_alokasi_detail($id)
{
    $hasil = $this->db->query("SELECT a.no_alk, a.coa,IFNULL(c.nama_coa,'-') as coa_name, a.cost_center, IFNULL(d.cost_name,'-') as cost_name, a.no_ref, a.ref_date, a.due_date, b.curr, if(b.curr = 'IDR',format(a.total, 2), format(a.total, 2)) as total, format(a.eqp_idr,2) as eqp_idr,format(a.amount, 2) as amount,format(round(a.total,2) - round(a.amount, 2),2) as ost, a.keterangan,e.supplier,if(b.rate = '0','-',b.rate) as rate from tbl_alokasi_detail a left join 
     mastercoa_v2 c on a.coa=c.no_coa LEFT JOIN 
     tbl_alokasi b on a.no_alk = b.no_alk left join
     mastersupplier AS e ON b.customer = e.id_supplier left join
     tbl_cost_center d on a.cost_center = d.code_cost where b.id = '$id' GROUP BY a.id ");
    return $hasil->result_array();
}


function report_alokasi($id)
{
    $hasil = $this->db->query("SELECT a.id, a.no_alk, DATE_FORMAT(a.tgl_alk,'%d-%m-%Y') as tgl_alk,a.customer,b.supplier,a.doc_number,d.nama_bank as bank,a.account,a.curr,if(rate = '0', '-',format(a.rate,2)) as rate,if(a.curr = 'IDR',format(a.amount, 2), format(a.amount, 2)) as amount,format(a.eqp_idr, 2) as eqp_idr,a.status from tbl_alokasi AS a INNER JOIN mastersupplier AS b ON a.customer = b.id_supplier inner join masterbank d on d.id = a.bank where a.id = '$id' ");
    return $hasil->row_array();
}

function cari_invoice_manual_post($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT DISTINCT a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
      DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, a.type, a.status, a.id, b.Id_Supplier AS id_customer, CONCAT(e.curr, ' ', FORMAT(grand_total,2)) total
      FROM  tbl_invoice_nb AS a INNER JOIN 
      mastersupplier AS b ON a.customer = b.id_supplier left JOIN
      tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN
      tbl_invoice_nb_pot as f on a.no_inv=f.no_inv 
      WHERE a.status = 'POST' AND e.sj_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' ORDER BY a.id asc");
    return $hasil->result_array();

}

function approve_invoice_manual($id)
{
    $hasil = $this->db->query("UPDATE tbl_invoice_nb SET status = 'APPROVED' WHERE id = '$id' ");
    return $hasil;
}

function cari_invoice_manual_appv($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT DISTINCT a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
      DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, a.type, a.status, a.id, b.Id_Supplier AS id_customer
      FROM  tbl_invoice_nb AS a INNER JOIN 
      mastersupplier AS b ON a.customer = b.id_supplier left JOIN
      tbl_invoice_nb_detail as e on a.no_inv=e.no_inv
      WHERE a.status = 'Approved' AND e.sj_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' ORDER BY a.id asc");
    return $hasil->result_array();

}

function cari_kwt_appv($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT a.id, a.no_kwt, DATE_FORMAT(a.tgl_kwt, '%Y-%m-%d') as tgl_kwt, UPPER(b.supplier) AS supp, FORMAT((a.total), 2) as total, a.terbilang as bilang, a.status, c.curr from tbl_kwitansi a inner join mastersupplier AS b ON a.supp = b.id_supplier inner join tbl_kwitansi_detail f on f.no_kwitansi = a.no_kwt inner join tbl_book_invoice d on f.no_invoice = d.no_invoice inner JOIN tbl_invoice_detail c on d.id = c.id_book_invoice where tgl_kwt BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' and a.status = 'Post' GROUP BY a.id");
    return $hasil->result_array();

}

function cari_alokasi_appv($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT a.id, a.no_alk,a.tgl_alk,a.customer,b.supplier,a.doc_number,c.nama_bank as bank,a.account,a.curr,if(rate = '0', '-',format(a.rate,0)) as rate,if(a.curr = 'IDR',format(a.amount, 0), format(a.amount, 2)) as amount,format(a.eqp_idr, 0) as eqp_idr,a.status,d.tanggal_input,d.nama from tbl_alokasi AS a INNER JOIN mastersupplier AS b ON a.customer = b.id_supplier inner join masterbank c on c.id = a.bank left join tbl_log d on d.doc_number = a.no_alk where a.tgl_alk BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' GROUP BY a.id");
    return $hasil->result_array();
}

function copy_alokasi($id)
{
    $hasil = $this->db->query("insert into log_alokasi select * from tbl_alokasi where no_alk = '$id' ");
    return $hasil;
}

function copy_alokasi_detail($id)
{
    $hasil = $this->db->query("insert into log_alokasi_detail select * from tbl_alokasi_detail where no_alk = '$id' ");
    return $hasil;
}

function copy_jurnal_alokasi($id)
{
    $hasil = $this->db->query("insert into tbl_list_journal_cancel select * from tbl_list_journal WHERE no_journal = '$id' ");
    return $hasil;
}

function delete_alokasi($id)
{
    $hasil = $this->db->query("delete from tbl_alokasi WHERE no_alk = '$id' ");
    return $hasil;
}

function delete_jurnal_alokasi($id)
{
    $hasil = $this->db->query("delete from tbl_list_journal WHERE no_journal = '$id' ");
    return $hasil;
}

function delete_alokasi_detail($id)
{
    $hasil = $this->db->query("delete from tbl_alokasi_detail WHERE no_alk = '$id' ");
    return $hasil;
}


function cari_kartu_ar($dt_dari_inv, $dt_sampai_inv, $id_customer)
{

    if ($id_customer == "all_customer") {
            // $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, 
            //                               DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer,
            //                               FORMAT((d.grand_total), 2) AS amount
            //                        FROM  tbl_book_invoice AS a INNER JOIN 
            //                               mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            //                               tbl_type AS c ON a.id_type = c.id_type INNER JOIN
            //                                tbl_invoice_pot AS d ON a.id = d.id_book_invoice       
            //                        WHERE a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
            //                        ORDER BY a.id ");

     $hasil = $this->db->query("SELECT * from 
        (select Supplier as namasupplier from mastersupplier where tipe_sup = 'C') ms
        left JOIN

        (select a.Supplier,round(sum(if(b.shipp = 'Export',c.grand_total ,'0')),2) as totalusd,round(sum(if(b.shipp = 'Local',c.grand_total ,c.grand_total * (select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'HARIAN' and tanggal = b.tgl_inv))),2) as totalidr from tbl_book_invoice b inner join tbl_invoice_pot c on c.id_book_invoice = b.id inner join mastersupplier a on a.Id_Supplier = b.id_customer where b.status != 'CANCEL' and b.tgl_inv between '$dt_dari_inv' and '$dt_sampai_inv'  GROUP BY supplier) a on ms.namasupplier = a.Supplier
        left join

        (select customer,round(sum(if(curr = 'USD',grand_total ,'0')),2) as saldousd,round(sum(if(curr = 'IDR',grand_total ,grand_total * (select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'HARIAN' and tanggal = inv_date))),2) as saldoidr from saldoawal_ar where status != 'CANCEL' GROUP BY customer) b on ms.namasupplier = b.customer
        left join

        (select a.Supplier,b.customer,round(sum(if(b.curr = 'USD',b.amount ,'0')),2) as bayarusd,round(sum(if(b.curr = 'IDR',b.amount,b.eqp_idr)),2) as bayaridr from tbl_alokasi b inner join mastersupplier a on a.Id_Supplier = b.customer where b.status != 'CANCEL' and b.tgl_alk between '$dt_dari_inv' and '$dt_sampai_inv' GROUP BY supplier) c on ms.namasupplier = c.Supplier
        left join

        (select a.Supplier,b.customer,round(sum(if(b.curr = 'USD',b.amount ,'0')),2) as bayarusd2,round(sum(if(b.curr = 'IDR',b.amount,b.eqp_idr)),2) as bayaridr2 from tbl_alokasi b inner join mastersupplier a on a.Id_Supplier = b.customer where b.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_inv' GROUP BY supplier) d on ms.namasupplier = d.Supplier
        ");

     return $hasil->result_array();
 } else {
    $hasil = $this->db->query("SELECT * from 
        (select Supplier as namasupplier from mastersupplier where tipe_sup = 'C' and Id_Supplier = '$id_customer') ms
        left JOIN

        (select a.Supplier,round(sum(if(b.shipp = 'Export',c.grand_total ,'0')),2) as totalusd,round(sum(if(b.shipp = 'Local',c.grand_total ,c.grand_total * (select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'HARIAN' and tanggal = b.tgl_inv))),2) as totalidr from tbl_book_invoice b inner join tbl_invoice_pot c on c.id_book_invoice = b.id inner join mastersupplier a on a.Id_Supplier = b.id_customer where b.status != 'CANCEL' and b.tgl_inv between '$dt_dari_inv' and '$dt_sampai_inv' and b.id_customer= '$id_customer'  GROUP BY supplier) a on ms.namasupplier = a.Supplier
        left join

        (select customer,round(sum(if(curr = 'USD',grand_total ,'0')),2) as saldousd,round(sum(if(curr = 'IDR',grand_total ,grand_total * (select ROUND(rate,2) as rate FROM masterrate where v_codecurr = 'HARIAN' and tanggal = inv_date))),2) as saldoidr from saldoawal_ar where status != 'CANCEL' and id_customer= '$id_customer' GROUP BY customer) b on ms.namasupplier = b.customer
        left join

        (select a.Supplier,b.customer,round(sum(if(b.curr = 'USD',b.amount ,'0')),2) as bayarusd,round(sum(if(b.curr = 'IDR',b.amount,b.eqp_idr)),2) as bayaridr from tbl_alokasi b inner join mastersupplier a on a.Id_Supplier = b.customer where b.status != 'CANCEL' and b.tgl_alk between '$dt_dari_inv' and '$dt_sampai_inv' and b.customer = '$id_customer' GROUP BY supplier) c on ms.namasupplier = c.Supplier
        left join

        (select a.Supplier,b.customer,round(sum(if(b.curr = 'USD',b.amount ,'0')),2) as bayarusd,round(sum(if(b.curr = 'IDR',b.amount,b.eqp_idr)),2) as bayaridr from tbl_alokasi b inner join mastersupplier a on a.Id_Supplier = b.customer where b.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_inv' and b.customer = '$id_customer' GROUP BY supplier) d on ms.namasupplier = d.Supplier ");
    return $hasil->result_array();
}
        //
        //With Duedate Query
        //
        // $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.peb,
        //                                   DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS tanggal, DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d') AS tanggal_kontrabon, 
        //                                   d.top, CASE WHEN e.status = 'DONE' THEN DATE_ADD(DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d'), INTERVAL d.top DAY) 
        //                                   ELSE DATE_ADD(DATE_FORMAT(a.tgl_inv, '%Y-%m-%d'), INTERVAL d.top DAY) END AS duedate,
        //                                   c.type, a.status, a.id AS id_inv, e.id_invoice AS id_inv_dd, e.status AS status_duedate
        //                            FROM  tbl_book_invoice AS a INNER JOIN 
        //                                   mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        //                                   tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
        //                                   tbl_master_top AS d ON a.id_top = d.id LEFT JOIN
        //                                   tbl_duedate AS e ON a.id = e.id_invoice
        //                            WHERE a.status = 'APPROVED' AND a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND a.id_customer = '$id_customer' ");
        // return $hasil->result_array();
}

function cari_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus)
{

    if ($id_cus == "all_customer") {

     $hasil = $this->db->query("SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
            FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
            FROM  tbl_book_invoice AS a INNER JOIN 
            mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            tbl_type AS c ON a.id_type = c.id_type INNER JOIN
            tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
            tbl_master_top AS f ON a.id_top = f.id left join 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_invoice
            where g.no_invoice is null and a.sj_date between '2022-05-01' and '$dt_sampai_alk'
            union
            SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
            FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
            FROM  tbl_invoice_nb AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
            tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
            tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_inv
            where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$dt_sampai_alk'
            union                                                                     
            select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar where no_invoice not like '%DN/%') inv LEFT JOIN
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rt) a) a
");

return $hasil->result_array();
} else {
    $hasil = $this->db->query("SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
            FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
            FROM  tbl_book_invoice AS a INNER JOIN 
            mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            tbl_type AS c ON a.id_type = c.id_type INNER JOIN
            tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
            tbl_master_top AS f ON a.id_top = f.id left join 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_invoice
            where g.no_invoice is null and a.sj_date between '2022-05-01' and '$dt_sampai_alk' and a.id_customer = '$id_cus'                                    

            union

            SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
            FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
            FROM  tbl_invoice_nb AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
            tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
            tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_inv
            where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$dt_sampai_alk' and a.customer = '$id_cus'
            union

            select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1,due_date,shipp from saldoawal_ar where id_customer = '$id_cus' and no_invoice not like '%DN/%') inv LEFT JOIN
        

        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        

        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rt) a) a");
return $hasil->result_array();
}
}

//ubah september

function cari_mutasi_invoice_dp($dt_dari_alk, $dt_sampai_alk, $id_cus)
{

    if ($id_cus == "all_customer") {

     $hasil = $this->db->query("SELECT * from 
        (SELECT distinct a.no_proforma_invoice AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,f.top,
            FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 2) AS amount, if(e.curr = 'USD',IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)),round(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 0)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL f.top DAY)) AS duedate
            FROM  tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
            mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            tbl_invoice_proforma_detail_so_dp_cbd as e on a.no_proforma_invoice=e.no_invoice_proforma inner JOIN 
            tbl_master_top AS f ON a.id_top = f.id left JOIN 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_proforma_invoice
            where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_proforma_inv between '$dt_dari_alk' and '$dt_sampai_alk'
            union
            SELECT distinct a.no_proforma_invoice AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,f.top,
            FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 2) AS amount, if(e.curr = 'USD',IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)),round(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 0)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL f.top DAY)) AS duedate
            FROM  tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
            mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            tbl_invoice_proforma_detail_so_dp_cbd as e on a.no_proforma_invoice=e.no_invoice_proforma inner JOIN 
            tbl_master_top AS f ON a.id_top = f.id left JOIN 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_proforma_invoice
            where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_proforma_inv between '2022-05-01' and '$dt_dari_alk'
-- union

-- select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar
) inv LEFT JOIN


        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN


        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice
        ");

     return $hasil->result_array();
 } else {
    $hasil = $this->db->query("SELECT * from 
        (SELECT distinct a.no_proforma_invoice AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.id_top,
            if(e.curr = 'IDR',FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 0),round(FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 2), 2)) AS amount, if(e.curr = 'IDR',FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 0),round(FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 2), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d'), INTERVAL a.id_top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.id_top DAY)) AS duedate
                FROM  tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
            mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            tbl_invoice_proforma_detail_so_dp_cbd as e on a.no_proforma_invoice=e.no_invoice_proforma left JOIN 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_proforma_invoice
            where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_proforma_inv between '$dt_dari_alk' and '$dt_sampai_alk' a.id_customer = '$id_cus'
            union
            SELECT distinct a.no_proforma_invoice AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.id_top,
            if(e.curr = 'IDR',FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 0),round(FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 2), 2)) AS amount, if(e.curr = 'IDR',FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 0),round(FORMAT(IF(a.dp = '0',a.total,if(a.tipe_dp = '%',a.value_dp,a.dp)), 2), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d'), INTERVAL a.id_top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.id_top DAY)) AS duedate
                FROM  tbl_invoice_proforma_dp_cbd AS a INNER JOIN 
            mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            tbl_invoice_proforma_detail_so_dp_cbd as e on a.no_proforma_invoice=e.no_invoice_proforma left JOIN 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_proforma_invoice
            where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_proforma_inv between '2022-05-01' and '$dt_dari_alk' a.id_customer = '$id_cus'                                   

            union

            select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1,due_date from saldoawal_ar where id_customer = '$id_cus') inv LEFT JOIN
        

        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        

        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice ");
    return $hasil->result_array();
}
}

//ubah september

function cari_mutasi_debit_note($dt_dari_alk, $dt_sampai_alk, $id_cus)
{

    if ($id_cus == "all_customer") {

     $hasil = $this->db->query("SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,COALESCE(amount1,0) amount1, duedate, no_invoice1,COALESCE(bayar,0) bayar, no_invoice2,COALESCE(bayar2,0) bayar2, COALESCE(amount,0) amount,IF(supplier is null,'-',supplier) supplier,IF(from_curr = 'IDR','1',rate) rate,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due  from 
        (
            SELECT distinct a.no_dn AS no_invoice, UPPER(b.supplier) AS customer, a.attn,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, a.to_curr as from_curr,DATEDIFF(a.due_date,a.tgl_dn) top,
            FORMAT(a.eqv_curr, 2) AS amount, if(a.to_curr = 'USD',a.eqv_curr,round(a.eqv_curr, 2)) AS amount1,a.due_date duedate
            FROM  tbl_debitnote_h AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier left join
            saldoawal_ar as g on g.no_invoice = a.no_dn
            where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_dn between '2022-05-01' and '$dt_sampai_alk'
            union

            select no_invoice, customer, '' attn, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar where no_invoice like '%DN/%'
            ) inv LEFT JOIN
        
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk >= '2022-05-01' and b.tgl_alk < '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN

        (select no_dn dnno,supplier from tbl_debitnote_det where supplier != '-' GROUP BY no_dn
            ) l_supp on l_supp.dnno = inv.no_invoice JOIN

        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rate) a) a order by no_invoice asc
     ");

return $hasil->result_array();
} else {
    $hasil = $this->db->query("SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,COALESCE(amount1,0) amount1, duedate, no_invoice1,COALESCE(bayar,0) bayar, no_invoice2,COALESCE(bayar2,0) bayar2, COALESCE(amount,0) amount,IF(supplier is null,'-',supplier) supplier,IF(from_curr = 'IDR','1',rate) rate,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due  from 
        (
            SELECT distinct a.no_dn AS no_invoice, UPPER(b.supplier) AS customer, a.attn,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, a.to_curr as from_curr,DATEDIFF(a.due_date,a.tgl_dn) top,
            FORMAT(a.eqv_curr, 2) AS amount, if(a.to_curr = 'USD',a.eqv_curr,round(a.eqv_curr, 0)) AS amount1,a.due_date duedate
            FROM  tbl_debitnote_h AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier left join
            saldoawal_ar as g on g.no_invoice = a.no_dn
            where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_dn between '2022-05-01' and '$dt_sampai_alk' and a.customer = '$id_cus'
            union

            select no_invoice, customer, '' attn, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar where no_invoice like '%DN/%'
            ) inv LEFT JOIN
        
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN

        (select no_dn dnno,supplier from tbl_debitnote_det where supplier != '-' GROUP BY no_dn
            ) l_supp on l_supp.dnno = inv.no_invoice JOIN

        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rate) a) a");
return $hasil->result_array();
}
}


function cari_nm_memo()
{
    $hasil = $this->db->query("SELECT nm_memo from memo_h where no_dn = '' ");
    return $hasil->result_array();
}

function edit_memo_h($dn_number, $nm_memo)
{
    $hasil = $this->db->query("UPDATE memo_h set no_dn = '$dn_number' WHERE nm_memo = '$nm_memo' ");
    return $hasil;
}


function cari_invoice_memo($dt_dari_memo, $dt_sampai_memo, $id_customer)
{
    $hasil = $this->db->query("SELECT b.id,a.id_supplier,d.supplier,a.nm_memo, a.tgl_memo,IF(b.inv_vendor is null,'-',b.inv_vendor) no_invoice,a.curr,sum(b.biaya) grand_total,'' id_book from memo_h a inner join mastersupplier d on d.id_supplier =a.id_supplier inner join memo_det b on b.id_h = a.id_h where a.id_buyer = '$id_customer' and a.tgl_memo BETWEEN '$dt_dari_memo' and '$dt_sampai_memo' and a.status NOT IN ('DRAFT','CANCEL') and b.cancel = 'N' and b.no_dn is null GROUP BY b.id order by a.nm_memo asc");
    return $hasil->result_array();
}


//     function cari_invoice_memo($dt_dari_memo, $dt_sampai_memo, $id_customer)
//     {
//         $hasil = $this->db->query("SELECT * FROM (SELECT b.id,a.id_supplier,d.supplier,a.nm_memo, a.tgl_memo,b.no_invoice,c.grand_total,b.id_book from memo_h a inner join memo_inv b on b.id_h = a.id_h INNER JOIN tbl_invoice_pot c on c.id_book_invoice = b.id_book inner join mastersupplier d on d.id_supplier =a.id_supplier where a.id_buyer = '$id_customer' and a.tgl_memo BETWEEN '$dt_dari_memo' and '$dt_sampai_memo' GROUP BY b.id) a INNER JOIN
// (SELECT id_book_invoice,curr from tbl_invoice_detail GROUP BY id_book_invoice) b on b.id_book_invoice = a. id_book");
//         return $hasil->result_array();
//     }

function simpan_invoice_detail_memo($data)
{
    $this->db->insert_batch('tbl_memo_temp', $data);
    return $this->db->insert_id();
}


function load_invoice_detail_memo()
{
    $hasil = $this->db->query("SELECT id,id_supplier,supplier,no_invoice,curr,total,nm_memo from tbl_memo_temp");
    return $hasil->result_array();
}

function delete_memo_temp()
{
    $hasil = $this->db->query("delete from tbl_memo_temp");
    return $hasil;
}

function update_memo_det($dn_number, $id_memodet)
{
    $hasil = $this->db->query("UPDATE memo_det set no_dn = '$dn_number' WHERE id = '$id_memodet' ");
    return $hasil;
}


function excel_debit_note($dt_dari_inv, $dt_sampai_inv, $id_customer)
{

    if ($id_customer == "all_customer") {
        $hasil = $this->db->query("SELECT * FROM (SELECT c.id,a.no_dn,a.tgl_dn,a.attn,b.Supplier consignee,c.supplier,c.supplier_invoice,a.from_curr,a.to_curr,format(c.value,2) amount,format(c.rate,2) rate,format(c.amount,2) eqv_idr,c.deskripsi,a.status from tbl_debitnote_h a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer INNER JOIN tbl_debitnote_det c on c.no_dn = a.no_dn where a.status != 'Cancel' and a.tgl_dn BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' GROUP BY c.id order by c.id asc) a left join
            (SELECT no_dn nodn,IF(nodn is null,'OTHER','MEMO') type_dn from (select DISTINCT a.no_dn,b.no_dn nodn from tbl_debitnote_det a left join memo_det b on a.no_dn = b.no_dn) a) b on b.nodn = a.no_dn");
        return $hasil->result_array();
    } else {
        $hasil = $this->db->query("SELECT * FROM (SELECT c.id,a.no_dn,a.tgl_dn,a.attn,b.Supplier consignee,c.supplier,c.supplier_invoice,a.from_curr,a.to_curr,format(c.value,2) amount,format(c.rate,2) rate,format(c.amount,2) eqv_idr,c.deskripsi,a.status from tbl_debitnote_h a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer INNER JOIN tbl_debitnote_det c on c.no_dn = a.no_dn where a.status != 'Cancel' and a.tgl_dn BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND a.customer = '$id_customer' GROUP BY c.id order by c.id asc) a left join
            (SELECT no_dn nodn,IF(nodn is null,'OTHER','MEMO') type_dn from (select DISTINCT a.no_dn,b.no_dn nodn from tbl_debitnote_det a left join memo_det b on a.no_dn = b.no_dn) a) b on b.nodn = a.no_dn");
        return $hasil->result_array();
    }
}

function cari_dn_appv($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT a.id,a.no_dn,a.tgl_dn,b.Supplier,a.attn,a.from_curr,a.to_curr,a.amount,a.eqv_curr,a.status from tbl_debitnote_h a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer
       WHERE a.status = 'APPROVED' AND a.tgl_dn BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
       GROUP BY a.no_dn");
    return $hasil->result_array();
}

function update_dn_h($id)
{
    $hasil = $this->db->query("UPDATE tbl_debitnote_h set status = 'POST' WHERE no_dn = '$id' ");
    return $hasil;
}

function update_status_memo($id)
{
    $hasil = $this->db->query("UPDATE memo_det SET no_dn = null WHERE no_dn = '$id' ");
    return $hasil;
}

function cari_summary_ar($dt_dari_alk, $dt_sampai_alk, $id_cus)
{

    if ($id_cus == "all_customer") {

     $hasil = $this->db->query("SELECT shipp,id_customer,customer, curr, IF(curr = 'USD',sum(total),0) foreign_curr, sum(eqv_idr) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= '$dt_sampai_alk',eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > '$dt_sampai_alk',eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (if(((sal_awal + tambah) - bayar) >= 0.1,((sal_awal + tambah) - bayar),0) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= '$dt_sampai_alk','0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= '$dt_sampai_alk',(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
            FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
            FROM  tbl_book_invoice AS a INNER JOIN 
            mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            tbl_type AS c ON a.id_type = c.id_type INNER JOIN
            tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
            tbl_master_top AS f ON a.id_top = f.id left join 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_invoice
            where g.no_invoice is null and a.sj_date between '2022-05-01' and '$dt_sampai_alk'
            union
            SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
            FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
            FROM  tbl_invoice_nb AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
            tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
            tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_inv
            where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$dt_sampai_alk'
            union                                                                     
            select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar where no_invoice not like '%DN/%') inv LEFT JOIN
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rt) a) a) a) a) a ) a GROUP BY a.id_customer,shipp
");

return $hasil->result_array();
} else {
    $hasil = $this->db->query("SELECT shipp,id_customer,customer, curr, IF(curr = 'USD',sum(total),0) foreign_curr, sum(eqv_idr) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= '$dt_sampai_alk',eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > '$dt_sampai_alk',eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (if(((sal_awal + tambah) - bayar) >= 0.1,((sal_awal + tambah) - bayar),0) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= '$dt_sampai_alk','0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= '$dt_sampai_alk',(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
            FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
            FROM  tbl_book_invoice AS a INNER JOIN 
            mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            tbl_type AS c ON a.id_type = c.id_type INNER JOIN
            tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
            tbl_master_top AS f ON a.id_top = f.id left join 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_invoice
            where g.no_invoice is null and a.sj_date between '2022-05-01' and '$dt_sampai_alk' and a.id_customer = '$id_cus'                                    

            union

            SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
            FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
            FROM  tbl_invoice_nb AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
            tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
            tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
            tbl_duedate AS h ON a.id = h.id_invoice left join
            saldoawal_ar as g on g.no_invoice = a.no_inv
            where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$dt_sampai_alk' and a.customer = '$id_cus'
            union

            select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1,due_date,shipp from saldoawal_ar where id_customer = '$id_cus' and no_invoice not like '%DN/%') inv LEFT JOIN
        

        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        

        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rt) a) a) a) a) a ) a GROUP BY a.id_customer,shipp");
return $hasil->result_array();
}
}



function cari_summary_dn($dt_dari_alk, $dt_sampai_alk, $id_cus)
{

    if ($id_cus == "all_customer") {

     $hasil = $this->db->query("SELECT id_customer,customer, from_curr, IF(from_curr = 'USD',sum(total),0) foreign_curr, sum(COALESCE(eqv_idr,0)) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= '$dt_sampai_alk',eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > '$dt_sampai_alk',eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (if(((sal_awal + tambah) - bayar) >= 0.1,((sal_awal + tambah) - bayar),0) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, IF(from_curr = 'USD',rate,'1') rate, IF(inv_date >= '$dt_sampai_alk','0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= '$dt_sampai_alk',(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,COALESCE(amount1,0) amount1, duedate, no_invoice1,COALESCE(bayar,0) bayar, no_invoice2,COALESCE(bayar2,0) bayar2, COALESCE(amount,0) amount,IF(supplier is null,'-',supplier) supplier,IF(from_curr = 'IDR','1',rate) rate,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due  from 
        (
            SELECT distinct a.no_dn AS no_invoice, UPPER(b.supplier) AS customer, a.attn,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, a.to_curr as from_curr,DATEDIFF(a.due_date,a.tgl_dn) top,
            FORMAT(a.eqv_curr, 2) AS amount, if(a.to_curr = 'USD',a.eqv_curr,round(a.eqv_curr, 0)) AS amount1,a.due_date duedate
            FROM  tbl_debitnote_h AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier left join
            saldoawal_ar as g on g.no_invoice = a.no_dn
            where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_dn between '2022-05-01' and '$dt_sampai_alk'
            union

            select no_invoice, customer, '' attn, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar where no_invoice like '%DN/%'
            ) inv LEFT JOIN
        
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN

        (select no_dn dnno,supplier from tbl_debitnote_det where supplier != '-' GROUP BY no_dn
            ) l_supp on l_supp.dnno = inv.no_invoice JOIN

        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rate) a) a) a) a) a ) a GROUP BY a.id_customer,from_curr
");

return $hasil->result_array();
} else {
    $hasil = $this->db->query("SELECT id_customer,customer, from_curr, IF(from_curr = 'USD',sum(total),0) foreign_curr, sum(COALESCE(eqv_idr,0)) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= '$dt_sampai_alk',eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > '$dt_sampai_alk',eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (if(((sal_awal + tambah) - bayar) >= 0.1,((sal_awal + tambah) - bayar),0) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, IF(from_curr = 'USD',rate,'1') rate, IF(inv_date >= '$dt_sampai_alk','0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= '$dt_sampai_alk',(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,COALESCE(amount1,0) amount1, duedate, no_invoice1,COALESCE(bayar,0) bayar, no_invoice2,COALESCE(bayar2,0) bayar2, COALESCE(amount,0) amount,IF(supplier is null,'-',supplier) supplier,IF(from_curr = 'IDR','1',rate) rate,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due  from 
        (
            SELECT distinct a.no_dn AS no_invoice, UPPER(b.supplier) AS customer, a.attn,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, a.to_curr as from_curr,DATEDIFF(a.due_date,a.tgl_dn) top,
            FORMAT(a.eqv_curr, 2) AS amount, if(a.to_curr = 'USD',a.eqv_curr,round(a.eqv_curr, 0)) AS amount1,a.due_date duedate
            FROM  tbl_debitnote_h AS a INNER JOIN 
            mastersupplier AS b ON a.customer = b.id_supplier left join
            saldoawal_ar as g on g.no_invoice = a.no_dn
            where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_dn between '2022-05-01' and '$dt_sampai_alk' and a.customer = '$id_cus'
            union

            select no_invoice, customer, '' attn, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar where no_invoice like '%DN/%'
            ) inv LEFT JOIN
        
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN

        (select no_dn dnno,supplier from tbl_debitnote_det where supplier != '-' GROUP BY no_dn
            ) l_supp on l_supp.dnno = inv.no_invoice JOIN

        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rate) a) a) a) a) a ) a GROUP BY a.id_customer,from_curr");
return $hasil->result_array();
}
}



function cari_summary_all($dt_dari_alk, $dt_sampai_alk, $id_cus)
{

    if ($id_cus == "all_customer") {

     $hasil = $this->db->query("(SELECT shipp,id_customer,customer, curr, IF(curr = 'USD',sum(total),0) foreign_curr, sum(eqv_idr) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= '$dt_sampai_alk',eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > '$dt_sampai_alk',eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= '$dt_sampai_alk','0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= '$dt_sampai_alk',(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
        FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_invoice
        where g.no_invoice is null and a.sj_date between '2022-05-01' and '$dt_sampai_alk'
        union
        SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
        FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
        FROM  tbl_invoice_nb AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
        tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
        tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_inv
        where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$dt_sampai_alk'
        union                                                                     
        select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar where no_invoice not like '%DN/%') inv LEFT JOIN
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rt) a) a) a) a) a ) a GROUP BY a.id_customer,shipp) 

        UNION (SELECT '',id_customer,customer, from_curr, IF(from_curr = 'USD',sum(total),0) foreign_curr, sum(COALESCE(eqv_idr,0)) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= '$dt_sampai_alk',eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > '$dt_sampai_alk',eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, IF(from_curr = 'USD',rate,'1') rate, IF(inv_date >= '$dt_sampai_alk','0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= '$dt_sampai_alk',(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,COALESCE(amount1,0) amount1, duedate, no_invoice1,COALESCE(bayar,0) bayar, no_invoice2,COALESCE(bayar2,0) bayar2, COALESCE(amount,0) amount,IF(supplier is null,'-',supplier) supplier,IF(from_curr = 'IDR','1',rate) rate,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due  from 
        (
        SELECT distinct a.no_dn AS no_invoice, UPPER(b.supplier) AS customer, a.attn,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, a.to_curr as from_curr,DATEDIFF(a.due_date,a.tgl_dn) top,
        FORMAT(a.eqv_curr, 2) AS amount, if(a.to_curr = 'USD',a.eqv_curr,round(a.eqv_curr, 0)) AS amount1,a.due_date duedate
        FROM  tbl_debitnote_h AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier left join
        saldoawal_ar as g on g.no_invoice = a.no_dn
        where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_dn between '2022-05-01' and '$dt_sampai_alk'
        union
        
        select no_invoice, customer, '' attn, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar where no_invoice like '%DN/%'
        ) inv LEFT JOIN
        
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN

        (select no_dn dnno,supplier from tbl_debitnote_det where supplier != '-' GROUP BY no_dn
        ) l_supp on l_supp.dnno = inv.no_invoice JOIN

        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rate) a) a) a) a) a ) a GROUP BY a.id_customer,from_curr)
        ");

return $hasil->result_array();
} else {
    $hasil = $this->db->query("(SELECT shipp,id_customer,customer, curr, IF(curr = 'USD',sum(total),0) foreign_curr, sum(eqv_idr) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= '$dt_sampai_alk',eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > '$dt_sampai_alk',eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= '$dt_sampai_alk','0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= '$dt_sampai_alk',(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
        FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
        FROM  tbl_book_invoice AS a INNER JOIN 
        mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
        tbl_type AS c ON a.id_type = c.id_type INNER JOIN
        tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
        tbl_master_top AS f ON a.id_top = f.id left join 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_invoice
        where g.no_invoice is null and a.sj_date between '2022-05-01' and '$dt_sampai_alk' and a.id_customer = '$id_cus'                                    
        
        union

        SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
        FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
        FROM  tbl_invoice_nb AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
        tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
        tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
        tbl_duedate AS h ON a.id = h.id_invoice left join
        saldoawal_ar as g on g.no_invoice = a.no_inv
        where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and '$dt_sampai_alk' and a.customer = '$id_cus'
        union
        
        select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1,due_date,shipp from saldoawal_ar where id_customer = '$id_cus' and no_invoice not like '%DN/%') inv LEFT JOIN
        

        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        

        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rt) a) a) a) a) a ) a GROUP BY a.id_customer,shipp) 

        UNION (SELECT '',id_customer,customer, from_curr, IF(from_curr = 'USD',sum(total),0) foreign_curr, sum(COALESCE(eqv_idr,0)) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= '$dt_sampai_alk',eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > '$dt_sampai_alk',eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date,  duedate, top, from_curr, IF(from_curr = 'USD',rate,'1') rate, IF(inv_date >= '$dt_sampai_alk','0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= '$dt_sampai_alk',(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,amount1, duedate, no_invoice1 , bayar, no_invoice2, bayar2, amount, supplier, rate, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due FROM (SELECT no_invoice,customer,attn,inv_date,tgl_inv,id_customer,from_curr,top,COALESCE(amount1,0) amount1, duedate, no_invoice1,COALESCE(bayar,0) bayar, no_invoice2,COALESCE(bayar2,0) bayar2, COALESCE(amount,0) amount,IF(supplier is null,'-',supplier) supplier,IF(from_curr = 'IDR','1',rate) rate,DATEDIFF('$dt_sampai_alk',duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT('$dt_sampai_alk','%m') fil_bln1,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT('$dt_sampai_alk','%m') + 5,2,0) fil_bln6, DATE_FORMAT('$dt_sampai_alk','%Y') fil_thn, IF(duedate <= '$dt_sampai_alk',amount1,0) ready_due  from 
        (
        SELECT distinct a.no_dn AS no_invoice, UPPER(b.supplier) AS customer, a.attn,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS inv_date,DATE_FORMAT(a.tgl_dn, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, a.to_curr as from_curr,DATEDIFF(a.due_date,a.tgl_dn) top,
        FORMAT(a.eqv_curr, 2) AS amount, if(a.to_curr = 'USD',a.eqv_curr,round(a.eqv_curr, 0)) AS amount1,a.due_date duedate
        FROM  tbl_debitnote_h AS a INNER JOIN 
        mastersupplier AS b ON a.customer = b.id_supplier left join
        saldoawal_ar as g on g.no_invoice = a.no_dn
        where g.no_invoice is null and a.status != 'CANCEL' and a.tgl_dn between '2022-05-01' and '$dt_sampai_alk' and a.customer = '$id_cus'
        union
        
        select no_invoice, customer, '' attn, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date from saldoawal_ar where no_invoice like '%DN/%'
        ) inv LEFT JOIN
        
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '$dt_dari_alk' and '$dt_sampai_alk' and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between '2022-05-01' and '$dt_dari_alk' and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice LEFT JOIN

        (select no_dn dnno,supplier from tbl_debitnote_det where supplier != '-' GROUP BY no_dn
        ) l_supp on l_supp.dnno = inv.no_invoice JOIN

        (select IF((select id from tbl_tgl_tb where tgl_akhir = '$dt_sampai_alk') != '',(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'HARIAN'),(select rate from masterrate where tanggal = '$dt_sampai_alk' and v_codecurr = 'PAJAK')) rate) rate) a) a) a) a) a ) a GROUP BY a.id_customer,from_curr)");
return $hasil->result_array();
}
}

//telah dibagi
function cari_sls_ytd_inv($filter)
{
    if ($filter == 'NAG') {
       $where = "and a.profit_center = 'NAG'";
   }elseif ($filter == 'NAK') {
    $where = "and a.profit_center = 'NAK'";
}else{
    $where = "";
}

$query = $this->db->query("SELECT sum(eqv_idr) sls_ytd_inv from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.id_type = '1' and a.status IN ('APPROVED','POST') $where and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");
foreach ($query->result() as $data) {
    $hasil = ($data->sls_ytd_inv);
}

return $hasil;
}


function cari_sls_cm_inv($filter)
{

    if ($filter == 'NAG') {
     $where = "and a.profit_center = 'NAG'";
     $query = $this->db->query("SELECT sum(eqv_idr) sls_cm_inv from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.id_type = '1' and a.status  IN ('APPROVED','POST') $where and a.sj_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) 
        UNION 
        select a.customer id_customer,a.status,a.id,c.Supplier customer,a.no_inv no_invoice,a.inv_date sj_date,a.type id_type,'IDR' curr,total from tbl_invoice_nb a inner join tbl_invoice_nb_pot b on b.no_inv = a.no_inv inner join mastersupplier c on c.Id_Supplier = a.customer where a.type = 'Commercial' and a.status  IN ('APPROVED','POST') and a.inv_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y'))) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");
 }elseif ($filter == 'NAK') {
    $where = "and a.profit_center = 'NAK'";
    $query = $this->db->query("SELECT sum(eqv_idr) sls_cm_inv from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.id_type = '1' and a.status  IN ('APPROVED','POST') $where and a.sj_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y'))) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");
}else{
    $where = "";
    $query = $this->db->query("SELECT sum(eqv_idr) sls_cm_inv from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.id_type = '1' and a.status  IN ('APPROVED','POST') $where and a.sj_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) 
        UNION 
        select a.customer id_customer,a.status,a.id,c.Supplier customer,a.no_inv no_invoice,a.inv_date sj_date,a.type id_type,'IDR' curr,total from tbl_invoice_nb a inner join tbl_invoice_nb_pot b on b.no_inv = a.no_inv inner join mastersupplier c on c.Id_Supplier = a.customer where a.type = 'Commercial' and a.status  IN ('APPROVED','POST') and a.inv_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y'))) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");
}
        // $query = $this->db->query("SELECT sum(eqv_idr) sls_cm_inv from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.id_type = '1' and a.status  IN ('APPROVED','POST') and a.sj_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y'))) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");


foreach ($query->result() as $data) {
    $hasil = ($data->sls_cm_inv);
}

return $hasil;
}

function cari_sls_no_inv($filter)
{
    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $query = $this->db->query("SELECT sum(total) sales_no_inv from tbl_data_dsb_ar where jenis_data = 'sales_no_inv' $where");

    foreach ($query->result() as $data) {
        $hasil = ($data->sales_no_inv);
        $hasil2 = 0;
        if ($query->num_rows() > 0) {
            return $hasil;
        }else{
            return $hasil2;
        }
    }

    return $hasil;
}

function cari_sls_cm_no_inv($filter)
{
    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $query = $this->db->query("SELECT sum(total) sales_cm_no_inv from tbl_data_dsb_ar where jenis_data = 'sales_cm_no_inv' $where");

    foreach ($query->result() as $data) {
        $hasil = ($data->sales_cm_no_inv);
    }

    return $hasil;
}

function cari_ar_eqvidr($filter)
{
    if ($filter == 'NAG') {
        $query = $this->db->query("SELECT eqv_idr ar_eqvidr from tbl_data_sum_ar2");
    }elseif ($filter == 'NAK') {
        $query = $this->db->query("SELECT eqv_idr ar_eqvidr from tbl_data_sum_ar_knitting");
    }else{
        $query = $this->db->query("SELECT sum(ar_eqvidr) ar_eqvidr from (SELECT eqv_idr ar_eqvidr from tbl_data_sum_ar_knitting UNION SELECT eqv_idr ar_eqvidr from tbl_data_sum_ar2) a");
    }

    foreach ($query->result() as $data) {
        $hasil = ($data->ar_eqvidr);
    }

    return $hasil;
}


function cari_ready_due($filter)
{
    if ($filter == 'NAG') {
        $query = $this->db->query("SELECT ready_due from tbl_data_sum_ar2");
    }elseif ($filter == 'NAK') {
        $query = $this->db->query("SELECT ready_due from tbl_data_sum_ar_knitting");
    }else{
        $query = $this->db->query("SELECT sum(ready_due) ready_due from (SELECT ready_due from tbl_data_sum_ar_knitting UNION SELECT ready_due from tbl_data_sum_ar2) a");
    }

    foreach ($query->result() as $data) {
        $hasil = ($data->ready_due);
    }

    return $hasil;
}


function cari_ar_lokal($filter)
{

    if ($filter == 'NAG') {
     $where = "and a.profit_center = 'NAG'";
 }elseif ($filter == 'NAK') {
    $where = "and a.profit_center = 'NAK'";
}else{
    $where = "";
}
$query = $this->db->query("SELECT Coalesce(sum(eqv_idr),0) eqv_idr from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.shipp = 'Local' and a.id_type = '1' and a.status IN ('APPROVED','POST') $where and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE()) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");
foreach ($query->result() as $data) {
    $hasil = ($data->eqv_idr);
}

return $hasil;
}

function cari_ar_lokal_ni($filter)
{
    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $query = $this->db->query("SELECT sum(total) eqv_idr from tbl_data_dsb_ar where jenis_data = 'ar_lokal_ni' $where");
    
    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}


function cari_ar_ekspor($filter)
{
    if ($filter == 'NAG') {
       $where = "and a.profit_center = 'NAG'";
   }elseif ($filter == 'NAK') {
    $where = "and a.profit_center = 'NAK'";
}else{
    $where = "";
}

$query = $this->db->query("SELECT Coalesce(sum(eqv_idr),0) eqv_idr from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.shipp = 'Export' and a.id_type = '1' and a.status IN ('APPROVED','POST') $where and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE()) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");
foreach ($query->result() as $data) {
    $hasil = ($data->eqv_idr);
}

return $hasil;
}

function cari_ar_ekspor_ni($filter)
{
    // $query = $this->db->query("SELECT Coalesce(sum(eqv_idr),0) eqv_idr from (SELECT bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr, area from (SELECT if(f.area = 'I','Export','Local') area,f.supplier,a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
    //     d.styleno, e.product_group, e.product_item, b.color, b.size,  
    //     c.curr, c.unit AS uom, c.qty, Round(b.price,4) AS unit_price,  
    //     ROUND(c.qty * Round(b.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
    //     FROM so AS a INNER JOIN 
    //     so_det AS b ON a.id = b.id_so INNER JOIN 
    //     bppb AS c ON b.id = c.id_so_det INNER JOIN 
    //     act_costing AS d ON a.id_cost = d.id INNER JOIN 
    //     masterproduct AS e ON d.id_product = e.id INNER JOIN
    //     mastersupplier f on f.Id_Supplier = c.id_supplier
    //     WHERE c.not_sales is null and c.id_supplier != '1038' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0') and c.confirm = 'Y' and c.cancel = 'N' and LEFT(c.bppbno_int,2) = 'FG' and c.bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a where a.area = 'Export'");

    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $query = $this->db->query("SELECT sum(total) eqv_idr from tbl_data_dsb_ar where jenis_data = 'ar_ekspor_ni' $where");

    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}


function cari_ar_fob($filter)
{
    if ($filter == 'NAG') {
     $where = "and a.profit_center = 'NAG'";
 }elseif ($filter == 'NAK') {
    $where = "and a.profit_center = 'NAK'";
}else{
    $where = "";
}

$query = $this->db->query("SELECT Coalesce(sum(eqv_idr),0) eqv_idr from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.type_so = 'FOB' and a.id_type = '1' and a.status = 'APPROVED' $where and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE()) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");
foreach ($query->result() as $data) {
    $hasil = ($data->eqv_idr);
}

return $hasil;
}

function cari_ar_fob_ni($filter)
{

    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $query = $this->db->query("SELECT sum(total) eqv_idr from tbl_data_dsb_ar where jenis_data = 'ar_fob_ni' $where");

    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}


function cari_ar_cmt($filter)
{

    if ($filter == 'NAG') {
       $where = "and a.profit_center = 'NAG'";
   }elseif ($filter == 'NAK') {
    $where = "and a.profit_center = 'NAK'";
}else{
    $where = "";
}

$query = $this->db->query("SELECT Coalesce(sum(eqv_idr),0) eqv_idr from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.type_so = 'CMT' and a.id_type = '1' and a.status = 'APPROVED' $where and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE()) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date) a");
foreach ($query->result() as $data) {
    $hasil = ($data->eqv_idr);
}

return $hasil;
}

function cari_ar_cmt_ni($filter)
{
    // $query = $this->db->query("SELECT Coalesce(sum(eqv_idr),0) eqv_idr from (SELECT bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr, area, jns_so from (SELECT jns_so,if(f.area = 'I','Export','Local') area,f.supplier,a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
    //     d.styleno, e.product_group, e.product_item, b.color, b.size,  
    //     c.curr, c.unit AS uom, c.qty, Round(b.price,4) AS unit_price,  
    //     ROUND(c.qty * Round(b.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
    //     FROM so AS a INNER JOIN 
    //     so_det AS b ON a.id = b.id_so INNER JOIN 
    //     bppb AS c ON b.id = c.id_so_det INNER JOIN 
    //     act_costing AS d ON a.id_cost = d.id INNER JOIN 
    //     masterproduct AS e ON d.id_product = e.id INNER JOIN
    //     mastersupplier f on f.Id_Supplier = c.id_supplier
    //     WHERE c.not_sales is null and c.id_supplier != '1038' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0') and c.confirm = 'Y' and c.cancel = 'N' and LEFT(c.bppbno_int,2) = 'FG' and c.bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a where a.jns_so = 'CMT'");

    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $query = $this->db->query("SELECT sum(total) eqv_idr from tbl_data_dsb_ar where jenis_data = 'ar_cmt_ni' $where");

    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}


function cari_filter_ar()
{
    $hasil = $this->db->query("SELECT DISTINCT name_fil,val_fil FROM tbl_fil_dsb_ar WHERE status = 'dsb1' ");
    return $hasil->result_array();
}

function cari_bulan_ar()
{
    $hasil = $this->db->query("SELECT bulan_text,nama_bulan from dim_date where tahun = '2025' GROUP BY bulan_text ");
    return $hasil->result_array();
}

function cari_tahun_ar()
{
    $hasil = $this->db->query("SELECT tahun from dim_date where tahun >= '2023' GROUP BY tahun ");
    return $hasil->result_array();
}

function cari_top_5_sales_name($filter)
{
    if ($filter == 'NAG') {
        $query = $this->db->query("SELECT GROUP_CONCAT(concat('''',customer,'''')) customer from (select customer, ROUND(eqv_idr,2) eqv_idr from (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales GROUP BY id_customer) a order by a.eqv_idr desc limit 5) a");
    }elseif ($filter == 'NAK') {
        $query = $this->db->query("SELECT GROUP_CONCAT(concat('''',customer,'''')) customer from (select customer, ROUND(eqv_idr,2) eqv_idr from (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales_knitting GROUP BY id_customer) a order by a.eqv_idr desc limit 5) a");
    }else{
        $query = $this->db->query("SELECT GROUP_CONCAT(concat('''',customer,'''')) customer from (select customer, ROUND(sum(eqv_idr),2) eqv_idr from ((select customer,sum(eqv_idr) eqv_idr from tbl_data_sales GROUP BY id_customer) UNION (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales_knitting GROUP BY id_customer)) a group by customer order by a.eqv_idr desc limit 5) a");
    }


    foreach ($query->result() as $data) {
        $hasil = ($data->customer);
    }

    return $hasil;
}

function cari_top_5_sales_val($filter)
{
    if ($filter == 'NAG') {
        $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (select customer, ROUND(eqv_idr,2) eqv_idr from (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales GROUP BY id_customer) a order by a.eqv_idr desc limit 5) a");
    }elseif ($filter == 'NAK') {
        $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (select customer, ROUND(eqv_idr,2) eqv_idr from (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales_knitting GROUP BY id_customer) a order by a.eqv_idr desc limit 5) a");
    }else{
        $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (select customer, ROUND(sum(eqv_idr),2) eqv_idr from ((select customer,sum(eqv_idr) eqv_idr from tbl_data_sales GROUP BY id_customer) UNION (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales_knitting GROUP BY id_customer)) a group by customer order by a.eqv_idr desc limit 5) a");
    }

    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}


function cari_top_5_sales_namefil($bulan,$tahun,$filter)
{

    if ($filter == 'NAG') {
        $query = $this->db->query("SELECT GROUP_CONCAT(concat('''',customer,'''')) customer from (select customer, ROUND(eqv_idr,2) eqv_idr from (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales where bulan = '$bulan' and tahun = '$tahun' GROUP BY id_customer) a order by a.eqv_idr desc limit 5) a");
    }elseif ($filter == 'NAK') {
        $query = $this->db->query("SELECT GROUP_CONCAT(concat('''',customer,'''')) customer from (select customer, ROUND(eqv_idr,2) eqv_idr from (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales_knitting where bulan = '$bulan' and tahun = '$tahun' GROUP BY id_customer) a order by a.eqv_idr desc limit 5) a");
    }else{
        $query = $this->db->query("SELECT GROUP_CONCAT(concat('''',customer,'''')) customer from (select customer, ROUND(sum(eqv_idr),2) eqv_idr from ((select customer,sum(eqv_idr) eqv_idr from tbl_data_sales where bulan = '$bulan' and tahun = '$tahun' GROUP BY id_customer) UNION (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales where bulan = '$bulan' and tahun = '$tahun' GROUP BY id_customer)) a GROUP BY customer order by a.eqv_idr desc limit 5) a");
    }

    foreach ($query->result() as $data) {
        $hasil = ($data->customer);
    }

    return $hasil;
}

function cari_top_5_sales_valfil($bulan,$tahun, $filter)
{

    if ($filter == 'NAG') {
        $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (select customer, ROUND(eqv_idr,2) eqv_idr from (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales where bulan = '$bulan' and tahun = '$tahun' GROUP BY id_customer) a order by a.eqv_idr desc limit 5) a");
    }elseif ($filter == 'NAK') {
        $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (select customer, ROUND(eqv_idr,2) eqv_idr from (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales_knitting where bulan = '$bulan' and tahun = '$tahun' GROUP BY id_customer) a order by a.eqv_idr desc limit 5) a");
    }else{
        $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (select customer, ROUND(sum(eqv_idr),2) eqv_idr from ((select customer,sum(eqv_idr) eqv_idr from tbl_data_sales where bulan = '$bulan' and tahun = '$tahun' GROUP BY id_customer) UNION (select customer,sum(eqv_idr) eqv_idr from tbl_data_sales where bulan = '$bulan' and tahun = '$tahun' GROUP BY id_customer)) a group by customer order by a.eqv_idr desc limit 5) a");
    }

    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}

function cari_pred_week1()
{
    $query = $this->db->query("SELECT week1 eqv_idr from tbl_data_ar_pred");
    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}

function cari_pred_week2()
{
    $query = $this->db->query("SELECT week2 eqv_idr from tbl_data_ar_pred");
    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}

function cari_pred_week3()
{
    $query = $this->db->query("SELECT week3 eqv_idr from tbl_data_ar_pred");
    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}

function cari_pred_week4()
{
    $query = $this->db->query("SELECT week4 eqv_idr from tbl_data_ar_pred");
    foreach ($query->result() as $data) {
        $hasil = ($data->eqv_idr);
    }

    return $hasil;
}


function cari_sj_noncom($dt_dari_sj, $dt_sampai_sj)
{
    $hasil = $this->db->query("SELECT *,IF(curr = 'USD',rate,1) rates, round((total_price * IF(curr = 'USD',rate,1)),2) ttl_price, FORMAT(round((total_price * IF(curr = 'USD',rate,1)),2),2) total_price2 from (SELECT a.so_date, c.id, jns_so,if(f.area = 'I','Export','Local') area,f.supplier,f.id_supplier,a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
        d.styleno, e.product_group, e.product_item, b.color, b.size,  
        c.curr, c.unit AS uom, c.qty, format(Round(b.price,4),2) AS unit_price,  
        ROUND(c.qty * Round(b.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade,c.not_sales , CONCAT(c.qty,' ',c.unit) qty_pcs, format(ROUND(c.qty * Round(b.price,4), 4),2) total, c.invno
        FROM so AS a INNER JOIN 
        so_det AS b ON a.id = b.id_so INNER JOIN 
        bppb AS c ON b.id = c.id_so_det INNER JOIN 
        act_costing AS d ON a.id_cost = d.id INNER JOIN 
        masterproduct AS e ON d.id_product = e.id INNER JOIN
        mastersupplier f on f.Id_Supplier = c.id_supplier
        WHERE c.not_sales is null and c.id_supplier not in ('1038','1384') AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0') and c.confirm = 'Y' and c.cancel = 'N' and LEFT(c.bppbno_int,2) = 'FG' and c.bppbdate BETWEEN '$dt_dari_sj' AND '$dt_sampai_sj') a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.bppbdate");
    return $hasil->result_array();
}


function update_nofg($id)
{
    $hasil = $this->db->query("UPDATE bppb SET not_sales = 'Y' WHERE id = '$id' ");
    return $hasil;
}

function cari_sales_ytd_mtm($filter)
{
    if ($filter == 'NAG') {
        $where = "select * from tbl_data_sales where tahun = '2025'";
    }elseif ($filter == 'NAK') {
        $where = "select * from tbl_data_sales_knitting where tahun = '2025'";
    }else{
        $where = "select * from tbl_data_sales where tahun = '2025' UNION select * from tbl_data_sales_knitting where tahun = '2025'";
    }

    $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (SELECT bulan_text,ROUND(COALESCE(eqv_idr,0),2) eqv_idr FROM (select DISTINCT bulan_text from dim_date WHERE tahun = '2025') a left join 
        (SELECT bulan,sum(eqv_idr) eqv_idr FROM($where) a GROUP BY bulan) b on b.bulan = a.bulan_text ORDER BY a.bulan_text asc) a");
    if ($query->result()) {  
        foreach ($query->result() as $data) {
            $hasil = ($data->eqv_idr);
        }
    } else {
        $hasil = 0;
    }

    return $hasil;
}

function cari_sales_ytd_mtm_bfr()
{
    $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (SELECT bulan_text,ROUND(COALESCE(eqv_idr,0),2) eqv_idr FROM (select DISTINCT bulan_text from dim_date WHERE tahun = '2023') a left join 
        (SELECT bulan,sum(eqv_idr) eqv_idr FROM(select * from tbl_data_sales_2023 where tahun = '2023') a GROUP BY bulan) b on b.bulan = a.bulan_text ORDER BY a.bulan_text asc) a");
    if ($query->result()) {  
        foreach ($query->result() as $data) {
            $hasil = ($data->eqv_idr);
        }
    } else {
        $hasil = 0;
    }

    return $hasil;
}

function cari_sales_ytd_mtm_pertahun($tahun, $filter)
{
    if ($filter == 'NAG') {
        $where = "select * from tbl_data_sales_$tahun where tahun = '$tahun'";
    }elseif ($filter == 'NAK') {
        $where = "select * from tbl_data_sales_knitting_$tahun where tahun = '$tahun'";
    }else{
        $where = "select * from tbl_data_sales_$tahun where tahun = '$tahun' UNION select * from tbl_data_sales_knitting_$tahun where tahun = '$tahun'";
    }

    $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (SELECT bulan_text,ROUND(COALESCE(eqv_idr,0),2) eqv_idr FROM (select DISTINCT bulan_text from dim_date WHERE tahun = '$tahun') a left join 
        (SELECT bulan,sum(eqv_idr) eqv_idr FROM($where) a GROUP BY bulan) b on b.bulan = a.bulan_text ORDER BY a.bulan_text asc) a");
    if ($query->result()) {  
        foreach ($query->result() as $data) {
                    $hasil = explode(',', $data->eqv_idr); // Ubah string menjadi array
                }
            } else {
                $hasil = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // Data default jika kosong
            }

            return $hasil;
        }

        function cari_sales_ytd_mtm_tahunini($filter)
        {

            if ($filter == 'NAG') {
                $where = "select * from tbl_data_sales where tahun = '2025'";
            }elseif ($filter == 'NAK') {
                $where = "select * from tbl_data_sales_knitting where tahun = '2025'";
            }else{
                $where = "select * from tbl_data_sales where tahun = '2025' UNION select * from tbl_data_sales_knitting where tahun = '2025'";
            }

            $query = $this->db->query("SELECT GROUP_CONCAT(eqv_idr) eqv_idr from (SELECT bulan_text,ROUND(COALESCE(eqv_idr,0),2) eqv_idr FROM (select DISTINCT bulan_text from dim_date WHERE tahun = '2025') a left join 
                (SELECT bulan,sum(eqv_idr) eqv_idr FROM($where) a GROUP BY bulan) b on b.bulan = a.bulan_text ORDER BY a.bulan_text asc) a");
            if ($query->result()) {  
                foreach ($query->result() as $data) {
                    $hasil = explode(',', $data->eqv_idr); // Ubah string menjadi array
                }
            } else {
                $hasil = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // Data default jika kosong
            }

            return $hasil;
        }

        function cari_overdue_aging($filter)
        {
            if ($filter == 'NAG') {
               $query = $this->db->query("SELECT CONCAT(ROUND(not_due,2),',',ROUND(amt_aging_1,2),',',ROUND(amt_aging_2,2),',',ROUND(amt_aging_3,2),',',ROUND(amt_aging_4,2),',',ROUND(amt_aging_5,2),',',ROUND(amt_aging_6,2),',',ROUND(amt_aging_7,2)) eqv_idr from tbl_data_sum_ar2");
           }elseif ($filter == 'NAK') {
            $query = $this->db->query("SELECT CONCAT(ROUND(not_due,2),',',ROUND(amt_aging_1,2),',',ROUND(amt_aging_2,2),',',ROUND(amt_aging_3,2),',',ROUND(amt_aging_4,2),',',ROUND(amt_aging_5,2),',',ROUND(amt_aging_6,2),',',ROUND(amt_aging_7,2)) eqv_idr from tbl_data_sum_ar_knitting");
        }else{
            $query = $this->db->query("SELECT CONCAT(ROUND(not_due,2),',',ROUND(amt_aging_1,2),',',ROUND(amt_aging_2,2),',',ROUND(amt_aging_3,2),',',ROUND(amt_aging_4,2),',',ROUND(amt_aging_5,2),',',ROUND(amt_aging_6,2),',',ROUND(amt_aging_7,2)) eqv_idr from (select SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7 from (select * from tbl_data_sum_ar2
                UNION
                select * from tbl_data_sum_ar_knitting) a) a");
        }

        if ($query->result()) {  
            foreach ($query->result() as $data) {
                $hasil = ($data->eqv_idr);
            }
        } else {
            $hasil = 0;
        }

        return $hasil;
    }

    function load_prediksi($filter)
    {
        if ($filter == 'NAG') {
           $hasil = $this->db->query("SELECT periode,week1,week2,week3,week4 from tbl_data_ar_pred ");
       }elseif ($filter == 'NAK') {
        $hasil = $this->db->query("SELECT periode,week1,week2,week3,week4 from tbl_data_ar_pred_knitting ");
    }else{
        $hasil = $this->db->query("SELECT periode,SUM(week1) week1,SUM(week2) week2,SUM(week3) week3,SUM(week4) week4 FROM (SELECT id, periode,week1,week2,week3,week4 from tbl_data_ar_pred UNION SELECT id, periode,week1,week2,week3,week4 from tbl_data_ar_pred) a GROUP BY periode ORDER BY id asc");
    }

    return $hasil->result_array();
}

function load_det_overdue($field, $filter)
{

    if ($filter == 'NAG') {
       $hasil = $this->db->query("SELECT customer,$field as data from (select * from tbl_data_overdue_ar) a WHERE $field != 0");
   }elseif ($filter == 'NAK') {
    $hasil = $this->db->query("SELECT customer,$field as data from (select * from tbl_data_overdue_ar_knitting) a WHERE $field != 0");
}else{
    $hasil = $this->db->query("SELECT customer,$field as data from (select id_customer, customer, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7 from ( select * from tbl_data_overdue_ar
        UNION
        select * from tbl_data_overdue_ar_knitting) a GROUP BY id_customer) a WHERE $field != 0");
}

return $hasil->result_array();
}


function cari_nm_memo_temp()
{
    $query = $this->db->query("SELECT GROUP_CONCAT(nm_memo) nm_memo from (SELECT DISTINCT nm_memo from tbl_memo_temp) a");
    if ($query->result()) {            
        foreach ($query->result() as $data) {
            $hasil = ($data->nm_memo);
        }
    } else {
        $hasil = '';
    }

    return $hasil;
}

function modal_caridata_slsytd($filter)
{
    if ($filter == 'NAG') {
       $where = "and a.profit_center = 'NAG'";
   }elseif ($filter == 'NAK') {
    $where = "and a.profit_center = 'NAK'";
}else{
    $where = "";
}

$hasil = $this->db->query("SELECT customer, qty,CONCAT(if(uom='PCS',format(qty,0),format(qty,2)),' ',uom) qty2, total, CONCAT('IDR ',format(total,2)) total2 from (SELECT customer,sum(qty) qty, sum(eqv_idr) total, uom from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr,qty, uom from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total,uom from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer
   INNER JOIN (select id_book_invoice, uom from tbl_invoice_detail where id_book_invoice is not null GROUP BY id_book_invoice) di on di.id_book_invoice = a.id where a.id_type = '1' and a.status IN ('APPROVED','POST') $where and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date LEFT JOIN
(select id_book_invoice,sum(qty) qty from tbl_invoice_detail where id_book_invoice is not null GROUP BY id_book_invoice) c on c.id_book_invoice = a.id) a GROUP BY customer) a order by qty desc");
return $hasil->result_array();
}

function modal_caridata_slscm($filter)
{
    if ($filter == 'NAG') {
       $where = "and a.profit_center = 'NAG'";
   }elseif ($filter == 'NAK') {
    $where = "and a.profit_center = 'NAK'";
}else{
    $where = "";
}

$hasil = $this->db->query("SELECT customer, qty,CONCAT(format(qty,0),' PCS') qty2, total, CONCAT('IDR ',format(total,2)) total2 from (SELECT customer,sum(qty) qty, sum(eqv_idr) total from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr,qty from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,total from tbl_book_invoice a inner join tbl_invoice_pot b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.id_type = '1' and a.status IN ('APPROVED','POST') $where and a.sj_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y'))) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) b on b.tanggal = a.sj_date LEFT JOIN (select id_book_invoice,sum(qty) qty from tbl_invoice_detail where id_book_invoice is not null GROUP BY id_book_invoice) c on c.id_book_invoice = a.id) a GROUP BY customer) a order by qty desc");
return $hasil->result_array();
}

function modal_caridata_slsytd2($filter)
{
    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $hasil = $this->db->query("SELECT * from tbl_data_dsb_ar_modal where jenis_data = 'modal_caridata_slsytd2' $where order by qty desc");

    return $hasil->result_array();
}

function modal_caridata_slsni($filter)
{
    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $hasil = $this->db->query("SELECT * from tbl_data_dsb_ar_modal where jenis_data = 'modal_caridata_slsni' $where order by qty desc");


    return $hasil->result_array();
}

function modal_caridata_slscm2($filter)
{
    if ($filter == 'NAG') {
        $where = "and profit_center = 'NAG'";
    }elseif ($filter == 'NAK') {
        $where = "and profit_center = 'NAK'";
    }else{
        $where = "";
    }

    $hasil = $this->db->query("SELECT * from tbl_data_dsb_ar_modal where jenis_data = 'modal_caridata_slscm2' $where order by qty desc");

    return $hasil->result_array();

}


function load_det_sales5($customer, $bulan, $filter)
{

    if ($bulan == "ALL") {
        $where = "where tahun = DATE_FORMAT(CURRENT_DATE,'%Y') and customer = '$customer' GROUP BY id_customer ";
    } else {
        $where = "where tahun = DATE_FORMAT(CURRENT_DATE,'%Y') and bulan = '$bulan' and customer = '$customer' GROUP BY id_customer ";
    }

    if ($filter == 'NAG') {
        $hasil = $this->db->query("SELECT customer, ROUND(qty,2) qty,ROUND(eqv_idr,2) eqv_idr from (select customer,sum(qty) qty,sum(eqv_idr) eqv_idr from tbl_data_sales $where) a");
    }elseif($filter == 'NAK'){
        $hasil = $this->db->query("SELECT customer, ROUND(qty,2) qty,ROUND(eqv_idr,2) eqv_idr from (select customer,sum(qty) qty,sum(eqv_idr) eqv_idr from tbl_data_sales_knitting $where) a");
    }else{

        $hasil = $this->db->query("SELECT customer, ROUND(qty,2) qty,ROUND(eqv_idr,2) eqv_idr from ((select customer,sum(qty) qty,sum(eqv_idr) eqv_idr from tbl_data_sales $where) UNION (select customer,sum(qty) qty,sum(eqv_idr) eqv_idr from tbl_data_sales_knitting $where)) a");
    }
    return $hasil->result_array();
}

function load_det_motm($bulan, $filter)
{
    if ($filter == 'NAG') {
        $where = "select * from tbl_data_sales";
    }elseif ($filter == 'NAK') {
        $where = "select * from tbl_data_sales_knitting";
    }else{
        $where = "select * from tbl_data_sales UNION select * from tbl_data_sales_knitting";
    }

        //
    $hasil = $this->db->query("SELECT bulan,customer,sum(qty) qty,sum(eqv_idr) eqv_idr FROM(select * from ($where) a where tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) a where bulan = '$bulan' and eqv_idr > 0 GROUP BY customer order by eqv_idr desc  ");
    return $hasil->result_array();
}

function load_det_motm2($bulan, $tahun)
{

        //
    $hasil = $this->db->query("SELECT bulan,customer,sum(qty) qty,sum(eqv_idr) eqv_idr FROM(select * from tbl_data_sales where tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) a where bulan = '$bulan' and eqv_idr > 0 GROUP BY customer order by eqv_idr desc  ");
    return $hasil->result_array();
}

function load_det_motm2_($bulan, $tahun)
{

        //
    $hasil = $this->db->query("SELECT bulan,customer,sum(qty) qty,sum(eqv_idr) eqv_idr FROM(select * from tbl_data_sales_$tahun where tahun = '$tahun') a where bulan = '$bulan' and eqv_idr > 0 GROUP BY customer order by eqv_idr desc  ");
    return $hasil->result_array();
}

// function load_det_motm2($bulan, $tahun, $filter)
// {
//     if ($filter == 'NAG') {
//         $where = "select * from tbl_data_sales";
//     }elseif ($filter == 'NAK') {
//         $where = "select * from tbl_data_sales_knitting";
//     }else{
//         $where = "select * from tbl_data_sales UNION select * from tbl_data_sales_knitting";
//     }

//         //
//     $hasil = $this->db->query("SELECT bulan,customer,sum(qty) qty,sum(eqv_idr) eqv_idr FROM(select * from ($where) a where tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) a where bulan = '$bulan' and eqv_idr > 0 GROUP BY customer order by eqv_idr desc  ");
//     return $hasil->result_array();
// }

// function load_det_motm2_($bulan, $tahun)
// {
//     // if ($filter == 'NAG') {
//     //     $where = "select * from tbl_data_sales_$";
//     // }elseif ($filter == 'NAK') {
//     //     $where = "select * from tbl_data_sales_knitting_$";
//     // }else{
//     //     $where = "select * from tbl_data_sales_$ UNION select * from tbl_data_sales_knitting_$";
//     // }

//         //
//     $hasil = $this->db->query("SELECT bulan,customer,sum(qty) qty,sum(eqv_idr) eqv_idr FROM(select * from tbl_data_sales_$ a tahun where tahun = '$tahun') a where bulan = '$bulan' and eqv_idr > 0 GROUP BY customer order by eqv_idr desc  ");
//     return $hasil->result_array();
// }

function load_det_motm_bfr($bulan)
{

        //
    $hasil = $this->db->query("SELECT bulan,customer,sum(qty) qty,sum(eqv_idr) eqv_idr FROM(select * from tbl_data_sales_2023 where tahun = '2023') a where bulan = '$bulan' and eqv_idr > 0 GROUP BY customer order by eqv_idr desc  ");
    return $hasil->result_array();
}

function cari_no_req()
{
    $hasil = $this->db->query("SELECT id,no_req from req_dn_h where status = 'Post' and no_dn is null");
    return $hasil->result_array();
}

function update_req_dn($dn_number, $no_req)
{
    $hasil = $this->db->query("UPDATE req_dn_h set no_dn = '$dn_number',status = 'Processed' WHERE id = '$no_req' ");
    return $hasil;
}

function cari_list_reqdn($nomor_req)
{

             // $hasil = $this->db->query("SELECT attn,a.id,item itemdesc,nama_supp,no_po,CONCAT(sum(qty),' / ',price) header2, CONCAT(no_reff,' / ',seasons) header3, round(SUM(qty * price),2) total,no_bpb from req_dn a INNER JOIN req_dn_h b on b.no_req = a.no_req where b.id IN ('$nomor_req') and b.status != 'Cancel' GROUP BY item,seasons,no_reff,price");

 $hasil = $this->db->query("SELECT attn,a.id,item itemdesc,nama_supp,no_po,CONCAT(sum(qty),' / ',price) header2, CONCAT(no_reff,' / ',seasons) header3, round(SUM(qty * price),2) total,no_bpb from req_dn a INNER JOIN req_dn_h b on b.no_req = a.no_req where b.id IN ('$nomor_req') and b.status != 'Cancel' GROUP BY item,seasons,no_reff,price");

 return $hasil->result_array();

}

function dsb_data_total_ar($filter)
{
    if ($filter == 'NAG') {
        $hasil = $this->db->query("SELECT shipp, customer, curr, ROUND(total,2 ) total, ROUND(total_idr,2 ) total_idr, ROUND(not_due,2 ) not_due, ROUND(ready_due,2 ) ready_due from tbl_data_ar order by shipp,customer asc");
    }elseif ($filter == 'NAK') {
        $hasil = $this->db->query("SELECT shipp, customer, curr, ROUND(total,2 ) total, ROUND(total_idr,2 ) total_idr, ROUND(not_due,2 ) not_due, ROUND(ready_due,2 ) ready_due from tbl_data_ar_knitting order by shipp,customer asc");
    }else{
     $hasil = $this->db->query("SELECT shipp, customer, curr, ROUND(sum(total),2 ) total, ROUND(sum(total_idr),2 ) total_idr, ROUND(sum(not_due),2 ) not_due, ROUND(sum(ready_due),2 ) ready_due from (SELECT shipp, customer, curr, ROUND(total,2 ) total, ROUND(total_idr,2 ) total_idr, ROUND(not_due,2 ) not_due, ROUND(ready_due,2 ) ready_due from tbl_data_ar
        UNION
        SELECT shipp, customer, curr, ROUND(total,2 ) total, ROUND(total_idr,2 ) total_idr, ROUND(not_due,2 ) not_due, ROUND(ready_due,2 ) ready_due from tbl_data_ar_knitting order by shipp,customer asc) a GROUP BY shipp,customer  order by shipp,customer asc"); 
 }

 return $hasil->result_array();
}

function getTopInvoice($id)
{
    $hasil = $this->db->query("SELECT b.id, b.no_invoice, b.id_customer, b.id_top, a.type, a.top
        FROM tbl_master_top AS a INNER JOIN tbl_book_invoice AS b ON a.id = b.id_top 
        WHERE b.id = '$id'");
    return $hasil->row();
}

function update_top_invoice($id, $id_top)
{
    $hasil = $this->db->query("UPDATE tbl_book_invoice SET id_top = '$id_top' WHERE id = '$id' ");
    return $hasil;
}

public function get_invoice_by_id($id) {
    return $this->db->get_where('tbl_book_invoice', ['id' => $id])->row_array();
}

public function get_invoice_pot_by_id($id) {
    return $this->db->get_where('tbl_invoice_pot', ['id_book_invoice' => $id])->row_array();
}

public function get_invoice_det_by_id($id) {
    return $this->db->get_where('tbl_invoice_detail', ['id_book_invoice' => $id])->result_array();
}

function get_tgl_invoice_by_id($id)
{
    $hasil = $this->db->query("select DISTINCT DATE_FORMAT(a.sj_date,'%Y-%m-%d') tgl_inv, DATE_FORMAT(DATE_ADD(a.sj_date, INTERVAL c.top DAY), '%Y-%m-%d') due_date from tbl_invoice_detail a INNER JOIN tbl_book_invoice b on b.id = a.id_book_invoice INNER JOIN tbl_master_top c on c.id = b.id_top where id_book_invoice = '$id' GROUP BY id_book_invoice");
    return $hasil->row_array();
}

function update_invoice_h($id, $id_top, $id_customer, $type, $profit_center, $id_bank, $pph, $type_so)
{
    $hasil = $this->db->query("UPDATE tbl_book_invoice SET id_top = '$id_top', id_customer = '$id_customer', id_type = '$type', profit_center = '$profit_center', id_bank = '$id_bank', pph = '$pph', type_so = '$type_so' WHERE id = '$id' ");
    return $hasil;
}

public function simpan_invoice_detail_edit($data_detail)
{
    if (!empty($data_detail)) {
        $this->db->insert_batch('tbl_invoice_detail', $data_detail);
    }
}

public function simpan_invoice_pot_edit($data_pot)
{
    if (!empty($data_pot)) {
        $this->db->insert('tbl_invoice_pot', $data_pot); // karena data_pot itu 1 row
    }
}

function get_pilihan_reverse()
{
    $hasil = $this->db->query("SELECT id, kode_pilihan, nama_pilihan FROM tbl_pilihan_ar where ctg_pilihan = 'reverse' ");
    return $hasil->result_array();
}


function cari_data_doc_reverse($dt_dari_doc, $dt_sampai_doc, $id_customer, $doc_type)
{


    if ($doc_type == 'INV') {

        if ($id_customer == 'ALL') {
            $where = "";
        }else{
            $where = "AND a.id_customer = '$id_customer' ";
        }

        $hasil = $this->db->query("select no_invoice no_document, DATE_FORMAT(b.sj_date, '%Y-%m-%d') tgl_document, ms.supplier customer, b.curr, grand_total total, a.id_customer from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice =  a.id INNER JOIN tbl_invoice_pot c on c.id_book_invoice = a.id INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN master_pc mp on mp.kode_pc = a.profit_center where b.sj_date >= '$dt_dari_doc' AND b.sj_date <= '$dt_sampai_doc' ".$where." AND a.status = 'APPROVED' group by no_invoice");

        return $hasil->result_array();
    } elseif ($doc_type == 'INM'){
        if ($id_customer == 'ALL') {
            $where = "";
        }else{
            $where = "AND a.customer = '$id_customer' ";
        }

        $hasil = $this->db->query("select a.no_inv no_document, inv_date tgl_document, ms.supplier customer, b.curr, c.total, a.customer id_customer from tbl_invoice_nb a INNER JOIN tbl_invoice_nb_detail b on b.no_inv =  a.no_inv INNER JOIN tbl_invoice_nb_pot c on c.no_inv = a.no_inv INNER JOIN mastersupplier ms on ms.id_supplier = a.customer where inv_date >= '$dt_dari_doc' AND inv_date <= '$dt_sampai_doc' ".$where." AND a.status = 'APPROVED' group by a.no_inv");

        return $hasil->result_array();
    } elseif ($doc_type == 'KWT'){
        if ($id_customer == 'ALL') {
            $where = "";
        }else{
            $where = "AND a.supp = '$id_customer' ";
        }

        $hasil = $this->db->query("select a.no_kwt no_document, tgl_kwt tgl_document, ms.supplier customer, 'IDR' curr, a.total, a.supp id_customer from tbl_kwitansi a INNER JOIN mastersupplier ms on ms.id_supplier = a.supp where tgl_kwt >= '$dt_dari_doc' AND tgl_kwt <= '$dt_sampai_doc' ".$where." AND a.status = 'APPROVED' group by a.no_kwt");

        return $hasil->result_array();
    } elseif ($doc_type == 'DBN'){
        if ($id_customer == 'ALL') {
            $where = "";
        }else{
            $where = "AND a.customer = '$id_customer' ";
        }

        $hasil = $this->db->query("select a.no_dn no_document, tgl_dn tgl_document, ms.supplier customer, from_curr curr, a.amount total, a.customer id_customer from tbl_debitnote_h a INNER JOIN mastersupplier ms on ms.id_supplier = a.customer where tgl_dn >= '$dt_dari_doc' AND tgl_dn <= '$dt_sampai_doc' ".$where." AND a.status = 'APPROVED' group by a.no_dn");

        return $hasil->result_array();
    }

}

function simpan_reverse_temp($data)
{
    $this->db->insert_batch('tbl_reverse_det_temp', $data);
    return $this->db->insert_id();
}

function delete_data_doc_reverse()
{
    $hasil = $this->db->query("DELETE FROM tbl_reverse_det_temp");
    return $hasil;
}

function load_doc_reverse_temp()
{
    $hasil = $this->db->query("select no_dokumen, tgl_dokumen, id_customer, supplier customer, curr, total, deskripsi from tbl_reverse_det_temp a INNER JOIN mastersupplier b on b.id_supplier = a.id_customer");
    return $hasil->result_array();
}

function get_kode_reverse()
{
    $q = $this->db->query("SELECT rvs_number, MAX(right(rvs_number, 5)) AS kd_max FROM tbl_reverse_h WHERE YEAR(rvs_date) = YEAR(CURRENT_DATE()) AND MONTH(rvs_date) = MONTH(CURRENT_DATE()) ");
        //
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%05s", $tmp);
        }
    } else {
        $kd = "00001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return "RVS/INV/" . date('my'). "/" . $kd;
}


function cari_list_reverse($dt_dari_inv, $dt_sampai_inv, $doc_type)
{

    if ($doc_type != "ALL") {
        $where = " AND type_doc = '$doc_type'";
    }else{
        $where = "";
    }

    // if ($status != "all_status") {
    //     $where2 = " AND a.status = '$status'";
    // }else{
    //     $where2 = "";
    // }

    $hasil = $this->db->query("SELECT id, rvs_number, rvs_date, type_doc, status, COALESCE(deskripsi,'-') deskripsi, created_by, created_date from tbl_reverse_h WHERE rvs_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' $where");
    return $hasil->result_array();
    
}


function cari_detail_reverse($id)
{
    $hasil = $this->db->query("select a.rvs_number, a.doc_number, a.doc_date, a.id_customer, supplier customer, a.curr, FORMAT(a.total,2) total, a.deskripsi from tbl_reverse_det a INNER JOIN mastersupplier b on b.id_supplier = a.id_customer INNER JOIN tbl_reverse_h c on c.rvs_number = a.rvs_number where a.status = 'Y' and c.id = '$id' ");
    return $hasil->result_array();
}

function get_reverse_header($id)
{
    $hasil = $this->db->query("select rvs_number, rvs_date, UPPER(type_doc) type_doc, UPPER(deskripsi) deskripsi, created_by from tbl_reverse_h where id = '$id' ");
    return $hasil->row_array();
}

function update_reverse_header($rvs_number)
{

    $db_nag = $this->load->database('db_nag', TRUE);
    $hasil1 = $db_nag->query("UPDATE tbl_reverse_h SET status = 'CANCEL' WHERE rvs_number = '$rvs_number'");

    return $hasil1;
}

function update_reverse_detail($rvs_number)
{

    $db_nag = $this->load->database('db_nag', TRUE);
    $hasil1 = $db_nag->query("UPDATE tbl_reverse_det SET status = 'N' WHERE rvs_number = '$rvs_number'");

    return $hasil1;
}


function cari_reverse_draft($dt_dari_inv, $dt_sampai_inv)
{
    $hasil = $this->db->query("SELECT id, rvs_number, rvs_date, type_doc, status, COALESCE(deskripsi,'-') deskripsi, created_by, created_date from tbl_reverse_h WHERE rvs_date BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' and status = 'DRAFT' ORDER BY id asc");
    return $hasil->result_array();
}

function approve_doc_reverse($id)
{
    $hasil = $this->db->query("UPDATE tbl_reverse_h SET status = 'APPROVED' WHERE id = '$id' ");

    // $query = $this->db->query("SELECT no_invoice FROM tbl_book_invoice WHERE id = '$id'");
    // $row = $query->row();
    // $no_invoice = $row->no_invoice;

    // if (strpos($no_invoice, 'NAK') !== false) {
    //     $inv_pot = 'NAK_pot';
    //     $inv_credit = 'NAK_credit';
    // } else {
    //     $inv_pot = 'INV_pot';
    //     $inv_credit = 'INV_credit';
    // }

    // $this->db->query("insert into tbl_list_journal select '', a.* from (select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, no_coa, nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, grand_total debit, 0 credit, (grand_total * COALESCE(rate,1)) debit_idr, 0 credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '' approve_by,'' approve_date,'' cancel_by,'' cancel_date,'' created_at,'' updated_at, a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a INNER JOIN (SELECT no_coa, nama_coa, shipp_tipe, so_tipe, cus_ctg, grade from mastercoa_v2 where inv_type like '%INV_debit%') b on b.shipp_tipe = a.shipp and b.so_tipe LIKE CONCAT('%', a.type_so, '%') and b.cus_ctg LIKE CONCAT('%', a.supplier_ctg, '%') and b.grade LIKE CONCAT('%', a.grade, '%') LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr
    //     UNION
    //     select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, no_coa, nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, discount debit, 0 credit, (discount * COALESCE(rate,1)) debit_idr, 0 credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '','','','','','', a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a INNER JOIN (SELECT no_coa, nama_coa, shipp_tipe, so_tipe, cus_ctg, grade from mastercoa_v2 where inv_type like '%$inv_pot%') b on b.shipp_tipe = a.shipp and b.so_tipe LIKE CONCAT('%', a.type_so, '%') and b.cus_ctg LIKE CONCAT('%', a.supplier_ctg, '%') and b.grade LIKE CONCAT('%', a.grade, '%') LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr
    //     UNION
    //     select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, no_coa, nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, dp debit, 0 credit, (dp * COALESCE(rate,1)) debit_idr, 0 credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '','','','','','', a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a INNER JOIN (SELECT no_coa, nama_coa, shipp_tipe, so_tipe, cus_ctg, grade from mastercoa_v2 where inv_type like '%DP%') b on b.shipp_tipe = a.shipp  LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr
    //     UNION
    //     select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, no_coa, nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, 0 debit, total credit, 0 debit_idr, (total * COALESCE(rate,1)) credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '','','','','','', a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a INNER JOIN (SELECT no_coa, nama_coa, shipp_tipe, so_tipe, cus_ctg, grade from mastercoa_v2 where inv_type like '%$inv_credit%') b on b.shipp_tipe = a.shipp and b.so_tipe LIKE CONCAT('%', a.type_so, '%') and b.cus_ctg LIKE CONCAT('%', a.supplier_ctg, '%') and b.grade LIKE CONCAT('%', a.grade, '%') LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr
    //     UNION
    //     select a.no_invoice, a.tgl_invoice, 'Invoice' type_journal, '2.53.01' no_coa, 'PPN KELUARAN' nama_coa, '-' no_cc, '-' nama_cc, '-' ref_doc, '-' ref_date, a.buyer, a.ws, a.curr, COALESCE(rate,1) rate, 0 debit, vat credit, 0 debit_idr, (vat * COALESCE(rate,1)) credit_idr, 'APPROVED' status, a.keterangan, nama, tanggal_input, '','','','','','', a.profit_center from (select a.no_invoice, DATE_FORMAT(b.sj_date,'%Y-%m-%d') tgl_invoice, ms.supplier buyer, b.ws, b.curr, log.nama, log.tanggal_input, a.profit_center, a.shipp, a.type_so, a.id_customer, IF(a.no_invoice like '%NAG%',RIGHT(c.grade,1),'A') grade, IF(supplier_ctg is null, 'Third', supplier_ctg) supplier_ctg, ip.total, ip.discount, ip.dp, ip.retur, ip.twot, ip.vat, ip.grand_total, CONCAT('PENJUALAN ',a.type_so,' KE ',UPPER(ms.supplier)) keterangan from tbl_book_invoice a INNER JOIN tbl_invoice_detail b on b.id_book_invoice = a.id INNER JOIN bppb c on c.id= b.id_bppb INNER JOIN mastersupplier ms on ms.id_supplier = a.id_customer INNER JOIN tbl_invoice_pot ip on ip.id_book_invoice = a.id INNER JOIN (select doc_number, nama, tanggal_input from tbl_log where activity = 'Create invoice' GROUP BY doc_number) log on log.doc_number = a.no_invoice LEFT JOIN (select id_supplier, supplier_ctg from tbl_ctg_supplier where status = 'Y' GROUP BY id_supplier) sc on sc.id_supplier = a.id_customer where a.id ='$id' GROUP BY a.id) a LEFT JOIN (select tanggal,curr,rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.tgl_invoice and c.curr = a.curr) a where debit > 0 OR credit > 0");
    return $hasil;
}


public function get_debitnote_by_id($id) {
    return $this->db->get_where('tbl_debitnote_h', ['id' => $id])->row_array();
}

function get_reffDN_by_id($id)
{
    $hasil = $this->db->query("SELECT * from (select a.no_dn, GROUP_CONCAT( DISTINCT mh.nm_memo) reff_doc, 'No Memo' text_reff_doc from (select no_dn from tbl_debitnote_h where id = '$id') a INNER JOIN memo_det md on md.no_dn = a.no_dn INNER JOIN memo_h mh on mh.id_h = md.id_h GROUP BY a.no_dn
        UNION
        select a.no_dn, GROUP_CONCAT( DISTINCT b.no_req) reff_doc, 'No Request' text_reff_doc from (select no_dn from tbl_debitnote_h where id = '$id') a INNER JOIN req_dn_h b on b.no_dn = a.no_dn GROUP BY a.no_dn) a GROUP BY no_dn");
    return $hasil->row_array();
}

function update_debitnote_h($id_dn, $dn_number, $dn_number_old, $dn_date, $dn_duedate, $customer, $txt_attn, $alamat, $profit_center_dn, $akun, $curr1, $curr2, $txt_header1, $txt_header2, $txt_header3)
{

   $hasil = $this->db->query("UPDATE tbl_debitnote_h SET no_dn = '$dn_number', tgl_dn = '$dn_date', due_date = '$dn_duedate', customer = '$customer', attn = '$txt_attn', alamat = '$alamat', profit_center = '$profit_center_dn', akun = '$akun', from_curr = '$curr1', to_curr = '$curr2', header1 = '$txt_header1', header2 = '$txt_header2', header3 = '$txt_header3' WHERE id = '$id_dn' ");

   $hasil2 = $this->db->query("UPDATE tbl_debitnote_det set no_dn = '$dn_number' where no_dn = '$dn_number_old' ");
   $hasil3 = $this->db->query("UPDATE memo_det set no_dn = '$dn_number' where no_dn = '$dn_number_old' ");

   return $hasil;
}

public function get_debitnoteDet_by_id($id) {
    $query = $this->db->query("SELECT no_dn FROM tbl_debitnote_h WHERE id = '$id'");
    $row = $query->row();
    $no_dn = $row->no_dn;
    return $this->db->get_where('tbl_debitnote_det', ['no_dn' => $no_dn])->result_array();
}

function simpandn_det_total($id_dn, $dn_total, $dn_total_eqv)
{

   $hasil = $this->db->query("UPDATE tbl_debitnote_h SET amount = '$dn_total', eqv_curr = '$dn_total_eqv' WHERE id = '$id_dn' ");

   return $hasil;
}

function cari_list_other_charges($status)
{

    if ($status != "ALL") {
        $where = " AND status = '$status'";
    }else{
        $where = "";
    }

    $hasil = $this->db->query("SELECT id, nama_pilihan, status, IF(status = 'Y','ACTIVE','NON-ACTIVE') status_show from tbl_pilihan_ar WHERE ctg_pilihan = 'other charge invoice' $where");
    return $hasil->result_array();
    
}

function cari_book_inv_knitting($dt_dari, $dt_sampai)
{
    $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
      DATE_FORMAT(a.tgl_book_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, 
      FORMAT(VALUE, 2) AS amount, profit_center
      FROM  tbl_book_invoice AS a INNER JOIN 
      mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
      tbl_type AS c ON a.id_type = c.id_type WHERE a.status = 'DRAFT' 
      AND a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' and profit_center = 'NAK'");
    return $hasil->result_array();
}

function cari_so_knitting($dt_dari_so, $dt_sampai_so, $id_customer, $buyer, $profit_center)
{
        //Database SignalBit
    $db_nag = $this->load->database('db_nag', TRUE);
    $db_pgsql = $this->load->database('db_pgsql', TRUE);
    $hasil  = [];
    $supplier = $db_nag->query("
        SELECT knitting_code from mastersupplier where tipe_sup = 'C' and Id_Supplier = '$buyer'
        ")->row();

    $knitting_code = $supplier ? $supplier->knitting_code : '';


    if (!empty($knitting_code)) {
        $hasil = $db_pgsql->query("SELECT kode_so so_no, so_date, nama_konsumen supplier, '-' buyerno, '-' so_type, a.id id_so from sales_orders a inner join master_konsumen b on b.id = a.konsumen_id where status_so != 'cancel' and kode_konsumen = '$knitting_code' AND a.so_date BETWEEN '$dt_dari_so' AND '$dt_sampai_so' order by a.id asc");
    }

    return $hasil->result_array();
}

function cari_sj_knitting($id_sj, $profit_center)
{
        //Database SignalBit
    $db_nag = $this->load->database('db_nag', TRUE);
    $db_pgsql = $this->load->database('db_pgsql', TRUE);
    $hasil  = [];

    $hasil = $db_pgsql->query("SELECT kode_so no_so, kode_out sj, tgl_pengeluaran bppbdate, kode_out shipping_number, '-' ws, lab_dip styleno, '-' product_group, nama_kain product_item, warna color, '-' size,  currency curr, g.nama_unit uom, qty_meter qty, Round(coalesce(harga_shipment,0),4) AS unit_price, ROUND(qty_meter * Round(coalesce(harga_shipment,0),4), 4) AS total_price,  a.no_so id_so, a.id AS id_bppb, 'GRADE A' grade,'A' grade, h.nama_unit uom_so, qty_netto qty_so, Round(coalesce(harga,0),4) AS unit_price_so, ROUND(qty_netto * Round(coalesce(harga,0),4), 4) AS total_price_so from official_out_h a 
        inner join official_out_barcode b on b.id_official = a.id 
        inner join master_kain c on c.id = b.kain_id 
        LEFT JOIN master_kain_detail d on d.id = b.detail_kain_id 
        INNER JOIN detail_so e on e.id = b.detail_so_id 
        INNER JOIN sales_orders f on f.id = e.sales_order_id 
        left join master_unit g on g.id = e.id_unit_sales_order_shipment 
        left join master_unit h on h.id = e.id_unit_sales_order
        where a.status_inv is null and a.tipe_pengeluaran = 'Penjualan' and a.no_so = '$id_sj' ORDER BY kode_out asc ");

    return $hasil->result_array();
}

function simpan_invoice_detail_knitting_temporary($data)
{
    $this->db->insert_batch('tbl_invoice_detail_knitting_temp', $data);
    return $this->db->insert_id();
}

function load_invoice_detail_knitting_temporary()
{
    $hasil = $this->db->query("SELECT id_bppb, so_number, bppb_number, sj_date, shipp_number, ws, styleno, product_group, product_item, color, size, curr, uom, qty, unit_price, disc, total_price, uom_ship, qty_ship, unit_price_ship, total_price_ship FROM tbl_invoice_detail_knitting_temp");
    return $hasil->result_array();
}

function cari_other_charges()
{

    $hasil = $this->db->query("select id, nama_pilihan from tbl_pilihan_ar where ctg_pilihan = 'other charge invoice' and status = 'Y'");
    return $hasil->result_array();
    
}

function simpan_invoice_detail_knitting($data)
{
    $this->db->insert_batch('tbl_invoice_detail_knitting', $data);
    return $this->db->insert_id();
}

function simpan_invoice_pot_knitting($data)
{
    $this->db->insert_batch('tbl_invoice_pot_knitting', $data);
    return $this->db->insert_id();
}

function simpan_other_charge_invoice($data)
{
    $this->db->insert_batch('tbl_invoice_other_charge', $data);
    return $this->db->insert_id();
}

function report_invoice_detail_knitting($id)
{
    $hasil = $this->db->query("(SELECT styleno, product_group, product_item, color, size, qty, format(round(unit_price,3),3) unit_price, disc, FORMAT(total_price, 2) AS total_price, uom, curr, id_bppb
       FROM tbl_invoice_detail_knitting
       WHERE id_book_invoice = '$id' ORDER BY id_bppb asc)
       UNION
       (select c.styleno, c.product_group, nama_pilihan product_item, c.color, '' size, a.qty, format(round(a.price,3),3) unit_price, 0 disc, FORMAT(a.total, 2) AS total_price, c.uom, c.curr, c.id_bppb from tbl_invoice_other_charge a INNER JOIN tbl_pilihan_ar b on b.id = a.id_ctg INNER JOIN tbl_invoice_detail_knitting c on c.id_book_invoice = a.id_book_invoice WHERE a.id_book_invoice = '$id' order by a.id) ");
    return $hasil->result_array();
}

function report_invoice_pot_knitting($id)
{
    $hasil = $this->db->query("SELECT id, id_book_invoice, FORMAT(total, 2) AS total, FORMAT(discount, 2) AS discount, FORMAT(dp, 2) AS dp, 
      FORMAT(retur, 2) AS retur, FORMAT(twot, 2) AS twot, FORMAT(vat, 2) AS vat, FORMAT(grand_total, 2) AS grand_total 
      FROM tbl_invoice_pot_knitting 
      WHERE id_book_invoice = '$id' ");
    return $hasil->row_array();
}


}