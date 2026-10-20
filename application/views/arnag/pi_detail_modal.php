<?php
// Modal detail Proforma Invoice - nomornya diklik di daftar atau di layar
// approval, isinya muncul tanpa pindah halaman.
//
// Bentuknya mengikuti modal detail Invoice (arnag/inv_detail_modal), tapi
// tanpa tab Documents & Journal: proforma belum punya lampiran dan belum
// menjurnal apa pun. Gayanya ditulis sendiri di sini supaya partial ini
// mandiri - layar yang memakainya tidak perlu ikut memuat modal invoice.
//
// Halaman yang memakainya cukup:
//   $this->load->view('arnag/pi_detail_modal')
// dan pastikan pembungkusnya ber-class .nag-skin.
//
// Isinya diambil pi_detail_buka() di crud-nag.js lewat arnag/proforma_detail_json.
?>
<style type="text/css">
/* ===== Modal detail Proforma Invoice ===== */
#modal-pi-detail .modal-header { align-items: center; }
#modal-pi-detail .modal-title { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

.nag-skin .pi-detail-loader { padding: 44px 0; text-align: center; color: #64748b; }
.nag-skin .pi-detail-loader .nag-loader-spinner { margin: 0 auto 10px; }

/* ---- Ringkasan kepala ----
   Di atas: yang ditagih & nilainya. Di bawah: keterangan pendek yang
   semuanya seukuran, jadi tidak ada kolom yang melompat karena alamatnya
   makan dua baris. */
.nag-skin .pi-detail-kartu {
  border: 1px solid #e3e9f2;
  border-radius: 10px;
  padding: 16px 18px;
  background: #fff;
}
.nag-skin .pi-detail-atas {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 28px;
  padding-bottom: 14px;
  margin-bottom: 14px;
  border-bottom: 1px dashed #dbe4ee;
}
.nag-skin .pi-detail-label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 4px;
}
.nag-skin .pi-detail-nama { font-size: 14px; font-weight: 700; color: #1e3a5f; }
.nag-skin .pi-detail-alamat { font-size: 12px; color: #64748b; margin-top: 3px; line-height: 1.5; }
.nag-skin .pi-detail-uang { text-align: right; white-space: nowrap; }
.nag-skin .pi-detail-jumlah { font-size: 20px; font-weight: 700; color: #0f172a; }
.nag-skin .pi-detail-tanggal { font-size: 12px; color: #64748b; margin-top: 3px; }

.nag-skin .pi-detail-info {
  display: flex;
  flex-wrap: wrap;
  gap: 14px 30px;
  margin: 0;
}
.nag-skin .pi-detail-info > div { min-width: 120px; }
.nag-skin .pi-detail-info dt {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 2px;
}
.nag-skin .pi-detail-info dd { font-size: 12.5px; color: #334155; margin: 0; }

/* ---- Baris SO ---- */
.nag-skin .pi-detail-judul-bagian {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 18px 0 10px;
  font-size: 12.5px;
  font-weight: 700;
  color: #1e3a5f;
}
.nag-skin .pi-detail-judul-bagian i { opacity: .6; font-size: 12px; }
.nag-skin .pi-detail-jml {
  font-size: 10.5px;
  font-weight: 700;
  color: #64748b;
  background: #eef2f7;
  border-radius: 999px;
  padding: 1px 8px;
}
.nag-skin .pi-detail-tabel-wrap { max-height: 320px; overflow: auto; }
.nag-skin .pi-detail-tabel { width: 100%; margin-bottom: 0; }
.nag-skin .pi-detail-tabel thead th { position: sticky; top: 0; z-index: 2; }
.nag-skin .pi-detail-kosong { padding: 26px 0; text-align: center; color: #94a3b8; font-size: 12.5px; }

/* Nomor yang bisa diklik - sama dengan List Invoice. */
.nag-skin .dn-no-link {
  color: #1d4ed8;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  text-decoration: none;
  border-bottom: 1px dashed rgba(29, 78, 216, .45);
}
.nag-skin .dn-no-link:hover { color: #1e3a5f; border-bottom-style: solid; }
.nag-skin .dn-no-link:focus-visible { outline: 0; box-shadow: 0 0 0 3px rgba(44, 82, 130, .45); border-radius: 6px; }
</style>

<div class="modal fade nag-skin" id="modal-pi-detail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="fas fa-file-invoice-dollar"></i>
          <span id="pi-detail-judul">Proforma Invoice</span>
          <span id="pi-detail-status"></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="pi-detail-loader" id="pi-detail-loader">
          <div class="nag-loader-spinner">
            <span class="nag-loader-ring nag-loader-ring-outer"></span>
            <span class="nag-loader-ring nag-loader-ring-inner"></span>
            <span class="nag-loader-brand">NAG</span>
          </div>
          <div class="nag-loader-caption">Loading proforma invoice...</div>
        </div>

        <div id="pi-detail-isi" hidden>
          <div class="pi-detail-kartu">
            <div class="pi-detail-atas">
              <div>
                <div class="pi-detail-label" id="pi-detail-label-nama">Billed To</div>
                <div class="pi-detail-nama" id="pi-detail-nama"></div>
                <div class="pi-detail-alamat" id="pi-detail-alamat"></div>
              </div>
              <div class="pi-detail-uang">
                <div class="pi-detail-label">Grand Total</div>
                <div class="pi-detail-jumlah" id="pi-detail-grand"></div>
                <div class="pi-detail-tanggal" id="pi-detail-tanggal"></div>
              </div>
            </div>
            <dl class="pi-detail-info" id="pi-detail-info"></dl>
          </div>

          <div class="pi-detail-judul-bagian">
            <i class="fas fa-list-ul"></i> SO Rows
            <span class="pi-detail-jml" id="pi-detail-jml-baris"></span>
          </div>
          <div class="pi-detail-tabel-wrap">
            <table class="dn-table pi-detail-tabel text-nowrap" id="pi-detail-tabel">
              <thead>
                <tr>
                  <th>SO Number</th>
                  <th>Product Item</th>
                  <th class="text-right">Qty</th>
                  <th>UOM</th>
                  <th class="text-right">Unit Price</th>
                  <th class="text-right">Total</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="pi-detail-kosong" id="pi-detail-kosong" hidden>No rows on this proforma invoice.</div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary" id="pi-detail-cetak">
          <i class="fa fa-print"></i> Print
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
          <i class="fas fa-times"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>
