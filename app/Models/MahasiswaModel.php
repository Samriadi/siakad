<?php

class MahasiswaModel{
    private $db;

    public function __construct()
    {
      
        $this->db = Database::getInstance();
    }
    public function getAll()
    {
        $query = "SELECT 
                    *
                    FROM 
                    mhs_mahasiswa";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}