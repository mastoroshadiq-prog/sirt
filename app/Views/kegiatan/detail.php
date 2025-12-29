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
        .card-custom { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .info-row { border-bottom: 1px solid #f1f5f9; padding: 15px 0; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-weight: 600; color: #64748b; width: 200px; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'kegiatan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Detail Kegiatan
                            </h5>
                            <div>
                                <a href="<?= base_url('kegiatan/list') ?>" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <a href="<?= base_url('kegiatan/edit/' . $kegiatan['id']) ?>" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </a>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="mb-4">
                            <?php
                            $statusBadge = [
                                'direncanakan' => 'bg-warning',
                                'sedang_berjalan' => 'bg-success',
                                'selesai' => 'bg-secondary',
                                'dibatalkan' => 'bg-danger'
                            ][$kegiatan['status']] ?? 'bg-secondary';
                            
                            $statusLabel = [
                                'direncanakan' => 'Direncanakan',
                                'sedang_berjalan' => 'Sedang Berjalan',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan'
                            ][$kegiatan['status']] ?? $kegiatan['status'];
                            ?>
                            <span class="badge <?= $statusBadge ?> fs-6"><?= $statusLabel ?></span>
                            <span class="badge bg-secondary fs-6 ms-2"><?= $kegiatan['kategori'] ?></span>
                        </div>

                        <!-- Information -->
                        <div class="row info-row">
                            <div class="col-md-3 info-label">Nama Kegiatan</div>
                            <div class="col-md-9"><strong><?= esc($kegiatan['nama_kegiatan']) ?></strong></div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 info-label">Tanggal</div>
                            <div class="col-md-9">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                <?= date('d F Y', strtotime($kegiatan['tanggal'])) ?>
                            </div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 info-label">Lokasi</div>
                            <div class="col-md-9">
                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                <?= esc($kegiatan['lokasi']) ?>
                            </div>
                        </div>

                        <div class="row info-row">
                            <div class="col-md-3 info-label">Anggaran</div>
                            <div class="col-md-9">
                                <strong class="text-success">Rp <?= number_format($kegiatan['anggaran'], 0, ',', '.') ?></strong>
                            </div>
                        </div>

                        <?php if ($kegiatan['realisasi'] > 0): ?>
                            <div class="row info-row">
                                <div class="col-md-3 info-label">Realisasi</div>
                                <div class="col-md-9">
                                    <strong class="text-info">Rp <?= number_format($kegiatan['realisasi'], 0, ',', '.') ?></strong>
                                    <?php 
                                    $percentage = $kegiatan['anggaran'] > 0 ? ($kegiatan['realisasi'] / $kegiatan['anggaran']) * 100 : 0;
                                    ?>
                                    <small class="text-muted">(<?= number_format($percentage, 1) ?>%)</small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($kegiatan['deskripsi']): ?>
                            <div class="row info-row">
                                <div class="col-md-3 info-label">Deskripsi</div>
                                <div class="col-md-9">
                                    <p class="mb-0"><?= nl2br(esc($kegiatan['deskripsi'])) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row info-row">
                            <div class="col-md-3 info-label">Dibuat</div>
                            <div class="col-md-9">
                                <small class="text-muted">
                                    <?= date('d F Y H:i', strtotime($kegiatan['created_at'])) ?>
                                </small>
                            </div>
                        </div>

                        <?php if ($kegiatan['updated_at'] != $kegiatan['created_at']): ?>
                            <div class="row info-row">
                                <div class="col-md-3 info-label">Terakhir Diupdate</div>
                                <div class="col-md-9">
                                    <small class="text-muted">
                                        <?= date('d F Y H:i', strtotime($kegiatan['updated_at'])) ?>
                                    </small>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
