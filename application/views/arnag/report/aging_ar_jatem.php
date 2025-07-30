<!-- Content Wrapper. Contains page content -->
<style>
  /* Title Case hanya pada header */
  #table-aging-ar thead th {
    text-transform: capitalize;
    vertical-align: middle !important;
    text-align: center;
    white-space: nowrap;
}

#table-aging-ar tbody td {
    vertical-align: middle;
}

/* Tambahkan border dan padding */
#table-aging-ar th,
#table-aging-ar td {
    border: 1px solid #dee2e6;
    padding: 6px 10px;
}

/* Header background lebih mencolok */
#table-aging-ar thead {
    background-color: #f1f1f1;
}

/* Table hover */
#table-aging-ar tbody tr:hover {
    background-color: #f9f9f9;
}

/* Optional: Responsive horizontal scroll */
.table-responsive {
    overflow-x: auto;
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
                                <h3 class="card-title">Aging Piutang Dagang</h3>
                            </div>
                            <!-- /.card-header -->
                            <form>
                                <div class="card-body">
                                    <!-- Row 1 -->
                                    <div class="row">
                                      <!-- Customer -->
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

                              <div class="col-md-2">
                                <div class="form-group">
                                  <label>Periode</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" id="monthPicker" class="form-control" placeholder="Pilih Bulan">
                                <input type="hidden" id="start_date" name="start_date">
                                <input type="hidden" id="end_date" name="end_date">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Search & Export (Horizontal) -->
                    <div class="form-group">
                        <label>Action</label>
                        <div class="input-group d-flex gap-2">
                            <button type="button" id="find_invoice" name="find_invoice" class="btn btn-primary mr-2" onclick="cari_aging_jatem()">
                                <i class="fa fa-search"></i> Search
                            </button>
                            <button type="button" class="btn btn-info mr-2" onclick="export_list_invoice()">
                                <i class="fa fa-download"></i> Export Excel
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable Sales Report</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <div class="table-responsive">
                      <table id="table-aging-ar" class="table table-bordered table-striped table-head-fixed text-nowrap">
                        <thead>
                          <tr>
                            <th rowspan="2">No</th>
                            <th colspan="3">Konsumen</th>
                            <th rowspan="2">Top</th>
                            <th rowspan="2">Total</th>
                            <th rowspan="2">M - > 6</th>
                            <th rowspan="2">M - 5</th>
                            <th rowspan="2">M - 4</th>
                            <th rowspan="2">M - 3</th>
                            <th rowspan="2">M - 2</th>
                            <th rowspan="2">M - 1</th>
                            <th rowspan="2">Bulan Berjalan</th>
                            <th rowspan="2">AR Days</th>
                            <th colspan="4">Jatuh Tempo Piutang</th>
                        </tr>
                        <tr>
                            <th>Coa</th>
                            <th>Id</th>
                            <th>Nama</th>
                            <th>1 - 30 H</th>
                            <th>31 - 60 H</th>
                            <th>61 - 90 H</th>
                            <th>> 90 H</th>
                        </tr>
                    </thead>
                    <tbody>
                      <!-- Data di sini -->
                  </tbody>
              </table>
          </div>

      </div>
      <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
</div>
<!-- Button Print -->
            <!-- <div class="row">
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary" onclick="print_sales_report()"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-info" onclick="export_sales_report()"><i class="fa fa-download"></i> Export To Excel</button>
                </div>
            </div> -->
        </div>
    </div>