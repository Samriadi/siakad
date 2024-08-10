<?php

class PerkuliahanModel
{
  private $db;
  private $mhs_perkuliahan = 'mhs_perkuliahan';
  private $mhs_matakuliah = 'mhs_matakuliah';
  private $mhs_dosen = 'mhs_dosen';


  public function __construct()
  {
    global $mhs_perkuliahan;
    global $mhs_matakuliah;
    global $mhs_dosen;


    $this->mhs_perkuliahan = $mhs_perkuliahan;
    $this->mhs_matakuliah = $mhs_matakuliah;
    $this->mhs_dosen = $mhs_dosen;

    $this->db = Database::getInstance();
  }
  public function getAll()
  {
    $query = "SELECT 
                    a.*,
                    b.course_name,
                    c.name
                    FROM 
                    $this->mhs_perkuliahan a
                    LEFT JOIN $this->mhs_matakuliah b ON b.course_id = a.course_id
                    LEFT JOIN $this->mhs_dosen c ON c.lecturer_id = a.dosen_id

                    ";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function addData($data)
  {
    try {
      $query = "INSERT INTO $this->mhs_perkuliahan (course_id, dosen_id, day, start_time, end_time, room) 
                    VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $data['course_id'],
        $data['dosen_id'],
        $data['day'],
        $data['start_time'],
        $data['end_time'],
        $data['room']
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
