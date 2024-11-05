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
                          <th scope="col">Program Studi</th>
                          <th scope="col">Jenis Tagihan</th>
                          <th scope="col">Angkatan</th>
                          <th scope="col">Nominal</th>
                          <th scope="col">Keterangan</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value) : ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->prodi ?></td>
                            <td><?= $value->nama_tagihan ?></td>
                            <td><?= $value->angkatan ?></td>
                            <td><?= 'Rp. ' . number_format($value->nominal, 0, ',', '.') ?></td>
                            <td><?= $value->keterangan ?></td>
                            <td style="white-space: nowrap;">
                              <a class="btn btn-primary btn-action mr-1" id="btn-edit" data-id="<?= $value->recid ?>">
                                <i class="fas fa-pencil-alt"></i>
                              </a>
                              <a class="btn btn-danger btn-action mr-1" data-id="<?= $value->recid ?>" onclick="confirmDelete(this)">
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
                <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                <div class="card-body">
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="add_prodi">Program Studi</label>
                        <input type="text" class="form-control" id="add_prodi" name="prodi">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="add_jenis_tagihan">Jenis Tagihan</label>
                        <select id="add_jenis_tagihan" class="form-control" name="jenis_tagihan" required>
                        <option value="" selected disabled>Pilih Jenis Tagihan</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="add_angkatan">Angkatan</label>
                        <select id="add_angkatan" class="form-control" name="angkatan" required>
                        <option value="" selected disabled>Pilih Angkatan</option>
                        <option value="Semua Angkatan">Semua Angkatan</option>
                        <option value="Angkatan 2024">Angkatan 2024</option>
                        <option value="Angkatan 2023">Angkatan 2023</option>
                        <option value="Angkatan 2022">Angkatan 2022</option>
                        <option value="Angkatan 2021">Angkatan 2021</option>
                        <option value="Angkatan 2020">Angkatan 2020</option>
                        <option value="Angkatan 2019">Angkatan 2019</option>
                        <option value="Angkatan 2018">Angkatan 2018</option>
                        <option value="Angkatan 2017">Angkatan 2017</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="add_nominal">Nominal</label>
                        <input type="number" class="form-control" id="add_nominal" name="nominal">
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="add_keterangan">Keterangan</label>
                    <input type="text" class="form-control" id="add_keterangan" name="keterangan">
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_submit">Submit</button>
                </div>
            </form>
            </div>
        </div>
        </div>


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
                  <label for="prodi">Program Studi</label>
                  <input type="text" id="prodi" class="form-control" required>
                  </input>
                </div>
                <div class="form-group col-md-6">
                  <label for="jenis_tagihan">Jenis Tagihan</label>
                    <select id="jenis_tagihan" class="form-control" name="jenis_tagihan" required>
                    <option value="" selected disabled>Pilih Jenis Tagihan</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                <label for="angkatan">Angkatan</label>
                        <select id="angkatan" class="form-control" name="angkatan" required>
                        <option value="" selected disabled>Pilih Angkatan</option>
                        <option value="Semua Angkatan">Semua Angkatan</option>
                        <option value="Angkatan 2024">Angkatan 2024</option>
                        <option value="Angkatan 2023">Angkatan 2023</option>
                        <option value="Angkatan 2022">Angkatan 2022</option>
                        <option value="Angkatan 2021">Angkatan 2021</option>
                        <option value="Angkatan 2020">Angkatan 2020</option>
                        <option value="Angkatan 2019">Angkatan 2019</option>
                        <option value="Angkatan 2018">Angkatan 2018</option>
                        <option value="Angkatan 2017">Angkatan 2017</option>
                        </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="nominal">Nominal</label>
                  <input type="number" class="form-control" id="nominal">
                </div>
              </div>
                <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                  <input type="text" class="form-control" id="keterangan">
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
            url: '/admin/siakad/tagihan/include',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;
                var dataPaytype = data.dataPaytype;

                $('#add_jenis_tagihan').empty().append('<option value="" selected disabled>Pilih Jenis Tagihan</option>');

                $.each(dataPaytype, function(index, value) {
                  $('#add_jenis_tagihan').append('<option value="' + value.recid + '">' + value.nama_tagihan + '</option>');
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
              prodi: $('#add_prodi').val(),
              jenis_tagihan: $('#add_jenis_tagihan').val(),
              angkatan: $('#add_angkatan').val(),
              nominal: $('#add_nominal').val(),
              keterangan: $('#add_keterangan').val(),
            }];

            console.log(arrayData);

            $.ajax({
              url: '/admin/siakad/tagihan/add',
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
                    showConfirmButton: true,
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
            url: '/admin/siakad/tagihan/fetch',
            type: 'POST',
            data: {
              id: id
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;
                var dataPaytype = response.dataPaytype;
                var optionPaytype = response.optionPaytype;

                $('#jenis_tagihan').empty().append('<option value="' + dataPaytype.recid + '">' + dataPaytype.nama_tagihan + '</option>');

                $.each(optionPaytype, function(index, item) {
                  if (!$('#jenis_tagihan option[value="' + item.recid + '"]').length) {
                    $('#jenis_tagihan').append('<option value="' + item.recid + '">' + item.nama_tagihan + '</option>');
                  }
                });

                $('#prodi').val(data.prodi);
                $('#angkatan').val(data.angkatan);
                $('#nominal').val(data.nominal);
                $('#keterangan').val(data.keterangan);


                $('#editModal').modal('show');

              } else {
                console.log('Data tidak ditemukan');
              }
            }
          });

          $('#submit').on('click', function() {

            var arrayData = [{
              recid: id,
              prodi: $('#prodi').val(),
              jenis_tagihan: $('#jenis_tagihan').val(),
              angkatan: $('#angkatan').val(),
              nominal: $('#nominal').val(),
              keterangan: $('#keterangan').val()
            }];

            $.ajax({
              url: '/admin/siakad/tagihan/update',
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
              url: '/admin/siakad/tagihan/delete',
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

<script>
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