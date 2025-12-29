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
        .card-custom { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .info-row { border-bottom: 1px solid #f1f5f9; padding: 15px 0; }
        .info-row:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'keamanan']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="row"><div class="col-md-10 offset-md-1"><div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i><?= $title ?></h5>
                    <a href="<?= base_url('keamanan/laporan') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                </div>
                <div class="mb-3">
                    <span class="badge bg-<?= $laporan['status'] == 'dilaporkan' ? 'warning' : ($laporan['status'] == 'ditangani' ? 'primary' : 'success') ?> fs-6"><?= ucfirst($laporan['status']) ?></span>
                    <span class="badge bg-info fs-6 ms-2"><?= esc($laporan['jenis_kejadian']) ?></span>
                </div>
                <div class="info-row">
                    <div class="row">
                        <div class="col-md-3 fw-bold text-muted">Tanggal & Waktu</div>
                        <div class="col-md-9"><i class="fas fa-calendar me-2 text-primary"></i><?= date('d F Y, H:i', strtotime($laporan['tanggal_waktu'])) ?></div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="row">
                        <div class="col-md-3 fw-bold text-muted">Lokasi</div>
                        <div class="col-md-9"><i class="fas fa-map-marker-alt me-2 text-danger"></i><?= esc($laporan['lokasi']) ?></div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="row">
                        <div class="col-md-3 fw-bold text-muted">Deskripsi</div>
                        <div class="col-md-9"><?= nl2br(esc($laporan['deskripsi'])) ?></div>
                    </div>
                </div>
                <?php if ($laporan['tindakan']): ?>
                    <div class="info-row">
                        <div class="row">
                            <div class="col-md-3 fw-bold text-muted">Tindakan</div>
                            <div class="col-md-9"><div class="alert alert-success mb-0"><?= nl2br(esc($laporan['tindakan'])) ?></div></div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="info-row">
                    <div class="row">
                        <div class="col-md-3 fw-bold text-muted">Dilaporkan</div>
                        <div class="col-md-9"><small class="text-muted"><?= date('d F Y H:i', strtotime($laporan['created_at'])) ?></small></div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="<?= base_url('keamanan/laporan/edit/' . $laporan['id']) ?>" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Edit Laporan</a>
                </div>
            </div></div></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
