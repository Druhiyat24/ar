<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <div class="card_body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Sales Report</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <!-- Row 1 -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Customer</label>
                                                <select class="form-control select2bs4" id="sr_customer" name="sr_customer">
                                                    <option value="All">All Customer</option>
                                                    <?php foreach ($customer as $cs) : ?>
                                                        <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select class="form-control select2bs4" id="sr_type" name="sr_type">
                                                    <option value="All">All</option>
                                                    <option value="Local">Local</option>
                                                    <option value="Export">Export</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>VAT Type</label>
                                                <select class="form-control select2bs4" id="sr_vat" name="sr_vat">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row 2 -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Periode</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control float-right" id="reservation" name="reservation">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Invoice Type</label>
                                                <select class="form-control select2bs4" id="sr_type_inv" name="sr_type_inv">
                                                    <option value="All">All</option>
                                                    <?php foreach ($type as $t) : ?>
                                                        <option value="<?= $t['id_type']; ?>"><?= $t['type']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>VAT Status</label>
                                                <select class="form-control select2bs4" id="sr_vat_status" name="sr_vat_status">
                                                    <option value="">All</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Revisi">Revisi</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row 3 -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select class="form-control select2bs4" id="sr_curr" name="sr_curr">
                                                    <option value="All">All</option>
                                                    <option value="USD">USD</option>
                                                    <option value="IDR">IDR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Group</label>
                                                <select class="form-control select2bs4" id="sr_group" name="sr_group">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Order Type</label>
                                                <select class="form-control select2bs4" id="sr_order_type" name="sr_order_type">
                                                    <option value="All">All</option>
                                                    <option value="FOB">FOB</option>
                                                    <option value="CMT">CMT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Button Search -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary" onclick="cari_sales_report()"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
    <!-- Data Table Sales Report -->
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DataTable Sales Report</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table id="table-sales-report" class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Invoice</th>
                                    <th>Invoice Date</th>
                                    <th>Group</th>
                                    <th>Vat Number</th>
                                    <th>Vat Date</th>
                                    <th>TOP</th>
                                    <th>Order Type</th>
                                    <th>Shipp</th>
                                    <th>Inv Type</th>
                                    <th>Qty</th>
                                    <th>Currency</th>
                                    <th>Rate</th>
                                    <th>Original Value</th>
                                    <th>Equiv Value</th>
                                    <th>VAT</th>
                                    <!-- <th>Total</th> -->
                                    <!-- <th>No Faktur</th>
                                    <th>Tgl Faktur</th> -->
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Button Print -->
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary" onclick="print_sales_report()"><i class="fa fa-print"></i> Print</button>
                <button type="button" class="btn btn-info" onclick="export_sales_report()"><i class="fa fa-download"></i> Export To Excel</button>
            </div>
        </div>
    </div>
</div>