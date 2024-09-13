<?php

class DosenModel
{
  private $db;
  private $mhs_dosen = 'mhs_dosen';


  public function __construct()
  {
    global $mhs_dosen;


    $this->mhs_dosen = $mhs_dosen;

    $this->db = Database::getInstance();
  }
  public function getAll()
  {
    $query = "SELECT 
                    *
                    FROM 
                    $this->mhs_dosen";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  public function addData($data)
  {
    try {
      $query = "INSERT INTO $this->mhs_dosen (nidn, name, birth_date, gender, address, phone, email, hire_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $data['nidn'],
        $data['name'],
        $data['birth_date'],
        $data['gender'],
        $data['address'],
        $data['phone'],
        $data['email'],
        $data['hire_date']
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
      $query = "UPDATE $this->mhs_dosen SET nidn = :nidn, name = :name, birth_date = :birth_date, gender = :gender, address = :address, phone = :phone, email = :email, hire_date = :hire_date WHERE lecturer_id = :id";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':nidn' => $data['nidn'],
        ':name' => $data['name'],
        ':birth_date' => $data['birth_date'],
        ':gender' => $data['gender'],
        ':address' => $data['address'],
        ':phone' => $data['phone'],
        ':email' => $data['email'],
        ':hire_date' => $data['hire_date'],
        ':id' => $data['id']
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
      $stmt = $this->db->prepare("DELETE FROM $this->mhs_dosen WHERE lecturer_id = :id");
      $stmt->execute([
        ':id' => $id
      ]);
      return $stmt->rowCount() > 0; // Return true if a row was deleted
    } catch (PDOException $e) {
      // Handle error (e.g., log error, rethrow exception, etc.)
      return false;
    }
  }
}
