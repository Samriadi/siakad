<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran D3</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
        }
        .header, .footer {
            background-color: #800020;
            color: white;
            padding: 20px;
            font-size: 24px;
            text-align: center;
        }
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border: 1px solid #800020;
            border-radius: 10px;
            max-width: 600px;
            width: 100%;
            text-align: left;
        }
        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .input-group {
            display: flex;
            width: 100%; /* Full width for the input group */
        }
        p {
            margin: 0 0 5px; /* Space between paragraph and input */
        }
        input[type="text"], select {
            width: 85%; /* Each input/select takes up half of the row */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 4%; /* Space between inputs */
        }
        input[type="text"]:last-child, select:last-child {
            margin-right: 0; /* Remove right margin from the last input */
        }
        input[type="submit"] {
            background-color: #5a6268;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px; /* Margin to separate from other inputs */
        }
        input[type="submit"]:hover {
            background-color: #343a40;
        }
        .note {
            font-size: 12px;
            margin-top: 10px;
        }
        .login-link {
            font-size: 14px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php
if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
} else {
    echo "NIK tidak ditemukan di URL.";
}
?>


    <div class="header">
        Universitas Almarisah Madani
    </div>

    <div class="container">
        <div class="form-container">
            <h3>Pendaftaran D3 - Periode 2025*</h3>
            <p>NIK/KTP : <?= $nik ?></p>
            <form method="POST" action="">

                <!-- Nama Lengkap -->
                <div class="form-row">
                    <div style="width: 100%;">
                        <p>Nama Lengkap:</p>
                        <input type="text" id="name" name="name" required>
                    </div>
                </div>

                <!-- Pilihan -->

                <div class="form-row">
                    <div style="width: 100%;">
                        <p>Pilihan Pertama:</p>
                        <input type="text" id="choice1" name="choice1" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <div style="width: 48%;">
                            <p>Pilihan Kedua:</p>
                            <input type="text" id="choice2" name="choice2" required>
                        </div>
                        <div style="width: 48%;">
                            <p>Pilihan Ketiga:</p>
                            <input type="text" id="choice3" name="choice3" required>
                        </div>
                    </div>
                </div>
              

                <!-- Jenis Pendaftaran dan Agama -->
                <div class="form-row">
                    <div class="input-group">
                        <div style="width: 48%;">
                            <p>Jenis Pendaftaran:</p>
                            <select id="registrationType" name="registrationType" required>
                                <option value="">Pilih Jenis Pendaftaran</option>
                                <option value="jalur_1">Jalur 1</option>
                                <option value="jalur_2">Jalur 2</option>
                            </select>
                        </div>
                        <div style="width: 48%;">
                            <p>Agama:</p>
                            <input type="text" id="religion" name="religion" required>
                        </div>
                    </div>
                </div>

                <!-- NIS/NISN dan Asal Sekolah -->
                <div class="form-row">
                    <div class="input-group">
                        <div style="width: 48%;">
                            <p>NIS/NISN/NIM/STAMBUK:</p>
                            <input type="text" id="nis" name="nis" required>
                        </div>
                        <div style="width: 48%;">
                            <p>Asal Sekolah/Perguruan Tinggi:</p>
                            <input type="text" id="schoolOrigin" name="schoolOrigin" required>
                        </div>
                    </div>
                </div>

                <!-- Tahun Lulus dan Jenis Kelamin -->
                <div class="form-row">
                    <div class="input-group">
                        <div style="width: 48%;">
                            <p>Tahun Lulus:</p>
                            <input type="text" id="graduationYear" name="graduationYear" required>
                        </div>
                        <div style="width: 48%;">
                            <p>Jenis Kelamin:</p>
                            <select id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="laki_laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Email dan Phone -->
                <div class="form-row">
                    <div class="input-group">
                        <div style="width: 48%;">
                            <p>Email:</p>
                            <input type="text" id="email" name="email" required>
                        </div>
                        <div style="width: 48%;">
                            <p>Phone/WA Number:</p>
                            <input type="text" id="phone" name="phone" required>
                        </div>
                    </div>
                </div>

                <!-- Asal Daerah dan Sumber Referensi -->
                <div class="form-row">
                    <div class="input-group">
                        <div style="width: 48%;">
                            <p>Asal Daerah:</p>
                            <input type="text" id="region" name="region" required>
                        </div>
                        <div style="width: 48%;">
                            <p>Sumber Referensi:</p>
                            <input type="text" id="referenceSource" name="referenceSource" required>
                        </div>
                    </div>
                </div>

                <!-- Referral ID dan Password -->
                <div class="form-row">
                    <div class="input-group">
                        <div style="width: 48%;">
                            <p>Referral ID:</p>
                            <input type="text" id="referralId" name="referralId">
                        </div>
                        <div style="width: 48%;">
                            <p>Password:</p>
                            <input type="text" id="password" name="password" required>
                        </div>
                    </div>
                </div>

                <input type="submit" value="Submit">
            </form>

            <p class="note">* Biaya Registrasi = Rp 153,000</p>
            <p class="login-link">
                Sudah mendaftar? <a href="#">Login di sini</a>
            </p>
        </div>
    </div>

    <div class="footer">
    @2024 HEWI
    </div>

</body>
</html>
