<?php

class ScheduleController
{

  private $ScheduleModel;
  private $ScheduleData;

  public function __construct()
  {
    $this->checkLogin();
    $this->ScheduleModel = new ScheduleModel();
    $this->ScheduleData = $this->ScheduleModel->getAll();
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

    $ScheduleData = $this->ScheduleData;
    include __DIR__ . '/../Views/others/page_schedule.php';
  }

  public function prepareData()
  {
    $dataMataKuliah = $this->ScheduleModel->getAllMataKuliah();
    $dataDosen = $this->ScheduleModel->getAllDosen();
    $dataRuangan = $this->ScheduleModel->getAllRuangan();
    if (!empty($dataMataKuliah && $dataDosen && $dataRuangan)) {
      echo json_encode([
        'success' => true,
        'dataMataKuliah' => $dataMataKuliah,
        'dataDosen' => $dataDosen,
        'dataRuangan' => $dataRuangan
      ]);
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'Data kelas tidak ditemukan.'
      ]);
    }
  }
}
