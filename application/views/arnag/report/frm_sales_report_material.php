<style>
    .table-wrapper {
        max-height: 350px;
        overflow-y: auto;
        position: relative;
    }

    .table-scroll {
        overflow-x: auto;
    }

    #table-sales-report-material {
        border-collapse: collapse;
        width: max-content; /* Supaya bisa scroll horizontal */
    }

/* ===== Sticky Header ===== */
#table-sales-report-material thead th {
    position: sticky;
    top: 0;
    z-index: 30; /* tinggi supaya di atas td */
    background: #f1f1f1;
    text-transform: capitalize;
    vertical-align: middle;
    text-align: center;
    white-space: nowrap;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
}

/* Baris kedua header juga sticky */
#table-sales-report-material thead tr:nth-child(2) th {
    top: 35px; /* tinggi baris pertama */
    z-index: 29;
    background: #f9f9f9;
}

/* ===== Body ===== */
#table-sales-report-material tbody td {
    vertical-align: middle;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
    background: #fff;
}

#table-sales-report-material tbody tr:hover {
    background-color: #f9f9f9;
}

/* ===== Freeze Kolom ===== */
/* Kolom 1 (No) */
#table-sales-report-material th:nth-child(1) {
    left: 0;
    z-index: 40; /* header freeze paling tinggi */
    background-color: #fff;
}
#table-sales-report-material td:nth-child(1) {
    left: 0;
    z-index: 20; /* lebih rendah dari header */
    position: sticky;
    background-color: #fff;
}

/* Kolom 2 (Customer) */
#table-sales-report-material th:nth-child(2) {
    left: 30px;
    z-index: 40;
    background-color: #fff;
}
#table-sales-report-material td:nth-child(2) {
    left: 30px;
    z-index: 20;
    position: sticky;
    background-color: #fff;
}

/* Kolom 3 (Invoice) */
#table-sales-report-material th:nth-child(3) {
    left: 230px;
    z-index: 40;
    background-color: #fff;
}
#table-sales-report-material td:nth-child(3) {
    left: 230px;
    z-index: 20;
    position: sticky;
    background-color: #fff;
}

/* Kolom 4 (Invoice Date) */
#table-sales-report-material th:nth-child(4) {
    left: 430px;
    z-index: 40;
    background-color: #fff;
}
#table-sales-report-material td:nth-child(4) {
    left: 430px;
    z-index: 20;
    position: sticky;
    background-color: #fff;
}

/* Kolom 4 (Invoice Date) */
#table-sales-report-material th:nth-child(5) {
    left: 630px;
    z-index: 40;
    background-color: #fff;
}
#table-sales-report-material td:nth-child(5) {
    left: 630px;
    z-index: 20;
    position: sticky;
    background-color: #fff;
}

/* ===== Search Input di kanan ===== */
.table-header {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 8px;
}

.search-box {
    position: relative;
}

.search-box input {
    padding: 6px 30px 6px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.search-box i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    pointer-events: none;
}
</style>
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
                                <h3 class="card-title">Sales Report Detail Item</h3>
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
                                                <select class="form-control select2bs4" id="sr_customer_mt" name="sr_customer_mt">
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
                                                <select class="form-control select2bs4" id="sr_type_mt" name="sr_type_mt">
                                                    <option value="All">All</option>
                                                    <option value="Local">Local</option>
                                                    <option value="Export">Export</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>VAT Type</label>
                                                <select class="form-control select2bs4" id="sr_vat_mt" name="sr_vat_mt">
                                                    <option value="All">All</option>
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
                                                <select class="form-control select2bs4" id="sr_type_inv_mt" name="sr_type_inv_mt">
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
                                                <select class="form-control select2bs4" id="sr_vat_status_mt" name="sr_vat_status_mt">
                                                    <option value="All">All</option>
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
                                                <select class="form-control select2bs4" id="sr_curr_mt" name="sr_curr_mt">
                                                    <option value="All">All</option>
                                                    <option value="USD">USD</option>
                                                    <option value="IDR">IDR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Group</label>
                                                <select class="form-control select2bs4" id="sr_group_mt" name="sr_group_mt">
                                                    <option value="All">All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Order Type</label>
                                                <select class="form-control select2bs4" id="sr_order_type_mt" name="sr_order_type_mt">
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
                                            <button type="button" class="btn btn-primary" onclick="cari_sales_report_material()"><i class="fa fa-search"></i> Search</button>
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
    <!-- Data Table Sales Report Material -->
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DataTable Sales Report Detail Item</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-scroll">
                            <div class="table-header">
                                <div class="search-box">
                                    <input type="text" id="tableSearch" placeholder="Search...">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <div class="table-wrapper">
                              <table id="table-sales-report-material" class="table table-bordered table-striped table-head-fixed text-nowrap">
                                <thead>
                                  <tr>
                                    <th style="width:30px;background-color: #FFE4C4;" rowspan="2">No</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Customer</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Invoice</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Invoice Date</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Shipp Number</th>
                                    <th style="width:150px;background-color: #FFE4C4;" rowspan="2">Shipp Date</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Group</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">WS</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Style</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Product Item</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Order Type</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Shipp</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Inv Type</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">VAT Number</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">VAT Date</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Currency</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Rate</th>
                                    <th style="background-color: #90EE90;" colspan="5">Billing Invoice</th>
                                    <th style="background-color: #87CEFA;" colspan="5">Shipping Invoice</th>
                                </tr>
                                <tr>
                                    <th style="width:150px;background-color: #90EE90;">Qty</th>
                                    <th style="width:150px;background-color: #90EE90;">Uom</th>
                                    <th style="width:150px;background-color: #90EE90;">Unit Price</th>
                                    <th style="width:150px;background-color: #90EE90;">Total</th>
                                    <th style="width:150px;background-color: #90EE90;">Total IDR</th>

                                    <th style="width:150px;background-color: #87CEFA;">Qty</th>
                                    <th style="width:150px;background-color: #87CEFA;">Uom</th>
                                    <th style="width:150px;background-color: #87CEFA;">Unit Price</th>
                                    <th style="width:150px;background-color: #87CEFA;">Total</th>
                                    <th style="width:150px;background-color: #87CEFA;">Total IDR</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

                    <!-- /.card-header -->
                    <!-- <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table id="table-sales-report-material" class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Invoice</th>
                                    <th>Invoice Date</th>
                                    <th>Shipp Number</th>
                                    <th>Shipp Date</th>
                                    <th>Group</th>
                                    <th>WS</th>
                                    <th>Style</th>
                                    <th>Product Item</th>
                                    <th>Qty</th>
                                    <th>Qty Shipment</th>
                                    <th>Uom</th>
                                    <th>Uom Shipment</th>
                                    <th>Unit Price</th>
                                    <th>Unit Price Shipment</th>
                                    <th>Shipp</th>
                                    <th>Inv Type</th>
                                    <th>Order Type</th>
                                    <th>Currency</th>
                                    <th>Rate</th>
                                    <th>Original Value</th>
                                    <th>Original Value Shipment</th>
                                    <th>Equiv Value</th>
                                    <th>Equiv Value Shipment</th>
                                    <th>No Faktur</th>
                                    <th>Tgl Faktur</th>                                          
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div> -->
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Button Print -->
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary" onclick="print_sales_report_material()"><i class="fa fa-print"></i> Print</button>
                <button type="button" class="btn btn-info" onclick="export_sales_report_material()"><i class="fa fa-download"></i> Export To Excel</button>
            </div>
        </div>

    </div>
</div>


