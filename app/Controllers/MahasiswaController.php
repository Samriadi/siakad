<?php

class MahasiswaController{

    private $MahasiswaModel;

    public function __construct()
    {
        $this->MahasiswaModel = new MahasiswaModel();
    }
    public function index(){

        $data = $this->MahasiswaModel->getAll();

        include __DIR__ . '/../Views/others/page_mahasiswa.php';
    }
}