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
                <div class="col-md-6">
                    <!-- Form Element sizes -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Invoice</h3>
                        </div>
                        <div class="card-body">
                            <!-- Start Input -->
                            <div class="form-group col-md-12">
                                <label>Invoice Number</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="inv_number1" name="inv_number1" readonly required>
                                    <input type="hidden" class="form-control float-right" id="profit_ctr_h" name="profit_ctr_h" readonly>
                                    <span class="input-group-append">
                                        <button id="inv_number2" name="inv_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-no-booking-invoice" onclick="clear_component()">Add Book Inv</button>
                                    </span>
                                </div>
                            </div>
                            <!-- Hidden Element -->
                            <div class="form-group col-md-12">
                                <!-- ID Invoice -->
                                <input type="hidden" class="form-control" id="id_inv" name="id_inv" readonly required>
                            </div>
                            <div class="form-group col-md-12">
                                <!-- ID Customer -->
                                <input type="hidden" class="form-control" id="id_cust" name="id_cust" readonly required>
                            </div>
                            <div class="form-group col-md-12">
                                <!-- ID TOP -->
                                <input type="hidden" class="form-control" id="id_top" name="id_top" readonly required>
                            </div>
                            <!-- /. Hidden Element -->
                            <div class="form-group col-md-12">
                                <label>Customer</label>
                                <input type="text" class="form-control" id="cust" name="cust" readonly required>
                                <input type="hidden" class="form-control" id="grade" name="grade" readonly>
                                <input type="hidden" class="form-control" id="inv_date" name="inv_date" readonly>
                                <input type="hidden" class="form-control" id="inv_curr" name="inv_curr" readonly>
                                <input type="hidden" class="form-control" id="no_coa_deb" name="no_coa_deb" readonly>
                                <input type="hidden" class="form-control" id="nama_coa_deb" name="nama_coa_deb" readonly>
                                <input type="hidden" class="form-control" id="no_coa_cre" name="no_coa_cre" readonly>
                                <input type="hidden" class="form-control" id="nama_coa_cre" name="nama_coa_cre" readonly>
                                <input type="hidden" class="form-control" id="no_coa_dp" name="no_coa_dp" readonly>
                                <input type="hidden" class="form-control" id="nama_coa_dp" name="nama_coa_dp" readonly>
                                <input type="hidden" class="form-control" id="no_coa_pot" name="no_coa_pot" readonly>
                                <input type="hidden" class="form-control" id="nama_coa_pot" name="nama_coa_pot" readonly>
                                <input type="hidden" class="form-control" id="no_coa_ppn" name="no_coa_ppn" readonly>
                                <input type="hidden" class="form-control" id="nama_coa_ppn" name="nama_coa_ppn" readonly>
                                <input type="hidden" class="form-control" id="inv_rate" name="inv_rate" readonly>
                            </div>
                            <!-- TOP -->
                            <div class="row col-md-12">
                                <div class="form-group col-md-4">
                                    <label>TOP Type</label>
                                    <input type="text" class="form-control" id="top" name="top" readonly required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Time Period</label>
                                    <input type="text" class="form-control" id="top_time" name="top_time" readonly required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Action.</label>
                                    <button type="button" id="find_top" name="find_top" class="btn btn-info" data-toggle="modal" data-target="#modal-add-top"><i class="fa fa-search"></i> Search Top</button>
                                </div>
                            </div>
                            <!-- END TOP -->
                            <div class="form-group col-md-12">
                                <label>Shipp</label>
                                <input type="text" class="form-control" id="shipp" name="shipp" readonly required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Document Type</label>
                                <input type="text" class="form-control" id="doc_type" name="doc_type" readonly required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Document Number</label>
                                <input type="text" class="form-control" id="doc_number" name="doc_number" readonly required>
                            </div>
                            <!--  End Start Input -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!--/.col (right) -->
                <div class="col-md-6">
                    <!-- Form Element sizes -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">-</h3>
                        </div>
                        <div class="card-body">
                            <!-- Start Input -->
                            <div class="form-group col-md-12">
                                <label>Type</label>
                                <input type="text" class="form-control" id="type" name="type" readonly required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" readonly required>
                            </div>
                            <!-- BANK -->
                            <div class="form-group col-md-12">
                                <label>Bank</label>
                                <select class="form-control" id="id_bank" name="id_bank" required>
                                    <?php foreach ($isi_bank as $bk) : ?>
                                        <option value="<?= $bk['id']; ?>"><?= $bk['nama_bank']; ?> (<?= $bk['no_rek']; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!--  -->
                            <div class="form-group col-md-12">
                                <label>PPh</label>
                                <select class="form-control" id="pph" name="pph" required>
                                   <option value="NA">NA</option>
                                   <option value="PPh 21">PPh 21</option>
                                   <option value="PPh 23">PPh 23</option>
                                   <option value="4 Ayat 2">4 Ayat 2</option>								
                               </select>
                           </div>
                           <div class="form-group col-md-12">
                            <label>Type SO</label>
                            <select class="form-control" id="type_so" name="type_so" required>
                                <option value="FOB">FOB</option>
                                <option value="CMT">CMT</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>SO Number</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="so_number1" name="so_number1" readonly required>
                                <span class="input-group-append">
                                    <button id="so_number2" name="so_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-so" href="javascript:void(0)" onclick="add_id_for_so()">Add SO</button>
                                </span>
                            </div>
                        </div>
                        <!--  End Start Input -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!--/.col (right) -->
        </div>
        <!-- Data Table Create Invoice -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DataTable Detail SJ</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table id="table-sj" class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID Bppb</th>
                                    <th>SO Number</th>
                                    <th>Bppb Number</th>
                                    <th>Sj_Date</th>
                                    <th>Shipping Number</th>
                                    <th>WS#</th>
                                    <th>Styleno</th>
                                    <th>Product Group</th>
                                    <th>Product Item</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Curr</th>
                                    <th>UOM</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Discount (%)</th>
                                    <th>Total Price</th>
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
        <!--  -->
        <!-- Data Potongan Invoice  -->
        <div class="row" style="display: flex; justify-content: flex-end">
            <!--/.col (right) -->
            <div class="col-md-6">
                <!-- Form Element sizes -->
                <div class="card card-success">
                    <div class="card-body">
                        <!-- Start Input -->
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="total" class="col-sm-4 col-form-label">Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="total" name="total" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="discount" class="col-sm-4 col-form-label">Discount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="discount" name="discount" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dp" class="col-sm-4 col-form-label">Down Payment</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="dp" name="dp" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="return" class="col-sm-4 col-form-label">Return</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="return" name="return" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="twot" class="col-sm-4 col-form-label">Total With Out Tax</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="twot" name="twot" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="vat" class="col-sm-4 col-form-label">VAT</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="vat" name="vat" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="grandtotal" class="col-sm-4 col-form-label">Grand Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="grandtotal" name="grandtotal" style="text-align:right;" placeholder="0.00" readonly>
                                        <input type="hidden" class="form-control" id="keterangan" name="keterangan" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <!-- /.card-footer -->
                        </form>
                        <!--  End Start Input -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!--/.col (right) -->
        </div>
        <!-- End Data Potongan Invoice  -->
        <!--  -->
        <!-- Button Simpan Data Invoice  -->
        <div class="row col-sm-12">
            <div class="input-group mb-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="asyncCall()"><i class="fa fa-save"></i> Save Change Invoice</button>
            </div>
        </div>
        <!-- End Button Simpan Data Invoice  -->
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Add No Booking Invoice -->
<div class="modal fade" id="modal-add-no-booking-invoice">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Number Booking Invoice</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <p>One fine body&hellip;</p> -->
                <!-- Datatable Nomor Booking Invoice -->
                <div class="card">
                    <div class="card-header">
                        <!-- Date Range -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!-- <label>Date Range</label> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="reservation" name="reservation">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button type="button" id="find_inv" name="find_inv" class="btn btn-info" href="javascript:void(0)" onclick="cari_book_inv_knitting()"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                        <!-- End Date Range -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 400px;">
                        <div class="d-flex justify-content-between">
                         <div class="ml-auto">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_noinvoice()">
                    </div>
                    <table id="table-add-bookinvoice" class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 10px">Action</th>
                                <th>Invoice Number</th>
                                <th>Customer</th>
                                <th>Shipp</th>
                                <th>Document Type</th>
                                <th>Document Number</th>
                                <th>Tanggal</th>
                                <th>Type</th>   
                                <th>Status</th>
                                <th>ID Cust</th>
                                <th>ID Inv</th>
                                <th>Amount</th>
                                <th>Profit Center</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- End Datatable Nomor Booking Invoice  -->
        </div>
        <div class="modal-footer right-content-between">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<!-- Modal Add TOP -->
<div class="modal fade" id="modal-add-top">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add TOP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="col-md-12">
                    <!-- Form Element sizes -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Table TOP</h3>
                        </div>
                        <div class="card-body">
                            <table id="tbl_top" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 35px">Action</th>
                                        <th>Customer</th>
                                        <th>Type</th>
                                        <th style="width: 40px">Top</th>
                                        <th>Status</th>
                                        <th>ID</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>
            <!-- End Modal Body -->
            <div class="modal-footer right-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Add SO And SJ -->
<div class="modal fade" id="modal-add-so">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">Add Number SO</h4>
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
                                <label>Nama Cust Book Invoice</label>
                                <input type="text" class="form-control float-right" id="custm" name="custm" readonly>
                                <input type="hidden" class="form-control float-right" id="profit_ctr" name="profit_ctr" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Buyer</label>
                                <select  class="form-control select2bs4" id="buyer" name="buyer" required>
                                    <?php foreach ($buyer as $byr) : ?>
                                        <option value="<?= $byr['Id_Supplier']; ?>"><?= $byr['Supplier']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>                    
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal SO</label>
                                    <!-- <label>Date Range</label> -->
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="reservation2" name="reservation2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="find_so" name="find_so" class="btn btn-info" href="javascript:void(0)" onclick="cari_so_knitting()"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="hidden"  class="form-control float-right" id="id_custm" name="id_custm" readonly>
                        </div>
                        <!-- End Date Range -->
                    </div>
                    <!-- /.card-header -->
                    <!-- Detail SO -->
                    <div class="d-flex justify-content-between">
                     <div class="ml-auto">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text"  id="cariso" name="cariso" required autocomplete="off" placeholder="Search SO number.." onkeyup="cariso()">
                </div>

                <div class="card-body">
                    <table id="example4" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">Cek</th>
                                <th>SO Number</th>
                                <th>SO Date</th>
                                <th>Customer</th>
                                <th>Buyer Number</th>
                                <th>SO Type</th>
                                <th>ID Sj</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- Detail SJ -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">DataTable Detail SJ</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="d-flex justify-content-between">
                         <div class="ml-auto">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text"  id="cari_shipp" name="cari_shipp" required autocomplete="off" placeholder="Search shipp number..." onkeyup="cari_shipp_num()">
                    </div>
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table id="table-sj-2" name="table-sj-2" class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>Bppb ID</th>
                                    <th>SO Number</th>
                                    <th>Bppb Number</th>
                                    <th>SJ Date</th>
                                    <th>Shipping Number</th>
                                    <th>WS#</th>
                                    <th>Styleno</th>
                                    <th>Produk Group</th>
                                    <th>Produk Item</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Curr</th>
                                    <th>UOM</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>UOM Shipment</th>
                                    <th>Qty Shipment</th>
                                    <th>Price Shipment</th>
                                    <th>Total Shipment</th>
                                    <th>Discount (%)</th>
                                    <th>Cek</th>
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
        <div class="row" >
            <div class="col-md-6">
                <!-- Form Element sizes -->
                <div class="card card-primary">
                    <div class="card-header">
                            <h3 class="card-title">Total</h3>
                        </div>
                    <div class="card-body">
                        <!-- Start Input -->
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="mdl_total" class="col-sm-4 col-form-label">Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_total_so" name="mdl_total_so" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_discount" class="col-sm-4 col-form-label">Discount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_discount_so" name="mdl_discount_so" style="text-align:right;" placeholder="0.00" readonly>
                                        <input type="hidden" class="form-control" id="grade_nya_so" name="grade_nya_so" readonly>
                                        <input type="hidden" class="form-control" id="tanggal_nya_so" name="tanggal_nya_so" readonly>
                                        <input type="hidden" class="form-control" id="curr_nya_so" name="curr_nya_so" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_dp" class="col-sm-4 col-form-label">Down Payment</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_dp_so" name="mdl_dp_so" style="text-align:right;" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="modal_input_dp_so(value)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_dpcbd" class="col-sm-4 col-form-label">DP/CBD from Invoice</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_dpcbd_so" name="mdl_dpcbd_so" style="text-align:right;" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="modal_input_dpcbd_so(value)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_return" class="col-sm-4 col-form-label">Return</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_return_so" name="mdl_return_so" style="text-align:right;" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="modal_input_retur_so(value)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_twot" class="col-sm-4 col-form-label">Total With Out Tax</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_twot_so" name="mdl_twot_so" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="custom-control custom-checkbox col-sm-2">
                                        <input class="custom-control-input" type="checkbox" id="check_vat_baru_so" name="check_vat_baru_so" onclick="modal_input_vat_baru_so()">
                                        <label for="check_vat_baru" class="custom-control-label">Vat 11%</label>
                                    </div>
                                    <div class="custom-control custom-checkbox col-sm-2">
                                        <input class="custom-control-input" type="checkbox" id="check_vat_so" name="check_vat_so" onclick="modal_input_vat_so()">
                                        <label for="check_vat" class="custom-control-label">Vat 12%</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_vat_so" name="mdl_vat_so" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_grandtotal" class="col-sm-4 col-form-label">Grand Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_grandtotal_so" name="mdl_grandtotal_so" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <!-- /.card-footer -->
                        </form>
                        <!--  End Start Input -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>


            <div class="col-md-6">
                <!-- Form Element sizes -->
                <div class="card card-success">
                    <div class="card-header">
                            <h3 class="card-title">Total Shipment</h3>
                        </div>
                    <div class="card-body">
                        <!-- Start Input -->
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="mdl_total" class="col-sm-4 col-form-label">Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_total" name="mdl_total" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_discount" class="col-sm-4 col-form-label">Discount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_discount" name="mdl_discount" style="text-align:right;" placeholder="0.00" readonly>
                                        <input type="hidden" class="form-control" id="grade_nya" name="grade_nya" readonly>
                                        <input type="hidden" class="form-control" id="tanggal_nya" name="tanggal_nya" readonly>
                                        <input type="hidden" class="form-control" id="curr_nya" name="curr_nya" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_dp" class="col-sm-4 col-form-label">Down Payment</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_dp" name="mdl_dp" style="text-align:right;" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="modal_input_dp(value)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_dpcbd" class="col-sm-4 col-form-label">DP/CBD from Invoice</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_dpcbd" name="mdl_dpcbd" style="text-align:right;" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="modal_input_dpcbd(value)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_return" class="col-sm-4 col-form-label">Return</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_return" name="mdl_return" style="text-align:right;" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="modal_input_retur(value)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_twot" class="col-sm-4 col-form-label">Total With Out Tax</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_twot" name="mdl_twot" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="custom-control custom-checkbox col-sm-2">
                                        <input class="custom-control-input" type="checkbox" id="check_vat_baru" name="check_vat_baru" onclick="modal_input_vat_baru()">
                                        <label for="check_vat_baru" class="custom-control-label">Vat 11%</label>
                                    </div>
                                    <div class="custom-control custom-checkbox col-sm-2">
                                        <input class="custom-control-input" type="checkbox" id="check_vat" name="check_vat" onclick="modal_input_vat()">
                                        <label for="check_vat" class="custom-control-label">Vat 12%</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_vat" name="mdl_vat" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mdl_grandtotal" class="col-sm-4 col-form-label">Grand Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mdl_grandtotal" name="mdl_grandtotal" style="text-align:right;" placeholder="0.00" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <!-- /.card-footer -->
                        </form>
                        <!--  End Start Input -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!--  -->
        </div>
        <!--  -->
    </div>
    <div class="modal-footer right-content-between">
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Add</button> -->
        <button type="button" id="btn_add_data_so" name="btn_add_data_so" class="btn btn-primary" href="javascript:void(0)" onclick="duplicate_data_so()">Add Data</button>
    </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<!-- ubah desember -->
<!-- Modal Simpan Invoice Status POST -->
<div class="modal fade" id="modal-simpan-invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Post Invoice</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- No Invoice -->
                <div class="form-group row">
                    <label for="id_inv" class="col-sm-5 col-form-label">Save Invoice Number :</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="no_inv_post" name="no_inv_post" style="border:none;" readonly>
                    </div>
                </div>
                <!-- ID Invoice, Pph -->
                <input type="hidden" class="form-control" id="id_inv_post" name="id_inv_post" readonly>
                <input type="hidden" class="form-control" id="pph_post" name="pph_post" readonly>
                <input type="hidden" class="form-control" id="txt_shipp" name="txt_shipp" readonly>
                <input type="hidden" class="form-control" id="txt_type_so" name="txt_type_so" readonly>
                <input type="hidden" class="form-control" id="txt_type" name="txt_type" readonly>
                <input type="hidden" class="form-control" id="txt_cust_ctg" name="txt_cust_ctg" readonly>
                <input type="hidden" class="form-control" id="txt_grade" name="txt_grade" readonly>
                <input type="hidden" class="form-control" id="txt_inv_date" name="txt_inv_date" readonly>
                <input type="hidden" class="form-control" id="txt_vat" name="txt_vat" readonly>
                <input type="hidden" class="form-control" id="txt_pot" name="txt_pot" readonly>
                <input type="hidden" class="form-control" id="txt_curr" name="txt_curr" readonly>
                <input type="hidden" class="form-control" id="txt_mdl_pc" name="txt_mdl_pc" readonly>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary toastrDefaultSuccess" onclick="save_invoice()">Save Change</button>
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