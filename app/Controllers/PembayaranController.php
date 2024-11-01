<?php

class PembayaranController
{

  private $PembayaranModel;

  public function __construct()
  {
    $this->checkLogin();
    $this->PembayaranModel = new PembayaranModel();
    $this->PembayaranData = $this->PembayaranModel->getAll();
  }

  public function checkLogin() {
    if (!isset($_SESSION['user_loged'])) {
        header("Location: /admin/login");
        exit();
    }
  }

  public function index()
  {

    $PembayaranData = $this->PembayaranData;
    include __DIR__ . '/../Views/others/page_pembayaran.php';
  }

  public function fetchData()
  {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $selectedData = null;
    foreach ($this->PembayaranData as $item) {
      if ($item->recid == $id) {
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

  public function addData()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);

    if ($dataArray === null) {
      $response = [
        'success' => false,
        'message' => 'Invalid JSON input'
      ];
    } else {
      $request = $this->PembayaranModel->addData($dataArray[0]);

      $response = [
        'success' => $request,
        'message' => $request ? 'Data successfully added' : 'Add data failed',
        'data' => $dataArray[0],
      ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
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
      $request = $this->PembayaranModel->updateData($dataArray[0]);

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

    $success = $this->PembayaranModel->deleteData($id);

    echo json_encode(['success' => $success]);
  }
}
