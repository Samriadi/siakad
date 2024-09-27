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
          // First, check if a record with the same student_id, semester, and academic_year exists
          $checkQuery = "SELECT krs_id FROM $this->mhs_krs WHERE student_id = ? AND semester = ? AND academic_year = ?";
          $checkStmt = $this->db->prepare($checkQuery);
          $checkStmt->execute([$student_id, $semester, $academic_year]);
          $existingKRSId = $checkStmt->fetchColumn();
  
          if ($existingKRSId) {
              // If a record exists, update it
              $updateQuery = "UPDATE $this->mhs_krs 
                              SET total_credits = ?, submission_date = ? 
                              WHERE krs_id = ?";
              $updateStmt = $this->db->prepare($updateQuery);
              $result = $updateStmt->execute([
                  $total_credits,
                  $submission_date,
                  $existingKRSId
              ]);
          } else {
              // If no record exists, insert a new record
              $insertQuery = "INSERT INTO $this->mhs_krs (student_id, semester, academic_year, total_credits, submission_date) 
                              VALUES (?, ?, ?, ?, ?)";
              $insertStmt = $this->db->prepare($insertQuery);
              $result = $insertStmt->execute([  
                  $student_id,
                  $semester,
                  $academic_year,
                  $total_credits,
                  $submission_date
              ]);
          }
  
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
                // Use the correct variable names
                $checkCourseExists = $this->checkCourseExists($student_id, $course_id);
                if ($checkCourseExists === false) {
                    $insertStmt->execute([$krs_id, $course_id]);
                }
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

private function checkCourseExists($student_id, $course_id) {
    $query = "SELECT COUNT(*) AS course_count 
              FROM $this->mhs_krs_courses mkc 
              JOIN $this->mhs_krs mk ON mkc.krs_id = mk.krs_id 
              WHERE mk.student_id = ? AND mkc.course_id = ?";
    
    $stmt = $this->db->prepare($query);
    $stmt->execute([$student_id, $course_id]);
    
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    
    return $result->course_count > 0;
}

private function getCourseCountByKrsId($krs_id) {
  $query = "SELECT COUNT(*) AS course_count 
            FROM $this->mhs_krs_courses 
            WHERE krs_id = ?";

  try {
      $stmt = $this->db->prepare($query);
      $stmt->execute([$krs_id]);
      
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      
      return (int)$result->course_count; // Return the count as an integer
  } catch (PDOException $e) {
      // Handle the error (log it, rethrow it, etc.)
      error_log("Database error: " . $e->getMessage());
      return 0; // Return 0 if there is an error
  }
}

private function getAllCourseIds() {
  $query = "SELECT course_id FROM $this->mhs_krs_courses";

  try {
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      
      // Fetch all Course IDs as an associative array
      $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
      
      return $result; // Return an array of Course IDs
  } catch (PDOException $e) {
      // Handle the error (log it, rethrow it, etc.)
      error_log("Database error: " . $e->getMessage());
      return []; // Return an empty array in case of an error
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
public function getApprovalStatusAndComments($student_id)
{
    try {
        // Prepare the SQL statement with a JOIN
        $query = "
            SELECT k.approval_status, a.comments 
            FROM mhs_krs AS k
            LEFT JOIN mhs_krs_approvals AS a ON k.krs_id = a.krs_id
            WHERE k.student_id = ?;
        ";
        $stmt = $this->db->prepare($query);

        // Execute the query
        $stmt->execute([$student_id]);

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $res = $result ? [
            'approval_status' => $result['approval_status'],
            'comments' => $result['comments'],
        ] : null;

    error_log(print_r($res, true));

        return $res;

    } catch (PDOException $e) {
        // Log error or handle it appropriately
        error_log("Error retrieving approval status and comments: " . $e->getMessage());
        return false; // Return false in case of error
    }
}


//persetujuan krs
public function getAllDataPersetujuan()
{
    $query = "SELECT 
                    m.NamaLengkap,
                    m.Nim,
                    k.krs_id,
                    k.semester,
                    k.approval_status
              FROM 
                    mhs_mahasiswa AS m
              JOIN 
                    mhs_krs AS k ON m.ID = k.student_id";
                    
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function getDetailProfilKrsPersetujuan($x){
  $query = "SELECT m.NamaLengkap, m.Nim, k.semester, k.approval_status FROM mhs_krs AS k JOIN mhs_mahasiswa AS m ON k.student_id = m.ID WHERE k.krs_id = ?";

  $stmt = $this->db->prepare($query);
  $stmt->execute([$x]);

  return $stmt->fetch(PDO::FETCH_ASSOC);

}

public function getDetailMatkulKrsPersetujuan($x){
  $query = "SELECT kc.course_id, mk.course_code, mk.course_name, mk.credits FROM mhs_krs_courses AS kc JOIN mhs_matakuliah AS MK ON kc.course_id = mk.course_id WHERE kc.krs_id = ?";

  $stmt = $this->db->prepare($query);
  $stmt->execute([$x]);

  return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function updateApprovalStatus($krs_id, $approval_status, $advisor_id)
{

    try {
        // Prepare the SQL statement
        $query = "UPDATE mhs_krs SET approval_status = ?, advisor_id = ? WHERE krs_id = ?";
        $stmt = $this->db->prepare($query);

        // Execute the query
        $req = $stmt->execute([$approval_status,$advisor_id, $krs_id]);

        return $req; // Return the result of the execution
    } catch (PDOException $e) {
        // Log error or handle it appropriately
        error_log("Error updating approval status: " . $e->getMessage());
        return false;
    }
}

public function addOrUpdateApprovalRecord($krs_id, $approval_date, $approval_status, $comments, $advisor_id)
{
    try {
        // Check if the record exists
        $checkQuery = "SELECT COUNT(*) FROM mhs_krs_approvals WHERE krs_id = ?";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->execute([$krs_id]);
        $exists = $checkStmt->fetchColumn() > 0;

        if ($exists) {
            // Update the existing record
            $updateQuery = "UPDATE mhs_krs_approvals 
                            SET approval_date = ?, approval_status = ?, comments = ?, advisor_id = ?
                            WHERE krs_id = ?";
            $updateStmt = $this->db->prepare($updateQuery);


            return $updateStmt->execute([$approval_date, $approval_status, $comments, $advisor_id, $krs_id]);
        } else {
            // Insert a new record
            $insertQuery = "INSERT INTO mhs_krs_approvals (krs_id, approval_date, approval_status, comments, advisor_id) 
                            VALUES (?, ?, ?, ?, ?)";
            $insertStmt = $this->db->prepare($insertQuery);
            
            return $insertStmt->execute([$krs_id, $approval_date, $approval_status, $comments, $advisor_id]);


        }
    } catch (PDOException $e) {
        // Log error or handle it appropriately
        error_log("Error adding/updating approval record: " . $e->getMessage());
        return false;
    }
}





}
