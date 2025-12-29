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
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'aset']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(37, 99, 235, 0.1); color: #2563EB;">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3 class="mb-1"><?= number_format($total_aset, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Total Aset</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3 class="mb-1"><?= $total_kategori ?></h3>
                        <p class="text-muted mb-0">Kategori Aset</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3 class="mb-1">Rp <?= number_format($total_nilai, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Total Nilai Perolehan</p>
                    </div>
                </div>
            </div>

            <!-- Kondisi Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-12">
                    <div class="card-custom">
                        <h5 class="mb-3"><i class="fas fa-chart-bar me-2 text-primary"></i>Kondisi Aset</h5>
                        <div class="row">
                            <?php 
                            $conditionMap = [
                                'Baik' => ['count' => 0, 'icon' => 'check-circle', 'color' => '#10B981'],
                                'Rusak Ringan' => ['count' => 0, 'icon' => 'exclamation-circle', 'color' => '#F59E0B'],
                                'Rusak Berat' => ['count' => 0, 'icon' => 'times-circle', 'color' => '#EF4444']
                            ];
                            
                            foreach ($stats_condition as $stat) {
                                if (isset($conditionMap[$stat['kondisi']])) {
                                    $conditionMap[$stat['kondisi']]['count'] = $stat['total'];
                                }
                            }
                            
                            foreach ($conditionMap as $kondisi => $data):
                            ?>
                                <div class="col-md-4">
                                    <div class="text-center p-3" style="background: <?= $data['color'] ?>15; border-radius: 10px;">
                                        <i class="fas fa-<?= $data['icon'] ?> fa-2x mb-2" style="color: <?= $data['color'] ?>;"></i>
                                        <h4 style="color: <?= $data['color'] ?>;"><?= $data['count'] ?></h4>
                                        <small class="text-muted"><?= $kondisi ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori dengan Jumlah -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card-custom">
                        <h5 class="mb-3"><i class="fas fa-list me-2 text-primary"></i>Kategori Aset</h5>
                        <?php if (empty($categories_count)): ?>
                            <p class="text-muted text-center py-3">Belum ada kategori</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($categories_count as $cat): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= esc($cat['nama_kategori']) ?></strong>
                                            <br><small class="text-muted">Kode: <?= esc($cat['prefix_kode']) ?></small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill"><?= $cat['jumlah_aset'] ?> item</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Aset -->
                <div class="col-md-6">
                    <div class="card-custom">
                        <h5 class="mb-3"><i class="fas fa-clock me-2 text-primary"></i>Aset Terbaru</h5>
                        <?php if (empty($recent_aset)): ?>
                            <p class="text-muted text-center py-3">Belum ada aset</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recent_aset as $aset): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong><?= esc($aset['nama_aset']) ?></strong>
                                                <br><small class="text-muted"><?= esc($aset['kode_register']) ?></small>
                                            </div>
                                            <span class="badge bg-secondary"><?= esc($aset['nama_kategori']) ?></span>
                                        </div>
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
                            <a href="<?= base_url('aset/add') ?>" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Aset
                            </a>
                            <a href="<?= base_url('aset/inventaris') ?>" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>Lihat Inventaris
                            </a>
                            <a href="<?= base_url('aset/kategori') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-tags me-2"></i>Kelola Kategori
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
