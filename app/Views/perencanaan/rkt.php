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
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2 text-primary"></i>Rencana Kerja Tahunan (RKT)</h5>
                    <div>
                        <a href="<?= base_url('perencanaan/rkt/add') ?>" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-2"></i>Tambah RKT
                        </a>
                        <a href="<?= base_url('perencanaan') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tahun</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Visi</th>
                                <th>Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($list_rkt)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada data RKT
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($list_rkt as $rkt): ?>
                                    <tr>
                                        <td><strong><?= $rkt['tahun'] ?></strong></td>
                                        <td><?= date('d/m/Y', strtotime($rkt['periode_mulai'])) ?> - <?= date('d/m/Y', strtotime($rkt['periode_selesai'])) ?></td>
                                        <td>
                                            <?php
                                            $statusBadge = [
                                                'draft' => 'bg-secondary',
                                                'approved' => 'bg-primary',
                                                'active' => 'bg-success',
                                                'archived' => 'bg-warning'
                                            ][$rkt['status']] ?? 'bg-secondary';
                                            ?>
                                            <span class="badge <?= $statusBadge ?>"><?= ucfirst($rkt['status']) ?></span>
                                        </td>
                                        <td><?= esc(substr($rkt['visi'], 0, 100)) ?>...</td>
                                        <td><small><?= date('d/m/Y', strtotime($rkt['created_at'])) ?></small></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('perencanaan/rkt/detail/' . $rkt['id']) ?>" class="btn btn-sm btn-info me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('perencanaan/rkt/edit/' . $rkt['id']) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
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
