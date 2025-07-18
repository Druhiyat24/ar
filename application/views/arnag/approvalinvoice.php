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
                            <h3 class="card-title">List Invoice</h3>
                        </div>
                        <!-- /.card-header -->
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date Range</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation2" name="reservation2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Action</label>
                            <div class="input-group">
                                <button type="button" id="find_invoice_post" name="find_invoice_post" class="btn btn-primary" href="javascript:void(0)" onclick="cari_invoice_post()"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                    <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_noinv()">
                             </div>
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table id="table-approval-invoice" class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Inv Number</th>
                                <th>Customer</th>
                                <th>Shipp</th>
                                <th>Document Type</th>
                                <th>Document Number</th>
                                <th>Inv Date</th>
                                <th>Type</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>ID</th>
                                <th style="text-align:center"><input type="checkbox" onchange="check_approv_invoice(this)" id="cek_inv_approve" name="cek_inv_approve"></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- Button Approve -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" id="approv_inv" name="approv_inv" class="btn btn-warning" onclick="modal_show_approve_invoice()"><i class="fas fa-thumbs-up"></i> Approved</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div><!-- /.container-fluid -->
    </section>
</div>

<!-- Modal Approved Invoice -->
<div class="modal fade" id="modal-approve-invoice">
    <form>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="id_inv_approv1" class="col-sm-5 col-form-label">Approved Invoice? </label>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="refresh()">Approved</button>
                </div>
            </div>
        </div>
    </form>
</div>


    <script>
    function cari_noinv() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_noinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-approval-invoice");
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