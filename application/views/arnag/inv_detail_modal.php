<?php
// Modal detail Invoice - dipakai List Invoice (nomor invoice diklik).
// Isinya diambil inv_detail_buka() di crud-nag.js lewat arnag/inv_detail_json.
// Halaman yang memakainya cukup:
//   $this->load->view('arnag/inv_detail_modal')
// dan pastikan pembungkusnya ber-class .nag-skin.
//
// Modal lama (#modal-inv-detail) sengaja tidak diubah - layar lain (Kartu AR,
// Reverse, List Invoice Manual, dsb.) masih memakainya lewat cari_inv_detail().
?>
<style type="text/css">
/* ===== Modal detail invoice (nomor invoice diklik) ===== */
.nag-skin .inv-detail-loader { padding: 44px 0; text-align: center; color: #64748b; }
.nag-skin .inv-detail-loader .nag-loader-spinner { margin: 0 auto 10px; }

/* Judul: nomor invoice + pil status */
#modal-inv-detail-v2 .modal-header { align-items: center; }
#modal-inv-detail-v2 .modal-title { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
#modal-inv-detail-v2 .modal-title .dn-badge { font-size: 10.5px; }

/* ---- Ringkasan kepala ----
   Dibagi dua bagian supaya barisnya rata: di atas penerima tagihan & nilai
   invoice (isinya boleh panjang, tingginya bebas), di bawah keterangan
   pendek yang semuanya seukuran - jadi tidak ada lagi kolom yang melompat
   karena alamatnya makan dua baris. */
.nag-skin .inv-detail-atas {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 28px;
  padding-bottom: 14px;
  margin-bottom: 14px;
  border-bottom: 1px dashed #dbe4ee;
}
.nag-skin .inv-detail-kepada { min-width: 0; }
.nag-skin .inv-detail-label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 3px;
}
.nag-skin .inv-detail-nama {
  font-size: 15px;
  font-weight: 700;
  line-height: 1.3;
  color: #0f172a;
}
.nag-skin .inv-detail-alamat {
  max-width: 52ch;
  margin-top: 3px;
  font-size: 11.5px;
  line-height: 1.55;
  color: #94a3b8;
}
.nag-skin .inv-detail-uang { flex: 0 0 auto; text-align: right; }
.nag-skin .inv-detail-jumlah {
  font-size: 22px;
  font-weight: 700;
  line-height: 1.2;
  color: #0f172a;
  font-variant-numeric: tabular-nums;
}
/* Tanggalnya dibuat cukup terbaca - bukan abu tipis seperti keterangan biasa */
.nag-skin .inv-detail-tanggal { margin-top: 5px; font-size: 12.5px; color: #64748b; }
.nag-skin .inv-detail-tanggal b { color: #0f172a; font-weight: 700; }
.nag-skin .inv-detail-tanggal .inv-detail-titik { color: #cbd5e1; margin: 0 2px; }

/* Keterangan pendek: 4 kolom di layar lebar, tingginya disamakan */
.nag-skin .inv-detail-info {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  align-content: start;
  gap: 14px 22px;
  margin: 0;
}
.nag-skin .inv-detail-info > div { min-width: 0; }
.nag-skin .inv-detail-info dt {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 2px;
}
.nag-skin .inv-detail-info dd {
  margin: 0;
  font-size: 13px;
  color: #1e293b;
  word-break: break-word;
}
.nag-skin .inv-detail-info dd small { display: block; font-size: 11px; color: #94a3b8; margin-top: 1px; }
.nag-skin .inv-detail-info dd.is-angka { font-variant-numeric: tabular-nums; font-weight: 600; }

/* Kartu kepala - membedakan ringkasan dari tabelnya */
.nag-skin .inv-detail-kartu {
  padding: 14px 16px;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  background: linear-gradient(180deg, #fbfdff, #f6f9fc);
}

.nag-skin .inv-detail-judul-bagian {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 18px 0 10px;
  padding-bottom: 8px;
  border-bottom: 1px solid #eef2f7;
  font-size: 12.5px;
  font-weight: 700;
  letter-spacing: .3px;
  color: #0f172a;
}
.nag-skin .inv-detail-judul-bagian i { color: #1e3a5f; opacity: .55; font-size: 12px; }
.nag-skin .inv-detail-judul-bagian .inv-detail-jumlah {
  font-size: 11px;
  font-weight: 600;
  color: #64748b;
  letter-spacing: 0;
  text-transform: none;
}

/* ---- Tabel baris SJ ----
   Kolomnya digabung bertingkat (nomor SO di atas, SJ & shipping di bawahnya)
   supaya semuanya muat tanpa perlu digeser ke samping. */
.nag-skin .inv-detail-tabel-wrap {
  overflow: auto;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  max-height: 330px;
}
.nag-skin .inv-detail-tabel { margin: 0; }
/* Kepala tabel tetap kelihatan waktu barisnya digulir - tanpa ini, begitu
   digulir sedikit tidak jelas lagi angka di kolom mana. Latarnya sudah gelap
   (dn-table di dn_skin), jadi barisnya lewat di belakangnya. */
.nag-skin .inv-detail-tabel thead th { position: sticky; top: 0; z-index: 3; }
.nag-skin .inv-detail-tabel td { vertical-align: top; }
.nag-skin .inv-detail-tabel .inv-utama { display: block; font-weight: 600; color: #1e293b; }
.nag-skin .inv-detail-tabel .inv-sub {
  display: block;
  margin-top: 1px;
  font-size: 10.5px;
  line-height: 1.35;
  color: #94a3b8;
  white-space: normal;
}
.nag-skin .inv-detail-tabel tfoot td {
  background: #f1f5f9 !important;
  font-weight: 700;
  border-top: 2px solid #e2e8f0;
}

/* ---- Rekap angka ---- */
.nag-skin .inv-detail-rekap-baris { display: flex; justify-content: flex-end; margin-top: 14px; }
.nag-skin .inv-detail-rekap {
  width: 100%;
  max-width: 340px;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  overflow: hidden;
  background: #fff;
}
.nag-skin .inv-detail-rekap-rinci > div {
  display: flex;
  justify-content: space-between;
  gap: 16px;
  padding: 8px 14px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 12.5px;
  color: #475569;
}
.nag-skin .inv-detail-rekap b { color: #1e293b; font-variant-numeric: tabular-nums; }
.nag-skin .inv-detail-rekap .is-grand {
  display: flex;
  justify-content: space-between;
  gap: 16px;
  background: #fdeef0;
  padding: 11px 14px;
  font-size: 13px;
  font-weight: 700;
  color: #9f1239;
}
.nag-skin .inv-detail-rekap .is-grand b { color: #9f1239; font-size: 14px; font-variant-numeric: tabular-nums; }

/* Bawaannya cuma Grand Total yang tampil - rinciannya dibuka kalau perlu,
   sama seperti kartu Summary di layar Create Invoice. */
.nag-skin .inv-detail-rekap-toggle {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  width: 100%;
  padding: 7px 10px;
  border: none;
  border-top: 1px solid #e2e8f0;
  background: #f8fafc;
  color: #2c5282;
  font-size: 11.5px;
  font-weight: 600;
  cursor: pointer;
}
.nag-skin .inv-detail-rekap-toggle:hover { background: #eef4fb; }
.nag-skin .inv-detail-rekap-toggle i { font-size: 10px; transition: transform .15s ease; }
.nag-skin .inv-detail-rekap-toggle.is-buka i { transform: rotate(180deg); }

/* ---- Lampiran (bentuknya sama dengan modal detail Debit Note) ---- */
.nag-skin .inv-att-kosong { font-size: 12.5px; font-style: italic; color: #94a3b8; opacity: .85; }
.nag-skin .inv-att-list { display: flex; flex-wrap: wrap; gap: 8px; list-style: none; margin: 0; padding: 0; }
.nag-skin .inv-att-item {
  display: flex;
  align-items: center;
  gap: 8px;
  max-width: 100%;
  padding: 6px 10px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  background: #fff;
  font-size: 12.5px;
  cursor: pointer;
  transition: border-color .15s ease, background .15s ease;
}
.nag-skin .inv-att-item:hover { border-color: #2c5282; background: #f8fafc; }
.nag-skin .inv-att-item.is-aktif { border-color: #2c5282; background: #eef2f7; }
.nag-skin .inv-att-item .fa-file-pdf { color: #dc2626; }
.nag-skin .inv-att-item .fa-file-image { color: #0891b2; }
.nag-skin .inv-att-nama { max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.nag-skin .inv-att-ukuran { color: #94a3b8; font-size: 11px; white-space: nowrap; }

/* ---- Dua tab dokumen: lampiran invoice & cetakan Surat Jalan ----
   Bentuknya seperti sheet: yang aktif menyatu dengan isinya. Cetakan SJ
   milik program pengiriman - dilihat di penampil yang sama, tapi tidak
   dihitung sebagai lampiran invoice. */
.nag-skin .inv-dok-tab {
  display: flex;
  gap: 4px;
  margin: 18px 0 0;
  border-bottom: 1px solid #e2e8f0;
}
.nag-skin .inv-dok-tombol {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  margin-bottom: -1px;
  padding: 8px 14px;
  border: 1px solid transparent;
  border-bottom: 0;
  border-radius: 8px 8px 0 0;
  background: transparent;
  color: #64748b;
  font-size: 12.5px;
  font-weight: 600;
  letter-spacing: .3px;
  cursor: pointer;
}
.nag-skin .inv-dok-tombol[hidden] { display: none; }
.nag-skin .inv-dok-tombol i { font-size: 12px; opacity: .6; }
.nag-skin .inv-dok-tombol:hover { color: #1e3a5f; background: #f8fafc; }
.nag-skin .inv-dok-tombol.is-aktif {
  border-color: #e2e8f0;
  background: #fff;
  color: #0f172a;
  box-shadow: inset 0 2px 0 #2c5282;
}
.nag-skin .inv-dok-tombol.is-aktif i { color: #1e3a5f; opacity: .8; }
.nag-skin .inv-dok-jml { font-size: 11px; font-weight: 600; color: #64748b; letter-spacing: 0; }
.nag-skin .inv-dok-isi { padding: 16px 0 2px; }
.nag-skin .inv-dok-isi[hidden] { display: none; }
.nag-skin .inv-dok-ket { margin-bottom: 10px; font-size: 11px; color: #94a3b8; }
.nag-skin .inv-dok-ket i { margin-right: 4px; opacity: .8; }

/* ---- Halaman jurnal (layar Second Approval) ---- */
.nag-skin #inv-detail-jurnal-tabel td.is-coa { font-weight: 600; color: #1e293b; white-space: nowrap; min-width: 210px; }
.nag-skin #inv-detail-jurnal-tabel .inv-jurnal-nama { display: block; font-weight: 400; color: #64748b; font-size: 11px; white-space: normal; }
/* Baris tambahan dari service charge ditandai supaya beda dengan jurnal invoice. */
.nag-skin #inv-detail-jurnal-tabel tr.is-tambahan td { background: #fffbeb !important; }
.nag-skin .inv-jurnal-tanda {
  display: inline-block;
  margin-left: 6px;
  padding: 1px 6px;
  border-radius: 999px;
  background: #fef3c7;
  color: #92400e;
  font-size: 10px;
  font-weight: 600;
}
.nag-skin .inv-jurnal-catatan {
  margin-top: 10px;
  padding: 8px 12px;
  border: 1px solid #fecaca;
  border-radius: 8px;
  background: #fef2f2;
  color: #b91c1c;
  font-size: 12px;
  line-height: 1.5;
}
.nag-skin .inv-jurnal-catatan[hidden] { display: none; }
.nag-skin .inv-jurnal-catatan i { margin-right: 5px; }
.nag-skin #inv-detail-jurnal-tabel tfoot td { background: #f1f5f9 !important; font-weight: 700; }
.nag-skin .inv-jurnal-timpang { color: #b91c1c; }
/* Keterangan ditaruh paling ujung & boleh turun baris; kolom rupiahnya
   dibuat lebih redup supaya mata tertuju ke nilai mata uang invoice. */
.nag-skin #inv-detail-jurnal-tabel td.is-cc { white-space: nowrap; font-weight: 600; color: #1e293b; }
.nag-skin #inv-detail-jurnal-tabel td.is-ket { white-space: normal; min-width: 250px; color: #475569; font-size: 11.5px; }
.nag-skin #inv-detail-jurnal-tabel td.is-idr, .nag-skin #inv-detail-jurnal-tabel th:nth-child(6), .nag-skin #inv-detail-jurnal-tabel th:nth-child(7) { color: #64748b; }
.nag-skin #inv-detail-jurnal-tabel tfoot td.is-idr { color: #334155; }
/* Judul pertama di halaman dokumen tidak perlu jarak atas lagi - tab-nya
   sudah jadi pembatas. */
.nag-skin .inv-detail-judul-bagian.is-awal { margin-top: 0; }
.nag-skin .inv-sj-dok[hidden] { display: none; }
.nag-skin .inv-sj-judul { flex-wrap: wrap; }
.nag-skin .inv-sj-judul small {
  font-weight: 400;
  font-size: 11px;
  letter-spacing: 0;
  color: #94a3b8;
}
/* Bedanya dengan lampiran cuma garis putus-putus: berkasnya milik program
   pengiriman, tapi cara melihatnya sama (penampil di dalam modal). */
.nag-skin .inv-att-item.is-luar { border-style: dashed; }
.nag-skin .inv-att-item.is-luar.is-mati { background: #f8fafc; cursor: default; color: #94a3b8; }
.nag-skin .inv-att-item.is-luar.is-mati:hover { border-color: #e2e8f0; background: #f8fafc; }
.nag-skin .inv-att-item.is-luar.is-mati .inv-att-nama { color: #94a3b8; }

.nag-skin .inv-detail-pratinjau { margin-top: 12px; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; }
.nag-skin .inv-detail-pratinjau-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  padding: 8px 12px;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  font-size: 12.5px;
  font-weight: 600;
  color: #1e293b;
}
.nag-skin .inv-detail-pratinjau-aksi { display: flex; gap: 6px; flex: 0 0 auto; }
/* Keterangan untuk berkas milik program lain - jangan mendesak nama berkas. */
.nag-skin .inv-detail-pratinjau-ket {
  flex: 1 1 auto;
  min-width: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  font-weight: 400;
  font-size: 11px;
  color: #94a3b8;
}
.nag-skin .inv-detail-pratinjau-ket[hidden] { display: none; }
.nag-skin #inv-detail-pratinjau-nama { flex: 0 1 auto; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.nag-skin .inv-detail-pratinjau-aksi .btn { height: 30px; padding: 0 10px !important; font-size: 11.5px; box-shadow: none !important; }
.nag-skin .inv-detail-pratinjau-isi { height: 62vh; background: #f1f5f9; }
.nag-skin .inv-detail-pratinjau-isi iframe { width: 100%; height: 100%; border: 0; display: block; }
.nag-skin .inv-detail-pratinjau-isi img { max-width: 100%; max-height: 100%; display: block; margin: 0 auto; }

/* Layar kecil: ringkasan jadi dua kolom, lalu satu kolom */
@media (max-width: 991px) {
  .nag-skin .inv-detail-info { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 575px) {
  .nag-skin .inv-detail-info { grid-template-columns: 1fr; }
  .nag-skin .inv-detail-info > div.is-lebar { grid-column: span 1; }
  .nag-skin .inv-detail-rekap { max-width: none; }
}

/* ==========================================================================
   TAMPILAN MODAL DETAIL INVOICE

   Berlaku untuk semua layar yang memuat modal ini: List Invoice dan Second
   Approval Invoice.

   Jaraknya sengaja rapat: satu layar cukup untuk kepala, ringkasan, dan
   beberapa baris SJ tanpa digulir.

   !important dipakai di beberapa tempat karena templates/header.php mengunci
   .modal-content, .modal-header, .modal-footer, dan .btn secara global.
   ========================================================================== */

/* ---- Kerangka ---- */
#modal-inv-detail-v2 .modal-content {
  border-radius: 16px !important;
  box-shadow: 0 24px 56px rgba(15, 23, 42, .3) !important;
}
/* Latar isi modal: gradasi sangat halus, bukan abu rata - kartu putihnya
   tetap terbaca sebagai "kertas" tanpa membuat layar jadi kelabu. */
#modal-inv-detail-v2 .modal-body {
  background: linear-gradient(180deg, #f8fafc 0%, #edf2f9 100%);
  padding: 12px 16px 14px;
}

/* ---- Kepala: gradien biru + lengkung tipis di kanan ---- */
#modal-inv-detail-v2 .modal-header {
  position: relative;
  overflow: hidden;
  padding: 13px 18px !important;
  border-bottom: 0 !important;
  background: linear-gradient(115deg, #16365c 0%, #1d4d86 52%, #2a6ab3 100%) !important;
}
/* Lingkaran besar bergaris tipis - efek gelombang di sudut kanan atas */
#modal-inv-detail-v2 .modal-header::after {
  content: '';
  position: absolute;
  top: -128px;
  right: -70px;
  width: 290px;
  height: 290px;
  border-radius: 50%;
  border: 26px solid rgba(255, 255, 255, .055);
  box-shadow: -66px 96px 0 -10px rgba(255, 255, 255, .04), -150px 40px 0 -6px rgba(255, 255, 255, .03);
  pointer-events: none;
}
#modal-inv-detail-v2 .modal-title { gap: 10px; position: relative; z-index: 1; }
#modal-inv-detail-v2 .modal-title > i {
  display: grid;
  place-items: center;
  width: 38px;
  height: 38px;
  border-radius: 11px;
  background: rgba(255, 255, 255, .16);
  box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .2);
  color: #fff;
  font-size: 15px;
}
#modal-inv-detail-v2 #inv-detail-judul { font-size: 17.5px; font-weight: 700; letter-spacing: .2px; }
#modal-inv-detail-v2 .modal-title .dn-badge { padding: 2px 9px; }
#modal-inv-detail-v2 .modal-header .close { position: relative; z-index: 1; color: #fff; opacity: .8; font-size: 24px; }
#modal-inv-detail-v2 .modal-header .close:hover { opacity: 1; }

/* ---- Tab ---- */
#modal-inv-detail-v2 .inv-dok-tab { gap: 5px; margin: 0 0 12px; border-bottom-color: #e3ebf4; }
#modal-inv-detail-v2 .inv-dok-tombol { padding: 7px 14px; border-radius: 9px 9px 0 0; font-size: 12px; }
#modal-inv-detail-v2 .inv-dok-tombol.is-aktif {
  border-color: #e3ebf4;
  color: #1d4d86;
  box-shadow: inset 0 2px 0 #2a6ab3, 0 8px 14px -12px rgba(15, 23, 42, .5);
}
#modal-inv-detail-v2 .inv-dok-tombol.is-aktif i { color: #2a6ab3; opacity: 1; }
#modal-inv-detail-v2 .inv-dok-isi { padding: 12px 0 0; }

/* ---- Kartu ringkasan ---- */
#modal-inv-detail-v2 .inv-detail-kartu {
  padding: 13px 15px;
  border: 1px solid #e5ecf4;
  border-radius: 13px;
  background: #fff;
  box-shadow: 0 1px 2px rgba(15, 23, 42, .05), 0 10px 22px -18px rgba(15, 23, 42, .45);
}
#modal-inv-detail-v2 .inv-detail-atas {
  align-items: center;
  gap: 20px;
  padding-bottom: 11px;
  margin-bottom: 11px;
  border-bottom: 1px solid #eef3f9;
}

/* Bill To: ikon di kiri, tiga baris keterangan di kanannya */
#modal-inv-detail-v2 .inv-detail-kepada {
  display: grid;
  grid-template-columns: 40px minmax(0, 1fr);
  gap: 1px 12px;
  align-items: start;
}
#modal-inv-detail-v2 .inv-detail-kepada::before {
  content: '\f1ad';
  grid-row: span 3;
  align-self: center;
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: #eaf2fe;
  color: #2a6ab3;
  font-size: 15px;
}
#modal-inv-detail-v2 .inv-detail-label { font-size: 10px; margin-bottom: 1px; }
#modal-inv-detail-v2 .inv-detail-nama { font-size: 14.5px; }
#modal-inv-detail-v2 .inv-detail-alamat { max-width: 46ch; margin-top: 1px; font-size: 11px; line-height: 1.45; }

/* Grand total di kanan - kotak biru muda */
#modal-inv-detail-v2 .inv-detail-uang {
  display: grid;
  grid-template-columns: 38px minmax(0, 1fr);
  gap: 1px 11px;
  align-items: start;
  padding: 9px 13px;
  border-radius: 12px;
  background: #eef5ff;
}
#modal-inv-detail-v2 .inv-detail-uang::before {
  content: '\f570';
  grid-row: span 3;
  align-self: center;
  width: 38px;
  height: 38px;
  border-radius: 11px;
  background: #fff;
  color: #2a6ab3;
  font-size: 14px;
}
#modal-inv-detail-v2 .inv-detail-uang .inv-detail-jumlah { font-size: 19px; }
#modal-inv-detail-v2 .inv-detail-tanggal { margin-top: 2px; font-size: 11px; }

/* Kotak ikon dipakai di beberapa tempat - bentuknya dibuat sekali disini */
#modal-inv-detail-v2 .inv-detail-kepada::before,
#modal-inv-detail-v2 .inv-detail-uang::before,
#modal-inv-detail-v2 .inv-detail-info > div::before {
  display: grid;
  place-items: center;
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
}

/* Keterangan pendek: tiap butir diberi ikon.
   Urutan ikon mengikuti daftar info di inv_detail_render() (crud-nag.js):
   Profit Center, Shipment, Document, Type, Terms Of Payment, Bank, Created,
   Approval. Kalau daftar itu berubah, ikonnya ikut digeser. */
#modal-inv-detail-v2 .inv-detail-info { gap: 11px 16px; }
#modal-inv-detail-v2 .inv-detail-info > div {
  display: grid;
  grid-template-columns: 30px minmax(0, 1fr);
  gap: 0 9px;
  align-items: center;
}
#modal-inv-detail-v2 .inv-detail-info > div::before {
  grid-row: span 2;
  width: 30px;
  height: 30px;
  border-radius: 9px;
  font-size: 12px;
}
#modal-inv-detail-v2 .inv-detail-info dt { font-size: 10px; margin-bottom: 0; }
/* Nilainya dibuat lebih tegas dari labelnya - ikon berwarna tidak boleh
   lebih dulu menarik mata daripada isinya. */
#modal-inv-detail-v2 .inv-detail-info dd { font-size: 12.5px; line-height: 1.35; color: #0f172a; font-weight: 600; }
#modal-inv-detail-v2 .inv-detail-info dd small { font-size: 10.5px; font-weight: 400; }
/* Semua ikon keterangan satu keluarga warna biru - senada dengan kepala
   modal dan ikon Bill To. Delapan warna berbeda bikin ramai dan tidak
   nyambung satu sama lain. Hijau disimpan khusus untuk penanda tahap yang
   sudah selesai di alur invoice. */
#modal-inv-detail-v2 .inv-detail-info > div::before { background: #eaf2fe; color: #2a6ab3; }
#modal-inv-detail-v2 .inv-detail-info > div:nth-child(1)::before { content: '\f275'; }
#modal-inv-detail-v2 .inv-detail-info > div:nth-child(2)::before { content: '\f0d1'; }
#modal-inv-detail-v2 .inv-detail-info > div:nth-child(3)::before { content: '\f15c'; }
#modal-inv-detail-v2 .inv-detail-info > div:nth-child(4)::before { content: '\f02b'; }
#modal-inv-detail-v2 .inv-detail-info > div:nth-child(5)::before { content: '\f017'; }
#modal-inv-detail-v2 .inv-detail-info > div:nth-child(6)::before { content: '\f19c'; }
#modal-inv-detail-v2 .inv-detail-info > div:nth-child(7)::before { content: '\f073'; }

/* ---- Alur invoice: Booking -> Invoice -> First -> Second Approval ----
   Diisi skrip di bawah (menggantikan keterangan "Approval"). Tahap yang
   sudah lewat diberi warna, yang belum dibiarkan redup - jadi sekali lihat
   ketahuan invoice ini berhenti di mana. */
#modal-inv-detail-v2 .inv-alur {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  margin-top: 11px;
  padding-top: 11px;
  border-top: 1px dashed #e3ebf4;
}
/* Ikon berderet di atas, keterangannya di bawah - kalau ikon & teks
   sebaris, garis penghubungnya memotong tulisan. */
#modal-inv-detail-v2 .inv-alur-langkah { position: relative; padding-right: 16px; }
/* Garis penghubung antar tahap - setinggi tengah ikon, jadi tidak kena teks */
#modal-inv-detail-v2 .inv-alur-langkah::after {
  content: '';
  position: absolute;
  left: 34px;
  right: 6px;
  top: 13px;
  height: 2px;
  border-radius: 2px;
  background: #e2e8f0;
}
#modal-inv-detail-v2 .inv-alur-langkah.is-selesai::after { background: #bbf7d0; }
#modal-inv-detail-v2 .inv-alur-langkah:last-child::after { display: none; }
#modal-inv-detail-v2 .inv-alur-ikon {
  position: relative;
  z-index: 1;
  display: grid;
  place-items: center;
  width: 28px;
  height: 28px;
  margin-bottom: 7px;
  border-radius: 50%;
  background: #eef2f7;
  color: #cbd5e1;
  font-size: 11px;
  box-shadow: 0 0 0 3px #fff;
}
#modal-inv-detail-v2 .inv-alur-judul,
#modal-inv-detail-v2 .inv-alur-isi { display: block; }
#modal-inv-detail-v2 .is-selesai .inv-alur-ikon { background: #dcfce7; color: #15803d; }
#modal-inv-detail-v2 .inv-alur-judul {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #94a3b8;
}
#modal-inv-detail-v2 .inv-alur-isi { font-size: 12.5px; font-weight: 600; line-height: 1.3; color: #0f172a; }
#modal-inv-detail-v2 .inv-alur-isi small { display: block; font-weight: 400; font-size: 10.5px; color: #94a3b8; }
#modal-inv-detail-v2 .is-nanti .inv-alur-isi { color: #cbd5e1; font-weight: 500; }

@media (max-width: 991px) {
  #modal-inv-detail-v2 .inv-alur { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 11px 0; }
  #modal-inv-detail-v2 .inv-alur-langkah:nth-child(2)::after { display: none; }
}

/* ---- Judul bagian (SJ Rows, Supporting Documents, dst.) ---- */
#modal-inv-detail-v2 .inv-detail-judul-bagian {
  gap: 7px;
  margin: 13px 0 7px;
  padding-bottom: 0;
  border-bottom: 0;
  font-size: 12.5px;
}
#modal-inv-detail-v2 .inv-detail-judul-bagian i {
  display: grid;
  place-items: center;
  width: 26px;
  height: 26px;
  border-radius: 8px;
  background: #eaf2fe;
  color: #2a6ab3;
  opacity: 1;
  font-size: 11px;
}
/* Angka di tabel dibuat paling pekat - itu yang dibaca orang duluan. */
#modal-inv-detail-v2 .inv-detail-tabel tbody td.dn-angka { color: #0f172a; font-weight: 600; }

/* ---- Tabel baris SJ ---- */
#modal-inv-detail-v2 .inv-detail-tabel-wrap {
  border: 1px solid #e6edf5;
  border-radius: 13px;
  background: #fff;
  box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
}
#modal-inv-detail-v2 .inv-detail-tabel thead th { padding: 9px 11px; font-size: 10px; }
#modal-inv-detail-v2 .inv-detail-tabel tbody td { padding: 7px 11px; font-size: 12px; }
#modal-inv-detail-v2 .inv-detail-tabel .inv-sub { font-size: 10px; }
/* Nomor SO dibuat biru - pembeda kolom pertama, sama seperti nomor invoice
   di daftar. */
#modal-inv-detail-v2 .inv-detail-tabel tbody td:first-child .inv-utama { color: #1d4ed8; }
#modal-inv-detail-v2 .inv-detail-tabel tfoot td { padding: 8px 11px; font-size: 12px; border-top-color: #e6edf5; }

/* Tanda urut - dipasang skrip di bawah, jadi panahnya memang berfungsi. */
#modal-inv-detail-v2 .inv-detail-tabel thead th.bisa-urut { cursor: pointer; }
#modal-inv-detail-v2 .inv-detail-tabel thead th.bisa-urut::after {
  content: '\f0dc';
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  margin-left: 6px;
  font-size: 9.5px;
  opacity: .4;
}
#modal-inv-detail-v2 .inv-detail-tabel thead th.is-urut-naik::after { content: '\f0de'; opacity: .95; }
#modal-inv-detail-v2 .inv-detail-tabel thead th.is-urut-turun::after { content: '\f0dd'; opacity: .95; }

/* ---- Rekap & kaki ---- */
#modal-inv-detail-v2 .inv-detail-rekap-baris { margin-top: 11px; }
#modal-inv-detail-v2 .inv-detail-rekap {
  max-width: 320px;
  border-color: #e6edf5;
  border-radius: 13px;
  box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
}
#modal-inv-detail-v2 .inv-detail-rekap-rinci > div { padding: 7px 12px; font-size: 12px; }
#modal-inv-detail-v2 .inv-detail-rekap .is-grand { align-items: center; gap: 9px; padding: 9px 12px; }
#modal-inv-detail-v2 .inv-detail-rekap .is-grand::before {
  content: '\f571';
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  display: grid;
  place-items: center;
  width: 26px;
  height: 26px;
  border-radius: 8px;
  background: rgba(159, 18, 57, .1);
  font-size: 11px;
}
#modal-inv-detail-v2 .inv-detail-rekap .is-grand span:first-of-type { margin-right: auto; }
#modal-inv-detail-v2 .inv-detail-rekap-toggle { padding: 6px 10px; font-size: 11px; }

#modal-inv-detail-v2 .modal-footer {
  background: #fff;
  padding: 11px 16px;
  border-top: 1px solid #e6edf5 !important;
}
#modal-inv-detail-v2 .modal-footer .btn {
  height: 34px;
  padding: 0 15px !important;
  border-radius: 9px !important;
  font-size: 12.5px;
  display: inline-flex;
  align-items: center;
  gap: 7px;
}
#modal-inv-detail-v2 #inv-detail-cetak,
#modal-inv-detail-v2 #inv-detail-cetak-knitting {
  background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
  border: 0 !important;
  color: #fff !important;
}
#modal-inv-detail-v2 .modal-footer .btn-secondary {
  background: #f1f5f9 !important;
  border: 1px solid #e2e8f0 !important;
  color: #334155 !important;
}
#modal-inv-detail-v2 .modal-footer .btn-secondary::before {
  content: '\f00d';
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  font-size: 11px;
}

/* ---- Lampiran & pratinjau ikut dirapatkan ---- */
#modal-inv-detail-v2 .inv-att-item { padding: 5px 9px; font-size: 12px; border-radius: 9px; }
#modal-inv-detail-v2 .inv-detail-pratinjau { border-radius: 12px; }

@media (max-width: 767.98px) {
  #modal-inv-detail-v2 .modal-body { padding: 12px; }
  #modal-inv-detail-v2 .inv-detail-atas { flex-direction: column; align-items: stretch; gap: 12px; }
  #modal-inv-detail-v2 .inv-detail-uang { text-align: left; }
}
</style>

<!-- Detail Invoice - dibuka waktu nomor invoice diklik (inv_detail_buka di crud-nag.js) -->
<div class="modal fade nag-skin" id="modal-inv-detail-v2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="fas fa-file-invoice"></i>
          <span id="inv-detail-judul">Invoice</span>
          <span id="inv-detail-status"></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="inv-detail-loader" id="inv-detail-loader">
          <div class="nag-loader-spinner">
            <span class="nag-loader-ring nag-loader-ring-outer"></span>
            <span class="nag-loader-ring nag-loader-ring-inner"></span>
            <span class="nag-loader-brand">NAG</span>
          </div>
          <div class="nag-loader-caption">Loading invoice...</div>
        </div>

        <div id="inv-detail-isi" hidden>
          <!-- Isi modal dibagi dua halaman (seperti sheet): invoice-nya sendiri
               dan dokumennya - supaya tidak perlu digulir jauh ke bawah. -->
          <div class="inv-dok-tab" role="tablist">
            <button type="button" class="inv-dok-tombol is-aktif" role="tab"
                    id="inv-detail-tab-detail" data-tab="detail" onclick="inv_detail_tab('detail')">
              <i class="fas fa-file-invoice"></i> Invoice Detail
            </button>
            <button type="button" class="inv-dok-tombol" role="tab"
                    id="inv-detail-tab-dok" data-tab="dokumen" onclick="inv_detail_tab('dokumen')">
              <i class="fas fa-paperclip"></i> Documents
              <span class="inv-dok-jml" id="inv-detail-jml-dok"></span>
            </button>
            <!-- Cuma dipasang di layar Second Approval (INV_DETAIL_JURNAL):
                 jurnal yang akan terbentuk kalau invoice ini di-approve. -->
            <button type="button" class="inv-dok-tombol" role="tab"
                    id="inv-detail-tab-jurnal" data-tab="jurnal" onclick="inv_detail_tab('jurnal')" hidden>
              <i class="fas fa-book"></i> Journal
              <span class="inv-dok-jml" id="inv-detail-jml-jurnal"></span>
            </button>
          </div>

          <div class="inv-dok-isi" id="inv-detail-panel-detail">
          <!-- Ringkasan kepala invoice -->
          <div class="inv-detail-kartu">
            <div class="inv-detail-atas">
              <div class="inv-detail-kepada">
                <div class="inv-detail-label">Bill To</div>
                <div class="inv-detail-nama" id="inv-detail-customer"></div>
                <div class="inv-detail-alamat" id="inv-detail-alamat"></div>
              </div>
              <div class="inv-detail-uang">
                <div class="inv-detail-label">Grand Total</div>
                <div class="inv-detail-jumlah" id="inv-detail-grand"></div>
                <div class="inv-detail-tanggal" id="inv-detail-tanggal"></div>
              </div>
            </div>
            <dl class="inv-detail-info" id="inv-detail-info"></dl>
          </div>

          <!-- Baris SJ -->
          <div class="inv-detail-judul-bagian">
            <i class="fas fa-truck"></i> SJ Rows
            <span class="inv-detail-jumlah" id="inv-detail-jml-baris"></span>
          </div>
          <div class="inv-detail-tabel-wrap">
            <table class="dn-table inv-detail-tabel" id="inv-detail-tabel">
              <thead></thead>
              <tbody></tbody>
              <tfoot></tfoot>
            </table>
          </div>

          <!-- Rekap angka: Grand Total dulu, rinciannya bisa dibuka -->
          <div class="inv-detail-rekap-baris">
            <div class="inv-detail-rekap">
              <div class="inv-detail-rekap-rinci" id="inv-detail-rekap-rinci" hidden></div>
              <div class="is-grand" id="inv-detail-rekap-grand"></div>
              <button type="button" class="inv-detail-rekap-toggle" id="inv-detail-rekap-toggle">
                <i class="fas fa-chevron-down"></i> <span>Show details</span>
              </button>
            </div>
          </div>

          </div><!-- /halaman 1: invoice -->

          <!-- Halaman 2: dokumennya. Lampiran invoice di atas, lalu cetakan
               Surat Jalan dari program pengiriman - yang terakhir ini bukan
               lampiran invoice: tidak dihitung dan tidak ikut digabung ke PDF
               invoice. Penampilnya di bawah keduanya. -->
          <div class="inv-dok-isi" id="inv-detail-panel-dok" hidden>
            <div class="inv-detail-judul-bagian is-awal">
              <i class="fas fa-paperclip"></i> Supporting Documents
              <span class="inv-detail-jumlah" id="inv-detail-jml-lampiran"></span>
            </div>
            <ul class="inv-att-list" id="inv-detail-lampiran"></ul>

            <div class="inv-sj-dok" id="inv-detail-sj-dok" hidden>
              <div class="inv-detail-judul-bagian inv-sj-judul">
                <i class="fas fa-truck"></i> Delivery Note (SJ)
                <span class="inv-detail-jumlah" id="inv-detail-jml-sj"></span>
                <small>from the delivery system &middot; not an attachment of this invoice</small>
              </div>
              <ul class="inv-att-list" id="inv-detail-sj-list"></ul>
            </div>

          <div class="inv-detail-pratinjau" id="inv-detail-pratinjau" hidden>
            <div class="inv-detail-pratinjau-bar">
              <span id="inv-detail-pratinjau-nama"></span>
              <!-- SJ datang dari program lain: kalau server-nya menolak
                   dibingkai, tombol di sebelah kanan yang dipakai. -->
              <small class="inv-detail-pratinjau-ket" id="inv-detail-pratinjau-ket" hidden>
                From the delivery system &middot; if it does not appear, open it in a new tab
              </small>
              <span class="inv-detail-pratinjau-aksi">
                <a href="#" id="inv-detail-pratinjau-buka" target="_blank" rel="noopener" class="btn btn-light btn-sm">
                  <i class="fas fa-external-link-alt"></i> Open in New Tab</a>
                <button type="button" class="btn btn-light btn-sm" onclick="inv_detail_tutup_pratinjau()">
                  <i class="fas fa-times"></i> Close</button>
              </span>
            </div>
            <div class="inv-detail-pratinjau-isi" id="inv-detail-pratinjau-isi"></div>
          </div>
          </div><!-- /halaman 2: dokumen -->

          <!-- Halaman 3: jurnal yang akan terbentuk (layar Second Approval).
               Isinya pratinjau - yang ditulis nanti waktu Approve ditekan. -->
          <div class="inv-dok-isi" id="inv-detail-panel-jurnal" hidden>
            <div class="inv-dok-ket">
              <i class="fas fa-info-circle"></i> Preview only &middot; these rows are written when the
              invoice is second approved
            </div>
            <div class="inv-detail-tabel-wrap">
              <table class="dn-table inv-detail-tabel" id="inv-detail-jurnal-tabel">
                <thead>
                  <tr>
                    <th>COA</th>
                    <th>Cost Center</th>
                    <th class="dn-tengah">Curr</th>
                    <th class="dn-angka">Rate</th>
                    <th class="dn-angka">Debit</th>
                    <th class="dn-angka">Credit</th>
                    <th class="dn-angka">Debit (IDR)</th>
                    <th class="dn-angka">Credit (IDR)</th>
                    <th>Description</th>
                  </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
              </table>
            </div>
            <div class="inv-jurnal-catatan" id="inv-detail-jurnal-catatan" hidden></div>
          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <span>
          <button type="button" class="btn btn-primary" id="inv-detail-cetak">
            <i class="fa fa-print"></i> Invoice Garment</button>
          <button type="button" class="btn btn-primary" id="inv-detail-cetak-knitting" hidden>
            <i class="fa fa-scroll"></i> Invoice Knitting</button>
        </span>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
/* ==========================================================================
   Isi tambahan modal detail

   Dua penyesuaian yang ditambahkan sesudah modal digambar crud-nag.js:
     1. Profit Center ditulis nama lengkapnya (NAG -> NIRWANA ALABARE
        GARMENT), diambil dari master_pc lewat inv_detail_header().
     2. Keterangan "Approval" diganti alur lengkap: Booking Invoice (dari
        Invoice EXIM) -> Invoice Created -> First Approval -> Second
        Approval, masing-masing dengan nama pemrosesnya dan waktunya.

   Ditulis disini, bukan di crud-nag.js, supaya ikut terbawa ke semua layar
   yang memuat modal ini tanpa menyentuh berkas yang dipakai layar lain.
   ========================================================================== */
document.addEventListener('DOMContentLoaded', function () {
  if (typeof inv_detail_render !== 'function') { return; }

  var LANGKAH = [
    ['Booking Invoice', 'fa-inbox', 'booking_by', 'booking_at'],
    ['Invoice Created', 'fa-file-invoice', 'invoice_by', 'invoice_at'],
    ['First Approval', 'fa-user-check', 'first_approve_by', 'first_approve_at'],
    ['Second Approval', 'fa-check-double', 'second_approve_by', 'second_approve_at']
  ];

  // "2026-09-24 16:49" -> "24 Sep 2026 · 16:49"
  function waktu(v) {
    var t = $.trim(String(v === null || v === undefined ? '' : v));
    if (t === '' || t.indexOf('0000') === 0) { return ''; }
    var bagi = t.split(' ');
    var tgl = inv_detail_tgl(bagi[0]);
    return tgl ? (tgl + (bagi[1] ? ' &middot; ' + bagi[1] : '')) : '';
  }

  function lengkapi(h) {
    var $info = $('#modal-inv-detail-v2 #inv-detail-info');
    if (!$info.length) { return; }

    // 1. Profit Center - butir pertama di daftar keterangan
    var namaPc = $.trim(h.nama_profit_center || '');
    if (namaPc) { $info.children('div').eq(0).find('dd').text(namaPc); }

    // 2. Approval - butir terakhir, diganti alur di bawah daftar
    $info.children('div').last().remove();
    $('#modal-inv-detail-v2 .inv-alur').remove();

    var html = '<div class="inv-alur">' + LANGKAH.map(function (l) {
      var oleh = $.trim(String(h[l[2]] || ''));
      var kapan = waktu(h[l[3]]);
      var selesai = oleh !== '' || kapan !== '';
      return '<div class="inv-alur-langkah ' + (selesai ? 'is-selesai' : 'is-nanti') + '">'
        + '<span class="inv-alur-ikon"><i class="fas ' + (selesai ? l[1] : 'fa-ellipsis-h') + '"></i></span>'
        + '<span class="inv-alur-judul">' + l[0] + '</span>'
        + '<span class="inv-alur-isi">' + (selesai ? inv_detail_isi(oleh, '-') : 'Waiting')
        + (kapan ? '<small>' + kapan + '</small>' : '') + '</span>'
        + '</div>';
    }).join('') + '</div>';

    $info.after(html);
  }

  var asli = inv_detail_render;
  window.inv_detail_render = function (res) {
    asli(res);
    // Modal tetap harus tampil walau bagian tambahan ini gagal.
    try { lengkapi((res && res.header) || {}); } catch (e) { }
  };
});

/* ==========================================================================
   Urut kolom tabel SJ di modal detail

   Sepasang dengan blok CSS "TAMPILAN MODAL DETAIL INVOICE" di atas: panah
   di kepala tabel memang bisa dipakai, bukan hiasan. Barisnya sedikit
   (satu invoice), jadi cukup diurutkan langsung di DOM tanpa plugin.
   Menu Approval memakai modal yang sama tapi tidak memuat skrip ini.
   ========================================================================== */
// jQuery baru ada sesudah skrip footer, jadi semuanya dipasang di sini.
document.addEventListener('DOMContentLoaded', function () {
  var TABEL = '#modal-inv-detail-v2 #inv-detail-tabel';

  // Angka ditulis dengan pemisah ribuan ("13,513.514") - dibandingkan sebagai
  // angka, sisanya sebagai teks.
  function nilai(td) {
    var teks = $(td).text().trim();
    var angka = teks.replace(/,/g, '');
    return (angka !== '' && /^-?\d+(\.\d+)?$/.test(angka)) ? parseFloat(angka) : teks.toLowerCase();
  }

  $(document).on('click', TABEL + ' thead th', function () {
    var th = this;
    var $tbody = $(TABEL + ' tbody');
    var baris = $tbody.children('tr').get();
    // Baris "No SJ row on this invoice" tidak perlu diurutkan.
    if (baris.length < 2) { return; }

    var kolom = $(th).index();
    var turun = !$(th).hasClass('is-urut-naik');

    baris.sort(function (a, b) {
      var x = nilai(a.cells[kolom]);
      var y = nilai(b.cells[kolom]);
      if (x < y) { return turun ? 1 : -1; }
      if (x > y) { return turun ? -1 : 1; }
      return 0;
    });

    $(th).siblings().removeClass('is-urut-naik is-urut-turun');
    $(th).toggleClass('is-urut-naik', !turun).toggleClass('is-urut-turun', turun);
    $tbody.append(baris);
  });

  // Kepala tabelnya digambar ulang tiap modal dibuka, dan waktunya ikut
  // lamanya permintaan data - jadi panahnya dipasang begitu isi <thead>
  // berubah, bukan ditunggu dengan jeda waktu.
  var thead = document.querySelector(TABEL + ' thead');
  if (!thead || !window.MutationObserver) { return; }
  new MutationObserver(function () {
    $(TABEL + ' thead th').addClass('bisa-urut');
  }).observe(thead, { childList: true, subtree: true });
});
</script>
