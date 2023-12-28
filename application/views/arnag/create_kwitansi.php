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
                <div class="col-md-7">
                    <!-- Form Element sizes -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Invoice</h3>
                        </div>
                        <div class="card-body">
                            <!-- Start Input -->
                            <div class="form-group col-md-12">
                                <label>Kwitansi Number</label>
                                <div class="input-group mb-3">
                                   <input type="text" class="form-control" id="kwt_number" name="kwt_number" value="<?= $kode_kwt; ?>" required readonly>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                            <label>Kwitansi Date</label>
                                             <div class="input-group mb-3">
                                            <input type="text" name="kwt_date" id="kwt_date" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" onchange="ubahnomor_kwt(this.value)" autocomplete='off'>
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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

                            <div class="form-group col-md-12">
                                            <label>Customer</label>
                                        <select class="form-control select2bs4" id="customer" name="customer">
                                  <!--           <option value="all_customer">All Customer</option> -->
                                            <?php foreach ($customer as $cs) : ?>
                                                <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        </div>

                            <!-- /. Hidden Element -->
                      <!--       <div class="form-group col-md-12">
                                <label>Customer</label>
                                <input type="text" class="form-control" id="cust" name="cust" readonly required>
                            </div> -->
                            <!-- TOP -->
                         <!--    <div class="row col-md-12">
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
                            </div> -->
                            <!-- END TOP -->
                          <!--   <div class="form-group col-md-12">
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
                            </div> -->
                            <!--  End Start Input -->
                            <div class="form-group col-md-12">
                                <label>Invoice Number</label>
                                <div class="input-group mb-3">
                                  <!--   <input type="text" class="form-control" id="so_number1" name="so_number1" readonly required> -->
                                    <span class="input-group-append">
                                        <button id="so_number2" name="so_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-so" href="javascript:void(0)" onclick="add_id_for_kwt()">Add Invoice number</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!--/.col (right) -->
                <div class="col-md-6">
                    <!-- Form Element sizes -->
               <!--      <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">-</h3>
                        </div> -->
                        <div class="card-body">
                            <!-- Start Input -->
                           <!--  <div class="form-group col-md-12">
                                <label>Type</label>
                                <input type="text" class="form-control" id="type" name="type" readonly required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" readonly required>
                            </div> -->
                            <!-- BANK -->
                          <!--   <div class="form-group col-md-12">
                                <label>Bank</label>
                                <select class="form-control" id="id_bank" name="id_bank" required>
                                    <?php foreach ($isi_bank as $bk) : ?>
                                        <option value="<?= $bk['id']; ?>"><?= $bk['nama_bank']; ?> (<?= $bk['no_rek']; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div> -->
                            <!--  -->
                      <!--       <div class="form-group col-md-12">
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
                                        <button id="so_number2" name="so_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-so" href="javascript:void(0)" onclick="add_id_for_kwt()">Add SO</button>
                                    </span>
                                </div>
                            </div>
 -->                            <!--  End Start Input -->
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
                            <h3 class="card-title">Untuk Pembayaran</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table id="tabelkwt" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No Invoice</th>
                                        <th>Invoice Date</th>
                                        <th>Customer</th>
                                        <th>Shipp</th>
                                        <th>Doc Type</th>
                                        <th>Doc Number</th>
                                        <th>Type</th>
                                        <th style="text-align: center;">Style</th>
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
                <div class="col-md-7">
                    <!-- Form Element sizes -->
                    <div class="card card-success">
                        <div class="card-body">
                            <!-- Start Input -->
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="total" class="col-sm-2 col-form-label">Total</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" class="form-control" id="total" name="total" style="text-align:right;" placeholder="0.00" readonly>
                                            <input type="text" class="form-control" id="total1" name="total1" style="text-align:right;" placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="discount" class="col-sm-2 col-form-label">Terbilang</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="terbilang" name="terbilang" style="text-align:right;" placeholder="-" readonly >
                                        </div>
                                    </div>
                                
                                    <!-- <div class="form-group row">
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
                                        </div>
                                    </div> -->
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="add_data_kwitansi()"><i class="fa fa-save"></i> Save Kwitansi</button>
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
                                <button type="button" id="find_inv" name="find_inv" class="btn btn-info" href="javascript:void(0)" onclick="cari_book_inv()"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                        <!-- End Date Range -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 400px;">
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
            <div class="modal-header">
                <h4 class="modal-title">Add Invoice</h4>
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
                                <label>Id Customer</label>
                                <input type="text" class="form-control float-right" id="custmr" name="custmr" readonly>
                            </div>
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                            </br>
                                <button type="button" id="find_so" name="find_so" class="btn btn-info" href="javascript:void(0)" onclick="cari_data_inv()"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="hidden" class="form-control float-right" id="id_custm" name="id_custm" readonly>
                        </div>
                        <!-- End Date Range -->
                    </div>
                    <!-- /.card-header -->
                    <!-- Detail SO -->
                       <!--  <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cariso" name="cariso" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cariso()">
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
                    </div> -->
                    <!-- /.card-body -->
                </div>
                <!-- Detail SJ -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Invoice</h3>
                            </div>
                            <!-- /.card-header -->
                                <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cariinvo" name="cariinvo" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cariinvo()">
                             </div>
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table id="table-inv-kwt" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No Invoice</th>
                                        <th>Invoice Date</th>
                                        <th>Customer</th>
                                        <th>Shipp</th>
                                        <th>Doc Type</th>
                                        <th>Doc Number</th>
                                        <th>Type</th>
                                        <th>Amount</th>
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
                <div class="row" style="display: flex; justify-content: flex-end">
                    <div class="col-md-6">
                        <!-- Form Element sizes -->
                        <div class="card card-success">
                            <div class="card-body">
                                <!-- Start Input -->
                                <form class="form-horizontal">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="mdl_total" class="col-sm-4 col-form-label">Total</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" class="form-control" id="val_kwt" name="val_kwt" style="text-align:right;" placeholder="0.00">
                                                <input type="text" class="form-control" id="val_kwt1" name="val_kwt1" style="text-align:right;" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label for="mdl_discount" class="col-sm-4 col-form-label">Discount</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_discount" name="mdl_discount" style="text-align:right;" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mdl_dp" class="col-sm-4 col-form-label">Down Payment</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_dp" name="mdl_dp" style="text-align:right;" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="modal_input_dp(value)" autocomplete="off">
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
                                            <div class="custom-control custom-checkbox col-sm-4">
                                                <input class="custom-control-input" type="checkbox" id="check_vat" name="check_vat" onclick="modal_input_vat()">
                                                <label for="check_vat" class="custom-control-label">Vat 10%</label>
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
                                        </div> -->
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
                <button type="button" id="btn_add_data_so" name="btn_add_data_so" class="btn btn-primary" href="javascript:void(0)" onclick="duplicate_data_kwt()">Add Data</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Simpan Invoice Status POST -->
<div class="modal fade" id="modal-simpan-kwt">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Save Kwitansi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- No Invoice -->
                <div class="form-group row">
                    <label for="id_inv" class="col-sm-5 col-form-label">Save Kwitansi Number :</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="kwt_no" name="kwt_no" style="border:none;" readonly>
                    </div>
                </div>
                <!-- ID Invoice, Pph -->
                <input type="hidden" class="form-control" id="id_inv_post" name="id_inv_post" readonly>
                <input type="hidden" class="form-control" id="pph_post" name="pph_post" readonly>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary toastrDefaultSuccess" onclick="save_kwitansi()">Save</button>
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
    function cariinvo() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cariinvo");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-inv-kwt");
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

<script >
        function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }
 
    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }           
        return $hasil;
    }
</script>