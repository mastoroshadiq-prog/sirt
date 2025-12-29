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
        .program-card { border-left: 4px solid; padding: 20px; margin-bottom: 15px; border-radius: 8px; background: #F9FAFB; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'perencanaan']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2 text-primary"></i><?= $title ?></h5>
                    <div>
                        <a href="<?= base_url('perencanaan/program/add?rkt_id=' . $rkt['id']) ?>" class="btn btn-primary me-2"><i class="fas fa-plus me-2"></i>Tambah Program</a>
                        <a href="<?= base_url('perencanaan/rkt') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                    </div>
                </div>

                <!-- RKT Info -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h6><strong>Visi:</strong> <?= esc($rkt['visi']) ?></h6>
                            <p class="mb-0"><strong>Misi:</strong> <?= esc($rkt['misi']) ?></p>
                            <small>Periode: <?= date('d M Y', strtotime($rkt['periode_mulai'])) ?> - <?= date('d M Y', strtotime($rkt['periode_selesai'])) ?></small>
                        </div>
                    </div>
                </div>

                <!-- Program Kerja List -->
                <h6 class="mb-3"><i class="fas fa-tasks me-2"></i>Program Kerja (<?= count($program_kerja) ?>)</h6>

                <?php if (empty($program_kerja)): ?>
                    <p class="text-muted text-center py-4">Belum ada program kerja. Silakan tambah program baru.</p>
                <?php else: ?>
                    <?php
                    $bidangColors = [
                        'Pendidikan & Pelatihan' => '#3B82F6',
                        'Kesehatan & Lingkungan' => '#10B981',
                        'Sosial & Budaya' => '#F59E0B',
                        'Ekonomi & Kewirausahaan' => '#8B5CF6',
                        'Infrastruktur & Fasilitas' => '#EF4444',
                        'Keamanan & Ketertiban' => '#EC4899',
                        'Administrasi & Organisasi' => '#6366F1'
                    ];
                    ?>
                    <?php foreach ($program_kerja as $program): ?>
                        <div class="program-card" style="border-left-color: <?= $bidangColors[$program['bidang']] ?? '#2563EB' ?>;">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-2"><?= esc($program['nama_program']) ?></h6>
                                    <p class="text-muted mb-2 small"><?= esc(substr($program['deskripsi'], 0, 150)) ?>...</p>
                                    <div class="mb-2">
                                        <span class="badge" style="background: <?= $bidangColors[$program['bidang']] ?? '#2563EB' ?>;"><?= esc($program['bidang']) ?></span>
                                        <span class="badge bg-secondary ms-2"><?= $program['jumlah_kegiatan'] ?? 0 ?> rencana kegiatan</span>
                                    </div>
                                    <small class="text-muted"><i class="fas fa-user me-1"></i>PJ: <?= esc($program['pj_program']) ?></small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-success" style="width: <?= $program['avg_progress'] ?? 0 ?>%">
                                            <?= round($program['avg_progress'] ?? 0) ?>%
                                        </div>
                                    </div>
                                    <small class="text-muted">Progress</small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="<?= base_url('perencanaan/program/detail/' . $program['id']) ?>" class="btn btn-sm btn-info mb-1"><i class="fas fa-eye"></i> Detail</a>
                                    <a href="<?= base_url('perencanaan/program/edit/' . $program['id']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
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
