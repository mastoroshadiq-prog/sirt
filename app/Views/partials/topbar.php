<div class="topbar">
    <div class="topbar-title">
        <h4 class="mb-0"><?= $title ?? 'Dashboard' ?></h4>
    </div>
    <div class="user-info" style="display: flex; align-items: center; gap: 15px;">
        <div style="text-align: right;">
            <strong><?= $user['nama_lengkap'] ?? 'User' ?></strong>
            <small class="d-block text-muted"><?= ucfirst($user['role'] ?? 'warga') ?></small>
        </div>
        <div class="user-avatar">
            <?= strtoupper(substr($user['nama_lengkap'] ?? 'U', 0, 1)) ?>
        </div>
    </div>
</div>
