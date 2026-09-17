<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arnag extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
    }

    //Master TOP

    public function index()
    {

        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Master TOP';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['customer'] = $this->Model_nag->cari_customer();
        $data['master_top'] = $this->Model_nag->master_top();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/mastertop', $data);
        $this->load->view('templates/footer', $data);
    }

    public function simpan_master_top()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $status = "Active";
        $data = [
            'id_customer' => $this->input->post('customer'),
            'type'        => $this->input->post('top'),
            'top'         => $this->input->post('txtop'),
            'status'      => $status
        ];
        $this->Model_nag->simpan_master_top($data, 'tbl_master_top');
        redirect('arnag');
    }

    public function edit_master_top()
    {
        $id     = $this->input->post('id_top');
        $status = $this->input->post('status_mdl');
        $this->Model_nag->edit_master_top($id, $status);
        redirect('arnag');
    }

    public function bookinvoice()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //
        $kode_inv = "";
        $data['kode_book_invoice'] = $this->Model_nag->get_kode_book_invoice($kode_inv);
        $data['title'] = 'Booking Invoice';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['customer'] = $this->Model_nag->cari_customer();
        $data['profit_center'] = $this->Model_nag->cari_profit_center();
        $data['book_customer'] = $this->Model_nag->cari_customer();
        $data['type'] = $this->db->get('tbl_type')->result_array();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/bookinvoice', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_kwitansi()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Kwitansi';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['customer'] = $this->Model_nag->cari_customer();
        $data['kode_kwt'] = $this->Model_nag->get_kode_kwt();
        $data['type'] = $this->db->get('tbl_type')->result_array();
        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result->tgl_awal != null) ? $result->tgl_awal : '';
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/create_kwitansi', $data);
        $this->load->view('templates/footer', $data);
    }

    //ubah september
    public function create_debitnote()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Create Debit Note';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['profit_center'] = $this->Model_nag->cari_profit_center();
        $data['customer'] = $this->Model_nag->cari_customer();
        $data['data_req'] = $this->Model_nag->cari_no_req();
        $data['nm_memo'] = $this->Model_nag->cari_nm_memo();
        $data['supplier'] = $this->Model_nag->cari_supplier();
        $data['bank'] = $this->Model_nag->get_bank();
        $data['cost_center'] = $this->Model_nag->cari_cost();
        $data['coa'] = $this->Model_nag->cari_coa();
        $data['kode_alokasi'] = $this->Model_nag->get_kode_debitnote();
        $data['rate'] = $this->Model_nag->get_rate();
        $data['kode_kwt'] = $this->Model_nag->get_kode_kwt();
        $data['type'] = $this->db->get('tbl_type')->result_array();
        $data['isi_bank'] = $this->Model_nag->load_bank();
        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result->tgl_awal != null) ? $result->tgl_awal : '';
        // $data['nm_memo'] = $this->Model_nag->cari_nm_memo_temp();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        // Ukuran potongan upload supporting document (ikut batas upload PHP).
        $data['dn_doc_chunk'] = $this->_dn_doc_chunk_size();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/create_debitnote', $data);
        $this->load->view('templates/footer', $data);
    }


    public function kwitansi_ar()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Kwitansi';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['customer'] = $this->Model_nag->cari_customer();
        $data['type'] = $this->db->get('tbl_type')->result_array();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/kwitansi_ar', $data);
        $this->load->view('templates/footer', $data);
    }

    public function loadbookinvoice($dt_dari, $dt_sampai, $id_customer, $status)
    {
        $data =  $this->Model_nag->loadbookinvoice($dt_dari, $dt_sampai, $id_customer, $status);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_credit($type_so,$shipp,$cust_ctg,$grade, $kode_pc)
    {
        $data = $this->Model_nag->getcoa_credit($type_so,$shipp,$cust_ctg,$grade, $kode_pc);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_dp($type_so,$shipp,$cust_ctg,$grade, $kode_pc)
    {
        $data = $this->Model_nag->getcoa_dp($type_so,$shipp,$cust_ctg,$grade, $kode_pc);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_pot($type_so,$shipp,$cust_ctg,$grade, $kode_pc)
    {
        $data = $this->Model_nag->getcoa_pot($type_so,$shipp,$cust_ctg,$grade, $kode_pc);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_ppn($type_so,$shipp,$cust_ctg,$grade, $kode_pc)
    {
        $data = $this->Model_nag->getcoa_ppn($type_so,$shipp,$cust_ctg,$grade, $kode_pc);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa($type_so,$shipp,$cust_ctg,$grade, $kode_pc)
    {
        $data = $this->Model_nag->getcoa($type_so,$shipp,$cust_ctg,$grade,$kode_pc);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_ppn4($shipp)
    {
        $data = $this->Model_nag->getcoa_ppn4($shipp);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa4($shipp)
    {
        $data = $this->Model_nag->getcoa4($shipp);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_credit2($type_so,$shipp,$cust_ctg)
    {
        $data = $this->Model_nag->getcoa_credit2($type_so,$shipp,$cust_ctg);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_dp2($type_so,$shipp,$cust_ctg)
    {
        $data = $this->Model_nag->getcoa_dp2($type_so,$shipp,$cust_ctg);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_pot2($type_so,$shipp,$cust_ctg)
    {
        $data = $this->Model_nag->getcoa_pot2($type_so,$shipp,$cust_ctg);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa_ppn2($type_so,$shipp,$cust_ctg)
    {
        $data = $this->Model_nag->getcoa_ppn2($type_so,$shipp,$cust_ctg);
        echo json_encode($data);
    }


    //ubah desember
    public function getcoa2($type_so,$shipp,$cust_ctg)
    {
        $data = $this->Model_nag->getcoa2($type_so,$shipp,$cust_ctg);
        echo json_encode($data);
    }

    //ubah desember
    public function getcoa3($cust_ctg)
    {
        $data = $this->Model_nag->getcoa3($cust_ctg);
        echo json_encode($data);
    }

    //ubah akhir
    public function getbuyer($id_cust)
    {
        $data = $this->Model_nag->getbuyer($id_cust);
        echo json_encode($data);
    }

    //ubah desember
    public function getrate($inv_date)
    {
        $data = $this->Model_nag->getrate($inv_date);
        echo json_encode($data);
    }

    //ubah desember
    public function at_debit_inv()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->at_debit_inv($data);
        echo json_encode(array("status" => TRUE));
    }

    //ubah desember
    public function at_pot_inv()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->at_pot_inv($data);
        echo json_encode(array("status" => TRUE));
    }

     //ubah desember
    public function at_dp_inv()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->at_dp_inv($data);
        echo json_encode(array("status" => TRUE));
    }

    //ubah desember
    public function at_credit_inv()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->at_credit_inv($data);
        echo json_encode(array("status" => TRUE));
    }

    //ubah desember
    public function at_credit_dpcbd()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->at_credit_dpcbd($data);
        echo json_encode(array("status" => TRUE));
    }

    //ubah desember
    public function at_dp_dpcbd()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->at_dp_dpcbd($data);
        echo json_encode(array("status" => TRUE));
    }

    //ubah desember
    public function at_ppn_inv()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->at_ppn_inv($data);
        echo json_encode(array("status" => TRUE));
    }

    //ubah desember
    public function update_coaname()
    {
        $this->Model_nag->update_coaname();
    }

    //ubah desember
    public function approval_invoice_dpcbd()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Approval Invoice DP & CBD';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/approval_invoice_dpcbd', $data);
        $this->load->view('templates/footer', $data);
    }

    //ubah desember
    public function cari_dpcbd_invoice_post($dt_dari_inv, $dt_sampai_inv)
    {
        $data =  $this->Model_nag->cari_dpcbd_invoice_post($dt_dari_inv, $dt_sampai_inv);
        echo json_encode($data);
    }

    //ubah desember
    public function approve_invoicedp()
    {
        $id = $this->input->post('id_inv');
        $this->Model_nag->approve_invoicedp($id);
    }

    public function approve_invoicedp_second()
    {
        $id = $this->input->post('id_inv');
        $this->Model_nag->approve_invoicedp_second($id);
    }

    public function cari_dpcbd_invoice_second_approv($dt_dari_inv, $dt_sampai_inv)
    {
        $data = $this->Model_nag->cari_dpcbd_invoice_second_approv($dt_dari_inv, $dt_sampai_inv);
        echo json_encode($data);
    }

    public function first_approval_invoice_dpcbd()
    {
        if (!$this->session->userdata('username')) { redirect('auth'); }
        $data['title'] = 'First Approval Invoice DP & CBD';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['profit_center'] = $this->Model_nag->cari_profit_center();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));
        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/first_approval_invoice_dpcbd', $data);
        $this->load->view('templates/footer', $data);
    }

    public function get_kode_book_invoice($kode_inv)
    { {
        $data = $this->Model_nag->get_kode_book_invoice($kode_inv);
        echo json_encode($data);
    }
}

public function getType($id)
{
    $data = $this->Model_nag->getType($id);
    echo json_encode($data);
}

public function simpan_booking_invoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //Cek nomor invoice di database
    $no_invoice = $this->input->post('id_inv');
    $query = $this->db->query("SELECT no_invoice FROM tbl_book_invoice WHERE no_invoice = '$no_invoice' ");

    if ($query->num_rows() > 0) {
        ?>
        <script type="text/javascript">
            alert("Sorry..terdapat nomor invoice yang sama di database, system akan melakukan reload page");
            window.location.href = ".../../bookinvoice";
        </script>
        <?php

    } else {
            //Tidak terdapat nomor invoice yang sama, lanjut input data
        $status = "DRAFT";
        $date = date('Y-m-d');
        $created_by = $this->session->userdata('username');
        $created_dated = date('Y-m-d H:i:s');
        $data = [
            'no_invoice'   => $this->input->post('id_inv'),
            'id_customer'  => $this->input->post('id_cust'),
            'id_customer_ship' => $this->input->post('id_cust_ship') ?: $this->input->post('id_cust'),
            'shipp'        => $this->input->post('type_shipp'),
            'id_type'      => $this->input->post('type_comm'),
            'tgl_book_inv' => $date,
            'status'       => $status,
            'value'        => $this->input->post('type_val'),
            'doc_type'    => $this->input->post('type_doc'),
            'doc_number'  => $this->input->post('type_doc_number'),
            'profit_center'  => $this->input->post('mdl_pc'),
            'reff_number'  => $this->input->post('reff_num'),
            'booking_by' => $created_by,
            'booking_date'       => $created_dated
        ];
        $this->Model_nag->simpan_booking_invoice($data, 'tbl_book_invoice');
            // Simpan Log
        $activity   = "Booking invoice";
        $doc_number = $this->input->post('id_inv');
        $status     = "DRAFT";
        $this->log_booking_invoice($activity, $doc_number, $status);
            // End Simpan Log
        redirect('arnag/bookinvoice');
    }
}

public function cancel_booking_invoice()
{
    $id = $this->input->post('id_book_inv');
    $this->Model_nag->cancel_booking_invoice($id);
        // Simpan Log
    $activity   = "Cancel booking invoice";
    $doc_number = $this->input->post('book_inv_number');
    $status     = "DRAFT";
    $this->log_booking_invoice($activity, $doc_number, $status);
        // End Simpan Log
    redirect('arnag/bookinvoice');
}


public function cancel_invoice()
{
    $id = $this->input->post('id_book_inv');
    $inv_info = $this->Model_nag->getType($id);
    // Ambil daftar FG/OUT (id_bppb + shipp_number + so_number + product_item) dulu
    // sebelum detail-nya dihapus, biar bisa dicatat per baris di log. Cek dua-duanya
    // (NAG di tbl_invoice_detail, NAK di tbl_invoice_detail_knitting) - yang ada
    // datanya cuma salah satu.
    $detail_rows = $this->db->query("
        SELECT DISTINCT id_bppb, shipp_number, so_number, product_item FROM tbl_invoice_detail WHERE id_book_invoice = '$id'
        UNION
        SELECT DISTINCT id_bppb, shipp_number, so_number, product_item FROM tbl_invoice_detail_knitting WHERE id_book_invoice = '$id'
    ")->result();

    // Ambil qty/price/total lama di bppb dulu (sebelum dikosongkan oleh update_bppb()),
    // supaya perubahannya ke-log lengkap. Nilai fallback (yang berlaku efektif begitu
    // kolom *_invoice dikosongkan) diambil dari bppb.qty & so_det.price (via id_so_det).
    $old_map = [];
    $fallback_map = [];
    if (!empty($detail_rows)) {
        $ids = array_map(function ($d) {
            return "'" . $d->id_bppb . "'";
        }, $detail_rows);
        $id_list = implode(',', $ids);
        $db_nag = $this->load->database('db_nag', TRUE);

        $bppb_rows = $db_nag->query("SELECT id, qty_invoice, price_invoice, total_invoice FROM bppb WHERE id IN ($id_list)")->result();
        foreach ($bppb_rows as $b) {
            $old_map[$b->id] = $b;
        }

        $fallback_rows = $db_nag->query("
            SELECT c.id AS id_bppb, c.qty, ROUND(b.price, 4) AS price
            FROM bppb c INNER JOIN so_det b ON b.id = c.id_so_det
            WHERE c.id IN ($id_list)
        ")->result();
        foreach ($fallback_rows as $f) {
            $fallback_map[$f->id_bppb] = $f;
        }
    }

    $this->Model_nag->update_bppb($id);
    $this->Model_nag->copy_invoice($id);
    $this->Model_nag->copy_pot($id);
    $this->Model_nag->copy_detail($id);
    $this->Model_nag->cancel_invoice($id);
    $this->Model_nag->delete_pot($id);
    $this->Model_nag->delete_detail($id);

        // Simpan Log Perubahan Data (dashboard) - 1 baris per FG/OUT kalau ada,
        // fallback 1 baris ringkasan invoice kalau tidak ada detail.
    if ($inv_info) {
        $created_by = $this->session->userdata('username');
        if (!empty($detail_rows)) {
            foreach ($detail_rows as $d) {
                $old   = isset($old_map[$d->id_bppb]) ? $old_map[$d->id_bppb] : null;
                $fb    = isset($fallback_map[$d->id_bppb]) ? $fallback_map[$d->id_bppb] : null;
                $qty_new   = $fb ? $fb->qty : null;
                $price_new = $fb ? $fb->price : null;
                $total_new = ($qty_new !== null && $price_new !== null) ? ($qty_new * $price_new) : null;

                $this->Model_nag->log_data_change($inv_info->no_invoice, 'bppb', 'Cancel Invoice', $inv_info->profit_center, $created_by, 'price_invoice', [
                    'qty_old'   => $old ? $old->qty_invoice : null,
                    'qty_new'   => $qty_new,
                    'price_old' => $old ? $old->price_invoice : null,
                    'price_new' => $price_new,
                    'total_old' => $old ? $old->total_invoice : null,
                    'total_new' => $total_new,
                ], $d->shipp_number, $d->so_number, $d->product_item);
            }
        } else {
            $this->Model_nag->log_data_change($inv_info->no_invoice, 'tbl_book_invoice', 'Cancel Invoice', $inv_info->profit_center, $created_by);
        }
    }

    redirect('arnag/listinvoice');
}


public function update_booking_invoice()
{
    $id          = $this->input->post('id_book_inv');
    $doc_number  = $this->input->post('doc_number_mdl');
    $id_type     = $this->input->post('type_mdl');
    $doc_type    = $this->input->post('docum_type');
    $amount     = $this->input->post('amount');
    $no_invoice     = $this->input->post('no_inv');
    $id_customer     = $this->input->post('cust_mdl');
    $id_customer_ship = $this->input->post('cust_ship_mdl') ?: $id_customer;
    $profit_center     = $this->input->post('pc_mdl');
    $shipp     = $this->input->post('shipp_mdl');
    $this->Model_nag->edit_booking_invoice($id, $doc_number, $id_type, $doc_type, $amount, $no_invoice, $id_customer, $profit_center, $shipp, $id_customer_ship);
    // redirect('arnag/bookinvoice');
    echo json_encode(['status' => 'ok']);
}

// Ubah Billed To pada booking invoice yang statusnya sudah diproses (bukan DRAFT) —
// khusus user 'lukman', untuk kasus koreksi setelah proses jalan
public function update_billed_to_processed()
{
    if (!$this->session->userdata('username')) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']); return;
    }
    if ($this->session->userdata('username') !== 'lukman') {
        echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']); return;
    }

    $id          = $this->input->post('id_book_inv_bt');
    $id_customer = $this->input->post('cust_bt');
    $no_invoice  = $this->input->post('no_inv_bt');

    if (!$id || !$id_customer) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']); return;
    }

    $this->Model_nag->update_billed_to($id, $id_customer);

    // Simpan Log
    $activity = 'Edit Billed To (invoice sudah diproses)';
    $this->log_booking_invoice($activity, $no_invoice, 'Billed To diubah ke id_customer=' . $id_customer);

    echo json_encode(['status' => 'ok']);
}

public function log_booking_invoice($activity, $doc_number, $status)
{
    $nama          = $this->session->userdata('username');
    $tanggal_input = date('Y-m-d');
    $tanggal_doc   = date('Y-m-d');
        //
    $data = [
        'nama'          => $nama,
        'activity'      => $activity,
        'tanggal_input' => $tanggal_input,
        'doc_number'    => $doc_number,
        'tanggal_doc'   => $tanggal_doc,
        'keterangan'    => $status

    ];
    $this->Model_nag->log_booking_invoice($data, 'tbl_log');
}

    //Create Invoice

public function createinvoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Create Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['isi_pph'] = $this->Model_nag->get_pph_list();
    $data['buyer'] = $this->Model_nag->cari_buyer();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/createinvoice', $data);
    $this->load->view('templates/footer', $data);
        //
    $this->delete_invoice_detail_temporary();
}

public function cari_book_inv($dt_dari, $dt_sampai)
{
    $data =  $this->Model_nag->cari_book_inv($dt_dari, $dt_sampai);
    echo json_encode($data);
}

    //ubah september
public function cari_bi($dt_dari, $dt_sampai)
{
    $data =  $this->Model_nag->cari_bi($dt_dari, $dt_sampai);
    echo json_encode($data);
}

public function cari_top()
{
    $id = $this->input->post('id_cust');
    $data =  $this->Model_nag->cari_top($id);
    echo json_encode($data);
}

public function cari_so($dt_dari_so, $dt_sampai_so, $id_customer, $buyer, $profit_center)
{
    $data =  $this->Model_nag->cari_so($dt_dari_so, $dt_sampai_so, $id_customer, $buyer, $profit_center);
    echo json_encode($data);
}

public function cari_sj($id_sj, $profit_center)
{
    $data =  $this->Model_nag->cari_sj($id_sj, $profit_center);
    echo json_encode($data);
}

    //ubah september
public function cari_dataso($id_so, $tipe)
{
    $data =  $this->Model_nag->cari_dataso($id_so, $tipe);
    echo json_encode($data);
}

public function update_invoice_header()
{
        //
    $id_inv = $this->input->post('id_inv');
    $no_inv = $this->input->post('inv_number1');
    $pph    = $this->input->post('pph');
    $id_pph = $this->input->post('id_pph');
    $tanggal_input = date('Y-m-d');
    $id_top = $this->input->post('id_top');
    $id_bank = $this->input->post('id_bank');
    $type_so = $this->input->post('type_so');
    $no_coa = $this->input->post('no_coa_deb');
    $nama_coa = $this->input->post('nama_coa_deb');
    $created_by = $this->session->userdata('username');
    $created_date = date('Y-m-d H:i:s');
    $this->Model_nag->update_status_invoice($id_inv, $pph, $tanggal_input, $id_top, $id_bank, $type_so, $no_coa, $nama_coa, $created_by, $created_date, $id_pph);
        // Simpan Log
    $activity   = "Create invoice";
    $doc_number = $no_inv;
    $status     = "POST";
    $this->log_booking_invoice($activity, $doc_number, $status);
        // Log Perubahan Data (dashboard) per FG/OUT sudah dicatat di
        // Model_nag::simpan_invoice_detail() (dipanggil terpisah dari JS), jadi tidak
        // perlu log ringkasan lagi di sini.
        // End Simpan Log
    redirect('arnag/createinvoice');
}

//ubah september
function update_status_bppb()
{
    $id = $this->input->post('id_bppb');
    $curr = $this->input->post('curr');
    $shipp = $this->input->post('no_invoice');
    $this->Model_nag->update_status_bppb($id, $shipp);
    $this->Model_nag->update_currency($curr, $shipp);
}


//ubah september
function update_pi_sodet()
{
    $id_sodet = $this->input->post('id_sodet');
    $no_pi = $this->input->post('prof_inv_number');
    $this->Model_nag->update_pi_sodet($id_sodet, $no_pi);
}
    //ubah september
function update_pi_sodet_cbd()
{
    $id_sodet = $this->input->post('id_sodet');
    $no_pi = $this->input->post('prof_inv_number');
    $this->Model_nag->update_pi_sodet_cbd($id_sodet, $no_pi);
}

public function simpan_invoice_detail()
{
    $data = $this->input->post('data_table');
    $created_by = $this->session->userdata('username');
    $this->Model_nag->simpan_invoice_detail($data, $created_by);
    echo json_encode(array("status" => TRUE));
}

public function simpan_invoice_pot()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_pot($data);
    echo json_encode(array("status" => TRUE));
}

public function simpan_invoice_detail_temporary()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_detail_temporary($data);
    echo json_encode(array("status" => TRUE));
}

public function load_invoice_detail_temporary()
{
    $data =  $this->Model_nag->load_invoice_detail_temporary();
    echo json_encode($data);
}

public function delete_invoice_detail_temporary()
{
    $this->Model_nag->delete_invoice_detail_temporary();
}

public function listinvoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'List Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['status'] = $this->Model_nag->cari_status();
    $data['user_cancel'] = $this->Model_nag->cari_usercancel($this->session->userdata('username'));
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/listinvoice', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer, $status)
{
    $data =  $this->Model_nag->cari_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer, $status);
    echo json_encode($data);
}

public function cari_inv_detail($id)
{
    $data =  $this->Model_nag->cari_inv_detail($id);
    echo json_encode($data);
}

public function cari_inv_pot($id)
{
    $data =  $this->Model_nag->cari_inv_pot($id);
    echo json_encode($data);
}

public function report_invoice($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //
    $this->load->library('pdfgenerator');
    $data['title'] = 'Report Invoice';
    $data['title_pdf'] = 'Report Invoice';
    $data['data_invoice'] = $this->Model_nag->report_invoice($id);
        //
    $file_pdf = 'report_invoice';
    $paper = 'A4';
    $orientation = "portrait";
    $html = $this->load->view('arnag/reportinvoice', $data, true);
        // run dompdf
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
}

public function report_invoice2($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //
    $this->load->library('pdfgenerator');
    $data['title'] = 'Report Invoice';
    $data['title_pdf'] = 'Report Invoice';
        //Report Invoice Header
    $data['data_invoice'] = $this->Model_nag->report_invoice($id);
    $data['data_invoice_detail'] = $this->Model_nag->report_invoice_detail($id);
    $data['data_invoice_pot'] = $this->Model_nag->report_invoice_pot($id);
        //
    $file_pdf = 'report_invoice';
    $paper = 'A4';
    $orientation = "portrait";
    $html = $this->load->view('arnag/reportinvoice2', $data, true);
        // run dompdf
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
}

public function report_invoice3($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_invoice'] = $this->Model_nag->report_invoice($id);
    if ($data['data_invoice'] && $data['data_invoice']['profit_center'] == 'NAK' && $data['data_invoice']['sj_date'] >= '2026-08-01') {
        $data_konsumen = $this->Model_nag->get_konsumen_invoice($id);
        if ($data_konsumen) {
            $data['data_invoice']['customer'] = $data_konsumen['supplier'];
            $data['data_invoice']['alamat'] = $data_konsumen['alamat'];
        }
    }
    $data['data_invoice_detail'] = $this->Model_nag->report_invoice_detail($id);
    $data['data_invoice_pot'] = $this->Model_nag->report_invoice_pot($id);
    $data['group_bppb_number'] = $this->Model_nag->group_bppb_number($id);
    $data['group_so_number'] = $this->Model_nag->group_so_number($id);
    $data['group_curr'] = $this->Model_nag->group_curr($id);
    $data['group_user'] = $this->Model_nag->group_user($id);

        //
    $html = $this->load->view('arnag/reportinvoice3', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

public function export_excel_invoice($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //
    $data['data_invoice'] = $this->Model_nag->report_invoice($id);
    if ($data['data_invoice'] && $data['data_invoice']['profit_center'] == 'NAK' && $data['data_invoice']['sj_date'] >= '2026-08-01') {
        $data_konsumen = $this->Model_nag->get_konsumen_invoice($id);
        if ($data_konsumen) {
            $data['data_invoice']['customer'] = $data_konsumen['supplier'];
            $data['data_invoice']['alamat'] = $data_konsumen['alamat'];
        }
    }
    $data['data_invoice_detail'] = $this->Model_nag->report_invoice_detail($id);
    $data['data_invoice_pot'] = $this->Model_nag->report_invoice_pot($id);
    $data['group_bppb_number'] = $this->Model_nag->group_bppb_number($id);
    $data['group_so_number'] = $this->Model_nag->group_so_number($id);
    $data['group_curr'] = $this->Model_nag->group_curr($id);
        //
    $this->load->view('arnag/excelinvoice', $data);
}

public function export_excel_list_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer, $status)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_list_invoice"] = $this->Model_nag->cari_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer, $status);
    $data["periode_dari"] = $dt_dari_inv;
    $data["periode_sampai"] = $dt_sampai_inv;
    $this->load->view('arnag/export_list_invoice', $data);
}

public function export_excel_list_alokasi($dt_dari_kwt, $dt_sampai_kwt, $id_customer)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_list_alokasi"] = $this->Model_nag->cari_alokasi_report($dt_dari_kwt, $dt_sampai_kwt, $id_customer);
    $data["periode_dari"] = $dt_dari_kwt;
    $data["periode_sampai"] = $dt_sampai_kwt;
    $this->load->view('arnag/export_list_alokasi', $data);
}

public function export_excel_book_invoice($dt_dari, $dt_sampai, $id_customer, $status)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_book_invoice"] = $this->Model_nag->loadbookinvoice($dt_dari, $dt_sampai, $id_customer, $status);
    $data["periode_dari_book"] = $dt_dari;
    $data["periode_sampai_book"] = $dt_sampai;
        // $data["status_book"] = $status;
    $this->load->view('arnag/export_book_invoice', $data);
}

public function approvalinvoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Second Approval Invoice';
    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/approvalinvoice', $data);
    $this->load->view('templates/footer', $data);
}

//ubah september
public function approval_proformainvoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Second Approval Proforma Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/approval_proformainvoice', $data);
    $this->load->view('templates/footer', $data);
}

//ubah september
public function approval_debitnote()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Second Approval Debit Note';
    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/approval_debitnote', $data);
    $this->load->view('templates/footer', $data);
}    


public function cari_invoice_post($dt_dari_inv, $dt_sampai_inv, $profit_center)
{
    $data =  $this->Model_nag->cari_invoice_post($dt_dari_inv, $dt_sampai_inv, $profit_center);
    echo json_encode($data);
}

    //ubah september
public function cari_proforma_invoice_post($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_proforma_invoice_post($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

    //ubah september
public function cari_debitnote_post($dt_dari_inv, $dt_sampai_inv, $profit_center)
{
    $data =  $this->Model_nag->cari_debitnote_post($dt_dari_inv, $dt_sampai_inv, $profit_center);
    echo json_encode($data);
}

public function cari_invoice_second_approv($dt_dari_inv, $dt_sampai_inv, $profit_center)
{
    $data = $this->Model_nag->cari_invoice_second_approv($dt_dari_inv, $dt_sampai_inv, $profit_center);
    echo json_encode($data);
}

public function cari_proforma_invoice_second_approv($dt_dari_inv, $dt_sampai_inv)
{
    $data = $this->Model_nag->cari_proforma_invoice_second_approv($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

public function cari_debitnote_second_approv($dt_dari_inv, $dt_sampai_inv, $profit_center)
{
    $data = $this->Model_nag->cari_debitnote_second_approv($dt_dari_inv, $dt_sampai_inv, $profit_center);
    echo json_encode($data);
}

public function approve_invoice()
{
    $id = $this->input->post('id_inv');
    $created_by = $this->session->userdata('username');
    $created_date = date('Y-m-d H:i:s');
    $result = $this->Model_nag->approve_invoice($id, $created_by, $created_date);
    $q = $this->db->query("SELECT no_invoice FROM tbl_book_invoice WHERE id = '$id'");
    $no_doc = ($q->row() && $q->row()->no_invoice) ? $q->row()->no_invoice : null;
    echo json_encode(['status' => (bool)$result, 'no_doc' => $no_doc]);
}

    //ubah september
public function approve_profinvoice()
{
    $id = $this->input->post('id_inv');
    $this->Model_nag->approve_profinvoice($id);
}

    //ubah september
public function approve_debitnote()
{
    $id = $this->input->post('id_inv');
    $result = $this->Model_nag->approve_debitnote($id);
    $q = $this->db->query("SELECT no_dn FROM tbl_debitnote_h WHERE id = '$id'");
    $no_doc = ($q->row() && $q->row()->no_dn) ? $q->row()->no_dn : null;
    echo json_encode(['status' => (bool)$result, 'no_doc' => $no_doc]);
}

public function approve_invoice_second()
{
    $id = $this->input->post('id_inv');
    $created_by = $this->session->userdata('username');
    $created_date = date('Y-m-d H:i:s');
    $this->Model_nag->approve_invoice_second($id, $created_by, $created_date);

    // affected_rows() dari query INSERT terakhir yang dijalankan model (tbl_list_journal atau sb_list_journal)
    $jurnal_rows = $this->db->affected_rows();
    $q = $this->db->query("SELECT no_invoice FROM tbl_book_invoice WHERE id = '$id'");
    $no_doc = ($q->row() && $q->row()->no_invoice) ? $q->row()->no_invoice : null;

    if ($jurnal_rows == 0) {
        $this->db->query("UPDATE tbl_book_invoice SET status = 'FIRST APPROVED', second_approve_by = NULL, second_approve_date = NULL WHERE id = '$id'");
        echo json_encode(['status' => false, 'reason' => 'jurnal_kosong', 'no_doc' => $no_doc]);
    } else {
        echo json_encode(['status' => true, 'no_doc' => $no_doc]);
    }
}

public function approve_profinvoice_second()
{
    $id = $this->input->post('id_inv');
    $this->Model_nag->approve_profinvoice_second($id);
}

public function approve_debitnote_second()
{
    $id = $this->input->post('id_inv');
    $result = $this->Model_nag->approve_debitnote_second($id);
    $q = $this->db->query("SELECT no_dn FROM tbl_debitnote_h WHERE id = '$id'");
    $no_doc = ($q->row() && $q->row()->no_dn) ? $q->row()->no_dn : null;
    echo json_encode(['status' => (bool)$result, 'no_doc' => $no_doc]);
}

    //Due Date Update

public function duedateupdate()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'DueDate Update';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['kode_duedate'] = $this->Model_nag->get_kode_duedate();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['load_duedate_inv'] = $this->Model_nag->load_duedate_invoice();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/duedateupdate', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_invoice_duedate($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    $data =  $this->Model_nag->cari_invoice_duedate($dt_dari_inv, $dt_sampai_inv, $id_customer);
    echo json_encode($data);
}

public function save_duedate()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->save_duedate($data);
    echo json_encode(array("status" => TRUE));
}

public function update_duedate_bookinvoice($id_inv)
{

    $no_duedate = $this->input->post('no_duedate');
    $this->Model_nag->update_duedate_bookinvoice($id_inv, $no_duedate);
}

function cancel_duedate()
{
    $id = $this->input->post('id_modal_dd');
    $this->Model_nag->cancel_duedate($id);
    redirect('arnag/duedateupdate');
}

    //Proforma Invoice 
    // ubah september

function proformainvoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //
    $kode_inv = "";
    $data['kode_proforma_invoice'] = $this->Model_nag->get_kode_proforma_invoice($kode_inv);

    $data['title'] = 'Proforma Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['isi_ppn'] = $this->Model_nag->load_ppn();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/proformainvoice', $data);
    $this->load->view('templates/footer', $data);
        //
    $this->delete_invoice_detail_proforma_temporary();
}

    //ubah september 
function proformainvoice_dp_cbd()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //
    $kode_inv = "";
    $type = "";
    $data['kode_proforma_invoice'] = $this->Model_nag->get_kode_proforma_invoice_cbd($kode_inv,$type);

    $data['title'] = 'Invoice DP & CBD';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['isi_ppn'] = $this->Model_nag->load_ppn();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/proformainvoice_dp_cbd', $data);
    $this->load->view('templates/footer', $data);
        //
    $this->delete_invoice_detail_proforma_temporary();
}

public function cari_prof_top($id)
{
    $data =  $this->Model_nag->cari_top($id);
    echo json_encode($data);
}

public function get_kode_proforma_invoice($kode_inv)
{ {
    $data = $this->Model_nag->get_kode_proforma_invoice($kode_inv);
    echo json_encode($data);
}
}

    //ubah september
public function get_kode_proforma_invoice_cbd($kode_inv,$type)
{ {
    $data = $this->Model_nag->get_kode_proforma_invoice_cbd($kode_inv,$type);
    echo json_encode($data);
}
}

    //ubah september
public function get_kode_cbd($kode)
{ {
    $data = $this->Model_nag->get_kode_cbd($kode);
    echo json_encode($data);
}
}

    //ubah septemb
public function cari_so_proforma($dt_dari_so_prof, $dt_sampai_so_prof, $id_customer)
{
    $data =  $this->Model_nag->cari_so_proforma($dt_dari_so_prof, $dt_sampai_so_prof, $id_customer);
    echo json_encode($data);
}

public function cari_so_proforma_cbd($dt_dari_so_prof, $dt_sampai_so_prof, $id_customer)
{
    $data =  $this->Model_nag->cari_so_proforma_cbd($dt_dari_so_prof, $dt_sampai_so_prof, $id_customer);
    echo json_encode($data);
}

public function simpan_invoice_detail_proforma_temporary()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_detail_proforma_temporary($data);
    echo json_encode(array("status" => TRUE));
}

    //ubah september
public function simpan_so_detail_proforma_temporary()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_so_detail_proforma_temporary($data);
    echo json_encode(array("status" => TRUE));
}

public function load_invoice_detail_proforma_temporary()
{
    $data =  $this->Model_nag->load_invoice_detail_proforma_temporary();
    echo json_encode($data);
}

    //ubah september
public function load_so_detail_proforma_temporary()
{
    $data =  $this->Model_nag->load_so_detail_proforma_temporary();
    echo json_encode($data);
}

public function sum_grandtotal_proforma()
{
    $data =  $this->Model_nag->sum_grandtotal_proforma();
    echo json_encode($data);
}

public function delete_invoice_detail_proforma_temporary()
{
    $this->Model_nag->delete_invoice_detail_proforma_temporary();
}

    //ubah september
public function delete_so_detail_proforma_temporary()
{
    $this->Model_nag->delete_so_detail_proforma_temporary();
}

public function simpan_proforma_invoice_header()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_proforma_invoice_header($data);
    echo json_encode(array("status" => TRUE));
}

    //ubah september
public function simpan_proforma_invoice_header_cbd()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_proforma_invoice_header_cbd($data);
    echo json_encode(array("status" => TRUE));
}

public function simpan_proforma_invoice_detail()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_proforma_invoice_detail($data);
    echo json_encode(array("status" => TRUE));
}

    //ubah september
public function simpan_proforma_invoice_detail_cbd()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_proforma_invoice_detail_cbd($data);
    echo json_encode(array("status" => TRUE));
}

    //ubah september
public function simpan_proforma_invoice_detail_so()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_proforma_invoice_detail_so($data);
    echo json_encode(array("status" => TRUE));
}

    //ubah september
public function simpan_proforma_invoice_detail_so_cbd()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_proforma_invoice_detail_so_cbd($data);
    echo json_encode(array("status" => TRUE));
}

function listproformainvoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //            
    $data['title'] = 'List Proforma Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        //
    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/listproformainvoice', $data);
    $this->load->view('templates/footer', $data);
}

    //ubah september
function listproformainvoice_dp_cbd()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //            
    $data['title'] = 'List Invoice DP & CBD';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        //
    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/listproformainvoice_dp_cbd', $data);
    $this->load->view('templates/footer', $data);
}

     //ubah september
function list_debitnote()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //            
    $data['title'] = 'List Debit Note';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        //
    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    // Hasil cancel dari halaman sebelumnya (lihat cancel_debnote).
    $data['dn_cancel_flash'] = $this->session->flashdata('dn_cancel');
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/list_debitnote', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_proforma_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    $data =  $this->Model_nag->cari_proforma_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer);
    echo json_encode($data);
}
    //ubah september
public function cari_proforma_invoice_cbd($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    $data =  $this->Model_nag->cari_proforma_invoice_cbd($dt_dari_inv, $dt_sampai_inv, $id_customer);
    echo json_encode($data);
}

    //ubah september
public function cari_debit_note($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    $data =  $this->Model_nag->cari_debit_note($dt_dari_inv, $dt_sampai_inv, $id_customer);
    echo json_encode($data);
}

public function update_faktur_pajak()
{

    $id          = $this->input->post('id_inv_prof');
    $faktur_pjk  = $this->input->post('no_paktur_pjk');
    $this->Model_nag->update_faktur_pajak($id, $faktur_pjk);
    redirect('arnag/listproformainvoice');
}

public function update_faktur_pajak_cbd()
{

    $id          = $this->input->post('id_inv_prof');
    $faktur_pjk  = $this->input->post('no_paktur_pjk');
    $this->Model_nag->update_faktur_pajak_cbd($id, $faktur_pjk);
    redirect('arnag/listproformainvoice_dp_cbd');
}

public function report_proforma_invoice($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_proforma_invoice'] = $this->Model_nag->report_proforma_invoice($id);
    $data['data_proforma_invoice_detail'] = $this->Model_nag->report_proforma_invoice_detail($id);
    $data['data_proforma_invoice_total'] = $this->Model_nag->report_proforma_invoice_total($id);
    $data['data_proforma_invoice_grandtotal'] = $this->Model_nag->report_proforma_invoice_grandtotal($id);
    $data['data_proforma_diskon'] = $this->Model_nag->report_proforma_diskon($id);
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        //
    $html = $this->load->view('arnag/reportproformainvoice', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

    //ubah september
public function report_proforma_invoice_cbd($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_proforma_invoice_cbd'] = $this->Model_nag->report_proforma_invoice_cbd($id);
    $data['data_proforma_invoice_detail_cbd'] = $this->Model_nag->report_proforma_invoice_detail_cbd($id);
    $data['data_proforma_invoice_total_cbd'] = $this->Model_nag->report_proforma_invoice_total_cbd($id);
    $data['data_proforma_invoice_grandtotal_cbd'] = $this->Model_nag->report_proforma_invoice_grandtotal_cbd($id);
    $data['data_proforma_diskon_cbd'] = $this->Model_nag->report_proforma_diskon_cbd($id);
    $data['data_invoice_dpcbd'] = $this->Model_nag->report_proforma_invoice_tot_dp($id);
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        //
    $html = $this->load->view('arnag/reportproformainvoicedpcbd', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}


    //ubah september
// ── Cetak Debit Note: PDF-nya digabung dengan supporting document ────────────
// DN yang tanggalnya mulai dari sini dicetak dengan desain PDF baru; yang
// lebih lama tetap memakai template lama supaya dokumen yang sudah beredar
// tidak berubah tampilannya. Kalau batasnya bergeser, ubah tanggal ini saja.
const DN_PDF_DESAIN_BARU_SEJAK = '2026-09-16';

private function _dn_desain_baru($tgl_dn)
{
    $tgl = substr(trim((string) $tgl_dn), 0, 10);
    return $tgl !== '' && $tgl >= self::DN_PDF_DESAIN_BARU_SEJAK;
}

// mPDF untuk desain baru: marginnya lebih rapat, bagian bawah disisakan untuk
// kaki halaman (pita + nama perusahaan), dan font tulis tangan Dancing Script
// (OFL, ikut disimpan di assets/build/fonts) didaftarkan untuk kata "Caring".
private function _dn_mpdf_baru()
{
    $bawaan = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $font = (new \Mpdf\Config\FontVariables())->getDefaults();

    $mpdf = new \Mpdf\Mpdf(array(
        'margin_top' => 7,
        'margin_bottom' => 30,
        // Jarak dari tepi bawah kertas ke kaki halaman. Bawaan mPDF 9mm, dan
        // kaki halaman tumbuh KE ATAS dari titik itu - dengan pita setinggi 16mm
        // hasilnya menabrak isi tabel. Jaraknya dirapatkan, margin bawah
        // dilebihkan: 30mm > 4mm + tinggi kaki halaman.
        'margin_footer' => 4,
        'margin_left' => 8,
        'margin_right' => 8,
        'fontDir' => array_merge($bawaan['fontDir'], array(FCPATH . 'assets/build/fonts/dancing-script')),
        'fontdata' => $font['fontdata'] + array(
            'dancingscript' => array('R' => 'DancingScript.ttf'),
        ),
    ));

    // Catatan: setAutoBottomMargin TIDAK dipakai. mPDF menghitung tinggi kaki
    // halaman tanpa memperhitungkan tinggi gambar pita, jadi hasilnya malah
    // terlalu kecil (9mm) dan isi tabel tertimpa. Margin bawah dipatok manual
    // di atas, harus >= tinggi pita + baris tulisan kaki halaman.

    return $mpdf;
}

// Menyusun PDF Debit Note (isinya saja, lampiran belum disambung) beserta
// nomornya. Dipakai bareng oleh tombol Print dan tombol Email supaya isi PDF
// keduanya selalu sama.
private function _dn_laporan($id, $dari_memo = false)
{
    $data['data_debit_note'] = $this->Model_nag->report_debit_note($id);
    $data['data_debit_note_det'] = $this->Model_nag->report_debit_note_det($id);
    $data['data_debit_note_det2'] = $dari_memo
        ? $this->Model_nag->report_debit_note_det_memo($id)
        : $this->Model_nag->report_debit_note_det2($id);
    $data['data_proforma_invoice_total_cbd'] = $this->Model_nag->report_proforma_invoice_total_cbd($id);
    $data['data_proforma_invoice_grandtotal_cbd'] = $this->Model_nag->report_proforma_invoice_grandtotal_cbd($id);
    $data['data_proforma_diskon_cbd'] = $this->Model_nag->report_proforma_diskon_cbd($id);
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

    // DN mulai tanggal batas dicetak dengan desain baru; sebelum itu tetap
    // memakai template lama supaya dokumen lama tidak berubah tampilannya.
    if ($this->_dn_desain_baru($data['data_debit_note']['tgl_dn'])) {
        $data['alamat_bank'] = $dari_memo
            ? $data['data_debit_note']['bank_address']
            : $data['data_debit_note']['bank_address'];
        $mpdf = $this->_dn_mpdf_baru();
        $html = $this->load->view('arnag/reportdebitnote_v2', $data, true);
    } else {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->setFooter('{PAGENO} / {nbpg}');
        $html = $this->load->view($dari_memo ? 'arnag/reportdebitnote_memo' : 'arnag/reportdebitnote', $data, true);
    }
    $mpdf->WriteHTML($html);

    return array('mpdf' => $mpdf, 'no_dn' => $data['data_debit_note']['no_dn']);
}

private function _dn_nama_file($no_dn)
{
    return 'DN_' . preg_replace('/[^A-Za-z0-9._-]/', '_', (string) $no_dn) . '.pdf';
}

// Menulis PDF akhir (isi DN + lampirannya) ke folder sementara lalu
// mengembalikan letak berkasnya. Pemanggil wajib menghapus berkas di kunci
// 'tmp' setelah selesai.
private function _dn_file_gabungan($mpdf, $id_dn, $no_dn, $docs = null)
{
    $folder_tmp = FCPATH . 'uploads/debitnote/tmp';
    if (!is_dir($folder_tmp)) {
        @mkdir($folder_tmp, 0755, true);
    }
    $tmp_dn    = $folder_tmp . '/cetak_' . (int) $id_dn . '_' . uniqid() . '.pdf';
    $tmp_hasil = $folder_tmp . '/gabung_' . (int) $id_dn . '_' . uniqid() . '.pdf';
    $mpdf->Output($tmp_dn, \Mpdf\Output\Destination::FILE);

    $kirim = $tmp_dn;
    $docs = $docs === null ? $this->Model_nag->get_dn_docs($id_dn) : $docs;
    if ($docs) {
        try {
            $lampiran = array();
            foreach ($docs as $doc) {
                $lampiran[] = array(
                    'path' => FCPATH . $doc['file_path'],
                    'nama' => $doc['original_name'],
                );
            }

            $this->load->library('Dn_pdf_gabung');
            $this->dn_pdf_gabung->gabung($tmp_dn, $lampiran, $tmp_hasil, $no_dn);
            if (is_file($tmp_hasil) && filesize($tmp_hasil) > 0) {
                $kirim = $tmp_hasil;
            }
        } catch (\Exception $e) {
            // Penggabungan gagal - Debit Note-nya sendiri tetap harus keluar.
            log_message('error', 'Gabung PDF Debit Note gagal: ' . $e->getMessage());
        }
    }

    return array('path' => $kirim, 'tmp' => array($tmp_dn, $tmp_hasil));
}

// Alamat tujuan dikirim lewat URL dalam bentuk base64url supaya tidak
// bertabrakan dengan aturan karakter URI CodeIgniter.
private function _dn_email_tujuan($sandi)
{
    $sandi = str_replace(array('-', '_'), array('+', '/'), (string) $sandi);
    $sisa = strlen($sandi) % 4;
    if ($sisa) {
        $sandi .= str_repeat('=', 4 - $sisa);
    }
    $alamat = trim((string) base64_decode($sandi, true));

    return filter_var($alamat, FILTER_VALIDATE_EMAIL) ? $alamat : '';
}
// mPDF tidak bisa mengimpor halaman dari PDF lain, jadi hasil mPDF ditulis ke
// file sementara dulu, lalu disambung dengan lampirannya oleh library
// Dn_pdf_gabung (FPDI + TCPDF).
// Kalau DN belum punya lampiran, PDF-nya dikirim langsung dari mPDF seperti
// sebelumnya - tanpa proses tambahan.
private function _dn_cetak($mpdf, $id_dn, $no_dn)
{
    $nama_file = $this->_dn_nama_file($no_dn);
    $docs = $this->Model_nag->get_dn_docs($id_dn);

    // Tanpa lampiran, PDF-nya dikirim langsung dari mPDF - tidak perlu singgah
    // ke berkas sementara.
    if (!$docs) {
        $mpdf->Output($nama_file, \Mpdf\Output\Destination::INLINE);
        return;
    }

    $hasil = $this->_dn_file_gabungan($mpdf, $id_dn, $no_dn, $docs);
    if (is_file($hasil['path']) && filesize($hasil['path']) > 0) {
        while (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $nama_file . '"');
        header('Content-Length: ' . filesize($hasil['path']));
        header('X-Content-Type-Options: nosniff');
        readfile($hasil['path']);
    }

    foreach ($hasil['tmp'] as $f) {
        if (is_file($f)) {
            @unlink($f);
        }
    }
    exit;
}

// Menyusun berkas .eml (PDF Debit Note + lampirannya menempel) - dipakai bareng
// oleh unduhan .eml (email_debitnote) dan jalur Outlook langsung (email_siapkan).
// Mengembalikan array('nama' => 'DN_xxx.eml', 'isi' => ...) atau null kalau
// PDF-nya gagal disusun.
private function _dn_susun_eml($id, $tipe, $to)
{
    $laporan = $this->_dn_laporan($id, $tipe === 'memo');
    $no_dn = $laporan['no_dn'];
    $hasil = $this->_dn_file_gabungan($laporan['mpdf'], $id, $no_dn);

    $isi_pdf = (is_file($hasil['path']) && filesize($hasil['path']) > 0)
        ? file_get_contents($hasil['path'])
        : '';
    foreach ($hasil['tmp'] as $f) {
        if (is_file($f)) {
            @unlink($f);
        }
    }
    if ($isi_pdf === '') {
        return null;
    }

    $nama_pdf = $this->_dn_nama_file($no_dn);
    // Badan pesan sengaja dikosongkan - isinya ditulis sendiri di Outlook.
    $isi_pesan = '';

    $this->load->library('Dn_email');
    $eml = $this->dn_email->buat_eml(array(
        'to' => $to,
        'subjek' => 'Debit Note ' . $no_dn,
        'isi' => $isi_pesan,
        'lampiran' => array(
            array('nama' => $nama_pdf, 'tipe' => 'application/pdf', 'isi' => $isi_pdf),
        ),
    ));

    return array('nama' => substr($nama_pdf, 0, -4) . '.eml', 'isi' => $eml);
}

// Tombol "Email" di daftar DN (jalur unduhan). Menghasilkan berkas .eml berisi
// pesan siap kirim; di Windows berkas itu dibuka Outlook sebagai jendela tulis.
public function email_debitnote($id, $tipe = 'biasa', $tujuan = '')
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    // Segmen tujuan boleh tidak ada - berarti To sengaja dikosongkan supaya
    // diisi langsung di Outlook. Yang ditolak cuma isian yang salah bentuk.
    $to = '';
    if (trim((string) $tujuan) !== '') {
        $to = $this->_dn_email_tujuan($tujuan);
        if ($to === '') {
            show_error('Alamat email tujuan tidak terbaca atau tidak valid.', 400, 'Email Debit Note');
        }
    }

    $eml = $this->_dn_susun_eml($id, $tipe, $to);
    if ($eml === null) {
        show_error('PDF Debit Note gagal disusun.', 500, 'Email Debit Note');
    }

    while (ob_get_level()) {
        ob_end_clean();
    }
    header('Content-Type: message/rfc822');
    header('Content-Disposition: attachment; filename="' . $eml['nama'] . '"');
    header('Content-Length: ' . strlen($eml['isi']));
    header('X-Content-Type-Options: nosniff');
    echo $eml['isi'];
    exit;
}

// ── Email DN: jalur "Outlook langsung" lewat protokol nagdn: ─────────────────
// Alur: halaman membuat KUNCI acak -> POST email_siapkan (butuh sesi) menyusun
// .eml ke application/cache/dn_email/ -> browser membuka
// nagdn:KUNCI/<skema>/<alamat aplikasi yang sedang dibuka>, mis. nagdn:KUNCI/http/10.10.5.60/ar/
// -> skrip kecil di PC pengguna mencocokkan alamat itu dengan daftar server
// yang dipasang di PC, lalu mengambil email_ambil/KUNCI dari server itu saja
// (tanpa sesi; sekali pakai, berumur 120 detik, harus dari IP dan alamat yang
// sama) dan membukanya di Outlook.
// Aplikasi bisa dibuka dari beberapa alamat/server (10.10.5.60, 10.10.5.12,
// DDNS); kunci yang dibuat lewat satu alamat hanya dilayani alamat itu.
// Tidak ada tabel/kolom baru: status disimpan sebagai berkas di
// application/cache, yang sudah ditolak dari web oleh application/.htaccess.
// Berkas per kunci: .json (meta) .tmp/.eml (isi) .nama .ping (skrip sudah
// menghubungi) .tolak (IP beda) .batal (pengguna memilih unduh) .diambil.

// Umur kunci (detik, sejak email_siapkan dimulai). Halaman berhenti menunggu
// dan membatalkan kunci sebelum batas ini; skrip PC berhenti mencoba lebih dulu.
const DN_EMAIL_UMUR_KUNCI = 120;
// Batas ukuran .eml yang diterima skrip PC (sama dengan BATAS_UKURAN di dn-email.vbs).
const DN_EMAIL_MAKS_BYTE = 41943040;

private function _dn_json($kode, array $data)
{
    while (ob_get_level()) {
        ob_end_clean();
    }
    set_status_header($kode);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    // Penanda bahwa jawaban ini dari aplikasi AR. Skrip PC mengabaikan jawaban
    // tanpa penanda (halaman router, alamat/port yang salah, dll).
    header('X-Nag-DnEmail: 2');
    echo json_encode($data);
    exit;
}

private function _dn_email_folder()
{
    $folder = APPPATH . 'cache/dn_email';
    if (!is_dir($folder)) {
        @mkdir($folder, 0700, true);
    }
    // Pelindung kalau application/.htaccess tidak dibaca server (AllowOverride None).
    if (!is_file($folder . '/index.html')) {
        @file_put_contents($folder . '/index.html', '');
        @file_put_contents($folder . '/.htaccess', "Require all denied\n");
    }
    return $folder;
}

private function _dn_email_kunci_sah($kunci)
{
    // \z, bukan $: $ masih meloloskan kunci yang diakhiri baris baru.
    return is_string($kunci) && preg_match('/^[A-Za-z0-9_-]{43}\z/', $kunci) === 1;
}

// IP pemanggil untuk ikatan kunci. Semua alamat loopback dianggap satu: di PC
// yang sama browser bisa datang lewat ::1 sementara skrip Windows lewat
// 127.0.0.1 - kalau dibandingkan mentah, kuncinya selalu ditolak. IPv4 yang
// masuk lewat soket dual-stack ('::ffff:a.b.c.d') disamakan dengan IPv4 biasa.
private function _dn_email_ip()
{
    $ip = (string) $this->input->ip_address();
    if ($ip === '::1' || strpos($ip, '127.') === 0 || strcasecmp($ip, '::ffff:127.0.0.1') === 0) {
        return 'loopback';
    }
    if (stripos($ip, '::ffff:') === 0 && filter_var(substr($ip, 7), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return substr($ip, 7);
    }
    return $ip;
}

// Alamat (host[:port]) yang dipakai membuka aplikasi, dalam bentuk baku: huruf
// kecil, tanpa :80/:443.
private function _dn_email_host()
{
    $host = strtolower(trim((string) $this->input->server('HTTP_HOST')));
    return preg_replace('/:(80|443)$/', '', $host);
}

// Penanda "PC ini sudah memasang skrip" hanya dipakai di jaringan kantor:
// aplikasi dibuka lewat IP/localhost (bukan nama DDNS - lewat hairpin NAT semua
// PC terlihat sebagai IP router) dan IP pemanggil privat. IP publik dipakai
// bersama banyak PC, jadi tidak pernah ditandai.
private function _dn_email_lan()
{
    $host = trim(preg_replace('/:\d+$/', '', $this->_dn_email_host()), '[]');
    if ($host !== 'localhost' && filter_var($host, FILTER_VALIDATE_IP) === false) {
        return false;
    }
    $ip = $this->_dn_email_ip();
    if ($ip === 'loopback') {
        return true;
    }
    return filter_var($ip, FILTER_VALIDATE_IP) !== false
        && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
}

// log_threshold aplikasi 0, jadi jejak fitur ini ditulis ke berkasnya sendiri
// (application/logs sudah tertutup dari web).
private function _dn_email_log($pesan)
{
    @file_put_contents(
        APPPATH . 'logs/dn_email-' . date('Y-m-d') . '.log',
        date('H:i:s') . ' ' . $pesan . "\n",
        FILE_APPEND | LOCK_EX
    );
}

// Kunci dibuang setelah 15 menit, penanda PC setelah 90 hari.
private function _dn_email_bersihkan($folder)
{
    $daftar = glob($folder . '/*');
    foreach ($daftar ? $daftar : array() as $f) {
        if (in_array(basename($f), array('index.html', '.htaccess'), true)) {
            continue;
        }
        $umur = strpos(basename($f), 'pc_') === 0 ? 7776000 : 900;
        if (is_file($f) && filemtime($f) < time() - $umur) {
            @unlink($f);
        }
    }
}

private function _dn_email_waktu_kunci($dasar)
{
    $meta = is_file($dasar . '.json') ? json_decode((string) file_get_contents($dasar . '.json'), true) : null;
    return is_array($meta) ? (int) $meta['waktu'] : 0;
}

private function _dn_email_penanda_pc()
{
    return $this->_dn_email_folder() . '/pc_' . md5($this->_dn_email_ip());
}

// Skrip PC tidak membawa cookie; jangan tinggalkan berkas sesi kosong tiap kali
// skrip itu memanggil. Kalau ada cookie (dibuka dari browser), sesi dibiarkan.
private function _dn_tanpa_sesi()
{
    if ($this->input->cookie($this->config->item('sess_cookie_name')) === null) {
        $this->session->sess_destroy();
    }
}

// POST dari halaman (bersesi): susun .eml untuk KUNCI buatan browser.
public function email_siapkan()
{
    $user = (string) $this->session->userdata('username');
    if ($user === '') {
        $this->_dn_json(401, array('pesan' => 'Session expired. Please log in again.'));
    }
    // X-Requested-With hanya bisa dikirim lintas situs lewat preflight CORS yang
    // tidak pernah dijawab server ini -> menutup CSRF (csrf_protection mati).
    if ($this->input->method() !== 'post' || !$this->input->is_ajax_request()) {
        $this->_dn_json(400, array('pesan' => 'Invalid request.'));
    }
    $kunci  = (string) $this->input->post('kunci');
    $id     = (int) $this->input->post('id');
    $tipe   = $this->input->post('tipe') === 'memo' ? 'memo' : 'biasa';
    $tujuan = trim((string) $this->input->post('tujuan'));
    if (!$this->_dn_email_kunci_sah($kunci) || $id <= 0) {
        $this->_dn_json(400, array('pesan' => 'Invalid request.'));
    }
    $to = '';
    if ($tujuan !== '') {
        $to = $this->_dn_email_tujuan($tujuan);
        if ($to === '') {
            $this->_dn_json(400, array('pesan' => 'Recipient address is not valid.'));
        }
    }
    // Lepas kunci berkas sesi: menyusun PDF bisa beberapa detik dan jangan
    // menahan permintaan lain dari browser yang sama (email_status).
    session_write_close();

    $folder = $this->_dn_email_folder();
    if (!is_dir($folder) || !is_writable($folder)) {
        $this->_dn_email_log('siapkan GAGAL folder tidak bisa ditulis: ' . $folder);
        // Unduhan .eml tidak memakai folder ini, jadi masih bisa dipakai.
        $this->_dn_json(500, array('pesan' => 'The server cannot prepare emails for Outlook right now.', 'unduh' => true));
    }
    $this->_dn_email_bersihkan($folder);

    // Mode 'x' gagal kalau berkasnya sudah ada: satu kunci hanya bisa diklaim sekali.
    $h = @fopen($folder . '/' . $kunci . '.json', 'x');
    if (!$h) {
        $this->_dn_json(409, array('pesan' => 'Please try again.'));
    }
    fwrite($h, json_encode(array(
        'user'  => $user,
        'ip'    => $this->_dn_email_ip(),
        'host'  => $this->_dn_email_host(),
        'waktu' => time(),
        'id'    => $id,
    )));
    fclose($h);
    $this->_dn_email_log('siapkan user=' . $user . ' ip=' . $this->_dn_email_ip() . ' host=' . $this->_dn_email_host() . ' id=' . $id);

    $eml = $this->_dn_susun_eml($id, $tipe, $to);
    $dasar = $folder . '/' . $kunci;
    if ($eml === null) {
        @unlink($dasar . '.json');
        $this->_dn_json(500, array('pesan' => 'The Debit Note PDF could not be built.'));
    }
    // Skrip PC menolak .eml di atas batas ini; lebih baik langsung ke unduhan.
    if (strlen($eml['isi']) > self::DN_EMAIL_MAKS_BYTE) {
        @unlink($dasar . '.json');
        $this->_dn_json(500, array('pesan' => 'This email is too large to open in Outlook automatically.', 'unduh' => true));
    }
    // Pengguna sudah membatalkan / sudah lewat batas selagi PDF disusun.
    if (is_file($dasar . '.batal') || time() - $this->_dn_email_waktu_kunci($dasar) > self::DN_EMAIL_UMUR_KUNCI) {
        $this->_dn_json(410, array('pesan' => 'The email request has expired.'));
    }
    $sementara = $dasar . '.tmp';
    $tulis = file_put_contents($sementara, $eml['isi'], LOCK_EX);
    @file_put_contents($dasar . '.nama', $eml['nama'], LOCK_EX);
    // rename atomik: skrip PC hanya pernah melihat .eml yang sudah utuh.
    if ($tulis !== strlen($eml['isi']) || !@rename($sementara, $dasar . '.eml')) {
        @unlink($sementara);
        @unlink($dasar . '.json');
        $this->_dn_email_log('siapkan GAGAL menulis .eml ' . $kunci);
        $this->_dn_json(500, array('pesan' => 'The server cannot prepare emails for Outlook right now.', 'unduh' => true));
    }

    $this->_dn_json(200, array('ok' => true));
}

// GET dari skrip PC (tanpa sesi). 404 = belum siap / kunci asing di alamat ini;
// 410 = dibatalkan, kedaluwarsa, atau sudah diambil.
public function email_ambil($kunci = '')
{
    $this->_dn_tanpa_sesi();
    if (!$this->_dn_email_kunci_sah($kunci)) {
        $this->_dn_json(404, array());
    }
    $folder = $this->_dn_email_folder();
    $dasar = $folder . '/' . $kunci;
    if (!is_file($dasar . '.json')) {
        $this->_dn_json(404, array());
    }
    $meta = json_decode((string) file_get_contents($dasar . '.json'), true);
    // Kunci yang dibuat lewat alamat lain dianggap asing di alamat ini.
    if (!is_array($meta) || (isset($meta['host']) && (string) $meta['host'] !== $this->_dn_email_host())) {
        $this->_dn_json(404, array());
    }
    if (is_file($dasar . '.batal') || time() - (int) $meta['waktu'] > self::DN_EMAIL_UMUR_KUNCI) {
        @unlink($dasar . '.eml');
        $this->_dn_json(410, array('alasan' => is_file($dasar . '.batal') ? 'batal' : 'kedaluwarsa'));
    }
    // Skrip jalan di PC yang sama dengan browser dan lewat alamat yang sama,
    // jadi IP-nya harus sama. Beda berarti proxy/VPN - halaman memberi tahu.
    if ((string) $meta['ip'] !== $this->_dn_email_ip()) {
        @touch($dasar . '.tolak');
        $this->_dn_email_log('ambil DITOLAK ip siapkan=' . $meta['ip'] . ' ip ambil=' . $this->_dn_email_ip() . ' host=' . $this->_dn_email_host());
        $this->_dn_json(403, array('alasan' => 'ip'));
    }
    // Skrip sudah menghubungi server: halaman berhenti menunggu "skrip tidak ada".
    @touch($dasar . '.ping');
    $eml_f = $dasar . '.eml';
    $ambil_f = $dasar . '.diambil';
    // Sekali pakai: yang kalah balapan rename mendapat 404.
    if (!is_file($eml_f) || !@rename($eml_f, $ambil_f)) {
        // Sudah diambil sebelumnya (mis. transfernya tadi terputus): jangan ditunggu lagi.
        if (is_file($ambil_f)) {
            $this->_dn_json(410, array('alasan' => 'diambil'));
        }
        $this->_dn_json(404, array());
    }
    $isi = (string) file_get_contents($ambil_f);
    @file_put_contents($ambil_f, '');          // tinggal penanda untuk email_status
    $nama = is_file($dasar . '.nama') ? (string) file_get_contents($dasar . '.nama') : 'DebitNote.eml';
    $this->_dn_email_log('ambil OK ' . $nama . ' user=' . $meta['user'] . ' ip=' . $this->_dn_email_ip() . ' host=' . $this->_dn_email_host());

    while (ob_get_level()) {
        ob_end_clean();
    }
    header('Content-Type: message/rfc822');
    header('Content-Disposition: attachment; filename="DebitNote.eml"');
    header('Content-Length: ' . strlen($isi));
    header('X-Dn-Nama: ' . preg_replace('/[^A-Za-z0-9._-]/', '_', $nama));
    header('X-Nag-DnEmail: 2');
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff');
    echo $isi;
    exit;
}

// GET dari halaman (bersesi): sampai mana skrip PC memproses kunci ini.
public function email_status($kunci = '')
{
    $user = (string) $this->session->userdata('username');
    session_write_close();
    if ($user === '' || !$this->_dn_email_kunci_sah($kunci)) {
        $this->_dn_json(400, array('status' => 'tidak_ada'));
    }
    $dasar = $this->_dn_email_folder() . '/' . $kunci;
    $meta = is_file($dasar . '.json') ? json_decode((string) file_get_contents($dasar . '.json'), true) : null;
    if (!is_array($meta) || $meta['user'] !== $user) {
        $this->_dn_json(200, array('status' => 'tidak_ada'));
    }
    $status = 'disusun';
    if (is_file($dasar . '.diambil')) {
        $status = 'diambil';
    } elseif (is_file($dasar . '.tolak')) {
        $status = 'ditolak';
    } elseif (is_file($dasar . '.batal')) {
        $status = 'dibatalkan';
    } elseif (is_file($dasar . '.ping')) {
        $status = 'dihubungi';
    } elseif (is_file($dasar . '.eml')) {
        $status = 'siap';
    }
    $this->_dn_json(200, array('status' => $status));
}

// GET dari halaman (bersesi): PC ini sudah memasang skrip pembantu? Hanya
// dijawab di jaringan kantor (lihat _dn_email_lan); di luar itu halaman
// mengandalkan ingatan browser per alamat.
public function email_handler()
{
    $ada = (bool) $this->session->userdata('username');
    session_write_close();
    // Dipanggil tiap halaman daftar dibuka: tempat yang pas membuang kunci lama
    // (berisi PDF DN) yang tidak pernah diambil.
    $this->_dn_email_bersihkan($this->_dn_email_folder());
    $f = $this->_dn_email_penanda_pc();
    $ada = $ada && $this->_dn_email_lan() && is_file($f) && filemtime($f) > time() - 7776000;
    $this->_dn_json(200, array('terpasang' => $ada, 'waktu' => $ada ? filemtime($f) : 0, 'versi' => 2));
}

// GET dari pemasang di PC (tanpa sesi). Hanya bisa menandai IP pemanggil
// sendiri, dan hanya di jaringan kantor.
public function email_handler_daftar()
{
    $this->_dn_tanpa_sesi();
    $lan = $this->_dn_email_lan();
    if ($lan) {
        @touch($this->_dn_email_penanda_pc());
    }
    $this->_dn_json(200, array('ok' => true, 'ditandai' => $lan, 'versi' => 2));
}

// POST dari halaman (bersesi): batalkan kunci yang masih menunggu supaya Outlook
// tidak terbuka dua kali. Rename .eml bersaing dengan rename di email_ambil -
// tepat satu yang menang. Kalau skrip sudah lebih dulu mengambil, jawabannya
// diambil:true dan halaman tidak ikut mengunduh. Penanda PC tidak dihapus.
public function email_handler_lupa()
{
    $user = (string) $this->session->userdata('username');
    session_write_close();
    if ($user === '' || !$this->input->is_ajax_request()) {
        $this->_dn_json(400, array());
    }
    $kunci = (string) $this->input->post('kunci');
    if ($this->_dn_email_kunci_sah($kunci)) {
        $dasar = $this->_dn_email_folder() . '/' . $kunci;
        $meta = is_file($dasar . '.json') ? json_decode((string) file_get_contents($dasar . '.json'), true) : null;
        if (is_array($meta) && $meta['user'] === $user) {
            @touch($dasar . '.batal');
            if (@rename($dasar . '.eml', $dasar . '.dibuang')) {
                @unlink($dasar . '.dibuang');
            } elseif (is_file($dasar . '.diambil')) {
                $this->_dn_json(200, array('ok' => true, 'diambil' => true));
            }
        }
    }
    $this->_dn_json(200, array('ok' => true, 'diambil' => false));
}
public function report_debit_note($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $laporan = $this->_dn_laporan($id, false);
    // Lampiran DN ikut disambung ke PDF ini (lihat _dn_cetak).
    $this->_dn_cetak($laporan['mpdf'], $id, $laporan['no_dn']);
}

    //ubah september
public function report_debit_note_memo($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $laporan = $this->_dn_laporan($id, true);
    // Lampiran DN ikut disambung ke PDF ini (lihat _dn_cetak).
    $this->_dn_cetak($laporan['mpdf'], $id, $laporan['no_dn']);
}


public function excel_pi_invoice($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //           
    $data['data_proforma_invoice'] = $this->Model_nag->report_proforma_invoice($id);
    $data['data_proforma_invoice_detail'] = $this->Model_nag->report_proforma_invoice_detail($id);
    $data['data_proforma_invoice_total'] = $this->Model_nag->report_proforma_invoice_total($id);
        //
    $this->load->view('arnag/excelproformainvoice', $data);
}

public function export_excel_list_pi($dt_dari_pi, $dt_sampai_pi, $id_customer)
{

    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_list_pi"] = $this->Model_nag->cari_proforma_invoice($dt_dari_pi, $dt_sampai_pi, $id_customer);
    $data["periode_dari"] = $dt_dari_pi;
    $data["periode_sampai"] = $dt_sampai_pi;
    $this->load->view('arnag/export_list_pi', $data);
}

    //ubah september
public function export_excel_list_pi_cbd($dt_dari_pi, $dt_sampai_pi, $id_customer)
{

    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_list_pi"] = $this->Model_nag->cari_proforma_invoice_cbd($dt_dari_pi, $dt_sampai_pi, $id_customer);
    $data["periode_dari"] = $dt_dari_pi;
    $data["periode_sampai"] = $dt_sampai_pi;
    $this->load->view('arnag/export_list_pi_cbd', $data);
}

    //Return Invoice 
public function returninvoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //
    $kode_inv = "";
    $data['kode_return_invoice'] = $this->Model_nag->get_kode_return_invoice($kode_inv);
        //
    $data['title'] = 'Return Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/returninvoice', $data);
    $this->load->view('templates/footer', $data);
        //        
    $this->delete_invoice_detail_return_temporary();
}

public function get_kode_return_invoice($kode_inv)
{ {
    $data = $this->Model_nag->get_kode_return_invoice($kode_inv);
    echo json_encode($data);
}
}

public function cari_sjbpb_return($dt_dari, $dt_sampai, $id_customer)
{
    $data =  $this->Model_nag->cari_sjbpb_return($dt_dari, $dt_sampai, $id_customer);
    echo json_encode($data);
}

public function simpan_invoice_detail_return_temporary()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_detail_return_temporary($data);
    echo json_encode(array("status" => TRUE));
}

public function load_invoice_detail_return_temporary()
{
    $data =  $this->Model_nag->load_invoice_detail_return_temporary();
    echo json_encode($data);
}

public function delete_invoice_detail_return_temporary()
{
    $this->Model_nag->delete_invoice_detail_return_temporary();
}

public function simpan_return_invoice_header()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_return_invoice_header($data);
    echo json_encode(array("status" => TRUE));
}

public function simpan_return_invoice_detail()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_return_invoice_detail($data);
    echo json_encode(array("status" => TRUE));
}

public function listreturninvoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //            
    $data['title'] = 'List Return Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        //
    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/listreturinvoice', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_return_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    $data =  $this->Model_nag->cari_return_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer);
    echo json_encode($data);
}

public function report_return_invoice($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_return_invoice'] = $this->Model_nag->report_return_invoice($id);
    $data['data_return_invoice_detail'] = $this->Model_nag->report_return_invoice_detail($id);
    $data['data_return_invoice_total'] = $this->Model_nag->report_return_invoice_total($id);
        //
    $html = $this->load->view('arnag/reportreturninvoice', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

public function excel_return_invoice($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //           
    $data['data_return_invoice'] = $this->Model_nag->report_return_invoice($id);
    $data['data_return_invoice_detail'] = $this->Model_nag->report_return_invoice_detail($id);
    $data['data_return_invoice_total'] = $this->Model_nag->report_return_invoice_total($id);
        //
    $this->load->view('arnag/excelreturninvoice', $data);
}

public function export_excel_list_return($dt_dari_rtn, $dt_sampai_rtn, $id_customer)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_list_return"] = $this->Model_nag->cari_return_invoice($dt_dari_rtn, $dt_sampai_rtn, $id_customer);
    $data["periode_dari"] = $dt_dari_rtn;
    $data["periode_sampai"] = $dt_sampai_rtn;
    $this->load->view('arnag/export_list_return', $data);
}

    //Debit Note

function debitnote()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Debit Note';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['kode_debitnote'] = $this->Model_nag->get_kode_debitnote();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['load_debitnote'] = $this->Model_nag->load_debitnote();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/debitnote', $data);
    $this->load->view('templates/footer', $data);
}

function save_debitnote()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->save_debitnote($data);
    echo json_encode(array("status" => TRUE));
}

function cancel_debitnote()
{
    $id = $this->input->post('id_modal_dn');
    $this->Model_nag->cancel_debitnote($id);
    redirect('arnag/debitnote');
}

    //User Role

public function userrole()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //Cek Block User From Input Address
        // $menu_name = 'User Role';
        // $block = $this->Model_nag->block_page($this->session->userdata('username'), $menu_name);
        // if ($block == "") {
        //     redirect('landingpage/block_page');
        // }
        //
    $data['title'] = 'User Role';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['data_user'] = $this->Model_nag->load_user();
    $data['data_menu'] = $this->Model_nag->load_menu();
    $data['data_user_access'] = $this->Model_nag->load_user_access();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/userrole', $data);
    $this->load->view('templates/footer', $data);
}

public function report_kwitansi($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_kwitansi'] = $this->Model_nag->cari_data_kwitansi($id);
    $data['data_kwitansi2'] = $this->Model_nag->cari_data_kwitansi2($id);
        // $data['data_invoice_pot'] = $this->Model_nag->report_invoice_pot($id);
        // $data['group_bppb_number'] = $this->Model_nag->group_bppb_number($id);
        // $data['group_so_number'] = $this->Model_nag->group_so_number($id);
        // $data['group_curr'] = $this->Model_nag->group_curr($id);
        //
    $html = $this->load->view('arnag/report_kwitansi', $data, true);
        // $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

public function update_tbl_kwitansi()
{
    $id          = $this->input->post('no_kwt');
    $bilang     = $this->input->post('terbilang');
    $this->Model_nag->update_tbl_kwitansi($id, $bilang);
    redirect('arnag/kwitansi_ar');
}

public function cancel_kwitansi()
{
    $id = $this->input->post('id_kwitansi');
    $this->Model_nag->cancel_kwitansi($id);
    $this->Model_nag->update_inv_kwt($id);

    redirect('arnag/kwitansi_ar');
}

//ubah september -
// User yang boleh membatalkan Debit Note. HARUS sama dengan daftar yang
// menyalakan tombol "Cancel Debit Note" di modal list_debitnote.php.
private function _dn_boleh_cancel()
{
    return array('willy', 'yulianto', 'hady', 'hadi', 'jefri', 'ramon', 'lukman', 'oktora', 'frisca');
}

// Cancel dari modal di List Debit Note (POST id_debnote = nomor DN).
// Memo & Req DN yang dipakai DN ikut dilepas di Model_nag::cancel_debnote(),
// dalam satu transaksi. Hasilnya ditampilkan di halaman list lewat flashdata.
public function cancel_debnote()
{
    $user = $this->session->userdata('username');
    if (!$user) {
        redirect('auth');
    }
    if ($this->input->method() !== 'post') {
        redirect('arnag/list_debitnote');
    }

    if (!in_array($user, $this->_dn_boleh_cancel(), true)) {
        $hasil = array('status' => false, 'message' => 'You are not allowed to cancel debit notes.');
    } else {
        $hasil = $this->Model_nag->cancel_debnote($this->input->post('id_debnote'));
        if ($hasil['status']) {
            log_message('info', 'Cancel Debit Note oleh ' . $user . ': ' . $hasil['message']);
        }
    }

    $this->session->set_flashdata('dn_cancel', array('status' => (bool) $hasil['status'], 'message' => $hasil['message']));
    redirect('arnag/list_debitnote');
}

public function delete_before_userrole($user)
{
    $this->Model_nag->delete_before_userrole($user);
}

public function hapus($id)
{
    $this->Model_nag->delete_userrole($id);
    redirect('arnag/userrole');
}

public function save_userrole()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->save_userrole($data);
    echo json_encode(array("status" => TRUE));
}

public function logout_user_acces()
{
    redirect('auth/logout');
}


public function cari_invoice_kwt($dt_dari_invkwt, $dt_sampai_invkwt, $id_customer)
{
    $data =  $this->Model_nag->cari_invoice_kwt($dt_dari_invkwt, $dt_sampai_invkwt, $id_customer);
    echo json_encode($data);
}

public function cari_kwitansi($dt_dari_kwt, $dt_sampai_kwt, $customer)
{
    $data =  $this->Model_nag->cari_kwitansi($dt_dari_kwt, $dt_sampai_kwt, $customer);
    echo json_encode($data);
}

public function cari_view_kwitansi($no_kwt)
{
    $data =  $this->Model_nag->cari_view_kwitansi($no_kwt);
    echo json_encode($data);
}

public function getType3($no_kwt)
{
    $data = $this->Model_nag->getType3($no_kwt);
    echo json_encode($data);
}

 //ubah september
public function get_alamat($kode)
{ 
    $data = $this->Model_nag->get_alamat($kode);
    echo json_encode($data);
}

//ubah september
public function ubahnomor_dn($kode, $pc = 'NAG')
{
    $data = $this->Model_nag->ubahnomor_dn($kode, $pc);
    echo json_encode($data);
}

//ubah september
public function ubahnomor_alo($kode)
{ 
    $data = $this->Model_nag->ubahnomor_alo($kode);
    echo json_encode($data);
}


 //ubah september
public function ubahnomor_kwt($kode)
{ 
    $data = $this->Model_nag->ubahnomor_kwt($kode);
    echo json_encode($data);
}   

public function delete_kwt_detail_temporary()
{
    $this->Model_nag->delete_kwt_detail_temporary();
}

public function simpan_kwt_detail_temporary()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_kwt_detail_temporary($data);
    echo json_encode(array("status" => TRUE));
}

public function load_kwt_detail_temporary()
{
    $data =  $this->Model_nag->load_kwt_detail_temporary();
    echo json_encode($data);
}

public function update_style()
{

    $id = $this->input->post('id');
    $style = $this->input->post('style');
    $this->Model_nag->update_style($id, $style);
}

public function simpan_kwt_detail()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_kwt_detail($data);
    echo json_encode(array("status" => TRUE));
}

function update_status_kwt_inv()
{
    $no_invoice = $this->input->post('no_invoice');
    $no_kwt = $this->input->post('no_kwt');
    $this->Model_nag->update_status_kwt_inv($no_invoice, $no_kwt);
}

function update_status_kwt_inv2()
{
    $no_invoice = $this->input->post('no_invoice');
    $no_kwt = $this->input->post('no_kwt');
    $this->Model_nag->update_status_kwt_inv($no_invoice, $no_kwt);
}

public function simpankwitansi()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpankwitansi($data);
    echo json_encode(array("status" => TRUE));
}


public function simpan_invoice_nb_detail()
{
    $data = $this->input->post('data_table');
    $created_by = $this->session->userdata('username');
    $this->Model_nag->simpan_invoice_nb_detail($data, $created_by);
    echo json_encode(array("status" => TRUE));
}

public function report_invoice4($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_invoice'] = $this->Model_nag->report_invoice_nb($id);
    $data['data_invoice_detail'] = $this->Model_nag->report_invoice_detail_nb($id);
    $data['data_invoice_pot'] = $this->Model_nag->report_invoice_pot_nb($id);
    $data['group_bppb_number'] = $this->Model_nag->group_bppb_number_nb($id);
    $data['group_so_number'] = $this->Model_nag->group_so_number_nb($id);
    $data['group_curr'] = $this->Model_nag->group_curr_nb($id);
    $data['group_user'] = $this->Model_nag->group_user_nb($id);
        //
    $html = $this->load->view('arnag/reportinvoice4', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

public function listinvoice_manual()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'List Invoice Manual';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));

        // $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/listinvoice_manual', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_invoice_nb($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    $data =  $this->Model_nag->cari_invoice_nb($dt_dari_inv, $dt_sampai_inv, $id_customer);
    echo json_encode($data);
}

public function cari_inv_detail_nb($id)
{
    $data =  $this->Model_nag->cari_inv_detail_nb($id);
    echo json_encode($data);
}

public function export_excel_list_invoice_nb($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_list_invoice"] = $this->Model_nag->cari_invoice_nb($dt_dari_inv, $dt_sampai_inv, $id_customer);
    $data["periode_dari"] = $dt_dari_inv;
    $data["periode_sampai"] = $dt_sampai_inv;
    $this->load->view('arnag/export_list_invoice2', $data);
}

public function export_excel_invoice_nb($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //          
    $data['data_invoice'] = $this->Model_nag->report_invoice_nb($id);
    $data['data_invoice_detail'] = $this->Model_nag->report_invoice_detail_nb($id);
    $data['data_invoice_pot'] = $this->Model_nag->report_invoice_pot_nb($id);
    $data['group_bppb_number'] = $this->Model_nag->group_bppb_number_nb($id);
    $data['group_so_number'] = $this->Model_nag->group_so_number_nb($id);
    $data['group_curr'] = $this->Model_nag->group_curr_nb($id);
        //
    $this->load->view('arnag/excelinvoice2', $data);
}

public function cancel_invoice_nb()
{
    $id = $this->input->post('id_book_inv');
    $created_by = $this->session->userdata('username');
    $this->Model_nag->cancel_invoice_nb($id, $created_by);


    redirect('arnag/listinvoice_manual');
}


public function simpan_invoice_nb_pot()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_nb_pot($data);
    echo json_encode(array("status" => TRUE));
}

public function simpan_invoice_nb()
{
    $data = $this->input->post('data_table');
    $no_inv = $this->input->post('no_inv');
    $this->Model_nag->simpan_invoice_nb($data);
    $activity   = "Create invoice Manual";
    $doc_number = $no_inv;
    $status     = "POST";
    $this->log_booking_invoice($activity, $doc_number, $status);
    echo json_encode(array("status" => TRUE));
}

public function createinvoice_manual()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Create Invoice Manual';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['isi_pph'] = $this->Model_nag->get_pph_list();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['kode_inv'] = $this->Model_nag->get_kode_inv_nb();
    $data['kode_id'] = $this->Model_nag->get_kode_id_nb();
    $data['kode_top'] = $this->Model_nag->get_kode_top_nb();
        // $data['cost_center'] = $this->Model_nag->cari_cost();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/createinvoice_manual', $data);
    $this->load->view('templates/footer', $data);
        //
        // $this->delete_invoice_detail_temporary();
}

public function get_kode_inv_nb($tanggal)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    echo json_encode(['kode_inv' => $this->Model_nag->get_kode_inv_nb($tanggal)]);
}

public function alokasi_ar()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Alokasi';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/alokasi_ar', $data);
    $this->load->view('templates/footer', $data);
}

public function create_alokasi()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Alokasi';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['cost_center'] = $this->Model_nag->cari_cost2();
    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['coa'] = $this->Model_nag->cari_coa();
    $data['kode_alokasi'] = $this->Model_nag->get_kode_alokasi();
    $data['kode_kwt'] = $this->Model_nag->get_kode_kwt();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/create_alokasi', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_invoice_alo($dt_dari_invkwt, $dt_sampai_invkwt, $id_customer, $rate, $pwith)
{
    $data =  $this->Model_nag->cari_invoice_alo($dt_dari_invkwt, $dt_sampai_invkwt, $id_customer, $rate, $pwith);
    echo json_encode($data);
}

public function delete_invoice_detail_alo()
{
    $this->Model_nag->delete_invoice_detail_alo();
}

public function simpan_invoice_detail_alo()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_detail_alo($data);
    echo json_encode(array("status" => TRUE));
}

public function load_invoice_detail_alo()
{
        // $data['cost_center'] = $this->Model_nag->cari_cost();
    $data =  $this->Model_nag->load_invoice_detail_alo();
    echo json_encode($data);
}

public function simpan_alokasi_detail()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_alokasi_detail($data);
    echo json_encode(array("status" => TRUE));
}

    //ubah september
public function simpandn_det()
{
    $data = $this->input->post('data_table');
    $ok   = $this->Model_nag->simpandn_det($data);
    echo json_encode(array("status" => $ok !== FALSE));
}


public function simpanalokasi()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpanalokasi($data);
    $activity   = "Create Alokasi";
    $doc_number = $this->input->post('no_alk');
    $status     = "POST";
    $this->log_booking_invoice($activity, $doc_number, $status);
    echo json_encode(array("status" => TRUE));
}

    //ubah september
// Header + detail dikirim bareng dari client (lihat simpandn_h() di crud-nag.js)
// dan di-insert dalam SATU transaksi lewat Model_nag->simpandn_h() - kalau salah
// satu gagal, dua-duanya di-rollback, jadi tidak ada header "nyangkut" tanpa
// detail. data_det opsional (dikosongkan array kalau tidak ada baris detail).
public function simpandn_h()
{
    $data     = $this->input->post('data_table');
    $data_det = $this->input->post('data_det');
    $no_dn    = $this->Model_nag->simpandn_h($data, $data_det);

    if ($no_dn === false) {
        echo json_encode(array("status" => FALSE, "message" => "Save failed, please try again."));
        return;
    }

    $activity   = "Create Debit Note";
    $doc_number = $no_dn;
    $status     = "POST";
    $this->log_booking_invoice($activity, $doc_number, $status);
    echo json_encode(array("status" => TRUE, "no_dn" => $no_dn));
}

// Upload supporting document untuk Debit Note yang baru saja tersimpan -
// dipanggil dari create_debitnote SETELAH simpandn_h sukses (butuh nomor DN
// final). Tidak ada batas ukuran file: file dikirim per potongan (ukurannya ikut
// batas upload PHP, lihat _dn_doc_chunk_size) lalu disambung di
// uploads/debitnote/tmp, jadi file ratusan MB tidak mentok upload_max_filesize /
// post_max_size. Setelah potongan terakhir, file dipindah ke uploads/debitnote/
// <tahun>/<bulan>/ dengan nama acak (folder uploads di-deny dari web lewat
// .htaccess) lalu dicatat di tbl_debitnote_doc - tabel itu dibuat manual lewat
// migrations/20260911_debitnote_supporting_document.sql.
public function upload_dn_doc()
{
    if (!$this->session->userdata('username')) {
        return $this->_dn_doc_json(false, 'Session expired, please log in again.');
    }
    // Request yang melebihi post_max_size dibuang PHP seluruhnya ($_POST & $_FILES kosong).
    if (empty($_POST) && empty($_FILES) && !empty($_SERVER['CONTENT_LENGTH'])) {
        return $this->_dn_doc_json(false, 'The upload is larger than the server allows.');
    }
    if (!$this->Model_nag->dn_doc_tabel_siap()) {
        return $this->_dn_doc_json(false, 'Supporting document table is not ready yet.', array('code' => 'table_missing'));
    }

    $no_dn = trim((string) $this->input->post('no_dn'));
    $id_dn = ($no_dn !== '') ? $this->Model_nag->cari_id_debitnote($no_dn) : null;
    if (!$id_dn) {
        return $this->_dn_doc_json(false, 'Debit note not found.');
    }
    // Lampiran dikunci setelah second approve (lihat Model_nag::dn_doc_bisa_diubah).
    $status_dn = $this->Model_nag->dn_doc_status_dn($id_dn);
    if (!$this->Model_nag->dn_doc_bisa_diubah($status_dn)) {
        return $this->_dn_doc_json(false, 'This debit note is already ' . strtolower((string) $status_dn) . ' - its documents can no longer be changed.');
    }

    $upload_id = (string) $this->input->post('upload_id');
    $nama_asli = basename(str_replace('\\', '/', (string) $this->input->post('nama')));
    $ukuran    = (int) $this->input->post('ukuran');
    $offset    = (int) $this->input->post('offset');
    $ext       = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
    $potongan  = isset($_FILES['potongan']) ? $_FILES['potongan'] : null;

    if (!preg_match('/^[a-f0-9]{32}$/', $upload_id) || $ukuran <= 0 || $offset < 0 || $offset >= $ukuran) {
        return $this->_dn_doc_json(false, 'Invalid upload request.');
    }
    if (!in_array($ext, array('pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'), true)) {
        return $this->_dn_doc_json(false, 'Only PDF and image files are allowed.');
    }
    if (!$potongan || is_array($potongan['name'])) {
        return $this->_dn_doc_json(false, 'No file received.');
    }
    if ($potongan['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($potongan['tmp_name'])) {
        $terlalu_besar = in_array($potongan['error'], array(UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE), true);
        return $this->_dn_doc_json(false, $terlalu_besar ? 'The upload is larger than the server allows.' : 'Upload failed (error ' . $potongan['error'] . ').');
    }

    $folder_tmp = FCPATH . 'uploads/debitnote/tmp';
    if (!is_dir($folder_tmp) && !@mkdir($folder_tmp, 0755, true)) {
        return $this->_dn_doc_json(false, 'Upload folder is not writable.');
    }
    $part = $folder_tmp . '/' . $upload_id . '.part';

    if ($offset === 0) {
        // Potongan pertama: cek isi file lewat byte awalnya, sekalian bersihkan
        // sisa upload lama yang tidak pernah selesai.
        if (!$this->_dn_doc_isi_cocok($potongan['tmp_name'], $ext)) {
            return $this->_dn_doc_json(false, 'File content does not match its type.');
        }
        foreach ((array) glob($folder_tmp . '/*.part') as $lama) {
            if (is_file($lama) && filemtime($lama) < time() - 86400) {
                @unlink($lama);
            }
        }
    } elseif (!is_file($part)) {
        return $this->_dn_doc_json(false, 'Upload expired, please try again.');
    }

    clearstatcache(true, $part);
    if ((is_file($part) ? filesize($part) : 0) < $offset) {
        return $this->_dn_doc_json(false, 'Upload is out of order, please try again.');
    }

    // Tulis mulai dari offset - potongan yang dikirim ulang (retry) menimpa bagiannya sendiri.
    $tulis = @fopen($part, 'c+');
    $baca  = @fopen($potongan['tmp_name'], 'rb');
    if (!$tulis || !$baca) {
        return $this->_dn_doc_json(false, 'Failed to store the file.');
    }
    ftruncate($tulis, $offset);
    fseek($tulis, $offset);
    stream_copy_to_stream($baca, $tulis);
    fclose($baca);
    fclose($tulis);

    clearstatcache(true, $part);
    $diterima = filesize($part);
    if ($diterima > $ukuran) {
        @unlink($part);
        return $this->_dn_doc_json(false, 'Upload size mismatch, please try again.');
    }
    if ($diterima < $ukuran) {
        return $this->_dn_doc_json(true, '', array('done' => false, 'received' => $diterima));
    }

    // Potongan terakhir - pindahkan ke folder final dengan nama acak.
    $folder = 'uploads/debitnote/' . date('Y') . '/' . date('m');
    if (!is_dir(FCPATH . $folder) && !@mkdir(FCPATH . $folder, 0755, true)) {
        return $this->_dn_doc_json(false, 'Upload folder is not writable.');
    }
    $nama   = (function_exists('random_bytes') ? bin2hex(random_bytes(16)) : md5(uniqid(mt_rand(), true))) . '.' . $ext;
    $tujuan = FCPATH . $folder . '/' . $nama;
    if (!@rename($part, $tujuan)) {
        @unlink($part);
        return $this->_dn_doc_json(false, 'Failed to store the file.');
    }

    $ok = $this->Model_nag->simpan_dn_doc(array(
        'id_dn'         => $id_dn,
        'no_dn'         => $no_dn,
        'original_name' => function_exists('mb_substr') ? mb_substr($nama_asli, 0, 255) : substr($nama_asli, 0, 255),
        'file_name'     => $nama,
        'file_path'     => $folder . '/' . $nama,
        'file_ext'      => $ext,
        'file_size'     => $ukuran,
        'mime_type'     => function_exists('mime_content_type') ? (@mime_content_type($tujuan) ?: null) : null,
        'uploaded_by'   => $this->session->userdata('username'),
        'uploaded_at'   => date('Y-m-d H:i:s'),
    ));
    if (!$ok) {
        @unlink($tujuan);
        return $this->_dn_doc_json(false, 'Failed to record the file.');
    }

    return $this->_dn_doc_json(true, '', array('done' => true, 'original_name' => $nama_asli));
}

private function _dn_doc_json($status, $pesan = '', $tambahan = array())
{
    echo json_encode(array_merge(array('status' => $status, 'message' => $pesan), $tambahan));
}

// Isi file dicek lewat byte awalnya (bukan cuma ekstensi), supaya file lain yang
// diganti ekstensinya tidak lolos. Yang boleh cuma PDF & gambar.
private function _dn_doc_isi_cocok($path, $ext)
{
    $awal = (string) @file_get_contents($path, false, null, 0, 1024);
    switch ($ext) {
        case 'pdf':
            return strpos($awal, '%PDF') !== false;
        case 'jpg':
        case 'jpeg':
            return strncmp($awal, "\xFF\xD8\xFF", 3) === 0;
        case 'png':
            return strncmp($awal, "\x89PNG", 4) === 0;
        case 'gif':
            return strncmp($awal, 'GIF87a', 6) === 0 || strncmp($awal, 'GIF89a', 6) === 0;
        case 'webp':
            return strncmp($awal, 'RIFF', 4) === 0 && substr($awal, 8, 4) === 'WEBP';
    }
    return false;
}

// Ukuran 1 potongan upload supporting document: 80% dari batas upload PHP
// (upload_max_filesize / post_max_size, mana yang lebih kecil), maksimal 8 MB,
// minimal 256 KB. Dikirim ke view create_debitnote.
private function _dn_doc_chunk_size()
{
    $batas = min($this->_ini_ke_byte(ini_get('upload_max_filesize')), $this->_ini_ke_byte(ini_get('post_max_size')));
    return (int) max(256 * 1024, min(8 * 1024 * 1024, $batas * 0.8));
}

// "40M" / "512K" / "1G" -> byte. 0 atau kosong = tidak dibatasi.
private function _ini_ke_byte($nilai)
{
    $nilai = trim((string) $nilai);
    $angka = (float) $nilai;
    switch (strtolower(substr($nilai, -1))) {
        case 'g':
            $angka *= 1024;
        case 'm':
            $angka *= 1024;
        case 'k':
            $angka *= 1024;
    }
    return $angka > 0 ? $angka : PHP_INT_MAX;
}

public function cari_alokasi($dt_dari_kwt, $dt_sampai_kwt, $customer)
{
    $data =  $this->Model_nag->cari_alokasi($dt_dari_kwt, $dt_sampai_kwt, $customer);
    echo json_encode($data);
}

public function cari_view_alokasi($no_kwt)
{
    $data =  $this->Model_nag->cari_view_alokasi($no_kwt);
    echo json_encode($data);
}

public function report_invoice5($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_alokasi'] = $this->Model_nag->report_alokasi($id);
    $data['data_alokasi_detail'] = $this->Model_nag->report_alokasi_detail($id);

    $html = $this->load->view('arnag/reportinvoice5', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

public function kartu_ar_global()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Summary Receivable';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/kartu_ar_global', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_kartu_ar($dt_dari_inv, $dt_sampai_inv, $id_customer)
{
    $data =  $this->Model_nag->cari_kartu_ar($dt_dari_inv, $dt_sampai_inv, $id_customer);
    echo json_encode($data);
}

public function export_excel_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus, $bln1, $bln2, $bln3, $bln4, $bln5, $bln6, $thn1, $thn2, $thn3, $thn4, $thn5, $thn6)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_kartu_ar2"] = $this->Model_nag->cari_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus);
    $data["periode_dari"] = $dt_dari_alk;
    $data["periode_sampai"] = $dt_sampai_alk;
    $data["bln1"] = $bln1;
    $data["bln2"] = $bln2;
    $data["bln3"] = $bln3;
    $data["bln4"] = $bln4;
    $data["bln5"] = $bln5;
    $data["bln6"] = $bln6;
    $data["thn1"] = $thn1;
    $data["thn2"] = $thn2;
    $data["thn3"] = $thn3;
    $data["thn4"] = $thn4;
    $data["thn5"] = $thn5;
    $data["thn6"] = $thn6;
    $this->load->view('arnag/export_kartu_ar2', $data);
}

    //ubah september
public function export_excel_mutasi_invoicedp($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_kartu_ar2"] = $this->Model_nag->cari_mutasi_invoice_dp($dt_dari_alk, $dt_sampai_alk, $id_cus);
    $data["periode_dari"] = $dt_dari_alk;
    $data["periode_sampai"] = $dt_sampai_alk;
    $this->load->view('arnag/export_mutasi_invoicedp', $data);
}

     //ubah september
public function export_excel_mutasi_debit_note($dt_dari_alk, $dt_sampai_alk, $id_cus, $bln1, $bln2, $bln3, $bln4, $bln5, $bln6, $thn1, $thn2, $thn3, $thn4, $thn5, $thn6)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_kartu_ar2"] = $this->Model_nag->cari_mutasi_debit_note($dt_dari_alk, $dt_sampai_alk, $id_cus);
    $data["periode_dari"] = $dt_dari_alk;
    $data["periode_sampai"] = $dt_sampai_alk;
    $data["bln1"] = $bln1;
    $data["bln2"] = $bln2;
    $data["bln3"] = $bln3;
    $data["bln4"] = $bln4;
    $data["bln5"] = $bln5;
    $data["bln6"] = $bln6;
    $data["thn1"] = $thn1;
    $data["thn2"] = $thn2;
    $data["thn3"] = $thn3;
    $data["thn4"] = $thn4;
    $data["thn5"] = $thn5;
    $data["thn6"] = $thn6;
    $this->load->view('arnag/export_mutasi_debit_note', $data);
}


public function kartu_ar_detail()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Kartu AR Detail';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/kartu_ar_detail', $data);
    $this->load->view('templates/footer', $data);
}

    //ubah september
public function frm_report_invoice_dpcbd()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Report Mutasi Invoice DP & CBD';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/frm_report_invoice_dpcbd', $data);
    $this->load->view('templates/footer', $data);
}

    //ubah september
public function frm_report_debit_note()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Report Mutasi Debit Note';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/frm_report_debit_note', $data);
    $this->load->view('templates/footer', $data);
}


public function cari_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    $data =  $this->Model_nag->cari_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus);
    echo json_encode($data);
}


    //ubah september
public function cari_mutasi_invoice_dp($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    $data =  $this->Model_nag->cari_mutasi_invoice_dp($dt_dari_alk, $dt_sampai_alk, $id_cus);
    echo json_encode($data);
}

    //ubah september
public function cari_mutasi_debit_note($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    $data =  $this->Model_nag->cari_mutasi_debit_note($dt_dari_alk, $dt_sampai_alk, $id_cus);
    echo json_encode($data);
}

public function approvalinvoice_manual()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Second Approval Invoice Manual';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/approvalinvoice_manual', $data);
    $this->load->view('templates/footer', $data);
}


public function cari_invoice_manual_post($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_invoice_manual_post($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

public function cari_invoice_manual_second_approv($dt_dari_inv, $dt_sampai_inv)
{
    $data = $this->Model_nag->cari_invoice_manual_second_approv($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

public function approve_invoice_manual()
{
    $id = $this->input->post('id_inv');
    $result = $this->Model_nag->approve_invoice_manual($id);
    $q = $this->db->query("SELECT no_inv FROM tbl_invoice_nb WHERE id = '$id'");
    $no_doc = ($q->row() && $q->row()->no_inv) ? $q->row()->no_inv : null;
    echo json_encode(['status' => (bool)$result, 'no_doc' => $no_doc]);
}

public function approve_invoice_manual_second()
{
    $id = $this->input->post('id_inv');
    $result = $this->Model_nag->approve_invoice_manual_second($id);
    $q = $this->db->query("SELECT no_inv FROM tbl_invoice_nb WHERE id = '$id'");
    $no_doc = ($q->row() && $q->row()->no_inv) ? $q->row()->no_inv : null;
    echo json_encode(['status' => (bool)$result, 'no_doc' => $no_doc]);
}

public function reverse_invoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Reverse Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/reverse_invoice', $data);
    $this->load->view('templates/footer', $data);
}


public function reverse_invoice_manual()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Reverse Invoice Manual';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/reverse_invoice_manual', $data);
    $this->load->view('templates/footer', $data);
}

public function reverse_kwitansi()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Reverse Kwitansi';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/reverse_kwitansi', $data);
    $this->load->view('templates/footer', $data);
}

public function reverse_alokasi()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Reverse Alokasi';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/reverse_alokasi', $data);
    $this->load->view('templates/footer', $data);
}


public function cari_invoice_appv($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_invoice_appv($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

public function reverseinvoice_manual()
{
    $id = $this->input->post('id_inv');
    $keter = $this->input->post('keter');
    $tgl_reverse = date('Y-m-d');
    $nama = $this->session->userdata('username');
    $activity = "Reverse Invoice Manual";

    $data = [

        'nama'          => $nama,
        'activity'      => $activity,
        'tanggal_input' => $tgl_reverse,
        'doc_number'    => $id,
        'tanggal_doc'   => $tgl_reverse,
        'keterangan'    => $keter

    ];
    $this->Model_nag->log_booking_invoice($data, 'tbl_log');
    $this->Model_nag->cancel_invoice_manual($id, $nama);


    redirect('arnag/listinvoice_manual');
}


public function rvs_invoice()
{
    $id = $this->input->post('id_inv');
    $keter = $this->input->post('keter');
    $tgl_reverse = date('Y-m-d');
    $nama = $this->session->userdata('username');
    $activity = "Reverse Invoice";

    $data = [

        'nama'          => $nama,
        'activity'      => $activity,
        'tanggal_input' => $tgl_reverse,
        'doc_number'    => $id,
        'tanggal_doc'   => $tgl_reverse,
        'keterangan'    => $keter

    ];
    $this->Model_nag->log_booking_invoice($data, 'tbl_log');
    $this->Model_nag->copy_invoice($id);
    $this->Model_nag->copy_pot($id);
    $this->Model_nag->copy_detail($id);
    $this->Model_nag->cancel_invoice($id);
    $this->Model_nag->delete_pot($id);
    $this->Model_nag->delete_detail($id);
    $this->Model_nag->update_bppb($id);
}


public function reverse_kwt()
{
 $id = $this->input->post('id_inv');
 $keter = $this->input->post('keter');
 $tgl_reverse = date('Y-m-d');
 $nama = $this->session->userdata('username');
 $activity = "Reverse Kwitansi";

 $data = [

    'nama'          => $nama,
    'activity'      => $activity,
    'tanggal_input' => $tgl_reverse,
    'doc_number'    => $id,
    'tanggal_doc'   => $tgl_reverse,
    'keterangan'    => $keter

];
$this->Model_nag->log_booking_invoice($data, 'tbl_log');
$this->Model_nag->cancel_kwitansi($id);
$this->Model_nag->update_inv_kwt($id);

redirect('arnag/kwitansi_ar');
}

public function rvs_alokasi()
{
    $id = $this->input->post('id_inv');
    $keter = $this->input->post('keter');
    $tgl_reverse = date('Y-m-d');
    $nama = $this->session->userdata('username');
    $activity = "Reverse Alokasi";

    $data = [

        'nama'          => $nama,
        'activity'      => $activity,
        'tanggal_input' => $tgl_reverse,
        'doc_number'    => $id,
        'tanggal_doc'   => $tgl_reverse,
        'keterangan'    => $keter

    ];
    $this->Model_nag->log_booking_invoice($data, 'tbl_log');
    $this->Model_nag->copy_alokasi($id);
    $this->Model_nag->copy_alokasi_detail($id);
    $this->Model_nag->copy_jurnal_alokasi($id);
    $this->Model_nag->delete_alokasi($id);
    $this->Model_nag->delete_jurnal_alokasi($id);
    $this->Model_nag->delete_alokasi_detail($id);
}

public function cari_invoice_manual_appv($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_invoice_manual_appv($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

public function cari_kwt_appv($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_kwt_appv($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

public function cari_alokasi_appv($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_alokasi_appv($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}


public function update_memo_h()
{
    $dn_number          = $this->input->post('dn_number');
    $nm_memo        = $this->input->post('nm_memo');
    $this->Model_nag->edit_memo_h($dn_number, $nm_memo);
}


public function cari_invoice_memo($dt_dari_memo, $dt_sampai_memo, $id_customer = '')
{
    $data =  $this->Model_nag->cari_invoice_memo($dt_dari_memo, $dt_sampai_memo, $id_customer);
    echo json_encode($data);
}

public function simpan_invoice_detail_memo()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_detail_memo($data);
    echo json_encode(array("status" => TRUE));
}

public function load_invoice_detail_memo()
{
        // $data['cost_center'] = $this->Model_nag->cari_cost();
    $data =  $this->Model_nag->load_invoice_detail_memo();
    echo json_encode($data);
}


public function delete_memo_temp()
{
    $this->Model_nag->delete_memo_temp();
}

public function update_memo_det()
{
    $dn_number          = $this->input->post('dn_number');
    $id_memodet         = $this->input->post('id_memo_det');
    $this->Model_nag->update_memo_det($dn_number, $id_memodet);
}


public function export_excel_list_dn($dt_dari_inv, $dt_sampai_inv, $id_customer)
{

    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_list_dn"] = $this->Model_nag->excel_debit_note($dt_dari_inv, $dt_sampai_inv, $id_customer);
    $data["periode_dari"] = $dt_dari_inv;
    $data["periode_sampai"] = $dt_sampai_inv;
    $this->load->view('arnag/export_list_dn', $data);
}


public function cari_dn_appv($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_dn_appv($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}


public function reverse_debitnote()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Reverse Debit Note';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/reverse_debitnote', $data);
    $this->load->view('templates/footer', $data);
}


public function reverse_dn()
{
 $id = $this->input->post('id_inv');
 $keter = $this->input->post('keter');
 $tgl_reverse = date('Y-m-d');
 $nama = $this->session->userdata('username');
 $activity = "Reverse Debitnote";

 $data = [

    'nama'          => $nama,
    'activity'      => $activity,
    'tanggal_input' => $tgl_reverse,
    'doc_number'    => $id,
    'tanggal_doc'   => $tgl_reverse,
    'keterangan'    => $keter

];
$this->Model_nag->log_booking_invoice($data, 'tbl_log');
$this->Model_nag->update_dn_h($id);
        // $this->Model_nag->update_status_memo($id);

redirect('arnag/reverse_debitnote');
}


public function cari_summary_ar($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    $data =  $this->Model_nag->cari_summary_ar($dt_dari_alk, $dt_sampai_alk, $id_cus);
    echo json_encode($data);
}

public function cari_summary_ar_new($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    $data =  $this->Model_nag->cari_summary_ar_new($dt_dari_alk, $dt_sampai_alk, $id_cus);
    echo json_encode($data);
}

public function cari_summary_dn($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    $data =  $this->Model_nag->cari_summary_dn($dt_dari_alk, $dt_sampai_alk, $id_cus);
    echo json_encode($data);
}

public function cari_summary_all($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    $data =  $this->Model_nag->cari_summary_all($dt_dari_alk, $dt_sampai_alk, $id_cus);
    echo json_encode($data);
}


public function export_excel_kartu_ar($dt_dari_inv, $dt_sampai_inv, $id_customer, $bln1, $bln2, $bln3, $bln4, $bln5, $bln6, $thn1, $thn2, $thn3, $thn4, $thn5, $thn6)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_sales"] = $this->Model_nag->cari_summary_ar_new($dt_dari_inv, $dt_sampai_inv, $id_customer);
    $data["data_debitnote"] = $this->Model_nag->cari_summary_dn($dt_dari_inv, $dt_sampai_inv, $id_customer);
    $data["periode_dari"] = $dt_dari_inv;
    $data["periode_sampai"] = $dt_sampai_inv;
    $data["bln1"] = $bln1;
    $data["bln2"] = $bln2;
    $data["bln3"] = $bln3;
    $data["bln4"] = $bln4;
    $data["bln5"] = $bln5;
    $data["bln6"] = $bln6;
    $data["thn1"] = $thn1;
    $data["thn2"] = $thn2;
    $data["thn3"] = $thn3;
    $data["thn4"] = $thn4;
    $data["thn5"] = $thn5;
    $data["thn6"] = $thn6;
    $this->load->view('arnag/export_kartu_ar', $data);
}


public function update_sj()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Update SJ Non - Commercial';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/update_sj', $data);
    $this->load->view('templates/footer', $data);
}


public function cari_sj_noncom($dt_dari_sj, $dt_sampai_sj)
{
    $data =  $this->Model_nag->cari_sj_noncom($dt_dari_sj, $dt_sampai_sj);
    echo json_encode($data);
}

public function update_nofg()
{
    $id = $this->input->post('id_bppb');
    $this->Model_nag->update_nofg($id);
}


public function frm_report_sj_not_invoice()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Report SJ Not Yet Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/frm_report_sj_not_invoice', $data);
    $this->load->view('templates/footer', $data);
}


public function export_sj_noncom2($dt_dari_sj, $dt_sampai_sj)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_sj_noncom"] = $this->Model_nag->cari_sj_noncom($dt_dari_sj, $dt_sampai_sj);
    $data["periode_dari_book"] = $dt_dari_sj;
    $data["periode_sampai_book"] = $dt_sampai_sj;
    $this->load->view('arnag/export_sj_noncom', $data);
}

public function update_req_dn()
{
    $dn_number          = $this->input->post('dn_number');
    $no_req        = $this->input->post('no_req');
    $this->Model_nag->update_req_dn($dn_number, $no_req);
}

public function cari_list_reqdn()
{
    $dn_number  = $this->input->post('dn_number');
    $no_req     = $this->input->post('no_req');
    $data =  $this->Model_nag->cari_list_reqdn($no_req);
    echo json_encode($data);
}

    // public function cari_list_reqdn($nomor_req)
    // {
    //     $data =  $this->Model_nag->cari_list_reqdn($nomor_req);
    //     echo json_encode($data);
    // }

public function getTopInvoice($id)
{
    $data = $this->Model_nag->getTopInvoice($id);
    $id_customer = $data->id_customer;
    $data2 =  $this->Model_nag->cari_top($id_customer);
    echo json_encode([
        'data' => $data,
        'top_options' => $data2
    ]);
}

// Rincian dokumen untuk modal detail di Projection Report. Nomor dikirim lewat
// query string karena mengandung "/".
public function invoice_detail_json()
{
    $no_invoice = $this->input->get('no_invoice');
    $data = $no_invoice ? $this->Model_nag->invoice_detail_lines($no_invoice) : null;

    if (!$data) {
        echo json_encode(array('status' => false, 'message' => 'Detail tidak ditemukan.'));
        return;
    }

    echo json_encode(array(
        'status' => true,
        'type'   => $data['type'],
        'lines'  => $data['lines'],
        'pot'    => $data['pot'],
        'dn'     => isset($data['dn']) ? $data['dn'] : null,
    ));
}


// Dipakai tombol "Buka PDF" di modal detail: terima NOMOR dokumen, lalu
// teruskan ke endpoint cetak PDF yang sesuai jenis dokumennya.
public function print_invoice_by_number()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $no_invoice = $this->input->get('no_invoice');
    $ref = $no_invoice ? $this->Model_nag->find_invoice_ref($no_invoice) : null;

    if (!$ref) {
        show_error('Detail untuk ' . html_escape($no_invoice) . ' tidak ditemukan.', 404, 'Tidak Ditemukan');
        return;
    }

    switch ($ref['type']) {
        case 'knitting':
            $this->print_invoice_knitting($ref['id']);
            return;

        case 'nb':
            $this->report_invoice4($ref['id']);
            return;

        case 'dn':
            if (!empty($ref['dn_memo'])) {
                $this->report_debit_note_memo($ref['id']);
            } else {
                $this->report_debit_note($ref['id']);
            }
            return;

        default:
            $this->report_invoice3($ref['id']);
            return;
    }
}


public function update_shipp_invoice()
{
    $id    = $this->input->post('id_inv');
    $shipp = $this->input->post('shipp');

    if (!$id || !in_array($shipp, ['Local', 'Export'], true)) {
        echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
        return;
    }

    $this->Model_nag->update_shipp_invoice($id, $shipp);

    echo json_encode(['status' => true, 'message' => 'Shipp berhasil diupdate']);
}


public function update_top_invoice()
{
    $id     = $this->input->post('id_book_inv');
    $id_top = $this->input->post('top_inv');
    $top_manual  = $this->input->post('top_manual');
    $id_customer = $this->input->post('id_customer');

    if (!$id || !$id_top) {
        echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
        return;
    }

    if ($top_manual && $id_customer) {
        $data_top = [
            'id_customer' => $id_customer,
            'type'        => 'TOP',
            'top'         => $top_manual,
            'status'      => 'Active'
        ];
        
        // Insert dan ambil id TOP baru
        $this->db->insert('tbl_master_top', $data_top);
        $id_top = $this->db->insert_id();
    }

    $this->Model_nag->update_top_invoice($id, $id_top);
    
    echo json_encode(['status' => true, 'message' => 'Berhasil update']);
}


public function update_invoice_h()
{

    $id             = $this->input->post('id_book_inv');
    $id_top         = $this->input->post('top_inv');
    $id_customer    = $this->input->post('id_customer');
    $type           = $this->input->post('type');
    $profit_center  = $this->input->post('profit_center');
    $id_bank        = $this->input->post('id_bank');
    $pph            = $this->input->post('pph');
    $type_so        = $this->input->post('type_so');
    $top_manual     = $this->input->post('top_manual');

    if (!$id || !$id_top) {
        echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
        return;
    }

    if ($top_manual) {
        $data_top = [
            'id_customer' => $id_customer,
            'type'        => 'TOP',
            'top'         => $top_manual,
            'status'      => 'Active'
        ];
        
        // Insert dan ambil id TOP baru
        $this->db->insert('tbl_master_top', $data_top);
        $id_top = $this->db->insert_id();
    }

    $this->Model_nag->update_invoice_h($id, $id_top, $id_customer, $type, $profit_center, $id_bank, $pph, $type_so);
    
    echo json_encode(['status' => true, 'message' => 'Berhasil update']);
}


public function edit_invoice($id = null) {
    if ($id === null) {
        show_404();
    }

    $data['tgl_invoice'] = $this->Model_nag->get_tgl_invoice_by_id($id);
    $data['invoice'] = $this->Model_nag->get_invoice_by_id($id);
    $data['invoice_pot'] = $this->Model_nag->get_invoice_pot_by_id($id);
    $data['invoice_det'] = $this->Model_nag->get_invoice_det_by_id($id);
    $id_customer = $data['invoice']['id_customer'];
    $data['top_options'] =  $this->Model_nag->cari_top($id_customer);
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['title'] = 'Form Edit Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['buyer'] = $this->Model_nag->cari_buyer();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    if (!$data['invoice']) {
        show_404();
    }

    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/edit_invoice', $data);
    $this->load->view('templates/footer', $data);
}

public function hapus_detail_invoice_edit() {
    $id_book_invoice = $this->input->post('id_book_invoice');

    if (empty($id_book_invoice)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'inv_number tidak boleh kosong'
        ]);
        return;
    }

    $inv_info = $this->Model_nag->getType($id_book_invoice);

    // Ambil daftar FG/OUT (id_bppb + shipp_number + so_number + product_item) dulu
    // sebelum detail-nya dihapus, biar bisa dicatat per baris di log & dicari nilai
    // lama/fallback-nya di bppb.
    $detail_rows = $this->db->query("
        SELECT DISTINCT id_bppb, shipp_number, so_number, product_item
        FROM tbl_invoice_detail WHERE id_book_invoice = '$id_book_invoice'
    ")->result();

    $old_map = [];
    $fallback_map = [];
    if (!empty($detail_rows) && $inv_info && $inv_info->profit_center === 'NAG') {
        $ids = array_map(function ($d) {
            return "'" . $d->id_bppb . "'";
        }, $detail_rows);
        $id_list = implode(',', $ids);
        $db_nag = $this->load->database('db_nag', TRUE);

        $bppb_rows = $db_nag->query("SELECT id, qty_invoice, price_invoice, total_invoice FROM bppb WHERE id IN ($id_list)")->result();
        foreach ($bppb_rows as $b) {
            $old_map[$b->id] = $b;
        }

        $fallback_rows = $db_nag->query("
            SELECT c.id AS id_bppb, c.qty, ROUND(b.price, 4) AS price
            FROM bppb c INNER JOIN so_det b ON b.id = c.id_so_det
            WHERE c.id IN ($id_list)
        ")->result();
        foreach ($fallback_rows as $f) {
            $fallback_map[$f->id_bppb] = $f;
        }
    }

    $detail_data = $this->db->get_where('tbl_invoice_detail', ['id_book_invoice' => $id_book_invoice])->result_array();
    if (!empty($detail_data)) {
        $this->db->insert_batch('tbl_invoice_detail_edit', $detail_data);
    }

    $pot_data = $this->db->get_where('tbl_invoice_pot', ['id_book_invoice' => $id_book_invoice])->result_array();
    if (!empty($pot_data)) {
        $this->db->insert_batch('tbl_invoice_pot_edit', $pot_data);
    }

    // Kosongkan bppb (stat_inv, id_invoice_ar, dan semua kolom invoice-tracking) buat
    // baris-baris yang detail invoice-nya dihapus.
    if (!empty($detail_rows)) {
        $db_nag = $this->load->database('db_nag', TRUE);
        foreach ($detail_rows as $d) {
            $db_nag->query("UPDATE bppb SET
                stat_inv = 0,
                id_invoice_ar = NULL,
                shipp_invoice = NULL,
                customer_invoice = NULL,
                qty_invoice = NULL,
                satuan_invoice = NULL,
                curr_invoice = NULL,
                price_invoice = NULL,
                total_invoice = NULL,
                price_other_invoice = NULL,
                total_other_invoice = NULL
                WHERE id = '{$d->id_bppb}'");
        }
    }

    $this->db->where('id_book_invoice', $id_book_invoice);
    $this->db->delete('tbl_invoice_detail');

    $this->db->where('id_book_invoice', $id_book_invoice);
    $this->db->delete('tbl_invoice_pot');

    // Simpan Log Perubahan Data (dashboard) - 1 baris per FG/OUT
    if ($inv_info && !empty($detail_rows)) {
        $created_by = $this->session->userdata('username');
        foreach ($detail_rows as $d) {
            $old   = isset($old_map[$d->id_bppb]) ? $old_map[$d->id_bppb] : null;
            $fb    = isset($fallback_map[$d->id_bppb]) ? $fallback_map[$d->id_bppb] : null;
            $qty_new   = $fb ? $fb->qty : null;
            $price_new = $fb ? $fb->price : null;
            $total_new = ($qty_new !== null && $price_new !== null) ? ($qty_new * $price_new) : null;

            $this->Model_nag->log_data_change($inv_info->no_invoice, 'bppb', 'Edit Invoice', $inv_info->profit_center, $created_by, 'price_invoice', [
                'qty_old'   => $old ? $old->qty_invoice : null,
                'qty_new'   => $qty_new,
                'price_old' => $old ? $old->price_invoice : null,
                'price_new' => $price_new,
                'total_old' => $old ? $old->total_invoice : null,
                'total_new' => $total_new,
            ], $d->shipp_number, $d->so_number, $d->product_item);
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Data berhasil diarsipkan dan dihapus'
    ]);
}

public function simpan_invoice_detail_pot_edit()
{
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $data_detail = $data['data_detail'];
    $data_pot    = $data['data_pot'];

    $created_by = $this->session->userdata('username');
    // Update bppb (stat_inv, id_invoice_ar, dan kolom invoice-tracking lainnya) +
    // log perubahan data sekarang ditangani di dalam simpan_invoice_detail_edit(),
    // sama seperti Create Invoice.
    $this->Model_nag->simpan_invoice_detail_edit($data_detail, $created_by);
    $this->Model_nag->simpan_invoice_pot_edit($data_pot);

    echo json_encode(array("status" => TRUE));
}


public function reverse_document()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Reverse Document';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['status'] = $this->Model_nag->cari_status();
    $data['user_cancel'] = $this->Model_nag->cari_usercancel($this->session->userdata('username'));
    $data['bank'] = $this->Model_nag->load_bank();
    $data['pilihan'] = $this->Model_nag->get_pilihan_reverse();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/list_reverse', $data);
    $this->load->view('templates/footer', $data);
}

public function create_reverse_document()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Create Reverse Document';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['cost_center'] = $this->Model_nag->cari_cost();
    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['coa'] = $this->Model_nag->cari_coa();
    $data['kode_reverse'] = $this->Model_nag->get_kode_reverse();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['pilihan'] = $this->Model_nag->get_pilihan_reverse();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/create_reverse', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_data_doc_reverse($dt_dari_doc, $dt_sampai_doc, $id_customer, $doc_type)
{
    $data =  $this->Model_nag->cari_data_doc_reverse($dt_dari_doc, $dt_sampai_doc, $id_customer, $doc_type);
    echo json_encode($data);
}

public function simpan_reverse_temp()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_reverse_temp($data);
    echo json_encode(array("status" => TRUE));
}

public function delete_data_doc_reverse()
{
    $this->Model_nag->delete_data_doc_reverse();
}

public function load_doc_reverse_temp()
{
        // $data['cost_center'] = $this->Model_nag->cari_cost();
    $data =  $this->Model_nag->load_doc_reverse_temp();
    echo json_encode($data);
}

public function simpan_data_reverse()
{
    $header = $this->input->post('header');
    $detail = $this->input->post('detail');

    $this->db->trans_begin();

    $data_h = [
        'rvs_number'    => $header['rvs_number'],
        'rvs_date'      => $header['rvs_date'],
        'type_doc'      => $header['type_doc'],
        'deskripsi'     => $header['rvs_deskripsi'],
        'status'        => 'DRAFT',
        'created_by'    => $this->session->userdata('username'),
        'created_date'  => date('Y-m-d H:i:s'),
        'approve_by'    => null,
        'approve_date'  => null,
        'cancel_by'     => null,
        'cancel_date'   => null
    ];

    $this->db->insert('tbl_reverse_h', $data_h);

    foreach ($detail as $dt) {
        $data_d = [
            'rvs_number'    => $header['rvs_number'],
            'doc_number'    => $dt['doc_number'],
            'doc_date'      => $dt['doc_date'],
            'id_customer'   => $dt['customer'],
            'curr'          => $dt['currency'],
            'total'         => $dt['total'],
            'deskripsi'     => $dt['descriptions'],
            'status'        => 'Y'
        ];
        $this->db->insert('tbl_reverse_det', $data_d);
    }

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        echo json_encode(['status' => false, 'message' => 'Gagal simpan data!']);
    } else {
        $this->db->trans_commit();
        echo json_encode(['status' => true, 'message' => 'Berhasil simpan data!']);
    }
}

public function cari_list_reverse($dt_dari_inv, $dt_sampai_inv, $doc_type)
{
    $data =  $this->Model_nag->cari_list_reverse($dt_dari_inv, $dt_sampai_inv, $doc_type);
    echo json_encode($data);
}

public function cari_detail_reverse($id)
{
    $data =  $this->Model_nag->cari_detail_reverse($id);
    echo json_encode($data);
}


public function pdf_reverse($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['reverse_header'] = $this->Model_nag->get_reverse_header($id);
    $data['reverse_detail'] = $this->Model_nag->cari_detail_reverse($id);

        //
    $html = $this->load->view('arnag/pdf_reverse', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

public function cancel_reverse_document()
{
    $rvs_number = $this->input->post('txt_cancel_book');
    $this->Model_nag->update_reverse_header($rvs_number);
    $this->Model_nag->update_reverse_detail($rvs_number);

    redirect('arnag/reverse_document');
}


public function approve_reverse_document()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Approve Reverse';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/approve_reverse', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_reverse_draft($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_reverse_draft($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

public function approve_doc_reverse()
{
    $id = $this->input->post('id_inv');
    $this->Model_nag->approve_doc_reverse($id);
}

public function cancel_doc_reverse()
{
    $id = $this->input->post('id_inv');
    $this->Model_nag->cancel_doc_reverse($id);
}


public function edit_debitnote($id = null) {
    if ($id === null) {
        show_404();
    }

    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Edit Debit Note';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['data_dn'] = $this->Model_nag->get_debitnote_by_id($id);
    if (!$data['data_dn']) {
        show_404();
    }

    // Isi DN hanya bisa diubah selagi status POST. Setelah first approve
    // halaman ini masih boleh dibuka, tapi cuma untuk mengurus lampiran -
    // sampai sebelum second approve (lihat Model_nag::dn_doc_bisa_diubah).
    $status_dn = $data['data_dn']['status'];
    if (!$this->Model_nag->dn_doc_bisa_diubah($status_dn)) {
        show_404();
    }
    $data['dn_hanya_dokumen'] = ($status_dn !== 'POST');
    $data['title'] = $data['dn_hanya_dokumen'] ? 'Supporting Documents' : 'Edit Debit Note';
    $data['data_dn_det'] = $this->Model_nag->get_debitnoteDet_by_id($id);
    $data['reff_dn'] = $this->Model_nag->get_reffDN_by_id($id);
    // Supporting document yang sudah tersimpan + ukuran potongan upload dokumen baru.
    $data['dn_docs'] = $this->Model_nag->get_dn_docs($id);
    $data['dn_doc_chunk'] = $this->_dn_doc_chunk_size();

    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['data_req'] = $this->Model_nag->cari_no_req();
    $data['nm_memo'] = $this->Model_nag->cari_nm_memo();
    $data['supplier'] = $this->Model_nag->cari_supplier();
    $data['bank'] = $this->Model_nag->get_bank();
    $data['cost_center'] = $this->Model_nag->cari_cost();
    $data['coa'] = $this->Model_nag->cari_coa();
    $data['kode_alokasi'] = $this->Model_nag->get_kode_debitnote();
    $data['rate'] = $this->Model_nag->get_rate();
    $data['kode_kwt'] = $this->Model_nag->get_kode_kwt();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
        // $data['nm_memo'] = $this->Model_nag->cari_nm_memo_temp();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    // if (!$data['invoice']) {
    //     show_404();
    // }

    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/edit_debitnote', $data);
    $this->load->view('templates/footer', $data);
}

// Simpan hasil Edit Debit Note: header + detail sekaligus dalam 1 transaksi
// (lihat Model_nag::update_debitnote). Balikan no_dn final - berubah kalau
// profit center diganti.
public function update_debitnote()
{
    if (!$this->session->userdata('username')) {
        echo json_encode(array('status' => false, 'message' => 'Session expired, please log in again.'));
        return;
    }

    // data_h / data_det dikirim sebagai JSON (DN dengan banyak baris bisa
    // melewati batas max_input_vars kalau dikirim sebagai array form).
    $header = json_decode((string) $this->input->post('data_h'), true);
    $baris  = json_decode((string) $this->input->post('data_det'), true);
    if (!is_array($header) || !is_array($baris)) {
        echo json_encode(array('status' => false, 'message' => 'Invalid data, please reload the page and try again.'));
        return;
    }

    $id_dn = (int) $this->input->post('id_dn');
    $lama  = $this->Model_nag->get_debitnote_by_id($id_dn);
    $hasil = $this->Model_nag->update_debitnote($id_dn, $header, $baris);

    if (!empty($hasil['status'])) {
        $keterangan = ($lama && $lama['no_dn'] !== $hasil['no_dn']) ? 'EDIT (old number ' . $lama['no_dn'] . ')' : 'EDIT';
        $this->log_booking_invoice('Edit Debit Note', $hasil['no_dn'], $keterangan);
    }
    echo json_encode($hasil);
}

// Buka supporting document yang sudah tersimpan. Folder uploads di-deny dari
// web, jadi file dikirim lewat sini setelah cek login - path-nya dipastikan
// tetap di dalam uploads/debitnote.
public function lihat_dn_doc($id = null)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $doc   = $id ? $this->Model_nag->get_dn_doc((int) $id) : null;
    $dasar = realpath(FCPATH . 'uploads/debitnote');
    $path  = $doc ? realpath(FCPATH . $doc['file_path']) : false;
    if (!$doc || !$dasar || !$path || strpos($path, $dasar . DIRECTORY_SEPARATOR) !== 0 || !is_file($path)) {
        show_404();
    }

    $tipe = array('pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'webp' => 'image/webp');
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if (!isset($tipe[$ext])) {
        show_404();
    }

    $nama = str_replace(array('"', "\r", "\n", '\\'), '', $doc['original_name']);
    while (ob_get_level()) {
        ob_end_clean();
    }
    header('Content-Type: ' . $tipe[$ext]);
    header('Content-Length: ' . filesize($path));
    header('Content-Disposition: inline; filename="' . $nama . '"; filename*=UTF-8\'\'' . rawurlencode($doc['original_name']));
    header('X-Content-Type-Options: nosniff');
    readfile($path);
    exit;
}

// Isi modal detail waktu nomor DN di List Debit Note diklik. Sengaja ringan:
// cuma data yang dipakai modal, tanpa merender PDF.
public function dn_detail_json($id = null)
{
    if (!$this->session->userdata('username')) {
        echo json_encode(array('status' => false, 'message' => 'Session expired, please log in again.'));
        return;
    }

    $data = $id ? $this->Model_nag->dn_detail((int) $id) : null;
    if (!$data) {
        echo json_encode(array('status' => false, 'message' => 'Debit note not found.'));
        return;
    }

    $h = $data['header'];
    $baris = array();
    foreach ($data['baris'] as $r) {
        $baris[] = array(
            'deskripsi' => $r['deskripsi'],
            'header1'   => isset($r['header1']) ? $r['header1'] : '',
            'header2'   => isset($r['header2']) ? $r['header2'] : '',
            'header3'   => isset($r['header3']) ? $r['header3'] : '',
            'header4'   => isset($r['header4']) ? $r['header4'] : '',
            'header5'   => isset($r['header5']) ? $r['header5'] : '',
            'value'     => $r['value'],
            'rate'      => $r['rate'],
            'amount'    => $r['amount'],
            'no_coa'    => $r['no_coa'],
            'nama_coa'  => isset($r['nama_coa']) ? $r['nama_coa'] : '',
            // Baris dari Memo / Request ditandai supaya kelihatan asalnya.
            'terkunci'  => $this->Model_nag->dn_baris_terkunci($r) ? 1 : 0,
        );
    }

    $lampiran = array();
    foreach ($data['lampiran'] as $d) {
        $lampiran[] = array(
            'id'     => (int) $d['id'],
            'nama'   => $d['original_name'],
            'ukuran' => (int) $d['file_size'],
            'url'    => base_url('arnag/lihat_dn_doc/' . (int) $d['id']),
        );
    }

    echo json_encode(array(
        'status' => true,
        'header' => array(
            'id'            => (int) $h['id'],
            'no_dn'         => $h['no_dn'],
            'tgl_dn'        => $h['tgl_dn'],
            'due_date'      => $h['due_date'],
            'status_dn'     => $h['status'],
            'consignee'     => $h['nama_customer'],
            'attn'          => $h['attn'],
            'alamat'        => $h['alamat'],
            'from_curr'     => $h['from_curr'],
            'to_curr'       => $h['to_curr'],
            'amount'        => $h['amount'],
            'eqv_curr'      => $h['eqv_curr'],
            'profit_center' => $h['profit_center'],
            'bank'          => trim((string) $h['bank_name'] . ' ' . (string) $h['no_rekening']),
            'sumber'        => !empty($data['sumber']['reff_doc'])
                ? $data['sumber']['text_reff_doc'] . ': ' . $data['sumber']['reff_doc']
                : 'Manual input',
            // Nama kolom tambahan - dipakai sebagai judul kolom di modal.
            'header1'       => isset($h['header1']) ? $h['header1'] : '',
            'header2'       => isset($h['header2']) ? $h['header2'] : '',
            'header3'       => isset($h['header3']) ? $h['header3'] : '',
            'header4'       => isset($h['header4']) ? $h['header4'] : '',
            'header5'       => isset($h['header5']) ? $h['header5'] : '',
        ),
        'baris'    => $baris,
        'lampiran' => $lampiran,
    ));
}
// Hapus 1 supporting document (dari halaman Edit Debit Note). Masih boleh
// selama DN belum second approve - aturannya di Model_nag::dn_doc_bisa_diubah.
public function hapus_dn_doc()
{
    if (!$this->session->userdata('username')) {
        return $this->_dn_doc_json(false, 'Session expired, please log in again.');
    }

    $doc = $this->Model_nag->get_dn_doc((int) $this->input->post('id'));
    if (!$doc) {
        return $this->_dn_doc_json(false, 'Document not found.');
    }

    $status_dn = $this->Model_nag->dn_doc_status_dn($doc['id_dn']);
    if (!$this->Model_nag->dn_doc_bisa_diubah($status_dn)) {
        return $this->_dn_doc_json(false, 'This debit note is already ' . strtolower((string) $status_dn) . ' - its documents can no longer be changed.');
    }

    $this->Model_nag->hapus_dn_doc($doc['id']);

    // File fisik dihapus setelah barisnya hilang, dan path-nya dipastikan
    // masih di dalam uploads/debitnote (sama seperti lihat_dn_doc).
    $dasar = realpath(FCPATH . 'uploads/debitnote');
    $file  = realpath(FCPATH . $doc['file_path']);
    if ($dasar && $file && strpos($file, $dasar . DIRECTORY_SEPARATOR) === 0 && is_file($file)) {
        @unlink($file);
    }

    $this->log_booking_invoice('Edit Debit Note', $doc['no_dn'], 'HAPUS DOKUMEN ' . $doc['original_name']);
    return $this->_dn_doc_json(true, 'Document removed.');
}

public function update_debitnote_h()
{

    $id_dn             = $this->input->post('id_dn');
    $dn_number         = $this->input->post('dn_number');
    $dn_number_old     = $this->input->post('dn_number_old');
    $dn_date           = $this->input->post('dn_date');
    $dn_duedate        = $this->input->post('dn_duedate');
    $customer          = $this->input->post('customer');
    $txt_attn          = $this->input->post('txt_attn');
    $alamat            = $this->input->post('alamat');
    $profit_center_dn  = $this->input->post('profit_center_dn');
    $akun              = $this->input->post('akun');
    $curr1             = $this->input->post('curr1');
    $curr2             = $this->input->post('curr2');
    $txt_header1       = $this->input->post('txt_header1');
    $txt_header2       = $this->input->post('txt_header2');
    $txt_header3       = $this->input->post('txt_header3');

    if (!$id_dn || !$dn_number) {
        echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
        return;
    }


    $this->Model_nag->update_debitnote_h($id_dn, $dn_number, $dn_number_old, $dn_date, $dn_duedate, $customer, $txt_attn, $alamat, $profit_center_dn, $akun, $curr1, $curr2, $txt_header1, $txt_header2, $txt_header3);
    
    echo json_encode(['status' => true, 'message' => 'Berhasil update']);
}

public function hapus_dn_det()
{
    $no_dn = $this->input->post('no_dn');

    if (!$no_dn) {
        echo json_encode(['status' => false, 'message' => 'No DN tidak valid']);
        return;
    }

    $sql_copy = "INSERT INTO tbl_debitnote_det_edit SELECT * FROM tbl_debitnote_det WHERE no_dn = ?";
    $this->db->query($sql_copy, [$no_dn]);

    $this->db->where('no_dn', $no_dn);
    $delete = $this->db->delete('tbl_debitnote_det');

    if ($delete) {
        echo json_encode(['status' => true, 'message' => 'Data berhasil disalin dan dihapus']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal menghapus data']);
    }
}


public function simpandn_det_total()
{

    $id_dn            = $this->input->post('id_dn');
    $dn_total         = $this->input->post('dn_total');
    $dn_total_eqv     = $this->input->post('dn_total_eqv');

    if (!$id_dn) {
        echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
        return;
    }


    $this->Model_nag->simpandn_det_total($id_dn, $dn_total, $dn_total_eqv);
    
    echo json_encode(['status' => true, 'message' => 'Berhasil update']);
}

public function master_other_charges()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //
    $kode_inv = "";
    $data['kode_book_invoice'] = $this->Model_nag->get_kode_book_invoice($kode_inv);
    $data['title'] = 'Master Other Charges';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['book_customer'] = $this->Model_nag->cari_customer();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/master_other_charges', $data);
    $this->load->view('templates/footer', $data);
}


public function simpan_other_charges()
{
    $nama_biaya = trim($this->input->post('nama_biaya'));

    $cek = $this->db->get_where('tbl_pilihan_ar', [
        'nama_pilihan' => $nama_biaya,
        'ctg_pilihan' => 'other charge invoice'
    ])->num_rows();

    if ($cek > 0) {
        echo json_encode(['status' => 'exists']);
    } else {
        $this->db->insert('tbl_pilihan_ar', [
            'kode_pilihan' => $nama_biaya,
            'nama_pilihan' => $nama_biaya,
            'ctg_pilihan' => 'other charge invoice',
            'status' => 'Y'
        ]);
        echo json_encode(['status' => 'success']);
    }
}

public function cari_list_other_charges($status)
{
    $data =  $this->Model_nag->cari_list_other_charges($status);
    echo json_encode($data);
}

public function ubah_status_other_charges($id)
{
    $cek = $this->db->get_where('tbl_pilihan_ar', ['id' => $id])->row();
    if ($cek) {
        $status_baru = ($cek->status == 'Y') ? 'N' : 'Y';

        $this->db->where('id', $id);
        $update = $this->db->update('tbl_pilihan_ar', ['status' => $status_baru]);

        if ($update) {
            echo json_encode([
                'status' => true,
                'message' => 'Status berhasil diubah ke ' . (($status_baru == 'Y') ? 'Aktif' : 'Nonaktif')
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Gagal mengubah status.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Data tidak ditemukan.'
        ]);
    }
}

public function hapus_other_charge($id)
{
    $cek = $this->db->get_where('tbl_pilihan_ar', ['id' => $id])->row();
    if ($cek) {
        $this->db->where('id', $id);
        $delete = $this->db->delete('tbl_pilihan_ar');

        if ($delete) {
            echo json_encode([
                'status' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Gagal menghapus data.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Data tidak ditemukan.'
        ]);
    }
}

public function export_list_other_charge($status)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_other_charge"] = $this->Model_nag->cari_list_other_charges($status);
    $this->load->view('arnag/export_master_other_charge', $data);
}

public function createinvoice_knitting()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Create Invoice Knitting';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['isi_pph'] = $this->Model_nag->get_pph_list();
    $data['buyer'] = $this->Model_nag->cari_buyer();
    $data['other_charge'] = $this->Model_nag->cari_other_charges();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/createinvoice_knitting', $data);
    $this->load->view('templates/footer', $data);
        //
    $this->delete_invoice_detail_temporary();
}

public function cari_book_inv_knitting($dt_dari, $dt_sampai)
{
    $data =  $this->Model_nag->cari_book_inv_knitting($dt_dari, $dt_sampai);
    echo json_encode($data);
}

public function cari_so_knitting($dt_dari_so, $dt_sampai_so, $id_customer, $buyer, $profit_center)
{
    $data =  $this->Model_nag->cari_so_knitting($dt_dari_so, $dt_sampai_so, $id_customer, $buyer, $profit_center);
    echo json_encode($data);
}

public function cari_sj_knitting($id_sj, $profit_center)
{
    $data =  $this->Model_nag->cari_sj_knitting($id_sj, $profit_center);
    echo json_encode($data);
}

public function simpan_invoice_detail_knitting_temporary()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_detail_knitting_temporary($data);
    echo json_encode(array("status" => TRUE));
}

public function load_invoice_detail_knitting_temporary()
{
    $data =  $this->Model_nag->load_invoice_detail_knitting_temporary();
    echo json_encode($data);
}

public function simpan_invoice_detail_knitting()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_detail_knitting($data);
    echo json_encode(array("status" => TRUE));
}

public function simpan_invoice_pot_knitting()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_invoice_pot_knitting($data);
    echo json_encode(array("status" => TRUE));
}

public function simpan_other_charge_invoice()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpan_other_charge_invoice($data);
    echo json_encode(array("status" => TRUE));
}

public function print_invoice_knitting($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_konsumen'] = $this->Model_nag->get_konsumen_invoice($id);
    $data['data_invoice'] = $this->Model_nag->report_invoice($id);
    $data['data_invoice_detail'] = $this->Model_nag->report_invoice_detail_knitting($id);
    $data['data_invoice_pot'] = $this->Model_nag->report_invoice_pot_knitting($id);
    $data['group_bppb_number'] = $this->Model_nag->group_bppb_number($id);
    $data['group_so_number'] = $this->Model_nag->group_so_number($id);
    $data['group_curr'] = $this->Model_nag->group_curr_knitting($id);
    $data['group_user'] = $this->Model_nag->group_user($id);

        //
    $html = $this->load->view('arnag/pdf_invoice_knitting', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

public function cari_kartu_ar_new($dt_dari_alk, $dt_sampai_alk, $id_cus)
{
    $data =  $this->Model_nag->cari_kartu_ar_new($dt_dari_alk, $dt_sampai_alk, $id_cus);
    echo json_encode($data);
}

public function export_kartu_ar_new($dt_dari_alk, $dt_sampai_alk, $id_cus, $bln1, $bln2, $bln3, $bln4, $bln5, $bln6, $thn1, $thn2, $thn3, $thn4, $thn5, $thn6)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //       
    $data["data_kartu_ar2"] = $this->Model_nag->cari_kartu_ar_new($dt_dari_alk, $dt_sampai_alk, $id_cus);
    $data["periode_dari"] = $dt_dari_alk;
    $data["periode_sampai"] = $dt_sampai_alk;
    $data["bln1"] = $bln1;
    $data["bln2"] = $bln2;
    $data["bln3"] = $bln3;
    $data["bln4"] = $bln4;
    $data["bln5"] = $bln5;
    $data["bln6"] = $bln6;
    $data["thn1"] = $thn1;
    $data["thn2"] = $thn2;
    $data["thn3"] = $thn3;
    $data["thn4"] = $thn4;
    $data["thn5"] = $thn5;
    $data["thn6"] = $thn6;
    $this->load->view('arnag/export_kartu_ar_new', $data);
}

public function cancel_alokasi()
{
    $id = $this->input->post('id_book_inv');
    $keter = "Cancel Alokasi";
    $tgl_reverse = date('Y-m-d');
    $nama = $this->session->userdata('username');
    $activity = "Cancel Alokasi";

    $data = [

        'nama'          => $nama,
        'activity'      => $activity,
        'tanggal_input' => $tgl_reverse,
        'doc_number'    => $id,
        'tanggal_doc'   => $tgl_reverse,
        'keterangan'    => $keter

    ];
    $this->Model_nag->log_booking_invoice($data, 'tbl_log');
    $this->Model_nag->copy_alokasi($id);
    $this->Model_nag->copy_alokasi_detail($id);
    $this->Model_nag->copy_jurnal_alokasi($id);
    $this->Model_nag->delete_alokasi($id);
    $this->Model_nag->delete_jurnal_alokasi($id);
    $this->Model_nag->delete_alokasi_detail($id);

    redirect('arnag/alokasi_ar');
}


public function list_duedate_update()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'List DueDate Update';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['bank'] = $this->Model_nag->load_bank();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));

        // $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/list_duedate_update', $data);
    $this->load->view('templates/footer', $data);
}

public function create_duedate_update()
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Form DueDate Update';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['customer'] = $this->Model_nag->cari_customer();
    $data['cost_center'] = $this->Model_nag->cari_cost();
    $data['profit_center'] = $this->Model_nag->cari_profit_center();
    $data['coa'] = $this->Model_nag->cari_coa();
    $data['kode_number'] = $this->Model_nag->get_kode_duedate_update();
    $data['type'] = $this->db->get('tbl_type')->result_array();
    $data['isi_bank'] = $this->Model_nag->load_bank();
    $data['pilihan'] = $this->Model_nag->get_pilihan_duedate_update();
    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result->tgl_awal != null) ? $result->tgl_awal : '';
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
    $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));


    $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
    $result = $query->row();
    $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/create_duedate_update', $data);
    $this->load->view('templates/footer', $data);
}

public function cari_data_reff_duedate($dt_dari_doc, $dt_sampai_doc, $id_customer, $doc_type)
{
    $data =  $this->Model_nag->cari_data_reff_duedate($dt_dari_doc, $dt_sampai_doc, $id_customer, $doc_type);
    echo json_encode($data);
}

public function simpan_duedate_temp()
{
    $data = $this->input->post('data_table');

    if (empty($data)) {
        echo json_encode([
            "status" => FALSE,
            "msg" => "Data kosong"
        ]);
        return;
    }

    $insert = $this->Model_nag->simpan_duedate_temp($data);

    if ($insert) {
        echo json_encode([
            "status" => TRUE
        ]);
    } else {
        echo json_encode([
            "status" => FALSE,
            "msg" => "Gagal insert ke database"
        ]);
    }
}

public function delete_data_reff_duedate($user)
{
    $this->Model_nag->delete_data_reff_duedate($user);
    echo json_encode(array("status" => TRUE));
}

public function load_doc_duedate_temp()
{
     $user = $this->session->userdata('username');
    $data =  $this->Model_nag->load_doc_duedate_temp($user);
    echo json_encode($data);
}


public function simpan_data_duedate()
{
    $header = $this->input->post('header');
    $detail = $this->input->post('detail');

    // Advisory lock — cegah 2 user generate nomor bersamaan (timeout 10 detik)
    $this->db->query("DO GET_LOCK('duedate_update_gen', 10)");

    // Generate nomor fresh saat save (bukan dari form) agar tidak bentrok
    $doc_number = $this->Model_nag->get_kode_duedate_update();

    $this->db->trans_begin();

    $data_h = [
        'doc_number'   => $doc_number,
        'duedate_update' => $header['duedate_update'],
        'keterangan'   => $header['keterangan'],
        'status'       => 'POST',
        'created_by'   => $this->session->userdata('username'),
        'created_date' => date('Y-m-d H:i:s'),
        'cancel_by'    => null,
        'cancel_date'  => null
    ];

    $this->db->insert('tbl_duedate_update_h', $data_h);

    foreach ($detail as $dt) {
        $data_d = [
            'doc_number'     => $doc_number,
            'no_invoice'     => $dt['no_invoice'],
            'duedate_update' => $header['duedate_update'],
            'curr'           => $dt['curr'],
            'amount'         => $dt['amount'],
            'keterangan'     => $dt['keterangan'],
            'status'         => 'Y'
        ];
        $this->db->insert('tbl_duedate_update_det', $data_d);
    }

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        $this->db->query("DO RELEASE_LOCK('duedate_update_gen')");
        echo json_encode(['status' => false, 'message' => 'Gagal simpan data!']);
    } else {
        $this->db->trans_commit();
        $this->db->query("DO RELEASE_LOCK('duedate_update_gen')");
        echo json_encode(['status' => true, 'message' => 'Berhasil simpan data!', 'doc_number' => $doc_number]);
    }
}

public function cari_list_duedate_update($dari = 'all', $sampai = 'all')
{
    $data = $this->Model_nag->cari_list_duedate_update($dari, $sampai);
    echo json_encode($data);
}

public function cari_detail_duedate_update($id)
{
    $data =  $this->Model_nag->cari_detail_duedate_update($id);
    echo json_encode($data);
}

public function cancel_duedate_update()
{
    $id = $this->input->post('id');
    $doc_number = $this->input->post('doc_number');

    // ambil user login (sesuaikan dengan session kamu)
    $user_cancel = $this->session->userdata('username');

    $result = $this->Model_nag->cancel_duedate_update($id, $doc_number, $user_cancel);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Document berhasil di cancel'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal cancel document'
        ]);
    }
}


    // =========================================================
    // FIRST APPROVE
    // =========================================================

    public function first_approvalinvoice()
    {
        if (!$this->session->userdata('username')) { redirect('auth'); }

        $data['title']               = 'First Approve Invoice';
        $data['profit_center']       = $this->Model_nag->cari_profit_center();
        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result->tgl_awal != null) ? $result->tgl_awal : '';
        $data['user']                = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['user_access_1']       = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2']       = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3']       = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4']       = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5']       = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6']       = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7']       = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse']   = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/first_approvalinvoice', $data);
        $this->load->view('templates/footer',  $data);
    }

    public function first_approvalinvoice_manual()
    {
        if (!$this->session->userdata('username')) { redirect('auth'); }

        $data['title']               = 'First Approve Invoice Manual';
        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result->tgl_awal != null) ? $result->tgl_awal : '';
        $data['user']                = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['user_access_1']       = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2']       = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3']       = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4']       = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5']       = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6']       = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7']       = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse']   = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/first_approvalinvoice_manual', $data);
        $this->load->view('templates/footer',  $data);
    }

    public function first_approval_proformainvoice()
    {
        if (!$this->session->userdata('username')) { redirect('auth'); }

        $data['title']               = 'First Approve Proforma Invoice';
        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result->tgl_awal != null) ? $result->tgl_awal : '';
        $data['user']                = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['user_access_1']       = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2']       = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3']       = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4']       = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5']       = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6']       = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7']       = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse']   = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/first_approval_proformainvoice', $data);
        $this->load->view('templates/footer',  $data);
    }

    public function first_approval_debitnote()
    {
        if (!$this->session->userdata('username')) { redirect('auth'); }

        $data['title']               = 'First Approve Debit Note';
        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result->tgl_awal != null) ? $result->tgl_awal : '';
        $data['profit_center']       = $this->Model_nag->cari_profit_center();
        $data['user']                = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['user_access_1']       = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2']       = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3']       = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4']       = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5']       = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6']       = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7']       = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse']   = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $this->load->view('templates/header',  $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/first_approval_debitnote', $data);
        $this->load->view('templates/footer',  $data);
    }

}
