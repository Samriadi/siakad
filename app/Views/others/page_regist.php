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
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        input[type="text"] {
            width: 70%; /* Adjust width to be smaller */
            padding: 10px;
            margin: 15px auto; /* Center the input field */
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block; /* Ensure input behaves as a block element for horizontal centering */
        }
        input[type="submit"] {
            background-color: #5a6268;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

    <div class="header">
        Universitas Almarisah Madani
    </div>

    <div class="container">
        <div class="form-container">
            <h3>Pendaftaran D3 - Periode 2025*</h3>
            <form method="POST" action="">
                <label for="nik">NIK/KTP:</label>
                <input type="text" id="nik" name="nik" required>
                <input type="submit" value="Submit">
            </form>

            <p class="note">* Biaya Registrasi = Rp 153,000</p>
            <p class="login-link">
                Sudah mendaftar sebelumnya? silahkan <a href="#">Login</a> terlebih dahulu
            </p>
        </div>
    </div>

    <div class="footer">
        @2024 HEWI
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault(); 

                var nik = $('#nik').val(); 

                if (nik === '') {
                    alert('Please enter your NIK/KTP');
                } else {

                    console.log(nik);
                    
                    $.ajax({
                        url: '/admin/siakad/regist/add',
                        type: 'POST',
                        data: { nik: nik },
                        success: function(response) {
                            if (response.status === 'exist') {
                                alert(response.message); 
                            } else if (response.status === 'null') {
                                window.location.href = '/admin/siakad/regist/insert?nik=' + encodeURIComponent(nik);
                            }
                            
                        },
                        error: function() {
                            alert('There was an error submitting the form.');
                        }
                    });

                }
            });
        });
    </script>

</body>
</html>

