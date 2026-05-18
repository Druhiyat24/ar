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
                                <h3 class="card-title"><?= $title; ?></h3>
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
                                            <select id="hist_type" class="form-control select2bs4" onchange="apply_history_filter()">
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
                                                    oninput="apply_history_filter()"
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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">History List</h3>
                    </div>
                    <div class="card-body">
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
                            <tbody id="tbody-history-list">
                                <tr><td colspan="9" class="text-center text-muted">Klik Search untuk menampilkan data</td></tr>
                            </tbody>
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

            <div class="modal-header bg-info">
                <h5 class="modal-title" id="modalHistoryLabel">Detail — <span id="modal-doc-number"></span></h5>
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

                <div style="overflow-x:auto; max-height:500px; overflow-y:auto;">
                    <table id="tbl-history-detail"
                           class="table table-bordered table-sm"
                           style="width:max-content; border-collapse:collapse; font-size:11px;">
                        <thead id="thead-history-detail"></thead>
                        <tbody id="tbody-history-detail"></tbody>
                        <tfoot id="tfoot-history-detail"></tfoot>
                    </table>
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

function load_history_list() {
    let from = $('#hist_from').val();
    let to   = $('#hist_to').val();
    if (!from || !to) { alert('Tanggal harus diisi!'); return; }

    $.ajax({
        url     : 'get_history_projection_list/' + from + '/' + to + '/',
        type    : 'GET',
        dataType: 'JSON',
        success : function(res) {
            let html = '';
            if (!res || res.length === 0) {
                html = '<tr><td colspan="10" class="text-center text-muted">Tidak ada data</td></tr>';
            } else {
                $.each(res, function(i, r) {
                    let total_idr = parseFloat(r.total_amount_idr || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    let typeBadge = { daily: 'badge-primary', weekly: 'badge-warning', monthly: 'badge-success' };
                    let typeClass = typeBadge[r.type] || 'badge-secondary';
                    html += `<tr data-doc="${r.doc_number}" data-type="${r.type || ''}">
                        <td class="text-center">${i + 1}</td>
                        <td>${r.doc_number}</td>
                        <td class="text-center">${r.periode_dari}</td>
                        <td class="text-center">${r.periode_sampai}</td>
                        <td class="text-center"><span class="badge ${typeClass}">${r.type || '-'}</span></td>
                        <td class="text-center">${r.total_invoice}</td>
                        <td class="text-right">${total_idr}</td>
                        <td>${r.created_by}</td>
                        <td class="text-center">${r.created_at}</td>
                        <td class="text-center" style="white-space:nowrap;">
                            <button class="btn btn-info btn-xs" onclick="view_history_detail('${r.doc_number}')">
                                <i class="fa fa-eye"></i> View
                            </button>
                            <button class="btn btn-danger btn-xs ml-1" onclick="cancel_history_projection('${r.doc_number}')">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </td>
                    </tr>`;
                });
            }
            $('#tbody-history-list').html(html);
        },
        error: function() { alert('Error loading data.'); }
    });
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

    // ── THEAD ──
    let hdrBg  = 'background-color:#FFE4C4;';
    let projBg = 'background-color:#90EE90;';
    let thStyle = 'style="white-space:nowrap; padding:4px 8px; border:1px solid #dee2e6; text-align:center; font-size:11px;' ;

    let thead = `<tr>
        <th ${thStyle + hdrBg}" rowspan="2">No</th>
        <th ${thStyle + hdrBg}" rowspan="2">Customer</th>
        <th ${thStyle + hdrBg}" rowspan="2">Reff Number</th>
        <th ${thStyle + hdrBg}" rowspan="2">Reff Date</th>
        <th ${thStyle + hdrBg}" rowspan="2">Category</th>
        <th ${thStyle + hdrBg}" rowspan="2">Due Date</th>
        <th ${thStyle + hdrBg}" rowspan="2">Due Date Update</th>
        <th ${thStyle + hdrBg}" rowspan="2">TOP</th>
        <th ${thStyle + hdrBg}" rowspan="2">Curr</th>
        <th ${thStyle + hdrBg}" rowspan="2">Amount</th>
        <th ${thStyle + hdrBg}" rowspan="2">Rate</th>
        <th ${thStyle + hdrBg}" rowspan="2">Amount IDR</th>
        <th ${thStyle + projBg}" colspan="${dates.length}">Duedate Projection</th>
    </tr><tr>`;
    dates.forEach(function(d) {
        thead += `<th ${thStyle + projBg}">${formatDate(d)}</th>`;
    });
    thead += '</tr>';
    $('#thead-history-detail').html(thead);

    // ── TBODY ──
    let tbody = '';
    let grandTotal = 0;
    let dateTotals = {};
    dates.forEach(d => dateTotals[d] = 0);

    let tdStyle = 'style="padding:4px 8px; border:1px solid #dee2e6; white-space:nowrap; font-size:11px;';

    rows.forEach(function(r, i) {
        grandTotal += parseFloat(r.amount_idr || 0);
        tbody += `<tr>
            <td ${tdStyle} text-align:center;">${i + 1}</td>
            <td ${tdStyle}">${r.customer}</td>
            <td ${tdStyle}">${r.no_invoice}</td>
            <td ${tdStyle} text-align:center;">${r.inv_date}</td>
            <td ${tdStyle} text-align:center;">${r.shipp}</td>
            <td ${tdStyle} text-align:center;">${r.duedate}</td>
            <td ${tdStyle} text-align:center;">${r.duedate_update || ''}</td>
            <td ${tdStyle} text-align:center;">${r.top}</td>
            <td ${tdStyle} text-align:center;">${r.curr}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.amount)}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.rate)}</td>
            <td ${tdStyle} text-align:right;">${fmt(r.amount_idr)}</td>`;

        dates.forEach(function(d) {
            let val = (r.duedate_update === d) ? parseFloat(r.amount_idr || 0) : 0.00;
            if (val !== 0) dateTotals[d] += val;
            tbody += `<td ${tdStyle} text-align:right;">${val !== 0 ? fmt(val) : 0.00}</td>`;
        });
        tbody += '</tr>';
    });
    $('#tbody-history-detail').html(tbody);

    // ── TFOOT ──
    let tfoot = `<tr style="background-color:#FFE4C4; font-weight:bold;">
        <td ${tdStyle} text-align:center;" colspan="11">TOTAL</td>
        <td ${tdStyle} text-align:right;">${fmt(grandTotal)}</td>`;
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

function formatDate(ymd) {
    let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    let p = ymd.split('-');
    return p[2] + ' ' + months[parseInt(p[1]) - 1] + ' ' + p[0];
}

function apply_history_filter() {
    let keyword  = ($('#hist_doc_filter').val() || '').toLowerCase().trim();
    let typeFilter = ($('#hist_type').val() || '').toLowerCase();

    $('#tbody-history-list tr').each(function() {
        let doc  = ($(this).data('doc')  || '').toLowerCase();
        let type = ($(this).data('type') || '').toLowerCase();

        let matchDoc  = !keyword    || doc.indexOf(keyword) > -1;
        let matchType = !typeFilter || type === typeFilter;

        $(this).toggle(matchDoc && matchType);
    });
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
