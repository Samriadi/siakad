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
                            <td><?= $value->nama_prodi ?></td>
                            <td><?= $value->nama_tagihan ?></td>
                            <td><?= $value->nama_angkatan ?></td>
                            <td><?= 'Rp. ' . number_format($value->nominal, 0, ',', '.') ?></td>
                            <td><?= $value->keterangan ?></td>
                            <td style="white-space: nowrap;">

                              <a class="btn btn-primary btn-action mr-1 btn-edit" data-id="<?= $value->recid ?>">
                                <i class="fas fa-pencil-alt"></i>
                              </a>

                              <a class="btn btn-danger btn-action mr-1" data-id="<?= $value->recid ?>"  onclick="confirmDelete(this)">
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
                        <select id="add_prodi" class="form-control" name="prodi" required>
                        <option value="" selected disabled>Pilih Prodi</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">						
                        <label for="add_angkatan">Angkatan</label>
                        <select id="add_angkatan" class="form-control" name="angkatan" required>
                        <option value="" selected disabled>Pilih Angkatan</option>
                        </select>						
                    </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="add_jenis_tagihan">Jenis Tagihan</label>
                        <select id="add_jenis_tagihan" class="form-control" name="jenis_tagihan" required>
                        <option value="" selected disabled>Pilih Jenis Tagihan</option>
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
                  <select id="prodi" class="form-control" name="prodi" required>
                    <option value="" selected disabled>Pilih Prodi</option>
                  </select>
                </div>
                <div class="form-group col-md-6">				  
                  <label for="angkatan">Angkatan</label>
                  <select id="angkatan" class="form-control" name="angkatan" required>
                    <option value="" selected disabled>Pilih Angkatan</option>
                  </select>				  
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="jenis_tagihan">Jenis Tagihan</label>
                    <select id="jenis_tagihan" class="form-control" name="jenis_tagihan" required>
                    <option value="" selected disabled>Pilih Jenis Tagihan</option>
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
                var dataProdi = data.dataProdi;
                var dataAngkatan = data.dataAngkatan;

                $('#add_prodi').empty().append('<option value="" selected disabled>Pilih Prodi</option>');

                $.each(dataProdi, function(index, value) {
                  $('#add_prodi').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
                });

                $('#add_jenis_tagihan').empty().append('<option value="" selected disabled>Pilih Jenis Tagihan</option>');

                $.each(dataPaytype, function(index, value) {
                  $('#add_jenis_tagihan').append('<option value="' + value.recid + '">' + value.nama_tagihan + '</option>');
                });

                $('#add_angkatan').empty().append('<option value="" selected disabled>Pilih Angkatan</option>');

                // Tambahkan opsi "Semua Angkatan" di awal
                $('#add_angkatan').append('<option value="Semua Angkatan">Semua Angkatan</option>');

                $.each(dataAngkatan, function(index, value) {
                  $('#add_angkatan').append('<option value="' + value.ID_angkatan + '">' + value.nama + '</option>');
                });


                $('#addModal').modal('show');

              } else {
                console.log('Data tidak ditemukan');
              }
            },
            error: function(xhr, status, error) {
              console.log('Respon False: ' + error);
            }
          });

        });

        $('#add_submit').on('click', async function(event) {
          event.preventDefault(); 
          
          // Ambil data dari input dan buat array
          var arrayData = [{
              prodi: $('#add_prodi').val(),
              jenis_tagihan: $('#add_jenis_tagihan').val(),
              angkatan: $('#add_angkatan').val(),
              nominal: $('#add_nominal').val(),
              keterangan: $('#add_keterangan').val(),
          }];

          try {
              let response = await $.ajax({
                  url: '/admin/siakad/tagihan/add',
                  type: 'POST',
                  contentType: 'application/json',
                  data: JSON.stringify(arrayData),
                  dataType: 'json',
              });

              if (response.success) {
                  await Swal.fire(
                      'Added!',
                      response.message,  
                      'success'
                  ).then(() => {
                      location.reload(); 
                  });
              } else {
                  await Swal.fire({
                      text: response.message, 
                      icon: 'warning',
                      confirmButtonText: 'OK'
                  });
              }

          } catch (error) {
              console.error('AJAX Error:', error);
              await Swal.fire({
                  text: 'An unexpected error occurred.',
                  icon: 'error',
                  confirmButtonText: 'OK'
              });
          }
      });




        //edit data
        $('.btn-edit').on('click', function() {

          var data = <?php echo json_encode($data) ?>;
          
          var id = $(this).data('id');


          $.ajax({
            url: '/admin/siakad/tagihan/fetch',
            type: 'POST',
            data: {
              id: id,
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;
                var dataPaytype = response.dataPaytype;
                var optionPaytype = response.optionPaytype;
                var dataProdi = response.dataProdi;
                var optionProdi = response.optionProdi;
                var dataAngkatan = response.dataAngkatan;
                var optionAngkatan = response.optionAngkatan;

                var optionAngkatan = response.optionAngkatan;
                $('#prodi').empty().append('<option value="' + dataProdi.ID + '">' + dataProdi.deskripsi + '</option>');

                $.each(optionProdi, function(index, item) {
                  if (!$('#prodi option[value="' + item.ID + '"]').length) {
                    $('#prodi').append('<option value="' + item.ID + '">' + item.deskripsi + '</option>');
                  }
                });

                $('#jenis_tagihan').empty().append('<option value="' + dataPaytype.recid + '">' + dataPaytype.nama_tagihan + '</option>');

                $.each(optionPaytype, function(index, item) {
                  if (!$('#jenis_tagihan option[value="' + item.recid + '"]').length) {
                    $('#jenis_tagihan').append('<option value="' + item.recid + '">' + item.nama_tagihan + '</option>');
                  }
                });

                $('#angkatan').empty();


                // Jika ada dataAngkatan, tambahkan opsi yang dipilih terlebih dahulu
                if (dataAngkatan) {
                    $('#angkatan').append('<option value="' + dataAngkatan.ID_angkatan + '" selected>' + dataAngkatan.nama + '</option>');
                    $('#angkatan').append('<option value="Semua Angkatan">Semua Angkatan</option>');
                } else {
                    // Jika tidak ada dataAngkatan, hanya tambahkan opsi "Semua Angkatan" sebagai default
                    $('#angkatan').append('<option value="Semua Angkatan">Semua Angkatan</option>');
                }

                // Tambahkan opsi lainnya dari optionAngkatan, hindari duplikat
                $.each(optionAngkatan, function(index, item) {
                    if (!$('#angkatan option[value="' + item.ID_angkatan + '"]').length) {
                        $('#angkatan').append('<option value="' + item.ID_angkatan + '">' + item.nama + '</option>');
                    }
                });


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