<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SIAKAD - Ortu</title>
    <?php include '../app/Views/others/layouts/header.php'; ?>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

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
                            <div class="breadcrumb-item">Data Ortu</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Data Ortu</h4>
                                        <div class="card-header-action">
                                            <button class="btn btn-primary" id="confirmButton">Import Data</button>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Mahasiswa</th>
                                                    <th scope="col">Ayah</th>
                                                    <th scope="col">Ibu</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $key => $value) : ?>
                                                    <tr>
                                                        <th scope="row"><?= ++$key ?></th>
                                                        <td><?= $value->NamaLengkap ?></td>
                                                        <td><?= $value->nama_ayah ?></td>
                                                        <td><?= $value->nama_ibu ?></td>
                                                        <td>
                                                            <a class="btn btn-primary btn-action mr-1" data-toggle="modal" data-target="#editModal" data-recid="<?= $value->recid ?>"><i class="fas fa-pencil-alt"></i></a>
                                                            <a class="btn btn-danger btn-action"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
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
                        <h5 class="modal-title" id="editModalLabel">Edit Data Orang Tua</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="namaAyah">Nama Ayah</label>
                                    <input type="text" class="form-control" id="namaAyah" placeholder="Nama Ayah">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="namaIbu">Nama Ibu</label>
                                    <input type="text" class="form-control" id="namaIbu" placeholder="Nama Ibu">
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
                checkProgressClassOnLoad('confirmButton');

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
                                url: '/admin/siakad/mahasiswa/import-ortu',
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
                    var recid = $(this).data('recid');

                    $.ajax({
                        url: '/admin/siakad/ortu/fetch',
                        type: 'POST',
                        data: {
                            recid: recid
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                var data = response.data;
                                $('#namaAyah').val(data.nama_ayah);
                                $('#namaIbu').val(data.nama_ibu);
                            } else {
                                console.log('Data tidak ditemukan');
                            }
                        }
                    });

                    $('#submit').on('click', function() {

                        var arrayData = [{
                            recid: recid,
                            namaAyah: $('#namaAyah').val(),
                            namaIbu: $('#namaIbu').val()
                        }];
                        // console.log("🚀 ~ $ ~ arrayData:", arrayData)

                        $.ajax({
                            url: '/admin/siakad/ortu/update',
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify(arrayData),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        text: 'Your data has been updated.',
                                        icon: 'success',
                                        showConfirmButton: false, // Menyembunyikan tombol konfirmasi
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
        </script>
</body>

</html>