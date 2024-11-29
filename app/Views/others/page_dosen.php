<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Dosen</title>
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
          <h1>Data Dosen</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Data</a></div>
            <div class="breadcrumb-item">Data Dosen</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-header-action">
                    <a class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                      <i class="fas fa-plus text-white"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab3" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">Dosen</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Penugasan</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent2">
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                      <div class="card">
                        <div class="card-body">
                          <div class="table-responsive" style="max-height: 760px; overflow-y: auto;">
                            <table class="table table-hover">
                              <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                                <tr>
                                  <th scope="col">No</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Nama</th>
                                  <th scope="col">NIDN</th>
                                  <th scope="col">NIK</th>
                                  <!-- <th scope="col">Action</th> -->
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($data as $key => $value) : ?>
                                  <tr>
                                    <th scope="row"><?= $key + 1 ?></th>
                                    <td><?= $value->Status ?></td>
                                    <td><?= $value->Nama ?></td>
                                    <td><?= $value->NIDN ?></td>
                                    <td><?= $value->NIK ?></td>
                                    <td>
                                      <a class="btn btn-danger btn-action mr-1" data-id="<?= $value->ID ?>" onclick="confirmDelete(this)">
                                        <i class="fas fa-trash-alt"></i>
                                      </a>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>



                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                      <div class="card">
                        <div class="card-body">
                          <div class="table-responsive" style="max-height: 760px;">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th scope="col">No</th>
                                  <th scope="col">Nama Dosen</th>
                                  <th scope="col">NIDN/NUP/NIDK</th>
                                  <th scope="col">Jenis Kelamin</th>
                                  <th scope="col">Tahun Ajaran</th>
                                  <th scope="col">Program Studi</th>
                                  <th scope="col">No. Surat Tugas</th>
                                  <th scope="col">Tanggal Surat Tugas</th>
                                  <th scope="col">Homebase</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($dataPenugasan as $key => $value) : ?>
                                  <tr>
                                    <th scope="row"><?= ++$key ?></th>
                                    <td><?= $value->nama_dosen ?></td>
                                    <td><?= $value->nidn_nup_nidk ?></td>
                                    <td><?= $value->jenis_kelamin ?></td>
                                    <td><?= $value->tahun_ajaran ?></td>
                                    <td><?= $value->program_studi ?></td>
                                    <td><?= $value->nomor_surat_tugas ?></td>
                                    <td><?= $value->tanggal_surat_tugas ?></td>
                                    <td><?= $value->homebase ?></td>
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
            </div>
          </div>
        </div>
    </div>
    </section>

    <!-- Modal Structure -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Add Data Dosen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_nidn">NIDN</label>
                  <input type="text" class="form-control" id="add_nidn">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_name">Nama Lengkap</label>
                  <input type="text" class="form-control" id="add_name">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_birth_date">Tanggal Lahir</label>
                  <input type="date" class="form-control" id="add_birth_date">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_gender">Gender</label>
                  <select class="form-control" id="add_gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_address">Alamat</label>
                  <input type="text" class="form-control" id="add_address">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_phone">Telepon</label>
                  <input type="text" class="form-control" id="add_phone">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_email">Email</label>
                  <input type="email" class="form-control" id="add_email">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_hire_date">Tanggal Masuk</label>
                  <input type="date" class="form-control" id="add_hire_date">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add_submit">Submit</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Data Dosen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nidn">NIDN</label>
                  <input type="text" class="form-control" id="nidn">
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Nama Lengkap</label>
                  <input type="text" class="form-control" id="name">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="birth_date">Tanggal Lahir</label>
                  <input type="date" class="form-control" id="birth_date">
                </div>
                <div class="form-group col-md-6">
                  <label for="gender">Gender</label>
                  <select class="form-control" id="gender">
                    <option value="Male" selected>Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>

              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="address">Alamat</label>
                  <input type="text" class="form-control" id="address">
                </div>
                <div class="form-group col-md-6">
                  <label for="phone">Telepon</label>
                  <input type="text" class="form-control" id="phone">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email">
                </div>
                <div class="form-group col-md-6">
                  <label for="hire_date">Tanggal Masuk</label>
                  <input type="date" class="form-control" id="hire_date">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="submit">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <?php include '../app/Views/others/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $(document).ready(function() {
        //add data
        $('#add_submit').on('click', function() {
          var arrayData = [{
            nidn: $('#add_nidn').val(),
            name: $('#add_name').val(),
            birth_date: $('#add_birth_date').val(),
            gender: $('#add_gender').val(),
            address: $('#add_address').val(),
            phone: $('#add_phone').val(),
            email: $('#add_email').val(),
            hire_date: $('#add_hire_date').val()
          }];

          console.log(arrayData);

          $.ajax({
            url: '/admin/siakad/dosen/add',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(arrayData),
            dataType: 'json',
            success: function(response) {
              console.log(response);
              if (response.success) {
                Swal.fire({
                  text: 'Your data has been added.',
                  icon: 'success',
                  showConfirmButton: false,
                  willClose: () => {
                    window.location.reload();
                  }
                });
              } else {
                Swal.fire({
                  text: 'An error occurred during the update.',
                  icon: 'error',
                  confirmButtonText: 'OK'
                });
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.error('AJAX Error:', textStatus, errorThrown);
              Swal.fire({
                text: 'An unexpected error occurred.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
          });
        });


        //edit data
        $('.btn-action').on('click', function() {
          var id = $(this).data('id');

          $.ajax({
            url: '/admin/siakad/dosen/fetch',
            type: 'POST',
            data: {
              id: id
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;
                $('#nidn').val(data.nidn);
                $('#name').val(data.name);
                $('#birth_date').val(data.birth_date);
                $('#gender').val(data.gender);
                $('#address').val(data.address);
                $('#phone').val(data.phone);
                $('#email').val(data.email);
                $('#hire_date').val(data.hire_date);

              } else {
                console.log('Data tidak ditemukan');
              }
            }
          });

          $('#submit').on('click', function() {

            var arrayData = [{
              id: id,
              nidn: $('#nidn').val(),
              name: $('#name').val(),
              birth_date: $('#birth_date').val(),
              gender: $('#gender').val(),
              address: $('#address').val(),
              phone: $('#phone').val(),
              email: $('#email').val(),
              hire_date: $('#hire_date').val(),
            }];

            $.ajax({
              url: '/admin/siakad/dosen/update',
              type: 'POST',
              contentType: 'application/json',
              data: JSON.stringify(arrayData),
              dataType: 'json',
              success: function(response) {
                if (response.success) {
                  Swal.fire({
                    text: 'Your data has been updated.',
                    icon: 'success',
                    showConfirmButton: false,
                    willClose: () => {
                      window.location.reload(); // Reload halaman setelah modal ditutup
                    }
                  });
                } else {
                  Swal.fire({
                    text: 'An error occurred during updated.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });

                }
              }
            });

          });

        });

      });


      function confirmDelete(element) {
        const id = element.getAttribute('data-id');

        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '/admin/siakad/dosen/delete', // URL to your PHP script that handles deletion
              type: 'POST',
              data: {
                id: id
              },
              success: function(response) {
                console.log(response);
                if (response.success) {
                  Swal.fire(
                    'Deleted!',
                    'The record has been deleted.',
                    'success'
                  ).then(() => {
                    // Optionally, you can reload the page or remove the row from the table
                    location.reload(); // Reload the page
                  });
                } else {
                  Swal.fire(
                    'Error!',
                    'There was an issue deleting the record.',
                    'error'
                  );
                }
              },
              error: function() {
                Swal.fire(
                  'Error!',
                  'Failed to send request.',
                  'error'
                );
              }
            });
          }
        });
      }
    </script>
    <script>
      $(document).ready(function() {
        $('.table').DataTable({
          "paging": true, // Pagination
          "searching": true, // Search box
          "ordering": true, // Column sorting
          "info": true // Info text (e.g., "Showing 1 to 10 of 20 entries")
        });
      });
    </script>

</body>

</html>