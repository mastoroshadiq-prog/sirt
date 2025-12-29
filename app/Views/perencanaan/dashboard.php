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
        .progress-ring { position: relative; display: inline-block; }
        .progress-value { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 1.5rem; font-weight: 700; }
        .project-card { border-left: 4px solid #2563EB; padding: 15px; border-radius: 8px; background: #F9FAFB; margin-bottom: 10px; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'perencanaan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- RKT Status -->
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <div class="card-custom">
                        <h5 class="mb-3"><i class="fas fa-tasks me-2 text-primary"></i>Rencana Kerja Tahunan (RKT)</h5>
                        <?php if ($active_rkt): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Tahun <?= $active_rkt['tahun'] ?></h6>
                                    <p class="text-muted mb-2">Periode: <?= date('d M Y', strtotime($active_rkt['periode_mulai'])) ?> - <?= date('d M Y', strtotime($active_rkt['periode_selesai'])) ?></p>
                                    <p class="mb-0"><strong>Visi:</strong> <?= esc($active_rkt['visi']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <?php if ($rkt_summary): ?>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <h3 class="text-primary"><?= $rkt_summary['jumlah_program'] ?></h3>
                                                <small class="text-muted">Program Kerja</small>
                                            </div>
                                            <div class="col-6">
                                                <h3 class="text-success"><?= $rkt_summary['jumlah_kegiatan'] ?></h3>
                                                <small class="text-muted">Rencana Kegiatan</small>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Belum ada RKT aktif. <a href="<?= base_url('perencanaan/rkt') ?>">Buat RKT baru</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(139, 92, 246, 0.1); color: #8B5CF6;">
                            <i class="fas fa-hammer"></i>
                        </div>
                        <h3 class="mb-1"><?= $project_stats['total'] ?></h3>
                        <p class="text-muted mb-0">Proyek Pembangunan</p>
                        <small class="text-muted"><?= $project_stats['on_progress'] ?> sedang berjalan</small>
                    </div>
                </div>
            </div>

            <!-- RAPB Monitoring -->
            <?php if ($rapb_realisasi): ?>
            <div class="card-custom mb-4">
                <h5 class="mb-3"><i class="fas fa-chart-line me-2 text-primary"></i>Monitoring RAPB Tahun <?= $rapb_realisasi['tahun'] ?></h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Pendapatan</h6>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Target: Rp <?= number_format($rapb_realisasi['total_target_pendapatan'], 0, ',', '.') ?></span>
                                <span class="fw-bold"><?= number_format($rapb_realisasi['persen_pendapatan'], 1) ?>%</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <?php
                                $pendapatanClass = $rapb_realisasi['persen_pendapatan'] >= 80 ? 'bg-success' : 
                                                   ($rapb_realisasi['persen_pendapatan'] >= 50 ? 'bg-warning' : 'bg-danger');
                                ?>
                                <div class="progress-bar <?= $pendapatanClass ?>" style="width: <?= min($rapb_realisasi['persen_pendapatan'], 100) ?>%">
                                    Rp <?= number_format($rapb_realisasi['realisasi_pendapatan'], 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6>Belanja</h6>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Anggaran: Rp <?= number_format($rapb_realisasi['total_rencana_belanja'], 0, ',', '.') ?></span>
                                <span class="fw-bold"><?= number_format($rapb_realisasi['persen_belanja'], 1) ?>%</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <?php
                                $belanjaClass = $rapb_realisasi['persen_belanja'] > 90 ? 'bg-danger' : 
                                               ($rapb_realisasi['persen_belanja'] > 75 ? 'bg-warning' : 'bg-info');
                                ?>
                                <div class="progress-bar <?= $belanjaClass ?>" style="width: <?= min($rapb_realisasi['persen_belanja'], 100) ?>%">
                                    Rp <?= number_format($rapb_realisasi['realisasi_belanja'], 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <?php
                    $saldo = $rapb_realisasi['realisasi_pendapatan'] - $rapb_realisasi['realisasi_belanja'];
                    ?>
                    <div class="alert alert-info mb-0">
                        <strong>Saldo Realisasi:</strong> Rp <?= number_format($saldo, 0, ',', '.') ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="card-custom mb-4">
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Belum ada RAPB aktif. <a href="<?= base_url('perencanaan/rapb') ?>">Buat RAPB baru</a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Active Projects -->
            <div class="card-custom">
                <h5 class="mb-3"><i class="fas fa-project-diagram me-2 text-primary"></i>Proyek Aktif</h5>
                <?php if (!empty($active_projects)): ?>
                    <?php foreach (array_slice($active_projects, 0, 5) as $project): ?>
                        <?php
                        $priorityColors = [
                            'High' => '#EF4444',
                            'Medium' => '#F59E0B',
                            'Low' => '#10B981'
                        ];
                        $borderColor = $priorityColors[$project['priority']] ?? '#2563EB';
                        ?>
                        <div class="project-card" style="border-left-color: <?= $borderColor ?>;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= esc($project['nama_proyek']) ?></h6>
                                    <p class="text-muted mb-2 small">
                                        <i class="fas fa-map-marker-alt me-1"></i><?= esc($project['lokasi']) ?> •
                                        <i class="fas fa-calendar ms-2 me-1"></i><?= date('M Y', strtotime($project['timeline_mulai'])) ?>
                                    </p>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" style="width: <?= $project['progress_fisik'] ?>%">
                                            <?= $project['progress_fisik'] ?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <span class="badge bg-<?= $project['priority'] == 'High' ? 'danger' : ($project['priority'] == 'Medium' ? 'warning' : 'success') ?>">
                                        <?= $project['priority'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="text-center mt-3">
                        <a href="<?= base_url('pembangunan') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>Lihat Semua Proyek
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3">Belum ada proyek pembangunan aktif</p>
                <?php endif; ?>
            </div>

            <!-- Quick Links -->
            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <a href="<?= base_url('perencanaan/rkt') ?>" class="btn btn-outline-primary w-100">
                        <i class="fas fa-clipboard me-2"></i>Kelola RKT
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url('perencanaan/rapb') ?>" class="btn btn-outline-success w-100">
                        <i class="fas fa-chart-pie me-2"></i>Kelola RAPB
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url('perencanaan/monitoring') ?>" class="btn btn-outline-warning w-100">
                        <i class="fas fa-tachometer-alt me-2"></i>Monitoring
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= base_url('pembangunan') ?>" class="btn btn-outline-info w-100">
                        <i class="fas fa-hammer me-2"></i>Pembangunan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
