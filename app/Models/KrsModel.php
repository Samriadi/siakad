<?php

class KrsModel
{
  private $db;
  private $mhs_matakuliah = 'mhs_matakuliah';
  private $mhs_krs = 'mhs_krs';
  private $mhs_krs_courses = 'mhs_krs_courses';


  public function __construct()
  {
    global $mhs_matakuliah;
    global $mhs_krs;
    global $mhs_krs_courses;

    $this->mhs_matakuliah = $mhs_matakuliah;
    $this->mhs_krs = $mhs_krs;
    $this->mhs_krs_courses = $mhs_krs_courses;

    $this->db = Database::getInstance();
  }
  public function getMatakuliah($x)
  {
    $query = "SELECT 
                    *
                    FROM 
                    $this->mhs_matakuliah WHERE semester = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$x]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function addData($student_id, $semester, $academic_year, $total_credits, $submission_date)
  {
    try {
      $query = "INSERT INTO $this->mhs_krs (student_id, semester, academic_year, total_credits, submission_date) 
                    VALUES (?, ?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $student_id,
        $semester,
        $academic_year,
        $total_credits,
        $submission_date
      ]);

      return $result;
    } catch (PDOException $e) {
      error_log($e->getMessage());
      return false;
    }
  }

  public function addDataKrsCourses($student_id, $selected_course_ids) {
    try {
        // Retrieve the KRS ID for the given student ID
        $query = "SELECT krs_id FROM $this->mhs_krs WHERE student_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$student_id]);
        $krs = $stmt->fetch(PDO::FETCH_OBJ);

        // Check if KRS ID exists
        if ($krs) {
            $krs_id = $krs->krs_id;

            // Prepare the insert statement
            $insertQuery = "INSERT INTO $this->mhs_krs_courses (krs_id, course_id) VALUES (?, ?)";
            $insertStmt = $this->db->prepare($insertQuery);

            // Loop through selected course IDs and insert into mhs_krs_courses
            foreach ($selected_course_ids as $course_id) {
                $insertStmt->execute([$krs_id, $course_id]);
            }

            return true; // Return true if successful
        } else {
            return false; // Return false if KRS ID does not exist
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display a message, etc.)
        error_log("Database error: " . $e->getMessage());
        return false; // Optionally return false on error
    }
}

public function getDetailKRS($x){
    $query = "SELECT mkc.krs_course_id, mkc.course_id, mk.krs_id, mk.student_id, mk.semester AS krs_semester, mk.academic_year, mk.total_credits, mk.submission_date, mk.approval_status, mk.advisor_id, mm.course_code, mm.course_name, mm.credits, mm.semester AS course_semester FROM $this->mhs_krs_courses mkc JOIN $this->mhs_krs mk ON mkc.krs_id = mk.krs_id JOIN $this->mhs_matakuliah mm ON mkc.course_id = mm.course_id WHERE mk.student_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$x]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function deleteData($id)
{
  try {
    $stmt = $this->db->prepare("DELETE FROM $this->mhs_krs_courses WHERE krs_course_id = :id");
    $stmt->execute([
      ':id' => $id
    ]);
    return $stmt->rowCount() > 0;
  } catch (PDOException $e) {
    return false;
  }
}


}
