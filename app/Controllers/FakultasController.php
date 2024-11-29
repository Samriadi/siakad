<?php

class FakultasController
{

  private $FakultasModel;
  private $dataFakultas;

  public function __construct()
  {
    $this->checkLogin();

    $this->FakultasModel = new FakultasModel();
    $this->dataFakultas = $this->FakultasModel->getAll();
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

    $data = $this->dataFakultas;

    include __DIR__ . '/../Views/others/page_fakultas.php';
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
  //     $request = $this->FakultasModel->addData($dataArray[0]);

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




  // public function updateData()
  // {
  //   $dataArray = json_decode(file_get_contents('php://input'), true);

  //   if ($dataArray === null) {
  //     $response = [
  //       'success' => false,
  //       'message' => 'Invalid JSON input'
  //     ];
  //   } else {
  //     $request = $this->FakultasModel->updateData($dataArray[0]);

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

  //   $success = $this->FakultasModel->deleteData($id);

  //   echo json_encode(['success' => $success]);
  // }
}
