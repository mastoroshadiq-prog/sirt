# Si-RT (Sistem Informasi Rukun Tetangga)

> **Aplikasi Manajemen Keuangan dan Administrasi RT Berbasis Web & Mobile**

[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.6.4-orange)](https://codeigniter.com/)
[![PHP](https://img.shields.io/badge/PHP-8.3.26-blue)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.4.3-blue)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

## 📋 Deskripsi

Si-RT adalah sistem informasi terintegrasi untuk manajemen Rukun Tetangga (RT) yang mencakup:

- ✅ **Manajemen Keuangan RT** - Multi-category iuran, kas masuk/keluar, laporan
- ✅ **Administrasi Warga** - Data KK, warga, mutasi, statistik demografi
- ✅ **Manajemen Aset/Inventaris** - Pendataan aset dengan GPS & foto
- ✅ **Keamanan & Ronda** - Jadwal, absensi GPS, laporan kejadian, kas ronda
- ✅ **Kegiatan RT** - Perencanaan, dokumentasi, realisasi anggaran
- ✅ **Layanan Warga** - Pengajuan surat, pengaduan, pengumuman

**Terinspirasi dari:** SIKADES-Lite (Sistem Keuangan Desa)

## 🚀 Status Implementasi

### Phase 1: Foundation & Setup ✅ **100% SELESAI**

- [x] CodeIgniter 4.6.4 installation
- [x] Database schema (27 tables)
- [x] Authentication system (login, logout, RBAC)
- [x] Modern UI dengan Bootstrap 5
- [x] Initial data seeding

### Phase 2: Core Modules 🚧 **IN PROGRESS**

- [x] **Models Created:**
  - UserModel
  - KategoriIuranModel
  - KartuKeluargaModel
  - KasTransaksiModel
  - IuranPembayaranModel
- [x] **Controllers Created:**
  - Auth Controller
  - Dashboard Controller
  - Keuangan Controller (partial)
- [ ] Keuangan Views
- [ ] Administrasi Warga Module
- [ ] Dashboard dengan real data

## 🛠️ Technology Stack

### Backend
- **Framework:** CodeIgniter 4.6.4
- **Language:** PHP 8.3.26
- **Database:** MySQL 8.4.3

### Frontend (Web)
- **UI Framework:** Bootstrap 5.3.2
- **Charts:** Chart.js
- **Icons:** Font Awesome 6.4.2

## 📦 Installation

1. **Clone repository:**
```bash
git clone https://github.com/mastoroshadiq-prog/sirt.git
cd sirt
```

2. **Install dependencies:**
```bash
composer install
```

3. **Setup database:**
```bash
mysql -u root -p
CREATE DATABASE si_rt_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. **Configure .env:**
```
database.default.database = si_rt_db
database.default.username = root
database.default.password = 
```

5. **Run migrations:**
```bash
php spark migrate
php spark db:seed InitialDataSeeder
```

6. **Run server:**
```bash
php spark serve
```

7. **Login:**
```
URL: http://localhost:8080
Username: admin
Password: admin123
```

## 📄 License

MIT License

---

**Built with ❤️ for Indonesian RT communities**

Last updated: 28 December 2024
