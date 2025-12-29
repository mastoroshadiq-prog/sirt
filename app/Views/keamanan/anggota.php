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
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'keamanan']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Anggota Ronda</h5>
                    <div>
                        <a href="<?= base_url('keamanan/anggota/add') ?>" class="btn btn-primary me-2"><i class="fas fa-plus me-2"></i>Tambah</a>
                        <a href="<?= base_url('keamanan') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($list_anggota)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>Belum ada data anggota ronda</td></tr>
                            <?php else: ?>
                                <?php foreach ($list_anggota as $anggota): ?>
                                    <tr>
                                        <td><strong><?= esc($anggota['nama']) ?></strong></td>
                                        <td><?= esc($anggota['no_hp']) ?></td>
                                        <td><?= esc($anggota['alamat']) ?></td>
                                        <td><?= $anggota['is_koordinator'] ? '<span class="badge bg-warning">Koordinator</span>' : '<span class="badge bg-secondary">Anggota</span>' ?></td>
                                        <td><span class="badge bg-<?= $anggota['status'] == 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($anggota['status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
