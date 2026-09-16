<?php
// Skin Debit Note - dipakai bareng List Debit Note & Second Approval.
// Pemakaiannya: pembungkus halaman diberi class .nag-skin, lalu
//   $this->load->view('arnag/dn_skin')   <- ditulis di dalam blok PHP halaman
// Aturan khusus per halaman (mis. warna tombolnya sendiri) ditulis di
// halaman masing-masing, bukan disini.
?>
<style type="text/css">
/* ==========================================================================
   Semua di-scope ke .nag-skin: class ini dipasang di .content-wrapper DAN di
   modal halaman ini (modal ada di luar .content-wrapper), jadi keduanya ikut
   ter-style tanpa menyentuh halaman lain.

   templates/header.php punya style global ber-!important (.form-control, .btn,
   .table thead). Karena itu tabel disini sengaja TIDAK memakai class .table
   (sama seperti Create Debit Note & Projection Report), dan properti yang
   memang harus beda dari global diberi !important.
   ========================================================================== */

.nag-skin > .content { padding-top: 14px; }

/* ===== Card ===== */
.nag-skin .card {
  margin-bottom: 14px;
  border: 1px solid #e5e9f0;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
}
.nag-skin .card > .card-header {
  background: #1e3a5f !important;
  background-image: none !important;
  border-bottom: 0;
  border-radius: 11px 11px 0 0;
  display: flex;
  align-items: center;
  padding: 13px 18px;
}
.nag-skin .card > .card-header::after { display: none; }
.nag-skin .card > .card-header .card-title {
  color: #f8fafc;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: .3px;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 9px;
}
.nag-skin .card > .card-header .card-title i { opacity: .75; font-size: 13px; }
.nag-skin .card > .card-body { padding: 18px; }

/* ===== Label & kontrol filter ===== */
.nag-skin label {
  font-size: 11.5px;
  font-weight: 600;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #64748b;
  margin-bottom: 6px;
}
.nag-skin .form-group { margin-bottom: 14px; }
.nag-skin .form-control,
.nag-skin .select2-container .select2-selection--single,
.nag-skin .input-group-text,
.nag-skin .btn {
  height: 38px;
  border-radius: 8px;
  border-color: #e2e8f0;
  font-size: 13px;
}
.nag-skin .form-control { color: #1e293b; }
.nag-skin .form-control:focus {
  border-color: #2c5282;
  box-shadow: 0 0 0 3px rgba(44, 82, 130, .15);
}
.nag-skin .select2-container { display: block; width: 100% !important; }
.nag-skin .select2-container .select2-selection--single { height: 38px !important; padding: 0; }
.nag-skin .select2-container .select2-selection--single .select2-selection__rendered {
  line-height: 36px;
  padding-left: 12px;
  padding-right: 28px;
  color: #1e293b;
}
.nag-skin .select2-container .select2-selection--single .select2-selection__arrow {
  height: 36px;
  top: 1px;
  right: 6px;
}
.nag-skin .input-group > .form-control { border-radius: 8px 0 0 8px !important; }
.nag-skin .input-group-text {
  background: #f8fafc;
  color: #64748b;
  border-left: 0;
  border-radius: 0 8px 8px 0;
  padding: 0 12px;
}
/* Ikon kalender dibikin lebih menonjol (aksen navy skin), bukan abu-abu polos */
.nag-skin .dn-date-group .input-group-text {
  background: #eef2f7 !important;
  color: #2c5282 !important;
  font-size: 14px;
}


/* ===== Dropdown select2 & datepicker (dilampirkan ke body, jadi tidak bisa
   di-scope ke .nag-skin - aman karena style ini cuma dimuat di halaman ini) ===== */
.select2-container--bootstrap4 .select2-dropdown {
  border-color: #e2e8f0;
  border-radius: 10px;
  box-shadow: 0 10px 25px rgba(15, 23, 42, .12);
  overflow: hidden;
}
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 6px 10px;
  font-size: 13px;
}
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field:focus {
  outline: none;
  border-color: #2c5282;
  box-shadow: 0 0 0 3px rgba(44, 82, 130, .15);
}
.select2-container--bootstrap4 .select2-results > .select2-results__options { max-height: 260px; }
.select2-container--bootstrap4 .select2-results__option {
  font-size: 13px;
  padding: 7px 12px;
  color: #1e293b;
}
.select2-container--bootstrap4 .select2-results__option[aria-selected=true] {
  background: #eef2f7;
  color: #0f172a;
  font-weight: 600;
}
.select2-container--bootstrap4 .select2-results__option--highlighted,
.select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected],
.select2-container--bootstrap4 .select2-results__option[aria-selected=true].select2-results__option--highlighted {
  background: #1e3a5f !important;
  color: #f8fafc !important;
}
.select2-container--bootstrap4.select2-container--focus .select2-selection,
.select2-container--bootstrap4.select2-container--open .select2-selection {
  border-color: #2c5282 !important;
  box-shadow: 0 0 0 3px rgba(44, 82, 130, .15);
}

/* Selektor sengaja .datepicker.dropdown-menu: plugin (datepicker3.css) sudah
   memakai selektor itu untuk radius & shadow bawaannya, jadi ".datepicker"
   saja kalah spesifik dan tidak kepakai. */
.datepicker.dropdown-menu,
.datepicker.datepicker-dropdown {
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  box-shadow: 0 10px 25px rgba(15, 23, 42, .12);
  padding: 8px;
  font-size: 13px;
}
.datepicker table tr th.datepicker-switch,
.datepicker table tr th.prev,
.datepicker table tr th.next {
  color: #0f172a;
  font-weight: 600;
  border-radius: 8px;
}
.datepicker table tr th.datepicker-switch:hover,
.datepicker table tr th.prev:hover,
.datepicker table tr th.next:hover { background: #eef2f7; }
.datepicker table tr th.dow {
  color: #64748b;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .3px;
  text-transform: uppercase;
}
.datepicker table tr td.day { border-radius: 8px; color: #1e293b; }
.datepicker table tr td.day:hover { background: #eef2f7; }
.datepicker table tr td.old,
.datepicker table tr td.new { color: #cbd5e1; }
.datepicker table tr td.today,
.datepicker table tr td.today:hover {
  background: #e2e8f0 !important;
  background-image: none !important;
  color: #0f172a !important;
  font-weight: 600;
}
.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.active,
.datepicker table tr td span.active {
  background: #1e3a5f !important;
  background-image: none !important;
  color: #fff !important;
  text-shadow: none !important;
  border-radius: 8px;
}
.datepicker table tr td span.month,
.datepicker table tr td span.year { border-radius: 8px; }
.datepicker table tr td span.month:hover,
.datepicker table tr td span.year:hover { background: #eef2f7; }

/* Tabel di dalam popup datepicker kebetulan ikut ber-class "table", jadi
   aturan .table thead th / .table tbody td di header.php (yang pakai
   !important) ikut kena: latar abu, garis antar baris, dan warna tanggal
   dipaksa gelap semua. Blok ini menetralkannya supaya popup tampil sebagai
   kalender, bukan tabel data - termasuk tanggal di luar bulan yang sedang
   tampil yang harus redup. */
.datepicker table thead th,
.datepicker table tbody td {
  background: transparent !important;
  border: none !important;
  padding: 5px 6px !important;
  font-size: 13px !important;
}
.datepicker table tbody tr:hover { background: transparent !important; }
.datepicker table tr th.datepicker-switch,
.datepicker table tr th.prev,
.datepicker table tr th.next { color: #1d4ed8 !important; }
.datepicker table tr th.dow { color: #64748b !important; font-size: 11px !important; }
.datepicker table tr td.day { color: #1e293b !important; }
/* Tanggal di luar bulan yang sedang tampil: diredupkan */
.datepicker table tr td.old,
.datepicker table tr td.new { color: #cbd5e1 !important; }
/* ===== Tombol filter ===== */
.nag-skin .dn-filter-aksi { display: flex; flex-wrap: wrap; gap: 8px; }
/* flex-shrink:0 - tanpa ini tombol ikut mengecil saat kolomnya sempit dan
   tulisannya kepotong; lebih baik turun baris. */
.nag-skin .dn-filter-aksi .btn { display: inline-flex; align-items: center; gap: 7px; white-space: nowrap; flex: 0 0 auto; }
.nag-skin .btn i { font-size: 12.5px; }
.nag-skin .btn:hover { filter: brightness(.94); }
.nag-skin .btn:active { filter: brightness(.88); }

/* ===== Judul tabel ===== */
.nag-skin .table-header {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
  padding-bottom: 12px;
  border-bottom: 1px solid #eef2f7;
}
.nag-skin .table-title {
  display: flex;
  align-items: center;
  gap: 9px;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: .3px;
  color: #0f172a;
}
.nag-skin .table-title i { color: #1e3a5f; opacity: .55; font-size: 13px; }

/* ===== Area tabel + loader ===== */
/* Loader menutup seluruh area tabel (termasuk kotak search & pagination). */
.nag-skin .dn-list-area { position: relative; min-height: 220px; }

/* ===== Tabel ===== */
.nag-skin .dn-table {
  width: 100% !important;
  margin: 0;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 12.5px;
  color: #1e293b;
}
.nag-skin .dn-table thead th {
  background: #1e3a5f;
  color: #f8fafc;
  font-weight: 600;
  font-size: 11px;
  letter-spacing: .4px;
  text-transform: uppercase;
  text-align: center;
  vertical-align: middle;
  white-space: nowrap;
  padding: 9px 12px;
  border: 0;
  border-right: 1px solid rgba(255, 255, 255, .10);
  border-bottom: 2px solid #0f2942;
}
.nag-skin .dn-table thead th:last-child { border-right: 0; }
.nag-skin .dn-table tbody td {
  padding: 7px 10px;
  vertical-align: middle;
  white-space: nowrap;
  border: 0;
  border-right: 1px solid #eef2f7;
  border-bottom: 1px solid #eef2f7;
  font-variant-numeric: tabular-nums;
}
.nag-skin .dn-table tbody tr:nth-child(odd)  td { background: #fff; }
.nag-skin .dn-table tbody tr:nth-child(even) td { background: #f8fafc; }
.nag-skin .dn-table tbody tr:hover td { background: #eaf2ff; }
.nag-skin .dn-table td.dn-angka { text-align: right; }
.nag-skin .dn-table td.dn-tengah { text-align: center; }
/* Kolom Action ditempel di kanan - kolomnya banyak, kalau ikut tergeser
   user harus scroll dulu tiap mau klik Print / Edit / Cancel. */
.nag-skin .dn-table thead th:last-child,
.nag-skin .dn-table tbody td:last-child:not(.dataTables_empty) {
  position: sticky;
  right: 0;
  z-index: 4;
  border-right: 0;
  box-shadow: -7px 0 9px -7px rgba(15, 23, 42, .25);
}
.nag-skin .dn-table thead th:last-child { z-index: 6; background: #1e3a5f; }
.nag-skin .dn-table tbody tr:nth-child(odd)  td:last-child { background: #fff; }
.nag-skin .dn-table tbody tr:nth-child(even) td:last-child { background: #f8fafc; }
.nag-skin .dn-table tbody tr:hover td:last-child { background: #eaf2ff; }

.nag-skin .dn-table td.dataTables_empty {
  text-align: center;
  color: #94a3b8;
  padding: 34px 12px;
  font-size: 13px;
}

/* Status & tombol per baris */
.nag-skin .dn-badge {
  display: inline-block;
  padding: 3px 10px;
  border-radius: 999px;
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .4px;
  text-transform: uppercase;
}
/* Satu warna per status: POST biru, first approval kuning (masih jalan),
   second approval hijau (beres), Cancel merah, sisanya abu. */
.nag-skin .dn-badge.is-post   { background: #e0f2fe; color: #075985; }
.nag-skin .dn-badge.is-first  { background: #fef3c7; color: #92400e; }
.nag-skin .dn-badge.is-second { background: #dcfce7; color: #166534; }
.nag-skin .dn-badge.is-batal  { background: #fee2e2; color: #991b1b; }
.nag-skin .dn-badge.is-lain   { background: #f1f5f9; color: #475569; }
/* Tombol Email: biru keabuan supaya tidak bersaing dengan Print & Edit */
.nag-skin .btn-dn-email {
  background: #475569 !important;
  border-color: #475569 !important;
  color: #fff !important;
}
.nag-skin .btn-dn-email:hover { background: #334155 !important; border-color: #334155 !important; }

/* ── Dialog "Send Debit Note" (SweetAlert2, tombol Email) ─────────────────
   Popup-nya ditaruh SweetAlert2 langsung di <body>, di LUAR .nag-skin, jadi
   selector di sini sengaja TANPA awalan .nag-skin. !important dipakai karena
   templates/header.php menimpa .btn/.btn-primary/.btn-secondary secara global
   dengan !important juga (tema sweetalert2-bootstrap-4 memakai class itu). */
.dn-swal-kirim { border-radius: 14px; }
.dn-swal-kirim .swal2-title { color: #1e3a5f; font-size: 19px; }
.dn-swal-kirim .swal2-icon.swal2-question { border-color: #1e3a5f !important; color: #1e3a5f !important; }
/* Warning dipakai saat Outlook langsung gagal - warna sama dengan "perhatian"
   di tabel (No attachment, dst.), bukan kuning bawaan SweetAlert2. */
.dn-swal-kirim .swal2-icon.swal2-warning { border-color: #dc2626 !important; color: #dc2626 !important; }
.dn-swal-kirim .swal2-input {
  height: 38px !important; margin: 14px auto 0 !important;
  border: 1px solid #e2e8f0 !important; border-radius: 8px !important;
  font-size: 13px !important; box-shadow: none !important;
}
.dn-swal-kirim .swal2-input:focus {
  border-color: #2c5282 !important; box-shadow: 0 0 0 3px rgba(44, 82, 130, .15) !important;
}
.dn-swal-kirim .swal2-confirm { background: #1e3a5f !important; border-color: #1e3a5f !important; }
.dn-swal-kirim .swal2-confirm:hover { filter: brightness(.92); }
.dn-swal-kirim .swal2-confirm:focus { box-shadow: 0 0 0 3px rgba(44, 82, 130, .35) !important; }
.dn-swal-kirim .swal2-cancel { background: #f1f5f9 !important; color: #334155 !important; }
.dn-swal-kirim .swal2-cancel:hover { background: #e2e8f0 !important; }
.dn-swal-kirim .swal2-footer { border-top-color: #eef2f7; }
.dn-swal-kirim .dn-email-kaki { color: #64748b; }
.dn-swal-kirim .dn-email-pakai-skrip { color: #2c5282; font-weight: 600; text-decoration: none; }
.dn-swal-kirim .dn-email-pakai-skrip:hover { color: #1e3a5f; text-decoration: underline; }
.nag-skin .dn-aksi { display: flex; gap: 6px; justify-content: center; }
.nag-skin .dn-aksi .btn {
  height: 30px;
  padding: 0 10px !important;
  font-size: 11.5px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: none !important;
}
.nag-skin .dn-aksi-kosong { color: #94a3b8; font-style: italic; font-size: 12px; }
/* Tombol lampiran (DN sudah first approve: Edit hilang, lampiran masih bisa) */
.nag-skin .dn-aksi .btn-dn-docs {
  background: linear-gradient(135deg, #0e7490, #0891b2) !important;
  border: none !important;
  color: #fff !important;
}

/* ===== Bagian bawaan DataTables (search, jumlah baris, info, halaman) ===== */
.nag-skin .dataTables_wrapper .row:first-child { margin-bottom: 12px; align-items: center; }
.nag-skin .dataTables_wrapper .row:last-child { margin-top: 12px; align-items: center; }
.nag-skin .dataTables_length label,
.nag-skin .dataTables_filter label {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
  color: #64748b;
  text-transform: none;
  font-size: 12px;
  font-weight: 600;
}
.nag-skin .dataTables_length select { width: auto; min-width: 74px; }
.nag-skin .dataTables_filter { text-align: right; }
.nag-skin .dataTables_filter label { justify-content: flex-end; }
.nag-skin .dataTables_filter input { min-width: 240px; }
.nag-skin .dataTables_info { color: #64748b; font-size: 12px; padding-top: 0 !important; }
.nag-skin .dataTables_paginate .pagination { margin: 0; justify-content: flex-end; }
.nag-skin .pagination .page-link {
  border: 1px solid #e2e8f0;
  color: #1e3a5f;
  font-size: 12.5px;
  padding: 5px 11px;
  margin-left: 4px;
  border-radius: 8px !important;
}
.nag-skin .pagination .page-item.active .page-link {
  background: #1e3a5f;
  border-color: #1e3a5f;
  color: #fff;
}
.nag-skin .pagination .page-item.disabled .page-link { color: #cbd5e1; background: #f8fafc; }
/* Tabel lebar - scrollbar dibikin tebal & kontras supaya user sadar masih ada
   kolom di kanan. */
.nag-skin .dataTables_scrollHead {
  border: 1px solid #e2e8f0;
  border-bottom: 0;
  border-radius: 12px 12px 0 0;
  overflow: hidden !important;
}
.nag-skin .dataTables_scrollBody {
  border: 1px solid #e2e8f0;
  border-top: 0;
  border-radius: 0 0 12px 12px;
  scrollbar-color: #64748b #e2e8f0;
  scrollbar-width: auto;
}
.nag-skin .dataTables_scrollBody::-webkit-scrollbar { width: 14px; height: 14px; }
.nag-skin .dataTables_scrollBody::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 8px; }
.nag-skin .dataTables_scrollBody::-webkit-scrollbar-thumb {
  background: #64748b;
  border-radius: 8px;
  border: 3px solid #e2e8f0;
}
.nag-skin .dataTables_scrollBody::-webkit-scrollbar-thumb:hover { background: #475569; }
.nag-skin .dn-table thead th.sorting,
.nag-skin .dn-table thead th.sorting_asc,
.nag-skin .dn-table thead th.sorting_desc { padding-right: 26px; cursor: pointer; }
.nag-skin .dn-table thead th.sorting:hover { background: #24466f; }

/* ===== Modal ===== */
.nag-skin.modal .modal-content { border: none; border-radius: 12px; overflow: hidden; }
.nag-skin.modal .modal-header { background: #1e3a5f; border-bottom: 0; padding: 14px 18px; }
.nag-skin.modal .modal-title { color: #f8fafc; font-size: 14px; font-weight: 600; letter-spacing: .3px; }
.nag-skin.modal .modal-header .close { color: #f8fafc; opacity: .8; text-shadow: none; }
.nag-skin.modal .modal-body { padding: 18px; }
.nag-skin.modal .modal-footer { border-top: 1px solid #eef2f7; padding: 12px 18px; }

/* ===== Layar HP ===== */
@media (max-width: 767.98px) {
  .nag-skin .card > .card-body { padding: 14px; }
  .nag-skin .dn-filter-aksi .btn { flex: 1 1 auto; justify-content: center; }
  .nag-skin .dataTables_length label,
  .nag-skin .dataTables_filter { text-align: left; }
  .nag-skin .dataTables_filter label { justify-content: flex-start; }
  .nag-skin .dataTables_filter input { min-width: 0; width: 100%; }
  .nag-skin .dataTables_paginate .pagination { justify-content: center; margin-top: 8px; }

  /* Tombol aksi jadi ikon saja - dengan teks, kolom Action makan hampir
     separuh lebar layar HP dan kolom datanya nyaris tidak kebagian. */
  .nag-skin .dn-aksi-teks { display: none; }
  .nag-skin .dn-aksi { gap: 4px; }
  .nag-skin .dn-aksi .btn { padding: 0 9px !important; }
  .nag-skin .dn-aksi .btn i { font-size: 13px; }

  /* Baris dirapatkan biar kolom yang kelihatan lebih banyak */
  .nag-skin .dn-table { font-size: 12px; }
  .nag-skin .dn-table thead th { padding: 8px 8px; }
  .nag-skin .dn-table tbody td { padding: 6px 8px; }

  /* Mode HP tidak digeser ke samping (kolom sisanya dilipat jadi baris
     detail), jadi Action tidak perlu ditempel di kanan lagi. */
  .nag-skin .dn-table thead th:last-child,
  .nag-skin .dn-table tbody td:last-child:not(.dataTables_empty) {
    position: static;
    box-shadow: none;
  }

  /* Tombol + untuk membuka detail */
  .nag-skin .dn-table tbody td.dtr-control { cursor: pointer; }
  .nag-skin .dn-table tbody td.dtr-control::before {
    background: #1e3a5f !important;
    border-color: #1e3a5f !important;
    box-shadow: none !important;
  }

  /* Baris detail: pasangan label - nilai */
  .nag-skin .dn-table tbody tr.child td {
    white-space: normal;
    background: #f8fafc !important;
  }
  .nag-skin .dn-table tbody tr.child ul.dtr-details { width: 100%; display: block; }
  .nag-skin .dn-table tbody tr.child ul.dtr-details > li {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 6px 2px;
    border-bottom: 1px solid #e7edf5;
  }
  .nag-skin .dn-table tbody tr.child ul.dtr-details > li:last-child { border-bottom: 0; }
  .nag-skin .dn-table tbody tr.child .dtr-title {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .3px;
    text-transform: uppercase;
    color: #64748b;
    min-width: 0;
  }
  .nag-skin .dn-table tbody tr.child .dtr-data { text-align: right; color: #1e293b; }
}
</style>
