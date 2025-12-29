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

            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-tags me-2 text-primary"></i>Kategori Aset</h5>
                    <a href="<?= base_url('aset') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="kategoriTable" class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">Kode</th>
                                <th style="width: 30%;">Nama Kategori</th>
                                <th style="width: 45%;">Deskripsi</th>
                                <th class="text-center" style="width: 15%;">Jumlah Aset</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($list_kategori)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada kategori aset
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($list_kategori as $kat): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary"><?= esc($kat['prefix_kode']) ?></span>
                                        </td>
                                        <td><strong><?= esc($kat['nama_kategori']) ?></strong></td>
                                        <td><small class="text-muted"><?= esc($kat['deskripsi']) ?></small></td>
                                        <td class="text-center">
                                            <?php if ($kat['jumlah_aset'] > 0): ?>
                                                <a href="<?= base_url('aset/inventaris?kategori_id=' . $kat['id']) ?>" 
                                                   class="badge bg-info">
                                                    <?= $kat['jumlah_aset'] ?> item
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">0 item</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Info:</strong> Kategori dikelola oleh administrator sistem. 
                    Untuk menambah/edit kategori, hubungi admin.
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
            <?php if (!empty($list_kategori)): ?>
                $('#kategoriTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                    },
                    order: [[1, 'asc']],
                    pageLength: 25
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
