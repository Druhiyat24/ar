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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">List Reverse Document</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-2">
                                        <label>Type Document</label>
                                        <select class="form-control select2bs4" id="doc_type" name="doc_type">
                                            <option value="ALL">ALL</option>
                                            <?php foreach ($pilihan as $pil) : ?>
                                                <option value="<?= $pil['nama_pilihan']; ?>"><?= $pil['nama_pilihan']; ?></option>
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

                                    <div class="form-group">
                                        <label>Action</label>
                                        <div class="input-group d-flex gap-2">
                                            <button type="button" id="find_invoice" name="find_invoice" class="btn btn-primary mr-2" onclick="cari_list_reverse()">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                            <button type="button" class="btn btn-success mr-2" onclick="window.location.href='<?= base_url("arnag/create_reverse_document") ?>'">
                                                <i class="fa fa-plus"></i> Create
                                            </button>

                                            <button type="button" class="btn btn-info mr-2" onclick="export_list_invoice()">
                                                <i class="fa fa-download"></i> Export Excel
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>

            <!-- Data Table List Invoice -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Data</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search No Reverse.." onkeyup="cari_noinvoice()">
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table id="table-reverse" class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>No Reverse</th>
                                    <th>Reverse Date</th>
                                    <th>Doc Type</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Created User</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
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

<div class="modal fade" id="modal-cancel-inv">
    <form action="<?= base_url('arnag/cancel_reverse_document'); ?>" method="POST">
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
                    <div class="form-group row">
                        <label for="id_inv" class="col-sm-5 col-form-label">Sure Cancel No Reverse :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="txt_cancel_book" name="txt_cancel_book" style="border:none;" readonly>
                        </div>
                    </div>
                    <!-- Hidden Text -->
                    <input type="hidden" id="id_book_inv" name="id_book_inv" readonly>
                    <input type="hidden" id="id_bppb" name="id_bppb" readonly>
                    <input type="hidden" id="user" name="user" value="<?= $user['username']; ?>" readonly>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php $data = $user['username'];
                    if ($data == 'willy' || $data == 'yulianto' || $data == 'hady' || $data == 'hadi' || $data == 'jefri' || $data == 'ramon' || $data == 'lukman') 
                    {
                        echo '<button type="submit" class="btn btn-primary toastsDefaultDanger">Cancel Invoice</button>';
                    } else {
                        echo '<button type="button" disabled class="btn btn-primary toastsDefaultDanger">Cancel Invoice</button>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- MODAL UPDATE -->
<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">Confirm Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_book_inv" id="id_book_inv" readonly>
                <div class="form-group col-md-12">
                    <label>Invoice Number</label>
                    <input type="text" class="form-control" id="no_inv" readonly>
                </div>
                <div class="form-group col-md-12">
                    <label>TOP</label>
                    <select id="top_inv" class="form-control select2bs4" required></select>
                    <input type="number" id="top_manual" class="form-control mt-2" placeholder="Masukkan TOP manual (hari)" style="display: none;">
                    <input type="text" id="id_customer" class="form-control mt-2" value="" style="display: none;">
                </div>
                <div class="row">
                    <div class=" col-md-6">
                        <label>Inv Date</label>
                        <div class="input-group mb-3">
                            <input type="text" name="inv_date" id="inv_date" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <label>Due Date</label>
                        <div class="input-group mb-3">
                            <input type="text" name="due_date" id="due_date" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="submitUpdateTOP()" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Invoice Detail -->
<div class="modal fade" id="modal-inv-detail">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Reverse Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Datatable Invoice Detail -->
                <div class="form-group">
                    <div class="col-md-4">
                        <label>Reverse Number</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="inv_number_list" name="inv_number_list" readonly>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 400px;">
                            <table id="table-inv-detail" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Document Number</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Curr</th>
                                        <th>Total</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                    <!-- End Datatable Nomor Booking Invoice  -->
                </div>
            
                <!--  -->
                <div class="modal-footer right-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        function cari_noinvoice() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_noinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-reverse");
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
