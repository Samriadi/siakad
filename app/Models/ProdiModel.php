<?php

class ProdiModel
{
  private $db;
  private $mhs_prodi = 'mhs_prodi';
  private $mhs_fakultas = 'mhs_fakultas';


  public function __construct()
  {
    global $mhs_prodi;
    global $mhs_fakultas;
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $query = "SELECT a.*, b.deskripsi AS nama_fakultas FROM $this->mhs_prodi a LEFT JOIN $this->mhs_fakultas b ON b.ID = a.fakultas";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // public function addData($data)
  // {
  //   try {
  //     $query = "INSERT INTO $this->mhs_paytype (nama_tagihan, jenis_tagihan) VALUES (?, ?)";
  //     $stmt = $this->db->prepare($query);
  //     $result = $stmt->execute([
  //       $data['nama_tagihan'],
  //       $data['jenis_tagihan']
  //     ]);
  //     return $result;
  //   } catch (PDOException $e) {
  //     error_log($e->getMessage());
  //     return false;
  //   }
  // }

  public function updateData($data)
  {
    try {
      $query = "UPDATE $this->mhs_prodi SET name = :name, deskripsi = :deskripsi, fakultas = :fakultas WHERE ID = :ID";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':name' => $data['name'],
        ':deskripsi' => $data['deskripsi'],
        ':fakultas' => $data['fakultas'],
        ':ID' => $data['ID']
      ]);

      return $result;
    } catch (PDOException $e) {
      error_log($e->getMessage());
      return false;
    }
  }

  // public function deleteData($id)
  // {
  //   try {
  //     $stmt = $this->db->prepare("DELETE FROM $this->mhs_paytype WHERE recid = :id");
  //     $stmt->execute([
  //       ':id' => $id
  //     ]);
  //     return $stmt->rowCount() > 0;
  //   } catch (PDOException $e) {
  //     return false;
  //   }
  // }
}
