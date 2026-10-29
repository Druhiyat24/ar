<?php
// Modal detail Alokasi - dipakai layar daftar Alokasi (nomornya diklik).
// Isinya diambil alo_detail_buka() di crud-nag.js lewat arnag/alokasi_detail_json.
// Halaman yang memakainya cukup:
//   $this->load->view('arnag/alo_detail_modal')
// dan pastikan pembungkusnya ber-class .nag-skin.
//
// Modal lama (#modal-view-kwt) sengaja dibiarkan - layar lain masih memanggil
// cari_view_alokasi() untuk mengisinya.
?>
<style type="text/css">
/* ===== Modal detail Alokasi ===== */
#modal-alo-detail .modal-header { align-items: center; }
#modal-alo-detail .modal-title { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
#modal-alo-detail .modal-title .dn-badge { font-size: 10.5px; }
#modal-alo-detail .modal-body { background: #f8fafc; }

.nag-skin .alo-d-loader { padding: 44px 0; text-align: center; color: #64748b; }
.nag-skin .alo-d-loader .nag-loader-spinner { margin: 0 auto 10px; }

/* ---- Kepala: dari siapa uangnya, dan berapa ---- */
.nag-skin .alo-d-atas {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 28px;
  padding: 14px 16px;
  background: #fff;
  border: 1px solid #eef2f7;
  border-radius: 10px;
}
.nag-skin .alo-d-label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 3px;
}
.nag-skin .alo-d-nama { font-size: 15px; font-weight: 700; line-height: 1.3; color: #0f172a; }
.nag-skin .alo-d-kecil { margin-top: 3px; font-size: 11.5px; color: #94a3b8; }
.nag-skin .alo-d-uang { flex: 0 0 auto; text-align: right; }
.nag-skin .alo-d-jumlah {
  font-size: 22px;
  font-weight: 700;
  line-height: 1.15;
  color: #0f172a;
  font-variant-numeric: tabular-nums;
}

/* ---- Keterangan pendek: semuanya seukuran, jadi barisnya rata ---- */
.nag-skin .alo-d-fakta {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 1px;
  margin-top: 12px;
  background: #eef2f7;
  border: 1px solid #eef2f7;
  border-radius: 10px;
  overflow: hidden;
}
.nag-skin .alo-d-fakta > div { padding: 9px 12px; background: #fff; min-width: 0; }
.nag-skin .alo-d-fakta .alo-d-isi {
  font-size: 12.5px;
  font-weight: 600;
  color: #1e293b;
  overflow-wrap: anywhere;
}
.nag-skin .alo-d-fakta .alo-d-isi.is-angka { font-variant-numeric: tabular-nums; }
.nag-skin .alo-d-fakta .alo-d-isi.is-sisa { color: #b45309; }
.nag-skin .alo-d-fakta .alo-d-isi.is-lunas { color: #15803d; }
@media (max-width: 991px) { .nag-skin .alo-d-fakta { grid-template-columns: repeat(2, minmax(0, 1fr)); } }

/* ---- Dua tabel di bawahnya ---- */
.nag-skin .alo-d-bagian { margin-top: 16px; }
.nag-skin .alo-d-bagian .table-header { margin-bottom: 8px; }
.nag-skin .alo-d-bagian .ci-table-wrap { background: #fff; max-height: 260px; }
.nag-skin .alo-d-bagian .dn-table td { font-size: 12px; }
/* Kolom angka rata kanan & sejajar digitnya. */
.nag-skin #table-alo-detail td:nth-child(6),
.nag-skin #table-alo-detail td:nth-child(7),
.nag-skin #table-alo-detail td:nth-child(8),
.nag-skin #table-alo-detail td:nth-child(9),
.nag-skin #table-alo-detail th:nth-child(6),
.nag-skin #table-alo-detail th:nth-child(7),
.nag-skin #table-alo-detail th:nth-child(8),
.nag-skin #table-alo-detail th:nth-child(9),
.nag-skin #table-alo-jurnal td:nth-child(6),
.nag-skin #table-alo-jurnal td:nth-child(7),
.nag-skin #table-alo-jurnal td:nth-child(8),
.nag-skin #table-alo-jurnal td:nth-child(9),
.nag-skin #table-alo-jurnal td:nth-child(10),
.nag-skin #table-alo-jurnal th:nth-child(6),
.nag-skin #table-alo-jurnal th:nth-child(7),
.nag-skin #table-alo-jurnal th:nth-child(8),
.nag-skin #table-alo-jurnal th:nth-child(9),
.nag-skin #table-alo-jurnal th:nth-child(10) {
  text-align: right;
  font-variant-numeric: tabular-nums;
}
/* Kolom terakhir kedua tabel ini berisi DATA, bukan tombol aksi. Skin DN
   mengunci kolom terakhir ke kanan - pas untuk tabel daftar yang kolom
   terakhirnya Action, tapi di sini malah mengambang menutupi kolom
   sebelahnya waktu tabelnya digeser. */
.nag-skin #table-alo-detail tbody td:last-child,
.nag-skin #table-alo-detail thead th:last-child,
.nag-skin #table-alo-jurnal tbody td:last-child,
.nag-skin #table-alo-jurnal thead th:last-child {
  position: static;
  right: auto;
  z-index: auto;
  box-shadow: none;
}

/* Baris jumlah jurnal - menempel di bawah tabelnya. */
.nag-skin #table-alo-jurnal tfoot td {
  position: sticky;
  bottom: 0;
  background: #f8fafc;
  font-weight: 700;
  border-top: 2px solid #e2e8f0;
}
/* Nilai nol ditulis redup supaya mata langsung menangkap sisi yang terisi. */
.nag-skin .alo-d-nol { color: #cbd5e1; }
.nag-skin .alo-d-kosong { padding: 26px 0; text-align: center; color: #94a3b8; font-size: 12px; }
</style>

<div class="modal fade nag-skin ci-sm" id="modal-alo-detail" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="fas fa-hand-holding-usd"></i>
          <span id="alo-d-nomor">Allocation</span>
          <span class="dn-badge" id="alo-d-status" hidden></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- Selagi datanya diambil -->
        <div class="alo-d-loader" id="alo-d-loader">
          <div class="nag-loader-spinner">
            <span class="nag-loader-ring nag-loader-ring-outer"></span>
            <span class="nag-loader-ring nag-loader-ring-inner"></span>
            <span class="nag-loader-brand">NAG</span>
          </div>
          <div>Loading allocation...</div>
        </div>

        <!-- Kalau gagal diambil -->
        <div class="alo-d-kosong" id="alo-d-gagal" hidden></div>

        <div id="alo-d-isi" hidden>
          <div class="alo-d-atas">
            <div>
              <div class="alo-d-label">Received from</div>
              <div class="alo-d-nama" id="alo-d-customer">-</div>
              <div class="alo-d-kecil" id="alo-d-doc">-</div>
            </div>
            <div class="alo-d-uang">
              <div class="alo-d-label">Bank Amount</div>
              <div class="alo-d-jumlah" id="alo-d-amount">0.00</div>
              <div class="alo-d-kecil" id="alo-d-eqv">-</div>
            </div>
          </div>

          <div class="alo-d-fakta">
            <div>
              <div class="alo-d-label">Allocation Date</div>
              <div class="alo-d-isi" id="alo-d-tanggal">-</div>
            </div>
            <div>
              <div class="alo-d-label">Bank</div>
              <div class="alo-d-isi" id="alo-d-bank">-</div>
            </div>
            <div>
              <div class="alo-d-label">Account</div>
              <div class="alo-d-isi is-angka" id="alo-d-account">-</div>
            </div>
            <div>
              <div class="alo-d-label">Currency / Rate</div>
              <div class="alo-d-isi is-angka" id="alo-d-curr">-</div>
            </div>
            <div>
              <div class="alo-d-label">Allocated</div>
              <div class="alo-d-isi is-angka" id="alo-d-dialokasikan">0.00</div>
            </div>
            <div>
              <div class="alo-d-label">Outstanding</div>
              <div class="alo-d-isi is-angka" id="alo-d-sisa">0.00</div>
            </div>
            <div>
              <div class="alo-d-label">Created By</div>
              <div class="alo-d-isi" id="alo-d-dibuat">-</div>
            </div>
            <div>
              <div class="alo-d-label">Lines</div>
              <div class="alo-d-isi is-angka" id="alo-d-jml-baris">0</div>
            </div>
          </div>

          <!-- Tagihan yang dilunasi -->
          <div class="alo-d-bagian">
            <div class="table-header">
              <span class="table-title"><i class="fas fa-list-ul"></i>Allocation Detail</span>
            </div>
            <div class="ci-table-wrap">
              <table id="table-alo-detail" class="dn-table text-nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>COA</th>
                    <th>Cost Center</th>
                    <th>Reference Number</th>
                    <th>Date</th>
                    <th>Due Date</th>
                    <th>Total</th>
                    <th>Equivalent IDR</th>
                    <th>Amount</th>
                    <th>Outstanding</th>
                    <th>Descriptions</th>
                    <th>Profit Center</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>

          <!-- Jurnal yang terbentuk -->
          <div class="alo-d-bagian">
            <div class="table-header">
              <span class="table-title"><i class="fas fa-book"></i>Journal</span>
              <div class="dn-filter-aksi">
                <span class="dn-badge" id="alo-d-imbang" hidden></span>
              </div>
            </div>
            <div class="ci-table-wrap">
              <table id="table-alo-jurnal" class="dn-table text-nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>COA</th>
                    <th>Account Name</th>
                    <th>Cost Center</th>
                    <th>Reff Doc</th>
                    <th>Curr</th>
                    <th>Rate</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Debit IDR</th>
                    <th>Credit IDR</th>
                  </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                  <tr>
                    <td colspan="6">Total</td>
                    <td id="alo-d-j-debit">0.00</td>
                    <td id="alo-d-j-kredit">0.00</td>
                    <td id="alo-d-j-debit-idr">0.00</td>
                    <td id="alo-d-j-kredit-idr">0.00</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="alo-d-cetak"><i class="fa fa-print"></i> Print</button>
      </div>
    </div>
  </div>
</div>
