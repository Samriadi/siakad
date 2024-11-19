<?php

class ProdiController
{

  private $ProdiModel;

  public function __construct()
  {
    $this->checkLogin();

    $this->ProdiModel = new ProdiModel();
    $this->dataProdi = $this->ProdiModel->getAll();
  }
  public function checkLogin() {
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

  public function fetchData()
  {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $dataPaytype = $this->PembayaranModel->getAll();
    $dataProdi = $this->TagihanModel->getDataProdi();
    $dataAngkatan = $this->TagihanModel->getDataAngkatan();


    $selectedData = null;
    $selectedDataProdi = null;
    $selectedDataPaytype = null;
    $selectedDataAngkatan = null;

    foreach ($this->dataTagihan as $item) {
      if ($item->recid == $id) {
        $selectedData = $item;
        foreach ($dataProdi as $itemProdi) {
          if ($itemProdi->ID == $item->prodi) {
            $selectedDataProdi = $itemProdi;
            // error_log("item selected prodi: " . print_r($selectedDataProdi, true));
          }
        }
        foreach ($dataPaytype as $itemPay) {
          if ($itemPay->recid == $item->jenis_tagihan) {
            $selectedDataPaytype = $itemPay;
          }
        }
        foreach ($dataAngkatan as $itemAngkatan) {
          if ($itemAngkatan->ID_angkatan == $item->angkatan) {
            $selectedDataAngkatan = $itemAngkatan;
          }
        }
        break;
      }
    }

    header('Content-Type: application/json');
    echo json_encode([
      'success' => $selectedData !== null,
      'data' => $selectedData,
      'dataPaytype' => $selectedDataPaytype,
      'optionPaytype' => $dataPaytype,
      'dataProdi' => $selectedDataProdi,
      'optionProdi' => $dataProdi,
      'dataAngkatan' => $selectedDataAngkatan,
      'optionAngkatan' => $dataAngkatan
    ]);
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
          $request = $this->ProdiModel->addData($dataArray[0]);
  
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
      $request = $this->TagihanModel->updateData($dataArray[0]);

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

    $success = $this->TagihanModel->deleteData($id);

    echo json_encode(['success' => $success]);
  }

  public function includeData()
  {
    $dataPaytype = $this->PembayaranModel->getAll();
    $dataProdi = $this->TagihanModel->getDataProdi();
    $dataAngkatan = $this->TagihanModel->getDataAngkatan();

    if (!empty($dataPaytype)) {
      $response = [
        'success' => true,
        'data' => [
          'dataPaytype' => $dataPaytype,
          'dataProdi' => $dataProdi,
          'dataAngkatan' => $dataAngkatan
        ]
      ];
    } else {
      $response = [
        'success' => false,
        'message' => 'Data tidak ditemukan'
      ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }


}
