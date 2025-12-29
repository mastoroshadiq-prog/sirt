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
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .content-area { padding: 30px; }
        .stats-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
        .stats-card .icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 15px; }
        .chart-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .mutasi-item { background: white; border-left: 4px solid #2563EB; padding: 15px; margin-bottom: 10px; border-radius: 8px; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'warga']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(37, 99, 235, 0.1); color: #2563EB;">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3 class="mb-1"><?= number_format($total_kk, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Total Kartu Keluarga</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="mb-1"><?= number_format($total_warga, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Total Warga Aktif</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(59, 130, 246, 0.1); color: #3B82F6;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h3 class="mb-1"><?= $mutasi_stats['baru'] + $mutasi_stats['kelahiran'] ?></h3>
                        <p class="text-muted mb-0">Warga Baru Bulan Ini</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">
                            <i class="fas fa-user-minus"></i>
                        </div>
                        <h3 class="mb-1"><?= $mutasi_stats['pindah'] + $mutasi_stats['meninggal'] ?></h3>
                        <p class="text-muted mb-0">Mutasi Keluar Bulan Ini</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="chart-card">
                        <h5 class="mb-4"><i class="fas fa-venus-mars me-2 text-primary"></i>Berdasarkan Jenis Kelamin</h5>
                        <div style="position: relative; height: 280px;">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-card">
                        <h5 class="mb-4"><i class="fas fa-pray me-2 text-success"></i>Berdasarkan Agama</h5>
                        <div style="position: relative; height: 280px;">
                            <canvas id="agamaChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-card">
                        <h5 class="mb-4"><i class="fas fa-birthday-cake me-2 text-warning"></i>Berdasarkan Usia</h5>
                        <div style="position: relative; height: 280px;">
                            <canvas id="usiaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Mutasi & Quick Actions -->
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="chart-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i>Mutasi Warga Terbaru</h5>
                            <a href="<?= base_url('warga/mutasi') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                        <?php if (empty($recent_mutasi)): ?>
                            <p class="text-muted text-center py-4">Belum ada mutasi warga</p>
                        <?php else: ?>
                            <?php foreach ($recent_mutasi as $mutasi): ?>
                                <?php
                                $badgeClass = [
                                    'baru' => 'bg-primary',
                                    'kelahiran' => 'bg-success',
                                    'pindah' => 'bg-warning',
                                    'meninggal' => 'bg-danger'
                                ][$mutasi['jenis_mutasi']] ?? 'bg-secondary';
                                ?>
                                <div class="mutasi-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="badge <?= $badgeClass ?> me-2"><?= ucfirst($mutasi['jenis_mutasi']) ?></span>
                                            <strong><?= esc($mutasi['nama_lengkap'] ?? 'N/A') ?></strong>
                                            <small class="text-muted d-block">NIK: <?= esc($mutasi['nik'] ?? '-') ?> | KK: <?= esc($mutasi['no_kk'] ?? '-') ?></small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted"><?= date('d/m/Y', strtotime($mutasi['tanggal_mutasi'])) ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="chart-card">
                        <h5 class="mb-3"><i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat</h5>
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('warga/kk/add') ?>" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Tambah KK Baru
                            </a>
                            <a href="<?= base_url('warga/add') ?>" class="btn btn-success">
                                <i class="fas fa-user-plus me-2"></i>Tambah Warga Baru
                            </a>
                            <a href="<?= base_url('warga/kk') ?>" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>Lihat Semua KK
                            </a>
                            <a href="<?= base_url('warga/list') ?>" class="btn btn-outline-success">
                                <i class="fas fa-users me-2"></i>Lihat Semua Warga
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Prevent auto-scroll and ensure charts render only after DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Gender Chart
            const genderCtx = document.getElementById('genderChart');
            const genderData = <?= json_encode($stats_gender) ?>;
            if (genderCtx) {
                new Chart(genderCtx, {
                    type: 'doughnut',
                    data: {
                        labels: genderData.map(s => s.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'),
                        datasets: [{
                            data: genderData.map(s => s.total),
                            backgroundColor: ['#2563EB', '#EC4899'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 1.2,
                        plugins: { 
                            legend: { 
                                position: 'bottom',
                                labels: { boxWidth: 15, padding: 8 }
                            } 
                        }
                    }
                });
            }

            // Agama Chart
            const agamaCtx = document.getElementById('agamaChart');
            const agamaData = <?= json_encode($stats_agama) ?>;
            if (agamaCtx) {
                new Chart(agamaCtx, {
                    type: 'bar',
                    data: {
                        labels: agamaData.map(s => s.agama),
                        datasets: [{
                            label: 'Jumlah',
                            data: agamaData.map(s => s.total),
                            backgroundColor: '#10B981'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 1.2,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            // Usia Chart
            const usiaCtx = document.getElementById('usiaChart');
            const usiaData = <?= json_encode($stats_usia) ?>;
            if (usiaCtx) {
                new Chart(usiaCtx, {
                    type: 'pie',
                    data: {
                        labels: usiaData.map(s => s.kategori_usia),
                        datasets: [{
                            data: usiaData.map(s => s.total),
                            backgroundColor: ['#F59E0B', '#3B82F6', '#8B5CF6', '#10B981', '#EF4444'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 1.2,
                        plugins: { 
                            legend: { 
                                position: 'bottom',
                                labels: { boxWidth: 15, padding: 8 }
                            } 
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
