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
    <?= view('partials/sidebar', ['active' => 'keamanan']) ?>
    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>
        <div class="content-area">
            <div class="row"><div class="col-md-10 offset-md-1"><div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i><?= $title ?></h5>
                    <a href="<?= base_url('keamanan/jadwal') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                </div>
                <form action="<?= base_url('keamanan/jadwal/save') ?>" method="POST">
                    <?= csrf_field() ?>
                    <?php if (isset($jadwal)): ?><input type="hidden" name="id" value="<?= $jadwal['id'] ?>"><?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal', $jadwal['tanggal'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Shift <span class="text-danger">*</span></label>
                        <select name="shift" class="form-select" id="shiftSelect" required>
                            <option value="Shift 1 (22:00-00:00)" <?= old('shift', $jadwal['shift'] ?? '') == 'Shift 1 (22:00-00:00)' ? 'selected' : '' ?>>Shift 1 (22:00-00:00)</option>
                            <option value="Shift 2 (00:00-02:00)" <?= old('shift', $jadwal['shift'] ?? '') == 'Shift 2 (00:00-02:00)' ? 'selected' : '' ?>>Shift 2 (00:00-02:00)</option>
                            <option value="Shift 3 (02:00-04:00)" <?= old('shift', $jadwal['shift'] ?? '') == 'Shift 3 (02:00-04:00)' ? 'selected' : '' ?>>Shift 3 (02:00-04:00)</option>
                            <option value="Custom" <?= old('shift', $jadwal['shift'] ?? '') == 'Custom' ? 'selected' : '' ?>>Custom</option>
                        </select>
                    </div>
                    <div class="mb-3" id="customShiftDiv" style="display: none;">
                        <label class="form-label fw-bold">Shift Custom</label>
                        <input type="text" name="shift_custom" class="form-control" value="<?= old('shift_custom', $jadwal['shift_custom'] ?? '') ?>" placeholder="Contoh: Shift Malam (20:00-24:00)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi Pos <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi_pos" class="form-control" value="<?= old('lokasi_pos', $jadwal['lokasi_pos'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"><?= old('catatan', $jadwal['catatan'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="scheduled" <?= old('status', $jadwal['status'] ?? 'scheduled') == 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                            <option value="selesai" <?= old('status', $jadwal['status'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="dibatalkan" <?= old('status', $jadwal['status'] ?? '') == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="d-grid"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Simpan</button></div>
                </form>
            </div></div></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('shiftSelect').addEventListener('change', function() {
            document.getElementById('customShiftDiv').style.display = this.value === 'Custom' ? 'block' : 'none';
        });
        if (document.getElementById('shiftSelect').value === 'Custom') {
            document.getElementById('customShiftDiv').style.display = 'block';
        }
    </script>
</body>
</html>
