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
                    <h5 class="mb-0"><i class="fas fa-tasks me-2 text-primary"></i><?= $title ?></h5>
                    <a href="<?= base_url('perencanaan/rkt/detail/' . $rkt['id']) ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                </div>
                <div class="alert alert-info mb-3">
                    <strong>RKT:</strong> Tahun <?= $rkt['tahun'] ?>
                </div>
                <form action="<?= base_url('perencanaan/program/save') ?>" method="POST">
                    <?= csrf_field() ?>
                    <?php if (isset($program)): ?><input type="hidden" name="id" value="<?= $program['id'] ?>"><?php endif; ?>
                    <input type="hidden" name="rkt_id" value="<?= $rkt['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Bidang <span class="text-danger">*</span></label>
                        <select name="bidang" class="form-select" required>
                            <option value="">-- Pilih Bidang --</option>
                            <option value="Pendidikan & Pelatihan" <?= old('bidang', $program['bidang'] ?? '') == 'Pendidikan & Pelatihan' ? 'selected' : '' ?>>Pendidikan & Pelatihan</option>
                            <option value="Kesehatan & Lingkungan" <?= old('bidang', $program['bidang'] ?? '') == 'Kesehatan & Lingkungan' ? 'selected' : '' ?>>Kesehatan & Lingkungan</option>
                            <option value="Sosial & Budaya" <?= old('bidang', $program['bidang'] ?? '') == 'Sosial & Budaya' ? 'selected' : '' ?>>Sosial & Budaya</option>
                            <option value="Ekonomi & Kewirausahaan" <?= old('bidang', $program['bidang'] ?? '') == 'Ekonomi & Kewirausahaan' ? 'selected' : '' ?>>Ekonomi & Kewirausahaan</option>
                            <option value="Infrastruktur & Fasilitas" <?= old('bidang', $program['bidang'] ?? '') == 'Infrastruktur & Fasilitas' ? 'selected' : '' ?>>Infrastruktur & Fasilitas</option>
                            <option value="Keamanan & Ketertiban" <?= old('bidang', $program['bidang'] ?? '') == 'Keamanan & Ketertiban' ? 'selected' : '' ?>>Keamanan & Ketertiban</option>
                            <option value="Administrasi & Organisasi" <?= old('bidang', $program['bidang'] ?? '') == 'Administrasi & Organisasi' ? 'selected' : '' ?>>Administrasi & Organisasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" name="nama_program" class="form-control" value="<?= old('nama_program', $program['nama_program'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="3" required><?= old('deskripsi', $program['deskripsi'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Output</label>
                        <textarea name="target_output" class="form-control" rows="2"><?= old('target_output', $program['target_output'] ?? '') ?></textarea>
                        <small class="text-muted">Output/hasil yang diharapkan dari program ini</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Penanggung Jawab <span class="text-danger">*</span></label>
                        <select name="pj_program" class="form-select" required>
                            <option value="">-- Pilih Pengurus --</option>
                            <?php foreach ($list_pengurus as $pengurus): ?>
                                <option value="<?= esc($pengurus['nama']) ?>" <?= old('pj_program', $program['pj_program'] ?? '') == $pengurus['nama'] ? 'selected' : '' ?>>
                                    <?= esc($pengurus['nama']) ?> (<?= esc($pengurus['jabatan']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Jika pengurus belum ada, <a href="<?= base_url('organisasi/add') ?>" target="_blank">tambah pengurus baru</a></small>
                    </div>
                    <div class="d-grid"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Simpan Program</button></div>
                </form>
            </div></div></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
