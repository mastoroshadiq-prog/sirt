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
        .period-selector { background: white; border-radius: 10px; padding: 15px 20px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .saldo-badge { font-size: 1.5rem; font-weight: 700; padding: 15px 25px; border-radius: 10px; display: inline-block; }
        .text-masuk { color: #10B981; }
        .text-keluar { color: #EF4444; }
        table.dataTable tbody tr:hover { background-color: #F9FAFB; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'keuangan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Period Selector -->
            <div class="period-selector">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <form method="GET" action="<?= base_url('keuangan/buku-kas') ?>" class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class="form-label mb-0"><i class="fas fa-calendar me-2"></i>Periode:</label>
                            </div>
                            <div class="col-auto">
                                <select name="bulan" class="form-select">
                                    <?php for($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?= $m ?>" <?= $bulan == $m ? 'selected' : '' ?>>
                                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="tahun" class="form-select">
                                    <?php for($y = date('Y') - 2; $y <= date('Y') + 1; $y++): ?>
                                        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Tampilkan
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="#" class="btn btn-success me-2">
                            <i class="fas fa-file-excel me-2"></i>Export Excel
                        </a>
                        <a href="#" class="btn btn-danger">
                            <i class="fas fa-file-pdf me-2"></i>Export PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Saldo Info -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card-custom text-center">
                        <h5 class="mb-3">Saldo Akhir</h5>
                        <div class="saldo-badge" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white;">
                            Rp <?= number_format($saldo_akhir, 0, ',', '.') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Kas Table -->
            <div class="card-custom">
                <h5 class="mb-4">
                    <i class="fas fa-book me-2 text-primary"></i>
                    Buku Kas - <?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) ?>
                </h5>
                
                <div class="table-responsive">
                    <table id="bukuKasTable" class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">Tanggal</th>
                                <th style="width: 35%;">Uraian</th>
                                <th style="width: 15%;">Kategori</th>
                                <th style="width: 13%;" class="text-end">Masuk</th>
                                <th style="width: 13%;" class="text-end">Keluar</th>
                                <th style="width: 14%;" class="text-end">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($transaksi)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada transaksi untuk periode ini
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($transaksi as $t): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                                        <td>
                                            <?= esc($t['uraian']) ?>
                                            <?php if ($t['bukti_file']): ?>
                                                <a href="#" class="ms-2 text-primary" title="Lihat bukti">
                                                    <i class="fas fa-paperclip"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($t['kategori']): ?>
                                                <span class="badge bg-secondary"><?= esc($t['kategori']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end text-masuk">
                                            <?= $t['masuk'] > 0 ? 'Rp ' . number_format($t['masuk'], 0, ',', '.') : '-' ?>
                                        </td>
                                        <td class="text-end text-keluar">
                                            <?= $t['keluar'] > 0 ? 'Rp ' . number_format($t['keluar'], 0, ',', '.') : '-' ?>
                                        </td>
                                        <td class="text-end fw-bold">
                                            Rp <?= number_format($t['saldo'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <?php if (!empty($transaksi)): ?>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end text-masuk">
                                        Rp <?= number_format(array_sum(array_column($transaksi, 'masuk')), 0, ',', '.') ?>
                                    </th>
                                    <th class="text-end text-keluar">
                                        Rp <?= number_format(array_sum(array_column($transaksi, 'keluar')), 0, ',', '.') ?>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        <?php endif; ?>
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
            <?php if (!empty($transaksi)): ?>
                $('#bukuKasTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                    },
                    order: [[0, 'desc']],
                    pageLength: 25,
                    dom: 'frtip'
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
