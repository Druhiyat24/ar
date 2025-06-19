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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Cek Proforma Invoice</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Customer</label>
                                        <select class="form-control select2bs4" id="list_prof_customer" name="list_prof_customer">
                                            <option value="all_customer">All Customer</option>
                                            <?php foreach ($customer as $cs) : ?>
                                                <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <!-- <label>Date Range</label> -->
                                            <label>Date Range</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control float-right" id="reservation2" name="reservation2">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Bank -->
                                    <!-- <div class="form-group col-md-3">
                                        <label>Bank</label>
                                        <select class="form-control" id="list_prof_bank" name="list_prof_bank" required>
                                            <?php foreach ($bank as $bk) : ?>
                                                <option value="<?= $bk['id']; ?>"><?= $bk['nama_bank']; ?> (<?= $bk['no_rek']; ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div> -->
                                    <!-- End Bank -->
                                    <div class="form-group">
                                        <label>Action</label>
                                        <div class="input-group">
                                            <button type="button" id="find_invoice_pi" name="find_invoice_pi" class="btn btn-primary" href="javascript:void(0)" onclick="cari_proforma_invoice()"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Export Data</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-info" onclick="export_list_pi()"><i class="fa fa-download"></i> Export</button>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-1">
                                        <label>Create</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-info" onclick="export_list_pi()"><i class="fa fa-download"></i> Create</button>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>

            <!-- Data Table List Proforma Invoice -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable Proforma Invoice</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table id="table-list-proforma-invoice" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>No Prof Inv</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Shipp</th>
                                        <th>Peb</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Faktur Pajak</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                       <!--  <th>Export</th> -->
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
        </div><!-- /.container-fluid -->
    </section>
</div>

<!-- Modal Update Faktur Pajak -->
<div class="modal fade" id="modal-update-faktur-pjk">
    <form action="<?= base_url('arnag/update_faktur_pajak'); ?>" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Update</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Update Paktur Pajak -->
                    <input type="hidden" name="id_inv_prof" id="id_inv_prof" required readonly>
                    <div class="form-group col-md-12">
                        <label>Input Faktur Pajak</label>
                        <input type="text" class="form-control" id="no_paktur_pjk" name="no_paktur_pjk" autocomplete="off">
                    </div>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>