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
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Debit Note List</h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="col-md-3">
                        <div class="input-group">
                            <button type="button" id="add_debitnote" name="add_debitnote" class="btn btn-primary" data-toggle="modal" data-target="#modal-debit-note"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table id="table-debitnote" class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DN Number</th>
                                <th>Customer</th>
                                <th>Doc Date</th>
                                <th>Coa</th>
                                <th>Value</th>
                                <th>Desc</th>
                                <th>Duedate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($load_debitnote as $dn) : ?>
                                <tr>
                                    <td><?= $dn['id']; ?></td>
                                    <td><?= $dn['no_debitnote']; ?></td>
                                    <td><?= $dn['customer']; ?></td>
                                    <td><?= $dn['doc_date']; ?></td>
                                    <td><?= $dn['coa']; ?></td>
                                    <td align="right"><?= $dn['value_']; ?></td>
                                    <td><?= $dn['description']; ?></td>
                                    <td><?= $dn['duedate']; ?> Days</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-cancel-debitnote<?= $dn['id']; ?>">Cancel</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

<!-- Modal Add Debit Note -->
<div class="modal fade" id="modal-debit-note">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Insert Debit Note</h4>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-12">
                    <label>Debit Note Number</label>
                    <input type="text" class="form-control" id="dn_number" name="dn_number" value="<?= $kode_debitnote; ?>" readonly>
                </div>
                <div class="form-group col-md-12">
                    <label>Customer</label>
                    <select class="form-control select2bs4" id="dn_customer" name="dn_customer" required>
                        <?php foreach ($customer as $cs) : ?>
                            <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Document Date :</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="doc_date" id="doc_date" autocomplete="off">
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label>Coa :</label>
                    <input type="text" class="form-control" id="dn_coa" name="dn_coa" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                    <label>Description :</label>
                    <input type="text" class="form-control" id="dn_desc" name="dn_desc" autocomplete="off">
                </div>
                <div class="form-group col-md-12">
                    <label>Duedate :</label>
                    <input type="text" class="form-control" id="dn_duedate" name="dn_duedate" autocomplete="off" onkeypress="javascript:return isNumber(event)">
                </div>
                <div class="form-group col-md-12">
                    <label>Value :</label>
                    <input type="text" class="form-control" id="dn_value" name="dn_value" autocomplete="off" onkeypress="javascript:return isNumber(event)">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal" href="javascript:void(0)" onclick="reload_page_debitnote()">Cancel</button>
                <button type="button" class="btn btn-primary toastrDefaultSuccess" href="javascript:void(0)" onclick="save_debitnote()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cancel DueDate -->
<?php foreach ($load_debitnote as $dn) : ?>
    <div class="modal fade" id="modal-cancel-debitnote<?= $dn['id']; ?>">
        <form action="<?= base_url('arnag/cancel_debitnote'); ?>" method="POST">
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
                        <p>Are you sure cancel Debitnote : <?= $dn['no_debitnote']; ?> ?</p>
                        <input type="hidden" id="id_modal_dn" name="id_modal_dn" value="<?= $dn['id']; ?>" readonly>
                        <!--  -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary toastsDefaultDanger">Cancel Debitnote</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php endforeach; ?>

<!-- Only Input Number In Text -->
<script>
    function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;
        return true;
    }
</script>