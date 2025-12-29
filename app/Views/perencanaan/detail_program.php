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
        .kegiatan-card { border-left: 4px solid #2563EB; padding: 15px; border-radius: 8px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 12px; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'perencanaan']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-tasks me-2 text-primary"></i><?= esc($program['nama_program']) ?></h5>
                    <div>
                        <a href="<?= base_url('perencanaan/kegiatan/add?program_id=' . $program['id']) ?>" class="btn btn-primary me-2"><i class="fas fa-plus me-2"></i>Tambah Kegiatan</a>
                        <a href="<?= base_url('perencanaan/rkt/detail/' . $program['rkt_id']) ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                    </div>
                </div>

                <!-- Program Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Bidang:</strong> <span class="badge bg-primary"><?= esc($program['bidang']) ?></span></p>
                        <p><strong>PJ:</strong> <?= esc($program['pj_program']) ?></p>
                        <p><strong>Deskripsi:</strong> <?= esc($program['deskripsi']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <h4><?= round($program['avg_progress'] ?? 0) ?>%</h4>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" style="width: <?= $program['avg_progress'] ?? 0 ?>%">Average Progress</div>
                            </div>
                            <small class="text-muted mt-2 d-block"><?= $program['jumlah_kegiatan'] ?> Rencana Kegiatan</small>
                        </div>
                    </div>
                </div>

                <!-- Rencana Kegiatan List -->
                <h6 class="mb-3"><i class="fas fa-calendar-check me-2"></i>Rencana Kegiatan</h6>

                <?php if (empty($rencana_kegiatan)): ?>
                    <p class="text-muted text-center py-4">Belum ada rencana kegiatan. Silakan tambah kegiatan baru.</p>
                <?php else: ?>
                    <?php foreach ($rencana_kegiatan as $kegiatan): ?>
                        <?php
                        $statusBadges = [
                            'belum_mulai' => 'bg-secondary',
                            'persiapan' => 'bg-info',
                            'berjalan' => 'bg-primary',
                            'selesai' => 'bg-success',
                            'dibatalkan' => 'bg-danger'
                        ];
                        $timelineBadges = [
                            'Triwulan I' => 'bg-info',
                            'Triwulan II' => 'bg-success',
                            'Triwulan III' => 'bg-warning',
                            'Triwulan IV' => 'bg-danger'
                        ];
                        ?>
                        <div class="kegiatan-card">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <h6 class="mb-2"><?= esc($kegiatan['nama_kegiatan']) ?></h6>
                                    <?php if ($kegiatan['deskripsi']): ?>
                                        <p class="text-muted small mb-2"><?= esc(substr($kegiatan['deskripsi'], 0, 100)) ?>...</p>
                                    <?php endif; ?>
                                    <div>
                                        <span class="badge <?= $timelineBadges[$kegiatan['timeline']] ?? 'bg-secondary' ?>"><?= esc($kegiatan['timeline']) ?></span>
                                        <span class="badge bg-secondary ms-2">Bulan <?= $kegiatan['bulan_target'] ?></span>
                                        <?php if ($kegiatan['target_peserta']): ?>
                                            <span class="badge bg-info ms-2"><i class="fas fa-users"></i> <?= $kegiatan['target_peserta'] ?> peserta</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($kegiatan['kegiatan_id_linked']): ?>
                                        <div class="mt-2">
                                            <small class="text-success"><i class="fas fa-link me-1"></i>Terhubung: <strong><?= esc($kegiatan['kegiatan_nama']) ?></strong></small>
                                            <br><small class="text-muted">Tanggal: <?= date('d M Y', strtotime($kegiatan['kegiatan_tanggal'])) ?> | Status: <?= ucfirst($kegiatan['kegiatan_status']) ?></small>
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-2">
                                            <small class="text-warning"><i class="fas fa-exclamation-circle me-1"></i>Belum ada kegiatan terhubung</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3">
                                    <div class="progress mb-1" style="height: 20px;">
                                        <div class="progress-bar bg-success" style="width: <?= $kegiatan['progress_persen'] ?>%"><?= $kegiatan['progress_persen'] ?>%</div>
                                    </div>
                                    <small><span class="badge <?= $statusBadges[$kegiatan['status']] ?? 'bg-secondary' ?>"><?= ucfirst(str_replace('_', ' ', $kegiatan['status'])) ?></span></small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <?php if (!$kegiatan['kegiatan_id_linked']): ?>
                                        <a href="<?= base_url('kegiatan/add') ?>" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus"></i> Buat</a>
                                    <?php else: ?>
                                        <a href="<?= base_url('kegiatan/detail/' . $kegiatan['kegiatan_id_linked']) ?>" class="btn btn-sm btn-info mb-1"><i class="fas fa-eye"></i> Lihat</a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('perencanaan/kegiatan/edit/' . $kegiatan['id']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
