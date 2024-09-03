<?php

class MahasiswaController
{

    private $MahasiswaModel;
    private $dataMahasiswa;
    private $checkData;

    public function __construct()
    {
        $this->MahasiswaModel = new MahasiswaModel();
        $this->dataMahasiswa = $this->MahasiswaModel->getAll();
        $this->checkData = $this->MahasiswaModel->checkData();
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

    public function importCSV()
    {
        if (isset($_POST['importCSV'])) {
            if ($_FILES['file']['name']) {
                $filename = explode(".", $_FILES['file']['name']);
                if (end($filename) == "csv") {
                    $handle = fopen($_FILES['file']['tmp_name'], "r");
                    if ($handle !== FALSE) {
                        try {
                            // Skip the first line if CSV has headers
                            fgetcsv($handle);

                            while ($data = fgetcsv($handle)) {
                                if ($data !== FALSE) {
                                    // Data mapping, sesuai dengan urutan kolom di CSV
                                    $NamaLengkap = $data[0];
                                    $Nim = $data[1];
                                    $WANumber = $data[2];
                                    $alamat = $data[3];

                                    // Simpan data ke dalam database menggunakan model
                                    $this->MahasiswaModel->saveMahasiswa($NamaLengkap, $Nim, $WANumber, $alamat);
                                } else {
                                    // Log the error if a line can't be parsed
                                    error_log("Error parsing CSV line: " . print_r($data, true));
                                }
                            }
                            fclose($handle);
                        } catch (Exception $e) {
                            // Log any exceptions that occur during processing
                            error_log("Exception caught during CSV import: " . $e->getMessage());
                        }
                    } else {
                        // Log error if file can't be opened
                        error_log("Error opening CSV file: " . $_FILES['file']['tmp_name']);
                    }
                } else {
                    // Log error if file is not a CSV
                    error_log("Uploaded file is not a CSV: " . $_FILES['file']['name']);
                }
            } else {
                // Log error if no file was uploaded
                error_log("No file uploaded for CSV import.");
            }
        } else {
            // Log error if importCSV was not set
            error_log("importCSV was not set in POST request.");
        }
    }
}
