<?php

class RuanganController
{

  private $RuanganModel;
  private $dataRuangan;

  public function __construct()
  {
    $this->checkLogin();

    $this->RuanganModel = new RuanganModel();
    $this->dataRuangan = $this->RuanganModel->getAll();
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

    $data = $this->dataRuangan;

    include __DIR__ . '/../Views/others/page_ruangan.php';
  }

  public function addData()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);
    if (empty($dataArray) || !isset($dataArray[0])) {
      $response = [
        'success' => false,
        'message' => 'No data provided',
      ];
    } else {
      $request = $this->RuanganModel->addData($dataArray[0]);

      if ($request) {
        $response = [
          'success' => true,
          'message' => 'Data berhasil ditambahkan',
        ];
      } else {
        $response = [
          'success' => false,
          'message' => 'Gagal menambahkan data',
        ];
      }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }

  public function fetchData()
  {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $selectedData = null;
    foreach ($this->dataRuangan as $item) {
      if ($item->ID_ruangan == $id) {
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



  // public function updateData()
  // {
  //   $dataArray = json_decode(file_get_contents('php://input'), true);

  //   if ($dataArray === null) {
  //     $response = [
  //       'success' => false,
  //       'message' => 'Invalid JSON input'
  //     ];
  //   } else {
  //     $request = $this->RuanganModel->updateData($dataArray[0]);

  //     $response = [
  //       'success' => $request,
  //       'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
  //     ];
  //   }

  //   header('Content-Type: application/json');
  //   echo json_encode($response);
  // }

  // public function deleteData()
  // {
  //   header('Content-Type: application/json');

  //   if (!isset($_POST['id']) || empty($_POST['id'])) {
  //     echo json_encode(['success' => false, 'message' => 'Invalid ID']);
  //     return;
  //   }

  //   $id = intval($_POST['id']);

  //   $success = $this->AngkatanModel->deleteData($id);

  //   echo json_encode(['success' => $success]);
  // }
}
