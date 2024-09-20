<?php
session_start();
date_default_timezone_set('Asia/Makassar');

require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Table.php';
// require_once __DIR__ . '/../app/Helpers/Function.php';

require_once __DIR__ . '/../app/Controllers/MainController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';
require_once __DIR__ . '/../app/Controllers/DosenController.php';
require_once __DIR__ . '/../app/Controllers/StaffController.php';
require_once __DIR__ . '/../app/Controllers/MatkulController.php';
require_once __DIR__ . '/../app/Controllers/PerkuliahanController.php';

require_once __DIR__ . '/../app/Models/MahasiswaModel.php';
require_once __DIR__ . '/../app/Models/DosenModel.php';
require_once __DIR__ . '/../app/Models/StaffModel.php';
require_once __DIR__ . '/../app/Models/MatkulModel.php';
require_once __DIR__ . '/../app/Models/PerkuliahanModel.php';



$router = new Router();
$router->add('/', 'MainController', 'index');
$router->add('/login', 'AuthController', 'login');

$router->add('/mahasiswa', 'MahasiswaController', 'index');
$router->add('/mahasiswa/import', 'MahasiswaController', 'importData');
$router->add('/mahasiswa/importCSV', 'MahasiswaController', 'importDataCSV');
$router->add('/mahasiswa/fetch', 'MahasiswaController', 'fetchData');
$router->add('/mahasiswa/update', 'MahasiswaController', 'updateData');
$router->add('/mahasiswa/delete', 'MahasiswaController', 'deleteData');


$router->add('/ortu', 'MahasiswaController', 'ortu');
$router->add('/ortu/fetch', 'MahasiswaController', 'fetchDataOrtu');
$router->add('/ortu/update', 'MahasiswaController', 'updateDataOrtu');
$router->add('/ortu/delete', 'MahasiswaController', 'deleteDataOrtu');


$router->add('/dosen', 'DosenController', 'index');
$router->add('/dosen/fetch', 'DosenController', 'fetchData');
$router->add('/dosen/add', 'DosenController', 'addData');
$router->add('/dosen/update', 'DosenController', 'updateData');
$router->add('/dosen/delete', 'DosenController', 'deleteData');

$router->add('/staff', 'StaffController', 'index');
$router->add('/staff/fetch', 'StaffController', 'fetchData');
$router->add('/staff/add', 'StaffController', 'addData');
$router->add('/staff/update', 'StaffController', 'updateData');
$router->add('/staff/delete', 'StaffController', 'deleteData');

$router->add('/matkul', 'MatkulController', 'index');
$router->add('/matkul/fetch', 'MatkulController', 'fetchData');
$router->add('/matkul/add', 'MatkulController', 'addData');
$router->add('/matkul/update', 'MatkulController', 'updateData');
$router->add('/matkul/delete', 'MatkulController', 'deleteData');

$router->add('/perkuliahan', 'PerkuliahanController', 'index');
$router->add('/perkuliahan/fetch', 'PerkuliahanController', 'fetchData');
$router->add('/perkuliahan/add', 'PerkuliahanController', 'addData');
$router->add('/perkuliahan/update', 'PerkuliahanController', 'updateData');
$router->add('/perkuliahan/delete', 'PerkuliahanController', 'deleteData');
$router->add('/perkuliahan/include', 'PerkuliahanController', 'includeData');

$router->add('/krs', 'KrsController', 'krs');







$url = isset($_GET['url']) ? '/' . $_GET['url'] : '/';

$router->dispatch($url);
