<?php

class AngkatanController
{

  private $AngkatanModel;
  private $dataAngkatan;

  public function __construct()
  {
    $this->checkLogin();

    $this->AngkatanModel = new AngkatanModel();
    $this->dataAngkatan = $this->AngkatanModel->getAll();
    // $filteredRecords = $yourModel->getAll(['column_name' => 'value', 'another_column' => 'another_value']);

  }
  public function checkLogin()
  {
    if (!isset($_SESSION['user_loged'])) {
      header("Location: /admin/login");
      exit();
    }
  }
  public function index()
  {

    $data = $this->dataAngkatan;

    include __DIR__ . '/../Views/others/page_angkatan.php';
  }

  public function addData()
  {
    // Ambil data JSON dari request body
    $dataArray = json_decode(file_get_contents('php://input'), true);

    // Pastikan data tidak kosong
    if (empty($dataArray) || !isset($dataArray[0])) {
      $response = [
        'success' => false,
        'message' => 'No data provided',
      ];
    } else {
      // Panggil fungsi addData pada model dan tangkap hasilnya
      $request = $this->AngkatanModel->addData($dataArray[0]);

      // Tentukan respon berdasarkan hasil dari model
      if ($request === 'success') {
        $response = [
          'success' => true,
          'message' => 'Data berhasil ditambahkan',
        ];
      } elseif ($request === 'exists') {
        $response = [
          'success' => false,
          'message' => 'Data sudah ada',
        ];
      } else {
        $response = [
          'success' => false,
          'message' => 'Gagal menambahkan data',
        ];
      }
    }

    // Set response header dan kirim JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
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
      $request = $this->AngkatanModel->updateData($dataArray[0]);

      $response = [
        'success' => $request,
        'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
      ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }

  public function deleteData()
  {
    header('Content-Type: application/json');

    if (!isset($_POST['id']) || empty($_POST['id'])) {
      echo json_encode(['success' => false, 'message' => 'Invalid ID']);
      return;
    }

    $id = intval($_POST['id']);

    $success = $this->AngkatanModel->deleteData($id);

    echo json_encode(['success' => $success]);
  }
}
