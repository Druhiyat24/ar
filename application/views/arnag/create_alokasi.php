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
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Form Alokasi</h3>
                        </div>
                        <div class="card-body">
                            <!-- Start Input -->
                            <div class="form-group col-md-12">
                                <label>Alokasi Number</label>
                                <input type="text" class="form-control" id="alk_number" name="alk_number" value="<?= $kode_alokasi; ?>" required readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="alo_date" id="alo_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" onchange="ubahnomor_alo(this.value)" autocomplete='off' readonly>
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
                            <!-- /. Hidden Element -->
                            <div class="form-group col-md-12">
                                <label>Customer</label>
                                <input type="text" class="form-control" id="cust" name="cust" readonly required>
                                <input type="hidden" class="form-control" id="customer" name="customer" readonly required>
                            </div>
                            <!-- TOP -->

                            <!-- END TOP -->
                            <div class="form-group col-md-12">
                                <label>Doc Number</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="doc_number" name="doc_number" readonly required>
                                    <span class="input-group-append">
                                        <button id="inv_number2" name="inv_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-no-bi">Add Incoming Bank</button>
                                        <!--                                         onclick="clear_component()" -->
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Bank</label>
                                <input type="hidden" class="form-control" id="id_bank" name="id_bank" autocomplete='off' required readonly>
                                <input type="text" class="form-control" id="bank" name="bank" autocomplete='off' required readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Account</label>
                                <input type="text" class="form-control" id="acc" name="acc" autocomplete='off' required readonly>
                            </div>
                            <!--  End Start Input -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!--/.col (right) -->
                <div class="col-md-6">
                    <!-- Form Element sizes -->
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">-</h3>
                        </div>
                        <div class="card-body">
                            <!-- Start Input -->
                            <div class="form-group col-md-12">
                               <label>Currency</label>
                               <div class="input-group mb-3">
                                     <!-- <span class="input-group-append">
                                         <button id="cr_idr" name="cr_idr" type="button" class="btn btn-success btn-flat" ><i class="fa fa-money" aria-hidden="true"></i> Rp</button>
                                         <button id="cr_usd" name="cr_usd" type="button" class="btn btn-info btn-flat" ><i class="fa fa-usd" aria-hidden="true"></i> $ </button>
                                     </span> -->
                                     <input type="text" class="form-control" id="currn" name="currn" required autocomplete="off" readonly>
                                 </div>
                             </div>

                             <div class="form-group col-md-12">
                                <label>Payment With</label>
                                <!--  <select class="form-control select2bs4" id="pay_type" name="pay_type" onchange="gantitype(this.value)"> -->
                                    <select class="form-control select2bs4" id="pay_type" name="pay_type" >
                                        <option value="IDR">IDR</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Rate</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="rate" name="rate" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="input_rate(value)" autocomplete="off" readonly>
                                        <input type="text" class="form-control" id="pl_rate" name="pl_rate" placeholder="0.00" autocomplete='off' readonly>
                                    </div>
                                    <input type="hidden" class="form-control" id="rate_h" name="rate_h" placeholder="0.00" autocomplete='off' required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Amount</label>
                                    <div class="input-group mb-3">
                                        <input type="hidden" class="form-control" id="am_awal" name="am_awal" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="input_awal(value)" autocomplete="off">
                                        <input type="text" class="form-control" id="pl_awal" name="pl_awal" placeholder="0.00" autocomplete='off' readonly>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Equivalent IDR</label>
                                    <input type="text" class="form-control" id="am_akhir" name="am_akhir" placeholder="0.00" readonly autocomplete='off' required>
                                    <input type="hidden" class="form-control" id="pl_akhir" name="pl_akhir" placeholder="0.00" autocomplete='off' required>
                                </div>
                                <!-- BANK -->
                                <div class="form-group col-md-12">
                                    <label>Add Data</label>
                                    <div class="input-group mb-3">
                                      <!--   <input type="text" class="form-control" id="so_number1" name="so_number1" readonly required> -->
                                      <span class="input-group-append">
                                        <button id="so_number2" name="so_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-so" href="javascript:void(0)" onclick="add_id_()">Add Data</button>
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
                            <h3 class="card-title">Detail</h3>
                        </div>
                        <div class="input-group-append col">
                            <input  style="margin-right: 15px;border: 0; line-height: 1; padding: 10px 20px; font-size: 1rem; text-align: center; color: #fff; text-shadow: 1px 1px 1px #000; border-radius: 6px; background-color: rgb(30, 144, 255);" id="add" type="button" value="(+) Add"> 

                            <input style="border: 0; line-height: 1; padding: 10px 20px; font-size: 1rem; text-align: center; color: #fff; text-shadow: 1px 1px 1px #000; border-radius: 6px; background-color: rgb(139, 5, 0);" id="delete" type="button" value="(-) Delete">
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table id="table-sj" class="table table-head-fixed text-nowrap table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>COA</th>
                                        <th>Cost Center</th>
                                        <th>Reference Number</th>
                                        <th>Date</th>
                                        <th>Due Date</th>
                                        <th>Total</th>
                                        <th>Equivalent IDR</th>
                                        <th>Amount</th>
                                        <th>descriptions</th>
                                        <th>Profit Center</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <!-- <tr> 
                                            <td ><select class="form-control select2bs4" name="coa" id="coa" style="width: 300px"> <option value="-" > - </option> <?php foreach ($coa as $coa) : ?> <option value="<?= $coa["id_coa"]; ?>"><?= $coa["id_coa"]; ?> <?= $coa["coa_name"]; ?> </option><?php endforeach; ?> </select></td> 
                                            <td><select class="form-control select2bs4" name="cost" id="cost" style="width: 250px" onkeyup="pilih()"> <option value="-" > - </option> <?php foreach ($cost_center as $cc) : ?> <option value="<?= $cc["id"]; ?>" ><?= $cc["cost_name"]; ?> </option><?php endforeach; ?> </select></td> 
                                            <td><input  type="text" class="form-control" id="ref_number" name="ref_number" style="text-align:left; width: 180px;"></td> 
                                            <td><input  type="text" class="form-control" id="ref_date" name="ref_date" value="<?php echo date("Y-m-d"); ?>" style="text-align:left; width: 150px;" ></td> 
                                            <td><input  type="text" class="form-control" id="due_date" name="due_date" value="<?php echo date("Y-m-d"); ?>" style="text-align:left; width: 150px;" ></td> 
                                            <td><input  type="text" class="form-control" id="total" name="total" style="text-align:left; width: 150px;" ></td> 
                                            <td><input  type="text" class="form-control" id="discount" name="discount" style="text-align:left; width: 150px;" ></td> 
                                            <td><input  type="text" class="form-control" id="discount" name="discount" style="text-align:left; width: 150px;" ></td> 
                                            <td><input  type="text" class="form-control" id="discount" name="discount" style="text-align:left; width: 250px;" ></td> 
                                        </tr> -->
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
                                            <label for="total_h" class="col-sm-4 col-form-label">Outstanding Amount Alokasi</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="out_alok" name="out_alok" style="text-align:right;" placeholder="0.00" autocomplete="off" readonly>
                                                <input type="hidden" class="form-control" id="out_alok_h" name="out_alok_h" style="text-align:right;" placeholder="0.00">

                                                <input type="hidden" class="form-control" id="total_alokasi" name="total_alokasi" style="text-align:right;" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    <!-- <div class="form-group row">
                                        <label for="discount" class="col-sm-4 col-form-label">Discount</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="diskon" name="diskon" style="text-align:right;" placeholder="0.00" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dp" class="col-sm-4 col-form-label">Down Payment</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="dp" name="dp" style="text-align:right;" placeholder="0.00" onkeypress="javascript:return isNumber(event)" oninput="modal_inputdp(value)" autocomplete="off">
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
            <!--  -->
            <!-- End Data Potongan Invoice  -->
            <!--  -->
            <!-- Button Simpan Data Invoice  -->
            <div class="row col-sm-12">
                <div class="input-group mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="simpan_data_alokasi()"><i class="fa fa-save"></i> Save </button>
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
<div class="modal fade" id="modal-add-no-bi">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Number Incoming Bank</h4>
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
                                <button type="button" id="find_inv" name="find_inv" class="btn btn-info" href="javascript:void(0)" onclick="cari_bi()"><i class="fa fa-search"></i> Search</button>
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
                        <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search No Incoming Bank.." onkeyup="cari_noinvoice()">
                    </div>
                    <table id="table-add-bi" class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 10px">Action</th>
                                <th>No incoming Bank</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>id_bank</th>
                                <th>Bank</th>
                                <th>Account</th>
                                <th>Currency</th>
                                <th>Amount</th>
                                <th>Rate</th>
                                <th>Equivalent IDR</th>
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
                                <input type="hidden" class="form-control float-right" id="custmr" name="custmr" readonly>
                                <input type="text" class="form-control float-right" id="nama_custmr" name="nama_custmr" readonly>
                                <input type="hidden" class="form-control float-right" id="rates" name="rates" readonly>
                                <input type="hidden" class="form-control float-right" id="pwith" name="pwith" readonly>
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
                            <!-- <div class="col-md-3">
                                <label>Reference</label>
                                <select class="form-control" id="pph" name="pph" required>
                                    <option value="inv">Invoice</option>
                                    <option value="rtn">Return</option>
                                    <option value="PPh 23">dsb..</option>
                                </select>
                            </div> -->
                            <div class="col-md-4 mt-2">

                            </br>
                            <button type="button" id="find_so" name="find_so" class="btn btn-info" href="javascript:void(0)" onclick="cari_data_invoic()"><i class="fa fa-search"></i> Search</button>
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
      <!--           <div class="card">
                <div class="form-group col-md-4">
                                <label>Alokasi Amount</label>
                                <div class="input-group mb-3">
                                <input type="text" class="form-control" id="pl_awal" name="pl_awal" placeholder="0.00" autocomplete='off' readonly>
                            </div>
                            </div>
                        </div> -->
                        <!-- Detail SJ -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Data</h3>
                                    </div>
                                    <!-- /.card-header -->
                           <!--      <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cariinvo" name="cariinvo" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cariinvo()">
                            </div> -->

                            <div class="d-flex justify-content-between">
                             <div class="ml-auto">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text"  id="carinoinv" name="carinoinv" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_inv_alok()">
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table id="table-inv-alok" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Reference Number</th>
                                        <th>Date</th>
                                        <th>Due Date</th>
                                        <th>Currency</th>
                                        <th>Total</th>
                                        <th>Equivalent IDR</th>
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
                                        <label for="mdl_total" class="col-sm-4 col-form-label">Amount Alokasi</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" class="form-control" id="val_alo" name="val_alo" style="text-align:right;" placeholder="0.00">
                                            <input type="text" class="form-control" id="val_alo1" name="val_alo1" style="text-align:right;" placeholder="0.00" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="mdl_total" class="col-sm-4 col-form-label">Outstanding Amount</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ost_alo" name="ost_alo" style="text-align:right;" placeholder="0.00" readonly>
                                            <!-- <input type="text" class="form-control" id="val_alo1" name="val_alo1" style="text-align:right;" placeholder="0.00" readonly> -->
                                        </div>
                                    </div>

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
            </div>
            <div class="modal-footer right-content-between">
                <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Add</button> -->
                <button type="button" id="btn_add_data_so" name="btn_add_data_so" class="btn btn-primary" href="javascript:void(0)" onclick="duplicate_data_alo()">Add Data</button>
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