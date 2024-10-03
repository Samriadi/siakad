<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pilih Dashboard Admin</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

  <style>
    body {
      background: linear-gradient(135deg, #8e44ad, #3498db);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .container {
      max-width: 1000px;
      padding: 50px;
    }

    .card {
      background-color: #fff;
      border-radius: 20px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      color: #333;
      padding: 20px;
    }

    .card:hover {
      transform: translateY(-15px) scale(1.05);
      box-shadow: 0 16px 50px rgba(0, 0, 0, 0.4);
    }

    .card-header {
      background-color: transparent;
      border-bottom: none;
      padding-bottom: 0;
    }

    h4 {
      font-size: 2.5rem;
      margin-bottom: 2rem;
      font-weight: 700;
    }

    .card-body {
      padding: 2rem;
    }

    .icon {
      font-size: 5rem;
      color: #8e44ad; /* Warna ungu */
      transition: color 0.4s ease, transform 0.4s ease;
    }
    .card:hover .icon {
      color: #8e44ad;
      transform: rotate(10deg);
    }

    .card-title {
      font-size: 1.4rem;
      font-weight: bold;
      color: #333;
    }

    .card-text {
      font-size: 1.0rem;
      margin: 20px 0;
      color: #666;
    }

    .btn {
      font-size: 1.0em;
      padding: 12px 30px;
      border-radius: 30px;
      transition: background-color 0.3s ease, transform 0.3s ease;
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: "";
      position: absolute;
      top: 0;
      left: -100%;
      width: 300%;
      height: 300%;
      background: rgba(255, 255, 255, 0.2);
      transition: all 0.4s ease;
      transform: rotate(45deg);
    }

    .btn:hover::before {
      left: -50%;
    }

    .btn-primary {
      background: linear-gradient(135deg, #3498db, #2980b9);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #2980b9, #1abc9c);
      transform: scale(1.05);
    }

    .btn-success {
      background: linear-gradient(135deg, #2ecc71, #27ae60);
    }

    .btn-success:hover {
      background: linear-gradient(135deg, #27ae60, #1abc9c);
      transform: scale(1.05);
    }

    .card-footer {
      background-color: transparent;
      text-align: center;
      color: #777;
      font-size: 0.9rem;
    }

    .row {
      display: flex;
      gap: 2rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    @media(max-width: 768px) {
      .row {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card text-center">
      <div class="card-header">
        <h4>Pilih Dashboard</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Admin PMB -->
          <div class="col-md-5 mb-4">
            <div class="card card-primary">
              <div class="card-body">
                <i class="fas fa-user-shield icon"></i>
                <h5 class="card-title mt-4">Dashboard PMB</h5>
                <p class="card-text">Kelola pendaftaran mahasiswa baru, jadwal tes, dan data pendaftar.</p>
                <a href="admin_pmb_dashboard.html" class="btn btn-primary">Masuk Dashboard PMB</a>
              </div>
            </div>
          </div>
          <!-- Admin SIAKAD -->
          <div class="col-md-5 mb-4">
            <div class="card card-danger">
              <div class="card-body">
                <i class="fas fa-users-cog icon"></i>
                <h5 class="card-title mt-4">Dashboard SIAKAD</h5>
                <p class="card-text">Kelola sistem akademik, data mahasiswa, nilai semester, dan KRS.</p>
                <a href="admin_siakad_dashboard.html" class="btn btn-danger">Masuk Dashboard SIAKAD</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <small>&copy; 2024 Your Company - All Rights Reserved</small>
      </div>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
