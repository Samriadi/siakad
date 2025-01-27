<?php

class TagihanController
{

  private $TagihanModel;
  private $PembayaranModel;
  private $FakultasModel;
  private $ProdiModel;
  private $dataPaytype;
  private $dataTagihan;
  private $tagihanMhs;
  private $selectedData;
  private $transaksiMhs;


  public function __construct()
  {
    $this->checkLogin();

    $this->TagihanModel = new TagihanModel();
    $this->PembayaranModel = new PembayaranModel();
    $this->FakultasModel = new FakultasModel();
    $this->ProdiModel = new ProdiModel();
    $this->dataTagihan = $this->TagihanModel->getAll();
    $this->tagihanMhs = $this->TagihanModel->getTagihanMhs();
    $this->transaksiMhs = $this->TagihanModel->getTransaksiMhs();
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

    $data = $this->dataTagihan;

    include __DIR__ . '/../Views/others/page_tagihan.php';
  }

  public function tagihanMhs()
  {
    $data = $this->tagihanMhs;
    $dataSelected = $_SESSION['selectedData'];
    include __DIR__ . '/../Views/others/page_tagihan_mhs.php';
  }

  public function transaksiMhs()
  {
    $data = $this->transaksiMhs;
    $dataSelectedPaying = $_SESSION['selectedPaying'];
    include __DIR__ . '/../Views/others/page_transaksi_mhs.php';
  }

  public function pelunasanTagihan()
  {
    include __DIR__ . '/../Views/others/page_pelunasan.php';
  }

  public function myInvoice()
  {
    $data = $this->TagihanModel->getMyInvoice();
    include __DIR__ . '/../Views/others/page_tagihanSaya.php';
  }

  public function searchTagihan()
  {
    $nim = $_GET['nim'] ?? null;

    if ($nim) {
      $dataTagihan = $this->TagihanModel->searchTagihan($nim);
      error_log("data tagihan: " . print_r($dataTagihan, true));


      if ($dataTagihan) {
        echo json_encode(['success' => true, 'data' => $dataTagihan]);
      } else {
        echo json_encode(['success' => false, 'message' => 'Data not found']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
  }

  public function saveTagihan()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);

    if (empty($dataArray)) {
      $response = [
        'success' => false,
        'message' => 'No data provided',
      ];
    } else {
      $request = $this->TagihanModel->savePembayaranTagihan($dataArray);

      if ($request === 'success') {
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

    // Set response header dan kirim JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }


  public function selectData()
  {
    $id_fakultas = $_GET['fakultas_id'] ?? null;

    if ($id_fakultas) {
      $dataSelect = $this->ProdiModel->getAll(['fakultas' => $id_fakultas]);

      if ($dataSelect) {
        unset($_SESSION['selectedData']);

        $_SESSION['selectedData'] = $dataSelect;

        echo json_encode(['success' => true, 'data' => $_SESSION['selectedData']]);
      } else {
        echo json_encode(['success' => false, 'message' => 'Data not found']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
  }

  public function payingData()
  {
    $id_fakultas = $_GET['fakultas_id'] ?? null;

    if ($id_fakultas) {
      $payingData = $this->ProdiModel->getAll(['fakultas' => $id_fakultas]);

      if ($payingData) {
        unset($_SESSION['selectedPaying']);

        $_SESSION['selectedPaying'] = $payingData;

        echo json_encode(['success' => true, 'data' => $_SESSION['selectedPaying']]);
      } else {
        echo json_encode(['success' => false, 'message' => 'Data not found']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
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
      $request = $this->TagihanModel->addData($dataArray[0]);

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

  public function prosesData()
  {
    // Decode the incoming JSON request
    $inputData = json_decode(file_get_contents('php://input'), true);

    error_log("Input data: " . print_r($inputData, true));

    // Check if the input data is empty
    if (empty($inputData)) {
      echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
      return;
    }

    // Initialize an array to store error messages
    $errors = [];

    // Iterate over the input data and check for missing fields
    foreach ($inputData as $index => $item) {
      if (empty($item['nim']) || empty($item['nama']) || empty($item['prodi']) || empty($item['angkatan'])) {
        $errors[] = "Data pada baris ke-$index tidak lengkap.";
      }
    }

    // If there are any errors, return them in the response
    if (!empty($errors)) {
      echo json_encode(['status' => 'error', 'message' => $errors]);
      return;
    }

    // Call the model to process the data
    $result = $this->TagihanModel->prosesInvoice($inputData);

    // Return success or error response based on the result of the processing
    if ($result) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Data berhasil diproses!',
        'data' => $result
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Gagal memproses data.',
        'data' => null
      ]);
    }
  }
}
