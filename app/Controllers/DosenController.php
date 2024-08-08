<?php

class DosenController
{

  private $DosenModel;
  private $dataDosen;

  public function __construct()
  {
    $this->DosenModel = new DosenModel();
    $this->dataDosen = $this->DosenModel->getAll();
  }
  public function index()
  {

    $data = $this->dataDosen;

    include __DIR__ . '/../Views/others/page_dosen.php';
  }
}
