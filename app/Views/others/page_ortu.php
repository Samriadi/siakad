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
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $key => $value) : ?>
                            <tr>
                                <th scope="row"><?= ++$key ?></th>
                                <td><?= $value->NamaLengkap ?></td>
                                <td><?= $value->nama_ayah ?></td>
                                <td><?= $value->nama_ibu ?></td>
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

        <!-- Footer -->
        <?php include '../app/Views/others/layouts/footer.php'; ?>

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            $(document).ready(function() {
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
                            }
                        });

                        // Perform AJAX request
                        $.ajax({
                            url: '/siakad/mahasiswa/import-ortu',
                            method: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                Swal.close(); // Close the processing alert
                                if (data.success) {
                                    Swal.fire({
                                        text: 'Your data has been imported.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload(); // Reload halaman setelah menekan OK
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
        });

    </script>
    </body>
</html>