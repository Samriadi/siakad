<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Schedule</title>
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
          <h1>Schedule</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Schedule</a></div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Schedule</h4>
                  <div class="card-header-action">
                    <a class="btn btn-primary btn-add" data-toggle="modal" data-target="#addModal">
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
                          <th scope="col">Ruangan</th>
                          <th scope="col">Mata Kuliah</th>
                          <th scope="col">SKS</th>
                          <th scope="col">Hari</th>
                          <th scope="col">Jam Mulai</th>
                          <th scope="col">Jam Selesai</th>
                          <th scope="col">Dosen</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($ScheduleData as $key => $value):
                          ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->nama_ruangan ?></td>
                            <td><?= $value->nama_matkul ?></td>
                            <td><?= $value->jumlah_sks ?></td>
                            <td><?= $value->hari ?></td>
                            <td><?= $value->jam_mulai ?></td>
                            <td><?= $value->jam_selesai ?></td>
                            <td><?= $value->nama_dosen ?></td>

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
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
      aria-hidden="true">
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
                  <label for="add_ruangan">Ruangan</label>
                  <select class="form-control" id="add_ruangan">
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="add_mata_kuliah">Mata Kuliah</label>
                  <select class="form-control" id="add_mata_kuliah">
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_sks">Jumlah SKS</label>
                  <input type="number" class="form-control" id="add_sks">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_hari">Hari</label>
                  <select class="form-control" id="add_hari">
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_jam_mulai">Jam Mulai</label>
                  <input type="time" class="form-control" id="add_jam_mulai">
                </div>
                <div class="form-group col-md-6">
                  <label for="add_jam_selesai">Jam Selesai</label>
                  <input type="time" class="form-control" id="add_jam_selesai">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="add_dosen">Dosen</label>
                  <select class="form-control" id="add_dosen">
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


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
      aria-hidden="true">
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
                <label for="nama_tagihan">Nama Tagihan</label>
                <input type="text" class="form-control" id="nama_tagihan">
              </div>
              <br>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="catgy_tagihan">Kategori</label>
                  <select class="form-control" id="catgy_tagihan">
                    <option value="Semester">Persemester</option>
                    <option value="Berulang">Berulang</option>
                    <option value="Sekali">Sekali Saja</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="jenis_tagihan">Syarat KRS</label>
                  <select class="form-control" id="jenis_tagihan">
                    <option value="KRS">Ya</option>
                    <option value="General">Tidak</option>
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
      $(document).ready(function () {

        $('.btn-add').on('click', function () {
          $.ajax({
            url: '/admin/siakad/schedule/prepare',
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function (response) {
              $('#add_ruangan').empty().append('<option value="">Pilih Ruangan</option>');
              $('#add_mata_kuliah').empty().append('<option value="">Pilih Mata Kuliah</option>');
              $('#add_dosen').empty().append('<option value="">Pilih Dosen</option>');

              // Tambahkan data ruangan ke dropdown
              $.each(response.dataRuangan, function (index, item) {
                $('#add_ruangan').append('<option value="' + item.ID_ruangan + '">' + item.name + '</option>');
              });

              // Tambahkan data mata kuliah ke dropdown
              $.each(response.dataMataKuliah, function (index, item) {
                $('#add_mata_kuliah').append('<option value="' + item.course_id + '" data-credits="' + item.credits + '">' + item.course_name + '</option>');
              });

              $('#add_mata_kuliah').on('change', function () {
                var selectedOption = $(this).find(':selected');
                var credits = selectedOption.attr('data-credits');
                $('#add_sks').val(credits);
              });


              // Tambahkan data dosen ke dropdown
              $.each(response.dataDosen, function (index, item) {
                $('#add_dosen').append('<option value="' + item.recid + '">' + item.Nama + '</option>');
              })

              let days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
              let select = $("#add_hari");

              days.forEach(function (day) {
                select.append(`<option value="${day}">${day}</option>`);
              });
            }
          });
        });

        //add data
        $('#add_submit').on('click', function () {
          var arrayData = [{
            ruangan: $('#add_ruangan').val(),
            matkul: $('#add_mata_kuliah').val(),
            sks: $('#add_sks').val(),
            hari: $('#add_hari').val(),
            jam_mulai: $('#add_jam_mulai').val(),
            jam_selesai: $('#add_jam_selesai').val(),
            dosen: $('#add_dosen').val(),
          }];

          console.log(arrayData);

          $.ajax({
            url: '/admin/siakad/schedule/add',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(arrayData),
            dataType: 'json',
            success: function (response) {
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
            error: function (jqXHR, textStatus, errorThrown) {
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

      // Edit data
      $('.btn-action').on('click', function () {
        var id = $(this).data('id');

        $.ajax({
          url: '/admin/siakad/pembayaran/fetch',
          type: 'POST',
          data: {
            id: id
          },
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              var data = response.data;
              $('#nama_tagihan').val(data.nama_tagihan);
              $('#jenis_tagihan').val(data.jenis_tagihan);
              $('#catgy_tagihan').val(data.catgy_tagihan);
            } else {
              console.log('Data tidak ditemukan');
            }
          }
        });

        $('#submit').off('click').on('click', function () {
          var arrayData = [{
            id: id,
            nama_tagihan: $('#nama_tagihan').val(),
            jenis_tagihan: $('#jenis_tagihan').val(),
            catgy_tagihan: $('#catgy_tagihan').val()
          }];

          $.ajax({
            url: '/admin/siakad/pembayaran/update',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(arrayData),
            dataType: 'json',
            success: function (response) {
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
              data: {
                id: id
              },
              success: function (response) {
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
              error: function () {
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
      $(document).ready(function () {
        $('.table').DataTable({
          "paging": true,
          "searching": true,
          "ordering": true,
          "info": true
        });
      });
    </script>

    <script>
      function hitungJamSelesai() {
        let jamMulai = document.getElementById("add_jam_mulai").value;
        let sks = parseInt(document.getElementById("add_sks").value) || 0; // Ambil nilai SKS

        if (jamMulai && sks > 0) {
          let [jam, menit] = jamMulai.split(":").map(Number);

          // Hitung durasi berdasarkan SKS (1 SKS = 50 menit)
          let tambahanMenit = sks * 50;
          menit += tambahanMenit;

          if (menit >= 60) {
            jam += Math.floor(menit / 60);
            menit = menit % 60;
          }

          // Format hasil ke dalam 2 digit
          let jamSelesai = `${String(jam).padStart(2, "0")}:${String(menit).padStart(2, "0")}`;
          document.getElementById("add_jam_selesai").value = jamSelesai;
        }
      }

      // Saat mata kuliah dipilih, isi add_sks otomatis
      $('#add_mata_kuliah').on('change', function () {
        var selectedOption = $(this).find(':selected');
        var credits = selectedOption.attr('data-credits'); // Ambil nilai SKS dari data-credits
        $('#add_sks').val(credits).trigger('change'); // Isi add_sks & trigger change agar jam selesai ikut berubah
      });

      // Saat SKS atau Jam Mulai berubah, hitung ulang jam selesai
      $('#add_sks, #add_jam_mulai').on('change input', hitungJamSelesai);
    </script>






</body>

</html>