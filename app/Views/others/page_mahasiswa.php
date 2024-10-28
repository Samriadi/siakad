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
            <h1>Data Mahasiswa</h1>
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
                        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#multiFormModal">
                           Add Data
                        </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#importCSVModal">Import CSV</button>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">Mahasiswa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Orang Tua</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                                <table class="table table-hover">
                                                    <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                                                        <tr>
                                                            <th scope="col">No</th>
                                                            <th scope="col">Nama Lengkap</th>
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
                                <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive" style="max-height: 400px;">
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
                                                        <?php foreach ($dataOrtu as $key => $value) : ?>
                                                            <tr>
                                                                <th scope="row"><?= ++$key ?></th>
                                                                <td><?= $value->NamaLengkap ?></td>
                                                                <td><?= $value->nama_ayah ?></td>
                                                                <td><?= $value->nama_ibu ?></td>
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
                </div>
            </div>
        </div>
    </section>



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

    <!-- Modal Structure -->
    <div class="modal fade" id="multiFormModal" tabindex="-1" role="dialog" aria-labelledby="multiFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"> <!-- Menambahkan modal-lg untuk memperlebar modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="multiFormModalLabel">Form Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="formTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="formMahasiswa-tab" data-toggle="tab" href="#formMahasiswa" role="tab" aria-controls="formMahasiswa" aria-selected="true">Mahasiswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="formOrangtua-tab" data-toggle="tab" href="#formOrangtua" role="tab" aria-controls="formOrangtua" aria-selected="false">Orangtua</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="formTabContent">
                        <!-- Form Mahasiswa -->
                        <div class="tab-pane fade show active" id="formMahasiswa" role="tabpanel" aria-labelledby="formMahasiswa-tab">
                            <form id="formMahasiswaContent">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tempatLahir">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempatLahir" name="tempatLahir" placeholder="Masukkan Tempat Lahir" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="tanggalLahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="jenkel">Jenis Kelamin</label>
                                        <select class="form-control" id="jenkel" name="jenkel" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="agama">Agama</label>
                                        <input type="text" class="form-control" id="agama" name="agama" placeholder="Masukkan Agama" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="kewarganegaraan">Kewarganegaraan</label>
                                        <input type="text" class="form-control" id="kewarganegaraan" name="kewarganegaraan" placeholder="Masukkan Kewarganegaraan" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nik">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nis">NIS</label>
                                        <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukkan NIS" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="rtrw">RT/RW</label>
                                        <input type="text" class="form-control" id="rtrw" name="rtrw" placeholder="Masukkan RT/RW" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text" class="form-control" id="kelurahan" name="kelurahan" placeholder="Masukkan Kelurahan" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" placeholder="Masukkan Kecamatan" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="kabupaten">Kabupaten</label>
                                        <input type="text" class="form-control" id="kabupaten" name="kabupaten" placeholder="Masukkan Kabupaten" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="propinsi">Propinsi</label>
                                        <input type="text" class="form-control" id="propinsi" name="propinsi" placeholder="Masukkan Propinsi" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="waNumber">Nomor WA</label>
                                        <input type="text" class="form-control" id="waNumber" name="waNumber" placeholder="Masukkan Nomor WA" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>


                        
                        <!-- Form Orangtua -->
                        <div class="tab-pane fade" id="formOrangtua" role="tabpanel" aria-labelledby="formOrangtua-tab">
                            <form id="formOrangtuaContent">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nama_ayah">Nama Ayah</label>
                                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Masukkan Nama Ayah">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nama_ibu">Nama Ibu</label>
                                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Masukkan Nama Ibu">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nik_ayah">NIK Ayah</label>
                                        <input type="text" class="form-control" id="nik_ayah" name="nik_ayah" placeholder="Masukkan NIK Ayah">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nik_ibu">NIK Ibu</label>
                                        <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" placeholder="Masukkan NIK Ibu">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="phone_ayah">No HP Ayah</label>
                                        <input type="text" class="form-control" id="phone_ayah" name="phone_ayah" placeholder="Masukkan No HP Ayah">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone_ibu">No HP Ibu</label>
                                        <input type="text" class="form-control" id="phone_ibu" name="phone_ibu" placeholder="Masukkan No HP Ibu">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="tglahir_ayah">Tanggal Lahir Ayah</label>
                                        <input type="date" class="form-control" id="tglahir_ayah" name="tglahir_ayah">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tglahir_ibu">Tanggal Lahir Ibu</label>
                                        <input type="date" class="form-control" id="tglahir_ibu" name="tglahir_ibu">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="agama_ayah">Agama Ayah</label>
                                        <input type="text" class="form-control" id="agama_ayah" name="agama_ayah" placeholder="Masukkan Agama Ayah">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="agama_ibu">Agama Ibu</label>
                                        <input type="text" class="form-control" id="agama_ibu" name="agama_ibu" placeholder="Masukkan Agama Ibu">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="job_ayah">Pekerjaan Ayah</label>
                                        <input type="text" class="form-control" id="job_ayah" name="job_ayah" placeholder="Masukkan Pekerjaan Ayah">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="job_ibu">Pekerjaan Ibu</label>
                                        <input type="text" class="form-control" id="job_ibu" name="job_ibu" placeholder="Masukkan Pekerjaan Ibu">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="salary_ayah">Penghasilan Ayah</label>
                                        <input type="number" class="form-control" id="salary_ayah" name="salary_ayah" placeholder="Masukkan Penghasilan Ayah">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="salary_ibu">Penghasilan Ibu</label>
                                        <input type="number" class="form-control" id="salary_ibu" name="salary_ibu" placeholder="Masukkan Penghasilan Ibu">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="alamat_ayah">Alamat Ayah</label>
                                        <input type="text" class="form-control" id="alamat_ayah" name="alamat_ayah" placeholder="Masukkan Alamat Ayah">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="alamat_ibu">Alamat Ibu</label>
                                        <input type="text" class="form-control" id="alamat_ibu" name="alamat_ibu" placeholder="Masukkan Alamat Ibu">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitForms()">Simpan</button>
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

            console.log(id)

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

    <script>
        function submitForms() {
            // Collect data from both forms
            const formMahasiswaData = new FormData(document.getElementById('formMahasiswaContent'));
            const formOrangtuaData = new FormData(document.getElementById('formOrangtuaContent'));

            // Combine the two FormData objects
            const combinedData = new FormData();
            formMahasiswaData.forEach((value, key) => combinedData.append(key, value));
            formOrangtuaData.forEach((value, key) => combinedData.append(key, value));

            // AJAX request to save data
            $.ajax({
                url: '/admin/siakad/mahasiswa/add', // URL to your controller method
                type: 'POST',
                data: combinedData,
                processData: false, // Important for FormData
                contentType: false,  // Important for FormData
                success: function(response) {
                    // Handle success response
                    console.log('Data saved successfully:', response);
                    Swal.fire(
                                    'Success!',
                                    'The record has been added.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle error response
                    console.error('Error saving data:', textStatus, errorThrown);
                    Swal.fire(
                                    'Error!',
                                    'There was an issue adding the record.',
                                    'error'
                                );
                }
            });
        }

   

    </script>

    <script>
        $(document).ready(function () {
            $('.table').DataTable({
                "paging": true,        // Menampilkan pagination
                "searching": true,     // Menampilkan search box
                "ordering": true,      // Menampilkan sorting
                "info": true          // Menampilkan informasi jumlah data
            });
        });
    </script>

    </body>

</html>