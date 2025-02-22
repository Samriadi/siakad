<?php
session_start();
date_default_timezone_set('Asia/Makassar');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Contoh data pengguna yang disimpan dalam session
// $_SESSION['student_id'] = 6662;
// $_SESSION['advisor_id'] = 23;

require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Table.php';
// require_once __DIR__ . '/../app/Helpers/Function.php';

// Controller Imports
$controllers = [
    'MainController',
    'AuthController',
    'MahasiswaController',
    'DosenController',
    'StaffController',
    'MatkulController',
    'PerkuliahanController',
    'KrsController',
    'KhsController',
    'SettingController',
    'PembayaranController',
    'TagihanController',
    'ProdiController',
    'AngkatanController',
    'AdjustmentController',
    'FakultasController',
    'RuanganController',
    'KelasController',
    'ProfileController',
    'ScheduleController',


];
foreach ($controllers as $controller) {
    require_once __DIR__ . "/../app/Controllers/$controller.php";
}

// Model Imports
$models = [
    'MahasiswaModel',
    'DosenModel',
    'StaffModel',
    'MatkulModel',
    'PerkuliahanModel',
    'KrsModel',
    'SettingModel',
    'PembayaranModel',
    'TagihanModel',
    'ProdiModel',
    'AngkatanModel',
    'AdjustmentModel',
    'FakultasModel',
    'RuanganModel',
    'KelasModel',
    'ProfileModel',
    'ScheduleModel',


];
foreach ($models as $model) {
    require_once __DIR__ . "/../app/Models/$model.php";
}

// Initialize Router
$router = new Router();

// Helper function to add grouped routes
function addRouteGroup($prefix, $controller, $routes)
{
    global $router;
    foreach ($routes as $route => $method) {
        $router->add("$prefix$route", $controller, $method);
    }
}

// Define routes
$router->add('/', 'MainController', 'index');
$router->add('/select-dash', 'MainController', 'selectDash');
$router->add('/login', 'AuthController', 'login');

// Mahasiswa routes
addRouteGroup('/mahasiswa', 'MahasiswaController', [
    '' => 'index',
    '/add' => 'addData',
    '/import' => 'importData',
    '/importCSV' => 'importDataCSV',
    '/fetch' => 'fetchData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
]);

// Orang Tua (Ortu) routes
addRouteGroup('/ortu', 'MahasiswaController', [
    '' => 'ortu',
    '/fetch' => 'fetchDataOrtu',
    '/update' => 'updateDataOrtu',
    '/delete' => 'deleteDataOrtu',
]);

// Dosen routes
addRouteGroup('/dosen', 'DosenController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
]);

// Staff routes
addRouteGroup('/staff', 'StaffController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
]);

// Mata Kuliah (Matkul) routes
addRouteGroup('/matkul', 'MatkulController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
]);

// Perkuliahan routes
addRouteGroup('/perkuliahan', 'PerkuliahanController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
    '/include' => 'includeData',
]);

// KRS (Kartu Rencana Studi) routes
addRouteGroup('/krs', 'KrsController', [
    '' => 'krs',
    '/add' => 'addData',
    '/delete' => 'deleteData',
]);

// KRS Approval routes
addRouteGroup('/persetujuan-krs', 'KrsController', [
    '' => 'indexPersetujuan',
    '/detail' => 'detailPersetujuan',
    '/update' => 'updatePersetujuan',
    '/update-general' => 'updatePersetujuanByGeneral',
]);

// KHS (Kartu Hasil Studi) routes
$router->add('/khs', 'KhsController', 'khs');

// Settings routes
addRouteGroup('/setting', 'SettingController', [
    '' => 'index',
    '/update' => 'updateData',
]);

// Registration routes
addRouteGroup('/regist', 'MainController', [
    '' => 'indexRegist',
    '/add' => 'addRegist',
    '/insert' => 'insertRegist',
    '/save' => 'saveRegist',
]);

// Pembayaran routes
addRouteGroup('/pembayaran', 'PembayaranController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
]);

// tagihan routes
addRouteGroup('/tagihan', 'TagihanController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
    '/include' => 'includeData',
    '/select' => 'selectData',
]);

addRouteGroup('/invoice', 'FakultasController', ['' => 'selectFakultas']);
addRouteGroup('/invoice-selected', 'TagihanController', [
    '' => 'tagihanMhs',
    '/proses-va' => 'prosesData',
]);
addRouteGroup('/invoice-find', 'TagihanController', [
    '' => 'selectData',
]);
addRouteGroup('/invoice-find-paying', 'TagihanController', [
    '' => 'payingData',
]);
addRouteGroup('/invoice-selected-paying', 'TagihanController', [
    '' => 'transaksiMhs',
]);

addRouteGroup('/multi-transaksi', 'AdjustmentController', [
    '' => 'multiTagihan',
    '/getPaytype' => 'getPaytypeMultiTagihan',
    '/getTotalNominal' => 'getTotalNominal',
    '/add' => 'addDataMultiTagihan',
]);
addRouteGroup('/pelunasan', 'TagihanController', [
    '' => 'pelunasanTagihan',
    '/search' => 'searchTagihan',
    '/save' => 'saveTagihan',
]);

// transaksi tagihan routes
addRouteGroup('/transaksi', 'AdjustmentController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
    '/include' => 'includeData',
    '/getNominal' => 'getNominal',
    '/drop' => 'dropData',
    '/search' => 'searchData',
    '/show' => 'showData',
    '/cekNim' => 'cekNim',

]);


// prodi routes
addRouteGroup('/prodi', 'ProdiController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
    '/include' => 'includeData',
]);

// angkatan routes
addRouteGroup('/angkatan', 'AngkatanController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
    '/include' => 'includeData',
]);

// fakultas routes
addRouteGroup('/fakultas', 'FakultasController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
    '/include' => 'includeData',
]);

// ruangan routes
addRouteGroup('/ruangan', 'RuanganController', [
    '' => 'index',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
    '/include' => 'includeData',
]);

// ruangan routes
addRouteGroup('/kelas', 'KelasController', [
    '' => 'index',
    '/prepare' => 'prepareData',
    '/fetch' => 'fetchData',
    '/add' => 'addData',
    '/update' => 'updateData',
    '/delete' => 'deleteData',
    '/include' => 'includeData',
]);


//profile router
addRouteGroup('/profile', 'ProfileController', [
    '' => 'index',
    '/changes' => 'changesData',
]);

addRouteGroup('/schedule', 'ScheduleController', [
    '' => 'index',
    '/prepare' => 'prepareData',
    '/add' => 'addData',
]);

addRouteGroup('/portal-mhs', 'TagihanController', ['' => 'myInvoice']);


// Dispatch URL
$url = isset($_GET['url']) ? '/' . $_GET['url'] : '/';
$router->dispatch($url);
