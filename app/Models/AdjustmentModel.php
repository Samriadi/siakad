<?php

class AdjustmentModel
{
  private $db;
  private $mhs_paytype = 'mhs_paytype';
  private $mhs_prodi = 'mhs_prodi';
  private $mhs_angkatan = 'mhs_angkatan';
  private $mhs_adjustment = 'mhs_adjustment';
  private $mhs_tagihan = 'mhs_tagihan';
  private $mhs_matakuliah = 'mhs_matakuliah';
  private $mhs_dosen = 'mhs_dosen';
  private $mhs_fakultas = 'mhs_fakultas';
  private $mhs_mahasiswa = 'mhs_mahasiswa';

  public function __construct()
  {
    global $mhs_adjustment;
    global $mhs_paytype;
    global $mhs_prodi;
    global $mhs_angkatan;
    global $mhs_matakuliah;
    global $mhs_dosen;
    global $mhs_tagihan;
    global $mhs_fakultas;
    global $mhs_mahasiswa;

    $this->mhs_adjustment = $mhs_adjustment;
    $this->mhs_paytype = $mhs_paytype;
    $this->mhs_prodi = $mhs_prodi;
    $this->mhs_angkatan = $mhs_angkatan;
    $this->mhs_matakuliah = $mhs_matakuliah;
    $this->mhs_dosen = $mhs_dosen;
    $this->mhs_tagihan = $mhs_tagihan;
    $this->mhs_fakultas = $mhs_fakultas;
    $this->mhs_mahasiswa = $mhs_mahasiswa;

    $this->db = Database::getInstance();
  }

  public function getAllAdjustment($conditions = [])
  {

    $query = "SELECT 
                a.*,
                e.nama_tagihan,
                c.deskripsi AS nama_prodi,
                CASE 
                    WHEN a.angkatan != 'Semua Angkatan' THEN d.nama
                    ELSE a.angkatan
                END AS nama_angkatan,
                f.name AS nama_fakultas
            FROM 
                $this->mhs_adjustment a
            LEFT JOIN $this->mhs_tagihan b ON b.recid = a.jenis_tagihan
            LEFT JOIN $this->mhs_paytype e ON e.recid = a.jenis_tagihan
            LEFT JOIN $this->mhs_prodi c ON c.ID = a.prodi 
            LEFT JOIN $this->mhs_angkatan d ON d.ID_angkatan = a.angkatan AND a.angkatan != 'Semua Angkatan'
            LEFT JOIN $this->mhs_fakultas f ON f.ID = a.fakultas";

    if (!empty($conditions)) {
      $whereClauses = [];

      foreach ($conditions as $key => $value) {
        $formattedValue = is_numeric($value) ? $value : "'$value'";
        $whereClauses[] = "$key = $formattedValue";
      }
      $query .= " WHERE " . implode(' AND ', $whereClauses);
    }

    $stmt = $this->db->prepare($query);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getTagihanMhs()
  {
    $query = "SELECT Nim,NamaLengkap,prodi_name,vw_mhs.angkatan,sum(nominal) AS nominal FROM vw_mhs INNER JOIN vw_tagihan ON vw_mhs.kode_prodi=vw_tagihan.prodi 
	  AND vw_mhs.angkatan=vw_tagihan.angkatan WHERE status='Aktif' GROUP BY Nim,NamaLengkap,prodi_name,vw_mhs.angkatan";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getOptionFilter()
  {
    $query = "SELECT DISTINCT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'mhs_adjustment' AND column_name IN ('fakultas', 'prodi', 'angkatan')";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getNominal($fakultas, $prodi, $angkatan, $paytype)
  {

    $query = "SELECT nominal 
              FROM mhs_tagihan 
              WHERE fakultas = :fakultas AND prodi = :prodi AND jenis_tagihan = :jenis_tagihan AND angkatan = :angkatan";

    $stmt = $this->db->prepare($query);

    $stmt->bindParam(':fakultas', $fakultas, PDO::PARAM_STR);
    $stmt->bindParam(':prodi', $prodi, PDO::PARAM_STR);
    $stmt->bindParam(':jenis_tagihan', $paytype, PDO::PARAM_STR);
    $stmt->bindParam(':angkatan', $angkatan, PDO::PARAM_STR);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_OBJ);

    // error_log(json_encode($result));

    return $result ? $result->nominal : null;
  }

  public function getFieldValuesFakultas($field)
  {
    $query = "SELECT DISTINCT b.ID, b.name, b.deskripsi FROM mhs_adjustment a LEFT JOIN mhs_fakultas b ON b.ID = a.$field";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    // error_log(json_encode($results));

    return $results;
  }

  public function getFieldValuesProdi($field)
  {
    $query = "SELECT DISTINCT a.ID, a.name, a.deskripsi FROM mhs_prodi a INNER JOIN mhs_adjustment b ON b.prodi = a.ID WHERE a.fakultas = $field";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    // error_log(json_encode($results));

    return $results;
  }

  public function getFieldValuesAngkatan($field)
  {
    $query = "SELECT DISTINCT a.ID_angkatan AS ID, a.nama AS deskripsi FROM mhs_angkatan a LEFT JOIN mhs_adjustment b ON b.angkatan = a.ID_angkatan WHERE b.fakultas=$field";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    // error_log(json_encode($results));

    return $results;
  }

  public function getAll()
  {
    $query = "SELECT 
                    a.*,
                    b.nama_tagihan,
                    ifnull(c.deskripsi,'') AS nama_prodi,
                    CASE 
                        WHEN a.angkatan != 'Semua Angkatan' THEN d.nama 
                        ELSE a.angkatan 
                    END AS nama_angkatan
                FROM 
                    $this->mhs_adjustment a
                LEFT JOIN $this->mhs_paytype b ON b.recid = a.jenis_tagihan
                LEFT JOIN $this->mhs_prodi c ON c.ID = ifnull(a.prodi,0) 
                LEFT JOIN $this->mhs_angkatan d ON d.ID_angkatan = a.angkatan AND a.angkatan != 'Semua Angkatan'

                  ";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  public function addData($data)
  {
    try {
      $checkQuery = "SELECT COUNT(*) FROM $this->mhs_adjustment 
                         WHERE fakultas =? AND prodi = ? AND jenis_tagihan = ? AND angkatan = ?";
      $checkStmt = $this->db->prepare($checkQuery);
      $checkStmt->execute([
        $data['fakultas'],
        $data['prodi'],
        $data['jenis_tagihan'],
        $data['angkatan']
      ]);

      /*
      if ($checkStmt->fetchColumn() == 0) {
        return 'exists';
      }
	  */

      $ID = $data['nim'];
      $adjType = $data['adj_type'];
      if (!$adjType) $adjType = "normal";

      if ($ID <> "") {
        $Nim = explode(",", $ID);
        $n = count($Nim);

        for ($I = 0; $I < $n; $I++) {
          $query = "INSERT INTO $this->mhs_adjustment (fakultas, prodi, jenis_tagihan, angkatan, nominal, keterangan, nim, adj_type, adjustment, qty) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = $this->db->prepare($query);
          $result = $stmt->execute([
            $data['fakultas'],
            $data['prodi'],
            $data['jenis_tagihan'],
            $data['angkatan'],
            $data['nominal'],
            $data['keterangan'],
            $Nim[$I],
            $adjType,
            $data['adjust'],
            $data['qty'],

          ]);
        }

        $query = "UPDATE $this->mhs_adjustment AS tagihan JOIN mhs_mahasiswa AS mhs ON tagihan.nim=mhs.nim SET prodi = kode_prodi WHERE prodi is null AND tagihan.nim is not null";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $query = "UPDATE $this->mhs_adjustment AS tagihan JOIN (SELECT nim, ID_angkatan AS angkatan FROM mhs_mahasiswa JOIN mhs_angkatan ON RTRIM(angkatan)=RTRIM(nama)) AS mhs 
			ON tagihan.nim = mhs.nim SET tagihan.angkatan = mhs.angkatan WHERE tagihan.angkatan is null AND tagihan.nim is not null";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
      } else {
        $query = "INSERT INTO $this->mhs_adjustment (nim, fakultas, prodi, jenis_tagihan, angkatan, nominal, keterangan, adj_type, adjustment, qty) 
		SELECT NIM, ?, kode_prodi, ?, id_angkatan, ?, ?, ?, ? FROM vw_mhs WHERE NIM<>'' ";

        if ($data['prodi'] <> '11111')
          $query .= "AND kode_prodi=? ";
        else
          $query .= "AND kode_prodi<>? ";

        if ($data['angkatan'] <> "Semua Angkatan")
          $query .= "AND id_angkatan=? ";
        else
          $query .= "AND id_angkatan<>? ";

        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([
          $data['fakultas'],
          $data['jenis_tagihan'],
          $data['nominal'],
          $data['qty'],
          $data['keterangan'],
          $data['adj_type'],
          $data['adjust'],
          $data['prodi'],
          $data['angkatan']
        ]);
      }

      return $result ? 'success' : 'error';
    } catch (PDOException $e) {
      error_log($e->getMessage());
      return 'error';
    }
  }



  public function updateData($data)
  {

    // error_log("data: " . print_r($data, true));

    try {
      $query = "UPDATE $this->mhs_adjustment SET prodi = :prodi, jenis_tagihan = :jenis_tagihan, angkatan = :angkatan, nominal = :nominal , qty = :qty, keterangan = :keterangan, nim = :nim, adjustment = :adjustment WHERE recid = :recid";
      $stmt = $this->db->prepare($query);
      $result = $stmt->execute([
        ':prodi' => $data['prodi'],
        ':jenis_tagihan' => $data['jenis_tagihan'],
        ':angkatan' => $data['angkatan'],
        ':nominal' => $data['nominal'],
        ':qty' => $data['qty'],
        ':keterangan' => $data['keterangan'],
        ':nim' => $data['nim'],
        ':adjustment' => $data['adjustment'],
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
      $stmt = $this->db->prepare("DELETE FROM $this->mhs_adjustment WHERE recid = :id");
      $stmt->execute([
        ':id' => $id
      ]);
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      return false;
    }
  }

  public function dropData(array $ids)
  {
    try {
      // Menggunakan placeholder untuk setiap ID dalam array
      $placeholders = implode(',', array_fill(0, count($ids), '?'));
      $query = "DELETE FROM $this->mhs_adjustment WHERE recid IN ($placeholders)";

      // Mempersiapkan query
      $stmt = $this->db->prepare($query);

      // Mengeksekusi query dengan parameter array $ids
      $stmt->execute($ids);

      // Mengembalikan jumlah baris yang terpengaruh
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      // Menangani error jika terjadi
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

  public function getDataProdi($column = null, $value = null)
  {
    $query = "SELECT * FROM $this->mhs_prodi";

    if ($column && $value) {
      $query .= " WHERE $column = :value";
    }

    $stmt = $this->db->prepare($query);

    if ($column && $value) {
      $stmt->bindParam(':value', $value);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  public function getDataAngkatan()
  {
    $query = "SELECT DISTINCT a.ID_angkatan, a.nama, a.deskripsi
                FROM $this->mhs_angkatan a 
                LEFT JOIN $this->mhs_mahasiswa b ON b.angkatan = a.nama 
                WHERE b.status = 'AKTIF';";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}
