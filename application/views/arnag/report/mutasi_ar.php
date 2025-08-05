<!-- Content Wrapper. Contains page content -->
<style>
  .table-wrapper {
    max-height: 350px;
    overflow-y: auto;
    position: relative;
}

.table-scroll {
    overflow-x: auto;
}

#table-mut-ar {
    border-collapse: collapse;
    width: max-content; /* Supaya bisa scroll horizontal */
}

/* Sticky Header */
#table-mut-ar thead th {
    position: sticky;
    top: 0;
    z-index: 3; /* Pastikan header paling atas */
    background: #f1f1f1;
    text-transform: capitalize;
    vertical-align: middle;
    text-align: center;
    white-space: nowrap;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
}

/* Baris kedua header juga sticky */
#table-mut-ar thead tr:nth-child(2) th {
    top: 35px; /* Sesuaikan ini dengan tinggi baris pertama */
    z-index: 2;
    background: #f9f9f9;
}

/* Body */
#table-mut-ar tbody td {
    vertical-align: middle;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
}

/* Hover row */
#table-mut-ar tbody tr:hover {
    background-color: #f9f9f9;
}

/* Optional hilangkan border sel kosong */
#table-mut-ar td.empty-cell {
    border: none !important;
    padding: 0 !important;
}

/* Header dengan garis double */
#table-mut-ar thead tr.header-bold th {
    font-weight: bold;
    border: double 3px #999 !important;
}
</style>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
            </div>
        </div>
    </section>
    <div class="card_body">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Piutang Dagang</h3>
                            </div>
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

                    <div class="form-group">
                        <label>Action</label>
                        <div class="input-group d-flex gap-2">
                            <button type="button" id="find_invoice" name="find_invoice" class="btn btn-primary mr-2" onclick="cari_mut_ar()">
                                <i class="fa fa-search"></i> Search
                            </button>
                            <button type="button" class="btn btn-info mr-2" onclick="export_mut_ar()">
                                <i class="fa fa-download"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Aging</h3>
            </div>
            <div class="table-scroll">
                <div class="table-wrapper">
                  <table id="table-mut-ar" class="table table-bordered table-striped table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        <th rowspan="2">No</th>
                        <th style="width:450px;" colspan="3">Konsumen</th>
                        <th style="width:75px;" rowspan="2">Top</th>
                        <th style="width:180px;" rowspan="2">Saldo Awal</th>
                        <th style="width:180px;" colspan="2">Penambahan</th>
                        <th style="width:180px;" colspan="4">Pengurangan</th>
                        <th style="width:180px;" rowspan="2">Saldo Akhir</th>
                        <th style="width:90px;" rowspan="2">AR Days</th>
                    </tr>
                    <tr>
                        <th style="width:100px;">Coa</th>
                        <th style="width:50px;">Id</th>
                        <th style="width:300px;">Nama</th>
                        <th style="width:180px;">Penjualan</th>
                        <th style="width:180px;">Lain-lain</th>
                        <th style="width:180px;">Pelunasan</th>
                        <th style="width:180px;">Retur</th>
                        <th style="width:180px;">Pph 23</th>
                        <th style="width:180px;">Lain-lain</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
</div>
</div>
</section>
</div>
</div>
