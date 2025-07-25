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
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));


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
        // $data['nm_memo'] = $this->Model_nag->cari_nm_memo_temp();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));


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
        $data = [
            'no_invoice'   => $this->input->post('id_inv'),
            'id_customer'  => $this->input->post('id_cust'),
            'shipp'        => $this->input->post('type_shipp'),
            'id_type'      => $this->input->post('type_comm'),
            'tgl_book_inv' => $date,
            'status'       => $status,
            'value'        => $this->input->post('type_val'),
            'doc_type'    => $this->input->post('type_doc'),
            'doc_number'  => $this->input->post('type_doc_number'),
            'profit_center'  => $this->input->post('mdl_pc')
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
    $this->Model_nag->update_bppb($id);
    $this->Model_nag->copy_invoice($id);
    $this->Model_nag->copy_pot($id);
    $this->Model_nag->copy_detail($id);
    $this->Model_nag->cancel_invoice($id);
    $this->Model_nag->delete_pot($id);
    $this->Model_nag->delete_detail($id);

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
    $profit_center     = $this->input->post('pc_mdl');
    $shipp     = $this->input->post('shipp_mdl');
    $this->Model_nag->edit_booking_invoice($id, $doc_number, $id_type, $doc_type, $amount, $no_invoice, $id_customer, $profit_center, $shipp);
    // redirect('arnag/bookinvoice');
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
    $data['buyer'] = $this->Model_nag->cari_buyer();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));


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
    $tanggal_input = date('Y-m-d');
    $id_top = $this->input->post('id_top');
    $id_bank = $this->input->post('id_bank');
    $type_so = $this->input->post('type_so');
    $no_coa = $this->input->post('no_coa_deb');
    $nama_coa = $this->input->post('nama_coa_deb');
    $this->Model_nag->update_status_invoice($id_inv, $pph, $tanggal_input, $id_top, $id_bank, $type_so, $no_coa, $nama_coa);
        // Simpan Log
    $activity   = "Create invoice";
    $doc_number = $no_inv;
    $status     = "POST";
    $this->log_booking_invoice($activity, $doc_number, $status);
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
    $this->Model_nag->simpan_invoice_detail($data);
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

    $data['title'] = 'Approval Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));


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

    $data['title'] = 'Approval Proforma Invoice';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));


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

    $data['title'] = 'Approval Debit Note';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/approval_debitnote', $data);
    $this->load->view('templates/footer', $data);
}    


public function cari_invoice_post($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_invoice_post($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

    //ubah september
public function cari_proforma_invoice_post($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_proforma_invoice_post($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

    //ubah september
public function cari_debitnote_post($dt_dari_inv, $dt_sampai_inv)
{
    $data =  $this->Model_nag->cari_debitnote_post($dt_dari_inv, $dt_sampai_inv);
    echo json_encode($data);
}

public function approve_invoice()
{
    $id = $this->input->post('id_inv');
    $this->Model_nag->approve_invoice($id);
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
    $this->Model_nag->approve_debitnote($id);
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

        //
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

        //
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

        //
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

        //
    $html = $this->load->view('arnag/reportproformainvoicedpcbd', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}


    //ubah september
public function report_debit_note($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_debit_note'] = $this->Model_nag->report_debit_note($id);
    $data['data_debit_note_det'] = $this->Model_nag->report_debit_note_det($id);
    $data['data_debit_note_det2'] = $this->Model_nag->report_debit_note_det2($id);
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

        //
    $html = $this->load->view('arnag/reportdebitnote', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}

    //ubah september
public function report_debit_note_memo($id)
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }
        //   
    $mpdf = new \Mpdf\Mpdf();
    $data['data_debit_note'] = $this->Model_nag->report_debit_note($id);
    $data['data_debit_note_det'] = $this->Model_nag->report_debit_note_det($id);
    $data['data_debit_note_det2'] = $this->Model_nag->report_debit_note_det_memo($id);
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

        //
    $html = $this->load->view('arnag/reportdebitnote_memo', $data, true);
    $mpdf->setFooter('{PAGENO} / {nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
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

        //
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
public function cancel_debnote()
{
    $id = $this->input->post('id_debnote');
    $this->Model_nag->cancel_debnote($id);
    $this->Model_nag->update_status_memo($id);
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
public function ubahnomor_dn($kode)
{ 
    $data = $this->Model_nag->ubahnomor_dn($kode);
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
    $this->Model_nag->simpan_invoice_nb_detail($data);
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
    $this->Model_nag->cancel_invoice_nb($id);


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
    $data['isi_bank'] = $this->Model_nag->load_bank();
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


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/createinvoice_manual', $data);
    $this->load->view('templates/footer', $data);
        //
        // $this->delete_invoice_detail_temporary();
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
    $data['cost_center'] = $this->Model_nag->cari_cost();
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
    $this->Model_nag->simpandn_det($data);
    echo json_encode(array("status" => TRUE));
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
public function simpandn_h()
{
    $data = $this->input->post('data_table');
    $this->Model_nag->simpandn_h($data);
    $activity   = "Create Debit Note";
    $doc_number = $this->input->post('no_dn');
    $status     = "POST";
    $this->log_booking_invoice($activity, $doc_number, $status);
    echo json_encode(array("status" => TRUE));
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

    $data['title'] = 'Approval Invoice Manual';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));


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

public function approve_invoice_manual()
{
    $id = $this->input->post('id_inv');
    $this->Model_nag->approve_invoice_manual($id);
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
    $this->Model_nag->cancel_invoice_manual($id);


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


public function cari_invoice_memo($dt_dari_memo, $dt_sampai_memo, $id_customer)
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
    $data["data_sales"] = $this->Model_nag->cari_summary_ar($dt_dari_inv, $dt_sampai_inv, $id_customer);
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


    if (!$data['invoice']) {
        show_404();
    }

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

    $detail_data = $this->db->get_where('tbl_invoice_detail', ['id_book_invoice' => $id_book_invoice])->result_array();
    if (!empty($detail_data)) {
        $this->db->insert_batch('tbl_invoice_detail_edit', $detail_data);
    }

    $pot_data = $this->db->get_where('tbl_invoice_pot', ['id_book_invoice' => $id_book_invoice])->result_array();
    if (!empty($pot_data)) {
        $this->db->insert_batch('tbl_invoice_pot_edit', $pot_data);
    }

    $sql_update_bppb = "
    UPDATE bppb a
    INNER JOIN tbl_invoice_detail b ON b.id_bppb = a.id
    SET a.stat_inv = 0,
    a.id_invoice_ar = NULL
    WHERE b.id_book_invoice = ?
    ";
    $this->db->query($sql_update_bppb, [$id_book_invoice]);

    $this->db->where('id_book_invoice', $id_book_invoice);
    $this->db->delete('tbl_invoice_detail');

    $this->db->where('id_book_invoice', $id_book_invoice);
    $this->db->delete('tbl_invoice_pot');

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

    $this->Model_nag->simpan_invoice_detail_edit($data_detail);
    $this->Model_nag->simpan_invoice_pot_edit($data_pot);

    $id_bppb_list = array_column($data_detail, 'id_bppb');
    $id_book_invoice_list = array_column($data_detail, 'id_book_invoice');

    $id_book_invoice = $id_book_invoice_list[0] ?? null;

    if (!empty($id_bppb_list) && $id_book_invoice) {
        $update_data = [
            'stat_inv' => '1',
            'id_invoice_ar' => $id_book_invoice
        ];

        $this->db->where_in('id', $id_bppb_list);
        $this->db->update('bppb', $update_data);
    }


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


public function edit_debitnote($id = null) {
    if ($id === null) {
        show_404();
    }

    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    $data['title'] = 'Form Edit Debit Note';
    $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    $data['data_dn'] = $this->Model_nag->get_debitnote_by_id($id);
    $data['data_dn_det'] = $this->Model_nag->get_debitnoteDet_by_id($id);
    $data['reff_dn'] = $this->Model_nag->get_reffDN_by_id($id);

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


    // if (!$data['invoice']) {
    //     show_404();
    // }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('arnag/edit_debitnote', $data);
    $this->load->view('templates/footer', $data);
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
    $data['buyer'] = $this->Model_nag->cari_buyer();
    $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));


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

}
