<!-- ==========================================================================
     Sales Report Detail Item
     Tampilannya mengikuti menu Debit Note (skin .nag-skin di dn_skin.php).
     Tabelnya DataTables, datanya diambil per bulan oleh
     cari_sales_report_detail_material() di crud-nag-report.js - persentase
     loading dihitung dari bulan yang sudah selesai. File Excel dirakit di
     browser dari data yang sama (export_sales_report_detail_material() di JS).
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<style type="text/css">
/* Khusus halaman ini */
/* header.php membuang margin .form-group di .row.align-items-end, jadi jarak
   tombol ke filter di atasnya diberi sendiri (sama dengan jarak antar baris filter). */
.nag-skin .srm-aksi { margin-top: 12px; }
.nag-skin .btn-dn-excel {
  background: linear-gradient(135deg, #15803d, #16a34a) !important;
  border: none !important;
  color: #fff !important;
}
.nag-skin .btn-srm-print {
  background: #475569 !important;
  border-color: #475569 !important;
  color: #fff !important;
}

/* ===== Area scroll =====
   Dibuat DataTables (opsi dom di crud-nag-report.js) dan hanya membungkus
   tabelnya, jadi Show/Search/halaman tidak ikut tergeser. 57 kolom tidak
   mungkin muat selebar layar - yang digeser cuma area tabel, bukan halaman. */
#srm-area .srm-scroll {
  max-height: 70vh;
  overflow: auto;
  position: relative;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  scrollbar-color: #64748b #e2e8f0;
}
#srm-area .srm-scroll::-webkit-scrollbar { width: 14px; height: 14px; }
#srm-area .srm-scroll::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 8px; }
#srm-area .srm-scroll::-webkit-scrollbar-thumb { background: #64748b; border-radius: 8px; border: 3px solid #e2e8f0; }
#srm-area .srm-scroll::-webkit-scrollbar-thumb:hover { background: #475569; }

/* ===== Kepala tabel menempel di atas area scroll =====
   top baris kedua & left kolom beku dihitung srmAtur() dari ukuran asli
   (lebar kolom ikut isi, jadi tidak bisa ditulis tetap disini). */
#srm-area .dn-table thead th { position: sticky; top: 0; z-index: 5; }
#srm-area .dn-table thead tr:nth-child(2) th { background: #264a73; }
#srm-area .dn-table thead th.srm-grup-bill { box-shadow: inset 0 -3px 0 #22c55e; }
#srm-area .dn-table thead th.srm-grup-ship { box-shadow: inset 0 -3px 0 #38bdf8; }
/* Batas antar kelompok (Billing / Shipping, Original / IDR) */
#srm-area .dn-table .srm-awal-grup { border-left: 2px solid #cbd5e1; }
#srm-area .dn-table thead th.srm-awal-grup { border-left-color: rgba(255, 255, 255, .35); }

/* Kolom terakhir di skin DN adalah Action yang ditempel di kanan - disini
   kolom terakhir cuma angka biasa. */
#srm-area .dn-table thead th:last-child { right: auto; z-index: 5; box-shadow: none; }
#srm-area .dn-table thead th.srm-grup-ship:last-child { box-shadow: inset 0 -3px 0 #38bdf8; }
#srm-area .dn-table tbody td:last-child:not(.dataTables_empty) { position: static; box-shadow: none; border-right: 0; }

/* ===== Kolom beku (No s/d Shipp Number) - hanya di layar lebar; di HP lima
   kolom itu saja sudah selebar layar. ===== */
@media (min-width: 768px) {
  #srm-area .dn-table thead th.srm-beku { z-index: 7; }
  #srm-area .dn-table tbody td.srm-beku { position: sticky; z-index: 3; }
  #srm-area .srm-scroll.is-geser .srm-beku-4 { box-shadow: 7px 0 9px -7px rgba(15, 23, 42, .3); }
}

/* ===== Keadaan kosong: ditempel di kiri area scroll supaya tidak ikut
   ke tengah tabel yang lebarnya ribuan piksel ===== */
#srm-area .dn-table td.dataTables_empty { text-align: left; padding: 30px 12px; }
#srm-area .srm-kosong {
  position: sticky;
  left: 12px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  white-space: normal;
  text-align: center;
}
#srm-area .srm-kosong-ikon {
  width: 44px; height: 44px; border-radius: 50%; background: #eef2f7;
  display: grid; place-items: center; color: #1e3a5f; margin-bottom: 4px;
}
#srm-area .srm-kosong-ikon i { opacity: .55; font-size: 17px; }
#srm-area .srm-kosong-judul { color: #0f172a; font-weight: 700; font-size: 13.5px; }

/* ===== Ringkasan di samping judul tabel ===== */
#srm-ringkasan:empty { display: none; }
#srm-ringkasan {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 3px 12px; border-radius: 999px;
  background: #eef2f7; color: #1e3a5f;
  font-size: 12px; font-weight: 700; font-variant-numeric: tabular-nums;
}

/* ===== Layar HP: kotak search selebar layar ===== */
@media (max-width: 767.98px) {
  #srm-area .dataTables_filter label { width: 100%; }
  #srm-area .dataTables_filter input { flex: 1 1 auto; margin-left: 0; }
}

/* Search / Export dikunci selama data masih dimuat */
.nag-skin .srm-aksi .btn:disabled { opacity: .6; cursor: not-allowed; filter: none; }

/* ===== Progress loading =====
   Tanpa awalan .nag-skin: dipakai juga di Swal Export, yang ditaruh
   SweetAlert2 langsung di <body> (di luar .nag-skin). */
.srm-progress {
  width: 240px;
  max-width: 100%;
  height: 6px;
  margin-top: 10px;
  background: #e2e8f0;
  border-radius: 999px;
  overflow: hidden;
}
.srm-progress-bar {
  width: 0;
  height: 100%;
  background: #1e3a5f;
  transition: width .25s ease;
}

/* ===== Swal (Export & pesan lain di halaman ini) =====
   !important: templates/header.php menimpa .btn secara global dengan !important. */
.srm-swal { border-radius: 14px; }
.srm-swal .swal2-title { color: #1e3a5f; font-size: 19px; }
.srm-swal .swal2-loader { border-color: #1e3a5f transparent #1e3a5f transparent; }
.srm-swal .srm-swal-teks { color: #475569; font-size: 14px; font-variant-numeric: tabular-nums; }
.srm-swal .srm-progress { margin: 12px auto 0; }
.srm-swal .swal2-confirm { background: #1e3a5f !important; border-color: #1e3a5f !important; }
.srm-swal .swal2-confirm:focus { box-shadow: 0 0 0 3px rgba(44, 82, 130, .35) !important; }
</style>

<div class="content-wrapper nag-skin">
  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-chart-line"></i>Sales Report Detail</h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end">
            <div class="form-group col-lg-4 col-md-6">
              <label for="sr_customer_mt">Customer</label>
              <select class="form-control select2bs4" id="sr_customer_mt" name="sr_customer_mt">
                <option value="All">All Customer</option>
                <?php foreach ($customer as $cs) : ?>
                  <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-3 col-6">
              <label for="filter_from">From</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_from" id="filter_from" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-3 col-6">
              <label for="filter_to">To</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_to" id="filter_to" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-6 col-6">
              <label for="sr_type_mt">Type</label>
              <select class="form-control select2bs4" id="sr_type_mt" name="sr_type_mt">
                <option value="All">All</option>
                <option value="Local">Local</option>
                <option value="Export">Export</option>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-6 col-6">
              <label for="sr_curr_mt">Currency</label>
              <select class="form-control select2bs4" id="sr_curr_mt" name="sr_curr_mt">
                <option value="All">All</option>
                <option value="USD">USD</option>
                <option value="IDR">IDR</option>
              </select>
            </div>

            <div class="form-group col-lg-4 col-md-6">
              <label for="sr_type_inv_mt">Invoice Type</label>
              <select class="form-control select2bs4" id="sr_type_inv_mt" name="sr_type_inv_mt">
                <option value="All">All</option>
                <?php foreach ($type as $t) : ?>
                  <option value="<?= $t['id_type']; ?>"><?= $t['type']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-6 col-6">
              <label for="sr_order_type_mt">Order Type</label>
              <select class="form-control select2bs4" id="sr_order_type_mt" name="sr_order_type_mt">
                <option value="All">All</option>
                <option value="FOB">FOB</option>
                <option value="CMT">CMT</option>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-4 col-6">
              <label for="sr_vat_mt">VAT Type</label>
              <select class="form-control select2bs4" id="sr_vat_mt" name="sr_vat_mt">
                <option value="All">All</option>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-4 col-6">
              <label for="sr_vat_status_mt">VAT Status</label>
              <select class="form-control select2bs4" id="sr_vat_status_mt" name="sr_vat_status_mt">
                <option value="All">All</option>
                <option value="Normal">Normal</option>
                <option value="Revisi">Revisi</option>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-4 col-6">
              <label for="sr_group_mt">Group</label>
              <select class="form-control select2bs4" id="sr_group_mt" name="sr_group_mt">
                <option value="All">All</option>
              </select>
            </div>

            <div class="form-group col-12 mb-0">
              <div class="dn-filter-aksi srm-aksi">
                <button type="button" id="srm-btn-search" class="btn btn-primary" onclick="cari_sales_report_detail_material()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-srm-print" onclick="print_sales_report_material()"><i class="fa fa-print"></i> Print</button>
                <button type="button" id="srm-btn-export" class="btn btn-dn-excel" onclick="export_sales_report_detail_material()"><i class="fas fa-file-excel"></i> Export</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Data -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Data Sales Report Detail Item</span>
            <!-- Diisi setelah Search: jumlah baris hasil -->
            <span id="srm-ringkasan" aria-live="polite"></span>
          </div>
          <div class="dn-list-area" id="srm-area">
            <!-- Loader dengan persentase: data diambil per bulan, jadi
                 persennya dihitung dari bulan yang sudah selesai. -->
            <div class="nag-loader-overlay" id="srm-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption" id="srm-progress-text">Loading data...</div>
                <div class="srm-progress"><div class="srm-progress-bar" id="srm-progress-bar"></div></div>
              </div>
            </div>
            <?php
            // Kolom beku: 5 kolom pertama (No s/d Shipp Number).
            $kolom_kiri = array('No', 'Customer', 'Invoice', 'Invoice Date', 'Shipp Number', 'Shipp Date', 'Group', 'WS', 'Style',
                                'Product Item', 'Order Type', 'Shipp', 'Inv Type', 'VAT Number', 'VAT Date', 'Currency', 'Rate');
            $grup = array(
                array('Billing Invoice (Original Currency)', 'srm-grup-bill'),
                array('Billing Invoice (Equivalent IDR)', 'srm-grup-bill'),
                array('Shipping Invoice (Original Currency)', 'srm-grup-ship'),
                array('Shipping Invoice (Equivalent IDR)', 'srm-grup-ship'),
            );
            $sub = array('Qty', 'UOM', 'Price', 'Gross Sales', 'Others Sales', 'Discount', 'Net Sales', 'Down Payment', 'VAT', 'Total');
            ?>
            <table id="table-sales-report-material" class="dn-table text-nowrap">
              <thead>
                <tr>
                  <?php foreach ($kolom_kiri as $i => $judul) : ?>
                    <th rowspan="2"<?= $i < 5 ? ' class="srm-beku srm-beku-' . $i . '"' : ''; ?>><?= $judul; ?></th>
                  <?php endforeach; ?>
                  <?php foreach ($grup as $g) : ?>
                    <th colspan="10" class="srm-awal-grup <?= $g[1]; ?>"><?= $g[0]; ?></th>
                  <?php endforeach; ?>
                </tr>
                <tr>
                  <?php foreach ($grup as $g) : ?>
                    <?php foreach ($sub as $j => $judul) : ?>
                      <th<?= $j === 0 ? ' class="srm-awal-grup"' : ''; ?>><?= $judul; ?></th>
                    <?php endforeach; ?>
                  <?php endforeach; ?>
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
  // DataTables baru siap setelah script footer dimuat.
  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      // Tabel kosong dulu, supaya kerangka Show/Search/halaman sudah tampil
      // sebelum Search pertama.
      srmTampilkan(null, [], true);
      $(window).on('resize', srmAtur);

      // Enter di kolom tanggal = klik Search.
      $('#filter_from, #filter_to').on('keydown', function (e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          cari_sales_report_detail_material();
        }
      });
    });
  });
</script>
