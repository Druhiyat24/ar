<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landingpage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
    }

    // public function index()
    // {

    //     if (!$this->session->userdata('username')) {
    //         redirect('auth');
    //         log_message('error', 'Some variable did not contain a value.');

    //     }

    //     $data['selected_pc'] = $this->input->get('dsb_pc') ?? ''; // ambil dari query string GET
    //     $data['profit_center'] = $this->Model_nag->cari_profit_center();
    //     $data['title'] = 'Dashboard';
    //     $filter = '';
    //     $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
    //     $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
    //     $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
    //     $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
    //     $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
    //     $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
    //     $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
    //     $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
    //     $data['sls_ytd_inv']   = $this->Model_nag->cari_sls_ytd_inv() ? $this->Model_nag->cari_sls_ytd_inv() : null;
    //     $data['sls_cm_inv']   = $this->Model_nag->cari_sls_cm_inv() ? $this->Model_nag->cari_sls_cm_inv() : 0;
    //     $data['sls_no_inv']   = $this->Model_nag->cari_sls_no_inv() ? $this->Model_nag->cari_sls_no_inv() : 0;
    //     $data['sls_cm_no_inv']   = $this->Model_nag->cari_sls_cm_no_inv() ? $this->Model_nag->cari_sls_cm_no_inv() : 0;
    //     $data['ar_eqvidr']   = $this->Model_nag->cari_ar_eqvidr() ? $this->Model_nag->cari_ar_eqvidr() : 0;
    //     $data['ready_due']   = $this->Model_nag->cari_ready_due() ? $this->Model_nag->cari_ready_due() : 0;
    //     $data['ar_lokal']   = $this->Model_nag->cari_ar_lokal() ? $this->Model_nag->cari_ar_lokal() : 0;
    //     $data['ar_ekspor']   = $this->Model_nag->cari_ar_ekspor() ? $this->Model_nag->cari_ar_ekspor() : 0;
    //     $data['ar_lokal_ni']   = $this->Model_nag->cari_ar_lokal_ni() ? $this->Model_nag->cari_ar_lokal_ni() : 0;
    //     $data['ar_ekspor_ni']   = $this->Model_nag->cari_ar_ekspor_ni() ? $this->Model_nag->cari_ar_ekspor_ni() : 0;
    //     $data['ar_fob']   = $this->Model_nag->cari_ar_fob() ? $this->Model_nag->cari_ar_fob() : 0;
    //     $data['ar_cmt']   = $this->Model_nag->cari_ar_cmt() ? $this->Model_nag->cari_ar_cmt() : 0;
    //     $data['ar_fob_ni']   = $this->Model_nag->cari_ar_fob_ni() ? $this->Model_nag->cari_ar_fob_ni() : 0;
    //     $data['ar_cmt_ni']   = $this->Model_nag->cari_ar_cmt_ni() ? $this->Model_nag->cari_ar_cmt_ni() : 0;
    //     $data['filter_ar'] = $this->Model_nag->cari_filter_ar() ? $this->Model_nag->cari_filter_ar() : 0;
    //     $data['top_5_sales_name']   = $this->Model_nag->cari_top_5_sales_name() ? $this->Model_nag->cari_top_5_sales_name() : 0;
    //     $data['top_5_sales_val'] = $this->Model_nag->cari_top_5_sales_val() ? $this->Model_nag->cari_top_5_sales_val() : 0;
    //     $data['bulan_ar'] = $this->Model_nag->cari_bulan_ar() ? $this->Model_nag->cari_bulan_ar() : 0;
    //     $data['tahun_ar'] = $this->Model_nag->cari_tahun_ar() ? $this->Model_nag->cari_tahun_ar() : 0;
    //     $data['sales_ytd_mtm'] = $this->Model_nag->cari_sales_ytd_mtm() ? $this->Model_nag->cari_sales_ytd_mtm() : 0;
    //     $data['sales_ytd_mtm_bfr'] = $this->Model_nag->cari_sales_ytd_mtm_bfr() ? $this->Model_nag->cari_sales_ytd_mtm_bfr() : 0;
    //     $data['overdue_aging'] = $this->Model_nag->cari_overdue_aging() ? $this->Model_nag->cari_overdue_aging() : 0;
    //     $data['data_slsytd'] = $this->Model_nag->modal_caridata_slsytd() ? $this->Model_nag->modal_caridata_slsytd() : 0;
    //     $data['data_slscm'] = $this->Model_nag->modal_caridata_slscm() ? $this->Model_nag->modal_caridata_slscm() : 0;
    //     $data['data_slsytd2'] = $this->Model_nag->modal_caridata_slsytd2() ? $this->Model_nag->modal_caridata_slsytd2() : [];
    //     $data['data_slsni'] = $this->Model_nag->modal_caridata_slsni() ? $this->Model_nag->modal_caridata_slsni() : 0;
    //     $data['data_slscm2'] = $this->Model_nag->modal_caridata_slscm2() ? $this->Model_nag->modal_caridata_slscm2() : 0;

    //     $data['top_5_sales_name_01']   = $this->Model_nag->cari_top_5_sales_namefil('01','2025');
    //     $data['top_5_sales_val_01'] = $this->Model_nag->cari_top_5_sales_valfil('01','2025');
    //     $data['top_5_sales_name_02']   = $this->Model_nag->cari_top_5_sales_namefil('02','2025');
    //     $data['top_5_sales_val_02'] = $this->Model_nag->cari_top_5_sales_valfil('02','2025');
    //     $data['top_5_sales_name_03']   = $this->Model_nag->cari_top_5_sales_namefil('03','2025');
    //     $data['top_5_sales_val_03'] = $this->Model_nag->cari_top_5_sales_valfil('03','2025');
    //     $data['top_5_sales_name_04']   = $this->Model_nag->cari_top_5_sales_namefil('04','2025');
    //     $data['top_5_sales_val_04'] = $this->Model_nag->cari_top_5_sales_valfil('04','2025');
    //     $data['top_5_sales_name_05']   = $this->Model_nag->cari_top_5_sales_namefil('05','2025');
    //     $data['top_5_sales_val_05'] = $this->Model_nag->cari_top_5_sales_valfil('05','2025');
    //     $data['top_5_sales_name_06']   = $this->Model_nag->cari_top_5_sales_namefil('06','2025');
    //     $data['top_5_sales_val_06'] = $this->Model_nag->cari_top_5_sales_valfil('06','2025');
    //     $data['top_5_sales_name_07']   = $this->Model_nag->cari_top_5_sales_namefil('07','2025');
    //     $data['top_5_sales_val_07'] = $this->Model_nag->cari_top_5_sales_valfil('07','2025');
    //     $data['top_5_sales_name_08']   = $this->Model_nag->cari_top_5_sales_namefil('08','2025');
    //     $data['top_5_sales_val_08'] = $this->Model_nag->cari_top_5_sales_valfil('08','2025');
    //     $data['top_5_sales_name_09']   = $this->Model_nag->cari_top_5_sales_namefil('09','2025');
    //     $data['top_5_sales_val_09'] = $this->Model_nag->cari_top_5_sales_valfil('09','2025');
    //     $data['top_5_sales_name_10']   = $this->Model_nag->cari_top_5_sales_namefil('10','2025');
    //     $data['top_5_sales_val_10'] = $this->Model_nag->cari_top_5_sales_valfil('10','2025');
    //     $data['top_5_sales_name_11']   = $this->Model_nag->cari_top_5_sales_namefil('11','2025');
    //     $data['top_5_sales_val_11'] = $this->Model_nag->cari_top_5_sales_valfil('11','2025');
    //     $data['top_5_sales_name_12']   = $this->Model_nag->cari_top_5_sales_namefil('12','2025');
    //     $data['top_5_sales_val_12'] = $this->Model_nag->cari_top_5_sales_valfil('12','2025');

    //     $data['pred_week1']   = $this->Model_nag->cari_pred_week1();
    //     $data['pred_week2']   = $this->Model_nag->cari_pred_week2();
    //     $data['pred_week3']   = $this->Model_nag->cari_pred_week3();
    //     $data['pred_week4']   = $this->Model_nag->cari_pred_week4();
    //     $data['data_pred'] = $this->Model_nag->load_prediksi();

    //     $data['data_ttl_ar'] = $this->Model_nag->dsb_data_total_ar() ? $this->Model_nag->dsb_data_total_ar() : [];

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('landingpage/landingpage', $data);
    //     $this->load->view('templates/footer', $data);
    // }


    public function index()
    {
        if (!$this->session->userdata('username')) {
            redirect('auth');
            log_message('error', 'Some variable did not contain a value.');
        }

        // $data['selected_pc'] = $this->input->get('dsb_pc') ?? '';
        $data['profit_center'] = $this->Model_nag->cari_profit_center();
        // $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('userpassword', ['username' => $this->session->userdata('username')])->row_array();
        $data['user_access_1'] = $this->Model_nag->load_user_access_1($this->session->userdata('username'));
        $data['user_access_2'] = $this->Model_nag->load_user_access_2($this->session->userdata('username'));
        $data['user_access_3'] = $this->Model_nag->load_user_access_3($this->session->userdata('username'));
        $data['user_access_4'] = $this->Model_nag->load_user_access_4($this->session->userdata('username'));
        $data['user_access_5'] = $this->Model_nag->load_user_access_5($this->session->userdata('username'));
        $data['user_access_6'] = $this->Model_nag->load_user_access_6($this->session->userdata('username'));
        $data['user_access_7'] = $this->Model_nag->load_user_access_7($this->session->userdata('username'));
        $data['user_access_reverse'] = $this->Model_nag->load_user_access_reverse($this->session->userdata('username'));

        $filter = null;

        $selected_pc = $this->input->get('dsb_pc');

        if (!$selected_pc) {
            $pref = $this->db->get_where('user_dashboard_ar', [
                'username' => $this->session->userdata('username')
            ])->row();

            if ($pref && $pref->default_pc) {
                $selected_pc = $pref->default_pc;
            }
        }

        $data['selected_pc'] = $selected_pc ?? '';

        switch ($data['selected_pc']) {
            case 'NAG':
            $data['title'] = 'DASHBOARD PT. NIRWANA ALABARE GARMENT';
            $filter = 'NAG';
            break;

            case 'NAK':
            $data['title'] = 'DASHBOARD PT. NIRWANA ALABARE KNITTING';
            $filter = 'NAK';
            break;

            case 'ALL':
            $data['title'] = 'DASHBOARD ALL';
            $filter = 'ALL';
            break;

            default:
            $data['title'] = 'DASHBOARD';
        // Bisa juga $filter = null;
            break;
        }


        if ($filter) {
            $data['sls_ytd_inv'] = $this->Model_nag->cari_sls_ytd_inv($filter);
            $data['data_slsytd'] = $this->Model_nag->modal_caridata_slsytd($filter);
            $data['sls_cm_inv'] = $this->Model_nag->cari_sls_cm_inv($filter);
            $data['data_slscm'] = $this->Model_nag->modal_caridata_slscm($filter);
            $data['data_slsytd2'] = $this->Model_nag->modal_caridata_slsytd2($filter);
            $data['sls_no_inv'] = $this->Model_nag->cari_sls_no_inv($filter);
            $data['sls_cm_no_inv'] = $this->Model_nag->cari_sls_cm_no_inv($filter);
            $data['data_slscm2'] = $this->Model_nag->modal_caridata_slscm2($filter);
            $data['data_slsni'] = $this->Model_nag->modal_caridata_slsni($filter);
            $data['ar_eqvidr'] = $this->Model_nag->cari_ar_eqvidr($filter);
            $data['ready_due'] = $this->Model_nag->cari_ready_due($filter);
            $data['data_ttl_ar'] = $this->Model_nag->dsb_data_total_ar($filter);
            $data['ar_lokal'] = $this->Model_nag->cari_ar_lokal($filter);
            $data['ar_ekspor'] = $this->Model_nag->cari_ar_ekspor($filter);
            $data['ar_lokal_ni'] = $this->Model_nag->cari_ar_lokal_ni($filter);
            $data['ar_ekspor_ni'] = $this->Model_nag->cari_ar_ekspor_ni($filter);
            $data['ar_fob'] = $this->Model_nag->cari_ar_fob($filter);
            $data['ar_cmt'] = $this->Model_nag->cari_ar_cmt($filter);
            $data['ar_fob_ni'] = $this->Model_nag->cari_ar_fob_ni($filter);
            $data['ar_cmt_ni'] = $this->Model_nag->cari_ar_cmt_ni($filter);
            $data['filter_ar'] = $this->Model_nag->cari_filter_ar();
            $data['top_5_sales_name'] = $this->Model_nag->cari_top_5_sales_name($filter);
            $data['top_5_sales_val'] = $this->Model_nag->cari_top_5_sales_val($filter);
            $data['bulan_ar'] = $this->Model_nag->cari_bulan_ar();
            $data['tahun_ar'] = $this->Model_nag->cari_tahun_ar();
            $data['sales_ytd_mtm'] = $this->Model_nag->cari_sales_ytd_mtm($filter);
            $data['overdue_aging'] = $this->Model_nag->cari_overdue_aging($filter);

    // Data per bulan
            for ($i = 1; $i <= 12; $i++) {
                $bln = str_pad($i, 2, '0', STR_PAD_LEFT);
                $data["top_5_sales_name_$bln"] = $this->Model_nag->cari_top_5_sales_namefil($bln, '2025', $filter);
                $data["top_5_sales_val_$bln"] = $this->Model_nag->cari_top_5_sales_valfil($bln, '2025', $filter);
            }

    // Prediksi mingguan
            // $data['pred_week1'] = $this->Model_nag->cari_pred_week1();
            // $data['pred_week2'] = $this->Model_nag->cari_pred_week2();
            // $data['pred_week3'] = $this->Model_nag->cari_pred_week3();
            // $data['pred_week4'] = $this->Model_nag->cari_pred_week4();
            $data['data_pred'] = $this->Model_nag->load_prediksi($filter);
        }


    // Tetap load view
        if (!$selected_pc) {
            $data['title'] = 'DASHBOARD';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('landingpage/no_dashboard', $data);
            $this->load->view('templates/footer', $data);
        }else{

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('landingpage/landingpage', $data);
            $this->load->view('templates/footer', $data);
        }

        // $this->output->enable_profiler(TRUE);
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
        $filter = $this->input->post("selected_pc");
        $data['events'] = $this->Model_nag->load_det_overdue($field, $filter);
        $this->load->view('arnag/eventsinModal',$data);
    }

    public function load_det_sales5()
    {
        // $data['selected_pc'] = $this->input->get('dsb_pc') ?? '';
        // $filter = $data['selected_pc'];
        $customer = $this->input->post("event_id");
        $bulan = $this->input->post("bulan");
        $filter = $this->input->post("selected_pc");
        $data['events'] = $this->Model_nag->load_det_sales5($customer,$bulan, $filter);
        $this->load->view('arnag/datamodal_sales5',$data);
    }

    public function load_det_motm()
    {
        $bulan = $this->input->post("event_id");
        $filter = $this->input->post('selected_pc');
        $data['events'] = $this->Model_nag->load_det_motm($bulan, $filter);
        $this->load->view('arnag/datamodal_motm',$data);
    }

    public function load_det_motm_bfr()
    {
        $bulan = $this->input->post("event_id");
        $data['events'] = $this->Model_nag->load_det_motm_bfr($bulan);
        $this->load->view('arnag/datamodal_motm',$data);
    }

    public function cari_sales_data() {
    $year = $this->input->post('year'); // Tahun yang diterima dari request
    $filter = $this->input->post('selected_pc');
    $currentYear = date('Y'); // Tahun berjalan
    $data = [];

    // Periksa apakah tahun sama dengan tahun berjalan
    if ($year == $currentYear) {
        $data = $this->Model_nag->cari_sales_ytd_mtm_tahunini($filter);
    } elseif($year < $currentYear) {
        $data = $this->Model_nag->cari_sales_ytd_mtm_pertahun($year, $filter);
    }else{
        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }

    echo json_encode($data);
}

public function load_det_motm2()
{
    $bulan = $this->input->post("event_id");
    $year = $this->input->post("year");
    $currentYear = date('Y');

        // Periksa apakah tahun sama dengan tahun berjalan
    if ($year == $currentYear) {
        $data['events'] = $this->Model_nag->load_det_motm2($bulan, $year);
    } else{
        $data['events'] = $this->Model_nag->load_det_motm2_($bulan, $year);
    }

    $this->load->view('arnag/datamodal_motm',$data);
}




}
