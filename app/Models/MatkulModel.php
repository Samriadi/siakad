<?php

class MatkulModel
{
  private $db;
  private $mhs_matakuliah = 'mhs_matakuliah';


  public function __construct()
  {
    global $mhs_matakuliah;


    $this->mhs_matakuliah = $mhs_matakuliah;

    $this->db = Database::getInstance();
  }
  public function getAll()
  {
    $query = "SELECT 
                    *
                    FROM 
                    $this->mhs_matakuliah";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  public function addData($data)
  {
    try {
      $query = "INSERT INTO $this->mhs_matakuliah (course_code, course_name, credits, semester) 
                    VALUES (?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $data['course_code'],
        $data['course_name'],
        $data['credits'],
        $data['semester']
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
      $query = "UPDATE $this->mhs_matakuliah SET course_code = :course_code, course_name = :course_name, credits = :credits, semester = :semester WHERE course_id = :course_id";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':course_code' => $data['course_code'],
        ':course_name' => $data['course_name'],
        ':credits' => $data['credits'],
        ':semester' => $data['semester'],
        ':course_id' => $data['course_id']
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
      $stmt = $this->db->prepare("DELETE FROM $this->mhs_matakuliah WHERE course_id = :id");
      $stmt->execute([
        ':id' => $id
      ]);
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      return false;
    }
  }
}
