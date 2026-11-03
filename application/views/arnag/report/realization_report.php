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

/* ===== Kepala laporan: nomor dokumen & periodenya ===== */
.nag-skin .rv-kepala { display: flex; flex-wrap: wrap; align-items: center; gap: 10px 22px; }
.nag-skin .rv-kepala .rv-ruas { display: flex; flex-direction: column; gap: 2px; }
.nag-skin .rv-kepala .rv-label {
  font-size: 10.5px; font-weight: 700; letter-spacing: .5px;
  text-transform: uppercase; color: #64748b;
}
.nag-skin .rv-kepala .rv-nilai { font-size: 13.5px; font-weight: 700; color: #0f172a; }
.nag-skin .rv-kepala .rv-aksi { margin-left: auto; display: flex; gap: 8px; flex-wrap: wrap; }

/* ===== Papan ringkasan =====
   Angka-angka ini yang dibaca duluan, jadi ditaruh di atas tabelnya.
   Lebarnya ikut isi kartu - tidak dipaksa satu baris, supaya di layar
   sempit melipat sendiri dan halamannya tidak perlu digeser ke samping. */
.nag-skin .rv-papan {
  display: grid; gap: 10px;
  grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
}
.nag-skin .rv-kartu {
  background: #fff; border: 1px solid #e2e8f0; border-radius: 10px;
  padding: 11px 13px; display: flex; flex-direction: column; gap: 4px;
  border-left: 3px solid #cbd5e1;
}
.nag-skin .rv-kartu .rv-k-judul {
  font-size: 10.5px; font-weight: 700; letter-spacing: .4px;
  text-transform: uppercase; color: #64748b;
}
.nag-skin .rv-kartu .rv-k-nilai {
  font-size: 17px; font-weight: 700; color: #0f172a;
  font-variant-numeric: tabular-nums; line-height: 1.15;
}
.nag-skin .rv-kartu .rv-k-kaki { font-size: 11px; color: #94a3b8; }
.nag-skin .rv-kartu.rv-proj  { border-left-color: #60a5fa; }
.nag-skin .rv-kartu.rv-real  { border-left-color: #34d399; }
.nag-skin .rv-kartu.rv-capai { border-left-color: #818cf8; }
.nag-skin .rv-kartu.rv-var   { border-left-color: #fbbf24; }
.nag-skin .rv-kartu.rv-fx    { border-left-color: #c084fc; }
.nag-skin .rv-kartu.rv-belum { border-left-color: #fb7185; }
/* Rekonsiliasi: hijau kalau nol, merah kalau tidak - itu satu-satunya
   angka di papan ini yang punya nilai "benar". */
.nag-skin .rv-kartu.rv-rekon.is-pas  { border-left-color: #22c55e; }
.nag-skin .rv-kartu.rv-rekon.is-pas .rv-k-nilai { color: #15803d; }
.nag-skin .rv-kartu.rv-rekon.is-meleset { border-left-color: #ef4444; background: #fef2f2; }
.nag-skin .rv-kartu.rv-rekon.is-meleset .rv-k-nilai { color: #b91c1c; }

/* ===== Rekap per buyer =====
   Papan di atas menjawab "berapa", tabel ini menjawab "siapa". Tingginya
   dibatasi dan digulung di dalam kartunya sendiri - buyer bisa puluhan, dan
   tabelnya tidak boleh mendorong tabel utama jauh ke bawah. */
.nag-skin .rv-buyer-bungkus { max-height: 260px; overflow-y: auto; border-radius: 6px; }
.nag-skin table.rv-buyer { width: 100%; border-collapse: collapse; font-size: 12px; }
.nag-skin table.rv-buyer th {
  position: sticky; top: 0; z-index: 1;
  background: #eef2f7; color: #334155; font-weight: 700; text-align: left;
  padding: 7px 10px; border-bottom: 1px solid #e2e8f0; white-space: nowrap;
}
.nag-skin table.rv-buyer td {
  padding: 6px 10px; border-bottom: 1px solid #f1f5f9; color: #0f172a;
}
.nag-skin table.rv-buyer th.dn-angka,
.nag-skin table.rv-buyer td.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
.nag-skin table.rv-buyer tbody tr:hover td { background: #f8fafc; }
.nag-skin table.rv-buyer tfoot td {
  background: #f8fafc; font-weight: 700; border-top: 2px solid #e2e8f0; border-bottom: none;
  position: sticky; bottom: 0;
}
.nag-skin table.rv-buyer .rv-minus { color: #b91c1c; }
.nag-skin table.rv-buyer .rv-kosong { color: #94a3b8; font-style: italic; padding: 10px; }

/* ===== Tabelnya ===== */
#rv-list-area .dn-table td.dn-angka,
#rv-list-area .dn-table th.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
#rv-list-area .dn-table td.dn-tengah,
#rv-list-area .dn-table th.dn-tengah { text-align: center; }
/* Kolom terakhir berisi data, bukan tombol - jangan dikunci ke kanan. */
#rv-list-area .dn-table tbody td:last-child,
#rv-list-area .dn-table thead th:last-child {
  position: static; right: auto; z-index: auto; box-shadow: none;
}
#rv-list-area .dataTables_scrollHeadInner,
#rv-list-area .dataTables_scrollHeadInner > table,
#rv-list-area .dataTables_scrollBody > table { min-width: 100% !important; }

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
#rv-list-area .dn-table tbody tr:hover td { filter: brightness(0.97); }

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
#rv-list-area .dn-table td .rv-minus { color: #b91c1c; }

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
</style>

<div class="content-wrapper nag-skin ci-sm">
  <section class="content">
    <div class="container-fluid">

      <!-- Kepala laporan -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-scale-balanced"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="rv-kepala">
            <div class="rv-ruas">
              <span class="rv-label">Projection Document</span>
              <span class="rv-nilai" id="rv-doc">-</span>
            </div>
            <div class="rv-ruas">
              <span class="rv-label">Period</span>
              <span class="rv-nilai" id="rv-periode">-</span>
            </div>
            <div class="rv-ruas">
              <span class="rv-label">Customer</span>
              <span class="rv-nilai" id="rv-customer">-</span>
            </div>
            <div class="rv-ruas">
              <span class="rv-label">Saved By</span>
              <span class="rv-nilai" id="rv-oleh">-</span>
            </div>
            <div class="rv-aksi">
              <button type="button" class="btn btn-dn-excel" id="rv-btn-export" onclick="rv_export()">
                <i class="fas fa-file-excel"></i> Export
              </button>
              <button type="button" class="btn btn-secondary" onclick="rv_kembali()">
                <i class="fas fa-arrow-left"></i> Back
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Papan ringkasan -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-gauge-high"></i>Performance Indicator</span>
          </div>
          <div class="rv-papan" id="rv-papan"></div>
        </div>
      </div>

      <!-- Rekap per buyer -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-users"></i>Summary Buyer</span>
          </div>
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

      <!-- Isi laporan -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Collection Realization &amp; Variance</span>
          </div>
          <div class="dn-list-area" id="rv-list-area">
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
      </div>

    </div>
  </section>
</div>

<script>
  var RV_DOC = <?= json_encode((string) $doc_number); ?>;

  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      rv_dt();
      rv_muat();
    });
  });
</script>
