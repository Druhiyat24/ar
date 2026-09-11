<style>
/* ===== Halaman ===== */
.content-wrapper .content-header { padding: 0; }
.content-wrapper .card { margin-bottom: 14px; }

/* ===== Card ===== */
.content-wrapper .card {
    border: 1px solid #e5e9f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
    overflow: hidden;
}
/* Navy disamakan dengan header tabel biar seragam */
.content-wrapper .card > .card-header {
    background: #1e3a5f !important;
    background-image: none !important;
    border-bottom: 0;
    display: flex;
    align-items: center;
    padding: 13px 18px;
}
.content-wrapper .card > .card-header::after { display: none; }
.content-wrapper .card > .card-header .card-title {
    color: #f8fafc;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: .3px;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 9px;
}
.content-wrapper .card > .card-header .card-title i { opacity: .75; font-size: 13px; }

/* ===== Form filter ===== */
.content-wrapper .card-body label {
    font-size: 11.5px;
    font-weight: 600;
    letter-spacing: .3px;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 6px;
}
/* Semua kontrol filter disamakan tingginya: select2, input tanggal, tombol */
.content-wrapper .card-body .form-control,
.content-wrapper .card-body .select2-container .select2-selection--single,
.content-wrapper .card-body .input-group-text,
.content-wrapper .card-body .btn {
    height: 38px;
    border-radius: 8px;
    border-color: #e2e8f0;
    font-size: 13px;
}
/* select2 defaultnya inline-block - menyisakan celah baseline di bawahnya
   sehingga kotaknya tidak sebaris dengan input tanggal. */
.content-wrapper .card-body .select2-container { display: block; width: 100% !important; }

/* Tema select2 mengunci tingginya pakai em (height: calc(1.5em + .75rem + 2px)
   !important) - karena font dikecilkan jadi 13px, kotaknya ikut menyusut dan
   tidak sebaris dengan input tanggal. Harus di-override pakai !important. */
.content-wrapper .card-body .select2-container .select2-selection--single {
    height: 38px !important;
    padding: 0;
}
.content-wrapper .card-body .select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: 12px;
    padding-right: 28px;
}
.content-wrapper .card-body .select2-container .select2-selection--single .select2-selection__arrow {
    height: 36px;
    top: 1px;
    right: 6px;
}

/* Input tanggal + tombol kalender jadi satu kesatuan */
.content-wrapper .card-body .input-group > .form-control { border-radius: 8px 0 0 8px; }
.content-wrapper .card-body .input-group-text {
    border-radius: 0 8px 8px 0;
    border-left: 0;
    background: #f8fafc;
    color: #64748b;
}
/* Warna tombol sengaja TIDAK diubah - yang dirapikan cuma jarak ikon ke teks,
   bobot huruf, dan bayangannya. Hover pakai brightness supaya warnanya tetap
   sama, hanya sedikit lebih gelap. */
.content-wrapper .card-body .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    border-color: transparent;
    font-weight: 500;
    box-shadow: 0 1px 2px rgba(15, 23, 42, .12);
}
.content-wrapper .card-body .btn i { font-size: 12.5px; }
.content-wrapper .card-body .btn:hover { filter: brightness(.93); }
.content-wrapper .card-body .btn:active { filter: brightness(.88); }

/* ===== Dropdown select2 (dilampirkan ke body, jadi tidak bisa di-scope
   ke .content-wrapper - aman karena style ini cuma dimuat di halaman ini) ===== */
.select2-container--bootstrap4 .select2-dropdown {
    border-color: #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(15, 23, 42, .12);
    overflow: hidden;
}
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 13px;
}
.select2-container--bootstrap4 .select2-search--dropdown .select2-search__field:focus {
    outline: none;
    border-color: #2c5282;
    box-shadow: 0 0 0 3px rgba(44, 82, 130, .15);
}
.select2-container--bootstrap4 .select2-results > .select2-results__options { max-height: 260px; }
.select2-container--bootstrap4 .select2-results__option {
    font-size: 13px;
    padding: 7px 12px;
    color: #1e293b;
}
/* Opsi yang sedang dipilih: abu lembut. Yang sedang disorot: navy. */
.select2-container--bootstrap4 .select2-results__option[aria-selected=true] {
    background: #eef2f7;
    color: #0f172a;
    font-weight: 600;
}
.select2-container--bootstrap4 .select2-results__option--highlighted,
.select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected],
.select2-container--bootstrap4 .select2-results__option[aria-selected=true].select2-results__option--highlighted {
    background: #1e3a5f !important;
    color: #f8fafc !important;
}
.select2-container--bootstrap4.select2-container--focus .select2-selection,
.select2-container--bootstrap4.select2-container--open .select2-selection {
    border-color: #2c5282 !important;
    box-shadow: 0 0 0 3px rgba(44, 82, 130, .15);
}

/* ===== Dropdown tanggal (bootstrap-datepicker) ===== */
.datepicker {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(15, 23, 42, .12);
    padding: 8px;
    font-size: 13px;
}
.datepicker table tr th.datepicker-switch,
.datepicker table tr th.prev,
.datepicker table tr th.next {
    color: #0f172a;
    font-weight: 600;
    border-radius: 8px;
}
.datepicker table tr th.datepicker-switch:hover,
.datepicker table tr th.prev:hover,
.datepicker table tr th.next:hover { background: #eef2f7; }
.datepicker table tr th.dow {
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .3px;
    text-transform: uppercase;
}
.datepicker table tr td.day { border-radius: 8px; color: #1e293b; }
.datepicker table tr td.day:hover { background: #eef2f7; }
.datepicker table tr td.old,
.datepicker table tr td.new { color: #cbd5e1; }
.datepicker table tr td.today,
.datepicker table tr td.today:hover {
    background: #e2e8f0 !important;
    background-image: none !important;
    color: #0f172a !important;
    font-weight: 600;
}
/* Tanggal terpilih pakai navy yang sama dengan header tabel */
.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.active,
.datepicker table tr td span.active {
    background: #1e3a5f !important;
    background-image: none !important;
    color: #fff !important;
    text-shadow: none !important;
    border-radius: 8px;
}
.datepicker table tr td span.month,
.datepicker table tr td span.year { border-radius: 8px; }
.datepicker table tr td span.month:hover,
.datepicker table tr td span.year:hover { background: #eef2f7; }

/* ===== Kontainer scroll ===== */
#proj-table-wrap {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
}
/* Scrollbar dibikin tebal & kontras - tabelnya lebar, kalau tipis/pucat
   user tidak sadar kalau masih ada kolom di kanan. */
#proj-table-wrap { scrollbar-color: #64748b #e2e8f0; scrollbar-width: auto; }
#proj-table-wrap::-webkit-scrollbar { width: 14px; height: 14px; }
#proj-table-wrap::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 8px; }
#proj-table-wrap::-webkit-scrollbar-thumb {
    background: #64748b;
    border-radius: 8px;
    border: 3px solid #e2e8f0;
}
#proj-table-wrap::-webkit-scrollbar-thumb:hover { background: #475569; }
#proj-table-wrap::-webkit-scrollbar-corner { background: #e2e8f0; }

/* ===== Tabel ===== */
#table-projection-report {
    border-collapse: separate;
    border-spacing: 0;
    width: max-content;
    font-size: 12.5px;
    color: #1e293b;
    margin: 0;
}

/* ===== Header ===== */
#table-projection-report thead th {
    position: sticky;
    top: 0;
    z-index: 40;
    background: #1e3a5f;
    color: #f8fafc;
    font-weight: 600;
    font-size: 11px;
    letter-spacing: .4px;
    text-transform: uppercase;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    padding: 9px 12px;
    border-right: 1px solid rgba(255, 255, 255, .10);
    border-bottom: 2px solid #0f2942;
}
#table-projection-report thead th.grp-recv { background: #2c5282; }
#table-projection-report thead th.sub-recv { background: #3563a0; }
#table-projection-report thead th.grp-proj { background: #0f766e; }
#table-projection-report thead th.sub-proj { background: #0d9488; }

/* Label grup membentang banyak kolom - dibuat menempel supaya tetap kebaca
   waktu digeser ke tengah rentangnya, dan tidak masuk ke area kolom beku. */
#table-projection-report thead th.grp-recv,
#table-projection-report thead th.grp-proj { text-align: left; padding-left: 0; padding-right: 0; }
#table-projection-report thead th.grp-recv > span,
#table-projection-report thead th.grp-proj > span {
    position: sticky;
    left: var(--fz-end, 640px);
    display: inline-block;
    padding: 0 12px;
}

/* Baris ke-2 header: nilai top-nya diisi fixProjHeaderRow2() setelah render */
#table-projection-report thead tr:nth-child(2) th { z-index: 39; }

/* ===== Freeze kolom — HANYA baris pertama header (baris ke-2 tidak boleh ikut) ===== */
#table-projection-report thead tr:first-child th:nth-child(1) { left: var(--fz1, 0px);     z-index: 45; }
#table-projection-report thead tr:first-child th:nth-child(2) { left: var(--fz2, 30px);   z-index: 45; }
#table-projection-report thead tr:first-child th:nth-child(3) { left: var(--fz3, 230px);  z-index: 45; }
#table-projection-report thead tr:first-child th:nth-child(4) { left: var(--fz4, 430px);  z-index: 45; }
#table-projection-report thead tr:first-child th:nth-child(4) { box-shadow: 8px 0 10px -8px rgba(15, 23, 42, .55); }

/* ===== Body ===== */
#table-projection-report tbody td {
    padding: 8px 12px;
    white-space: nowrap;
    vertical-align: middle;
    border-right: 1px solid #eef2f7;
    border-bottom: 1px solid #eef2f7;
    font-variant-numeric: tabular-nums;
}
#table-projection-report tbody tr:nth-child(odd)  td { background: #ffffff; }
#table-projection-report tbody tr:nth-child(even) td { background: #f8fafc; }
#table-projection-report tbody tr:hover td { background: #eaf2ff; }

#table-projection-report tbody td:nth-child(1) { position: sticky; left: var(--fz1, 0px);    z-index: 20; text-align: center; color: #64748b; }
#table-projection-report tbody td:nth-child(2) { position: sticky; left: var(--fz2, 30px);   z-index: 20; font-weight: 600; }
#table-projection-report tbody td:nth-child(3) { position: sticky; left: var(--fz3, 230px);  z-index: 20; }
#table-projection-report tbody td .inv-link { color: #1d4ed8; cursor: pointer; text-decoration: none; }
#table-projection-report tbody td .inv-link:hover { color: #1e3a5f; text-decoration: underline; }
#table-projection-report tbody td:nth-child(4) { position: sticky; left: var(--fz4, 430px);  z-index: 20; box-shadow: 8px 0 10px -8px rgba(15, 23, 42, .18); }

/* ===== Baris TOTAL (nempel di bawah) ===== */
#table-projection-report tfoot td {
    position: sticky;
    bottom: 0;
    z-index: 30;
    background: #1e3a5f;
    color: #f8fafc;
    font-weight: 700;
    white-space: nowrap;
    padding: 9px 12px;
    border-right: 1px solid rgba(255, 255, 255, .10);
    border-top: 2px solid #2c5282;
    font-variant-numeric: tabular-nums;
}
#table-projection-report tfoot td:nth-child(1) { left: var(--fz1, 0px);    z-index: 35; }
#table-projection-report tfoot td:nth-child(2) { left: var(--fz2, 30px);   z-index: 35; letter-spacing: .5px; }
#table-projection-report tfoot td:nth-child(3) { left: var(--fz3, 230px);  z-index: 35; }
#table-projection-report tfoot td:nth-child(4) { left: var(--fz4, 430px);  z-index: 35; box-shadow: 8px 0 10px -8px rgba(0, 0, 0, .45); }

/* ===== Mode tanpa freeze (class dipasang setProjFreezeOffsets di layar
   sempit). Header tetap nempel di atas dan TOTAL tetap nempel di bawah,
   hanya kunci ke kirinya yang dilepas. ===== */
#table-projection-report.no-freeze thead tr:first-child th:nth-child(-n+4),
#table-projection-report.no-freeze tfoot td:nth-child(-n+4) {
    left: auto;
    box-shadow: none;
}
#table-projection-report.no-freeze tbody td:nth-child(-n+4) {
    position: static;
    box-shadow: none;
}
#table-projection-report.no-freeze thead th.grp-recv > span,
#table-projection-report.no-freeze thead th.grp-proj > span { left: 0; }

#proj-table-wrap { -webkit-overflow-scrolling: touch; }

/* ===== Layar HP ===== */
@media (max-width: 767.98px) {
    /* Sisakan ruang di bawah tabel supaya halamannya sendiri tetap bisa
       digulir (inline max-height 500px hampir memenuhi layar HP). */
    #proj-table-wrap { max-height: 70vh !important; }

    /* Kotak Search (min 260px) tadinya memaksa kartu lebih lebar dari layar. */
    .table-header { flex-wrap: wrap; }
    .search-box,
    .search-box input { width: 100%; min-width: 0; }

    /* Tombol Search/Export/Save History turun ke baris baru kalau tidak muat. */
    .content-wrapper .card-body .d-flex { flex-wrap: wrap; }
}

/* Angka rata kanan (baris data & total) */
#table-projection-report tbody td[align="right"],
#table-projection-report tfoot td[align="right"] { text-align: right; }

/* ===== Modal detail invoice ===== */
.inv-head {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px 18px;
    padding: 14px 16px;
    margin-bottom: 14px;
    background: #f8fafc;
    border: 1px solid #eef2f7;
    border-radius: 10px;
}
.inv-head-item { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.inv-head-item span {
    font-size: 10.5px;
    font-weight: 600;
    letter-spacing: .3px;
    text-transform: uppercase;
    color: #64748b;
}
.inv-head-item b {
    font-size: 13px;
    color: #0f172a;
    font-variant-numeric: tabular-nums;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.inv-lines-wrap { overflow-x: auto; }
/* !important supaya lebar inline yang dipasang DataTables tidak bikin tabelnya
   menyempit di tengah modal yang lebar. */
.inv-lines { width: 100% !important; border-collapse: separate; border-spacing: 0; font-size: 12.5px; }
.inv-lines thead th {
    background: #1e3a5f;
    color: #e2e8f0;
    font-size: 10.5px;
    font-weight: 600;
    letter-spacing: .3px;
    text-transform: uppercase;
    text-align: left;
    white-space: nowrap;
    padding: 8px 10px;
}
.inv-lines tbody td {
    padding: 7px 10px;
    border-bottom: 1px solid #eef2f7;
    white-space: nowrap;
    font-variant-numeric: tabular-nums;
}
.inv-lines tbody tr:nth-child(even) td { background: #fafbfc; }
.inv-lines .num { text-align: right; }
.inv-lines .inv-empty { text-align: center; color: #64748b; padding: 22px 10px; }

/* ===== Ringkasan potongan (khusus invoice) ===== */
.inv-pot { display: flex; justify-content: flex-end; margin-top: 14px; }
.inv-pot-table {
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12.5px;
    min-width: 340px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
}
.inv-pot-table td {
    padding: 7px 12px;
    border-bottom: 1px solid #eef2f7;
    font-variant-numeric: tabular-nums;
}
.inv-pot-table tr:last-child td { border-bottom: 0; }
.inv-pot-table td:first-child { color: #475569; }
.inv-pot-table .cur { color: #64748b; text-align: center; width: 46px; }
.inv-pot-table .num { text-align: right; font-weight: 600; color: #0f172a; min-width: 140px; }
.inv-pot-table tr:nth-child(even) td { background: #fafbfc; }
.inv-pot-table tr.grand td {
    background: #fff;
    border-top: 2px solid #cbd5e1;
    font-weight: 700;
    color: #0f172a;
}
.inv-pot-table tr.grand td:first-child { color: #0f172a; }

.inv-lines tfoot td {
    background: #fff;
    color: #0f172a;
    font-weight: 700;
    white-space: nowrap;
    padding: 9px 10px;
    border-top: 2px solid #cbd5e1;
    font-variant-numeric: tabular-nums;
}
.inv-lines tfoot td:first-child { text-align: right; letter-spacing: .5px; }

/* Kontrol DataTables di dalam modal dibikin ringkas */
/* .row bawaan Bootstrap punya margin negatif - di dalam wrapper ini efeknya
   bikin isinya lebih lebar dari kontainer dan memunculkan scrollbar palsu. */
#proj-inv-lines_wrapper .row { margin-left: 0; margin-right: 0; }
#proj-inv-lines_wrapper .dataTables_filter { text-align: left; }
#proj-inv-lines_wrapper .dataTables_filter input {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 5px 10px;
    font-size: 13px;
}
#proj-inv-lines_wrapper .dataTables_info,
#proj-inv-lines_wrapper .dataTables_filter label { font-size: 12.5px; color: #64748b; }
#proj-inv-lines_wrapper .pagination { margin: 0; }
#proj-inv-lines_wrapper .page-link { font-size: 12.5px; padding: 4px 10px; }

/* ===== Judul tabel + search box ===== */
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eef2f7;
}
.table-title {
    display: flex;
    align-items: center;
    gap: 9px;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: .3px;
    color: #0f172a;
}
.table-title i { color: #1e3a5f; opacity: .55; font-size: 13px; }
.table-title .row-count {
    font-weight: 500;
    font-size: 11.5px;
    letter-spacing: 0;
    color: #64748b;
    background: #f1f5f9;
    border-radius: 999px;
    padding: 2px 10px;
}
.search-box { position:relative; }
.search-box input {
    padding: 8px 34px 8px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 13px;
    min-width: 260px;
    transition: border-color .15s ease, box-shadow .15s ease;
}
.search-box input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, .15); }
.search-box i { position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    <div class="card_body ml-3 mr-3">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-file-invoice-dollar"></i><?= $title; ?></h3>
                            </div>
                            <form>
                                <div class="card-body">
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <div class="form-group mb-0">
                                                <label>Customer</label>
                                                <select class="form-control select2bs4" id="sr_customer" name="sr_customer">
                                                    <option value="All">All Customer</option>
                                                    <?php foreach ($customer as $cs) : ?>
                                                        <option value="<?= $cs['Id_Supplier']; ?>"><?= $cs['Supplier']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label>From</label>
                                                <div class="input-group">
                                                    <input type="text" name="filter_from" id="filter_from" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label>To</label>
                                                <div class="input-group">
                                                    <input type="text" name="filter_to" id="filter_to" class="form-control tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete='off'>
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label>Type</label>
                                                <select class="form-control select2bs4" id="filter_type" name="filter_type">
                                                    <option value="daily">Daily</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="d-flex" style="gap:8px;">
                                                <button type="button" id="find_data" class="btn btn-primary" style="height:38px; white-space:nowrap;" onclick="cari_projection_report()">
                                                    <i class="fa fa-search"></i> Search
                                                </button>
                                                <button type="button" class="btn btn-success" style="height:38px; white-space:nowrap;" onclick="export_projection_report()">
                                                    <i class="fa fa-file-excel"></i> Export
                                                </button>
                                                <button type="button" class="btn btn-warning" style="height:38px; white-space:nowrap;" onclick="save_history_projection_report()">
                                                    <i class="fa fa-download"></i> Save History
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-header">
                            <span class="table-title">
                                <i class="fas fa-table"></i>Detail Data
                                <span class="row-count" id="proj-row-count" style="display:none;"></span>
                            </span>
                            <div class="search-box">
                                <input type="text" id="tableSearch" placeholder="Search...">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <!-- single overflow container — kunci sticky bekerja -->
                        <div id="proj-table-wrap" style="max-height:500px; min-height:300px; overflow:auto; position:relative;">
                            <div class="nag-loader-overlay" id="proj-loader">
                                <div class="nag-loader-card">
                                    <div class="nag-loader-spinner">
                                        <span class="nag-loader-ring nag-loader-ring-outer"></span>
                                        <span class="nag-loader-ring nag-loader-ring-inner"></span>
                                        <span class="nag-loader-brand">NAG</span>
                                    </div>
                                    <div class="nag-loader-caption">Memuat data...</div>
                                </div>
                            </div>
                            <table id="table-projection-report" class="text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width:30px;" rowspan="2">No</th>
                                        <th style="width:200px;" rowspan="2">Customer</th>
                                        <th style="width:200px;" rowspan="2">Invoice No</th>
                                        <th style="width:200px;" rowspan="2">Invoice Date</th>
                                        <th style="width:200px;" rowspan="2">Destination</th>
                                        <th style="width:150px;" rowspan="2">Order Type</th>
                                        <th style="width:200px;" rowspan="2">Due Date</th>
                                        <th style="width:200px;" rowspan="2">Expected Collection Date</th>
                                        <th style="width:200px;" rowspan="2">Payment Term</th>
                                        <th style="width:200px;" rowspan="2">Currency</th>
                                        <th style="width:200px;" rowspan="2">Invoice Amount</th>
                                        <th style="width:200px;" rowspan="2">Rate</th>
                                        <th class="grp-recv" colspan="5"><span>Receivable Amount</span></th>
                                        <th class="grp-proj" colspan=""><span>Projected Cash Inflow from Accounts Receivable</span></th>
                                    </tr>
                                    <tr>
                                        <th class="sub-recv" style="width:150px;">Tax Base</th>
                                        <th class="sub-recv" style="width:150px;">VAT</th>
                                        <th class="sub-recv" style="width:150px;">Total Invoice</th>
                                        <th class="sub-recv" style="width:150px;">Income Tax Art 23</th>
                                        <th class="sub-recv" style="width:150px;">Collection Amount</th>
                                        <th class="sub-proj" style="width:150px;"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== Modal Detail Invoice / Debit Note ===== -->
<div class="modal fade" id="modal-invoice-pdf" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width:92%;">
        <div class="modal-content">
            <div class="modal-header" style="background:#1e3a5f; color:#f8fafc;">
                <h5 class="modal-title" style="font-size:14px; font-weight:600; letter-spacing:.3px;">
                    <i class="fas fa-file-invoice-dollar" style="opacity:.75; margin-right:8px;"></i>
                    <span id="proj-pdf-title"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#f8fafc; opacity:.85;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="proj-inv-head" class="inv-head"></div>
                <div class="inv-lines-wrap">
                    <!-- Kolomnya dibangun via JS: invoice dan debit note beda format. -->
                    <table class="inv-lines" id="proj-inv-lines">
                        <thead></thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
                <div id="proj-inv-pot" class="inv-pot" style="display:none;"></div>
            </div>
            <div class="modal-footer">
                <a href="#" id="proj-pdf-open" target="_blank" class="btn btn-primary">
                    <i class="fa fa-file-pdf"></i> Buka PDF
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
// Nomor invoice di tabel bisa diklik - tampilkan modal detail.
var PROJ_DETAIL_URL = '<?= base_url('arnag/invoice_detail_json'); ?>';
var PROJ_PDF_URL    = '<?= base_url('arnag/print_invoice_by_number'); ?>';

// Diisi crud-nag-report.js tiap kali Search, supaya header modal bisa langsung
// tampil dari data yang sudah ada di browser (tanpa nunggu server).
var PROJ_ROWS = {};

function _fmtMoney(v) {
    if (v === null || v === '' || isNaN(parseFloat(v))) return '-';
    return parseFloat(v).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

var invDT = null;

function _esc(v) {
    if (v === null || v === undefined) return '';
    return String(v).replace(/[&<>"]/g, function (c) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c];
    });
}

// Kolom tabel rincian dibangun via JS karena invoice dan debit note beda format.
var INV_COLS = [
    { l: 'No', w: '34px' }, { l: 'SO Number' }, { l: 'BPPB' }, { l: 'Shipp No' },
    { l: 'Style' }, { l: 'Item' }, { l: 'Color' }, { l: 'Size' }, { l: 'UOM' },
    { l: 'Qty', num: true }, { l: 'Unit Price', num: true }, { l: 'Total', num: true }
];

function _setLinesHead(cols) {
    var h = '<tr>';
    cols.forEach(function (c) {
        h += '<th' + (c.num ? ' class="num"' : '') +
             (c.w ? ' style="width:' + c.w + ';"' : '') + '>' + _esc(c.l) + '</th>';
    });
    document.querySelector('#proj-inv-lines thead').innerHTML = h + '</tr>';
    return cols.length;
}

// Format tabel debit note mengikuti PDF-nya: Description, Supplier, Supplier
// Invoice, lalu kolom dinamis dari header1/2/3, dan Value/Rate/Value.
function _dnCols(dn) {
    var cols = [{ l: 'No', w: '34px' }, { l: 'Description' }, { l: 'Supplier' }, { l: 'Supplier Invoice' }];
    ['header1', 'header2', 'header3'].forEach(function (k) {
        if (dn && dn[k]) cols.push({ l: dn[k] });
    });
    cols.push({ l: 'Value ' + ((dn && dn.from_curr) || ''), num: true });
    cols.push({ l: 'Rate', num: true });
    cols.push({ l: 'Value ' + ((dn && dn.to_curr) || ''), num: true });
    return cols;
}

function _renderDnLines(res, tbody, tfoot) {
    var dn   = res.dn || {};
    var cols = _dnCols(dn);
    _setLinesHead(cols);

    var html = '', totValue = 0, totAmount = 0;

    res.lines.forEach(function (d, i) {
        totValue  += parseFloat(d.value) || 0;
        totAmount += parseFloat(d.amount) || 0;

        html += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + _esc(d.deskripsi) + '</td>' +
                '<td>' + _esc(d.supplier) + '</td>' +
                '<td>' + _esc(d.supplier_invoice) + '</td>';

        // Satu nilai per baris, sama seperti tampilan di PDF.
        ['header1', 'header2', 'header3'].forEach(function (k) {
            if (!dn[k]) return;
            var isi = (d[k] || []).map(_esc).join('<br>');
            html += '<td>' + (isi || '-') + '</td>';
        });

        html += '<td class="num">' + _fmtMoney(d.value) + '</td>' +
                '<td class="num">' + _fmtMoney(d.rate) + '</td>' +
                '<td class="num">' + _fmtMoney(d.amount) + '</td>' +
                '</tr>';
    });

    tbody.innerHTML = html;
    tfoot.innerHTML = '<tr>' +
        '<td colspan="' + (cols.length - 3) + '">TOTAL</td>' +
        '<td class="num">' + _fmtMoney(totValue) + '</td>' +
        '<td></td>' +
        '<td class="num">' + _fmtMoney(totAmount) + '</td>' +
        '</tr>';
}

// DataTables harus dimatikan dulu sebelum isi tabel diganti manual, kalau tidak
// state internalnya jadi tidak sinkron dengan DOM.
function _destroyInvDataTable() {
    if (invDT) {
        invDT.destroy();
        invDT = null;
    }
}

function _initInvDataTable() {
    _destroyInvDataTable();

    invDT = $('#proj-inv-lines').DataTable({
        destroy    : true,
        pageLength : 5,
        lengthChange: false,
        order      : [],            // biarkan urut sesuai urutan aslinya
        // Tanpa ini DataTables mengunci lebar kolom dari hasil pengukuran saat
        // modal belum tampil penuh, jadi tabelnya jadi sempit sendiri.
        autoWidth  : false,
        columnDefs : [{ orderable: false, targets: 0 }],
        language   : {
            emptyTable      : 'Tidak ada rincian',
            zeroRecords     : 'Tidak ada rincian yang cocok',
            info            : 'Menampilkan _START_ - _END_ dari _TOTAL_ baris',
            infoEmpty       : 'Tidak ada rincian',
            infoFiltered    : '(difilter dari _MAX_ baris)',
            search          : '',
            searchPlaceholder: 'Cari rincian...',
            paginate        : { first: '«', last: '»', next: '›', previous: '‹' }
        },
        dom: '<"row align-items-center mb-2"<"col-sm-6"f><"col-sm-6 text-right"i>>rt<"row mt-2"<"col-sm-12 d-flex justify-content-end"p>>'
    });

}

// Ringkasan potongan (Total s/d Grand Total) - hanya ada untuk invoice,
// debit note tidak punya tabel potongan jadi bloknya disembunyikan.
function _renderInvPot(pot, curr) {
    var box = document.getElementById('proj-inv-pot');

    if (!pot) {
        box.style.display = 'none';
        box.innerHTML = '';
        return;
    }

    var baris = [
        ['Total', pot.total],
        ['Discount', pot.discount],
        ['Down Payment', pot.dp],
        ['Return', pot.retur],
        ['Total Before Value Added Tax', pot.twot]
    ];

    // Kolom other charges cuma ada di invoice knitting.
    if (pot.total_other !== undefined && pot.total_other !== null) {
        baris.push(['Other Charges', pot.total_other]);
    }

    baris.push(['Value Added Tax', pot.vat]);

    var html = '<table class="inv-pot-table">';
    baris.forEach(function (b) {
        html += '<tr><td>' + b[0] + '</td><td class="cur">' + curr + '</td>' +
                '<td class="num">' + _fmtMoney(b[1]) + '</td></tr>';
    });
    html += '<tr class="grand"><td>Grand Total</td><td class="cur">' + curr + '</td>' +
            '<td class="num">' + _fmtMoney(pot.grand_total) + '</td></tr>';
    html += '</table>';

    box.innerHTML = html;
    box.style.display = '';
}

function show_invoice_detail(no_invoice) {
    if (!no_invoice) return;

    var r = PROJ_ROWS[no_invoice] || {};

    document.getElementById('proj-pdf-title').textContent = no_invoice;
    document.getElementById('proj-pdf-open').href = PROJ_PDF_URL + '?no_invoice=' + encodeURIComponent(no_invoice);

    // Header langsung dari baris tabel - instan, tanpa request.
    var head = [
        ['Customer', r.customer || '-'],
        ['Invoice Date', r.inv_date || '-'],
        ['Destination', r.shipp || '-'],
        ['Order Type', r.type_so || '-'],
        ['Due Date', r.duedate || '-'],
        ['Expected Collection', r.duedate_update || '-'],
        ['Payment Term', r.top || '-'],
        ['Currency', r.curr || '-'],
        ['Rate', _fmtMoney(r.rate)],
        ['Invoice Amount', _fmtMoney(r.amount)],
        ['Tax Base', _fmtMoney(r.tax_base)],
        ['VAT', _fmtMoney(r.tax_vat)],
        ['Total Invoice', _fmtMoney(r.total_invoice)],
        ['Income Tax Art 23', _fmtMoney(r.income_tax_23)],
        ['Collection Amount', _fmtMoney(r.collection_amount)]
    ];
    var headHTML = '';
    head.forEach(function (h) {
        headHTML += '<div class="inv-head-item"><span>' + h[0] + '</span><b>' + h[1] + '</b></div>';
    });
    document.getElementById('proj-inv-head').innerHTML = headHTML;

    _destroyInvDataTable();

    var tbody = document.querySelector('#proj-inv-lines tbody');
    var tfoot = document.querySelector('#proj-inv-lines tfoot');
    var nCol  = _setLinesHead(INV_COLS);

    tbody.innerHTML = '<tr><td colspan="' + nCol + '" class="inv-empty"><i class="fa fa-spinner fa-spin"></i> Memuat rincian...</td></tr>';
    tfoot.innerHTML = '';
    _renderInvPot(null, '');

    $('#modal-invoice-pdf').modal('show');

    $.ajax({
        url: PROJ_DETAIL_URL,
        type: 'GET',
        data: { no_invoice: no_invoice },
        dataType: 'JSON',
        success: function (res) {
            if (!res.status || !res.lines.length) {
                tbody.innerHTML = '<tr><td colspan="' + nCol + '" class="inv-empty">' +
                    _esc(res.message || 'Rincian tidak ditemukan.') + '</td></tr>';
                return;
            }

            // Debit note: format kolomnya beda, ikut PDF debit note.
            if (res.type === 'dn') {
                _renderDnLines(res, tbody, tfoot);
                _renderInvPot(null, '');
                _initInvDataTable();
                return;
            }

            var html = '';
            var totQty = 0, totAmount = 0, adaQty = false;

            res.lines.forEach(function (d, i) {
                if (d.qty !== null && d.qty !== '' && !isNaN(parseFloat(d.qty))) {
                    totQty += parseFloat(d.qty);
                    adaQty = true;
                }
                totAmount += parseFloat(d.total_price) || 0;

                html += '<tr>' +
                    '<td>' + (i + 1) + '</td>' +
                    '<td>' + _esc(d.so_number || '-') + '</td>' +
                    '<td>' + _esc(d.bppb_number || '-') + '</td>' +
                    '<td>' + _esc(d.shipp_number || '-') + '</td>' +
                    '<td>' + _esc(d.styleno || '-') + '</td>' +
                    '<td>' + _esc(d.product_item || '-') + '</td>' +
                    '<td>' + _esc(d.color || '-') + '</td>' +
                    '<td>' + _esc(d.size || '-') + '</td>' +
                    '<td>' + _esc(d.uom || '-') + '</td>' +
                    '<td class="num">' + (d.qty === null ? '-' : d.qty) + '</td>' +
                    '<td class="num">' + _fmtMoney(d.unit_price) + '</td>' +
                    '<td class="num">' + _fmtMoney(d.total_price) + '</td>' +
                    '</tr>';
            });
            tbody.innerHTML = html;

            tfoot.innerHTML = '<tr>' +
                '<td colspan="9">TOTAL</td>' +
                '<td class="num">' + (adaQty ? totQty.toLocaleString('en-US', { maximumFractionDigits: 2 }) : '-') + '</td>' +
                '<td></td>' +
                '<td class="num">' + _fmtMoney(totAmount) + '</td>' +
                '</tr>';

            _renderInvPot(res.pot, r.curr || 'IDR');
            _initInvDataTable();
        },
        error: function () {
            tbody.innerHTML = '<tr><td colspan="' + nCol + '" class="inv-empty">Gagal memuat rincian.</td></tr>';
            tfoot.innerHTML = '';
        }
    });
}

// Pakai addEventListener biasa, BUKAN $(document).on(...): jQuery baru dimuat
// di footer.php (setelah view ini), jadi $ belum ada waktu skrip ini jalan.
document.addEventListener('click', function (e) {
    var link = e.target.closest ? e.target.closest('.inv-link') : null;
    if (link) {
        e.preventDefault();
        show_invoice_detail(link.dataset.no);
    }
});

function fixProjHeaderRow2() {
    var tr1 = document.querySelector('#table-projection-report thead tr:first-child');
    if (!tr1) return;
    var h = tr1.getBoundingClientRect().height;
    if (h > 0) {
        document.querySelectorAll('#table-projection-report thead tr:nth-child(2) th').forEach(function(th) {
            th.style.setProperty('top', h + 'px', 'important');
        });
    } else {
        setTimeout(fixProjHeaderRow2, 50);
    }
}

// Offset kolom beku (No/Customer/Invoice No/Invoice Date) diukur dari lebar
// kolom yang benar-benar ter-render - kalau di-hardcode, nama customer yang
// panjang bikin kolomnya melar dan posisi freeze-nya meleset/tumpang tindih.
function setProjFreezeOffsets() {
    var table = document.getElementById('table-projection-report');
    if (!table) return;
    var row = table.querySelector('tbody tr') || table.querySelector('thead tr:first-child');
    if (!row) return;

    var left = 0;
    for (var i = 0; i < 4; i++) {
        var cell = row.cells[i];
        if (!cell) break;
        table.style.setProperty('--fz' + (i + 1), left + 'px');
        left += cell.getBoundingClientRect().width;
    }

    // Batas kanan area beku - dipakai label grup biar tidak ketutup kolom beku
    table.style.setProperty('--fz-end', left + 'px');

    // Di layar sempit (HP/tablet) 4 kolom beku bisa lebih lebar dari layarnya
    // sendiri, sehingga menutupi seluruh area tabel dan tabel terlihat tidak
    // bisa digeser. Kalau area beku makan >85% lebar yang terlihat, freeze
    // dimatikan; di laptop/desktop tetap aktif seperti biasa.
    var wrap = document.getElementById('proj-table-wrap');
    table.classList.toggle('no-freeze', !!wrap && left > wrap.clientWidth * 0.85);
}

// Hitung sekali saat halaman dibuka, dan ulang tiap ukuran layar berubah
// (termasuk HP diputar landscape/portrait).
setProjFreezeOffsets();
var _projResizeTimer = null;
window.addEventListener('resize', function () {
    clearTimeout(_projResizeTimer);
    _projResizeTimer = setTimeout(setProjFreezeOffsets, 150);
});

document.getElementById("tableSearch").addEventListener("keyup", function() {
    let value = this.value.toLowerCase().trim();
    let rows = document.querySelectorAll("#table-projection-report tbody tr");
    rows.forEach(function(row) {
        // Kolom teks yang ikut dicari: Customer s/d Currency.
        let colsToSearch = [1,2,3,4,5,6,7,8,9];
        let match = false;
        for (let i of colsToSearch) {
            let cell = row.cells[i];
            if (cell) {
                let text = cell.textContent.toLowerCase().trim().replace(/\s+/g, " ");
                if (text.indexOf(value) > -1) { match = true; break; }
            }
        }
        row.style.display = match ? "" : "none";
    });
});
</script>
