<!-- ==========================================================================
     Sub Ledger - Uang Muka Penjualan
     Satu baris = satu uang muka (per COA, per dokumen, per customer), dengan
     mutasinya di periode yang dipilih dan umurnya.

     Angkanya dibaca dari buku besar lewat arnag/subledger_uang_muka_json -
     lihat Model_nag::subledger_uang_muka(). Tampilannya mengikuti menu
     laporan lain (skin .nag-skin di dn_skin.php).
     ========================================================================== -->
<?php $this->load->view('arnag/dn_skin'); ?>
<?php $this->load->view('arnag/_ukuran_sm'); ?>
<style type="text/css">
.nag-skin .btn-dn-excel {
  background: linear-gradient(135deg, #15803d, #16a34a) !important;
  border: none !important;
  color: #fff !important;
}

.nag-skin .um-aksi { margin-top: 12px; }
@media (min-width: 1280px) {
  .nag-skin .um-filter > .um-f-coa { flex: 0 0 22%; max-width: 22%; }
  .nag-skin .um-filter > .um-f-customer { flex: 0 1 24%; max-width: 340px; min-width: 220px; }
  .nag-skin .um-filter > .um-f-tgl { flex: 0 0 15%; max-width: 15%; }
  .nag-skin .um-filter > .um-f-aksi { flex: 0 0 auto; width: auto; max-width: none; }
  .nag-skin .um-filter .um-aksi { margin-top: 0; flex-wrap: nowrap; }
}
.nag-skin .um-aksi .btn { padding: 0 12px !important; }
.nag-skin .um-aksi .btn i { font-size: 11.5px; }

/* Kolom angka rata kanan & digitnya sejajar. */
#um-list-area .dn-table td.dn-angka,
#um-list-area .dn-table th.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
#um-list-area .dn-table td.dn-tengah,
#um-list-area .dn-table th.dn-tengah { text-align: center; }
/* Kolom terakhir berisi data, bukan tombol - jangan dikunci ke kanan. */
#um-list-area .dn-table tbody td:last-child,
#um-list-area .dn-table thead th:last-child {
  position: static; right: auto; z-index: auto; box-shadow: none;
}
/* Tabelnya minimal selebar kartunya; isinya memang lebar, jadi digeser di
   dalam kartunya sendiri. */
#um-list-area .dataTables_scrollHeadInner,
#um-list-area .dataTables_scrollHeadInner > table,
#um-list-area .dataTables_scrollBody > table { min-width: 100% !important; }

/* Warna tiap bagian. Kepala tabelnya tetap satu warna seperti menu lain -
   pembedanya garis aksen tipis di bawah nama kolomnya, dan rona isi kolom
   yang sangat muda. Tenang dilihat, tapi batas antar bagiannya jelas. */
#um-list-area .dn-table thead .um-grup th.g-beg  { box-shadow: inset 0 -3px 0 #60a5fa; }
#um-list-area .dn-table thead .um-grup th.g-add  { box-shadow: inset 0 -3px 0 #34d399; }
#um-list-area .dn-table thead .um-grup th.g-dedi { box-shadow: inset 0 -3px 0 #fbbf24; }
#um-list-area .dn-table thead .um-grup th.g-dedm { box-shadow: inset 0 -3px 0 #fb7185; }
#um-list-area .dn-table thead .um-grup th.g-end  { box-shadow: inset 0 -3px 0 #818cf8; }
#um-list-area .dn-table thead .um-grup th.g-age  { box-shadow: inset 0 -3px 0 #c084fc; }

#um-list-area .dn-table td.g-beg,
#um-list-area .dn-table tfoot td.g-beg  { background: #f2f7fe; }
#um-list-area .dn-table td.g-add,
#um-list-area .dn-table tfoot td.g-add  { background: #f0fbf6; }
#um-list-area .dn-table td.g-dedi,
#um-list-area .dn-table tfoot td.g-dedi { background: #fff9ef; }
#um-list-area .dn-table td.g-dedm,
#um-list-area .dn-table tfoot td.g-dedm { background: #fef4f4; }
#um-list-area .dn-table td.g-end,
#um-list-area .dn-table tfoot td.g-end  { background: #f4f4fe; }
#um-list-area .dn-table td.g-age,
#um-list-area .dn-table tfoot td.g-age  { background: #f9f4fe; }
/* Garis pemisah antar bagian, senada dengan aksennya. */
#um-list-area .dn-table td.g-beg:first-of-type { border-left: 2px solid #bfdbfe; }

/* Nomor dokumen bisa diklik - jurnal & transaksinya muncul di modal, jadi
   tidak perlu pindah menu. */
#um-list-area .dn-table a.um-dok {
  color: #1d4ed8; font-weight: 600; text-decoration: none;
  border-bottom: 1px dashed rgba(29, 78, 216, .45); cursor: pointer;
}
#um-list-area .dn-table a.um-dok:hover { color: #1e3a8a; border-bottom-style: solid; }

/* Modal rincian dokumennya. */
#modal-um-dok .modal-content { border: none; border-radius: 10px; overflow: hidden; }
#modal-um-dok .modal-header {
  background: #1e3a5f; color: #fff; border-bottom: none; padding: 12px 16px;
}
#modal-um-dok .modal-title { font-size: 14px; font-weight: 700; letter-spacing: .2px; }
#modal-um-dok .modal-header .close { color: #fff; opacity: .85; text-shadow: none; }
#modal-um-dok .modal-body { padding: 14px 16px 18px; background: #f8fafc; }
#modal-um-dok .um-dok-bagian { margin-bottom: 16px; }
#modal-um-dok .um-dok-bagian:last-child { margin-bottom: 0; }
#modal-um-dok .um-dok-judul {
  font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
  color: #475569; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;
}
#modal-um-dok .um-dok-judul i { color: #94a3b8; }
#modal-um-dok table { width: 100%; background: #fff; border-collapse: collapse; font-size: 11.5px; }
#modal-um-dok table th {
  background: #eef2f7; color: #334155; font-weight: 700; text-align: left;
  padding: 6px 8px; border-bottom: 1px solid #e2e8f0; white-space: nowrap;
}
#modal-um-dok table td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; color: #0f172a; }
#modal-um-dok table td.angka { text-align: right; font-variant-numeric: tabular-nums; }
#modal-um-dok table tr:last-child td { border-bottom: none; }
#modal-um-dok .um-dok-kosong { color: #94a3b8; font-style: italic; padding: 8px 2px; }
#modal-um-dok .um-dok-wrap { overflow-x: auto; border-radius: 6px; border: 1px solid #e2e8f0; }
#modal-um-dok .um-dok-seimbang { font-size: 11px; color: #475569; margin-top: 6px; }
#modal-um-dok .um-dok-seimbang b { color: #0f172a; }
/* Baris yang disorot tetap kelihatan disorot walau kolomnya berwarna. */
#um-list-area .dn-table tbody tr:hover td { filter: brightness(0.97); }

/* Kelompok kolom - supaya mata tidak tersesat di tabel selebar ini. */
#um-list-area .dn-table thead .um-grup th {
  background: #16304d;
  border-left: 1px solid rgba(255, 255, 255, .14);
  font-size: 10.5px;
  letter-spacing: .4px;
}
#um-list-area .dn-table thead .um-grup th.is-kosong { background: #1e3a5f; border-left: 0; }
#um-list-area .dn-table td.um-batas,
#um-list-area .dn-table th.um-batas { border-left: 1px solid #e2e8f0; }

/* Baris jumlah di kaki tabel. */
#um-list-area .dn-table tfoot td {
  background: #f8fafc; font-weight: 700; color: #0f172a; border-top: 2px solid #e2e8f0;
}
#um-list-area .dn-table tfoot td.dn-angka { text-align: right; font-variant-numeric: tabular-nums; }
#um-list-area .dn-table tfoot .um-total-label {
  font-size: 13.5px; font-weight: 700; letter-spacing: .3px;
  text-transform: uppercase; color: #0f172a;
}
#um-list-area .dn-table tfoot td:first-child { text-align: center; }
</style>

<div class="content-wrapper nag-skin ci-sm">
  <section class="content">
    <div class="container-fluid">

      <!-- Filter -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-wallet"></i><?= $title; ?></h3>
        </div>
        <div class="card-body">
          <div class="row align-items-end um-filter">
            <div class="form-group col-lg-3 col-md-6 um-f-coa">
              <label for="coa_um">COA</label>
              <select class="form-control select2bs4" id="coa_um" name="coa_um">
                <option value="all_coa">All COA</option>
                <?php foreach ((array) $coa_um as $c) : ?>
                  <option value="<?= $c['no_coa']; ?>"><?= $c['no_coa'] . ' - ' . $c['nama_coa']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-3 col-md-6 um-f-customer">
              <label for="customer">Customer</label>
              <select class="form-control select2bs4" id="customer" name="customer">
                <option value="all_customer">All Customer</option>
                <?php foreach ((array) $customer as $cs) : ?>
                  <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-lg-2 col-md-3 col-6 um-f-tgl">
              <label for="filter_from">From</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_from" id="filter_from" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off" placeholder="all">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-3 col-6 um-f-tgl">
              <label for="filter_to">To</label>
              <div class="input-group dn-date-group">
                <input type="text" name="filter_to" id="filter_to" class="form-control tanggal" value="<?= date('Y-m-d'); ?>" autocomplete="off" placeholder="all">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="form-group col-12 um-f-aksi">
              <div class="dn-filter-aksi um-aksi">
                <button type="button" id="find_um" name="find_um" class="btn btn-primary" onclick="um_cari()"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-dn-excel" onclick="um_export()"><i class="fas fa-file-excel"></i> Export</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Isi laporan -->
      <div class="card">
        <div class="card-body">
          <div class="table-header">
            <span class="table-title"><i class="fas fa-table"></i>Data Uang Muka Penjualan</span>
          </div>
          <div class="dn-list-area" id="um-list-area">
            <div class="nag-loader-overlay" id="um-list-loader">
              <div class="nag-loader-card">
                <div class="nag-loader-spinner">
                  <span class="nag-loader-ring nag-loader-ring-outer"></span>
                  <span class="nag-loader-ring nag-loader-ring-inner"></span>
                  <span class="nag-loader-brand">NAG</span>
                </div>
                <div class="nag-loader-caption">Loading data...</div>
              </div>
            </div>
            <table id="table-uang-muka" class="dn-table text-nowrap" width="100%">
              <thead>
                <tr class="um-grup">
                  <th rowspan="2" class="is-kosong">Coa Number</th>
                  <th rowspan="2" class="is-kosong">Coa Name</th>
                  <th rowspan="2" class="is-kosong">Profit Center</th>
                  <th rowspan="2" class="is-kosong um-batas">PI No</th>
                  <th rowspan="2" class="is-kosong">PI Date</th>
                  <th rowspan="2" class="is-kosong">BM No</th>
                  <th rowspan="2" class="is-kosong">BM Date</th>
                  <th rowspan="2" class="is-kosong">Allocation No</th>
                  <th rowspan="2" class="is-kosong">Allocation Date</th>
                  <th rowspan="2" class="is-kosong um-batas">Customer Name</th>
                  <th rowspan="2" class="is-kosong">Payer</th>
                  <th colspan="3" class="g-beg">Beginning Balance</th>
                  <th colspan="2" class="g-add">Addition</th>
                  <th colspan="3" class="g-dedi">Deduction - Invoice</th>
                  <th colspan="3" class="g-dedm">Deduction - Memorial</th>
                  <th colspan="2" class="g-end">Ending Balance</th>
                  <th colspan="7" class="g-age">Aging</th>
                </tr>
                <tr>
                  <th class="um-batas dn-tengah">Currency</th>
                  <th class="dn-angka">Amount</th>
                  <th class="dn-angka">Eqv IDR</th>
                  <th class="um-batas dn-angka">Amount</th>
                  <th class="dn-angka">Eqv IDR</th>
                  <th class="um-batas">Doc No</th>
                  <th class="dn-angka">Amount</th>
                  <th class="dn-angka">Eqv IDR</th>
                  <th class="um-batas">Doc No</th>
                  <th class="dn-angka">Amount</th>
                  <th class="dn-angka">Eqv IDR</th>
                  <th class="um-batas dn-angka">Amount</th>
                  <th class="dn-angka">Eqv IDR</th>
                  <th class="um-batas dn-angka">1-30</th>
                  <th class="dn-angka">31-60</th>
                  <th class="dn-angka">61-90</th>
                  <th class="dn-angka">91-120</th>
                  <th class="dn-angka">121-180</th>
                  <th class="dn-angka">181-360</th>
                  <th class="dn-angka">&gt; 360</th>
                </tr>
              </thead>
              <tbody></tbody>
              <!-- Jumlah per mata uang - diisi um_cari() dari angka yang dihitung
                   server, jadi tidak mungkin beda dengan isinya. -->
              <tfoot id="um-total"></tfoot>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Rincian satu dokumen: jurnal, alokasi & pemakaiannya. Isinya diambil
     dari arnag/dokumen_uang_muka_json waktu nomornya diklik. -->
<div class="modal fade nag-skin ci-sm" id="modal-um-dok" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-file-invoice-dollar mr-2"></i>Document Detail
          &mdash; <span id="um-dok-no"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="um-dok-isi"></div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $(function () {
      // Tabelnya disiapkan sejak halaman dibuka: kotak Search, pilihan jumlah
      // baris, dan pesan "belum ada data" sudah ada sebelum Search ditekan.
      um_dt();
    });
  });
</script>
