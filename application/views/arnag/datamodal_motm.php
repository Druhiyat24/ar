<?php
// $events sekarang bisa lebih dari 1 baris buat customer yang sama (1 baris per
// profit_center, lihat Model_nag::load_det_motm/load_det_motm2) - digabung
// disini biar tetap 1 kartu per customer, tapi qty-nya dipecah per satuan
// aslinya (bukan ditumpuk jadi 1 angka pakai 1 label satuan yang belum tentu
// benar buat semuanya, misal customer yang beli dari NAG (PCS) dan NAK
// (Kilogram) sekaligus).
$rows_by_customer = [];
foreach ($events as $dp) {
    $cust = $dp['customer'];
    $qty  = (float) $dp['qty'];
    $uom  = (isset($dp['profit_center']) && $dp['profit_center'] === 'NAK') ? 'Kilogram' : 'PCS';
    if (!isset($rows_by_customer[$cust])) {
        $rows_by_customer[$cust] = ['customer' => $cust, 'total' => 0, 'qty_by_uom' => []];
    }
    $rows_by_customer[$cust]['total'] += (float) $dp['eqv_idr'];
    $rows_by_customer[$cust]['qty_by_uom'][$uom] = ($rows_by_customer[$cust]['qty_by_uom'][$uom] ?? 0) + $qty;
}

$rows = [];
foreach ($rows_by_customer as $r) {
    $qty_sum = array_sum($r['qty_by_uom']);
    $r['qty']       = $qty_sum;
    $r['avg_price'] = $qty_sum > 0 ? ($r['total'] / $qty_sum) : 0;
    $rows[] = $r;
}
usort($rows, function ($a, $b) { return $b['total'] <=> $a['total']; });

$ttl_total = 0; $max_total = 0; $qty_by_uom_all = [];
foreach ($rows as $r) {
    $ttl_total += $r['total'];
    if ($r['total'] > $max_total) $max_total = $r['total'];
    foreach ($r['qty_by_uom'] as $uom => $q) {
        $qty_by_uom_all[$uom] = ($qty_by_uom_all[$uom] ?? 0) + $q;
    }
}
if ($max_total <= 0) $max_total = 1;
$cust_count = count($rows);
$top = $cust_count > 0 ? $rows[0] : null;
$top_pct = ($top && $ttl_total > 0) ? ($top['total'] / $ttl_total * 100) : 0;

// Format qty sesuai satuan (PCS = tanpa desimal, selain itu 2 desimal).
$fmt_qty = function ($q, $uom) { return number_format($q, $uom === 'PCS' ? 0 : 2); };
?>
<div class="sls-sum-strip" id="sls-sum-motm">
    <div class="sls-sum-card">
        <i class="fas fa-users sls-sum-icon" style="color:#1565c0;"></i>
        <div class="sls-sum-label">Customers</div>
        <div class="sls-sum-value"><?= $cust_count; ?></div>
        <div class="sls-sum-sub">contributing this period</div>
    </div>
    <div class="sls-sum-card">
        <i class="fas fa-boxes sls-sum-icon" style="color:#00897b;"></i>
        <?php if (count($qty_by_uom_all) > 1) : ?>
            <div class="sls-sum-label">Total Qty</div>
            <div class="sls-sum-curr-list">
                <?php foreach ($qty_by_uom_all as $uom => $q) : ?>
                    <div class="sls-sum-curr-row"><span class="curr-code"><?= htmlspecialchars($uom); ?></span><span class="curr-amt"><?= $fmt_qty($q, $uom); ?></span></div>
                <?php endforeach; ?>
            </div>
        <?php else :
            $only_uom = $qty_by_uom_all ? array_key_first($qty_by_uom_all) : 'PCS';
        ?>
            <div class="sls-sum-label">Total Qty (<?= htmlspecialchars($only_uom); ?>)</div>
            <div class="sls-sum-value"><?= $fmt_qty(array_sum($qty_by_uom_all), $only_uom); ?></div>
        <?php endif; ?>
        <div class="sls-sum-sub">across all customers</div>
    </div>
    <div class="sls-sum-card" style="background:linear-gradient(135deg,#1565c0 0%,#42a5f5 100%); flex:1.4; min-width:220px;">
        <i class="fas fa-sack-dollar sls-sum-icon" style="color:#fff;"></i>
        <div class="sls-sum-label" style="color:rgba(255,255,255,0.75);">Total Value (IDR)</div>
        <div class="sls-sum-value" style="color:#fff;"><?= number_format($ttl_total, 2); ?></div>
        <div class="sls-sum-sub" style="color:rgba(255,255,255,0.8);">
            <?php if ($top): ?>Top: <?= htmlspecialchars($top['customer']); ?> (<?= number_format($top_pct, 1); ?>%)<?php endif; ?>
        </div>
    </div>
</div>

<div class="sls-search-wrap d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
    <div class="input-group input-group-sm" style="max-width:320px;">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
        <input type="text" class="form-control" placeholder="Search customer..." oninput="_slsFilterCards(this, 'motm-cust-list')">
    </div>
</div>

<div class="sls-cust-list" id="motm-cust-list">
    <?php foreach ($rows as $i => $r) : ?>
        <div class="sls-cust-card" data-sls-name="<?= strtolower($r['customer']); ?>">
            <div class="sls-cust-rank<?= $i < 3 ? ' top3' : ''; ?>">#<?= $i + 1; ?></div>
            <div class="sls-cust-body">
                <div class="sls-cust-name"><?= htmlspecialchars($r['customer']); ?></div>
                <div class="sls-cust-bar-track">
                    <div class="sls-cust-bar" style="width:<?= min(100, $r['total'] / $max_total * 100); ?>%;"></div>
                </div>
            </div>
            <div class="sls-cust-fig">
                <div class="sls-cust-fig-label">% of Total</div>
                <div class="sls-cust-pct"><?= $ttl_total > 0 ? number_format($r['total'] / $ttl_total * 100, 1) : '0.0'; ?>%</div>
            </div>
            <div class="sls-cust-figures">
                <div class="sls-cust-fig">
                    <div class="sls-cust-fig-label">Qty</div>
                    <div class="sls-cust-fig-value"><?= implode('<br>', array_map(function ($uom, $q) use ($fmt_qty) { return $fmt_qty($q, $uom) . ' ' . $uom; }, array_keys($r['qty_by_uom']), array_values($r['qty_by_uom']))); ?></div>
                </div>
                <div class="sls-cust-fig">
                    <div class="sls-cust-fig-label">Avg Price</div>
                    <div class="sls-cust-fig-value">IDR <?= number_format($r['avg_price'], 2); ?></div>
                </div>
                <div class="sls-cust-fig wide">
                    <div class="sls-cust-fig-label">Total</div>
                    <div class="sls-cust-fig-value emph">IDR <?= number_format($r['total'], 2); ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <p class="sls-no-result" style="display:none;color:#aaa;text-align:center;padding:20px;">No customer matches your search.</p>
</div>
