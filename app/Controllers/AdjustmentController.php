<?php

class AdjustmentController
{

  private $TagihanModel;
  private $PembayaranModel;
  private $FakultasModel;
  private $dataPaytype;
  private $dataTagihan;
  private $dataFakultas;
  private $tagihanMhs;
  private $optionFilter;
  private $optionFakultas;


  public function __construct()
  {
    $this->checkLogin();

    $this->TagihanModel = new AdjustmentModel();
    $this->PembayaranModel = new PembayaranModel();
    $this->PembayaranModel = new TagihanModel();
    $this->FakultasModel = new FakultasModel();
    $this->dataTagihan = $this->TagihanModel->getAllAdjustment();
    $this->tagihanMhs = $this->TagihanModel->getTagihanMhs();
    $this->optionFilter = $this->TagihanModel->getOptionFilter();
    $this->optionFakultas = $this->TagihanModel->getFieldValuesFakultas('fakultas');
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

    if (isset($_SESSION['fieldNameFilter']) && isset($_SESSION['fieldValueFilter']) && isset($_SESSION['fieldAngkatanFilter'])) {
      $filters = [
        'a.fakultas' => $_SESSION['fieldNameFilter'],
        'a.prodi' => $_SESSION['fieldValueFilter'],
        'a.angkatan' => $_SESSION['fieldAngkatanFilter']
      ];
      $data = $this->TagihanModel->getAllAdjustment($filters);
    } else {
      $data = null;
    }

    $dataOptionFilter = $this->optionFilter;
    $dataOptionFakultas = $this->optionFakultas;

    include __DIR__ . '/../Views/others/page_adjustment.php';
  }

  public function tagihanMhs()
  {

    $data = $this->tagihanMhs;

    include __DIR__ . '/../Views/others/page_tagihan_mhs.php';
  }

  public function multiTagihan()
  {

    $dataPaytype = $this->PembayaranModel->getAll();
    $dataProdi = $this->TagihanModel->getDataProdi();
    $dataAngkatan = $this->TagihanModel->getDataAngkatan();
    $dataFakultas = $this->FakultasModel->getAll();

    include __DIR__ . '/../Views/others/page_multiTagihan.php';
  }

  public function fetchData()
  {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $dataPaytype = $this->PembayaranModel->getAll();
    $dataFakultas = $this->FakultasModel->getAll();
    $dataProdi = $this->TagihanModel->getDataProdi();
    $dataAngkatan = $this->TagihanModel->getDataAngkatan();


    $selectedData = null;
    $selectedDataProdi = null;
    $selectedDataPaytype = null;
    $selectedDataAngkatan = null;
    $selectedDataFakultas = null;

    foreach ($this->dataTagihan as $item) {
      if ($item->recid == $id) {
        $selectedData = $item;
        foreach ($dataProdi as $itemProdi) {
          if ($itemProdi->ID == $item->prodi) {
            $selectedDataProdi = $itemProdi;
          }
        }
        foreach ($dataPaytype as $itemPay) {
          if ($itemPay->jenis_tagihan == $item->jenis_tagihan) {
            $selectedDataPaytype = $itemPay;
          }
        }
        foreach ($dataAngkatan as $itemAngkatan) {
          if ($itemAngkatan->ID_angkatan == $item->angkatan) {
            $selectedDataAngkatan = $itemAngkatan;
          }
        }
        foreach ($dataFakultas as $itemFakultas) {
          if ($itemFakultas->ID == $item->fakultas) {
            $selectedDataFakultas = $itemFakultas;
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
      'optionAngkatan' => $dataAngkatan,
      'dataFakultas' => $selectedDataFakultas,
      'optionFakultas' => $dataFakultas



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

      $_SESSION['fieldNameFilter'] = $dataArray[0]['fakultas'];
      $_SESSION['fieldValueFilter'] = $dataArray[0]['prodi'];
      $_SESSION['fieldAngkatanFilter'] = $dataArray[0]['angkatan'];

      $request = $this->TagihanModel->addData($dataArray[0]);

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

  public function addDataMultiTagihan()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);

    if (empty($dataArray) || !isset($dataArray[0])) {
      $response = [
        'success' => false,
        'message' => 'No data provided',
      ];
    } else {

      $request = $this->TagihanModel->addDataMultiTagihan($dataArray);

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

  public function dropData()
  {
    $recids = $_POST['recids'];

    if (!empty($recids)) {
      // error_log("recids: " . print_r($recids, true));
      $req = $this->TagihanModel->dropData($recids);

      if ($req) {
        echo json_encode(['status' => 'success']);
      } else {
        echo json_encode(['status' => 'error']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'No IDs provided']);
    }
  }

  public function includeData()
  {
    $dataPaytype = $this->PembayaranModel->getAll();
    $dataProdi = $this->TagihanModel->getDataProdi();
    $dataAngkatan = $this->TagihanModel->getDataAngkatan();
    $dataFakultas = $this->FakultasModel->getAll();

    if (!empty($dataPaytype)) {
      $response = [
        'success' => true,
        'data' => [
          'dataPaytype' => $dataPaytype,
          'dataProdi' => $dataProdi,
          'dataAngkatan' => $dataAngkatan,
          'dataFakultas' => $dataFakultas
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


  public function getTotalNominal()
  {
    $selectedPaytype = $_GET['selectedPaytype'] ?? null;
    $fakultas = $_GET['fakultas'] ?? null;
    $prodi = $_GET['prodi'] ?? null;
    $angkatan = $_GET['angkatan'] ?? null;

    if ($selectedPaytype) {
      $data = $this->TagihanModel->getTotalNominal($selectedPaytype, $fakultas, $prodi, $angkatan);

      if ($data) {
        echo json_encode(['success' => true, 'data' => $data['data'], 'totalNominal' => $data['total_nominal']]);
      } else {
        echo json_encode(['success' => false, 'message' => 'Data not found']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
  }

  public function getNominal()
  {
    $fakultas = $_GET['fakultas'] ?? null;
    $prodi = $_GET['prodi'] ?? null;
    $angkatan = $_GET['angkatan'] ?? null;
    $paytype = $_GET['paytype'] ?? null;

    if ($fakultas && $prodi && $angkatan && $paytype) {
      $nominal = $this->TagihanModel->getNominal($fakultas, $prodi, $angkatan, $paytype);

      if ($nominal || $nominal === 0) {
        echo json_encode(['success' => true, 'nominal' => $nominal]);
      } else {
        echo json_encode(['success' => false, 'message' => 'Data not found']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
  }
  public function getPaytypeMultiTagihan()
  {
    $fakultas = $_GET['fakultas'] ?? null;
    $prodi = $_GET['prodi'] ?? null;
    $angkatan = $_GET['angkatan'] ?? null;
    error_log("fakultas: " . print_r($fakultas, true));


    if ($fakultas && $prodi && $angkatan) {
      $dataPaytype = $this->TagihanModel->getPaytypeMultiTagihan($fakultas, $prodi, $angkatan);

      error_log("dataPaytype: " . print_r($dataPaytype, true));

      if ($dataPaytype) {
        echo json_encode(['success' => true, 'data' => $dataPaytype]);
      } else {
        echo json_encode(['success' => false, 'message' => 'Data not found']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
  }

  public function searchData()
  {
    $field = $_GET['field'] ?? null;

    if ($field) {
      $prodi = $this->TagihanModel->getFieldValuesProdi($field);
      $angkatan = $this->TagihanModel->getFieldValuesAngkatan($field);

      if ($prodi && $angkatan) {
        echo json_encode(['success' => true, 'prodi' => $prodi, 'angkatan' => $angkatan]);
      } else {
        echo json_encode(['success' => false, 'prodi' => null, 'angkatan' => null]);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
  }

  public function showData()
  {
    $field = $_GET['field'] ?? null;
    $value = $_GET['value'] ?? null;
    $angkatan = $_GET['angkatan'] ?? null;

    if ($field && $value && $angkatan) {

      $_SESSION['fieldNameFilter'] = $field;
      $_SESSION['fieldValueFilter'] = $value;
      $_SESSION['fieldAngkatanFilter'] = $angkatan;

      $filters = [
        'a.fakultas' => $_SESSION['fieldNameFilter'],
        'a.prodi' => $_SESSION['fieldValueFilter'],
        'a.angkatan' => $_SESSION['fieldAngkatanFilter'],
      ];


      $result = $this->TagihanModel->getAllAdjustment($filters);

      if ($result) {
        echo json_encode(['success' => true, 'data' => $result]);
      } else {
        echo json_encode(['success' => false, 'message' => 'value not found']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
  }
}
