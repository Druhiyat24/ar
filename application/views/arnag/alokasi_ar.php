<!-- ==========================================================================
     List Alokasi
     Tampilannya mengikuti menu List Invoice (skin .nag-skin di dn_skin.php):
     kartu filter di atas, lalu kartu tabel dengan loader & DataTables.
     Nomor alokasinya diklik untuk membuka modal detail (alo_detail_modal).
     Data tabelnya diisi alo_list_cari() di crud-nag.js.
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<?php $this->load->view('arnag/_ukuran_sm'); ?>
<style type="text/css">
/* Khusus halaman List Alokasi - warna tombol mengikuti List Invoice. */
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

/* Filter + tombol satu baris di layar lebar: Customer tidak ikut melar
   mengisi sisa ruang, tombolnya menempel di sebelah tanggal To. */
.nag-skin .alo-aksi { margin-top: 12px; }
@media (min-width: 1280px) {
  .nag-skin .alo-filter > .alo-f-customer { flex: 0 1 26%; max-width: 380px; min-width: 220px; }
  .nag-skin .alo-filter > .alo-f-status { flex: 0 0 14%; max-width: 14%; }
  .nag-skin .alo-filter > .alo-f-tgl { flex: 0 0 16%; max-width: 16%; }
  .nag-skin .alo-filter > .alo-f-aksi { flex: 0 0 auto; width: auto; max-width: none; }
  .nag-skin .alo-filter .alo-aksi { margin-top: 0; flex-wrap: nowrap; }
}
.nag-skin .alo-aksi .btn { padding: 0 12px !important; }
.nag-skin .alo-aksi .btn i { font-size: 11.5px; }

/* ---- Kolom Alokasi Number ----
   Nomornya jelas bisa diklik - itu pintu ke modal detailnya. */
.nag-skin .dn-no-link {
  color: #1d4ed8;
  font-size: 13.5px;
  font-weight: 600;
  cursor: pointer;
  text-decoration: none;
  border-bottom: 1px dashed rgba(29, 78, 216, .45);
}
.nag-skin .dn-no-link:hover { color: #1e3a5f; border-bottom-style: solid; }
.nag-skin .dn-no-link:focus-visible { outline: 0; box-shadow: 0 0 0 3px rgba(44, 82, 130, .45); border-radius: 6px; }

/* ---- Kolom Created By ----
   Nama pembuatnya di atas, tanggalnya di bawah dengan warna lebih redup. */
#alo-list-area .alo-dibuat { display: flex; flex-direction: column; line-height: 1.25; }
#alo-list-area .alo-dibuat b { font-weight: 600; }
#alo-list-area .alo-dibuat small { color: #94a3b8; font-size: 10.5px; font-variant-numeric: tabular-nums; }
#alo-list-area .alo-kosong { color: #cbd5e1; }

/* DataTables menghitung lebar kolom dari isinya. Kalau hitungannya jatuh
   waktu kartunya masih sempit (sidebar baru dipasang), tabelnya tetap
   sempit walau kartunya sudah melebar - sisanya kosong dengan garis
   menggantung di kanan. Jadi tabelnya dipatok minimal selebar kartunya;
   kalau isinya lebih lebar, ia tetap melebar dan bisa digeser. */
#alo-list-area .dataTables_scrollHeadInner,
#alo-list-area .dataTables_scrollHeadInner > table,
#alo-list-area .dataTables_scrollBody > table { min-width: 100% !important; }

/* Kolom uang rata kanan & digitnya sejajar. */
#alo-list-area .dn-table td.dn-angka,
#alo-list-area .dn-table th.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
#alo-list-area .dn-table td.dn-tengah,
#alo-list-area .dn-table th.dn-tengah { text-align: center; }
/* Kolom Action berisi tombol - rata kiri supaya tombol yang sama selalu
   jatuh di tempat yang sama, walau jumlah tombolnya beda per baris. */
#alo-list-area .dn-table td:last-child { text-align: left; }
</style>

<div class="content-wrapper nag-skin ci-sm">
  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-hand-holding-usd"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end alo-filter">
            <div class="form-group col-lg-4 col-md-6 alo-f-customer">
              <label for="customer">Customer</label>
              <select class="form-control select2bs4" id="customer" name="customer">
                <option value="all_customer">All Customer</option>
                <?php foreach ($customer as $cs) : ?>
                  <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-6 alo-f-status">
              <label for="status">Status</label>
              <!-- Statusnya disaring di layar ini saja - datanya sudah ada,
                   tidak perlu menembak ulang ke server. -->
              <select class="form-control select2bs4" id="status" name="status">
                <option value="all_status">ALL</option>
                <option value="POST">POST</option>
                <option value="CANCEL">CANCEL</option>
              </select>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-6 alo-f-tgl">
              <label for="filter_from">From</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_from" id="filter_from" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-6 alo-f-tgl">
              <label for="filter_to">To</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_to" id="filter_to" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-12 alo-f-aksi">
              <div class="dn-filter-aksi alo-aksi">
                <button type="button" id="find_alokasi" name="find_alokasi" class="btn btn-primary" onclick="alo_list_cari()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-dn-create" onclick="location.href='<?= base_url('arnag/create_alokasi'); ?>'"><i class="fas fa-plus"></i> Create</button>
                <button type="button" class="btn btn-dn-excel" onclick="export_list_alokasi()"><i class="fas fa-file-excel"></i> Export</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Daftar Alokasi -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Data Alokasi</span>
          </div>
          <div class="dn-list-area" id="alo-list-area">
            <div class="nag-loader-overlay" id="alo-list-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Memuat data...</div>
              </div>
            </div>
            <table id="table-alokasi" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr>
                  <th>Alokasi Number</th>
                  <th>Alokasi Date</th>
                  <th>Customer</th>
                  <th>Doc Number</th>
                  <th>Bank</th>
                  <th>Account</th>
                  <th>Curr</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th>Equivalent IDR</th>
                  <th>Created By</th>
                  <th>Status</th>
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

<script>
  // Alamat layar Create - dipakai tombol Create & tombol Back di layar itu.
  var ALO_URL_LIST = <?= json_encode(base_url('arnag/alokasi_ar')); ?>;

  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      // Tabelnya disiapkan sejak halaman dibuka: kotak Search, pilihan jumlah
      // baris, dan pesan "belum ada data" sudah ada sebelum Search ditekan.
      alo_list_dt();
      alo_list_pulihkan();
    });
  });
</script>

<!-- Cancel Alokasi: konfirmasinya pakai Swal (di crud-nag.js), tapi
     kirimannya tetap POST biasa lewat form ini - alur di servernya
     tidak berubah sama sekali. -->
<form id="alo-form-cancel" action="<?= base_url('arnag/cancel_alokasi'); ?>" method="POST" style="display:none;">
  <input type="hidden" id="id_book_inv" name="id_book_inv">
  <input type="hidden" id="txt_cancel_book" name="txt_cancel_book">
  <input type="hidden" id="id_bppb" name="id_bppb">
  <input type="hidden" id="user" name="user" value="<?= $user['username']; ?>">
</form>

<?php
// Modal detail Alokasi - dibuka dengan mengklik nomor alokasinya.
$this->load->view('arnag/alo_detail_modal');
?>
