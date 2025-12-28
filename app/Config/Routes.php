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

