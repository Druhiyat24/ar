<?php
$filter = isset($filter) ? $filter : '';
$uom    = ($filter === 'NAK') ? 'Kilogram' : 'PCS';

$rows = [];
foreach ($events as $dp) {
    $qty = (float) $dp['qty'];
    $rows[] = [
        'customer'   => $dp['customer'],
        'qty'        => $qty,
        'total'      => (float) $dp['eqv_idr'],
        'avg_price'  => $qty > 0 ? ((float) $dp['eqv_idr'] / $qty) : 0,
        'uom'        => $uom,
    ];
}
usort($rows, function ($a, $b) { return $b['total'] <=> $a['total']; });

$ttl_qty = 0; $ttl_total = 0; $max_total = 0;
foreach ($rows as $r) {
    $ttl_qty += $r['qty'];
    $ttl_total += $r['total'];
    if ($r['total'] > $max_total) $max_total = $r['total'];
}
if ($max_total <= 0) $max_total = 1;
$cust_count = count($rows);
$top = $cust_count > 0 ? $rows[0] : null;
$top_pct = ($top && $ttl_total > 0) ? ($top['total'] / $ttl_total * 100) : 0;
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
        <div class="sls-sum-label">Total Qty (<?= $uom; ?>)</div>
        <div class="sls-sum-value"><?= number_format($ttl_qty, 0); ?></div>
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
                    <div class="sls-cust-fig-value"><?= ($r['uom'] == 'PCS') ? number_format($r['qty'], 0) : number_format($r['qty'], 2); ?> <?= $r['uom']; ?></div>
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
