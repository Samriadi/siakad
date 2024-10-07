<?php

class SettingController
{

  private $SettingModel;

  public function __construct()
  {
    $this->SettingModel = new SettingModel();
  
  }
  public function index()
  {

    $AllTable = $this->SettingModel->getAll();

    include __DIR__ . '/../Views/others/page_setting.php';

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
          $request = $this->SettingModel->updateData($dataArray);

          $response = [
              'success' => $request,
              'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
          ];
      }

      header('Content-Type: application/json');
      echo json_encode($response);
  }
}
