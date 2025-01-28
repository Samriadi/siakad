<?php
class TagihanModel
{
  private $db;
  private $mhs_tagihan = 'mhs_tagihan';
  private $mhs_paytype = 'mhs_paytype';
  private $mhs_prodi = 'mhs_prodi';
  private $mhs_angkatan = 'mhs_angkatan';
  private $mhs_matakuliah = 'mhs_matakuliah';
  private $mhs_dosen = 'mhs_dosen';
  private $mhs_fakultas = 'mhs_fakultas';
  private $mhs_transaksi = 'mhs_transaksi';


  public function __construct()
  {
    global $mhs_tagihan;
    global $mhs_paytype;
    global $mhs_prodi;
    global $mhs_angkatan;
    global $mhs_matakuliah;
    global $mhs_dosen;
    global $mhs_fakultas;
    global $mhs_transaksi;

    $this->mhs_tagihan = $mhs_tagihan;
    $this->mhs_paytype = $mhs_paytype;
    $this->mhs_prodi = $mhs_prodi;
    $this->mhs_angkatan = $mhs_angkatan;
    $this->mhs_matakuliah = $mhs_matakuliah;
    $this->mhs_dosen = $mhs_dosen;
    $this->mhs_fakultas = $mhs_fakultas;
    $this->mhs_transaksi = $mhs_transaksi;

    $this->db = Database::getInstance();
  }

  public function getTagihanMhs()
  {
    $query = "SELECT vh.nim AS Nim, vh.NamaLengkap, vh.prodi AS prodi_name, vh.angkatan, vh.tagihan AS nominal, vh.periode, ifnull(tagihan_mhs,0) AS tagihan_mhs, fak_id FROM vw_hit_tagihan vh 
	INNER JOIN (SELECT pr.deskripsi AS prodi_name, fak.name AS fak_id, fak.deskripsi AS fak_name FROM mhs_prodi pr INNER JOIN mhs_fakultas fak ON fakultas = fak.ID) AS fak ON RTRIM(vh.prodi)=RTRIM(fak.prodi_name) 
    LEFT JOIN (SELECT nim, periode, SUM(tagihan) AS tagihan_mhs FROM mhs_transaksi GROUP BY nim, periode) AS tagih ON vh.nim=tagih.nim AND vh.periode=tagih.periode 
	WHERE vh.tagihan > ifnull(tagihan_mhs,0)";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getMyInvoice()
  {

    $nim = $_SESSION['user_loged'];

    $query = "SELECT mt.*, 
                     COALESCE(vh.tagihan, 0) AS nominal_pembayaran 
              FROM mhs_transaksi mt
              LEFT JOIN vw_hit_tagihan vh 
              ON mt.nim = vh.nim AND mt.periode = vh.periode
              WHERE mt.nim = :nim";

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':nim', $nim, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }



  public function getTransaksiMhs()
  {
    $query = "SELECT tr.nim, nama, prodi, angkatan, tagihan, tr.va_number, trans_id, pay_type, pay.nominal AS payment FROM $this->mhs_transaksi tr LEFT JOIN mhs_paymentva pay ON tr.va_number=pay.va_number";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getAll()
  {
    $query = "SELECT DISTINCT 
                  a.*,
                  b.nama_tagihan,
                  c.deskripsi AS nama_prodi,
                  e.name AS nama_fakultas,
                  CASE 
                      WHEN a.angkatan != 'Semua Angkatan' THEN d.nama
                      ELSE a.angkatan
                  END AS nama_angkatan
              FROM 
                  $this->mhs_tagihan a
              LEFT JOIN $this->mhs_paytype b ON b.recid = a.jenis_tagihan
              LEFT JOIN $this->mhs_prodi c ON c.ID = a.prodi 
              LEFT JOIN $this->mhs_angkatan d ON d.ID_angkatan = a.angkatan AND a.angkatan != 'Semua Angkatan'
              LEFT JOIN $this->mhs_fakultas e ON e.ID = a.fakultas;
              ";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  public function addData($data)
  {
    try {
      $checkQuery = "SELECT COUNT(*) FROM $this->mhs_tagihan WHERE fakultas = ? AND prodi = ? AND jenis_tagihan = ? AND angkatan = ? FOR UPDATE";
      $checkStmt = $this->db->prepare($checkQuery);
      $checkStmt->execute([
        $data['fakultas'],
        $data['prodi'],
        $data['jenis_tagihan'],
        $data['angkatan']
      ]);

      if ($checkStmt->fetchColumn() > 0) {
        return 'exists';
      } else {
        $query = "INSERT INTO $this->mhs_tagihan (fakultas, prodi, jenis_tagihan, angkatan, nominal, keterangan) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([
          $data['fakultas'],
          $data['prodi'],
          $data['jenis_tagihan'],
          $data['angkatan'],
          $data['nominal'],
          $data['keterangan']
        ]);
        return $result ? 'success' : 'error';
      }
    } catch (PDOException $e) {
      error_log($e->getMessage());
      return 'error';
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
    $query = "SELECT * FROM $this->mhs_angkatan";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function getSelectDataTagihan($id_fakultas)
  {
    $query = "SELECT * FROM $this->mhs_tagihan WHERE prodi_name = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$id_fakultas]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  public function prosesInvoice($data)
  {
    $response = [
      'status' => true,
      'messages' => [],
      'errors' => []
    ];

    try {
      require_once "../../../va/function.php";

      foreach ($data as $item) {
        try {
          if (isset($item['nim'], $item['nama'], $item['prodi'], $item['angkatan'])) {
            $nominal = isset($item['nominal']) && $item['nominal'] !== '' ? $item['nominal'] : 0;

            writeLog("DT -> " . $item['nim'] . ", " . $item['fakultas'] . "\r\n");

            $checkQuery = "SELECT trans_id, tagihan, pay.va_number 
                                   FROM $this->mhs_transaksi tr 
                                   LEFT JOIN mhs_paymentva pay ON tr.va_number = pay.va_number 
                                   WHERE tr.nim = ? AND tr.periode = ?";
            $stmtCheck = $this->db->prepare($checkQuery);
            $stmtCheck->execute([$item['nim'], $item['periode']]);
            $existingRecord = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingRecord and (!$existingRecord['va_number'])) {
              $newTagihan = $existingRecord['tagihan'] + $nominal;

              writeLog("Edit -> " . $item['nim'] . "\r\n");

              require_once "../../../va/bni/ecrvac.php";

              $payType = "c";
              $TransID = $existingRecord['trans_id'];
              $VA = CRVAC($item['nim'], $TransID, 30, $newTagihan, $payType, $item['nama'], $item['fakultas']);

              $updateQuery = "UPDATE $this->mhs_transaksi 
                                        SET tagihan = ? 
                                        WHERE nim = ? AND periode = ?";
              $stmtUpdate = $this->db->prepare($updateQuery);
              $stmtUpdate->execute([$newTagihan, $item['nim'], $item['periode']]);
            } else {
              require_once "../../../va/bni/crvac.php";

              writeLog("Add -> " . $item['nim'] . "\r\n");

              $payType = "c";
              $TransID = get_transid($item['nim'], "MHS");
              $VA = CRVAC($item['nim'], $TransID, 30, $nominal, $payType, $item['nama'], $item['fakultas']);

              $insertQuery = "INSERT INTO $this->mhs_transaksi 
                                        (nim, nama, prodi, angkatan, tagihan, periode, trans_id, va_number, pay_type) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
              $stmtInsert = $this->db->prepare($insertQuery);
              $req = $stmtInsert->execute([
                $item['nim'],
                $item['nama'],
                $item['prodi'],
                $item['angkatan'],
                $nominal,
                $item['periode'],
                $TransID,
                $VA,
                $payType
              ]);

              // Ambil ID record yang baru dimasukkan
              if ($req) {
                $lastInsertId = $this->db->lastInsertId();

                $updateQuery = "UPDATE mhs_adjustment SET trans_id = ? WHERE trans_id Is NUll AND nim = ?";
                $stmtUpdate = $this->db->prepare($updateQuery);
                $stmtUpdate->execute([$lastInsertId, $item['nim']]);
              } else {
                error_log("Gagal memasukkan data.");
                return false;
              }
            }

            sleep(1);
          } else {
            throw new Exception("Invalid data: Missing required fields for nim " . $item['nim']);
          }
        } catch (Exception $e) {
          $response['status'] = false;
          $response['errors'][] = [
            'nim' => $item['nim'] ?? null,
            'error' => $e->getMessage()
          ];
        }
      }
    } catch (PDOException $e) {
      $response['status'] = false;
      $response['messages'][] = "Database Error: " . $e->getMessage();
    }

    return json_encode($response);
  }

  public function searchTagihan($nim)
  {
    $query = "SELECT a.*, b.deskripsi AS nama_fakultas, c.deskripsi AS nama_prodi, d.nama_tagihan, e.nama AS tahun_angkatan FROM mhs_adjustment a LEFT JOIN mhs_fakultas b ON b.ID = a.fakultas LEFT JOIN mhs_prodi c ON c.ID = a.prodi LEFT JOIN mhs_paytype d ON d.recid = a.jenis_tagihan LEFT JOIN mhs_angkatan e ON e.ID_angkatan = a.angkatan WHERE nim = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$nim]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function savePembayaranTagihan($data)
  {
    try {


      foreach ($data as $item) {

        error_log(print_r($item['selectedCheckboxValues'], true));

        $nim = $item['nim'];
        $nominalPembayaran = $item['nominal_pembayaran'];
        $tanggalTransaksi = $item['tgl_transaksi'];
        $periode = $item['selectedCheckboxValues'][0]['periode'];
        $referensi = $item['referensi'];

        $insertHeaderQuery = "INSERT INTO mhs_pembayaran_header (nim, tgl_transaksi, jumlah_pembayaran, periode, ID_referensi) VALUES (?, ?, ?, ?, ?)";
        $headerStmt = $this->db->prepare($insertHeaderQuery);
        $headerInserted = $headerStmt->execute([$nim, $tanggalTransaksi, $nominalPembayaran, $periode, $referensi]);

        if (!$headerInserted) {
          continue;
        }

        $getHeaderIdQuery = "SELECT id FROM mhs_pembayaran_header WHERE nim = ? AND tgl_transaksi = ? AND jumlah_pembayaran = ? AND periode = ? AND ID_referensi = ?";
        $headerIdStmt = $this->db->prepare($getHeaderIdQuery);
        $headerIdStmt->execute([$nim, $tanggalTransaksi, $nominalPembayaran, $periode, $referensi]);
        $headerIdResult = $headerIdStmt->fetch(PDO::FETCH_ASSOC);

        if (empty($headerIdResult['id'])) {
          continue;
        }

        $idPembayaranHeader = $headerIdResult['id'];

        $insertDetailQuery = "INSERT INTO mhs_pembayaran_detail (id_pembayaran_header, id_jenis_transaksi) VALUES (?, ?)";
        $detailStmt = $this->db->prepare($insertDetailQuery);

        foreach ($item['selectedCheckboxValues'] as $key) {
          $detailStmt->execute([$idPembayaranHeader, $key['id']]);
        }
      }

      return 'success';
    } catch (Exception $e) {
      error_log($e->getMessage());
      return 'error';
    }
  }
}
