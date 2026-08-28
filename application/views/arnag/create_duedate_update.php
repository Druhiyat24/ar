<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Form Element sizes -->
                    <div class="card">
                        <div class="card-header text-white bg-success">
                            <h3 class="card-title"><?= mb_strtoupper($title, 'UTF-8'); ?></h3>
                        </div>
                        <div class="row card-body">
                            <!-- Start Input -->
                            <div class="form-group col-md-3">
                                <label>Document Number</label>
                                <input type="text" class="form-control" id="duedate_number" name="duedate_number" value="<?= $kode_number; ?>" required readonly>
                                <input type="hidden" id="user_login" name="user_login" value="<?= $this->session->userdata('username'); ?>">
                            </div>

                            <div class="form-group col-md-2">
                                <label>Due Date Update</label>
                                <div class="input-group mb-1">
                                    <input type="text" name="duedate_to" id="duedate_to" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="form-group col-md-7"></div>


                        <div class="form-group col-md-3">
                            <label>Customer</label>
                            <select class="form-control select2bs4" id="duedate_cust" name="duedate_cust" required>
                                <option value="ALL" selected>ALL</option>
                                <?php foreach ($customer as $cs) : ?>
                                    <option value="<?= $cs['Id_Supplier']; ?>"
                                        <?= (isset($invoice['id_customer']) && $invoice['id_customer'] == $cs['Id_Supplier']) ? 'selected' : ''; ?>>
                                        <?= $cs['Supplier']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                            <div class="form-group col-md-2">
                                <label>Type Document</label>
                                <select class="form-control select2bs4" id="type_doc" name="type_doc" required>
                                  <?php foreach ($pilihan as $pil) : ?>
                                    <option value="<?= $pil['nama_pilihan']; ?>" data-kode="<?= $pil['kode_pilihan']; ?>"><?= $pil['nama_pilihan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Add Data</label>
                            <div class="input-group mb-1">
                              <span class="input-group-append">
                                <button id="add_data" name="add_data" type="button" class="btn btn-info btn-flat" style="border-radius: 5px;" onclick="add_document_duedate()"><i class="far fa-plus-square"></i> Add Data</button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-md-7"></div>

                    <div class="form-group col-md-6">
                        <label>Descriptions</label>
                        <textarea class="form-control" id="duedate_deskripsi" name="duedate_deskripsi" rows="2" required autocomplete="off"></textarea>
                    </div>


                </div>
            </div>
        </div>

    </div>
    <!-- Data Table Create Invoice -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">LIST DETAIL</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table id="table-doc-duedate" class="table table-head-fixed text-nowrap table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Reff Number</th>
                                <th>Reff Date</th>
                                <th>Due Date</th>
                                <th>Customer</th>
                                <th>Currency</th>
                                <th>Total</th>
                                <th>Descriptions</th>
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
    <!-- End Data Table Create Invoice -->

    <!-- Button Simpan Data Invoice  -->
    <div class="row col-sm-12">
        <div class="input-group mb-3">
            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" onclick="simpan_data_duedate()"><i class="fa fa-save"></i> Save </button>
            <a href="<?php echo base_url('arnag/list_duedate_update'); ?>" class="btn btn-danger">
                <i class="fas fa-arrow-circle-left"></i> Back
            </a>
        </div>
    </div>
    <!-- End Button Simpan Data Invoice  -->
    <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Modal Add SO And SJ -->
<div class="modal fade" id="modal-add-duedate">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title">Add Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <p>One fine body&hellip;</p> -->
                <!-- Datatable Nomor SO -->
                <div class="card">
                    <div class="card-header">
                        <!-- Date Range -->
                        <div class="row">
                            <div class="col-md-4">
                                <label>Customer</label>
                                <input type="hidden" class="form-control float-left" id="mdl_custmr" name="mdl_custmr" readonly>
                                <input type="text" class="form-control float-left" id="mdl_nama_custmr" name="mdl_nama_custmr" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>Type Document</label>
                                <input type="hidden" class="form-control float-left" id="mdl_type_doc" name="nama_custmr" readonly>
                                <input type="text" class="form-control float-left" id="mdl_type_doc_show" name="nama_custmr" readonly>
                                <input type="hidden" id="user_login_temp" name="user_login_temp" value="<?= $this->session->userdata('username'); ?>">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>From</label>
                                    <div class="input-group">
                                        <input type="text" name="filter_from_so" id="filter_from" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label>To</label>
                                    <div class="input-group">
                                        <input type="text" name="filter_to_so" id="filter_to" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group mb-0">
                                    <label>All Date</label>
                                    <div class="d-flex align-items-center" style="height:38px;">
                                        <input type="checkbox" id="chk_all_date" onchange="toggleAllDate(this)" style="width:18px;height:18px;cursor:pointer;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 mt-2">
                                <br>
                                <button type="button" id="find_doc" name="find_doc" class="btn btn-info" onclick="cari_data_reff_duedate()"><i class="fa fa-search"></i> Search</button>
                            </div>
                    </div>
                    <!-- End Date Range -->
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label>Description</label>
                                <textarea class="form-control" id="mdl_desc_all" name="mdl_desc_all" rows="2" placeholder="Type here to auto-fill the Description of checked rows below" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data</h3>
                        </div>

                        <div class="d-flex justify-content-between">
                         <div class="ml-auto">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text"  id="carinoinv" name="carinoinv" required autocomplete="off" placeholder="Search Reff.." onkeyup="cari_inv_alok()">
                    </div>
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table id="table-list-data" class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Reff Number</th>
                                    <th style="width: 10%;">Reff Date</th>
                                    <th style="width: 10%;">Due Date</th>
                                    <th style="width: 20%;">customer</th>
                                    <th style="width: 10%;">Currency</th>
                                    <th style="width: 15%;">Total</th>
                                    <th style="width: 15%;">amount</th>
                                    <th style="width: 24%;">Description</th>
                                    <th style="width: 6%; text-align:center;"><input type="checkbox" id="check_all_duedate"></th>

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
        <!-- Potongan Invoice -->
    </div>
    <div class="modal-footer right-content-between">
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Add</button> -->
        <button type="button" id="btn_add_data_so" name="btn_add_data_so" class="btn btn-success" href="javascript:void(0)" onclick="simpan_duedate_temp()">Add Data</button>
    </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>


<!-- Modal Simpan Invoice Status POST -->
<div class="modal fade" id="modal-simpan-alokasi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Save Alokasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- No Invoice -->
                <div class="form-group row">
                    <label for="id_inv" class="col-sm-5 col-form-label">Save Alokasi Number :</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="no_alokasi" name="no_alokasi" style="border:none;" readonly>
                    </div>
                </div>
                <!-- ID Invoice, Pph -->
                <input type="hidden" class="form-control" id="id_inv_post" name="id_inv_post" readonly>
                <input type="hidden" class="form-control" id="pph_post" name="pph_post" readonly>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary toastrDefaultSuccess" onclick="save_alokasi()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Date 1 -->
<div class="modal fade" id="modal-show-date1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Date</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Start Date  -->
                <p>Select Date</p>
                <div class="form-group" style="width: 250px;">
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="reservationdate" class="form-control datetimepicker-input" data-target="#reservationdate" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="tambah_tanggal_1()">Apply</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Show Date 2 -->
<div class="modal fade" id="modal-show-date2">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Date</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Start Date  -->
                <p>Select Date</p>
                <div class="form-group" style="width: 250px;">
                    <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                        <input type="text" name="reservationdate2" class="form-control datetimepicker-input" data-target="#reservationdate2" />
                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="tambah_tanggal_2()">Apply</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Only Input Number In Text -->
<script>
    function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;
        return true;
    }
</script>



<script>
    function cariso() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cariso");
        filter = input.value.toUpperCase();
        table = document.getElementById("example4");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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
    function cari_noinvoice() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_noinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-add-bookinvoice");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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
    function cari_shipp_num() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_shipp");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-sj-2");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[4]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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
    function cari_inv_alok() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("carinoinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-list-data");
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