<?php

class MahasiswaController
{

    private $MahasiswaModel;
    private $dataMahasiswa;
    private $checkData;

    public function __construct()
    {
        $this->checkLogin();

        $this->MahasiswaModel = new MahasiswaModel();
        $this->dataMahasiswa = $this->MahasiswaModel->getAll();
        $this->checkData = $this->MahasiswaModel->checkData();
    }

    public function checkLogin() {
        if (!isset($_SESSION['user_loged'])) {
            header("Location: /admin/login");
            exit();
        }
      }
      
    public function index()
    {

        $data = $this->dataMahasiswa;
        $isData = $this->checkData;

        include __DIR__ . '/../Views/others/page_mahasiswa.php';
    }
    public function importData()
    {
        try {
            ob_start();

            $this->MahasiswaModel->importData();
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

    public function fetchData()
    {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        // Menemukan data berdasarkan ID
        $selectedData = null;
        foreach ($this->dataMahasiswa as $item) {
            if ($item->ID == $id) {
                $selectedData = $item;
                break;
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $selectedData !== null,
            'data' => $selectedData,
        ]);
    }

    public function fetchDataOrtu()
    {
        $recid = isset($_POST['recid']) ? intval($_POST['recid']) : 0;

        $dataOrtu = $this->MahasiswaModel->getOrtu();

        $selectedData = null;
        foreach ($dataOrtu as $item) {
            if ($item->recid == $recid) {
                $selectedData = $item;
                break;
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => $selectedData !== null,
            'data' => $selectedData,
        ]);
    }

    public function updateData()
    {
        $dataArray = json_decode(file_get_contents('php://input'), true);

        if ($dataArray === null) {
            $response = [
                'success' => false,
                'message' => 'Invalid JSON input'
            ];
        } else {
            $request = $this->MahasiswaModel->updateData($dataArray[0]);

            $response = [
                'success' => $request,
                'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function updateDataOrtu()
    {
        $dataArray = json_decode(file_get_contents('php://input'), true);

        if ($dataArray === null) {
            $response = [
                'success' => false,
                'message' => 'Invalid JSON input'
            ];
        } else {
            $request = $this->MahasiswaModel->updateDataOrtu($dataArray[0]);

            $response = [
                'success' => $request,
                'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }




    public function ortu()
    {
        $data = $this->MahasiswaModel->getOrtu();

        include __DIR__ . '/../Views/others/page_ortu.php';
    }

    public function deleteData()
    {
        header('Content-Type: application/json');

        if (!isset($_POST['id']) || empty($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            return;
        }

        $id = intval($_POST['id']);

        $success = $this->MahasiswaModel->deleteData($id);
        $success = $this->MahasiswaModel->deleteDataOrtu($id);


        echo json_encode(['success' => $success]);
    }

    public function importDataCSV()
    {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $filename = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if ($filename === "csv") {
                $handle = fopen($_FILES['file']['tmp_name'], "r");
                if ($handle !== FALSE) {
                    try {
                        // Skip the first line (header)
                        fgetcsv($handle);
                        
                        // Set your CSV delimiter here
                        $delimiter = ";"; // Change this if your CSV uses a different delimiter
                        
                        while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                            // Log the raw row for debugging
                            error_log("Raw CSV row: " . print_r($data, true));

                            if (count($data) >= 4) {
                                $NamaLengkap = isset($data[0]) ? trim($data[0]) : null;
                                $Nim = isset($data[1]) ? trim($data[1]) : null;
                                $WANumber = isset($data[2]) ? trim($data[2]) : null;
                                $alamat = isset($data[3]) ? trim($data[3]) : null;

                                // Log data being processed
                                error_log("Processing: $NamaLengkap, $Nim, $WANumber, $alamat");

                                // Save the data
                                $this->MahasiswaModel->saveMahasiswa($NamaLengkap, $Nim, $WANumber, $alamat);
                            } else {
                                // Log invalid rows with specific details
                                error_log("Invalid CSV row or missing columns: " . print_r($data, true));
                            }
                        }

                        fclose($handle);
                    } catch (Exception $e) {
                        error_log("Exception caught during CSV import: " . $e->getMessage());
                    }
                } else {
                    error_log("Error opening CSV file: " . $_FILES['file']['tmp_name']);
                }
            } else {
                error_log("Uploaded file is not a CSV: " . $_FILES['file']['name']);
            }
        } else {
            error_log("No file uploaded or file upload error.");
        }
    }



    
    
}
