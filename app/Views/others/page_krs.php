<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Mahasiswa</title>
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
          <h1>Data</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Kartu Rencana Studi</a></div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <form method="POST" action="#">
                    <div class="form-group">
                      <label for="name">Nama</label>
                      <input type="text" class="form-control" id="name" value="bass">
                    </div>
                    <div class="form-group">
                      <label for="semester">Semester</label>
                      <input type="number" class="form-control" id="semester">
                    </div>
                    <div class="form-group">
                      <label for="academic_year">Tahun Akademik</label>
                      <input type="text" class="form-control" id="academic_year">
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="d-inline">Mata Kuliah Semester 1</h4>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled list-unstyled-border">
                    <?php foreach ($dataMatkul1 as $key => $value) : ?>
                      <li class="media">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="cbx-1">
                          <label class="custom-control-label" for="cbx-1"></label>
                        </div>
                        <div class="media-body">
                          <h6 class="media-title"><a href="#"><?= $value->course_name ?></a></h6>
                          <div class="text-small text-muted"><?= $value->course_code ?><div class="bullet"></div> <span class="text-primary"><?= $value->credits ?> SKS</span></div>
                        </div>
                      </li>
                    <?php endforeach ?>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-6 col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="d-inline">Mata Kuliah Semester 2</h4>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled list-unstyled-border">
                    <?php foreach ($dataMatkul2 as $key => $value) : ?>
                      <li class="media">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="cbx-1">
                          <label class="custom-control-label" for="cbx-1"></label>
                        </div>
                        <div class="media-body">
                          <h6 class="media-title"><a href="#"><?= $value->course_name ?></a></h6>
                          <div class="text-small text-muted"><?= $value->course_code ?><div class="bullet"></div> <span class="text-primary"><?= $value->credits ?> SKS</span></div>
                        </div>
                      </li>
                    <?php endforeach ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 col-md-6 col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="d-inline">Mata Kuliah Yang Dipilih</h4>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                      <div class="media-body">
                        <h6 class="media-title"><a href="#">Informatika</a></h6>
                        <div class="text-small text-muted">IT303 <div class="bullet"></div> <span class="text-primary">2 SKS</span></div>
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-body">
                        <h6 class="media-title"><a href="#">Sistem Informasi</a></h6>
                        <div class="text-small text-muted">IT303 <div class="bullet"></div> <span class="text-primary">2 SKS</span></div>
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-body">
                        <h6 class="media-title"><a href="#">Algoritma Pemrograman</a></h6>
                        <div class="text-small text-muted">IT303 <div class="bullet"></div> <span class="text-primary">2 SKS</span></div>
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-body">
                        <h6 class="media-title"><a href="#">Sistem Basis Data</a></h6>
                        <div class="text-small text-muted">IT303 <div class="bullet"></div> <span class="text-primary">2 SKS</span></div>
                      </div>
                    </li>
                  </ul><br>
                  <h6>Total SKS : 22 SKS</h6>
                  <br>
                  <button class="btn btn-primary">Input</button>
                </div>


                </form>
              </div>
      </section>
    </div>
  </div>

  <!-- Footer -->
  <?php include '../app/Views/others/layouts/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    data = <?php echo json_encode($dataMatkul1) ?>;
    console.log(data);
  </script>
</body>

</html>