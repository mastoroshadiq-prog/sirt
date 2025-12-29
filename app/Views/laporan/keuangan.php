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
    <?= view('partials/sidebar', ['active' => 'laporan']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2 text-primary"></i>Laporan Keuangan</h5>
                    <a href="<?= base_url('laporan') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                </div>
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-2"><input type="month" name="bulan" class="form-control" value="<?= $tahun ?>-<?= str_pad($bulan, 2, '0', STR_PAD_LEFT) ?>" onchange="this.form.submit()"></div>
                </form>
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><div class="card text-center"><div class="card-body"><h6 class="text-muted">Total Pemasukan</h6><h4 class="text-success">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h4></div></div></div>
                    <div class="col-md-4"><div class="card text-center"><div class="card-body"><h6 class="text-muted">Total Pengeluaran</h6><h4 class="text-danger">Rp <?= number_format($total_keluar, 0, ',', '.') ?></h4></div></div></div>
                    <div class="col-md-4"><div class="card text-center"><div class="card-body"><h6 class="text-muted">Saldo</h6><h4 class="text-primary">Rp <?= number_format($saldo, 0, ',', '.') ?></h4></div></div></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Uraian</th>
                                <th class="text-end">Masuk</th>
                                <th class="text-end">Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($transaksi)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>Tidak ada transaksi</td></tr>
                            <?php else: ?>
                                <?php foreach ($transaksi as $tr): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($tr['tanggal'])) ?></td>
                                        <td><span class="badge bg-<?= $tr['jenis'] == 'masuk' ? 'success' : 'danger' ?>"><?= ucfirst($tr['kategori']) ?></span></td>
                                        <td><?= esc($tr['uraian']) ?></td>
                                        <td class="text-end text-success"><strong><?= $tr['masuk'] > 0 ? 'Rp ' . number_format($tr['masuk'], 0, ',', '.') : '-' ?></strong></td>
                                        <td class="text-end text-danger"><strong><?= $tr['keluar'] > 0 ? 'Rp ' . number_format($tr['keluar'], 0, ',', '.') : '-' ?></strong></td>
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
