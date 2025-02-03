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
    $query = "SELECT * FROM $this->mhs_schedule";
    $stmt = $this->db->prepare($query);
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
}
