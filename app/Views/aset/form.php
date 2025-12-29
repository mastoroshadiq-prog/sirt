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
        .section-title { border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 20px; color: #1e293b; font-weight: 600; }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'aset']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-box me-2 text-primary"></i>
                                <?= isset($aset) ? 'Edit' : 'Tambah' ?> Data Aset
                            </h5>
                            <a href="<?= base_url('aset/inventaris') ?>" class="btn btn-outline-secondary">
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

                        <form action="<?= base_url('aset/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <?php if (isset($aset)): ?>
                                <input type="hidden" name="id" value="<?= $aset['id'] ?>">
                                <input type="hidden" name="kode_register" value="<?= $aset['kode_register'] ?>">
                            <?php endif; ?>

                            <!-- Section: Identitas -->
                            <h6 class="section-title"><i class="fas fa-id-card me-2"></i>Identitas Aset</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Kategori Aset <span class="text-danger">*</span>
                                    </label>
                                    <select name="kategori_aset_id" class="form-select" required <?= isset($aset) ? 'disabled' : '' ?>>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($list_kategori as $kat): ?>
                                            <option value="<?= $kat['id'] ?>" 
                                                <?= old('kategori_aset_id', $aset['kategori_aset_id'] ?? '') == $kat['id'] ? 'selected' : '' ?>>
                                                [<?= $kat['prefix_kode'] ?>] <?= $kat['nama_kategori'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($aset)): ?>
                                        <input type="hidden" name="kategori_aset_id" value="<?= $aset['kategori_aset_id'] ?>">
                                        <small class="text-muted">Kategori tidak bisa diubah setelah dibuat</small>
                                    <?php else: ?>
                                        <small class="text-muted">Kode register akan dibuat otomatis</small>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <?php if (isset($aset)): ?>
                                        <label class="form-label fw-bold">Kode Register</label>
                                        <input type="text" class="form-control" value="<?= $aset['kode_register'] ?>" disabled>
                                        <small class="text-muted">Kode register tidak bisa diubah</small>
                                    <?php else: ?>
                                        <label class="form-label fw-bold">Kode Register</label>
                                        <input type="text" class="form-control" value="(otomatis)" disabled>
                                        <small class="text-muted">Akan dibuat otomatis saat disimpan</small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Nama Aset <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama_aset" class="form-control" 
                                       value="<?= old('nama_aset', $aset['nama_aset'] ?? '') ?>" 
                                       placeholder="Contoh: Kursi Plastik" required>
                            </div>

                            <!-- Section: Detail -->
                            <h6 class="section-title mt-4"><i class="fas fa-info-circle me-2"></i>Detail Perolehan</h6>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Merek/Tipe</label>
                                    <input type="text" name="merek_tipe" class="form-control" 
                                           value="<?= old('merek_tipe', $aset['merek_tipe'] ?? '') ?>" 
                                           placeholder="Contoh: Olymplast">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Tahun Perolehan <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="tahun_perolehan" class="form-control" 
                                           value="<?= old('tahun_perolehan', $aset['tahun_perolehan'] ?? date('Y')) ?>" 
                                           min="1900" max="<?= date('Y') + 1 ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Nilai Perolehan (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="nilai_perolehan" class="form-control" 
                                           value="<?= old('nilai_perolehan', $aset['nilai_perolehan'] ?? '') ?>" 
                                           placeholder="Contoh: 500000" min="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control" 
                                           value="<?= old('lokasi', $aset['lokasi'] ?? '') ?>" 
                                           placeholder="Contoh: Balai RT">
                                </div>
                            </div>

                            <!-- Section: Kondisi -->
                            <h6 class="section-title mt-4"><i class="fas fa-wrench me-2"></i>Kondisi & Keterangan</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Kondisi <span class="text-danger">*</span>
                                </label>
                                <select name="kondisi" class="form-select" required>
                                    <option value="">-- Pilih Kondisi --</option>
                                    <option value="Baik" <?= old('kondisi', $aset['kondisi'] ?? '') == 'Baik' ? 'selected' : '' ?>>
                                        Baik
                                    </option>
                                    <option value="Rusak Ringan" <?= old('kondisi', $aset['kondisi'] ?? '') == 'Rusak Ringan' ? 'selected' : '' ?>>
                                        Rusak Ringan
                                    </option>
                                    <option value="Rusak Berat" <?= old('kondisi', $aset['kondisi'] ?? '') == 'Rusak Berat' ? 'selected' : '' ?>>
                                        Rusak Berat
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3" 
                                          placeholder="Catatan tambahan tentang aset..."><?= old('keterangan', $aset['keterangan'] ?? '') ?></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Data Aset
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
