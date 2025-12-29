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
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'warga']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($kk_info) && $kk_info): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Filter KK:</strong> <?= esc($kk_info['no_kk']) ?> - <?= esc($kk_info['kepala_keluarga']) ?>
                    <a href="<?= base_url('warga/list') ?>" class="btn btn-sm btn-outline-info float-end">
                        <i class="fas fa-times me-1"></i>Hapus Filter
                    </a>
                </div>
            <?php endif; ?>

            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Data Warga</h5>
                    <div>
                        <a href="<?= base_url('warga') ?>" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="<?= base_url('warga/add') ?>" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Tambah Warga
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="wargaTable" class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>No. KK</th>
                                <th>L/P</th>
                                <th>TTL</th>
                                <th>Status Keluarga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($list_warga)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        <?= isset($keyword) && $keyword ? 'Tidak ada hasil pencarian' : 'Belum ada data warga' ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($list_warga as $w): ?>
                                    <tr>
                                        <td><small><?= esc($w['nik']) ?></small></td>
                                        <td>
                                            <strong><?= esc($w['nama_lengkap']) ?></strong>
                                            <br><small class="text-muted"><?= esc($w['pekerjaan'] ?? '-') ?></small>
                                        </td>
                                        <td><small><?= esc($w['no_kk']) ?></small></td>
                                        <td>
                                            <?php if ($w['jenis_kelamin'] == 'L'): ?>
                                                <span class="badge bg-primary"><i class="fas fa-mars"></i> L</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><i class="fas fa-venus"></i> P</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small>
                                                <?= esc($w['tempat_lahir']) ?>, 
                                                <?= date('d/m/Y', strtotime($w['tanggal_lahir'])) ?>
                                                <br>
                                                <span class="text-muted">
                                                    (<?= floor((time() - strtotime($w['tanggal_lahir'])) / (365.25 * 24 * 60 * 60)) ?> th)
                                                </span>
                                            </small>
                                        </td>
                                        <td><small><?= esc($w['status_keluarga']) ?></small></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('warga/edit/' . $w['id']) ?>" 
                                               class="btn btn-sm btn-warning" title="Edit">
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#wargaTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                order: [[1, 'asc']],
                pageLength: 25
            });
        });
    </script>
</body>
</html>
