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
        .card-custom { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'perencanaan']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="row"><div class="col-md-10 offset-md-1"><div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2 text-primary"></i><?= $title ?></h5>
                    <a href="<?= base_url('perencanaan/program/detail/' . $program['id']) ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                </div>
                <div class="alert alert-info mb-3">
                    <strong>Program:</strong> <?= esc($program['nama_program']) ?>
                </div>
                <form action="<?= base_url('perencanaan/kegiatan/save') ?>" method="POST">
                    <?= csrf_field() ?>
                    <?php if (isset($kegiatan)): ?><input type="hidden" name="id" value="<?= $kegiatan['id'] ?>"><?php endif; ?>
                    <input type="hidden" name="program_kerja_id" value="<?= $program['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kegiatan" class="form-control" value="<?= old('nama_kegiatan', $kegiatan['nama_kegiatan'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi', $kegiatan['deskripsi'] ?? '') ?></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Timeline <span class="text-danger">*</span></label>
                            <select name="timeline" class="form-select" required>
                                <option value="">-- Pilih Timeline --</option>
                                <option value="Triwulan I" <?= old('timeline', $kegiatan['timeline'] ?? '') == 'Triwulan I' ? 'selected' : '' ?>>Triwulan I (Jan-Mar)</option>
                                <option value="Triwulan II" <?= old('timeline', $kegiatan['timeline'] ?? '') == 'Triwulan II' ? 'selected' : '' ?>>Triwulan II (Apr-Jun)</option>
                                <option value="Triwulan III" <?= old('timeline', $kegiatan['timeline'] ?? '') == 'Triwulan III' ? 'selected' : '' ?>>Triwulan III (Jul-Sep)</option>
                                <option value="Triwulan IV" <?= old('timeline', $kegiatan['timeline'] ?? '') == 'Triwulan IV' ? 'selected' : '' ?>>Triwulan IV (Okt-Des)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Bulan Target <span class="text-danger">*</span></label>
                            <input type="number" name="bulan_target" class="form-control" value="<?= old('bulan_target', $kegiatan['bulan_target'] ?? '') ?>" min="1" max="12" required>
                            <small class="text-muted">1-12 (Januari-Desember)</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Peserta</label>
                        <input type="number" name="target_peserta" class="form-control" value="<?= old('target_peserta', $kegiatan['target_peserta'] ?? '') ?>" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Expected Outcome</label>
                        <textarea name="expected_outcome" class="form-control" rows="2"><?= old('expected_outcome', $kegiatan['expected_outcome'] ?? '') ?></textarea>
                        <small class="text-muted">Hasil/dampak yang diharapkan dari kegiatan ini</small>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="belum_mulai" <?= old('status', $kegiatan['status'] ?? 'belum_mulai') == 'belum_mulai' ? 'selected' : '' ?>>Belum Mulai</option>
                                <option value="persiapan" <?= old('status', $kegiatan['status'] ?? '') == 'persiapan' ? 'selected' : '' ?>>Persiapan</option>
                                <option value="berjalan" <?= old('status', $kegiatan['status'] ?? '') == 'berjalan' ? 'selected' : '' ?>>Berjalan</option>
                                <option value="selesai" <?= old('status', $kegiatan['status'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                <option value="dibatalkan" <?= old('status', $kegiatan['status'] ?? '') == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Progress (%)</label>
                            <input type="number" name="progress_persen" class="form-control" value="<?= old('progress_persen', $kegiatan['progress_persen'] ?? 0) ?>" min="0" max="100">
                        </div>
                    </div>
                    <div class="d-grid"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Simpan Kegiatan</button></div>
                </form>
            </div></div></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
