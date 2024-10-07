<?php

class SettingModel
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }
  public function getAll(){
    $query = "SELECT * FROM mhs_setting";

    try {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $result;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return [];
    }
  }
  public function updateData($data)
  {

      try {
          $query = "UPDATE mhs_setting SET status = :status WHERE id = :id";
          $stmt = $this->db->prepare($query);

        
            $result = $stmt->execute([
                ':status' => $data['status'],
                ':id' => $data['id']
            ]);
        

          return $result;
      } catch (PDOException $e) {
          error_log($e->getMessage());
          return false;
      }
  }

}
