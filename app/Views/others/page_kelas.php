<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Kelas</title>
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
          <h1>Master Kelas</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Master Kelas</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-header-action">
                    <a class="btn btn-primary btn-add">
                      <i class="fas fa-plus text-white"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive" style="max-height: 770px; overflow-y: auto;">
                    <table class="table table-hover">
                      <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Kelas</th>
                          <th scope="col">Mata Kuliah</th>
                          <th scope="col">Kurikulum</th>
                          <th scope="col">Kapasitas</th>
                          <th scope="col">Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value) : ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->nama_kelas ?></td>
                            <td><?= $value->mata_kuliah ?></td>
                            <td><?= $value->tahun_kurikulum ?></td>
                            <td><?= $value->kapasitas ?></td>
                            <td style="white-space: nowrap;">
                              <a class="btn btn-primary btn-action mr-1 btn-edit" data-id="<?= $value->ID_ruangan ?>">
                                <i class="fas fa-pencil-alt"></i>
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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Add Master Kelas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_name">Nama Kelas</label>
                  <input type="text" class="form-control" id="add_name">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_matkul">Mata Kuliah</label>
                  <select class="form-control" id="add_matkul" name="add_matkul">
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_kurikulum">Tahun Kurikulum</label>
                  <input type="text" class="form-control" id="add_kurikulum">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_kapasitas">Kapasitas</label>
                  <input type="number" class="form-control" id="add_kapasitas">
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Edit Master Kelas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="edit_name">Name</label>
                  <input type="text" class="form-control" id="edit_name">
                </div>
                <div class="form-group col-md-6">
                  <label for="edit_capacity">Capacity</label>
                  <input type="number" class="form-control" id="edit_capacity">
                </div>
              </div>
              <div class="form-group">
                <label for="edit_desc">Description</label>
                <input type="text" class="form-control" id="edit_desc">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="edit_submit">Submit</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Footer -->
    <?php include '../app/Views/others/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $(document).ready(function() {

        $('.btn-add').on('click', function() {
          $.ajax({
            url: '/admin/siakad/kelas/prepare',
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var options = '';
                var data = response.data;
                data.forEach(function(item) {
                  options += '<option value="' + item.course_id + '">' + item.course_name + '</option>';
                });
                $('#add_matkul').html(options);
                $('#addModal').modal('show');
              } else {
                console.log('Data tidak ditemukan');
              }
            }
          });
        });

        //add data
        $('#add_submit').on('click', function() {
          var arrayData = [{
            nama_kelas: $('#add_name').val(),
            mata_kuliah: $('#add_matkul').val(),
            tahun_kurikulum: $('#add_kurikulum').val(),
            kapasitas: $('#add_kapasitas').val()
          }];

          $.ajax({
            url: '/admin/siakad/kelas/add',
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
                  text: 'An error occurred during the add.',
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
        $('.btn-edit').on('click', function() {

          var id = $(this).data('id');
          $.ajax({
            url: '/admin/siakad/ruangan/fetch',
            type: 'POST',
            data: {
              id: id,
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;

                $('#edit_name').val(data.name);
                $('#edit_capacity').val(data.capacity);
                $('#edit_desc').val(data.description);

                $('#editModal').modal('show');

              } else {
                console.log('Data tidak ditemukan');
              }
            }
          });

          $('#edit_submit').on('click', function() {

            var arrayData = [{
              ID_ruangan: id,
              name: $('#edit_name').val(),
              capacity: $('#edit_capacity').val(),
              description: $('#edit_desc').val()
            }];

            console.log(arrayData);

            $.ajax({
              url: '/admin/siakad/ruangan/update',
              type: 'POST',
              contentType: 'application/json',
              data: JSON.stringify(arrayData),
              dataType: 'json',
              success: function(response) {
                console.log(response);
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

        //paging
        $('.table').DataTable({
          "paging": true,
          "searching": true,
          "ordering": true,
          "info": true
        });
      });
    </script>




</body>

</html>