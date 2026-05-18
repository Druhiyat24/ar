<style>
    .table-wrapper {
        max-height: 350px;
        overflow-y: auto;
        position: relative;
    }

    .table-scroll {
        overflow-x: auto;
    }

    #table-projection-report {
        border-collapse: collapse;
        width: max-content; /* Supaya bisa scroll horizontal */
    }

/* ===== Sticky Header ===== */
#table-projection-report thead th {
    position: sticky !important;
    top: 0 !important;
    z-index: 30 !important;
    background: #f1f1f1 !important;
    text-transform: capitalize;
    vertical-align: middle !important;
    text-align: center !important;
    white-space: nowrap !important;
    border: 1px solid #dee2e6 !important;
    padding: 6px 10px !important;  /* override global padding agar tinggi row 1 tetap 31px */
    font-size: 12px !important;
}

/* Baris kedua header sticky — top di-set otomatis via JS sesuai tinggi row 1 */
#table-projection-report thead tr:nth-child(2) th {
    top: 35px; /* fallback, di-override JS */
    z-index: 29 !important;
    background: #f9f9f9 !important;
}

/* ===== Body ===== */
#table-projection-report tbody td {
    vertical-align: middle;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
    background: #fff;
}

#table-projection-report tbody tr:hover {
    background-color: #f9f9f9;
}

/* ===== Freeze Kolom ===== */
/* Kolom 1 (No) */
#table-projection-report th:nth-child(1) {
    left: 0;
    z-index: 40; /* header freeze paling tinggi */
    background-color: #fff;
}
#table-projection-report td:nth-child(1) {
    left: 0;
    z-index: 20; /* lebih rendah dari header */
    position: sticky;
    background-color: #fff;
}

/* Kolom 2 (Customer) */
#table-projection-report th:nth-child(2) {
    left: 30px;
    z-index: 40;
    background-color: #fff;
}
#table-projection-report td:nth-child(2) {
    left: 30px;
    z-index: 20;
    position: sticky;
    background-color: #fff;
}

/* Kolom 3 (Invoice) */
#table-projection-report th:nth-child(3) {
    left: 230px;
    z-index: 40;
    background-color: #fff;
}
#table-projection-report td:nth-child(3) {
    left: 230px;
    z-index: 20;
    position: sticky;
    background-color: #fff;
}

/* Kolom 4 (Invoice Date) */
#table-projection-report th:nth-child(4) {
    left: 430px;
    z-index: 40;
    background-color: #fff;
}
#table-projection-report td:nth-child(4) {
    left: 430px;
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

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div> -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <div class="card_body ml-3 mr-3">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><?= $title; ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <!-- Row 1 -->
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <div class="form-group mb-0">
                                                <label>Customer</label>
                                                <select class="form-control select2bs4" id="sr_customer" name="sr_customer">
                                                    <option value="All">All Customer</option>
                                                    <?php foreach ($customer as $cs) : ?>
                                                        <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

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

                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label>Type</label>
                                                <select class="form-control select2bs4" id="filter_type" name="filter_type">
                                                    <option value="daily">Daily</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="d-flex" style="gap:8px;">
                                                <button type="button"
                                                    id="find_data"
                                                    class="btn btn-primary"
                                                    style="height:38px; white-space:nowrap;"
                                                    onclick="cari_projection_report()">
                                                    <i class="fa fa-search"></i> Search
                                                </button>

                                                <button type="button"
                                                    class="btn btn-success"
                                                    style="height:38px; white-space:nowrap;"
                                                    onclick="export_projection_report()">
                                                    <i class="fa fa-file-excel"></i> Export
                                                </button>

                                                <button type="button"
                                                    class="btn btn-warning"
                                                    style="height:38px; white-space:nowrap;"
                                                    onclick="save_history_projection_report()">
                                                    <i class="fa fa-download"></i> Save History
                                                </button>
                                            </div>
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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Detail Data</h3>
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
                              <table id="table-projection-report" class="table table-bordered table-striped table-head-fixed text-nowrap">
                                <thead>
                                  <tr>
                                    <th style="width:30px;background-color: #FFE4C4;" rowspan="2">No</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Customer</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Reff Number</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Reff Date</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Category</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Due Date</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Due Date Update</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">TOP</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Curr</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Total</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Rate</th>
                                    <th style="width:200px;background-color: #FFE4C4;" rowspan="2">Total IDR</th>
                                    <th style="background-color: #90EE90;" colspan="">Duedate Pojection</th>
                                </tr>
                                <tr>
                                    <th style="width:150px;background-color: #90EE90;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

                </div>
                <!-- /.card -->
            </div>
        </div>
        
    </div>
</div>

<script>
document.getElementById("tableSearch").addEventListener("keyup", function() {
    let value = this.value.toLowerCase().trim();
    let rows = document.querySelectorAll("#table-projection-report tbody tr");

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
