<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Pelunasan Tagihan</title>
  <?php include '../app/Views/others/layouts/header.php'; ?>
  <style>
    input[disabled] {
      background-color: #fff !important;
      /* Warna latar belakang normal */
      color: #495057 !important;
      /* Warna teks normal */
      opacity: 1 !important;
      /* Menghilangkan efek transparan */
      border: 1px solid #ced4da !important;
      /* Border normal */
    }
  </style>

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
          <h1>Pelunasan Tagihan</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pelunasan</a></div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Tagihan Mahasiswa</h4>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label>NIM</label>
                    <div class="d-flex align-items-center">
                      <input type="text" class="form-control mr-2" id="nim" name="nim" style="flex: 1;">
                      <button class="btn btn-primary py-2" type="button" id="cari">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label>Fakultas</label>
                      <input type="text" class="form-control" id="fakultas" name="fakultas">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Program Studi</label>
                      <input type="text" class="form-control" id="prodi" name="prodi">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Angkatan</label>
                      <input type="text" class="form-control" id="angkatan" name="angkatan">
                    </div>

                  </div>
                  <div class="form-group">
                    <label class="d-block">Jenis Tagihan</label>
                    <div id="checkbox-container"></div>
                    <div id="info-container">
                      <div class="alert alert-info py-2 px-3" role="alert" id="info-alert">
                        Silakan pilih opsi Fakultas, Program Studi dan Angkatan terlebih dahulu!
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Nominal Tagihan</label>
                    <input type="number" class="form-control" id="nominal" name="nominal" disabled>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit" id="submit">Simpan</button>
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
          $('#cari').click(function() {
            var nim = $('#nim').val();

            console.log(nim);
            $.ajax({
              url: '/admin/siakad/pelunasan/search',
              method: 'GET',
              data: {
                nim: nim
              },
              dataType: 'json',
              success: function(response) {
                var data = response.data;
                $('#fakultas').val(data.fakultas);
                $('#prodi').val(data.prodi);
                $('#angkatan').val(data.angkatan);
                console.log(response);
              },
              error: function(xhr, status, error) {
                console.log('Error:', error);
              }
            });
          });
        });
      </script>

</body>

</html>