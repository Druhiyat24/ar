<!-- ==========================================================================
     List Invoice
     Tampilannya mengikuti menu Debit Note (skin .nag-skin di dn_skin.php):
     kartu filter di atas, lalu kartu tabel dengan loader & DataTables.
     Data tabelnya tetap diisi cari_invoice() di crud-nag.js.
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<style type="text/css">
/* Khusus halaman List Invoice - warna tombol mengikuti List Debit Note. */
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
/* Filter + Search / Create / Export satu baris di layar lebar (>= 1280px):
   Customer mengisi sisa ruang, Status & tanggal lebarnya tetap, tombol selebar
   isinya. Di bawah itu layout kolom Bootstrap biasa - tombol turun ke baris
   sendiri. header.php membuang margin .form-group di .row.align-items-end,
   jadi jarak baris tombolnya diberi disini. */
.nag-skin .inv-aksi { margin-top: 12px; }
@media (min-width: 1280px) {
  /* Customer tidak ikut melar mengisi sisa ruang - di layar lebar kotaknya
     jadi jauh lebih panjang dari isinya. Tombolnya menempel di sebelah
     tanggal To; sisa ruangnya dibiarkan kosong di kanan. */
  .nag-skin .inv-filter > .inv-f-customer { flex: 0 1 24%; max-width: 360px; min-width: 220px; }
  .nag-skin .inv-filter > .inv-f-status { flex: 0 0 15%; max-width: 15%; }
  .nag-skin .inv-filter > .inv-f-tgl { flex: 0 0 16%; max-width: 16%; }
  .nag-skin .inv-filter > .inv-f-aksi { flex: 0 0 auto; width: auto; max-width: none; }
  .nag-skin .inv-filter .inv-aksi { margin-top: 0; flex-wrap: nowrap; }
}

/* ===== Ukuran "sm" =====
   Filter, select2, dan tombol dibuat 31px, bukan 38px bawaan skin DN.
   !important dipakai karena templates/header.php mengunci tinggi, padding,
   dan font .form-control / .btn / .select2-selection secara global. Kotak
   Show & Search di kartu tabel ikut, supaya seukuran filternya. */
.nag-skin .card-body .form-control,
.nag-skin .card-body .select2-container .select2-selection--single,
.nag-skin .card-body .input-group-text,
.nag-skin .inv-aksi .btn {
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
.nag-skin .inv-aksi .btn { padding: 0 12px !important; }
.nag-skin .inv-aksi .btn i { font-size: 11.5px; }
/* Isi dropdown select2 ikut mengecil - dropdown-nya dititipkan ke <body>,
   jadi tidak bisa di-scope ke .nag-skin (aman, style ini cuma dimuat disini). */
.select2-container--bootstrap4 .select2-results__option,
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field { font-size: 12.5px; }
/* ---- Kolom Inv Number ----
   Nomornya dibikin jelas bisa diklik (pintu ke modal detail), dengan penanda
   lampiran di bawahnya. Gayanya sama dengan nomor DN di List Debit Note. */
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
#inv-list-area .dn-table td:first-child { white-space: normal; line-height: 1.35; }
#inv-list-area .dn-table td:first-child .dn-no-link { display: inline-block; }
/* Belum ada lampiran: abu selagi masih DRAFT/POST (wajar belum diisi), merah
   setelah masuk approval (mestinya sudah ada). */
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

/* ---- Kolom Created By ----
   Nama pembuatnya di atas, tanggal & jamnya di bawah dengan warna lebih redup. */
#inv-list-area .inv-dibuat { display: flex; flex-direction: column; line-height: 1.25; }
#inv-list-area .inv-dibuat b { font-weight: 600; }
#inv-list-area .inv-dibuat small { color: #94a3b8; font-size: 10.5px; font-variant-numeric: tabular-nums; }
#inv-list-area .inv-kosong { color: #cbd5e1; }

/* ---- Kolom Action ----
   Tombolnya ikon + nama (Edit, Print, Excel, Cancel) seperti List Debit Note,
   supaya jelas fungsinya. Di HP namanya disembunyikan dn_skin.php - disana
   tombolnya bisa sampai 4 dan tidak muat kalau pakai teks. */
/* Rata kiri - baris yang tombolnya lebih sedikit (bukan POST) tetap sejajar
   dengan baris lain, jadi tombol yang sama selalu jatuh di tempat yang sama. */
#inv-list-area .dn-table .dn-aksi { justify-content: flex-start; flex-wrap: nowrap; gap: 5px; }
#inv-list-area .dn-table thead th:last-child,
#inv-list-area .dn-table tbody td:last-child:not(.dataTables_empty) { text-align: left; }
#inv-list-area .dn-table tbody tr:not(.child) > td:not(.dataTables_empty) { height: 38px; }
#inv-list-area .dn-aksi .btn i { font-size: 12.5px; }

/* ---- Menu di kolom Action (Print & "...") ----
   Menunya dititipkan ke <body> waktu dibuka - kalau digambar di dalam tabel,
   kotak gulirnya memotong. Gayanya dibuat senada kartu: sudut membulat,
   bayangan lembut, tiap pilihan punya judul & keterangan singkat. */
.dropdown-menu.inv-menu {
  min-width: 224px;
  padding: 5px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  box-shadow: 0 12px 28px rgba(15, 23, 42, .16);
}
.dropdown-menu.inv-menu .dropdown-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 8px 10px;
  border-radius: 8px;
  color: #1e293b;
  white-space: normal;
}
.dropdown-menu.inv-menu .dropdown-item > i {
  width: 16px;
  margin-top: 2px;
  text-align: center;
  color: #2c5282;
}
.dropdown-menu.inv-menu .dropdown-item b {
  display: block;
  font-size: 12.5px;
  font-weight: 600;
  line-height: 1.25;
}
.dropdown-menu.inv-menu .dropdown-item small {
  display: block;
  color: #94a3b8;
  font-size: 10.5px;
  line-height: 1.3;
}
.dropdown-menu.inv-menu .dropdown-item:hover,
.dropdown-menu.inv-menu .dropdown-item:focus {
  background: #eef4fb;
  color: #0f172a;
}

/* ---- Dialog Cancel (SweetAlert) ----
   Bentuknya mengikuti dialog simpan di Create Invoice: ringkasan berupa
   baris label-nilai, lalu satu paragraf keterangan kecil. */
.inv-swal { border-radius: 14px !important; padding: 8px 6px 14px !important; }
.inv-swal .swal2-title { font-size: 19px !important; }
.inv-swal .swal2-html-container { margin: 6px 14px 0 !important; font-size: 13px !important; }
.inv-swal .swal2-actions .btn,
.inv-swal .swal2-actions .swal2-styled {
  min-width: 132px;
  justify-content: center;
  font-size: 13px;
}
.inv-swal .inv-swal-ringkas {
  margin: 10px 0 0;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  overflow: hidden;
  text-align: left;
}
.inv-swal .inv-swal-ringkas > div {
  display: flex;
  justify-content: space-between;
  gap: 14px;
  padding: 7px 12px;
  border-bottom: 1px solid #eef2f7;
}
.inv-swal .inv-swal-ringkas > div:last-child { border-bottom: none; }
.inv-swal .inv-swal-ringkas span { color: #64748b; font-size: 12px; }
.inv-swal .inv-swal-ringkas b { color: #1e293b; font-size: 12.5px; text-align: right; }
.inv-swal .inv-swal-catatan {
  margin: 10px 2px 0;
  text-align: left;
  font-size: 11.5px;
  line-height: 1.5;
  color: #64748b;
}
.inv-swal .inv-swal-sisa {
  margin: 10px 0 0;
  padding: 9px 12px;
  border: 1px solid #fde68a;
  border-radius: 9px;
  background: #fffbeb;
  text-align: left;
  font-size: 11.5px;
  line-height: 1.5;
  color: #92400e;
}

</style>

<div class="content-wrapper nag-skin">
  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-file-invoice"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end inv-filter">
            <div class="form-group col-lg-4 col-md-6 inv-f-customer">
              <label for="customer">Customer</label>
              <select class="form-control select2bs4" id="customer" name="customer">
                <option value="all_customer">All Customer</option>
                <?php foreach ($customer as $cs) : ?>
                  <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-6 inv-f-status">
              <label for="status">Status</label>
              <select class="form-control select2bs4" id="status" name="status">
                <option value="all_status">ALL</option>
                <?php foreach ($status as $sts) : ?>
                  <option value="<?= $sts['status']; ?>"><?= $sts['status']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-6 inv-f-tgl">
              <label for="filter_from">From</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_from" id="filter_from" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-6 inv-f-tgl">
              <label for="filter_to">To</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_to" id="filter_to" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-12 inv-f-aksi">
              <div class="dn-filter-aksi inv-aksi">
                <button type="button" id="find_invoice" name="find_invoice" class="btn btn-primary" onclick="cari_invoice()"><i class="fa fa-search"></i> Search</button>
                <!-- Layar Create Invoice yang baru - satu form untuk garment & knitting. -->
                <button type="button" class="btn btn-dn-create" onclick="location.href='<?= base_url('arnag/create_invoice'); ?>'"><i class="fas fa-plus"></i> Create</button>
                <button type="button" class="btn btn-dn-excel" onclick="export_list_invoice()"><i class="fas fa-file-excel"></i> Export</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Daftar Invoice -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Data Invoice</span>
          </div>
          <div class="dn-list-area" id="inv-list-area">
            <div class="nag-loader-overlay" id="inv-list-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Memuat data...</div>
              </div>
            </div>
            <table id="table-invoice" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr>
                  <th>Inv Number</th>
                  <th>Inv Date</th>
                  <th>Type</th>
                  <th>Customer</th>
                  <th>Shipp</th>
                  <th>Doc Type</th>
                  <th>Doc Number</th>
                  <th>Created By</th>
                  <th>Amount</th>
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
  // Tabel disiapkan sejak halaman dibuka - sama seperti List Debit Note: kotak
  // Search, pilihan jumlah baris, dan pesan "belum ada data" sudah ada sebelum
  // tombol Search ditekan.
  //
  // Sesudah itu tampilan terakhir dipulihkan: filter, kotak pencarian, urutan,
  // dan halamannya. Jadi menekan Create lalu Back (atau membuka menu ini lagi
  // di tab yang sama) langsung memperlihatkan daftar yang tadi, tanpa mengisi
  // filter & menekan Search lagi.
  // Tombol Cancel: yang boleh memakainya sama seperti dulu (dulu tombol di
  // dalam modalnya yang dimatikan). Sekarang layar cuma memberi tahu; yang
  // benar-benar menjaga adalah pemeriksaan di Arnag::cancel_invoice_json().
  window.INV_BOLEH_CANCEL = <?= !empty($boleh_cancel) ? 'true' : 'false'; ?>;

  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      inv_list_dt();
      inv_list_pulihkan();
    });
  });

</script>

<!-- MODAL UPDATE -->
<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">Confirm Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_book_inv" id="id_book_inv" readonly>
                <div class="form-group col-md-12">
                    <label>Invoice Number</label>
                    <input type="text" class="form-control" id="no_inv" readonly>
                </div>
                <div class="form-group col-md-12">
                    <label>TOP</label>
                    <select id="top_inv" class="form-control select2bs4" required></select>
                    <input type="number" id="top_manual" class="form-control mt-2" placeholder="Masukkan TOP manual (hari)" style="display: none;">
                    <input type="text" id="id_customer" class="form-control mt-2" value="" style="display: none;">
                </div>
                <div class="row">
                    <div class=" col-md-6">
                        <label>Inv Date</label>
                        <div class="input-group mb-3">
                            <input type="text" name="inv_date" id="inv_date" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <label>Due Date</label>
                        <div class="input-group mb-3">
                            <input type="text" name="due_date" id="due_date" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="submitUpdateTOP()" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>


<?php
// Modal detail invoice yang baru - dibuka dengan mengklik nomor invoice.
// Modal lamanya (#modal-inv-detail) dipindahkan ke berkas ini dalam bentuk
// baru; layar lain yang masih memakai modal lama tidak ikut berubah.
$this->load->view('arnag/inv_detail_modal');
?>

    <script>
        function cari_noinvoice() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_noinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-invoice");
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
