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
                            <h3 class="card-title">Due Date</h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="col-md-3">
                        <div class="input-group">
                            <button type="button" id="add_duedate" name="add_duedate" class="btn btn-primary" data-toggle="modal" data-target="#modal-update-duedate"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                    <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cari_doc" name="cari_doc" required autocomplete="off" placeholder="Search invoice number.." onkeyup="cari_doc_num()">
                             </div>
                <div class="card-body table-responsive p-0" style="height: 350px;">
                    <table id="table-duedate-inv" class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Doc Number</th>
                                <th>Inv Date</th>
                                <th>Kontrabon Date</th>
                                <th>Top</th>
                                <th>DueDate</th>
                                <th>Inv Number</th>
                                <th>Customer</th>
                                <th>Shipp</th>
                                <th>Document Type</th>
                                <th>Document Number</th>
                                <th>Type</th>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($load_duedate_inv as $dd_inv) : ?>
                                <tr>
                                    <td><?= $dd_inv['no_duedate']; ?></td>
                                    <td><?= $dd_inv['invoice_date']; ?></td>
                                    <td><?= $dd_inv['kontrabon_date']; ?></td>
                                    <td><?= $dd_inv['top']; ?> Days</td>
                                    <td><?= $dd_inv['duedate']; ?></td>
                                    <td><?= $dd_inv['no_invoice']; ?></td>
                                    <td><?= $dd_inv['customer']; ?></td>
                                    <td><?= $dd_inv['shipp']; ?></td>
                                    <td><?= $dd_inv['doc_type']; ?></td>
                                    <td><?= $dd_inv['doc_number']; ?></td>
                                    <td><?= $dd_inv['type']; ?></td>
                                    <td><?= $dd_inv['id']; ?></td>
                                    <td><?= $dd_inv['status']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-cancel-duedate<?= $dd_inv['id']; ?>">Cancel</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

<!-- Modal Add DueDate -->
<div class="modal fade" id="modal-update-duedate">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">DueDate</h4>
            </div>
            <div class="modal-body">
                <!-- <p>One fine body&hellip;</p> -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Doc Number :</label>
                                <input type="text" class="form-control" id="doc_dd" name="doc_dd" readonly value="<?= $kode_duedate; ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kontabon Date :</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tgl_kontrabon" id="tgl_kontrabon">
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Note :</label>
                                <input type="text" class="form-control" id="cat_dd" name="cat_dd" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Customer</label>
                                <select class="form-control select2bs4" id="customer_dd" name="customer_dd" required>
                                    <?php foreach ($customer as $cs) : ?>
                                        <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Invoice Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation2" name="reservation2">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Action</label>
                                <div class="input-group">
                                    <button type="button" id="find_inv_dd" name="find_inv_dd" class="btn btn-primary" href="javascript:void(0)" onclick="cari_invoice_dd()"><i class="fa fa-search"></i> Search Invoice</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_noinvoice()">
                             </div>
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Inv Number</th>
                                    <th>Customer</th>
                                    <th>Shipp</th>
                                    <th>Document Type</th>
                                    <th>Document Number</th>
                                    <th>Tanggal</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>ID</th>
                                    <th style="width: 10px">Cek</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal" href="javascript:void(0)" onclick="reload_page_duedate()">Cancel</button>
                <button type="button" id="" name="" class="btn btn-primary" href="javascript:void(0)" onclick="save_duedate()">Save Change</button>
                <!-- <button type="button" id="btn_add_data_so" name="btn_add_data_so" class="btn btn-primary" href="javascript:void(0)" onclick="save_duedate()">Save Change</button> -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Cancel DueDate -->
<?php foreach ($load_duedate_inv as $dd) : ?>
    <div class="modal fade" id="modal-cancel-duedate<?= $dd['id']; ?>">
        <form action="<?= base_url('arnag/cancel_duedate'); ?>" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--  -->
                        <p>Are you sure cancel Duedate : <?= $dd['doc_number']; ?> ?</p>
                        <input type="hidden" id="id_modal_dd" name="id_modal_dd" value="<?= $dd['id']; ?>" readonly>
                        <!--  -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary toastsDefaultDanger">Cancel Duedate</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php endforeach; ?>

<script>
    function cari_noinvoice() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_noinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("example2");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

    <script>
    function cari_doc_num() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_doc");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-duedate-inv");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[5]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>