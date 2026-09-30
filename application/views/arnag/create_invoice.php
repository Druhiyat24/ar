<!-- ==========================================================================
     Create Invoice - satu layar untuk garment (NAG) & knitting (NAK).
     Tampilannya mengikuti menu Debit Note (skin .nag-skin di dn_skin.php).

     Kenapa bisa satu layar (dulu dua):
       - Other Charge sudah tidak dipakai lagi.
       - Nilai shipment knitting sekarang sama dengan nilai billing-nya, jadi
         tidak perlu lagi dua kolom angka (Total vs Total Shipment).
     Profit center diambil dari booking invoice yang dipilih - itu yang
     menentukan sumber SO/SJ (garment MySQL atau knitting PostgreSQL) dan
     tabel mana saja yang ditulis waktu Save.

     Penyimpanannya TIDAK berubah: endpoint, nama field, dan tabel tujuannya
     persis sama dengan dua layar lama (lihat crud-create-invoice.js).
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
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

/* ===== Khusus layar Create Invoice ===== */
/* Kartu atas dibuat sama tinggi biar rapi bersebelahan. */
.nag-skin .ci-baris-atas > [class*="col-"] { display: flex; }
.nag-skin .ci-baris-atas > [class*="col-"] > .card { flex: 1; }

/* Isian yang nilainya datang dari booking / master - dibedakan supaya jelas
   mana yang memang tidak bisa diketik. */
.nag-skin .ci-ikut .form-control[readonly] { background: #f1f5f9 !important; color: #475569; }

/* Penanda profit center di samping nomor invoice. */
.nag-skin .ci-pc-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  height: 24px;
  padding: 0 10px;
  border-radius: 999px;
  background: #e0f2fe;
  color: #075985;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .4px;
}
.nag-skin .ci-pc-badge[hidden] { display: none; }
.nag-skin .ci-pc-badge.is-nak { background: #dcfce7; color: #166534; }

/* Tabel detail & tabel di dalam modal: tinggi dibatasi, isinya digulir
   sendiri supaya tombol Save tidak terdorong jauh ke bawah. */
.nag-skin .ci-table-wrap {
  position: relative;
  overflow: auto;
  border: 1px solid #eef2f7;
  border-radius: 10px;
}
#ci-table-wrap { max-height: 380px; }
#ci-so-wrap    { max-height: 220px; }
#ci-sj-wrap    { max-height: 300px; }
.nag-skin .ci-table-wrap::-webkit-scrollbar { width: 12px; height: 12px; }
.nag-skin .ci-table-wrap::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 8px; }
.nag-skin .ci-table-wrap::-webkit-scrollbar-thumb { background: #64748b; border-radius: 8px; border: 3px solid #e2e8f0; }
.nag-skin .ci-table-wrap::-webkit-scrollbar-thumb:hover { background: #475569; }
.nag-skin .ci-table-wrap .dn-table thead th { position: sticky; top: 0; z-index: 3; }
/* dn_skin mengunci kolom TERAKHIR ke kanan - itu pas untuk tabel daftar yang
   kolom terakhirnya Action, tapi di modal ini kolom terakhirnya data (Amount /
   Status), jadi malah mengambang di atas kolom lain. Yang dimatikan HANYA sel
   isinya; judul kolomnya tetap sticky ke atas seperti kolom lain - kalau ikut
   dimatikan, judul Amount-nya ikut tergulir dan barisnya kelihatan menembus. */
.nag-skin #ci-book-wrap .dn-table tbody td:last-child,
.nag-skin #ci-top-wrap .dn-table tbody td:last-child,
.nag-skin #ci-so-wrap .dn-table tbody td:last-child {
  position: static;
  box-shadow: none;
}
.nag-skin #ci-book-wrap .dn-table thead th:last-child,
.nag-skin #ci-top-wrap .dn-table thead th:last-child,
.nag-skin #ci-so-wrap .dn-table thead th:last-child {
  /* Judulnya tetap menempel ke atas, tapi tidak dikunci ke kanan - sama
     dengan sel isinya di atas. */
  position: sticky;
  top: 0;
  right: auto;
  background: #1e3a5f;
  box-shadow: none;
}
/* Tabel yang kolom terakhirnya MEMANG Action (Detail SJ di layar & daftar SJ
   di modal): sel isinya dikunci ke kanan oleh dn_skin, jadi judulnya harus
   ikut dikunci - kalau tidak, judul Action-nya tertinggal waktu tabel digeser
   dan barisnya kelihatan menembus ke atas. */
.nag-skin #ci-table-wrap .dn-table thead th:last-child,
.nag-skin #ci-sj-wrap .dn-table thead th:last-child {
  position: sticky;
  top: 0;
  right: 0;
  z-index: 7;
  background: #1e3a5f;
}

/* Daftar booking: lebar kolomnya dipatok supaya seluruh kolom muat tanpa
   digeser ke samping. Nama customer yang panjang dipotong dengan elipsis. */
/* Lebarnya persen, bukan piksel: berapa pun lebar modalnya (layar kecil, atau
   jendela browser yang dikecilkan) seluruh kolom tetap muat - tidak ada geser
   ke samping. Judul & isi boleh turun baris, itu yang bikin kolom bisa
   menyempit tanpa terpotong. */
.nag-skin #ci-book-table { table-layout: fixed; width: 100%; }
/* Boleh turun baris di spasi, tapi kata/angka tidak dipotong di tengah -
   "1,038,716.22" harus tetap utuh. */
.nag-skin #ci-book-table thead th,
.nag-skin #ci-book-table tbody td { white-space: normal; line-height: 1.3; overflow: hidden; }
.nag-skin #ci-book-table th:nth-child(1),  .nag-skin #ci-book-table td:nth-child(1)  { width: 10%; }
.nag-skin #ci-book-table th:nth-child(2),  .nag-skin #ci-book-table td:nth-child(2)  { width: 14%; }
.nag-skin #ci-book-table th:nth-child(3),  .nag-skin #ci-book-table td:nth-child(3)  { width: 7%; }
.nag-skin #ci-book-table th:nth-child(4),  .nag-skin #ci-book-table td:nth-child(4)  { width: 18%; }
.nag-skin #ci-book-table th:nth-child(5),  .nag-skin #ci-book-table td:nth-child(5)  { width: 6%; }
.nag-skin #ci-book-table th:nth-child(6),  .nag-skin #ci-book-table td:nth-child(6)  { width: 8%; }
.nag-skin #ci-book-table th:nth-child(7),  .nag-skin #ci-book-table td:nth-child(7)  { width: 10%; }
.nag-skin #ci-book-table th:nth-child(8),  .nag-skin #ci-book-table td:nth-child(8)  { width: 9%; }
.nag-skin #ci-book-table th:nth-child(9),  .nag-skin #ci-book-table td:nth-child(9)  { width: 9%; }
.nag-skin #ci-book-table th:nth-child(10), .nag-skin #ci-book-table td:nth-child(10) { width: 9%; }

/* Tombol pilih di kolom Action. Warnanya senada kepala modal (biru tua) tapi
   dibuat versi muda - tulisannya biru tua, bukan putih, supaya tetap terbaca
   di atas baris tabel yang putih. Selektornya dibuat kuat (.dn-table .btn)
   karena header.php & dn_skin sama-sama memaksa gaya .btn. */
.nag-skin .dn-table .btn.btn-ci-pilih,
.ci-sm .dn-table .btn.btn-ci-pilih {
  display: inline-flex !important;
  align-items: center;
  justify-content: center;
  gap: 5px;
  white-space: nowrap;
  height: 26px !important;
  min-width: 74px;
  padding: 0 10px !important;
  /* Warnanya disamakan dengan tombol Add Book Inv / Add SO (btn-info di
     header.php) supaya satu bahasa warna di seluruh layar ini. */
  border: none !important;
  border-radius: 6px !important;
  background: linear-gradient(135deg, #006064, #00838f) !important;
  color: #ffffff !important;
  font-size: 11px !important;
  font-weight: 700 !important;
  letter-spacing: .4px;
  text-transform: uppercase;
  box-shadow: 0 1px 3px rgba(15, 23, 42, .18) !important;
}
.nag-skin .dn-table .btn.btn-ci-pilih:hover,
.ci-sm .dn-table .btn.btn-ci-pilih:hover {
  background: linear-gradient(135deg, #00838f, #0097a7) !important;
  color: #ffffff !important;
  box-shadow: 0 3px 8px rgba(15, 23, 42, .25) !important;
}
.nag-skin .dn-table .btn.btn-ci-pilih:active { background: linear-gradient(135deg, #004d51, #006064) !important; }

/* Booking yang datang dari Invoice EXIM: barisnya terkunci, jadi diberi
   keterangan dan ikon gembok menggantikan tombol hapus baris. */
.nag-skin .ci-catatan-exim {
  display: block;
  margin-top: 5px;
  padding: 6px 10px;
  border: 1px solid #fde68a;
  border-radius: 8px;
  background: #fffbeb;
  color: #92400e;
  font-size: 11.5px;
  line-height: 1.5;
}
.nag-skin .ci-catatan-exim[hidden] { display: none; }
/* SJ-nya belum terbit: bukan larangan, cuma perlu diketahui - jadi warnanya
   kuning seperti keterangan lain, bukan merah. */
.nag-skin .ci-catatan-nosj { border-color: #bfdbfe; background: #eff6ff; color: #1e40af; }
.nag-skin #ci-so-terbatas { margin: 10px 0 0; }
.nag-skin #ci-so-terbatas[hidden] { display: none; }
.nag-skin .ci-book-nosj { background: #fffdf5; }
.nag-skin .ci-lencana-nosj {
  display: inline-block;
  margin-left: 4px;
  padding: 0 6px;
  border-radius: 9px;
  background: #fef3c7;
  color: #92400e;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .3px;
}
.nag-skin .ci-catatan-exim i { margin-right: 5px; opacity: .8; }
.nag-skin .dn-table .ci-kunci { color: #94a3b8; font-size: 12px; }

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

/* Layar di bawah 1700px: Detail SJ kolomnya 17, jarak dalam selnya dirapatkan
   supaya tabelnya tetap muat utuh - bukan tabelnya yang digeser ke samping. */
@media (max-width: 1700px) {
  .nag-skin #ci-table thead th { padding-left: 7px; padding-right: 7px; }
  .nag-skin #ci-table tbody td { padding-left: 6px; padding-right: 6px; }
}
@media (max-width: 1400px) {
  .nag-skin #ci-table thead th,
  .nag-skin #ci-table tbody td { padding-left: 4px; padding-right: 4px; font-size: 12px; }
}

/* Kotak isian di dalam tabel (Discount %) - seukuran isinya saja. */
.nag-skin .dn-table .form-control.ci-kecil {
  height: 26px;
  width: 74px;
  margin-left: auto;
  padding: 0 8px;
  text-align: right;
  font-size: 12px;
  border-radius: 6px;
}
.nag-skin .dn-table td.ci-angka { text-align: right; font-variant-numeric: tabular-nums; }
.nag-skin .dn-table td.ci-tengah { text-align: center; }

/* Keterangan waktu tabel masih kosong. */
.nag-skin .ci-kosong {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  padding: 34px 12px;
  color: #94a3b8;
  font-size: 12.5px;
  text-align: center;
}
.nag-skin .ci-kosong i { font-size: 22px; opacity: .6; }

/* Baris ringkasan uang - gaya sama dengan ringkasan Debit Note. */
.nag-skin .ci-sum-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 7px 0;
  border-bottom: 1px dashed #e2e8f0;
}
.nag-skin .ci-sum-row > span {
  font-size: 11.5px;
  font-weight: 600;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #64748b;
  white-space: nowrap;
}
.nag-skin .ci-sum-row .form-control[readonly] {
  height: auto;
  padding: 0 !important;
  border: 0 !important;
  background: transparent !important;
  box-shadow: none !important;
  text-align: right;
  font-size: 13.5px;
  font-weight: 600;
  color: #1e293b;
  font-variant-numeric: tabular-nums;
}
/* Booking dari Invoice EXIM: DP, DP/CBD, dan Return diketik disini karena
   layar itu tidak lewat modal Add SO. Kotaknya dibuat terlihat sebagai isian,
   bukan angka tempelan seperti baris ringkasan lainnya. */
.nag-skin .ci-sum-row .form-control.ci-bisa-isi,
.ci-sm .ci-sum-row .form-control.ci-bisa-isi {
  height: 28px !important;
  width: 160px;
  flex: 0 0 160px;
  padding: 0 10px !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 6px !important;
  background: #fff !important;
  text-align: right !important;
  font-size: 12.5px !important;
  font-weight: 600;
  font-variant-numeric: tabular-nums;
  color: #1e293b;
}
.nag-skin .ci-sum-row .form-control.ci-bisa-isi:focus {
  border-color: #2c5282 !important;
  box-shadow: 0 0 0 3px rgba(44, 82, 130, .15) !important;
}

.nag-skin .ci-sum-row.is-grand { border-bottom: 0; padding-top: 12px; }
.nag-skin .ci-sum-row.is-grand > span { color: #0f172a; font-size: 12.5px; }
.nag-skin .ci-sum-row.is-grand .form-control[readonly] { font-size: 18px; font-weight: 700; color: #0f172a; }
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

.nag-skin .ci-save-bar { display: flex; justify-content: flex-end; gap: 8px; margin-top: 14px; }
.nag-skin .ci-save-bar .btn { min-width: 120px; height: 40px; padding: 0 22px !important; font-size: 14px; }

/* Panel filter di dalam modal. */
.nag-skin .ci-filter {
  background: #f8fafc;
  border: 1px solid #eef2f7;
  border-radius: 10px;
  padding: 14px 16px;
  margin-bottom: 14px;
}
.nag-skin .ci-filter .form-group { margin-bottom: 0; }

/* Ringkasan pilihan di kaki modal Add SO. */
/* Catatan SJ yang disembunyikan (sudah dipesan booking Invoice EXIM). */
.nag-skin #ci-sj-dipakai { margin: 10px 0 0; }
.nag-skin #ci-sj-dipakai[hidden] { display: none; }
/* Keterangan aturan "satu invoice = satu tanggal SJ" + baris yang dikunci
   karena tanggalnya beda. */
.nag-skin .ci-catatan-tgl {
  display: block;
  margin: 10px 0 0;
  padding: 6px 10px;
  border: 1px solid #bfdbfe;
  border-radius: 8px;
  background: #eff6ff;
  color: #1e40af;
  font-size: 11.5px;
  line-height: 1.5;
}
.nag-skin .ci-catatan-tgl[hidden] { display: none; }
.nag-skin .ci-catatan-tgl i { margin-right: 5px; opacity: .8; }
.nag-skin .dn-table tr.is-kunci-tgl > td { background: #f8fafc; color: #94a3b8; }
/* Kotak centangnya memang dihilangkan, bukan cuma dimatikan - begitu pilihannya
   dikosongkan, kotaknya muncul lagi. */
.nag-skin .dn-table tr.is-kunci-tgl .ci-sj-cek { display: none; }
.nag-skin .ci-pilih-info {
  margin-top: 10px;
  font-size: 12px;
  color: #475569;
}
.nag-skin .ci-pilih-info b { color: #0f172a; }
.nag-skin .ci-pilih-qty {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  margin-left: 10px;
  padding: 3px 10px;
  border-radius: 999px;
  background: #eef4fb;
  color: #1e3a5f;
  font-size: 11.5px;
}

/* Blok angka di modal Add SO - tampilannya sama dengan kartu Summary di
   layar: label kiri, angka kanan, dipisah garis putus-putus. Yang berbeda cuma
   disini semuanya selalu terlihat (di layar hanya Grand Total yang tampil
   duluan), sebab di modal inilah angkanya diisi. */
.nag-skin .ci-uang {
  padding: 4px 16px 6px;
  border: 1px solid #eef2f7;
  border-radius: 10px;
  background: #fff;
}
.nag-skin .ci-uang-baris {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 7px 0;
  border-bottom: 1px dashed #e2e8f0;
}
.nag-skin .ci-uang-baris > label {
  margin: 0;
  font-size: 11.5px;
  font-weight: 600;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #64748b;
  white-space: nowrap;
}
/* Angka yang dihitung sendiri: tempelan teks, bukan kotak isian. */
.nag-skin .ci-uang-baris .form-control[readonly],
.ci-sm .ci-uang-baris .form-control[readonly] {
  height: auto !important;
  padding: 0 !important;
  border: 0 !important;
  background: transparent !important;
  box-shadow: none !important;
  text-align: right;
  font-size: 13.5px !important;
  font-weight: 600;
  color: #1e293b;
  font-variant-numeric: tabular-nums;
}
/* Down Payment, DP/CBD & Return diketik disini - kotaknya dibiarkan
   kelihatan sebagai isian, sama seperti di kartu Summary. */
.nag-skin .ci-uang-baris .form-control:not([readonly]),
.ci-sm .ci-uang-baris .form-control:not([readonly]) {
  height: 28px !important;
  width: 170px;
  flex: 0 0 170px;
  padding: 0 10px !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 6px !important;
  background: #fff !important;
  text-align: right !important;
  font-size: 12.5px !important;
  font-weight: 600;
  color: #1e293b;
  font-variant-numeric: tabular-nums;
}
.nag-skin .ci-uang-baris .form-control:not([readonly]):focus {
  border-color: #2c5282 !important;
  box-shadow: 0 0 0 3px rgba(44, 82, 130, .15) !important;
}
.nag-skin .ci-uang-baris.is-grand { border-bottom: 0; padding-top: 12px; }
.nag-skin .ci-uang-baris.is-grand > label { color: #0f172a; font-size: 12.5px; }
.nag-skin .ci-uang-baris.is-grand .form-control[readonly],
.ci-sm .ci-uang-baris.is-grand .form-control[readonly] {
  font-size: 18px !important;
  font-weight: 700;
  color: #0f172a;
}
.nag-skin .ci-vat-opsi { display: flex; gap: 14px; align-items: center; margin: 0; }
.nag-skin .ci-vat-opsi .custom-control-label {
  font-size: 11.5px;
  font-weight: 600;
  letter-spacing: .3px;
  text-transform: uppercase;
  color: #64748b;
  white-space: nowrap;
}
.nag-skin .ci-vat-opsi .custom-control { padding-left: 1.4rem; }

/* ===== Supporting document =====
   Bentuknya disamakan dengan Debit Note (.dn-doc-* di create_debitnote.php):
   file dipilih dulu di layar (bisa dibuka sebelum save), di-upload setelah
   invoice-nya tersimpan. Awalan .ci-doc- dipakai untuk LAMPIRAN - jangan
   tertukar dengan isian Document Type / Document Number di kartu kiri. */
.nag-skin .ci-doc-drop {
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
.nag-skin .ci-doc-drop.is-drag { border-color: #2c5282; background: #eef2f7; }
.nag-skin .ci-doc-hint { font-size: 12px; color: #94a3b8; }
/* Jumlah file di samping label. */
.nag-skin .ci-doc-jumlah:not(:empty) {
  margin-left: 6px;
  padding: 1px 8px;
  border-radius: 999px;
  background: #eef4fb;
  color: #1e3a5f;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0;
  text-transform: none;
  vertical-align: 1px;
}

/* File tampil sebagai chip berjejer di dalam kotak upload - lebih dari ~2
   baris scroll di dalam kotak, jadi form tidak memanjang ke bawah. */
.nag-skin .ci-doc-list {
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
.nag-skin .ci-doc-list:empty { display: none; }
.nag-skin .ci-doc-item {
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
.nag-skin .ci-doc-ikon { flex: 0 0 auto; font-size: 13px; }
.nag-skin .ci-doc-ikon.is-pdf { color: #b91c1c; }
.nag-skin .ci-doc-ikon.is-img { color: #0369a1; }
.nag-skin .ci-doc-nama {
  max-width: 160px;
  overflow: hidden;
  font-size: 12.5px;
  color: #1e293b;
  text-overflow: ellipsis;
  white-space: nowrap;
  cursor: pointer;
}
.nag-skin .ci-doc-nama:hover { color: #1d4ed8; text-decoration: underline; }
.nag-skin .ci-doc-ukuran { font-size: 11px; color: #94a3b8; white-space: nowrap; }
.nag-skin .ci-doc-aksi { display: inline-flex; }
.nag-skin .ci-doc-aksi .btn,
.nag-skin .ci-doc-aksi .btn:hover {
  width: 24px;
  height: 24px !important;
  padding: 0 !important;
  border-radius: 6px !important;
  background: transparent;
  color: #64748b;
  font-size: 11px;
  box-shadow: none !important;
  filter: none;
}
.nag-skin .ci-doc-aksi .btn:hover { background: #eef2f7; color: #1e3a5f; }
.nag-skin .ci-doc-aksi .ci-doc-hapus:hover { background: #fee2e2; color: #b91c1c; }

/* Progres upload di swal */
.ci-upload-bar { height: 6px; margin-top: 12px; overflow: hidden; border-radius: 999px; background: #e2e8f0; }
.ci-upload-bar > span { display: block; width: 0; height: 100%; background: #1e3a5f; transition: width .2s ease; }
.ci-swal-list { margin: 8px 0 0; padding-left: 18px; text-align: left; font-size: 12.5px; }

/* ===== Penampil pratinjau PDF (modal) ===== */
.ci-pdf-dialog { max-width: min(1100px, 94vw); }
.ci-pdf-dialog .modal-content { height: 92vh; }
.ci-pdf-body { display: flex; flex: 1 1 auto; min-height: 0; background: #525659; }
#ci-pdf-frame { flex: 1; width: 100%; height: 100%; border: 0; background: #525659; }
/* Pemilih berkas pratinjau (knitting punya dua cetakan). */
.ci-pdf-pilih { display: flex; gap: 6px; margin-left: 18px; }
.ci-pdf-pilih[hidden] { display: none; }
.nag-skin .ci-pdf-pilih .btn,
.ci-sm .ci-pdf-pilih .btn {
  height: 27px !important;
  padding: 0 12px !important;
  border: 1px solid rgba(255, 255, 255, .28) !important;
  border-radius: 999px !important;
  background: transparent;
  color: rgba(248, 250, 252, .75);
  font-size: 11.5px !important;
  box-shadow: none !important;
}
.nag-skin .ci-pdf-pilih .btn:hover { background: rgba(255, 255, 255, .12); color: #fff; }
.nag-skin .ci-pdf-pilih .btn.is-aktif {
  border-color: #fff !important;
  background: #fff;
  color: #1e3a5f;
  font-weight: 600;
}

.ci-pdf-tanda {
  margin: 0 12px 0 auto;
  padding: 3px 11px;
  border-radius: 999px;
  background: rgba(255, 255, 255, .16);
  color: #f8fafc;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .4px;
  white-space: nowrap;
}

/* ===== Penampil supporting document (modal) ===== */
.ci-doc-dialog { max-width: min(1320px, 94vw); }
.ci-doc-dialog .modal-content { height: 90vh; }
.ci-doc-head { flex: 1; min-width: 0; }
.ci-doc-head .modal-title { min-width: 0; }
.ci-doc-head .modal-title span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.ci-doc-meta { margin: 3px 0 0 22px; font-size: 11.5px; color: rgba(248, 250, 252, .6); }
.ci-doc-posisi {
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
.ci-doc-body { display: flex; flex: 1 1 auto; min-height: 0; }

/* Daftar dokumen di kiri */
.ci-doc-side {
  flex: 0 0 250px;
  display: flex;
  flex-direction: column;
  min-height: 0;
  border-right: 1px solid #e2e8f0;
  background: #f8fafc;
}
.ci-doc-side-judul {
  padding: 14px 16px 8px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #64748b;
}
.ci-doc-side-list { flex: 1; margin: 0; padding: 0 8px 10px; overflow-y: auto; list-style: none; }
.ci-doc-side-list li {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 2px;
  padding: 7px 8px;
  border: 1px solid transparent;
  border-radius: 8px;
  cursor: pointer;
}
.ci-doc-side-list li:hover { background: #eef2f7; }
.ci-doc-side-list li.is-aktif {
  border-color: #cbd5e1;
  background: #fff;
  box-shadow: inset 3px 0 0 #1e3a5f, 0 1px 2px rgba(15, 23, 42, .06);
}
.ci-doc-thumb {
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
.ci-doc-thumb.is-pdf { background: #fee2e2; color: #b91c1c; }
.ci-doc-thumb.is-img { background: #e0f2fe; color: #0369a1; }
.ci-doc-thumb img { width: 100%; height: 100%; object-fit: cover; }
.ci-doc-side-info { display: flex; flex-direction: column; min-width: 0; }
.ci-doc-side-nama { overflow: hidden; font-size: 12.5px; color: #1e293b; text-overflow: ellipsis; white-space: nowrap; }
.ci-doc-side-list li.is-aktif .ci-doc-side-nama { font-weight: 600; color: #0f172a; }
.ci-doc-side-ukuran { font-size: 11px; color: #94a3b8; }

/* Area preview - latar abu gelap senada penampil PDF bawaan browser */
.ci-doc-preview {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 0;
  overflow: hidden;
  background: #525659;
}
.ci-doc-preview iframe { display: block; width: 100%; height: 100%; border: 0; }
.ci-doc-preview img {
  display: block;
  max-width: calc(100% - 40px);
  max-height: calc(100% - 40px);
  border-radius: 4px;
  box-shadow: 0 6px 24px rgba(0, 0, 0, .35);
  background: #fff;
  cursor: zoom-in;
}
/* Gambar diklik -> ukuran asli, bisa digeser */
.ci-doc-preview.is-zoom { align-items: flex-start; justify-content: flex-start; overflow: auto; }
.ci-doc-preview.is-zoom img { max-width: none; max-height: none; margin: 20px; cursor: zoom-out; }

.ci-doc-nav { display: flex; flex-wrap: wrap; gap: 8px; }
.nag-skin .ci-doc-btn-hapus { color: #b91c1c; }
.nag-skin .ci-doc-btn-hapus:hover { background: #fee2e2; }

@media (max-width: 767.98px) {
  .ci-doc-side { display: none; }
  .ci-doc-dialog { max-width: none; margin: 0; }
  .ci-doc-dialog .modal-content { height: 100vh; border-radius: 0 !important; }
}

/* ===== SweetAlert =====
   Swal menempel ke <body>, di luar .nag-skin - jadi dikasih kelas sendiri.
   Isinya sama dengan dialog di menu Invoice EXIM supaya seragam. */
.ci-swal { border-radius: 14px; }
.ci-swal .swal2-title { color: #1e3a5f; font-size: 19px; }
.ci-swal .swal2-icon.swal2-question { border-color: #1e3a5f !important; color: #1e3a5f !important; }
/* Tombol dialog dibuat seragam - tingginya sama, tidak ada yang lebih besar
   sendiri, dan ukurannya mengikuti tombol "sm" di layar. */
.ci-swal .swal2-styled {
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
.ci-swal .swal2-styled i { font-size: 11.5px; }
.ci-swal .swal2-confirm { background: #1e3a5f !important; border-color: #1e3a5f !important; }
.ci-swal .swal2-confirm:hover { filter: brightness(.92); }
.ci-swal .swal2-cancel { background: #f1f5f9 !important; color: #334155 !important; }
.ci-swal .swal2-cancel:hover { background: #e2e8f0 !important; }

/* Ringkasan sebelum simpan: label kiri, nilai kanan. */
.ci-swal .ci-swal-ringkas {
  text-align: left;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  overflow: hidden;
  margin: 4px 0 12px;
}
.ci-swal .ci-swal-ringkas > div {
  display: flex;
  justify-content: space-between;
  gap: 16px;
  padding: 7px 14px;
  font-size: 13px;
  border-bottom: 1px solid #eef2f7;
}
.ci-swal .ci-swal-ringkas > div:last-child { border-bottom: 0; }
.ci-swal .ci-swal-ringkas span { color: #64748b; }
.ci-swal .ci-swal-ringkas b { color: #1e293b; text-align: right; font-variant-numeric: tabular-nums; }
.ci-swal .ci-swal-ringkas .ci-swal-grand { background: #eef2f7; }
.ci-swal .ci-swal-ringkas .ci-swal-grand b { color: #1e3a5f; font-size: 15px; }
/* Daftar isian yang belum lengkap: tiap baris punya ikon, nama isian, dan
   keterangan singkat harus melakukan apa. */
.ci-swal .ci-swal-sub { font-size: 13px; color: #475569; text-align: left; margin-bottom: 10px; }

/* Dialog "Update Invoice EXIM to match the SJ?" - ringkasan angkanya dibaca
   dulu, rinciannya per bagian di bawahnya. */
.ci-swal .ci-swal-ringkas-ubah {
  margin: 2px 0 8px;
  padding: 7px 10px;
  text-align: left;
  font-size: 12.5px;
  color: #334155;
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
}
.ci-swal .ci-swal-ringkas-ubah b { color: #0f172a; font-variant-numeric: tabular-nums; }
.ci-swal .ci-swal-judul-kecil {
  margin: 10px 0 2px;
  text-align: left;
  font-size: 12px;
  font-weight: 700;
  color: #334155;
}
/* Alasan kenapa barisnya berubah - dibuat lebih redup dari judul bagiannya. */
.ci-swal .ci-swal-alasan {
  margin: 0 0 5px;
  text-align: left;
  font-size: 11.5px;
  line-height: 1.45;
  color: #64748b;
}
.ci-swal .ci-swal-daftar {
  margin: 0;
  padding-left: 18px;
  text-align: left;
  font-size: 12.5px;
  line-height: 1.6;
  color: #475569;
}
.ci-swal .ci-swal-daftar b { color: #1e293b; font-variant-numeric: tabular-nums; }
.ci-swal .ci-swal-catatan {
  margin: 10px 0 0;
  text-align: left;
  font-size: 12px;
  line-height: 1.5;
  color: #64748b;
}
.ci-swal .ci-titik { color: #cbd5e1; }
.ci-swal .ci-swal-kurang {
  text-align: left;
  margin: 0;
  padding: 0;
  list-style: none;
}
.ci-swal .ci-swal-kurang li {
  display: flex;
  align-items: flex-start;
  gap: 11px;
  margin-bottom: 8px;
  padding: 9px 12px;
  border: 1px solid #fde68a;
  border-radius: 9px;
  background: #fffbeb;
}
.ci-swal .ci-swal-kurang li:last-child { margin-bottom: 0; }
.ci-swal .ci-swal-kurang li > i {
  flex: 0 0 26px;
  height: 26px;
  line-height: 26px;
  border-radius: 7px;
  background: #fef3c7;
  color: #b45309;
  font-size: 12px;
  text-align: center;
}
.ci-swal .ci-swal-kurang li span { display: block; min-width: 0; }
.ci-swal .ci-swal-kurang li b { display: block; font-size: 13px; color: #1e293b; }
.ci-swal .ci-swal-kurang li small {
  display: block;
  margin-top: 1px;
  font-size: 11.5px;
  line-height: 1.45;
  color: #64748b;
}
.ci-swal .ci-swal-kurang li b, .ci-swal .ci-swal-kurang li small { text-align: left; }

/* Sorotan sebentar di isian yang diminta - muncul sesudah dialognya ditutup. */
.nag-skin .ci-sorot,
.nag-skin .ci-sorot .select2-selection {
  border-color: #f59e0b !important;
  box-shadow: 0 0 0 4px rgba(245, 158, 11, .25) !important;
  border-radius: 6px !important;
  transition: box-shadow .2s ease;
}
.ci-swal .ci-swal-catatan {
  margin: 0;
  font-size: 12px;
  color: #64748b;
  text-align: left;
  line-height: 1.5;
}
.ci-swal .ci-swal-list { margin: 8px 0 0; padding-left: 20px; text-align: left; font-size: 12.5px; }
/* Pengingat waktu invoice disimpan tanpa lampiran. */
.ci-swal .ci-swal-ingat {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin: 0 0 12px;
  padding: 8px 12px;
  border: 1px solid #fde68a;
  border-radius: 8px;
  background: #fffbeb;
  color: #92400e;
  font-size: 12px;
  text-align: left;
  line-height: 1.45;
}
.ci-swal .ci-swal-ingat i { margin-top: 2px; }
/* Penunjuk langkah di dialog "Saving..." - biar kelihatan sedang apa. */
.ci-swal .ci-swal-tahap { margin-top: 10px; font-size: 12px; color: #64748b; }
/* Kabar hasil upload lampiran di dialog penutup. */
.ci-swal .ci-swal-kabar { margin-top: 10px; font-size: 12.5px; color: #64748b; }
/* Dialog penutup punya tiga pilihan - warnanya dibedakan supaya jelas mana
   yang mencetak, mana yang membuat lagi, mana yang keluar. */
.swal2-popup .ci-swal-deny { background: #0e7490 !important; border-color: #0e7490 !important; }
.swal2-popup .ci-swal-deny:hover { filter: brightness(.92); }
.swal2-popup .ci-swal-aksi { flex-wrap: nowrap; gap: 8px; }
.swal2-popup .ci-swal-aksi .swal2-styled { margin: 0; white-space: nowrap; }
</style>

<div class="content-wrapper nag-skin ci-page ci-sm">
  <section class="content">
    <div class="container-fluid">

      <!-- ===== Baris atas: identitas invoice & syarat pembayaran ===== -->
      <div class="row ci-baris-atas">
        <div class="col-lg-6">
          <div class="card ci-ikut">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-file-invoice"></i><?= $title; ?></h3>
            </div>
            <div class="card-body">
              <!-- Penunjuk baris yang dipakai saat simpan - tidak ditampilkan. -->
              <input type="hidden" id="ci-id-inv" name="id_inv">
              <input type="hidden" id="ci-id-cust" name="id_cust">
              <input type="hidden" id="ci-id-top" name="id_top">
              <input type="hidden" id="ci-pc-h" name="profit_ctr_h">
              <input type="hidden" id="ci-grade" name="grade">
              <input type="hidden" id="ci-inv-date" name="inv_date">
              <input type="hidden" id="ci-inv-curr" name="inv_curr">
              <input type="hidden" id="ci-coa-no" name="no_coa_deb">
              <input type="hidden" id="ci-coa-nama" name="nama_coa_deb">
              <input type="hidden" id="ci-rate" name="inv_rate">

              <div class="form-group">
                <label for="ci-inv-number">Invoice Number <span class="ci-pc-badge" id="ci-pc-badge" hidden><i class="fas fa-industry"></i><span id="ci-pc-teks"></span></span></label>
                <div class="input-group">
                  <input type="text" class="form-control" id="ci-inv-number" name="inv_number1" placeholder="Pick a booking invoice" readonly>
                  <?php if (!isset($mode) || $mode !== 'edit') : ?>
                    <!-- Mode edit: booking-nya sudah tetap, jadi tombolnya tidak ada. -->
                    <div class="input-group-append">
                      <button type="button" class="btn btn-info" id="ci-btn-book"><i class="fas fa-plus"></i> Add Book Inv</button>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <div class="form-group">
                <label for="ci-customer">Customer</label>
                <input type="text" class="form-control" id="ci-customer" name="cust" readonly>
              </div>

              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="ci-shipp">Shipp</label>
                  <!-- Knitting boleh mengubah Local/Export (perilaku lama layar
                       knitting); garment ikut apa adanya dari booking. -->
                  <select class="form-control select2bs4" id="ci-shipp" name="shipp" disabled>
                    <option value="">-</option>
                    <option value="Local">Local</option>
                    <option value="Export">Export</option>
                  </select>
                </div>
                <div class="form-group col-sm-6">
                  <label for="ci-type">Invoice Type</label>
                  <input type="text" class="form-control" id="ci-type" name="type" readonly>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="ci-doc-type">Document Type</label>
                  <input type="text" class="form-control" id="ci-doc-type" name="doc_type" readonly>
                </div>
                <div class="form-group col-sm-6">
                  <label for="ci-doc-number">Document Number</label>
                  <input type="text" class="form-control" id="ci-doc-number" name="doc_number" readonly>
                </div>
              </div>

              <!-- Supporting document: tidak wajib, bisa lebih dari 1 file.
                   File-nya ditahan dulu di browser (bisa dibuka lewat penampil),
                   lalu di-upload SETELAH invoice tersimpan - butuh id invoice
                   final & statusnya sudah POST. Lihat docUpload() di
                   crud-create-invoice.js. -->
              <div class="form-group mb-0">
                <label>Supporting Documents <span class="ci-doc-jumlah" id="ci-doc-jumlah"></span></label>
                <!-- File tampil sebagai chip di dalam kotak ini (maks ~2 baris,
                     sisanya scroll) supaya layar tidak memanjang ke bawah. -->
                <div class="ci-doc-drop" id="ci-doc-drop">
                  <input type="file" id="ci-doc-input" class="d-none" multiple accept=".pdf,.jpg,.jpeg,.png,.gif,.webp">
                  <button type="button" class="btn btn-light" id="ci-doc-pilih"><i class="fas fa-paperclip"></i> Choose Files</button>
                  <span class="ci-doc-hint">or drop files here &middot; PDF or image</span>
                  <ul class="ci-doc-list" id="ci-doc-list"></ul>
                </div>
                <small class="text-muted">Uploaded right after the invoice is saved.</small>
              </div>

            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card ci-ikut">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-sliders-h"></i>Terms &amp; Account</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="ci-top">TOP Type</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="ci-top" name="top" placeholder="Pick a term of payment" readonly>
                    <div class="input-group-append">
                      <button type="button" class="btn btn-info" id="ci-btn-top" title="Search term of payment"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
                <div class="form-group col-sm-6">
                  <label for="ci-top-time">Time Period</label>
                  <input type="text" class="form-control" id="ci-top-time" name="top_time" readonly>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="ci-bank">Bank</label>
                  <select class="form-control select2bs4" id="ci-bank" name="id_bank" required>
                    <option value="" selected disabled>-- Select Bank --</option>
                    <?php foreach ($isi_bank as $bank) : ?>
                      <option value="<?= $bank['id']; ?>"><?= $bank['nama_bank']; ?> - <?= $bank['curr']; ?> - <?= $bank['no_rek']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-6">
                  <!-- Nilai booking-nya ditaruh disini supaya kartu kiri &
                       kanan sama panjang. -->
                  <label for="ci-amount">Booking Amount</label>
                  <input type="text" class="form-control" id="ci-amount" name="amount" readonly>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="ci-pph">PPh</label>
                  <select class="form-control select2bs4" id="ci-pph" name="pph" required>
                    <option value="NA" data-idtax="0">NA</option>
                    <?php foreach ($isi_pph as $tx) : ?>
                      <option value="<?= $tx['type']; ?>" data-idtax="<?= $tx['idtax']; ?>"><?= $tx['tax_show']; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <input type="hidden" id="ci-id-pph" name="id_pph" value="0">
                </div>
                <div class="form-group col-sm-6">
                  <label for="ci-type-so">Type SO</label>
                  <select class="form-control select2bs4" id="ci-type-so" name="type_so" required>
                    <option value="FOB">FOB</option>
                    <option value="CMT">CMT</option>
                  </select>
                </div>
              </div>

              <div class="form-group mb-0">
                <label>Sales Order</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="ci-so-list" name="so_number1" placeholder="Pick the SJ rows to invoice" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" id="ci-btn-so"><i class="fas fa-plus"></i> Add SO</button>
                  </div>
                </div>
                <small class="text-muted" id="ci-so-bantu">Pick a booking invoice first - its profit center decides where the SJ comes from.</small>
                <!-- Booking dari Invoice EXIM: SJ-nya sudah dipilih disana. -->
                <small class="ci-catatan-exim" id="ci-catatan-exim" hidden><i class="fas fa-lock"></i>
                  SJ rows come from <b>Invoice EXIM</b> and cannot be changed here.</small>
                <!-- Invoice EXIM boleh dibuat sebelum SJ-nya terbit. SJ-nya
                     dipilih di sini, tapi terbatas pada SO yang dipesan. -->
                <small class="ci-catatan-exim ci-catatan-nosj" id="ci-catatan-nosj" hidden><i class="fas fa-circle-info"></i>
                  The SJ is not issued yet in <b>Invoice EXIM</b>. Use <b>Add SO</b> to pick it -
                  only the SO booked there is listed.</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== Baris SJ yang akan ditagihkan ===== -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Detail SJ</span>
            <div class="dn-filter-aksi">
              <button type="button" class="btn btn-dn-hapus-baris" id="ci-btn-kosongkan"><i class="fas fa-eraser"></i> Clear All</button>
            </div>
          </div>
          <div class="ci-table-wrap" id="ci-table-wrap">
            <table id="ci-table" class="dn-table text-nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>SO Number</th>
                  <th>SJ Number</th>
                  <th>SJ Date</th>
                  <th>Shipping Number</th>
                  <th>WS#</th>
                  <th>Style No</th>
                  <th>Product Group</th>
                  <th>Product Item</th>
                  <th>Color</th>
                  <th>Size</th>
                  <th>Curr</th>
                  <th>UOM</th>
                  <th class="text-right">Qty</th>
                  <th class="text-right">Unit Price</th>
                  <th class="text-right">Disc (%)</th>
                  <th class="text-right">Total Price</th>
                  <th style="width:52px" class="dn-tengah">Action</th>
                </tr>
              </thead>
              <tbody id="ci-tbody">
                <tr>
                  <td colspan="17">
                    <div class="ci-kosong">
                      <i class="fas fa-truck"></i>
                      <span>No SJ selected yet. Use &ldquo;Add SO&rdquo; to pick one.</span>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tfoot id="ci-tfoot" hidden>
                <tr>
                  <td colspan="12" id="ci-foot-kiri"></td>
                  <td class="ci-angka" id="ci-foot-qty">0.00</td>
                  <td colspan="2"></td>
                  <td class="ci-angka" id="ci-foot-total">0.00</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

      <!-- ===== Ringkasan uang + tombol simpan ===== -->
      <div class="row justify-content-end">
        <div class="col-xl-4 col-lg-5 col-md-7">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-calculator"></i>Summary</h3>
            </div>
            <div class="card-body">
              <!-- Yang tampil pertama cuma Grand Total; rinciannya dibuka sendiri
                   lewat tombol di bawah. Isiannya tetap ada di halaman (cuma
                   disembunyikan), jadi perhitungan & payload simpannya sama
                   saja seperti sebelumnya. -->
              <div id="ci-sum-detail" hidden>
                <div class="ci-sum-row"><span>Total</span><input type="text" class="form-control" id="ci-total" name="total" value="0.00" readonly></div>
                <div class="ci-sum-row"><span>Discount</span><input type="text" class="form-control" id="ci-discount" name="discount" value="0.00" readonly></div>
                <div class="ci-sum-row"><span>Down Payment</span><input type="text" class="form-control" id="ci-dp" name="dp" value="0.00" readonly></div>
                <div class="ci-sum-row"><span>DP/CBD from Invoice</span><input type="text" class="form-control" id="ci-dpcbd" name="dp_cbd" value="0.00" readonly></div>
                <div class="ci-sum-row"><span>Return</span><input type="text" class="form-control" id="ci-retur" name="return" value="0.00" readonly></div>
                <div class="ci-sum-row"><span>Total Without Tax</span><input type="text" class="form-control" id="ci-twot" name="twot" value="0.00" readonly></div>
                <div class="ci-sum-row"><span>VAT <small class="text-muted" id="ci-vat-label"></small></span><input type="text" class="form-control" id="ci-vat" name="vat" value="0.00" readonly></div>
              </div>
              <div class="ci-sum-row is-grand"><span>Grand Total</span><input type="text" class="form-control" id="ci-grand" name="grandtotal" value="0.00" readonly></div>
              <button type="button" class="btn btn-ci-rinci" id="ci-sum-toggle">
                <i class="fas fa-chevron-down"></i> <span>Show details</span></button>
              <input type="hidden" id="ci-keterangan" name="keterangan">
              <div class="ci-save-bar">
                <button type="button" class="btn btn-danger" id="ci-btn-kembali"><i class="fas fa-arrow-left"></i> Back</button>
                <button type="button" class="btn btn-primary" id="ci-btn-simpan"><i class="fa fa-save"></i> Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>
</div>
<!-- /.content-wrapper -->

<!-- ============================ Modal: Add Book Inv ======================= -->
<div class="modal fade dn-modal nag-skin ci-sm" id="ci-modal-book" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-file-invoice"></i> Add Book Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="ci-filter">
          <div class="row align-items-end">
            <!-- Profit center ditaruh paling kiri: itu yang paling dulu dipilih,
                 baru rentang tanggalnya. Pilihannya memakai nama lengkap dari
                 master_pc, bukan singkatan NAG/NAK. -->
            <div class="form-group col-md-4 col-lg-3">
              <label for="ci-book-pc">Profit Center</label>
              <select class="form-control select2bs4" id="ci-book-pc">
                <option value="">All profit centers</option>
                <?php foreach ((isset($profit_center) ? $profit_center : array()) as $pc) : ?>
                  <option value="<?= $pc['kode_pc']; ?>"><?= $pc['nama_pc']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-md-4 col-lg-3">
              <label for="ci-book-from">Booking Date From</label>
              <div class="input-group dn-date-group">
                <input type="text" class="form-control tanggal" id="ci-book-from" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-md-4 col-lg-3">
              <label for="ci-book-to">Booking Date To</label>
              <div class="input-group dn-date-group">
                <input type="text" class="form-control tanggal" id="ci-book-to" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-md-4 col-lg-2">
              <div class="dn-filter-aksi">
                <button type="button" class="btn btn-primary" id="ci-book-cari"><i class="fa fa-search"></i> Search</button>
              </div>
            </div>
          </div>
        </div>
        <div class="table-header">
          <span class="table-title"><i class="fas fa-list"></i>Draft Booking Invoice</span>
          <div class="ci-cari"><i class="fas fa-search"></i>
            <input type="text" class="form-control" id="ci-book-filter" placeholder="Search invoice number / customer..."></div>
        </div>
        <div class="ci-table-wrap" id="ci-book-wrap" style="max-height:340px">
          <table id="ci-book-table" class="dn-table text-nowrap">
            <thead>
              <tr>
                <th style="width:70px" class="dn-tengah">Action</th>
                <th>Invoice Number</th>
                <th>Profit Center</th>
                <th>Customer</th>
                <th>Shipp</th>
                <th>Document Type</th>
                <th>Document Number</th>
                <th>Booking Date</th>
                <th>Type</th>
                <th class="text-right">Amount</th>
              </tr>
            </thead>
            <tbody id="ci-book-body">
              <tr><td colspan="10"><div class="ci-kosong"><i class="fas fa-search"></i><span>Pick a date range, then press Search.</span></div></td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- ============================ Modal: Search TOP ======================== -->
<div class="modal fade dn-modal nag-skin ci-sm" id="ci-modal-top" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-hand-holding-usd"></i> Term of Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="ci-table-wrap" id="ci-top-wrap" style="max-height:340px">
          <table class="dn-table text-nowrap" style="width:100%">
            <thead>
              <tr>
                <th style="width:70px" class="dn-tengah">Action</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Top</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="ci-top-body">
              <tr><td colspan="5"><div class="ci-kosong"><i class="fas fa-hand-holding-usd"></i><span>No term of payment found for this customer.</span></div></td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- ============================ Modal: Add SO / SJ ======================= -->
<div class="modal fade dn-modal nag-skin ci-sm" id="ci-modal-so" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-truck"></i> Add SO &amp; SJ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="ci-filter">
          <div class="row align-items-end">
            <div class="form-group col-lg-3 col-md-6">
              <label for="ci-so-cust">Customer</label>
              <input type="text" class="form-control" id="ci-so-cust" readonly>
            </div>
            <div class="form-group col-lg-3 col-md-6">
              <label for="ci-so-buyer">Buyer</label>
              <select class="form-control" id="ci-so-buyer">
                <option value="">ALL</option>
                <?php foreach ($buyer as $b) : ?>
                  <option value="<?= $b['Id_Supplier']; ?>"><?= $b['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-4 col-6">
              <label for="ci-so-from">SO Date From</label>
              <div class="input-group dn-date-group">
                <input type="text" class="form-control tanggal" id="ci-so-from" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-4 col-6">
              <label for="ci-so-to">SO Date To</label>
              <div class="input-group dn-date-group">
                <input type="text" class="form-control tanggal" id="ci-so-to" value="<?= date('Y-m-d'); ?>" autocomplete="off">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-4">
              <div class="dn-filter-aksi">
                <button type="button" class="btn btn-primary" id="ci-so-cari"><i class="fa fa-search"></i> Search</button>
              </div>
            </div>
          </div>
        </div>

        <!-- SO di atas, SJ di bawah - berdampingan membuat kolom SJ terpotong. -->
        <div class="table-header">
          <span class="table-title"><i class="fas fa-file-signature"></i>Sales Order</span>
        </div>
        <div class="ci-table-wrap" id="ci-so-wrap">
          <table class="dn-table text-nowrap" style="width:100%">
            <thead>
              <tr>
                <!-- SO boleh lebih dari satu, sama seperti layar lama: SJ dari
                     tiap SO yang dicentang dikumpulkan di tabel bawah. -->
                <th style="width:44px" class="dn-tengah"><input type="checkbox" id="ci-so-cek-semua" title="Tick all"></th>
                <th>SO Number</th>
                <th>SO Date</th>
                <th>Customer</th>
                <th>Buyer Number</th>
                <th>SO Type</th>
                <th>ID Sj</th>
              </tr>
            </thead>
            <tbody id="ci-so-body">
              <tr><td colspan="7"><div class="ci-kosong"><i class="fas fa-search"></i><span>Press Search to list the SO.</span></div></td></tr>
            </tbody>
          </table>
        </div>

        <div class="table-header" style="margin-top:14px">
          <span class="table-title"><i class="fas fa-truck"></i>SJ List</span>
          <div class="ci-cari"><i class="fas fa-search"></i>
            <input type="text" class="form-control" id="ci-sj-filter" placeholder="Search SJ / shipping number..."></div>
        </div>
        <div class="ci-table-wrap" id="ci-sj-wrap">
          <table class="dn-table text-nowrap" style="width:100%">
            <thead>
              <tr>
                <th>SO Number</th>
                <th>SJ Number</th>
                <th>SJ Date</th>
                <th>Shipping Number</th>
                <th>WS#</th>
                <th>Style No</th>
                <th>Product Group</th>
                <th>Product Item</th>
                <th>Color</th>
                <th>Size</th>
                <th>Curr</th>
                <th>UOM</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Disc (%)</th>
                <th class="text-right">Total Price</th>
                <th style="width:44px" class="dn-tengah"><input type="checkbox" id="ci-sj-cek-semua" title="Tick all"></th>
              </tr>
            </thead>
            <tbody id="ci-sj-body">
              <tr><td colspan="17"><div class="ci-kosong"><i class="fas fa-truck"></i><span>Tick one or more SO above to see their SJ.</span></div></td></tr>
            </tbody>
          </table>
        </div>
        <!-- Daftar SO-nya dibatasi ke SO yang dipesan booking Invoice EXIM;
             dikatakan supaya filter di atas tidak terlihat seperti rusak. -->
        <div class="ci-catatan-exim" id="ci-so-terbatas" hidden><i class="fas fa-filter-circle-xmark"></i>
          The SJ of this booking is not issued yet, so only the <b>SO booked in Invoice EXIM</b>
          is listed - the filter above does not apply.</div>
        <!-- SJ yang sudah dipesan booking Invoice EXIM tidak ikut ditampilkan;
             jumlahnya diberitahukan disini supaya user tidak mencarinya terus. -->
        <div class="ci-catatan-exim" id="ci-sj-dipakai" hidden></div>
        <!-- Satu invoice cuma boleh memuat SJ dari SATU tanggal - begitu ada
             yang dicentang, baris bertanggal lain dikunci. -->
        <div class="ci-catatan-tgl" id="ci-sj-tgl-info" hidden></div>
        <div class="ci-pilih-info" id="ci-sj-info">No SJ ticked yet.</div>

        <hr>

        <!-- Susunannya mengikuti layar lama: satu kolom, label di kiri dan
             isian di kanan, rata kanan supaya sejajar dengan tabel di atas. -->
        <div class="row justify-content-end">
          <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="ci-uang">
              <div class="ci-uang-baris">
                <label for="ci-m-total">Total</label>
                <input type="text" class="form-control" id="ci-m-total" value="0.00" readonly>
              </div>
              <div class="ci-uang-baris">
                <label for="ci-m-discount">Discount</label>
                <input type="text" class="form-control" id="ci-m-discount" value="0.00" readonly>
              </div>
              <div class="ci-uang-baris">
                <label for="ci-m-dp">Down Payment</label>
                <input type="text" class="form-control ci-num" id="ci-m-dp" value="" placeholder="0.00" autocomplete="off">
              </div>
              <div class="ci-uang-baris">
                <label for="ci-m-dpcbd">DP/CBD from Invoice</label>
                <input type="text" class="form-control ci-num" id="ci-m-dpcbd" value="" placeholder="0.00" autocomplete="off">
              </div>
              <div class="ci-uang-baris">
                <label for="ci-m-retur">Return</label>
                <input type="text" class="form-control ci-num" id="ci-m-retur" value="" placeholder="0.00" autocomplete="off">
              </div>
              <div class="ci-uang-baris">
                <label for="ci-m-twot">Total With Out Tax</label>
                <input type="text" class="form-control" id="ci-m-twot" value="0.00" readonly>
              </div>
              <div class="ci-uang-baris">
                <div class="ci-vat-opsi">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="ci-m-vat11">
                    <label class="custom-control-label" for="ci-m-vat11">Vat 11%</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="ci-m-vat12">
                    <label class="custom-control-label" for="ci-m-vat12">Vat 12%</label>
                  </div>
                </div>
                <input type="text" class="form-control" id="ci-m-vat" value="0.00" readonly>
              </div>
              <div class="ci-uang-baris is-grand">
                <label for="ci-m-grand">Grand Total</label>
                <input type="text" class="form-control" id="ci-m-grand" value="0.00" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button type="button" class="btn btn-primary" id="ci-so-apply"><i class="fas fa-check"></i> Apply</button>
      </div>
    </div>
  </div>
</div>

<!-- ===================== Modal: Pratinjau PDF Invoice =====================
     Cetakan yang AKAN terbentuk - dibuat dari isi layar, belum ada yang
     tersimpan. PDF-nya datang dari POST ke arnag/preview_invoice_v2 yang
     hasilnya diarahkan ke iframe di bawah (target = nama iframe-nya). -->
<div class="modal fade dn-modal nag-skin ci-sm" id="ci-modal-pdf" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered ci-pdf-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-file-pdf"></i> Invoice preview</h5>
        <!-- Knitting punya dua cetakan - masing-masing berkas sendiri, dipilih
             disini. Untuk garment tombolnya disembunyikan. -->
        <div class="ci-pdf-pilih" id="ci-pdf-pilih" hidden>
          <button type="button" class="btn btn-light is-aktif" data-jenis="">Invoice</button>
          <button type="button" class="btn btn-light" data-jenis="knitting">Invoice Knitting</button>
        </div>
        <span class="ci-pdf-tanda">NOT SAVED YET</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body p-0 ci-pdf-body">
        <iframe id="ci-pdf-frame" name="ci-pdf-frame" title="Invoice preview"></iframe>
      </div>
      <div class="modal-footer justify-content-between">
        <small class="text-muted">This is only a preview - the invoice is saved after you press <b>Yes, save it</b>.</small>
        <div>
          <button type="button" class="btn btn-light" id="ci-pdf-tab"><i class="fas fa-external-link-alt"></i> Open in New Tab</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ===================== Modal: Penampil Supporting Document ==============
     Kiri daftar semua file yang dipilih, kanan preview file yang aktif.
     File-nya masih di browser (blob URL) - belum ada di server. -->
<div class="modal fade dn-modal nag-skin ci-sm" id="ci-modal-doc" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered ci-doc-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="ci-doc-head">
          <h5 class="modal-title"><i class="fas fa-file-pdf" id="ci-doc-judul-ikon"></i> <span id="ci-doc-judul"></span></h5>
          <div class="ci-doc-meta" id="ci-doc-meta"></div>
        </div>
        <span class="ci-doc-posisi" id="ci-doc-posisi"></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body p-0 ci-doc-body">
        <aside class="ci-doc-side">
          <div class="ci-doc-side-judul">Documents <span id="ci-doc-side-jumlah"></span></div>
          <ul class="ci-doc-side-list" id="ci-doc-side-list"></ul>
        </aside>
        <div class="ci-doc-preview" id="ci-doc-isi"></div>
      </div>
      <div class="modal-footer justify-content-between">
        <div class="ci-doc-nav">
          <button type="button" class="btn btn-light" id="ci-doc-prev" title="Previous (&larr;)"><i class="fas fa-chevron-left"></i> Previous</button>
          <button type="button" class="btn btn-light" id="ci-doc-next" title="Next (&rarr;)">Next <i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="ci-doc-nav">
          <button type="button" class="btn btn-light ci-doc-btn-hapus" id="ci-doc-buang"><i class="fas fa-trash-alt"></i> Remove</button>
          <a href="#" class="btn btn-light" id="ci-doc-buka" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i> Open in New Tab</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  /* Alamat dasar dipakai JS supaya URL-nya tidak bergantung pada ada/tidaknya
     garis miring di ujung alamat halaman. */
  var CI_URL = <?= json_encode(base_url('arnag/')); ?>;
  var CI_URL_LIST = <?= json_encode(base_url('arnag/listinvoice')); ?>;
  /* Besar potongan upload supporting document (ikut batas upload PHP). */
  var CI_DOC_CHUNK = <?= isset($inv_doc_chunk) ? (int) $inv_doc_chunk : 1048576; ?>;
  /* Layar ini dipakai dua kali: membuat invoice baru, dan mengubah invoice
     yang sudah ada. Alurnya sama; yang berbeda cuma isian awalnya dan
     endpoint waktu disimpan. */
  var CI_MODE = <?= json_encode(isset($mode) && $mode === 'edit' ? 'edit' : 'create'); ?>;
  var CI_ID_EDIT = <?= (int) (isset($id_edit) ? $id_edit : 0); ?>;
  /* Invoice yang sudah FIRST APPROVED: isinya dikunci, yang boleh cuma
     melengkapi supporting document (kesempatan terakhir sebelum approval
     kedua). */
  var CI_DOK_SAJA = <?= json_encode(!empty($dok_saja)); ?>;
</script>
<script defer src="<?= base_url('assets/build/js/crud/crud-create-invoice.js'); ?>?v=<?= @filemtime(FCPATH . 'assets/build/js/crud/crud-create-invoice.js'); ?>"></script>
