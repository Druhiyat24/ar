<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><u><?= $title; ?></u></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Form Element sizes -->
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Form Reverse</h3>
                        </div>
                        <div class="row card-body">
                            <!-- Start Input -->
                            <div class="form-group col-md-3">
                                <label>Reverse Number</label>
                                <input type="text" class="form-control" id="rvs_number" name="rvs_number" value="<?= $kode_reverse; ?>" required readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Reverse Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="rvs_date" id="rvs_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" autocomplete='off' readonly>
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Type Document</label>
                                <select class="form-control select2bs4" id="type_doc" name="type_doc" onchange="updateReversePrefix()" required>
                                  <!--   <option value="" disabled selected>Pilih Type Document</option> -->
                                    <?php foreach ($pilihan as $pil) : ?>
                                        <option value="<?= $pil['nama_pilihan']; ?>"><?= $pil['nama_pilihan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3"></div>

                            <div class="form-group col-md-3">
                                <label>Customer</label>
                                <select class="form-control select2bs4" id="rvs_cust" name="rvs_cust" required>
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
                                <label>Add Data</label>
                                <div class="input-group mb-3">
                                  <span class="input-group-append">
                                    <button id="so_number2" name="so_number2" type="button" class="btn btn-info btn-flat" style="border-radius: 5px;" onclick="add_document_reverse()"><i class="far fa-plus-square"></i> Add Data</button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-7"></div>

                        <div class="form-group col-md-9">
                            <label>Descriptions</label>
                            <textarea class="form-control" id="rvs_deskripsi" name="rvs_deskripsi" rows="2" required autocomplete="off"></textarea>
                        </div>


                    </div>
                </div>
            </div>

        </div>
        <!-- Data Table Create Invoice -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table id="table-doc-reverse" class="table table-head-fixed text-nowrap table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Document Number</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Currency</th>
                                    <th>Total</th>
                                    <th>descriptions</th>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="simpan_data_reverse()"><i class="fa fa-save"></i> Save </button>
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
<div class="modal fade" id="modal-add-docrvs">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
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
                                <input type="text" class="form-control float-left" id="mdl_type_doc" name="nama_custmr" readonly>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!-- <label>Date Range</label> -->
                                    <label>Date Range</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="cobacoba" name="cobacoba">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mt-2">

                            </br>
                            <button type="button" id="find_doc" name="find_doc" class="btn btn-info" href="javascript:void(0)" onclick="cari_data_doc_reverse()"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                    <!-- End Date Range -->
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
                        <input type="text"  id="carinoinv" name="carinoinv" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_inv_alok()">
                    </div>
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table id="table-list-doc" class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Document Number</th>
                                    <th style="width: 10%;">Date</th>
                                    <th style="width: 20%;">customer</th>
                                    <th style="width: 10%;">Currency</th>
                                    <th style="width: 15%;">Total</th>
                                    <th style="width: 24%;">Description</th>
                                    <th style="width: 6%;">Cek</th>
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
        <button type="button" id="btn_add_data_so" name="btn_add_data_so" class="btn btn-primary" href="javascript:void(0)" onclick="simpan_reverse_temp()">Add Data</button>
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
        table = document.getElementById("table-inv-alok");
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