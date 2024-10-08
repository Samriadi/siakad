<?php

class MainController{
    public function index(){
        
        if (!isset($_SESSION['user_loged'])) {
            header("Location: /admin/login");
            exit();
        }
    
        // Jika sesi ada, tampilkan halaman dashboard
        include __DIR__ . '/../Views/others/page_dashboard.php';
    }
    
    public function selectDash()
    {
        include __DIR__ . '/../Views/others/page_selectDash.php';
    }

}