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
        .section-title { border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 20px; color: #1e293b; font-weight: 600; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'warga']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2 text-primary"></i>
                                <?= isset($warga) ? 'Edit' : 'Tambah' ?> Data Warga
                            </h5>
                            <a href="<?= base_url('warga/list') ?>" class="btn btn-outline-secondary">
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

                        <form action="<?= base_url('warga/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <?php if (isset($warga)): ?>
                                <input type="hidden" name="id" value="<?= $warga['id'] ?>">
                            <?php endif; ?>

                            <!-- Section: Identitas -->
                            <h6 class="section-title"><i class="fas fa-id-card me-2"></i>Data Identitas</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Kartu Keluarga <span class="text-danger">*</span></label>
                                    <select name="kk_id" class="form-select" required>
                                        <option value="">-- Pilih KK --</option>
                                        <?php foreach ($list_kk as $kk): ?>
                                            <option value="<?= $kk['id'] ?>" 
                                                <?= old('kk_id', $warga['kk_id'] ?? '') == $kk['id'] ? 'selected' : '' ?>>
                                                <?= $kk['no_kk'] ?> - <?= $kk['kepala_keluarga'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control" 
                                           value="<?= old('nik', $warga['nik'] ?? '') ?>" 
                                           placeholder="3201011980010001" maxlength="16" required>
                                    <small class="text-muted">16 digit angka</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control" 
                                       value="<?= old('nama_lengkap', $warga['nama_lengkap'] ?? '') ?>" 
                                       placeholder="Nama sesuai KTP" required>
                            </div>

                            <!-- Section: Kelahiran -->
                            <h6 class="section-title mt-4"><i class="fas fa-birthday-cake me-2"></i>Data Kelahiran</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control" 
                                           value="<?= old('tempat_lahir', $warga['tempat_lahir'] ?? '') ?>" 
                                           placeholder="Jakarta" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" 
                                           value="<?= old('tanggal_lahir', $warga['tanggal_lahir'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L" <?= old('jenis_kelamin', $warga['jenis_kelamin'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= old('jenis_kelamin', $warga['jenis_kelamin'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Agama <span class="text-danger">*</span></label>
                                    <select name="agama" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Islam" <?= old('agama', $warga['agama'] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                        <option value="Kristen" <?= old('agama', $warga['agama'] ?? '') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                        <option value="Katolik" <?= old('agama', $warga['agama'] ?? '') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                        <option value="Hindu" <?= old('agama', $warga['agama'] ?? '') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                        <option value="Buddha" <?= old('agama', $warga['agama'] ?? '') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                        <option value="Konghucu" <?= old('agama', $warga['agama'] ?? '') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Section: Status -->
                            <h6 class="section-title mt-4"><i class="fas fa-info-circle me-2"></i>Status & Pekerjaan</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pekerjaan <span class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan" class="form-control" 
                                           value="<?= old('pekerjaan', $warga['pekerjaan'] ?? '') ?>" 
                                           placeholder="Pegawai Swasta" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status Perkawinan <span class="text-danger">*</span></label>
                                    <select name="status_perkawinan" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Belum Kawin" <?= old('status_perkawinan', $warga['status_perkawinan'] ?? '') == 'Belum Kawin' ? 'selected' : '' ?>>Belum Kawin</option>
                                        <option value="Kawin" <?= old('status_perkawinan', $warga['status_perkawinan'] ?? '') == 'Kawin' ? 'selected' : '' ?>>Kawin</option>
                                        <option value="Cerai Hidup" <?= old('status_perkawinan', $warga['status_perkawinan'] ?? '') == 'Cerai Hidup' ? 'selected' : '' ?>>Cerai Hidup</option>
                                        <option value="Cerai Mati" <?= old('status_perkawinan', $warga['status_perkawinan'] ?? '') == 'Cerai Mati' ? 'selected' : '' ?>>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status dalam Keluarga <span class="text-danger">*</span></label>
                                    <select name="status_keluarga" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Kepala Keluarga" <?= old('status_keluarga', $warga['status_keluarga'] ?? '') == 'Kepala Keluarga' ? 'selected' : '' ?>>Kepala Keluarga</option>
                                        <option value="Istri" <?= old('status_keluarga', $warga['status_keluarga'] ?? '') == 'Istri' ? 'selected' : '' ?>>Istri</option>
                                        <option value="Anak" <?= old('status_keluarga', $warga['status_keluarga'] ?? '') == 'Anak' ? 'selected' : '' ?>>Anak</option>
                                        <option value="Orang Tua" <?= old('status_keluarga', $warga['status_keluarga'] ?? '') == 'Orang Tua' ? 'selected' : '' ?>>Orang Tua</option>
                                        <option value="Keluarga Lain" <?= old('status_keluarga', $warga['status_keluarga'] ?? '') == 'Keluarga Lain' ? 'selected' : '' ?>>Keluarga Lain</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status Warga</label>
                                    <select name="status" class="form-select">
                                        <option value="aktif" <?= old('status', $warga['status'] ?? 'aktif') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="pindah" <?= old('status', $warga['status'] ?? '') == 'pindah' ? 'selected' : '' ?>>Pindah</option>
                                        <option value="meninggal" <?= old('status', $warga['status'] ?? '') == 'meninggal' ? 'selected' : '' ?>>Meninggal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Data Warga
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
        document.querySelector('input[name="nik"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').substring(0, 16);
        });
    </script>
</body>
</html>
