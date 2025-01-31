<?php

class ProfileController
{

  private $ProfileModel;
  private $dataProfile;

  public function __construct()
  {
    $this->checkLogin();

    $this->ProfileModel = new ProfileModel();
    $this->dataProfile = $this->ProfileModel->getProfile(['username' => $_SESSION['user_loged']]);
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

    if ($_SESSION['user_type'] == 'mahasiswa') {
      $data = $this->ProfileModel->getProfileMhs(['UserName' => $_SESSION['user_loged']]);
    } else {
      $data = $this->dataProfile;
    }

    include __DIR__ . '/../Views/others/page_profile.php';
  }

  public function changesData()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);

    if ($dataArray === null) {
      $response = [
        'success' => false,
        'message' => 'Invalid JSON input'
      ];
    } else {
      $request = $this->ProfileModel->changesData($dataArray[0]);

      $response = [
        'success' => $request,
        'message' => $request ? 'Data berhasil diupdate' : 'Update failed',
      ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }
}
