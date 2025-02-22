<?php

class AngkatanModel
{
  private $db;
  private $table = 'mhs_angkatan';

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getAll($where = [])
  {
      $query = "SELECT * FROM {$this->table}";

      if (!empty($where)) {
          $conditions = [];
          foreach ($where as $column => $value) {
              $conditions[] = "$column = :$column";
          }
          $query .= " WHERE " . implode(" AND ", $conditions);
      }

      $stmt = $this->db->prepare($query);

      if (!empty($where)) {
          foreach ($where as $column => $value) {
              $stmt->bindValue(":$column", $value);
          }
      }

      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  public function addData(array $data): bool
  {
    try {
      $query = "INSERT INTO {$this->table} (ID_angkatan, nama, deskripsi) VALUES (?, ?, ?)";
      $stmt = $this->db->prepare($query);
      return $stmt->execute([
        $data['ID_angkatan'],
        $data['nama'],
        $data['deskripsi']
      ]);
    } catch (PDOException $e) {
      error_log("Add Data Error: " . $e->getMessage());
      return false;
    }
  }

  public function updateData(array $data): bool
  {
    try {
      $query = "UPDATE {$this->table} SET nama = :nama, deskripsi = :deskripsi WHERE ID_angkatan = :ID_angkatan";
      $stmt = $this->db->prepare($query);
      return $stmt->execute([
        ':nama' => $data['nama'],
        ':deskripsi' => $data['deskripsi'],
        ':ID_angkatan' => $data['ID_angkatan']
      ]);
    } catch (PDOException $e) {
      error_log("Update Data Error: " . $e->getMessage());
      return false;
    }
  }

  public function deleteData(int $ID_angkatan): bool
  {
    try {
      $query = "DELETE FROM {$this->table} WHERE ID_angkatan = :ID_angkatan";
      $stmt = $this->db->prepare($query);
      $stmt->execute([':ID_angkatan' => $ID_angkatan]);
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      error_log("Delete Data Error: " . $e->getMessage());
      return false;
    }
  }
}
