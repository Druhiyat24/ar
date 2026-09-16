<?php
// Modal detail Debit Note - dipakai bareng List Debit Note dan Second
// Approval. Isinya diambil dn_list_detail() di crud-nag.js lewat
// arnag/dn_detail_json. Halaman yang memakainya cukup:
//   $this->load->view('arnag/dn_detail_modal')   <- ditulis di dalam blok PHP halaman
// dan pastikan pembungkusnya ber-class .nag-skin.
?>
<style type="text/css">
/* ===== Modal detail (nomor DN diklik) ===== */
/* Nomor DN dibikin jelas bisa diklik - ini pintu ke detailnya */
.nag-skin .dn-no-link {
  color: #1d4ed8;
  font-size: 13.5px;
  font-weight: 600;
  cursor: pointer;
  text-decoration: none;
  border-bottom: 1px dashed rgba(29, 78, 216, .45);
}
.nag-skin .dn-no-link:hover { color: #1e3a5f; border-bottom-style: solid; }

.nag-skin .dn-detail-loader { padding: 40px 0; text-align: center; color: #64748b; }
.nag-skin .dn-detail-loader .nag-loader-spinner { margin: 0 auto 10px; }

/* Ringkasan header: pasangan label - nilai, 3 kolom di layar lebar */
.nag-skin .dn-detail-info {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 10px 22px;
  margin: 0 0 18px;
}
.nag-skin .dn-detail-info > div { min-width: 0; }
.nag-skin .dn-detail-info dt {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .4px;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 2px;
}
.nag-skin .dn-detail-info dd {
  margin: 0;
  font-size: 13px;
  color: #1e293b;
  word-break: break-word;
}
.nag-skin .dn-detail-info dd.is-angka { font-variant-numeric: tabular-nums; font-weight: 600; }

.nag-skin .dn-detail-judul-bagian {
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
.nag-skin .dn-detail-judul-bagian i { color: #1e3a5f; opacity: .55; font-size: 12px; }

.nag-skin .dn-detail-tabel-wrap {
  overflow: auto;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  max-height: 320px;
}
.nag-skin .dn-detail-tabel tfoot td {
  background: #f1f5f9 !important;
  font-weight: 700;
  border-top: 2px solid #e2e8f0;
}
/* Baris dari Memo / Request ditandai, sama seperti di halaman Edit */
.nag-skin .dn-detail-tabel tbody tr.is-terkunci td:first-child { box-shadow: inset 3px 0 0 #94a3b8; }
/* Description yang dikosongkan ikut baris di atasnya - sama seperti aturan di
   PDF. Sel .dn-table di sini cuma punya border-bottom (bukan border-top), jadi
   cukup hilangkan itu di baris yang menyambung ke bawah supaya terlihat satu
   sel. Latar belang-seling (zebra) sel yang digabung disamakan dengan baris
   induknya (ganjil/genap) - !important untuk menang atas aturan zebra biasa. */
.nag-skin .dn-detail-tabel tbody td.sambung-bawah { border-bottom: none; }
.nag-skin .dn-detail-tabel tbody td.sambung-ganjil { background: #fff !important; }
.nag-skin .dn-detail-tabel tbody td.sambung-genap { background: #f8fafc !important; }


/* Penanda DN yang belum punya lampiran. Abu selagi masih POST (wajar belum
   diisi), merah setelah masuk approval (mestinya sudah ada). */
.nag-skin .dn-tanpa-doc {
  display: flex;
  align-items: center;
  gap: 5px;
  margin-top: 2px;
  opacity: .85;
  font-size: 10.5px;
  font-weight: 600;
  letter-spacing: .2px;
  color: #94a3b8;
}
.nag-skin .dn-tanpa-doc i { font-size: 10px; }
.nag-skin .dn-tanpa-doc.is-perhatian { color: #dc2626; }
/* Kolom nomor DN jadi dua baris - nomornya sendiri di atas penanda */
.nag-skin .dn-table td:first-child { white-space: normal; line-height: 1.35; }
.nag-skin .dn-table td:first-child .dn-no-link { display: inline-block; }

/* Pesan lampiran kosong di modal detail - warnanya ikut aturan yang sama */
.nag-skin .dn-att-kosong { font-size: 12.5px; font-style: italic; color: #94a3b8; opacity: .85; }
.nag-skin .dn-att-kosong.is-perhatian { color: #dc2626; font-style: normal; font-weight: 600; }

.nag-skin .dn-att-jumlah { font-size: 11px; font-weight: 600; color: #64748b; letter-spacing: 0; text-transform: none; }
.nag-skin .dn-att-list {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  list-style: none;
  margin: 0;
  padding: 0;
}
.nag-skin .dn-att-item {
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
.nag-skin .dn-att-item:hover { border-color: #2c5282; background: #f8fafc; }
.nag-skin .dn-att-item.is-aktif { border-color: #2c5282; background: #eef2f7; }
.nag-skin .dn-att-item .fa-file-pdf { color: #dc2626; }
.nag-skin .dn-att-item .fa-file-image { color: #0891b2; }
.nag-skin .dn-att-nama { max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.nag-skin .dn-att-ukuran { color: #94a3b8; font-size: 11px; white-space: nowrap; }
/* Nama COA (mastercoa_v2) di bawah kodenya - lihat Arnag::dn_detail_json(). */
.nag-skin .dn-coa-nama { display: block; margin-top: 2px; font-size: 10.5px; color: #64748b; white-space: normal; }
/* Pratinjau lampiran di dalam modal - tidak perlu pindah halaman */
.nag-skin .dn-detail-pratinjau {
  margin-top: 12px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  overflow: hidden;
}
.nag-skin .dn-detail-pratinjau-bar {
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
.nag-skin .dn-detail-pratinjau-aksi { display: flex; gap: 6px; flex: 0 0 auto; }
.nag-skin .dn-detail-pratinjau-aksi .btn { height: 30px; padding: 0 10px !important; font-size: 11.5px; box-shadow: none !important; }
.nag-skin .dn-detail-pratinjau-isi { height: 62vh; background: #f1f5f9; }
.nag-skin .dn-detail-pratinjau-isi iframe { width: 100%; height: 100%; border: 0; display: block; }
.nag-skin .dn-detail-pratinjau-isi img { max-width: 100%; max-height: 100%; display: block; margin: 0 auto; }
</style>

<!-- Detail Debit Note - dibuka waktu nomor DN diklik (dn_list_detail di crud-nag.js) -->
<div class="modal fade nag-skin" id="modal-dn-detail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-file-invoice-dollar"></i> <span id="dn-detail-judul">Debit Note</span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="dn-detail-loader" id="dn-detail-loader">
          <div class="nag-loader-spinner">
            <span class="nag-loader-ring nag-loader-ring-outer"></span>
            <span class="nag-loader-ring nag-loader-ring-inner"></span>
            <span class="nag-loader-brand">NAG</span>
          </div>
          <div class="nag-loader-caption">Memuat data...</div>
        </div>

        <div id="dn-detail-isi" hidden>
          <!-- Ringkasan header -->
          <dl class="dn-detail-info" id="dn-detail-info"></dl>

          <!-- Baris detail -->
          <div class="dn-detail-judul-bagian"><i class="fas fa-table"></i> Detail</div>
          <div class="dn-detail-tabel-wrap">
            <table class="dn-table dn-detail-tabel" id="dn-detail-tabel">
              <thead></thead>
              <tbody></tbody>
              <tfoot></tfoot>
            </table>
          </div>

          <!-- Lampiran -->
          <div class="dn-detail-judul-bagian"><i class="fas fa-paperclip"></i> Supporting Documents <span id="dn-detail-jml-lampiran" class="dn-att-jumlah"></span></div>
          <ul class="dn-att-list" id="dn-detail-lampiran"></ul>
          <!-- Pratinjau muncul setelah salah satu lampiran diklik -->
          <div class="dn-detail-pratinjau" id="dn-detail-pratinjau" hidden>
            <div class="dn-detail-pratinjau-bar">
              <span id="dn-detail-pratinjau-nama"></span>
              <span class="dn-detail-pratinjau-aksi">
                <a href="#" id="dn-detail-pratinjau-buka" target="_blank" rel="noopener" class="btn btn-light btn-sm"><i class="fas fa-external-link-alt"></i> Open in New Tab</a>
                <button type="button" class="btn btn-light btn-sm" onclick="dn_detail_tutup_pratinjau()"><i class="fas fa-times"></i> Close</button>
              </span>
            </div>
            <div class="dn-detail-pratinjau-isi" id="dn-detail-pratinjau-isi"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary" onclick="print_debit_note(DN_DETAIL_ID, DN_DETAIL_TYPE)"><i class="fa fa-print"></i> Print</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
