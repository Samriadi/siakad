<?php

class TagihanModel
{
  private $db;
  private $mhs_tagihan = 'mhs_tagihan';
  private $mhs_paytype = 'mhs_paytype';


  public function __construct()
  {
    global $mhs_tagihan;
    global $mhs_paytype;

    $this->mhs_tagihan = $mhs_tagihan;
    $this->mhs_paytype = $mhs_paytype;

    $this->db = Database::getInstance();
  }
  public function getAll()
  {
      $query = "SELECT 
                      a.*,
                      b.nama_tagihan
                  FROM 
                      $this->mhs_tagihan a
                  LEFT JOIN $this->mhs_paytype b ON b.recid = a.jenis_tagihan";
      
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  

  public function addData($data)
  {
    try {
      $query = "INSERT INTO $this->mhs_tagihan (prodi, jenis_tagihan, angkatan, nominal, keterangan) 
                    VALUES (?, ?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $data['prodi'],
        $data['jenis_tagihan'],
        $data['angkatan'],
        $data['nominal'],
        $data['keterangan']
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
      $query = "UPDATE $this->mhs_perkuliahan SET course_id = :course_id, dosen_id = :dosen_id, day = :day, start_time = :start_time , end_time = :end_time, room = :room WHERE schedule_id = :schedule_id";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':course_id' => $data['course_id'],
        ':dosen_id' => $data['dosen_id'],
        ':day' => $data['day'],
        ':start_time' => $data['start_time'],
        ':end_time' => $data['end_time'],
        ':room' => $data['room'],
        ':schedule_id' => $data['schedule_id']
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
      $stmt = $this->db->prepare("DELETE FROM $this->mhs_perkuliahan WHERE schedule_id = :id");
      $stmt->execute([
        ':id' => $id
      ]);
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      return false;
    }
  }

  public function getDataMatkul()
  {
    $query = "SELECT course_id, course_name FROM $this->mhs_matakuliah";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getDataDosen()
  {
    $query = "SELECT lecturer_id, name FROM $this->mhs_dosen";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}