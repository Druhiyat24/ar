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
                        <form action="<?= base_url('arnag/simpan_master_top'); ?>" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select class="form-control select2bs4" id="customer" name="customer" required>
                                            <?php foreach ($customer as $cs) : ?>
                                                <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" id="top" name="top" onchange="topSelect()" required>
                                            <option value="TOP">TOP</option>
                                            <option value="CASH">CASH</option>
                                            <option value="TRANSFER">TRANSFER</option>
                                            <option value="COD">COD</option>
                                            <option value="LC">LC</option>
                                            <option value="SKBDN">SKBDN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txtop" id="lbtop">TOP</label>
                                    <input type="text" class="form-control" id="txtop" name="txtop" onkeypress="javascript:return isNumber(event)">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success toastrDefaultSuccess"><i class="fa fa-save"></i> Submit</button>
                                <a href="<?= base_url('arnag'); ?>" class="btn btn-info" role="button">Refresh</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                    <!-- Form Element sizes -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Table TOP</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Customer</th>
                                        <th>Type</th>
                                        <th style="width: 40px">Top</th>
                                        <th>Status</th>
                                        <th style="width: 50px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($master_top as $mt) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $mt['customer']; ?></td>
                                            <td><?= $mt['type']; ?></td>
                                            <td><?= $mt['top']; ?></td>
                                            <td><?= $mt['status']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-edit<?= $mt['id']; ?>">Edit</button>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Confirm Edit Data -->
<?php foreach ($master_top as $mt) : ?>
    <div class="modal fade" id="modal-edit<?= $mt['id']; ?>">
        <form action="<?= base_url('arnag/edit_master_top'); ?>" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Edit Master TOP Active / Non Active  -->
                        <input type="hidden" name="id_top" value="<?= $mt['id']; ?>">
                        <div class="form-group col-md-12">
                            <label>Customer</label>
                            <input type="text" class="form-control" id="cust_mdl" name="cust_mdl" value="<?= $mt['customer']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Type</label>
                            <input type="text" class="form-control" id="type_mdl" name="type_mdl" value="<?= $mt['type']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Top</label>
                            <input type="text" class="form-control" id="top_mdl" name="top_mdl" value="<?= $mt['top']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Status</label>
                            <select id="status_mdl" name="status_mdl" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Non Active">Non Active</option>
                            </select>
                        </div>
                        <!--  -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary toastsDefaultDanger">Edit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php endforeach; ?>

<!-- Jenis TOP -->
<script>
    function topSelect() {
        $("#txtop").val("");
        var x = document.getElementById("top").value;
        if (x == "TOP") {
            document.getElementById("lbtop").style.visibility = "visible";
            document.getElementById("txtop").style.visibility = "visible";
        }else if (x == "SKBDN") {
            document.getElementById("lbtop").style.visibility = "visible";
            document.getElementById("txtop").style.visibility = "visible";
        }else if (x == "LC") {
            document.getElementById("lbtop").style.visibility = "visible";
            document.getElementById("txtop").style.visibility = "visible";
        } else {
            document.getElementById("lbtop").style.visibility = "hidden";
            document.getElementById("txtop").style.visibility = "hidden";
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