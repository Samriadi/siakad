<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Pembayaran</title>
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
          <h1>Daftar Transaksi & Status Pembayaran</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="/admin/siakad/invoice">Invoice</a></div>
            <div class="breadcrumb-item">Selected</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Transaksi Mahasiswa - Fakultas <?= $dataSelectedPaying[0]->nama_fakultas ?></h4>
                  <div class="card-header-action">
                    <!--
                    <a class="btn btn-primary" id="btn-add">
                      <i class="fas fa-plus text-white"></i>
                    </a>
				  -->
                  </div>
                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab3" role="tablist">
                    <?php foreach ($dataSelectedPaying as $index => $item): ?>
                      <li class="nav-item">
                        <a class="nav-link <?= $index == 0 ? 'active' : '' ?>"
                          id="tab-<?= $item->ID ?>"
                          data-toggle="tab"
                          href="#tab-content-<?= $item->ID ?>"
                          role="tab"
                          aria-controls="tab-content-<?= $item->ID ?>"
                          aria-selected="<?= $index == 0 ? 'true' : 'false' ?>">
                          <?= $item->deskripsi ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>

                  <div class="tab-content" id="myTabContent2">
                    <?php foreach ($dataSelectedPaying as $index => $item): ?>
                      <div class="tab-pane fade <?= $index == 0 ? 'show active' : '' ?>"
                        id="tab-content-<?= $item->ID ?>"
                        role="tabpanel"
                        aria-labelledby="tab-<?= $item->ID ?>">
                        <div class="card">
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
                                    <th scope="col">ID Transaksi</th>
                                    <th scope="col">VA Number</th>
                                    <th scope="col">Nominal</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $counter = 1; // Menggunakan variabel untuk nomor urut
                                  foreach ($data as $value) :
                                    // Memastikan data yang ditampilkan sesuai dengan prodi pada tab yang aktif
                                    if ($value->prodi == $item->deskripsi) :
                                  ?>
                                      <tr>
                                        <th scope="row"><?= $counter++ ?></th>
                                        <td><?= $value->nim ?></td>
                                        <td><?= $value->nama ?></td>
                                        <td><?= $value->prodi ?></td>
                                        <td><?= $value->angkatan ?></td>
                                        <td><?= $value->trans_id ?></td>
                                        <td><?= $value->va_number ?></td>
                                        <td><?= 'Rp. ' . number_format($value->tagihan ?? 0, 0, ',', '.') ?></td>
                                      </tr>
                                  <?php
                                    endif;
                                  endforeach;
                                  ?>
                                </tbody>
                              </table>
                            </div>
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


    <script>
      $(document).ready(function() {
        $('.table').DataTable({
          "paging": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "pageLength": 25 // Set jumlah record per halaman
        });
      });
    </script>

</body>

</html>