<?php

class DosenController
{

  private $DosenModel;
  private $dataDosen;
  private $dataPenugasan;

  public function __construct()
  {
    $this->checkLogin();

    $this->DosenModel = new DosenModel();
    $this->dataDosen = $this->DosenModel->getAll();
    $this->dataPenugasan = $this->DosenModel->getAllPenugasan();
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

    $data = $this->dataDosen;
    $dataPenugasan = $this->dataPenugasan;

    include __DIR__ . '/../Views/others/page_dosen.php';
  }

  public function fetchData()
  {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $selectedData = null;
    foreach ($this->dataDosen as $item) {
      if ($item->lecturer_id == $id) {
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
      $request = $this->DosenModel->addData($dataArray[0]);

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
      $request = $this->DosenModel->updateData($dataArray[0]);

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

    // Call the model method to delete the record
    $success = $this->DosenModel->deleteData($id);

    // Return JSON response
    echo json_encode(['success' => $success]);
  }
}
