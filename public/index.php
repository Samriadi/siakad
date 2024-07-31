<?php
session_start();
date_default_timezone_set('Asia/Makassar');

require_once __DIR__ . '/../app/Core/Router.php';   
require_once __DIR__ . '/../app/Core/Database.php';
// require_once __DIR__ . '/../app/Helpers/Function.php';
// require_once __DIR__ . '/../app/Core/Table.php';

require_once __DIR__ . '/../app/Controllers/MainController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';

require_once __DIR__ . '/../app/Models/MahasiswaModel.php';



$router = new Router();
$router->add('/', 'MainController', 'index');
$router->add('/login', 'AuthController', 'login');

$router->add('/mahasiswa', 'MahasiswaController', 'index');
$router->add('/mahasiswa/import', 'MahasiswaController', 'importData');

$router->add('/ortu', 'MahasiswaController', 'ortu');
$router->add('/mahasiswa/import-ortu', 'MahasiswaController', 'importDataOrtu');




$url = isset($_GET['url']) ? '/' . $_GET['url'] : '/';

$router->dispatch($url);
