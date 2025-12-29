<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

// Authentication routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('attemptLogin', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');
    $routes->get('changePassword', 'Auth::changePassword');
    $routes->post('updatePassword', 'Auth::updatePassword');
});

// Dashboard route
$routes->get('dashboard', 'Dashboard::index');

// Module routes will be added here as we develop them

// Keuangan routes
$routes->group('keuangan', function($routes) {
    $routes->get('/', 'Keuangan::index');
    $routes->get('buku-kas', 'Keuangan::bukuKas');
    $routes->get('input-iuran', 'Keuangan::inputIuran');
    $routes->post('input-iuran', 'Keuangan::storeIuran');
    $routes->get('status-iuran', 'Keuangan::statusIuran');
});

// Warga (Administrasi) routes
$routes->group('warga', function($routes) {
    $routes->get('/', 'Warga::index');
    $routes->get('kk', 'Warga::listKK');
    $routes->get('kk/add', 'Warga::formKK');
    $routes->get('kk/edit/(:num)', 'Warga::formKK/$1');
    $routes->post('kk/save', 'Warga::saveKK');
    $routes->get('list', 'Warga::listWarga');
    $routes->get('add', 'Warga::formWarga');
    $routes->get('edit/(:num)', 'Warga::formWarga/$1');
    $routes->post('save', 'Warga::saveWarga');
    $routes->get('mutasi', 'Warga::mutasi');
});

// Kegiatan Routes
$routes->group('kegiatan', function($routes) {
    $routes->get('/', 'Kegiatan::index');
    $routes->get('list', 'Kegiatan::list');
    $routes->get('add', 'Kegiatan::form');
    $routes->get('edit/(:num)', 'Kegiatan::form/$1');
    $routes->post('save', 'Kegiatan::save');
    $routes->get('detail/(:num)', 'Kegiatan::detail/$1');
});

// Aset Routes
$routes->group('aset', function($routes) {
    $routes->get('/', 'Aset::index');
    $routes->get('kategori', 'Aset::kategori');
    $routes->get('inventaris', 'Aset::inventaris');
    $routes->get('add', 'Aset::form');
    $routes->get('edit/(:num)', 'Aset::form/$1');
    $routes->post('save', 'Aset::save');
});

// Keamanan Routes
$routes->group('keamanan', function($routes) {
    $routes->get('/', 'Keamanan::index');
    $routes->get('anggota', 'Keamanan::anggota');
    $routes->get('anggota/add', 'Keamanan::formAnggota');
    $routes->get('anggota/edit/(:num)', 'Keamanan::formAnggota/$1');
    $routes->post('anggota/save', 'Keamanan::saveAnggota');
    $routes->get('jadwal', 'Keamanan::jadwal');
    $routes->get('jadwal/add', 'Keamanan::formJadwal');
    $routes->get('jadwal/edit/(:num)', 'Keamanan::formJadwal/$1');
    $routes->post('jadwal/save', 'Keamanan::saveJadwal');
    $routes->get('laporan', 'Keamanan::laporan');
    $routes->get('laporan/add', 'Keamanan::formLaporan');
    $routes->get('laporan/edit/(:num)', 'Keamanan::formLaporan/$1');
    $routes->post('laporan/save', 'Keamanan::saveLaporan');
    $routes->get('laporan/detail/(:num)', 'Keamanan::detailLaporan/$1');
});

// Laporan Routes
$routes->group('laporan', function($routes) {
    $routes->get('/', 'Laporan::index');
    $routes->get('keuangan', 'Laporan::keuangan');
    $routes->get('warga', 'Laporan::warga');
    $routes->get('kegiatan', 'Laporan::kegiatan');
    $routes->get('ronda', 'Laporan::ronda');
});

// Perencanaan Routes
$routes->group('perencanaan', function($routes) {
    $routes->get('/', 'Perencanaan::index');
    $routes->get('rkt', 'Perencanaan::rkt');
    $routes->get('rkt/add', 'Perencanaan::formRkt');
    $routes->get('rkt/edit/(:num)', 'Perencanaan::formRkt/$1');
    $routes->get('rkt/detail/(:num)', 'Perencanaan::detailRkt/$1');
    $routes->post('rkt/save', 'Perencanaan::saveRkt');
    $routes->get('program/add', 'Perencanaan::formProgram');
    $routes->get('program/edit/(:num)', 'Perencanaan::formProgram/$1');
    $routes->get('program/detail/(:num)', 'Perencanaan::detailProgram/$1');
    $routes->post('program/save', 'Perencanaan::saveProgram');
    $routes->get('kegiatan/add', 'Perencanaan::formKegiatan');
    $routes->get('kegiatan/edit/(:num)', 'Perencanaan::formKegiatan/$1');
    $routes->post('kegiatan/save', 'Perencanaan::saveKegiatan');
    $routes->get('rapb', 'Perencanaan::rapb');
    $routes->get('rapb/add', 'Perencanaan::formRapb');
    $routes->get('rapb/edit/(:num)', 'Perencanaan::formRapb/$1');
    $routes->post('rapb/save', 'Perencanaan::saveRapb');
    $routes->get('monitoring', 'Perencanaan::monitoring');
});

// Organisasi Routes
$routes->group('organisasi', function($routes) {
    $routes->get('/', 'Organisasi::index');
    $routes->get('add', 'Organisasi::form');
    $routes->get('edit/(:num)', 'Organisasi::form/$1');
    $routes->post('save', 'Organisasi::save');
    $routes->get('delete/(:num)', 'Organisasi::delete/$1');
});

// Pembangunan Routes
$routes->group('pembangunan', function($routes) {
    $routes->get('/', 'Pembangunan::index');
    $routes->get('detail/(:num)', 'Pembangunan::detail/$1');
});

