<div class="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-home-lg-alt me-2"></i>Si-RT</h3>
        <p class="mb-0" style="font-size: 0.85rem; opacity: 0.7;">Sistem Informasi RT</p>
    </div>
    
    <div class="sidebar-menu" style="padding: 20px 0;">
        <a href="<?= base_url('dashboard') ?>" class="menu-item <?= isset($active) && $active == 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?= base_url('keuangan') ?>" class="menu-item <?= isset($active) && $active == 'keuangan' ? 'active' : '' ?>">
            <i class="fas fa-wallet"></i>
            <span>Keuangan</span>
        </a>
        <a href="#" class="menu-item <?= isset($active) && $active == 'warga' ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            <span>Warga</span>
        </a>
        <a href="#" class="menu-item <?= isset($active) && $active == 'kegiatan' ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i>
            <span>Kegiatan</span>
        </a>
        <a href="#" class="menu-item <?= isset($active) && $active == 'aset' ? 'active' : '' ?>">
            <i class="fas fa-building"></i>
            <span>Aset</span>
        </a>
        <a href="#" class="menu-item <?= isset($active) && $active == 'keamanan' ? 'active' : '' ?>">
            <i class="fas fa-shield-alt"></i>
            <span>Keamanan</span>
        </a>
        <a href="#" class="menu-item <?= isset($active) && $active == 'laporan' ? 'active' : '' ?>">
            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>
        <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">
        <a href="<?= base_url('auth/logout') ?>" class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>
