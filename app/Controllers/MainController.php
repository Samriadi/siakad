<?php

class MainController
{

    private $MahasiswaModel;

    public function __construct()
    {
        $this->checkLogin();
        $this->MahasiswaModel = new MahasiswaModel();
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

        if (!isset($_SESSION['user_loged'])) {
            header("Location: /admin/login");
            exit();
        }

        $prodi = $this->MahasiswaModel->countBy("deskripsi", "prodi");
        $mhsAktif = $this->MahasiswaModel->countBy("deskripsi", "prodi", "Aktif");
        $userAccess = $this->MahasiswaModel->getAccess($_SESSION['user_loged']);

        // Jika sesi ada, tampilkan halaman dashboard
        include __DIR__ . '/../Views/others/page_dashboard.php';
    }

    public function selectDash()
    {
        include __DIR__ . '/../Views/others/page_selectDash.php';
    }
}
