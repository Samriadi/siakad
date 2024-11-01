<?php

class TagihanController
{

  private $TagihanModel;
  private $dataPaytype;

  public function __construct()
  {
    $this->checkLogin();

    $this->TagihanModel = new TagihanModel();
    $this->dataTagihan = $this->TagihanModel->getAll();
  }
  public function checkLogin() {
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

//   public function fetchData()
//   {
//     $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

//     $dataMatkul = $this->PerkuliahanModel->getDataMatkul();
//     $dataDosen = $this->PerkuliahanModel->getDataDosen();


//     $selectedData = null;
//     $selectedDataMatkul = null;
//     $selectedDataDosen = null;

//     foreach ($this->dataPerkuliahan as $item) {
//       if ($item->schedule_id == $id) {
//         $selectedData = $item;

//         foreach ($dataMatkul as $matkul) {
//           if ($matkul->course_id == $item->course_id) {
//             $selectedDataMatkul = $matkul;
//           }
//         }

//         foreach ($dataDosen as $dosen) {
//           if ($dosen->lecturer_id == $item->dosen_id) {
//             $selectedDataDosen = $dosen;
//           }
//         }

//         break;
//       }
//     }

//     header('Content-Type: application/json');
//     echo json_encode([
//       'success' => $selectedData !== null,
//       'data' => $selectedData,
//       'dataMatkul' => $selectedDataMatkul,
//       'dataDosen' => $selectedDataDosen,
//       'optionMatkul' => $dataMatkul,
//       'optionDosen' => $dataDosen
//     ]);
//   }

//   public function addData()
//   {
//     $dataArray = json_decode(file_get_contents('php://input'), true);

//     if ($dataArray === null) {
//       $response = [
//         'success' => false,
//         'message' => 'Invalid JSON input'
//       ];
//     } else {
//       $request = $this->PerkuliahanModel->addData($dataArray[0]);

//       $response = [
//         'success' => $request,
//         'message' => $request ? 'Data successfully added' : 'Add data failed',
//         'data' => $dataArray[0],
//       ];
//     }

//     header('Content-Type: application/json');
//     echo json_encode($response);
//   }


//   public function updateData()
//   {
//     $dataArray = json_decode(file_get_contents('php://input'), true);

//     if ($dataArray === null) {
//       $response = [
//         'success' => false,
//         'message' => 'Invalid JSON input'
//       ];
//     } else {
//       $request = $this->PerkuliahanModel->updateData($dataArray[0]);

//       $response = [
//         'success' => $request,
//         'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
//       ];
//     }

//     header('Content-Type: application/json');
//     echo json_encode($response);
//   }

//   public function deleteData()
//   {
//     header('Content-Type: application/json');

//     if (!isset($_POST['id']) || empty($_POST['id'])) {
//       echo json_encode(['success' => false, 'message' => 'Invalid ID']);
//       return;
//     }

//     $id = intval($_POST['id']);

//     $success = $this->PerkuliahanModel->deleteData($id);

//     echo json_encode(['success' => $success]);
//   }

//   public function includeData()
//   {
//     $dataMatkul = $this->PerkuliahanModel->getDataMatkul();
//     $dataDosen = $this->PerkuliahanModel->getDataDosen();

//     if (!empty($dataMatkul) && !empty($dataDosen)) {
//       $response = [
//         'success' => true,
//         'data' => [
//           'DataMatkul' => $dataMatkul,
//           'DataDosen' => $dataDosen
//         ]
//       ];
//     } else {
//       $response = [
//         'success' => false,
//         'message' => 'Data tidak ditemukan'
//       ];
//     }

//     // Mengembalikan response dalam format JSON
//     header('Content-Type: application/json');
//     echo json_encode($response);
//   }


}
