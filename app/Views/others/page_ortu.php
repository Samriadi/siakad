<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard</title>
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
                            <a href="#" class="btn btn-primary" id="importData">Import Data</a>
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

        <script>
                $(document).ready(function() {

                    $('#importData').click(function() {
                        $.ajax({
                            url: '/siakad/mahasiswa/import-ortu',
                            method: 'GET',
                            dataType: 'json', // Specify that you expect JSON data in response
                            success: function(data) {
                                console.log('Response:', data);
                                if (data.success) {
                                    console.log('Import successful');
                                } else {
                                    console.error('Import failed:', data.error);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                                console.log('Response Text:', xhr.responseText); // Log the response text for debugging
                            }
                        });
                    });


                });
        </script>
      
    </body>
</html>