<?php

use SebastianBergmann\Environment\Console;

class Model_nag extends CI_Model
{
    function cari_customer()
    {
        $hasil = $this->db->query("SELECT DISTINCT Id_Supplier, UPPER(Supplier) As Supplier FROM mastersupplier WHERE tipe_sup = 'C' ");
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

    function edit_booking_invoice($id, $doc_number, $id_type)
    {
        $hasil = $this->db->query("UPDATE tbl_book_invoice SET doc_number = '$doc_number', id_type = '$id_type' WHERE id = '$id' ");
        return $hasil;
    }

    function cancel_booking_invoice($id)
    {
        $hasil = $this->db->query("UPDATE tbl_book_invoice SET status = 'CANCEL' WHERE id = '$id' ");
        return $hasil;
    }

    function log_booking_invoice($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function getType($id)
    {
        $hasil = $this->db->query("SELECT b.id, b.id_type, b.doc_number, a.type, b.no_invoice
                                   FROM tbl_type AS a INNER JOIN tbl_book_invoice AS b ON a.id_type = b.id_type 
                                   WHERE b.id = '$id' ");
        return $hasil->row();
    }

    function cari_book_inv($dt_dari, $dt_sampai)
    {
        $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
                                          DATE_FORMAT(a.tgl_book_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, 
                                          FORMAT(VALUE, 2) AS amount
                                   FROM  tbl_book_invoice AS a INNER JOIN 
                                          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                                          tbl_type AS c ON a.id_type = c.id_type WHERE a.status = 'DRAFT' 
                                          AND a.tgl_book_inv BETWEEN '$dt_dari' AND '$dt_sampai' ");
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

    function cari_so($dt_dari_so, $dt_sampai_so, $id_customer)
    {
        //Database Localhost / SB2     
        // $hasil = $this->db->query("SELECT DISTINCT a.so_no, a.so_date, c.Supplier, a.buyerno, a.so_type, b.id_so
        //                            FROM  so_det AS b INNER JOIN so AS a 
        //                                  ON (b.id_so = a.id) INNER JOIN 
        //                                  act_costing AS d ON (a.id_cost = d.id) INNER JOIN 
        //                                  mastersupplier AS c ON (c.Id_Supplier = d.id_buyer) INNER JOIN 
        //                                  bppb AS e ON (e.id_so_det = b.id) 
        //                            WHERE c.Id_Supplier = '$id_customer' AND a.so_date BETWEEN '$dt_dari_so' AND '$dt_sampai_so' AND c.tipe_sup = 'C' ");
        // return $hasil->result_array();
        //
        //Database SignalBit
        $db_nag = $this->load->database('db_nag', TRUE);
        $hasil = $db_nag->query("SELECT DISTINCT a.so_no, a.so_date, c.Supplier, a.buyerno, a.so_type, b.id_so
                                 FROM  so_det AS b INNER JOIN so AS a 
                                       ON (b.id_so = a.id) INNER JOIN 
                                       act_costing AS d ON (a.id_cost = d.id) INNER JOIN 
                                       mastersupplier AS c ON (c.Id_Supplier = d.id_buyer) INNER JOIN 
                                       bppb AS e ON (e.id_so_det = b.id) 
                                 WHERE c.Id_Supplier = '$id_customer' AND a.so_date BETWEEN '$dt_dari_so' AND '$dt_sampai_so' AND c.tipe_sup = 'C' ");
        return $hasil->result_array();
    }

    function cari_sj($id_sj)
    {
        //Database Localhost / SB2
        // $hasil = $this->db->query("SELECT a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number,  d.kpno AS ws,  
        //                                   d.styleno, e.product_group, e.product_item, b.color, b.size,  
        //                                   c.curr, c.unit AS uom, b.qty, c.price AS unit_price,  
        //                                   ROUND(b.qty * c.price, 2) AS total_price,  b.id_so, c.id AS id_bppb
        //                            FROM so AS a INNER JOIN 
        //                                   so_det AS b ON a.id = b.id_so INNER JOIN 
        //                                   bppb AS c ON b.id = c.id_so_det INNER JOIN 
        //                                   act_costing AS d ON a.id_cost = d.id INNER JOIN 
        //                                   masterproduct AS e ON d.id_product = e.id               
        //                            WHERE b.id_so = '$id_sj' AND (ISNULL(c.stat_inv) OR c.stat_inv = '')
        //                            ORDER BY c.bppbno ");
        // return $hasil->result_array();
        //
        //Database SignalBit
        $db_nag = $this->load->database('db_nag', TRUE);
        $hasil = $db_nag->query("SELECT a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
                                        d.styleno, e.product_group, e.product_item, b.color, b.size,  
                                        c.curr, c.unit AS uom, c.qty, c.price AS unit_price,  
                                        ROUND(c.qty * c.price, 2) AS total_price,  b.id_so, c.id AS id_bppb
                                 FROM so AS a INNER JOIN 
                                       so_det AS b ON a.id = b.id_so INNER JOIN 
                                       bppb AS c ON b.id = c.id_so_det INNER JOIN 
                                       act_costing AS d ON a.id_cost = d.id INNER JOIN 
                                       masterproduct AS e ON d.id_product = e.id               
                                 WHERE b.id_so = '$id_sj' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0')
                                 ORDER BY c.bppbno ");
        return $hasil->result_array();
    }

    function update_status_invoice($id_inv, $pph, $tanggal_input, $id_top, $id_bank, $type_so)
    {
        $hasil = $this->db->query("UPDATE tbl_book_invoice 
                                   SET status  = 'POST', 
                                       pph     = '$pph', 
                                       tgl_inv = '$tanggal_input',
                                       id_top  = '$id_top', 
                                       id_bank =  '$id_bank', 
                                       type_so = '$type_so'
                                    WHERE id = '$id_inv' ");
        return $hasil;
    }

    function update_status_bppb($id)
    {
        //Database Localhost / SB2
        // $hasil = $this->db->query("UPDATE bppb SET stat_inv = '1' WHERE id = '$id' ");
        // return $hasil;
        //
        //Database SignalBit
        $db_nag = $this->load->database('db_nag', TRUE);
        $hasil = $db_nag->query("UPDATE bppb SET stat_inv = '1' WHERE id = '$id' ");
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
        return $hasil;
    }

    function cari_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
    {

        if ($id_customer == "all_customer") {
            // $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, 
            //                               DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer,
            //                               FORMAT((d.grand_total), 2) AS amount
            //                        FROM  tbl_book_invoice AS a INNER JOIN 
            //                               mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
            //                               tbl_type AS c ON a.id_type = c.id_type INNER JOIN
            //                      		  tbl_invoice_pot AS d ON a.id = d.id_book_invoice       
            //                        WHERE a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
            //                        ORDER BY a.id ");

             $hasil = $this->db->query("SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp,                                     a.doc_type, a.doc_number, 
                                          DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer,
                                          FORMAT((d.grand_total), 2) AS amount
                                   FROM  tbl_book_invoice AS a INNER JOIN 
                                          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                                          tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                                          tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
                                          tbl_invoice_detail as e on a.id=e.id_book_invoice      
                                   WHERE a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
                                   ORDER BY a.id ");

            return $hasil->result_array();
        } else {
            $hasil = $this->db->query("SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, 
                                              DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, 
                                              FORMAT((d.grand_total), 2) AS amount
                                       FROM  tbl_book_invoice AS a INNER JOIN 
                                              mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                                              tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                                 		      tbl_invoice_pot AS d ON a.id = d.id_book_invoice  INNER JOIN
                                              tbl_invoice_detail as e on a.id=f.id_book_invoice      
                                       WHERE a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND a.id_customer = '$id_customer' 
                                       ORDER BY a.id ");
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
        $hasil = $this->db->query("SELECT id_book_invoice, total, discount, dp, retur, twot, vat, grand_total
                                   FROM tbl_invoice_pot
                                   WHERE id_book_invoice = '$id' ");
        return $hasil->result_array();
    }

    function report_invoice($id)
    {
        $hasil = $this->db->query("SELECT distinct a.no_invoice, LEFT(b.Supplier, 30) AS customer,
                                          LEFT(IFNULL(b.alamat, '-'), 27) AS alamat, IFNULL(b.Phone, '-') AS phone, IFNULL(b.Email, '-') AS email,
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
        $hasil = $this->db->query("SELECT styleno, product_group, product_item, color, size, qty, unit_price, disc, FORMAT(total_price, 2) AS total_price, uom, curr
                                   FROM tbl_invoice_detail
                                   WHERE id_book_invoice = '$id' ");
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

    function cari_bank($id)
    {
        $hasil = $this->db->query("SELECT id, kode_bank, nama_bank, curr, no_rek, nama_rek, id_coa, v_company, 
                                          v_companyaddress, v_branch, v_bankaddress, v_swiftcode
                                   FROM masterbank WHERE id = '$id' ");
        return $hasil->row_array();
    }

    function cari_invoice_post($dt_dari_inv, $dt_sampai_inv)
    {
        $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number,
                                          DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS inv_date, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer
                                   FROM  tbl_book_invoice AS a INNER JOIN 
                                          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                                          tbl_type AS c ON a.id_type = c.id_type 
                                   WHERE a.status = 'POST' AND a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' ");
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
        //With Condition
        //
        $hasil = $this->db->query("SELECT a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, 
                                          DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS tanggal, c.type,  a.status, a.id, c.id_type, b.Id_Supplier AS id_customer, d.top, 
                                          DATE_ADD(a.tgl_inv, INTERVAL d.top DAY) AS duedate, e.no_duedate, e.id_invoice
                                   FROM  tbl_book_invoice AS a INNER JOIN 
                                           mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                                           tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
                                           tbl_master_top AS d ON a.id_top = d.id LEFT JOIN 
                                           tbl_duedate AS e ON a.no_duedate = e.no_duedate
                                    WHERE a.status = 'APPROVED' AND a.tgl_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
                                           AND a.id_customer = '$id_customer' AND (ISNULL(a.no_duedate) OR a.no_duedate = '' OR e.status = 'CANCEL')");
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
        $hasil = $this->db->query("SELECT e.id, e.no_duedate, DATE_FORMAT(a.tgl_inv, '%Y-%m-%d') AS invoice_date, 
                                          DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d') AS kontrabon_date, d.top, DATE_ADD(DATE_FORMAT(e.kontrabon_date, '%Y-%m-%d'), INTERVAL d.top DAY) AS duedate,
                                          a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, a.shipp, a.doc_type, a.doc_number, c.type,  a.status, e.status
                                   FROM  tbl_book_invoice AS a INNER JOIN 
                                         mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                                         tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
                                         tbl_master_top AS d ON a.id_top = d.id INNER JOIN 
                                         tbl_duedate AS e ON a.id = e.id_invoice
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
        $hasil = $db_nag->query("SELECT a.so_no, a.so_date, c.Supplier, a.buyerno, e.curr,
                                        FORMAT(SUM(b.qty), 2) AS qty, FORMAT(SUM(e.price), 2) AS unit_price, FORMAT(SUM(b.qty) * SUM(e.price), 2) AS total_price, b.id_so
                                 FROM so_det AS b INNER JOIN so AS a 
                                        ON (b.id_so = a.id) INNER JOIN 
                                        act_costing AS d ON (a.id_cost = d.id) INNER JOIN 
                                        mastersupplier AS c ON (c.Id_Supplier = d.id_buyer) INNER JOIN 
                                        bppb AS e ON (e.id_so_det = b.id) 
                                 WHERE c.Id_Supplier = '$id_customer' AND a.so_date BETWEEN '$dt_dari_so_prof' AND '$dt_sampai_so_prof' AND c.tipe_sup = 'C'
                                 GROUP BY b.id_so
                                 ORDER BY b.id_so ");
        return $hasil->result_array();
    }

    function simpan_invoice_detail_proforma_temporary($data)
    {
        $this->db->insert_batch('tbl_invoice_proforma_detail_temp', $data);
        return $this->db->insert_id();
    }

    function load_invoice_detail_proforma_temporary()
    {
        $hasil = $this->db->query("SELECT id_so, so_no, DATE_FORMAT(so_date, '%Y-%m-%d') AS so_date, buyerno, curr, FORMAT(qty, 2) AS qty, 
                                          FORMAT(unit_price, 2) AS unit_price, FORMAT(total_price, 2) AS total_price 
                                   FROM tbl_invoice_proforma_detail_temp");
        return $hasil->result_array();
    }

    function sum_grandtotal_proforma()
    {
        $hasil = $this->db->query("SELECT FORMAT(SUM(total_price), 2) AS grand_total
                                   FROM tbl_invoice_proforma_detail_temp");
        return $hasil->result_array();
    }

    function delete_invoice_detail_proforma_temporary()
    {
        $hasil = $this->db->query("DELETE FROM tbl_invoice_proforma_detail_temp");
        return $hasil;
    }

    function simpan_proforma_invoice_header($data)
    {
        $this->db->insert_batch('tbl_invoice_proforma', $data);
        return $this->db->insert_id();
    }

    function simpan_proforma_invoice_detail($data)
    {
        $this->db->insert_batch('tbl_invoice_proforma_detail', $data);
        return $this->db->insert_id();
    }

    function cari_proforma_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
    {

        if ($id_customer == "all_customer") {
            $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
                                              c.type, a.status, a.no_faktur_pajak,  FORMAT(SUM(d.total_price), 2) AS amount
                                       FROM tbl_invoice_proforma AS a INNER JOIN 
                                              mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
                                              tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
                                              tbl_invoice_proforma_detail AS d ON a.no_proforma_invoice = d.no_invoice_proforma
                                       WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' 
                                       GROUP BY a.no_proforma_invoice ");
            return $hasil->result_array();
        } else {
            $hasil = $this->db->query("SELECT a.id, a.no_proforma_invoice AS no_pi, DATE_FORMAT(a.tgl_proforma_inv, '%Y-%m-%d') AS date_pi, b.supplier AS customer, a.shipp, a.peb,
                                              c.type, a.status, a.no_faktur_pajak, FORMAT(SUM(d.total_price), 2) AS amount
                                       FROM tbl_invoice_proforma AS a INNER JOIN 
                                              mastersupplier AS b ON a.id_customer = b.Id_Supplier INNER JOIN 
                                              tbl_type AS c ON a.id_type = c.id_type INNER JOIN 
                                              tbl_invoice_proforma_detail AS d ON a.no_proforma_invoice = d.no_invoice_proforma
                                       WHERE a.status = 'POST' AND a.tgl_proforma_inv BETWEEN '$dt_dari_inv' AND '$dt_sampai_inv' AND a.id_customer = '$id_customer' 
                                       GROUP BY a.no_proforma_invoice ");
            return $hasil->result_array();
        }
    }

    function update_faktur_pajak($id, $faktur_pjk)
    {
        $hasil = $this->db->query("UPDATE tbl_invoice_proforma SET no_faktur_pajak = '$faktur_pjk' WHERE id = '$id' ");
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

    function report_proforma_invoice_detail($id)
    {
        $hasil = $this->db->query("SELECT b.id, a.no_invoice_proforma, a.so_no, a.curr, FORMAT(a.qty, 2) AS qty, 
                                          FORMAT(a.unit_price, 2) AS unit_price, 
                                          FORMAT(a.total_price, 2) AS total_price
                                   FROM tbl_invoice_proforma_detail AS a INNER JOIN 
                                         tbl_invoice_proforma AS b ON a.no_invoice_proforma = b.no_proforma_invoice
                                   WHERE b.id = '$id' ");
        return $hasil->result_array();
    }

    function report_proforma_invoice_total($id)
    {
        $hasil = $this->db->query("SELECT a.curr,
                                          SUM(a.qty) AS qty, 
                                          SUM(a.unit_price) AS unit_price, 
                                          SUM(a.total_price) AS total_price
                                  FROM tbl_invoice_proforma_detail AS a INNER JOIN 
                                          tbl_invoice_proforma AS b ON a.no_invoice_proforma = b.no_proforma_invoice
                                  WHERE b.id = '$id' ");
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

    //Debit Note

    function get_kode_debitnote()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(no_debitnote, 4)) AS kd_max 
                               FROM tbl_debitnote
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
        return "DN/NAG/" . date('my') . "/" . $kd;
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

    function block_page($user, $menu_name)
    {
        $hasil = $this->db->query("SELECT b.user, a.menu, b.menu_id
                                   FROM tbl_user_role AS a INNER JOIN 
                                        tbl_user_access AS b ON a.id = b.menu_id
                                   WHERE b.user = '$user' AND a.menu = '$menu_name' ");
        return $hasil->row_array();
    }
}
