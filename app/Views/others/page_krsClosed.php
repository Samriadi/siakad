<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - KRS</title>
  <?php include '../app/Views/others/layouts/header.php'; ?>
</head>

<body>
  <div id="app">
    <!-- navbar -->
    <?php include '../app/Views/others/layouts/topbar.php'; ?>

    <!-- sidebar -->
    <?php include '../app/Views/others/layouts/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>Kartu Rencana Studi</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Kartu Rencana Studi</a></div>
          </div>
        </div>

        <div class="section-body">
        <div class="row">
            <div class="col-12">
            <div class="card">
                  <div class="card-body">
                    <div class="empty-state" data-height="400">
                      <div class="empty-state-icon bg-warning">
                        <i class="fas fa-info"></i>
                      </div>
                      <h2>Pengisian KRS telah ditutup.</h2>
                      <p class="lead">
                        <!-- Sorry we can't find any data, to get rid of this message, make at least 1 entry. -->
                      </p>
                    </div>
                  </div>
                </div>
            </div>
            </div>

        </div>

    </div>
</div>



      </section>
    </div>
  </div>

  <!-- Footer -->
  <?php include '../app/Views/others/layouts/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>