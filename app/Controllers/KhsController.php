<?php

class KhsController
{
  public function __construct()
  {
    $this->checkLogin();
  }
  public function checkLogin() {
    if (!isset($_SESSION['user_loged'])) {
        header("Location: /admin/login");
        exit();
    }
  }
  public function khs()
  {
    include __DIR__ . '/../Views/others/page_khs.php';
  }

        
}
