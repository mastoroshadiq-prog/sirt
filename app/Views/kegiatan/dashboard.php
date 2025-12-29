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
        .event-card { border-left: 4px solid var(--primary); padding: 15px; margin-bottom: 15px; background: #F9FAFB; border-radius: 8px; transition: all 0.3s; }
        .event-card:hover { background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'kegiatan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(37, 99, 235, 0.1); color: #2563EB;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="mb-1"><?= $total_kegiatan ?></h3>
                        <p class="text-muted mb-0">Total Kegiatan</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="mb-1"><?= $total_direncanakan ?></h3>
                        <p class="text-muted mb-0">Direncanakan</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="mb-1"><?= $total_selesai ?></h3>
                        <p class="text-muted mb-0">Selesai</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3 class="mb-1" style="font-size: 1.2rem;">Rp <?= number_format($total_anggaran, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Total Anggaran</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Kegiatan & Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <div class="card-custom">
                        <h5 class="mb-3"><i class="fas fa-calendar-day me-2 text-primary"></i>Kegiatan Mendatang</h5>
                        <?php if (empty($upcoming_kegiatan)): ?>
                            <p class="text-muted text-center py-3">Tidak ada kegiatan mendatang</p>
                        <?php else: ?>
                            <?php foreach ($upcoming_kegiatan as $kg): ?>
                                <?php
                                $statusColors = [
                                    'direncanakan' => '#F59E0B',
                                    'sedang_berjalan' => '#10B981',
                                    'selesai' => '#6B7280',
                                    'dibatalkan' => '#EF4444'
                                ];
                                $borderColor = $statusColors[$kg['status']] ?? '#2563EB';
                                ?>
                                <div class="event-card" style="border-left-color: <?= $borderColor ?>;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-2"><strong><?= esc($kg['nama_kegiatan']) ?></strong></h6>
                                            <p class="mb-1 text-muted">
                                                <i class="fas fa-calendar me-2"></i><?= date('d M Y', strtotime($kg['tanggal'])) ?>
                                            </p>
                                            <p class="mb-0 text-muted">
                                                <i class="fas fa-map-marker-alt me-2"></i><?= esc($kg['lokasi']) ?>
                                                <span class="badge bg-secondary ms-2"><?= $kg['kategori'] ?></span>
                                            </p>
                                        </div>
                                        <a href="<?= base_url('kegiatan/detail/' . $kg['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-custom">
                        <h5 class="mb-3"><i class="fas fa-chart-pie me-2 text-primary"></i>Kategori Kegiatan</h5>
                        <?php if (empty($stats_kategori)): ?>
                            <p class="text-muted text-center py-3">Belum ada data</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($stats_kategori as $stat): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><?= esc($stat['kategori']) ?></span>
                                        <span class="badge bg-primary rounded-pill"><?= $stat['total'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card-custom">
                        <h5 class="mb-3"><i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat</h5>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="<?= base_url('kegiatan/add') ?>" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Kegiatan
                            </a>
                            <a href="<?= base_url('kegiatan/list') ?>" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>Lihat Semua Kegiatan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
