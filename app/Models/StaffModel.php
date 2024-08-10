<?php

class StaffModel
{
  private $db;
  private $mhs_staff = 'mhs_staff';


  public function __construct()
  {
    global $mhs_staff;


    $this->mhs_staff = $mhs_staff;

    $this->db = Database::getInstance();
  }
  public function getAll()
  {
    $query = "SELECT 
                    *
                    FROM 
                    $this->mhs_staff";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function addData($data)
  {
    try {
      $query = "INSERT INTO $this->mhs_staff (IDStaff, Nama, Departemen, Posisi, Email) 
                    VALUES (?, ?, ?, ?, ?)";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        $data['IDStaff'],
        $data['Nama'],
        $data['Departemen'],
        $data['Posisi'],
        $data['Email']
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
      $query = "UPDATE $this->mhs_staff SET Nama = :Nama, Departemen = :Departemen, Posisi = :Posisi, Email = :Email WHERE IDStaff = :IDStaff";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':Nama' => $data['Nama'],
        ':Departemen' => $data['Departemen'],
        ':Posisi' => $data['Posisi'],
        ':Email' => $data['Email'],
        ':IDStaff' => $data['IDStaff']
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
      $stmt = $this->db->prepare("DELETE FROM $this->mhs_staff WHERE IDStaff = :id");
      $stmt->execute([
        ':id' => $id
      ]);
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      return false;
    }
  }
}
