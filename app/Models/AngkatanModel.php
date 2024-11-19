<?php

class AngkatanModel
{
  private $db;
  private $mhs_angkatan = 'mhs_angkatan';


  public function __construct()
  {
    global $mhs_angkatan;
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $query = "SELECT   * FROM $this->mhs_angkatan";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function addData($data)
  {
    try {
      $query = "INSERT INTO $this->mhs_angkatan (ID_angkatan, nama, deskripsi) VALUES (?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $data['ID_angkatan'],
        $data['nama'],
        $data['deskripsi']
      ]);
      return $result;
    } catch (PDOException $e) {
      error_log($e->getMessage());
      return false;
    }
  }

  public function updateData($data)
  {
    try {
      $query = "UPDATE $this->mhs_angkatan SET nama = :nama, deskripsi = :deskripsi WHERE ID_angkatan = :ID_angkatan";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':nama' => $data['nama'],
        ':deskripsi' => $data['deskripsi'],
        ':ID_angkatan' => $data['ID_angkatan']
      ]);

      return $result;
    } catch (PDOException $e) {
      error_log($e->getMessage());
      return false;
    }
  }

  public function deleteData($id)
  {
    try {
      $stmt = $this->db->prepare("DELETE FROM $this->mhs_angkatan WHERE ID_angkatan = :ID_angkatan");
      $stmt->execute([
        ':ID_angkatan' => $ID_angkatan
      ]);
      return $stmt->rowCount() > 0; 
    } catch (PDOException $e) {
      return false;
    }
  }
}
