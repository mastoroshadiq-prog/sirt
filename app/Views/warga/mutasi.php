<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Si-RT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        :root { --primary: #2563EB; --secondary: #10B981; --sidebar-width: 260px; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #F9FAFB; }
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width); background: linear-gradient(180deg, #1E293B 0%, #0F172A 100%); color: white; overflow-y: auto; z-index: 1000; }
        .sidebar-header { padding: 25px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .sidebar-header h3 { margin: 0; font-size: 1.5rem; font-weight: 700; }
        .menu-item { padding: 12px 20px; color: rgba(255, 255, 255, 0.8); text-decoration: none; display: flex; align-items: center; transition: all 0.3s; }
        .menu-item:hover, .menu-item.active { background: rgba(255, 255, 255, 0.1); color: white; }
        .menu-item i { width: 20px; margin-right: 12px; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .content-area { padding: 30px; }
        .card-custom { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .timeline-item { border-left: 3px solid #e2e8f0; padding-left: 20px; padding-bottom: 20px; position: relative; }
        .timeline-item:last-child { border-left: none; }
        .timeline-marker { position: absolute; left: -8px; width: 14px; height: 14px; border-radius: 50%; border: 3px solid white; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'warga']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i>Riwayat Mutasi Warga</h5>
                    <a href="<?= base_url('warga') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="mutasiTable" class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Mutasi</th>
                                <th>Nama Warga</th>
                                <th>NIK</th>
                                <th>No. KK</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($mutasi_list)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada riwayat mutasi warga
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($mutasi_list as $m): ?>
                                    <?php
                                    $badgeClass = [
                                        'baru' => 'bg-primary',
                                        'kelahiran' => 'bg-success',
                                        'pindah' => 'bg-warning',
                                        'meninggal' => 'bg-danger'
                                    ][$m['jenis_mutasi']] ?? 'bg-secondary';
                                    
                                    $icon = [
                                        'baru' => 'fa-user-plus',
                                        'kelahiran' => 'fa-baby',
                                        'pindah' => 'fa-truck-moving',
                                        'meninggal' => 'fa-cross'
                                    ][$m['jenis_mutasi']] ?? 'fa-exchange-alt';
                                    ?>
                                    <tr>
                                        <td><small><?= date('d/m/Y', strtotime($m['tanggal_mutasi'])) ?></small></td>
                                        <td>
                                            <span class="badge <?= $badgeClass ?>">
                                                <i class="fas <?= $icon ?> me-1"></i>
                                                <?= ucfirst($m['jenis_mutasi']) ?>
                                            </span>
                                        </td>
                                        <td><strong><?= esc($m['nama_lengkap'] ?? '-') ?></strong></td>
                                        <td><small><?= esc($m['nik'] ?? '-') ?></small></td>
                                        <td><small><?= esc($m['no_kk'] ?? '-') ?></small></td>
                                        <td><small><?= esc($m['keterangan']) ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Stats Summary -->
                <?php if (!empty($mutasi_list)): ?>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="text-primary mb-1">
                                    <?= count(array_filter($mutasi_list, fn($m) => $m['jenis_mutasi'] == 'baru')) ?>
                                </h4>
                                <small class="text-muted">Warga Baru</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="text-success mb-1">
                                    <?= count(array_filter($mutasi_list, fn($m) => $m['jenis_mutasi'] == 'kelahiran')) ?>
                                </h4>
                                <small class="text-muted">Kelahiran</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="text-warning mb-1">
                                    <?= count(array_filter($mutasi_list, fn($m) => $m['jenis_mutasi'] == 'pindah')) ?>
                                </h4>
                                <small class="text-muted">Pindah</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <h4 class="text-danger mb-1">
                                    <?= count(array_filter($mutasi_list, fn($m) => $m['jenis_mutasi'] == 'meninggal')) ?>
                                </h4>
                                <small class="text-muted">Meninggal</small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mutasiTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                order: [[0, 'desc']],
                pageLength: 25
            });
        });
    </script>
</body>
</html>
