<!-- DataTables 2.x CSS — khusus halaman ini -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables2/css/dataTables.bootstrap4.min.css'); ?>">

<style>
/* Palet & komponen disamakan dengan Projection Report. */

/* ===== Halaman & card ===== */
.content-wrapper .content-header { padding: 0; }
.content-wrapper .card {
    margin-bottom: 14px;
    border: 1px solid #e5e9f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
    overflow: hidden;
}
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
.content-wrapper .card-body .form-control,
.content-wrapper .card-body .select2-container .select2-selection--single,
.content-wrapper .card-body .input-group-text,
.content-wrapper .card-body .btn {
    height: 38px;
    border-radius: 8px;
    border-color: #e2e8f0;
    font-size: 13px;
}
.content-wrapper .card-body .select2-container { display: block; width: 100% !important; }
/* Tema select2 mengunci tinggi pakai em - harus di-override. */
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
.content-wrapper .card-body .input-group > .form-control { border-radius: 8px 0 0 8px; }
.content-wrapper .card-body .input-group-text {
    border-radius: 0 8px 8px 0;
    border-left: 0;
    background: #f8fafc;
    color: #64748b;
}
/* Warna tombol tidak diubah - hanya jarak ikon, bobot huruf, dan bayangan. */
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

/* ===== Dropdown select2 & datepicker (dilampirkan ke body) ===== */
.select2-container--bootstrap4 .select2-dropdown {
    border-color: #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(15, 23, 42, .12);
    overflow: hidden;
}
.select2-container--bootstrap4 .select2-results__option { font-size: 13px; padding: 7px 12px; color: #1e293b; }
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
.datepicker {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(15, 23, 42, .12);
    padding: 8px;
    font-size: 13px;
}
.datepicker table tr th.datepicker-switch,
.datepicker table tr th.prev,
.datepicker table tr th.next { color: #0f172a; font-weight: 600; border-radius: 8px; }
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

/* ===== Judul tabel (menggantikan bar biru kedua) ===== */
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

/* ===== Tabel list history ===== */
#tbl-history-list thead th {
    background: #1e3a5f;
    color: #e2e8f0;
    font-weight: 600;
    font-size: 11px;
    letter-spacing: .4px;
    text-transform: uppercase;
    white-space: nowrap;
    border: 0;
    padding: 9px 12px;
    vertical-align: middle;
}
#tbl-history-list tbody td {
    font-size: 12.5px;
    padding: 8px 12px;
    vertical-align: middle;
    border-color: #eef2f7;
    font-variant-numeric: tabular-nums;
}
#tbl-history-list tbody tr:hover td { background: #eaf2ff; }
#tbl-history-list_wrapper .dataTables_filter input,
#tbl-history-list_wrapper .dataTables_length select {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 4px 10px;
    font-size: 13px;
}
#tbl-history-list_wrapper .dataTables_info,
#tbl-history-list_wrapper label { font-size: 12.5px; color: #64748b; }
#tbl-history-list_wrapper .page-link { font-size: 12.5px; padding: 4px 10px; }

/* ===== Modal detail ===== */
#modal-history-detail .modal-content { border-radius: 12px; overflow: hidden; }
#modal-history-detail .modal-header {
    background: #1e3a5f !important;
    border-bottom: 0;
    padding: 13px 18px;
}
#modal-history-detail .modal-title {
    color: #f8fafc;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: .3px;
}
#modal-history-detail .close { color: #f8fafc; opacity: .85; text-shadow: none; }
#tbl-history-detail tbody tr:nth-child(even) td { background: #fafbfc; }
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
                                <h3 class="card-title"><i class="fas fa-history"></i><?= $title; ?></h3>
                            </div>
                            <form>
                                <div class="card-body">
                                    <div class="row align-items-end">
                                        <div class="form-group col-md-2">
                                            <label>Saved Date From</label>
                                            <div class="input-group">
                                                <input type="text" id="hist_from" class="form-control tanggal"
                                                    value="<?= date('Y-m-01'); ?>" autocomplete="off">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>To</label>
                                            <div class="input-group">
                                                <input type="text" id="hist_to" class="form-control tanggal"
                                                    value="<?= date('Y-m-d'); ?>" autocomplete="off">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Type</label>
                                            <select id="hist_type" class="form-control select2bs4">
                                                <option value="">All Type</option>
                                                <option value="daily">Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Doc Number</label>
                                            <div style="position:relative;">
                                                <input type="text" id="hist_doc_filter" class="form-control"
                                                    placeholder="Cari doc number..." autocomplete="off"
                                                    style="padding-right:30px;">
                                                <i class="fa fa-search" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);color:#aaa;pointer-events:none;"></i>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>&nbsp;</label>
                                            <div>
                                                <button type="button" class="btn btn-primary" onclick="load_history_list()">
                                                    <i class="fa fa-search"></i> Search
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

    <!-- Tabel List History -->
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="position:relative;">
                        <div class="table-header">
                            <span class="table-title"><i class="fas fa-table"></i>History List</span>
                        </div>
                        <div class="nag-loader-overlay" id="hist-loader">
                            <div class="nag-loader-card">
                                <div class="nag-loader-spinner">
                                    <span class="nag-loader-ring nag-loader-ring-outer"></span>
                                    <span class="nag-loader-ring nag-loader-ring-inner"></span>
                                    <span class="nag-loader-brand">NAG</span>
                                </div>
                                <div class="nag-loader-caption">Memuat data...</div>
                            </div>
                        </div>
                        <table id="tbl-history-list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Doc Number</th>
                                    <th class="text-center">Periode From</th>
                                    <th class="text-center">Periode To</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Total Invoice</th>
                                    <th class="text-right">Total Amount IDR</th>
                                    <th>Saved By</th>
                                    <th class="text-center">Saved At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-history-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== Modal Detail ===== -->
<div class="modal fade" id="modal-history-detail" tabindex="-1" role="dialog"
     aria-labelledby="modalHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width:95%;">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalHistoryLabel">
                    <i class="fas fa-file-invoice-dollar" style="opacity:.75; margin-right:8px;"></i>Detail — <span id="modal-doc-number"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-2">
                <div class="mb-2 d-flex gap-2">
                    <button type="button" class="btn btn-success btn-sm" onclick="export_history_excel()">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm ml-2" onclick="export_history_pdf()">
                        <i class="fa fa-file-pdf"></i> Export PDF
                    </button>
                </div>

                <p id="modal-period" class="mb-1 font-weight-bold" style="font-size:12px;"></p>

                <!-- wrapper: horizontal scroll di luar, vertikal di dalam -->
                <div style="overflow-x:auto;">
                    <div id="history-detail-scroll" style="max-height:470px; overflow-y:auto;">
                        <table id="tbl-history-detail"
                               class="table table-bordered table-sm"
                               style="width:max-content; border-collapse:collapse; font-size:11px;">
                            <thead id="thead-history-detail"></thead>
                            <tbody id="tbody-history-detail"></tbody>
                            <tfoot id="tfoot-history-detail"></tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
let _activeDocNumber = '';
var histDT = null;

/* ── DataTables 2.x dimuat dinamis agar tidak konflik dengan load order ── */
document.addEventListener('DOMContentLoaded', function () {
    var css = document.createElement('link');
    css.rel = 'stylesheet';
    css.href = '<?= base_url('assets/plugins/datatables2/css/dataTables.bootstrap4.min.css'); ?>';
    document.head.appendChild(css);

    var s = document.createElement('script');
    s.src = '<?= base_url('assets/plugins/datatables2/js/dataTables.min.js'); ?>';
    s.onload = function () {
        var s2 = document.createElement('script');
        s2.src = '<?= base_url('assets/plugins/datatables2/js/dataTables.bootstrap4.min.js'); ?>';
        document.head.appendChild(s2);
    };
    document.head.appendChild(s);
});

function _initHistDT(url) {
    if (histDT) { histDT.destroy(); histDT = null; }

    let typeBadge = { daily:'badge-primary', weekly:'badge-warning', monthly:'badge-success' };

    histDT = $('#tbl-history-list').DataTable({
        destroy  : true,
        ajax     : {
            url: url, dataSrc: '', type: 'GET',
            error: function () {
                document.getElementById('hist-loader').classList.remove('show');
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data history.' });
            }
        },
        columns  : [
            {
                data: null, orderable: false, width: '40px', className: 'text-center',
                render: function (d, t, r, m) { return m.row + 1; }
            },
            { data: 'doc_number' },
            { data: 'periode_dari',   className: 'text-center', render: function(d){ return d ? formatDate(d.slice(0,10)) : '-'; } },
            { data: 'periode_sampai', className: 'text-center', render: function(d){ return d ? formatDate(d.slice(0,10)) : '-'; } },
            {
                data: 'type', className: 'text-center',
                render: function (d) {
                    return '<span class="badge ' + (typeBadge[d] || 'badge-secondary') + '">' + (d || '-') + '</span>';
                }
            },
            { data: 'total_invoice',   className: 'text-center' },
            {
                data: 'total_amount_idr', className: 'text-right',
                render: function (d) {
                    return parseFloat(d || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            { data: 'created_by' },
            { data: 'created_at', className: 'text-center', render: function(d){ return d ? formatDate(d.slice(0,10)) : '-'; } },
            {
                data: null, orderable: false, className: 'text-center',
                render: function (d, t, r) {
                    return '<span style="white-space:nowrap;">' +
                        '<button class="btn btn-info btn-xs" onclick="view_history_detail(\'' + r.doc_number + '\')"><i class="fa fa-eye"></i> View</button> ' +
                        '<button class="btn btn-danger btn-xs" onclick="cancel_history_projection(\'' + r.doc_number + '\')"><i class="fa fa-times"></i> Cancel</button>' +
                        '</span>';
                }
            }
        ],
        order    : [[8, 'desc']],
        pageLength: 10,
        language : {
            emptyTable    : 'Tidak ada data',
            zeroRecords   : 'Tidak ada data yang cocok',
            info          : 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            infoEmpty     : 'Tidak ada data',
            infoFiltered  : '(difilter dari _MAX_ data)',
            search        : '<i class="fa fa-search"></i>',
            searchPlaceholder: 'Cari...',
            paginate      : { first: '«', last: '»', next: '›', previous: '‹' },
            lengthMenu    : 'Tampilkan _MENU_ baris'
        },
        dom: '<"row align-items-center mb-2"<"col-sm-4"l><"col-sm-8 text-right"f>>rt<"row mt-2 align-items-center"<"col-sm-5"i><"col-sm-7 d-flex justify-content-end"p>>',
        initComplete: function () {
            document.getElementById('hist-loader').classList.remove('show');
        }
    });
}

// Terapkan filter Type & Doc Number yang lagi diisi ke DataTables - dipanggil
// cuma dari load_history_list() (tombol Search), BUKAN otomatis pas dropdown
// Type dipilih/diketik di Doc Number, biar tidak "ngaco" waktu Search
// menimpa hasil filter yang belum sempat diterapkan ke data baru.
function _applyHistFilter() {
    if (!histDT) return;
    let typeVal = $('#hist_type').val();
    let docVal  = $('#hist_doc_filter').val();
    histDT.column(4).search(typeVal ? '^' + typeVal + '$' : '', true, false).draw(false);
    histDT.column(1).search(docVal || '').draw(false);
}

function load_history_list() {
    let from = $('#hist_from').val();
    let to   = $('#hist_to').val();
    if (!from || !to) { Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Tanggal harus diisi!' }); return; }

    let url = 'get_history_projection_list/' + from + '/' + to + '/';

    document.getElementById('hist-loader').classList.add('show');

    if (histDT) {
        // Muat data periode baru, lalu terapkan filter Type/Doc Number yang
        // lagi diisi user (bukan di-reset) - jadi Search sekali jalan sekalian
        // nge-filter, bukan menghapus filter yang sudah dipilih.
        histDT.ajax.url(url).load(function () {
            _applyHistFilter();
            document.getElementById('hist-loader').classList.remove('show');
        });
    } else {
        // Loader disembunyikan lewat initComplete di _initHistDT (baru jalan
        // sekali, pas tabel pertama kali dibuat).
        _initHistDT(url);
    }
}

function view_history_detail(doc_number) {
    _activeDocNumber = doc_number;
    $('#modal-doc-number').text(doc_number);
    $('#thead-history-detail').html('');
    $('#tbody-history-detail').html('<tr><td class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>');
    $('#tfoot-history-detail').html('');
    $('#modal-period').text('');
    $('#modal-history-detail').modal('show');

    $.ajax({
        url     : 'get_history_projection_detail/',
        type    : 'POST',
        data    : { doc_number: doc_number },
        dataType: 'JSON',
        success : function(res) {
            render_detail_table(res);
        },
        error: function() {
            $('#tbody-history-detail').html('<tr><td class="text-center text-danger">Error loading detail.</td></tr>');
        }
    });
}

function render_detail_table(res) {
    let header = res.header;
    let rows   = res.detail;

    $('#modal-period').text('Period : ' + header.periode_dari + ' s/d ' + header.periode_sampai);

    // Generate dates in range
    let dates = [];
    let cur   = new Date(header.periode_dari);
    let end   = new Date(header.periode_sampai);
    while (cur <= end) {
        dates.push(cur.toISOString().slice(0, 10));
        cur.setDate(cur.getDate() + 1);
    }

    // ── THEAD ── (palet disamakan dengan Projection Report)
    let hdrBg  = '#1e3a5f';
    let recvBg = '#2c5282';
    let subBg  = '#3563a0';
    let projBg = '#0f766e';
    let dateBg = '#0d9488';
    // Row-1: sticky top:0
    let th1 = (bg, extra='') =>
        `style="white-space:nowrap;padding:7px 10px;border-right:1px solid rgba(255,255,255,.10);text-align:center;font-size:10.5px;font-weight:600;letter-spacing:.3px;text-transform:uppercase;color:#f8fafc;background:${bg};position:sticky;top:0;z-index:3;${extra}"`;
    // Row-2: top will be set after render via JS
    let th2 = (bg) =>
        `class="th-row2" style="white-space:nowrap;padding:7px 10px;border-right:1px solid rgba(255,255,255,.10);text-align:center;font-size:10.5px;font-weight:600;letter-spacing:.3px;text-transform:uppercase;color:#f8fafc;background:${bg};position:sticky;top:0;z-index:2;"`;

    let thead = `<tr>
        <th ${th1(hdrBg)} rowspan="2">No</th>
        <th ${th1(hdrBg)} rowspan="2">Customer</th>
        <th ${th1(hdrBg)} rowspan="2">Invoice No</th>
        <th ${th1(hdrBg)} rowspan="2">Invoice Date</th>
        <th ${th1(hdrBg)} rowspan="2">Destination</th>
        <th ${th1(hdrBg)} rowspan="2">Order Type</th>
        <th ${th1(hdrBg)} rowspan="2">Due Date</th>
        <th ${th1(hdrBg)} rowspan="2">Expected Collection Date</th>
        <th ${th1(hdrBg)} rowspan="2">Payment Term</th>
        <th ${th1(hdrBg)} rowspan="2">Currency</th>
        <th ${th1(hdrBg)} rowspan="2">Invoice Amount</th>
        <th ${th1(hdrBg)} rowspan="2">Rate</th>
        <th ${th1(recvBg, 'text-align:left;vertical-align:top;')} colspan="5">Receivable Amount</th>
        <th ${th1(projBg)} colspan="${dates.length}">Projected Cash Inflow from Accounts Receivable</th>
    </tr><tr>`;
    thead += `<th ${th2(subBg)}>Tax Base</th>`;
    thead += `<th ${th2(subBg)}>VAT</th>`;
    thead += `<th ${th2(subBg)}>Total Invoice</th>`;
    thead += `<th ${th2(subBg)}>Income Tax Art 23</th>`;
    thead += `<th ${th2(subBg)}>Collection Amount</th>`;
    dates.forEach(function(d) {
        thead += `<th ${th2(dateBg)}>${formatDate(d)}</th>`;
    });
    thead += '</tr>';
    $('#thead-history-detail').html(thead);

    // Ukur row-1 height lalu pasang top row-2; retry sampai dapat nilai valid
    (function fixRow2() {
        let h = $('#tbl-history-detail thead tr:eq(0)')[0]
                    ? $('#tbl-history-detail thead tr:eq(0)')[0].getBoundingClientRect().height
                    : 0;
        if (h > 0) {
            $('#tbl-history-detail .th-row2').css('top', h + 'px');
        } else {
            setTimeout(fixRow2, 50);
        }
    })();

    // ── TBODY ──
    let tbody = '';
    let grandTotal = 0;
    let totalTaxBase = 0;
    let totalTaxVat = 0;
    let totalInvoice = 0;
    let totalIncomeTax23 = 0;
    let totalCollectionAmount = 0;
    let dateTotals = {};
    dates.forEach(d => dateTotals[d] = 0);

    let tdStyle = 'style="padding:4px 8px; border:1px solid #dee2e6; white-space:nowrap; font-size:11px;';

    rows.forEach(function(r, i) {
        grandTotal += parseFloat(r.amount_idr || 0);
        totalTaxBase += parseFloat(r.tax_base || 0);
        totalTaxVat += parseFloat(r.tax_vat || 0);
        totalInvoice += parseFloat(r.total_invoice || 0);
        totalIncomeTax23 += parseFloat(r.income_tax_23 || 0);
        totalCollectionAmount += parseFloat(r.collection_amount || 0);
        tbody += `<tr>
            <td ${tdStyle} text-align:center;">${i + 1}</td>
            <td ${tdStyle}">${r.customer}</td>
            <td ${tdStyle}">${r.no_invoice}</td>
            <td ${tdStyle} text-align:center;">${r.inv_date}</td>
            <td ${tdStyle} text-align:center;">${r.shipp}</td>
            <td ${tdStyle} text-align:center;">${r.type_so || '-'}</td>
            <td ${tdStyle} text-align:center;">${r.duedate}</td>
            <td ${tdStyle} text-align:center;">${r.duedate_update || ''}</td>
            <td ${tdStyle} text-align:center;">${r.top}</td>
            <td ${tdStyle} text-align:center;">${r.curr}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.amount)}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.rate)}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.tax_base)}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.tax_vat)}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.total_invoice)}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.income_tax_23)}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.collection_amount)}</td>`;

        dates.forEach(function(d) {
            let val = (r.duedate_update === d) ? histNetAmount(r) : 0.00;
            if (val !== 0) dateTotals[d] += val;
            tbody += `<td ${tdStyle} text-align:right;">${val !== 0 ? fmt(val) : 0.00}</td>`;
        });
        tbody += '</tr>';
    });
    $('#tbody-history-detail').html(tbody);

    // ── TFOOT ──
    let tfoot = `<tr style="background-color:#FFE4C4; font-weight:bold;">
        <td ${tdStyle} text-align:center;" colspan="12">TOTAL</td>
        <td ${tdStyle} text-align:right;">${fmt(totalTaxBase)}</td>
        <td ${tdStyle} text-align:right;">${fmt(totalTaxVat)}</td>
        <td ${tdStyle} text-align:right;">${fmt(totalInvoice)}</td>
        <td ${tdStyle} text-align:right;">${fmt(totalIncomeTax23)}</td>
        <td ${tdStyle} text-align:right;">${fmt(totalCollectionAmount)}</td>`;
    dates.forEach(function(d) {
        tfoot += `<td ${tdStyle} background-color:#90EE90; text-align:right;">${dateTotals[d] !== 0 ? fmt(dateTotals[d]) : 0}</td>`;
    });
    tfoot += '</tr>';
    $('#tfoot-history-detail').html(tfoot);
}

function export_history_excel() {
    if (!_activeDocNumber) return;
    window.open('.../../export_history_projection_excel/?doc_number=' + encodeURIComponent(_activeDocNumber));
}

function export_history_pdf() {
    if (!_activeDocNumber) return;
    window.open('.../../export_history_projection_pdf/?doc_number=' + encodeURIComponent(_activeDocNumber));
}

function fmt(n) {
    return parseFloat(n || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

// Nilai yang masuk ke kolom tanggal = Collection Amount (sudah dipotong PPh),
// sama seperti Projection Report. Sengaja dihitung amount_idr x (collection /
// total invoice), bukan collection_amount langsung: history lama menyimpan
// Receivable Amount dari nilai penuh invoice, sedangkan amount_idr-nya sudah
// memperhitungkan alokasi - rasio PPh-nya sama, jadi hasilnya tetap benar.
// Samakan dengan export_history_projection_excel.php / _pdf.php.
function histNetAmount(r) {
    let amt = parseFloat(r.amount_idr || 0);
    let ti  = parseFloat(r.total_invoice || 0);
    let col = parseFloat(r.collection_amount || 0);
    return ti !== 0 ? amt * col / ti : amt;
}

function formatDate(ymd) {
    let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    let p = ymd.split('-');
    return p[2] + ' ' + months[parseInt(p[1]) - 1] + ' ' + p[0];
}

function cancel_history_projection(doc_number) {
    Swal.fire({
        title: 'Cancel History',
        html: 'Hapus history <strong>' + doc_number + '</strong>?<br><small class="text-muted">Data header dan detail akan dihapus permanen.</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url     : 'cancel_history_projection_report/',
                type    : 'POST',
                data    : { doc_number: doc_number },
                dataType: 'JSON',
                success : function(res) {
                    if (res.status === 'success') {
                        Swal.fire({ icon: 'success', title: 'Dihapus!', text: doc_number + ' berhasil dihapus.', timer: 1500, showConfirmButton: false });
                        load_history_list();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message || 'Gagal menghapus data.' });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat menghapus.' });
                }
            });
        }
    });
}
</script>
