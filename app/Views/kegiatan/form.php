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
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items-center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .content-area { padding: 30px; }
        .card-custom { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .section-title { border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 20px; color: #1e293b; font-weight: 600; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'kegiatan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <?= isset($kegiatan) ? 'Edit' : 'Tambah' ?> Kegiatan
                            </h5>
                            <a href="<?= base_url('kegiatan/list') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>

                        <?php if (session()->has('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('kegiatan/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <?php if (isset($kegiatan)): ?>
                                <input type="hidden" name="id" value="<?= $kegiatan['id'] ?>">
                            <?php endif; ?>

                            <!-- Section: Informasi Dasar -->
                            <h6 class="section-title"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Nama Kegiatan <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama_kegiatan" class="form-control" 
                                       value="<?= old('nama_kegiatan', $kegiatan['nama_kegiatan'] ?? '') ?>" 
                                       placeholder="Contoh: Kerja Bakti Minggu Bersih" required>
                            </div>

                            <?php if (!empty($rencana_kegiatan)): ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Link ke Rencana Kegiatan (RKT)</label>
                                <select name="rencana_kegiatan_id" class="form-select">
                                    <option value="">-- Pilih Rencana (Optional) --</option>
                                    <?php foreach ($rencana_kegiatan as $rencana): ?>
                                        <?php
                                        $rencanaModel = new \App\Models\RencanaKegiatanModel();
                                        $rencanaData = $rencanaModel->find($rencana['id']);
                                        $selected = isset($kegiatan) && $rencanaData && $rencanaData['kegiatan_id'] == $kegiatan['id'];
                                        ?>
                                        <option value="<?= $rencana['id'] ?>" <?= $selected ? 'selected' : '' ?>>
                                            [RKT <?= $rencana['tahun'] ?>] <?= esc($rencana['nama_kegiatan']) ?> - <?= esc($rencana['nama_program']) ?> (Bulan <?= $rencana['bulan_target'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Hubungkan dengan rencana kegiatan dari RKT untuk monitoring otomatis</small>
                            </div>
                            <?php endif; ?>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select name="kategori" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Gotong Royong" <?= old('kategori', $kegiatan['kategori'] ?? '') == 'Gotong Royong' ? 'selected' : '' ?>>Gotong Royong</option>
                                        <option value="17-an" <?= old('kategori', $kegiatan['kategori'] ?? '') == '17-an' ? 'selected' : '' ?>>17-an</option>
                                        <option value="Posyandu" <?= old('kategori', $kegiatan['kategori'] ?? '') == 'Posyandu' ? 'selected' : '' ?>>Posyandu</option>
                                        <option value="Pengajian" <?= old('kategori', $kegiatan['kategori'] ?? '') == 'Pengajian' ? 'selected' : '' ?>>Pengajian</option>
                                        <option value="Rapat RT" <?= old('kategori', $kegiatan['kategori'] ?? '') == 'Rapat RT' ? 'selected' : '' ?>>Rapat RT</option>
                                        <option value="Lainnya" <?= old('kategori', $kegiatan['kategori'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" class="form-select" required>
                                        <option value="direncanakan" <?= old('status', $kegiatan['status'] ?? 'direncanakan') == 'direncanakan' ? 'selected' : '' ?>>Direncanakan</option>
                                        <option value="sedang_berjalan" <?= old('status', $kegiatan['status'] ?? '') == 'sedang_berjalan' ? 'selected' : '' ?>>Sedang Berjalan</option>
                                        <option value="selesai" <?= old('status', $kegiatan['status'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                        <option value="dibatalkan" <?= old('status', $kegiatan['status'] ?? '') == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Section: Detail -->
                            <h6 class="section-title mt-4"><i class="fas fa-calendar-day me-2"></i>Detail Kegiatan</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Tanggal <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal" class="form-control" 
                                           value="<?= old('tanggal', $kegiatan['tanggal'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Lokasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="lokasi" class="form-control" 
                                           value="<?= old('lokasi', $kegiatan['lokasi'] ?? '') ?>" 
                                           placeholder="Contoh: Balai RT 005" required>
                                </div>
                            </div>

                            <!-- Section: Anggaran -->
                            <h6 class="section-title mt-4"><i class="fas fa-money-bill-wave me-2"></i>Anggaran</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Anggaran (Rp)</label>
                                    <input type="number" name="anggaran" class="form-control" 
                                           value="<?= old('anggaran', $kegiatan['anggaran'] ?? 0) ?>" 
                                           placeholder="0" min="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Realisasi (Rp)</label>
                                    <input type="number" name="realisasi" class="form-control" 
                                           value="<?= old('realisasi', $kegiatan['realisasi'] ?? 0) ?>" 
                                           placeholder="0" min="0">
                                </div>
                            </div>

                            <!-- Section: Keterangan -->
                            <h6 class="section-title mt-4"><i class="fas fa-file-alt me-2"></i>Keterangan</h6>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Deskripsi Kegiatan</label>
                                <textarea name="deskripsi" class="form-control" rows="4" 
                                          placeholder="Deskripsi detail tentang kegiatan..."><?= old('deskripsi', $kegiatan['deskripsi'] ?? '') ?></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Kegiatan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
