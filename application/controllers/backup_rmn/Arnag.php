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
        $data['book_customer'] = $this->Model_nag->cari_customer();
        $data['type'] = $this->db->get('tbl_type')->result_array();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));


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


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/create_kwitansi', $data);
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
                'doc_number'  => $this->input->post('type_doc_number')
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
        $this->Model_nag->edit_booking_invoice($id, $doc_number, $id_type, $doc_type, $amount);
        redirect('arnag/bookinvoice');
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
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));


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

    public function cari_top()
    {
        $id = $this->input->post('id_cust');
        $data =  $this->Model_nag->cari_top($id);
        echo json_encode($data);
    }

    public function cari_so($dt_dari_so, $dt_sampai_so, $id_customer)
    {
        $data =  $this->Model_nag->cari_so($dt_dari_so, $dt_sampai_so, $id_customer);
        echo json_encode($data);
    }

    public function cari_sj($id_sj)
    {
        $data =  $this->Model_nag->cari_sj($id_sj);
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
        $this->Model_nag->update_status_invoice($id_inv, $pph, $tanggal_input, $id_top, $id_bank, $type_so);
        // Simpan Log
        $activity   = "Create invoice";
        $doc_number = $no_inv;
        $status     = "POST";
        $this->log_booking_invoice($activity, $doc_number, $status);
        // End Simpan Log
        redirect('arnag/createinvoice');
    }

     function update_status_bppb()
    {
        $id = $this->input->post('id_bppb');
        $shipp = $this->input->post('no_invoice');
        $this->Model_nag->update_status_bppb($id, $shipp);
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
        $data['user_cancel'] = $this->Model_nag->cari_usercancel($this->session->userdata('username'));
        $data['bank'] = $this->Model_nag->load_bank();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/listinvoice', $data);
        $this->load->view('templates/footer', $data);
    }

    public function cari_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
    {
        $data =  $this->Model_nag->cari_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer);
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

    public function export_excel_list_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //       
        $data["data_list_invoice"] = $this->Model_nag->cari_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer);
        $data["periode_dari"] = $dt_dari_inv;
        $data["periode_sampai"] = $dt_sampai_inv;
        $this->load->view('arnag/export_list_invoice', $data);
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


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/approvalinvoice', $data);
        $this->load->view('templates/footer', $data);
    }

    public function cari_invoice_post($dt_dari_inv, $dt_sampai_inv)
    {
        $data =  $this->Model_nag->cari_invoice_post($dt_dari_inv, $dt_sampai_inv);
        echo json_encode($data);
    }

    public function approve_invoice()
    {
        $id = $this->input->post('id_inv');
        $this->Model_nag->approve_invoice($id);
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
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/proformainvoice', $data);
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

    public function cari_so_proforma($dt_dari_so_prof, $dt_sampai_so_prof, $id_customer)
    {
        $data =  $this->Model_nag->cari_so_proforma($dt_dari_so_prof, $dt_sampai_so_prof, $id_customer);
        echo json_encode($data);
    }

    public function simpan_invoice_detail_proforma_temporary()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->simpan_invoice_detail_proforma_temporary($data);
        echo json_encode(array("status" => TRUE));
    }

    public function load_invoice_detail_proforma_temporary()
    {
        $data =  $this->Model_nag->load_invoice_detail_proforma_temporary();
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

    public function simpan_proforma_invoice_header()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->simpan_proforma_invoice_header($data);
        echo json_encode(array("status" => TRUE));
    }

    public function simpan_proforma_invoice_detail()
    {
        $data = $this->input->post('data_table');
        $this->Model_nag->simpan_proforma_invoice_detail($data);
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

        //
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/listproformainvoice', $data);
        $this->load->view('templates/footer', $data);
    }

    public function cari_proforma_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer)
    {
        $data =  $this->Model_nag->cari_proforma_invoice($dt_dari_inv, $dt_sampai_inv, $id_customer);
        echo json_encode($data);
    }

    public function update_faktur_pajak()
    {

        $id          = $this->input->post('id_inv_prof');
        $faktur_pjk  = $this->input->post('no_paktur_pjk');
        $this->Model_nag->update_faktur_pajak($id, $faktur_pjk);
        redirect('arnag/listproformainvoice');
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
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));

        //
        $html = $this->load->view('arnag/reportproformainvoice', $data, true);
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
        $this->Model_nag->simpan_invoice_nb($data);
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

        $data['title'] = 'Kartu AR Global';
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

    public function export_excel_kartu_ar($dt_dari_inv, $dt_sampai_inv, $id_customer)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //       
        $data["data_kartu_ar"] = $this->Model_nag->cari_kartu_ar($dt_dari_inv, $dt_sampai_inv, $id_customer);
        $data["periode_dari"] = $dt_dari_inv;
        $data["periode_sampai"] = $dt_sampai_inv;
        $this->load->view('arnag/export_kartu_ar', $data);
    }

    public function export_excel_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //       
        $data["data_kartu_ar2"] = $this->Model_nag->cari_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus);
        $data["periode_dari"] = $dt_dari_alk;
        $data["periode_sampai"] = $dt_sampai_alk;
        $this->load->view('arnag/export_kartu_ar2', $data);
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


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/kartu_ar_detail', $data);
        $this->load->view('templates/footer', $data);
    }

    public function cari_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus)
    {
        $data =  $this->Model_nag->cari_kartu_ar2($dt_dari_alk, $dt_sampai_alk, $id_cus);
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
        $this->Model_nag->delete_alokasi($id);
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



}
