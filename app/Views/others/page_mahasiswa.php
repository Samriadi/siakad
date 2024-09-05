<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SIAKAD - Mahasiswa</title>
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
                        <div class="breadcrumb-item">Data Mahasiswa</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Data Mahasiswa</h4>
                                    <div class="card-header-action">


                                        <button class="btn btn-primary" data-toggle="modal" data-target="#importCSVModal">Import CSV</button>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">NamaLengkap</th>
                                                <th scope="col">Nim</th>
                                                <th scope="col">Wa Number</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $key => $value) : ?>
                                                <tr>
                                                    <th scope="row"><?= ++$key ?></th>
                                                    <td><?= $value->NamaLengkap ?></td>
                                                    <td><?= $value->Nim ?></td>
                                                    <td><?= $value->WANumber ?></td>
                                                    <td><?= $value->alamat ?></td>
                                                    <td>
                                                        <!-- <a class="btn btn-primary btn-action mr-1" data-toggle="modal" data-target="#editModal" data-id="<?= $value->ID ?>"><i class="fas fa-pencil-alt"></i></a> -->
                                                        <a class="btn btn-danger btn-action mr-1" data-id="<?= $value->ID ?>" onclick="confirmDelete(this)">
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
            </section>
        </div>

    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="NamaLengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="NamaLengkap" placeholder="Nama Lengkap">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nim">NIM</label>
                                <input type="text" class="form-control" id="nim" placeholder="Nim">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" placeholder="Alamat">
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

    <!-- Modal -->
    <div class="modal fade" id="importCSVModal" tabindex="-1" role="dialog" aria-labelledby="importCSVModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importCSVModalLabel">Import CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="csvUploadForm" action="/admin/siakad/mahasiswa/importCSV" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="csvFile">Choose CSV File</label>
                            <input type="hidden" name="importCSV" value="true">
                            <input type="file" class="form-control" id="csvFile" name="file" accept=".csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload CSV</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <?php include '../app/Views/others/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            checkProgressClassOnLoad('confirmButton');

            //import csv
            $('#csvUploadForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                console.log(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Menampilkan pesan sukses atau error
                        console.log(response);
                        // Menutup modal setelah sukses
                        $('#importCSVModal').modal('hide');
                        // Reload halaman atau update tabel
                    },
                    error: function(response) {
                        alert('Failed to import CSV');
                    }
                });
            });

            //import data
            $('#confirmButton').click(function() {
                Swal.fire({
                    text: "Do you want to proceed with the import?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, import it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show a processing alert
                        Swal.fire({
                            text: 'Please wait while we process your request.',
                            icon: 'info',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                                addProgressClass('confirmButton');
                            }
                        });

                        // Perform AJAX request
                        $.ajax({
                            url: '/admin/siakad/mahasiswa/import',
                            method: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                Swal.close(); // Close the processing alert
                                removeProgressClass('confirmButton')

                                if (data.success) {
                                    Swal.fire({
                                        text: 'Your data has been imported.',
                                        icon: 'success',
                                        showConfirmButton: false, // Menyembunyikan tombol konfirmasi
                                        willClose: () => {
                                            window.location.reload(); // Reload halaman setelah modal ditutup
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        text: data.error || 'An error occurred during import.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.close(); // Close the processing alert
                                Swal.fire({
                                    text: 'An error occurred during the import: ' + error,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });

            //edit data
            $('.btn-action').on('click', function() {
                var id = $(this).data('id');

                // Mengirim ID ke server melalui AJAX
                $.ajax({
                    url: '/admin/siakad/mahasiswa/fetch',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var data = response.data;
                            $('#NamaLengkap').val(data.NamaLengkap);
                            $('#nim').val(data.Nim);
                            $('#alamat').val(data.alamat);

                        } else {
                            console.log('Data tidak ditemukan');
                        }
                    }
                });

                $('#submit').on('click', function() {

                    var arrayData = [{
                        id: id,
                        alamat: $('#alamat').val()
                    }];
                    // console.log("🚀 ~ $ ~ arrayData:", arrayData)

                    $.ajax({
                        url: '/admin/siakad/mahasiswa/update',
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
                        url: '/admin/siakad/mahasiswa/delete',
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