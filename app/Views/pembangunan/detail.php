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
        .info-row { border-bottom: 1px solid #f1f5f9; padding: 15px 0; }
        .info-row:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'perencanaan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Detail Proyek</h5>
                            <a href="<?= base_url('pembangunan') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>

                        <!-- Status & Priority -->
                        <div class="mb-4">
                            <?php
                            $statusBadges = [
                                'proposal' => 'bg-secondary',
                                'approved' => 'bg-primary',
                                'survey' => 'bg-info',
                                'pelaksanaan' => 'bg-warning',
                                'selesai' => 'bg-success',
                                'ditunda' => 'bg-danger'
                            ];
                            $priorityBadges = [ 'High' => 'bg-danger', 'Medium' => 'bg-warning', 'Low' => 'bg-success' ];
                            ?>
                            <span class="badge <?= $statusBadges[$proyek['status']] ?> fs-6"><?= ucfirst($proyek['status']) ?></span>
                            <span class="badge <?= $priorityBadges[$proyek['priority']] ?> fs-6 ms-2">Priority: <?= $proyek['priority'] ?></span>
                        </div>

                        <!-- Info -->
                        <div class="info-row">
                            <h4><?= esc($proyek['nama_proyek']) ?></h4>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 fw-bold text-muted">Lokasi</div>
                            <div class="col-md-9"><i class="fas fa-map-marker-alt me-2 text-danger"></i><?= esc($proyek['lokasi']) ?></div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 fw-bold text-muted">Timeline</div>
                            <div class="col-md-9">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                <?= date('d F Y', strtotime($proyek['timeline_mulai'])) ?> - <?= date('d F Y', strtotime($proyek['timeline_selesai'])) ?>
                            </div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 fw-bold text-muted">Estimasi Biaya</div>
                            <div class="col-md-9"><strong class="text-success">Rp <?= number_format($proyek['estimasi_biaya'], 0, ',', '.') ?></strong></div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 fw-bold text-muted">Realisasi Biaya</div>
                            <div class="col-md-9">
                                <strong class="text-info">Rp <?= number_format($proyek['realisasi_biaya'], 0, ',', '.') ?></strong>
                                <?php if ($proyek['estimasi_biaya'] > 0): ?>
                                    <small class="text-muted">(<?= number_format(($proyek['realisasi_biaya']/$proyek['estimasi_biaya'])*100, 1) ?>%)</small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 fw-bold text-muted">Sumber Dana</div>
                            <div class="col-md-9"><?= esc($proyek['sumber_dana']) ?></div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 fw-bold text-muted">Progress Fisik</div>
                            <div class="col-md-9">
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success" style="width: <?= $proyek['progress_fisik'] ?>%">
                                        <?= $proyek['progress_fisik'] ?>%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 fw-bold text-muted">Deskripsi</div>
                            <div class="col-md-9"><?= nl2br(esc($proyek['deskripsi'])) ?></div>
                        </div>

                        <?php if ($proyek['manfaat']): ?>
                            <div class="row info-row">
                                <div class="col-md-3 fw-bold text-muted">Manfaat</div>
                                <div class="col-md-9"><?= nl2br(esc($proyek['manfaat'])) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if ($proyek['kendala']): ?>
                            <div class="row info-row">
                                <div class="col-md-3 fw-bold text-muted">Kendala</div>
                                <div class="col-md-9">
                                    <div class="alert alert-warning mb-0"><?= nl2br(esc($proyek['kendala'])) ?></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row info-row">
                            <div class="col-md-3 fw-bold text-muted">Dibuat</div>
                            <div class="col-md-9"><small class="text-muted"><?= date('d F Y H:i', strtotime($proyek['created_at'])) ?></small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
