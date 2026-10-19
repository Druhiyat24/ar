<!-- ==========================================================================
     List Proforma Invoice
     Tampilannya mengikuti List Invoice (skin .nag-skin di dn_skin.php):
     kartu filter di atas, lalu kartu tabel.

     Isi tabelnya tetap digambar cari_proforma_invoice() di crud-nag.js, jadi
     id tabel & urutan kolomnya tidak boleh berubah.
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<style type="text/css">
/* Warna tombol mengikuti List Invoice. */
.nag-skin .btn-dn-create {
  background: linear-gradient(135deg, #38bdf8, #0ea5e9) !important;
  border: none !important;
  color: #fff !important;
}
.nag-skin .btn-dn-excel {
  background: linear-gradient(135deg, #15803d, #16a34a) !important;
  border: none !important;
  color: #fff !important;
}
/* header.php membuang margin .form-group di .row.align-items-end, jadi jarak
   baris tombolnya diberi di sini. */
.nag-skin .pi-aksi { margin-top: 12px; }
@media (min-width: 1280px) {
  /* Di layar lebar semuanya muat satu baris: Customer tidak ikut melar
     mengisi sisa ruang, tombolnya menempel di sebelah tanggal To. */
  .nag-skin .pi-filter > .pi-f-customer { flex: 0 1 28%; max-width: 420px; min-width: 220px; }
  .nag-skin .pi-filter > .pi-f-tgl { flex: 0 0 16%; max-width: 16%; }
  .nag-skin .pi-filter > .pi-f-aksi { flex: 0 0 auto; width: auto; max-width: none; }
  .nag-skin .pi-filter .pi-aksi { margin-top: 0; flex-wrap: nowrap; }
}

/* ===== Ukuran "sm" =====
   Filter, select2, dan tombol dibuat 31px, bukan 38px bawaan skin DN.
   !important dipakai karena templates/header.php mengunci tinggi, padding, dan
   font .form-control / .btn / .select2-selection secara global. */
.nag-skin .card-body .form-control,
.nag-skin .card-body .select2-container .select2-selection--single,
.nag-skin .card-body .input-group-text,
.nag-skin .pi-aksi .btn {
  height: 31px !important;
  font-size: 12.5px !important;
  border-radius: 6px !important;
}
.nag-skin .card-body .form-control { padding: 3px 10px !important; }
.nag-skin .card-body .input-group > .form-control { border-radius: 6px 0 0 6px !important; }
.nag-skin .card-body .input-group-text { padding: 0 10px !important; border-radius: 0 6px 6px 0 !important; }
.nag-skin .card-body .select2-container .select2-selection--single .select2-selection__rendered {
  line-height: 29px;
  padding-left: 10px;
  font-size: 12.5px;
}
.nag-skin .card-body .select2-container .select2-selection--single .select2-selection__arrow { height: 29px; }
.nag-skin .pi-aksi .btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 0 12px !important;
}
.nag-skin .pi-aksi .btn i { font-size: 11.5px; }
/* Isi dropdown select2 ikut mengecil - dropdown-nya dititipkan ke <body>, jadi
   tidak bisa di-scope ke .nag-skin (aman, gaya ini cuma dimuat di sini). */
.select2-container--bootstrap4 .select2-results__option,
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field { font-size: 12.5px; }

/* Tombol di kolom Action - digambar crud-nag.js, jadi ukurannya diatur dari
   sini, bukan dari kelas di tombolnya. */
.nag-skin #table-list-proforma-invoice .btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  height: 27px;
  padding: 0 10px !important;
  font-size: 11.5px !important;
  border-radius: 6px !important;
}
.nag-skin #table-list-proforma-invoice .btn i { font-size: 10.5px; }

/* Dialog Swal - gayanya disamakan dengan layar Proforma Invoice. Dipasang ke
   .swal2-popup langsung karena dialognya dipanggil dari crud-nag.js yang
   dipakai bareng layar lain; berkas gaya ini cuma dimuat di sini. */
.swal2-popup { border-radius: 14px; }
.swal2-popup .swal2-title { color: #1e3a5f; font-size: 19px; }
.swal2-popup .swal2-html-container { font-size: 13.5px; }
.swal2-popup .swal2-icon.swal2-question,
.swal2-popup .swal2-icon.swal2-warning { border-color: #1e3a5f !important; color: #1e3a5f !important; }
.swal2-popup .swal2-styled {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  min-width: 104px;
  height: 34px;
  padding: 0 16px !important;
  border-radius: 6px !important;
  font-size: 12.5px !important;
  font-weight: 600;
  line-height: 1;
}
.swal2-popup .swal2-confirm { background: #1e3a5f !important; border-color: #1e3a5f !important; }
.swal2-popup .swal2-confirm:hover { filter: brightness(.92); }
.swal2-popup .swal2-cancel { background: #f1f5f9 !important; color: #334155 !important; border-color: #f1f5f9 !important; }
.swal2-popup .swal2-cancel:hover { background: #e2e8f0 !important; }
</style>

<div class="content-wrapper nag-skin">
  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-filter"></i>Filter</h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end pi-filter">
            <div class="form-group col-lg-2 col-md-3 pi-f-tipe">
              <label for="list_prof_tipe">Proforma Type</label>
              <!-- Saringan di layar saja - daftarnya tetap diambil utuh,
                   jadi menggantinya tidak perlu menunggu server. -->
              <select class="form-control select2bs4" id="list_prof_tipe" name="list_prof_tipe">
                <option value="">All Type</option>
                <option value="PI">PI</option>
                <option value="PI NON SO">PI NON SO</option>
                <option value="DP">DP</option>
                <option value="CBD">CBD</option>
              </select>
            </div>
            <div class="form-group col-lg-3 col-md-6 pi-f-customer">
              <label for="list_prof_customer">Customer</label>
              <select class="form-control select2bs4" id="list_prof_customer" name="list_prof_customer">
                <option value="all_customer">All Customer</option>
                <?php foreach ($customer as $cs) : ?>
                  <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
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
                <button type="button" id="find_invoice_pi" name="find_invoice_pi" class="btn btn-primary" onclick="cari_proforma_invoice()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-dn-create" onclick="location.href='<?= base_url('arnag/proformainvoice'); ?>'"><i class="fas fa-plus"></i> Create</button>
                <button type="button" class="btn btn-dn-excel" onclick="export_list_pi()"><i class="fas fa-file-excel"></i> Export</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Daftar Proforma Invoice -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Data Proforma Invoice</span>
          </div>
          <div class="dn-list-area">
            <table id="table-list-proforma-invoice" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>No Prof Inv</th>
                  <!-- Satu daftar untuk empat jenis: PI, PI NON SO, DP, CBD.
                       Menu DP & CBD yang lama tidak diperlukan lagi. -->
                  <th>Proforma Type</th>
                  <th>Date</th>
                  <th>Customer</th>
                  <th>Shipp</th>
                  <th>Peb</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Faktur Pajak</th>
                  <th class="text-right">Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Modal Update Faktur Pajak -->
<div class="modal fade dn-modal nag-skin" id="modal-update-faktur-pjk" tabindex="-1" role="dialog" aria-hidden="true">
  <form action="<?= base_url('arnag/update_faktur_pajak'); ?>" method="POST">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-receipt"></i> Update Faktur Pajak</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_inv_prof" id="id_inv_prof" required readonly>
          <div class="form-group mb-0">
            <label for="no_paktur_pjk">Faktur Pajak Number</label>
            <input type="text" class="form-control" id="no_paktur_pjk" name="no_paktur_pjk" autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Update</button>
        </div>
      </div>
    </div>
  </form>
</div>
