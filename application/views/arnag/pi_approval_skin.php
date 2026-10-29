<!-- ==========================================================================
     Gaya bersama layar First & Second Approval Proforma Invoice.

     Dipakai dua layar yang isinya memang kembar, jadi gayanya ditulis sekali
     di sini. Dimuat SESUDAH arnag/dn_skin - ini cuma penyesuaian di atasnya:
     ukuran "sm", kotak cari nomor, dan baris tombol Approved.
     ========================================================================== -->
<style type="text/css">
/* Baris tombol di bawah saringan - header.php membuang margin .form-group
   di .row.align-items-end, jadi jaraknya diberi di sini. */
.nag-skin .pi-aksi { margin-top: 12px; }
@media (min-width: 1280px) {
  /* Di layar lebar semuanya muat satu baris: dua kotak tanggal lalu tombolnya
     menempel di sebelahnya. */
  .nag-skin .pi-filter > .pi-f-tgl { flex: 0 0 18%; max-width: 18%; }
  .nag-skin .pi-filter > .pi-f-aksi { flex: 0 0 auto; width: auto; max-width: none; }
  .nag-skin .pi-filter .pi-aksi { margin-top: 0; flex-wrap: nowrap; }
}

/* ===== Ukuran "sm" =====
   Sama dengan layar daftar Proforma Invoice: 31px, bukan 38px bawaan skin.
   !important dipakai karena templates/header.php mengunci tinggi, padding dan
   font .form-control / .btn secara global. */
.nag-skin .card-body .form-control,
.nag-skin .card-body .input-group-text,
.nag-skin .pi-aksi .btn {
  height: 31px !important;
  font-size: 12.5px !important;
  border-radius: 6px !important;
}
.nag-skin .card-body .form-control { padding: 3px 10px !important; }
.nag-skin .card-body .input-group > .form-control { border-radius: 6px 0 0 6px !important; }
.nag-skin .card-body .input-group-text { padding: 0 10px !important; border-radius: 0 6px 6px 0 !important; }
.nag-skin .pi-aksi .btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 0 12px !important;
}
.nag-skin .pi-aksi .btn i { font-size: 11.5px; }

/* ===== Kotak cari nomor =====
   Isi tabelnya digambar crud-nag.js (bukan DataTables), jadi kotak carinya
   disediakan sendiri di sebelah judul tabel. */
.nag-skin .pi-cari {
  display: flex;
  align-items: center;
  gap: 0;
  margin-left: auto;
}
.nag-skin .pi-cari .pi-cari-ikon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 31px;
  height: 29px;
  border: 1px solid #dbe3ee;
  border-right: 0;
  border-radius: 6px 0 0 6px;
  background: #f8fafc;
  color: #64748b;
  font-size: 11.5px;
}
.nag-skin .pi-cari input {
  height: 29px;
  width: 220px;
  max-width: 48vw;
  padding: 0 10px;
  border: 1px solid #dbe3ee;
  border-radius: 0 6px 6px 0;
  font-size: 12.5px;
  color: #334155;
  outline: none;
}
.nag-skin .pi-cari input:focus { border-color: #1e3a5f; }

/* ===== Tabelnya =====
   Dua belas kolom, jadi yang menggulung tabelnya sendiri - bukan halamannya. */
.nag-skin .pi-tabel-gulung { overflow-x: auto; }
.nag-skin .pi-tabel-gulung .dn-table { margin-bottom: 0; }
.nag-skin .dn-table tbody td input[type="checkbox"],
.nag-skin .dn-table thead th input[type="checkbox"] { cursor: pointer; }

/* ===== Tombol Approve =====
   Warnanya sama persis dengan Second Approval Invoice - letaknya pun sama,
   berdiri di baris aksi bersama tombol Search. */
.nag-skin .btn-dn-approve {
  background: linear-gradient(135deg, #b45309, #d97706) !important;
  border: none !important;
  color: #fff !important;
}

/* Kolom centang: dibikin lega supaya gampang diklik - sama dengan acuannya. */
.nag-skin .dn-table td.dn-cek,
.nag-skin .dn-table th.dn-cek { text-align: center; width: 52px; }
.nag-skin .dn-table .dn-cek input[type="checkbox"] {
  width: 17px;
  height: 17px;
  cursor: pointer;
  accent-color: #1e3a5f;
  vertical-align: middle;
}

/* ===== Dialog Swal =====
   Dipasang ke .swal2-popup langsung karena dialognya dipanggil dari
   crud-nag.js yang dipakai bareng layar lain; berkas gaya ini cuma dimuat
   di kedua layar approval. */
.swal2-popup { border-radius: 14px; }
.swal2-popup .swal2-title { color: #1e3a5f; font-size: 19px; }
.swal2-popup .swal2-html-container { font-size: 13.5px; }
.swal2-popup .swal2-icon.swal2-question,
.swal2-popup .swal2-icon.swal2-warning { border-color: #1e3a5f !important; color: #1e3a5f !important; }
.swal2-popup .swal2-styled {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  min-width: 104px;
  height: 34px;
  padding: 0 16px !important;
  border-radius: 6px !important;
  font-size: 12.5px !important;
  font-weight: 600;
  line-height: 1;
}
.swal2-popup .swal2-confirm { background: #1e3a5f !important; border-color: #1e3a5f !important; }
.swal2-popup .swal2-confirm:hover { filter: brightness(.92); }
.swal2-popup .swal2-cancel { background: #f1f5f9 !important; color: #334155 !important; border-color: #f1f5f9 !important; }
.swal2-popup .swal2-cancel:hover { background: #e2e8f0 !important; }
</style>
