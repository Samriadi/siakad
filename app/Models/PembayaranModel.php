<?php

class PembayaranModel
{
  private $db;
  private $mhs_paytype = 'mhs_paytype';


  public function __construct()
  {
    global $mhs_paytype;
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $query = "SELECT * FROM $this->mhs_paytype";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function addData($data)
  {
    try {
      $query = "INSERT INTO $this->mhs_paytype (nama_tagihan, jenis_tagihan) VALUES (?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $data['nama_tagihan'],
        $data['jenis_tagihan']
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
      $query = "UPDATE $this->mhs_paytype SET nama_tagihan = :nama_tagihan, jenis_tagihan = :jenis_tagihan WHERE recid = :id";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':nama_tagihan' => $data['nama_tagihan'],
        ':jenis_tagihan' => $data['jenis_tagihan'],
        ':id' => $data['id']
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
