<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/content', 'Home::content');
// $routes->resource('AdminController');
$routes->add('admin/create', 'AdminController::create');
$routes->add('admin/update/(:segment)', 'AdminController::update/$1');
$routes->add('admin/delete/(:segment)', 'AdminController::delete/$1');

$routes->add('laporan/create', 'LaporanController::create');
$routes->add('laporan/update/(:segment)', 'LaporanController::update/$1');
$routes->add('laporan/delete/(:segment)', 'LaporanController::delete/$1');

$routes->add('content/create', 'ContentController::create');
$routes->add('content/update/(:segment)', 'ContentController::update/$1');
$routes->add('content/delete/(:segment)', 'ContentController::delete/$1');


$routes->get('administrator', 'Admin::index');
$routes->get('administrator/evaluasi', 'Admin::evaluasi');
$routes->get('administrator/kontak', 'Admin::kontak');
$routes->get('administrator/layanan', 'Admin::layanan');
$routes->get('administrator/profile', 'Admin::profile');
$routes->get('administrator/evaluasi/(:any)', 'Admin::evaluasi/$1');
$routes->get('administrator/kontak/(:any)', 'Admin::kontak/$1');
$routes->get('administrator/layanan/(:any)', 'Admin::layanan/$1');
$routes->get('administrator/profile/(:any)', 'Admin::profile/$1');


$routes->get('login', 'Login::index');
$routes->post('login', 'Login::index');

$routes->get('logout', 'Login::logout');
// ajax
$routes->post('UserController/getUserDatatables', 'UserController::getUserDatatables');
$routes->post('UserController/deleteUser', 'UserController::deleteUser');
$routes->post('UserController/index', 'UserController::index');
$routes->post('LaporanController/index', 'LaporanController::index');
$routes->post('ContentController/index', 'ContentController::index');
$routes->post('AdminController/index', 'AdminController::index');
$routes->post('AdminController/getAdminDatatables', 'AdminController::getAdminDatatables');
$routes->post('AdminController/deleteAdmin', 'AdminController::deleteAdmin');
$routes->post('AdminController/nonaktifkanAdmin', 'AdminController::nonaktifkanAdmin');
$routes->post('AdminController/aktifkanAdmin', 'AdminController::aktifkanAdmin');

$routes->post('LaporanController/countchart', 'LaporanController::countchart');
$routes->post('LaporanController/countrating', 'LaporanController::countrating');
$routes->post('LaporanController/getLaporanData', 'LaporanController::getLaporanData');
$routes->post('LaporanController/getLaporanById', 'LaporanController::getLaporanById');
$routes->post('LaporanController/KirimBalasan', 'LaporanController::KirimBalasan');
$routes->post('LaporanController/TandaiDibaca', 'LaporanController::TandaiDibaca');
$routes->post('LaporanController/getLaporanDataDibaca', 'LaporanController::getLaporanDataDibaca');
$routes->post('LaporanController/getLaporanDataDibalas', 'LaporanController::getLaporanDataDibalas');
$routes->post('LaporanController/getBalasanLaporanById', 'LaporanController::getBalasanLaporanById');
$routes->post('LaporanController/HapusBalasLaporan', 'LaporanController::HapusBalasLaporan');
$routes->post('LaporanController/TandaiBelumDibaca', 'LaporanController::TandaiBelumDibaca');
$routes->post('LaporanController/downloadLaporan', 'LaporanController::downloadLaporan');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
