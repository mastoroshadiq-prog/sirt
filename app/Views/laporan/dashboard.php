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
        .card-custom { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 20px; }
        .report-card { padding: 25px; background: white; border-radius: 12px; border-left: 4px solid var(--primary); text-decoration: none; display: block; transition: all 0.3s; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .report-card:hover { transform: translateX(5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .report-card h5 { color: #1e293b; margin-bottom: 10px; }
        .report-card p { color: #64748b; margin-bottom: 0; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'laporan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="card-custom mb-4">
                <h5 class="mb-3"><i class="fas fa-chart-bar me-2 text-primary"></i>Pusat Laporan</h5>
                <p class="text-muted mb-0">
                    Akses berbagai laporan dan statistik untuk monitoring dan evaluasi kegiatan RT.
                </p>
            </div>

            <!-- Report Cards -->
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="<?= base_url('laporan/keuangan') ?>" class="report-card" style="border-left-color: #10B981;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-money-bill-wave fa-3x text-success"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5><i class="fas fa-arrow-right me-2"></i>Laporan Keuangan</h5>
                                <p>Rekap transaksi, pemasukan, pengeluaran, dan saldo kas RT per bulan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="<?= base_url('laporan/warga') ?>" class="report-card" style="border-left-color: #3B82F6;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-users fa-3x text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5><i class="fas fa-arrow-right me-2"></i>Laporan Warga</h5>
                                <p>Statistik demografis, jumlah KK, dan data penduduk berdasarkan kategori</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="<?= base_url('laporan/kegiatan') ?>" class="report-card" style="border-left-color: #F59E0B;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-calendar-check fa-3x text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5><i class="fas fa-arrow-right me-2"></i>Laporan Kegiatan</h5>
                                <p>Rekap kegiatan RT, anggaran, realisasi, dan kategori per periode</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="<?= base_url('laporan/ronda') ?>" class="report-card" style="border-left-color: #8B5CF6;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-shield-alt fa-3x text-purple"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5><i class="fas fa-arrow-right me-2"></i>Laporan Ronda</h5>
                                <p>Jadwal ronda, kehadiran anggota, dan laporan kejadian keamanan</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card-custom mt-4">
                <div class="alert alert-info mb-0">
                    <i class="fas fa-download me-2"></i>
                    <strong>Fitur Export:</strong> Semua laporan dapat di-export ke format Excel atau PDF untuk dokumentasi dan analisis lebih lanjut. (Fitur akan ditambahkan pada fase selanjutnya)
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
