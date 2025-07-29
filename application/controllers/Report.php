<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
    }

    //Sales Report
    public function cari_sales_report($dt_dari, $dt_sampai, $id_customer, $shipp, $type, $curr, $type_so)
    {
        $data =  $this->Model_report->sales_report($dt_dari, $dt_sampai, $id_customer, $shipp, $type, $curr, $type_so);
        echo json_encode($data);
    }


    public function frm_sales_report()
    {

        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Report Ar';
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
        $this->load->view('arnag/report/frm_sales_report', $data);
        $this->load->view('templates/footer', $data);
    }

    public function sales_report($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'Legal']);
        $data["periode_dari"] = $periode_dari;
        $data["periode_sampai"] = $periode_sampai;
        $data["id_customer"] = $id_customer;
        $data["shipp"] = $shipp;
        $data["type"] = $type;
        $data["curr"] = $curr;
        $data["type_so"] = $type_so;
        $data["sales_report"] = $this->Model_report->sales_report($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so);
        $data["tot_unit"] = $this->Model_report->tot_unit($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so);
        //
        $html = $this->load->view('arnag/report/sales_report', $data, true);
        $mpdf->setFooter('{PAGENO} / {nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    //Sales Report Material
    public function cari_sales_report_material($dt_dari, $dt_sampai, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt)
    {
        $data =  $this->Model_report->sales_report_material($dt_dari, $dt_sampai, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt);
        echo json_encode($data);
    }

    public function frm_sales_report_material()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Report Ar';
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
        $this->load->view('arnag/report/frm_sales_report_material', $data);
        $this->load->view('templates/footer', $data);
    }

    public function sales_report_material($periode_dari_mt, $periode_sampai_mt, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'Legal']);
        $data["sales_report_material"] = $this->Model_report->sales_report_material($periode_dari_mt, $periode_sampai_mt, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt);
        $data["periode_dari_mt"] = $periode_dari_mt;
        $data["periode_sampai_mt"] = $periode_sampai_mt;
        $data["id_customer_mt"] = $id_customer_mt;
        $data["shipp_mt"] = $shipp_mt;
        $data["type_mt"] = $type_mt;
        $data["curr_mt"] = $curr_mt;
        $data["type_so_mt"] = $type_so_mt;
        //$data["tot_unit_material"] = $this->Model_report->tot_unit_material();
        //
        $html = $this->load->view('arnag/report/sales_report_material', $data, true);
        $mpdf->setFooter('{PAGENO} / {nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    //Report Outstanding PI
    public function cari_outstanding_pi($dt_dari_pi, $dt_sampai_pi)
    {
        $data =  $this->Model_report->report_outstanding_pi($dt_dari_pi, $dt_sampai_pi);
        echo json_encode($data);
    }

    public function frm_report_outstanding_pi()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Report Proforma Invoice';
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
        $this->load->view('arnag/report/frm_report_outstanding_pi', $data);
        $this->load->view('templates/footer', $data);
    }

    public function report_outstanding_pi($periode_dari_pi, $periode_sampai_pi)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'Legal']);
        $data["report_outstanding_pi"] = $this->Model_report->report_outstanding_pi($periode_dari_pi, $periode_sampai_pi);
        $data["periode_dari_pi"] = $periode_dari_pi;
        $data["periode_sampai_pi"] = $periode_sampai_pi;
        //
        $html = $this->load->view('arnag/report/report_outstanding_pi', $data, true);
        $mpdf->setFooter('{PAGENO} / {nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    //Export To Excel

    public function export_sales_report($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //       
        $data["periode_dari"] = $periode_dari;
        $data["periode_sampai"] = $periode_sampai;
        $data["id_customer"] = $id_customer;
        $data["shipp"] = $shipp;
        $data["type"] = $type;
        $data["curr"] = $curr;
        $data["type_so"] = $type_so;
        $data["sales_report"] = $this->Model_report->sales_report($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so);
        $data["tot_unit"] = $this->Model_report->tot_unit($periode_dari, $periode_sampai, $id_customer, $shipp, $type, $curr, $type_so);
        //
        $this->load->view('arnag/report/export_sales_report', $data);
    }

    function export_sales_report_material($periode_dari_mt, $periode_sampai_mt, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //       
        $data["sales_report_material"] = $this->Model_report->sales_report_material($periode_dari_mt, $periode_sampai_mt, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt);
        $data["periode_dari_mt"] = $periode_dari_mt;
        $data["periode_sampai_mt"] = $periode_sampai_mt;
        $data["id_customer_mt"] = $id_customer_mt;
        $data["shipp_mt"] = $shipp_mt;
        $data["type_mt"] = $type_mt;
        $data["curr_mt"] = $curr_mt;
        $data["type_so_mt"] = $type_so_mt;
        //
        $this->load->view('arnag/report/export_sales_report_material', $data);
    }

    function export_outstanding_pi($periode_dari_pi, $periode_sampai_pi)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        //       
        $data["report_outstanding_pi"] = $this->Model_report->report_outstanding_pi($periode_dari_pi, $periode_sampai_pi);
        $data["periode_dari_pi"] = $periode_dari_pi;
        $data["periode_sampai_pi"] = $periode_sampai_pi;
        //
        $this->load->view('arnag/report/export_outstanding_pi', $data);
    }

    public function aging_ar_jatem()
    {

        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'AGING PIUTANG DAGANG - BULANAN';
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
        $this->load->view('arnag/report/aging_ar_jatem', $data);
        $this->load->view('templates/footer', $data);
    }

}
