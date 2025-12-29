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
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>RAPB (Rencana Anggaran Pendapatan dan Belanja)</h5>
                    <div>
                        <a href="<?= base_url('perencanaan/rapb/add') ?>" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-2"></i>Tambah RAPB
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
                                <th class="text-end">Target Pendapatan</th>
                                <th class="text-end">Rencana Belanja</th>
                                <th class="text-center">Buffer</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($list_rapb)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada data RAPB
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($list_rapb as $rapb): ?>
                                    <tr>
                                        <td><strong><?= $rapb['tahun'] ?></strong></td>
                                        <td class="text-end">Rp <?= number_format($rapb['total_target_pendapatan'], 0, ',', '.') ?></td>
                                        <td class="text-end">Rp <?= number_format($rapb['total_rencana_belanja'], 0, ',', '.') ?></td>
                                        <td class="text-center"><?= $rapb['buffer_persen'] ?>%</td>
                                        <td class="text-center">
                                            <?php
                                            $statusBadge = [
                                                'draft' => 'bg-secondary',
                                                'approved' => 'bg-primary',
                                                'active' => 'bg-success'
                                            ][$rapb['status']] ?? 'bg-secondary';
                                            ?>
                                            <span class="badge <?= $statusBadge ?>"><?= ucfirst($rapb['status']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('perencanaan/rapb/edit/' . $rapb['id']) ?>" class="btn btn-sm btn-warning me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('perencanaan/monitoring') ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-chart-line"></i>
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
