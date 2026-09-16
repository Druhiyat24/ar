<!-- ==========================================================================
     List Debit Note
     Tampilannya disamakan dengan Create / Edit Debit Note (skin .nag-skin).
     Tabelnya DataTables: pencarian, urutan, dan halaman ditangani DataTables,
     datanya diisi cari_debit_note() di crud-nag.js lewat API DataTables.
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<style type="text/css">
/* Khusus halaman List Debit Note */
/* Create sengaja biru muda supaya beda jelas dengan Search (navy) di sebelah
   kirinya, tapi tetap satu keluarga warna. */
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

/* =========================================================================
   Sentuhan premium (tanpa mengubah warna). Semua di file ini, BUKAN di
   dn_skin.php, supaya halaman Second Approval & tabel modal tidak ikut
   berubah. Kepala tabel lewat #dn-list-area karena di mode scrollX yang
   terlihat adalah salinan kepala tanpa id. Source Sans Pro cuma ada 400/700 -
   jangan tulis font-weight 600 (tampil sebagai 700).
   ========================================================================= */

/* -- Ritme baris: tinggi seragam, kolom dipisah perataan, bukan kisi -- */
/* height pada sel tabel TIDAK termasuk padding (6px atas-bawah) - 38px isi = baris 50px */
#dn-list-area .dn-table tbody tr:not(.child) > td:not(.dataTables_empty) { height: 38px; }
#dn-list-area .dn-table tbody td { padding: 6px 12px; border-right: 0; border-bottom: 1px solid #eef2f7; }
#dn-list-area .dn-table tbody tr:last-child td { border-bottom: 0; }
#dn-list-area .dn-tanpa-doc { margin-top: 3px; line-height: 1.1; }

/* -- Kepala tabel tenang: rata mengikuti isi, panah urut cuma saat perlu -- */
/* padding kanan 26px milik th.sorting di skin sengaja tidak ditimpa (tempat panah) */
#dn-list-area .dn-table thead th { text-align: left; border-right: 0; padding-top: 11px; padding-bottom: 11px; }
#dn-list-area .dn-table thead th.dn-angka  { text-align: right; }
#dn-list-area .dn-table thead th.dn-tengah { text-align: center; }
#dn-list-area .dn-table td.dn-angka { padding-right: 26px; }
#dn-list-area .dn-table thead th.sorting::before,
#dn-list-area .dn-table thead th.sorting::after,
#dn-list-area .dn-table thead th.sorting_asc::after,
#dn-list-area .dn-table thead th.sorting_desc::before { opacity: 0; transition: opacity .15s; }
#dn-list-area .dn-table thead th.sorting:hover::before,
#dn-list-area .dn-table thead th.sorting:hover::after { opacity: .45; }
#dn-list-area .dn-table thead th.sorting_asc::before,
#dn-list-area .dn-table thead th.sorting_desc::after { opacity: .9; }
#dn-list-area .dn-table thead th.sorting_asc,
#dn-list-area .dn-table thead th.sorting_desc { box-shadow: inset 0 -2px 0 rgba(248, 250, 252, .5); }
#dn-list-area .dataTables_scrollHead { border-color: #1e3a5f; }

/* -- Kolom Action rata kiri: Print & Email jatuh di posisi yang sama tiap baris -- */
#dn-list-area .dn-table .dn-aksi { justify-content: flex-start; }
#dn-list-area .dn-aksi .btn i { width: 13px; text-align: center; }
#dn-list-area .dn-table thead th:last-child,
#dn-list-area .dn-table tbody td:last-child:not(.dataTables_empty) { text-align: left; padding-left: 12px; }
#dn-list-area .dn-aksi-kosong { display: block; text-align: left; padding-left: 0; }
/* garis halus sebelum kelompok aksi yang mengubah data (Edit / Cancel / Docs) */
#dn-list-area .dn-aksi .btn:nth-child(3) { margin-left: 7px; position: relative; }
#dn-list-area .dn-aksi .btn:nth-child(3)::before {
  content: ''; position: absolute; left: -8px; top: 6px; bottom: 6px; width: 1px; background: #e2e8f0;
}

/* -- Bayangan kolom Action cuma muncul kalau memang ada kolom yang tergeser -- */
#dn-list-area .dn-table thead th:last-child { box-shadow: none; transition: box-shadow .2s ease; }
#dn-list-area .dn-table tbody td:last-child:not(.dataTables_empty) { box-shadow: -1px 0 0 #eef2f7; transition: box-shadow .2s ease; }
#dn-list-area.is-ada-kanan .dn-table thead th:last-child,
#dn-list-area.is-ada-kanan .dn-table tbody td:last-child:not(.dataTables_empty) { box-shadow: -7px 0 9px -7px rgba(15, 23, 42, .25); }

/* -- Kedalaman kartu: diam, garis tipis, bayangan berlapis -- */
.nag-skin .card, .nag-skin .card:hover {
  border: 1px solid #e5e9f0 !important;
  box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 6px 20px -8px rgba(15, 23, 42, .10) !important;
  margin-bottom: 16px !important;
}
.nag-skin .card > .card-header { border-radius: 11px 11px 0 0 !important; }
.nag-skin .card > .card-header .card-title { font-size: 14px !important; }
#dn-list-area .dataTables_scrollBody { box-shadow: 0 1px 2px rgba(15, 23, 42, .04); }

/* -- Pil status: tinggi & lebar seragam + titik penanda -- */
#dn-list-area .dn-badge {
  display: inline-flex; align-items: center; justify-content: center; gap: 6px;
  height: 22px; min-width: 12.5em;
  padding: 0 10px; font-size: 10.5px; letter-spacing: .5px; line-height: 1; vertical-align: middle;
}
#dn-list-area .dn-badge::before {
  content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: .7; flex: 0 0 6px;
}
#dn-list-area .dn-badge.is-post   { box-shadow: inset 0 0 0 1px rgba(7, 89, 133, .14); }
#dn-list-area .dn-badge.is-first  { box-shadow: inset 0 0 0 1px rgba(146, 64, 14, .14); }
#dn-list-area .dn-badge.is-second { box-shadow: inset 0 0 0 1px rgba(22, 101, 52, .14); }
#dn-list-area .dn-badge.is-batal  { box-shadow: inset 0 0 0 1px rgba(153, 27, 27, .14); }

/* -- Respons mikro & fokus keyboard -- */
.nag-skin #table-list-debit-note tbody td { transition: background-color .12s ease; }
.nag-skin #table-list-debit-note tbody tr:hover td:first-child,
.nag-skin #table-list-debit-note tbody tr:has(:focus-visible) td:first-child { box-shadow: inset 3px 0 0 #1e3a5f; }
.nag-skin #table-list-debit-note tbody tr:has(:focus-visible) td,
.nag-skin #table-list-debit-note tbody tr:has(:focus-visible) td:last-child { background: #eaf2ff; }
.nag-skin #table-list-debit-note .dn-aksi .btn { transition: box-shadow .12s ease, filter .12s ease !important; }
.nag-skin #table-list-debit-note .dn-aksi .btn:hover { box-shadow: 0 3px 8px rgba(15, 23, 42, .18) !important; }
.nag-skin #table-list-debit-note .dn-aksi .btn:active { box-shadow: none !important; }
.nag-skin #table-list-debit-note .dn-aksi .btn:focus-visible { outline: 0; box-shadow: 0 0 0 3px rgba(44, 82, 130, .45) !important; }
.nag-skin #table-list-debit-note .dn-no-link:focus-visible { outline: 0; box-shadow: 0 0 0 3px rgba(44, 82, 130, .45); border-radius: 6px; }

/* -- Memuat ulang tanpa kehilangan konteks: data lama diredupkan, garis progres -- */
.nag-skin #dn-list-area.is-muat-ulang #dn-list-loader { background: transparent; }
.nag-skin #dn-list-area.is-muat-ulang .nag-loader-card { display: none; }
.nag-skin #dn-list-area.is-muat-ulang #table-list-debit-note tbody { opacity: .45; transition: opacity .15s; }
.nag-skin #dn-list-loader::before {
  content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px;
  background: linear-gradient(90deg, transparent, #1e3a5f, transparent);
  background-size: 40% 100%; background-repeat: no-repeat;
  animation: dn-progres 1s ease-in-out infinite;
}
@keyframes dn-progres { from { background-position: -40% 0; } to { background-position: 140% 0; } }

/* -- Kepala tabel ikut menempel saat halaman digulir -- */
/* !important: DataTables memberi inline position:relative ke scrollHead */
#dn-list-area .dataTables_scrollHead { position: sticky !important; top: 0; z-index: 8; }

/* -- Preset tanggal cepat -- */
.nag-skin .dn-preset { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
.nag-skin .btn-preset {
  border: 1px solid #e2e8f0; background: #fff; color: #1e3a5f; font-size: 12px;
  padding: 3px 11px; border-radius: 999px; line-height: 1.5; cursor: pointer;
  transition: background-color .12s, border-color .12s, color .12s;
}
.nag-skin .btn-preset:hover { background: #eef2f7; border-color: #2c5282; }
.nag-skin .btn-preset.is-aktif { background: #1e3a5f; border-color: #1e3a5f; color: #fff; }
.nag-skin .btn-preset:focus-visible { outline: 0; box-shadow: 0 0 0 3px rgba(44, 82, 130, .35); }

/* -- Keadaan kosong yang memandu -- */
.nag-skin .dn-kosong { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 8px 0; animation: dn-muncul .2s ease both; }
.nag-skin .dn-kosong-ikon {
  width: 44px; height: 44px; border-radius: 50%; background: #eef2f7;
  display: grid; place-items: center; color: #1e3a5f; margin-bottom: 4px;
}
.nag-skin .dn-kosong-ikon i { opacity: .55; font-size: 17px; }
.nag-skin .dn-kosong-judul { color: #0f172a; font-weight: 700; font-size: 13.5px; white-space: normal; }
.nag-skin .dn-kosong-aksi {
  margin-top: 6px; border: 1px solid #e2e8f0; background: #fff; color: #1e3a5f;
  border-radius: 999px; padding: 4px 14px; font-size: 12px; font-weight: 700; cursor: pointer;
}
.nag-skin .dn-kosong-aksi:hover { background: #eef2f7; border-color: #2c5282; }
@keyframes dn-muncul { from { opacity: 0; } }

/* -- Ringkasan di samping judul tabel -- */
#dn-list-ringkasan { display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; gap: 6px 10px; min-width: 0; }
#dn-list-ringkasan:empty { display: none; }
#dn-list-ringkasan .dn-ringkasan-status { display: flex; flex-wrap: wrap; align-items: center; gap: 4px 6px; }
#dn-list-ringkasan .dn-ringkasan-chip {
  display: inline-flex; align-items: center; border: 0; background: none; padding: 0;
  cursor: pointer; border-radius: 999px; transition: transform .12s ease, opacity .12s ease;
}
#dn-list-ringkasan .dn-ringkasan-chip .dn-badge { transition: box-shadow .12s ease; padding: 3px 8px; font-size: 10px; letter-spacing: .2px; }
#dn-list-ringkasan .dn-ringkasan-chip:hover .dn-badge { box-shadow: inset 0 0 0 1px currentColor; }
#dn-list-ringkasan .dn-ringkasan-chip.is-aktif .dn-badge { box-shadow: inset 0 0 0 1.5px currentColor; }
#dn-list-ringkasan .dn-ringkasan-chip:focus-visible { outline: 0; box-shadow: 0 0 0 3px rgba(44, 82, 130, .35); }
/* Jumlahnya ikut warna teks badge induknya (currentColor), cuma sedikit lebih tebal. */
#dn-list-ringkasan .dn-ringkasan-n { margin-left: 4px; font-weight: 800; font-variant-numeric: tabular-nums; }
#dn-list-ringkasan .dn-ringkasan-perhatian {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 3px 10px; border-radius: 999px;
  background: #fee2e2; color: #991b1b;
  font-weight: 700; font-size: 10.5px; letter-spacing: .4px; text-transform: uppercase;
  white-space: nowrap;
}
#dn-list-ringkasan .dn-ringkasan-perhatian i { font-size: 10px; }

/* -- Mode HP: kembalikan yang tidak cocok di layar sempit -- */
@media (max-width: 767.98px) {
  #dn-list-area .dn-table tbody tr:not(.child) > td { height: auto; }
  #dn-list-area .dn-table tbody td { padding: 6px 8px; }
  #dn-list-area .dn-table .dn-aksi { justify-content: center; }
  #dn-list-area .dn-table thead th:last-child,
  #dn-list-area .dn-table tbody td:last-child:not(.dataTables_empty) { text-align: center; }
  /* Di HP tombolnya ikon saja dan bisa sampai 4 - jarak pemisah & padding
     kiri desktop bikin barisnya meluber, jadi dikembalikan ke ukuran HP. */
  #dn-list-area .dn-table thead th:last-child,
  #dn-list-area .dn-table tbody td:last-child:not(.dataTables_empty) { padding-left: 8px; padding-right: 8px; }
  #dn-list-area .dn-aksi .btn:nth-child(3) { margin-left: 0; }
  #dn-list-area .dn-aksi .btn:nth-child(3)::before { display: none; }
  /* Sejak ada tombol Email, DN berstatus POST punya 4 ikon - padding skin
     (9px) bikin selnya lebih lebar dari layar 390px. */
  #dn-list-area .dn-aksi .btn { padding: 0 8px !important; }
  #dn-list-area .dn-table thead th:last-child,
  #dn-list-area .dn-table tbody td:last-child { box-shadow: none; }
  #dn-list-area .dn-badge { min-width: 0; }
  .nag-skin #table-list-debit-note tbody tr td:first-child { box-shadow: none; }
  .nag-skin .card > .card-body { padding: 14px !important; }
  #dn-list-ringkasan { width: 100%; justify-content: flex-start; }
  .nag-skin #table-list-debit-note thead th,
  .nag-skin #table-list-debit-note thead th:last-child { position: sticky; top: 0; z-index: 8; }
}
@media (prefers-reduced-motion: reduce) {
  .nag-skin #table-list-debit-note tbody td,
  .nag-skin #table-list-debit-note .dn-aksi .btn { transition: none !important; }
  .nag-skin #dn-list-loader::before { animation: none; }
  .nag-skin .dn-kosong { animation: none; }
}
</style>

<div class="content-wrapper nag-skin">
  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-file-invoice-dollar"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end">
            <div class="form-group col-lg-4 col-md-6">
              <label for="list_prof_customer">Consignee</label>
              <select class="form-control select2bs4" id="list_prof_customer" name="list_prof_customer">
                <option value="all_customer">All Customer</option>
                <?php foreach ($customer as $cs) : ?>
                  <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-3 col-6">
              <label for="filter_from">From</label>
              <!-- Tanpa class "tanggal": datepicker di-init sendiri di bawah, formatnya
                   beda dari datepicker global (footer.php) yang dipakai halaman lain. -->
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
            <div class="form-group col-lg-4">
              <div class="dn-filter-aksi">
                <button type="button" id="find_invoice_pi" name="find_invoice_pi" class="btn btn-primary" onclick="cari_debit_note()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-dn-create" onclick="location.href='<?= base_url('arnag/create_debitnote'); ?>'"><i class="fas fa-plus"></i> Create</button>
                <button type="button" class="btn btn-dn-excel" onclick="export_list_dn()"><i class="fas fa-file-excel"></i> Export</button>
              </div>
            </div>
            <!-- Rentang tanggal yang paling sering dipakai, cukup sekali klik -->
            <div class="col-12 dn-preset" role="group" aria-label="Quick date range">
              <button type="button" class="btn-preset" data-preset="hari" aria-pressed="false">Today</button>
              <button type="button" class="btn-preset" data-preset="minggu" aria-pressed="false">This week</button>
              <button type="button" class="btn-preset" data-preset="bulan" aria-pressed="false">This month</button>
              <button type="button" class="btn-preset" data-preset="bulan_lalu" aria-pressed="false">Last month</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Daftar Debit Note -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Data Debit Note</span>
            <!-- Diisi dn_list_ringkasan() setelah Search -->
            <div id="dn-list-ringkasan" class="dn-ringkasan" aria-live="polite"></div>
          </div>
          <div class="dn-list-area" id="dn-list-area">
            <div class="nag-loader-overlay" id="dn-list-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Memuat data...</div>
              </div>
            </div>
            <table id="table-list-debit-note" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr>
                  <th>No Debit Note</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Consignee</th>
                  <th>Attn</th>
                  <th>From Curr</th>
                  <th>To Curr</th>
                  <th>Amount</th>
                  <th>Equivalent Currency</th>
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
  // DataTables & datepicker baru siap setelah script footer dimuat.
  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      dn_list_dt();
      // PC ini sudah memasang skrip "Outlook langsung"? (kalau belum, tombol
      // Email tetap mengunduh .eml seperti biasa)
      dn_email_cek_handler();

      // From/To pakai datepicker sendiri (bukan class "tanggal" global di
      // footer.php) - formatnya "14 Sep 2026" mengikuti skin, bukan yyyy-mm-dd.
      // Inputnya readonly (isi cuma lewat kalender); nilai ISO buat dikirim ke
      // server diambil balik lewat dn_list_tanggal_iso() di crud-nag.js.
      $('#filter_from, #filter_to').each(function () {
        var $el = $(this);
        // Nilai awal dikirim sebagai objek Date - kalau string, datepicker
        // mem-parsingnya pakai format tampilan ('d M yyyy'), jadi "2026-09-14"
        // malah terbaca tanggal 2026.
        var p = String($el.data('iso')).split('-');
        $el.datepicker({ format: 'd M yyyy', autoclose: true, todayHighlight: true })
          .datepicker('update', new Date(+p[0], +p[1] - 1, +p[2]));
      });

      // Kembali dari Edit / Docs: filter yang tadi dipasang lagi sekalian
      // datanya dicari ulang, jadi tidak balik ke tanggal hari ini. Masuk
      // menu dari awal tetap mulai dari hari ini (lihat dn_list_pulihkan_filter).
      if (dn_list_pulihkan_filter()) {
        cari_debit_note();
      }

      // Preset tanggal: tombol yang sesuai rentang From/To sekarang ditandai aktif.
      dn_list_tandai_preset();
      $('#filter_from, #filter_to').on('changeDate', dn_list_tandai_preset);
      $(document).on('click', '.dn-preset .btn-preset', function () {
        dn_list_preset($(this).data('preset'));
      });

      // Nomor DN bisa dibuka lewat keyboard (Tab lalu Enter/Spasi). Didelegasikan
      // dari document supaya tetap hidup waktu tabel dibangun ulang.
      $(document).on('keydown', '#table-list-debit-note .dn-no-link', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.click();
        }
      });

      // Chip status di ringkasan: saring tabel ke status itu.
      $(document).on('click', '#dn-list-ringkasan .dn-ringkasan-chip', function () {
        dn_list_klik_status($(this).attr('data-status'));
      });

      // Tombol di keadaan tabel kosong.
      $('#dn-list-area').on('click', '.dn-kosong-aksi', function () {
        if ($(this).data('aksi') === 'hapus-cari') {
          DN_LIST_DT.search('').draw();
          $('#dn-list-area .dataTables_filter input').val('');
        } else {
          dn_list_preset('bulan');
        }
      });

      // Pratinjau lampiran dihentikan waktu modal ditutup - kalau tidak,
      // PDF-nya tetap termuat di latar belakang.
      $('#modal-dn-detail').on('hidden.bs.modal', dn_detail_tutup_pratinjau);

      // Enter di kolom filter = klik Search. Dulu filter ada di dalam <form>,
      // jadi Enter malah me-reload halaman.
      $('#filter_from, #filter_to').on('keydown', function (e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          cari_debit_note();
        }
      });
    });
  });
</script>

<?php if (!empty($dn_cancel_flash) && is_array($dn_cancel_flash)) : ?>
<script>
  // Hasil cancel (flashdata dari Arnag::cancel_debnote) - sekali tampil.
  document.addEventListener('DOMContentLoaded', function () {
    var hasil = <?= json_encode(array('status' => !empty($dn_cancel_flash['status']), 'message' => (string) (isset($dn_cancel_flash['message']) ? $dn_cancel_flash['message'] : '')), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    Swal.fire({
      icon: hasil.status ? 'success' : 'error',
      title: hasil.status ? 'Debit Note Cancelled' : 'Cannot Cancel',
      text: hasil.message
    });
  });
</script>
<?php endif; ?>

<?php $this->load->view('arnag/dn_detail_modal'); ?>

<div class="modal fade nag-skin" id="modal-cancel-dn">
    <form action="<?= base_url('arnag/cancel_debnote'); ?>" method="POST">
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
                        <label for="id_inv" class="col-sm-5 col-form-label">Sure Cancel DebitNote:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="txt_cancel_book" name="txt_cancel_book" style="border:none;" readonly>
                        </div>
                    </div>
                    <!-- Hidden Text -->
                    <input type="hidden" id="id_debnote" name="id_debnote" readonly>
                    <input type="hidden" id="id_bppb" name="id_bppb" readonly>
                    <input type="hidden" id="user" name="user" value="<?= $user['username']; ?>" readonly>
                    <!--  -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php // Daftar ini HARUS sama dengan Arnag::_dn_boleh_cancel() (dicek juga di server).
                    $data = $user['username'];
                    if ($data == 'willy' || $data == 'yulianto' || $data == 'hady' || $data == 'hadi' || $data == 'jefri' || $data == 'ramon' || $data == 'lukman' || $data == 'oktora' || $data == 'frisca') 
                    {
                        echo '<button type="submit" class="btn btn-primary toastsDefaultDanger">Cancel Debit Note</button>';
                     } else {
                    echo '<button type="button" disabled class="btn btn-primary toastsDefaultDanger">Cancel Debit Note</button>';
                }
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Update Faktur Pajak -->
<div class="modal fade nag-skin" id="modal-update-faktur-pjk">
    <form action="<?= base_url('arnag/update_faktur_pajak'); ?>" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Update</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Update Paktur Pajak -->
                    <input type="hidden" name="id_inv_prof" id="id_inv_prof" required readonly>
                    <div class="form-group col-md-12">
                        <label>Input Faktur Pajak</label>
                        <input type="text" class="form-control" id="no_paktur_pjk" name="no_paktur_pjk" autocomplete="off">
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
