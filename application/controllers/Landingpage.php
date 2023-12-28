<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landingpage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
    }

    public function index()
    {

        if (!$this->session->userdata('username')) {
            redirect('auth');
            log_message('error', 'Some variable did not contain a value.');

        }

        $data['title'] = 'Dashboard';
        $filter = '';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['sls_ytd_inv']   = $this->Model_nag->cari_sls_ytd_inv();
        $data['sls_cm_inv']   = $this->Model_nag->cari_sls_cm_inv();
        $data['sls_no_inv']   = $this->Model_nag->cari_sls_no_inv();
        $data['sls_cm_no_inv']   = $this->Model_nag->cari_sls_cm_no_inv();
        $data['ar_eqvidr']   = $this->Model_nag->cari_ar_eqvidr();
        $data['ready_due']   = $this->Model_nag->cari_ready_due();
        $data['ar_lokal']   = $this->Model_nag->cari_ar_lokal();
        $data['ar_ekspor']   = $this->Model_nag->cari_ar_ekspor();
        $data['ar_lokal_ni']   = $this->Model_nag->cari_ar_lokal_ni();
        $data['ar_ekspor_ni']   = $this->Model_nag->cari_ar_ekspor_ni();
        $data['ar_fob']   = $this->Model_nag->cari_ar_fob();
        $data['ar_cmt']   = $this->Model_nag->cari_ar_cmt();
        $data['ar_fob_ni']   = $this->Model_nag->cari_ar_fob_ni();
        $data['ar_cmt_ni']   = $this->Model_nag->cari_ar_cmt_ni();
        $data['filter_ar'] = $this->Model_nag->cari_filter_ar();
        $data['top_5_sales_name']   = $this->Model_nag->cari_top_5_sales_name();
        $data['top_5_sales_val'] = $this->Model_nag->cari_top_5_sales_val();
        $data['bulan_ar'] = $this->Model_nag->cari_bulan_ar();
        $data['sales_ytd_mtm'] = $this->Model_nag->cari_sales_ytd_mtm();
        $data['overdue_aging'] = $this->Model_nag->cari_overdue_aging();
        $data['data_slsytd'] = $this->Model_nag->modal_caridata_slsytd();
        $data['data_slscm'] = $this->Model_nag->modal_caridata_slscm();
        $data['data_slsytd2'] = $this->Model_nag->modal_caridata_slsytd2();
        $data['data_slsni'] = $this->Model_nag->modal_caridata_slsni();
        $data['data_slscm2'] = $this->Model_nag->modal_caridata_slscm2();

        $data['top_5_sales_name_01']   = $this->Model_nag->cari_top_5_sales_namefil('01','2023');
        $data['top_5_sales_val_01'] = $this->Model_nag->cari_top_5_sales_valfil('01','2023');
        $data['top_5_sales_name_02']   = $this->Model_nag->cari_top_5_sales_namefil('02','2023');
        $data['top_5_sales_val_02'] = $this->Model_nag->cari_top_5_sales_valfil('02','2023');
        $data['top_5_sales_name_03']   = $this->Model_nag->cari_top_5_sales_namefil('03','2023');
        $data['top_5_sales_val_03'] = $this->Model_nag->cari_top_5_sales_valfil('03','2023');
        $data['top_5_sales_name_04']   = $this->Model_nag->cari_top_5_sales_namefil('04','2023');
        $data['top_5_sales_val_04'] = $this->Model_nag->cari_top_5_sales_valfil('04','2023');
        $data['top_5_sales_name_05']   = $this->Model_nag->cari_top_5_sales_namefil('05','2023');
        $data['top_5_sales_val_05'] = $this->Model_nag->cari_top_5_sales_valfil('05','2023');
        $data['top_5_sales_name_06']   = $this->Model_nag->cari_top_5_sales_namefil('06','2023');
        $data['top_5_sales_val_06'] = $this->Model_nag->cari_top_5_sales_valfil('06','2023');
        $data['top_5_sales_name_07']   = $this->Model_nag->cari_top_5_sales_namefil('07','2023');
        $data['top_5_sales_val_07'] = $this->Model_nag->cari_top_5_sales_valfil('07','2023');
        $data['top_5_sales_name_08']   = $this->Model_nag->cari_top_5_sales_namefil('08','2023');
        $data['top_5_sales_val_08'] = $this->Model_nag->cari_top_5_sales_valfil('08','2023');
        $data['top_5_sales_name_09']   = $this->Model_nag->cari_top_5_sales_namefil('09','2023');
        $data['top_5_sales_val_09'] = $this->Model_nag->cari_top_5_sales_valfil('09','2023');
        $data['top_5_sales_name_10']   = $this->Model_nag->cari_top_5_sales_namefil('10','2023');
        $data['top_5_sales_val_10'] = $this->Model_nag->cari_top_5_sales_valfil('10','2023');
        $data['top_5_sales_name_11']   = $this->Model_nag->cari_top_5_sales_namefil('11','2023');
        $data['top_5_sales_val_11'] = $this->Model_nag->cari_top_5_sales_valfil('11','2023');
        $data['top_5_sales_name_12']   = $this->Model_nag->cari_top_5_sales_namefil('12','2023');
        $data['top_5_sales_val_12'] = $this->Model_nag->cari_top_5_sales_valfil('12','2023');

        $data['pred_week1']   = $this->Model_nag->cari_pred_week1();
        $data['pred_week2']   = $this->Model_nag->cari_pred_week2();
        $data['pred_week3']   = $this->Model_nag->cari_pred_week3();
        $data['pred_week4']   = $this->Model_nag->cari_pred_week4();
        $data['data_pred'] = $this->Model_nag->load_prediksi();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('landingpage/landingpage', $data);
        $this->load->view('templates/footer', $data);
    }

    public function block_page()
    {
        $this->load->view('block_page/block_page');
    }

    public function load_det_overdue()
    {
        $event_id = $this->input->post("event_id");
        if ($event_id == 0) {
            $field = 'not_due';
            $data['judul'] = 'Not Due';
        }elseif($event_id == 1){
            $field = 'amt_aging_1';
            $data['judul'] = '1-30';
        }elseif($event_id == 2){
            $field = 'amt_aging_2';
            $data['judul'] = '31-60';
        }elseif($event_id == 3){
            $field = 'amt_aging_3';
            $data['judul'] = '61-90';
        }elseif($event_id == 4){
            $field = 'amt_aging_4';
            $data['judul'] = '91-120';
        }elseif($event_id == 5){
            $field = 'amt_aging_5';
            $data['judul'] = '121-180';
        }elseif($event_id == 6){
            $field = 'amt_aging_6';
            $data['judul'] = '181-360';
        }elseif($event_id == 7){
            $field = 'amt_aging_7';
            $data['judul'] = '>360';
        }else{

        }
        $data['events'] = $this->Model_nag->load_det_overdue($field);
        $this->load->view('arnag/eventsinModal',$data);
    }

    public function load_det_sales5()
    {
        $customer = $this->input->post("event_id");
        $bulan = $this->input->post("bulan");
        $data['events'] = $this->Model_nag->load_det_sales5($customer,$bulan);
        $this->load->view('arnag/datamodal_sales5',$data);
    }

    public function load_det_motm()
    {
        $bulan = $this->input->post("event_id");
        $data['events'] = $this->Model_nag->load_det_motm($bulan);
        $this->load->view('arnag/datamodal_motm',$data);
    }
}
