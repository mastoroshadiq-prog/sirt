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
    <?= view('partials/sidebar', ['active' => 'organisasi']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="row"><div class="col-md-10 offset-md-1"><div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-sitemap me-2 text-primary"></i><?= $title ?></h5>
                    <a href="<?= base_url('organisasi') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                </div>
                <form action="<?= base_url('organisasi/save') ?>" method="POST">
                    <?= csrf_field() ?>
                    <?php if (isset($pengurus)): ?><input type="hidden" name="id" value="<?= $pengurus['id'] ?>"><?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="<?= old('nama', $pengurus['nama'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                        <select name="jabatan" class="form-select" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Ketua RT" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Ketua RT' ? 'selected' : '' ?>>Ketua RT</option>
                            <option value="Sekretaris" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Sekretaris' ? 'selected' : '' ?>>Sekretaris</option>
                            <option value="Bendahara" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Bendahara' ? 'selected' : '' ?>>Bendahara</option>
                            <option value="Seksi Keamanan & Ketertiban" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Seksi Keamanan & Ketertiban' ? 'selected' : '' ?>>Seksi Keamanan & Ketertiban</option>
                            <option value="Seksi Kebersihan & Lingkungan" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Seksi Kebersihan & Lingkungan' ? 'selected' : '' ?>>Seksi Kebersihan & Lingkungan</option>
                            <option value="Seksi Sosial & Budaya" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Seksi Sosial & Budaya' ? 'selected' : '' ?>>Seksi Sosial & Budaya</option>
                            <option value="Seksi Pembangunan" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Seksi Pembangunan' ? 'selected' : '' ?>>Seksi Pembangunan</option>
                            <option value="Seksi Kesehatan" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Seksi Kesehatan' ? 'selected' : '' ?>>Seksi Kesehatan</option>
                            <option value="Seksi Pendidikan" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Seksi Pendidikan' ? 'selected' : '' ?>>Seksi Pendidikan</option>
                            <option value="Seksi Pemuda dan Olahraga" <?= old('jabatan', $pengurus['jabatan'] ?? '') == 'Seksi Pemuda dan Olahraga' ? 'selected' : '' ?>>Seksi Pemuda dan Olahraga</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Periode Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="periode_mulai" class="form-control" value="<?= old('periode_mulai', $pengurus['periode_mulai'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Periode Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="periode_selesai" class="form-control" value="<?= old('periode_selesai', $pengurus['periode_selesai'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= old('no_hp', $pengurus['no_hp'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"><?= old('alamat', $pengurus['alamat'] ?? '') ?></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="<?= old('urutan', $pengurus['urutan'] ?? 99) ?>" min="1">
                            <small class="text-muted">Urutan tampilan (angka kecil tampil lebih dulu)</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" <?= old('is_active', $pengurus['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Simpan Pengurus</button></div>
                </form>
            </div></div></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
