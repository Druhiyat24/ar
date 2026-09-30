<!-- ==========================================================================
     Second Approval Invoice
     Bentuknya disamakan dengan Second Approval Debit Note: skin yang sama
     (partial dn_skin), tabelnya DataTables, nomor invoice bisa diklik untuk
     melihat detail + dokumennya (partial inv_detail_modal), dan invoice yang
     belum punya supporting document ditandai + diperingatkan sebelum approve.
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<style type="text/css">
/* Khusus halaman Second Approval */
.nag-skin .btn-dn-approve {
  background: linear-gradient(135deg, #b45309, #d97706) !important;
  border: none !important;
  color: #fff !important;
}
/* Kolom centang: dibikin lega supaya gampang diklik */
.nag-skin .dn-table td.dn-cek,
.nag-skin .dn-table th.dn-cek { text-align: center; width: 52px; }
.nag-skin .dn-table .dn-cek input[type="checkbox"] {
  width: 17px;
  height: 17px;
  cursor: pointer;
  accent-color: #1e3a5f;
  vertical-align: middle;
}
/* Baris yang dipilih ditandai supaya jelas mana yang akan di-approve */
.nag-skin .dn-table tbody tr.dn-dipilih td { background: #eff6ff !important; }
/* ---- Kolom Inv Number ----
   Sama dengan List Invoice: nomornya dibikin jelas bisa diklik (pintu ke modal
   detail), penanda lampiran di bawahnya. */
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
/* Selnya jadi dua baris - nomor di atas, penanda lampiran di bawahnya. */
#inv-appv-area .dn-table td:first-child { white-space: normal; line-height: 1.35; }
/* Penanda "No attachment" di kolom nomor - bentuknya sama dengan List Invoice.
   Di layar ini semuanya sudah FIRST APPROVED, jadi penandanya merah: tinggal
   ini kesempatan terakhir melampirkan dokumennya. */
.nag-skin .dn-tanpa-doc {
  display: flex;
  align-items: center;
  gap: 5px;
  margin-top: 3px;
  opacity: .85;
  font-size: 10.5px;
  font-weight: 600;
  letter-spacing: .2px;
  line-height: 1.1;
  color: #94a3b8;
}
.nag-skin .dn-tanpa-doc i { font-size: 10px; }
.nag-skin .dn-tanpa-doc.is-perhatian { color: #dc2626; }
#inv-appv-area .dn-table td:first-child .dn-no-link { display: inline-block; }

/* Jumlah yang dipilih, di sebelah judul tabel */
.nag-skin .dn-appv-bar { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.nag-skin .dn-appv-jumlah { font-size: 12.5px; color: #64748b; }
.nag-skin .dn-appv-jumlah b { color: #0f172a; }
.nag-skin .dn-appv-jumlah .is-perhatian { color: #dc2626; opacity: .85; font-weight: 600; }
.nag-skin .dn-appv-jumlah .dn-appv-samar { color: #94a3b8; opacity: .9; }
</style>

<div class="content-wrapper nag-skin">
  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-stamp"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end">
            <div class="form-group col-lg-2 col-md-3 col-6">
              <label for="filter_from">From</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_from" id="filter_from" class="form-control" data-iso="<?= date('Y-m-d'); ?>" autocomplete="off" readonly>
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-3 col-6">
              <label for="filter_to">To</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_to" id="filter_to" class="form-control" data-iso="<?= date('Y-m-d'); ?>" autocomplete="off" readonly>
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-4">
              <label for="pc_invoice">Profit Center</label>
              <select class="form-control select2bs4" id="pc_invoice" name="pc_invoice" required>
                <option value="ALL" selected>ALL</option>
                <?php foreach ($profit_center as $pc) : ?>
                  <option value="<?= $pc['kode_pc']; ?>"><?= $pc['nama_pc']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-5">
              <div class="dn-filter-aksi">
                <button type="button" class="btn btn-primary" onclick="cari_invoice_second_approv()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-dn-approve" onclick="modal_show_approve_invoice_second()"><i class="fa fa-thumbs-up"></i> Approve</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Daftar invoice yang menunggu second approval -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Waiting for Second Approval</span>
            <div class="dn-appv-bar">
              <span class="dn-appv-jumlah" id="inv-appv-jumlah"></span>
            </div>
          </div>
          <div class="dn-list-area" id="inv-appv-area">
            <div class="nag-loader-overlay" id="inv-appv-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Loading data...</div>
              </div>
            </div>
            <table id="table-approval-invoice" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr>
                  <!-- Susunan kolomnya mengikuti List Invoice -->
                  <th>Inv Number</th>
                  <th>Inv Date</th>
                  <th>Type</th>
                  <th>Customer</th>
                  <th>Shipp</th>
                  <th>Doc Type</th>
                  <th>Doc Number</th>
                  <th>Amount</th>
                  <th class="dn-cek">
                    <input type="checkbox" id="cek_inv_approve" name="cek_inv_approve" title="Select all" onchange="inv_appv_centang_semua(this)">
                  </th>
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

<?php $this->load->view('arnag/inv_detail_modal'); ?>

<script>
  // Modal detail di layar ini punya satu tab tambahan: jurnal yang akan
  // terbentuk kalau invoice-nya di-approve (lihat inv_detail_jurnal_* di
  // crud-nag.js). Layar lain tidak memakainya.
  window.INV_DETAIL_JURNAL = true;

  // DataTables & datepicker baru siap setelah script footer dimuat.
  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      inv_appv_dt();

      // From/To pakai datepicker sendiri (bukan class "tanggal" global di
      // footer.php) - formatnya "14 Sep 2026" mengikuti skin.
      $('#filter_from, #filter_to').each(function () {
        var $el = $(this);
        var p = String($el.data('iso')).split('-');
        $el.datepicker({ format: 'd M yyyy', autoclose: true, todayHighlight: true })
          .datepicker('update', new Date(+p[0], +p[1] - 1, +p[2]));
      });

    });
  });
</script>
