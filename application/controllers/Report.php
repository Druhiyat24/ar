<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
        ini_set('memory_limit', '2048M');
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
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
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
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/report/frm_sales_report_material', $data);
        $this->load->view('templates/footer', $data);
    }

    public function frm_sales_report_detail_material()
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
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('arnag/report/frm_sales_report_detail_material', $data);
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
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result && $result->tgl_awal != null) ? $result->tgl_awal : '';
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
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    ini_set('display_errors', 0);

    if (ob_get_length()) {
        ob_end_clean();
    }
    ob_start();
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

    error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    ini_set('display_errors', 0);

    if (ob_get_length()) {
        ob_end_clean();
    }
    ob_start();

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
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    ini_set('display_errors', 0);

    if (ob_get_length()) {
        ob_end_clean();
    }
    ob_start();
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

        $data['title'] = 'Aging Piutang Dagang Bulanan';
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
        $this->load->view('arnag/report/aging_ar_jatem', $data);
        $this->load->view('templates/footer', $data);
    }


    public function cari_aging_jatem($id_customer, $start_date, $end_date)
    {
        $data =  $this->Model_report->cari_aging_jatem($id_customer, $start_date, $end_date);
        echo json_encode($data);
    }


    public function export_aging_jatem($id_customer, $start_date, $end_date)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    ini_set('display_errors', 0);

    if (ob_get_length()) {
        ob_end_clean();
    }
    ob_start();
        //       
        $data["periode_dari"] = $start_date;
        $data["periode_sampai"] = $end_date;
        $data["id_customer"] = $id_customer;
        $data["aging_jatem"] = $this->Model_report->cari_aging_jatem($id_customer, $start_date, $end_date);
        //
        $this->load->view('arnag/report/export_aging_jatem', $data);
    }


    public function mutasi_ar()
    {

        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Mutasi Piutang Dagang';
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
        $this->load->view('arnag/report/mutasi_ar', $data);
        $this->load->view('templates/footer', $data);
    }

    public function cari_mut_ar($id_customer, $start_date, $end_date)
    {
        $data =  $this->Model_report->cari_mut_ar($id_customer, $start_date, $end_date);
        echo json_encode($data);
    }


    public function export_mut_ar($id_customer, $start_date, $end_date)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    ini_set('display_errors', 0);

    if (ob_get_length()) {
        ob_end_clean();
    }
    ob_start();
        //       
        $data["periode_dari"] = $start_date;
        $data["periode_sampai"] = $end_date;
        $data["id_customer"] = $id_customer;
        $data["mut_ar"] = $this->Model_report->cari_mut_ar($id_customer, $start_date, $end_date);
        //
        $this->load->view('arnag/report/export_mut_ar', $data);
    }

    public function cari_sales_report_detail_material($dt_dari, $dt_sampai, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt)
    {
        $data =  $this->Model_report->sales_report_detail_material($dt_dari, $dt_sampai, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt);
        echo json_encode($data);
    }


    function export_sales_report_detail_material($periode_dari_mt, $periode_sampai_mt, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt)
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    ini_set('display_errors', 0);

    if (ob_get_length()) {
        ob_end_clean();
    }
    ob_start();
        //       
        $data["sales_report_material"] = $this->Model_report->sales_report_detail_material($periode_dari_mt, $periode_sampai_mt, $id_customer_mt, $shipp_mt, $type_mt, $curr_mt, $type_so_mt);
        $data["periode_dari_mt"] = $periode_dari_mt;
        $data["periode_sampai_mt"] = $periode_sampai_mt;
        $data["id_customer_mt"] = $id_customer_mt;
        $data["shipp_mt"] = $shipp_mt;
        $data["type_mt"] = $type_mt;
        $data["curr_mt"] = $curr_mt;
        $data["type_so_mt"] = $type_so_mt;
        //
        $this->load->view('arnag/report/export_sales_report_detail_material', $data);
    }


     public function projection_report()
    {

        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $data['title'] = 'Projection Report';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['customer'] = $this->Model_nag->cari_customer();
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
        $this->load->view('arnag/report/projection_report', $data);
        $this->load->view('templates/footer', $data);
    }


    public function cari_projection_report($id_customer, $dt_dari, $dt_sampai, $type = 'daily')
    {
        $data = $this->Model_report->cari_projection_report($id_customer, $dt_dari, $dt_sampai, $type);
        echo json_encode($data);
    }


public function export_projection_report($id_customer = '', $from = '', $to = '', $type = 'daily')
{
    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
    ini_set('display_errors', 0);

    if (ob_get_length()) {
        ob_end_clean();
    }
    ob_start();

    $data["projection"] = $this->Model_report
        ->cari_projection_report_export($id_customer, $from, $to, $type);

    $data["periode_dari_mt"]   = $from;
    $data["periode_sampai_mt"] = $to;

    $this->load->view(
        'arnag/report/export_projection_report',
        $data
    );
}


    public function save_history_projection_report($id_customer, $from, $to)
    {
        if (!$this->session->userdata('username')) {
            echo json_encode(['status' => 'error', 'message' => 'Session expired']);
            return;
        }

        $created_by = $this->session->userdata('username');
        $type       = $this->input->post('type') ?: 'daily';

        $doc_number = $this->Model_report->save_history_projection_report(
            $id_customer, $from, $to, $created_by, $type
        );

        if ($doc_number) {
            echo json_encode(['status' => 'success', 'doc_number' => $doc_number]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data to save']);
        }
    }


    // public function export_projection_report($id_customer = '', $from = '', $to = '')
    // {
    //     $this->load->library('excel');
    //     $data = $this->Model_report->cari_projection_report_export($id_customer, $from, $to);

    //     $excel = new PHPExcel();
    //     $sheet = $excel->setActiveSheetIndex(0);

    //     // =========================
    //     // HEADER FIX
    //     // =========================
    //     $headers = [
    //         'No','Customer','Reff Number','Reff Date','Category',
    //         'Due Date','Due Date Update','TOP','Curr',
    //         'Total','Rate','Total IDR'
    //     ];

    //     // =========================
    //     // GENERATE TANGGAL DINAMIS
    //     // =========================
    //     $start = strtotime($from);
    //     $end   = strtotime($to);

    //     $dates = [];
    //     while($start <= $end){
    //         $dates[] = date('j M Y', $start); // 1 Mar 2025
    //         $start = strtotime('+1 day', $start);
    //     }

    //     $headers = array_merge($headers, $dates);

    //     // =========================
    //     // TULIS HEADER
    //     // =========================
    //     $col = 0;
    //     foreach($headers as $h){
    //         $sheet->setCellValueByColumnAndRow($col, 1, $h);
    //         $col++;
    //     }

    //     // =========================
    //     // DATA
    //     // =========================
    //     $row = 2;
    //     $no  = 1;

    //     // reset lagi untuk looping data
    //     $start_loop = strtotime($from);
    //     $end_loop   = strtotime($to);

    //     foreach($data as $d){

    //         $col = 0;

    //         $sheet->setCellValueByColumnAndRow($col++, $row, $no++);
    //         $sheet->setCellValueByColumnAndRow($col++, $row, $d->customer);
    //         $sheet->setCellValueByColumnAndRow($col++, $row, $d->no_invoice);
    //         $sheet->setCellValueByColumnAndRow($col++, $row, date('j M Y', strtotime($d->inv_date)));
    //         $sheet->setCellValueByColumnAndRow($col++, $row, $d->shipp);
    //         $sheet->setCellValueByColumnAndRow($col++, $row, date('j M Y', strtotime($d->duedate)));
    //         $sheet->setCellValueByColumnAndRow($col++, $row, date('j M Y', strtotime($d->duedate_update)));
    //         $sheet->setCellValueByColumnAndRow($col++, $row, $d->top);
    //         $sheet->setCellValueByColumnAndRow($col++, $row, $d->curr);
    //         $sheet->setCellValueByColumnAndRow($col++, $row, $d->amount);
    //         $sheet->setCellValueByColumnAndRow($col++, $row, $d->rate);
    //         $sheet->setCellValueByColumnAndRow($col++, $row, $d->amount_idr);

    //         // =========================
    //         // KOLOM DINAMIS
    //         // =========================
    //         $i = 1;
    //         $start_loop = strtotime($from);

    //         while($start_loop <= $end_loop){

    //             $key = 'data'.$i;
    //             $val = isset($d->$key) ? $d->$key : 0;

    //             $sheet->setCellValueByColumnAndRow($col++, $row, $val);

    //             $start_loop = strtotime('+1 day', $start_loop);
    //             $i++;
    //         }

    //         $row++;
    //     }

    //     // =========================
    //     // AUTO WIDTH (BIAR RAPI)
    //     // =========================
    //     foreach(range('A','Z') as $c){
    //         $sheet->getColumnDimension($c)->setAutoSize(true);
    //     }

    //     // =========================
    //     // OUTPUT
    //     // =========================
    //     $filename = "projection_report_".date('Ymd_His').".xls";

    //     header('Content-Type: application/vnd.ms-excel');
    //     header("Content-Disposition: attachment;filename=\"$filename\"");
    //     header('Cache-Control: max-age=0');

    //     $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    //     $writer->save('php://output');
    // }


    // =========================================================
    // HISTORY PROJECTION REPORT
    // =========================================================

    public function history_projection_report()
    {
        if (!$this->session->userdata('username')) { redirect('auth'); }

        $data['title']              = 'History Projection Report';
        $data['user']               = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
         $query = $this->db->query("SELECT '2022-01-01' tgl_awal FROM tbl_closing_periode WHERE status_closing = 'Open' ORDER BY tgl_awal ASC LIMIT 1");
        $result = $query->row();
        $data['min_date'] = ($result->tgl_awal != null) ? $result->tgl_awal : '';
        $data['user_access_1']      = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2']      = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3']      = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4']      = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5']      = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6']      = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7']      = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse']   = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

        $this->load->view('templates/header',   $data);
        $this->load->view('templates/sidebar',  $data);
        $this->load->view('arnag/report/history_projection_report', $data);
        $this->load->view('templates/footer',   $data);
    }

    public function get_history_projection_list($from, $to)
    {
        $data = $this->Model_report->get_history_projection_list($from, $to);
        echo json_encode($data);
    }

    public function cancel_history_projection_report()
    {
        $doc_number = $this->input->post('doc_number');
        if (!$doc_number) {
            echo json_encode(['status' => 'error', 'message' => 'Doc number tidak valid.']);
            return;
        }
        $result = $this->Model_report->cancel_history_projection_report($doc_number);
        echo json_encode($result
            ? ['status' => 'success']
            : ['status' => 'error', 'message' => 'Gagal menghapus data.']
        );
    }

    public function get_history_projection_detail()
    {
        $doc_number = $this->input->post('doc_number');
        $data = $this->Model_report->get_history_projection_detail($doc_number);
        echo json_encode($data);
    }

    public function export_history_projection_excel()
    {
        if (!$this->session->userdata('username')) { redirect('auth'); }

        $doc_number = $this->input->get('doc_number');

        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        ini_set('display_errors', 0);

        if (ob_get_length()) { ob_end_clean(); }
        ob_start();

        $result = $this->Model_report->get_history_projection_detail($doc_number);
        $data['header']  = $result['header'];
        $data['detail']  = $result['detail'];

        $this->load->view('arnag/report/export_history_projection_excel', $data);
    }

    public function export_history_projection_pdf()
    {
        if (!$this->session->userdata('username')) { redirect('auth'); }

        $doc_number = $this->input->get('doc_number');
        $result = $this->Model_report->get_history_projection_detail($doc_number);
        $data['header'] = $result['header'];
        $data['detail'] = $result['detail'];

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'format' => 'A3']);
        $mpdf->SetTitle('Projection Report History - ' . $doc_number);

        $html = $this->load->view('arnag/report/export_history_projection_pdf', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('projection_history_' . $doc_number . '.pdf', 'I');
    }

}
