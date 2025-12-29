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
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .content-area { padding: 30px; }
        .card-custom { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'warga']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-home me-2 text-primary"></i>
                                <?= isset($kk) ? 'Edit' : 'Tambah' ?> Kartu Keluarga
                            </h5>
                            <a href="<?= base_url('warga/kk') ?>" class="btn btn-outline-secondary">
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

                        <form action="<?= base_url('warga/kk/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <?php if (isset($kk)): ?>
                                <input type="hidden" name="id" value="<?= $kk['id'] ?>">
                            <?php endif; ?>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-id-card me-2"></i>No. Kartu Keluarga
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="no_kk" class="form-control" 
                                           value="<?= old('no_kk', $kk['no_kk'] ?? '') ?>" 
                                           placeholder="3201012301230001" 
                                           maxlength="16" required>
                                    <small class="text-muted">16 digit angka</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-user me-2"></i>Kepala Keluarga
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="kepala_keluarga" class="form-control" 
                                           value="<?= old('kepala_keluarga', $kk['kepala_keluarga'] ?? '') ?>" 
                                           placeholder="Nama Lengkap" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea name="alamat" class="form-control" rows="3" 
                                          placeholder="Jl. Contoh No. 123" required><?= old('alamat', $kk['alamat'] ?? '') ?></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">RT <span class="text-danger">*</span></label>
                                    <input type="text" name="rt" class="form-control" 
                                           value="<?= old('rt', $kk['rt'] ?? '001') ?>" 
                                           placeholder="001" maxlength="3" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">RW <span class="text-danger">*</span></label>
                                    <input type="text" name="rw" class="form-control" 
                                           value="<?= old('rw', $kk['rw'] ?? '005') ?>" 
                                           placeholder="005" maxlength="3" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="aktif" <?= old('status', $kk['status'] ?? 'aktif') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="pindah" <?= old('status', $kk['status'] ?? '') == 'pindah' ? 'selected' : '' ?>>Pindah</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Data KK
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validate NIK format (16 digits)
        document.querySelector('input[name="no_kk"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').substring(0, 16);
        });
    </script>
</body>
</html>
