<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Keuangan' ?> - Si-RT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary: #2563EB;
            --secondary: #10B981;
            --sidebar-width: 260px;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #F9FAFB;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1E293B 0%, #0F172A 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .menu-item {
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        .menu-item:hover, .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .menu-item i {
            width: 20px;
            margin-right: 12px;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        .content-area {
            padding: 30px;
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .chart-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .period-selector {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'keuangan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <!-- Period Selector -->
            <div class="period-selector">
                <form method="GET" action="<?= base_url('keuangan') ?>" class="row g-3 align-items-center">
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

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(37, 99, 235, 0.1); color: #2563EB;">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3 class="mb-1">Rp <?= number_format($saldo_kas, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Saldo Kas RT</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <h3 class="mb-1">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Kas Masuk Bulan Ini</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <h3 class="mb-1">Rp <?= number_format($total_keluar, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Kas Keluar Bulan Ini</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="mb-1">Rp <?= number_format($total_masuk - $total_keluar, 0, ',', '.') ?></h3>
                        <p class="text-muted mb-0">Selisih Bulan Ini</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="chart-card">
                        <h5 class="mb-4"><i class="fas fa-chart-pie me-2 text-primary"></i>Iuran per Kategori</h5>
                        <canvas id="iuranCategoryChart" height="200"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-card">
                        <h5 class="mb-4"><i class="fas fa-chart-line me-2 text-success"></i>Trend Saldo 6 Bulan Terakhir</h5>
                        <canvas id="saldoTrendChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="chart-card">
                        <h5 class="mb-3"><i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat</h5>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="<?= base_url('keuangan/input-iuran') ?>" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Input Iuran
                            </a>
                            <a href="<?= base_url('keuangan/buku-kas') ?>" class="btn btn-outline-primary">
                                <i class="fas fa-book me-2"></i>Lihat Buku Kas
                            </a>
                            <a href="<?= base_url('keuangan/status-iuran') ?>" class="btn btn-outline-success">
                                <i class="fas fa-check-circle me-2"></i>Status Iuran
                            </a>
                            <a href="#" class="btn btn-outline-danger">
                                <i class="fas fa-file-pdf me-2"></i>Export Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Prevent auto-scroll and ensure charts render only after DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Iuran Category Chart
            const iuranCtx = document.getElementById('iuranCategoryChart');
            if (iuranCtx) {
                new Chart(iuranCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: <?= json_encode(array_column($iuran_by_category, 'nama_kategori')) ?>,
                        datasets: [{
                            data: <?= json_encode(array_column($iuran_by_category, 'total')) ?>,
                            backgroundColor: ['#2563EB', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            // Saldo Trend Chart
            const trendCtx = document.getElementById('saldoTrendChart');
            if (trendCtx) {
                new Chart(trendCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: <?= json_encode(array_column($saldo_trend, 'month')) ?>,
                        datasets: [{
                            label: 'Saldo Kas',
                            data: <?= json_encode(array_column($saldo_trend, 'saldo')) ?>,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
