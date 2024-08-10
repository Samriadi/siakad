<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Perkuliahan</title>
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
            <div class="breadcrumb-item">Data Perkuliahan</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Data Perkuliahan</h4>
                  <div class="card-header-action">
                    <a class="btn btn-primary" id="btn-add">
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
                          <th scope="col">Mata Kuliah</th>
                          <th scope="col">Dosen</th>
                          <th scope="col">Hari</th>
                          <th scope="col">Jam Mulai</th>
                          <th scope="col">Jam Selesai</th>
                          <th scope="col">Ruangan</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value) : ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->course_name ?></td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->day ?></td>
                            <td><?= date('H:i', strtotime($value->start_time)) ?></td>
                            <td><?= date('H:i', strtotime($value->end_time)) ?></td>
                            <td><?= $value->room ?></td>
                            <td style="white-space: nowrap;">
                              <a class="btn btn-primary btn-action mr-1" id="btn-edit" data-id="<?= $value->schedule_id ?>">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              <a class="btn btn-danger btn-action mr-1" data-id="<?= $value->schedule_id ?>" onclick="confirmDelete(this)">
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
            <h5 class="modal-title" id="addModalLabel">Add Data Perkuliahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_course_id">Mata Kuliah</label>
                  <select id="add_course_id" class="form-control" required>
                    <option value="" selected disabled>Pilih Mata Kuliah</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="add_dosen_id">Dosen</label>
                  <select id="add_dosen_id" class="form-control" required>
                    <option value="" selected disabled>Pilih Dosen</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_day">Hari</label>
                  <select id="add_day" class="form-control" required>
                    <option value="" selected disabled>Pilih Hari</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="add_start_time">Jam Mulai</label>
                  <input type="time" class="form-control" id="add_start_time">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_end_time">Jam Selesai</label>
                  <input type="time" class="form-control" id="add_end_time">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_room">Ruangan</label>
                  <input type="text" class="form-control" id="add_room">
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
            <h5 class="modal-title" id="editModalLabel">Edit Data Perkuliahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="course_id">Mata Kuliah</label>
                  <select id="course_id" class="form-control" required>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="dosen_id">Dosen</label>
                  <select id="dosen_id" class="form-control" required>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="day">Hari</label>
                  <select id="day" class="form-control" required>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="start_time">Jam Mulai</label>
                  <input type="time" class="form-control" id="start_time">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="end_time">Jam Selesai</label>
                  <input type="time" class="form-control" id="end_time">
                </div>
                <div class="form-group col-md-6">
                  <label for="room">Ruangan</label>
                  <input type="text" class="form-control" id="room">
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
        $('#btn-add').on('click', function() {
          $.ajax({
            url: '/admin/siakad/perkuliahan/include',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;
                var DataMatkul = data.DataMatkul;
                var DataDosen = data.DataDosen;

                $('#add_course_id').empty().append('<option value="" selected disabled>Pilih Mata Kuliah</option>');
                $('#add_dosen_id').empty().append('<option value="" selected disabled>Pilih Dosen</option>');

                $.each(DataMatkul, function(index, matkul) {
                  $('#add_course_id').append('<option value="' + matkul.course_id + '">' + matkul.course_name + '</option>');
                });

                $.each(DataDosen, function(index, dosen) {
                  $('#add_dosen_id').append('<option value="' + dosen.lecturer_id + '">' + dosen.name + '</option>');
                });

                $('#addModal').modal('show');

              } else {
                console.log('Data tidak ditemukan');
              }
            },
            error: function(xhr, status, error) {
              console.log('Terjadi kesalahan: ' + error);
            }
          });

          $('#add_submit').on('click', function() {
            var arrayData = [{
              course_id: $('#add_course_id').val(),
              dosen_id: $('#add_dosen_id').val(),
              day: $('#add_day').val(),
              start_time: $('#add_start_time').val(),
              end_time: $('#add_end_time').val(),
              room: $('#add_room').val()
            }];

            console.log(arrayData);

            $.ajax({
              url: '/admin/siakad/perkuliahan/add',
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
        });


        //edit data
        $('#btn-edit').on('click', function() {
          var id = $(this).data('id');

          console.log(id);

          $.ajax({
            url: '/admin/siakad/perkuliahan/fetch',
            type: 'POST',
            data: {
              id: id
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;
                var dataMatkul = response.dataMatkul;
                var dataDosen = response.dataDosen;
                var optionMatkul = response.optionMatkul;
                var optionDosen = response.optionDosen;

                $('#course_id').empty().append('<option value="' + dataMatkul.course_id + '">' + dataMatkul.course_name + '</option>');

                $('#dosen_id').empty().append('<option value="' + dataDosen.lecturer_id + '">' + dataDosen.name + '</option>');

                $('#day').empty().append('<option value="' + data.day + '">' + data.day + '</option>');

                $.each(optionMatkul, function(index, matkul) {
                  if (!$('#course_id option[value="' + matkul.course_id + '"]').length) {
                    $('#course_id').append('<option value="' + matkul.course_id + '">' + matkul.course_name + '</option>');
                  }
                });

                $.each(optionDosen, function(index, dosen) {
                  if (!$('#dosen_id option[value="' + dosen.lecturer_id + '"]').length) {
                    $('#dosen_id').append('<option value="' + dosen.lecturer_id + '">' + dosen.name + '</option>');
                  }
                });

                var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                $.each(days, function(index, day) {
                  if (!$('#day option[value="' + day + '"]').length) {
                    $('#day').append('<option value="' + day + '">' + day + '</option>');
                  }
                });


                $('#start_time').val(data.start_time);
                $('#end_time').val(data.end_time);
                $('#room').val(data.room);


                $('#editModal').modal('show');

              } else {
                console.log('Data tidak ditemukan');
              }
            }
          });

          $('#submit').on('click', function() {

            var arrayData = [{
              schedule_id: id,
              course_id: $('#course_id').val(),
              dosen_id: $('#dosen_id').val(),
              day: $('#day').val(),
              start_time: $('#start_time').val(),
              end_time: $('#end_time').val(),
              room: $('#room').val(),
            }];

            $.ajax({
              url: '/admin/siakad/perkuliahan/update',
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
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '/admin/siakad/perkuliahan/delete',
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