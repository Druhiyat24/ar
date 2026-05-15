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
                       <div class="card-header text-white bg-success">
                            <h3 class="card-title"><?= mb_strtoupper($title, 'UTF-8'); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
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

                                    <div class="form-group">
                                        <label>Action</label>
                                        <div class="input-group">

                                            <button type="button" class="btn btn-info" onclick="cari_list_duedate_update()">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            <a href="<?php echo base_url('arnag/create_duedate_update'); ?>" class="btn btn-warning ml-2">
                                                <i class="fas fa-plus"></i> Create
                                            </a>

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
            <div class="card">
    <div class="card-header bg-info">
        <h3 class="card-title">LIST DATA</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table id="table-list-duedate-update" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Document Number</th>
                        <th>DueDate Update</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>User Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

        </div><!-- /.container-fluid -->
    </section>
</div>

<div class="modal fade" id="modal-cancel-inv-nb">
    <form action="<?= base_url('arnag/cancel_invoice_nb'); ?>" method="POST">
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
                        <label for="id_inv" class="col-sm-5 col-form-label">Sure Cancel List Invoice :</label>
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
                    if ($data == 'willy' || $data == 'yulianto' || $data == 'hady' || $data == 'hadi' || $data == 'jefri' || $data == 'ramon' || $data == 'lukman' || $data == 'oktora' || $data == 'oktora malau') 
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

<!-- Modal Invoice Detail -->
<div class="modal fade" id="modal-duedate-detail">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">DETAIL DATA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Datatable Invoice Detail -->
                <div class="form-group">
                    <div class="col-md-3">
                        <label>Document Number</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="inv_number_list" name="inv_number_list" readonly>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 400px;">
                            <table id="table-duedate-detail" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Reff Number</th>
                                        <th>Reff Date</th>
                                        <th>DueDate</th>
                                        <th>Customer</th>
                                        <th>Curr</th>
                                        <th>Total</th>
                                        <th>Deskripsi</th>
                                        <th>status</th>
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
        table = document.getElementById("table-invoice-nb");
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
