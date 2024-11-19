<?php

class ProdiModel
{
  private $db;
  private $mhs_prodi = 'mhs_prodi';


  public function __construct()
  {
    global $mhs_prodi;
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $query = "SELECT   * FROM $this->mhs_prodi";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function addData($data)
  {
    try {
      $query = "INSERT INTO $this->mhs_prodi (ID, name, deskripsi) VALUES (?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $data['ID'],
        $data['name'],
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
      $query = "UPDATE $this->mhs_prodi SET name = :name, deskripsi = :deskripsi WHERE ID = :ID";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':name' => $data['name'],
        ':deskripsi' => $data['deskripsi'],
        ':ID' => $data['ID']
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
      $stmt = $this->db->prepare("DELETE FROM $this->mhs_paytype WHERE recid = :id");
      $stmt->execute([
        ':id' => $id
      ]);
      return $stmt->rowCount() > 0; 
    } catch (PDOException $e) {
      return false;
    }
  }
}
