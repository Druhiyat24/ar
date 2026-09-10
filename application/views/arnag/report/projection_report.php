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

/* Angka rata kanan (baris data & total) */
#table-projection-report tbody td[align="right"],
#table-projection-report tfoot td[align="right"] { text-align: right; }

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

<script>
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
}

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
