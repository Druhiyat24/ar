
<style type="text/css">
    body{
  overflow-y: scroll;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel" data-interval="10000">
    <div class="carousel-inner">
        <div class="carousel-item active">
           <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3">
                    <div class="card border-success mb-3" style="max-width: 22rem;">
                        <div class="card-header bg-info border-dark"><b style="font-size: 0.9rem;">Sales Ytd ( Invoiced )</b></div>
                        <div class="card-body text-secondary">
                           <!--  <div id="value">100</div> -->
                                <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F" onclick="showdata_slsytd()">IDR <?= number_format($sls_ytd_inv,2); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card border-success mb-3" style="max-width: 22rem;">
                        <div class="card-header bg-info border-dark"><a href="<?= base_url('report/frm_sales_report'); ?>" target="blank"><b style="font-size: 0.9rem;">Sales Current Month ( Invoiced )</b></a></div>
                        <div class="card-body text-secondary count_content">
                                <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F" onclick="showdata_slscm()">IDR <?= number_format($sls_cm_inv,2); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card border-success mb-3" style="max-width: 22rem;">
                        <div class="card-header bg-info border-dark"><b style="font-size: 0.9rem;">Sales Ytd</b></div>
                        <div class="card-body text-secondary">
                                <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F" onclick="showdata_slsytd2()">IDR <?= number_format($sls_no_inv + $sls_ytd_inv,2); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card border-success mb-3" style="max-width: 22rem;">
                        <div class="card-header bg-info border-dark"><b style="font-size: 0.9rem;">Sales Current Month</b></div>
                        <div class="card-body text-secondary">
                                <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F" onclick="showdata_slscm2()">IDR <?= number_format($sls_cm_no_inv + $sls_cm_inv,2); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card border-success mb-3" style="max-width: 22rem;">
                        <div class="card-header bg-success
                         border-dark"><a href="<?= base_url('arnag/frm_report_sj_not_invoice'); ?>" target="blank"><b style="font-size: 0.9rem;">Sales ( not invoiced )</b></a></div>
                        <div class="card-body text-secondary">
                                <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F" onclick="showdata_slsni()">IDR <?= number_format($sls_no_inv,2); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-danger" style="text-align: center;"><p class="card-text" style="font-size: 1.2rem;"><b><?= number_format($sls_no_inv / $sls_ytd_inv * 100,2); ?> %</b></p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card border-success mb-3" style="max-width: 22rem;">
                        <div class="card-header bg-danger border-dark"><b style="font-size: 0.9rem;">Account Receivable</b></div>
                        <div class="card-body text-secondary">
                                <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F">IDR <?= number_format($ar_eqvidr,2); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-danger" style="text-align: center;"><p class="card-text" style="font-size: 1.2rem;"><b>100 %</b></p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card border-success mb-3" style="max-width: 22rem;">
                        <div class="card-header bg-danger border-dark"><a href="<?= base_url('arnag/kartu_ar_detail'); ?>" target="blank"><b style="font-size: 0.9rem;">Overdue Receivable</b></a></div>
                        <div class="card-body text-secondary">
                                <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F">IDR <?= number_format($ready_due,2); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-danger" style="text-align: center;"><p class="card-text" style="font-size: 1.2rem;"><b><?= number_format($ready_due / $ar_eqvidr * 100,2); ?> %</b></p></div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card border-success mb-3" style="max-width: 22rem;">
                        <div class="card-header bg-danger border-dark"><a href="<?= base_url('arnag/kartu_ar_detail'); ?>" target="blank"><b style="font-size: 0.9rem;">Not Due Receivable</b></a></div>
                        <div class="card-body text-secondary">
                                <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F">IDR <?= number_format(($ar_eqvidr - $ready_due),2); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-danger" style="text-align: center;"><p class="card-text" style="font-size: 1.2rem;"><b><?= number_format(($ar_eqvidr - $ready_due) / $ar_eqvidr * 100,2); ?> %</b></p></div>
                    </div>
                </div>

                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b><u>Sales Value By Destination</u></b></h3>
                                <select style="width:12rem" class="form-control" id="filter_dsb1" name="filter_dsb1" onchange="cari_ar_lokal_ekspor(this.value)">
                                        <option value="ALL">ALL</option>
                                    <?php foreach ($filter_ar as $fa) : ?>
                                        <option value="<?= $fa['val_fil']; ?>"><?= $fa['name_fil']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <div id="chart"></div>
                            </div>

                        </div>
                    </div>
                </div>

                 <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b><u>Sales Value By Order Tipe</u></b></h3>
                                <select style="width:12rem" class="form-control" id="filter_dsb1a" name="filter_dsb1a" onchange="cari_ar_fob_cmt(this.value)">
                                        <option value="ALL">ALL</option>
                                    <?php foreach ($filter_ar as $fa) : ?>
                                        <option value="<?= $fa['val_fil']; ?>"><?= $fa['name_fil']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <div id="chart2"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>

        </div>
        <div class="carousel-item">
            <div class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b><u>TOP 5 Buyer By Sales Value</u></b></h3>
                                <select style="width:15rem" class="form-control" id="filter_dsb2" name="filter_dsb2" onchange="change_top_5_sales(this.value)">
                                        <option value="ALL">ALL</option>
                                    <?php foreach ($bulan_ar as $bln) : ?>
                                        <option value="<?= $bln['bulan_text']; ?>"><?= $bln['nama_bulan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <div id="chart3"></div>
                            </div>

                            <div class="card">
                                <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                 <h3 class="card-title"><b><u>Receivable Prediction</u></b></h3>
                                </div>
                                </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;font-size: 1rem;" scope="col">Periode</th>
                                            <th style="text-align: left;" scope="col">Week 1 (1-7)</th>
                                            <th style="text-align: left;" scope="col">Week 2 (8-14)</th>
                                            <th style="text-align: left;" scope="col">Week 3 (15-21)</th>
                                            <th style="text-align: left;" scope="col">Week 4 (22-31)</th>
                                            <th style="text-align: left;" scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($data_pred as $dp) : ?>
                                            <tr>
                                                <td style="text-align: left;font-size: 1.1rem;color: #2F4F4F"><?= $dp['periode']; ?></td>
                                                <td style="text-align: left;font-size: 1.1rem;color: #2F4F4F">IDR <?= number_format($dp['week1'],2); ?></td>
                                                <td style="text-align: left;font-size: 1.1rem;color: #2F4F4F">IDR <?= number_format($dp['week2'],2); ?></td>
                                                <td style="text-align: left;font-size: 1.1rem;color: #2F4F4F">IDR <?= number_format($dp['week3'],2); ?></td>
                                                <td style="text-align: left;font-size: 1.1rem;color: #2F4F4F">IDR <?= number_format($dp['week4'],2); ?></td>
                                                <td style="text-align: left;font-size: 1.1rem;color: #2F4F4F">IDR <?= number_format($dp['week4'] + $dp['week1'] + $dp['week2'] + $dp['week3'],2); ?></td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                </div> 
                                </div>
                               <!--  <div class="col-lg-3">
                                <div class="card border-secondary mb-3" style="max-width: 18rem;">
                                    <div class="card-header"><b>Week 1</b></div>
                                    <div class="card-body text-secondary">
                                        <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F">IDR <?= number_format($pred_week1,2); ?></p>
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-3">
                                <div class="card border-secondary mb-3" style="max-width: 18rem;">
                                    <div class="card-header"><b>Week 2</b></div>
                                    <div class="card-body text-secondary">
                                        <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F">IDR <?= number_format($pred_week2,2); ?></p>
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-3">
                                <div class="card border-secondary mb-3" style="max-width: 18rem;">
                                    <div class="card-header"><b>Week 3</b></div>
                                    <div class="card-body text-secondary">
                                        <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F">IDR <?= number_format($pred_week3,2); ?></p>
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-3">
                                <div class="card border-secondary mb-3" style="max-width: 18rem;">
                                    <div class="card-header"><b>Week 4</b></div>
                                    <div class="card-body text-secondary">
                                        <p class="card-text" style="text-align: center;font-size: 1.4rem;color: #2F4F4F">IDR <?= number_format($pred_week4,2); ?></p>
                                    </div>
                                </div>
                                </div> -->
                            </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b><u>Sales Year To Date (Month To Month Comparison)</u></b></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <div id="chart4"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b><u>Overdue Receivable Aging</u></b></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <div id="chart5"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
  </div>
  <a style="width: 3rem;" class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span style="background-color: grey;" class="carousel-control-prev-icon" aria-hidden="true"></span>
  </a>
  <a style="width: 3rem;" class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span style="background-color: grey;" class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>
</div>

    <!-- Main content -->
    
    <!-- /.content -->
</div>
<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Overdue Receivable Aging</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive">
                <div id="det_overdue"></div>
                </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<div class="modal fade " id="modal_slsytd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Sales YTD (Invoiced)</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive" style="height: 400px">
                    <table class="table table-striped table-head-fixed text-nowrap" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: left;width: 20%;font-size: 1rem;" scope="col">Customer</th>
                                <th style="text-align: left;width: 35%;" scope="col">Qty</th>
                                <th style="text-align: left;width: 45%;" scope="col">Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; 
                            $ttl_qty = 0;
                            $ttl_total = 0; ?>
                        <?php foreach ($data_slsytd as $dsy) : ?>
                            <?php $ttl_qty += $dsy['qty'];
                                  $ttl_total += $dsy['total']; ?>
                                <tr>
                                    <td style="text-align: left;font-size: 0.9rem;color: #2F4F4F"><?= $dsy['customer']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $dsy['qty2']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $dsy['total2']; ?></td>
                                </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                                <tr>
                                    <th style="text-align: left;font-size: 1rem;" scope="col">Total :</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col"><?= number_format($ttl_qty,2); ?> PCS</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col">IDR <?= number_format($ttl_total,2); ?></th>
                                </tr>
                        </tbody>
                    </table>
                </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<div class="modal fade " id="modal_slscm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Sales Current Month ( Invoiced )</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive" style="height: 400px">
                    <table class="table table-striped table-head-fixed text-nowrap" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: left;width: 20%;font-size: 1rem;" scope="col">Customer</th>
                                <th style="text-align: left;width: 35%;" scope="col">Qty</th>
                                <th style="text-align: left;width: 45%;" scope="col">Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; 
                            $ttl_qty = 0;
                            $ttl_total = 0; ?>
                        <?php foreach ($data_slscm as $dsc) : ?>
                            <?php $ttl_qty += $dsc['qty'];
                                  $ttl_total += $dsc['total']; ?>
                                <tr>
                                    <td style="text-align: left;font-size: 0.9rem;color: #2F4F4F"><?= $dsc['customer']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $dsc['qty2']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $dsc['total2']; ?></td>
                                </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                                <tr>
                                    <th style="text-align: left;font-size: 1rem;" scope="col">Total :</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col"><?= number_format($ttl_qty,2); ?> PCS</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col">IDR <?= number_format($ttl_total,2); ?></th>
                                </tr>
                        </tbody>
                    </table>
                </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<div class="modal fade " id="modal_slsytd2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Sales YTD</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive" style="height: 400px">
                    <table class="table table-striped table-head-fixed text-nowrap" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: left;width: 20%;font-size: 1rem;" scope="col">Customer</th>
                                <th style="text-align: left;width: 35%;" scope="col">Qty</th>
                                <th style="text-align: left;width: 45%;" scope="col">Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; 
                            $ttl_qty = 0;
                            $ttl_total = 0; ?>
                        <?php foreach ($data_slsytd2 as $dsy2) : ?>
                            <?php $ttl_qty += $dsy2['qty'];
                                  $ttl_total += $dsy2['total']; ?>
                                <tr>
                                    <td style="text-align: left;font-size: 0.9rem;color: #2F4F4F"><?= $dsy2['customer']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $dsy2['qty2']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $dsy2['total2']; ?></td>
                                </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                                <tr>
                                    <th style="text-align: left;font-size: 1rem;" scope="col">Total :</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col"><?= number_format($ttl_qty,2); ?> PCS</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col">IDR <?= number_format($ttl_total,2); ?></th>
                                </tr>
                        </tbody>
                    </table>
                </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade " id="modal_slsni" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Sales (Not Invoice)</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive" style="height: 400px">
                    <table class="table table-striped table-head-fixed text-nowrap" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: left;width: 20%;font-size: 1rem;" scope="col">Customer</th>
                                <th style="text-align: left;width: 35%;" scope="col">Qty</th>
                                <th style="text-align: left;width: 45%;" scope="col">Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; 
                            $ttl_qty = 0;
                            $ttl_total = 0; ?>
                        <?php foreach ($data_slsni as $sni) : ?>
                            <?php $ttl_qty += $sni['qty'];
                                  $ttl_total += $sni['total']; ?>
                                <tr>
                                    <td style="text-align: left;font-size: 0.9rem;color: #2F4F4F"><?= $sni['customer']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $sni['qty2']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $sni['total2']; ?></td>
                                </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                                <tr>
                                    <th style="text-align: left;font-size: 1rem;" scope="col">Total :</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col"><?= number_format($ttl_qty,2); ?> PCS</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col">IDR <?= number_format($ttl_total,2); ?></th>
                                </tr>
                        </tbody>
                    </table>
                </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<div class="modal fade " id="modal_slscm2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Sales Current Month</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive" style="height: 400px">
                    <table class="table table-striped table-head-fixed text-nowrap" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: left;width: 20%;font-size: 1rem;" scope="col">Customer</th>
                                <th style="text-align: left;width: 35%;" scope="col">Qty</th>
                                <th style="text-align: left;width: 45%;" scope="col">Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; 
                            $ttl_qty = 0;
                            $ttl_total = 0; ?>
                        <?php foreach ($data_slscm2 as $dsc2) : ?>
                            <?php $ttl_qty += $dsc2['qty'];
                                  $ttl_total += $dsc2['total']; ?>
                                <tr>
                                    <td style="text-align: left;font-size: 0.9rem;color: #2F4F4F"><?= $dsc2['customer']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $dsc2['qty2']; ?></td>
                                    <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= $dsc2['total2']; ?></td>
                                </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                                <tr>
                                    <th style="text-align: left;font-size: 1rem;" scope="col">Total :</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col"><?= number_format($ttl_qty,2); ?> PCS</th>
                                    <th style="text-align: right;font-size: 0.9rem;" scope="col">IDR <?= number_format($ttl_total,2); ?></th>
                                </tr>
                        </tbody>
                    </table>
                </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade " id="mysales5" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">TOP 5 Buyer By Sales Value</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive">
                <div id="det_sales5"></div>
                </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade " id="mymotm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="jdl_motm"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <div class="table-responsive">
                <div id="det_motm"></div>
                </div> 
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
