
<style>
body { overflow-y: scroll; }

/* ── Dashboard KPI Cards ── */
.dsb-card {
    border: none !important;
    border-radius: 14px !important;
    box-shadow: 0 4px 18px rgba(0,0,0,0.10) !important;
    transition: transform .18s, box-shadow .18s;
    overflow: hidden;
}
.dsb-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(0,0,0,0.16) !important;
    cursor: pointer;
}
.dsb-card .card-header {
    border-radius: 0 !important;
    padding: 10px 14px !important;
    display: flex;
    align-items: center;
    gap: 8px;
}
.dsb-card .card-header i { font-size: 16px; opacity: .85; }
.dsb-card .card-header span { font-size: 0.82rem; font-weight: 600; letter-spacing: .3px; }
.dsb-card .card-header a { color: #fff !important; text-decoration: none; }
.dsb-card .kpi-value {
    text-align: center;
    font-size: 1.3rem;
    font-weight: 700;
    color: #1a2340;
    padding: 14px 10px 10px;
    letter-spacing: -.3px;
    position: relative;
    z-index: 1;
}
.dsb-card-bigicon {
    position: absolute; right: 10px; top: 46px;
    font-size: 52px; opacity: 0.06; pointer-events: none; z-index: 0;
    transform: rotate(-8deg);
}
@keyframes kpiFlash {
    0% { box-shadow: 0 0 0 3px rgba(255,213,79,0.85), 0 4px 18px rgba(0,0,0,0.10); }
    100% { box-shadow: 0 4px 18px rgba(0,0,0,0.10); }
}
.dsb-card.kpi-flash-anim { animation: kpiFlash 1.4s ease; }
.dsb-card .kpi-footer {
    background: rgba(0,0,0,0.04);
    border-top: 1px solid rgba(0,0,0,0.06);
    text-align: center;
    padding: 6px 10px;
    font-size: 1rem;
    font-weight: 700;
    color: #4a5568;
}

/* ── Detail modal: ranked customer cards (Sales YTD, CM, dsb) ── */
.sls-detail-modal .modal-content { border: none; border-radius: 14px; overflow: hidden; }
.sls-detail-modal .modal-header { border: none; padding: 18px 24px; }
.sls-detail-modal .modal-body { background: #f6f7fb; padding: 20px 24px; }
.sls-sum-strip { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 16px; }
.sls-sum-card { flex: 1; min-width: 160px; background: #fff; border-radius: 12px; padding: 14px 18px; box-shadow: 0 2px 8px rgba(30,40,90,0.06); border: 1px solid #edeef5; position: relative; overflow: hidden; }
.sls-sum-icon { position: absolute; right: 10px; top: 10px; font-size: 26px; opacity: 0.12; }
.sls-sum-label { font-size: 11px; color: #8a8fa3; text-transform: uppercase; letter-spacing: .4px; font-weight: 600; position: relative; z-index: 1; }
.sls-sum-value { font-size: 19px; font-weight: 800; color: #1a2340; margin-top: 2px; position: relative; z-index: 1; }
.sls-sum-sub { font-size: 11px; color: #a3a7ba; margin-top: 2px; position: relative; z-index: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sls-sum-curr-list { margin-top: 6px; position: relative; z-index: 1; display: flex; flex-direction: column; gap: 2px; }
.sls-sum-curr-row { display: flex; justify-content: space-between; font-size: 11px; }
.sls-sum-curr-row .curr-code { font-weight: 700; color: #6a6f85; }
.sls-sum-curr-row .curr-amt { font-weight: 600; }
.sls-search-wrap { margin-bottom: 12px; }
.sls-cust-list { max-height: 55vh; overflow-y: auto; padding-right: 4px; }
.sls-cust-card { background: #fff; border-radius: 12px; padding: 14px 18px; margin-bottom: 10px; box-shadow: 0 1px 4px rgba(30,40,90,0.05); border: 1px solid #edeef5; display: flex; align-items: center; gap: 14px; transition: transform .12s ease, box-shadow .12s ease; }
.sls-cust-card:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(30,40,90,0.10); }
.sls-cust-rank { width: 30px; height: 30px; border-radius: 9px; background: linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%); color: #fff; font-weight: 800; font-size: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.sls-cust-rank.top3 { background: linear-gradient(135deg,#f9a825 0%,#f57f17 100%); }
.sls-cust-body { flex: 1; min-width: 0; }
.sls-cust-name { font-weight: 700; font-size: 14px; color: #20233a; white-space: normal; overflow-wrap: break-word; line-height: 1.3; }
.sls-cust-bar-track { background: #eef0f7; border-radius: 6px; height: 8px; overflow: hidden; margin-top: 6px; }
.sls-cust-bar { height: 100%; background: linear-gradient(90deg,#5c6bc0,#3949ab); border-radius: 6px; }
.sls-cust-figures { display: flex; gap: 18px; align-items: baseline; flex-shrink: 0; }
.sls-cust-fig { width: 108px; text-align: right; }
.sls-cust-fig.wide { width: 150px; }
.sls-cust-fig-label { font-size: 10px; color: #9aa0b8; text-transform: uppercase; font-weight: 700; }
.sls-cust-fig-value { font-size: 13px; font-weight: 700; color: #333a52; white-space: nowrap; }
.sls-cust-fig-value.emph { font-size: 15px; color: #3949ab; }
.sls-cust-pct { font-size: 13px; font-weight: 800; color: #3949ab; }

/* ── Chart Cards ── */
.chart-card .card-header {
    background: #f8faff !important;
    border-bottom: 2px solid #e8eeff !important;
    padding: 12px 18px !important;
}
.chart-card .card-title {
    font-size: 14px !important;
    font-weight: 700 !important;
    color: #2d3748 !important;
    letter-spacing: .2px;
}

/* ── Carousel ── */
.carousel-control-prev, .carousel-control-next {
    width: 40px;
    opacity: 1;
}
.carousel-ctrl-btn {
    width: 36px; height: 36px;
    background: rgba(57,73,171,0.85);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    transition: background .18s;
}
.carousel-ctrl-btn:hover { background: rgba(30,136,229,0.95); }
.carousel-ctrl-btn i { color: #fff; font-size: 14px; }

/* ── Section header ── */
.section-label {
    font-size: 13px;
    font-weight: 700;
    color: #3949ab;
    text-transform: uppercase;
    letter-spacing: .8px;
    border-left: 4px solid #3949ab;
    padding-left: 8px;
    margin-bottom: 0;
}

/* ── Last Update label ── */
.kpi-last-update {
    text-align: center;
    font-size: 10px;
    color: #7986cb;
    padding: 3px 8px 5px;
    border-top: 1px solid rgba(0,0,0,0.05);
}
.kpi-last-update i { font-size: 9px; }

/* ── Refresh button spin ── */
.fa-spin-custom { animation: spin 1s linear infinite; }
@keyframes spin { 100% { transform: rotate(360deg); } }

/* ── Prediction table ── */
.tbl-pred th {
    background: #eef1fb;
    font-size: 12.5px;
    font-weight: 700;
    color: #3949ab;
    padding: 9px 12px;
    border-bottom: 2px solid #c5cae9;
}
.tbl-pred td {
    font-size: 13px;
    color: #2d3748;
    padding: 8px 12px;
}
.tbl-pred tbody tr:hover { background: #f0f4ff; }
.tbl-pred .tr-total th { background: #e8eaf6; color: #1a237e; }

/* ── Profit center select ── */
.pc-select-wrap .form-control {
    border-radius: 20px !important;
    font-size: 13px;
    border: 1.5px solid #c5cae9;
}

/* ── Dashboard sync skeleton overlay ── */
.dsb-skel-overlay {
    position: absolute; inset: 0; z-index: 500;
    background: #f0f2f8;
    padding: 4px 0 24px;
    opacity: 1;
    transition: opacity .4s ease;
    overflow: hidden;
}
.dsb-skel-pill {
    display: inline-flex; align-items: center; gap: 9px;
    background: linear-gradient(135deg, #3949ab, #1a2340);
    color: #fff; font-size: 12.5px; font-weight: 600;
    padding: 8px 18px 8px 14px; border-radius: 30px;
    box-shadow: 0 8px 22px rgba(26,35,64,0.32);
    margin: 0 0 10px 4px;
    position: relative; overflow: hidden;
}
.dsb-skel-pill::after {
    content: ''; position: absolute; top: 0; left: -60%; width: 40%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.16), transparent);
    animation: dsbPillSheen 2.2s ease-in-out infinite;
}
@keyframes dsbPillSheen {
    0% { left: -60%; }
    100% { left: 130%; }
}
.dsb-skel-sub {
    display: inline-block; min-width: 150px; transition: opacity .25s ease;
}
.dsb-skel-dot {
    width: 8px; height: 8px; border-radius: 50%; background: #7cf29c;
    animation: dsbSkelPulse 1.2s infinite;
    flex-shrink: 0;
}
@keyframes dsbSkelPulse {
    0% { box-shadow: 0 0 0 0 rgba(124,242,156,0.6); }
    70% { box-shadow: 0 0 0 7px rgba(124,242,156,0); }
    100% { box-shadow: 0 0 0 0 rgba(124,242,156,0); }
}
.dsb-skel-progress-track {
    width: 220px; height: 4px; border-radius: 4px; overflow: hidden;
    background: rgba(255,255,255,0.18); margin: 0 0 18px 4px;
}
.dsb-skel-progress-bar {
    width: 40%; height: 100%; border-radius: 4px;
    background: linear-gradient(90deg, #7cf29c, #3949ab);
    animation: dsbProgressSlide 1.3s ease-in-out infinite;
}
@keyframes dsbProgressSlide {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(350%); }
}
.dsb-skel-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 20px;
}
@media (max-width: 991px) { .dsb-skel-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 575px) { .dsb-skel-grid { grid-template-columns: 1fr; } }
.dsb-skel-card {
    background: #fff; border-radius: 14px; padding: 18px 16px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.07);
    display: flex; flex-direction: column; gap: 14px;
}
.dsb-skel-bar {
    height: 12px; border-radius: 6px;
    background: linear-gradient(90deg, #e8eaf3 25%, #f4f5fa 37%, #e8eaf3 63%);
    background-size: 400% 100%;
    animation: dsbSkelShimmer 1.6s ease infinite;
}
.dsb-skel-bar.dsb-skel-h { height: 10px; border-radius: 20px; }
.dsb-skel-bar.dsb-skel-v { height: 20px; border-radius: 6px; align-self: center; }
.dsb-skel-bar.dsb-skel-f { height: 8px; align-self: center; opacity: .7; }
@keyframes dsbSkelShimmer {
    0% { background-position: 100% 50%; }
    100% { background-position: 0 50%; }
}
.dsb-skel-chart-row {
    display: grid; grid-template-columns: 1fr 1fr; gap: 18px;
}
@media (max-width: 767px) { .dsb-skel-chart-row { grid-template-columns: 1fr; } }
.dsb-skel-chart {
    background: #fff; border-radius: 14px; padding: 20px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.07);
    display: flex; flex-direction: column; align-items: center;
}
.dsb-skel-donut {
    width: 130px; height: 130px; border-radius: 50%;
    background: conic-gradient(#e8eaf3 0deg, #f4f5fa 120deg, #e8eaf3 240deg, #f4f5fa 360deg);
    background-size: 400% 400%;
    animation: dsbSkelShimmer 1.8s ease infinite;
}
</style>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <?php
            // Format last update untuk tampilan
            $last_update_fmt = 'Belum ada data';
            if (!empty($last_update)) {
                $dt = new DateTime($last_update);
                $months = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                $last_update_fmt = $dt->format('d') . ' ' . $months[(int)$dt->format('m')] . ' ' . $dt->format('Y H:i:s');
            }
            ?>
            <div class="row align-items-center mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 font-weight-bold" style="color:#1a2340;">
                        <i class="fas fa-chart-line mr-2" style="color:#3949ab;"></i><?= $title; ?>
                    </h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex justify-content-end align-items-center" style="gap:10px;">
                        <!-- Today's Change Log button -->
                        <button id="btn-change-log" type="button" class="btn btn-sm btn-outline-secondary"
                                onclick="openChangeLogModal()"
                                title="Today's data change log"
                                style="border-radius:20px; white-space:nowrap;">
                            <i class="fas fa-list-alt"></i> Change Log
                        </button>
                        <!-- Tombol Refresh Data — disembunyikan, sudah digantikan auto-refresh 1 menit -->
                        <?php if (!empty($can_refresh)) : ?>
                        <button id="btn-refresh-dsb" type="button" class="btn btn-sm btn-outline-primary"
                                onclick="refreshDashboard()"
                                title="Refresh semua data dashboard"
                                style="border-radius:20px; white-space:nowrap; display:none;">
                            <i class="fas fa-sync-alt" id="icon-refresh"></i> Refresh Data
                        </button>
                        <?php endif; ?>
                    <form id="filterForm" method="get" action="<?= base_url('landingpage'); ?>" class="form-inline pc-select-wrap">
                        <div class="input-group" style="max-width:260px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="border-radius:20px 0 0 20px; border:1.5px solid #c5cae9; background:#f0f4ff;">
                                    <i class="fas fa-building" style="color:#3949ab; font-size:12px;"></i>
                                </span>
                            </div>
                            <select class="form-control select2bs4" id="dsb_pc" name="dsb_pc" onchange="this.form.submit()" style="border-radius:0 20px 20px 0 !important;">
                                <?php if ($user['username'] == 'hanum') { ?>
                                    <option value="NAK" <?= ($selected_pc == 'ALL' ? 'selected' : '') ?>>NIRWANA ALABARE KNITTING</option>
                                <?php } else { ?>
                                    <option value="" disabled <?= empty($selected_pc) ? 'selected' : ''; ?>>Pilih Profit Center</option>
                                    <option value="ALL" <?= ($selected_pc == 'ALL' ? 'selected' : '') ?>>ALL</option>
                                    <?php foreach ($profit_center as $pc) : ?>
                                        <option value="<?= $pc['kode_pc']; ?>" <?= ($pc['kode_pc'] == $selected_pc ? 'selected' : '') ?>>
                                            <?= $pc['nama_pc']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </select>
                        </div>
                    </form>
                    </div><!-- /.d-flex -->
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel -->
    <div id="dsb-content-wrap" style="position:relative;">
    <div id="dsb-sync-overlay" class="dsb-skel-overlay">

        <!-- Status pill -->
        <div class="dsb-skel-pill">
            <span class="dsb-skel-dot"></span>
            <span id="dsb-sync-sub" class="dsb-skel-sub">Syncing latest data...</span>
        </div>
        <div class="dsb-skel-progress-track"><div class="dsb-skel-progress-bar"></div></div>

        <!-- KPI card skeletons -->
        <div class="dsb-skel-grid">
            <?php for ($i = 0; $i < 8; $i++) : ?>
            <div class="dsb-skel-card">
                <div class="dsb-skel-bar dsb-skel-h" style="width:70%;"></div>
                <div class="dsb-skel-bar dsb-skel-v" style="width:85%;"></div>
                <div class="dsb-skel-bar dsb-skel-f" style="width:40%;"></div>
            </div>
            <?php endfor; ?>
        </div>

        <!-- Chart skeletons -->
        <div class="dsb-skel-chart-row">
            <div class="dsb-skel-chart">
                <div class="dsb-skel-bar dsb-skel-h" style="width:45%;margin-bottom:18px;"></div>
                <div class="dsb-skel-donut"></div>
            </div>
            <div class="dsb-skel-chart">
                <div class="dsb-skel-bar dsb-skel-h" style="width:45%;margin-bottom:18px;"></div>
                <div class="dsb-skel-donut"></div>
            </div>
        </div>
    </div>
    <div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel" data-interval="10000">
        <div class="carousel-inner">

            <!-- Slide 1: KPI + Charts -->
            <div class="carousel-item active">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">

                            <!-- Sales YTD Invoiced -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slsytd()">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        <span>Sales YTD (Invoiced)</span>
                                    </div>
                                    <i class="fas fa-file-invoice-dollar dsb-card-bigicon"></i>
                                    <div class="kpi-value" data-kpi-key="sls_ytd_inv" data-kpi-raw="<?= (float)$sls_ytd_inv; ?>">IDR <?= number_format((float)$sls_ytd_inv, 2); ?></div>
                                    <div class="kpi-last-update" id="lu_sls_ytd_inv"><i class="fas fa-clock"></i> <span class="kpi-lu-text"><?= $last_update_fmt; ?></span></div>
                                </div>
                            </div>

                            <!-- Sales Current Month Invoiced -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slscm()">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-calendar-check"></i>
                                        <span><a href="<?= base_url('report/frm_sales_report'); ?>" target="blank">Sales Current Month (Invoiced)</a></span>
                                    </div>
                                    <i class="fas fa-calendar-check dsb-card-bigicon"></i>
                                    <div class="kpi-value" data-kpi-key="sls_cm_inv" data-kpi-raw="<?= (float)$sls_cm_inv; ?>">IDR <?= number_format((float)$sls_cm_inv, 2); ?></div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <span class="kpi-lu-text"><?= $last_update_fmt; ?></span></div>
                                </div>
                            </div>

                            <!-- Sales YTD (all) -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slsytd2()">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-chart-bar"></i>
                                        <span>Sales YTD</span>
                                    </div>
                                    <i class="fas fa-chart-bar dsb-card-bigicon"></i>
                                    <div class="kpi-value" data-kpi-key="sls_ytd_all" data-kpi-raw="<?= (float)$sls_no_inv + (float)$sls_ytd_inv; ?>">IDR <?= number_format((float)$sls_no_inv + (float)$sls_ytd_inv, 2); ?></div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <span class="kpi-lu-text"><?= $last_update_fmt; ?></span></div>
                                </div>
                            </div>

                            <!-- Sales Current Month (all) -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slscm2()">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Sales Current Month</span>
                                    </div>
                                    <i class="fas fa-calendar-alt dsb-card-bigicon"></i>
                                    <div class="kpi-value" data-kpi-key="sls_cm_all" data-kpi-raw="<?= (float)$sls_cm_no_inv + (float)$sls_cm_inv; ?>">IDR <?= number_format((float)$sls_cm_no_inv + (float)$sls_cm_inv, 2); ?></div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <span class="kpi-lu-text"><?= $last_update_fmt; ?></span></div>
                                </div>
                            </div>

                            <!-- Sales Not Invoiced -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slsni()">
                                    <div class="card-header bg-success text-white">
                                        <i class="fas fa-shipping-fast"></i>
                                        <span><a href="<?= base_url('arnag/frm_report_sj_not_invoice'); ?>" target="blank">Sales (Not Invoiced)</a></span>
                                    </div>
                                    <i class="fas fa-shipping-fast dsb-card-bigicon"></i>
                                    <div class="kpi-value" data-kpi-key="sls_no_inv" data-kpi-raw="<?= (float)$sls_no_inv; ?>">IDR <?= number_format((float)$sls_no_inv, 2); ?></div>
                                    <div class="kpi-footer">
                                        <?php
                                            $denom  = $sls_ytd_inv ?: $sls_no_inv;
                                            $result = ($denom > 0) ? ($sls_no_inv / $denom * 100) : 0;
                                            echo number_format($result, 2);
                                        ?> %
                                    </div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <span class="kpi-lu-text"><?= $last_update_fmt; ?></span></div>
                                </div>
                            </div>

                            <!-- Account Receivable -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_total_ar()">
                                    <div class="card-header bg-danger text-white">
                                        <i class="fas fa-hand-holding-usd"></i>
                                        <span>Account Receivable</span>
                                    </div>
                                    <i class="fas fa-hand-holding-usd dsb-card-bigicon"></i>
                                    <div class="kpi-value" data-kpi-key="ar_eqvidr" data-kpi-raw="<?= (float)$ar_eqvidr; ?>">IDR <?= number_format((float)$ar_eqvidr, 2); ?></div>
                                    <div class="kpi-footer">100.00 %</div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <span class="kpi-lu-text"><?= $last_update_fmt; ?></span></div>
                                </div>
                            </div>

                            <!-- Overdue Receivable -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_total_overdue()">
                                    <div class="card-header bg-danger text-white">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span><a href="<?= base_url('arnag/kartu_ar_detail'); ?>" target="blank">Overdue Receivable</a></span>
                                    </div>
                                    <i class="fas fa-exclamation-circle dsb-card-bigicon"></i>
                                    <div class="kpi-value" data-kpi-key="ready_due" data-kpi-raw="<?= (float)$ready_due; ?>">IDR <?= number_format((float)$ready_due, 2); ?></div>
                                    <div class="kpi-footer"><?= number_format((float)$ar_eqvidr > 0 ? ((float)$ready_due / (float)$ar_eqvidr * 100) : 0, 2); ?> %</div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <span class="kpi-lu-text"><?= $last_update_fmt; ?></span></div>
                                </div>
                            </div>

                            <!-- Not Due Receivable -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_total_notdue()">
                                    <div class="card-header bg-danger text-white">
                                        <i class="fas fa-check-circle"></i>
                                        <span><a href="<?= base_url('arnag/kartu_ar_detail'); ?>" target="blank">Not Due Receivable</a></span>
                                    </div>
                                    <i class="fas fa-check-circle dsb-card-bigicon"></i>
                                    <div class="kpi-value" data-kpi-key="not_due" data-kpi-raw="<?= (float)($ar_eqvidr - $ready_due); ?>">IDR <?= number_format((float)($ar_eqvidr - $ready_due), 2); ?></div>
                                    <div class="kpi-footer"><?= number_format((float)$ar_eqvidr > 0 ? (((float)$ar_eqvidr - (float)$ready_due) / (float)$ar_eqvidr * 100) : 0, 2); ?> %</div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <span class="kpi-lu-text"><?= $last_update_fmt; ?></span></div>
                                </div>
                            </div>

                            <!-- Chart: Sales By Destination -->
                            <div class="col-lg-6 mb-3">
                                <div class="card chart-card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="section-label mb-0">Sales Value By Destination</p>
                                            <select style="width:12rem" class="form-control form-control-sm" id="filter_dsb1" name="filter_dsb1" onchange="cari_ar_lokal_ekspor(this.value)">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($filter_ar as $fa) : ?>
                                                    <option value="<?= $fa['val_fil']; ?>"><?= $fa['name_fil']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chart: Sales By Order Type -->
                            <div class="col-lg-6 mb-3">
                                <div class="card chart-card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="section-label mb-0">Sales Value By Order Type</p>
                                            <select style="width:12rem" class="form-control form-control-sm" id="filter_dsb1a" name="filter_dsb1a" onchange="cari_ar_fob_cmt(this.value)">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($filter_ar as $fa) : ?>
                                                    <option value="<?= $fa['val_fil']; ?>"><?= $fa['name_fil']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart2"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!-- /slide 1 -->

            <!-- Slide 2: TOP 5 + Prediction -->
            <div class="carousel-item">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="card chart-card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="section-label mb-0">TOP 5 Buyer By Sales Value</p>
                                            <select style="width:15rem" class="form-control form-control-sm" id="filter_dsb2" name="filter_dsb2" onchange="change_top_5_sales(this.value)">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($bulan_ar as $bln) : ?>
                                                    <option value="<?= $bln['bulan_text']; ?>"><?= $bln['nama_bulan']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart3"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Receivable Prediction table -->
                            <div class="col-lg-12 mb-3">
                                <div class="card chart-card">
                                    <div class="card-header">
                                        <p class="section-label mb-0">Receivable Prediction</p>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table tbl-pred mb-0" style="white-space:nowrap; width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Periode</th>
                                                        <th>Week 1 (1–7)</th>
                                                        <th>Week 2 (8–14)</th>
                                                        <th>Week 3 (15–21)</th>
                                                        <th>Week 4 (22–31)</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data_pred as $dp) : ?>
                                                        <tr>
                                                            <td><strong><?= $dp['periode']; ?></strong></td>
                                                            <td>IDR <?= number_format($dp['week1'], 2); ?></td>
                                                            <td>IDR <?= number_format($dp['week2'], 2); ?></td>
                                                            <td>IDR <?= number_format($dp['week3'], 2); ?></td>
                                                            <td>IDR <?= number_format($dp['week4'], 2); ?></td>
                                                            <td><strong>IDR <?= number_format($dp['week4'] + $dp['week1'] + $dp['week2'] + $dp['week3'], 2); ?></strong></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /slide 2 -->

            <!-- Slide 3: Sales YTD MTM -->
            <div class="carousel-item">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="card chart-card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="section-label mb-0">Sales Year To Date (Month To Month Comparison)</p>
                                            <select style="width:15rem" class="form-control form-control-sm" id="filter_chart4" name="filter_chart4" onchange="change_sales_ytd_mtm(this.value)">
                                                <?php foreach ($tahun_ar as $thn) : ?>
                                                    <?php $isselected = ($thn['tahun'] == date("Y")) ? 'selected' : ''; ?>
                                                    <option value="<?= $thn['tahun']; ?>" <?= $isselected; ?>><?= $thn['tahun']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /slide 3 -->

            <!-- Slide 4: Overdue Aging -->
            <div class="carousel-item">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="card chart-card">
                                    <div class="card-header">
                                        <p class="section-label mb-0">Overdue Receivable Aging</p>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /slide 4 -->

        </div><!-- /.carousel-inner -->

        <!-- Carousel Controls -->
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <div class="carousel-ctrl-btn"><i class="fas fa-chevron-left"></i></div>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <div class="carousel-ctrl-btn"><i class="fas fa-chevron-right"></i></div>
        </a>
    </div><!-- /.carousel -->
    </div><!-- /#dsb-content-wrap -->
</div><!-- /.content-wrapper -->


<!-- ══════════ MODALS ══════════ -->

<!-- Overdue Aging -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-clock mr-2"></i>Overdue Receivable Aging</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"><div id="det_overdue"></div></div>
        </div>
    </div>
</div>

<?php
// ── Helper render kartu ranking per-customer buat modal detail dashboard ──────
// Dipakai bareng sama modal Sales (qty/uom/avg_price/total) & modal AR
// (curr/total/total_idr) - sekali ditulis, dipanggil berkali-kali per modal.
if (!function_exists('_sls_render_customer_cards')) {
    function _sls_render_customer_cards($rows, $list_id, $sum_prefix, $unit_label)
    {
        $ttl_qty = 0; $ttl_total = 0; $max_total = 0; $qty_by_uom = [];
        foreach ($rows as $r) {
            $ttl_qty += $r['qty'];
            $ttl_total += $r['total'];
            if ($r['total'] > $max_total) $max_total = $r['total'];
            // Grup qty per satuan aslinya - jangan ditumpuk jadi 1 angka pakai
            // $unit_label kalau datanya campuran (misal filter ALL gabung NAG/PCS
            // dan NAK/Kilogram), soalnya menjumlahkan 2 satuan beda jadi 1 angka
            // itu tidak berarti apa-apa.
            $uom_key = trim((string) ($r['uom'] ?? ''));
            if ($uom_key === '') $uom_key = $unit_label;
            $qty_by_uom[$uom_key] = ($qty_by_uom[$uom_key] ?? 0) + $r['qty'];
        }
        if ($max_total <= 0) $max_total = 1;
        $cust_count = count($rows);
        $top = $cust_count > 0 ? $rows[0] : null;
        $top_pct = ($top && $ttl_total > 0) ? ($top['total'] / $ttl_total * 100) : 0;
        ?>
        <div class="sls-sum-strip" id="sls-sum-<?= $sum_prefix; ?>">
            <div class="sls-sum-card">
                <i class="fas fa-users sls-sum-icon" style="color:#3949ab;"></i>
                <div class="sls-sum-label">Customers</div>
                <div class="sls-sum-value" id="sls-sum-count-<?= $sum_prefix; ?>"><?= $cust_count; ?></div>
                <div class="sls-sum-sub">contributing this period</div>
            </div>
            <div class="sls-sum-card" id="sls-sum-qtycard-<?= $sum_prefix; ?>">
                <i class="fas fa-boxes sls-sum-icon" style="color:#00897b;"></i>
                <?php if (count($qty_by_uom) > 1) : ?>
                    <div class="sls-sum-label">Total Qty</div>
                    <div class="sls-sum-curr-list">
                        <?php foreach ($qty_by_uom as $uom => $q) : ?>
                            <div class="sls-sum-curr-row"><span class="curr-code"><?= htmlspecialchars($uom); ?></span><span class="curr-amt"><?= number_format($q, $uom === 'PCS' ? 0 : 2); ?></span></div>
                        <?php endforeach; ?>
                    </div>
                <?php else :
                    $only_uom = $qty_by_uom ? array_key_first($qty_by_uom) : $unit_label;
                ?>
                    <div class="sls-sum-label">Total Qty (<?= htmlspecialchars($only_uom); ?>)</div>
                    <div class="sls-sum-value"><?= number_format($ttl_qty, $only_uom === 'PCS' ? 0 : 2); ?></div>
                <?php endif; ?>
                <div class="sls-sum-sub">across all customers</div>
            </div>
            <div class="sls-sum-card" style="background:linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%); flex:1.4; min-width:220px;">
                <i class="fas fa-sack-dollar sls-sum-icon" style="color:#fff;"></i>
                <div class="sls-sum-label" style="color:rgba(255,255,255,0.75);">Total Value (IDR)</div>
                <div class="sls-sum-value" style="color:#fff;" id="sls-sum-total-<?= $sum_prefix; ?>"><?= number_format($ttl_total, 2); ?></div>
                <div class="sls-sum-sub" style="color:rgba(255,255,255,0.8);" id="sls-sum-top-<?= $sum_prefix; ?>">
                    <?php if ($top): ?>Top: <?= $top['customer']; ?> (<?= number_format($top_pct, 1); ?>%)<?php endif; ?>
                </div>
            </div>
        </div>

        <div class="sls-search-wrap d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
            <div class="input-group input-group-sm" style="max-width:320px;">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                <input type="text" class="form-control" placeholder="Search customer..." oninput="_slsFilterCards(this, '<?= $list_id; ?>')">
            </div>
            <span style="font-size:11px;color:#9aa0b8;display:flex;align-items:center;gap:5px;">
                <span style="width:6px;height:6px;border-radius:50%;background:#7cf29c;display:inline-block;"></span>
                Live &mdash; updates every minute
            </span>
        </div>

        <div class="sls-cust-list" id="<?= $list_id; ?>">
            <?php foreach ($rows as $i => $r): ?>
                <div class="sls-cust-card" data-sls-name="<?= strtolower($r['customer']); ?>">
                    <div class="sls-cust-rank<?= $i < 3 ? ' top3' : ''; ?>">#<?= $i + 1; ?></div>
                    <div class="sls-cust-body">
                        <div class="sls-cust-name"><?= $r['customer']; ?></div>
                        <div class="sls-cust-bar-track">
                            <div class="sls-cust-bar" style="width:<?= min(100, $r['total'] / $max_total * 100); ?>%;"></div>
                        </div>
                    </div>
                    <div class="sls-cust-fig">
                        <div class="sls-cust-fig-label">% of Total</div>
                        <div class="sls-cust-pct"><?= $ttl_total > 0 ? number_format($r['total'] / $ttl_total * 100, 1) : '0.0'; ?>%</div>
                    </div>
                    <div class="sls-cust-figures">
                        <div class="sls-cust-fig">
                            <div class="sls-cust-fig-label">Qty</div>
                            <div class="sls-cust-fig-value"><?= ($r['uom'] == 'PCS') ? number_format($r['qty'], 0) : number_format($r['qty'], 2); ?> <?= $r['uom']; ?></div>
                        </div>
                        <div class="sls-cust-fig">
                            <div class="sls-cust-fig-label">Avg Price</div>
                            <div class="sls-cust-fig-value">IDR <?= number_format($r['avg_price'], 2); ?></div>
                        </div>
                        <div class="sls-cust-fig wide">
                            <div class="sls-cust-fig-label">Total</div>
                            <div class="sls-cust-fig-value emph">IDR <?= number_format($r['total'], 2); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <p class="sls-no-result" style="display:none;color:#aaa;text-align:center;padding:20px;">No customer matches your search.</p>
        </div>
        <?php
    }
}

// Sama seperti di atas, tapi buat modal berbasis AR (curr/total/IDR equivalent)
// - shipp ditampilin sebagai sub-label di bawah nama customer, curr sebagai badge.
if (!function_exists('_ar_render_customer_cards')) {
    function _ar_render_customer_cards($rows, $list_id, $sum_prefix, $value_field, $value_label)
    {
        usort($rows, function ($a, $b) use ($value_field) { return $b[$value_field] <=> $a[$value_field]; });
        $ttl_value = 0; $max_value = 0; $local_value = 0; $export_value = 0;
        $local_by_curr = []; $export_by_curr = [];
        foreach ($rows as $r) {
            $ttl_value += $r[$value_field];
            if ($r[$value_field] > $max_value) $max_value = $r[$value_field];
            // trim() penting - data live kadang ada spasi nyempil di curr (mis. "IDR "
            // vs "IDR"), kalau tidak di-trim bisa keanggep 2 currency beda padahal sama.
            $curr_key = trim((string) $r['curr']);
            if ($r['shipp'] === 'Local') {
                $local_value += $r[$value_field];
                $local_by_curr[$curr_key] = ($local_by_curr[$curr_key] ?? 0) + $r['total'];
            } elseif ($r['shipp'] === 'Export') {
                $export_value += $r[$value_field];
                $export_by_curr[$curr_key] = ($export_by_curr[$curr_key] ?? 0) + $r['total'];
            }
        }
        if ($max_value <= 0) $max_value = 1;
        $row_count = count($rows);
        $top = $row_count > 0 ? $rows[0] : null;
        $top_pct = ($top && $ttl_value > 0) ? ($top[$value_field] / $ttl_value * 100) : 0;
        $local_pct = $ttl_value > 0 ? ($local_value / $ttl_value * 100) : 0;
        $export_pct = $ttl_value > 0 ? ($export_value / $ttl_value * 100) : 0;
        $render_by_curr = function ($by_curr) {
            if (!$by_curr) { echo '<div class="sls-sum-curr-row"><span class="curr-amt" style="color:#c7cbdb;">No data</span></div>'; return; }
            foreach ($by_curr as $curr => $amt) {
                echo '<div class="sls-sum-curr-row"><span class="curr-code">' . $curr . '</span><span class="curr-amt">' . number_format($amt, 2) . '</span></div>';
            }
        };
        ?>
        <div class="sls-sum-strip" id="sls-sum-<?= $sum_prefix; ?>">
            <div class="sls-sum-card">
                <i class="fas fa-building sls-sum-icon" style="color:#3949ab;"></i>
                <div class="sls-sum-label">Records</div>
                <div class="sls-sum-value" id="sls-sum-count-<?= $sum_prefix; ?>"><?= $row_count; ?></div>
                <div class="sls-sum-sub">customer &times; shipment &times; currency</div>
            </div>
            <div class="sls-sum-card">
                <i class="fas fa-map-marker-alt sls-sum-icon" style="color:#00897b;"></i>
                <div class="sls-sum-label">Local (IDR)</div>
                <div class="sls-sum-value" id="sls-sum-local-<?= $sum_prefix; ?>"><?= number_format($local_value, 2); ?></div>
                <div class="sls-sum-sub" id="sls-sum-local-pct-<?= $sum_prefix; ?>"><?= number_format($local_pct, 1); ?>% of total</div>
                <div class="sls-sum-curr-list" id="sls-sum-local-orig-<?= $sum_prefix; ?>"><?php $render_by_curr($local_by_curr); ?></div>
            </div>
            <div class="sls-sum-card">
                <i class="fas fa-plane-departure sls-sum-icon" style="color:#5c6bc0;"></i>
                <div class="sls-sum-label">Export (IDR)</div>
                <div class="sls-sum-value" id="sls-sum-export-<?= $sum_prefix; ?>"><?= number_format($export_value, 2); ?></div>
                <div class="sls-sum-sub" id="sls-sum-export-pct-<?= $sum_prefix; ?>"><?= number_format($export_pct, 1); ?>% of total</div>
                <div class="sls-sum-curr-list" id="sls-sum-export-orig-<?= $sum_prefix; ?>"><?php $render_by_curr($export_by_curr); ?></div>
            </div>
            <div class="sls-sum-card" style="background:linear-gradient(135deg,#c62828 0%,#e57373 100%); flex:1.4; min-width:220px;">
                <i class="fas fa-hand-holding-usd sls-sum-icon" style="color:#fff;"></i>
                <div class="sls-sum-label" style="color:rgba(255,255,255,0.75);"><?= $value_label; ?> (IDR)</div>
                <div class="sls-sum-value" style="color:#fff;" id="sls-sum-total-<?= $sum_prefix; ?>"><?= number_format($ttl_value, 2); ?></div>
                <div class="sls-sum-sub" style="color:rgba(255,255,255,0.8);" id="sls-sum-top-<?= $sum_prefix; ?>">
                    <?php if ($top): ?>Top: <?= $top['customer']; ?> (<?= number_format($top_pct, 1); ?>%)<?php endif; ?>
                </div>
            </div>
        </div>

        <div class="sls-search-wrap d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
            <div class="input-group input-group-sm" style="max-width:320px;">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                <input type="text" class="form-control" placeholder="Search customer..." oninput="_slsFilterCards(this, '<?= $list_id; ?>')">
            </div>
            <span style="font-size:11px;color:#9aa0b8;display:flex;align-items:center;gap:5px;">
                <span style="width:6px;height:6px;border-radius:50%;background:#7cf29c;display:inline-block;"></span>
                Live &mdash; updates every minute
            </span>
        </div>

        <div class="sls-cust-list" id="<?= $list_id; ?>">
            <?php foreach ($rows as $i => $r): ?>
                <div class="sls-cust-card" data-sls-name="<?= strtolower($r['customer']); ?>">
                    <div class="sls-cust-rank<?= $i < 3 ? ' top3' : ''; ?>">#<?= $i + 1; ?></div>
                    <div class="sls-cust-body">
                        <div class="sls-cust-name"><?= $r['customer']; ?></div>
                        <div style="font-size:11px;color:#9aa0b8;margin-top:1px;"><?= $r['shipp']; ?> &middot; <span class="badge badge-light" style="font-weight:700;"><?= $r['curr']; ?></span></div>
                        <div class="sls-cust-bar-track">
                            <div class="sls-cust-bar" style="width:<?= min(100, $r[$value_field] / $max_value * 100); ?>%;background:linear-gradient(90deg,#e57373,#c62828);"></div>
                        </div>
                    </div>
                    <div class="sls-cust-fig">
                        <div class="sls-cust-fig-label">% of Total</div>
                        <div class="sls-cust-pct" style="color:#c62828;"><?= $ttl_value > 0 ? number_format($r[$value_field] / $ttl_value * 100, 1) : '0.0'; ?>%</div>
                    </div>
                    <div class="sls-cust-figures">
                        <div class="sls-cust-fig">
                            <div class="sls-cust-fig-label">Original (<?= $r['curr']; ?>)</div>
                            <div class="sls-cust-fig-value"><?= number_format($r['total'], 2); ?></div>
                        </div>
                        <div class="sls-cust-fig wide">
                            <div class="sls-cust-fig-label"><?= $value_label; ?> (IDR)</div>
                            <div class="sls-cust-fig-value emph" style="color:#c62828;">IDR <?= number_format($r[$value_field], 2); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <p class="sls-no-result" style="display:none;color:#aaa;text-align:center;padding:20px;">No records match your search.</p>
        </div>
        <?php
    }
}
?>

<!-- Sales YTD Invoiced -->
<div class="modal fade sls-detail-modal" id="modal_slsytd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-file-invoice-dollar mr-2"></i>Sales YTD (Invoiced)</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Invoiced sales year-to-date, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php _sls_render_customer_cards($data_slsytd, 'sls-list-ytd', 'ytd', ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Sales CM Invoiced -->
<div class="modal fade sls-detail-modal" id="modal_slscm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-calendar-check mr-2"></i>Sales Current Month (Invoiced)</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Invoiced sales this month, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php _sls_render_customer_cards($data_slscm, 'sls-list-cm', 'cm', ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Sales YTD All -->
<div class="modal fade sls-detail-modal" id="modal_slsytd2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-chart-bar mr-2"></i>Sales YTD</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Sales value year-to-date, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php _sls_render_customer_cards($data_slsytd2, 'sls-list-ytd2', 'ytd2', ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Sales Not Invoiced -->
<div class="modal fade sls-detail-modal" id="modal_slsni" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#2e7d32 0%,#66bb6a 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-shipping-fast mr-2"></i>Sales (Not Invoiced)</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Shipped but not yet invoiced, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php _sls_render_customer_cards($data_slsni, 'sls-list-ni', 'ni', ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Sales CM All -->
<div class="modal fade sls-detail-modal" id="modal_slscm2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-calendar-alt mr-2"></i>Sales Current Month</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">All sales this month, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php _sls_render_customer_cards($data_slscm2, 'sls-list-cm2', 'cm2', ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'); ?>
            </div>
        </div>
    </div>
</div>

<!-- TOP 5 -->
<div class="modal fade sls-detail-modal" id="mysales5" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#00838f 0%,#26c6da 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-trophy mr-2"></i>TOP 5 Buyer By Sales Value</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Buyer detail for the selected period</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"><div id="det_sales5"></div></div>
        </div>
    </div>
</div>

<!-- MoTM -->
<div class="modal fade sls-detail-modal" id="mymotm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#1565c0 0%,#42a5f5 100%);">
                <div>
                    <h5 class="modal-title mb-0" id="jdl_motm"></h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">All sales this period, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"><div id="det_motm"></div></div>
        </div>
    </div>
</div>

<!-- Account Receivable -->
<div class="modal fade sls-detail-modal" id="modal_total_ar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#c62828 0%,#e57373 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-hand-holding-usd mr-2"></i>Account Receivable</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Outstanding receivable, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php _ar_render_customer_cards($data_ttl_ar, 'ar-list-total', 'ar', 'total_idr', 'Total'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Overdue Receivable -->
<div class="modal fade sls-detail-modal" id="modal_total_overdue" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#c62828 0%,#e57373 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-exclamation-circle mr-2"></i>Overdue Receivable</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Past due receivable, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php _ar_render_customer_cards(array_values(array_filter($data_ttl_ar, function ($r) { return $r['ready_due'] > 0; })), 'ar-list-overdue', 'overdue', 'ready_due', 'Overdue'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Not Due Receivable -->
<div class="modal fade sls-detail-modal" id="modal_total_notdue" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:95vw; width:1100px;">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#c62828 0%,#e57373 100%);">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-check-circle mr-2"></i>Not Due Receivable</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Not yet due receivable, ranked by customer</div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php _ar_render_customer_cards(array_values(array_filter($data_ttl_ar, function ($r) { return $r['not_due'] > 0; })), 'ar-list-notdue', 'notdue', 'not_due', 'Not Due'); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Today's Data Change Log modal (tbl_data_change_log) -->
<style>
#modal_change_log .modal-content { border:none; border-radius:14px; overflow:hidden; }
#modal_change_log .modal-header { background:linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%); border:none; padding:18px 24px; }
#modal_change_log .modal-body { background:#f6f7fb; padding:20px 24px; }
.cl-kpi-card { flex:1; min-width:150px; background:#fff; border-radius:12px; padding:14px 18px; box-shadow:0 2px 8px rgba(30,40,90,0.06); border:1px solid #edeef5; position:relative; overflow:hidden; }
.cl-kpi-card .cl-kpi-icon { position:absolute; right:10px; top:10px; font-size:26px; opacity:0.12; }
.cl-kpi-label { font-size:11px; color:#8a8fa3; text-transform:uppercase; letter-spacing:.4px; font-weight:600; }
.cl-kpi-value { font-size:20px; font-weight:800; margin-top:2px; }
.cl-kpi-sub { font-size:11px; color:#a3a7ba; margin-top:2px; }
.cl-section-title { font-size:13px; font-weight:700; color:#3949ab; margin:0 0 10px 2px; display:flex; align-items:center; gap:6px; }
.cl-cust-card { background:#fff; border-radius:14px; padding:18px 22px; box-shadow:0 2px 10px rgba(30,40,90,0.07); border:1px solid #edeef5; transition:transform .12s ease, box-shadow .12s ease; }
.cl-cust-card:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(30,40,90,0.12); }
.cl-cust-rank { width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%); color:#fff; font-weight:800; font-size:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.cl-cust-name { font-weight:800; font-size:17px; color:#20233a; }
.cl-cust-bar-track { background:#eef0f7; border-radius:8px; height:12px; overflow:hidden; display:flex; margin-top:10px; }
.cl-cust-figure-label { font-size:11px; color:#9aa0b8; text-transform:uppercase; letter-spacing:.3px; font-weight:700; }
.cl-cust-figure-value { font-size:18px; font-weight:800; margin-top:2px; }
#modal_change_log .table thead th { background:#f0f1f8; color:#555; border-top:none; font-size:11px; text-transform:uppercase; letter-spacing:.3px; }
#modal_change_log .table td { vertical-align:middle; }
#cl-list-area { background:#fff; border-radius:10px; box-shadow:0 1px 4px rgba(30,40,90,0.05); padding:4px; }
.cl-tabs { display:flex; gap:4px; background:#eceef7; border-radius:10px; padding:4px; width:fit-content; margin-bottom:14px; }
.cl-tab-btn { border:none; background:transparent; padding:6px 16px; border-radius:8px; font-size:12px; font-weight:600; color:#6a6f85; cursor:pointer; }
.cl-tab-btn.active { background:#fff; color:#3949ab; box-shadow:0 1px 4px rgba(30,40,90,0.12); }
.cl-recon-strip { background:#fff; border-radius:12px; padding:16px 20px; box-shadow:0 2px 8px rgba(30,40,90,0.06); border:1px solid #edeef5; margin-bottom:14px; flex:1; min-width:280px; }
.cl-recon-flow { display:flex; align-items:center; flex-wrap:wrap; gap:10px; }
.cl-recon-row { display:flex; flex-wrap:wrap; gap:14px; }
.cl-recon-node { text-align:center; min-width:130px; }
.cl-recon-node-label { font-size:10px; color:#9aa0b8; text-transform:uppercase; letter-spacing:.4px; font-weight:700; }
.cl-recon-node-value { font-size:16px; font-weight:800; color:#2b2f42; margin-top:2px; }
.cl-recon-arrow { color:#c7cbdb; font-size:18px; }
</style>
<div class="modal fade" id="modal_change_log" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:98vw; width:1850px;">
        <div class="modal-content">
            <div class="modal-header text-white">
                <div>
                    <h5 class="modal-title mb-0"><i class="fas fa-chart-line mr-2"></i>Today's Change Log</h5>
                    <div style="font-size:12px;opacity:0.85;margin-top:2px;">Live view of data changes recorded today &mdash; resets daily &mdash; all values in IDR</div>
                </div>
                <div class="d-flex align-items-center" style="gap:14px;">
                    <span id="cl-live-indicator" style="font-size:11px;opacity:0.9;display:flex;align-items:center;gap:6px;">
                        <span style="width:7px;height:7px;border-radius:50%;background:#7cf29c;display:inline-block;animation:dsbSkelPulse 1.2s infinite;"></span>
                        <span id="cl-live-text">Updated just now</span>
                    </span>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
            </div>
            <div class="modal-body" style="min-height:200px;">
                <div id="cl-recon" class="mb-3"></div>
                <div id="cl-summary" class="mb-3"></div>

                <div class="cl-tabs">
                    <button type="button" class="cl-tab-btn active" id="cl-tab-btn-detail" onclick="clSwitchTab('detail')">
                        <i class="fas fa-list-ul mr-1"></i>Detail Log
                    </button>
                    <button type="button" class="cl-tab-btn" id="cl-tab-btn-customer" onclick="clSwitchTab('customer')">
                        <i class="fas fa-users mr-1"></i>By Customer
                    </button>
                </div>

                <div id="cl-tab-detail">
                    <div id="cl-breakdown" class="mb-3"></div>
                    <div class="d-flex align-items-center flex-wrap mb-2" style="gap:8px;">
                        <div class="input-group input-group-sm" style="max-width:320px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="cl_search" class="form-control" placeholder="Search doc number, FG/OUT, SO, item, user..." oninput="filterChangeLogRows()">
                        </div>
                        <span id="cl-count-label" style="color:#888;font-size:12px;"></span>
                    </div>
                    <div id="cl-list-area" class="table-responsive" style="max-height:58vh;overflow-y:auto;font-size:12px;">
                        <p style="color:#aaa;text-align:center;padding:20px;">Click "Change Log" to load data.</p>
                    </div>
                </div>

                <div id="cl-tab-customer" style="display:none;">
                    <div class="cl-section-title"><i class="fas fa-building"></i>Impact per Buyer / Customer (today)</div>
                    <div id="cl-by-customer" style="max-height:62vh;overflow-y:auto;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh Change Log - biar beneran "live" (dulu cuma nampilin teks itu
// doang tapi datanya statis). PENTING: sengaja TIDAK punya interval sendiri -
// refresh-nya "numpang" di timer dashboard KPI (DSB_KPI_REFRESH_MS, lihat di
// bawah) supaya keduanya kebaca dari state ar_dashboard yang PERSIS sama di
// momen yang sama, bukan dua timer independen yang bisa balapan dan bikin
// angka Change Log vs dashboard depan sempat tidak sinkron sepersekian menit.
window._clTickTimer = null;
window._clLastLoadedAt = 0;

function openChangeLogModal() {
    document.getElementById('cl_search').value = '';
    clSwitchTab('detail');
    $('#modal_change_log').modal('show');
    loadChangeLog();

    if (window._clTickTimer) clearInterval(window._clTickTimer);
    window._clTickTimer = setInterval(_clUpdateLiveText, 1000);
}

document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('modal_change_log');
    if (modalEl && window.jQuery) {
        $(modalEl).on('hidden.bs.modal', function () {
            if (window._clTickTimer) { clearInterval(window._clTickTimer); window._clTickTimer = null; }
        });
    }
});

function _clUpdateLiveText() {
    var el = document.getElementById('cl-live-text');
    if (!el || !window._clLastLoadedAt) return;
    var secs = Math.floor((Date.now() - window._clLastLoadedAt) / 1000);
    if (secs < 5) el.textContent = 'Updated just now';
    else if (secs < 60) el.textContent = 'Updated ' + secs + 's ago';
    else el.textContent = 'Updated ' + Math.floor(secs / 60) + 'm ago';
}

function clSwitchTab(tab) {
    var isDetail = tab === 'detail';
    document.getElementById('cl-tab-detail').style.display = isDetail ? '' : 'none';
    document.getElementById('cl-tab-customer').style.display = isDetail ? 'none' : '';
    document.getElementById('cl-tab-btn-detail').classList.toggle('active', isDetail);
    document.getElementById('cl-tab-btn-customer').classList.toggle('active', !isDetail);
}

function _clFmt2(n) {
    if (n === null || n === undefined || n === '') return '-';
    return parseFloat(n).toLocaleString('id-ID', {minimumFractionDigits:2, maximumFractionDigits:2});
}

function _clFmtSigned(n) {
    n = parseFloat(n || 0);
    var s = Math.abs(n).toLocaleString('id-ID', {minimumFractionDigits:0, maximumFractionDigits:0});
    return (n > 0 ? '+' : (n < 0 ? '-' : '')) + s;
}

// Semua baris hari ini disimpan di sini biar search box bisa filter tanpa
// nge-hit server lagi.
window._clAllRows = [];

function loadChangeLog() {
    var pc = document.getElementById('dsb_pc') ? document.getElementById('dsb_pc').value : '<?= $selected_pc ?: "ALL"; ?>';

    var area = document.getElementById('cl-list-area');
    // Cuma nampilin placeholder "Loading..." kalau ini load pertama (belum ada
    // data sama sekali) - biar auto-refresh di background tidak bikin layar
    // kedip/flicker dan kehilangan posisi scroll/paging user.
    var isFirstLoad = !window._clAllRows.length;
    if (isFirstLoad) {
        area.innerHTML = '<p style="color:#aaa;text-align:center;padding:20px;"><i class="fas fa-spinner fa-spin"></i> Loading...</p>';
    }

    $.ajax({
        url: '<?= base_url("landingpage/data_change_log"); ?>',
        type: 'POST', dataType: 'json',
        data: { pc: pc },
        success: function(res) {
            if (!res.status) {
                area.innerHTML = '<p style="color:#e74c3c;text-align:center;padding:20px;">Failed to load data.</p>';
                return;
            }
            window._clAllRows = res.data || [];
            window._clLastLoadedAt = Date.now();
            _clUpdateLiveText();
            renderChangeLogRecon(res.ar_start_today, res.ar_now, res.sales_cm_start_today, res.sales_cm_now, res.sales_ytd_start_today, res.sales_ytd_now);
            // Plus/Minus Today TETAP dari SUM tbl_data_change_log (akurat per baris,
            // cocok dengan Detail Log) - JANGAN dipaksa ikut tanda reconDelta seperti
            // sebelumnya, karena itu bikin Plus tampil 0 padahal ada baris log yang
            // beneran nambah (cuma kalah besar dari pergerakan yang tidak ke-log).
            // Net Actual Today tetap dibuat sama dengan "Change Today" (sumber
            // ar_dashboard, PASTI cocok dashboard depan) - kalau angkanya beda dari
            // Plus-Minus versi log, itu sinyal ada pergerakan yang belum ke-cover
            // logging-nya, jadi ditampilkan sebagai catatan "gap" di kartu Net,
            // bukan disembunyikan dengan menimpa Plus/Minus.
            var reconDelta = (parseFloat(res.sales_cm_now || 0) - parseFloat(res.sales_cm_start_today || 0));
            var loggedNet = parseFloat(res.summary.delta_total || 0);
            var summaryForDisplay = Object.assign({}, res.summary, {
                delta_total: reconDelta,
                unlogged_gap: reconDelta - loggedNet
            });
            renderChangeLogSummary(summaryForDisplay);
            renderChangeLogBreakdown(res.breakdown);
            // Tetap terapin filter search yang lagi diketik user (kalau ada), biar
            // auto-refresh tidak nge-reset hasil pencarian yang sedang dilihat.
            var kw = (document.getElementById('cl_search').value || '').trim();
            if (kw) { filterChangeLogRows(); } else { renderChangeLogList(window._clAllRows); }
            renderChangeLogByCustomer(res.by_customer);
        },
        error: function() {
            area.innerHTML = '<p style="color:#e74c3c;text-align:center;padding:20px;">Failed to load data.</p>';
        }
    });
}

// Strip "Start of Day -> Change Today -> Now" - semua angka dihitung pakai
// fungsi & kolom PERSIS yang sama dengan kartu-kartu di dashboard depan
// (Account Receivable, Sales Current Month), jadi angka "Now" di sini DIJAMIN
// sama dengan yang di depan. Note: karena tbl_data_change_log cuma nyatet
// sebagian jalur (FG/OUT + Invoice Manual), "Change Today" di sini bisa beda
// dari total transaksi di tab Detail Log kalau ada perubahan AR/Sales lewat
// jalur lain yang belum ke-cover logging-nya.
function renderChangeLogRecon(arStartToday, arNow, salesCmStartToday, salesCmNow, salesYtdStartToday, salesYtdNow) {
    var wrap = document.getElementById('cl-recon');
    if (!wrap) return;
    // Account Receivable strip di-hide dulu sementara (belum dipakai) - tinggal
    // masukin lagi ke .cl-recon-row di bawah buat nyalain, data/plumbing-nya tetap ada.
    wrap.innerHTML = '<div class="cl-recon-row">' +
        _clReconStrip('Sales Current Month', salesCmStartToday, salesCmNow) +
        _clReconStrip('Sales Year to Date', salesYtdStartToday, salesYtdNow) +
    '</div>';
}

function _clReconStrip(title, startVal, nowVal) {
    var start = parseFloat(startVal || 0);
    var now = parseFloat(nowVal || 0);
    var diff = now - start;
    var diffColor = diff > 0 ? '#2e7d32' : (diff < 0 ? '#c62828' : '#666');
    var diffIcon = diff > 0 ? 'fa-arrow-up' : (diff < 0 ? 'fa-arrow-down' : 'fa-minus');

    return '<div class="cl-recon-strip" style="margin-bottom:0;">' +
        '<div class="cl-section-title" style="margin-bottom:12px;"><i class="fas fa-balance-scale"></i>' + title + ' Reconciliation (today, IDR) &mdash; matches the front dashboard</div>' +
        '<div class="cl-recon-flow">' +
            '<div class="cl-recon-node">' +
                '<div class="cl-recon-node-label">Start of Day</div>' +
                '<div class="cl-recon-node-value">IDR ' + _clFmt0(start) + '</div>' +
            '</div>' +
            '<div class="cl-recon-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>' +
            '<div class="cl-recon-node">' +
                '<div class="cl-recon-node-label" style="color:' + diffColor + ';">Change Today</div>' +
                '<div class="cl-recon-node-value" style="color:' + diffColor + ';"><i class="fas ' + diffIcon + ' mr-1"></i>' + _clFmtSigned(diff) + '</div>' +
            '</div>' +
            '<div class="cl-recon-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>' +
            '<div class="cl-recon-node">' +
                '<div class="cl-recon-node-label">Now (Actual)</div>' +
                '<div class="cl-recon-node-value" style="color:#3949ab;">IDR ' + _clFmt0(now) + '</div>' +
            '</div>' +
        '</div>' +
    '</div>';
}

function renderChangeLogSummary(summary) {
    var wrap = document.getElementById('cl-summary');
    if (!summary) { wrap.innerHTML = ''; return; }

    wrap.innerHTML =
        '<div class="d-flex flex-wrap" style="gap:12px;">' +

        '<div class="cl-kpi-card">' +
            '<i class="fas fa-exchange-alt cl-kpi-icon" style="color:#3949ab;"></i>' +
            '<div class="cl-kpi-label">Transactions Today</div>' +
            '<div class="cl-kpi-value" style="color:#3949ab;">' + (summary.cnt || 0) + '</div>' +
            '<div class="cl-kpi-sub">' + (summary.plus_cnt || 0) + ' up &middot; ' + (summary.minus_cnt || 0) + ' down</div>' +
        '</div>' +

        '<div class="cl-kpi-card">' +
            '<i class="fas fa-arrow-up cl-kpi-icon" style="color:#2e7d32;"></i>' +
            '<div class="cl-kpi-label">Plus Today (IDR)</div>' +
            '<div class="cl-kpi-value" style="color:#2e7d32;">+IDR ' + _clFmt0(summary.plus_total) + '</div>' +
            '<div class="cl-kpi-sub">Qty +' + _clFmt0(summary.plus_qty) + '</div>' +
        '</div>' +

        '<div class="cl-kpi-card">' +
            '<i class="fas fa-arrow-down cl-kpi-icon" style="color:#c62828;"></i>' +
            '<div class="cl-kpi-label">Minus Today (IDR)</div>' +
            '<div class="cl-kpi-value" style="color:#c62828;">-IDR ' + _clFmt0(summary.minus_total) + '</div>' +
            '<div class="cl-kpi-sub">Qty -' + _clFmt0(summary.minus_qty) + '</div>' +
        '</div>' +

        '<div class="cl-kpi-card" style="background:linear-gradient(135deg,#3949ab 0%,#5c6bc0 100%);">' +
            '<i class="fas fa-bullseye cl-kpi-icon" style="color:#fff;"></i>' +
            '<div class="cl-kpi-label" style="color:rgba(255,255,255,0.75);">Net Actual Today (IDR)</div>' +
            '<div class="cl-kpi-value" style="color:#fff;">' + _clFmtSigned(summary.delta_total) + '</div>' +
            '<div class="cl-kpi-sub" style="color:rgba(255,255,255,0.75);">Qty ' + _clFmtSigned(summary.delta_qty) + '</div>' +
            (Math.abs(summary.unlogged_gap || 0) >= 1
                ? '<div class="cl-kpi-sub" style="color:#ffe082;margin-top:4px;" title="Selisih antara Change Today (dashboard) dan total Plus/Minus di Detail Log - ada pergerakan yang belum tercatat di log ini.">' +
                    '<i class="fas fa-exclamation-triangle mr-1"></i>Unlogged: ' + _clFmtSigned(summary.unlogged_gap) +
                  '</div>'
                : '') +
        '</div>' +

        '</div>';
}

function _clFmt0(n) {
    n = parseFloat(n || 0);
    return Math.abs(n).toLocaleString('id-ID', {minimumFractionDigits:0, maximumFractionDigits:0});
}

// Tanggalnya selalu hari ini (Change Log cuma nampilin hari berjalan), jadi
// cukup tampilin jamnya aja - lebih ringkas & gampang dibaca daripada
// "2026-08-13 09:07:59" penuh tiap baris.
function _clFmtTime(dt) {
    if (!dt) return '-';
    var parts = dt.split(' ');
    var time = parts.length > 1 ? parts[1] : dt;
    return '<span style="display:inline-flex;align-items:center;gap:5px;background:#f0f1f8;color:#4a4f66;padding:3px 9px;border-radius:8px;font-weight:600;font-variant-numeric:tabular-nums;"><i class="fas fa-clock" style="font-size:10px;color:#9aa0b8;"></i>' + time + '</span>';
}

// Ringkasan dampak hari ini per buyer/customer - dicari lewat so_number yang
// tersimpan di baris log (bukan kolom customer langsung, karena tabelnya
// tidak nyimpen itu). Kalau so_number tidak ketemu -> masuk bucket "Unknown".
function renderChangeLogByCustomer(list) {
    var wrap = document.getElementById('cl-by-customer');
    if (!wrap) return;
    if (!list || !list.length) {
        wrap.innerHTML = '<p style="color:#aaa;text-align:center;padding:20px;">No customer-linked changes today.</p>';
        return;
    }
    var maxAbs = 0;
    var totalPlusAll = 0;
    list.forEach(function(c) {
        var mag = Math.abs(parseFloat(c.plus_total || 0)) + Math.abs(parseFloat(c.minus_total || 0));
        if (mag > maxAbs) maxAbs = mag;
        totalPlusAll += parseFloat(c.plus_total || 0);
    });
    if (maxAbs <= 0) maxAbs = 1;

    var html = '<div class="d-flex flex-column" style="gap:14px;">';
    list.forEach(function(c, idx) {
        var plus = parseFloat(c.plus_total || 0);
        var minus = parseFloat(c.minus_total || 0);
        var net = parseFloat(c.net_total || 0);
        var netColor = net > 0 ? '#2e7d32' : (net < 0 ? '#c62828' : '#666');
        var plusPct = (plus / maxAbs) * 100;
        var minusPct = (minus / maxAbs) * 100;
        var shareOfTotalPlus = totalPlusAll > 0 ? (plus / totalPlusAll) * 100 : 0;
        html += '<div class="cl-cust-card">' +
            '<div class="d-flex align-items-center" style="gap:14px;">' +
                '<div class="cl-cust-rank">#' + (idx + 1) + '</div>' +
                '<div class="flex-grow-1">' +
                    '<div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">' +
                        '<div class="cl-cust-name"><i class="fas fa-building mr-2" style="color:#9aa0b8;"></i>' + (c.customer || 'Unknown') + '</div>' +
                        '<div class="d-flex align-items-center" style="gap:8px;">' +
                            (shareOfTotalPlus > 0 ? '<span style="background:#e8f5e9;color:#2e7d32;font-size:11px;font-weight:800;padding:3px 9px;border-radius:8px;">' + shareOfTotalPlus.toFixed(1) + '% of total increase</span>' : '') +
                            '<span style="font-size:12px;color:#9aa0b8;font-weight:600;">' + (c.cnt || 0) + ' change(s) today</span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="cl-cust-bar-track">' +
                        '<div style="width:' + plusPct + '%;background:linear-gradient(90deg,#66bb6a,#43a047);"></div>' +
                        '<div style="width:' + minusPct + '%;background:linear-gradient(90deg,#ef5350,#e53935);"></div>' +
                    '</div>' +
                    '<div class="d-flex justify-content-between flex-wrap mt-3" style="gap:10px;">' +
                        '<div>' +
                            '<div class="cl-cust-figure-label">Plus</div>' +
                            '<div class="cl-cust-figure-value" style="color:#2e7d32;">+IDR ' + _clFmt0(plus) + '</div>' +
                        '</div>' +
                        '<div>' +
                            '<div class="cl-cust-figure-label">Minus</div>' +
                            '<div class="cl-cust-figure-value" style="color:#c62828;">-IDR ' + _clFmt0(minus) + '</div>' +
                        '</div>' +
                        '<div style="text-align:right;">' +
                            '<div class="cl-cust-figure-label">Net</div>' +
                            '<div class="cl-cust-figure-value" style="color:' + netColor + ';">' + _clFmtSigned(net) + ' IDR</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
    });
    html += '</div>';
    wrap.innerHTML = html;
}

// Ringkasan jumlah transaksi per jenis action (Create Invoice, Cancel Invoice,
// Edit SJ, dst) - biar langsung kelihatan komposisi perubahan hari ini tanpa
// harus scroll ke tabel.
function renderChangeLogBreakdown(breakdown) {
    var wrap = document.getElementById('cl-breakdown');
    if (!breakdown || !breakdown.length) { wrap.innerHTML = ''; return; }
    var html = '<div class="d-flex flex-wrap" style="gap:8px;">';
    breakdown.forEach(function(b) {
        html += '<div style="background:#fff;border:1px solid #e3e6f0;border-radius:8px;padding:4px 10px;display:flex;align-items:center;gap:6px;">' +
            _clActionBadge(b.action) +
            '<span style="font-size:12px;font-weight:bold;">' + b.cnt + '</span>' +
            '</div>';
    });
    wrap.innerHTML = html;
}

function filterChangeLogRows() {
    var kw = (document.getElementById('cl_search').value || '').toLowerCase().trim();
    if (!kw) {
        renderChangeLogList(window._clAllRows);
        return;
    }
    var filtered = window._clAllRows.filter(function(r) {
        return [r.doc_number, r.ref_number, r.so_number, r.product_item, r.customer, r.action, r.created_by]
            .some(function(v) { return (v || '').toString().toLowerCase().indexOf(kw) !== -1; });
    });
    renderChangeLogList(filtered);
}

function renderChangeLogList(rows) {
    var area = document.getElementById('cl-list-area');
    var countLabel = document.getElementById('cl-count-label');
    if (!rows || !rows.length) {
        area.innerHTML = '<p style="color:#aaa;text-align:center;padding:20px;">No changes found.</p>';
        if (countLabel) countLabel.textContent = '';
        return;
    }
    if (countLabel) countLabel.textContent = rows.length + ' row(s)';
    var html = '<table id="cl-detail-table" class="table table-striped text-nowrap" style="width:100%;font-size:12px;">' +
        '<thead><tr>' +
        '<th>Time</th><th>Customer</th><th>Doc Number</th><th>FG/OUT</th><th>SO</th><th>Item</th>' +
        '<th>Action</th><th>Field</th><th>Curr</th>' +
        '<th class="text-right">Qty</th><th class="text-right">Price (IDR)</th><th class="text-right">Total (IDR)</th>' +
        '</tr></thead><tbody>';

    rows.forEach(function(r) {
        html += '<tr>' +
            '<td>' + _clFmtTime(r.created_at) + '</td>' +
            '<td>' + _clCustomerBadge(r.customer) + '</td>' +
            '<td>' + (r.doc_number || '-') + '</td>' +
            '<td>' + (r.ref_number || '-') + '</td>' +
            '<td>' + (r.so_number || '-') + '</td>' +
            '<td>' + (r.product_item || '-') + '</td>' +
            '<td>' + _clActionBadge(r.action) + '</td>' +
            '<td>' + (r.field_name || '-') + '</td>' +
            '<td>' + _clCurrBadge(r.curr) + '</td>' +
            '<td class="text-right">' + _clDeltaCell(r.qty_old, r.qty_new) + '</td>' +
            '<td class="text-right">' + _clDeltaCell(r.price_old_idr, r.price_new_idr) + '</td>' +
            '<td class="text-right">' + _clDeltaCell(r.total_old_idr, r.total_new_idr) + '</td>' +
            '</tr>';
    });
    html += '</tbody></table>';
    area.innerHTML = html;

    // DataTable buat paging - dom diseting biar cuma nampilin length+table+info+
    // paginate (search bar bawaan disembunyiin karena kita udah punya #cl_search
    // sendiri buat filter window._clAllRows).
    if ($.fn.DataTable.isDataTable('#cl-detail-table')) {
        $('#cl-detail-table').DataTable().destroy();
    }
    $('#cl-detail-table').DataTable({
        paging: true,
        searching: false,
        ordering: false,
        info: true,
        lengthChange: true,
        lengthMenu: [10, 20, 50, 100],
        pageLength: 10,
        dom: '<"d-flex justify-content-between align-items-center mb-2"l>rtip'
    });
}

// Tag currency asli transaksi ini - bantu user tau nilai IDR di kolom Price/Total
// itu hasil konversi dari currency apa (kalau bukan IDR langsung).
function _clCurrBadge(curr) {
    curr = curr || 'IDR';
    var isIdr = curr === 'IDR';
    var bg = isIdr ? '#eef0f7' : '#fff3e0';
    var fg = isIdr ? '#6a6f85' : '#e65100';
    return '<span style="background:' + bg + ';color:' + fg + ';padding:1px 7px;border-radius:8px;font-size:10px;font-weight:700;">' + curr + '</span>';
}

// Badge customer/buyer - warnanya konsisten per nama (hash dari nama -> index
// palet tetap), jadi baris dari buyer yang sama gampang dikenalin sekilas
// tanpa harus baca teksnya satu-satu, dan tetap sama warnanya tiap refresh.
var _CL_CUST_PALETTE = [
    { bg: '#e3f2fd', fg: '#1565c0' }, // biru
    { bg: '#e8f5e9', fg: '#2e7d32' }, // hijau
    { bg: '#fff3e0', fg: '#e65100' }, // oranye
    { bg: '#f3e5f5', fg: '#7b1fa2' }, // ungu
    { bg: '#fce4ec', fg: '#c2185b' }, // pink
    { bg: '#e0f2f1', fg: '#00695c' }, // teal
    { bg: '#fff8e1', fg: '#f57f17' }, // kuning tua
    { bg: '#efebe9', fg: '#4e342e' }, // coklat
    { bg: '#e8eaf6', fg: '#283593' }, // indigo
    { bg: '#fbe9e7', fg: '#d84315' }  // merah bata
];
function _clCustomerBadge(customer) {
    if (!customer) return '<span style="color:#c7cbdb;font-size:11px;">-</span>';
    var hash = 0;
    for (var i = 0; i < customer.length; i++) { hash = (hash * 31 + customer.charCodeAt(i)) & 0xffffffff; }
    var color = _CL_CUST_PALETTE[Math.abs(hash) % _CL_CUST_PALETTE.length];
    return '<span style="background:' + color.bg + ';color:' + color.fg + ';padding:2px 8px;border-radius:8px;font-size:10.5px;font-weight:700;white-space:nowrap;">' + customer + '</span>';
}

// Badge warna per jenis action - hijau buat yang nambah data, merah buat yang
// membatalkan/reverse, biru buat edit.
function _clActionBadge(action) {
    if (!action) return '-';
    var a = action.toLowerCase();
    var bg = '#607d8b'; // default abu-abu
    if (a.indexOf('create') !== -1 || a.indexOf('confirm') !== -1) {
        bg = '#2e7d32'; // hijau
    } else if (a.indexOf('cancel') !== -1 || a.indexOf('reverse') !== -1) {
        bg = '#c62828'; // merah
    } else if (a.indexOf('edit') !== -1) {
        bg = '#1565c0'; // biru
    }
    return '<span style="background:' + bg + ';color:#fff;padding:2px 8px;border-radius:10px;font-size:11px;white-space:nowrap;">' + action + '</span>';
}

// Sel "old -> new" diwarnai: hijau kalau naik, merah kalau turun, abu-abu kalau sama.
function _clDeltaCell(oldVal, newVal) {
    if (oldVal === null && newVal === null) return '-';
    var o = parseFloat(oldVal || 0);
    var n = parseFloat(newVal || 0);
    var color = '#555';
    if (n > o) color = '#2e7d32';
    else if (n < o) color = '#c62828';
    return '<span style="color:' + color + ';font-weight:600;">' + _clFmt2(oldVal) + ' &rarr; ' + _clFmt2(newVal) + '</span>';
}

// Buat perubahan non-angka (mis. currency: USD -> IDR).
function _clTextDeltaCell(oldVal, newVal) {
    if ((oldVal === null || oldVal === undefined) && (newVal === null || newVal === undefined)) return '-';
    if (oldVal === newVal) return oldVal || '-';
    return '<span style="color:#1565c0;font-weight:600;">' + (oldVal || '-') + ' &rarr; ' + (newVal || '-') + '</span>';
}
</script>

<script>
// Pesan status bergantian selama nunggu sync (biasanya sekitar 5-8 detik) -
// biar nunggunya kerasa lebih hidup & informatif, bukan cuma satu teks statis.
var DSB_SYNC_MESSAGES = [
    'Syncing latest data...',
    'Fetching sales figures...',
    'Calculating receivables...',
    'Crunching shipment data...',
    'Almost there...'
];

function _dsbStartSyncMessages() {
    var sub = document.getElementById('dsb-sync-sub');
    if (!sub) return null;
    var i = 0;
    return setInterval(function () {
        i = (i + 1) % DSB_SYNC_MESSAGES.length;
        sub.style.opacity = 0;
        setTimeout(function () {
            sub.textContent = DSB_SYNC_MESSAGES[i];
            sub.style.opacity = 1;
        }, 200);
    }, 1400);
}

document.addEventListener('DOMContentLoaded', function () {
    var overlay = document.getElementById('dsb-sync-overlay');
    if (!overlay) return;

    var THROTTLE_MS = 30000; // sinkron ulang cuma kalau data terakhir lebih tua dari ini
    var lastSyncAt = parseInt(sessionStorage.getItem('dsb_synced_at') || '0', 10);

    if (Date.now() - lastSyncAt < THROTTLE_MS) {
        overlay.style.display = 'none';
        return;
    }

    var msgTimer = _dsbStartSyncMessages();

    $.ajax({
        url: '<?= base_url("landingpage/sync_dashboard_ajax"); ?>',
        type: 'POST', dataType: 'json', timeout: 60000,
        success: function (res) {
            sessionStorage.setItem('dsb_synced_at', Date.now());
            if (msgTimer) clearInterval(msgTimer);
            if (res.status && !res.skipped) {
                document.getElementById('dsb-sync-sub').textContent = 'Loading latest data...';
                setTimeout(function () { location.reload(); }, 400);
            } else {
                overlay.style.opacity = 0;
                setTimeout(function () { overlay.style.display = 'none'; }, 350);
            }
        },
        error: function () {
            sessionStorage.setItem('dsb_synced_at', Date.now());
            if (msgTimer) clearInterval(msgTimer);
            overlay.style.opacity = 0;
            setTimeout(function () { overlay.style.display = 'none'; }, 350);
        }
    });
});

// Auto-refresh dashboard depan setiap 1 menit TANPA reload halaman - cuma
// nge-patch angka KPI + jam "last update" di DOM. Server-side sudah dijaga
// throttle per-menit (dashboard_kpi_refresh), jadi aman meski banyak tab/user
// buka dashboard bersamaan - stored procedure beratnya cuma jalan sekali per
// menit, request lain di menit yang sama cuma re-SELECT nilai yang sudah ada.
var DSB_KPI_REFRESH_MS = 60000;

// Search box di modal detail per-customer (Sales YTD, dsb) - filter kartu
// yang sudah dirender server-side, murni client-side, tanpa AJAX ulang.
function _slsFilterCards(inputEl, listId) {
    var kw = (inputEl.value || '').toLowerCase().trim();
    var list = document.getElementById(listId);
    if (!list) return;
    var cards = list.querySelectorAll('.sls-cust-card');
    var visibleCount = 0;
    cards.forEach(function (card) {
        var match = !kw || (card.getAttribute('data-sls-name') || '').indexOf(kw) !== -1;
        card.style.display = match ? '' : 'none';
        if (match) visibleCount++;
    });
    var noResult = list.querySelector('.sls-no-result');
    if (noResult) noResult.style.display = visibleCount === 0 ? '' : 'none';
}

// Auto-refresh modal detail Sales & AR (semuanya) tiap 1 menit selama
// modalnya kebuka - cuma re-SELECT dari ar_dashboard (murah, tidak nge-
// trigger stored procedure), jadi aman dipoll tiap menit. Timer per-modal
// disimpen di elemen modal-nya sendiri, berhenti otomatis begitu ditutup.
var _slsFmt0 = function (n) { return parseFloat(n || 0).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }); };
var _slsFmt2 = function (n) { return parseFloat(n || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); };

// Render ulang kartu buat modal "shape Sales" (qty/uom/avg_price/total).
function _slsRenderSalesCards(rows, listId, sumPrefix) {
    var listEl = document.getElementById(listId);
    if (!listEl) return;

    var ttlQty = 0, ttlTotal = 0, maxTotal = 0;
    rows.forEach(function (r) {
        ttlQty += parseFloat(r.qty || 0);
        ttlTotal += parseFloat(r.total || 0);
        if (parseFloat(r.total || 0) > maxTotal) maxTotal = parseFloat(r.total || 0);
    });
    if (maxTotal <= 0) maxTotal = 1;

    var countEl  = document.getElementById('sls-sum-count-' + sumPrefix);
    var qtyCardEl = document.getElementById('sls-sum-qtycard-' + sumPrefix);
    var totEl    = document.getElementById('sls-sum-total-' + sumPrefix);
    var topEl    = document.getElementById('sls-sum-top-' + sumPrefix);
    if (countEl) countEl.textContent = rows.length;
    if (totEl) totEl.textContent = _slsFmt2(ttlTotal);

    // Grup qty per satuan aslinya (sama seperti versi PHP) - jangan ditumpuk
    // jadi 1 angka kalau datanya campuran satuan (misal filter ALL gabung
    // NAG/PCS dan NAK/Kilogram).
    if (qtyCardEl) {
        var qtyByUom = {};
        rows.forEach(function (r) {
            var uom = (r.uom || 'PCS').toString().trim() || 'PCS';
            qtyByUom[uom] = (qtyByUom[uom] || 0) + parseFloat(r.qty || 0);
        });
        var uomKeys = Object.keys(qtyByUom);
        var qtyHtml = '<i class="fas fa-boxes sls-sum-icon" style="color:#00897b;"></i>';
        if (uomKeys.length > 1) {
            qtyHtml += '<div class="sls-sum-label">Total Qty</div><div class="sls-sum-curr-list">';
            uomKeys.forEach(function (uom) {
                qtyHtml += '<div class="sls-sum-curr-row"><span class="curr-code">' + uom + '</span><span class="curr-amt">' + (uom === 'PCS' ? _slsFmt0(qtyByUom[uom]) : _slsFmt2(qtyByUom[uom])) + '</span></div>';
            });
            qtyHtml += '</div>';
        } else {
            var onlyUom = uomKeys.length ? uomKeys[0] : 'PCS';
            qtyHtml += '<div class="sls-sum-label">Total Qty (' + onlyUom + ')</div>' +
                '<div class="sls-sum-value">' + (onlyUom === 'PCS' ? _slsFmt0(ttlQty) : _slsFmt2(ttlQty)) + '</div>';
        }
        qtyHtml += '<div class="sls-sum-sub">across all customers</div>';
        qtyCardEl.innerHTML = qtyHtml;
    }
    if (topEl) {
        topEl.textContent = rows.length ? ('Top: ' + rows[0].customer + ' (' + (ttlTotal > 0 ? (parseFloat(rows[0].total) / ttlTotal * 100).toFixed(1) : '0.0') + '%)') : '';
    }

    var html = '';
    rows.forEach(function (r, i) {
        var pct = ttlTotal > 0 ? (parseFloat(r.total) / ttlTotal * 100).toFixed(1) : '0.0';
        var barPct = Math.min(100, parseFloat(r.total) / maxTotal * 100);
        html += '<div class="sls-cust-card" data-sls-name="' + (r.customer || '').toLowerCase() + '">' +
            '<div class="sls-cust-rank' + (i < 3 ? ' top3' : '') + '">#' + (i + 1) + '</div>' +
            '<div class="sls-cust-body">' +
                '<div class="sls-cust-name">' + (r.customer || '-') + '</div>' +
                '<div class="sls-cust-bar-track"><div class="sls-cust-bar" style="width:' + barPct + '%;"></div></div>' +
            '</div>' +
            '<div class="sls-cust-fig"><div class="sls-cust-fig-label">% of Total</div><div class="sls-cust-pct">' + pct + '%</div></div>' +
            '<div class="sls-cust-figures">' +
                '<div class="sls-cust-fig"><div class="sls-cust-fig-label">Qty</div><div class="sls-cust-fig-value">' + (r.uom === 'PCS' ? _slsFmt0(r.qty) : _slsFmt2(r.qty)) + ' ' + (r.uom || '') + '</div></div>' +
                '<div class="sls-cust-fig"><div class="sls-cust-fig-label">Avg Price</div><div class="sls-cust-fig-value">IDR ' + _slsFmt2(r.avg_price) + '</div></div>' +
                '<div class="sls-cust-fig wide"><div class="sls-cust-fig-label">Total</div><div class="sls-cust-fig-value emph">IDR ' + _slsFmt2(r.total) + '</div></div>' +
            '</div>' +
        '</div>';
    });
    html += '<p class="sls-no-result" style="display:none;color:#aaa;text-align:center;padding:20px;">No customer matches your search.</p>';
    listEl.innerHTML = html;
    _slsReapplyFilter(listId);
}

// Render ulang kartu buat modal "shape AR" (curr/total_idr/ready_due/not_due).
function _slsRenderArCards(rows, listId, sumPrefix, valueField, valueLabel) {
    var listEl = document.getElementById(listId);
    if (!listEl) return;

    rows = rows.slice().sort(function (a, b) { return parseFloat(b[valueField] || 0) - parseFloat(a[valueField] || 0); });

    var ttlValue = 0, maxValue = 0, localValue = 0, exportValue = 0;
    var localByCurr = {}, exportByCurr = {};
    rows.forEach(function (r) {
        var v = parseFloat(r[valueField] || 0);
        ttlValue += v;
        if (v > maxValue) maxValue = v;
        // trim() penting - data live kadang ada spasi nyempil di curr, kalau tidak
        // di-trim bisa keanggep 2 currency beda padahal sama.
        var currKey = (r.curr || '').toString().trim();
        if (r.shipp === 'Local') {
            localValue += v;
            localByCurr[currKey] = (localByCurr[currKey] || 0) + parseFloat(r.total || 0);
        } else if (r.shipp === 'Export') {
            exportValue += v;
            exportByCurr[currKey] = (exportByCurr[currKey] || 0) + parseFloat(r.total || 0);
        }
    });
    if (maxValue <= 0) maxValue = 1;

    var renderByCurr = function (byCurr) {
        var keys = Object.keys(byCurr);
        if (!keys.length) return '<div class="sls-sum-curr-row"><span class="curr-amt" style="color:#c7cbdb;">No data</span></div>';
        var html = '';
        keys.forEach(function (curr) {
            html += '<div class="sls-sum-curr-row"><span class="curr-code">' + curr + '</span><span class="curr-amt">' + _slsFmt2(byCurr[curr]) + '</span></div>';
        });
        return html;
    };

    var countEl    = document.getElementById('sls-sum-count-' + sumPrefix);
    var totEl      = document.getElementById('sls-sum-total-' + sumPrefix);
    var topEl      = document.getElementById('sls-sum-top-' + sumPrefix);
    var localEl    = document.getElementById('sls-sum-local-' + sumPrefix);
    var localPEl   = document.getElementById('sls-sum-local-pct-' + sumPrefix);
    var localOEl   = document.getElementById('sls-sum-local-orig-' + sumPrefix);
    var expEl      = document.getElementById('sls-sum-export-' + sumPrefix);
    var expPEl     = document.getElementById('sls-sum-export-pct-' + sumPrefix);
    var expOEl     = document.getElementById('sls-sum-export-orig-' + sumPrefix);
    if (countEl) countEl.textContent = rows.length;
    if (totEl) totEl.textContent = _slsFmt2(ttlValue);
    if (topEl) {
        topEl.textContent = rows.length ? ('Top: ' + rows[0].customer + ' (' + (ttlValue > 0 ? (parseFloat(rows[0][valueField]) / ttlValue * 100).toFixed(1) : '0.0') + '%)') : '';
    }
    if (localEl) localEl.textContent = _slsFmt2(localValue);
    if (localPEl) localPEl.textContent = (ttlValue > 0 ? (localValue / ttlValue * 100).toFixed(1) : '0.0') + '% of total';
    if (localOEl) localOEl.innerHTML = renderByCurr(localByCurr);
    if (expEl) expEl.textContent = _slsFmt2(exportValue);
    if (expPEl) expPEl.textContent = (ttlValue > 0 ? (exportValue / ttlValue * 100).toFixed(1) : '0.0') + '% of total';
    if (expOEl) expOEl.innerHTML = renderByCurr(exportByCurr);

    var html = '';
    rows.forEach(function (r, i) {
        var pct = ttlValue > 0 ? (parseFloat(r[valueField]) / ttlValue * 100).toFixed(1) : '0.0';
        var barPct = Math.min(100, parseFloat(r[valueField]) / maxValue * 100);
        html += '<div class="sls-cust-card" data-sls-name="' + (r.customer || '').toLowerCase() + '">' +
            '<div class="sls-cust-rank' + (i < 3 ? ' top3' : '') + '">#' + (i + 1) + '</div>' +
            '<div class="sls-cust-body">' +
                '<div class="sls-cust-name">' + (r.customer || '-') + '</div>' +
                '<div style="font-size:11px;color:#9aa0b8;margin-top:1px;">' + (r.shipp || '') + ' &middot; <span class="badge badge-light" style="font-weight:700;">' + (r.curr || '') + '</span></div>' +
                '<div class="sls-cust-bar-track"><div class="sls-cust-bar" style="width:' + barPct + '%;background:linear-gradient(90deg,#e57373,#c62828);"></div></div>' +
            '</div>' +
            '<div class="sls-cust-fig"><div class="sls-cust-fig-label">% of Total</div><div class="sls-cust-pct" style="color:#c62828;">' + pct + '%</div></div>' +
            '<div class="sls-cust-figures">' +
                '<div class="sls-cust-fig"><div class="sls-cust-fig-label">Original (' + (r.curr || '') + ')</div><div class="sls-cust-fig-value">' + _slsFmt2(r.total) + '</div></div>' +
                '<div class="sls-cust-fig wide"><div class="sls-cust-fig-label">' + valueLabel + ' (IDR)</div><div class="sls-cust-fig-value emph" style="color:#c62828;">IDR ' + _slsFmt2(r[valueField]) + '</div></div>' +
            '</div>' +
        '</div>';
    });
    html += '<p class="sls-no-result" style="display:none;color:#aaa;text-align:center;padding:20px;">No records match your search.</p>';
    listEl.innerHTML = html;
    _slsReapplyFilter(listId);
}

// Terapin ulang filter search yang lagi diketik user (kalau ada) setelah re-render.
function _slsReapplyFilter(listId) {
    var listEl = document.getElementById(listId);
    if (!listEl) return;
    var searchInput = listEl.closest('.modal-body') ? listEl.closest('.modal-body').querySelector('input[placeholder="Search customer..."]') : null;
    if (searchInput && searchInput.value.trim()) {
        _slsFilterCards(searchInput, listId);
    }
}

function _slsLoadSalesDetail(report, listId, sumPrefix) {
    var pc = document.getElementById('dsb_pc') ? document.getElementById('dsb_pc').value : '<?= $selected_pc ?: "ALL"; ?>';
    $.ajax({
        url: '<?= base_url("landingpage/sales_detail_refresh"); ?>',
        type: 'POST', dataType: 'json', timeout: 60000,
        data: { pc: pc, report: report },
        success: function (res) {
            if (res && res.status) _slsRenderSalesCards(res.data || [], listId, sumPrefix);
        }
    });
}

function _slsLoadArDetail(report, listId, sumPrefix, valueField, valueLabel) {
    var pc = document.getElementById('dsb_pc') ? document.getElementById('dsb_pc').value : '<?= $selected_pc ?: "ALL"; ?>';
    $.ajax({
        url: '<?= base_url("landingpage/ar_detail_refresh"); ?>',
        type: 'POST', dataType: 'json', timeout: 60000,
        data: { pc: pc, report: report },
        success: function (res) {
            if (res && res.status) _slsRenderArCards(res.data || [], listId, sumPrefix, valueField, valueLabel);
        }
    });
}

// Ikat auto-refresh 1 menit ke satu modal: mulai pas modal dibuka, berhenti
// pas ditutup. Timer disimpen sebagai properti di elemen modal-nya sendiri.
function _slsBindModalAutoRefresh(modalId, loadFn) {
    var modalEl = document.getElementById(modalId);
    if (!modalEl || !window.jQuery) return;
    $(modalEl).on('shown.bs.modal', function () {
        if (modalEl._slsTimer) clearInterval(modalEl._slsTimer);
        loadFn();
        modalEl._slsTimer = setInterval(loadFn, 60000);
    });
    $(modalEl).on('hidden.bs.modal', function () {
        if (modalEl._slsTimer) { clearInterval(modalEl._slsTimer); modalEl._slsTimer = null; }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    if (!window.jQuery) return;
    _slsBindModalAutoRefresh('modal_slsytd',  function () { _slsLoadSalesDetail('ytd',  'sls-list-ytd',  'ytd'); });
    _slsBindModalAutoRefresh('modal_slscm',   function () { _slsLoadSalesDetail('cm',   'sls-list-cm',   'cm'); });
    _slsBindModalAutoRefresh('modal_slsytd2', function () { _slsLoadSalesDetail('ytd2', 'sls-list-ytd2', 'ytd2'); });
    _slsBindModalAutoRefresh('modal_slscm2',  function () { _slsLoadSalesDetail('cm2',  'sls-list-cm2',  'cm2'); });
    _slsBindModalAutoRefresh('modal_slsni',   function () { _slsLoadSalesDetail('ni',   'sls-list-ni',   'ni'); });
    _slsBindModalAutoRefresh('modal_total_ar',      function () { _slsLoadArDetail('ar',      'ar-list-total',   'ar',      'total_idr', 'Total'); });
    _slsBindModalAutoRefresh('modal_total_overdue', function () { _slsLoadArDetail('overdue', 'ar-list-overdue', 'overdue', 'ready_due', 'Overdue'); });
    _slsBindModalAutoRefresh('modal_total_notdue',  function () { _slsLoadArDetail('notdue',  'ar-list-notdue',  'notdue',  'not_due',   'Not Due'); });
});

function _dsbPatchKpiValues(res) {
    if (!res || !res.status || !res.kpi) return;
    Object.keys(res.kpi).forEach(function (key) {
        var el = document.querySelector('.kpi-value[data-kpi-key="' + key + '"]');
        if (!el) return;
        var val = parseFloat(res.kpi[key]) || 0;
        var oldVal = parseFloat(el.getAttribute('data-kpi-raw')) || 0;
        el.setAttribute('data-kpi-raw', val);
        el.textContent = 'IDR ' + val.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Flash halus di kartunya kalau nilainya beneran berubah dari sebelumnya -
        // biar user sadar ada data baru yang masuk tanpa harus baca ulang angkanya.
        if (Math.abs(val - oldVal) > 0.005) {
            var card = el.closest('.dsb-card');
            if (card) {
                card.classList.remove('kpi-flash-anim');
                void card.offsetWidth; // restart animasi
                card.classList.add('kpi-flash-anim');
            }
        }
    });
    if (res.last_update_fmt) {
        document.querySelectorAll('.kpi-lu-text').forEach(function (el) {
            el.textContent = res.last_update_fmt;
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    if (!document.querySelector('[data-kpi-key]')) return; // halaman "no_dashboard" - tidak ada kartu KPI

    setInterval(function () {
        var pc = document.getElementById('dsb_pc') ? document.getElementById('dsb_pc').value : '<?= $selected_pc ?: "ALL"; ?>';
        $.ajax({
            url: '<?= base_url("landingpage/dashboard_kpi_refresh"); ?>',
            type: 'POST', dataType: 'json', timeout: 60000,
            data: { pc: pc },
            success: function (res) {
                _dsbPatchKpiValues(res);
                // Change Log "numpang" di timer ini (lihat catatan di openChangeLogModal)
                // - cuma ditarik ulang kalau modalnya lagi kebuka, dan SETELAH dashboard
                // kelar sync, biar keduanya baca ar_dashboard di state yang sama persis.
                var clModal = document.getElementById('modal_change_log');
                if (clModal && clModal.classList.contains('show')) {
                    loadChangeLog();
                }
            }
        });
    }, DSB_KPI_REFRESH_MS);
});

function refreshDashboard() {
    var btn = document.getElementById('btn-refresh-dsb');
    var overlay = document.getElementById('dsb-sync-overlay');
    var sub = document.getElementById('dsb-sync-sub');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-sync-alt fa-spin-custom" id="icon-refresh"></i> Processing...';

    var msgTimer = null;
    if (overlay) {
        overlay.style.display = 'block';
        overlay.style.opacity = 1;
        if (sub) sub.textContent = 'Refreshing dashboard data...';
        overlay.scrollIntoView({ behavior: 'smooth', block: 'start' });
        msgTimer = _dsbStartSyncMessages();
    }

    $.ajax({
        url: '<?= base_url("landingpage/refresh_dashboard"); ?>',
        type: 'POST', dataType: 'json', timeout: 300000,
        success: function (res) {
            if (msgTimer) clearInterval(msgTimer);
            if (res.status) {
                sessionStorage.setItem('dsb_synced_at', Date.now());
                if (sub) sub.textContent = 'Latest data ready, reloading...';
                setTimeout(function () { location.reload(); }, 500);
            } else {
                if (overlay) { overlay.style.opacity = 0; setTimeout(function () { overlay.style.display = 'none'; }, 350); }
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync-alt" id="icon-refresh"></i> Refresh Data';
                Swal.fire({
                    icon: 'warning',
                    title: '<span style="color:#e65100;font-size:18px;">Refresh Failed</span>',
                    html: '<p style="font-size:13px;color:#555;">An error occurred while refreshing the data.<br>Please try again or contact the administrator.</p>',
                    confirmButtonText: 'Try Again', confirmButtonColor: '#e65100',
                    showCancelButton: true, cancelButtonText: 'Close', cancelButtonColor: '#9e9e9e'
                }).then(function(r) { if (r.isConfirmed) refreshDashboard(); });
            }
        },
        error: function () {
            if (msgTimer) clearInterval(msgTimer);
            if (overlay) { overlay.style.opacity = 0; setTimeout(function () { overlay.style.display = 'none'; }, 350); }
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync-alt" id="icon-refresh"></i> Refresh Data';
            Swal.fire({ icon: 'error', title: 'Connection Failed', text: 'Unable to reach the server. Please try again.', confirmButtonColor: '#3949ab' });
        }
    });
}
</script>

