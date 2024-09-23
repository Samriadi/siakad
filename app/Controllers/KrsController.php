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
}
