<?php

class MahasiswaController{

    private $MahasiswaModel;
    private $dataMahasiswa;

    public function __construct()
    {
        $this->MahasiswaModel = new MahasiswaModel();
        $this->dataMahasiswa = $this->MahasiswaModel->getAll();
    }
    public function index(){

        $this->dataMahasiswa;

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

    public function fetchData() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        // Menemukan data berdasarkan ID
        $selectedData = null;
        foreach ($this->dataMahasiswa as $item) {
            if ($item->ID == $id) {
                $selectedData = $item;
                break;
            }
        }

        // Mengirimkan respons kembali ke JavaScript
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $selectedData !== null,
            'data' => $selectedData,
        ]);
    }

   public function updateData() {
    // Get and decode the JSON input
    $dataArray = json_decode(file_get_contents('php://input'), true);
    
    if ($dataArray === null) {
        // Invalid JSON
        $response = [
            'success' => false,
            'message' => 'Invalid JSON input'
        ];
    } else {
        $request = $this->MahasiswaModel->updateData($dataArray[0]);
        
        // Prepare success response
        $response = [
            'success' => $request,
            'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
        ];
    }

    // Set response header and echo JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
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