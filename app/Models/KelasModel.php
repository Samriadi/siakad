<?php

class KelasModel
{
  private $db;
  private $table = 'mhs_kelas';
  private $mhs_matakuliah = 'mhs_matakuliah';

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

  public function getAllMataKuliah()
  {
    try {
      $query = "SELECT course_id, course_code, course_name FROM {$this->mhs_matakuliah}";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      error_log("Error in getAllMataKuliah: " . $e->getMessage());
      return [];
    }
  }



  public function addData(array $data): bool
  {
    try {
      $query = "INSERT INTO {$this->table} (nama_kelas, mata_kuliah, tahun_kurikulum, kapasitas) VALUES (?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $req = $stmt->execute([
        $data['nama_kelas'],
        $data['mata_kuliah'],
        $data['tahun_kurikulum'],
        $data['kapasitas']
      ]);

      if ($req) {
        return true;
      }
    } catch (PDOException $e) {
      error_log("Add Data Error: " . $e->getMessage());
      return false;
    }
  }

  public function updateData(array $data): bool
  {
    try {
      $query = "UPDATE {$this->table} SET name = :name, capacity = :capacity, description = :description WHERE ID_ruangan = :ID_ruangan";
      $stmt = $this->db->prepare($query);
      return $stmt->execute([
        ':name' => $data['name'],
        ':capacity' => $data['capacity'],
        ':description' => $data['description'],
        ':ID_ruangan' => $data['ID_ruangan']
      ]);
    } catch (PDOException $e) {
      error_log("Update Data Error: " . $e->getMessage());
      return false;
    }
  }

  public function deleteData(int $ID_ruangan): bool
  {
    try {
      $query = "DELETE FROM {$this->table} WHERE ID_ruangan = :ID_ruangan";
      $stmt = $this->db->prepare($query);
      $stmt->execute([':ID_ruangan' => $ID_ruangan]);
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      error_log("Delete Data Error: " . $e->getMessage());
      return false;
    }
  }
}
