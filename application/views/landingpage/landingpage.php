
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
            <div class="row align-items-center mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 font-weight-bold" style="color:#1a2340;">
                        <i class="fas fa-chart-line mr-2" style="color:#3949ab;"></i><?= $title; ?>
                    </h4>
                </div>
                <div class="col-sm-6">
                    <form id="filterForm" method="get" action="<?= base_url('landingpage'); ?>" class="form-inline justify-content-end pc-select-wrap">
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
                    <table class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php if (!empty($data_slsytd)): ?>
                                <?php foreach ($data_slsytd as $dsy): $ttl_qty += $dsy['qty']; $ttl_total += $dsy['total']; ?>
                                    <tr>
                                        <td><?= $dsy['customer']; ?></td>
                                        <td class="text-right"><?= $dsy['qty2']; ?></td>
                                        <td class="text-right">IDR <?= number_format(($dsy['total'] / $dsy['qty']), 2); ?></td>
                                        <td class="text-right"><?= $dsy['total2']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="font-weight-bold bg-light">
                                    <td>Total</td><td class="text-right"><?= number_format($ttl_qty, 2); ?></td><td></td><td class="text-right">IDR <?= number_format($ttl_total, 2); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted">No Data Available</td></tr>
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
                    <table class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php if (!empty($data_slscm)): ?>
                                <?php foreach ($data_slscm as $dsc): $ttl_qty += $dsc['qty']; $ttl_total += $dsc['total']; ?>
                                    <tr>
                                        <td><?= $dsc['customer']; ?></td>
                                        <td class="text-right"><?= $dsc['qty2']; ?></td>
                                        <td class="text-right">IDR <?= number_format(($dsc['total'] / $dsc['qty']), 2); ?></td>
                                        <td class="text-right"><?= $dsc['total2']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="font-weight-bold bg-light">
                                    <td>Total</td><td class="text-right"><?= number_format($ttl_qty, 2); ?></td><td></td><td class="text-right">IDR <?= number_format($ttl_total, 2); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted">No Data Available</td></tr>
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
                    <table class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php foreach ($data_slsytd2 as $dsy2): $ttl_qty += $dsy2['qty']; $ttl_total += $dsy2['total']; ?>
                                <tr>
                                    <td><?= $dsy2['customer']; ?></td>
                                    <td class="text-right"><?= $dsy2['qty2']; ?></td>
                                    <td class="text-right">IDR <?= number_format(($dsy2['total'] / $dsy2['qty']), 2); ?></td>
                                    <td class="text-right"><?= $dsy2['total2']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td>Total</td>
                                <td class="text-right"><?= number_format($ttl_qty, 2); ?> <?= ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'; ?></td>
                                <td></td>
                                <td class="text-right">IDR <?= number_format($ttl_total, 2); ?></td>
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
                    <table class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php foreach ($data_slsni as $sni): $ttl_qty += $sni['qty']; $ttl_total += $sni['total']; ?>
                                <tr>
                                    <td><?= $sni['customer']; ?></td>
                                    <td class="text-right"><?= $sni['qty2']; ?></td>
                                    <td class="text-right">IDR <?= number_format(($sni['total'] / $sni['qty']), 2); ?></td>
                                    <td class="text-right"><?= $sni['total2']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td>Total</td>
                                <td class="text-right"><?= number_format($ttl_qty, 2); ?> <?= ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'; ?></td>
                                <td></td>
                                <td class="text-right">IDR <?= number_format($ttl_total, 2); ?></td>
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
                    <table class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr><th>Customer</th><th class="text-right">Qty</th><th class="text-right">Avg Sales Price</th><th class="text-right">Total Value</th></tr>
                        </thead>
                        <tbody>
                            <?php $ttl_qty = 0; $ttl_total = 0; ?>
                            <?php foreach ($data_slscm2 as $dsc2): $ttl_qty += $dsc2['qty']; $ttl_total += $dsc2['total']; ?>
                                <tr>
                                    <td><?= $dsc2['customer']; ?></td>
                                    <td class="text-right"><?= $dsc2['qty2']; ?></td>
                                    <td class="text-right">IDR <?= number_format(($dsc2['total'] / $dsc2['qty']), 2); ?></td>
                                    <td class="text-right"><?= $dsc2['total2']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold bg-light">
                                <td>Total</td>
                                <td class="text-right"><?= number_format($ttl_qty, 2); ?> <?= ($selected_pc == 'NAK') ? 'Kilogram' : 'PCS'; ?></td>
                                <td></td>
                                <td class="text-right">IDR <?= number_format($ttl_total, 2); ?></td>
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
                    <table class="table table-striped table-head-fixed text-nowrap">
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
                    <table class="table table-striped table-head-fixed text-nowrap">
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
                    <table class="table table-striped table-head-fixed text-nowrap">
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


