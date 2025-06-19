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
                            <h3 class="card-title">Cek Alokasi</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Customer</label>
                                        <select class="form-control select2bs4" id="customer" name="customer">
                                            <option value="all_customer">All Customer</option>
                                            <?php foreach ($customer as $cs) : ?>
                                                <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
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

                                    <div class="form-group">
                                        <label>Action</label>
                                        <div class="input-group">
                                            <button type="button" id="find_invoice" name="find_invoice" class="btn btn-primary" href="javascript:void(0)" onclick="cari_alokasi()"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                   <div class="col-md-3">
                                        <label>Export Data</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-info" onclick="export_list_alokasi()"><i class="fa fa-download"></i> Export To Excel</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>

            <!-- Data Table List Invoice -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Alokasi</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cari_nokwt" name="cari_nokwt" required autocomplete="off" placeholder="Search No Alokasi.." onkeyup="cari_kwt()">
                             </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 400px;">
                            <table id="table-kwitansi" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Alokasi Number</th>
                                        <th style="text-align: center;">Alokasi Date</th>
                                        <th style="text-align: center;">Customer</th>
                                        <th style="text-align: center;">Doc Number</th>
                                        <th style="text-align: center;">Bank</th>
                                        <th style="text-align: center;">Account</th>
                                        <th style="text-align: center;">Curr</th>
                                        <th style="text-align: center;">Rate</th>
                                        <th style="text-align: center;">Amount</th>
                                        <th style="text-align: center;">Equivalent IDR</th>
                                        <th style="text-align: center;">Create Date</th>
                                        <th style="text-align: center;">Create By</th>
                                        <th style="text-align: center;">Action</th>
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
</div>

<!-- Modal Update Booking Invoice -->
<div class="modal fade" id="update-kwt">
    <form action="<?= base_url('arnag/update_tbl_kwitansi'); ?>" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Update</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Update Document Number dan type -->
                    <div class="form-group col-md-12">
                        <label>Kwitansi Number</label>
                        <input type="text" class="form-control" id="no_kwt" name="no_kwt" readonly>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" min="0" autocomplete="off" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Terbilang</label>
                        <textarea type="text" class="form-control" id="terbilang" name="terbilang"></textarea>
                        <!-- <input type="text" class="form-control" id="terbilang" name="terbilang"> -->
                    </div>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modal-cancel-kwt">
    <form action="<?= base_url('arnag/cancel_kwitansi'); ?>" method="POST">
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
                        <label for="id_inv" class="col-sm-5 col-form-label">Sure Cancel Kwitansi:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="txt_cancel_book" name="txt_cancel_book" style="border:none;" readonly>
                        </div>
                    </div>
                    <!-- Hidden Text -->
                    <input type="hidden" id="id_kwitansi" name="id_kwitansi" readonly>
                    <input type="hidden" id="id_bppb" name="id_bppb" readonly>
                    <input type="hidden" id="user" name="user" value="<?= $user['username']; ?>" readonly>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php $data = $user['username'];
                    if ($data == 'willy' || $data == 'yulianto' || $data == 'hady' || $data == 'hadi' || $data == 'jefri' || $data == 'ramon' || $data == 'lukman' || $data == 'oktora' || $data == 'oktora malau') 
                    {
                        echo '<button type="submit" class="btn btn-primary toastsDefaultDanger">Cancel Kwitansi</button>';
                     } else {
                    echo '<button type="button" disabled class="btn btn-primary toastsDefaultDanger">Cancel Kwitansi</button>';
                }
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modal-view-kwt">
    <form >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" >Data Kwitansi <input type="text" style="background-color: white; border: none; font-size: 18px;" class="form-control" id="txt_view" name="txt_view" style="border:none;" readonly></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table id="table-view-kwt" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>COA</th>
                                        <th>Cost Center</th>
                                        <th>Customer</th>
                                        <th>Ref Number</th>
                                        <th>Ref Date</th>
                                        <th>Due Date</th>
                                        <th>Curr</th>
                                        <th>Total</th>
                                        <th>Amount</th>
                                        <th>Outstanding</th>
                                        <th>Descriptions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Update Booking Invoice -->
<div class="modal fade" id="update-inv-style">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Update</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Update Document Number dan type -->
                    <div class="form-group col-md-12">
                        <!-- <label>Kwitansi Number</label> -->
                        <input type="hidden" class="form-control" id="id" name="id" readonly>
                    </div>

                    <div class="form-group col-md-12">
                        <label>No Invoice</label>
                        <input type="text" class="form-control" id="no_inv" name="no_inv" min="0" autocomplete="off" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Style</label>
                        <textarea type="text" class="form-control" id="style" name="style"></textarea>
                        <!-- <input type="text" class="form-control" id="terbilang" name="terbilang"> -->
                    </div>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary toastrDefaultSuccess" onclick="update_style2()">Update</button>
                </div>
            </div>
        </div>
</div>

    <script>
    function cari_kwt() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_nokwt");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-kwitansi");
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
