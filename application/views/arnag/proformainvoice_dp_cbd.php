 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1><?= $title; ?></h1>
                 </div>
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#">Main Menu</a></li>
                         <li class="breadcrumb-item active">Proforma Invoice</li>
                     </ol>
                 </div>
             </div>
         </div><!-- /.container-fluid -->
     </section>

     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="card card-default">
                 <div class="card-header">
                     <h3 class="card-title"></h3>
                     <div class="card-tools">
                         <button type="button" class="btn btn-tool" data-card-widget="collapse">
                             <i class="fas fa-minus"></i>
                         </button>
                         <button type="button" class="btn btn-tool" data-card-widget="remove">
                             <i class="fas fa-times"></i>
                         </button>
                     </div>
                 </div>
                 <!-- /.card-header -->
                 <div class="card-body">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Proforma Invoice</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="prof_inv_number" name="prof_inv_number" value="<?= $kode_proforma_invoice; ?>" readonly required>
                                 </div>
                             </div>
                             <!-- /.form-group -->
                             <div class="form-group">
                                 <label>Customer</label>
                                 <select class="form-control select2bs4" id="prof_customer" name="prof_customer">
                                     <?php foreach ($customer as $cs) : ?>
                                         <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <!-- <div class="form-group">
                                 <label>Type PI</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="prof_type_pi" name="prof_type_pi" required autocomplete="off">
                                     <span class="input-group-append">
                                         <button id="prof_C" name="prof_C" type="button" class="btn btn-success btn-flat" onclick="get_kode_cbd('C')"> CBD</button>
                                         <button id="prof_D" name="prof_D" type="button" class="btn btn-info btn-flat" onclick="get_kode_cbd('D')"> DP</button>
                                     </span>
                                 </div>
                             </div> -->
                             <div class="form-group">
                                 <label>Shipp</label>
                                 <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="prof_type_pi" name="prof_type_pi" required autocomplete="off" readonly>
                                     <span class="input-group-append" style="padding-right: 10px">
                                         <button id="prof_C" name="prof_C" type="button" class="btn btn-success btn-flat" onclick="get_kode_cbd('C')"> CBD</button>
                                         <button id="prof_D" name="prof_D" type="button" class="btn btn-info btn-flat" onclick="get_kode_cbd('D')"> DP</button>
                                     </span>
                                     <input type="text" class="form-control" id="prof_shipp_cbd" name="prof_shipp_cbd" required autocomplete="off">
                                     <span class="input-group-append">
                                         <button id="prof_L_cbd" name="prof_L_cbd" type="button" class="btn btn-success btn-flat" onclick="get_kode_proforma_invoice_cbd('L')"><i class="fa fa-car"></i> Local</button>
                                         <button id="prof_E_cbd" name="prof_E_cbd" type="button" class="btn btn-info btn-flat" onclick="get_kode_proforma_invoice_cbd('E')"><i class="fa fa-plane"></i> Export</button>
                                     </span>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label>Material Type</label>
                                 <select id="prof_material_type" name="prof_material_type" class="form-control" required>
                                     <option value="Barang Jadi">Barang Jadi</option>
                                     <option value="Non Barang Jadi">Non Barang Jadi</option>
                                 </select>
                             </div>
                             <!-- BANK -->
                             <div class="form-group">
                                 <label>Bank</label>
                                 <select class="form-control" id="id_bank_prof" name="id_bank_prof" required>
                                     <?php foreach ($isi_bank as $bk) : ?>
                                         <option value="<?= $bk['id']; ?>"><?= $bk['nama_bank']; ?> (<?= $bk['no_rek']; ?>)</option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <!-- END BANK -->
                             <!-- /.form-group -->
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Peb</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="prof_peb" name="prof_peb" autocomplete="off">
                                     <input type="hidden" class="form-control" id="no_coa_deb4" name="no_coa_deb4" readonly>
                                     <input type="hidden" class="form-control" id="nama_coa_deb4" name="nama_coa_deb4" readonly>
                                     <input type="hidden" class="form-control" id="no_coa_ppn4" name="no_coa_ppn4" readonly>
                                     <input type="hidden" class="form-control" id="nama_coa_ppn4" name="nama_coa_ppn4" readonly>
                                 </div>
                             </div>
                             <!-- /.form-group -->
                             <div class="form-group">
                                 <label>Type</label>
                                 <select id="prof_type" name="prof_type" class="form-control" required>
                                     <?php foreach ($type as $t) : ?>
                                         <option value="<?= $t['id_type']; ?>"><?= $t['type']; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <!-- TOP -->
                             <div class="row">
                                 <div class="form-group col-md-4">
                                     <label>TOP Type</label>
                                     <input type="text" class="form-control" id="prof_top" name="prof_top" readonly required>
                                 </div>
                                 <div class="form-group col-md-4">
                                     <label>Time Period</label>
                                     <input type="text" class="form-control" id="prof_top_time" name="prof_top_time" readonly required>
                                 </div>
                                 <div class="form-group col-md-4">
                                     <label>Action.</label>
                                     <button type="button" id="prof_find_top" name="prof_find_top" class="btn btn-info" data-toggle="modal" data-target="#modal-add-prof-top"><i class="fa fa-search"></i> Search Top</button>
                                 </div>
                                 <div class="form-group">
                                     <!-- ID TOP -->
                                     <input type="hidden" class="form-control" id="prof_id_top" name="prof_id_top" readonly required>
                                 </div>
                             </div>
                             <!-- END TOP -->
                             <!--  -->
                             <!-- TYPE SO -->
                             <div class="form-group">
                                 <label>Type SO</label>
                                 <select class="form-control" id="type_so_prof" name="type_so_prof" required>
                                     <option value="FOB">FOB</option>
                                     <option value="CMT">CMT</option>
                                 </select>
                             </div>
                             <!-- END TYPE SO -->
                             <div class="form-group">
                                 <label>SO Number</label>
                                 <div class="input-group mb-3">
                                     <input type="hidden" class="form-control" id="prof_so_number1" name="prof_so_number1" readonly required>
                                     <span class="input-group-append">
                                         <button style="padding-right: 25px;padding-left: 25px;" id="prof_so_number2" name="prof_so_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-so-proforma" href="javascript:void(0)" onclick="add_id_for_proforma_inv()">Add SO</button>
                                     </span>
                                 </div>
                             </div>
                             <!-- /.form-group -->
                         </div>
                         <!-- /.col -->
                     </div>
                     <!-- /.row -->
                 </div>
                 <div class="card-header">
                    <h3 class="card-title">Data SO</h3>
                 </div>
                 <div class="card-body table-responsive p-0" style="height: 200px;">
                     <table id="table-proforma-invoice" class="table table-head-fixed text-nowrap">
                         <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>SO Number</th>
                                 <th>SO Date</th>
                                 <th>Buyer Number</th>
                                 <th>Curr</th>
                                 <th>Qty</th>
                                 <th>Unit Price</th>
                                 <th>Total Price</th>
                             </tr>
                         </thead>
                         <tbody>

                         </tbody>
                     </table>
                 </div>
                 <br>

                 <div class="card-header">
                    <h3 class="card-title">Data Detail SO</h3>
                 </div>
                 <div class="card-body table-responsive p-0" style="height: 300px;">
                     <table id="table-proforma-sodet" class="table table-head-fixed text-nowrap">
                         <thead>
                             <tr>
                                <th>ID</th>
                                <th>SO Number</th>
                                <th>Product</th>
                                <th>Curr</th>
                                <th>QTY</th>
                                <th>UOM</th>
                                <th>Unit Price</th>
                                <th>Price</th>
                             </tr>
                         </thead>
                         <tbody>

                         </tbody>
                     </table>
                 </div>
                 <br>
                 <!-- Input DP & Grand Total -->
                 <div class="row" style="display: flex; justify-content: flex-end">
                     <div class="col-md-5">
                         <!-- Form Element sizes -->
                         <div class="card card-success">
                             <div class="card-body">
                                 <!-- Start Input -->
                                 <form class="form-horizontal">
                                     <div class="card-body">
                                         <div class="form-group row">
                                             <label for="prof_mdl_grandtotal" class="col-sm-4 col-form-label">Discount</label>
                                             <div class="col-sm-8">
                                                <div class="input-group">
                                                 <input type="number" min="0" class="form-control" id="prof_diskon" name="prof_diskon" oninput="input_diskon_proforma()" style="text-align:right;width: 50px;" placeholder="0.00">
                                                  <select class="form-control" id="pilih_diskn_prof" name="pilih_diskn_prof" onchange="ganti_diskon(this.value)" required>
                                                <option value="%">Percentage (%)</option>
                                                <option value="Amount">Amount ($/Rp)</option>
                                            </select>
                                              </div>
                                             </div>
                                         </div>
                                          <div class="form-group row">
                                             <label for="prof_mdl_grandtotal" class="col-sm-4 col-form-label">VAT</label>
                                             <div class="col-sm-8">
                                                <select class="form-control" id="id_ppn_prof" name="id_ppn_prof" onchange="hitung_ppn(this.value)" required>
                                                    <option value="0">Non PPN</option>
                                                <?php foreach ($isi_ppn as $ppn) : ?>
                                                <option value="<?= $ppn['percentage']; ?>"><?= $ppn['kriteria2']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                             </div>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                     <div class="col-md-1">
                     </div>
                     <div class="col-md-6">
                         <!-- Form Element sizes -->
                         <div class="card card-success">
                             <div class="card-body">
                                 <!-- Start Input -->
                                 <form class="form-horizontal">
                                     <div class="card-body">
                                         <div class="form-group row">
                                             <label for="prof_mdl_grandtotal" class="col-sm-4 col-form-label">Total With Out Tax</label>
                                             <div class="col-sm-8">
                                                 <input type="hidden" class="form-control" id="prof_twot" name="prof_twot" style="text-align:right;" placeholder="0.00" readonly>
                                                 <input type="hidden" class="form-control" id="prof_twot2" name="prof_twot2" style="text-align:right;" placeholder="0.00" readonly>
                                                 <input type="text" class="form-control" id="prof_twot_h" name="prof_twot_h" style="text-align:right;" placeholder="0.00" readonly>
                                             </div>
                                         </div>
                                         <div class="form-group row">
                                             <label for="prof_mdl_grandtotal" class="col-sm-4 col-form-label">Taxes</label>
                                             <div class="col-sm-8">
                                                 <input type="hidden" class="form-control" id="prof_taxes" name="prof_taxes" style="text-align:right;" placeholder="0.00" readonly>
                                                 <input type="text" class="form-control" id="prof_taxes" name="prof_taxes_h" style="text-align:right;" placeholder="0.00" readonly>
                                             </div>
                                         </div>
                                         <div class="form-group row">
                                             <label for="prof_mdl_grandtotal" class="col-sm-4 col-form-label">Grand Total</label>
                                             <div class="col-sm-8">
                                                 <input type="hidden" class="form-control" id="prof_grandtotal" name="prof_grandtotal" style="text-align:right;" placeholder="0.00" readonly>
                                                 <input type="text" class="form-control" id="prof_grandtotal_h" name="prof_grandtotal_h" style="text-align:right;" placeholder="0.00" readonly>
                                             </div>
                                         </div>
                                         <div class="form-group row">
                                             <div class="custom-control custom-checkbox col-sm-4">
                                                 <input class="custom-control-input" type="checkbox" id="prof_check_dp" name="prof_check_dp" onclick="check_dp(this)" disabled>
                                                 <label for="prof_check_dp" class="custom-control-label">DP Max 75%</label>
                                             </div>
                                             <div class="col-sm-8">
                                                 <div class="input-group" >
                                                  <select class="form-control" id="pilih_dp_prof" name="pilih_dp_prof" onchange="ganti_dp(this.value)" required disabled>
                                                <option value="%">Percentage (%)</option>
                                                <option value="Amount">Amount ($/Rp)</option>
                                                 <input type="text" class="form-control" id="prof_dp" name="prof_dp" style="text-align:right;" placeholder="0.00" readonly onkeypress="javascript:return isNumber(event)" oninput="input_dp_proforma_invoice2()">
                                             </div>
                                         </div>
                                         </div>
                                         <div class="form-group row">
                                             <label for="prof_mdl_grandtotal" class="col-sm-4 col-form-label">Value DP</label>
                                             <div class="col-sm-8">
                                                <!-- <input type="text" class="form-control float-right" id="prof_tipe_h" name="prof_tipe_h" value="CBD" readonly> -->
                                                 <input type="text" class="form-control" id="prof_dp_h" name="prof_dp_h" style="text-align:right;" placeholder="0.00" readonly >
                                                 <input type="hidden" class="form-control" id="prof_dp_h2" name="prof_dp_h2" >
                                             </div>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!--  -->
                 <!-- /.card-body -->
                 <div class="card-footer">
                     <div class="row col-sm-12">
                         <div class="input-group mb-3">
                             <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-simpan-proforma-invoice" onclick="add_data_proforma_invoice()"><i class="fa fa-save"></i> Save Change</button> -->
                             <button type="button" class="btn btn-primary" data-toggle="modal" onclick="add_data_proforma_invoice_cbd()"><i class="fa fa-save"></i> Save Change</button>
                         </div>
                     </div>
                 </div>
             </div>
             <!-- /.card -->
         </div>
         <!-- /.container-fluid -->
     </section>
     <!-- /.content -->
 </div>

 <!-- Modal Add TOP -->
 <div class="modal fade" id="modal-add-prof-top">
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
                             <table id="tbl_prof_top" class="table table-bordered">
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

 <!-- Modal Add SO -->
 <div class="modal fade" id="modal-add-so-proforma">
     <div class=" modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Add SO</h4>
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
                                 <input type="text" class="form-control float-right" id="prof_custm" name="prof_custm" readonly>
                                 <input type="hidden" class="form-control float-right" id="prof_tipe" name="prof_tipe" value="CBD" readonly>
                             </div>
                             <div class="col-md-4">
                                 <div class="form-group">
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
                                 <button type="button" id="prof_find_so" name="prof_find_so" class="btn btn-info" href="javascript:void(0)" onclick="cari_so_proforma_cbd()"><i class="fa fa-search"></i> Search</button>
                             </div>
                         </div>
                         <!-- ID Customer -->
                         <div class="col-md-2">
                             <input type="hidden" class="form-control float-right" id="prof_id_custm" name="prof_id_custm" readonly>
                         </div>
                         <!-- End Date Range -->
                     </div>
                     <!-- /.card-header -->
                     <!-- Detail SO -->
                     <div class="card-body">
                        <div class="card-header">
                                <h3 class="card-title">DataTable SO</h3>
                            </div>
                        <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cari_so" name="cari_so" required autocomplete="off" placeholder="Search SO number.." onkeyup="cari_so_num()">
                             </div>
                             <div class="card-body table-responsive p-0" style="height: 350px;">
                         <table id="example4" class="table table-head-fixed text-nowrap table-bordered table-striped" >
                             <thead>
                                 <tr>
                                     <th style="width: 10px">Cek</th>
                                     <th>SO Number</th>
                                     <th>SO Date</th>
                                     <th>Customer</th>
                                     <th>Buyer Number</th>
                                     <th>Curr</th>
                                     <th>Qty</th>
                                     <th>Unit Price</th>
                                     <th>Total Price</th>
                                     <th>ID</th>
                                 </tr>
                             </thead>

                             <tbody>

                             </tbody>
                         </table>
                     </div>
                     </div>
                     <!-- /.card-body -->
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable Detail SO</h3>
                            </div>
                            <!-- /.card-header -->
                 <!--                <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cari_shipp" name="cari_shipp" required autocomplete="off" placeholder="Search shipp number..." onkeyup="cari_shipp_num()">
                             </div> -->
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table id="table-so-detail" name="table-so-detail" class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>SO Number</th>
                                            <th>Product</th>
                                            <th>Curr</th>
                                            <th>QTY</th>
                                            <th>UOM</th>
                                            <th>Unit Price</th>
                                            <th>Price</th>
                                            <th style="text-align:center"><input type="checkbox" onchange="pilihsemua(this)" id="cek_sodet" name="cek_sodet"></th>
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
                                                <input type="hidden" class="form-control" id="mdl_total_sodet" name="mdl_total_sodet" style="text-align:right;" placeholder="0.00" readonly>
                                                <input type="text" class="form-control" id="mdl_total_sodet_h" name="mdl_total_sodet_h" style="text-align:right;" placeholder="0.00" readonly>
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
                 <button type="button" id="prof_btn_add_data_so" name="prof_btn_add_data_so" class="btn btn-primary" href="javascript:void(0)" onclick="duplicate_data_so_proforma()">Add Data</button>
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>
</div>

 <!-- Modal Simpan Proforma Invoice -->
 <div class="modal fade" id="modal-simpan-proforma-invoice">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Confirm Save</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <!-- No Proforma Invoice -->
                 <div class="form-group row">
                     <label for="prof_no_inv_mdl" class="col-sm-5 col-form-label">Save Proforma Invoice :</label>
                     <div class="col-sm-7">
                         <input type="text" class="form-control" id="prof_no_inv_mdl" name="prof_no_inv_mdl" style="border:none;" readonly>
                     </div>
                 </div>
             </div>
             <div class="modal-footer justify-content-between">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                 <button type="button" class="btn btn-primary toastrDefaultSuccess" onclick="save_proforma_invoice_cbd()">Save Change</button>
             </div>
         </div>
     </div>
 </div>



 <!-- Check DP -->
 <script>
     function check_dp(checkboxElem) {
         if (checkboxElem.checked) {
             $("#prof_dp").prop("readonly", false);
             $("#pilih_dp_prof").prop("disabled", false);
             $("#prof_dp").val("");
             $("#prof_dp_h").val("");
             $("#prof_dp_h2").val("");
         } else {
             $("#prof_dp").prop("readonly", true);
             $("#pilih_dp_prof").prop("true", true);
             $("#prof_dp").val("0.00");
             $("#prof_dp_h").val("0.00");
             $("#prof_dp_h2").val("0.00");
         }
     }
 </script>

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
    function cari_so_num() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_so");
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


