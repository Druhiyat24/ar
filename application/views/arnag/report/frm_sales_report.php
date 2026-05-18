<style>
    .table-wrapper {
        max-height: 500px;
        overflow: auto;
        position: relative;
    }

    .table-scroll {
        /* overflow ditangani table-wrapper */
    }

    #table-sales-report {
        border-collapse: collapse;
        width: max-content; /* Supaya bisa scroll horizontal */
    }

/* ===== Body ===== */
#table-sales-report tbody td {
    vertical-align: middle;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
    background: #fff;
}
#table-sales-report tbody tr:hover td { background-color: #f9f9f9; }

/* ===== Freeze Kolom Body ===== */
#table-sales-report td:nth-child(1) { position:sticky !important; left:0 !important;     z-index:20; background:#fff; }
#table-sales-report td:nth-child(2) { position:sticky !important; left:30px !important;  z-index:20; background:#fff; }
#table-sales-report td:nth-child(3) { position:sticky !important; left:230px !important; z-index:20; background:#fff; }
#table-sales-report td:nth-child(4) { position:sticky !important; left:430px !important; z-index:20; background:#fff; }

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
                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label>From</label>
                                                <div class="input-group">
                                                    <input type="text" name="filter_from" id="filter_from" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label>To</label>
                                                <div class="input-group">
                                                    <input type="text" name="filter_to" id="filter_to" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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

                    <div class="card-body">
                        <div class="table-header">
                            <div class="search-box">
                                <input type="text" id="tableSearch" placeholder="Search...">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <div id="sales-table-wrap" style="max-height:500px; overflow:auto; position:relative;">
                              <table id="table-sales-report" class="table table-bordered table-striped text-nowrap" style="border-collapse:collapse; width:max-content;">
                                <thead>
                                  <tr>
                                    <th style="width:30px;background-color: #FFE4C4;" rowspan="2">No</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Customer</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Invoice</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Invoice Date</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Group</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Relationship</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Profit Center</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">TOP</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Order Type</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Shipp</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Inv Type</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">VAT Number</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">VAT Date</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Currency</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Rate</th>
                                    <th style="background-color: #90EE90;" colspan="8">Billing Invoice (Original Currency)</th>
                                    <th style="background-color: #90EE90;" colspan="8">Billing Invoice (Equivalent IDR)</th>
                                    <th style="background-color: #87CEFA;" colspan="8">Shipping Invoice (Original Currency)</th>
                                    <th style="background-color: #87CEFA;" colspan="8">Shipping Invoice (Equivalent IDR)</th>
                                    <th style="width:50px;background-color: #FFFFFF;border:1px solid #FFFFFF;" rowspan="2"></th>
                                    <th style="width:200px;background-color: #FFDAB9;" rowspan="2">Net Sales</th>
                                    <th style="width:200px;background-color: #FFDAB9;" rowspan="2">VAT</th>
                                    <th style="width:200px;background-color: #FFDAB9;" rowspan="2">Total</th>
                                </tr>
                                <tr>
                                    <th style="width:150px;background-color: #90EE90;">Qty</th>
                                    <th style="width:150px;background-color: #90EE90;">Gross Sales</th>
                                    <th style="width:150px;background-color: #90EE90;">Others Sales</th>
                                    <th style="width:150px;background-color: #90EE90;">Discount</th>
                                    <th style="width:150px;background-color: #90EE90;">Net Sales</th>
                                    <th style="width:150px;background-color: #90EE90;">Down Payment</th>
                                    <th style="width:150px;background-color: #90EE90;">VAT</th>
                                    <th style="width:150px;background-color: #90EE90;">Total</th>

                                    <th style="width:150px;background-color: #90EE90;">Qty</th>
                                    <th style="width:150px;background-color: #90EE90;">Gross Sales</th>
                                    <th style="width:150px;background-color: #90EE90;">Others Sales</th>
                                    <th style="width:150px;background-color: #90EE90;">Discount</th>
                                    <th style="width:150px;background-color: #90EE90;">Net Sales</th>
                                    <th style="width:150px;background-color: #90EE90;">Down Payment</th>
                                    <th style="width:150px;background-color: #90EE90;">VAT</th>
                                    <th style="width:150px;background-color: #90EE90;">Total</th>

                                    <th style="width:150px;background-color: #87CEFA;">Qty</th>
                                    <th style="width:150px;background-color: #87CEFA;">Gross Sales</th>
                                    <th style="width:150px;background-color: #87CEFA;">Others Sales</th>
                                    <th style="width:150px;background-color: #87CEFA;">Discount</th>
                                    <th style="width:150px;background-color: #87CEFA;">Net Sales</th>
                                    <th style="width:150px;background-color: #87CEFA;">Down Payment</th>
                                    <th style="width:150px;background-color: #87CEFA;">VAT</th>
                                    <th style="width:150px;background-color: #87CEFA;">Total</th>

                                    <th style="width:150px;background-color: #87CEFA;">Qty</th>
                                    <th style="width:150px;background-color: #87CEFA;">Gross Sales</th>
                                    <th style="width:150px;background-color: #87CEFA;">Others Sales</th>
                                    <th style="width:150px;background-color: #87CEFA;">Discount</th>
                                    <th style="width:150px;background-color: #87CEFA;">Net Sales</th>
                                    <th style="width:150px;background-color: #87CEFA;">Down Payment</th>
                                    <th style="width:150px;background-color: #87CEFA;">VAT</th>
                                    <th style="width:150px;background-color: #87CEFA;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div><!-- /#sales-table-wrap -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>

            <!-- /.card-header -->
                    <!-- <div class="card-body table-responsive p-0" style="height: 300px;">
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
                                    <th>Qty Billing</th>
                                    <th>Qty Shipment</th>
                                    <th>Currency</th>
                                    <th>Rate</th>
                                    <th>Original Value Billing</th>
                                    <th>Original Value Shipment</th>
                                    <th>Equiv Value Billing</th>
                                    <th>Equiv Value Shipment</th>
                                    <th>VAT</th>
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
                <button type="button" class="btn btn-primary" onclick="print_sales_report()"><i class="fa fa-print"></i> Print</button>
                <button type="button" class="btn btn-info" onclick="export_sales_report()"><i class="fa fa-download"></i> Export To Excel</button>
            </div>
        </div>
    </div>
</div>

<script>
/* Hitung top row-2 header setelah layout ready */
(function applySalesSticky() {
    var tr1 = document.querySelector('#table-sales-report thead tr:first-child');
    if (!tr1) { setTimeout(applySalesSticky, 50); return; }
    var h = tr1.getBoundingClientRect().height;
    if (h <= 0) { setTimeout(applySalesSticky, 50); return; }

    var frozenLeft = [0, 30, 230, 430]; // left offset tiap kolom frozen

    // Row 1: semua th sticky top:0, 4 kolom pertama juga sticky left
    var row1Ths = tr1.querySelectorAll('th');
    row1Ths.forEach(function(th, i) {
        th.style.setProperty('position', 'sticky', 'important');
        th.style.setProperty('top', '0px', 'important');
        th.style.setProperty('z-index', i < 4 ? '41' : '30', 'important');
        if (i < 4) th.style.setProperty('left', frozenLeft[i] + 'px', 'important');
    });

    // Row 2: sticky top = tinggi row 1
    document.querySelectorAll('#table-sales-report thead tr:nth-child(2) th').forEach(function(th) {
        th.style.setProperty('position', 'sticky', 'important');
        th.style.setProperty('top', h + 'px', 'important');
        th.style.setProperty('z-index', '29', 'important');
    });
})();

document.getElementById("tableSearch").addEventListener("keyup", function() {
    let value = this.value.toLowerCase().trim();
    let rows = document.querySelectorAll("#table-sales-report tbody tr");

    rows.forEach(function(row) {
        // ambil hanya kolom tertentu (index mulai dari 0)
        let colsToSearch = [1,2,4,5,6,8,9,10,13];
        let match = false;

        for (let i of colsToSearch) {
            let cell = row.cells[i];
            if (cell) {
                let text = cell.textContent.toLowerCase().trim().replace(/\s+/g, " ");
                if (text.indexOf(value) > -1) {
                    match = true;
                    break;
                }
            }
        }

        row.style.display = match ? "" : "none";
    });
});
</script>

<!-- <script>
// Search cepat tanpa lemot
document.getElementById("tableSearch").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    let rows = document.getElementById("table-sales-report").tBodies[0].rows;

    for (let i = 0; i < rows.length; i++) {
        let rowText = rows[i].innerText.toLowerCase();
        rows[i].style.display = rowText.indexOf(value) > -1 ? "" : "none";
    }
});
</script> -->