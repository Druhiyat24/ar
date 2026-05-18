<style>
/* ===== Sticky Header ===== */
#table-projection-report thead th {
    position: sticky !important;
    top: 0 !important;
    z-index: 30;
    background: #FFE4C4;
    text-transform: capitalize;
    vertical-align: middle;
    text-align: center;
    white-space: nowrap;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
}

/* Row-2: top di-set JS setelah render */
#table-projection-report thead tr:nth-child(2) th {
    z-index: 29;
    background: #90EE90;
}

/* ===== Freeze Kolom Header (top+left) ===== */
#table-projection-report th:nth-child(1) { left:0 !important;     z-index:41 !important; }
#table-projection-report th:nth-child(2) { left:30px !important;  z-index:41 !important; }
#table-projection-report th:nth-child(3) { left:230px !important; z-index:41 !important; }
#table-projection-report th:nth-child(4) { left:430px !important; z-index:41 !important; }

/* ===== Body ===== */
#table-projection-report tbody td {
    vertical-align: middle;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
    background: #fff;
}

#table-projection-report tbody tr:hover td { background-color: #f9f9f9; }

/* ===== Freeze Kolom Body ===== */
#table-projection-report td:nth-child(1) { position:sticky !important; left:0 !important;     z-index:20; background:#fff; }
#table-projection-report td:nth-child(2) { position:sticky !important; left:30px !important;  z-index:20; background:#fff; }
#table-projection-report td:nth-child(3) { position:sticky !important; left:230px !important; z-index:20; background:#fff; }
#table-projection-report td:nth-child(4) { position:sticky !important; left:430px !important; z-index:20; background:#fff; }

/* ===== Search box ===== */
.table-header { display:flex; justify-content:flex-end; margin-bottom:8px; }
.search-box { position:relative; }
.search-box input { padding:6px 30px 6px 10px; border:1px solid #ccc; border-radius:4px; }
.search-box i { position:absolute; right:10px; top:50%; transform:translateY(-50%); color:#888; pointer-events:none; }
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
                                <h3 class="card-title"><?= $title; ?></h3>
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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Detail Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-header">
                            <div class="search-box">
                                <input type="text" id="tableSearch" placeholder="Search...">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <!-- single overflow container — kunci sticky bekerja -->
                        <div id="proj-table-wrap" style="max-height:500px; overflow:auto; position:relative;">
                            <table id="table-projection-report" class="table table-bordered table-striped text-nowrap" style="border-collapse:collapse; width:max-content;">
                                <thead>
                                    <tr>
                                        <th style="width:30px;background-color:#FFE4C4;" rowspan="2">No</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Customer</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Reff Number</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Reff Date</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Category</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Due Date</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Due Date Update</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">TOP</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Curr</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Total</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Rate</th>
                                        <th style="width:200px;background-color:#FFE4C4;" rowspan="2">Total IDR</th>
                                        <th style="background-color:#90EE90;" colspan="">Duedate Projection</th>
                                    </tr>
                                    <tr>
                                        <th style="width:150px;background-color:#90EE90;"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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

document.getElementById("tableSearch").addEventListener("keyup", function() {
    let value = this.value.toLowerCase().trim();
    let rows = document.querySelectorAll("#table-projection-report tbody tr");
    rows.forEach(function(row) {
        let colsToSearch = [1,2,4,5,6,8,9,10,13];
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
