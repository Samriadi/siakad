<?php

class TagihanModel
{
  private $db;
  private $mhs_tagihan = 'mhs_tagihan';
  private $mhs_paytype = 'mhs_paytype';
  private $mhs_prodi = 'mhs_prodi';


  public function __construct()
  {
    global $mhs_tagihan;
    global $mhs_paytype;
    global $mhs_prodi;

    $this->mhs_tagihan = $mhs_tagihan;
    $this->mhs_paytype = $mhs_paytype;
    $this->mhs_prodi = $mhs_prodi;

    $this->db = Database::getInstance();
  }
  public function getAll()
  {
      $query = "SELECT 
                      a.*,
                      b.nama_tagihan,
                      c.deskripsi AS nama_prodi
                  FROM 
                      $this->mhs_tagihan a
                  LEFT JOIN $this->mhs_paytype b ON b.recid = a.jenis_tagihan
                  LEFT JOIN $this->mhs_prodi c ON c.ID = a.prodi 
                  ";
      
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
      $query = "UPDATE $this->mhs_tagihan SET prodi = :prodi, jenis_tagihan = :jenis_tagihan, angkatan = :angkatan, nominal = :nominal , keterangan = :keterangan WHERE recid = :recid";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':prodi' => $data['prodi'],
        ':jenis_tagihan' => $data['jenis_tagihan'],
        ':angkatan' => $data['angkatan'],
        ':nominal' => $data['nominal'],
        ':keterangan' => $data['keterangan'],
        ':recid' => $data['recid']
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
      $stmt = $this->db->prepare("DELETE FROM $this->mhs_tagihan WHERE recid = :id");
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

  public function getDataProdi()
  {
      $query = "SELECT * FROM $this->mhs_prodi";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}
