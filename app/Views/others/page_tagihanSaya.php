<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD</title>

  <!-- header -->
  <?php include '../app/Views/others/layouts/header-mhs.php'; ?>


<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">

      <?php include '../app/Views/others/layouts/topbar-mhs.php'; ?>


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
                          <th scope="col">Virtual Account</th>
                          <th scope="col">Periode</th>
                          <th scope="col">Tagihan Baru</th>
                          <th scope="col">Total Pembayaran</th>
                          <th scope="col">Status</th>
                        </tr>
                        <?php foreach ($data as $key => $value) :
                          if ($value->total_pembayaran >= $value->tagihan)
                            $status = "Lunas";
                          else
                            $status = "Belum Lunas";
                        ?>
                          <tr>
                            <td><?= $value->va_number ?></td>
                            <td><?= $value->periode ?></td>
                            <td>Rp. <?= number_format($value->tagihan, 0) ?></td>
                            <td>Rp. <?= number_format($value->total_pembayaran, 0) ?></td>
                            <td>Rp. <?= $status ?></td>
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
      <footer class="main-footer">
        <?php include '../app/Views/others/layouts/footer-mhs.php'; ?>



</body>
<script>
  var data = <?php echo json_encode($data); ?>;
  $(document).ready(function() {
    $('#nim').val(data[0].nim);
    $('#nama').val(data[0].nama);
  });
</script>

</html>