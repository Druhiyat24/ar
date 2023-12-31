<!-- Content Wrapper. Contains page content -->

<style type="text/css">
table {
  height: 100%;
  border-collapse: collapse;
  width: 100%;
  margin: 10px;
}

thead {
  position: sticky;
  top: 0;
  background: #eee;
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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Cek </h3>
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
                                                <input type="text" class="form-control float-right" id="cobacoba" name="cobacoba">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Action</label>
                                        <div class="input-group">
                                            <button type="button" id="find_invoice" name="find_invoice" class="btn btn-primary" href="javascript:void(0)" onclick="cari_kartu_ar2()"><i class="fa fa-search"></i>  Search</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Export Data</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-info" onclick="export_kartu_ar2()"><i class="fa fa-download"></i> Export To Excel</button>
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
                            <h3 class="card-title">DataTable Kartu AR Detail</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                           <div class="ml-auto">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                                <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search no invoice..." onkeyup="cari_noinvoice()">
                             </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 400px;">
                            <table id="table-kartu_ar2" class="table table-bordered table-head-fixed text-nowrap">
                                <thead >
                                    <tr>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Customer</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;"> No Invoice</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Invoice Date</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Category</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Due Date</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">TOP</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Curr</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Rate</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Beginning Balance</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Addition</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Deduction</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Ending Balance</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Equivalent IDR</th>
                                        <th colspan="9" style="text-align: center;vertical-align: middle;">Receivable Aging Based on Due Date</th>
                                        <th rowspan="2" style="text-align: center;vertical-align: middle;"></th>
                                        <th colspan="8" style="text-align: center;vertical-align: middle;">Receivable Due Date Projection</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;vertical-align: middle;">Not Due</th>
                                        <th style="text-align: center;vertical-align: middle;">1-30</th>
                                        <th style="text-align: center;vertical-align: middle;">31-60</th>
                                        <th style="text-align: center;vertical-align: middle;">61-90</th>
                                        <th style="text-align: center;vertical-align: middle;">91-120</th>
                                        <th style="text-align: center;vertical-align: middle;">121-180</th>
                                        <th style="text-align: center;vertical-align: middle;">181-360</th>
                                        <th style="text-align: center;vertical-align: middle;">>360</th>
                                        <th style="text-align: center;vertical-align: middle;">Total</th>

                                        <th style="text-align: center;vertical-align: middle;">Already Due</th>
                                        <th style="text-align: center;vertical-align: middle;width: auto;"><input type="text" class="form-control" id="bulan_1" name="bulan_1" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;width: 150px;margin-left: 0;margin-right: 0;background: #eee;" placeholder="" readonly></th>
                                        <th style="text-align: center;vertical-align: middle;"><input type="text" class="form-control" id="bulan_2" name="bulan_2" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;width: 150px;margin-left: 0;margin-right: 0;background: #eee;" placeholder="" readonly></th>
                                        <th style="text-align: center;vertical-align: middle;"><input type="text" class="form-control" id="bulan_3" name="bulan_3" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;width: 150px;margin-left: 0;margin-right: 0;background: #eee;" placeholder="" readonly></th>
                                        <th style="text-align: center;vertical-align: middle;"><input type="text" class="form-control" id="bulan_4" name="bulan_4" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;width: 150px;margin-left: 0;margin-right: 0;background: #eee;" placeholder="" readonly></th>
                                        <th style="text-align: center;vertical-align: middle;"><input type="text" class="form-control" id="bulan_5" name="bulan_5" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;width: 150px;margin-left: 0;margin-right: 0;background: #eee;" placeholder="" readonly></th>
                                        <th style="text-align: center;vertical-align: middle;"><input type="text" class="form-control" id="bulan_6" name="bulan_6" style="border: none;border-color: transparent;outline: none;text-align: center;background-color: white;font-weight: bold;text-transform: capitalize;color: black;width: 150px;margin-left: 0;margin-right: 0;background: #eee;" placeholder="" readonly></th>
                                        <th style="text-align: center;vertical-align: middle;">Total</th>
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

<div class="modal fade" id="modal-cancel-inv">
    <form action="<?= base_url('arnag/cancel_invoice'); ?>" method="POST">
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
                        <label for="id_inv" class="col-sm-5 col-form-label">Sure Cancel List Invoice :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="txt_cancel_book" name="txt_cancel_book" style="border:none;" readonly>
                        </div>
                    </div>
                    <!-- Hidden Text -->
                    <input type="hidden" id="id_book_inv" name="id_book_inv" readonly>
                    <input type="hidden" id="id_bppb" name="id_bppb" readonly>
                    <input type="hidden" id="user" name="user" value="<?= $user['username']; ?>" readonly>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php $data = $user['username'];
                    if ($data == 'willy' || $data == 'yulianto' || $data == 'hady' || $data == 'hadi' || $data == 'jefri' || $data == 'ramon' || $data == 'lukman' || $data == 'oktora' || $data == 'oktora malau') 
                    {
                        echo '<button type="submit" class="btn btn-primary toastsDefaultDanger">Cancel Invoice</button>';
                     } else {
                    echo '<button type="button" disabled class="btn btn-primary toastsDefaultDanger">Cancel Invoice</button>';
                }
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Invoice Detail -->
<div class="modal fade" id="modal-inv-detail">
    <div class=" modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invoice Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Datatable Invoice Detail -->
                <div class="form-group">
                    <div class="col-md-4">
                        <label>Invoice Number</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="inv_number_list" name="inv_number_list" readonly>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 400px;">
                            <table id="table-inv-detail" class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>SO Number</th>
                                        <th>Bppb Number</th>
                                        <th>Shipping Number</th>
                                        <th>WS#</th>
                                        <th>Styleno</th>
                                        <th>Product Group</th>
                                        <th>Product Item</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Curr</th>
                                        <th>UOM</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Discount (%)</th>
                                        <th>Total Price</th>
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
                <!-- Datatable Potongan Invoice  -->
                <div class="row" style="display: flex; justify-content: flex-end">
                    <div class="col-md-6">
                        <!-- Form Element sizes -->
                        <div class="card card-success">
                            <div class="card-body">
                                <!-- Start Input -->
                                <form class="form-horizontal">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="mdl_total_det" class="col-sm-4 col-form-label">Total</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_total_det" name="mdl_total_det" style="text-align:right;" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mdl_discount_det" class="col-sm-4 col-form-label">Discount</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_discount_det" name="mdl_discount_det" style="text-align:right;" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mdl_dp_det" class="col-sm-4 col-form-label">Down Payment</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_dp_det" name="mdl_dp_det" style="text-align:right;" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mdl_return_det" class="col-sm-4 col-form-label">Return</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_return_det" name="mdl_return_det" style="text-align:right;" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mdl_twot_det" class="col-sm-4 col-form-label">Total With Out Tax</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_twot_det" name="mdl_twot_det" style="text-align:right;" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mdl_vat_det" class="col-sm-4 col-form-label">VAT</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_vat_det" name="mdl_vat_det" style="text-align:right;" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mdl_grandtotal_det" class="col-sm-4 col-form-label">Grand Total</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mdl_grandtotal_det" name="mdl_grandtotal_det" style="text-align:right;" placeholder="0.00" readonly>
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
                <div class="modal-footer right-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
    function cari_noinvoice() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_noinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-kartu_ar2");
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

<script type="text/javascript">
    $(document).ready(function () {
    let statusCard = document.querySelector('#table-kartu_ar2');
    // add scroll event listener for change head's position 
    statusCard.addEventListener('scroll',e =>{
      let tableHead = document.querySelector('thead');
      let scrollTop =  statusCard.scrollTop;
      tableHead.style.transform = 'translateY(' + scrollTop + 'px)';
});
});
</script>
