<?php

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

    include __DIR__ . '/../Views/others/page_krs.php';
  }

    public function addData()
  {
    // Mengambil input JSON
      $data = json_decode(file_get_contents('php://input'), true);
      error_log(print_r($data, true));

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
        
}
