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
          <h1>Data Tagihan</h1>
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
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>NIM</label>
                      <input type="number" class="form-control" id="nim" name="nim" disabled>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Nama</label>
                      <input type="text" class="form-control" id="nama" name="nama" disabled>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-md">
                      <tr>
                        <th scope="col">Tagihan</th>
                        <th scope="col">Periode</th>
                        <th scope="col">Virtual Account</th>
                        <th scope="col">Jumlah Pembayaran</th>
                        <th scope="col">Status</th>
                      </tr>
                      <?php foreach ($data as $key => $value) : ?>
                        <tr>
                          <td>Rp. <?= $value->tagihan ?></td>
                          <td><?= $value->periode ?></td>
                          <td><?= $value->va_number ?></td>
                          <td>Rp. <?= $value->nominal_pembayaran ?></td>
                          <?php
                          $value->tagihan < $value->nominal_pembayaran ? $status = 'Belum Lunas' : $status = 'Lunas';
                          echo '<td>' . $status . '</td>';
                          ?>
                        </tr>
                      <?php endforeach ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Footer -->
    <?php include '../app/Views/others/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      var data = <?php echo json_encode($data); ?>;
      $(document).ready(function() {
        $('#nim').val(data[0].nim);
        $('#nama').val(data[0].nama);
      });
    </script>
</body>

</html>