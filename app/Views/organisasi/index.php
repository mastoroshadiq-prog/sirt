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
        .pengurus-card { border-left: 4px solid #2563EB; padding: 20px; margin-bottom: 15px; border-radius: 8px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'organisasi']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-sitemap me-2 text-primary"></i><?= $title ?></h5>
                    <a href="<?= base_url('organisasi/add') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Pengurus</a>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <?php if (empty($pengurus)): ?>
                    <p class="text-muted text-center py-4">Belum ada data pengurus RT. Silakan tambah pengurus baru.</p>
                <?php else: ?>
                    <?php foreach ($pengurus as $p): ?>
                        <div class="pengurus-card">
                            <div class="row align-items-center">
                                <div class="col-md-1 text-center">
                                    <div class="badge bg-primary fs-5"><?= $p['urutan'] ?></div>
                                </div>
                                <div class="col-md-7">
                                    <h6 class="mb-1"><?= esc($p['nama']) ?></h6>
                                    <p class="mb-2"><strong class="text-primary"><?= esc($p['jabatan']) ?></strong></p>
                                    <?php if ($p['no_hp']): ?>
                                        <small class="text-muted"><i class="fas fa-phone me-1"></i><?= esc($p['no_hp']) ?></small>
                                    <?php endif; ?>
                                    <br>
                                    <small class="text-muted">Periode: <?= date('d M Y', strtotime($p['periode_mulai'])) ?> - <?= date('d M Y', strtotime($p['periode_selesai'])) ?></small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <?php if ($p['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="<?= base_url('organisasi/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning mb-1"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="<?= base_url('organisasi/delete/' . $p['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus pengurus ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
