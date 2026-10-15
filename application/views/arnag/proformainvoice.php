<?php $this->load->view('arnag/dn_skin'); ?>
<style type="text/css">
/* ===== Proforma Invoice: skin Add SO ===== */
/* Ukuran "sm" - sama dengan layar Create Invoice. !important dipakai karena
   templates/header.php mengunci tinggi & font .form-control/.btn global. */
.ci-sm .form-control,
.ci-sm .select2-container .select2-selection--single,
.ci-sm .input-group-text,
.ci-sm .btn {
  height: 31px !important;
  font-size: 12.5px !important;
  border-radius: 6px !important;
}
.ci-sm .form-control { padding: 3px 10px !important; }
.ci-sm .btn { padding: 0 12px !important; }
/* Baris tombol simpan - sama dengan layar Create Invoice. Dua aturan ini
   bekerja berpasangan: yang .nag-skin mengatur tata letak & lebar minimum,
   yang .ci-sm mengecilkan tingginya (dan menang karena !important). */
.nag-skin .ci-save-bar { display: flex; justify-content: flex-end; gap: 8px; }
.nag-skin .ci-save-bar .btn { min-width: 120px; height: 40px; padding: 0 22px !important; font-size: 14px; }
/* Tombol Back itu tag <a>, bukan <button> - teksnya tidak otomatis
   ketengah waktu tingginya dipatok, jadi kelihatan menggantung di atas.
   Dibuat flex supaya ikon & teksnya rata tengah seperti tombol lain. */
.nag-skin .ci-save-bar .btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  line-height: 1;
}
.ci-sm .ci-save-bar .btn { height: 31px !important; font-size: 12.5px !important; padding: 0 16px !important; }
.ci-sm .btn i { font-size: 11.5px; }
/* select2 dirender sebagai <span>, bukan <input> - tingginya tidak ikut
   .form-control, jadi harus diatur sendiri. Tanpa ini kotak select kelihatan
   lebih jangkung daripada isian di sebelahnya. */
.ci-sm .select2-container .select2-selection--single .select2-selection__rendered {
  line-height: 29px;
  padding-left: 10px;
  font-size: 12.5px;
}
.ci-sm .select2-container .select2-selection--single .select2-selection__arrow { height: 29px; }
/* Isi dropdown-nya ikut mengecil. Dropdown select2 dititipkan ke <body>, jadi
   tidak bisa dibatasi ke .ci-sm. */
.select2-container--bootstrap4 .select2-results__option,
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field { font-size: 12.5px; }

.nag-skin .ci-table-wrap {
  position: relative;
  overflow: auto;
  border: 1px solid #eef2f7;
  border-radius: 10px;
}
.nag-skin .ci-table-wrap::-webkit-scrollbar { width: 12px; height: 12px; }
.nag-skin .ci-table-wrap::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 8px; }
.nag-skin .ci-table-wrap::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 8px; }

/* Baris grup vs baris rinciannya. Rincian sengaja dibuat lebih redup dan
   menjorok, supaya sekilas kelihatan mana induk mana anak. */
.nag-skin .dn-table tr.pi-grup.is-pilih > td { background: #eff6ff; }
.nag-skin .dn-table tr.pi-rinci > td {
  background: #fafbfc;
  font-size: 11.5px;
  color: #64748b;
  border-top: 0;
}
.nag-skin .dn-table tr.pi-rinci td.pi-rinci-produk { padding-left: 22px; }
.nag-skin .dn-table .pi-buka {
  padding: 0 4px;
  font-size: 11.5px;
  color: #475569;
  text-decoration: none;
}
.nag-skin .dn-table .pi-buka:hover { color: #1d4ed8; }

/* Dua kartu atas dibuat sama tinggi biar sejajar - sama seperti Create
   Invoice. Tanpa ini kartu kanan berhenti lebih pendek karena isiannya
   lebih sedikit. */
.nag-skin .ci-baris-atas > [class*="col-"] { display: flex; }
.nag-skin .ci-baris-atas > [class*="col-"] > .card { flex: 1; }
/* Baris isian terakhir didorong ke bawah supaya kedua kartu rata bawahnya
   tanpa ada ruang kosong menganga di tengah. */
.nag-skin .ci-baris-atas .card-body { display: flex; flex-direction: column; }
.nag-skin .ci-baris-atas .card-body > .row:last-child { margin-top: auto; }

.nag-skin .pi-so-kaki { display: flex; align-items: baseline; gap: 14px; }
.nag-skin .pi-so-total { font-size: 13px; color: #334155; }
.nag-skin .pi-so-total b { font-size: 15px; color: #1e3a5f; }

/* ===== Dialog Swal =====
   Gayanya disamakan dengan layar Create Invoice. Dipasang ke .swal2-popup
   langsung - BUKAN lewat kelas tambahan - karena dialognya banyak yang
   dipanggil dari crud-nag.js yang dipakai bareng layar lain. Berkas gaya
   ini cuma dimuat di layar Proforma Invoice, jadi yang kena ya dialog di
   layar ini saja. Popup-nya ditempel ke <body>, di luar .nag-skin, jadi
   tidak boleh ikut di-scope ke situ. */
.swal2-popup { border-radius: 14px; }
.swal2-popup .swal2-title { color: #1e3a5f; font-size: 19px; }
.swal2-popup .swal2-html-container { font-size: 13.5px; }
.swal2-popup .swal2-icon.swal2-question { border-color: #1e3a5f !important; color: #1e3a5f !important; }
/* Tombol dialog dibuat seragam - tingginya sama, tidak ada yang lebih besar
   sendiri, dan ukurannya mengikuti tombol "sm" di layar. */
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

/* Kepala tabel menempel waktu isinya di-scroll - tanpa ini, begitu barisnya
   banyak nama kolomnya hilang dari pandangan. */
.nag-skin .ci-table-wrap thead th {
  position: sticky;
  top: 0;
  z-index: 2;
}

/* Pilihan Local / Export. Yang sedang dipilih diberi warna penuh, yang lain
   dibiarkan pucat - dengan ikon saja user sulit membedakannya. */
.nag-skin .pi-shipp { display: flex; gap: 6px; }
.nag-skin .pi-shipp .btn {
  flex: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  border: 1px solid #cbd5e1;
  background: #f8fafc;
  color: #64748b;
  font-weight: 600;
}
.nag-skin .pi-shipp .btn:hover { background: #eef2f7; color: #334155; }
.nag-skin .pi-shipp #prof_L.is-aktif {
  border-color: #15803d; background: #15803d; color: #fff;
}
.nag-skin .pi-shipp #prof_E.is-aktif {
  border-color: #0369a1; background: #0369a1; color: #fff;
}

.nag-skin .ci-cari { position: relative; width: 100%; }
.nag-skin .ci-cari .form-control { padding-left: 30px !important; }
.nag-skin .ci-cari i {
  position: absolute; top: 50%; left: 10px; transform: translateY(-50%);
  color: #94a3b8; font-size: 11.5px; pointer-events: none;
}

.ci-sm .input-group > .select2-container { flex: 1 1 auto; width: 1% !important; }
.ci-sm .input-group > .select2-container .select2-selection--single { border-radius: 0 6px 6px 0 !important; }
.ci-sm .input-group > .select2-container:not(:last-child) .select2-selection--single { border-radius: 0 !important; }

/* Lebar modal Add SO mengikuti modal-xl bawaan - sama dengan modal Add SO di
   Create Invoice. Nama produk yang kepanjangan diurus scroll mendatar di
   dalam tabelnya, bukan dengan melebarkan modalnya. */
</style>
 <!-- Content Wrapper. Contains page content -->
 <!-- ==========================================================================
      Proforma Invoice.
      Tampilannya mengikuti menu Create Invoice (skin .nag-skin di dn_skin.php).

      Nama & id isiannya SENGAJA dipertahankan sama dengan layar lama -
      crud-nag.js masih yang mengurus nomor PI, TOP, diskon, PPN, DP, hitungan
      total, dan seluruh alur Save. Yang diganti cuma tampilannya dan cara
      memilih SO (lihat modal Add SO + crud-proforma-invoice.js).
      ========================================================================== -->
 <div class="content-wrapper nag-skin ci-sm">
   <section class="content">
     <div class="container-fluid">

       <!-- ===== Kepala proforma ===== -->
       <div class="row ci-baris-atas">
         <div class="col-lg-6">
           <div class="card">
             <div class="card-header">
               <h3 class="card-title"><i class="fas fa-file-invoice"></i>Proforma Invoice</h3>
             </div>
             <div class="card-body">
               <div class="row">
                 <div class="form-group col-sm-6">
                   <label for="prof_inv_number">Proforma Number</label>
                   <input type="text" class="form-control" id="prof_inv_number" name="prof_inv_number" value="<?= $kode_proforma_invoice; ?>" readonly required>
                 </div>
                 <div class="form-group col-sm-6">
                   <label for="prof_customer">Customer</label>
                   <select class="form-control select2bs4" id="prof_customer" name="prof_customer">
                     <?php foreach ($customer as $cs) : ?>
                       <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                     <?php endforeach; ?>
                   </select>
                 </div>
               </div>

               <div class="row">
                 <div class="form-group col-sm-6">
                   <label for="prof_shipp">Shipp</label>
                   <!-- Nomor PI-nya ikut Local / Export - get_kode_proforma_invoice()
                        di crud-nag.js yang mengisinya. -->
                   <!-- Dua pilihan saja, jadi dibuat tombol - bukan dropdown.
                        Tulisannya ikut tampil (ikon saja sulit dibedakan), dan
                        yang sedang dipilih ditebalkan lewat kelas .is-aktif.
                        Nilainya tetap masuk ke #prof_shipp: itu yang dibaca
                        waktu simpan, diisi handler di templates/footer.php. -->
                   <div class="pi-shipp" id="pi-shipp">
                     <button id="prof_L" name="prof_L" type="button" class="btn" onclick="get_kode_proforma_invoice('L')"><i class="fas fa-truck"></i> Local</button>
                     <button id="prof_E" name="prof_E" type="button" class="btn" onclick="get_kode_proforma_invoice('E')"><i class="fas fa-plane"></i> Export</button>
                     <input type="hidden" id="prof_shipp" name="prof_shipp" required>
                   </div>
                 </div>
                 <div class="form-group col-sm-6">
                   <label for="prof_peb">PEB</label>
                   <input type="text" class="form-control" id="prof_peb" name="prof_peb" autocomplete="off">
                 </div>
               </div>

               <div class="row">
                 <div class="form-group col-sm-6">
                   <label for="prof_type">Invoice Type</label>
                   <select id="prof_type" name="prof_type" class="form-control select2bs4" required>
                     <?php foreach ($type as $t) : ?>
                       <option value="<?= $t['id_type']; ?>"><?= $t['type']; ?></option>
                     <?php endforeach; ?>
                   </select>
                 </div>
                 <div class="form-group col-sm-6">
                   <label for="prof_material_type">Material Type</label>
                   <select id="prof_material_type" name="prof_material_type" class="form-control select2bs4" required>
                     <option value="Barang Jadi">Barang Jadi</option>
                     <option value="Non Barang Jadi">Non Barang Jadi</option>
                   </select>
                 </div>
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
                   <label for="prof_top">TOP Type</label>
                   <div class="input-group">
                     <input type="text" class="form-control" id="prof_top" name="prof_top" placeholder="Pick a term of payment" readonly required>
                     <div class="input-group-append">
                       <button type="button" id="prof_find_top" name="prof_find_top" class="btn btn-info" data-toggle="modal" data-target="#modal-add-prof-top" title="Search term of payment"><i class="fas fa-search"></i></button>
                     </div>
                   </div>
                   <input type="hidden" id="prof_id_top" name="prof_id_top">
                 </div>
                 <div class="form-group col-sm-6">
                   <label for="prof_top_time">Time Period</label>
                   <input type="text" class="form-control" id="prof_top_time" name="prof_top_time" readonly required>
                 </div>
               </div>

               <div class="row">
                 <div class="form-group col-sm-12">
                   <label for="id_bank_prof">Bank</label>
                   <select class="form-control select2bs4" id="id_bank_prof" name="id_bank_prof" required>
                     <?php foreach ($isi_bank as $bk) : ?>
                       <option value="<?= $bk['id']; ?>"><?= $bk['nama_bank']; ?> (<?= $bk['no_rek']; ?>)</option>
                     <?php endforeach; ?>
                   </select>
                 </div>
               </div>

               <div class="row">
                 <div class="form-group col-sm-6 mb-0">
                   <label for="type_so_prof">Type SO</label>
                   <select class="form-control select2bs4" id="type_so_prof" name="type_so_prof" required>
                     <option value="FOB">FOB</option>
                     <option value="CMT">CMT</option>
                   </select>
                 </div>
                 <div class="form-group col-sm-6 mb-0">
                   <label>SO</label>
                   <div>
                     <!-- add_id_for_proforma_inv() mengosongkan pilihan sebelumnya
                          dulu - satu sesi Add SO menggantikan isi tabel di bawah. -->
                     <button id="prof_so_number2" name="prof_so_number2" type="button" class="btn btn-primary" data-toggle="modal" data-target="#pi-modal-so" onclick="add_id_for_proforma_inv()"><i class="fas fa-plus"></i> Add SO</button>
                   </div>
                   <input type="hidden" id="prof_so_number1" name="prof_so_number1">
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>

       <!-- ===== Data SO =====
            Satu kartu saja. Yang ditampilkan rinciannya - itu yang benar-benar
            tersimpan dan yang tercetak di PDF, satu baris per warna & size.

            Tabel ringkasan per SO di bawah ini TIDAK ditampilkan, tapi tetap
            ada di halaman: alur simpan lama (simpan_proforma_invoice_detail di
            crud-nag.js) membaca barisnya langsung dari tabel ini. Kalau
            dihapus, baris per SO-nya tidak ikut tersimpan. -->
       <div class="card">
         <div class="card-body">
           <div class="table-header">
             <span class="table-title"><i class="fas fa-layer-group"></i>Data SO</span>
           </div>
           <div hidden>
             <table id="table-proforma-invoice" class="dn-table text-nowrap" style="width:100%">
               <thead>
                 <tr>
                   <th>ID</th>
                   <th>SO Number</th>
                   <th>SO Date</th>
                   <th>Buyer Number</th>
                   <th>Curr</th>
                   <th class="text-right">Qty</th>
                   <th class="text-right">Unit Price</th>
                   <th class="text-right">Total Price</th>
                 </tr>
               </thead>
               <tbody></tbody>
             </table>
           </div>
           <div class="ci-table-wrap" style="max-height:min(50vh,420px)">
             <table id="table-proforma-sodet" class="dn-table text-nowrap" style="width:100%">
               <thead>
                 <tr>
                   <th>ID</th>
                   <th>SO Number</th>
                   <th>Product</th>
                   <th>Curr</th>
                   <th class="text-right">QTY</th>
                   <th>UOM</th>
                   <th class="text-right">Unit Price</th>
                   <th class="text-right">Price</th>
                 </tr>
               </thead>
               <tbody></tbody>
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
               <!-- Nilai SO sebelum diskon. Begitu Discount diisi, Total
                    Without Tax langsung ikut turun - angka ini yang jadi
                    pegangan berapa aslinya. Diisi sum_grandtotal_proforma()
                    bersamaan dengan angka lainnya. -->
               <div class="form-group row ci-sum-row">
                 <label class="col-sm-5 col-form-label">Total (SO)</label>
                 <div class="col-sm-7">
                   <input type="text" class="form-control text-right" id="prof_total_so_h" name="prof_total_so_h" placeholder="0.00" readonly>
                 </div>
               </div>
               <hr class="mt-0">
               <!-- Diskon & PPN ditaruh di sini: dua-duanya yang mengubah angka
                    di bawahnya, jadi lebih mudah dibaca kalau berdekatan. -->
               <div class="form-group row">
                 <label for="prof_diskon" class="col-sm-5 col-form-label">Discount</label>
                 <div class="col-sm-7">
                   <div class="input-group">
                     <input type="text" class="form-control text-right" id="prof_diskon" name="prof_diskon" oninput="input_diskon_proforma()" placeholder="0.00">
                     <select class="form-control select2bs4" id="pilih_diskn_prof" name="pilih_diskn_prof" onchange="ganti_diskon(this.value)" required>
                       <option value="%">%</option>
                       <option value="Amount">Amount</option>
                     </select>
                   </div>
                 </div>
               </div>
               <div class="form-group row">
                 <label for="id_ppn_prof" class="col-sm-5 col-form-label">VAT</label>
                 <div class="col-sm-7">
                   <select class="form-control select2bs4" id="id_ppn_prof" name="id_ppn_prof" onchange="hitung_ppn(this.value)" required>
                     <option value="0">Non PPN</option>
                     <?php foreach ($isi_ppn as $ppn) : ?>
                       <option value="<?= $ppn['percentage']; ?>"><?= $ppn['kriteria2']; ?></option>
                     <?php endforeach; ?>
                   </select>
                 </div>
               </div>
               <hr class="mt-0">
               <div class="form-group row ci-sum-row">
                 <label class="col-sm-5 col-form-label">Total Without Tax</label>
                 <div class="col-sm-7">
                   <input type="hidden" id="prof_twot" name="prof_twot">
                   <input type="hidden" id="prof_twot2" name="prof_twot2">
                   <input type="text" class="form-control text-right" id="prof_twot_h" name="prof_twot_h" placeholder="0.00" readonly>
                 </div>
               </div>
               <div class="form-group row ci-sum-row">
                 <label class="col-sm-5 col-form-label">Taxes</label>
                 <div class="col-sm-7">
                   <input type="hidden" id="prof_taxes" name="prof_taxes">
                   <input type="text" class="form-control text-right" id="prof_taxes_h" name="prof_taxes_h" placeholder="0.00" readonly>
                 </div>
               </div>
               <div class="form-group row ci-sum-row is-grand">
                 <label class="col-sm-5 col-form-label">Grand Total</label>
                 <div class="col-sm-7">
                   <input type="hidden" id="prof_grandtotal" name="prof_grandtotal">
                   <input type="text" class="form-control text-right" id="prof_grandtotal_h" name="prof_grandtotal_h" placeholder="0.00" readonly>
                 </div>
               </div>
               <div class="form-group row mb-0">
                 <label class="col-sm-5 col-form-label">
                   <div class="custom-control custom-checkbox">
                     <input class="custom-control-input" type="checkbox" id="prof_check_dp" name="prof_check_dp" onclick="check_dp(this)">
                     <label for="prof_check_dp" class="custom-control-label">DP Max 75%</label>
                   </div>
                 </label>
                 <div class="col-sm-7">
                   <div class="input-group">
                     <input type="text" class="form-control text-right" id="prof_dp" name="prof_dp" placeholder="0.00" readonly onkeypress="javascript:return isNumber(event)" oninput="input_dp_proforma_invoice()">
                     <input type="text" class="form-control text-right" id="prof_dp_h" name="prof_dp_h" placeholder="0.00" readonly>
                   </div>
                 </div>
               </div>
             </div>
             <div class="card-footer ci-save-bar">
               <a href="<?= base_url('arnag/listproformainvoice'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Back</a>
               <button type="button" class="btn btn-primary" onclick="add_data_proforma_invoice()"><i class="fa fa-save"></i> Save</button>
             </div>
           </div>
         </div>
       </div>

     </div>
   </section>
 </div>

 <!-- Modal Add TOP -->
 <!-- Modal Add TOP - skinnya disamakan dengan modal Add SO. Isi tabelnya
      tetap digambar cari_prof_top() di crud-nag.js, jadi susunan & urutan
      kolomnya tidak boleh berubah. -->
 <div class="modal fade dn-modal nag-skin ci-sm" id="modal-add-prof-top" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title"><i class="fas fa-hand-holding-usd"></i> Add TOP</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <div class="ci-table-wrap" style="max-height:min(55vh,420px);overflow:auto">
                     <table id="tbl_prof_top" class="dn-table text-nowrap" style="width:100%">
                         <thead>
                             <tr>
                                 <th style="width:70px" class="dn-tengah">Action</th>
                                 <th>Customer</th>
                                 <th>Type</th>
                                 <th class="text-right" style="width:60px">Top</th>
                                 <th>Status</th>
                                 <th>ID</th>
                             </tr>
                         </thead>
                         <tbody></tbody>
                     </table>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
             </div>
         </div>
     </div>
     <!-- /.modal-dialog -->
 </div>

 <!-- Modal Add SO -->
 <!-- ===================== Modal Add SO =====================
      SATU tabel. Barisnya diringkas per SO + produk + HARGA - harga ikut jadi
      kunci karena satu produk bisa beda harga antar warna, dan yang begitu
      tidak boleh disatukan. Grupnya bisa dibuka (tanda segitiga) kalau ada
      warna/size yang perlu dilepas.

      Yang dikirim waktu Add Data tetap per so_det, lewat endpoint yang sama
      dengan layar lama - jadi isi database & cetakan PDF-nya tidak berubah.
      Lihat crud-proforma-invoice.js. -->
 <div class="modal fade dn-modal nag-skin ci-sm" id="pi-modal-so" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title"><i class="fas fa-file-invoice"></i> Add SO</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <div class="row align-items-end mb-2">
                     <div class="form-group col-md-4 mb-2">
                         <label>Customer</label>
                         <!-- Ikut customer yang dipilih di layar - SO yang boleh
                              ditarik memang cuma milik customer itu. Diisi JS
                              waktu modalnya dibuka. -->
                         <input type="text" class="form-control" id="pi-f-cust" readonly>
                     </div>
                     <div class="form-group col-md-2 mb-2">
                         <label>From</label>
                         <input type="text" class="form-control tanggal" id="pi-f-from" value="<?php echo date('Y-m-01'); ?>" autocomplete="off">
                     </div>
                     <div class="form-group col-md-2 mb-2">
                         <label>To</label>
                         <input type="text" class="form-control tanggal" id="pi-f-to" value="<?php echo date('Y-m-d'); ?>" autocomplete="off">
                     </div>
                     <div class="form-group col-md-auto mb-2">
                         <!-- Tombolnya selebar isinya saja - btn-block bikin
                              memanjang sampai ujung kolom. -->
                         <button type="button" class="btn btn-primary" id="pi-f-cari"><i class="fas fa-search"></i> Search</button>
                     </div>
                     <div class="form-group col-md-3 mb-2">
                         <label>Search</label>
                         <div class="ci-cari"><i class="fas fa-search"></i>
                             <input type="text" class="form-control" id="pi-f-filter" placeholder="SO number / product..." autocomplete="off">
                         </div>
                     </div>
                     <div class="form-group col mb-2 text-right">
                         <small class="text-muted" id="pi-so-info"></small>
                     </div>
                     <!-- Tipe PI: kosong = PI biasa (penanda so_det.no_pi),
                          'CBD' = Proforma DP/CBD (no_pi_cbd). -->
                     <input type="hidden" id="pi-tipe-pi" value="">
                 </div>

                 <div class="ci-table-wrap" style="max-height:min(55vh,440px);overflow:auto">
                     <table class="dn-table text-nowrap" style="width:100%">
                         <thead>
                             <tr>
                                 <th style="width:40px" class="dn-tengah"><input type="checkbox" id="pi-so-pilih-semua"></th>
                                 <th style="width:64px" class="dn-tengah">Lines</th>
                                 <th>SO Number</th>
                                 <th>SO Date</th>
                                 <th>Product</th>
                                 <th class="dn-tengah">Curr</th>
                                 <th class="text-right">Qty</th>
                                 <th class="text-right">Unit Price</th>
                                 <th class="text-right">Total Price</th>
                             </tr>
                         </thead>
                         <tbody id="pi-so-tbody">
                             <tr><td colspan="9" class="text-center text-muted py-4">Pick a date range, then press Search.</td></tr>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="modal-footer justify-content-between">
                 <div class="pi-so-kaki">
                     <small class="text-muted" id="pi-so-terpilih">0 rows</small>
                     <!-- Nilai baris yang dicentang - supaya kelihatan berapa
                          yang akan ditambahkan sebelum menekan Add Data. -->
                     <span class="pi-so-total">Total <b id="pi-so-total">0.00</b></span>
                 </div>
                 <div>
                     <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                     <button type="button" class="btn btn-primary" id="pi-so-tambah" disabled><i class="fas fa-plus"></i> Add Data</button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Simpan Proforma Invoice -->
 <!-- Dua penolong ini dipakai langsung oleh atribut di layar:
      check_dp()  - centang "DP Max 75%" membuka/mengunci kotak DP
      isNumber()  - kotak DP hanya menerima angka
      Isinya sama persis dengan layar sebelumnya. -->
 <script>
     function check_dp(checkboxElem) {
         if (checkboxElem.checked) {
             $("#prof_dp").prop("readonly", false);
             $("#prof_dp").val("");
         } else {
             $("#prof_dp").prop("readonly", true);
             $("#prof_dp").val("0.00");
         }
     }

     function isNumber(evt) {
         var iKeyCode = (evt.which) ? evt.which : evt.keyCode
         if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
             return false;
         return true;
     }
 </script>

<script>
  // Alamat dasar controller - dipakai crud-proforma-invoice.js. Ditulis
  // di sini karena base_url() itu fungsi PHP, bukan variabel JS.
  var CI_URL = <?= json_encode(base_url('arnag/')); ?>;
</script>

<script defer src="<?= base_url('assets/build/js/crud/crud-proforma-invoice.js'); ?>?v=<?= @filemtime(FCPATH . 'assets/build/js/crud/crud-proforma-invoice.js'); ?>"></script>
