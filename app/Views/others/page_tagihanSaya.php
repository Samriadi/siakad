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
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>NIM</label>
                        <input type="number" class="form-control" id="nim" name="nim" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" disabled>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>Fakultas</label>
                        <input type="text" class="form-control" id="fakultas" name="fakultas" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Program Studi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" disabled>
                      </div>
                    </div>


                    <?php foreach ($data as $key => $value) :
                      $status = ($value->total_pembayaran >= $value->tagihan) ? "Lunas" : "Belum Lunas";
                    ?>
                      <div class="row border p-3 mb-3">
                        <div class="col-12 mb-2">
                          <label>Virtual Account</label>
                          <input type="text" class="form-control" name="va_number[<?= $key ?>]" value="<?= $value->va_number ?>" readonly>
                        </div>
                        <div class="col-12 mb-2">
                          <label>Periode</label>
                          <input type="text" class="form-control" name="periode[<?= $key ?>]" value="<?= $value->periode ?>" readonly>
                        </div>
                        <div class="col-12 mb-2">
                          <label>Tagihan Baru</label>
                          <input type="text" class="form-control" name="tagihan[<?= $key ?>]" value="Rp. <?= number_format($value->tagihan, 0) ?>" readonly>
                        </div>
                        <div class="col-12 mb-2">
                          <label>Total Pembayaran</label>
                          <input type="text" class="form-control" name="total_pembayaran[<?= $key ?>]" value="Rp. <?= number_format($value->total_pembayaran, 0) ?>" readonly>
                        </div>
                        <div class="col-12 mb-2">
                          <label>Status</label>
                          <input type="text" class="form-control font-weight-bold" name="status[<?= $key ?>]" value="<?= $status ?>" readonly>
                        </div>
                      </div>
                    <?php endforeach; ?>


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
    $('#fakultas').val(data[0].nama_fakultas);
    $('#prodi').val(data[0].nama_prodi);
  });
</script>

</html>