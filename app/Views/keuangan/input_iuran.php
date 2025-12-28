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
        .kategori-item { 
            border: 2px solid #E5E7EB;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        .kategori-item:hover { border-color: var(--primary); }
        .kategori-item.selected { 
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }
        .kategori-checkbox { 
            width: 24px;
            height: 24px;
            cursor: pointer;
        }
        .total-summary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 15px;
            padding: 25px;
            position: sticky;
            top: 20px;
        }
        .total-amount {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <?= view('partials/sidebar', ['active' => 'keuangan']) ?>

    <div class="main-content">
        <?= view('partials/topbar', ['user' => $user, 'title' => $title]) ?>

        <div class="content-area">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                Form Input Iuran Warga
                            </h5>
                            <a href="<?= base_url('keuangan') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>

                        <form action="<?= base_url('keuangan/input-iuran') ?>" method="POST" id="formIuran">
                            <?= csrf_field() ?>

                            <!-- Data KK -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-users me-2"></i>Pilih Kartu Keluarga
                                </label>
                                <select name="kk_id" id="kkSelect" class="form-select form-select-lg" required>
                                    <option value="">-- Pilih KK --</option>
                                    <?php foreach ($list_kk as $kk): ?>
                                        <option value="<?= $kk['id'] ?>">
                                            <?= $kk['no_kk'] ?> - <?= $kk['kepala_keluarga'] ?> (<?= $kk['alamat'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Period -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar me-2"></i>Bulan
                                    </label>
                                    <select name="bulan" class="form-select" required>
                                        <?php for($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?= $m ?>" <?= $m == date('n') ? 'selected' : '' ?>>
                                                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Tahun</label>
                                    <select name="tahun" class="form-select" required>
                                        <?php for($y = date('Y') - 1; $y <= date('Y') + 1; $y++): ?>
                                            <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar-check me-2"></i>Tanggal Bayar
                                    </label>
                                    <input type="date" name="tanggal_bayar" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>

                            <!-- Kategori Iuran (Multi-select) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-3">
                                    <i class="fas fa-list-check me-2"></i>Pilih Kategori Iuran
                                </label>
                                
                                <div id="kategoriContainer">
                                    <?php foreach ($kategori_iuran as $kategori): ?>
                                        <div class="kategori-item" data-kategori-id="<?= $kategori['id'] ?>">
                                            <div class="row align-items-center">
                                                <div class="col-md-1">
                                                    <input type="checkbox" 
                                                           name="kategori_iuran_id[]" 
                                                           value="<?= $kategori['id'] ?>" 
                                                           class="kategori-checkbox form-check-input"
                                                           data-nominal="<?= $kategori['nominal_default'] ?>">
                                                </div>
                                                <div class="col-md-5">
                                                    <strong><?= esc($kategori['nama_kategori']) ?></strong>
                                                    <?php if ($kategori['deskripsi']): ?>
                                                        <br><small class="text-muted"><?= esc($kategori['deskripsi']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                                        Rp <?= number_format($kategori['nominal_default'], 0, ',', '.') ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <?php if (empty($kategori_iuran)): ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Belum ada kategori iuran aktif. Silakan hubungi administrator.
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-comment me-2"></i>Keterangan (Opsional)
                                </label>
                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit" disabled>
                                    <i class="fas fa-save me-2"></i>Simpan Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Summary Sidebar -->
                <div class="col-md-4">
                    <div class="total-summary">
                        <h5 class="mb-2">
                            <i class="fas fa-calculator me-2"></i>Ringkasan Pembayaran
                        </h5>
                        <hr style="border-color: rgba(255,255,255,0.3);">
                        
                        <div id="selectedCategories">
                            <p class="text-white-50 mb-0">Belum ada kategori dipilih</p>
                        </div>

                        <hr style="border-color: rgba(255,255,255,0.3);">
                        
                        <div class="text-center">
                            <small class="text-white-50 d-block mb-2">Total Pembayaran</small>
                            <div class="total-amount" id="totalAmount">Rp 0</div>
                            <div id="totalKategori" class="badge bg-white text-primary mt-2">0 Kategori</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong><br>
                                • Pilih kategori iuran yang akan dibayar<br>
                                • Bisa bayar sebagian atau semua kategori<br>
                                • Nominal yang ditampilkan adalah nominal default
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedKategori = [];

            // Handle kategori checkbox change
            $('.kategori-checkbox').on('change', function() {
                const item = $(this).closest('.kategori-item');
                const nominal = parseFloat($(this).data('nominal'));
                const kategoriId = item.data('kategori-id');
                const kategoriNama = item.find('strong').text();

                if ($(this).is(':checked')) {
                    item.addClass('selected');
                    selectedKategori.push({
                        id: kategoriId,
                        nama: kategoriNama,
                        nominal: nominal
                    });
                } else {
                    item.removeClass('selected');
                    selectedKategori = selectedKategori.filter(k => k.id != kategoriId);
                }

                updateSummary();
            });

            function updateSummary() {
                const total = selectedKategori.reduce((sum, k) => sum + k.nominal, 0);
                const count = selectedKategori.length;

                // Update total amount
                $('#totalAmount').text('Rp ' + total.toLocaleString('id-ID'));
                $('#totalKategori').text(count + ' Kategori');

                // Update selected categories list
                if (count === 0) {
                    $('#selectedCategories').html('<p class="text-white-50 mb-0">Belum ada kategori dipilih</p>');
                    $('#btnSubmit').prop('disabled', true);
                } else {
                    let html = '';
                    selectedKategori.forEach(k => {
                        html += `<div class="d-flex justify-content-between mb-2">
                            <span>${k.nama}</span>
                            <strong>Rp ${k.nominal.toLocaleString('id-ID')}</strong>
                        </div>`;
                    });
                    $('#selectedCategories').html(html);
                    $('#btnSubmit').prop('disabled', false);
                }
            }

            // Form validation
            $('#formIuran').on('submit', function(e) {
                if (selectedKategori.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal 1 kategori iuran!');
                    return false;
                }

                if (!$('#kkSelect').val()) {
                    e.preventDefault();
                    alert('Pilih Kartu Keluarga terlebih dahulu!');
                    return false;
                }
            });
        });
    </script>
</body>
</html>
