<?php

class StaffController
{

  private $StaffModel;
  private $dataStaff;

  public function __construct()
  {
    $this->checkLogin();

    $this->StaffModel = new StaffModel();
    $this->dataStaff = $this->StaffModel->getAll();
  }
  public function checkLogin() {
    if (!isset($_SESSION['user_loged'])) {
        header("Location: /admin/login");
        exit();
    }
  }
  public function index()
  {

    $data = $this->dataStaff;

    include __DIR__ . '/../Views/others/page_staff.php';
  }

  public function fetchData()
  {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $selectedData = null;
    foreach ($this->dataStaff as $item) {
      if ($item->IDStaff == $id) {
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
      $request = $this->StaffModel->addData($dataArray[0]);

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
      $request = $this->StaffModel->updateData($dataArray[0]);

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

    $success = $this->StaffModel->deleteData($id);

    echo json_encode(['success' => $success]);
  }
}
