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

            <!-- Data Table Booking Invoice -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Data Master</h3>
                                </div>
                                <form>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label>Status</label>
                                                <select class="form-control select2bs4" id="status" name="status">
                                                    <option value="ALL">ALL</option>
                                                    <option value="Y">ACTIVE</option>
                                                    <option value="N">NON-ACTIVE</option>
                                                </select>
                                            </div>                                          
                                            <div class="form-group">
                                                <label>Action</label>
                                                <div class="input-group d-flex gap-2">
                                                    <button type="button" id="find_invoice" name="find_invoice" class="btn btn-info mr-2" onclick="cari_list_other_charges()">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                    <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#modalOtherCharges">
                                                        <i class="fa fa-plus"></i> Create
                                                    </button>

                                                    <button type="button" class="btn btn-primary mr-2" onclick="export_list_other_charge()">
                                                        <i class="fas fa-file-excel"></i> Export Excel
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

                    <!-- Data Table Booking Invoice -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">DataTable Master</h3>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between">
                                     <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search Data.." onkeyup="cari_noinvoice()">
                                </div>


                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                    <table id="table-other-charges" class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Status</th>
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

<div class="modal fade" id="modalOtherCharges" tabindex="-1" role="dialog" aria-labelledby="modalOtherChargesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalOtherChargesLabel">Tambah Other Charges</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
      <div class="form-group">
        <label for="nama_biaya">Nama Biaya</label>
        <input type="text" class="form-control" id="nama_biaya" name="nama_biaya" required>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" onclick="simpanOtherCharges()">Simpan</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
</div>
</div>
</div>
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
                    <input type="hidden" class="form-control" id="mdl_pc" name="mdl_pc" readonly>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Update Booking Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Update Document Number dan type -->
                    <input type="hidden" name="id_book_inv" id="id_book_inv" required readonly>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Invoice Number</label>
                            <input type="text" class="form-control" id="no_inv" name="no_inv" readonly>
                            <input type="hidden" class="form-control" id="no_inv_hide" name="no_inv_hide" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Customer</label>
                            <select id="cust_mdl" name="cust_mdl" class="form-control select2bs4" required>
                                <?php foreach ($customer as $csm) : ?>
                                    <option value="<?= $csm['Id_Supplier']; ?>"><?= $csm['Supplier']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Profit Center</label>
                            <select id="pc_mdl" name="pc_mdl" class="form-control select2bs4" required>
                                <?php foreach ($profit_center as $pc) : ?>
                                    <option value="<?= $pc['kode_pc']; ?>"><?= $pc['nama_pc']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Shipp</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="shipp_mdl" name="shipp_mdl" readonly required>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-success btn-flat" onclick="changeShipp_Invoice('L')"><i class="fa fa-car"></i> Local</button>
                                    <button type="button" class="btn btn-info btn-flat" onclick="changeShipp_Invoice('E')"><i class="fa fa-plane"></i> Export</button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Document Type</label>
                            <select id="docum_type" name="docum_type" class="form-control select2bs4" required>
                                <option value="" disabled selected="true">Choose options</option>  
                                <option value="PEB">PEB</option>  
                                <option value="BC 4.1">BC 4.1</option>                      
                                <option value="BC 25">BC 25</option>  
                                <option value="BC 27">BC 27</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Document Number</label>
                            <input type="text" class="form-control" id="doc_number_mdl" name="doc_number_mdl">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" min="0" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Type</label>
                            <select id="type_mdl" name="type_mdl" class="form-control select2bs4" required>
                                <?php foreach ($type as $t) : ?>
                                    <option value="<?= $t['id_type']; ?>"><?= $t['type']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="handleUpdate_BookInvoice()">Update</button>
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
        table = document.getElementById("table-other-charges");
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



