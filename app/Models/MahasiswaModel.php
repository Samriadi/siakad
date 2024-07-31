<?php

class MahasiswaModel{
    private $db;

    public function __construct()
    {
      
        $this->db = Database::getInstance();
    }
    public function getAll()
    {
        $query = "SELECT 
                    *
                    FROM 
                    mhs_mahasiswa";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function importData() {
        $selectMahasiswaIncludeNim = "SELECT a.*, b.nim FROM pmb_mahasiswa a INNER JOIN pmb_nim b ON b.member_id = a.ID";
        $stmt = $this->db->prepare($selectMahasiswaIncludeNim);
        $stmt->execute();
        $dataMahasiswaList = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Convert data to JSON
        $jsonData = json_encode($dataMahasiswaList);

        // Output JSON data
        echo $jsonData;
    
        $insertDataMahasiswa = "INSERT INTO mhs_mahasiswa (
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
    
    
    
}