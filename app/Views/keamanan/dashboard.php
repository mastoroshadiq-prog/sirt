<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Si-RT</title>
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
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .content-area { padding: 30px; }
        .stats-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
        .stats-card .icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 15px; }
        .card-custom { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 20px; }
        .menu-card { padding: 20px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 12px; color: white; text-decoration: none; display: block; transition: all 0.3s; }
        .menu-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); color: white; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'keamanan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Stats Card -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(37, 99, 235, 0.1); color: #2563EB;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="mb-1"><?= $total_anggota ?></h3>
                        <p class="text-muted mb-0">Anggota Ronda Aktif</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="mb-1"><?= count($jadwal_minggu_ini) ?></h3>
                        <p class="text-muted mb-0">Jadwal Minggu Ini</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="mb-1"><?= count($laporan_terbaru) ?></h3>
                        <p class="text-muted mb-0">Laporan Terbaru</p>
                    </div>
                </div>
            </div>

            <!-- Menu Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <a href="<?= base_url('keamanan/anggota') ?>" class="menu-card">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h5>Anggota Ronda</h5>
                        <p class="mb-0">Kelola anggota ronda</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url('keamanan/jadwal') ?>" class="menu-card" style="background: linear-gradient(135deg, #10B981, #059669);">
                        <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                        <h5>Jadwal Ronda</h5>
                        <p class="mb-0">Lihat & kelola jadwal</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url('keamanan/laporan') ?>" class="menu-card" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                        <h5>Laporan Kejadian</h5>
                        <p class="mb-0">Kejadian & insiden</p>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url('laporan/ronda') ?>" class="menu-card" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED);">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <h5>Laporan Bulanan</h5>
                        <p class="mb-0">Rekap bulanan</p>
                    </a>
                </div>
            </div>

            <!-- Informasi -->
            <div class="card-custom">
                <h5 class="mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Informasi</h5>
                <div class="alert alert-info mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Catatan:</strong> Modul Keamanan & Ronda ini dapat diakses melalui aplikasi mobile untuk fitur absensi dan pelaporan kejadian real-time.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
