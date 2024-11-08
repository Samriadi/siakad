<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Paytype</title>
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
          <h1>Data Paytype</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Invoice</a></div>
            <div class="breadcrumb-item">Paytype</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Data Paytype</h4>
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
                          <th scope="col">Nama Tagihan</th>
                          <th scope="col">Periode Tagihan</th>
                          <th class="w-15">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($PembayaranData as $key => $value) : ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->nama_tagihan ?></td>
                            <td><?= $value->jenis_tagihan ?></td>
                            <td style="white-space: nowrap;">
                              <a class="btn btn-primary btn-action mr-1" data-toggle="modal" data-target="#editModal" data-id="<?= $value->recid ?>">
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
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_nama_tagihan">Nama Tagihan</label>
                  <input type="text" class="form-control" id="add_nama_tagihan">
                </div>
                <div class="form-group col-md-6">
                <label for="add_jenis_tagihan">Periode Tagihan</label>
                  <select class="form-control" id="add_jenis_tagihan">
                    <option value="Persemester">Persemester</option>
                    <option value="Sekali">Sekali</option>
                    <option value="Tertentu">Tertentu</option>
                  </select>
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
            <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nama_tagihan">Nama Tagihan</label>
                  <input type="text" class="form-control" id="nama_tagihan">
                </div>
                <div class="form-group col-md-6">
                  <label for="jenis_tagihan">Periode Tagihan</label>
                  <select class="form-control" id="jenis_tagihan">
                    <option value="Persemester">Persemester</option>
                    <option value="Sekali">Sekali</option>
                    <option value="Tertentu">Tertentu</option>
                  </select>
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
        // Add data
        $('#add_submit').on('click', function() {
        var arrayData = [{
            nama_tagihan: $('#add_nama_tagihan').val(),
            jenis_tagihan: $('#add_jenis_tagihan').val(),
        }];

        console.log(arrayData);

        $.ajax({
            url: '/admin/siakad/pembayaran/add',
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

        // Edit data
        $('.btn-action').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/admin/siakad/pembayaran/fetch',
            type: 'POST',
            data: {
            id: id
            },
            dataType: 'json',
            success: function(response) {
            if (response.success) {
                var data = response.data;
                $('#nama_tagihan').val(data.nama_tagihan);
                $('#jenis_tagihan').val(data.jenis_tagihan);
            } else {
                console.log('Data tidak ditemukan');
            }
            }
        });

        $('#submit').off('click').on('click', function() {
            var arrayData = [{
            id: id,
            nama_tagihan: $('#nama_tagihan').val(),
            jenis_tagihan: $('#jenis_tagihan').val()
            }];

            $.ajax({
            url: '/admin/siakad/pembayaran/update',
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
                    text: 'An error occurred during the update.',
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
            url: '/admin/siakad/pembayaran/delete',
            type: 'POST',
            data: { id: id },
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