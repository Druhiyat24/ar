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
        $data['user_access_corporate'] = $this->Model_nag->load_user_corporate_report($this->session->userdata('username'));

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


        // Default values for chart variables (overridden below when filter is set)
        $data['ar_lokal'] = 0; $data['ar_ekspor'] = 0;
        $data['ar_lokal_ni'] = 0; $data['ar_ekspor_ni'] = 0;
        $data['ar_fob'] = 0; $data['ar_cmt'] = 0;
        $data['ar_fob_ni'] = 0; $data['ar_cmt_ni'] = 0;

        if ($filter) {
            // Scalar KPI dari ar_dashboard
            $data['sls_ytd_inv']   = $this->Model_nag->dsb_ar_total('sales_ytd_invoiced',    'total',           $filter);
            $data['sls_cm_inv']    = $this->Model_nag->dsb_ar_total('sales_cm_invoiced',     'total',           $filter);
            $data['sls_no_inv']    = $this->Model_nag->dsb_ar_total('sales_ytd_not_invoiced','total',           $filter);
            $data['sls_cm_no_inv'] = $this->Model_nag->dsb_ar_total('sales_cm_not_invoiced', 'total',           $filter);
            $data['ar_eqvidr']     = $this->Model_nag->dsb_ar_total('receivable',            'total_idr',       $filter);
            $data['ready_due']     = $this->Model_nag->dsb_ar_total('receivable',            'total_ready_due', $filter);

            // Chart: Sales Value By Destination & By Order Type — dari ar_dashboard
            $data['ar_lokal']     = $this->Model_nag->dsb_ar_total('ar_lokal',     'total', $filter);
            $data['ar_ekspor']    = $this->Model_nag->dsb_ar_total('ar_ekspor',    'total', $filter);
            $data['ar_lokal_ni']  = $this->Model_nag->dsb_ar_total('ar_lokal_ni',  'total', $filter);
            $data['ar_ekspor_ni'] = $this->Model_nag->dsb_ar_total('ar_ekspor_ni', 'total', $filter);
            $data['ar_fob']       = $this->Model_nag->dsb_ar_total('ar_fob',       'total', $filter);
            $data['ar_cmt']       = $this->Model_nag->dsb_ar_total('ar_cmt',       'total', $filter);
            $data['ar_fob_ni']    = $this->Model_nag->dsb_ar_total('ar_fob_ni',    'total', $filter);
            $data['ar_cmt_ni']    = $this->Model_nag->dsb_ar_total('ar_cmt_ni',    'total', $filter);

            // Modal detail dari ar_dashboard
            $data['data_slsytd']  = $this->Model_nag->dsb_ar_detail_sales('sales_ytd_invoiced',    $filter) ?: [];
            $data['data_slscm']   = $this->Model_nag->dsb_ar_detail_sales('sales_cm_invoiced',     $filter) ?: [];
            $data['data_slsni']   = $this->Model_nag->dsb_ar_detail_sales('sales_ytd_not_invoiced',$filter) ?: [];
            $data['data_slsytd2'] = $this->Model_nag->dsb_ar_detail_combined('sales_ytd_invoiced','sales_ytd_not_invoiced',$filter) ?: [];
            $data['data_slscm2']  = $this->Model_nag->dsb_ar_detail_combined('sales_cm_invoiced','sales_cm_not_invoiced',  $filter) ?: [];
            $data['data_ttl_ar']  = $this->Model_nag->dsb_ar_detail_receivable($filter) ?: [];

            $data['bulan_ar']     = $this->Model_nag->cari_bulan_ar()  ?? 0;
            $data['tahun_ar']     = $this->Model_nag->cari_tahun_ar()  ?? 0;
            $data['filter_ar']    = $this->Model_nag->cari_filter_ar() ?: [];
            $data['top_5_sales_name'] = $this->Model_nag->cari_top_5_sales_name($filter) ?: [];
            $data['top_5_sales_val']  = $this->Model_nag->cari_top_5_sales_val($filter)  ?: [];
            $data['sales_ytd_mtm']    = $this->Model_nag->cari_sales_ytd_mtm($filter) ?: [];
            $data['overdue_aging']    = $this->Model_nag->cari_overdue_aging($filter)  ?: [];

            $tahun_ini = date('Y');
            for ($i = 1; $i <= 12; $i++) {
                $bln = str_pad($i, 2, '0', STR_PAD_LEFT);
                $data["top_5_sales_name_$bln"] = $this->Model_nag->cari_top_5_sales_namefil($bln, $tahun_ini, $filter);
                $data["top_5_sales_val_$bln"]  = $this->Model_nag->cari_top_5_sales_valfil($bln, $tahun_ini, $filter);
            }

            $data['data_pred'] = $this->Model_nag->load_prediksi($filter);
        }

        // Cek akses tombol Refresh Dashboard
        $data['can_refresh'] = (bool) $this->db->query("
            SELECT COUNT(*) AS cnt FROM tbl_user_role a
            INNER JOIN tbl_user_access b ON a.id = b.menu_id
            WHERE b.user = '{$this->session->userdata('username')}'
            AND a.menu_status = 'dsb_refresh' AND a.status = 'Y'
        ")->row()->cnt;

        // Last update dari ar_dashboard
        $data['last_update'] = $this->Model_nag->dsb_ar_last_update();

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


    public function refresh_dashboard()
    {
        if (!$this->session->userdata('username')) {
            echo json_encode(['status' => false, 'message' => 'Unauthorized']); return;
        }

        // Validasi akses role
        $allowed = $this->db->query("
            SELECT COUNT(*) AS cnt FROM tbl_user_role a
            INNER JOIN tbl_user_access b ON a.id = b.menu_id
            WHERE b.user = '{$this->session->userdata('username')}'
            AND a.menu_status = 'dsb_refresh' AND a.status = 'Y'
        ")->row()->cnt;
        if (!$allowed) {
            echo json_encode(['status' => false, 'message' => 'Akses ditolak']); return;
        }

        // $procedures = [
        //     'get_data_sales', 'get_data_sum_ar', 'get_data_ar',
        //     'get_data_sum_ar_knitting', 'get_data_prediction', 'update_invoice',
        //     'get_data_overdue_knitting', 'get_data_ar_knitting',
        //     'get_data_prediction_knitting', 'get_data_sales_knitting',
        //     'get_data_dsb_ar', 'get_data_overdue', 'get_data_dsb_ar_modal'
        // ];

        $procedures = [
            'ar_get_data_dashboard'
        ];

        $failed  = [];
        $success = [];
        foreach ($procedures as $proc) {
            try {
                $this->db->query("CALL {$proc}()");
                $success[] = $proc;
            } catch (Exception $e) {
                $failed[] = $proc . ': ' . $e->getMessage();
            }
        }

        // Simpan timestamp refresh ke tbl_kpi_cache
        $last_update = date('Y-m-d H:i:s');
        $this->db->query("INSERT INTO tbl_kpi_cache (pc, key_name, value, updated_at)
            VALUES ('ALL', '_last_refresh', 0, NOW())
            ON DUPLICATE KEY UPDATE value = 0, updated_at = NOW()");

        echo json_encode([
            'status'      => empty($failed),
            'success'     => $success,
            'failed'      => $failed,
            'last_update' => $last_update
        ]);
    }

    public function dashboard_log()
    {
        if (!$this->session->userdata('username')) {
            echo json_encode(['status' => false]); return;
        }
        $filter    = $this->input->post('pc')     ?: 'ALL';
        $date_from = $this->input->post('dari')   ?: date('Y-m-d');
        $date_to   = $this->input->post('sampai') ?: date('Y-m-d');
        $rows = $this->Model_nag->dsb_ar_log_summary($filter, $date_from, $date_to);
        echo json_encode(['status' => true, 'data' => $rows]);
    }

    public function dashboard_log_detail()
    {
        if (!$this->session->userdata('username')) {
            echo json_encode(['status' => false]); return;
        }
        $filter   = $this->input->post('pc')       ?: 'ALL';
        $run_time = $this->input->post('run_time') ?: '';
        $col_key  = $this->input->post('col_key')  ?: '';
        $rows = $this->Model_nag->dsb_ar_log_detail($filter, $run_time, $col_key);
        echo json_encode(['status' => true, 'data' => $rows]);
    }

    // Daftar perubahan terbaru (untuk isi dropdown lonceng notifikasi) + jumlah belum dibaca
    public function notif_list()
    {
        if (!$this->session->userdata('username')) {
            echo json_encode(['status' => false]); return;
        }
        $since_id = (int) ($this->input->get('since_id') ?: 0);
        $rows   = $this->Model_nag->get_dashboard_activity_log(0, 50);
        $unread = $this->Model_nag->count_dashboard_activity_log($since_id);
        echo json_encode(['status' => true, 'data' => $rows, 'unread' => $unread]);
    }

    // Cari di seluruh histori tbl_log (dipanggil dari kotak search lonceng notifikasi)
    public function notif_search()
    {
        if (!$this->session->userdata('username')) {
            echo json_encode(['status' => false]); return;
        }
        $keyword = trim($this->input->get('q') ?: '');
        if ($keyword === '') {
            echo json_encode(['status' => true, 'data' => []]); return;
        }
        $rows = $this->Model_nag->search_dashboard_activity_log($keyword, 50);
        echo json_encode(['status' => true, 'data' => $rows]);
    }

    // SSE: dorong perubahan baru ke browser tanpa perlu polling manual
    public function notif_stream()
    {
        if (!$this->session->userdata('username')) {
            http_response_code(403); return;
        }

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        session_write_close();
        set_time_limit(0);
        ignore_user_abort(true);
        while (ob_get_level() > 0) { ob_end_clean(); }

        $last_id = (int) ($this->input->get('since_id') ?: $this->Model_nag->max_dashboard_activity_log_id());
        $started = time();

        while (true) {
            if (connection_aborted()) break;

            // Putuskan tiap 5 menit — browser (EventSource) akan otomatis reconnect
            if (time() - $started > 300) {
                echo "event: retry\ndata: {}\n\n";
                flush();
                break;
            }

            $rows = $this->Model_nag->get_dashboard_activity_log($last_id, 50);
            if (!empty($rows)) {
                $ids     = array_column($rows, 'id');
                $last_id = max($ids);
                echo 'data: ' . json_encode(['rows' => $rows, 'last_id' => $last_id]) . "\n\n";
            } else {
                echo "event: ping\ndata: {}\n\n";
            }
            flush();
            sleep(5);
        }
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
        $data['filter'] = $filter;
        $this->load->view('arnag/datamodal_sales5',$data);
    }

    public function load_det_motm()
    {
        $bulan = $this->input->post("event_id");
        $filter = $this->input->post('selected_pc') ?? 'ALL';
        $data['events'] = $this->Model_nag->load_det_motm($bulan, $filter);
        $data['filter'] = $filter;
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
