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
                         <li class="breadcrumb-item active">Return Invoice</li>
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
                                 <label>Return Invoice</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="rtn_inv_number" name="rtn_inv_number" value="<?= $kode_return_invoice; ?>" readonly required>
                                 </div>
                             </div>
                             <!-- /.form-group -->
                             <div class="form-group">
                                 <label>Customer</label>
                                 <select class="form-control select2bs4" id="rtn_customer" name="rtn_customer">
                                     <?php foreach ($customer as $cs) : ?>
                                         <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <div class="form-group">
                                 <label>Shipp</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="rtn_shipp" name="rtn_shipp" required autocomplete="off">
                                     <span class="input-group-append">
                                         <button id="rtn_L" name="rtn_L" type="button" class="btn btn-success btn-flat" onclick="get_kode_return_invoice('L')"><i class="fa fa-car"></i> Local</button>
                                         <button id="rtn_E" name="rtn_E" type="button" class="btn btn-info btn-flat" onclick="get_kode_return_invoice('E')"><i class="fa fa-plane"></i> Export</button>
                                     </span>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label>NRP</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="rtn_nrp" name="rtn_nrp" autocomplete="off">
                                 </div>
                             </div>
                             <!-- BANK -->
                             <div class="form-group">
                                 <label>Bank</label>
                                 <select class="form-control" id="id_bank_return" name="id_bank_return" required>
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
                                 <label>No Invoice Asal</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="rtn_inv_asal" name="rtn_inv_asal" autocomplete="off">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label>Peb</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="rtn_peb" name="rtn_peb" autocomplete="off">
                                 </div>
                             </div>
                             <!-- /.form-group -->
                             <div class="form-group">
                                 <label>Type</label>
                                 <select id="rtn_type" name="rtn_type" class="form-control" required>
                                     <?php foreach ($type as $t) : ?>
                                         <option value="<?= $t['id_type']; ?>"><?= $t['type']; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <div class="form-group">
                                 <label>SJ/BPB Number</label>
                                 <div class="input-group mb-3">
                                     <input type="text" class="form-control" id="rtn_sjbpb_number1" name="rtn_sjbpb_number1" readonly required>
                                     <span class="input-group-append">
                                         <button id="rtn_sjbpb_number2" name="rtn_sjbpb_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-sjbpb-return" href="javascript:void(0)" onclick="add_id_for_return_inv()">Add SJ/BPB</button>
                                     </span>
                                 </div>
                             </div>
                             <!-- /.form-group -->
                         </div>
                         <!-- /.col -->
                     </div>
                     <!-- /.row -->
                 </div>
                 <div class="card-body table-responsive p-0" style="height: 300px;">
                     <table id="table-return-invoice" class="table table-head-fixed text-nowrap">
                         <thead>
                             <tr>
                                 <!-- <th>ID</th> -->
                                 <th>Bpb Number</th>
                                 <th>Sj Number</th>
                                 <th>Bpb Date</th>
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
                 <!-- /.card-body -->
                 <div class="card-footer">
                     <div class="row col-sm-12">
                         <div class="input-group mb-3">
                             <button type="button" class="btn btn-primary" data-toggle="modal" onclick="add_data_return_invoice()"><i class="fa fa-save"></i> Save Change</button>
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

 <!-- Modal Add SJ/BPB -->
 <div class="modal fade" id="modal-add-sjbpb-return">
     <div class=" modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Add SJ/BPB</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <!-- <p>One fine body&hellip;</p> -->
                 <!-- Datatable Nomor SJ/BPB -->
                 <div class="card">
                     <div class="card-header">
                         <!-- Date Range -->
                         <div class="row">
                             <div class="col-md-4">
                                 <input type="text" class="form-control float-right" id="rtn_custm" name="rtn_custm" readonly>
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
                                 <button type="button" id="rtn_find_sjbpb" name="rtn_find_sjbpb" class="btn btn-info" href="javascript:void(0)" onclick="cari_sjbpb_return()"><i class="fa fa-search"></i> Search</button>
                             </div>
                         </div>
                         <!-- ID Customer -->
                         <div class="col-md-2">
                             <input type="hidden" class="form-control float-right" id="rtn_id_custm" name="rtn_id_custm" readonly>
                         </div>
                         <!-- End Date Range -->
                     </div>
                     <!-- /.card-header -->
                     <!-- Detail SJ/BPB -->
                     <div class="card-body table-responsive p-0" style="height: 300px;">
                         <table id="table-return-invoice-mdl" class="table table-head-fixed text-nowrap">
                             <thead>
                                 <tr>
                                     <th style="width: 10px">Cek</th>
                                     <!-- <th>ID</th> -->
                                     <th>Bpb Number</th>
                                     <th>Sj Number</th>
                                     <th>Bpb Date</th>
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
                     <!-- /.card-body -->
                 </div>
             </div>
             <div class="modal-footer right-content-between">
                 <button type="button" id="rtn_btn_add_data_sjbpb" name="rtn_btn_add_data_sjbpb" class="btn btn-primary" href="javascript:void(0)" onclick="duplicate_data_sjbpb_return()">Add Data</button>
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>

 <!-- Modal Simpan Return Invoice -->
 <div class="modal fade" id="modal-simpan-return-invoice">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Confirm Save</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <!-- No Return Invoice -->
                 <div class="form-group row">
                     <label for="rtn_no_inv_mdl" class="col-sm-5 col-form-label">Save Return Invoice :</label>
                     <div class="col-sm-7">
                         <input type="text" class="form-control" id="rtn_no_inv_mdl" name="rtn_no_inv_mdl" style="border:none;" readonly>
                     </div>
                 </div>
             </div>
             <div class="modal-footer justify-content-between">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                 <button type="button" class="btn btn-primary toastrDefaultSuccess" onclick="save_return_invoice()">Save Change</button>
             </div>
         </div>
     </div>
 </div>