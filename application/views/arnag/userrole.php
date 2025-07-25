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
                            <h3 class="card-title">Table User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <!-- /.card-header -->
                            <br>
                            <div class="form-group col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="cari_user" name="cari_user" required autocomplete="off" placeholder="Search for username.." onkeyup="cari_username()">
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0" style="height: 350px;">
                                <div>
                                <table id="table-user" class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Fullname</th>
                                            <th>Cek</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($data_user as $du) : ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $du['username']; ?></td>
                                                <td><?= $du['fullname']; ?></td>
                                                <td style="text-align:center"><input type="radio" name="pilih_user" id="pilih_user" class="flat" onchange="user_change('<?= $du['username']; ?>')"></td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group col-md-12">
                                    <input type="hidden" class="form-control" id="txt_username" name="txt_username" required readonly>
                                </div>
                                <button type="button" class="btn btn-success toastrDefaultSuccess" href="javascript:void(0)" onclick="save_userrole()"><i class="fa fa-save"></i> Save</button>
                                <a href="<?= base_url('arnag/userrole'); ?>" class="btn btn-info" role="button"><i class="fas fa-window-close"></i> Cancel</a>
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
                            <h3 class="card-title">Table Menu</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table id="table-menu" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <!-- <th>Cek</th> -->
                                        <th><input type="checkbox" onchange="checkallmenu(this)" id="cekmenu" name="cekmenu"></th>
                                        <th>Menu</th>
                                        <th>Base Url</th>
                                        <th>ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_menu as $dm) : ?>
                                        <tr>
                                            <td style="text-align:center"><input type="checkbox" name="pilih_menu" id="pilih_menu" class="flat"></td>
                                            <td><?= $dm['menu']; ?></td>
                                            <td><?= $dm['base_url']; ?></td>
                                            <td hidden="hidden"><?= $dm['id']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!--/.col (right) -->
            </div>

            <!-- Data Table User Access -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable User Access</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th width="20%">Username</th>
                                <th width="30%">Menu</th>
                                <th width="35%">Base Url</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_user_access as $ua) : ?>
                                <tr>
                                    <td><?= $ua['user']; ?></td>
                                    <td><?= $ua['menu']; ?></td>
                                    <td><?= $ua['base_url']; ?></td>
                                    <td style="text-align: center;"><a href ="<?= base_url() ?>arnag/hapus/<?= $ua['id'] ?>" class="btn btn-danger">Hapus</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    function cari_username() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_user");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-user");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
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

