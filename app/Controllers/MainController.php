<?php

class MainController{
    public function index(){
        include __DIR__ . '/../Views/others/page_dashboard.php';
    }
    public function selectDash()
    {
        include __DIR__ . '/../Views/others/page_selectDash.php';
    }

}