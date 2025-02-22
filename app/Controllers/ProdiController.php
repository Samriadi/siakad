<?php

class ProdiController
{

  private $ProdiModel;
  private $FakultasModel;
  private $dataProdi;

  public function __construct()
  {
    $this->checkLogin();

    $this->ProdiModel = new ProdiModel();
    $this->FakultasModel = new FakultasModel();

    $this->dataProdi = $this->ProdiModel->getAll();
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

    $data = $this->dataProdi;

    include __DIR__ . '/../Views/others/page_prodi.php';
  }

  // public function addData()
  // {
  //   $dataArray = json_decode(file_get_contents('php://input'), true);

  //   if (empty($dataArray) || !isset($dataArray[0])) {
  //     $response = [
  //       'success' => false,
  //       'message' => 'No data provided',
  //     ];
  //   } else {
  //     $request = $this->ProdiModel->addData($dataArray[0]);

  //     if ($request === 'success') {
  //       $response = [
  //         'success' => true,
  //         'message' => 'Data berhasil ditambahkan',
  //       ];
  //     } elseif ($request === 'exists') {
  //       $response = [
  //         'success' => false,
  //         'message' => 'Data sudah ada',
  //       ];
  //     } else {
  //       $response = [
  //         'success' => false,
  //         'message' => 'Gagal menambahkan data',
  //       ];
  //     }
  //   }
  //   header('Content-Type: application/json');
  //   echo json_encode($response);
  //   exit;
  // }


  public function fetchData()
  {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;


    $dataFakultas = $this->FakultasModel->getAll();

    $selectedData = null;
    $selectedDataFakultas = null;

    foreach ($this->dataProdi as $item) {
      if ($item->ID == $id) {
        $selectedData = $item;
        error_log("id: " . print_r($selectedData, true));

        foreach ($dataFakultas as $itemFakultas) {
          if ($itemFakultas->ID == $item->fakultas) {
            $selectedDataFakultas = $itemFakultas;
            error_log("item selected fakultas: " . print_r($selectedDataFakultas, true));
          }
        }

        break;
      }
    }

    header('Content-Type: application/json');
    echo json_encode([
      'success' => $selectedData !== null,
      'data' => $selectedData,
      'dataFakultas' => $selectedDataFakultas,
      'optionFakultas' => $dataFakultas
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
      $request = $this->ProdiModel->updateData($dataArray[0]);

      $response = [
        'success' => $request,
        'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
      ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }

  // public function deleteData()
  // {
  //   header('Content-Type: application/json');

  //   if (!isset($_POST['id']) || empty($_POST['id'])) {
  //     echo json_encode(['success' => false, 'message' => 'Invalid ID']);
  //     return;
  //   }

  //   $id = intval($_POST['id']);

  //   $success = $this->ProdiModel->deleteData($id);

  //   echo json_encode(['success' => $success]);
  // }
}
