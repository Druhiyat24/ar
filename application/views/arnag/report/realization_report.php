<!-- ==========================================================================
     AR Collection Realization & Variance Report

     Membandingkan satu DOKUMEN PROYEKSI yang sudah tersimpan dengan alokasi
     yang benar-benar terjadi di periode dokumen itu. Karena acuannya dokumen,
     layar ini TIDAK punya menu sendiri - dibukanya dari tombol "Realization"
     di daftar History Projection Report.

     Semua angkanya dihitung server (Model_report::realization_report), layar
     ini cuma memajangnya. Tampilannya mengikuti laporan lain (skin .nag-skin
     di dn_skin.php).
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<?php $this->load->view('arnag/_ukuran_sm'); ?>
<style type="text/css">
.nag-skin .btn-dn-excel {
  background: linear-gradient(135deg, #15803d, #16a34a) !important;
  border: none !important;
  color: #fff !important;
}

/* ===== Kepala laporan =====
   Nomor dokumennya ditaruh paling depan dan dibuat paling besar: seluruh
   angka di layar ini mengacu ke satu dokumen proyeksi itu, jadi itulah yang
   harus terbaca duluan. Sisanya keterangan, dibuat lebih kecil. */
.nag-skin .rv-kepala { display: flex; flex-wrap: wrap; align-items: center; gap: 12px 20px; }

.nag-skin .rv-dok { display: flex; align-items: center; gap: 11px; }
.nag-skin .rv-dok-ikon {
  display: inline-flex; align-items: center; justify-content: center;
  width: 40px; height: 40px; border-radius: 11px; flex: 0 0 auto;
  background: linear-gradient(135deg, #1e3a5f, #2c5282);
  color: #e8f0fb; font-size: 16px;
  box-shadow: 0 2px 8px rgba(30, 58, 95, .25);
}
.nag-skin .rv-dok-teks { display: flex; flex-direction: column; gap: 1px; line-height: 1.25; }
.nag-skin .rv-dok-no {
  font-size: 17px; font-weight: 800; color: #0f172a; letter-spacing: -.2px;
  font-variant-numeric: tabular-nums;
}
.nag-skin .rv-dok-ket {
  font-size: 10.5px; font-weight: 700; letter-spacing: .4px;
  text-transform: uppercase; color: #94a3b8;
  display: flex; align-items: center; gap: 6px;
}
/* Jenis proyeksinya selama ini tersimpan tapi tidak pernah dipajang -
   padahal itu yang membedakan dokumen harian, mingguan, dan bulanan. */
.nag-skin .rv-dok-tipe {
  border-radius: 20px; padding: 1px 8px; font-size: 9.5px; font-weight: 800;
  letter-spacing: .3px; text-transform: uppercase;
  background: #eef2f7; color: #475569; border: 1px solid #e2e8f0;
}
.nag-skin .rv-dok-tipe.is-daily   { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.nag-skin .rv-dok-tipe.is-weekly  { background: #fffbeb; color: #a16207; border-color: #fde68a; }
.nag-skin .rv-dok-tipe.is-monthly { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.nag-skin .rv-dok-tipe:empty { display: none; }

.nag-skin .rv-kepala-garis {
  width: 1px; align-self: stretch; min-height: 34px; background: #e8edf4; margin: 0 2px;
}

.nag-skin .rv-kepala .rv-ruas { display: flex; flex-direction: column; gap: 2px; }
.nag-skin .rv-kepala .rv-label {
  font-size: 10px; font-weight: 700; letter-spacing: .5px;
  text-transform: uppercase; color: #94a3b8;
  display: flex; align-items: center; gap: 5px;
}
.nag-skin .rv-kepala .rv-label i { color: #cbd5e1; font-size: 10px; }
.nag-skin .rv-kepala .rv-nilai { font-size: 13px; font-weight: 700; color: #0f172a; }
.nag-skin .rv-kepala .rv-nilai .rv-nilai-ket { font-weight: 600; color: #94a3b8; }

.nag-skin .rv-kepala .rv-aksi { margin-left: auto; display: flex; gap: 8px; flex-wrap: wrap; }
/* Back merah - sewarna tombol keluar di layar AR lainnya. */
.nag-skin .btn-rv-back {
  background: linear-gradient(135deg, #b91c1c, #dc2626) !important;
  border: none !important; color: #fff !important; font-weight: 600;
}
.nag-skin .btn-rv-back:hover {
  background: linear-gradient(135deg, #991b1b, #b91c1c) !important; color: #fff !important;
}

/* ===== Papan ringkasan =====
   Angka-angka ini yang dibaca duluan, jadi ditaruh di atas tabelnya.
   Lebarnya ikut isi kartu - tidak dipaksa satu baris, supaya di layar
   sempit melipat sendiri dan halamannya tidak perlu digeser ke samping. */
.nag-skin .rv-papan {
  display: grid; gap: 8px;
  grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
}
/* Di layar lebar dipaku empat kolom - dua belas kotak jadi tiga baris rapi,
   bukan lima-lima-dua. */
@media (min-width: 992px) {
  .nag-skin .rv-papan { grid-template-columns: repeat(4, 1fr); }
}
.nag-skin .rv-kartu {
  background: #fff; border: 1px solid #e2e8f0; border-radius: 9px;
  padding: 8px 11px; display: flex; flex-direction: column; gap: 2px;
  border-left: 3px solid #cbd5e1;
}
.nag-skin .rv-kartu .rv-k-judul {
  font-size: 9.5px; font-weight: 700; letter-spacing: .3px; line-height: 1.35;
  text-transform: uppercase; color: #64748b;
}
.nag-skin .rv-kartu .rv-k-nilai {
  font-size: 15px; font-weight: 700; color: #0f172a;
  font-variant-numeric: tabular-nums; line-height: 1.2;
}
.nag-skin .rv-kartu .rv-k-kaki { font-size: 10px; color: #94a3b8; line-height: 1.3; }
.nag-skin .rv-kartu.rv-proj  { border-left-color: #60a5fa; }
.nag-skin .rv-kartu.rv-real  { border-left-color: #34d399; }
.nag-skin .rv-kartu.rv-capai { border-left-color: #818cf8; }
.nag-skin .rv-kartu.rv-var   { border-left-color: #fbbf24; }
.nag-skin .rv-kartu.rv-fx    { border-left-color: #c084fc; }
.nag-skin .rv-kartu.rv-belum { border-left-color: #fb7185; }
.nag-skin .rv-kartu.rv-sebagian { border-left-color: #facc15; }
.nag-skin .rv-kartu.rv-tak-rencana { border-left-color: #f59e0b; }
/* Rekonsiliasi: hijau kalau nol, merah kalau tidak - itu satu-satunya
   angka di papan ini yang punya nilai "benar". */
.nag-skin .rv-kartu.rv-rekon.is-pas  { border-left-color: #22c55e; }
.nag-skin .rv-kartu.rv-rekon.is-pas .rv-k-nilai { color: #15803d; }
.nag-skin .rv-kartu.rv-rekon.is-meleset { border-left-color: #ef4444; background: #fef2f2; }
.nag-skin .rv-kartu.rv-rekon.is-meleset .rv-k-nilai { color: #b91c1c; }

/* ===== Rekap per buyer =====
   Papan di atas menjawab "berapa", tabel ini menjawab "siapa". Tingginya
   dibatasi dan digulung di dalam kartunya sendiri - buyer bisa puluhan, dan
   tabelnya tidak boleh mendorong isi tab ini jauh ke bawah. */
.nag-skin .rv-buyer-bungkus {
  max-height: 300px; overflow-y: auto;
  border: 1px solid #e8edf4; border-radius: 9px; background: #fff;
}
.nag-skin table.rv-buyer {
  width: 100%; border-collapse: separate; border-spacing: 0; font-size: 12px;
}
/* Kepalanya navy, sama dengan .dn-table di seluruh aplikasi - satu laporan
   tidak boleh punya dua macam kepala tabel. */
.nag-skin table.rv-buyer th {
  position: sticky; top: 0; z-index: 2;
  background: #1e3a5f; color: #f8fafc;
  font-size: 10.5px; font-weight: 600; letter-spacing: .4px; text-transform: uppercase;
  text-align: left; padding: 8px 11px; white-space: nowrap;
  border-right: 1px solid rgba(255, 255, 255, .10);
  border-bottom: 2px solid #0f2942;
}
.nag-skin table.rv-buyer th:last-child { border-right: 0; }
.nag-skin table.rv-buyer td {
  padding: 6px 11px; border-bottom: 1px solid #f3f6fa; color: #0f172a;
  vertical-align: middle;
}
.nag-skin table.rv-buyer tbody tr:last-child td { border-bottom: 0; }
.nag-skin table.rv-buyer th.dn-angka,
.nag-skin table.rv-buyer td.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
.nag-skin table.rv-buyer tbody tr:hover td { background: #f8fafc; }

/* Nama buyer diberi titik warna - urutan siapa yang tertinggal terbaca
   sebelum angkanya dibaca. */
.nag-skin table.rv-buyer .rv-b-nama { display: flex; align-items: center; gap: 8px; }
.nag-skin table.rv-buyer .rv-b-titik {
  width: 7px; height: 7px; border-radius: 50%; flex: 0 0 auto; background: #cbd5e1;
}
.nag-skin table.rv-buyer .rv-b-titik.is-capai { background: #22c55e; }
.nag-skin table.rv-buyer .rv-b-titik.is-hampir { background: #f59e0b; }
.nag-skin table.rv-buyer .rv-b-titik.is-jauh { background: #ef4444; }

/* Capaian jadi lencana - hijau kalau sampai target, kuning kalau mepet,
   merah kalau jauh. Bentuknya sama dengan lencana di kartu. */
.nag-skin table.rv-buyer .rv-b-capai {
  display: inline-block; min-width: 62px; text-align: right;
  border-radius: 20px; padding: 1px 8px;
  font-size: 10.5px; font-weight: 800; font-variant-numeric: tabular-nums;
  background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
}
.nag-skin table.rv-buyer .rv-b-capai.is-capai { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.nag-skin table.rv-buyer .rv-b-capai.is-hampir { background: #fffbeb; color: #a16207; border-color: #fde68a; }
.nag-skin table.rv-buyer .rv-b-capai.is-jauh { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }

/* Bilah setipis rambut di bawah nilai realisasinya - panjangnya sebanding
   dengan buyer terbesar, jadi besar-kecilnya terbaca sekilas. */
/* Bilahnya duduk di bawah nama buyer - menjorok sedikit supaya sejajar
   dengan teksnya, bukan dengan titik warnanya. */
.nag-skin table.rv-buyer .rv-b-bilah {
  height: 3px; border-radius: 20px; background: #eef2f7;
  margin: 4px 0 0 15px; max-width: 220px; overflow: hidden;
}
.nag-skin table.rv-buyer .rv-b-bilah span { display: block; height: 100%; background: #bfdbfe; border-radius: 20px; }

.nag-skin table.rv-buyer tfoot td {
  position: sticky; bottom: 0; z-index: 2;
  background: #f6f8fb; font-weight: 800; color: #0f172a;
  border-top: 1px solid #e2e8f0; border-bottom: 0;
}
.nag-skin table.rv-buyer .rv-minus { color: #b91c1c; }
/* Kotak saring di kepala bagiannya - didorong ke kanan sendiri. */
.nag-skin .table-header.rv-lipat-kepala .rv-cari { margin-left: auto; position: relative; }
.nag-skin .rv-cari i {
  position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
  color: #cbd5e1; font-size: 11px; pointer-events: none;
}
.nag-skin .rv-cari input {
  border: 1px solid #e2e8f0; border-radius: 8px; background: #fff;
  padding: 5px 11px 5px 28px; font-size: 11.5px; color: #0f172a;
  width: 190px; max-width: 100%; outline: none; transition: border-color .15s, box-shadow .15s;
}
.nag-skin .rv-cari input::placeholder { color: #b6c2d2; }
.nag-skin .rv-cari input:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px rgba(147, 197, 253, .25); }

.nag-skin table.rv-buyer .rv-kosong { color: #94a3b8; font-style: italic; padding: 14px; text-align: center; }

/* ===== Tabelnya ===== */
/* ===== Perlakuan yang SAMA untuk ketiga tabel tab 2-4 =====
   Ditulis sekali di sini, bukan sekali per tab: begitu dipisah, cepat atau
   lambat salah satu tabnya kelihatan lain sendiri. Kepala tabelnya sendiri
   navy, ikut .dn-table di dn_skin - sama dengan tabel lain di aplikasi ini. */
.nag-skin .rv-tabel-area .dn-table td.dn-angka,
.nag-skin .rv-tabel-area .dn-table th.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
.nag-skin .rv-tabel-area .dn-table td.dn-tengah,
.nag-skin .rv-tabel-area .dn-table th.dn-tengah { text-align: center; }
/* Kolom terakhir berisi data, bukan tombol - jangan dikunci ke kanan. */
.nag-skin .rv-tabel-area .dn-table tbody td:last-child,
.nag-skin .rv-tabel-area .dn-table thead th:last-child {
  position: static; right: auto; z-index: auto; box-shadow: none;
}
.nag-skin .rv-tabel-area .dataTables_scrollHeadInner,
.nag-skin .rv-tabel-area .dataTables_scrollHeadInner > table,
.nag-skin .rv-tabel-area .dataTables_scrollBody > table { min-width: 100% !important; }
.nag-skin .rv-tabel-area .dn-table tbody tr:hover td { filter: brightness(0.97); }
.nag-skin .rv-tabel-area .dn-table td .rv-minus { color: #b91c1c; }

/* Mata uang & status ditulis sebagai keping kecil - sama bentuknya di
   ketiga tabel. */
.nag-skin .rv-tabel-area .dn-table .rv-kurs {
  display: inline-block; min-width: 38px; padding: 1px 6px; border-radius: 5px;
  background: #eef2f7; color: #475569; font-size: 10.5px; font-weight: 800;
  letter-spacing: .3px;
}
.nag-skin .rv-tabel-area .dn-table .rv-post {
  display: inline-block; padding: 1px 8px; border-radius: 20px;
  font-size: 10px; font-weight: 800; letter-spacing: .3px;
  background: #eef2f7; color: #64748b;
}
.nag-skin .rv-tabel-area .dn-table .rv-post.is-post { background: #f0fdf4; color: #15803d; }

/* Tiga kelompok kolom - Projection, Realization, Result - dibedakan garis
   aksen di kepalanya dan rona isi yang sangat muda, sama seperti Unearned Revenue
   Uang Muka. Tabel selebar ini susah dibaca tanpa penanda kelompok. */
#rv-list-area .dn-table thead .rv-grup th { background: #16304d; border-left: 1px solid rgba(255,255,255,.14); font-size: 10.5px; letter-spacing: .4px; }
#rv-list-area .dn-table thead .rv-grup th.is-kosong { background: #1e3a5f; border-left: 0; }
#rv-list-area .dn-table thead .rv-grup th.g-proj { box-shadow: inset 0 -3px 0 #60a5fa; }
#rv-list-area .dn-table thead .rv-grup th.g-real { box-shadow: inset 0 -3px 0 #34d399; }
#rv-list-area .dn-table thead .rv-grup th.g-hasil { box-shadow: inset 0 -3px 0 #fbbf24; }
#rv-list-area .dn-table td.g-proj  { background: #f2f7fe; }
#rv-list-area .dn-table td.g-real  { background: #f0fbf6; }
#rv-list-area .dn-table td.g-hasil { background: #fff9ef; }
#rv-list-area .dn-table td.rv-batas,
#rv-list-area .dn-table th.rv-batas { border-left: 1px solid #e2e8f0; }

/* Kelompok kolom di tab Projection - bentuknya sama dengan kelompok di tab
   utamanya, bukan warna lain lagi. */
#rv-proy-area .dn-table thead .rv-grup th { background: #16304d; border-left: 1px solid rgba(255,255,255,.14); font-size: 10.5px; letter-spacing: .4px; }
#rv-proy-area .dn-table thead .rv-grup th.is-kosong { background: #1e3a5f; border-left: 0; }
#rv-proy-area .dn-table thead .rv-grup th.g-recv { box-shadow: inset 0 -3px 0 #60a5fa; }
#rv-proy-area .dn-table thead .rv-grup th.g-inflow { box-shadow: inset 0 -3px 0 #34d399; }
#rv-proy-area .dn-table td.g-recv { background: #f2f7fe; }
#rv-proy-area .dn-table td.g-inflow { background: #f0fbf6; }
#rv-proy-area .dn-table td.rv-batas,
#rv-proy-area .dn-table th.rv-batas { border-left: 1px solid #e2e8f0; }
#rv-proy-area .dn-table tfoot td {
  background: #f8fafc; font-weight: 700; color: #0f172a; border-top: 2px solid #e2e8f0;
}
#rv-proy-area .dn-table tfoot td.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
#rv-proy-area .dn-table tfoot td:first-child { text-align: center; }
#rv-proy-area .dn-table tfoot .rv-total-label {
  font-size: 13.5px; font-weight: 700; letter-spacing: .3px;
  text-transform: uppercase; color: #0f172a;
}

/* Lencana status. */
.nag-skin .rv-status {
  display: inline-block; padding: 2px 8px; border-radius: 20px;
  font-size: 10.5px; font-weight: 700; letter-spacing: .3px; white-space: nowrap;
}
.nag-skin .rv-status.s-collected { background: #dcfce7; color: #15803d; }
.nag-skin .rv-status.s-partial   { background: #fef3c7; color: #a16207; }
.nag-skin .rv-status.s-belum     { background: #fee2e2; color: #b91c1c; }
.nag-skin .rv-status.s-unplanned { background: #e0e7ff; color: #4338ca; }

/* Selisih minus dibedakan warnanya - yang dicari mata memang yang minus. */

/* Penjelasan selisih: satu-satunya kolom yang diketik tangan, jadi dibuat
   jelas bisa diklik. */
#rv-list-area .dn-table a.rv-catat {
  color: #1d4ed8; text-decoration: none;
  border-bottom: 1px dashed rgba(29, 78, 216, .45); cursor: pointer;
}
#rv-list-area .dn-table a.rv-catat:hover { color: #1e3a8a; border-bottom-style: solid; }
#rv-list-area .dn-table a.rv-catat.is-kosong { color: #94a3b8; font-style: italic; }

/* Baris jumlah di kaki tabel. */
#rv-list-area .dn-table tfoot td {
  background: #f8fafc; font-weight: 700; color: #0f172a; border-top: 2px solid #e2e8f0;
}
#rv-list-area .dn-table tfoot td.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
#rv-list-area .dn-table tfoot td:first-child { text-align: center; }
#rv-list-area .dn-table tfoot .rv-total-label {
  font-size: 13.5px; font-weight: 700; letter-spacing: .3px;
  text-transform: uppercase; color: #0f172a;
}

/* ===== Empat tab =====
   Satu tab = satu lembar unduhannya, supaya yang dilihat di layar dan yang
   ditarik ke Excel tidak pernah beda isi. Tabnya dibiarkan melipat di layar
   sempit, bukan digeser ke samping. */
.nag-skin .rv-tab { border-bottom: 2px solid #e2e8f0; gap: 2px; flex-wrap: wrap; }
.nag-skin .rv-tab .nav-link {
  border: none; border-bottom: 3px solid transparent; border-radius: 0;
  margin-bottom: -2px; padding: 9px 14px;
  font-size: 12.5px; font-weight: 700; letter-spacing: .2px;
  color: #64748b; background: transparent; white-space: nowrap;
}
.nag-skin .rv-tab .nav-link i { margin-right: 6px; opacity: .7; }
.nag-skin .rv-tab .nav-link:hover { color: #1e3a5f; background: #f8fafc; }
.nag-skin .rv-tab .nav-link.active {
  color: #1e3a5f; background: transparent; border-bottom-color: #1e3a5f;
}
.nag-skin .rv-tab .nav-link.active i { opacity: 1; }
/* Tirai loadingnya menumpang di sini, jadi kotaknya harus jadi acuan. */
.nag-skin .rv-tab-bungkus { position: relative; padding-top: 14px; min-height: 120px; }
/* Jarak antara papan indikator dan rekap buyer di tab pertama. */
.nag-skin .rv-sela { margin-top: 18px; }


/* ===== Kepala papan indikator ===== */
.nag-skin .rv-papan-kepala {
  display: flex; flex-wrap: wrap; align-items: center; gap: 10px;
  padding: 2px 0 11px;
}
.nag-skin .rv-papan-judul { display: flex; align-items: center; gap: 10px; }
.nag-skin .rv-papan-ikon {
  display: inline-flex; align-items: center; justify-content: center;
  width: 36px; height: 36px; border-radius: 10px;
  background: #eef4fc; color: #1e3a5f; border: 1px solid #dbe6f5; font-size: 15px;
}
.nag-skin .rv-papan-teks { display: flex; flex-direction: column; line-height: 1.3; }
.nag-skin .rv-papan-teks b { font-size: 14.5px; color: #0f172a; letter-spacing: -.2px; }
.nag-skin .rv-papan-teks small { font-size: 11px; color: #94a3b8; }
.nag-skin .rv-papan-alat { margin-left: auto; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

/* Saklar Compact / Exact. */
.nag-skin .rv-saklar {
  display: inline-flex; background: #f1f5f9; border: 1px solid #e2e8f0;
  border-radius: 9px; padding: 2px;
}
.nag-skin .rv-saklar button {
  border: 0; background: transparent; border-radius: 7px;
  padding: 4px 11px; font-size: 11.5px; font-weight: 700; color: #64748b;
  cursor: pointer; transition: all .15s;
}
.nag-skin .rv-saklar button:hover { color: #1e3a5f; }
.nag-skin .rv-saklar button.is-aktif {
  background: #fff; color: #0f172a; box-shadow: 0 1px 2px rgba(15, 23, 42, .12);
}
/* Petunjuk sorot cuma berguna waktu angkanya dipendekkan. */
.nag-skin .rv-papan-petunjuk { font-size: 10.5px; color: #b6c2d2; }
.nag-skin .rv-papan-petunjuk.is-sembunyi { visibility: hidden; }

/* Tanda Reconciliation - pas atau meleset, tidak ada yang lain. */
.nag-skin .rv-rekon {
  display: inline-flex; align-items: center; gap: 6px;
  border-radius: 9px; padding: 4px 10px;
  font-size: 11px; font-weight: 800; border: 1px solid transparent;
  font-variant-numeric: tabular-nums;
}
.nag-skin .rv-rekon .rv-rekon-label {
  font-size: 10px; font-weight: 700; letter-spacing: .4px;
  text-transform: uppercase; color: #94a3b8;
}
.nag-skin .rv-rekon.is-pas { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
.nag-skin .rv-rekon.is-meleset { background: #fef2f2; border-color: #fecaca; color: #b91c1c; }
.nag-skin .rv-rekon.is-meleset .rv-rekon-label { color: #b91c1c; }

/* ===== Bagian yang bisa ditutup =====
   Tab pertama dua bagian, dan tidak semua orang perlu melihat keduanya
   sekaligus. Pilihannya diingat per browser. */
.nag-skin .rv-lipat {
  border: 1px solid #e2e8f0; background: #fff; color: #64748b;
  width: 21px; height: 21px; border-radius: 6px; font-size: 9.5px; padding: 0;
  display: inline-flex; align-items: center; justify-content: center;
  flex: 0 0 auto; cursor: pointer; margin-right: 8px; transition: all .15s;
}
.nag-skin .rv-lipat:hover { color: #1e3a5f; border-color: #cbd5e1; background: #f8fafc; }
.nag-skin .rv-lipat i { transition: transform .15s; }
.nag-skin .rv-lipat-kepala.is-tutup .rv-lipat i { transform: rotate(180deg); }
.nag-skin .rv-lipat-kepala .rv-papan-judul,
.nag-skin .rv-lipat-kepala .table-title { cursor: pointer; }
.nag-skin .rv-lipat-isi.is-tutup { display: none; }
/* .table-header bawaannya merenggangkan isinya ke dua tepi - judulnya harus
   menempel ke tombol lipatnya, bukan terlempar ke kanan. */
.nag-skin .table-header.rv-lipat-kepala { justify-content: flex-start; gap: 0; }

/* ===== Judul kelompok kartu =====
   Delapan kartu dibagi dua: yang paling sering ditanya di atas, rincian
   selisihnya di bawah. */
.nag-skin .rv-bagian { display: flex; align-items: baseline; gap: 10px; margin: 2px 0 7px; }
.nag-skin .rv-bagian + .rv-papan { margin-bottom: 2px; }
.nag-skin .rv-papan + .rv-bagian { margin-top: 11px; }
.nag-skin .rv-bagian-judul {
  font-size: 10px; font-weight: 800; letter-spacing: .9px;
  text-transform: uppercase; color: #64748b;
}
.nag-skin .rv-bagian-judul i { margin-right: 6px; color: #cbd5e1; }

/* ===== Isi kartunya ===== */
.nag-skin .rv-kartu { position: relative; transition: box-shadow .15s, border-color .15s; }
.nag-skin .rv-kartu:hover { box-shadow: 0 2px 10px rgba(15, 23, 42, .07); }
.nag-skin .rv-kartu .rv-k-atas { display: flex; align-items: flex-start; gap: 8px; }
.nag-skin .rv-kartu .rv-k-atas .rv-k-judul { flex: 1 1 auto; }
.nag-skin .rv-kartu .rv-k-ikon {
  display: inline-flex; align-items: center; justify-content: center;
  width: 22px; height: 22px; border-radius: 7px; flex: 0 0 auto;
  background: #f1f5f9; color: #64748b; font-size: 10.5px;
}
.nag-skin .rv-kartu.rv-proj  .rv-k-ikon { background: #eff6ff; color: #2563eb; }
.nag-skin .rv-kartu.rv-real  .rv-k-ikon { background: #ecfdf5; color: #059669; }
.nag-skin .rv-kartu.rv-belum .rv-k-ikon { background: #fef2f2; color: #dc2626; }
.nag-skin .rv-kartu.rv-tak-rencana .rv-k-ikon { background: #fffbeb; color: #d97706; }

/* Lencana kecil di pojok kanan atas kartu. */
.nag-skin .rv-kartu .rv-k-lencana {
  flex: 0 0 auto; border-radius: 20px; padding: 1px 7px;
  font-size: 9.5px; font-weight: 800; white-space: nowrap;
  background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
}
.nag-skin .rv-kartu .rv-k-lencana.is-naik { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.nag-skin .rv-kartu .rv-k-lencana.is-turun { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }

/* Kartu Achievement: nilainya ditemani bilah, supaya kurang/lebihnya terbaca
   tanpa membandingkan dua angka lain. */
.nag-skin .rv-kartu.rv-capai { background: linear-gradient(135deg, #ffffff, #f5f8ff); }
.nag-skin .rv-kartu .rv-k-bilah {
  height: 4px; border-radius: 20px; background: #e2e8f0; overflow: hidden; margin: 3px 0 1px;
}
.nag-skin .rv-kartu .rv-k-bilah span { display: block; height: 100%; border-radius: 20px; background: #818cf8; }
.nag-skin .rv-kartu .rv-k-bilah.is-penuh span { background: #22c55e; }
.nag-skin .rv-kartu .rv-k-bilah.is-kurang span { background: #f59e0b; }

/* Nilai pastinya muncul waktu kartunya disorot - mode Compact tetap bisa
   dibaca sampai sennya tanpa pindah mode. */
.nag-skin .rv-kartu .rv-k-pasti {
  position: absolute; left: 50%; bottom: 100%; transform: translate(-50%, 4px);
  margin-bottom: 6px; z-index: 30;
  background: #0f172a; color: #fff; border-radius: 8px; padding: 6px 10px;
  font-size: 11px; font-weight: 600; white-space: nowrap;
  font-variant-numeric: tabular-nums;
  opacity: 0; visibility: hidden; pointer-events: none; transition: all .15s;
  box-shadow: 0 6px 18px rgba(15, 23, 42, .25);
}
.nag-skin .rv-kartu .rv-k-pasti::after {
  content: ''; position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
  border: 4px solid transparent; border-top-color: #0f172a;
}
.nag-skin .rv-kartu:hover .rv-k-pasti { opacity: 1; visibility: visible; transform: translate(-50%, 0); }

/* ===== Keterangan warna ===== */
.nag-skin .rv-legenda {
  display: flex; flex-wrap: wrap; align-items: center; gap: 6px 16px;
  margin-top: 11px; padding-top: 9px; border-top: 1px solid #eef2f7;
  font-size: 10.5px; color: #94a3b8;
}
.nag-skin .rv-legenda .rv-titik {
  display: inline-block; width: 7px; height: 7px; border-radius: 50%; margin-right: 6px;
}
.nag-skin .rv-legenda .rv-titik.is-hijau { background: #22c55e; }
.nag-skin .rv-legenda .rv-titik.is-merah { background: #ef4444; }
.nag-skin .rv-legenda .rv-titik.is-kuning { background: #f59e0b; }
.nag-skin .rv-legenda .rv-legenda-kanan { margin-left: auto; }

</style>

<div class="content-wrapper nag-skin ci-sm">
  <section class="content">
    <div class="container-fluid">

      <!-- Kepala laporan -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-balance-scale"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="rv-kepala">
            <!-- Nomor dokumennya yang jadi tokoh utama: seluruh angka di layar
                 ini mengacu ke satu dokumen proyeksi itu. -->
            <div class="rv-dok">
              <span class="rv-dok-ikon"><i class="fas fa-file-invoice-dollar"></i></span>
              <span class="rv-dok-teks">
                <span class="rv-dok-no" id="rv-doc">-</span>
                <span class="rv-dok-ket">
                  Projection document
                  <span class="rv-dok-tipe" id="rv-tipe"></span>
                </span>
              </span>
            </div>

            <span class="rv-kepala-garis"></span>

            <div class="rv-ruas">
              <span class="rv-label"><i class="far fa-calendar-alt"></i>Period</span>
              <span class="rv-nilai" id="rv-periode">-</span>
            </div>
            <div class="rv-ruas">
              <span class="rv-label"><i class="far fa-building"></i>Customer</span>
              <span class="rv-nilai" id="rv-customer">-</span>
            </div>
            <div class="rv-ruas">
              <span class="rv-label"><i class="far fa-user"></i>Saved by</span>
              <span class="rv-nilai" id="rv-oleh">-</span>
            </div>

            <div class="rv-aksi">
              <button type="button" class="btn btn-dn-excel" id="rv-btn-export" onclick="rv_export()">
                <i class="fas fa-file-excel"></i> Export
              </button>
              <button type="button" class="btn btn-rv-back" onclick="rv_kembali()">
                <i class="fas fa-arrow-left"></i> Back
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Empat tab, isinya persis empat lembar unduhannya: Executive
           Summary, lembar utama, Projection, lalu Realization. Satu tarikan
           data untuk keempatnya - pindah tab tidak memanggil server lagi. -->
      <div class="card">
        <div class="card-body">

          <ul class="nav nav-tabs rv-tab" id="rv-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="rv-tab-ringkas" data-toggle="tab" href="#rv-pane-ringkas"
                 role="tab" aria-controls="rv-pane-ringkas" aria-selected="true">
                <i class="fas fa-tachometer-alt"></i> Executive Summary
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="rv-tab-utama" data-toggle="tab" href="#rv-pane-utama"
                 role="tab" aria-controls="rv-pane-utama" aria-selected="false">
                <i class="fas fa-balance-scale"></i> AR Collection Realization &amp; Variance
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="rv-tab-proyeksi" data-toggle="tab" href="#rv-pane-proyeksi"
                 role="tab" aria-controls="rv-pane-proyeksi" aria-selected="false">
                <i class="fas fa-chart-line"></i> Projection
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="rv-tab-realisasi" data-toggle="tab" href="#rv-pane-realisasi"
                 role="tab" aria-controls="rv-pane-realisasi" aria-selected="false">
                <i class="fas fa-money-check-alt"></i> Realization
              </a>
            </li>
          </ul>

          <!-- Tirai loadingnya menutup seluruh isi tab - datanya memang satu
               tarikan untuk keempat tabnya. -->
          <div class="rv-tab-bungkus">
            <div class="nag-loader-overlay" id="rv-list-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Loading data...</div>
              </div>
            </div>

            <div class="tab-content" id="rv-tab-isi">

              <!-- 1. Executive Summary -->
              <div class="tab-pane active" id="rv-pane-ringkas" role="tabpanel"
                   aria-labelledby="rv-tab-ringkas">
                <!-- Tab ini dua bagian - Performance Indicators & Summary
                     Buyer - dan masing-masing bisa ditutup. Reconciliation Check
                     tidak lagi jadi lencana di kepala: angka itu sudah punya
                     kotaknya sendiri, sama seperti di lembar Executive Summary
                     unduhannya. -->
                <div class="rv-papan-kepala rv-lipat-kepala" data-lipat="papan">
                  <button type="button" class="rv-lipat" title="Hide or show">
                    <i class="fas fa-chevron-up"></i>
                  </button>
                  <div class="rv-papan-judul">
                    <span class="rv-papan-ikon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="rv-papan-teks">
                      <b>Performance Indicators</b>
                      <small>Collection performance, achievement, and variance for this document</small>
                    </span>
                  </div>
                  <div class="rv-papan-alat">
                    <span class="rv-papan-petunjuk">Hover a card for the exact figure</span>
                    <div class="rv-saklar" id="rv-format">
                      <button type="button" data-format="ringkas">Compact</button>
                      <button type="button" data-format="penuh">Exact</button>
                    </div>
                    <!-- Reconciliation Check: satu-satunya angka di layar ini
                         yang punya nilai "benar", jadi dipajang sebagai tanda
                         pas/meleset - bukan kartu nominal kesembilan. -->
                    <div class="rv-rekon" id="rv-rekon"></div>
                  </div>
                </div>

                <!-- Isinya sama persis dengan baris indikator di lembar
                     Executive Summary unduhannya - urutannya pun sama, supaya
                     layar dan Excel tidak pernah beda isi. -->
                <div class="rv-lipat-isi" id="rv-lipat-papan">
                  <div class="rv-bagian">
                    <span class="rv-bagian-judul"><i class="fas fa-layer-group"></i>Key Performance Metrics</span>
                  </div>
                  <div class="rv-papan" id="rv-papan"></div>

                  <div class="rv-bagian">
                    <span class="rv-bagian-judul"><i class="fas fa-calculator"></i>Variance &amp; FX Breakdown</span>
                  </div>
                  <div class="rv-papan rv-papan-kedua" id="rv-papan-2"></div>

                  <div class="rv-legenda">
                    <span><i class="rv-titik is-hijau"></i>Positive / target met</span>
                    <span><i class="rv-titik is-merah"></i>Action required (unpaid)</span>
                    <span><i class="rv-titik is-kuning"></i>Unplanned inflow</span>
                    <span class="rv-legenda-kanan">All amounts in IDR</span>
                  </div>
                </div>

                <div class="table-header rv-sela rv-lipat-kepala" data-lipat="buyer">
                  <button type="button" class="rv-lipat" title="Hide or show">
                    <i class="fas fa-chevron-up"></i>
                  </button>
                  <span class="table-title"><i class="fas fa-users"></i>Summary Buyer</span>
                  <!-- Mengetik di sini tidak menutup bagiannya: yang membuka
                       tutup cuma tombol lipat dan judulnya. -->
                  <div class="rv-cari">
                    <i class="fas fa-search"></i>
                    <input type="text" id="rv-buyer-cari" autocomplete="off"
                           placeholder="Filter buyer...">
                  </div>
                </div>
                <div class="rv-lipat-isi" id="rv-lipat-buyer">
                  <div class="rv-buyer-bungkus">
                  <table class="rv-buyer" id="rv-buyer">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th class="dn-angka">Projected</th>
                        <th class="dn-angka">Realization</th>
                        <th class="dn-angka">Variance</th>
                        <th class="dn-angka">Achievement</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                    </table>
                  </div>
                </div>
              </div>

              <!-- 2. Lembar utama, satu baris per invoice -->
              <div class="tab-pane" id="rv-pane-utama" role="tabpanel"
                   aria-labelledby="rv-tab-utama">
                <div class="dn-list-area rv-tabel-area" id="rv-list-area">
                  <table id="table-realization" class="dn-table text-nowrap" width="100%">
                    <thead>
                      <tr class="rv-grup">
                        <th rowspan="2" class="is-kosong">Customer Name</th>
                        <th rowspan="2" class="is-kosong">Invoice No</th>
                        <th rowspan="2" class="is-kosong">Invoice Date</th>
                        <th rowspan="2" class="is-kosong">Due Date</th>
                        <th rowspan="2" class="is-kosong">Currency</th>
                        <th colspan="4" class="g-proj">Projection</th>
                        <th colspan="4" class="g-real">Realization</th>
                        <th colspan="8" class="g-hasil">Result</th>
                      </tr>
                      <tr>
                        <th class="rv-batas dn-tengah">Collection Date</th>
                        <th class="dn-angka">Amount in OCY</th>
                        <th class="dn-angka">Rate</th>
                        <th class="dn-angka">Amount Eqv Idr</th>
                        <th class="rv-batas dn-tengah">Collection Date</th>
                        <th class="dn-angka">Amount in OCY</th>
                        <th class="dn-angka">Rate</th>
                        <th class="dn-angka">Amount Eqv Idr</th>
                        <th class="rv-batas dn-tengah">Collection Status</th>
                        <th class="dn-angka">Achievement %</th>
                        <th class="dn-angka">Collection Date Variance</th>
                        <th class="dn-angka">Days Past Due</th>
                        <th>Variance Explanation</th>
                        <th class="dn-angka">Collection Variance (Excl. FX)</th>
                        <th class="dn-angka">FX Variance</th>
                        <th class="dn-angka">Total Variance</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <!-- Jumlahnya diisi rv_gambar_total() dari angka yang dihitung
                         server, jadi tidak mungkin beda dengan isinya. -->
                    <tfoot id="rv-total"></tfoot>
                  </table>
                </div>
              </div>

              <!-- 3. Projection - susunan kolomnya sama persis dengan modal
                   Detail di History Projection: dua belas kolom keterangan,
                   kelompok Receivable Amount, lalu satu kolom per tanggal
                   dalam periodenya. Kepalanya dirakit JS karena kolom
                   tanggalnya ikut panjang periode dokumennya. -->
              <div class="tab-pane" id="rv-pane-proyeksi" role="tabpanel"
                   aria-labelledby="rv-tab-proyeksi">
                <div class="dn-list-area rv-tabel-area" id="rv-proy-area">
                  <table id="table-rv-proyeksi" class="dn-table text-nowrap" width="100%">
                    <thead></thead>
                    <tbody></tbody>
                    <tfoot id="rv-proy-total"></tfoot>
                  </table>
                </div>
              </div>

              <!-- 4. Realization - satu baris per baris alokasi -->
              <div class="tab-pane" id="rv-pane-realisasi" role="tabpanel"
                   aria-labelledby="rv-tab-realisasi">
                <div class="dn-list-area rv-tabel-area" id="rv-real-area">
                  <table id="table-rv-realisasi" class="dn-table text-nowrap" width="100%">
                    <thead>
                      <tr>
                        <th>No Alokasi</th>
                        <th class="dn-tengah">Alokasi Date</th>
                        <th>Customer</th>
                        <th>Document Number</th>
                        <th>Bank</th>
                        <th class="dn-tengah">Account</th>
                        <th class="dn-tengah">Curr</th>
                        <th>No Reference</th>
                        <th class="dn-tengah">Reference Date</th>
                        <th class="dn-angka">Total</th>
                        <th class="dn-angka">Rate</th>
                        <th class="dn-angka">Equivalent IDR</th>
                        <th class="dn-angka">Amount Alokasi</th>
                        <th class="dn-angka">Equivalent IDR</th>
                        <th class="dn-angka">Income Tax Art 23</th>
                        <th class="dn-angka">Comission</th>
                        <th class="dn-angka">Bank Adm</th>
                        <th class="dn-angka">Others</th>
                        <th class="dn-angka">Collection Amount</th>
                        <th>Description</th>
                        <th class="dn-tengah">Create Date</th>
                        <th>Create By</th>
                        <th class="dn-tengah">Status</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
  var RV_DOC = <?= json_encode((string) $doc_number); ?>;

  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      rv_dt();
      // Tab Projection baru dirakit sesudah datanya masuk - jumlah kolom
      // tanggalnya ikut periode dokumennya.
      rv_dt_realisasi();
      // Lebar kolom tabel di tab yang belum kelihatan dihitung ulang
      // begitu tabnya dibuka - tanpa ini kolomnya menumpuk di kiri.
      rv_tab();
      rv_muat();
    });
  });
</script>
