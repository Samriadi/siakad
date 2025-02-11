<?php

class ScheduleModel
{
  private $db;
  private $mhs_schedule = 'mhs_schedule';
  private $mhs_matakuliah = 'mhs_matakuliah';
  private $mhs_dosen = 'mhs_dosen';
  private $mhs_ruangan = 'mhs_ruangan';

  public function __construct()
  {
    global $mhs_schedule;
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $query = "SELECT a.*, b.course_name AS nama_matkul, c.Nama AS nama_dosen, d.name AS nama_ruangan
    FROM $this->mhs_schedule a
    LEFT JOIN $this->mhs_matakuliah b ON b.course_id = a.mata_kuliah
    LEFT JOIN $this->mhs_dosen c ON c.recid = a.dosen
    LEFT JOIN $this->mhs_ruangan d ON d.ID_ruangan = a.ruangan
    ";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getAllMataKuliah()
  {
    try {
      $query = "SELECT course_id, course_code, course_name, credits FROM {$this->mhs_matakuliah}";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      error_log("Error in getAllMataKuliah: " . $e->getMessage());
      return [];
    }
  }

  public function getAllDosen()
  {
    try {
      $query = "SELECT recid, Nama FROM {$this->mhs_dosen}";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      error_log("Error in getAllMataKuliah: " . $e->getMessage());
      return [];
    }
  }

  public function getAllRuangan()
  {
    try {
      $query = "SELECT ID_ruangan, name FROM {$this->mhs_ruangan}";
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
      $query = "INSERT INTO {$this->mhs_schedule} (ruangan, mata_kuliah, jumlah_sks,hari,jam_mulai,jam_selesai,dosen) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $req = $stmt->execute([
        $data['ruangan'],
        $data['matkul'],
        $data['sks'],
        $data['hari'],
        $data['jam_mulai'],
        $data['jam_selesai'],
        $data['dosen']
      ]);

      if ($req) {
        return true;
      }
    } catch (PDOException $e) {
      error_log("Add Data Error: " . $e->getMessage());
      return false;
    }
  }
}
