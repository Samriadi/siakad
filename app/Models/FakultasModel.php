<?php

class FakultasModel
{
  private $db;
  private $mhs_fakultas = 'mhs_fakultas';


  public function __construct()
  {
    global $mhs_fakultas;
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $query = "SELECT   * FROM $this->mhs_fakultas";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}
