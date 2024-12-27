<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Tagihan</title>
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
          <h1>Tagihan</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Tagihan</a></div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label>NIM</label>
                    <div class="d-flex align-items-center">
                      <input type="text" class="form-control" id="nim" name="nim" disabled>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label>Fakultas</label>
                      <input type="text" class="form-control" id="fakultas" name="fakultas" disabled>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Program Studi</label>
                      <input type="text" class="form-control" id="prodi" name="prodi" disabled>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Angkatan</label>
                      <input type="text" class="form-control" id="angkatan" name="angkatan" disabled>
                    </div>

                  </div>
                  <div class="form-group">
                    <label class="d-block">Jenis Tagihan</label>
                    <input type="text" class="form-control" id="jenis_tagihan" name="jenis_tagihan" disabled>

                  </div>
                  <div class="form-group">
                    <label>Nominal Tagihan</label>
                    <input type="number" class="form-control" id="nominal" name="nominal" disabled>
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
        var data = <?php echo json_encode($data); ?>;

        $('#nim').val(data[0].nim);
        $('#fakultas').val(data[0].nama_fakultas);
        $('#prodi').val(data[0].nama_prodi);
        $('#angkatan').val(data[0].tahun_angkatan);
        $('#nominal').val(data[0].nominal);
        $('#jenis_tagihan').val(data[0].nama_tagihan);

        console.log(data)
      </script>

</body>

</html>