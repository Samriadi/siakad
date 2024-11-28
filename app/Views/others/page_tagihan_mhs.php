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
          <h1>Data Tagihan</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Invoice</a></div>
            <div class="breadcrumb-item">Data Tagihann</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Data Tagihan</h4>
                  <div class="card-header-action">
				  <!--
                    <a class="btn btn-primary" id="btn-add">
                      <i class="fas fa-plus text-white"></i>
                    </a>
				  -->
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">NIM</th>
                          <th scope="col">Nama Mahasiswa</th>
                          <th scope="col">Prodi</th>
						  <th scope="col">Angkatan</th>
                          <th scope="col">Nominal</th>
                          <!--<th scope="col">Action</th>-->
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value) : ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->Nim ?></td>
                            <td><?= $value->NamaLengkap ?></td>
                            <td><?= $value->prodi_name ?></td>
							<td><?= $value->angkatan ?></td>
                            <td><?= 'Rp. ' . number_format($value->nominal, 0, ',', '.') ?></td>
							<!--
                            <td style="white-space: nowrap;">

                              <a class="btn btn-primary btn-action mr-1 btn-edit" data-id="<?= $value->recid ?>">
                                <i class="fas fa-pencil-alt"></i>
                              </a>

                              <a class="btn btn-danger btn-action mr-1" data-id="<?= $value->recid ?>"  onclick="confirmDelete(this)">
                                <i class="fas fa-trash-alt"></i>
                              </a>

                            </td>
							-->
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
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


<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "pageLength": 100  // Set jumlah record per halaman
        });
    });
</script>

</body>

</html>