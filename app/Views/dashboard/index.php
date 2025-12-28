<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - Si-RT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root { --primary: #2563EB; --secondary: #10B981; --sidebar-width: 260px; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #F9FAFB; }
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width); background: linear-gradient(180deg, #1E293B 0%, #0F172A 100%); color: white; overflow-y: auto; z-index: 1000; }
        .sidebar-header { padding: 25px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .sidebar-header h3 { margin: 0; font-size: 1.5rem; font-weight: 700; }
        .menu-item { padding: 12px 20px; color: rgba(255, 255, 255, 0.8); text-decoration: none; display: flex; align-items: center; transition: all 0.3s; }
        .menu-item:hover, .menu-item.active { background: rgba(255, 255, 255, 0.1); color: white; }
        .menu-item i { width: 20px; margin-right: 12px; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .content-area { padding: 30px; }
        .stats-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
        .stats-card .icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 15px; }
        .welcome-banner { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'dashboard']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <h2>Selamat Datang, <?= $user['nama_lengkap'] ?? 'User' ?>! 👋</h2>
                <p>Sistem Informasi RT - Dashboard Utama</p>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(37, 99, 235, 0.1); color: #2563EB;">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3 class="mb-1">Rp 0</h3>
                        <p class="text-muted mb-0">Saldo Kas RT</p>
                        <a href="<?= base_url('keuangan') ?>" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="mb-1">5</h3>
                        <p class="text-muted mb-0">Total KK</p>
                        <a href="<?= base_url('warga') ?>" class="btn btn-sm btn-outline-success mt-2">
                            <i class="fas fa-arrow-right me-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <h3 class="mb-1">11</h3>
                        <p class="text-muted mb-0">Total Warga</p>
                        <a href="<?= base_url('warga/list') ?>" class="btn btn-sm btn-outline-warning mt-2">
                            <i class="fas fa-arrow-right me-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(139, 92, 246, 0.1); color: #8B5CF6;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="mb-1">0</h3>
                        <p class="text-muted mb-0">Kegiatan Bulan Ini</p>
                        <small class="text-muted">Coming soon</small>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="stats-card">
                        <h5 class="mb-3"><i class="fas fa-link me-2 text-primary"></i>Akses Cepat ke Modul</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="<?= base_url('keuangan') ?>" class="btn btn-outline-primary w-100 py-3">
                                    <i class="fas fa-wallet d-block mb-2" style="font-size: 2rem;"></i>
                                    <strong>Keuangan</strong>
                                    <small class="d-block text-muted">Kas & Iuran</small>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= base_url('warga') ?>" class="btn btn-outline-success w-100 py-3">
                                    <i class="fas fa-users d-block mb-2" style="font-size: 2rem;"></i>
                                    <strong>Administrasi</strong>
                                    <small class="d-block text-muted">KK & Warga</small>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-outline-secondary w-100 py-3 disabled">
                                    <i class="fas fa-building d-block mb-2" style="font-size: 2rem;"></i>
                                    <strong>Aset</strong>
                                    <small class="d-block text-muted">Coming Soon</small>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-outline-secondary w-100 py-3 disabled">
                                    <i class="fas fa-shield-alt d-block mb-2" style="font-size: 2rem;"></i>
                                    <strong>Ronda</strong>
                                    <small class="d-block text-muted">Coming Soon</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Info -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-success">
                        <h6 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Status Sistem</h6>
                        <hr>
                        <p class="mb-2"><strong>✅ Modul Keuangan:</strong> Fully implemented - Dashboard, Buku Kas, Input Iuran Multi-Category, Status Iuran</p>
                        <p class="mb-2"><strong>✅ Modul Administrasi Warga:</strong> Fully implemented - Dashboard dengan statistik dan charts real-time</p>
                        <p class="mb-2"><strong>📊 Sample Data:</strong> 5 KK dan 11 Warga dengan demografi yang beragam</p>
                        <p class="mb-0"><strong>🚀 Siap digunakan:</strong> Login, Keuangan, Administrasi Warga</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
