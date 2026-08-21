<?php
// $events sekarang bisa lebih dari 1 baris buat customer yang sama (1 baris per
// profit_center, lihat Model_nag::load_det_sales5) - digabung disini biar tetap
// 1 kartu per customer, tapi qty-nya dipecah per satuan aslinya (bukan ditumpuk
// jadi 1 angka pakai 1 label satuan yang belum tentu benar buat semuanya).
$qty_by_uom = [];
$total = 0;
$customer_name = null;
foreach ($events as $r) {
    if ($customer_name === null) $customer_name = $r['customer'];
    $uom = (isset($r['profit_center']) && $r['profit_center'] === 'NAK') ? 'Kilogram' : 'PCS';
    $qty_by_uom[$uom] = ($qty_by_uom[$uom] ?? 0) + (float) $r['qty'];
    $total += (float) $r['eqv_idr'];
}
$ttl_qty = array_sum($qty_by_uom);
$avg = $ttl_qty > 0 ? $total / $ttl_qty : 0;
?>
<?php if ($customer_name === null) : ?>
    <p style="color:#aaa;text-align:center;padding:30px;">No data.</p>
<?php else : ?>
    <div style="display:flex;align-items:center;gap:14px;padding:2px 2px 18px;border-bottom:1px solid #eef0f5;margin-bottom:18px;">
        <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#00838f,#26c6da);display:flex;align-items:center;justify-content:center;color:#fff;font-size:22px;flex-shrink:0;">
            <i class="fas fa-building"></i>
        </div>
        <div>
            <div style="font-size:17px;font-weight:800;color:#1a2340;"><?= htmlspecialchars($customer_name); ?></div>
            <div style="font-size:12px;color:#9aa0b8;font-weight:600;">Top buyer detail for the selected period</div>
        </div>
    </div>

    <div class="sls-sum-strip" style="margin-bottom:0;">
        <div class="sls-sum-card">
            <i class="fas fa-boxes sls-sum-icon" style="color:#00838f;"></i>
            <?php if (count($qty_by_uom) > 1) : ?>
                <div class="sls-sum-label">Qty</div>
                <div class="sls-sum-curr-list">
                    <?php foreach ($qty_by_uom as $uom => $q) : ?>
                        <div class="sls-sum-curr-row"><span class="curr-code"><?= htmlspecialchars($uom); ?></span><span class="curr-amt"><?= number_format($q, $uom === 'PCS' ? 0 : 2); ?></span></div>
                    <?php endforeach; ?>
                </div>
            <?php else :
                $only_uom = $qty_by_uom ? array_key_first($qty_by_uom) : 'PCS';
            ?>
                <div class="sls-sum-label">Qty (<?= htmlspecialchars($only_uom); ?>)</div>
                <div class="sls-sum-value"><?= number_format($ttl_qty, $only_uom === 'PCS' ? 0 : 2); ?></div>
            <?php endif; ?>
        </div>
        <div class="sls-sum-card">
            <i class="fas fa-tag sls-sum-icon" style="color:#00838f;"></i>
            <div class="sls-sum-label">Avg Sales Price</div>
            <div class="sls-sum-value">IDR <?= number_format($avg, 2); ?></div>
        </div>
        <div class="sls-sum-card" style="background:linear-gradient(135deg,#00838f 0%,#26c6da 100%);border:none;">
            <i class="fas fa-sack-dollar sls-sum-icon" style="color:#fff;opacity:0.25;"></i>
            <div class="sls-sum-label" style="color:rgba(255,255,255,0.8);">Total Value</div>
            <div class="sls-sum-value" style="color:#fff;">IDR <?= number_format($total, 2); ?></div>
        </div>
    </div>
<?php endif; ?>
