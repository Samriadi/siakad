<?php
session_start();

class KrsController
{

  private $KrsModel;
  private $matkul1;
  private $matkul2;
  public function __construct()
  {
    $this->KrsModel = new KrsModel();
    
    $this->matkul1 = $this->KrsModel->getMatakuliah(1);
    $this->matkul2 = $this->KrsModel->getMatakuliah(2);
    $this->matkul3 = $this->KrsModel->getMatakuliah(3);
    $this->matkul4 = $this->KrsModel->getMatakuliah(4);
    $this->matkul5 = $this->KrsModel->getMatakuliah(5);
    $this->matkul6 = $this->KrsModel->getMatakuliah(6);
    $this->matkul7 = $this->KrsModel->getMatakuliah(7);
    $this->matkul8 = $this->KrsModel->getMatakuliah(8);


    $this->student_id = $_SESSION['student_id'];
  }
  public function krs()
  {

    $dataMatkul1 = $this->matkul1;
    $dataMatkul2 = $this->matkul2;
    $dataMatkul3 = $this->matkul3;
    $dataMatkul4 = $this->matkul4;
    $dataMatkul5 = $this->matkul5;
    $dataMatkul6 = $this->matkul6;
    $dataMatkul7 = $this->matkul7;
    $dataMatkul8 = $this->matkul8;

    $DetailKRS = $this->KrsModel->getDetailKRS($this->student_id);

    include __DIR__ . '/../Views/others/page_krs.php';
  }

    public function addData()
  {
    // Mengambil input JSON
      $data = json_decode(file_get_contents('php://input'), true);

      // Validasi data
      $academic_year = $data[0]['academic_year'] ?? null;
      $semester = $data[0]['semester'] ?? null;
      $student_id = $data[0]['student_id'] ?? null;
      $total_credits = $data[0]['total_credits'] ?? null;
      $selected_course_ids = $data[0]['selected_course_ids'] ?? null;
      error_log(print_r($selected_course_ids, true));

      $submission_date = date('Y-m-d');

      if ($data === null) {
        $response = [
          'success' => false,
          'message' => 'Invalid JSON input'
        ];
      } else {
        $request = $this->KrsModel->addData($student_id, $semester, $academic_year, $total_credits, $submission_date);

        if($request === true){
          $this->KrsModel->addDataKrsCourses($student_id, $selected_course_ids);
        }

  
        $response = [
          'success' => $request,
          'message' => $request ? 'Data successfully added' : 'Add data failed',
          'data' => $data,
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

    $success = $this->KrsModel->deleteData($id);

    echo json_encode(['success' => $success]);
  }

  //persetujuan krs

  public function indexPersetujuan(){

    $dataKRS = $this->KrsModel->getAllDataPersetujuan();

    include __DIR__ . '/../Views/others/page_persetujuanKrs.php';

  }

  public function detailPersetujuan(){
    $krs_id = $_GET['krs_id'] ?? '';

    $detailProfil = $this->KrsModel->getDetailProfilKrsPersetujuan($krs_id);
    $detailMatkul = $this->KrsModel->getDetailMatkulKrsPersetujuan($krs_id);

    $response = array_merge($detailProfil, ['courses' => $detailMatkul]);
    // error_log(print_r($detailMatkul, true));

    header('Content-Type: application/json');
    echo json_encode($response);
  }

  // Assuming this is within your controller class
public function updatePersetujuan()
{
    // Make sure the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the data sent via AJAX
        $krs_id = $_POST['krs_id'];
        $approval_status = $_POST['approval_status'];
        $comment = $_POST['comment'] ?? ''; 

        // Validate the input data
        if (empty($krs_id) || empty($approval_status)) {
            echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
            return;
        }

        $result = $this->KrsModel->updateApprovalStatus($krs_id, $approval_status);

        // echo json_encode(['success' => true, 'krs id' => $approval_status]);

        header('Content-Type: application/json');

        if ($result) {


             $this->KrsModel->addApprovalRecord($krs_id, date('Y-m-d'), $approval_status, $comments, 30);

            echo json_encode(['success' => true, 'message' => 'Approval status updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the approval status.']);
        }
        exit;
    } else {
        // Handle invalid request methods
        header('Content-Type: application/json');

        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        exit;
    }
}

        
}
