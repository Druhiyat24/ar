<?php
// Ukuran isian, select2 & tombol untuk layar yang memakai skin DN tapi
// ingin tampilan yang lebih padat (31px). Dipakai bersama layar Invoice &
// Alokasi - pembungkusnya diberi kelas .ci-sm, termasuk tiap modalnya.
?>
<style type="text/css">
/* ===== Ukuran "sm" =====
   Isian, select2, dan tombol dibuat 31px - bukan 38px bawaan skin DN.
   !important dipakai karena templates/header.php mengunci tinggi, padding, dan
   font .form-control / .btn / .select2-selection secara global. Dipasang di
   layar DAN di tiap modal (modal ada di luar .content-wrapper). */
.ci-sm .form-control,
.ci-sm .select2-container .select2-selection--single,
.ci-sm .input-group-text,
.ci-sm .btn {
  height: 31px !important;
  font-size: 12.5px !important;
  border-radius: 6px !important;
}
.ci-sm .form-control { padding: 3px 10px !important; }
.ci-sm .input-group > .form-control { border-radius: 6px 0 0 6px !important; }
.ci-sm .input-group-append .btn { border-radius: 0 6px 6px 0 !important; }
.ci-sm .input-group-text { padding: 0 10px !important; border-radius: 0 6px 6px 0 !important; }
.ci-sm .select2-container .select2-selection--single .select2-selection__rendered {
  line-height: 29px;
  padding-left: 10px;
  font-size: 12.5px;
}
.ci-sm .select2-container .select2-selection--single .select2-selection__arrow { height: 29px; }
.ci-sm .btn { padding: 0 12px !important; }
.ci-sm .btn i { font-size: 11.5px; }
/* Isi dropdown select2 ikut mengecil - dropdown-nya dititipkan ke <body>,
   jadi tidak bisa di-scope ke .ci-sm (aman, style ini cuma dimuat disini). */
.select2-container--bootstrap4 .select2-results__option,
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field { font-size: 12.5px; }
/* Kotak kecil di dalam tabel & angka ringkasan punya ukuran sendiri. */
.ci-sm .dn-table .form-control.ci-kecil { height: 26px !important; font-size: 12px !important; padding: 0 8px !important; }
.ci-sm .ci-sum-row .form-control[readonly] { height: auto !important; padding: 0 !important; font-size: 13.5px !important; }
.ci-sm .ci-sum-row.is-grand .form-control[readonly] { font-size: 18px !important; }
.ci-sm .ci-save-bar .btn { height: 31px !important; font-size: 12.5px !important; padding: 0 16px !important; }
/* Tombol buka/tutup rincian - dibuat datar supaya Grand Total tetap yang
   paling menonjol di kartu ini. */
.nag-skin .btn-ci-rinci,
.ci-sm .btn-ci-rinci {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  width: 100%;
  margin-top: 10px;
  padding: 0 !important;
  border: 1px dashed #cbd5e1 !important;
  border-radius: 8px !important;
  background: #f8fafc;
  color: #475569;
  font-size: 11.5px !important;
  letter-spacing: .2px;
  box-shadow: none !important;
}
.nag-skin .btn-ci-rinci:hover { background: #eef2f7; color: #1e3a5f; }
.nag-skin .btn-ci-rinci i { font-size: 10px; transition: transform .15s ease; }
.nag-skin .btn-ci-rinci.is-buka i { transform: rotate(180deg); }
/* Panel filter di dalam modal. */
.nag-skin .ci-filter {
  background: #f8fafc;
  border: 1px solid #eef2f7;
  border-radius: 10px;
  padding: 14px 16px;
  margin-bottom: 14px;
}
.nag-skin .ci-filter .form-group { margin-bottom: 0; }
/* Kotak cari di atas tabel - ikon kaca pembesar di dalam kotaknya. */
.nag-skin .ci-cari {
  position: relative;
  max-width: 280px;
  width: 100%;
}
.nag-skin .ci-cari .form-control { padding-left: 30px !important; }
.nag-skin .ci-cari i {
  position: absolute;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 11.5px;
  pointer-events: none;
}

/* ===== Pembungkus tabel =====
   Tabel detail lebih lebar dari kartunya - gesernya harus di DALAM
   pembungkus ini. Tanpa aturan ini kelasnya tidak berarti apa-apa dan
   luberannya jatuh ke halaman: begitu Add Row ditekan, seluruh layar
   yang ikut bergeser ke samping. */
.nag-skin .ci-table-wrap {
  position: relative;
  overflow: auto;
  border: 1px solid #eef2f7;
  border-radius: 10px;
}
.nag-skin .ci-table-wrap::-webkit-scrollbar { width: 12px; height: 12px; }
.nag-skin .ci-table-wrap::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 8px; }
.nag-skin .ci-table-wrap::-webkit-scrollbar-thumb { background: #64748b; border-radius: 8px; border: 3px solid #e2e8f0; }
.nag-skin .ci-table-wrap::-webkit-scrollbar-thumb:hover { background: #475569; }
/* Judul kolomnya tetap kelihatan waktu isinya digulir. */
.nag-skin .ci-table-wrap .dn-table thead th { position: sticky; top: 0; z-index: 3; }
</style>
