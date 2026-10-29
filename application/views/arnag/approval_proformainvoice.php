<!-- ==========================================================================
     Second Approval Proforma Invoice

     Kembaran layar First Approval - yang berbeda cuma status yang dicari dan
     fungsi yang dipanggil. Satu layar untuk semua jenis proforma: PI,
     PI NON SO, DP & CBD, dengan Amount yang mengikuti jenisnya.

     Isi tabelnya digambar cari_proforma_invoice_second_approv() di
     crud-nag.js, jadi id tabel & urutan kolomnya tidak boleh berubah. Kotak
     From & To juga dibaca dari sana lewat #filter_from / #filter_to.
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<?php $this->load->view('arnag/pi_approval_skin'); ?>

<div class="content-wrapper nag-skin">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $title; ?></h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-stamp"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end pi-filter">
            <div class="form-group col-lg-3 col-md-3 col-6 pi-f-tgl">
              <label for="filter_from">From</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_from" id="filter_from" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-6 pi-f-tgl">
              <label for="filter_to">To</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_to" id="filter_to" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-12 pi-f-aksi">
              <div class="dn-filter-aksi pi-aksi">
                <button type="button" id="find_profinvoice_post" name="find_profinvoice_post" class="btn btn-primary" onclick="cari_proforma_invoice_second_approv()"><i class="fa fa-search"></i> Search</button>
                <button type="button" id="approv_inv" name="approv_inv" class="btn btn-dn-approve" onclick="modal_show_approve_profinvoice()"><i class="fa fa-thumbs-up"></i> Approve</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Daftar -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Waiting for Second Approval</span>
            <!-- Tabelnya digambar crud-nag.js, bukan DataTables, jadi kotak
                 carinya disediakan sendiri di sini. -->
            <div class="pi-cari">
              <span class="pi-cari-ikon"><i class="fas fa-search"></i></span>
              <input type="text" id="cari_noinv" name="cari_noinv" autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_noinv()">
            </div>
          </div>
          <div class="dn-list-area">
            <div class="pi-tabel-gulung">
              <table id="table-approval-profinvoice" class="dn-table text-nowrap" width="100%">
                <thead>
                  <tr>
                    <th>No Prof Inv</th>
                    <!-- Jenisnya ikut dipajang: satu layar untuk PI, PI NON SO,
                         DP & CBD - lihat daftar Proforma Invoice. -->
                    <th>Proforma Type</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Shipp</th>
                    <th>PEB</th>
                    <th>Type</th>
                    <th>Tax Invoice No</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>ID</th>
                    <th class="dn-cek"><input type="checkbox" onchange="check_approv_profinvoice(this)" id="cek_profinv_approve" name="cek_profinv_approve"></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>


<!-- Nomor proforma bisa diklik - detailnya muncul di modal ini. -->
<?php $this->load->view('arnag/pi_detail_modal'); ?>

<!-- Modal Approved Invoice -->
<div class="modal fade" id="modal-approve-profinvoice">
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
            <label for="id_inv_approv1" class="col-sm-12 col-form-label">Approve the selected proforma invoice?</label>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="refresh_pi_second()">Approved</button>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  /** Saring baris daftar menurut nomor proformanya - kolom pertama. */
  function cari_noinv() {
    var input = document.getElementById("cari_noinv");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("table-approval-profinvoice");
    var tr = table.getElementsByTagName("tr");

    for (var i = 0; i < tr.length; i++) {
      var td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        var txtValue = td.textContent || td.innerText;
        tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
      }
    }
  }
</script>
