<?php

class MahasiswaController{

    private $MahasiswaModel;

    public function __construct()
    {
        $this->MahasiswaModel = new MahasiswaModel();
    }
    public function index(){

        $data = $this->MahasiswaModel->getAll();

        include __DIR__ . '/../Views/others/page_mahasiswa.php';
    }
    public function importData() {
        try {
            ob_start();
            
            $this->MahasiswaModel->importData();
            
            ob_end_clean();
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function ortu() {
        $data = $this->MahasiswaModel->getOrtu();

        include __DIR__ . '/../Views/others/page_ortu.php';
    }

    public function importDataOrtu() {
        try {
            ob_start();
            
            $this->MahasiswaModel->importDataOrtu();
            
            ob_end_clean();
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

}