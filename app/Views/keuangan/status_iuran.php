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
        .status-badge { padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; }
        .status-lunas { background: #D1FAE5; color: #065F46; }
        .status-belum { background: #FEF3C7; color: #92400E; }
        .status-nunggak { background: #FEE2E2; color: #991B1B; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'keuangan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Period Selector -->
            <div class="period-selector">
                <form method="GET" action="<?= base_url('keuangan/status-iuran') ?>" class="row g-3 align-items-center">
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
                    <div class="col-auto ms-auto">
                        <a href="<?= base_url('keuangan/input-iuran') ?>" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i>Input Iuran
                        </a>
                    </div>
                </form>
            </div>

            <!-- Status Table -->
            <div class="card-custom">
                <h5 class="mb-4">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>
                    Status Iuran Warga - <?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) ?>
                </h5>

                <div class="table-responsive">
                    <table id="statusTable" class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 15%;">No. KK</th>
                                <th style="width: 20%;">Kepala Keluarga</th>
                                <th style="width: 25%;">Alamat</th>
                                <th style="width: 15%;">Kategori</th>
                                <th style="width: 12%;" class="text-end">Nominal</th>
                                <th style="width: 13%;" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($payment_status)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada data untuk periode ini
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php 
                                $currentKK = null;
                                $rowspan = [];
                                
                                // Calculate rowspan for each KK
                                foreach ($payment_status as $ps) {
                                    $kkId = $ps['id'];
                                    if (!isset($rowspan[$kkId])) {
                                        $rowspan[$kkId] = 0;
                                    }
                                    $rowspan[$kkId]++;
                                }
                                
                                $kkCounter = [];
                                foreach ($payment_status as $ps): 
                                    $kkId = $ps['id'];
                                    $isFirstRow = !isset($kkCounter[$kkId]);
                                    if ($isFirstRow) {
                                        $kkCounter[$kkId] = true;
                                    }
                                ?>
                                    <tr>
                                        <?php if ($isFirstRow): ?>
                                            <td rowspan="<?= $rowspan[$kkId] ?>"><?= esc($ps['no_kk']) ?></td>
                                            <td rowspan="<?= $rowspan[$kkId] ?>">
                                                <strong><?= esc($ps['kepala_keluarga']) ?></strong>
                                            </td>
                                            <td rowspan="<?= $rowspan[$kkId] ?>">
                                                <small><?= esc($ps['alamat']) ?></small>
                                            </td>
                                        <?php endif; ?>
                                        
                                        <td>
                                            <?php if ($ps['nama_kategori']): ?>
                                                <span class="badge bg-secondary"><?= esc($ps['nama_kategori']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="text-end">
                                            <?php if ($ps['jumlah']): ?>
                                                Rp <?= number_format($ps['jumlah'], 0, ',', '.') ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php if ($ps['nama_kategori']): ?>
                                                <?php if ($ps['sudah_bayar']): ?>
                                                    <span class="status-badge status-lunas" title="Dibayar: <?= date('d/m/Y', strtotime($ps['tanggal_bayar'])) ?>">
                                                        <i class="fas fa-check-circle me-1"></i>Lunas
                                                    </span>
                                                <?php else: ?>
                                                    <span class="status-badge status-belum">
                                                        <i class="fas fa-clock me-1"></i>Belum
                                                    </span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Legend -->
                <div class="mt-3 p-3" style="background: #F9FAFB; border-radius: 10px;">
                    <small class="d-block mb-2"><strong>Keterangan:</strong></small>
                    <div class="d-flex gap-3 flex-wrap">
                        <span><span class="status-badge status-lunas me-1">Lunas</span> = Sudah dibayar</span>
                        <span><span class="status-badge status-belum me-1">Belum</span> = Belum dibayar bulan ini</span>
                        <span><span class="status-badge status-nunggak me-1">Nunggak</span> = Tunggakan > 2 bulan</span>
                    </div>
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
            $('#statusTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                pageLength: 25,
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [5] }
                ]
            });
        });
    </script>
</body>
</html>
