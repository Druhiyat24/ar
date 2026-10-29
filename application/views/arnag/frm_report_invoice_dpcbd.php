<!-- ==========================================================================
     Report Proforma Invoice
     Tampilannya mengikuti menu List Invoice / Alokasi (skin .nag-skin di
     dn_skin.php): kartu filter di atas, lalu kartu tabel dengan loader &
     DataTables, dan jumlah per mata uang di bawahnya.

     Isinya diambil mpi_cari() di crud-nag.js lewat arnag/mutasi_pi_json -
     sumbernya PI yang sekarang (tbl_invoice_proforma) dan potongannya dari
     alokasi. Hitungan saldonya di SQL, bukan di browser.
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<?php $this->load->view('arnag/_ukuran_sm'); ?>
<style type="text/css">
/* Tombol unduh - warnanya sama dengan Export di menu lain. */
.nag-skin .btn-dn-excel {
  background: linear-gradient(135deg, #15803d, #16a34a) !important;
  border: none !important;
  color: #fff !important;
}

.nag-skin .mpi-aksi { margin-top: 12px; }
@media (min-width: 1280px) {
  .nag-skin .mpi-filter > .mpi-f-customer { flex: 0 1 28%; max-width: 420px; min-width: 240px; }
  .nag-skin .mpi-filter > .mpi-f-tgl { flex: 0 0 16%; max-width: 16%; }
  .nag-skin .mpi-filter > .mpi-f-aksi { flex: 0 0 auto; width: auto; max-width: none; }
  .nag-skin .mpi-filter .mpi-aksi { margin-top: 0; flex-wrap: nowrap; }
}
.nag-skin .mpi-aksi .btn { padding: 0 12px !important; }
.nag-skin .mpi-aksi .btn i { font-size: 11.5px; }

/* Kolom angka rata kanan & digitnya sejajar. */
#mpi-list-area .dn-table td.dn-angka,
#mpi-list-area .dn-table th.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
#mpi-list-area .dn-table td.dn-tengah,
#mpi-list-area .dn-table th.dn-tengah { text-align: center; }
/* Angka Deduction bisa diklik - di balik angkanya ada daftar alokasinya. */
.nag-skin .mpi-ded-link {
  color: #1d4ed8;
  font-weight: 600;
  cursor: pointer;
  border-bottom: 1px dashed rgba(29, 78, 216, .45);
}
.nag-skin .mpi-ded-link:hover { color: #1e3a5f; border-bottom-style: solid; }
.nag-skin .mpi-ded-link:focus-visible { outline: 0; box-shadow: 0 0 0 3px rgba(44, 82, 130, .45); border-radius: 6px; }

/* ---- Modal rincian Deduction ---- */
#modal-mpi-ded .modal-body { background: #f8fafc; }
#modal-mpi-ded .modal-title { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.nag-skin .mpi-ded-kepala {
  display: flex; flex-wrap: wrap; gap: 1px; margin-bottom: 14px;
  background: #eef2f7; border: 1px solid #eef2f7; border-radius: 10px; overflow: hidden;
}
.nag-skin .mpi-ded-kepala > div { flex: 1 1 200px; padding: 9px 12px; background: #fff; min-width: 0; }
.nag-skin .mpi-ded-label {
  font-size: 10.5px; font-weight: 700; letter-spacing: .4px;
  text-transform: uppercase; color: #94a3b8; margin-bottom: 3px;
}
.nag-skin .mpi-ded-isi { font-size: 13px; font-weight: 600; color: #1e293b; overflow-wrap: anywhere; }
.nag-skin .mpi-ded-isi.is-angka { font-variant-numeric: tabular-nums; }
#modal-mpi-ded .ci-table-wrap { background: #fff; max-height: 320px; }
#modal-mpi-ded .dn-table td { font-size: 12px; }
#modal-mpi-ded .dn-table td:nth-child(7),
#modal-mpi-ded .dn-table td:nth-child(8),
#modal-mpi-ded .dn-table th:nth-child(7),
#modal-mpi-ded .dn-table th:nth-child(8) { text-align: right; font-variant-numeric: tabular-nums; }
/* Kolom terakhir berisi data, bukan tombol - jangan dikunci ke kanan. */
#modal-mpi-ded .dn-table tbody td:last-child,
#modal-mpi-ded .dn-table thead th:last-child {
  position: static; right: auto; z-index: auto; box-shadow: none;
}
#modal-mpi-ded .dn-table tfoot td {
  background: #f8fafc; font-weight: 700; color: #0f172a; border-top: 2px solid #e2e8f0;
}
/* Penanda asal uangnya. */
.nag-skin .dn-badge.mpi-sumber-bank { background: #dcfce7; color: #166534; }
.nag-skin .dn-badge.mpi-sumber-memorial { background: #fef3c7; color: #92400e; }
.nag-skin .mpi-ded-kosong { padding: 26px 0; text-align: center; color: #94a3b8; font-size: 12px; }

/* Penanda DP / CBD / PI NON SO. */
.nag-skin .dn-badge.mpi-tipe { background: #e0f2fe; color: #075985; }
/* ---- Baris jumlah di kaki tabel ---- */
#mpi-list-area .dn-table tfoot td {
  background: #f8fafc;
  font-weight: 700;
  color: #0f172a;
  border-top: 2px solid #e2e8f0;
}
#mpi-list-area .dn-table tfoot td.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
/* Tulisan TOTAL-nya rata tengah di selnya. */
#mpi-list-area .dn-table tfoot td:first-child { text-align: center; }
/* Tulisan TOTAL USD / TOTAL IDR dibuat sebesar angkanya - itu penanda
   mata uang barisnya, bukan keterangan kecil. */
#mpi-list-area .dn-table tfoot .mpi-total-label {
  font-size: 13.5px;
  font-weight: 700;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #0f172a;
}

/* Kolom terakhir berisi data, bukan tombol - jangan dikunci ke kanan. */
#mpi-list-area .dn-table tbody td:last-child,
#mpi-list-area .dn-table thead th:last-child {
  position: static; right: auto; z-index: auto; box-shadow: none;
}
/* Tabelnya minimal selebar kartunya; kalau isinya lebih lebar tetap bisa digeser. */
#mpi-list-area .dataTables_scrollHeadInner,
#mpi-list-area .dataTables_scrollHeadInner > table,
#mpi-list-area .dataTables_scrollBody > table { min-width: 100% !important; }

</style>

<div class="content-wrapper nag-skin ci-sm">
  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-chart-line"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end mpi-filter">
            <div class="form-group col-lg-4 col-md-6 mpi-f-customer">
              <label for="customer">Customer</label>
              <select class="form-control select2bs4" id="customer" name="customer">
                <option value="all_customer">All Customer</option>
                <?php foreach ($customer as $cs) : ?>
                  <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-6 mpi-f-tgl">
              <label for="filter_from">From</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_from" id="filter_from" class="form-control tanggal" value="<?= date('Y-m-01'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-6 mpi-f-tgl">
              <label for="filter_to">To</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_to" id="filter_to" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-12 mpi-f-aksi">
              <div class="dn-filter-aksi mpi-aksi">
                <button type="button" id="find_invoice" name="find_invoice" class="btn btn-primary" onclick="mpi_cari()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-dn-excel" onclick="mpi_export()"><i class="fas fa-file-excel"></i> Export</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Isi laporan -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Data Proforma Invoice</span>
          </div>
          <div class="dn-list-area" id="mpi-list-area">
            <div class="nag-loader-overlay" id="mpi-list-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Loading data...</div>
              </div>
            </div>
            <table id="table-mutasi-pi" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr>
                  <th>No Proforma Invoice</th>
                  <th>Tgl Proforma Invoice</th>
                  <th>Type Document</th>
                  <th>Customer</th>
                  <th>Billed To</th>
                  <th>Beginning Balance</th>
                  <th>Addition</th>
                  <th>Deduction</th>
                  <th>Ending Balance</th>
                </tr>
              </thead>
              <tbody></tbody>
              <!-- Jumlah per mata uang - diisi mpi_cari() dari angka yang
                   dihitung server, jadi tidak mungkin beda dengan isinya.
                   Selnya sebelas penuh (tanpa colspan) supaya tetap lurus
                   dengan kolom di atasnya waktu tabelnya digeser. -->
              <tfoot id="mpi-total"></tfoot>
            </table>
          </div>


        </div>
      </div>

    </div>
  </section>
</div>

<!-- Rincian Deduction: alokasi mana saja yang memotong PI ini, dan uangnya
     dari nomor bank masuk / memorial jurnal yang mana. Diisi
     mpi_deduction_buka() di crud-nag.js. -->
<div class="modal fade nag-skin ci-sm" id="modal-mpi-ded" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="fas fa-hand-holding-usd"></i>
          <span id="mpi-ded-judul">Deduction</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mpi-ded-kepala">
          <div>
            <div class="mpi-ded-label">Proforma Invoice</div>
            <div class="mpi-ded-isi" id="mpi-ded-no">-</div>
          </div>
          <div>
            <div class="mpi-ded-label">Period</div>
            <div class="mpi-ded-isi" id="mpi-ded-periode">-</div>
          </div>
          <div>
            <div class="mpi-ded-label">Total Deduction</div>
            <div class="mpi-ded-isi is-angka" id="mpi-ded-total">0.00</div>
          </div>
        </div>

        <div class="ci-table-wrap">
          <table id="table-mpi-ded" class="dn-table text-nowrap" style="width:100%">
            <thead>
              <tr>
                <th>No Alokasi</th>
                <th>Tgl Alokasi</th>
                <th>Source</th>
                <th>Doc Number</th>
                <th>Bank</th>
                <th>Account</th>
                <th>Curr</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot id="mpi-ded-kaki"></tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      // Tabelnya disiapkan sejak halaman dibuka: kotak Search, pilihan jumlah
      // baris, dan pesan "belum ada data" sudah ada sebelum Search ditekan.
      mpi_dt();
    });
  });
</script>
