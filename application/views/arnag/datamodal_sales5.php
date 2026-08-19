<?php
$satuan = ($filter === 'NAK') ? 'Kilogram' : 'PCS';
$row = $events[0] ?? null;
?>
<?php if (!$row) : ?>
    <p style="color:#aaa;text-align:center;padding:30px;">No data.</p>
<?php else :
    $qty   = (float) $row['qty'];
    $total = (float) $row['eqv_idr'];
    $avg   = $qty > 0 ? $total / $qty : 0;
?>
    <div style="display:flex;align-items:center;gap:14px;padding:2px 2px 18px;border-bottom:1px solid #eef0f5;margin-bottom:18px;">
        <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#00838f,#26c6da);display:flex;align-items:center;justify-content:center;color:#fff;font-size:22px;flex-shrink:0;">
            <i class="fas fa-building"></i>
        </div>
        <div>
            <div style="font-size:17px;font-weight:800;color:#1a2340;"><?= htmlspecialchars($row['customer']); ?></div>
            <div style="font-size:12px;color:#9aa0b8;font-weight:600;">Top buyer detail for the selected period</div>
        </div>
    </div>

    <div class="sls-sum-strip" style="margin-bottom:0;">
        <div class="sls-sum-card">
            <i class="fas fa-boxes sls-sum-icon" style="color:#00838f;"></i>
            <div class="sls-sum-label">Qty</div>
            <div class="sls-sum-value"><?= number_format($qty, 2); ?> <?= $satuan; ?></div>
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
