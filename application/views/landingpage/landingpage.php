
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
}
.dsb-card .kpi-footer {
    background: rgba(0,0,0,0.04);
    border-top: 1px solid rgba(0,0,0,0.06);
    text-align: center;
    padding: 6px 10px;
    font-size: 1rem;
    font-weight: 700;
    color: #4a5568;
}

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
.kpi-log-btn {
    display: inline-block;
    margin-left: 6px;
    cursor: pointer;
    color: #9fa8da;
    opacity: 0.7;
    transition: opacity .15s, color .15s;
}
.kpi-log-btn:hover { opacity: 1; color: #3949ab; }
.kpi-log-btn i { font-size: 10px; }

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
                        <!-- Tombol Refresh Data — tampil hanya jika punya role dsb_refresh -->
                        <?php if (!empty($can_refresh)) : ?>
                        <button id="btn-refresh-dsb" type="button" class="btn btn-sm btn-outline-primary"
                                onclick="refreshDashboard()"
                                title="Refresh semua data dashboard"
                                style="border-radius:20px; white-space:nowrap;">
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
                                    <div class="kpi-value" data-kpi-key="sls_ytd_inv" data-kpi-raw="<?= (float)$sls_ytd_inv; ?>">IDR <?= number_format((float)$sls_ytd_inv, 2); ?></div>
                                    <div class="kpi-last-update" id="lu_sls_ytd_inv"><i class="fas fa-clock"></i> <?= $last_update_fmt; ?> <span class="kpi-log-btn" onclick="event.stopPropagation();showKpiLog('sls_ytd_inv','Sales YTD Invoiced')" title="Lihat log perubahan"><i class="fas fa-history"></i></span></div>
                                </div>
                            </div>

                            <!-- Sales Current Month Invoiced -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slscm()">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-calendar-check"></i>
                                        <span><a href="<?= base_url('report/frm_sales_report'); ?>" target="blank">Sales Current Month (Invoiced)</a></span>
                                    </div>
                                    <div class="kpi-value" data-kpi-key="sls_cm_inv" data-kpi-raw="<?= (float)$sls_cm_inv; ?>">IDR <?= number_format((float)$sls_cm_inv, 2); ?></div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <?= $last_update_fmt; ?> <span class="kpi-log-btn" onclick="event.stopPropagation();showKpiLog('sls_cm_inv','Sales CM Invoiced')" title="Lihat log perubahan"><i class="fas fa-history"></i></span></div>
                                </div>
                            </div>

                            <!-- Sales YTD (all) -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slsytd2()">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-chart-bar"></i>
                                        <span>Sales YTD</span>
                                    </div>
                                    <div class="kpi-value" data-kpi-key="sls_ytd_all" data-kpi-raw="<?= (float)$sls_no_inv + (float)$sls_ytd_inv; ?>">IDR <?= number_format((float)$sls_no_inv + (float)$sls_ytd_inv, 2); ?></div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <?= $last_update_fmt; ?> <span class="kpi-log-btn" onclick="event.stopPropagation();showKpiLog('sls_ytd_all','Sales YTD (All)')" title="Lihat log perubahan"><i class="fas fa-history"></i></span></div>
                                </div>
                            </div>

                            <!-- Sales Current Month (all) -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slscm2()">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Sales Current Month</span>
                                    </div>
                                    <div class="kpi-value" data-kpi-key="sls_cm_all" data-kpi-raw="<?= (float)$sls_cm_no_inv + (float)$sls_cm_inv; ?>">IDR <?= number_format((float)$sls_cm_no_inv + (float)$sls_cm_inv, 2); ?></div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <?= $last_update_fmt; ?> <span class="kpi-log-btn" onclick="event.stopPropagation();showKpiLog('sls_cm_all','Sales CM (All)')" title="Lihat log perubahan"><i class="fas fa-history"></i></span></div>
                                </div>
                            </div>

                            <!-- Sales Not Invoiced -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_slsni()">
                                    <div class="card-header bg-success text-white">
                                        <i class="fas fa-shipping-fast"></i>
                                        <span><a href="<?= base_url('arnag/frm_report_sj_not_invoice'); ?>" target="blank">Sales (Not Invoiced)</a></span>
                                    </div>
                                    <div class="kpi-value" data-kpi-key="sls_no_inv" data-kpi-raw="<?= (float)$sls_no_inv; ?>">IDR <?= number_format((float)$sls_no_inv, 2); ?></div>
                                    <div class="kpi-footer">
                                        <?php
                                            $denom  = $sls_ytd_inv ?: $sls_no_inv;
                                            $result = ($denom > 0) ? ($sls_no_inv / $denom * 100) : 0;
                                            echo number_format($result, 2);
                                        ?> %
                                    </div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <?= $last_update_fmt; ?> <span class="kpi-log-btn" onclick="event.stopPropagation();showKpiLog('sls_no_inv','Sales Not Invoiced')" title="Lihat log perubahan"><i class="fas fa-history"></i></span></div>
                                </div>
                            </div>

                            <!-- Account Receivable -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_total_ar()">
                                    <div class="card-header bg-danger text-white">
                                        <i class="fas fa-hand-holding-usd"></i>
                                        <span>Account Receivable</span>
                                    </div>
                                    <div class="kpi-value" data-kpi-key="ar_eqvidr" data-kpi-raw="<?= (float)$ar_eqvidr; ?>">IDR <?= number_format((float)$ar_eqvidr, 2); ?></div>
                                    <div class="kpi-footer">100.00 %</div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <?= $last_update_fmt; ?> <span class="kpi-log-btn" onclick="event.stopPropagation();showKpiLog('ar_idr','Account Receivable')" title="Lihat log perubahan"><i class="fas fa-history"></i></span></div>
                                </div>
                            </div>

                            <!-- Overdue Receivable -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_total_overdue()">
                                    <div class="card-header bg-danger text-white">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span><a href="<?= base_url('arnag/kartu_ar_detail'); ?>" target="blank">Overdue Receivable</a></span>
                                    </div>
                                    <div class="kpi-value" data-kpi-key="ready_due" data-kpi-raw="<?= (float)$ready_due; ?>">IDR <?= number_format((float)$ready_due, 2); ?></div>
                                    <div class="kpi-footer"><?= number_format((float)$ar_eqvidr > 0 ? ((float)$ready_due / (float)$ar_eqvidr * 100) : 0, 2); ?> %</div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <?= $last_update_fmt; ?> <span class="kpi-log-btn" onclick="event.stopPropagation();showKpiLog('ready_due','Overdue Receivable')" title="Lihat log perubahan"><i class="fas fa-history"></i></span></div>
                                </div>
                            </div>

                            <!-- Not Due Receivable -->
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
                                <div class="card dsb-card" onclick="showdata_total_notdue()">
                                    <div class="card-header bg-danger text-white">
                                        <i class="fas fa-check-circle"></i>
                                        <span><a href="<?= base_url('arnag/kartu_ar_detail'); ?>" target="blank">Not Due Receivable</a></span>
                                    </div>
                                    <div class="kpi-value" data-kpi-key="not_due" data-kpi-raw="<?= (float)($ar_eqvidr - $ready_due); ?>">IDR <?= number_format((float)($ar_eqvidr - $ready_due), 2); ?></div>
                                    <div class="kpi-footer"><?= number_format((float)$ar_eqvidr > 0 ? (((float)$ar_eqvidr - (float)$ready_due) / (float)$ar_eqvidr * 100) : 0, 2); ?> %</div>
                                    <div class="kpi-last-update"><i class="fas fa-clock"></i> <?= $last_update_fmt; ?> <span class="kpi-log-btn" onclick="event.stopPropagation();showKpiLog('not_due','Not Due Receivable')" title="Lihat log perubahan"><i class="fas fa-history"></i></span></div>
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
</div><!-- /.content-wrapper -->


<!-- ══════════ MODALS ══════════ -->

<!-- Overdue Aging -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-clock mr-2"></i>Overdue Receivable Aging</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"><div id="det_overdue"></div></div>
        </div>
    </div>
</div>

<!-- Sales YTD Invoiced -->
<div class="modal fade" id="modal_slsytd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-file-invoice-dollar mr-2"></i>Sales YTD (Invoiced)</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height:400px">
                    <table id="tbl_slsytd" class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th>Unit</th><th class="text-right">Curr</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php if (!empty($data_slsytd)): ?>
                                <?php foreach ($data_slsytd as $dsy): $ttl_qty += $dsy['qty']; $ttl_total += $dsy['total']; ?>
                                    <tr>
                                        <td><?= $dsy['customer']; ?></td>
                                        <td class="text-right"><?= ($dsy['uom'] == 'PCS') ? number_format($dsy['qty'], 0) : number_format($dsy['qty'], 2); ?></td>
                                        <td><?= $dsy['uom']; ?></td>
                                        <td class="text-right">IDR</td>
                                        <td class="text-right"><?= number_format($dsy['avg_price'], 2); ?></td>
                                        <td class="text-right"><?= number_format($dsy['total'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="font-weight-bold bg-light">
                                    <td>Total</td><td class="text-right"><?= number_format($ttl_qty, 2); ?></td><td></td><td class="text-right">IDR</td><td></td><td class="text-right"><?= number_format($ttl_total, 2); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center text-muted">No Data Available</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales CM Invoiced -->
<div class="modal fade" id="modal_slscm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-calendar-check mr-2"></i>Sales Current Month (Invoiced)</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height:400px">
                    <table id="tbl_slscm" class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th>Unit</th><th class="text-right">Curr</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php if (!empty($data_slscm)): ?>
                                <?php foreach ($data_slscm as $dsc): $ttl_qty += $dsc['qty']; $ttl_total += $dsc['total']; ?>
                                    <tr>
                                        <td><?= $dsc['customer']; ?></td>
                                        <td class="text-right"><?= ($dsc['uom'] == 'PCS') ? number_format($dsc['qty'], 0) : number_format($dsc['qty'], 2); ?></td>
                                        <td><?= $dsc['uom']; ?></td>
                                        <td class="text-right">IDR</td>
                                        <td class="text-right"><?= number_format($dsc['avg_price'], 2); ?></td>
                                        <td class="text-right"><?= number_format($dsc['total'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="font-weight-bold bg-light">
                                    <td>Total</td><td class="text-right"><?= number_format($ttl_qty, 2); ?></td><td></td><td class="text-right">IDR</td><td></td><td class="text-right"><?= number_format($ttl_total, 2); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center text-muted">No Data Available</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales YTD All -->
<div class="modal fade" id="modal_slsytd2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-chart-bar mr-2"></i>Sales YTD</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height:400px">
                    <table id="tbl_slsytd2" class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th>Unit</th><th class="text-right">Curr</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php foreach ($data_slsytd2 as $dsy2): $ttl_qty += $dsy2['qty']; $ttl_total += $dsy2['total']; ?>
                                <tr>
                                    <td><?= $dsy2['customer']; ?></td>
                                    <td class="text-right"><?= ($dsy2['uom'] == 'PCS') ? number_format($dsy2['qty'], 0) : number_format($dsy2['qty'], 2); ?></td>
                                    <td><?= $dsy2['uom']; ?></td>
                                    <td class="text-right">IDR</td>
                                    <td class="text-right"><?= number_format($dsy2['avg_price'], 2); ?></td>
                                    <td class="text-right"><?= number_format($dsy2['total'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td>Total</td>
                                <td class="text-right"><?= number_format($ttl_qty, 2); ?></td>
                                <td><?= ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'; ?></td>
                                <td class="text-right">IDR</td>
                                <td></td>
                                <td class="text-right"><?= number_format($ttl_total, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Not Invoiced -->
<div class="modal fade" id="modal_slsni" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-shipping-fast mr-2"></i>Sales (Not Invoiced)</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height:400px">
                    <table id="tbl_slsni" class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th>Unit</th><th class="text-right">Curr</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php foreach ($data_slsni as $sni): $ttl_qty += $sni['qty']; $ttl_total += $sni['total']; ?>
                                <tr>
                                    <td><?= $sni['customer']; ?></td>
                                    <td class="text-right"><?= ($sni['uom'] == 'PCS') ? number_format($sni['qty'], 0) : number_format($sni['qty'], 2); ?></td>
                                    <td><?= $sni['uom']; ?></td>
                                    <td class="text-right">IDR</td>
                                    <td class="text-right"><?= number_format($sni['avg_price'], 2); ?></td>
                                    <td class="text-right"><?= number_format($sni['total'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td>Total</td>
                                <td class="text-right"><?= number_format($ttl_qty, 2); ?></td>
                                <td><?= ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'; ?></td>
                                <td class="text-right">IDR</td>
                                <td></td>
                                <td class="text-right"><?= number_format($ttl_total, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales CM All -->
<div class="modal fade" id="modal_slscm2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-calendar-alt mr-2"></i>Sales Current Month</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height:400px">
                    <table id="tbl_slscm2" class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th>Unit</th><th class="text-right">Curr</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php foreach ($data_slscm2 as $dsc2): $ttl_qty += $dsc2['qty']; $ttl_total += $dsc2['total']; ?>
                                <tr>
                                    <td><?= $dsc2['customer']; ?></td>
                                    <td class="text-right"><?= ($dsc2['uom'] == 'PCS') ? number_format($dsc2['qty'], 0) : number_format($dsc2['qty'], 2); ?></td>
                                    <td><?= $dsc2['uom']; ?></td>
                                    <td class="text-right">IDR</td>
                                    <td class="text-right"><?= number_format($dsc2['avg_price'], 2); ?></td>
                                    <td class="text-right"><?= number_format($dsc2['total'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td>Total</td>
                                <td class="text-right"><?= number_format($ttl_qty, 2); ?></td>
                                <td><?= ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'; ?></td>
                                <td class="text-right">IDR</td>
                                <td></td>
                                <td class="text-right"><?= number_format($ttl_total, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TOP 5 -->
<div class="modal fade" id="mysales5" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-trophy mr-2"></i>TOP 5 Buyer By Sales Value</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"><div id="det_sales5"></div></div>
        </div>
    </div>
</div>

<!-- MoTM -->
<div class="modal fade" id="mymotm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="jdl_motm"></h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"><div id="det_motm"></div></div>
        </div>
    </div>
</div>

<!-- Account Receivable -->
<div class="modal fade" id="modal_total_ar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-hand-holding-usd mr-2"></i>Account Receivable</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height:400px">
                    <table id="tbl_total_ar" class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Type Shipment</th><th>Customer</th><th class="text-right">Curr</th><th class="text-right">Total</th><th class="text-right">Equivalent IDR</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_total = 0; $ttl_total_idr = 0; ?>
                            <?php foreach ($data_ttl_ar as $data_ta): $ttl_total += $data_ta['total']; $ttl_total_idr += $data_ta['total_idr']; ?>
                                <tr>
                                    <td><?= $data_ta['shipp']; ?></td>
                                    <td><?= $data_ta['customer']; ?></td>
                                    <td class="text-right"><?= $data_ta['curr']; ?></td>
                                    <td class="text-right"><?= number_format($data_ta['total'], 2); ?></td>
                                    <td class="text-right"><?= number_format($data_ta['total_idr'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td colspan="3">Total</td>
                                <td class="text-right"><?= number_format($ttl_total, 2); ?></td>
                                <td class="text-right"><?= number_format($ttl_total_idr, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overdue Receivable -->
<div class="modal fade" id="modal_total_overdue" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-circle mr-2"></i>Overdue Receivable</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height:400px">
                    <table id="tbl_overdue" class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Type Shipment</th><th>Customer</th><th class="text-right">Curr</th><th class="text-right">Total</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_total = 0; ?>
                            <?php foreach ($data_ttl_ar as $data_ta): $ttl_total += $data_ta['ready_due']; ?>
                                <?php if ($data_ta['ready_due'] > 0): ?>
                                <tr>
                                    <td><?= $data_ta['shipp']; ?></td>
                                    <td><?= $data_ta['customer']; ?></td>
                                    <td class="text-right">IDR</td>
                                    <td class="text-right"><?= number_format($data_ta['ready_due'], 2); ?></td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td colspan="3">Total</td>
                                <td class="text-right"><?= number_format($ttl_total, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Not Due Receivable -->
<div class="modal fade" id="modal_total_notdue" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle mr-2"></i>Not Due Receivable</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height:400px">
                    <table id="tbl_notdue" class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Type Shipment</th><th>Customer</th><th class="text-right">Curr</th><th class="text-right">Total</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_total = 0; ?>
                            <?php foreach ($data_ttl_ar as $data_ta): $ttl_total += $data_ta['not_due']; ?>
                                <?php if ($data_ta['not_due'] > 0): ?>
                                <tr>
                                    <td><?= $data_ta['shipp']; ?></td>
                                    <td><?= $data_ta['customer']; ?></td>
                                    <td class="text-right">IDR</td>
                                    <td class="text-right"><?= number_format($data_ta['not_due'], 2); ?></td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td colspan="3">Total</td>
                                <td class="text-right"><?= number_format($ttl_total, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log History Modal -->
<div class="modal fade" id="modal_kpi_log" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:#3949ab;">
                <h5 class="modal-title" id="log_modal_title"><i class="fas fa-history mr-2"></i>Log History</h5>
                <button id="btn_log_export" class="btn btn-sm btn-light mr-2" style="padding:2px 7px;font-size:11px;opacity:0.75;display:none;" title="Export Excel"><i class="fas fa-file-excel text-success"></i></button>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="min-height:200px;">
                <div id="log-kpi-wrap"></div>
            </div>
        </div>
    </div>
</div>

<script>
function fmtDate(dt) {
    try {
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var p = dt.split(/[- :]/);
        return p[2]+"  "+months[parseInt(p[1])-1]+" "+p[0]+" "+p[3]+":"+p[4]+":"+p[5];
    } catch(e) { return dt; }
}

// Label tiap kolom KPI untuk tampilan log
var _kpiLogMeta = {
    'sls_ytd_inv': 'Sales YTD Invoiced',
    'sls_cm_inv':  'Sales CM Invoiced',
    'sls_ytd_all': 'Sales YTD (All)',
    'sls_cm_all':  'Sales CM (All)',
    'sls_no_inv':  'Sales Not Invoiced',
    'ar_idr':      'Account Receivable (IDR)',
    'ready_due':   'Overdue Receivable',
    'not_due':     'Not Due Receivable'
};

// Semua kolom untuk tampilan detail
var _kpiAllCols = [
    { key: 'sls_ytd_inv', label: 'Sales YTD Inv' },
    { key: 'sls_cm_inv',  label: 'Sales CM Inv' },
    { key: 'sls_ytd_all', label: 'Sales YTD All' },
    { key: 'sls_cm_all',  label: 'Sales CM All' },
    { key: 'sls_no_inv',  label: 'Not Invoiced' },
    { key: 'ar_idr',      label: 'AR IDR' },
    { key: 'ready_due',   label: 'Ready Due' },
    { key: 'not_due',     label: 'Not Due' }
];

function _computeRow(r) {
    r.sls_ytd_all = (parseFloat(r.sls_ytd_inv||0) + parseFloat(r.sls_no_inv||0)).toFixed(2);
    r.sls_cm_all  = (parseFloat(r.sls_cm_inv||0)  + parseFloat(r.sls_cm_no_inv||0)).toFixed(2);
    r.not_due     = (parseFloat(r.ar_idr||0) - parseFloat(r.ready_due||0)).toFixed(2);
    return r;
}

function _fmt(n) {
    return parseFloat(n || 0).toLocaleString('id-ID', {minimumFractionDigits:0, maximumFractionDigits:0});
}

function _logShowListView() {
    var today = new Date().toISOString().slice(0,10);
    document.getElementById('log_modal_title').innerHTML = '<i class="fas fa-history mr-2"></i>Log History &mdash; ' + (window._logColLabel || '');
    document.getElementById('btn_log_export').style.display = 'none';
    document.getElementById('log-kpi-wrap').innerHTML =
        '<div class="d-flex align-items-center flex-wrap mb-3" style="gap:8px;">' +
        '<label class="mb-0">From:</label>' +
        '<input type="date" id="log_dari" value="' + today + '" class="form-control form-control-sm" style="width:auto;">' +
        '<label class="mb-0 ml-1">To:</label>' +
        '<input type="date" id="log_sampai" value="' + today + '" class="form-control form-control-sm" style="width:auto;">' +
        '<button onclick="loadKpiLog()" class="btn btn-sm btn-primary ml-1">Show</button>' +
        '</div>' +
        '<div id="log-list-area" class="table-responsive" style="max-height:400px;overflow-y:auto;font-size:12px;">' +
        '<p style="color:#aaa;text-align:center;padding:20px;"><i class="fas fa-spinner fa-spin"></i> Loading...</p>' +
        '</div>';
}

function showKpiLog(colKey) {
    var pc       = document.getElementById('dsb_pc') ? document.getElementById('dsb_pc').value : '<?= $selected_pc ?: 'ALL'; ?>';
    var colLabel = _kpiLogMeta[colKey] || colKey;
    window._logKpiPc     = pc;
    window._logColKey    = colKey;
    window._logColLabel  = colLabel;
    window._logAllRows     = [];
    window._logDisplayRows = [];
    _logShowListView();
    $('#modal_kpi_log').modal('show');
    loadKpiLog();
}

function loadKpiLog() {
    var dari    = document.getElementById('log_dari')    ? document.getElementById('log_dari').value    : '';
    var sampai  = document.getElementById('log_sampai')  ? document.getElementById('log_sampai').value  : '';
    var area    = document.getElementById('log-list-area');
    if (!area) return;
    area.innerHTML = '<p style="color:#aaa;text-align:center;padding:20px;"><i class="fas fa-spinner fa-spin"></i> Loading...</p>';

    $.ajax({
        url: '<?= base_url("landingpage/dashboard_log"); ?>',
        type: 'POST', dataType: 'json',
        data: { pc: window._logKpiPc || 'ALL', dari: dari, sampai: sampai },
        success: function(res) {
            if (!res.status || !res.data.length) {
                area.innerHTML = '<p style="color:#aaa;text-align:center;padding:20px;">No log data for this filter.</p>';
                window._logAllRows = [];
                window._logDisplayRows = [];
                return;
            }
            window._logAllRows = res.data.map(_computeRow);
            renderKpiLogList();
        },
        error: function() {
            area.innerHTML = '<p style="color:#e74c3c;text-align:center;padding:20px;">Failed to load log.</p>';
        }
    });
}

var _pcName = { 'NAG': 'Nirwana Alabare Garment', 'NAK': 'Nirwana Alabare Knitting' };

// Latar lembut: hijau kalau naik, merah kalau turun
function _deltaStyle(delta) {
    if (delta > 0) return 'background:#e8f5e9;color:#2e7d32;';
    if (delta < 0) return 'background:#ffebee;color:#c62828;';
    return '';
}

// Sembunyikan baris log yang nilainya sama beruntun (per profit center),
// hanya tampilkan baris TERBARU dari tiap kelompok nilai yang sama.
function _dedupLogRows(rows, colKey) {
    var groups = {};
    rows.forEach(function(r) {
        var pc = r.profit_center;
        if (!groups[pc]) groups[pc] = [];
        groups[pc].push(r);
    });
    var kept = [];
    Object.keys(groups).forEach(function(pc) {
        var list = groups[pc].slice().sort(function(a, b) {
            return a.run_time < b.run_time ? -1 : (a.run_time > b.run_time ? 1 : 0);
        });
        var prevKept = null;
        list.forEach(function(r, i) {
            var curVal  = parseFloat(r[colKey] || 0).toFixed(2);
            var isLast  = (i === list.length - 1);
            var nextVal = isLast ? null : parseFloat(list[i + 1][colKey] || 0).toFixed(2);
            var keepThis = isLast || nextVal !== curVal;
            if (keepThis) {
                r._prevRunTime = prevKept ? prevKept.run_time : null;
                r._prevVal     = prevKept ? parseFloat(prevKept[colKey] || 0) : null;
                kept.push(r);
                prevKept = r;
            }
        });
    });
    kept.sort(function(a, b) {
        return a.run_time < b.run_time ? 1 : (a.run_time > b.run_time ? -1 : 0);
    });
    return kept;
}

function renderKpiLogList() {
    var area   = document.getElementById('log-list-area');
    var colKey = window._logColKey;
    var rows   = window._logAllRows;
    if (!area || !rows.length) return;

    var dispRows = _dedupLogRows(rows, colKey);
    window._logDisplayRows = dispRows;

    var html = '<table id="tbl_log_history" class="table table-striped table-head-fixed text-nowrap" style="width:100%;font-size:12px;">' +
        '<thead><tr>' +
        '<th>Time</th>' +
        '<th>Profit Center</th>' +
        '<th class="text-right">' + (window._logColLabel || colKey) + '</th>' +
        '<th style="width:36px;"></th>' +
        '</tr></thead><tbody>';

    dispRows.forEach(function(r) {
        var val      = _fmt(r[colKey]);
        var pcLabel  = _pcName[r.profit_center] || r.profit_center;
        var prevArg  = r._prevRunTime ? "'" + r._prevRunTime.replace(/'/g,"\\'") + "'" : 'null';
        var delta    = (r._prevVal !== null && r._prevVal !== undefined) ? (parseFloat(r[colKey] || 0) - r._prevVal) : 0;
        var rowStyle = r._prevRunTime ? _deltaStyle(delta) : '';
        html += '<tr style="' + rowStyle + '">' +
            '<td style="white-space:nowrap;">' + r.run_time + '</td>' +
            '<td>' + pcLabel + '</td>' +
            '<td class="text-right font-weight-bold">IDR ' + val + '</td>' +
            '<td class="text-center">' +
            '<span onclick="showKpiLogDetail(\'' + r.run_time.replace(/'/g,"\\'") + '\',\'' + r.profit_center + '\',' + prevArg + ')" ' +
            'style="cursor:pointer;color:#3949ab;font-size:13px;" title="View detail per buyer">' +
            '<i class="fas fa-search-plus"></i></span></td>' +
            '</tr>';
    });
    html += '</tbody></table>';
    area.innerHTML = html;
}

function exportLogDetailXLS() {
    var fname = 'Log_Detail_' + (window._logColLabel || 'KPI').replace(/\s+/g,'_');
    exportTableXLS('tbl_log_detail', fname);
}

function exportTableXLS(tableId, filename) {
    var tbl = document.getElementById(tableId);
    if (!tbl) { alert('Tabel tidak ditemukan.'); return; }
    var uri  = 'data:application/vnd.ms-excel;charset=utf-8,';
    var html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">' +
               '<head><meta charset="UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>' + filename + '</x:Name>' +
               '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>' +
               '<body><table border="1">' + tbl.innerHTML + '</table></body></html>';
    var blob = new Blob([html], { type: 'application/vnd.ms-excel;charset=utf-8' });
    var url  = URL.createObjectURL(blob);
    var a    = document.createElement('a');
    a.href   = url;
    a.download = filename + '.xls';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function backToLogList() {
    _logShowListView();
    if (window._logAllRows && window._logAllRows.length) renderKpiLogList();
}

function showKpiLogDetail(runTime, pc, prevRunTime) {
    var colKey   = window._logColKey  || '';
    var colLabel = window._logColLabel || colKey;
    var pcLabel  = (pc === 'ALL') ? 'All Profit Centers' : (_pcName[pc] || pc);

    // Switch modal to detail view — export hanya tersedia di sini, bukan di list history
    document.getElementById('log_modal_title').innerHTML =
        '<i class="fas fa-search-plus mr-2"></i>' + colLabel + ' &nbsp;&middot;&nbsp; ' + runTime;
    var btnExport = document.getElementById('btn_log_export');
    btnExport.style.display = 'inline-block';
    btnExport.onclick = exportLogDetailXLS;
    document.getElementById('log-kpi-wrap').innerHTML =
        '<button onclick="backToLogList()" class="btn btn-sm btn-secondary mb-3" style="font-size:12px;">' +
        '<i class="fas fa-arrow-left mr-1"></i> Back</button>' +
        '<div class="text-muted mb-2" style="font-size:11px;"><b>' + pcLabel + '</b>' +
        (prevRunTime
            ? ' &nbsp;&middot;&nbsp; Compared to: <b>' + prevRunTime + '</b>'
            : ' &nbsp;&middot;&nbsp; <i>First entry, no comparison available</i>') +
        '</div>' +
        '<div class="table-responsive" id="log-detail-area" style="max-height:400px;overflow-y:auto;">' +
        '<p style="color:#aaa;text-align:center;padding:20px;"><i class="fas fa-spinner fa-spin"></i> Loading...</p>' +
        '</div>';

    var reqCurrent = $.ajax({
        url: '<?= base_url("landingpage/dashboard_log_detail"); ?>',
        type: 'POST', dataType: 'json',
        data: { pc: pc, run_time: runTime, col_key: colKey }
    });

    if (prevRunTime) {
        var reqPrev = $.ajax({
            url: '<?= base_url("landingpage/dashboard_log_detail"); ?>',
            type: 'POST', dataType: 'json',
            data: { pc: pc, run_time: prevRunTime, col_key: colKey }
        });
        $.when(reqCurrent, reqPrev).done(function(curArgs, prevArgs) {
            _renderLogDetailCompare(curArgs[0], prevArgs[0]);
        }).fail(_logDetailError);
    } else {
        reqCurrent.done(function(res) {
            _renderLogDetailCompare(res, null);
        }).fail(_logDetailError);
    }
}

function _logDetailError() {
    var area = document.getElementById('log-detail-area');
    if (area) area.innerHTML = '<p style="color:#e74c3c;text-align:center;padding:20px;">Failed to load data.</p>';
}

function _renderLogDetailCompare(curRes, prevRes) {
    var area = document.getElementById('log-detail-area');
    if (!area) return;
    if (!curRes.status || !curRes.data.length) {
        area.innerHTML = '<p style="color:#aaa;text-align:center;padding:20px;">No data.</p>';
        return;
    }
    var colKey  = window._logColKey || '';
    var isAR    = (colKey === 'ar_idr' || colKey === 'ready_due' || colKey === 'not_due');
    var hasPrev = !!(prevRes && prevRes.status && prevRes.data.length);

    var fmtNum = function(n) {
        return parseFloat(n||0).toLocaleString('id-ID', {minimumFractionDigits:2, maximumFractionDigits:2});
    };
    var fmtQtyNum = function(qty, uom) {
        var q = parseFloat(qty || 0);
        return (uom === 'PCS')
            ? q.toLocaleString('id-ID', {minimumFractionDigits:0, maximumFractionDigits:0})
            : q.toLocaleString('id-ID', {minimumFractionDigits:2, maximumFractionDigits:2});
    };
    var fmtDeltaText = function(n) {
        var v    = parseFloat(n||0);
        var sign = v > 0 ? '+' : '';
        return sign + fmtNum(v);
    };

    var prevMap = {};
    if (hasPrev) {
        prevRes.data.forEach(function(r) {
            prevMap[(r.customer||'') + '|' + (r.uom||'')] = r;
        });
    }

    var html = '<table id="tbl_log_detail" class="table table-striped table-head-fixed text-nowrap" style="width:100%;font-size:12px;"><thead><tr>';

    if (isAR) {
        var arField = colKey === 'ar_idr' ? 'total_idr' : (colKey === 'ready_due' ? 'total_ready_due' : 'total_not_due');
        var showIdr = (colKey === 'ar_idr');
        html += '<th>Customer</th><th class="text-right">Curr</th>' +
            (hasPrev ? '<th class="text-right">Previous</th>' : '') +
            '<th class="text-right">Total</th>' +
            (hasPrev ? '<th class="text-right">Difference</th>' : '') +
            (showIdr ? '<th class="text-right">Equivalent IDR</th>' : '') +
            '</tr></thead><tbody>';
        var ttlAmt = 0, ttlIdr = 0, ttlPrev = 0;
        curRes.data.forEach(function(r) {
            var amt      = parseFloat(r[arField] || 0);
            var idr      = parseFloat(r.total_idr || 0);
            var prevRow  = prevMap[(r.customer||'') + '|' + (r.uom||'')];
            var prevAmt  = prevRow ? parseFloat(prevRow[arField] || 0) : 0;
            var rowStyle = hasPrev ? _deltaStyle(amt - prevAmt) : '';
            ttlAmt += amt;
            if (showIdr) ttlIdr += idr;
            if (hasPrev) ttlPrev += prevAmt;
            html += '<tr style="' + rowStyle + '"><td>' + (r.customer || '-') + '</td>' +
                '<td class="text-right">IDR</td>' +
                (hasPrev ? '<td class="text-right">' + fmtNum(prevAmt) + '</td>' : '') +
                '<td class="text-right">' + fmtNum(amt) + '</td>' +
                (hasPrev ? '<td class="text-right">' + fmtDeltaText(amt - prevAmt) + '</td>' : '') +
                (showIdr ? '<td class="text-right">' + fmtNum(idr) + '</td>' : '') +
                '</tr>';
        });
        var totalStyle = hasPrev ? _deltaStyle(ttlAmt - ttlPrev) : 'background:#f8f9fa;';
        html += '<tr class="font-weight-bold" style="' + totalStyle + '">' +
            '<td colspan="2">Total</td>' +
            (hasPrev ? '<td class="text-right">' + fmtNum(ttlPrev) + '</td>' : '') +
            '<td class="text-right">' + fmtNum(ttlAmt) + '</td>' +
            (hasPrev ? '<td class="text-right">' + fmtDeltaText(ttlAmt - ttlPrev) + '</td>' : '') +
            (showIdr ? '<td class="text-right">' + fmtNum(ttlIdr) + '</td>' : '') +
            '</tr>';
    } else {
        html += '<th>Customer</th><th class="text-right">Qty</th><th>Unit</th>' +
            '<th class="text-right">Curr</th><th class="text-right">Avg Sales Price</th>' +
            (hasPrev ? '<th class="text-right">Previous</th>' : '') +
            '<th class="text-right">Total Value</th>' +
            (hasPrev ? '<th class="text-right">Difference</th>' : '') +
            '</tr></thead><tbody>';
        var ttlQty = 0, ttlTotal = 0, ttlTotalPrev = 0;
        curRes.data.forEach(function(r) {
            var qty       = parseFloat(r.qty   || 0);
            var total     = parseFloat(r.total || 0);
            var prevRow   = prevMap[(r.customer||'') + '|' + (r.uom||'')];
            var prevTotal = prevRow ? parseFloat(prevRow.total || 0) : 0;
            var rowStyle  = hasPrev ? _deltaStyle(total - prevTotal) : '';
            ttlQty   += qty;
            ttlTotal += total;
            if (hasPrev) ttlTotalPrev += prevTotal;
            html += '<tr style="' + rowStyle + '"><td>' + (r.customer || '-') + '</td>' +
                '<td class="text-right">' + fmtQtyNum(qty, r.uom) + '</td>' +
                '<td>' + (r.uom || '') + '</td>' +
                '<td class="text-right">IDR</td>' +
                '<td class="text-right">' + fmtNum(r.avg_price) + '</td>' +
                (hasPrev ? '<td class="text-right">' + fmtNum(prevTotal) + '</td>' : '') +
                '<td class="text-right">' + fmtNum(total) + '</td>' +
                (hasPrev ? '<td class="text-right">' + fmtDeltaText(total - prevTotal) + '</td>' : '') +
                '</tr>';
        });
        var totalStyle = hasPrev ? _deltaStyle(ttlTotal - ttlTotalPrev) : 'background:#f8f9fa;';
        html += '<tr class="font-weight-bold" style="' + totalStyle + '">' +
            '<td>Total</td>' +
            '<td class="text-right">' + ttlQty.toLocaleString('id-ID', {minimumFractionDigits:2, maximumFractionDigits:2}) + '</td>' +
            '<td></td><td class="text-right">IDR</td><td></td>' +
            (hasPrev ? '<td class="text-right">' + fmtNum(ttlTotalPrev) + '</td>' : '') +
            '<td class="text-right">' + fmtNum(ttlTotal) + '</td>' +
            (hasPrev ? '<td class="text-right">' + fmtDeltaText(ttlTotal - ttlTotalPrev) + '</td>' : '') +
            '</tr>';
    }
    html += '</tbody></table>';
    area.innerHTML = html;
}

function refreshDashboard() {
    var btn = document.getElementById('btn-refresh-dsb');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-sync-alt fa-spin-custom" id="icon-refresh"></i> Memproses...';

    Swal.fire({
        title: 'Memperbarui Data...',
        html: '<div style="text-align:center;padding:10px 0;"><div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem;"></div><p style="font-size:13px;color:#666;margin:0;">Harap tunggu, proses ini bisa beberapa menit.</p></div>',
        allowOutsideClick: false, allowEscapeKey: false, showConfirmButton: false
    });

    $.ajax({
        url: '<?= base_url("landingpage/refresh_dashboard"); ?>',
        type: 'POST', dataType: 'json', timeout: 300000,
        success: function (res) {
            var fmt = res.last_update ? fmtDate(res.last_update) : '-';
            document.querySelectorAll('.kpi-last-update').forEach(function(el) {
                el.innerHTML = '<i class="fas fa-clock"></i> ' + fmt;
            });
            if (res.status) {
                Swal.fire({
                    iconHtml: '<div style="background:linear-gradient(135deg,#43a047,#1b5e20);border-radius:50%;width:64px;height:64px;display:flex;align-items:center;justify-content:center;margin:auto;"><i class="fas fa-check" style="color:#fff;font-size:28px;"></i></div>',
                    title: '<span style="color:#2e7d32;font-size:20px;">Data Diperbarui!</span>',
                    html: '<div style="text-align:center;"><div style="background:#f1f8e9;border:1px solid #c8e6c9;border-radius:10px;padding:14px 18px;margin:12px 0;"><p style="margin:0;font-size:12px;color:#81c784;text-transform:uppercase;letter-spacing:1px;">Last Update</p><p style="margin:6px 0 0;font-size:18px;font-weight:700;color:#1b5e20;">' + fmt + '</p></div><p style="font-size:12px;color:#bdbdbd;margin:0;">Halaman akan dimuat ulang otomatis...</p></div>',
                    confirmButtonText: '<i class="fas fa-sync-alt mr-1"></i> Muat Ulang Sekarang',
                    confirmButtonColor: '#43a047',
                    showCancelButton: true, cancelButtonText: 'Tutup', cancelButtonColor: '#9e9e9e',
                    timer: 4000, timerProgressBar: true
                }).then(function() { location.reload(); });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: '<span style="color:#e65100;font-size:18px;">Gagal Memperbarui</span>',
                    html: '<p style="font-size:13px;color:#555;">Terjadi kesalahan saat memperbarui data.<br>Silakan coba lagi atau hubungi administrator.</p>',
                    confirmButtonText: 'Coba Lagi', confirmButtonColor: '#e65100',
                    showCancelButton: true, cancelButtonText: 'Tutup', cancelButtonColor: '#9e9e9e'
                }).then(function(r) { if (r.isConfirmed) refreshDashboard(); });
            }
        },
        error: function () {
            Swal.fire({ icon: 'error', title: 'Koneksi Gagal', text: 'Tidak dapat menghubungi server. Silakan coba lagi.', confirmButtonColor: '#3949ab' });
        },
        complete: function () {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync-alt" id="icon-refresh"></i> Refresh Data';
        }
    });
}
</script>

