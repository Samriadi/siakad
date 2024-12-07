<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Transaksi Tagihan</title>
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
          <h1>Transaksi Tagihan</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Invoice</a></div>
            <div class="breadcrumb-item">Transaksi Tagihan</div>
          </div>
        </div>
        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <!-- Select Field -->
                    <div class="col-12 col-md-5 col-lg-5">
                      <div class="form-group">
                        <label>Column Select</label>
                        <select id="show_field" name="show_field" class="form-control">
                          <option value="" selected disabled>-- Pilih Column --</option>
                        </select>
                      </div>
                    </div>
                    <!-- Select Value -->
                    <div class="col-12 col-md-5 col-lg-5">
                      <div class="form-group">
                        <label>Value Select</label>
                        <select id="show_value" name="show_value" class="form-control">
                          <option value="" selected disabled>Pilih Value</option>
                        </select>
                      </div>
                    </div>
                    <!-- Filter Button -->
                    <div class="col-12 col-md-5 col-lg-2 text-right">
                      <button class="btn btn-primary" id="filter">
                        <i class="fas fa-search text-white"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-header-action">
                    <a class="btn btn-primary" id="btn-add">
                      <i class="fas fa-plus text-white"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="exampleTable" class="table table-hover">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="checkAll"></th>
                          <th>No</th>
                          <th>NIM</th>
                          <th>Fakultas</th>
                          <th>Prodi</th>
                          <th>Tagihan</th>
                          <th>Angkatan</th>
                          <th>Nominal</th>
                          <th>Quantity</th>
                          <th>Type</th>
                          <th>Keterangan</th>
                          <th>Adjustment</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($data) : ?>
                          <?php foreach ($data as $key => $value) : ?>
                            <tr>
                              <td>
                                <input type="checkbox" class="check-item" value="<?= $value->recid ?>">
                              </td>
                              <td><?= $key + 1 ?></td>
                              <td><?= $value->nim ?></td>
                              <td><?= $value->nama_fakultas ?></td>
                              <td><?= $value->nama_prodi ?></td>
                              <td><?= $value->nama_tagihan ?></td>
                              <td><?= $value->nama_angkatan ?></td>
                              <td>Rp. <?= number_format($value->nominal, 0, ',', '.') ?>
                              <td><?= $value->qty ?></td>
                              <td><?= $value->adj_type ?></td>
                              <td><?= $value->keterangan ?></td>
                              <td><?= $value->adjustment ?></td>
                              <td>
                                <a class="btn btn-primary btn-sm btn-action mr-1 btn-edit" data-id="<?= $value->recid ?>">
                                  <i class="fas fa-pencil-alt"></i>
                                </a>
                              </td>
                            </tr>
                          <?php endforeach ?>
                        <?php else : ?>
                          <tr>
                            <td colspan="13" class="text-center">Tidak ada data yang tersedia.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                    <button id="deleteSelected" class="btn btn-danger mt-2 mb-3">Delete Selected</button>
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
            <h5 class="modal-title" id="addModalLabel">Add Adjustment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="addForm">
            <div class="modal-body">
              <div class="card-body">
                <!-- <div style="border-top:2px solid #abb2b9; border-bottom:2px solid #abb2b9; 
				  margin-bottom: 20px; padding-top:10px;"> -->

                <!-- <div class="form-row"> -->
                <!-- <div class="form-group col-md-6">
                      <label for="add_nim">NIM</label>
                      <input type="text" class="form-control" id="add_nim" name="nim">
                      (Lebih dari 1 orang, pisahkan dengan Koma)
                    </div> -->
                <!-- <div class="form-group col-md-6">
                      <center><label for="adj_type">Replace Tagihan</label></center>
                      <input type="checkbox" class="form-control" id="adj_type" name="adj_type" value="replace">
                    </div> -->
                <!-- </div> -->

                <div class="form-group">
                  <label for="add_fakultas">Fakultas</label>
                  <select id="add_fakultas" class="form-control" name="fakultas" required>
                    <option value="" selected disabled></option>
                  </select>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="add_prodi">Program Studi</label>
                    <select id="add_prodi" class="form-control" name="prodi" required>
                      <option value="" selected disabled></option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="add_angkatan">Angkatan</label>
                    <select id="add_angkatan" class="form-control" name="angkatan" required>
                      <option value="" selected disabled></option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="add_nim">NIM</label>
                    <input type="text" class="form-control" id="add_nim" name="nim">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="add_jenis_tagihan">Jenis Tagihan</label>
                    <select id="add_jenis_tagihan" class="form-control" name="jenis_tagihan" required>
                      <option value="" selected disabled></option>
                    </select>
                  </div>
                </div>
                <!-- </div> -->



                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="add_nominal">Nominal</label>
                    <input type="number" class="form-control" id="add_nominal" name="nominal" disabled>
                    <small class="form-text text-danger" id="nominalValidation">nominal tagihan tidak ada!</small>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="add_qty">Quantity</label>
                    <input type="number" class="form-control" id="add_qty" name="qty">
                  </div>
                </div>

                <div class="form-group">
                  <label for="add_keterangan">Keterangan</label>
                  <input type="text" class="form-control" id="add_keterangan" name="keterangan">
                </div>
                <div class="form-group">
                  <!--
                  <label for="add_adjustment">Adjustment</label>
                  <input type="number" class="form-control" id="add_adjustment" name="adjust">
				-->
                  <input type="hidden" id="add_adjustment" name="adjust">
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
                  <label for="fakultas">Fakultas</label>
                  <select id="fakultas" class="form-control" name="fakultas" required>
                    <option value="" selected disabled>Pilih Fakultas</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="prodi">Program Studi</label>
                  <select id="prodi" class="form-control" name="prodi" required>
                    <option value="" selected disabled>Pilih Prodi</option>
                  </select>
                </div>

                <!-- <div class="form-group col-md-6">
                  <center><label for="adjtype">Replace Tagihan</label></center>
                  <input type="checkbox" class="form-control" id="adjtype">
                </div> -->
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="angkatan">Angkatan</label>
                  <select id="angkatan" class="form-control" name="angkatan" required>
                    <option value="" selected disabled>Pilih Angkatan</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="add_nim">NIM</label>
                  <input type="text" class="form-control" id="nim">
                  (Lebih dari 1 orang, pisahkan dengan Koma)
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
                  <input type="number" class="form-control" id="nominal" disabled>
                  <small class="form-text text-danger" id="nominalEditValidation">nominal tagihan tidak ada!</small>

                </div>

              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="qty">Quantity</label>
                  <input type="number" class="form-control" id="qty">
                </div>
                <div class="form-group col-md-6">
                  <label for="adjustment">Adjustment</label>
                  <input type="number" class="form-control" id="adjustment">
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
          $('#add_submit').prop('disabled', true);
          nominalValidation.style.display = "none";

          $.ajax({
            url: '/admin/siakad/adjustment/include',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                var data = response.data;
                var dataPaytype = data.dataPaytype;
                var dataProdi = data.dataProdi;
                var dataAngkatan = data.dataAngkatan;
                var dataFakultas = data.dataFakultas;

                $('#add_fakultas').empty().append('<option value="" selected disabled></option>');
                $.each(dataFakultas, function(index, value) {
                  $('#add_fakultas').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
                });

                // Event onchange untuk memfilter prodi berdasarkan fakultas
                $('#add_fakultas').on('change', function() {
                  let selectedFakultas = $(this).val(); // Ambil ID fakultas yang dipilih

                  $('#add_prodi').empty();

                  $.each(dataProdi, function(index, value) {
                    if (value.name == 'ALL') {
                      $('#add_prodi').append('<option value="' + value.ID + '" selected>' + value.deskripsi + '</option>');
                    }
                  });

                  // Tambahkan opsi lainnya berdasarkan fakultas yang dipilih
                  $.each(dataProdi, function(index, value) {
                    if (value.fakultas == selectedFakultas && value.name != 'ALL') {
                      $('#add_prodi').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
                    }
                  });

                });


                $('#add_jenis_tagihan').empty().append('<option value="" selected disabled></option>');

                // Menggunakan Set untuk melacak jenis tagihan unik
                let uniqueTagihan = new Set();

                $.each(dataPaytype, function(index, value) {
                  if (!uniqueTagihan.has(value.jenis_tagihan)) {
                    uniqueTagihan.add(value.jenis_tagihan); // Tambahkan ke Set
                    $('#add_jenis_tagihan').append('<option value="' + value.jenis_tagihan + '">' + value.nama_tagihan + '</option>');
                  }
                });



                $('#add_angkatan').empty().append('<option value="" selected disabled></option>');

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

        function updateNominal() {
          var selectedFakultas = $('#add_fakultas').val();
          var selectedProdi = $('#add_prodi').val();
          var selectedAngkatan = $('#add_angkatan').val();
          var selectedPaytype = $('#add_jenis_tagihan').val();

          if (selectedFakultas && selectedProdi && selectedAngkatan && selectedPaytype) {
            $.ajax({
              url: '/admin/siakad/adjustment/getNominal', // Endpoint yang dibuat
              type: 'GET',
              data: {
                fakultas: selectedFakultas,
                prodi: selectedProdi,
                angkatan: selectedAngkatan,
                paytype: selectedPaytype
              },
              dataType: 'json',
              success: function(response) {

                if (response.success) {
                  $('#add_nominal').val(response.nominal);
                  $('#add_submit').prop('disabled', false);
                  nominalValidation.style.display = "none";

                } else {
                  $('#add_nominal').val('');
                  nominalValidation.style.display = "block";
                  $('#add_submit').prop('disabled', true);

                }
              },
              error: function(xhr, status, error) {
                console.log('Error:', error);
              }
            });
          }
        }

        // Tambahkan event listener pada dropdown
        $('#add_fakultas').on('change', updateNominal);
        $('#add_prodi').on('change', updateNominal);
        $('#add_angkatan').on('change', updateNominal);
        $('#add_jenis_tagihan').on('change', updateNominal);

        $('#add_submit').on('click', async function(event) {
          event.preventDefault();

          // Ambil data dari input dan buat array
          var arrayData = [{
            fakultas: $('#add_fakultas').val(),
            prodi: $('#add_prodi').val(),
            jenis_tagihan: $('#add_jenis_tagihan').val(),
            angkatan: $('#add_angkatan').val(),
            nominal: $('#add_nominal').val(),
            keterangan: $('#add_keterangan').val(),
            nim: $('#add_nim').val(),
            adj_type: $('#adj_type').prop('checked') ? "replace" : "normal",
            adjust: 0,
            qty: $('#add_qty').val(),

          }];

          try {
            let response = await $.ajax({
              url: '/admin/siakad/adjustment/add',
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
        $(document).on('click', '.btn-edit', function() {
          $('#edit_submit').prop('disabled', true);
          nominalEditValidation.style.display = "none";

          var id = $(this).data('id');


          $.ajax({
            url: '/admin/siakad/adjustment/fetch',
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
                var dataFakultas = response.dataFakultas;
                var optionFakultas = response.optionFakultas;


                $('#fakultas').empty().append('<option value="' + dataFakultas.ID + '">' + dataFakultas.deskripsi + '</option>');

                $.each(optionFakultas, function(index, item) {
                  if (!$('#fakultas option[value="' + item.ID + '"]').length) {
                    $('#fakultas').append('<option value="' + item.ID + '">' + item.deskripsi + '</option>');
                  }
                });

                $('#prodi').empty().append('<option value="' + dataProdi.ID + '">' + dataProdi.deskripsi + '</option>');

                $.each(optionProdi, function(index, item) {
                  if (!$('#prodi option[value="' + item.ID + '"]').length) {
                    $('#prodi').append('<option value="' + item.ID + '">' + item.deskripsi + '</option>');
                  }
                });

                $('#jenis_tagihan').empty().append('<option value="' + dataPaytype.jenis_tagihan + '">' + dataPaytype.nama_tagihan + '</option>');

                $.each(optionPaytype, function(index, item) {
                  if (!$('#jenis_tagihan option[value="' + item.jenis_tagihan + '"]').length) {
                    $('#jenis_tagihan').append('<option value="' + item.jenis_tagihan + '">' + item.nama_tagihan + '</option>');
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
                $('#qty').val(data.qty);
                $('#keterangan').val(data.keterangan);
                $('#nim').val(data.nim);
                $('#adjustment').val(data.adjustment);


                // if (data.adj_type === "replace") {
                //   $('#adjtype').prop('checked', true); // Centang checkbox
                // } else {
                //   $('#adjtype').prop('checked', false); // Tidak dicentang
                // }


                $('#editModal').modal('show');

              } else {
                console.log('Data tidak ditemukan');
              }
            }
          });

          function editNominal() {
            var selectedProdi = $('#prodi').val();
            var selectedAngkatan = $('#angkatan').val();
            var selectedPaytype = $('#jenis_tagihan').val();
            var selectedFakultas = $('#fakultas').val();

            console.log(selectedAngkatan);
            console.log(selectedProdi);
            console.log(selectedPaytype);
            console.log(selectedFakultas);


            if (selectedFakultas && selectedProdi && selectedAngkatan && selectedPaytype) {
              $.ajax({
                url: '/admin/siakad/adjustment/getNominal',
                type: 'GET',
                data: {
                  prodi: selectedProdi,
                  angkatan: selectedAngkatan,
                  paytype: selectedPaytype,
                  fakultas: selectedFakultas
                },
                dataType: 'json',
                success: function(response) {

                  console.log(response);
                  if (response.success) {
                    $('#nominal').val(response.nominal);
                    $('#add_submit').prop('disabled', false);
                    nominalEditValidation.style.display = "none";
                  } else {
                    $('#nominal').val('');
                    nominalEditValidation.style.display = "block";
                    $('#add_submit').prop('disabled', true);
                  }
                },
                error: function(xhr, status, error) {
                  console.log('Error:', error);
                }
              });
            }
          }

          // Tambahkan event listener pada dropdown
          $('#prodi').on('change', editNominal);
          $('#angkatan').on('change', editNominal);
          $('#jenis_tagihan').on('change', editNominal);
          $('#fakultas').on('change', editNominal);

          $('#submit').on('click', function() {

            var arrayData = [{
              recid: id,
              fakultas: $('#fakultas').val(),
              prodi: $('#prodi').val(),
              jenis_tagihan: $('#jenis_tagihan').val(),
              angkatan: $('#angkatan').val(),
              nominal: $('#nominal').val(),
              qty: $('#qty').val(),
              keterangan: $('#keterangan').val(),
              nim: $('#nim').val(),
              adjustment: $('#adjustment').val()
              // adjtype: $('#adjtype').prop('checked') ? "replace" : "normal"
            }];

            console.log(arrayData);


            $.ajax({
              url: '/admin/siakad/adjustment/update',
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
                    timer: 700,
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
              url: '/admin/siakad/adjustment/delete',
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
      // Ceklis All
      $('#checkAll').click(function() {
        $('.check-item').prop('checked', $(this).prop('checked'));
      });

      // Tombol Delete
      $('#deleteSelected').click(function() {
        let selectedIds = [];
        $('.check-item:checked').each(function() {
          selectedIds.push($(this).val());
        });

        // console.log(selectedIds);

        if (selectedIds.length > 0) {
          Swal.fire({
            title: 'Are you sure?',
            text: 'You will delete the selected items!',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: '/admin/siakad/adjustment/drop', // Ubah sesuai endpoint backend Anda
                type: 'POST',
                data: {
                  recids: selectedIds
                },
                success: function(response) {
                  Swal.fire('Deleted!', 'The selected items have been deleted.', 'success')
                    .then(() => location.reload());
                },
                error: function() {
                  Swal.fire('Error!', 'There was an issue deleting the items.', 'error');
                }
              });
            }
          });
        } else {
          Swal.fire('No items selected!', 'Please select items to delete.', 'info');
        }
      });
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

    <script>
      var dataOptionFilter = <?= json_encode($dataOptionFilter) ?>;
      console.log(dataOptionFilter);

      $.each(dataOptionFilter, function(index, value) {
        // Memeriksa apakah COLUMN_NAME ada, jika tidak, menggunakan column_name
        var columnName = value.COLUMN_NAME || value.column_name;

        // Menambahkan opsi ke dalam elemen #show_field
        $('#show_field').append('<option value="' + columnName + '">' + columnName + '</option>');
      });


      var selectedField = localStorage.getItem('selectedField');
      var selectedValue = localStorage.getItem('selectedValue');

      if (selectedField) {
        $('#show_field').val(selectedField);

        loadShowValueOptions(selectedField, selectedValue);
      }

      $('#show_field').on('change', function() {
        var selectedField = $(this).val();
        localStorage.setItem('selectedField', selectedField);

        if (selectedField) {
          loadShowValueOptions(selectedField);
        } else {
          $('#show_value').empty();
          localStorage.removeItem('selectedValue');
        }
      });

      // Event listener untuk perubahan pada #show_value
      $('#show_value').on('change', function() {
        var selectedValue = $(this).val();
        localStorage.setItem('selectedValue', selectedValue);
      });
      // Fungsi untuk memuat opsi di #show_value berdasarkan #show_field
      function loadShowValueOptions(field, selectedValue = null) {
        $.ajax({
          url: '/admin/siakad/adjustment/search',
          type: 'GET',
          data: {
            field: field
          },
          dataType: 'json',
          success: function(response) {
            $('#show_value').empty(); // Hapus opsi lama

            // Tambahkan opsi default
            $('#show_value').append('<option value="" disabled selected>-- Pilih Value --</option>');

            $.each(response.value, function(index, value) {
              $('#show_value').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
            });

            // Setel nilai terpilih jika tersedia
            if (selectedValue) {
              $('#show_value').val(selectedValue);
            }
          },
          error: function(xhr, status, error) {
            console.log('Error:', error);
          }
        });
      }
    </script>
    <script>
      $(document).ready(function() {
        $('#filter').on('click', function(e) {
          e.preventDefault(); // Mencegah submit form default jika tombol berada di dalam form

          // Ambil nilai dari dropdown
          var selectedField = $('#show_field').val();
          var selectedValue = $('#show_value').val();

          // Validasi apakah kedua dropdown sudah dipilih
          if (!selectedField) {
            alert('Silakan pilih Field terlebih dahulu!');
            return;
          }

          if (!selectedValue) {
            alert('Silakan pilih Value terlebih dahulu!');
            return;
          }

          // Tampilkan nilai yang dipilih di console
          console.log('Field:', selectedField);
          console.log('Value:', selectedValue);

          // Anda dapat menambahkan logika lain di sini, seperti mengirim data ke server menggunakan AJAX

          if (selectedValue && selectedField) {
            $.ajax({
              url: '/admin/siakad/adjustment/show',
              type: 'GET',
              data: {
                field: selectedField,
                value: selectedValue,
              },
              dataType: 'json',
              success: function(response) {
                console.log(response);

                if (response.success) {
                  window.location.href = "/admin/siakad/adjustment";
                }

              },
              error: function(xhr, status, error) {
                console.log('Error:', error);
              }
            });
          };
        });
      });
    </script>

</body>

</html>