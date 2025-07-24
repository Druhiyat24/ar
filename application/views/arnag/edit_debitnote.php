<!-- Content Wrapper. Contains page content -->
<style type="text/css">
    .select2-selection--multiple{
        overflow: hidden !important;
        height: auto !important;
    }
</style>
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
                            <h3 class="card-title">Data Header</h3>
                        </div>
                        <div class="card-body">
                            <!-- Start Input -->
                            <div class="form-group col-md-12">
                                <label>Debit Note Number</label>
                                <input type="text" class="form-control" id="dn_number" name="dn_number" value="<?= $data_dn['no_dn']; ?>" required readonly>
                                <input type="hidden" class="form-control" id="dn_number_old" name="dn_number_old" value="<?= $data_dn['no_dn']; ?>" required readonly>
                                <input type="hidden" class="form-control" id="id_dn" name="id_dn" value="<?= $data_dn['id']; ?>" required readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="dn_date" id="dn_date" class="form-control tanggal" value="<?= isset($data_dn['tgl_dn']) && $data_dn['tgl_dn'] != '' ? $data_dn['tgl_dn'] : date('Y-m-d'); ?>" autocomplete='off'>
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Due Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="dn_duedate" id="dn_duedate" class="form-control tanggal" value="<?= isset($data_dn['due_date']) && $data_dn['due_date'] != '' ? $data_dn['due_date'] : date('Y-m-d'); ?>" autocomplete='off'>
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <!-- /. Hidden Element -->
                            <div class="form-group col-md-12">
                                <label>Consignee</label>
                                <select class="form-control select2bs4" id="customer" name="customer" onchange="get_alamat_edit(this.value)">
                                  <?php foreach ($customer as $cs) : ?>
                                    <option value="<?= $cs['Id_Supplier']; ?>"
                                        <?= (isset($data_dn['customer']) && $data_dn['customer'] == $cs['Id_Supplier']) ? 'selected' : ''; ?>>
                                        <?= $cs['Supplier']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" class="form-control" id="nama_supp" name="nama_supp" readonly>
                        <!-- TOP -->

                        <!-- END TOP -->
                        <div class="form-group col-md-12">
                            <label>Attn</label>
                            <input type="text" class="form-control" id="txt_attn" name="txt_attn" value="<?= $data_dn['attn']; ?>" autocomplete='off' required>
                            <input type="hidden" class="form-control" id="no_coa_deb3" name="no_coa_deb3" value="<?= $data_dn['no_coa']; ?>" readonly>
                            <input type="hidden" class="form-control" id="nama_coa_deb3" name="nama_coa_deb3" value="<?= $data_dn['nama_coa']; ?>" readonly>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Address</label>
                            <textarea rows="4"  type="text" class="form-control" id="alamat" name="alamat" autocomplete='off' required><?= $data_dn['alamat'] ?></textarea>
                        </div>

                        <!-- <div class="form-group col-md-12">
                            <label>No Memo</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="no_memo" name="no_memo" value="<?= $reff_dn['reff_doc']; ?>" readonly required>
                                <span class="input-group-append">
                                    <button id="so_number2" name="so_number2" type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-add-memo" href="javascript:void(0)" onclick="add_memo()">Add Memo</button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label>No Request</label>
                            <select class="form-control selectpicker" multiple="" id="no_req" name="no_req" data-dropup-auto="false" data-live-search="true" data-size="5" onchange="getdata_reqdn(value)">
                              <?php foreach ($data_req as $req) : ?>
                                <option value="<?= $req['id']; ?>"><?= $req['no_req']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->

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
                        <label>Profit Center</label>
                        <select class="form-control select2bs4" id="profit_center_dn" name="profit_center_dn" onchange="updateDN()" required>
                            <?php foreach ($profit_center as $pc) : ?>
                                <option value="<?= $pc['kode_pc']; ?>" <?= (isset($data_dn['profit_center']) && $data_dn['profit_center'] == $pc['kode_pc']) ? 'selected' : ''; ?>><?= $pc['nama_pc']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Bank Account</label>
                        <select class="form-control select2bs4" id="akun" name="akun" >
                          <?php foreach ($bank as $bk) : ?>
                            <option value="<?= $bk['akun']; ?>" <?= (isset($data_dn['akun']) && $data_dn['akun'] == $bk['akun']) ? 'selected' : ''; ?>><?= $bk['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <div class="form-group">
                     <label>Currency From - To</label>
                     <div class="input-group mb-3">
                        <select class="form-control select2bs4" id="curr1" name="curr1" required>
                            <option value="IDR" <?= ($data_dn['from_curr'] == 'IDR') ? 'selected' : '' ?>>IDR</option>
                            <option value="USD" <?= ($data_dn['from_curr'] == 'USD') ? 'selected' : '' ?>>USD</option>
                        </select>
                        <label style="padding-right: 30px;padding-left: 30px;"> - </label>
                        <select class="form-control select2bs4" id="curr2" name="curr2" required>
                            <option value="IDR" <?= ($data_dn['to_curr'] == 'IDR') ? 'selected' : '' ?>>IDR</option>
                            <option value="USD" <?= ($data_dn['to_curr'] == 'USD') ? 'selected' : '' ?>>USD</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group col-md-12">
                <div class="form-group row">
                 <div class="custom-control custom-checkbox col-sm-3">
                     <input class="custom-control-input" type="checkbox" id="cek_header1" name="cek_header1" onclick="check_dp(this)" <?= ($data_dn['header1'] != '') ? 'checked' : '' ?>>
                     <label for="cek_header1" class="custom-control-label">Header 1</label>
                 </div>
                 <div class="col-sm-9">
                     <div class="input-group" >
                         <input type="text" class="form-control" id="txt_header1" name="txt_header1" style="text-align:left;" value="<?= $data_dn['header1'] ?>" readonly oninput="ubah_header1(this.value)">
                     </div>
                 </div>
             </div>
         </div>
         <div class="form-group col-md-12">
            <div class="form-group row">
             <div class="custom-control custom-checkbox col-sm-3">
                 <input class="custom-control-input" type="checkbox" id="cek_header2" name="cek_header2" onclick="check_dp2(this)" <?= ($data_dn['header2'] != '') ? 'checked' : '' ?>>
                 <label for="cek_header2" class="custom-control-label">Header 2</label>
             </div>
             <div class="col-sm-9">
                 <div class="input-group" >
                     <input type="text" class="form-control" id="txt_header2" name="txt_header2" style="text-align:left;" value="<?= $data_dn['header2'] ?>" readonly oninput="ubah_header2(this.value)">
                 </div>
             </div>
         </div>
     </div>
     <div class="form-group col-md-12">
        <div class="form-group row">
         <div class="custom-control custom-checkbox col-sm-3">
             <input class="custom-control-input" type="checkbox" id="cek_header3" name="cek_header3" onclick="check_dp3(this)" <?= ($data_dn['header3'] != '') ? 'checked' : '' ?>>
             <label for="cek_header3" class="custom-control-label">Header 3</label>
         </div>
         <div class="col-sm-9">
             <div class="input-group" >
                 <input type="text" class="form-control" id="txt_header3" name="txt_header3" style="text-align:left;" value="<?= $data_dn['header3'] ?>" readonly oninput="ubah_header3(this.value)">
             </div>
         </div>
     </div>
 </div>
 <div class="form-group col-md-12">
    <label>Update Data Header</label>
    <div class="input-group mb-3">
        <button type="button" onclick="handleUpdate_Debitnote()" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>

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
                <button type="button" id="add_row" class="btn btn-primary" onclick="addRow('tbody2')">Add Row</button>
                <button type="button" class="btn btn-warning" onclick="InsertRow('tbody2')">Interject Row</button>
                <button type="button" class="btn btn-danger" onclick="hapusbaris()">Delete Row</button>
            </div>
                    <!--     <div class="input-group-append col">
                        <input  style="margin-right: 15px;border: 0; line-height: 1; padding: 10px 20px; font-size: 1rem; text-align: center; color: #fff; text-shadow: 1px 1px 1px #000; border-radius: 6px; background-color: rgb(30, 144, 255);" id="add" type="button" value="(+) Add"> 

                        <input style="border: 0; line-height: 1; padding: 10px 20px; font-size: 1rem; text-align: center; color: #fff; text-shadow: 1px 1px 1px #000; border-radius: 6px; background-color: rgb(139, 5, 0);" id="delete" type="button" value="(-) Delete">
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 400px;">
                        <table id="table-dn" class="table table-head-fixed text-nowrap table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center;width: 12%;">Description</th>
                                    <th style="text-align: center;width: 12%;">Supplier</th>
                                    <th style="text-align: center;width: 12%;">Supplier Invoice</th>
                                    <th style="width: 10%"><input type="text" class="form-control" id="h_header1" name="h_header1" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;" placeholder="Header 1" readonly></th>
                                    <th style="width: 10%"><input type="text" class="form-control" id="h_header2" name="h_header2" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;" placeholder="Header 2" readonly></th>
                                    <th style="width: 10%"><input type="text" class="form-control" id="h_header3" name="h_header3" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;" placeholder="Header 3" readonly></th>
                                    <th style="text-align: center;width: 10%;">Value</th>
                                    <th style="text-align: center;width: 10%;">Rate</th>
                                    <th style="text-align: center;width: 10%;">Amount</th>
                                    <th style="text-align: center;width: 12%;">COA</th>
                                    <th style="text-align: center;width: 4%;">Cek</th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody2">
                                <tr style="display: none">
                                    <td>
                                        <input style="width: 300px;word-wrap: break-word;" type="text" class="form-control" name="inputan0" placeholder="" autocomplete='off'>
                                    </td>
                                    <td >
                                        <input style="width: 250px;" class="form-control" list="supp" name="supp">
                                        <datalist id="supp">
                                            <option value="-" > - </option> 
                                            <?php foreach ($supplier as $cs) : ?>
                                                <option value="<?= $cs['Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                            <?php endforeach; ?>
                                        </datalist>  
                                    </td>
                                    <td>
                                        <input style="width: 200px" type="text" class="form-control" name="inputan2" placeholder="" autocomplete='off'> 
                                    </td>
                                    <td>
                                        <input style="width: 200px" type="text" class="form-control" id="inputan3" name="inputan3" placeholder="" autocomplete='off'>
                                    </td>
                                    <td>
                                        <input style="width: 200px" type="text" class="form-control" id="inputan4" name="inputan4" placeholder="" autocomplete='off' readonly> 
                                    </td>
                                    <td>
                                        <input style="width: 200px" type="text" class="form-control" id="inputan5" name="inputan5" placeholder="" autocomplete='off'> 
                                    </td>
                                    <td>
                                        <input  type="text" class="form-control" id="amt" name="amt" style="text-align:right; width: 150px;" oninput="modal_input_amt_dn(value)" autocomplete="off">
                                    </td>
                                    <td>
                                        <input  type="text" class="form-control" id="amt_rate" name="amt_rate" style="text-align:right; width: 150px;" value="<?= $rate; ?>" onkeypress="javascript:return isNumber(event)" oninput="modal_input_rate_dn(value)" autocomplete="off">
                                    </td>
                                    <td>
                                        <input style="width: 150px;text-align: right;" type="text" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly> 
                                    </td>
                                    <td><input style="width: 250px;" class="form-control" value="1.34.04" list="nm_coa" name="nm_coa">
                                        <datalist id="nm_coa"> <option value="-" > - </option> <?php foreach ($coa as $coa) : ?> <option value="<?= $coa["id_coa"]; ?>"><?= $coa["id_coa"]; ?> <?= $coa["coa_name"]; ?> </option><?php endforeach; ?> </datalist></td>

                                        <td><input name="chk_a[]" type="checkbox" class="checkall_a" value=""/></td>
                                        <!-- <td style="visibility:hidden;"><input style="width: 150px;text-align: right;" type="hidden" class="form-control" name="inputan10" value="" placeholder="" autocomplete="off" readonly></td> -->
                                        <td style="display: none;">
                                            <input type="hidden" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly> 
                                        </td>
                                        <td style="display: none;">
                                            <input type="hidden" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly> 
                                        </td>
                                        <td style="display: none;">
                                            <input type="hidden" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly> 
                                        </td>
                                    </tr>

                                    <?php if (!empty($data_dn_det)) : ?>
                                        <?php foreach ($data_dn_det as $row) : ?>
                                            <tr>
                                                <td>
                                                    <input style="width: 300px;word-wrap: break-word;" type="text" class="form-control" name="inputan0" placeholder="" value="<?= $row['deskripsi']; ?>" autocomplete='off'>
                                                </td>
                                                <td >
                                                    <input style="width: 250px;" class="form-control" list="supp" name="supp">
                                                    <datalist id="supp">
                                                        <?php foreach ($supplier as $cs) : ?>
                                                            <option value="<?= $cs['Supplier']; ?>" <?= (isset($row['supplier']) && $row['supplier'] == $cs['Supplier']) ? 'selected' : ''; ?>><?= $cs['Supplier']; ?></option>
                                                        <?php endforeach; ?>
                                                        <option value="-" > - </option> 
                                                    </datalist>  
                                                </td>
                                                <td>
                                                    <input style="width: 200px" type="text" class="form-control" name="inputan2" placeholder="" value="<?= $row['supplier_invoice']; ?>" autocomplete='off'> 
                                                </td>
                                                <td>
                                                    <input style="width: 200px" type="text" class="form-control" id="inputan3" name="inputan3" placeholder="" value="<?= $row['header1']; ?>" autocomplete='off' <?= ($data_dn['header1'] != '') ? '' : 'readonly' ?>>
                                                </td>
                                                <td>
                                                    <input style="width: 200px" type="text" class="form-control" id="inputan4" name="inputan4" placeholder="" value="<?= $row['header2']; ?>" autocomplete='off' <?= ($data_dn['header2'] != '') ? '' : 'readonly' ?>> 
                                                </td>
                                                <td>
                                                    <input style="width: 200px" type="text" class="form-control" id="inputan5" name="inputan5" placeholder="" value="<?= $row['header3']; ?>" autocomplete='off' <?= ($data_dn['header3'] != '') ? '' : 'readonly' ?>> 
                                                </td>
                                                <td>
                                                    <input  type="text" class="form-control" id="amt" name="amt" style="text-align:right; width: 150px;" value="<?= $row['value']; ?>" oninput="modal_input_amt_dn(value)" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input  type="text" class="form-control" id="amt_rate" name="amt_rate" style="text-align:right; width: 150px;" value="<?= $row['rate']; ?>" onkeypress="javascript:return isNumber(event)" oninput="modal_input_rate_dn(value)" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input style="width: 150px;text-align: right;" type="text" class="form-control" name="inputan8" placeholder="" value="<?= $row['amount']; ?>" autocomplete='off' readonly> 
                                                </td>
                                                <td><input style="width: 250px;" class="form-control" value="1.34.04" list="nm_coa" name="nm_coa">
                                                    <datalist id="nm_coa"> <?php foreach ($coa as $coa) : ?> <option value="<?= $coa["id_coa"]; ?>" <?= (isset($row['no_coa']) && $row['no_coa'] == $coa['id_coa']) ? 'selected' : ''; ?>><?= $coa["id_coa"]; ?> <?= $coa["coa_name"]; ?> </option><?php endforeach; ?> <option value="-" > - </option> </datalist></td>

                                                    <td><input name="chk_a[]" type="checkbox" class="checkall_a" value=""/></td>
                                                    <!-- <td style="visibility:hidden;"><input style="width: 150px;text-align: right;" type="hidden" class="form-control" name="inputan10" value="" placeholder="" autocomplete="off" readonly></td> -->
                                                    <td style="display: none;">
                                                        <input type="hidden" class="form-control" name="inputan8" placeholder="" value="<?= $row['id_memo_det']; ?>" autocomplete='off' readonly> 
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="hidden" class="form-control" name="inputan8" placeholder="" value="<?= $row['nm_memo']; ?>" autocomplete='off' readonly> 
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="hidden" class="form-control" name="inputan8" placeholder="" value="<?= $row['id_memo_det']; ?>" autocomplete='off' readonly> 
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="17" class="text-center">Tidak ada data detail</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody> 
                                </table>

                                <!-- <input  style="margin-right: 15px;border: 0; line-height: 1; padding: 10px 20px; font-size: 1rem; text-align: center; color: #fff; text-shadow: 1px 1px 1px #000; border-radius: 6px; background-color: rgb(30, 144, 255);" id="add" type="button" value="(+) Add">  -->

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
                                            <label for="total_h" class="col-sm-4 col-form-label">Total Amount</label>
                                            <div class="col-sm-8">
                                                <input type="text" style="text-align: right;" class="form-control" id="total_value" name="total_value" placeholder="0.00" value="<?= number_format($data_dn['amount'],2); ?>" readonly>
                                                <input type="hidden" name="total_value_h" id="total_value_h" value="<?= $data_dn['amount']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="total_h" class="col-sm-4 col-form-label">Equivalent Currency</label>
                                            <div class="col-sm-8">
                                                <input type="text" style="text-align: right;" class="form-control" id="total_value_idr" name="total_value_idr" placeholder="0.00" value="<?= number_format($data_dn['eqv_curr'],2); ?>" readonly>
                                                <input type="hidden" name="total_value_idr_h" id="total_value_idr_h" value="<?= $data_dn['eqv_curr']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="button" class="btn btn-success" data-toggle="modal" onclick="simpan_data_dn_detail()">
                                                    <i class="fa fa-save"></i> Update Detail
                                                </button>
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
                <!--  -->
                <!-- End Data Potongan Invoice  -->
                <!--  -->
                <!-- Button Simpan Data Invoice  -->
                <div class="row col-sm-12">
                    <div class="input-group mb-3">
                       <button type="button" class="btn btn-danger" onclick="window.close();">
                        <i class="fas fa-arrow-circle-left"></i> Back
                    </button>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" onclick="simpan_data_dn()"><i class="fa fa-save"></i> Save </button> -->
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
<div class="modal fade" id="modal-add-memo">
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
                                <input type="text" class="form-control float-right" id="custm" name="custm" readonly>
                                <input type="hidden" class="form-control float-right" id="id_custm" name="id_custm" readonly>
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
                                        <input type="text" class="form-control float-right" id="tgl_fil_memo" name="tgl_fil_memo">
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
                            <div class="col-md-4">

                            </br>
                            <button type="button" id="find_so" name="find_so" class="btn btn-info" href="javascript:void(0)" onclick="cari_data_memo()"><i class="fa fa-search"></i> Search</button>
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
                            <input type="text"  id="carinoinv" name="carinoinv" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_inv_memo()">
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table id="table-inv-memo" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Supplier</th>
                                        <th>No Memo</th>
                                        <th>Memo Date</th>
                                        <th>No Invoice</th>
                                        <th>Curr</th>
                                        <th>Total</th>
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
                                        <label for="mdl_total" class="col-sm-4 col-form-label">Amount Memo</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" class="form-control" id="val_memo" name="val_memo" style="text-align:right;" placeholder="0.00">
                                            <input type="text" class="form-control" id="val_memo_h" name="val_memo_h" style="text-align:right;" placeholder="0.00" readonly>
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
        </div>
        <div class="modal-footer right-content-between">
            <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Add</button> -->
            <button type="button" id="btn_add_data_so" name="btn_add_data_so" class="btn btn-primary" href="javascript:void(0)" onclick="duplicate_data_memo()">Add Data</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- Modal Simpan Invoice Status POST -->
<div class="modal fade" id="modal-simpan-dn">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Save Debit Note</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- No Invoice -->
                <div class="form-group row">
                    <label for="id_inv" class="col-sm-5 col-form-label">Save Debit Note Number :</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="no_debinote" name="no_debinote" style="border:none;" readonly>
                    </div>
                </div>
                <!-- ID Invoice, Pph -->
                <input type="hidden" class="form-control" id="id_inv_post" name="id_inv_post" readonly>
                <input type="hidden" class="form-control" id="pph_post" name="pph_post" readonly>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary toastrDefaultSuccess" onclick="save_dn()">Save</button>
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
    window.onload = function() {
        const checkbox = document.getElementById('cek_header1');
        check_dp(checkbox);
        if (checkbox) {
            const input1 = document.getElementById('txt_header1');
            ubah_header1(input1.value);
        }

        const checkbox2 = document.getElementById('cek_header2');
        check_dp2(checkbox2);
        if (checkbox2) {
            const input2 = document.getElementById('txt_header2');
            ubah_header2(input2.value);
        }

        const checkbox3 = document.getElementById('cek_header3');
        check_dp3(checkbox3);
        if (checkbox3) {
            const input3 = document.getElementById('txt_header3');
            ubah_header3(input3.value);
        }
    }
</script>

<script>
    function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;
        return true;
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2memo').select2({
            dropdownAutoWidth : true;
        });
    });
</script>

<script type="text/javascript">
    var tampung = [];
    function getdata_reqdn(val){

        let array = $('#no_req').val();
        $('select option').on('mousedown', function (e) {
            this.selected = !this.selected;
            alert(this.selected = !this.selected);
            e.preventDefault();
        });
        let text1 = "";
        let kodenya = text1.concat(array, "");
        let kode_req = kodenya.toString();
        let no_req = kode_req.replace(/,/g,"','");
        console.log(no_req);
                //
                $.ajax({                        
                    url: "cari_list_reqdn/",      
                    type: "POST",   
                    data: {
                        no_req: no_req,
                    },   
                    dataType: "JSON",
                    success: function (response) {
                // console.log(response,tampung);

                var trHTML = '';
                $.each(response, function (i, item) {
                    if (!tampung.includes(item.id)) {
                       console.log(tampung.includes(item.id),item.id); 
                       trHTML += '<tr>';       
                       trHTML += '<td><input style="width: 300px;word-wrap: break-word;" type="text" class="form-control" name="inputan0" value="'+ item.itemdesc +'" placeholder="" autocomplete="off">';     
                       trHTML += '<td><input style="width: 250px;" class="form-control" value="'+ item.nama_supp +'" list="supp" name="supp"> <datalist id="supp"><option value="'+ item.nama_supp +'">'+ nama_supp.supplier +'</option></datalist></td>';
                       trHTML += '<td><input style="width: 200px" type="text" class="form-control" name="inputan2" value="" placeholder="" autocomplete="off"></td>';
                       trHTML += '<td><input style="width: 200px" type="text" class="form-control" id="inputan3" name="inputan3" value="'+ item.no_po +'" placeholder="" autocomplete="off" readonly></td>';
                       trHTML += '<td><input style="width: 200px" type="text" class="form-control" id="inputan4" name="inputan4" value="'+ item.header2 +'" placeholder="" autocomplete="off" readonly></td>';
                       trHTML += '<td><input style="width: 200px" type="text" class="form-control" id="inputan5" name="inputan5" value="'+ item.header3 +'" placeholder="" autocomplete="off" readonly></td>';
                       trHTML += '<td><input  type="text" class="form-control" id="amt" name="amt" value="'+ item.total +'" style="text-align:right; width: 150px;" oninput="modal_input_amt_dn(value)" autocomplete="off"></td>';
                       trHTML += '<td><input  type="text" class="form-control" id="amt_rate" name="amt_rate" style="text-align:right; width: 150px;" value="1" onkeypress="javascript:return isNumber(event)" oninput="modal_input_rate_dn(value)" autocomplete="off"></td>';                                                              
                       trHTML += '<td ><input style="width: 150px;text-align: right;" type="text" class="form-control" name="inputan8" value="'+ item.total +'" placeholder="" autocomplete="off" readonly></td>';
                       trHTML += '<td><input style="width: 250px;" class="form-control" value="1.34.05" list="nm_coa" name="nm_coa"></td>';       
                       trHTML += '<td><input name="chk_a[]" type="checkbox" class="checkall_a" value=""/></td>';                                           
                       trHTML += '<td hidden><input type="checkbox" name="id_memo_det" id="id_memo_det" class="flat" value = "" checked></td>';
                       trHTML += '<td hidden><input style="width: 200px" type="text" class="form-control" name="text" value="'+ item.no_bpb +'" placeholder="" autocomplete="off"></td>';
                       trHTML += '<td hidden><input style="width: 200px" type="text" class="form-control" name="text" value="" placeholder="" autocomplete="off"></td>';
                       trHTML += '</tr>';
                       tampung.push(item.id);
                   }

               });
                // console.log(tampung,trHTML);
                $('#tbody2').append(trHTML);     
                modal_input_amt_dn();

            },
            error: function (jqXHR, textStatus, errorThrown) {
                msg = 'Error Update Invoice Header' + jqXHR.text
            }
        });     
                //
                // $('#modal-approve-invoice-manual').modal('hide');
                // console.log(id_inv);  
                // window.location.reload();
                // cari_invoice_post();
            }

   // JavaScript Document
   function addRow(tableID) {

    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;
    var header1         = $('#txt_header1').val();
    var header2         = $('#txt_header2').val();
    var header3         = $('#txt_header3').val();

    for(var i=0; i<colCount; i++) {
        var newcell = row.insertCell(i);
        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        var child = newcell.children;
        for(var i2=0; i2<child.length; i2++) {
            var test = newcell.children[i2].tagName;
            switch(test) {
                case "INPUT":
                if(newcell.children[i2].type=='checkbox'){
                        // newcell.children[i2].value = "";
                        newcell.children[i2].checked[0] = true;
                        $('#inputan4').prop('readonly', false);

                    }else{
                        if (header1 == '') {
                            $('#inputan3').prop('readonly', true);
                        }else{
                            $('#inputan3').prop('readonly', false);
                        }

                        if (header2 == '') {
                            $('#inputan4').prop('readonly', true);
                        }else{
                            $('#inputan4').prop('readonly', false);
                        }

                        if (header3 == '') {
                            $('#inputan5').prop('readonly', true);
                        }else{
                            $('#inputan5').prop('readonly', false);
                        }

                    }
                    break;
                    case "SELECT":
                    // newcell.children[i2].value = "";
                    break;
                    default:
                    break;
                }
            }
        }            

    }
    
    function deleteRow()
    {
        try
        {
            var table = document.getElementById("tbody2");
            var rowCount = table.rows.length;
            for(var i=0; i<rowCount; i++)
            {
                var row = table.rows[i];
                var chkbox = row.cells[10].childNodes[0];
                if (null != chkbox && true == chkbox.checked)
                {
                    if (rowCount <= 1)
                    {
                        alert("Tidak dapat menghapus semua baris.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }
        } catch(e)
        {
            alert(e);
        }
    }

    function InsertRow(tableID)
    {
        try{
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            for(var i=0; i<rowCount; i++)
            {
                var row = table.rows[i];
                var chkbox = row.cells[10].childNodes[0];
                if (null != chkbox && true == chkbox.checked)
                {
                    var newRow = table.insertRow(i+1);
                    var colCount = table.rows[0].cells.length;
                    for (h=0; h<colCount; h++){
                        var newCell = newRow.insertCell(h);
                        newCell.innerHTML = table.rows[0].cells[h].innerHTML;
                        var child = newCell.children;
                        for(var i2=0; i2<child.length; i2++) {
                            var test = newCell.children[i2].tagName;
                            switch(test) {
                                case "INPUT":
                                if(newCell.children[i2].type=='checkbox'){
                                    newCell.children[i2].value = "";
                                    newCell.children[i2].checked[9] = true;
                                }else{
                                    newCell.children[i2].value = "";
                                }
                                break;
                                case "SELECT":
                                newCell.children[i2].value = "";
                                break;
                                default:
                                break;
                            }
                        }
                    }
                }

            }
        } catch(e)
        {
            alert(e);
        }
    }

    function hitungRow(){
        var table = document.getElementById("tbody2");
        var rowCount2 = table.rows.length;
        var tota = 0;
        var tot_price = 0;

        for(var i=0; i<rowCount2; i++){

            var price = parseFloat(document.getElementById("tbody2").rows[i].cells[6].children[0].value,10) || 0;

            tota += price;

            document.getElementsByName("total_value_h")[0].value = tota.toFixed(2);
            document.getElementsByName("total_value")[0].value = formatMoney(tota.toFixed(2));
        }

    }


    async function hapusbaris(){
       await deleteRow()
       console.log("result");
       hitungRow();
   }
</script>


<script>
 function check_dp(checkboxElem) {
     if (checkboxElem.checked) {
         $("#txt_header1").prop("readonly", false);
     } else {
         $("#txt_header1").prop("readonly", true);
         $("#txt_header1").val("");
         ('input[name=inputan3]').prop('readonly', true);
         $('input[name=inputan3]').val("");
     }
 }
</script>

<script>
 function check_dp2(checkboxElem) {
     if (checkboxElem.checked) {
         $("#txt_header2").prop("readonly", false);
             // var inputan4 = $(this).closest('tr').find('td:eq(4)').find('input[name=inputan4]');
             //  inputan4.prop('readonly', false);   
             // document.getElementById("table-dn").rows.cells[4].children[0].prop('readonly', false);

             // $('input[name=inputan4]').prop('readonly', false);
         } else {
             $("#txt_header2").prop("readonly", true);
             $("#txt_header2").val("");
             // $('#inputan4').prop('readonly', true);
             $('input[name=inputan4]').prop('readonly', true);
             $('input[name=inputan4]').val("");
         }
     }
 </script>

 <script>
     function check_dp3(checkboxElem) {
         if (checkboxElem.checked) {
             $("#txt_header3").prop("readonly", false);
         } else {
             $("#txt_header3").prop("readonly", true);
             $("#txt_header3").val("");
             ('input[name=inputan5]').prop('readonly', true);
             $('input[name=inputan5]').val("");
         }
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
    function cari_inv_memo() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("carinoinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-inv-memo");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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
<script type="text/javascript">
    function ubahnomor_dn(kode){
// alert(kode);
$('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    //Ajax Load data from ajax
    // alert(kode);
    $.ajax({
        url: "ubahnomor_dn/" + kode,
        type: "GET",
        dataType: "JSON",
        success: function (data) {

            $('[name="dn_number"]').val(data.nomor);
            // $('[name="amount"]').val(total);
            // $('[name="terbilang"]').val(bilang);
            // $('#update-kwt').modal('show'); // show bootstrap modal when complete loaded
            //
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}
</script>

<script>
  document.getElementById('profit_center_dn').addEventListener('change', function () {
    const selectedPc = this.value; // NAG atau NAK
    const input = document.getElementById('dn_number');
    let currentVal = input.value;

    console.log("Changed to:", selectedPc);
    console.log("Sebelum:", currentVal);


    // Cek dan ganti kode profit center di no_dn
    if (currentVal.includes('/NAG/')) {
      input.value = currentVal.replace('/NAG/', '/' + selectedPc + '/');
  } else if (currentVal.includes('/NAK/')) {
      input.value = currentVal.replace('/NAK/', '/' + selectedPc + '/');
  } else {
        // Jika belum ada profit center, sisipkan setelah DN
        const parts = currentVal.split('/');
        if (parts.length >= 2 && parts[0] === 'DN') {
            parts.splice(1, 0, selectedPc); // Sisipkan PC di posisi ke-2
            input.value = parts.join('/');
        }
    }
});
</script>

<script type="text/javascript">
    function confirmBack() {
    const id_debitnote = document.getElementById('id_dn').value;

    Swal.fire({
        title: 'Kembali ke daftar Debit Note?',
        text: 'Silakan pilih tindakan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Kembali & Cetak',
        cancelButtonText: 'Hanya Kembali',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Cetak dan kembali
            window.open('<?= base_url("arnag/report_invoice3/") ?>' + id_debitnote, '_blank');
            window.close();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Hanya kembali
            window.close();
        }
    });
}

</script>

