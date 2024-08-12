<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Mata Kuliah</title>
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
          <h1>Data</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Data</a></div>
            <div class="breadcrumb-item">Data Mata Kuliah</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Data Mata Kuliah</h4>
                  <div class="card-header-action">
                    <a class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                      <i class="fas fa-plus text-white"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Course Code</th>
                          <th scope="col">Course Namae</th>
                          <th scope="col">Credits</th>
                          <th scope="col">Semester</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value) : ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->course_code ?></td>
                            <td><?= $value->course_name ?></td>
                            <td><?= $value->credits ?></td>
                            <td><?= $value->semester ?></td>
                            <td style="white-space: nowrap;">
                              <a class="btn btn-primary btn-action mr-1" data-toggle="modal" data-target="#editModal" data-id="<?= $value->course_id ?>">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              <a class="btn btn-danger btn-action mr-1" data-id="<?= $value->course_id ?>" onclick="confirmDelete(this)">
                                <i class="fas fa-trash-alt"></i>
                              </a>
                            </td>

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

    <!-- Modal Structure -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Add Data Mata Kuliah</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_course_code">Course Code</label>
                  <input type="text" class="form-control" id="add_course_code">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_course_name">Course Name</label>
                  <input type="text" class="form-control" id="add_course_name">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_credits">Credits</label>
                  <input type="number" class="form-control" id="add_credits">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_semester">Semester</label>
                  <input type="number" class="form-control" id="add_semester">
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
            <h5 class="modal-title" id="editModalLabel">Edit Data Mata Kuliah</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="course_code">Course Code</label>
                  <input type="text" class="form-control" id="course_code">
                </div>
                <div class="form-group col-md-6">
                  <label for="course_name">Course Name</label>
                  <input type="text" class="form-control" id="course_name">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="credits">Credits</label>
                  <input type="number" class="form-control" id="credits">
                </div>
                <div class="form-group col-md-6">
                  <label for="semester">Semester</label>
                  <input type="number" class="form-control" id="semester">
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
            course_code: $('#add_course_code').val(),
            course_name: $('#add_course_name').val(),
            credits: $('#add_credits').val(),
            semester: $('#add_semester').val()
          }];

          console.log(arrayData);

          $.ajax({
            url: '/admin/siakad/matkul/add',
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

          console.log(id);

          $.ajax({
            url: '/admin/siakad/matkul/fetch',
            type: 'POST',
            data: {
              id: id
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;
                console.log(data);

                $('#course_code').val(data.course_code);
                $('#course_name').val(data.course_name);
                $('#credits').val(data.credits);
                $('#semester').val(data.semester);

              } else {
                console.log('Data tidak ditemukan');
              }
            }
          });

          $('#submit').on('click', function() {

            var arrayData = [{
              course_id: id,
              course_code: $('#course_code').val(),
              course_name: $('#course_name').val(),
              credits: $('#credits').val(),
              semester: $('#semester').val(),
            }];

            $.ajax({
              url: '/admin/siakad/matkul/update',
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
                      window.location.reload();
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
              url: '/admin/siakad/matkul/delete',
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
                    location.reload();
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

</body>

</html>