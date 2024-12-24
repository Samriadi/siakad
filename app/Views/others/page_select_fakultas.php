<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Tagihan</title>
  <?php include '../app/Views/others/layouts/header.php'; ?>

<body>
  <div id="app">
    <!-- <div class="main-wrapper main-wrapper-1"> -->

    <!-- navbar -->
    <?php include '../app/Views/others/layouts/topbar.php'; ?>

    <!-- sidbar -->
    <?php include '../app/Views/others/layouts/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>Tagihan Mahasiswa</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Invoice</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <?php foreach ($data as $value): ?>
                      <div class="col-lg-6">
                        <div class="card card-large-icons">
                          <div class="card-icon bg-primary text-white">
                            <i class="fas fa-graduation-cap"></i> <!-- Ikon default -->
                          </div>
                          <div class="card-body">
                            <h4><?= $value->name ?></h4>
                            <p><?= $value->deskripsi ?></p>
                            <a href="#" class="card-cta" onclick="handleTagihanMahasiswa(<?= $value->ID ?>)">Penerbitan Tagihan <i class="fas fa-chevron-right"></i></a><br><br>
                            <a href="#" class="card-cta" onclick="handlePembayaranMahasiswa(<?= $value->ID ?>)">Status Pembayaran<i class="fas fa-chevron-right"></i></a>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </section>

    <!-- Footer -->
    <?php include '../app/Views/others/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $(document).ready(function() {
        $('.table').DataTable({
          "paging": true,
          "searching": true,
          "ordering": true,
          "info": true
        });
      });

      function handleTagihanMahasiswa(id) {
        $.ajax({
          url: '/admin/siakad/invoice-find',
          type: 'GET',
          data: {
            fakultas_id: id
          },
          dataType: 'json',
          success: function(response) {
            console.log('Response:', response);
            window.location.href = '/admin/siakad/invoice-selected';
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
          }
        });
      }

      function handlePembayaranMahasiswa(id) {
        $.ajax({
          url: '/admin/siakad/invoice-find-paying',
          type: 'GET',
          data: {
            fakultas_id: id
          },
          dataType: 'json',
          success: function(response) {
            console.log('Response:', response);
            window.location.href = '/admin/siakad/invoice-selected-paying';
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
          }
        });
      }
    </script>


</body>

</html>