<?php

class MainController{

    public function __construct()
    {
      $this->checkLogin();
      $this->MahasiswaModel = new MahasiswaModel();

    }

    public function checkLogin() {
        if (!isset($_SESSION['user_loged'])) {
            header("Location: /admin/login");
            exit();
        }
      }
      
    public function index(){
        
        if (!isset($_SESSION['user_loged'])) {
            header("Location: /admin/login");
            exit();
        }
    
        // Jika sesi ada, tampilkan halaman dashboard
        include __DIR__ . '/../Views/others/page_dashboard.php';
    }
    
    public function selectDash()
    {
        include __DIR__ . '/../Views/others/page_selectDash.php';
    }

     //pmb
    public function indexRegist()
    {
        include __DIR__ . '/../Views/others/page_regist.php';
    }

    public function addRegist() {
        $nik = $_POST['nik'] ?? ''; 
        
        // Mengecek apakah NIK sudah terdaftar
        $checkNik = $this->MahasiswaModel->getDataRegistUsingNik($nik);
        
        if (!empty($checkNik)) {
            $response = [
                'status' => 'exist',
                'message' => 'Anda sudah terdaftar sebelumnya. Silahkan login menggunakan NIK dan password Anda sebelumnya.'
            ];
        }
        else{
            // $addNik = $this->MahasiswaModel->addDataRegistUsingNik($nik);

            $response =  ['status' => 'null', 'data' => $nik];
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function insertRegist()
    {
        include __DIR__ . '/../Views/others/page_insertRegist.php';
    }
    
    

}