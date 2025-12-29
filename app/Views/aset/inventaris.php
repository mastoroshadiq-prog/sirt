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
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .content-area { padding: 30px; }
        .card-custom { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'aset']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($kategori_info) && $kategori_info): ?>
                <div class="alert alert-info">
                    <i class="fas fa-filter me-2"></i>
                    <strong>Filter Kategori:</strong> <?= esc($kategori_info['nama_kategori']) ?>
                    <a href="<?= base_url('aset/inventaris') ?>" class="btn btn-sm btn-outline-info float-end">
                        <i class="fas fa-times me-1"></i>Hapus Filter
                    </a>
                </div>
            <?php endif; ?>

            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-boxes me-2 text-primary"></i>Inventaris Aset</h5>
                    <div>
                        <a href="<?= base_url('aset') ?>" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="<?= base_url('aset/add') ?>" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Aset
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="inventarisTable" class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 12%;">Kode Register</th>
                                <th style="width: 20%;">Nama Aset</th>
                                <th style="width: 12%;">Kategori</th>
                                <th style="width: 15%;">Merek/Tipe</th>
                                <th style="width: 8%;">Tahun</th>
                                <th class="text-end" style="width: 13%;">Nilai</th>
                                <th class="text-center" style="width: 10%;">Kondisi</th>
                                <th class="text-center" style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($list_aset)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada data inventaris aset
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($list_aset as $aset): ?>
                                    <tr>
                                        <td><small><strong><?= esc($aset['kode_register']) ?></strong></small></td>
                                        <td>
                                            <strong><?= esc($aset['nama_aset']) ?></strong>
                                            <?php if ($aset['lokasi']): ?>
                                                <br><small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i><?= esc($aset['lokasi']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-secondary"><?= esc($aset['nama_kategori']) ?></span></td>
                                        <td><small><?= esc($aset['merek_tipe'] ?? '-') ?></small></td>
                                        <td class="text-center"><?= esc($aset['tahun_perolehan']) ?></td>
                                        <td class="text-end"><small>Rp <?= number_format($aset['nilai_perolehan'], 0, ',', '.') ?></small></td>
                                        <td class="text-center">
                                            <?php 
                                            $badgeClass = [
                                                'Baik' => 'bg-success',
                                                'Rusak Ringan' => 'bg-warning',
                                                'Rusak Berat' => 'bg-danger'
                                            ][$aset['kondisi']] ?? 'bg-secondary';
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= esc($aset['kondisi']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('aset/edit/' . $aset['id']) ?>" 
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
            <?php if (!empty($list_aset)): ?>
                $('#inventarisTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                    },
                    order: [[0, 'desc']],
                    pageLength: 25
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
