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
        .stats-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); text-align: center; }
        .card-custom { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 20px; }
        .project-item { border-left: 4px solid #2563EB; padding: 20px; margin-bottom: 15px; border-radius: 8px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'perencanaan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-project-diagram fa-2x text-primary mb-2"></i>
                        <h3><?= $stats['total'] ?></h3>
                        <p class="text-muted mb-0">Total Proyek</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-file-alt fa-2x text-warning mb-2"></i>
                        <h3><?= $stats['proposal'] ?></h3>
                        <p class="text-muted mb-0">Proposal</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-cogs fa-2x text-info mb-2"></i>
                        <h3><?= $stats['on_progress'] ?></h3>
                        <p class="text-muted mb-0">Sedang Berjalan</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h3><?= $stats['selesai'] ?></h3>
                        <p class="text-muted mb-0">Selesai</p>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="card-custom">
                <form method="GET" class="row g-2">
                    <div class="col-md-3">
                        <select name="priority" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Priority</option>
                            <option value="High" <?= $priority_filter == 'High' ? 'selected' : '' ?>>High</option>
                            <option value="Medium" <?= $priority_filter == 'Medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="Low" <?= $priority_filter == 'Low' ? 'selected' : '' ?>>Low</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="proposal" <?= $status_filter == 'proposal' ? 'selected' : '' ?>>Proposal</option>
                            <option value="approved" <?= $status_filter == 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="survey" <?= $status_filter == 'survey' ? 'selected' : '' ?>>Survey</option>
                            <option value="pelaksanaan" <?= $status_filter == 'pelaksanaan' ? 'selected' : '' ?>>Pelaksanaan</option>
                            <option value="selesai" <?= $status_filter == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                    <?php if ($priority_filter || $status_filter): ?>
                        <div class="col-md-2">
                            <a href="<?= base_url('pembangunan') ?>" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times me-1"></i>Reset
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Projects List -->
            <div class="card-custom">
                <h5 class="mb-3"><i class="fas fa-list me-2 text-primary"></i>Daftar Proyek</h5>
                
                <?php if (!empty($list_proyek)): ?>
                    <?php foreach ($list_proyek as $project): ?>
                        <?php
                        $priorityColors = ['High' => '#EF4444', 'Medium' => '#F59E0B', 'Low' => '#10B981'];
                        $statusBadges = [
                            'proposal' => 'bg-secondary',
                            'approved' => 'bg-primary',
                            'survey' => 'bg-info',
                            'pelaksanaan' => 'bg-warning',
                            'selesai' => 'bg-success',
                            'ditunda' => 'bg-danger'
                        ];
                        ?>
                        <div class="project-item" style="border-left-color: <?= $priorityColors[$project['priority']] ?>;">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <h6 class="mb-2"><?= esc($project['nama_proyek']) ?></h6>
                                    <p class="text-muted mb-2 small">
                                        <i class="fas fa-map-marker-alt me-1"></i><?= esc($project['lokasi']) ?> •
                                        <i class="fas fa-calendar ms-2 me-1"></i><?= date('d M Y', strtotime($project['timeline_mulai'])) ?> - <?= date('d M Y', strtotime($project['timeline_selesai'])) ?>
                                    </p>
                                    <div>
                                        <span class="badge <?= $statusBadges[$project['status']] ?>"><?= ucfirst($project['status']) ?></span>
                                        <span class="badge bg-<?= $project['priority'] == 'High' ? 'danger' : ($project['priority'] == 'Medium' ? 'warning' : 'success') ?> ms-2">
                                            Priority: <?= $project['priority'] ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <small class="text-muted">Progress Fisik</small>
                                        <div class="progress mt-1" style="height: 20px;">
                                            <div class="progress-bar bg-success" style="width: <?= $project['progress_fisik'] ?>%">
                                                <?= $project['progress_fisik'] ?>%
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Budget: Rp <?= number_format($project['estimasi_biaya'], 0, ',', '.') ?></small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="<?= base_url('pembangunan/detail/' . $project['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center py-4">Tidak ada proyek pembangunan</p>
                <?php endif; ?>
            </div>

            <!-- Budget Summary -->
            <div class="card-custom">
                <h6><i class="fas fa-money-bill-wave me-2 text-success"></i>Total Estimasi Budget</h6>
                <h3 class="text-success mb-0">Rp <?= number_format($stats['total_budget'], 0, ',', '.') ?></h3>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
