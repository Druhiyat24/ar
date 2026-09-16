<?php
// Form ini dipakai Create DAN Edit Debit Note (edit_debitnote.php meng-include
// file ini dengan $is_edit = true) supaya tampilan & alurnya selalu sama.
// Mode edit: isian diambil dari DN yang dibuka, No Memo / No Request diganti
// info sumber (read-only), dan baris detail dari Memo / Request terkunci.
$is_edit = !empty($is_edit);
// DN yang sudah first approve: isinya tidak boleh diubah lagi, tapi lampiran
// masih boleh sampai sebelum second approve (lihat Arnag::edit_debitnote).
$hanya_dokumen = $is_edit && !empty($dn_hanya_dokumen);
$dn      = $is_edit ? $data_dn : array();
$dn_det  = ($is_edit && !empty($data_dn_det)) ? $data_dn_det : array();
$dn_docs = ($is_edit && !empty($dn_docs)) ? $dn_docs : array();
$esc     = function ($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); };
$dnv     = function ($kolom, $default = '') use ($dn) {
  return (isset($dn[$kolom]) && $dn[$kolom] !== null && $dn[$kolom] !== '') ? $dn[$kolom] : $default;
};
// Baris dari Memo (id_memo_det terisi) / Request (nm_memo = no BPB request) -
// aturan yang sama dengan Model_nag::dn_baris_terkunci.
$baris_terkunci = function ($row) {
  return trim((string) $row['id_memo_det']) !== '' || trim((string) $row['nm_memo']) !== '';
};
$ada_terkunci = false;
foreach ($dn_det as $row) {
  if ($baris_terkunci($row)) { $ada_terkunci = true; break; }
}
$nama_header = array();
for ($i = 1; $i <= 5; $i++) {
  $nama_header[$i] = $is_edit ? (string) $dnv('header' . $i) : '';
}
?>
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
/* ==========================================================================
   Create Debit Note - palet & komponen disamakan dengan Projection Report.
   Semua di-scope ke .nag-skin: class ini dipasang di .content-wrapper DAN di
   modal milik halaman ini (modal ada di luar .content-wrapper), jadi keduanya
   ikut ter-style tanpa menyentuh halaman lain.

   templates/header.php punya style global ber-!important (.form-control
   background putih + border + padding, .btn padding + shadow, .table thead).
   Karena itu:
   - tabel di sini sengaja TIDAK pakai class .table (sama seperti Projection
     Report) supaya header navy-nya tidak ketimpa;
   - properti yang memang harus beda dari global diberi !important.
   ========================================================================== */

.select2-selection--multiple {
  overflow: hidden !important;
  height: auto !important;
}

.nag-skin > .content { padding-top: 14px; }

/* ===== Card ===== */
/* Sengaja TANPA overflow:hidden (beda dengan Projection Report) - dropdown
   No Request (bootstrap-select) dirender di dalam kartu, bakal kepotong. */
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

/* Dua kartu form di atas dibikin sama tinggi */
.nag-skin .dn-form-row > [class*="col-"] { display: flex; }
.nag-skin .dn-form-row > [class*="col-"] > .card { flex: 1; }

/* ===== Label & kontrol form ===== */
.nag-skin label {
  font-size: 11.5px;
  font-weight: 600;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #64748b;
  margin-bottom: 6px;
}
.nag-skin .form-group { margin-bottom: 14px; }
/* Semua kontrol disamakan tingginya: input, select2, ikon kalender, tombol */
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
.nag-skin .form-control::placeholder { color: #94a3b8; }
.nag-skin .form-control:focus {
  border-color: #2c5282;
  box-shadow: 0 0 0 3px rgba(44, 82, 130, .15);
}
.nag-skin textarea.form-control { height: auto; line-height: 1.5; resize: vertical; }
/* Abu = tidak bisa diketik (No Memo, Header 1-3 yang belum diaktifkan, dst) */
.nag-skin .form-control[readonly] { background: #f8fafc !important; color: #334155; }

/* Nomor DN dibikin menonjol - ini identitas dokumen yang sedang dibuat */
.nag-skin #dn_number {
  background: #eef2f7 !important;
  border-color: #dbe3ee !important;
  color: #1e3a5f;
  font-weight: 700;
  letter-spacing: .4px;
}

/* select2 defaultnya inline-block - menyisakan celah baseline di bawahnya.
   Tema select2 juga mengunci tingginya pakai em, jadi harus !important. */
.nag-skin .select2-container { display: block; width: 100% !important; }
.nag-skin .select2-container .select2-selection--single {
  height: 38px !important;
  padding: 0;
}
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

/* Input + ikon kalender / tombol di kanan jadi satu kesatuan */
.nag-skin .input-group > .form-control:not(:last-child) { border-radius: 8px 0 0 8px !important; }
.nag-skin .input-group-text {
  border-radius: 0 8px 8px 0;
  border-left: 0 !important;
  background: #f8fafc;
  color: #64748b;
}
.nag-skin .input-group-append > .btn { border-radius: 0 8px 8px 0 !important; box-shadow: none !important; }

/* Warna tombol sengaja TIDAK diubah - yang dirapikan cuma jarak ikon ke teks,
   bobot huruf, dan bayangannya. Kecuali tiga tombol baris di bawah: warnanya
   sengaja disamarkan (pastel) karena kalau memakai biru/merah solid, terlihat
   sama pentingnya dengan Save/Back padahal cuma aksi bantu di dalam tabel. */
.nag-skin .btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  border-color: transparent;
  font-weight: 500;
  box-shadow: 0 1px 2px rgba(15, 23, 42, .12);
}
.nag-skin .btn i { font-size: 12.5px; }
.nag-skin .btn:hover { filter: brightness(.93); }
.nag-skin .btn:active { filter: brightness(.88); }
.nag-skin .btn-light { background: #f1f5f9; color: #334155; }
/* Aksi baris (tabel rincian) - warna pastel dari palet badge status yang sama
   dengan kolom Status, jadi tetap satu bahasa warna dengan menu lain. */
.nag-skin .btn-dn-tambah-baris { background: #bbf7d0 !important; color: #166534; border: 1px solid #86efac !important; }
.nag-skin .btn-dn-sisip-baris  { background: #fde68a !important; color: #92400e; border: 1px solid #fcd34d !important; }
.nag-skin .btn-dn-hapus-baris  { background: #fecaca !important; color: #991b1b; border: 1px solid #fca5a5 !important; }

/* ===== Dropdown No Request (bootstrap-select) =====
   Div pembungkusnya ikut dapat class .form-control (kena border & padding
   global -> kotak dobel), dan tombolnya juga .btn - dua-duanya dibalikin
   supaya tampil seperti input biasa. */
.nag-skin .bootstrap-select.form-control {
  height: auto;
  padding: 0 !important;
  border: 0 !important;
  background: transparent !important;
  box-shadow: none !important;
}
.nag-skin .bootstrap-select > .dropdown-toggle,
.nag-skin .bootstrap-select > .dropdown-toggle:hover {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  color: #1e293b;
  box-shadow: none !important;
  filter: none;
  padding: 0 12px !important;
}
.nag-skin .bootstrap-select > .dropdown-toggle .filter-option { height: auto; }
.nag-skin .bootstrap-select > .dropdown-toggle.bs-placeholder,
.nag-skin .bootstrap-select > .dropdown-toggle.bs-placeholder:hover { color: #94a3b8; }
.nag-skin .bootstrap-select > .dropdown-toggle:focus,
.nag-skin .bootstrap-select.show > .dropdown-toggle {
  outline: none !important;
  border-color: #2c5282;
  box-shadow: 0 0 0 3px rgba(44, 82, 130, .15) !important;
}
.nag-skin .bootstrap-select .dropdown-menu {
  border-color: #e2e8f0;
  border-radius: 10px;
  box-shadow: 0 10px 25px rgba(15, 23, 42, .12);
  padding: 6px;
  font-size: 13px;
}
.nag-skin .bootstrap-select .bs-searchbox { padding: 2px 2px 6px; }
.nag-skin .bootstrap-select .bs-searchbox .form-control { height: 34px; }
.nag-skin .bootstrap-select .dropdown-menu li a {
  border-radius: 6px;
  padding: 7px 12px;
  color: #1e293b;
}
/* Yang sudah dipilih: abu lembut. Yang sedang disorot: navy. */
.nag-skin .bootstrap-select .dropdown-menu li.selected a {
  background: #eef2f7;
  color: #0f172a;
  font-weight: 600;
}
.nag-skin .bootstrap-select .dropdown-menu li a:hover,
.nag-skin .bootstrap-select .dropdown-menu li a.active {
  background: #1e3a5f;
  color: #f8fafc;
}

/* ===== Currency From -> To ===== */
.nag-skin .dn-curr { display: flex; align-items: center; gap: 10px; }
.nag-skin .dn-curr .form-control { flex: 1; }
.nag-skin .dn-curr-sep { color: #94a3b8; font-size: 12px; }

/* ===== Kolom tambahan (Header 1-3) ===== */
.nag-skin .dn-subhead {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 4px 0 12px;
  font-size: 11.5px;
  font-weight: 600;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #64748b;
}
.nag-skin .dn-subhead::after { content: ""; flex: 1; height: 1px; background: #eef2f7; }
.nag-skin .dn-opt {
  display: grid;
  grid-template-columns: 120px 1fr;
  align-items: center;
  gap: 12px;
  margin-bottom: 10px;
}
.nag-skin .dn-opt:last-child { margin-bottom: 0; }
.nag-skin .dn-opt .custom-control-label {
  margin: 0;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0;
  text-transform: none;
  color: #334155;
  cursor: pointer;
}
.nag-skin .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #1e3a5f;
  border-color: #1e3a5f;
}
.nag-skin .custom-control-input:focus ~ .custom-control-label::before {
  box-shadow: 0 0 0 3px rgba(44, 82, 130, .15);
}
.nag-skin .custom-control-input:focus:not(:checked) ~ .custom-control-label::before { border-color: #2c5282; }

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
/* ===== Judul tabel + tombol aksi / search box ===== */
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
.nag-skin .dn-toolbar { display: flex; flex-wrap: wrap; gap: 8px; }
.nag-skin .search-box { position: relative; }
.nag-skin .search-box input {
  height: 38px;
  padding: 0 34px 0 14px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 13px;
  min-width: 260px;
  transition: border-color .15s ease, box-shadow .15s ease;
}
.nag-skin .search-box input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, .15); }
.nag-skin .search-box i { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }

/* ===== Kontainer scroll tabel ===== */
.nag-skin .dn-table-wrap {
  position: relative;
  overflow: auto;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  background: #fff;
  -webkit-overflow-scrolling: touch;
}
#dn-table-wrap  { min-height: 220px; max-height: 420px; }
#dn-memo-wrap   { min-height: 200px; max-height: 320px; }
/* Scrollbar dibikin tebal & kontras - tabel detail lebar, kalau tipis/pucat
   user tidak sadar kalau masih ada kolom di kanan. */
.nag-skin .dn-table-wrap { scrollbar-color: #64748b #e2e8f0; scrollbar-width: auto; }
.nag-skin .dn-table-wrap::-webkit-scrollbar { width: 14px; height: 14px; }
.nag-skin .dn-table-wrap::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 8px; }
.nag-skin .dn-table-wrap::-webkit-scrollbar-thumb {
  background: #64748b;
  border-radius: 8px;
  border: 3px solid #e2e8f0;
}
.nag-skin .dn-table-wrap::-webkit-scrollbar-thumb:hover { background: #475569; }
.nag-skin .dn-table-wrap::-webkit-scrollbar-corner { background: #e2e8f0; }

/* ===== Tabel ===== */
.nag-skin .dn-table {
  width: 100%;
  margin: 0;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 12.5px;
  color: #1e293b;
}
.nag-skin .dn-table thead th {
  position: sticky;
  top: 0;
  z-index: 10;
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
  padding: 6px 8px;
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
.nag-skin .dn-table tbody .form-control {
  height: 34px;
  border-radius: 6px !important;
  font-size: 12.5px !important;
  padding: 4px 10px !important;
}
.nag-skin .dn-table tbody .form-control[readonly] { background: #f1f5f9 !important; color: #475569; }
.nag-skin .dn-table input[type="checkbox"] {
  width: 16px;
  height: 16px;
  margin: 0;
  vertical-align: middle;
  accent-color: #1e3a5f;
  cursor: pointer;
}

/* Nama kolom Header 1-3 di thead berupa input readonly - dibikin menyatu
   dengan header navy. Placeholder pudar = kolomnya belum dipakai. */
.nag-skin .dn-table thead .dn-th-input,
.nag-skin .dn-table thead .dn-th-input:focus {
  height: auto;
  min-width: 120px;
  padding: 0 !important;
  border: 0 !important;
  background: transparent !important;
  box-shadow: none !important;
  color: #f8fafc;
  font-size: 11px !important;
  font-weight: 600;
  letter-spacing: .4px;
  text-transform: uppercase;
  text-align: center;
  cursor: default;
}
.nag-skin .dn-table thead .dn-th-input::placeholder { color: rgba(248, 250, 252, .45); }

/* select2 di tabel detail (kolom Supplier & kolom Header bernama Supplier) -
   tingginya disamakan dengan input di tabel (34px). */
.nag-skin .dn-table td .select2-container {
  display: inline-block;
  width: 100% !important;
  min-width: 200px;
  vertical-align: middle;
}
.nag-skin .dn-table td .select2-container .select2-selection--single { height: 34px !important; }
.nag-skin .dn-table td .select2-container .select2-selection--single .select2-selection__rendered {
  line-height: 32px;
  font-size: 12.5px;
}
.nag-skin .dn-table td .select2-container .select2-selection--single .select2-selection__arrow { height: 32px; }
.nag-skin .dn-table td .select2-container--disabled .select2-selection { background: #f1f5f9 !important; }

/* Kolom ke-12 dst isinya input hidden (id memo, no bpb, consignee) dan tidak
   punya header. Di baris hasil addRow() atribut hidden-nya tidak ikut
   ter-clone, jadi muncul sebagai kolom kosong - disembunyikan lewat CSS.
   Nilainya tetap terbaca waktu save karena elemennya masih ada di DOM.
   (11 kolom tampil: Description, Header 1-5, Value, Rate, Amount, COA, Cek) */
.nag-skin #table-dn tbody td:nth-child(n+12) { display: none; }
.nag-skin #table-dn thead th:nth-child(11) { width: 44px; }
.nag-skin #table-dn tbody td:nth-child(11) { text-align: center; }

/* ===== Mode edit ===== */
/* Keterangan di atas form waktu DN cuma bisa diurus lampirannya */
.nag-skin .dn-banner-dokumen {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin-bottom: 14px;
  padding: 12px 16px;
  border: 1px solid #fde68a;
  border-radius: 10px;
  background: #fffbeb;
  color: #92400e;
  font-size: 12.5px;
  line-height: 1.55;
}
.nag-skin .dn-banner-dokumen i { margin-top: 2px; opacity: .8; }
/* Isian terkunci di mode itu - dibedakan dari field readonly biasa */
.nag-skin .dn-terkunci .form-control,
.nag-skin .dn-terkunci .select2-selection {
  background: #f1f5f9 !important;
  color: #64748b !important;
}
.nag-skin .dn-hint { display: block; margin-top: 5px; font-size: 11.5px; color: #b45309; }
.nag-skin .dn-hint[hidden] { display: none; }
.nag-skin .dn-curr + .dn-hint { color: #64748b; }
/* Nama COA di bawah kode COA (kolom Value Rate Amount COA - lihat #nm_coa
   datalist). Cuma keterangan, bukan bagian dari nilai yang disimpan. */
.nag-skin .dn-coa-nama { display: block; margin-top: 3px; font-size: 10.5px; color: #64748b; white-space: normal; }
.nag-skin .dn-coa-nama:empty { display: none; }
/* Baris dari Memo / Request: terkunci, tidak bisa diubah / dihapus */
.nag-skin #table-dn tbody tr[data-kunci="1"] td { background: #f1f5f9; }
.nag-skin #table-dn tbody tr[data-kunci="1"] .form-control[readonly] { background: #e9eef4 !important; color: #475569; cursor: not-allowed; }
.nag-skin #table-dn tbody tr[data-kunci="1"] .select2-container--disabled .select2-selection { background: #e9eef4 !important; cursor: not-allowed; }
.nag-skin #table-dn tbody tr[data-kunci="1"] .select2-selection__rendered { color: #475569 !important; }
.nag-skin .dn-table td .select2-container--disabled .select2-selection__clear { display: none; }
.nag-skin .dn-kunci-ikon { color: #94a3b8; font-size: 12px; }
.nag-skin .dn-hint-tabel { margin: -4px 0 10px; color: #64748b; }
/* Chip dokumen yang sudah tersimpan (tidak bisa dihapus dari sini) */
.nag-skin .dn-doc-item.is-lama { background: #f8fafc; border-style: dashed; }
.nag-skin .dn-doc-tersimpan { font-size: 10.5px; color: #15803d; white-space: nowrap; }

.nag-skin #table-inv-memo tbody td { padding: 8px 12px; }
.nag-skin #table-inv-memo tbody td:nth-child(8) { text-align: right; }
.nag-skin #table-inv-memo tbody td:nth-child(9) { text-align: center; }

/* Keterangan saat tabel masih kosong. Disembunyikan begitu ada baris yang
   tampil (baris template #tbody2 selalu display:none, jadi tidak dihitung). */
.nag-skin .dn-empty {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  padding: 40px 12px;
  color: #94a3b8;
  font-size: 12.5px;
  text-align: center;
}
.nag-skin .dn-empty i { font-size: 22px; opacity: .6; }
#dn-table-wrap:has(#tbody2 > tr:not([style*="none"])) .dn-empty,
#dn-memo-wrap:has(#table-inv-memo tbody tr) .dn-empty { display: none; }
/* Tabel masih kosong (baris pertama kali dibuka): kolom disamakan lebarnya
   kecuali Cek, supaya rapi - tanpa ini "table-layout:auto" cuma menuruti
   lebar bawaan <input> di header Header 1-5, sisanya (Description, Value,
   dst - cuma teks) jadi sempit sekali. Begitu ada baris beneran, kembali ke
   lebar tetap per kolom (input 300/200/150/250px) supaya bisa digeser. */
#dn-table-wrap:not(:has(#tbody2 > tr:not([style*="none"]))) #table-dn { table-layout: fixed; }

/* ===== Ringkasan total + tombol simpan ===== */
.nag-skin .dn-sum-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 9px 0;
  border-bottom: 1px dashed #e2e8f0;
}
.nag-skin .dn-sum-row > span {
  font-size: 11.5px;
  font-weight: 600;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #64748b;
  white-space: nowrap;
}
.nag-skin .dn-sum-row .form-control[readonly] {
  height: auto;
  padding: 0 !important;
  border: 0 !important;
  background: transparent !important;
  box-shadow: none !important;
  text-align: right;
  font-size: 16px !important;
  font-weight: 700;
  color: #0f172a;
  font-variant-numeric: tabular-nums;
}
.nag-skin .dn-summary .card-body { padding-top: 8px !important; }
.nag-skin .dn-save-bar { display: flex; justify-content: flex-end; margin-top: 14px; }
.nag-skin .dn-summary .btn-save {
  min-width: 130px;
  height: 40px;
  padding: 0 24px !important;
  font-size: 14px;
}

/* ===== Modal ===== */
.dn-modal .modal-content {
  border: 0;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(15, 23, 42, .25);
}
.dn-modal .modal-header {
  background: #1e3a5f;
  border-bottom: 0;
  padding: 13px 18px;
  align-items: center;
}
.dn-modal .modal-title {
  display: flex;
  align-items: center;
  gap: 9px;
  color: #f8fafc;
  font-size: 14px;
  font-weight: 600;
  letter-spacing: .3px;
}
.dn-modal .modal-title i { opacity: .75; font-size: 13px; }
.dn-modal .modal-header .close { color: #f8fafc; opacity: .85; text-shadow: none; }
.dn-modal .modal-header .close:hover { opacity: 1; }
.dn-modal .modal-body { padding: 18px; }
.dn-modal .modal-footer { border-top: 1px solid #eef2f7; padding: 12px 18px; }
.dn-modal .dn-footer-actions { display: flex; gap: 8px; }

/* Panel filter di modal Add Memo */
.nag-skin .dn-filter {
  background: #f8fafc;
  border: 1px solid #eef2f7;
  border-radius: 10px;
  padding: 14px 16px;
  margin-bottom: 16px;
}
/* header.php men-nol-kan margin form-group di .row.align-items-end - di HP
   (kolom bertumpuk) jaraknya dikembalikan. */
@media (max-width: 767.98px) {
  .nag-skin .dn-filter .form-group { margin-bottom: 10px !important; }
  .nag-skin .dn-filter .form-group:last-child { margin-bottom: 0 !important; }
}

/* Total memo di footer modal */
.nag-skin .dn-sum-inline { justify-content: flex-start; gap: 16px; border-bottom: 0; padding: 0; }
.nag-skin .dn-sum-inline .form-control[readonly] { width: 180px; text-align: left; }

/* Isi swal konfirmasi & info simpan (swal dirender di luar .nag-skin) */
.dn-swal-catatan { margin-top: 12px; font-size: 12.5px; color: #64748b; }
.dn-swal-label { font-size: 11.5px; font-weight: 600; letter-spacing: .4px; text-transform: uppercase; color: #64748b; }
.dn-swal-nomor { margin-top: 4px; font-size: 21px; font-weight: 700; letter-spacing: .4px; color: #1e3a5f; }

/* ===== Supporting document ===== */
.nag-skin .dn-optional {
  margin-left: 6px;
  padding: 1px 7px;
  border-radius: 999px;
  background: #f1f5f9;
  color: #94a3b8;
  font-size: 9.5px;
  letter-spacing: .4px;
  vertical-align: 1px;
}
.nag-skin .dn-doc-drop {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 10px 12px;
  padding: 10px 12px;
  border: 1.5px dashed #cbd5e1;
  border-radius: 10px;
  background: #f8fafc;
  transition: border-color .15s ease, background .15s ease;
}
.nag-skin .dn-doc-drop.is-drag { border-color: #2c5282; background: #eef2f7; }
.nag-skin .dn-doc-hint { font-size: 12px; color: #94a3b8; }
.nag-skin .dn-doc-jumlah { margin-left: 8px; color: #1e3a5f; letter-spacing: 0; text-transform: none; }

/* File tampil sebagai chip berjejer di dalam kotak upload - lebih dari ~2
   baris scroll di dalam kotak, jadi form tidak memanjang ke bawah. */
.nag-skin .dn-doc-list {
  flex: 1 0 100%;
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  max-height: 72px;
  margin: 0;
  padding: 0 2px 0 0;
  overflow-y: auto;
  list-style: none;
}
.nag-skin .dn-doc-list:empty { display: none; }
.nag-skin .dn-doc-item {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  max-width: 100%;
  height: 30px;
  padding: 0 2px 0 9px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  background: #fff;
}
.nag-skin .dn-doc-ikon { flex: 0 0 auto; font-size: 13px; }
.nag-skin .dn-doc-ikon.is-pdf { color: #b91c1c; }
.nag-skin .dn-doc-ikon.is-img { color: #0369a1; }
.nag-skin .dn-doc-nama {
  max-width: 160px;
  overflow: hidden;
  font-size: 12.5px;
  color: #1e293b;
  text-overflow: ellipsis;
  white-space: nowrap;
  cursor: pointer;
}
.nag-skin .dn-doc-nama:hover { color: #1d4ed8; text-decoration: underline; }
.nag-skin .dn-doc-ukuran { font-size: 11px; color: #94a3b8; white-space: nowrap; }
.nag-skin .dn-doc-aksi { display: inline-flex; }
.nag-skin .dn-doc-aksi .btn,
.nag-skin .dn-doc-aksi .btn:hover {
  width: 24px;
  height: 24px;
  padding: 0 !important;
  border-radius: 6px !important;
  background: transparent;
  color: #64748b;
  font-size: 11px;
  box-shadow: none !important;
  filter: none;
}
.nag-skin .dn-doc-aksi .btn:hover { background: #eef2f7; color: #1e3a5f; }
.nag-skin .dn-doc-aksi .dn-doc-hapus:hover { background: #fee2e2; color: #b91c1c; }

/* Progres upload di swal */
.dn-upload-bar { height: 6px; margin-top: 12px; overflow: hidden; border-radius: 999px; background: #e2e8f0; }
.dn-upload-bar > span { display: block; width: 0; height: 100%; background: #1e3a5f; transition: width .2s ease; }


/* ===== Penampil supporting document (modal) ===== */
.dn-doc-dialog { max-width: min(1320px, 94vw); }
.dn-doc-dialog .modal-content { height: 90vh; }
.dn-doc-head { flex: 1; min-width: 0; }
.dn-doc-head .modal-title { min-width: 0; }
.dn-doc-head .modal-title span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.dn-doc-meta { margin: 3px 0 0 22px; font-size: 11.5px; color: rgba(248, 250, 252, .6); }
.dn-doc-posisi {
  margin: 0 6px 0 16px;
  padding: 3px 11px;
  border-radius: 999px;
  background: rgba(255, 255, 255, .12);
  color: #f8fafc;
  font-size: 12px;
  font-weight: 600;
  white-space: nowrap;
  font-variant-numeric: tabular-nums;
}
.dn-doc-body { display: flex; flex: 1 1 auto; min-height: 0; }

/* Daftar dokumen di kiri */
.dn-doc-side {
  flex: 0 0 250px;
  display: flex;
  flex-direction: column;
  min-height: 0;
  border-right: 1px solid #e2e8f0;
  background: #f8fafc;
}
.dn-doc-side-judul {
  padding: 14px 16px 8px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #64748b;
}
.dn-doc-side-list { flex: 1; margin: 0; padding: 0 8px 10px; overflow-y: auto; list-style: none; }
.dn-doc-side-list li {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 2px;
  padding: 7px 8px;
  border: 1px solid transparent;
  border-radius: 8px;
  cursor: pointer;
}
.dn-doc-side-list li:hover { background: #eef2f7; }
.dn-doc-side-list li.is-aktif {
  border-color: #cbd5e1;
  background: #fff;
  box-shadow: inset 3px 0 0 #1e3a5f, 0 1px 2px rgba(15, 23, 42, .06);
}
.dn-doc-thumb {
  flex: 0 0 38px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 38px;
  height: 38px;
  overflow: hidden;
  border-radius: 6px;
  font-size: 16px;
}
.dn-doc-thumb.is-pdf { background: #fee2e2; color: #b91c1c; }
.dn-doc-thumb.is-img { background: #e0f2fe; color: #0369a1; }
.dn-doc-thumb img { width: 100%; height: 100%; object-fit: cover; }
.dn-doc-side-info { display: flex; flex-direction: column; min-width: 0; }
.dn-doc-side-nama { overflow: hidden; font-size: 12.5px; color: #1e293b; text-overflow: ellipsis; white-space: nowrap; }
.dn-doc-side-list li.is-aktif .dn-doc-side-nama { font-weight: 600; color: #0f172a; }
.dn-doc-side-ukuran { font-size: 11px; color: #94a3b8; }

/* Area preview - latar abu gelap senada penampil PDF bawaan browser */
.dn-doc-preview {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 0;
  overflow: hidden;
  background: #525659;
}
.dn-doc-preview iframe { display: block; width: 100%; height: 100%; border: 0; }
.dn-doc-preview img {
  display: block;
  max-width: calc(100% - 40px);
  max-height: calc(100% - 40px);
  border-radius: 4px;
  box-shadow: 0 6px 24px rgba(0, 0, 0, .35);
  background: #fff;
  cursor: zoom-in;
}
/* Gambar diklik -> ukuran asli, bisa digeser */
.dn-doc-preview.is-zoom { align-items: flex-start; justify-content: flex-start; overflow: auto; }
.dn-doc-preview.is-zoom img { max-width: none; max-height: none; margin: 20px; cursor: zoom-out; }

.dn-doc-nav { display: flex; flex-wrap: wrap; gap: 8px; }
.nag-skin .dn-doc-btn-hapus { color: #b91c1c; }
.nag-skin .dn-doc-btn-hapus:hover { background: #fee2e2; }

@media (max-width: 767.98px) {
  .dn-doc-side { display: none; }
  .dn-doc-dialog { max-width: none; margin: 0; }
  .dn-doc-dialog .modal-content { height: 100vh; border-radius: 0 !important; }
}
.dn-swal-list { margin: 10px 0 0; padding-left: 18px; text-align: left; font-size: 13px; }

/* ===== Layar HP ===== */
@media (max-width: 767.98px) {
  .nag-skin .search-box,
  .nag-skin .search-box input { width: 100%; min-width: 0; }
  .nag-skin .dn-toolbar { width: 100%; }
  .nag-skin .dn-toolbar .btn { flex: 1 1 auto; white-space: nowrap; }
  .dn-modal .modal-footer .dn-sum-inline,
  .dn-modal .modal-footer .dn-footer-actions { width: 100%; }
  .dn-modal .modal-footer .dn-footer-actions .btn { flex: 1; }
}
</style>

<div class="content-wrapper nag-skin">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <?php if ($hanya_dokumen) : ?>
        <div class="dn-banner-dokumen">
          <i class="fas fa-lock"></i>
          <div>
            <b>This debit note is already <?= $esc(strtolower($dnv('status'))); ?>.</b>
            Its content can no longer be changed - only the supporting documents below,
            and only until it is second approved.
          </div>
        </div>
      <?php endif; ?>
      <div class="row dn-form-row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas <?= $is_edit ? 'fa-edit' : 'fa-file-invoice'; ?>"></i><?= $title; ?></h3>
            </div>
            <div class="card-body">
              <!-- Hidden Element: ID Invoice, ID Customer, ID TOP, nama consignee, COA -->
              <input type="hidden" class="form-control" id="id_inv" name="id_inv" readonly required>
              <input type="hidden" class="form-control" id="id_cust" name="id_cust" readonly required>
              <input type="hidden" class="form-control" id="id_top" name="id_top" readonly required>
              <input type="hidden" class="form-control" id="nama_supp" name="nama_supp" readonly>
              <input type="hidden" class="form-control" id="no_coa_deb3" name="no_coa_deb3" readonly>
              <input type="hidden" class="form-control" id="nama_coa_deb3" name="nama_coa_deb3" readonly>
              <!-- /. Hidden Element -->

              <!-- Profit Center di samping nomor DN - nomornya ikut kode profit center -->
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="dn_number">Debit Note Number</label>
                  <input type="text" class="form-control" id="dn_number" name="dn_number" value="<?= $is_edit ? $esc($dn['no_dn']) : $kode_alokasi; ?>" required readonly>
                  <?php if ($is_edit) : ?>
                    <small class="dn-hint" id="dn-nomor-hint" hidden><i class="fas fa-info-circle"></i> A new number will be generated for this profit center when saved.</small>
                  <?php endif; ?>
                </div>
                <div class="form-group col-sm-6">
                  <label for="profit_center_dn">Profit Center</label>
                  <select class="form-control select2bs4" id="profit_center_dn" name="profit_center_dn" onchange="<?= $is_edit ? 'dn_edit_pc_berubah()' : 'updateDN()'; ?>" required>
                    <?php foreach ($profit_center as $pc) : ?>
                      <option value="<?= $pc['kode_pc']; ?>" <?= ($is_edit && $dnv('profit_center') == $pc['kode_pc']) ? 'selected' : ''; ?>><?= $pc['nama_pc']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="dn_date">Date</label>
                  <div class="input-group">
                    <?php if ($is_edit) : ?>
                      <input type="text" name="dn_date" id="dn_date" class="form-control tanggal" value="<?= $esc($dnv('tgl_dn', date('Y-m-d'))); ?>" autocomplete='off'>
                    <?php else : ?>
                      <input type="text" name="dn_date" id="dn_date" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" onchange="ubahnomor_dn(this.value, document.getElementById('profit_center_dn').value)" autocomplete='off'>
                    <?php endif; ?>
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
                <div class="form-group col-sm-6">
                  <label for="dn_duedate">Due Date</label>
                  <div class="input-group">
                    <input type="text" name="dn_duedate" id="dn_duedate" class="form-control tanggal" value="<?= $is_edit ? $esc($dnv('due_date', date('Y-m-d'))) : date('Y-m-d'); ?>" autocomplete='off'>
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="customer">Consignee</label>
                <!-- get_alamat_edit pakai URL absolut (halaman edit ada di arnag/edit_debitnote/ID) -->
                <select class="form-control select2bs4" id="customer" name="customer" onchange="<?= $is_edit ? 'get_alamat_edit' : 'get_alamat'; ?>(this.value)" required>
                  <?php if (!$is_edit) : ?>
                    <option value="" selected disabled>-- Select Consignee --</option>
                  <?php endif; ?>
                  <?php foreach ($customer as $cs) : ?>
                    <option value="<?= $cs['Id_Supplier']; ?>" <?= ($is_edit && $dnv('customer') == $cs['Id_Supplier']) ? 'selected' : ''; ?>><?= $cs['Supplier']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="txt_attn">Attn</label>
                <input type="text" class="form-control" id="txt_attn" name="txt_attn" value="<?= $is_edit ? $esc($dnv('attn')) : ''; ?>" autocomplete='off' required>
              </div>

              <?php if ($is_edit) : ?>
                <!-- Edit: sumber data DN (read-only). Baris dari Memo / Request terkunci. -->
                <div class="form-group">
                  <label>Source</label>
                  <input type="text" class="form-control" value="<?= !empty($reff_dn['reff_doc']) ? $esc($reff_dn['text_reff_doc'] . ': ' . $reff_dn['reff_doc']) : 'Manual input'; ?>" readonly>
                </div>
              <?php else : ?>
              <div class="form-group">
                <label for="no_memo">No Memo</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="no_memo" name="no_memo" readonly required>
                  <div class="input-group-append">
                    <button id="so_number2" name="so_number2" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add-memo" onclick="add_memo()"><i class="fas fa-plus"></i> Add Memo</button>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>No Request</label>
                <select class="form-control selectpicker" multiple="" id="no_req" name="no_req" data-width="100%" data-dropup-auto="false" data-live-search="true" data-size="5" onchange="getdata_reqdn(value)">
                  <?php foreach ($data_req as $req) : ?>
                    <option value="<?= $req['id']; ?>"><?= $req['no_req']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <?php endif; ?>

              <!-- Supporting document: tidak wajib, bisa lebih dari 1 file. File baru
                   di-upload setelah Debit Note tersimpan (lihat dn_upload_dokumen). -->
              <div class="form-group mb-0">
                <label>Supporting Documents <span class="dn-doc-jumlah" id="dn-doc-jumlah"></span></label>
                <!-- File tampil sebagai chip di dalam kotak ini (maks ~2 baris, sisanya
                     scroll) supaya form tidak memanjang ke bawah. -->
                <div class="dn-doc-drop" id="dn-doc-drop">
                  <input type="file" id="dn_doc_input" class="d-none" multiple accept=".pdf,.jpg,.jpeg,.png,.gif,.webp" onchange="dn_doc_tambah(this.files); this.value = '';">
                  <button type="button" class="btn btn-light" onclick="document.getElementById('dn_doc_input').click()"><i class="fas fa-paperclip"></i> Choose Files</button>
                  <span class="dn-doc-hint">or drop files here &middot; PDF or image</span>
                  <ul class="dn-doc-list" id="dn-doc-list"></ul>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-sliders-h"></i>Account &amp; Currency</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="akun">Bank Account</label>
                <select class="form-control select2bs4" id="akun" name="akun">
                  <?php foreach ($bank as $bk) : ?>
                    <option value="<?= $bk['akun']; ?>" <?= ($is_edit && $dnv('akun') == $bk['akun']) ? 'selected' : ''; ?>><?= $bk['nama']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="curr1">Currency From - To</label>
                <!-- Currency tetap bisa diubah walau detailnya berisi baris dari
                     Memo / Request: Amount tiap baris dihitung ulang dari Value x
                     Rate memakai currency ini. -->
                <div class="dn-curr">
                  <?php foreach (array('curr1' => 'from_curr', 'curr2' => 'to_curr') as $id_curr => $kolom_curr) : ?>
                    <?php if ($id_curr === 'curr2') : ?><span class="dn-curr-sep"><i class="fas fa-arrow-right"></i></span><?php endif; ?>
                    <select class="form-control" id="<?= $id_curr; ?>" name="<?= $id_curr; ?>" required onchange="modal_input_rate_dn(this.value)">
                      <?php foreach (array('IDR', 'USD') as $kode_curr) : ?>
                        <option value="<?= $kode_curr; ?>" <?= ($is_edit && $dnv($kolom_curr) === $kode_curr) ? 'selected' : ''; ?>><?= $kode_curr; ?></option>
                      <?php endforeach; ?>
                    </select>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="form-group">
                <label for="alamat">Address</label>
                <textarea rows="3" class="form-control" id="alamat" name="alamat" autocomplete='off' required><?= $is_edit ? $esc($dnv('alamat')) : ''; ?></textarea>
              </div>

              <!-- Header 1-5: nama kolom tambahan di tabel detail. Header 4-5
                   tersimpan setelah migrations/20260911_debitnote_header4_header5.sql
                   dijalankan. -->
              <div class="dn-subhead">Additional Columns</div>
              <?php for ($no_h = 1; $no_h <= 5; $no_h++) : $aktif_h = ($nama_header[$no_h] !== ''); ?>
                <div class="dn-opt">
                  <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" id="cek_header<?= $no_h; ?>" name="cek_header<?= $no_h; ?>" onclick="dn_toggle_header(<?= $no_h; ?>, this)" <?= $aktif_h ? 'checked' : ''; ?>>
                    <label for="cek_header<?= $no_h; ?>" class="custom-control-label">Header <?= $no_h; ?></label>
                  </div>
                  <input type="text" class="form-control" id="txt_header<?= $no_h; ?>" name="txt_header<?= $no_h; ?>" placeholder="Column name" value="<?= $esc($nama_header[$no_h]); ?>" <?= $aktif_h ? '' : 'readonly'; ?> oninput="dn_nama_header(<?= $no_h; ?>, this.value)">
                </div>
              <?php endfor; ?>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>

      <!-- Detail Debit Note -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Detail Debit Note</span>
            <?php if (!$hanya_dokumen) : ?>
            <div class="dn-toolbar">
              <button type="button" id="add_row" class="btn btn-dn-tambah-baris" onclick="addRow('tbody2')"><i class="fas fa-plus"></i> Add Row</button>
              <button type="button" class="btn btn-dn-sisip-baris" onclick="InsertRow('tbody2')"><i class="fas fa-level-down-alt"></i> Interject Row</button>
              <button type="button" class="btn btn-dn-hapus-baris" onclick="hapusbaris()"><i class="fas fa-trash-alt"></i> Delete Row</button>
            </div>
            <?php endif; ?>
          </div>
          <!-- <?php if ($ada_terkunci) : ?>
            <small class="dn-hint dn-hint-tabel"><i class="fas fa-lock"></i> Grey rows come from Memo / Request and cannot be changed or deleted. New rows can still be added.</small>
          <?php endif; ?> -->
          <div class="dn-table-wrap" id="dn-table-wrap">
            <div class="nag-loader-overlay" id="dn-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Memuat data...</div>
              </div>
            </div>
            <table id="table-dn" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr>
                  <th>Description</th>
                  <?php for ($no_h = 1; $no_h <= 5; $no_h++) : ?>
                    <th><input type="text" class="form-control dn-th-input" id="h_header<?= $no_h; ?>" name="h_header<?= $no_h; ?>" placeholder="Header <?= $no_h; ?>" value="<?= $esc($nama_header[$no_h]); ?>" readonly></th>
                  <?php endfor; ?>
                  <th>Value</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th>COA</th>
                  <th>Cek</th>
                </tr>
              </thead>
                          <tbody id="tbody2">
                            <tr style="display: none">
                              <td>
                                <input style="width: 300px;word-wrap: break-word;" type="text" class="form-control" name="inputan0" placeholder="" autocomplete='off'>
                              </td>
                              <td>
                                <input style="width: 200px" type="text" class="form-control" id="inputan3" name="inputan3" placeholder="" autocomplete='off'>
                              </td>
                              <td>
                                <input style="width: 200px" type="text" class="form-control" id="inputan4" name="inputan4" placeholder="" autocomplete='off' readonly> 
                              </td>
                              <td>
                                <input style="width: 200px" type="text" class="form-control" id="inputan5" name="inputan5" placeholder="" autocomplete='off'>
                              </td>
                              <td>
                                <input style="width: 200px" type="text" class="form-control" name="inputan6" placeholder="" autocomplete='off' readonly>
                              </td>
                              <td>
                                <input style="width: 200px" type="text" class="form-control" name="inputan7" placeholder="" autocomplete='off' readonly> 
                              </td>
                              <td>
                                <input  type="text" class="form-control" id="amt" name="amt" style="text-align:right; width: 150px;" oninput="modal_input_amt_dn(value)" autocomplete="off">
                              </td>
                              <td>
                                <input  type="text" class="form-control" id="amt_rate" name="amt_rate" style="text-align:right; width: 150px;" value="<?= $rate; ?>" onkeypress="javascript:return isNumber(event)" oninput="modal_input_rate_dn(value)" autocomplete="off">
                              </td>
                              <td>
                                <input style="width: 150px;text-align: right;" type="text" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly> 
                              </td>
                              <td><input style="width: 250px;" class="form-control" value="1.34.04" list="nm_coa" name="nm_coa" oninput="dn_coa_perbarui_nama(this)">
                                <small class="dn-coa-nama"></small>
                                <datalist id="nm_coa"> <option value="-" data-nama=""> - </option> <?php foreach ($coa as $coa) : ?> <option value="<?= $coa["id_coa"]; ?>" data-nama="<?= $esc($coa["coa_name"]); ?>"><?= $coa["id_coa"]; ?> - <?= $coa["coa_name"]; ?> </option><?php endforeach; ?> </datalist></td>

                                <td><input name="chk_a[]" type="checkbox" class="checkall_a" value=""/></td>
                                <!-- <td style="visibility:hidden;"><input style="width: 150px;text-align: right;" type="hidden" class="form-control" name="inputan10" value="" placeholder="" autocomplete="off" readonly></td> -->
                                <td style="visibility:hidden;">
                                  <input type="hidden" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly> 
                                </td>
                                <td style="visibility:hidden;">
                                  <input type="hidden" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly> 
                                </td>
                                <td style="visibility:hidden;">
                                  <input type="hidden" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly>
                                </td>
                                <td style="visibility:hidden;">
                                  <input type="hidden" class="form-control" name="inputan8" placeholder="" autocomplete='off' readonly>
                                </td>
                              </tr>
                              <?php
                              // Edit: baris detail yang sudah tersimpan - susunan sel sama dengan
                              // baris template. Baris Memo / Request dikunci (data-kunci="1"):
                              // semua input readonly & tanpa checkbox, jadi tidak bisa diubah /
                              // dihapus (server juga memakai ulang isi baris ini dari database).
                              // data-supplier(-invoice) = nilai field lama, dipakai waktu save kalau
                              // Header 1/2 bukan Supplier / Supplier Invoice supaya tidak hilang.
                              foreach ($dn_det as $row) :
                                $kunci = $baris_terkunci($row);
                                $ro = $kunci ? 'readonly' : '';
                              ?>
                                <tr data-id="<?= (int) $row['id']; ?>" data-kunci="<?= $kunci ? '1' : '0'; ?>" data-supplier="<?= $esc($row['supplier']); ?>" data-supplier-invoice="<?= $esc($row['supplier_invoice']); ?>" <?= $kunci ? 'title="From ' . (trim((string) $row['id_memo_det']) !== '' ? 'Memo' : 'Request') . ' - only Value &amp; Rate can be changed, and the row cannot be deleted"' : ''; ?>>
                                  <td><input style="width: 300px;" type="text" class="form-control" name="inputan0" value="<?= $esc($row['deskripsi']); ?>" autocomplete="off" <?= $ro; ?>></td>
                                  <?php for ($no_h = 1; $no_h <= 5; $no_h++) : ?>
                                    <td><input style="width: 200px" type="text" class="form-control" name="inputan<?= $no_h + 2; ?>" value="<?= $esc(isset($row['header' . $no_h]) ? $row['header' . $no_h] : ''); ?>" autocomplete="off" <?= $ro; ?>></td>
                                  <?php endfor; ?>
                                  <!-- Value & Rate tetap bisa diubah walau barisnya dari Memo /
                                       Request: kurs sering baru ketahuan salah setelah DN dibuat.
                                       Kolom lain (deskripsi, header, COA) tetap dikunci supaya
                                       kaitan ke Memo / Request tidak berubah. -->
                                  <td><input type="text" class="form-control" name="amt" value="<?= $esc($row['value']); ?>" style="text-align:right; width: 150px;" oninput="modal_input_amt_dn(value)" autocomplete="off"></td>
                                  <td><input type="text" class="form-control" name="amt_rate" value="<?= $esc($row['rate']); ?>" style="text-align:right; width: 150px;" onkeypress="javascript:return isNumber(event)" oninput="modal_input_rate_dn(value)" autocomplete="off"></td>
                                  <td><input style="width: 150px;text-align: right;" type="text" class="form-control" name="inputan8" value="<?= $esc($row['amount']); ?>" autocomplete="off" readonly></td>
                                  <td><input style="width: 250px;" class="form-control" value="<?= $esc($row['no_coa']); ?>" list="nm_coa" name="nm_coa" oninput="dn_coa_perbarui_nama(this)" <?= $ro; ?>>
                                    <small class="dn-coa-nama"></small>
                                  </td>
                                  <?php if ($kunci) : ?>
                                    <td><i class="fas fa-lock dn-kunci-ikon"></i></td>
                                  <?php else : ?>
                                    <td><input name="chk_a[]" type="checkbox" class="checkall_a" value=""/></td>
                                  <?php endif; ?>
                                  <td hidden><input type="hidden" value=""></td>
                                  <td hidden><input type="hidden" value="<?= $esc($row['nm_memo']); ?>"></td>
                                  <td hidden><input type="hidden" value="<?= $esc($row['id_memo_det']); ?>"></td>
                                  <td hidden><input type="hidden" value="<?= $esc(isset($row['customer']) ? $row['customer'] : ''); ?>"></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
            </table>
            <div class="dn-empty">
              <i class="fas fa-inbox"></i>
              <?= $is_edit ? 'No detail rows yet - click Add Row.' : 'No detail rows yet - choose a No Request, add a memo, or click Add Row.'; ?>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- Total + Save -->
      <div class="row justify-content-end">
        <div class="col-xl-4 col-lg-5 col-md-7">
          <div class="card dn-summary">
            <div class="card-body">
              <div class="dn-sum-row">
                <span>Total Amount</span>
                <input type="text" class="form-control" id="total_value" name="total_value" placeholder="0.00" value="<?= $is_edit ? number_format((float) $dnv('amount', 0), 2) : ''; ?>" readonly>
                <input type="hidden" name="total_value_h" id="total_value_h" value="<?= $is_edit ? $esc($dnv('amount', 0)) : ''; ?>">
              </div>
              <div class="dn-sum-row">
                <span>Equivalent IDR</span>
                <input type="text" class="form-control" id="total_value_idr" name="total_value_idr" placeholder="0.00" value="<?= $is_edit ? number_format((float) $dnv('eqv_curr', 0), 2) : ''; ?>" readonly>
                <input type="hidden" name="total_value_idr_h" id="total_value_idr_h" value="<?= $is_edit ? $esc($dnv('eqv_curr', 0)) : ''; ?>">
              </div>
              <div class="dn-save-bar">
                  <button type="button" class="btn btn-danger btn-save mr-2" onclick="dn_kembali()"><i class="fas fa-arrow-left"></i> Back</button>
                <?php if (!$hanya_dokumen) : ?>
                  <button type="button" class="btn btn-primary btn-save" onclick="dn_simpan()"><i class="fa fa-save"></i> Save</button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

                    <!-- Modal Add No Booking Invoice -->
                    <div class="modal fade" id="modal-add-no-booking-invoice">
                      <div class=" modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add Number Booking Invoice</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <!-- <p>One fine body&hellip;</p> -->
                            <!-- Datatable Nomor Booking Invoice -->
                            <div class="card">
                              <div class="card-header">
                                <!-- Date Range -->
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <!-- <label>Date Range</label> -->
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="reservation" name="reservation">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-8">
                                    <button type="button" id="find_inv" name="find_inv" class="btn btn-info" href="javascript:void(0)" onclick="cari_book_inv()"><i class="fa fa-search"></i> Search</button>
                                  </div>
                                </div>
                                <!-- End Date Range -->
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body table-responsive p-0" style="height: 400px;">
                                <div class="d-flex justify-content-between">
                                 <div class="ml-auto">
                                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text"  id="cari_noinv" name="cari_noinv" required autocomplete="off" placeholder="Search No Invoice.." onkeyup="cari_noinvoice()">
                              </div>
                              <table id="table-add-bookinvoice" class="table table-head-fixed text-nowrap">
                                <thead>
                                  <tr>
                                    <th style="width: 10px">Action</th>
                                    <th>Invoice Number</th>
                                    <th>Customer</th>
                                    <th>Shipp</th>
                                    <th>Document Type</th>
                                    <th>Document Number</th>
                                    <th>Tanggal</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>ID Cust</th>
                                    <th>ID Inv</th>
                                    <th>Amount</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                            <!-- /.card-body -->
                          </div>
                          <!-- End Datatable Nomor Booking Invoice  -->
                        </div>
                        <div class="modal-footer right-content-between">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>

                  <!-- Modal Add TOP -->
                  <div class="modal fade" id="modal-add-top">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Add TOP</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                          <div class="col-md-12">
                            <!-- Form Element sizes -->
                            <div class="card card-success">
                              <div class="card-header">
                                <h3 class="card-title">Table TOP</h3>
                              </div>
                              <div class="card-body">
                                <table id="tbl_top" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th style="width: 35px">Action</th>
                                      <th>Customer</th>
                                      <th>Type</th>
                                      <th style="width: 40px">Top</th>
                                      <th>Status</th>
                                      <th>ID</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                                </table>
                              </div>
                              <!-- /.card-body -->
                            </div>
                          </div>

                        </div>
                        <!-- End Modal Body -->
                        <div class="modal-footer right-content-between">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>

<?php if (!$is_edit) : /* Add Memo hanya di create */ ?>
<!-- Modal Add Memo -->
<div class="modal fade nag-skin dn-modal" id="modal-add-memo">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-sticky-note"></i>Add Memo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Hidden Element -->
        <input type="hidden" class="form-control" id="custm" name="custm" readonly>
        <input type="hidden" class="form-control" id="id_custm" name="id_custm" readonly>
        <input type="hidden" class="form-control" id="rates" name="rates" readonly>
        <input type="hidden" class="form-control" id="pwith" name="pwith" readonly>

        <div class="dn-filter">
          <div class="row align-items-end">
            <div class="form-group col-md-4">
              <label for="filter_customer_memo">Customer</label>
              <select class="form-control select2bs4" id="filter_customer_memo" name="filter_customer_memo" required>
                <?php foreach ($customer as $cs) : ?>
                  <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="filter_from">From</label>
              <div class="input-group">
                <input type="text" name="filter_from_so" id="filter_from" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="filter_to">To</label>
              <div class="input-group">
                <input type="text" name="filter_to_so" id="filter_to" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-md-2">
              <button type="button" id="find_so" name="find_so" class="btn btn-info btn-block" onclick="cari_data_memo()"><i class="fa fa-search"></i> Search</button>
            </div>
          </div>
        </div>

        <div class="table-header">
          <span class="table-title"><i class="fas fa-list"></i>Memo List</span>
          <div class="search-box">
            <input type="text" id="carinoinv" name="carinoinv" autocomplete="off" placeholder="Search No Memo / No Invoice..." onkeyup="cari_inv_memo()">
            <i class="fas fa-search"></i>
          </div>
        </div>
        <div class="dn-table-wrap" id="dn-memo-wrap">
          <div class="nag-loader-overlay" id="dn-memo-loader">
            <div class="nag-loader-card">
              <div class="nag-loader-spinner">
                <span class="nag-loader-ring nag-loader-ring-outer"></span>
                <span class="nag-loader-ring nag-loader-ring-inner"></span>
                <span class="nag-loader-brand">NAG</span>
              </div>
              <div class="nag-loader-caption">Memuat data...</div>
            </div>
          </div>
          <table id="table-inv-memo" class="dn-table text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Supplier</th>
                <th>Customer</th>
                <th>No Memo</th>
                <th>Memo Date</th>
                <th>No Invoice</th>
                <th>Curr</th>
                <th>Total</th>
                <th>Cek</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
          <div class="dn-empty">
            <i class="fas fa-search"></i>
            No memo yet - choose a customer and date range, then click Search.
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <div class="dn-sum-row dn-sum-inline">
          <span>Amount Memo</span>
          <input type="hidden" class="form-control" id="val_memo" name="val_memo">
          <input type="text" class="form-control" id="val_memo_h" name="val_memo_h" placeholder="0.00" readonly>
        </div>
        <div class="dn-footer-actions">
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          <button type="button" id="btn_add_data_so" name="btn_add_data_so" class="btn btn-primary" onclick="duplicate_data_memo()"><i class="fas fa-plus"></i> Add Data</button>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php endif; ?>

<!-- Modal Preview Supporting Document (file masih di browser, belum di-upload).
     Kiri: daftar semua dokumen, kanan: preview dokumen yang dipilih. -->
<div class="modal fade nag-skin dn-modal" id="modal-dn-doc">
  <div class="modal-dialog modal-xl modal-dialog-centered dn-doc-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="dn-doc-head">
          <h4 class="modal-title"><i class="fas fa-file-pdf" id="dn-doc-judul-ikon"></i><span id="dn-doc-judul"></span></h4>
          <div class="dn-doc-meta" id="dn-doc-meta"></div>
        </div>
        <span class="dn-doc-posisi" id="dn-doc-posisi"></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0 dn-doc-body">
        <aside class="dn-doc-side">
          <div class="dn-doc-side-judul">Documents <span id="dn-doc-side-jumlah"></span></div>
          <ul class="dn-doc-side-list" id="dn-doc-side-list"></ul>
        </aside>
        <div class="dn-doc-preview" id="dn-doc-isi"></div>
      </div>
      <div class="modal-footer justify-content-between">
        <div class="dn-doc-nav">
          <button type="button" class="btn btn-light" id="dn-doc-prev" onclick="dn_doc_geser(-1)" title="Previous (&larr;)"><i class="fas fa-chevron-left"></i> Previous</button>
          <button type="button" class="btn btn-light" id="dn-doc-next" onclick="dn_doc_geser(1)" title="Next (&rarr;)">Next <i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="dn-doc-nav">
          <button type="button" class="btn btn-light dn-doc-btn-hapus" onclick="dn_doc_hapus_aktif()"><i class="fas fa-trash-alt"></i> Remove</button>
          <a href="#" class="btn btn-light" id="dn-doc-buka" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> Open in New Tab</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

              <!-- Modal Show Date 1 -->
              <div class="modal fade" id="modal-show-date1">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Date</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- Start Date  -->
                      <p>Select Date</p>
                      <div class="form-group" style="width: 250px;">
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" name="reservationdate" class="form-control datetimepicker-input" data-target="#reservationdate" />
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                      <!--  -->
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" onclick="tambah_tanggal_1()">Apply</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>

              <!-- Modal Show Date 2 -->
              <div class="modal fade" id="modal-show-date2">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Date</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- Start Date  -->
                      <p>Select Date</p>
                      <div class="form-group" style="width: 250px;">
                        <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                          <input type="text" name="reservationdate2" class="form-control datetimepicker-input" data-target="#reservationdate2" />
                          <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                      <!--  -->
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" onclick="tambah_tanggal_2()">Apply</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>

              <!-- Only Input Number In Text -->
              <script>
                function isNumber(evt) {
                  var iKeyCode = (evt.which) ? evt.which : evt.keyCode
                  if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                    return false;
                  return true;
                }
              </script>

              <script type="text/javascript">
                $(document).ready(function() {
                  $('.select2memo').select2({
                    dropdownAutoWidth : true;
                  });
                });
              </script>

              <script type="text/javascript">
                var tampung = [];

                function getdata_reqdn(val){

                  let array = $('#no_req').val();

                  $('select option').on('mousedown', function (e) {
                    this.selected = !this.selected;
                    e.preventDefault();
                  });

                  let no_req = array.toString().replace(/,/g,"','");

                  $('#dn-loader').addClass('show');
                  $.ajax({
                    url: "cari_list_reqdn/",
                    type: "POST",
                    data: {
                      no_req: no_req,
                    },
                    dataType: "JSON",
                    complete: function () {
                      $('#dn-loader').removeClass('show');
                    },
                    success: function (response) {

            // 🔥 CLEAR DULU SEBELUM MASUKIN DATA BARU
            $('#tbody2').empty();
            tampung = [];   // reset detector duplikasi

            var consignee_name = $('#nama_supp').val();
            var trHTML = '';

            $.each(response, function (i, item) {

              if (!tampung.includes(item.id)) {

                trHTML += '<tr>';       
                trHTML += '<td><input style="width:300px" type="text" class="form-control" name="inputan0" value="'+ item.itemdesc +'"></td>';     
                // Header 1 = Supplier, Header 2 = Supplier Invoice (namanya diset
                // dn_header_supplier_otomatis). Data Header 1-3 yang lama (No PO,
                // Qty / Price, Ref / Season) geser ke Header 3-5.
                trHTML += '<td><input style="width:200px" type="text" class="form-control" name="inputan3" value="'+ item.nama_supp +'" readonly></td>';
                trHTML += '<td><input style="width:200px" type="text" class="form-control" name="inputan4" value="" readonly></td>';
                trHTML += '<td><input style="width:200px" type="text" class="form-control" name="inputan5" value="'+ item.no_po +'" readonly></td>';
                trHTML += '<td><input style="width:200px;" type="text" class="form-control" name="inputan6" value="'+ item.header2 +'" readonly></td>';
                trHTML += '<td><input style="width:200px;" type="text" class="form-control" name="inputan7" value="'+ item.header3 +'" readonly></td>';
                trHTML += '<td><input type="text" class="form-control" id="amt" name="amt" value="'+ item.total +'" style="text-align:right;width:150px;" oninput="modal_input_amt_dn(value)"></td>';
                trHTML += '<td><input type="text" class="form-control" id="amt_rate" name="amt_rate" value="1" style="text-align:right;width:150px;" oninput="modal_input_rate_dn(value)"></td>';                                                              
                trHTML += '<td><input style="width:150px;text-align:right;" type="text" class="form-control" name="inputan8" value="'+ item.total +'" readonly></td>';
                trHTML += '<td><input style="width:250px;" class="form-control" value="1.34.05" list="nm_coa" name="nm_coa" oninput="dn_coa_perbarui_nama(this)"><small class="dn-coa-nama"></small></td>';       
                trHTML += '<td><input name="chk_a[]" type="checkbox" class="checkall_a"></td>';                                           
                trHTML += '<td hidden><input type="checkbox" name="id_memo_det" value="" checked></td>';
                trHTML += '<td hidden><input type="text" class="form-control" value="'+ item.no_bpb +'"></td>';
                trHTML += '<td hidden><input type="text" class="form-control" value=""></td>';
                trHTML += '<td hidden><input type="text" class="form-control" value="'+ (consignee_name || '') +'"></td>';
                trHTML += '</tr>';

                tampung.push(item.id);
              }
            });

            $('#tbody2').append(trHTML);
            if (response.length) { dn_header_supplier_otomatis(); }
            modal_input_amt_dn();
          },
          error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load request data.' });
          }
        });     
                }


   // JavaScript Document
   function addRow(tableID) {

    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;

    for(var i=0; i<colCount; i++) {
      var newcell = row.insertCell(i);
      newcell.innerHTML = table.rows[0].cells[i].innerHTML;
      // Baris template (row[0]) punya id statis (id="inputan3", "amt", dst) -
      // di-clone innerHTML apa adanya bikin baris baru ini KEBAWA id yang sama,
      // jadi dobel id di DOM. Selector berbasis id ($('#inputan3'), dst) selalu
      // kena elemen PERTAMA yang match, yaitu baris template yang tersembunyi -
      // bukan baris baru yang user isi. Hapus id-nya disini biar tidak dobel;
      // pembacaan data pas save (collectDnDetailRows) sudah lewat posisi
      // baris/kolom, bukan id, jadi aman tanpa id.
      newcell.querySelectorAll('[id]').forEach(function (el) { el.removeAttribute('id'); });
      var child = newcell.children;
      for(var i2=0; i2<child.length; i2++) {
        var el = newcell.children[i2];
        var test = el.tagName;
        switch(test) {
          case "INPUT":
          // Kolom Header 1-5 & select2 Supplier disiapkan dn_siapkan_baris()
          // lewat MutationObserver #tbody2, ikut status switch-nya.
          if(el.type=='checkbox'){
                        // Checkbox "Cek" (penanda baris untuk Delete/Interject
                        // Row) di baris baru tidak dicentang - dulu otomatis
                        // tercentang, jadi baris baru ikut terhapus kalau user
                        // langsung klik Delete Row. Checkbox hidden lain tetap.
                        el.checked = !el.classList.contains('checkall_a');

                      }
                      break;
                      case "SELECT":
                    // newcell.children[i2].value = "";
                    break;
                    default:
                    break;
                  }
                }
              }            

            }
            
            function deleteRow()
            {
              try
              {
                var table = document.getElementById("tbody2");
                var rowCount = table.rows.length;
                for(var i=0; i<rowCount; i++)
                {
                  var row = table.rows[i];
                  var chkbox = row.querySelector('input.checkall_a'); // lewat class, bukan posisi kolom
                  if (null != chkbox && true == chkbox.checked)
                  {
                    if (rowCount <= 1)
                    {
                      Swal.fire({ icon: 'warning', title: 'Cannot Delete', text: 'Tidak dapat menghapus semua baris.' });
                      break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                  }
                }
              } catch(e)
              {
                Swal.fire({ icon: 'error', title: 'Error', text: String(e) });
              }
            }

            function InsertRow(tableID)
            {
              try{
                var table = document.getElementById(tableID);
                var rowCount = table.rows.length;
                for(var i=0; i<rowCount; i++)
                {
                  var row = table.rows[i];
                  var chkbox = row.querySelector('input.checkall_a'); // lewat class, bukan posisi kolom
                  if (null != chkbox && true == chkbox.checked)
                  {
                    var newRow = table.insertRow(i+1);
                    var colCount = table.rows[0].cells.length;
                    for (h=0; h<colCount; h++){
                      var newCell = newRow.insertCell(h);
                      newCell.innerHTML = table.rows[0].cells[h].innerHTML;
                      // Sama seperti addRow() - hapus id hasil clone biar tidak dobel di DOM.
                      newCell.querySelectorAll('[id]').forEach(function (el) { el.removeAttribute('id'); });
                      var child = newCell.children;
                      for(var i2=0; i2<child.length; i2++) {
                        var test = newCell.children[i2].tagName;
                        switch(test) {
                          case "INPUT":
                          if(newCell.children[i2].type=='checkbox'){
                            newCell.children[i2].value = "";
                            newCell.children[i2].checked[9] = true;
                          }else{
                            newCell.children[i2].value = "";
                          }
                          break;
                          case "SELECT":
                          newCell.children[i2].value = "";
                          break;
                          default:
                          break;
                        }
                      }
                    }
                  }

                }
              } catch(e)
              {
                Swal.fire({ icon: 'error', title: 'Error', text: String(e) });
              }
            }

            function hitungRow(){
              var table = document.getElementById("tbody2");
              var rowCount2 = table.rows.length;
              var tota = 0;
              var tot_price = 0;

              for(var i=0; i<rowCount2; i++){

                var price = parseFloat(document.getElementById("tbody2").rows[i].cells[6].children[0].value,10) || 0;

                tota += price;

                document.getElementsByName("total_value_h")[0].value = tota.toFixed(2);
                document.getElementsByName("total_value")[0].value = formatMoney(tota.toFixed(2));
              }

            }


            async function hapusbaris(){
             await deleteRow()
             console.log("result");
             hitungRow();
           }
         </script>


         <script>
           // ===== Kolom tambahan Header 1-5 =====
           // Switch Header N yang menentukan kolom ke-N di tabel detail bisa
           // diisi atau tidak - nama kolom cuma jadi judulnya. Isi kolom hanya
           // di-clear saat switch dimatikan (on -> off).
           //
           // Kolom Supplier & Supplier Invoice yang tetap sudah dihapus, diganti
           // Header 1-2: baris dari No Request / Add Memo otomatis mengisi
           // Header 1 = Supplier, Header 2 = Supplier Invoice. Baris manual (Add
           // Row) bebas. Kalau Header 1 = "Supplier" / Header 2 = "Supplier
           // Invoice", isinya juga disalin ke field lama supplier /
           // supplier_invoice waktu save (collectDnDetailRows di crud-nag.js).
           //
           // Nama fungsi sengaja beda dari ubah_header1/2/3 lama di crud-nag.js
           // (perilakunya beda).
           // Header 4-5 (inputan6/7) ikut dikirim waktu save, tapi baru
           // tersimpan setelah migrations/20260911_debitnote_header4_header5.sql
           // dijalankan (lihat Model_nag::simpandn_h).
           var DN_HEADER_COL = { 1: 'inputan3', 2: 'inputan4', 3: 'inputan5', 4: 'inputan6', 5: 'inputan7' };

           // Mode edit (form yang sama dipakai edit_debitnote).
           var DN_EDIT = <?= $is_edit ? 'true' : 'false'; ?>;
           var DN_EDIT_ID = <?= $is_edit ? (int) $dn['id'] : 0; ?>;
           var DN_EDIT_PC = '<?= $is_edit ? $esc($dnv('profit_center')) : ''; ?>';
           // DN sudah first approve: isinya dikunci, yang bisa diurus cuma lampiran.
           // Tidak ada tombol Save disini, jadi file baru langsung di-upload.
           var DN_HANYA_DOKUMEN = <?= $hanya_dokumen ? 'true' : 'false'; ?>;
           var DN_NOMOR = '<?= $is_edit ? $esc($dnv('no_dn')) : ''; ?>';

           // Daftar supplier untuk select2 - disaring di browser per 50 hasil,
           // jadi tiap baris cukup menyimpan 1 option terpilih, bukan ribuan.
           var DN_SUPPLIERS = <?= json_encode(array_values(array_column($supplier, 'Supplier')), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

           function dn_header_aktif(no) {
             var cb = document.getElementById('cek_header' + no);
             return !!(cb && cb.checked);
           }

           // Kolom Header yang namanya "Supplier" (header ke berapa pun) diisi
           // lewat pilihan supplier, bukan diketik.
           function dn_header_supplier(no) {
             return $.trim($('#txt_header' + no).val()).toLowerCase() === 'supplier';
           }

           function dn_baris_tabel() {
             return $('#tbody2 > tr').not('[style*="none"]');
           }

           function dn_select2_supplier(sel) {
             var $sel = $(sel);
             if ($sel.data('select2')) { return; }
             // Baris hasil clone addRow()/InsertRow() ikut membawa markup select2
             // baris asalnya - dibersihkan dulu supaya tidak dobel.
             $sel.siblings('.select2-container').remove();
             $sel.removeClass('select2-hidden-accessible').removeAttr('data-select2-id aria-hidden tabindex');
             $sel.find('option').removeAttr('data-select2-id');
             $sel.select2({
               theme: 'bootstrap4',
               placeholder: 'Select supplier',
               allowClear: true,
               dropdownAutoWidth: true,
               ajax: {
                 delay: 150,
                 transport: function (params, success) {
                   var q = ((params.data && params.data.term) || '').toLowerCase();
                   var page = (params.data && params.data.page) || 1;
                   var cocok = DN_SUPPLIERS.filter(function (s) { return s.toLowerCase().indexOf(q) > -1; });
                   success({
                     results: cocok.slice((page - 1) * 50, page * 50).map(function (s) { return { id: s, text: s }; }),
                     pagination: { more: page * 50 < cocok.length }
                   });
                 }
               }
             });
           }

           // Tukar field input <-> select supplier; name, nilai, dan lebarnya ikut.
           function dn_ganti_field(el, jadiSelect) {
             var nilai = $(el).val() || '';
             var baru;
             if (jadiSelect) {
               baru = document.createElement('select');
               if (nilai) { baru.appendChild(new Option(nilai, nilai, true, true)); }
             } else {
               if ($(el).data('select2')) { $(el).select2('destroy'); }
               baru = document.createElement('input');
               baru.type = 'text';
               baru.autocomplete = 'off';
               baru.value = nilai;
             }
             baru.name = el.name;
             baru.className = 'form-control' + (jadiSelect ? ' dn-supp' : '');
             baru.style.width = el.style.width || '200px';
             $(el).siblings('.select2-container').remove();
             el.parentNode.replaceChild(baru, el);
             return baru;
           }

           // Input dikunci lewat readonly, select lewat disabled.
           function dn_kunci(el, terkunci) {
             if (el.tagName === 'SELECT') { el.disabled = terkunci; } else { el.readOnly = terkunci; }
           }

           // Samakan 1 sel kolom Header N dengan status switch & namanya.
           function dn_siapkan_kolom_header(row, no) {
             var el = row.querySelector('[name="' + DN_HEADER_COL[no] + '"]');
             if (!el) { return null; }
             var mauSelect = dn_header_supplier(no);
             if (mauSelect !== (el.tagName === 'SELECT')) { el = dn_ganti_field(el, mauSelect); }
             if (mauSelect) { dn_select2_supplier(el); }
             // Baris dari Memo / Request (edit) selalu terkunci.
             dn_kunci(el, row.getAttribute('data-kunci') === '1' || !dn_header_aktif(no));
             return el;
           }

           function dn_siapkan_baris(row) {
             for (var no = 1; no <= 5; no++) { dn_siapkan_kolom_header(row, no); }
             var coaEl = row.querySelector('[name="nm_coa"]');
             if (coaEl) { dn_coa_perbarui_nama(coaEl); }
           }

           // Keterangan nama COA (mastercoa_v2) di bawah kolom COA - cuma tampilan,
           // kode COA yang tersimpan (isi input ini) tidak ikut berubah. Datalist
           // #nm_coa dibaca dari baris template (baris pertama tabel), yang
           // datanya selalu dari Model_nag::cari_coa() - sama untuk semua baris.
           function dn_coa_perbarui_nama(input) {
             var hint = input.parentNode.querySelector('.dn-coa-nama');
             if (!hint) { return; }
             var opsi = null;
             try { opsi = document.querySelector('#nm_coa option[value="' + CSS.escape(input.value) + '"]'); } catch (e) {}
             hint.textContent = opsi ? (opsi.getAttribute('data-nama') || '') : '';
           }

           function dn_render_header(no) {
             dn_baris_tabel().each(function () { dn_siapkan_kolom_header(this, no); });
           }

           function dn_toggle_header(no, el) {
             var nama = $('#txt_header' + no);

             if (el.checked) {
               nama.prop('readonly', false).focus();
               dn_render_header(no);
             } else {
               // Edit: kolom yang berisi data baris Memo / Request tidak boleh
               // dimatikan - isinya ikut terhapus.
               var adaDataTerkunci = dn_baris_tabel().filter('[data-kunci="1"]').toArray().some(function (row) {
                 var f = row.querySelector('[name="' + DN_HEADER_COL[no] + '"]');
                 return f && $.trim($(f).val() || '') !== '';
               });
               if (adaDataTerkunci) {
                 el.checked = true;
                 Swal.fire({ icon: 'warning', title: 'Column Locked', text: 'Header ' + no + ' contains data from Memo / Request and cannot be turned off.' });
                 return;
               }
               nama.prop('readonly', true).val('');
               $('#h_header' + no).val('');
               // Nama sudah kosong -> sel balik jadi input biasa & terkunci, lalu
               // isinya dikosongkan.
               dn_baris_tabel().each(function () {
                 var f = dn_siapkan_kolom_header(this, no);
                 if (f && this.getAttribute('data-kunci') !== '1') { f.value = ''; }
               });
             }
           }

           function dn_nama_header(no, nama) {
             $('#h_header' + no).val(nama);
             dn_render_header(no);
           }

           // Nyalakan Header N dengan nama tertentu tanpa menyentuh isi kolomnya.
           function dn_set_header(no, nama) {
             document.getElementById('cek_header' + no).checked = true;
             $('#txt_header' + no).prop('readonly', false).val(nama);
             $('#h_header' + no).val(nama);
             dn_render_header(no);
           }

           // Dipanggil setelah baris dari No Request (getdata_reqdn) atau Add Memo
           // (load_invoice_detail_memo di crud-nag.js) masuk.
           function dn_header_supplier_otomatis() {
             dn_set_header(1, 'Supplier');
             dn_set_header(2, 'Supplier Invoice');
           }

           // Baris baru datang dari Add Row, Interject Row, No Request, dan Add
           // Memo - semua baris yang masuk ke #tbody2 disiapkan disini.
           new MutationObserver(function (mutations) {
             mutations.forEach(function (m) {
               m.addedNodes.forEach(function (node) {
                 if (node.nodeName === 'TR') { dn_siapkan_baris(node); }
               });
             });
           }).observe(document.getElementById('tbody2'), { childList: true });

           // Edit: baris yang sudah tersimpan dirender server (sebelum observer di
           // atas aktif) - disiapkan setelah jQuery & select2 selesai dimuat, dan
           // SETELAH handler ready di footer: footer menjalankan
           // $('.select2').select2(), sedangkan container select2 juga ber-class
           // "select2". Kalau select2 Supplier baris ini dibuat duluan,
           // container-nya ikut di-select2 ulang dan yang tampil kotak kosong
           // (supplier tersimpan tidak muncul, tidak terkunci). $(fn) yang
           // didaftarkan disini antre di belakang handler ready footer.
           document.addEventListener('DOMContentLoaded', function () {
             $(function () {
               $('#tbody2 > tr[data-id]').each(function () { dn_siapkan_baris(this); });

               if (DN_HANYA_DOKUMEN) {
                 // Semua isian dikunci - kecuali yang di kotak lampiran. Pakai
                 // readonly untuk input/textarea (nilainya tetap kelihatan jelas)
                 // dan disabled untuk select & checkbox yang tidak bisa readonly.
                 var $isian = $('.nag-skin').find('input, select, textarea').not('#dn-doc-drop *');
                 $isian.filter('select, [type=checkbox], [type=radio], [type=file]').prop('disabled', true);
                 // Pakai properti .type, bukan selektor [type=text]: sebagian input
                 // (mis. kolom COA) ditulis tanpa atribut type sama sekali.
                 $isian.filter(function () { return this.type === 'text' || this.type === 'textarea'; }).prop('readonly', true);
                 $('.nag-skin .card').addClass('dn-terkunci');
                 // select2 tidak perlu di-trigger: dia punya pengawas sendiri untuk
                 // atribut disabled. Kalau di-trigger change, onchange bawaan select
                 // (get_alamat_edit, dst) ikut jalan padahal tidak ada yang berubah.
               }
             });
           });

           // Header aktif tapi namanya kosong: di PDF judul kolomnya tidak
           // dicetak sedangkan isinya tetap dicetak, jadi kolom PDF bergeser.
           function dn_simpan() {
             for (var no = 1; no <= 5; no++) {
               if (dn_header_aktif(no) && $.trim($('#txt_header' + no).val()) === '') {
                 Swal.fire({ icon: 'warning', title: 'Column Name Required', text: 'Header ' + no + ' is on - fill in the column name or turn it off.' });
                 $('#txt_header' + no).focus();
                 return;
               }
             }
             if (DN_EDIT) { dn_edit_simpan(); } else { simpan_data_dn(); }
           }

           // Konfirmasi Save - dipanggil simpan_data_dn() di crud-nag.js setelah
           // validasinya lolos. Nomor DN sengaja tidak ditampilkan (dihitung ulang
           // server saat simpan, baru muncul di info setelah tersimpan).
           // Supporting document tidak wajib: kalau belum ada, konfirmasinya
           // berupa peringatan tapi save tetap bisa lanjut.
           function dn_konfirmasi_simpan(lanjut) {
             var n = DN_DOKUMEN.length, lama = DN_DOKUMEN_LAMA.length;
             var tanpaDokumen = !n && !lama;
             var catatan = !DN_EDIT
               ? '<div class="dn-swal-catatan">The debit note number will be generated when it is saved.</div>'
               : (dn_edit_ganti_nomor() ? '<div class="dn-swal-catatan">Profit center changed - a new debit note number will be generated.</div>' : '');
             var infoDokumen = n
               ? '<i class="fas fa-paperclip"></i> ' + n + (DN_EDIT ? ' new' : '') + ' supporting document' + (n > 1 ? 's' : '') + ' will be uploaded.'
               : lama + ' supporting document' + (lama > 1 ? 's are' : ' is') + ' already attached.';
             Swal.fire({
               icon: tanpaDokumen ? 'warning' : 'question',
               title: tanpaDokumen ? 'No Supporting Document' : (DN_EDIT ? 'Save Changes?' : 'Save Debit Note?'),
               html: (tanpaDokumen
                 ? 'No supporting document has been attached to this debit note. Do you want to continue saving?'
                 : infoDokumen) + catatan,
               showCancelButton: true,
               confirmButtonText: tanpaDokumen ? 'Continue Save' : 'Save',
               cancelButtonText: 'Cancel',
               reverseButtons: true
             }).then(function (r) {
               if (r.isConfirmed) { lanjut(); }
             });
           }

           // ===== Simpan (mode edit) =====
           // Header + detail dikirim sekaligus ke arnag/update_debitnote (1
           // transaksi). Baris Memo / Request cuma dikirim id-nya - server memakai
           // ulang isinya dari database.
           function dn_edit_ganti_nomor() {
             return DN_EDIT && $('#profit_center_dn').val() !== DN_EDIT_PC;
           }

           function dn_edit_pc_berubah() {
             document.getElementById('dn-nomor-hint').hidden = !dn_edit_ganti_nomor();
           }

           function dn_header_bernama(no, nama) {
             return $.trim($('#txt_header' + no).val() || '').toLowerCase() === nama;
           }

           function dn_edit_kumpul_detail() {
             var hasil = [];
             dn_baris_tabel().each(function () {
               var row = this;
               var isi = function (name) { var el = dn_row_input(row, name); return el ? ($(el).val() || '') : ''; };
               if (row.getAttribute('data-kunci') === '1') {
                 // Baris Memo / Request: isinya dipakai ulang server dari database,
                 // KECUALI Value / Rate / Amount yang boleh dibetulkan lewat Edit.
                 hasil.push({
                   id_det: row.getAttribute('data-id'),
                   value: isi('amt'), rate: isi('amt_rate'), amount: isi('inputan8')
                 });
                 return;
               }
               var h = {};
               for (var no = 1; no <= 5; no++) { h[no] = isi(DN_HEADER_COL[no]); }
               var data = {
                 deskripsi: isi('inputan0'),
                 // Field lama Supplier / Supplier Invoice: dari Header 1 / 2 kalau
                 // namanya itu, selain itu nilai lama baris ini (baris baru kosong).
                 supplier: dn_header_bernama(1, 'supplier') ? h[1] : (row.getAttribute('data-supplier') || ''),
                 supplier_invoice: dn_header_bernama(2, 'supplier invoice') ? h[2] : (row.getAttribute('data-supplier-invoice') || ''),
                 header1: h[1], header2: h[2], header3: h[3], header4: h[4], header5: h[5],
                 value: isi('amt'), rate: isi('amt_rate'), amount: isi('inputan8'), no_coa: isi('nm_coa')
               };
               if (!data.deskripsi && !data.supplier && !parseFloat(data.amount)) { return; } // baris kosong
               hasil.push(data);
             });
             return hasil;
           }

           function dn_edit_simpan() {
             if ($('#dn_duedate').val() < $('#dn_date').val()) {
               Swal.fire({ icon: 'warning', title: 'Invalid Date', text: "Due Date can't be smaller than Debit Note Date" });
               $('#dn_duedate').focus();
               return;
             }
             if ($.trim($('#txt_attn').val()) === '') {
               Swal.fire({ icon: 'warning', title: 'Attn Required', text: 'Attn is required' });
               $('#txt_attn').focus();
               return;
             }
             var detail = dn_edit_kumpul_detail();
             var total = 0;
             dn_baris_tabel().each(function () { var el = dn_row_input(this, 'amt'); total += (el && parseFloat(el.value)) || 0; });
             if (!detail.length || !total) {
               Swal.fire({ icon: 'warning', title: 'Invalid Amount', text: "Amount Can't be Zero" });
               return;
             }
             dn_konfirmasi_simpan(function () { dn_edit_kirim(detail); });
           }

           function dn_edit_kirim(detail) {
             Swal.fire({
               title: 'Saving...',
               allowOutsideClick: false,
               allowEscapeKey: false,
               showConfirmButton: false,
               didOpen: function () { Swal.showLoading(); }
             });
             var header = {
               tgl_dn: $('#dn_date').val(), due_date: $('#dn_duedate').val(), customer: $('#customer').val(),
               attn: $('#txt_attn').val(), alamat: $('#alamat').val(), from_curr: $('#curr1').val(), to_curr: $('#curr2').val(),
               akun: $('#akun').val(), profit_center: $('#profit_center_dn').val()
             };
             for (var no = 1; no <= 5; no++) { header['header' + no] = $('#txt_header' + no).val() || ''; }

             // Dikirim sebagai JSON supaya DN dengan banyak baris tidak kepotong
             // batas max_input_vars PHP.
             $.ajax({
               url: '<?= base_url('arnag/update_debitnote'); ?>',
               type: 'POST',
               dataType: 'JSON',
               data: { id_dn: DN_EDIT_ID, data_h: JSON.stringify(header), data_det: JSON.stringify(detail) }
             }).done(function (res) {
               if (!res || !res.status) {
                 dn_edit_gagal((res && res.message) || 'Please try again.', detail);
                 return;
               }
               var nomorLama = $('#dn_number').val();
               $('#dn_number').val(res.no_dn);
               dn_upload_dokumen(res.no_dn, function (info) {
                 info = info || {};
                 Swal.fire({
                   icon: info.icon || 'success',
                   title: 'Debit Note Updated',
                   html: '<div class="dn-swal-label">DN Number</div><div class="dn-swal-nomor">' + dn_esc(res.no_dn) + '</div>' +
                     (res.no_dn !== nomorLama ? '<div class="dn-swal-catatan">Previous number: ' + dn_esc(nomorLama) + '</div>' : '') +
                     (info.html ? '<div class="dn-swal-catatan">' + info.html + '</div>' : '')
                 }).then(function () { location.reload(); });
               });
             }).fail(function () {
               dn_edit_gagal('Connection error, please try again.', detail);
             });
           }

           function dn_edit_gagal(pesan, detail) {
             Swal.fire({
               icon: 'warning',
               title: 'Failed to Save',
               text: pesan,
               showCancelButton: true,
               confirmButtonText: 'Save Again',
               cancelButtonText: 'Close'
             }).then(function (r) {
               if (r.isConfirmed) { dn_edit_kirim(detail); }
             });
           }

           // Halaman edit dibuka di tab yang sama dari List Debit Note. Kalau datang
           // dari halaman lain di aplikasi ini, mundur lewat riwayat browser supaya
           // filter & hasil pencarian di daftar tidak hilang; selain itu (mis. URL
           // edit dibuka langsung) buka daftarnya.
           function dn_kembali() {
             var dariAplikasi = document.referrer.indexOf(location.origin + '/') === 0;
             if (dariAplikasi && history.length > 1) {
               history.back();
             } else {
               location.href = '<?= base_url('arnag/list_debitnote'); ?>';
             }
           }
         </script>

         <script>
           // ===== Supporting document =====
           // Tidak wajib & bisa lebih dari 1 file. File disimpan dulu di browser
           // (bisa di-preview sebelum save), lalu di-upload satu per satu ke
           // upload_dn_doc SETELAH Debit Note tersimpan - butuh nomor DN final
           // dari server. Dipanggil dari simpandn_h() di crud-nag.js.
           // Hanya PDF & gambar (semuanya bisa di-preview browser). Tidak ada batas
           // ukuran - file dikirim per potongan sebesar DN_DOC_CHUNK byte (ikut batas
           // upload PHP server, dihitung Arnag::_dn_doc_chunk_size).
           var DN_DOC_EXT = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
           var DN_DOC_CHUNK = <?= isset($dn_doc_chunk) ? (int) $dn_doc_chunk : 1048576; ?>;
           var DN_DOC_IKON = { pdf: 'fa-file-pdf', img: 'fa-file-image' };
           var DN_DOKUMEN = [];                 // { file: File, url: blob URL untuk preview }
           // Mode edit: dokumen yang sudah tersimpan (tidak bisa dihapus dari sini).
           var DN_DOKUMEN_LAMA = <?= json_encode(array_map(function ($d) {
             return array('id' => (int) $d['id'], 'nama' => $d['original_name'], 'ukuran' => (int) $d['file_size'], 'url' => base_url('arnag/lihat_dn_doc/' . (int) $d['id']));
           }, $dn_docs), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

           function dn_esc(teks) {
             var el = document.createElement('div');
             el.textContent = teks;
             return el.innerHTML;
           }

           function dn_doc_ext(nama) {
             var i = nama.lastIndexOf('.');
             return i > -1 ? nama.slice(i + 1).toLowerCase() : '';
           }

           function dn_doc_jenis(nama) {
             return dn_doc_ext(nama) === 'pdf' ? 'pdf' : 'img';
           }

           function dn_doc_ukuran(byte) {
             if (byte < 1024) { return byte + ' B'; }
             if (byte < 1024 * 1024) { return Math.round(byte / 1024) + ' KB'; }
             return (byte / 1024 / 1024).toFixed(1) + ' MB';
           }

           function dn_doc_tambah(files) {
             var ditolak = [];
             Array.prototype.forEach.call(files || [], function (f) {
               if (DN_DOC_EXT.indexOf(dn_doc_ext(f.name)) === -1) { ditolak.push(f.name + ' - file type not allowed'); return; }
               if (!f.size) { ditolak.push(f.name + ' - file is empty'); return; }
               var sudahAda = DN_DOKUMEN.some(function (d) {
                 return d.file.name === f.name && d.file.size === f.size && d.file.lastModified === f.lastModified;
               });
               if (!sudahAda) { DN_DOKUMEN.push({ file: f, url: URL.createObjectURL(f) }); }
             });
             dn_doc_render();

             if (ditolak.length) {
               Swal.fire({
                 icon: 'warning',
                 title: 'Some Files Were Skipped',
                 html: '<ul class="dn-swal-list">' + ditolak.map(function (t) { return '<li>' + dn_esc(t) + '</li>'; }).join('') + '</ul>' +
                       '<div class="mt-2" style="font-size:12.5px;color:#64748b;">Only PDF and image files (JPG, PNG, GIF, WEBP) are allowed.</div>'
               });
             }

             // Mode dokumen (DN sudah first approve): tidak ada tombol Save, jadi
             // file yang baru dipilih langsung di-upload saat itu juga.
             if (DN_HANYA_DOKUMEN && DN_DOKUMEN.length) {
               dn_doc_upload_sekarang();
             }
           }

           // Upload isi antrian sekarang juga, lalu daftar dokumennya disegarkan
           // dari server supaya yang baru ikut punya tombol lihat & hapus.
           function dn_doc_upload_sekarang() {
             dn_upload_dokumen(DN_NOMOR, function (info) {
               info = info || {};
               Swal.fire({
                 icon: info.icon || 'success',
                 title: 'Documents Uploaded',
                 html: info.html || 'Supporting document uploaded.'
               }).then(function () { location.reload(); });
             });
           }

           function dn_doc_hapus(i) {
             URL.revokeObjectURL(DN_DOKUMEN[i].url);
             DN_DOKUMEN.splice(i, 1);
             dn_doc_render();
           }

           // Dokumen yang sudah tersimpan: dihapus di server saat itu juga (tidak
           // menunggu Save). Server ikut mengecek statusnya - lampiran dikunci
           // setelah second approve.
           function dn_doc_hapus_tersimpan(id, nama) {
             Swal.fire({
               icon: 'warning',
               title: 'Remove Document?',
               html: '<div class="dn-swal-label">File</div><div class="dn-swal-nomor">' + dn_esc(nama) + '</div>' +
                 '<div class="dn-swal-catatan">It will be deleted from the server right away.</div>',
               showCancelButton: true,
               confirmButtonText: 'Remove',
               cancelButtonText: 'Cancel',
               reverseButtons: true
             }).then(function (r) {
               if (!r.isConfirmed) { return; }
               Swal.fire({
                 title: 'Removing...',
                 allowOutsideClick: false,
                 allowEscapeKey: false,
                 showConfirmButton: false,
                 didOpen: function () { Swal.showLoading(); }
               });
               $.ajax({
                 url: '<?= base_url('arnag/hapus_dn_doc'); ?>',
                 type: 'POST',
                 dataType: 'JSON',
                 data: { id: id }
               }).done(function (res) {
                 if (!res || !res.status) {
                   Swal.fire({ icon: 'error', title: 'Failed to Remove', text: (res && res.message) || 'Please try again.' });
                   return;
                 }
                 DN_DOKUMEN_LAMA = DN_DOKUMEN_LAMA.filter(function (d) { return d.id !== id; });
                 if ($('#modal-dn-doc').hasClass('show')) { $('#modal-dn-doc').modal('hide'); }
                 dn_doc_render();
                 Swal.close();
               }).fail(function () {
                 Swal.fire({ icon: 'error', title: 'Failed to Remove', text: 'Connection error, please try again.' });
               });
             });
           }

           // Semua dokumen untuk chip & penampil: yang sudah tersimpan (mode edit)
           // dulu, lalu file baru yang masih di browser. baru = index di DN_DOKUMEN.
           function dn_doc_semua() {
             return DN_DOKUMEN_LAMA.map(function (d) {
               return { id: d.id, nama: d.nama, ukuran: d.ukuran, url: d.url, lama: true };
             }).concat(DN_DOKUMEN.map(function (d, i) {
               return { nama: d.file.name, ukuran: d.file.size, url: d.url, lama: false, baru: i };
             }));
           }

           function dn_doc_render() {
             var list = document.getElementById('dn-doc-list');
             list.innerHTML = '';
             dn_doc_semua().forEach(function (d, i) {
               var jenis = dn_doc_jenis(d.nama);
               var li = document.createElement('li');
               li.className = 'dn-doc-item' + (d.lama ? ' is-lama' : '');
               li.innerHTML =
                 '<i class="fas ' + DN_DOC_IKON[jenis] + ' dn-doc-ikon is-' + jenis + '"></i>' +
                 '<span class="dn-doc-nama"></span><span class="dn-doc-ukuran"></span>' +
                 (d.lama ? '<span class="dn-doc-tersimpan"><i class="fas fa-check"></i> Saved</span>' : '') +
                 '<span class="dn-doc-aksi">' +
                   '<button type="button" class="btn dn-doc-lihat" title="View"><i class="fas fa-eye"></i></button>' +
                   '<button type="button" class="btn dn-doc-hapus" title="Remove"><i class="fas fa-times"></i></button>' +
                 '</span>';
               // Nama file dari user - lewat textContent, bukan innerHTML.
               var nama = li.querySelector('.dn-doc-nama');
               nama.textContent = d.nama;
               nama.title = d.nama + ' - click to view';
               nama.addEventListener('click', function () { dn_doc_lihat(i); });
               li.querySelector('.dn-doc-ukuran').textContent = dn_doc_ukuran(d.ukuran);
               li.querySelector('.dn-doc-lihat').addEventListener('click', function () { dn_doc_lihat(i); });
               li.querySelector('.dn-doc-hapus').addEventListener('click', function () {
                 if (d.lama) { dn_doc_hapus_tersimpan(d.id, d.nama); } else { dn_doc_hapus(d.baru); }
               });
               list.appendChild(li);
             });
             var n = DN_DOKUMEN.length, lama = DN_DOKUMEN_LAMA.length;
             document.getElementById('dn-doc-jumlah').textContent = lama
               ? lama + ' saved' + (n ? ' · ' + n + ' new' : '')
               : (n ? n + ' file' + (n > 1 ? 's' : '') : '');
           }

           // ===== Penampil dokumen =====
           // File baru masih di browser (blob URL), yang sudah tersimpan dibuka
           // lewat arnag/lihat_dn_doc. Kiri daftar semua dokumen, kanan preview
           // dokumen ke-DN_DOC_AKTIF (index di dn_doc_semua()).
           var DN_DOC_AKTIF = -1;

           function dn_doc_lihat(i) {
             if (!dn_doc_semua()[i]) { return; }
             DN_DOC_AKTIF = i;
             dn_doc_viewer();
             if (!$('#modal-dn-doc').hasClass('show')) { $('#modal-dn-doc').modal('show'); }
           }

           function dn_doc_viewer() {
             var semua = dn_doc_semua(), i = DN_DOC_AKTIF, n = semua.length, d = semua[i];
             var jenis = dn_doc_jenis(d.nama);

             document.getElementById('dn-doc-judul').textContent = d.nama;
             document.getElementById('dn-doc-judul-ikon').className = 'fas ' + DN_DOC_IKON[jenis];
             document.getElementById('dn-doc-meta').textContent = (jenis === 'pdf' ? 'PDF document' : 'Image') + ' · ' + dn_doc_ukuran(d.ukuran) + (d.lama ? ' · Saved' : '');
             document.getElementById('dn-doc-posisi').textContent = (i + 1) + ' / ' + n;
             document.getElementById('dn-doc-buka').href = d.url;
             document.getElementById('dn-doc-prev').disabled = (i === 0);
             document.getElementById('dn-doc-next').disabled = (i === n - 1);
             document.querySelector('#modal-dn-doc .dn-doc-btn-hapus').hidden = false;

             // Preview - gambar bisa diklik untuk ukuran asli.
             var isi = document.getElementById('dn-doc-isi');
             var el = document.createElement(jenis === 'pdf' ? 'iframe' : 'img');
             el.src = d.url;
             el.title = el.alt = d.nama;
             if (jenis === 'img') { el.addEventListener('click', function () { isi.classList.toggle('is-zoom'); }); }
             isi.classList.remove('is-zoom');
             isi.innerHTML = '';
             isi.appendChild(el);

             // Daftar dokumen di kiri
             var side = document.getElementById('dn-doc-side-list');
             side.innerHTML = '';
             semua.forEach(function (x, j) {
               var jx = dn_doc_jenis(x.nama);
               var li = document.createElement('li');
               if (j === i) { li.className = 'is-aktif'; }
               li.innerHTML = '<span class="dn-doc-thumb is-' + jx + '"></span>' +
                 '<span class="dn-doc-side-info"><span class="dn-doc-side-nama"></span><span class="dn-doc-side-ukuran"></span></span>';
               var thumb = li.querySelector('.dn-doc-thumb');
               if (jx === 'img') {
                 var im = document.createElement('img');
                 im.src = x.url;
                 im.alt = '';
                 thumb.appendChild(im);
               } else {
                 thumb.innerHTML = '<i class="fas ' + DN_DOC_IKON[jx] + '"></i>';
               }
               li.querySelector('.dn-doc-side-nama').textContent = x.nama;
               li.querySelector('.dn-doc-side-nama').title = x.nama;
               li.querySelector('.dn-doc-side-ukuran').textContent = dn_doc_ukuran(x.ukuran) + (x.lama ? ' · Saved' : '');
               li.addEventListener('click', function () { dn_doc_lihat(j); });
               side.appendChild(li);
             });
             document.getElementById('dn-doc-side-jumlah').textContent = '(' + n + ')';
             var aktif = side.querySelector('.is-aktif');
             if (aktif && aktif.scrollIntoView) { aktif.scrollIntoView({ block: 'nearest' }); }
           }

           function dn_doc_geser(arah) {
             var j = DN_DOC_AKTIF + arah;
             if (j >= 0 && j < dn_doc_semua().length) { dn_doc_lihat(j); }
           }

           // Hapus dokumen baru yang sedang dilihat, lanjut ke dokumen berikutnya.
           function dn_doc_hapus_aktif() {
             var i = DN_DOC_AKTIF, d = dn_doc_semua()[i];
             if (!d) { return; }
             // Yang sudah tersimpan: hapus di server (modalnya ditutup disana).
             if (d.lama) { dn_doc_hapus_tersimpan(d.id, d.nama); return; }
             dn_doc_hapus(d.baru);
             var n = dn_doc_semua().length;
             if (!n) {
               $('#modal-dn-doc').modal('hide');
               return;
             }
             DN_DOC_AKTIF = Math.min(i, n - 1);
             dn_doc_viewer();
           }

           // Panah kiri/kanan pindah dokumen selama penampil terbuka (kalau fokus
           // sedang di dalam PDF, panah dipakai PDF-nya untuk scroll).
           document.addEventListener('keydown', function (e) {
             if (!window.jQuery || !$('#modal-dn-doc').hasClass('show')) { return; }
             if (e.key === 'ArrowLeft') { dn_doc_geser(-1); }
             if (e.key === 'ArrowRight') { dn_doc_geser(1); }
           });


           function dn_upload_id() {
             var acak = new Uint8Array(16);
             (window.crypto || window.msCrypto).getRandomValues(acak);
             return Array.prototype.map.call(acak, function (b) { return ('0' + b.toString(16)).slice(-2); }).join('');
           }

           // Kirim 1 file per potongan DN_DOC_CHUNK byte (server menyambungnya).
           // Potongan yang gagal karena koneksi dicoba ulang sampai 3x dulu.
           function dn_doc_kirim_file(no_dn, file, progres, beres) {
             var uploadId = dn_upload_id(), offset = 0, coba = 0;
             (function potongan() {
               var ujung = Math.min(offset + DN_DOC_CHUNK, file.size);
               var fd = new FormData();
               fd.append('no_dn', no_dn);
               fd.append('upload_id', uploadId);
               fd.append('nama', file.name);
               fd.append('ukuran', file.size);
               fd.append('offset', offset);
               fd.append('potongan', file.slice(offset, ujung), file.name);
               $.ajax({ url: '<?= base_url('arnag/upload_dn_doc'); ?>', type: 'POST', data: fd, processData: false, contentType: false, dataType: 'JSON' })
                 .done(function (res) {
                   if (!res || !res.status) { beres(res || { message: 'Upload failed.' }); return; }
                   coba = 0;
                   offset = res.received || ujung;
                   progres(Math.min(offset, file.size) / file.size);
                   if (res.done) { beres(null); } else { potongan(); }
                 })
                 .fail(function () {
                   if (++coba <= 3) { setTimeout(potongan, 1000 * coba); } else { beres({ message: 'Connection error.' }); }
                 });
             })();
           }

           // Upload berurutan per file (gagalnya bisa per file). File yang gagal
           // bisa di-retry; Debit Note-nya sendiri sudah tersimpan saat fungsi
           // ini dipanggil.
           function dn_upload_dokumen(no_dn, selesai, antrian, sudah) {
             antrian = antrian || DN_DOKUMEN.slice();
             sudah = sudah || 0;
             if (!antrian.length) { selesai(); return; }

             var total = antrian.length, i = 0, berhasil = 0, gagal = [], tabelBelumAda = false;

             Swal.fire({
               title: 'Uploading Documents',
               html: '<span id="dn-upload-progres"></span><div class="dn-upload-bar"><span id="dn-upload-bar"></span></div>',
               allowOutsideClick: false,
               allowEscapeKey: false,
               showConfirmButton: false,
               didOpen: function () { Swal.showLoading(); kirim(); }
             });

             function kirim() {
               if (i >= total || tabelBelumAda) { return akhir(); }
               var d = antrian[i];
               var label = 'Uploading ' + (i + 1) + ' of ' + total + ': ' + d.file.name;
               var tampil = function (p) {
                 $('#dn-upload-progres').text(label + ' (' + Math.floor(p * 100) + '%)');
                 $('#dn-upload-bar').css('width', (p * 100) + '%');
               };
               tampil(0);

               dn_doc_kirim_file(no_dn, d.file, tampil, function (err) {
                 if (!err) {
                   berhasil++;
                 } else {
                   if (err.code === 'table_missing') { tabelBelumAda = true; }
                   gagal.push({ doc: d, pesan: err.message || 'Upload failed.' });
                 }
                 i++;
                 kirim();
               });
             }

             function akhir() {
               var semua = sudah + berhasil;
               if (tabelBelumAda) {
                 selesai({ icon: 'warning', html: 'Supporting documents were <b>not saved</b> - the document table is not ready yet. Please contact IT.' });
                 return;
               }
               if (!gagal.length) {
                 selesai({ html: semua + ' supporting document' + (semua > 1 ? 's' : '') + ' uploaded.' });
                 return;
               }
               Swal.fire({
                 icon: 'warning',
                 title: 'Some Documents Failed',
                 html: 'The debit note is saved, but ' + gagal.length + ' document' + (gagal.length > 1 ? 's' : '') + ' failed to upload:' +
                       '<ul class="dn-swal-list">' + gagal.map(function (g) { return '<li>' + dn_esc(g.doc.file.name) + ' - ' + dn_esc(g.pesan) + '</li>'; }).join('') + '</ul>',
                 showCancelButton: true,
                 confirmButtonText: 'Retry Upload',
                 cancelButtonText: 'Skip',
                 allowOutsideClick: false
               }).then(function (r) {
                 if (r.isConfirmed) {
                   dn_upload_dokumen(no_dn, selesai, gagal.map(function (g) { return g.doc; }), semua);
                 } else {
                   selesai({ icon: 'warning', html: semua + ' supporting document' + (semua === 1 ? '' : 's') + ' uploaded, ' + gagal.length + ' skipped.' });
                 }
               });
             }
           }

           // Drag & drop ke kotak upload. File yang terlanjur di-drop di luar kotak
           // jangan sampai dibuka browser (halaman pindah & isian form hilang).
           (function () {
             var zona = document.getElementById('dn-doc-drop');
             ['dragenter', 'dragover'].forEach(function (ev) {
               zona.addEventListener(ev, function (e) { e.preventDefault(); zona.classList.add('is-drag'); });
             });
             ['dragleave', 'drop'].forEach(function (ev) {
               zona.addEventListener(ev, function (e) { e.preventDefault(); zona.classList.remove('is-drag'); });
             });
             zona.addEventListener('drop', function (e) { dn_doc_tambah(e.dataTransfer.files); });
             window.addEventListener('dragover', function (e) { e.preventDefault(); });
             window.addEventListener('drop', function (e) { e.preventDefault(); });
           })();

           // jQuery baru dimuat di footer (setelah view ini) - handler modal
           // dipasang setelah halaman selesai dimuat.
           document.addEventListener('DOMContentLoaded', function () {
             $('#modal-dn-doc').on('hidden.bs.modal', function () { document.getElementById('dn-doc-isi').innerHTML = ''; });
           });

           // Mode edit: tampilkan dokumen yang sudah tersimpan.
           dn_doc_render();
         </script>

       <script>
        function cariso() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cariso");
        filter = input.value.toUpperCase();
        table = document.getElementById("example4");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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

      <script>
        function cari_inv_memo() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("carinoinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-inv-memo");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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

      <script>
        function cari_noinvoice() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_noinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-add-bookinvoice");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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

      <script>
        function cari_shipp_num() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari_shipp");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-sj-2");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[4]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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

      <script>
        function cari_inv_alok() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("carinoinv");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-inv-alok");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[4]; //kolom ke berapa.. ini kolom ke 1,, harusnya kolom ke 0
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
      <script type="text/javascript">
        function ubahnomor_dn(kode, pc){
// alert(kode);
$('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    //Ajax Load data from ajax
    // alert(kode);
    pc = pc || document.getElementById('profit_center_dn').value || 'NAG';
    $.ajax({
      url: "ubahnomor_dn/" + kode + "/" + pc,
      type: "GET",
      dataType: "JSON",
      success: function (data) {

        $('[name="dn_number"]').val(data.nomor);
            // $('[name="amount"]').val(total);
            // $('[name="terbilang"]').val(bilang);
            // $('#update-kwt').modal('show'); // show bootstrap modal when complete loaded
            //
            
          },
          error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Error get data from ajax' });
          }
        });
  }
</script>

<?php if (!$is_edit) : /* Edit: nomor baru dibuat server saat save (dn_edit_pc_berubah) */ ?>
<script>
  document.getElementById('profit_center_dn').addEventListener('change', function () {
    const selectedPc = this.value; // NAG atau NAK
    const input = document.getElementById('dn_number');
    let currentVal = input.value;

    console.log("Changed to:", selectedPc);
    console.log("Sebelum:", currentVal);


    // Cek dan ganti kode profit center di no_dn
    if (currentVal.includes('/NAG/')) {
      input.value = currentVal.replace('/NAG/', '/' + selectedPc + '/');
    } else if (currentVal.includes('/NAK/')) {
      input.value = currentVal.replace('/NAK/', '/' + selectedPc + '/');
    } else {
        // Jika belum ada profit center, sisipkan setelah DN
        const parts = currentVal.split('/');
        if (parts.length >= 2 && parts[0] === 'DN') {
            parts.splice(1, 0, selectedPc); // Sisipkan PC di posisi ke-2
            input.value = parts.join('/');
          }
        }
      });
    </script>
<?php endif; ?>

