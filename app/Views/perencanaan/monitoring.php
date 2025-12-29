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
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'perencanaan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Monitoring Anggaran Tahun <?= $rapb['tahun'] ?></h5>
                    <a href="<?= base_url('perencanaan') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <!-- Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Target Pendapatan</h6>
                                <h4 class="text-success">Rp <?= number_format($rapb['total_target_pendapatan'], 0, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Realisasi Pendapatan</h6>
                                <h4 class="text-primary">Rp <?= number_format($rapb['realisasi_pendapatan'], 0, ',', '.') ?></h4>
                                <small class="text-muted"><?= number_format($rapb['persen_pendapatan'], 1) ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Rencana Belanja</h6>
                                <h4 class="text-warning">Rp <?= number_format($rapb['total_rencana_belanja'], 0, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Realisasi Belanja</h6>
                                <h4 class="text-danger">Rp <?= number_format($rapb['realisasi_belanja'], 0, ',', '.') ?></h4>
                                <small class="text-muted"><?= number_format($rapb['persen_belanja'], 1) ?>%</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bars -->
                <div class="row">
                    <div class="col-md-6">
                        <h6>Progress Pendapatan</h6>
                        <div class="progress mb-3" style="height: 30px;">
                            <?php
                            $pendapatanClass = $rapb['persen_pendapatan'] >= 80 ? 'bg-success' : 
                                               ($rapb['persen_pendapatan'] >= 50 ? 'bg-warning' : 'bg-danger');
                            ?>
                            <div class="progress-bar <?= $pendapatanClass ?>" style="width: <?= min($rapb['persen_pendapatan'], 100) ?>%">
                                <?= number_format($rapb['persen_pendapatan'], 1) ?>%
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6>Progress Belanja</h6>
                        <div class="progress mb-3" style="height: 30px;">
                            <?php
                            $belanjaClass = $rapb['persen_belanja'] > 90 ? 'bg-danger' : 
                                           ($rapb['persen_belanja'] > 75 ? 'bg-warning' : 'bg-info');
                            ?>
                            <div class="progress-bar <?= $belanjaClass ?>" style="width: <?= min($rapb['persen_belanja'], 100) ?>%">
                                <?= number_format($rapb['persen_belanja'], 1) ?>%
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Saldo -->
                <div class="alert alert-info mt-4">
                    <?php $saldo = $rapb['realisasi_pendapatan'] - $rapb['realisasi_belanja']; ?>
                    <h5 class="mb-0">
                        <i class="fas fa-wallet me-2"></i>
                        Saldo Realisasi: <strong>Rp <?= number_format($saldo, 0, ',', '.') ?></strong>
                    </h5>
                </div>

                <!-- Variance Analysis -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Variance Pendapatan</h6>
                            </div>
                            <div class="card-body">
                                <?php $varPendapatan = $rapb['realisasi_pendapatan'] - $rapb['total_target_pendapatan']; ?>
                                <h4 class="<?= $varPendapatan >= 0 ? 'text-success' : 'text-danger' ?>">
                                    Rp <?= number_format(abs($varPendapatan), 0, ',', '.') ?>
                                </h4>
                                <p class="mb-0"><?= $varPendapatan >= 0 ? 'Di atas target' : 'Di bawah target' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h6 class="mb-0">Variance Belanja</h6>
                            </div>
                            <div class="card-body">
                                <?php $varBelanja = $rapb['total_rencana_belanja'] - $rapb['realisasi_belanja']; ?>
                                <h4 class="<?= $varBelanja >= 0 ? 'text-success' : 'text-danger' ?>">
                                    Rp <?= number_format(abs($varBelanja), 0, ',', '.') ?>
                                </h4>
                                <p class="mb-0"><?= $varBelanja >= 0 ? 'Hemat' : 'Over budget' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
