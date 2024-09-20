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
  }
  public function krs()
  {

    $dataMatkul1 = $this->matkul1;
    $dataMatkul2 = $this->matkul2;

    include __DIR__ . '/../Views/others/page_krs.php';
  }
}
