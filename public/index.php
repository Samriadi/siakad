<?php
session_start();
date_default_timezone_set('Asia/Makassar');

require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Table.php';
// require_once __DIR__ . '/../app/Helpers/Function.php';
// require_once __DIR__ . '/../app/Core/Table.php';

require_once __DIR__ . '/../app/Controllers/MainController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';
require_once __DIR__ . '/../app/Controllers/DosenController.php';

require_once __DIR__ . '/../app/Models/MahasiswaModel.php';
require_once __DIR__ . '/../app/Models/DosenModel.php';



$router = new Router();
$router->add('/', 'MainController', 'index');
$router->add('/login', 'AuthController', 'login');

$router->add('/mahasiswa', 'MahasiswaController', 'index');
$router->add('/mahasiswa/import', 'MahasiswaController', 'importData');
$router->add('/mahasiswa/fetch', 'MahasiswaController', 'fetchData');
$router->add('/mahasiswa/update', 'MahasiswaController', 'updateData');

$router->add('/ortu', 'MahasiswaController', 'ortu');
$router->add('/ortu/fetch', 'MahasiswaController', 'fetchDataOrtu');
$router->add('/ortu/update', 'MahasiswaController', 'updateDataOrtu');
$router->add('/mahasiswa/import-ortu', 'MahasiswaController', 'importDataOrtu');

$router->add('/dosen', 'DosenController', 'index');
$router->add('/dosen/fetch', 'DosenController', 'fetchData');
$router->add('/dosen/add', 'DosenController', 'addData');
$router->add('/dosen/update', 'DosenController', 'updateData');
$router->add('/dosen/delete', 'DosenController', 'deleteData');






$url = isset($_GET['url']) ? '/' . $_GET['url'] : '/';

$router->dispatch($url);
