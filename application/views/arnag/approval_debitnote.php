<!-- ==========================================================================
     Second Approval Debit Note
     Tampilannya memakai skin yang sama dengan List Debit Note (partial dn_skin),
     tabelnya DataTables, dan nomor DN bisa diklik untuk melihat detail +
     lampirannya (partial dn_detail_modal).
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
/* Jumlah yang dipilih, di sebelah tombol Approve */
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
              <label for="pc_dn">Profit Center</label>
              <select class="form-control select2bs4" id="pc_dn" name="pc_dn" required>
                <option value="ALL" selected>ALL</option>
                <?php foreach ($profit_center as $pc) : ?>
                  <option value="<?= $pc['kode_pc']; ?>"><?= $pc['nama_pc']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-5">
              <div class="dn-filter-aksi">
                <button type="button" class="btn btn-primary" onclick="cari_debitnote_second_approv()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-dn-approve" onclick="modal_show_approve_debitnote_second()"><i class="fa fa-thumbs-up"></i> Approve</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Daftar DN yang menunggu second approval -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Waiting for Second Approval</span>
            <div class="dn-appv-bar">
              <span class="dn-appv-jumlah" id="dn-appv-jumlah"></span>
            </div>
          </div>
          <div class="dn-list-area" id="dn-appv-area">
            <div class="nag-loader-overlay" id="dn-appv-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Memuat data...</div>
              </div>
            </div>
            <table id="table-approval-debitnote" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr>
                  <th>No Debit Note</th>
                  <th>Date</th>
                  <th>Consignee</th>
                  <th>Attn</th>
                  <th>From Curr</th>
                  <th>To Curr</th>
                  <th>Amount</th>
                  <th>Equivalent Currency</th>
                  <th>Status</th>
                  <th class="dn-cek">
                    <input type="checkbox" id="cek_debitnote_approve" name="cek_debitnote_approve" title="Select all" onchange="dn_appv_centang_semua(this)">
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

<?php $this->load->view('arnag/dn_detail_modal'); ?>

<script>
  // DataTables & datepicker baru siap setelah script footer dimuat.
  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      dn_appv_dt();

      // From/To pakai datepicker sendiri (bukan class "tanggal" global di
      // footer.php) - formatnya "14 Sep 2026" mengikuti skin.
      $('#filter_from, #filter_to').each(function () {
        var $el = $(this);
        var p = String($el.data('iso')).split('-');
        $el.datepicker({ format: 'd M yyyy', autoclose: true, todayHighlight: true })
          .datepicker('update', new Date(+p[0], +p[1] - 1, +p[2]));
      });

      $('#modal-dn-detail').on('hidden.bs.modal', dn_detail_tutup_pratinjau);
    });
  });
</script>
