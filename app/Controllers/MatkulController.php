<?php

class MatkulController
{

  private $MatkulModel;
  private $dataMatkul;

  public function __construct()
  {
    $this->MatkulModel = new MatkulModel();
    $this->dataMatkul = $this->MatkulModel->getAll();
  }
  public function index()
  {

    $data = $this->dataMatkul;

    include __DIR__ . '/../Views/others/page_matkul.php';
  }

  public function fetchData()
  {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $selectedData = null;
    foreach ($this->dataMatkul as $item) {
      if ($item->course_id == $id) {
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
      $request = $this->MatkulModel->addData($dataArray[0]);

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
      $request = $this->MatkulModel->updateData($dataArray[0]);

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

    $success = $this->MatkulModel->deleteData($id);

    echo json_encode(['success' => $success]);
  }
}
