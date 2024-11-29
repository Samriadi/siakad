<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Prodi</title>
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
          <h1>Data Prodi</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Invoice</a></div>
            <div class="breadcrumb-item">Data Prodi</div>
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
                  <div class="table-responsive" style="max-height: 770px; overflow-y: auto;">
                    <table class="table table-hover">
                      <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Deskripsi</th>
                          <th scope="col">Fakultas</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value) : ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->name ?></td>
                            <td><?= $value->deskripsi ?></td>
                            <td><?= $value->nama_fakultas ?></td>
                            <td style="white-space: nowrap;">

                              <a class="btn btn-primary btn-action mr-1 btn-edit" data-id="<?= $value->ID ?>">
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


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name">Nama</label>
                  <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group col-md-6">
                  <label for="deskripsi">Deskripsi</label>
                  <input type="text" class="form-control" id="deskripsi">
                </div>
              </div>
              <div class="form-group">
                <label for="fakultas">Fakultas</label>
                <select id="fakultas" class="form-control" name="fakultas" required>
                  <option value="" selected disabled>Pilih Fakultas</option>
                </select>
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
      //edit data
      $('.btn-edit').on('click', function() {

        var id = $(this).data('id');

        console.log(id)


        $.ajax({
          url: '/admin/siakad/prodi/fetch',
          type: 'POST',
          data: {
            id: id,
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              var data = response.data;
              var dataFakultas = response.dataFakultas;
              var optionFakultas = response.optionFakultas;


              $('#fakultas').empty().append('<option value="' + dataFakultas.ID + '">' + dataFakultas.deskripsi + '</option>');

              $.each(optionFakultas, function(index, item) {
                if (!$('#fakultas option[value="' + item.ID + '"]').length) {
                  $('#fakultas').append('<option value="' + item.ID + '">' + item.deskripsi + '</option>');
                }
              });



              $('#name').val(data.name);
              $('#deskripsi').val(data.deskripsi);


              $('#editModal').modal('show');

            } else {
              console.log('Data tidak ditemukan');
            }
          }
        });

        $('#submit').on('click', function() {

          var arrayData = [{
            ID: id,
            name: $('#name').val(),
            deskripsi: $('#deskripsi').val(),
            fakultas: $('#fakultas').val()
          }];

          $.ajax({
            url: '/admin/siakad/prodi/update',
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


      $(document).ready(function() {
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