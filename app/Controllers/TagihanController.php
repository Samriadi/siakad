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


  public function __construct()
  {
    $this->checkLogin();

    $this->TagihanModel = new TagihanModel();
    $this->PembayaranModel = new PembayaranModel();
    $this->FakultasModel = new FakultasModel();
    $this->ProdiModel = new ProdiModel();
    $this->dataTagihan = $this->TagihanModel->getAll();
    $this->tagihanMhs = $this->TagihanModel->getTagihanMhs();
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
    $dataSelected = $_SESSION['selectedData'];;
    // error_log("item selected prodi: " . print_r($dataSelected, true));

    include __DIR__ . '/../Views/others/page_tagihan_mhs.php';
  }

  public function selectData()
  {
    $id_fakultas = $_GET['fakultas_id'] ?? null;

    error_log("item: " . print_r($id_fakultas, true));

    if ($id_fakultas) {
      $dataSelect = $this->ProdiModel->getAll(['fakultas' => $id_fakultas]);

      error_log("item select: " . print_r($dataSelect, true));

      if ($dataSelect) {
        // Hapus sesi sebelumnya
        unset($_SESSION['selectedData']);

        // Isi sesi baru
        $_SESSION['selectedData'] = $dataSelect;

        echo json_encode(['success' => true, 'data' => $_SESSION['selectedData']]);
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

  public function prosesInvoice()
  {
    // Ambil data dari request (JSON)
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (empty($inputData)) {
      echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
      return;
    }

    // Validasi data
    $errors = [];
    foreach ($inputData as $index => $item) {
      if (empty($item['nim']) || empty($item['nama']) || empty($item['prodi'] || empty($item['angkatan']))) {
        $errors[] = "Data pada baris ke-$index tidak lengkap.";
      }
    }

    if (!empty($errors)) {
      echo json_encode(['status' => 'error', 'message' => $errors]);
      return;
    }

    // Simpan data ke database
    $result = $this->TagihanModel->prosesInvoice($inputData);

    if ($result) {
      echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data.']);
    }
  }
}
