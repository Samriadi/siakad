<?php

class MahasiswaModel
{
    private $db;
    private $mhs_mahasiswa = 'mhs_mahasiswa';
    private $pmb_mahasiswa = 'pmb_mahasiswa';
    private $mhs_ortu = 'mhs_ortu';
    private $pmb_ortu = 'pmb_ortu';
    private $pmb_nim = 'pmb_nim';

    public function __construct()
    {
        global $mhs_mahasiswa;
        global $pmb_mahasiswa;
        global $mhs_ortu;
        global $pmb_ortu;
        global $pmb_nim;

        $this->mhs_mahasiswa = $mhs_mahasiswa;
        $this->pmb_mahasiswa = $pmb_mahasiswa;
        $this->mhs_ortu = $mhs_ortu;
        $this->pmb_ortu = $pmb_ortu;
        $this->pmb_nim = $pmb_nim;

        $this->db = Database::getInstance();
    }
    public function getAll()
    {
        $query = "SELECT 
                    *
                    FROM 
                    $this->mhs_mahasiswa";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



    public function checkData()
    {
        $query = "SELECT p.ID
                    FROM $this->pmb_mahasiswa p
                    WHERE NOT EXISTS (
                        SELECT 1
                        FROM $this->mhs_mahasiswa m
                        WHERE p.ID = m.ID
                    )
                    ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function saveMahasiswa($NamaLengkap, $Nim, $WANumber, $alamat)
    {
        // Validate input values
        if (empty($Nim) || empty($NamaLengkap) || empty($WANumber) || empty($alamat)) {
            error_log("Validation failed: One or more required fields are empty.");
            return false;
        }

        // Prepare SQL statement
        $insertDataMahasiswa = "INSERT INTO $this->mhs_mahasiswa (
            Nim, NamaLengkap, WANumber, alamat
        ) VALUES (
            :Nim, :NamaLengkap, :WANumber, :alamat
        )";

        $stmtInsert = $this->db->prepare($insertDataMahasiswa);

        try {
            // Execute statement with parameter binding
            $stmtInsert->execute([
                ':Nim' => $Nim,
                ':NamaLengkap' => $NamaLengkap,
                ':WANumber' => $WANumber,
                ':alamat' => $alamat
            ]);
            return true;
        } catch (PDOException $e) {
            // Log detailed error message
            error_log("Error inserting mahasiswa: " . $e->getMessage());
            return false;
        }
    }


    public function importData()
    {
        $selectMahasiswaIncludeNim = "SELECT a.*, b.nim FROM $this->pmb_mahasiswa a INNER JOIN $this->pmb_nim b ON b.member_id = a.ID";
        $stmt = $this->db->prepare($selectMahasiswaIncludeNim);
        $stmt->execute();
        $dataMahasiswaList = $stmt->fetchAll(PDO::FETCH_OBJ);

        $insertDataMahasiswa = "INSERT INTO $this->mhs_mahasiswa (
            ID, Nim, NamaLengkap, Agama, NamaAsalSekolah, AsalKampus,
            TahunLulus, AsalProvinsi, NIS, UserName, UserPass, Email,
            WANumber, SumberReferensi, berkas, jenkel, tempat_lahir,
            tgl_lahir, kewarganegaraan, status, alamat, photo, ipk,
            tanggal_daftar, verifikasi, nik, id_lama, rtrw, kelurahan,
            kecamatan, kabupaten, propinsi, negara
        ) VALUES (
            :ID, :Nim, :NamaLengkap, :Agama, :NamaAsalSekolah, :AsalKampus,
            :TahunLulus, :AsalProvinsi, :NIS, :UserName, :UserPass, :Email,
            :WANumber, :SumberReferensi, :berkas, :jenkel, :tempat_lahir,
            :tgl_lahir, :kewarganegaraan, :status, :alamat, :photo, :ipk,
            :tanggal_daftar, :verifikasi, :nik, :id_lama, :rtrw, :kelurahan,
            :kecamatan, :kabupaten, :propinsi, :negara
        )";

        $stmtInsert = $this->db->prepare($insertDataMahasiswa);

        try {
            foreach ($dataMahasiswaList as $dataMahasiswa) {
                $stmtInsert->execute([
                    ':ID' => $dataMahasiswa->ID,
                    ':Nim' => $dataMahasiswa->nim,
                    ':NamaLengkap' => $dataMahasiswa->NamaLengkap,
                    ':Agama' => $dataMahasiswa->Agama,
                    ':NamaAsalSekolah' => $dataMahasiswa->NamaAsalSekolah,
                    ':AsalKampus' => $dataMahasiswa->AsalKampus,
                    ':TahunLulus' => $dataMahasiswa->TahunLulus,
                    ':AsalProvinsi' => $dataMahasiswa->AsalProvinsi,
                    ':NIS' => $dataMahasiswa->NIS,
                    ':UserName' => $dataMahasiswa->UserName,
                    ':UserPass' => $dataMahasiswa->UserPass,
                    ':Email' => $dataMahasiswa->Email,
                    ':WANumber' => $dataMahasiswa->WANumber,
                    ':SumberReferensi' => $dataMahasiswa->SumberReferensi,
                    ':berkas' => $dataMahasiswa->berkas,
                    ':jenkel' => $dataMahasiswa->jenkel,
                    ':tempat_lahir' => $dataMahasiswa->tempat_lahir,
                    ':tgl_lahir' => $dataMahasiswa->tgl_lahir,
                    ':kewarganegaraan' => $dataMahasiswa->kewarganegaraan,
                    ':status' => $dataMahasiswa->status,
                    ':alamat' => $dataMahasiswa->alamat,
                    ':photo' => $dataMahasiswa->photo,
                    ':ipk' => $dataMahasiswa->ipk,
                    ':tanggal_daftar' => $dataMahasiswa->tanggal_daftar,
                    ':verifikasi' => $dataMahasiswa->verifikasi,
                    ':nik' => $dataMahasiswa->nik,
                    ':id_lama' => $dataMahasiswa->id_lama,
                    ':rtrw' => $dataMahasiswa->rtrw,
                    ':kelurahan' => $dataMahasiswa->kelurahan,
                    ':kecamatan' => $dataMahasiswa->kecamatan,
                    ':kabupaten' => $dataMahasiswa->kabupaten,
                    ':propinsi' => $dataMahasiswa->propinsi,
                    ':negara' => $dataMahasiswa->negara
                ]);
            }
            return true;
        } catch (PDOException $e) {

            error_log($e->getMessage());
            return false;
        }
    }

    public function getOrtu()
    {
        $query = "SELECT a.*, b.ID, b.NamaLengkap FROM $this->mhs_ortu a LEFT JOIN $this->mhs_mahasiswa b ON b.ID = a.maba_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

   

    public function importDataOrtu()
    {
        $selectOrtuFromPmbOrtu = "SELECT * FROM $this->pmb_ortu";
        $stmt = $this->db->prepare($selectOrtuFromPmbOrtu);
        $stmt->execute();
        $dataOrtu = $stmt->fetchAll(PDO::FETCH_OBJ);

        $insertDataOrtu = "INSERT INTO $this->mhs_ortu (maba_id, nama_ayah, t4lahir_ayah, tglahir_ayah, pend_ayah, agama_ayah, phone_ayah, job_ayah, salary_ayah, alamat_ayah, nik_ayah,
                                nama_ibu, t4lahir_ibu, tglahir_ibu, pend_ibu, agama_ibu, phone_ibu, job_ibu, salary_ibu, alamat_ibu, nik_ibu, id_lama
                            ) VALUES (:maba_id, :nama_ayah, :t4lahir_ayah, :tglahir_ayah, :pend_ayah, :agama_ayah, :phone_ayah, :job_ayah, :salary_ayah, :alamat_ayah, :nik_ayah,
                                :nama_ibu, :t4lahir_ibu, :tglahir_ibu, :pend_ibu, :agama_ibu, :phone_ibu, :job_ibu, :salary_ibu, :alamat_ibu, :nik_ibu, :id_lama
                            )";

        $stmtInsert = $this->db->prepare($insertDataOrtu);

        try {
            foreach ($dataOrtu as $data) {
                $stmtInsert->execute([
                    ':maba_id' => $data->maba_id,
                    ':nama_ayah' => $data->nama_ayah,
                    ':t4lahir_ayah' => $data->t4lahir_ayah,
                    ':tglahir_ayah' => $data->tglahir_ayah,
                    ':pend_ayah' => $data->pend_ayah,
                    ':agama_ayah' => $data->agama_ayah,
                    ':phone_ayah' => $data->phone_ayah,
                    ':job_ayah' => $data->job_ayah,
                    ':salary_ayah' => $data->salary_ayah,
                    ':alamat_ayah' => $data->alamat_ayah,
                    ':nik_ayah' => $data->nik_ayah,
                    ':nama_ibu' => $data->nama_ibu,
                    ':t4lahir_ibu' => $data->t4lahir_ibu,
                    ':tglahir_ibu' => $data->tglahir_ibu,
                    ':pend_ibu' => $data->pend_ibu,
                    ':agama_ibu' => $data->agama_ibu,
                    ':phone_ibu' => $data->phone_ibu,
                    ':job_ibu' => $data->job_ibu,
                    ':salary_ibu' => $data->salary_ibu,
                    ':alamat_ibu' => $data->alamat_ibu,
                    ':nik_ibu' => $data->nik_ibu,
                    ':id_lama' => $data->id_lama,
                ]);
            }
            return true;
        } catch (PDOException $e) {

            error_log($e->getMessage());
            return false;
        }
    }

    public function updateData($data)
    {
        try {
            $query = "UPDATE $this->mhs_mahasiswa SET alamat = :alamat WHERE ID = :id";
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([
                ':alamat' => $data['alamat'],
                ':id' => $data['id']
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateDataOrtu($data)
    {
        try {
            $query = "UPDATE $this->mhs_ortu SET nama_ayah = :nama_ayah, nama_ibu = :nama_ibu WHERE recid = :recid";
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([
                ':nama_ayah' => $data['namaAyah'],
                ':nama_ibu' => $data['namaIbu'],
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
            $stmt = $this->db->prepare("DELETE FROM $this->mhs_mahasiswa WHERE ID = :id");
            $stmt->execute([
                ':id' => $id
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteDataOrtu($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM $this->mhs_ortu WHERE maba_id = :id");
            $stmt->execute([
                ':id' => $id
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getDataRegistUsingNik($x) {
        $query = "SELECT nik FROM pmb_mahasiswa WHERE nik = :nik";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':nik' => $x]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("check result: " . print_r($result, true));

        return $result;

    }

    public function addDataRegistUsingNik($x) {
        $query = "INSERT INTO pmb_mahasiswa (nik) VALUES (:nik)";
        
        $stmt = $this->db->prepare($query);
        
        $result = $stmt->execute([':nik' => $x]);
    
        error_log("Insert result: " . ($result ? "Success" : "Failed"));
    
        return $result;
    }
    
          
    
   
}
