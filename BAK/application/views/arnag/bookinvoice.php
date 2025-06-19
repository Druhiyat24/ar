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
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Form Input</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-12">
                                            <label>Invoice Number</label>
                                            <input type="text" class="form-control" id="inv_book_number" name="inv_book_number" value="<?= $kode_book_invoice; ?>" required readonly>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Customer</label>
                                            <select class="form-control select2bs4" id="customer" name="customer" required>
                                                <?php foreach ($customer as $cs) : ?>
                                                    <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Shipp</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="shipp" name="shipp" readonly required>
                                                <span class="input-group-append">
                                                    <button id="L" name="L" type="button" class="btn btn-success btn-flat" onclick="get_kode_booking_invoice('L')"><i class="fa fa-car"></i> Local</button>
                                                    <button id="E" name="E" type="button" class="btn btn-info btn-flat" onclick="get_kode_booking_invoice('E')"><i class="fa fa-plane"></i> Export</button>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- DOCUMENT TYPE -->
                                        <div class="form-group col-md-12">
                                            <label>Document Type</label>
                                            <select class="form-control select2bs4" id="doc_type" name="doc_type">

                                            </select>
                                        </div>
                                        <!-- DOCUMENT NUMBER -->
                                        <div class="form-group col-md-12">
                                            <label>Document Number</label>
                                            <input type="text" class="form-control" id="doc_number" name="doc_number" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Amount</label>
                                            <input type="text" class="form-control" id="val" name="val" onkeypress="javascript:return isNumber(event)" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Type</label>
                                            <select id="type" name="type" class="form-control" required>
                                                <?php foreach ($type as $t) : ?>
                                                    <option value="<?= $t['id_type']; ?>"><?= $t['type']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" onclick="modal_book_invoice()"><i class="fa fa-save"></i> Submit</button>
                                            <a href="<?= base_url('arnag/bookinvoice'); ?>" class="btn btn-info" role="button">Refresh</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>

            <!-- Data Table Booking Invoice -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Cek Data Booking Invoice</h3>
                                </div>
                                <form>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label>Customer</label>
                                                <select class="form-control select2bs4" id="book_customer" name="book_customer">
                                                    <option value="all_customer">All Customer</option>
                                                    <?php foreach ($book_customer as $bcs) : ?>
                                                        <option value="<?= $bcs['Id_Supplier']; ?>"><?= $bcs['Supplier']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Date Range</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control float-right" id="reservation2" name="reservation2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Status</label>
                                                <select class="form-control select2bs4" id="book_status" name="book_status">
                                                    <option value="All">All</option>
                                                    <option value="DRAFT">DRAFT</option>
                                                    <option value="POST">POST</option>
                                                    <option value="APPROVED">APPROVED</option>
                                                </select>
                                            </div>                                          
                                            <div class="form-group">
                                                <label>Action</label>
                                                <div class="input-group">
                                                    <button type="button" id="find_book_invoice" name="find_book_invoice" class="btn btn-primary" href="javascript:void(0)" onclick="loadbookinvoice()"><i class="fa fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                        <label>Export Data</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-info" onclick="export_book_invoice()"><i class="fa fa-download"></i> Export To Excel</button>
                                        </div>
                                    </div>


                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table Booking Invoice -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">DataTable Booking Invoice</h3>
                                </div>
                                <div>
                        <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_noinvoice()">
                             </div>


                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                    <table id="table-booking-invoice" class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Inv Number</th>
                                                <th>Customer</th>
                                                <th>Shipp</th>
                                                <th>Tanggal</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Doc Type</th>
                                                <th>Doc Number</th>
                                                <th>Value</th>
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

        </div><!-- /.container-fluid -->
    </section>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modal-add-booking-invoice">
    <form action="<?= base_url('arnag/simpan_booking_invoice'); ?>" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- No Booking Invoice -->
                    <div class="form-group row">
                        <label for="id_inv" class="col-sm-5 col-form-label">Booking Invoice Number :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="id_inv" name="id_inv" style="border:none;" readonly>
                        </div>
                    </div>
                    <!-- HIDDEN COMPONENT -->
                    <!-- ID Customer -->
                    <input type="hidden" class="form-control" id="id_cust" name="id_cust" readonly>
                    <!-- Type Shipp -->
                    <input type="hidden" class="form-control" id="type_shipp" name="type_shipp" readonly>
                    <!-- Document Type -->
                    <input type="hidden" class="form-control" id="type_doc" name="type_doc" readonly>
                    <!-- Document Number -->
                    <input type="hidden" class="form-control" id="type_doc_number" name="type_doc_number" readonly>
                    <!-- Value -->
                    <input type="hidden" class="form-control" id="type_val" name="type_val" readonly>
                    <!-- Type Commercial -->
                    <input type="hidden" class="form-control" id="type_comm" name="type_comm" readonly>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess">Save Change</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Cancel Booking Invoice -->
<div class="modal fade" id="modal-cancel-book">
    <form action="<?= base_url('arnag/cancel_booking_invoice'); ?>" method="POST">
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
                        <label for="id_inv" class="col-sm-5 col-form-label">Sure Cancel Book Invoice :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="txt_cancel_book" name="txt_cancel_book" style="border:none;" readonly>
                        </div>
                    </div>
                    <!-- Hidden Text -->
                    <input type="hidden" id="id_book_inv" name="id_book_inv" readonly>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary toastsDefaultDanger">Cancel Invoice</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Update Booking Invoice -->
<div class="modal fade" id="modal-update">
    <form action="<?= base_url('arnag/update_booking_invoice'); ?>" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Update</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Update Document Number dan type -->
                    <input type="hidden" name="id_book_inv" id="id_book_inv" required readonly>
                    <div class="form-group col-md-12">
                        <label>Invoice Number</label>
                        <input type="text" class="form-control" id="no_inv" name="no_inv" readonly>
                    </div>

                    <div class="form-group col-md-12">
                    <label>Document Type</label>
                     <select id="docum_type" name="docum_type" class="form-control" required>
                    <option value="" disabled selected="true">Choose options</option>  
                    <option value="PEB">PEB</option>  
                    <option value="BC 4.1">BC 4.1</option>                      
                    <option value="BC 25">BC 25</option>  
                    <option value="BC 27">BC 27</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Document Number</label>
                        <input type="text" class="form-control" id="doc_number_mdl" name="doc_number_mdl">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" min="0" autocomplete="off">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Type</label>
                        <select id="type_mdl" name="type_mdl" class="form-control" required>
                            <?php foreach ($type as $t) : ?>
                                <option value="<?= $t['id_type']; ?>"><?= $t['type']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
    function cari_noinvoice() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_noinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-booking-invoice");
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


