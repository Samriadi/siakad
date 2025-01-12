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


  public function getTotalNominal($selectedPaytype, $fakultas, $prodi, $angkatan)
  {
    $total_nominal = 0;
    $all_data = [];
    foreach ($selectedPaytype as $jenis_tagihan) {
      $query = "SELECT jenis_tagihan, nominal FROM mhs_tagihan WHERE jenis_tagihan = :jenis_tagihan AND angkatan = :angkatan AND prodi = :prodi AND fakultas = :fakultas";

      $stmt = $this->db->prepare($query);

      $stmt->bindParam(':jenis_tagihan', $jenis_tagihan, PDO::PARAM_INT);
      $stmt->bindParam(':angkatan', $angkatan, PDO::PARAM_STR);
      $stmt->bindParam(':prodi', $prodi, PDO::PARAM_STR);
      $stmt->bindParam(':fakultas', $fakultas, PDO::PARAM_STR);
      $stmt->execute();

      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($data) {
        $total_nominal += $data['nominal'];
        $all_data[] = $data;
      } else {
        error_log("No data found for jenis_tagihan $jenis_tagihan");
      }
    }


    return ['total_nominal' => $total_nominal, 'data' => $all_data];
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
    $query = "SELECT DISTINCT a.ID, a.name, a.deskripsi FROM mhs_prodi a INNER JOIN mhs_adjustment b ON b.prodi = a.ID WHERE b.fakultas = $field";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    // error_log(json_encode($results));

    return $results;
  }

  public function getFieldValuesAngkatan($field)
  {
    $query = "SELECT DISTINCT a.ID_angkatan AS ID, a.nama AS deskripsi FROM mhs_angkatan a INNER JOIN mhs_adjustment b ON b.angkatan = a.ID_angkatan WHERE b.fakultas=$field";

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

      $ID = $data['nim'];
      $adjType = $data['adj_type'];
      if (!$adjType) $adjType = "normal";

      if ($ID <> "") {
        $Nim = explode(",", $ID);
        $n = count($Nim);

        for ($I = 0; $I < $n; $I++) {
          $checkQuery = "SELECT COUNT(*) FROM $this->mhs_adjustment 
                   WHERE nim = ? AND jenis_tagihan = ?";
          $checkStmt = $this->db->prepare($checkQuery);
          $checkStmt->execute([
            $Nim[$I],
            $data['jenis_tagihan']
          ]);

          if ($checkStmt->fetchColumn() == 0) {
            $angkatanQuery = "SELECT id_angkatan FROM $this->mhs_angkatan 
                          WHERE nama = (SELECT angkatan FROM $this->mhs_mahasiswa WHERE nim = ?)";
            $angkatanStmt = $this->db->prepare($angkatanQuery);
            $angkatanStmt->execute([$Nim[$I]]);
            $idAngkatan = $angkatanStmt->fetchColumn();

            if ($idAngkatan) {
              $query = "INSERT INTO $this->mhs_adjustment 
                      (fakultas, prodi, jenis_tagihan, angkatan, nominal, keterangan, nim, adj_type, adjustment, qty, periode, from_date, to_date) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
              $stmt = $this->db->prepare($query);
              $newNominal = $data['nominal'] * $data['qty'];

              $result = $stmt->execute([
                $data['fakultas'],
                $data['prodi'],
                $data['jenis_tagihan'],
                $idAngkatan,
                $newNominal,
                $data['keterangan'],
                $Nim[$I],
                $adjType,
                $data['adjust'],
                $data['qty'],
                $data['periode_pembayaran'],
                $data['awal_pembayaran'],
                $data['akhir_pembayaran']
              ]);

              if (!$result) {
                error_log("Failed to insert data for NIM: $Nim[$I]");
              }
            } else {
              error_log("id_angkatan not found for NIM: $Nim[$I]");
            }
          } else {
            if ($n == 1) {
              return 'exists';
            }
          }
        }


        $query = "UPDATE $this->mhs_adjustment AS tagihan JOIN mhs_mahasiswa AS mhs ON tagihan.nim=mhs.nim SET prodi = kode_prodi WHERE prodi is null AND tagihan.nim is not null";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $query = "UPDATE $this->mhs_adjustment AS tagihan JOIN (SELECT nim, ID_angkatan AS angkatan FROM mhs_mahasiswa JOIN mhs_angkatan ON RTRIM(angkatan)=RTRIM(nama)) AS mhs ON tagihan.nim = mhs.nim SET tagihan.angkatan = mhs.angkatan WHERE tagihan.angkatan is null AND tagihan.nim is not null";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
      } else {
        $query = "INSERT INTO $this->mhs_adjustment (nim, fakultas, prodi, jenis_tagihan, angkatan, nominal, keterangan, adj_type, adjustment, qty, periode, from_date, to_date)
        SELECT NIM, ?, kode_prodi, ?, id_angkatan, ?, ?, ?, ?, ?, ?, ?, ?
        FROM vw_mhs 
        WHERE NIM <> '' 
        AND NOT EXISTS (
            SELECT 1 
            FROM $this->mhs_adjustment 
            WHERE $this->mhs_adjustment.nim = vw_mhs.NIM
            AND $this->mhs_adjustment.jenis_tagihan = ?
            AND $this->mhs_adjustment.periode = ?
        )";

        if ($data['prodi'] <> '11111') {
          $query .= " AND kode_prodi = ? ";
        } else {
          $query .= " AND kode_prodi <> ? ";
        }

        if ($data['angkatan'] <> "Semua Angkatan") {
          $query .= " AND id_angkatan = ? ";
        } else {
          $query .= " AND id_angkatan <> ? ";
        }

        $newNominal = $data['nominal'] * $data['qty'];

        $params = [
          $data['fakultas'],
          $data['jenis_tagihan'],
          $newNominal,
          $data['keterangan'],
          $data['adj_type'],
          $data['adjust'],
          $data['qty'],
          $data['periode_pembayaran'],
          $data['awal_pembayaran'],
          $data['akhir_pembayaran'],
          $data['jenis_tagihan'],
          $data['periode_pembayaran'],
          $data['prodi'],
          $data['angkatan'],
        ];

        $stmt = $this->db->prepare($query);
        $result = $stmt->execute($params);
      }

      return $result ? 'success' : 'error';
    } catch (PDOException $e) {
      error_log($e->getMessage());
      return 'error';
    }
  }

  public function addDataMultiTagihan($data)
  {
    try {
      if (!is_array($data)) {
        throw new Exception("Expected an array, but received: " . gettype($data));
      }

      foreach ($data as $item) {
        if (!is_array($item)) {
          throw new Exception("Each item should be an array, but received: " . gettype($item));
        }

        $fakultas = $item['fakultas'];
        $prodi = $item['prodi'];
        $angkatan = $item['angkatan'];
        $keterangan = $item['keterangan'];
        $nim = $item['nim'];
        $periode = $item['periode_pembayaran'];
        $awal_pembayaran = $item['awal_pembayaran'];
        $akhir_pembayaran = $item['akhir_pembayaran'];
        $adjust = $item['adjust'];
        $qty = 1;
        $adjType = "normal";


        if ($nim == null) {
          $query = "INSERT INTO $this->mhs_adjustment (nim, fakultas, prodi, jenis_tagihan, angkatan, nominal, keterangan, periode, from_date, to_date, adjustment, adj_type, qty) 
          SELECT DISTINCT NIM, ?, kode_prodi, ?, id_angkatan, ?, ?, ?, ?, ?, ?, ?, ?
          FROM vw_mhs 
          WHERE NIM <> ''
          AND NOT EXISTS (
              SELECT 1 
              FROM $this->mhs_adjustment 
              WHERE $this->mhs_adjustment.nim = vw_mhs.NIM
              AND $this->mhs_adjustment.jenis_tagihan = ?
              AND $this->mhs_adjustment.periode = ?
          )";

          if ($item['prodi'] <> '11111') {
            $query .= " AND kode_prodi = ? ";
          } else {
            $query .= " AND kode_prodi <> ? ";
          }

          if ($item['angkatan'] <> "Semua Angkatan") {
            $query .= " AND id_angkatan = ? ";
          } else {
            $query .= " AND id_angkatan <> ? ";
          }

          foreach ($item['tagihan'] as $tagihan) {
            if (!is_array($tagihan)) {
              throw new Exception("Each tagihan should be an array, but received: " . gettype($tagihan));
            }
            $jenis_tagihan = $tagihan['jenis_tagihan'];
            $nominal = $tagihan['nominal'];

            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([
              $fakultas,
              $jenis_tagihan,
              $nominal,
              $keterangan,
              $periode,
              $awal_pembayaran,
              $akhir_pembayaran,
              $adjust,
              $adjType,
              $qty,
              $jenis_tagihan,
              $periode,
              $prodi,
              $angkatan
            ]);

            if (!$result) {
              return 'error';
            }
          }
        } else {
          $query = "INSERT INTO $this->mhs_adjustment 
          (fakultas, prodi, jenis_tagihan, angkatan, nominal, keterangan, nim, periode, from_date, to_date, adjustment, adj_type, qty) 
          VALUES (?, ?, ?, 
          (SELECT id_angkatan FROM $this->mhs_angkatan WHERE nama = (SELECT angkatan FROM $this->mhs_mahasiswa WHERE nim = ?)), 
          ?, ?, ?, ?, ?, ?, ?, ?, ?)";

          foreach ($item['tagihan'] as $tagihan) {
            if (!is_array($tagihan) || !isset($tagihan['jenis_tagihan'], $tagihan['nominal'])) {
              throw new Exception("Each tagihan should be an array with 'jenis_tagihan' and 'nominal'.");
            }

            $jenis_tagihan = $tagihan['jenis_tagihan'];
            $nominal = $tagihan['nominal'];

            $stmt = $this->db->prepare($query);

            $ArrNIM = explode(",", $nim);
            $n = count($ArrNIM);

            for ($I = 0; $I < $n; $I++) {
              $currentNim = trim($ArrNIM[$I]);

              if (empty($currentNim)) {
                throw new Exception("NIM cannot be empty. Found an empty value in the list.");
              }

              $checkQuery = "SELECT COUNT(*) FROM $this->mhs_adjustment WHERE nim = ? AND jenis_tagihan = ?";
              $checkStmt = $this->db->prepare($checkQuery);
              $checkStmt->execute([$currentNim, $jenis_tagihan]);

              if ($checkStmt->fetchColumn() == 0) {
                $result = $stmt->execute([
                  $fakultas,
                  $prodi,
                  $jenis_tagihan,
                  $currentNim,
                  $nominal,
                  $keterangan,
                  $currentNim,
                  $periode,
                  $awal_pembayaran,
                  $akhir_pembayaran,
                  $adjust,
                  $adjType,
                  $qty
                ]);

                if (!$result) {
                  throw new Exception("Failed to insert adjustment data for NIM: $currentNim, jenis_tagihan: $jenis_tagihan");
                }
              } else {
                if ($n == 1) {
                  return 'exists';
                }
              }
            }
          }
        }
      }

      return 'success';
    } catch (Exception $e) {
      error_log($e->getMessage());
      return 'error';
    }
  }




  public function updateData($data)
  {

    // error_log("data: " . print_r($data, true));

    try {
      $query = "UPDATE $this->mhs_adjustment SET prodi = :prodi, jenis_tagihan = :jenis_tagihan, angkatan = :angkatan, nominal = :nominal , qty = :qty, keterangan = :keterangan, nim = :nim, adjustment = :adjustment, periode = :periode, from_date = :from_date, to_date = :to_date WHERE recid = :recid";
      $stmt = $this->db->prepare($query);
      $newNominal = $data['satuan_nominal'] * $data['qty'];
      $result = $stmt->execute([
        ':prodi' => $data['prodi'],
        ':jenis_tagihan' => $data['jenis_tagihan'],
        ':angkatan' => $data['angkatan'],
        ':nominal' => $newNominal,
        ':qty' => $data['qty'],
        ':keterangan' => $data['keterangan'],
        ':nim' => $data['nim'],
        ':adjustment' => $data['adjustment'],
        ':periode' => $data['periode_pembayaran'],
        ':from_date' => $data['awal_pembayaran'],
        ':to_date' => $data['akhir_pembayaran'],
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
    try {
      $query = "SELECT course_id, course_name FROM $this->mhs_matakuliah";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      error_log("Error in getDataMatkul: " . $e->getMessage());
      return []; // Kembalikan array kosong jika terjadi error
    }
  }


  public function getDataDosen()
  {
    try {
      $query = "SELECT lecturer_id, name FROM $this->mhs_dosen";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      error_log("Error in getDataDosen: " . $e->getMessage());
      return [];
    }
  }


  public function getDataProdi($column = null, $value = null)
  {
    try {
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
    } catch (PDOException $e) {
      error_log("Error in getDataProdi: " . $e->getMessage());
      return []; // Kembalikan array kosong jika terjadi error
    }
  }



  public function getDataAngkatan()
  {
    try {
      $query = "SELECT DISTINCT a.ID_angkatan, a.nama, a.deskripsi
                  FROM $this->mhs_angkatan a 
                  LEFT JOIN $this->mhs_mahasiswa b ON b.angkatan = a.nama 
                  WHERE b.status = 'AKTIF';";

      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      error_log("Error in getDataAngkatan: " . $e->getMessage());
      return [];
    }
  }


  public function getPaytypeMultiTagihan($fakultas, $prodi, $angkatan)
  {
    try {
      $query = "SELECT a.*, b.nama_tagihan 
                  FROM mhs_tagihan a 
                  LEFT JOIN mhs_paytype b ON b.recid = a.jenis_tagihan 
                  WHERE fakultas = :fakultas AND prodi = :prodi AND angkatan = :angkatan";

      $stmt = $this->db->prepare($query);

      $stmt->bindParam(':fakultas', $fakultas, PDO::PARAM_STR);
      $stmt->bindParam(':prodi', $prodi, PDO::PARAM_STR);
      $stmt->bindParam(':angkatan', $angkatan, PDO::PARAM_STR);

      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_OBJ);

      return $result;
    } catch (PDOException $e) {
      error_log("Error in getPaytypeMultiTagihan: " . $e->getMessage());
      return [];
    }
  }


  public function cekNim($nim)
  {
    try {
      $query = "SELECT nim FROM $this->mhs_mahasiswa WHERE nim = :nim";
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      error_log("Database error: " . $e->getMessage());
      return null;
    }
  }
}
