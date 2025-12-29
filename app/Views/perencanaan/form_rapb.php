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
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i><?= $title ?></h5>
                            <a href="<?= base_url('perencanaan/rapb') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                        </div>
                        <form action="<?= base_url('perencanaan/rapb/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <?php if (isset($rapb)): ?><input type="hidden" name="id" value="<?= $rapb['id'] ?>"><?php endif; ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Link ke RKT</label>
                                    <select name="rkt_id" class="form-select">
                                        <option value="">-- Pilih RKT (Optional) --</option>
                                        <?php foreach ($list_rkt as $rkt): ?>
                                            <option value="<?= $rkt['id'] ?>" <?= old('rkt_id', $rapb['rkt_id'] ?? '') == $rkt['id'] ? 'selected' : '' ?>>
                                                RKT Tahun <?= $rkt['tahun'] ?> (<?= ucfirst($rkt['status']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun" class="form-control" value="<?= old('tahun', $rapb['tahun'] ?? date('Y')) ?>" required min="2020" max="2050">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Target Pendapatan (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="total_target_pendapatan" class="form-control" value="<?= old('total_target_pendapatan', $rapb['total_target_pendapatan'] ?? 0) ?>" required min="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Rencana Belanja (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="total_rencana_belanja" class="form-control" value="<?= old('total_rencana_belanja', $rapb['total_rencana_belanja'] ?? 0) ?>" required min="0">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Buffer (%)</label>
                                    <input type="number" name="buffer_persen" class="form-control" value="<?= old('buffer_persen', $rapb['buffer_persen'] ?? 10) ?>" min="0" max="100" step="0.1">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="draft" <?= old('status', $rapb['status'] ?? 'draft') == 'draft' ? 'selected' : '' ?>>Draft</option>
                                        <option value="approved" <?= old('status', $rapb['status'] ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="active" <?= old('status', $rapb['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Catatan:</strong> Realisasi pendapatan dan belanja akan otomatis dihitung dari transaksi keuangan yang ada.
                            </div>
                            <div class="d-grid"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Simpan RAPB</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
