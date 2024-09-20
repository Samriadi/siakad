<?php

class KrsModel
{
  private $db;
  private $mhs_matakuliah = 'mhs_matakuliah';


  public function __construct()
  {
    global $mhs_matakuliah;

    $this->mhs_matakuliah = $mhs_matakuliah;

    $this->db = Database::getInstance();
  }
  public function getMatakuliah($x)
  {
    $query = "SELECT 
                    *
                    FROM 
                    $this->mhs_matakuliah WHERE semester = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$x]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}
