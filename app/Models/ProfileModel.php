<?php

class ProfileModel
{
  private $db;
  private $table = 'usrapp';

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getProfile($where = [])
  {
    $query = "SELECT * FROM {$this->table}";

    if (!empty($where)) {
      $conditions = [];
      foreach ($where as $column => $value) {
        $conditions[] = "$column = :$column";
      }
      $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $this->db->prepare($query);

    if (!empty($where)) {
      foreach ($where as $column => $value) {
        $stmt->bindValue(":$column", $value);
      }
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  private function getPassword($data)
  {
    $x = base64_encode($data);

    return crypt($x, $this->encKey());
  }

  private function encKey()
  {
    return '$2y$10$' . bin2hex(random_bytes(11));
  }

  public function changesData(array $data): bool
  {
    try {
      $query = "UPDATE {$this->table} SET userpass = :userpass WHERE userid = :userid";
      $stmt = $this->db->prepare($query);
      return $stmt->execute([
        ':userpass' => $this->getPassword($data['userpass']),
        ':userid' => $data['userid']
      ]);
    } catch (PDOException $e) {
      error_log("Update Data Error: " . $e->getMessage());
      return false;
    }
  }
}
