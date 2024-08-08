<?php

class DosenModel
{
  private $db;
  private $mhs_dosen = 'mhs_dosen';


  public function __construct()
  {
    global $mhs_dosen;


    $this->mhs_dosen = $mhs_dosen;

    $this->db = Database::getInstance();
  }
  public function getAll()
  {
    $query = "SELECT 
                    *
                    FROM 
                    $this->mhs_dosen";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}
