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
          <h1>Penginputan Transaksi Tagihan</h1>
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
                    <div class="col-12 col-md-5 col-lg-3">
                      <div class="form-group">
                        <label for="show_field">Fakultas</label>
                        <select id="show_field" name="show_field" class="form-control">
                          <option value="" selected disabled>Pilih Fakultas</option>
                        </select>
                      </div>
                    </div>
                    <!-- Select Value -->
                    <div class="col-12 col-md-5 col-lg-3">
                      <div class="form-group">
                        <label for="show_value">Program Studi</label>
                        <select id="show_value" name="show_value" class="form-control">
                          <option value="" selected disabled>Pilih Prodi</option>
                        </select>
                      </div>
                    </div>
                    <!-- Select Value -->
                    <div class="col-12 col-md-5 col-lg-3">
                      <div class="form-group">
                        <label for="show_angkatan">Angkatan</label>
                        <select id="show_angkatan" name="show_angkatan" class="form-control">
                          <option value="" selected disabled>Pilih Angkatan</option>
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
                      <i class="fas fa-plus text-white"> Per-Tagihan</i>
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="/admin/siakad/multi-transaksi" class="btn btn-primary" id="btn-multi">
                      <i class="fas fa-plus text-white"> Multi Tagihan</i>
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
                          <th>Periode</th>
                          <th>From</th>
                          <th>To</th>
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
                              <td><?= $value->periode ?></td>
                              <td>
                                <?= $value->from_date ? date('j-n-Y', strtotime($value->from_date)) : '' ?>
                              </td>
                              <td>
                                <?= $value->to_date ? date('j-n-Y', strtotime($value->to_date)) : '' ?>
                              </td>


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
            <h5 class="modal-title" id="addModalLabel">Add Transaksi Tagihan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="addForm">
            <div class="modal-body">
              <div class="card-body">
                <div style="border-top:2px solid #abb2b9; border-bottom:2px solid #abb2b9; 
				  margin-bottom: 20px; padding-top:10px;">

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
                      <label for="add_jenis_tagihan">Jenis Tagihan</label>
                      <select id="add_jenis_tagihan" class="form-control" name="jenis_tagihan" required>
                        <option value="" selected disabled></option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="add_nim">NIM</label>
                      <input type="text" class="form-control" id="add_nim" name="nim">
                      (Pisahkan dengan Koma)
                      <div id="info-container">
                      </div>
                    </div>
                  </div>
                </div>


                <div style="border-bottom:2px solid #abb2b9; padding-bottom:10px;">

                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="add_periode_pembayaran">Periode</label>
                      <select id="add_periode_pembayaran" class="form-control" name="periode_pembayaran" required>
                        <option value="2023/2024">2023/2024</option>
                        <option value="2024/2025">2024/2025</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="add_awal_pembayaran">From</label>
                      <input type="date" class="form-control" id="add_awal_pembayaran" name="awal_pembayaran">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="add_akhir_pembayaran">To</label>
                      <input type="date" class="form-control" id="add_akhir_pembayaran" name="akhir_pembayaran">
                    </div>
                  </div>


                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="add_nominal">Nominal</label>
                      <input type="number" class="form-control" id="add_nominal" name="nominal" disabled>
                      <small class="form-text text-danger" id="nominalValidation">nominal tagihan tidak ada!</small>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="add_qty">Quantity</label>
                      <input type="number" class="form-control" id="add_qty" name="qty" value="1">
                    </div>
                  </div>



                  <div class="form-group">
                    <label for="add_keterangan">Keterangan</label>
                    <input type="text" class="form-control" id="add_keterangan" name="keterangan">
                  </div>

                  <!--
                <div class="form-group">                 
                  <label for="add_adjustment">Adjustment</label>
                  <input type="number" class="form-control" id="add_adjustment" name="adjust">                  
                </div>
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
            <h5 class="modal-title" id="editModalLabel">Edit Transaksi Tagihan</h5>
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
                  <label for="jenis_tagihan">Jenis Tagihan</label>
                  <select id="jenis_tagihan" class="form-control" name="jenis_tagihan" required>
                    <option value="" selected disabled>Pilih Jenis Tagihan</option>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="add_nim">NIM</label>
                  <input type="text" class="form-control" id="nim">
                  (Pisahkan dengan Koma)
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

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="periode_pembayaran">Periode</label>
                  <select id="periode_pembayaran" class="form-control" name="periode_pembayaran" required>
                    <option value="2023/2024">2023/2024</option>
                    <option value="2024/2025">2024/2025</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="awal_pembayaran">From</label>
                  <input type="date" class="form-control" id="awal_pembayaran" name="awal_pembayaran">
                </div>
                <div class="form-group col-md-4">
                  <label for="akhir_pembayaran">To</label>
                  <input type="date" class="form-control" id="akhir_pembayaran" name="akhir_pembayaran">
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
        //add data
        $('#btn-add').on('click', function() {
          nominalValidation.style.display = "none";

          $.ajax({
            url: '/admin/siakad/transaksi/include',
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

                $('#add_fakultas').on('change', function() {
                  let selectedFakultas = $(this).val(); // Ambil ID fakultas yang dipilih

                  $('#add_prodi').empty();

                  $.each(dataProdi, function(index, value) {
                    if (value.name == 'ALL') {
                      $('#add_prodi').append('<option value="' + value.ID + '" selected>' + value.deskripsi + '</option>');
                    }
                  });

                  $.each(dataProdi, function(index, value) {
                    if (value.fakultas == selectedFakultas && value.name != 'ALL') {
                      $('#add_prodi').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
                    }
                  });

                });


                $('#add_jenis_tagihan').empty().append('<option value="" selected disabled></option>');

                let uniqueTagihan = new Set();

                $.each(dataPaytype, function(index, value) {
                  if (!uniqueTagihan.has(value.jenis_tagihan)) {
                    uniqueTagihan.add(value.jenis_tagihan);
                    $('#add_jenis_tagihan').append('<option value="' + value.jenis_tagihan + '">' + value.nama_tagihan + '</option>');
                  }
                });

                $('#add_angkatan').empty().append('<option value="" selected disabled></option>');

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
              url: '/admin/siakad/transaksi/getNominal',
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
        };

        $('#add_fakultas').on('change', updateNominal);
        $('#add_prodi').on('change', updateNominal);
        $('#add_angkatan').on('change', updateNominal);
        $('#add_jenis_tagihan').on('change', updateNominal);


        $('#add_submit').on('click', async function(event) {
          event.preventDefault();
          let lastCheckedNIM = [];
          var nim = $('#add_nim').val();


          var arrNIM = nim.split(",").map(n => n.trim()).filter(n => n !== "");
          var newNIM = arrNIM.filter(n => !lastCheckedNIM.includes(n));

          let notFoundNIM = [];
          let validNIM = [];

          for (const value of newNIM) {
            try {
              const response = await $.ajax({
                url: '/admin/siakad/transaksi/cekNim',
                type: 'GET',
                data: {
                  nim: value,

                },
                dataType: 'json'
              });

              if (response.success) {
                validNIM.push(value);
              } else {
                notFoundNIM.push(value);
              }
            } catch (error) {
              console.log('Error:', error);
            }
          }

          lastCheckedNIM = lastCheckedNIM.concat(newNIM);

          if (notFoundNIM.length > 0) {
            Swal.fire({
              icon: 'error',
              html: `<p>NIM tidak ditemukan:</p>${notFoundNIM.map(n => `${n}`).join(',')}`,
              confirmButtonText: 'OK'
            });
          } else {
            var arrayData = [{
              fakultas: $('#add_fakultas').val(),
              prodi: $('#add_prodi').val(),
              jenis_tagihan: $('#add_jenis_tagihan').val(),
              angkatan: $('#add_angkatan').val(),
              nominal: $('#add_nominal').val(),
              keterangan: $('#add_keterangan').val(),
              nim: validNIM.join(","),
              adj_type: $('#adj_type').prop('checked') ? "replace" : "normal",
              adjust: 0,
              qty: $('#add_qty').val(),
              periode_pembayaran: $('#add_periode_pembayaran').val(),
              awal_pembayaran: $('#add_awal_pembayaran').val(),
              akhir_pembayaran: $('#add_akhir_pembayaran').val()

            }];

            try {
              $('#add_submit').prop('disabled', true);
              let response = await $.ajax({
                url: '/admin/siakad/transaksi/add',
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
                  $('#add_submit').prop('disabled', false);
                  location.reload();
                });
              } else {
                $('#add_submit').prop('disabled', false);
                await Swal.fire({
                  text: response.message,
                  icon: 'warning',
                  confirmButtonText: 'OK'
                });
              }

            } catch (error) {
              $('#add_submit').prop('disabled', false);
              await Swal.fire({
                text: 'Tagihan Sudah Ada.',
                icon: 'Warning',
                confirmButtonText: 'OK'
              });
            }
          }
        });

        //edit data
        $(document).on('click', '.btn-edit', function() {
          $('#edit_submit').prop('disabled', true);
          nominalEditValidation.style.display = "none";

          var id = $(this).data('id');
          var currentQty = 0;
          var satNominal = 0;


          $.ajax({
            url: '/admin/siakad/transaksi/fetch',
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
                $('#periode_pembayaran').val(data.periode);
                $('#awal_pembayaran').val(data.from_date);
                $('#akhir_pembayaran').val(data.to_date);

                currentQty = data.qty;
                satNominal = data.nominal / currentQty;



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
                url: '/admin/siakad/transaksi/getNominal',
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
              adjustment: $('#adjustment').val(),
              periode_pembayaran: $('#periode_pembayaran').val(),
              awal_pembayaran: $('#awal_pembayaran').val(),
              akhir_pembayaran: $('#akhir_pembayaran').val(),
              satuan_nominal: satNominal
              // adjtype: $('#adjtype').prop('checked') ? "replace" : "normal"
            }];

            $.ajax({
              url: '/admin/siakad/transaksi/update',
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
              url: '/admin/siakad/transaksi/delete',
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
                url: '/admin/siakad/transaksi/drop', // Ubah sesuai endpoint backend Anda
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
      var dataOptionFakultas = <?= json_encode($dataOptionFakultas) ?>;

      $.each(dataOptionFakultas, function(index, value) {

        $('#show_field').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
      });


      // Ambil nilai dari session yang diekspor oleh PHP
      var sessionField = <?= json_encode($_SESSION['fieldNameFilter'] ?? '') ?>;
      var sessionValue = <?= json_encode($_SESSION['fieldValueFilter'] ?? '') ?>;
      var sessionAngkatan = <?= json_encode($_SESSION['fieldAngkatanFilter'] ?? '') ?>;

      // Jika nilai session tersedia, gunakan nilai tersebut. Jika tidak, gunakan localStorage.
      var selectedField = sessionField || localStorage.getItem('selectedField');
      var selectedValue = sessionValue || localStorage.getItem('selectedValue');
      var selectedAngkatan = sessionAngkatan || localStorage.getItem('selectedAngkatan');

      // Simpan kembali nilai yang digunakan ke localStorage untuk keperluan di masa depan
      if (sessionField) {
        localStorage.setItem('selectedField', sessionField);
      }
      if (sessionValue) {
        localStorage.setItem('selectedValue', sessionValue);
      }
      if (sessionAngkatan) {
        localStorage.setItem('selectedAngkatan', sessionAngkatan);
      }

      if (selectedField) {
        $('#show_field').val(selectedField);

        loadShowValueOptions(selectedField, selectedValue, selectedAngkatan);
      }

      $('#show_field').on('change', function() {
        var selectedField = $(this).val();

        loadShowValueOptions(selectedField);


        localStorage.setItem('selectedField', selectedField);

        if (selectedField) {
          loadShowValueOptions(selectedField);
        } else {
          $('#show_value').empty();
          $('#show_angkatan').empty();
          localStorage.removeItem('selectedValue');
          localStorage.removeItem('selectedAngkatan');
        }
      });

      $('#show_value').on('change', function() {
        var selectedValue = $(this).val();

        localStorage.setItem('selectedValue', selectedValue);
      });

      $('#show_angkatan').on('change', function() {
        var selectedAngkatan = $(this).val();

        localStorage.setItem('selectedAngkatan', selectedAngkatan);
      });

      function loadShowValueOptions(field, selectedValue = null, selectedAngkatan = null) {
        $.ajax({
          url: '/admin/siakad/transaksi/search',
          type: 'GET',
          data: {
            field: field
          },
          dataType: 'json',
          success: function(response) {

            $('#show_value').empty();

            $('#show_value').append('<option value="" disabled selected>Pilih Prodi</option>');

            $.each(response.prodi, function(index, value) {
              $('#show_value').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
            });

            $('#show_angkatan').empty();

            $('#show_angkatan').append('<option value="" disabled selected>Pilih Angkatan</option>');

            $.each(response.angkatan, function(index, value) {
              $('#show_angkatan').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
            });

            if (selectedValue && selectedAngkatan) {
              $('#show_value').val(selectedValue);
              $('#show_angkatan').val(selectedAngkatan);
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
          e.preventDefault();
          var selectedField = $('#show_field').val();
          var selectedValue = $('#show_value').val();
          var selectedAngkatan = $('#show_angkatan').val();

          if (!selectedField) {
            alert('Silakan pilih Field terlebih dahulu!');
            return;
          }

          if (!selectedValue) {
            alert('Silakan pilih Value terlebih dahulu!');
            return;
          }

          if (!selectedAngkatan) {
            alert('Silakan pilih Angkatan terlebih dahulu!');
            return;
          }


          if (selectedValue && selectedField && selectedAngkatan) {
            $.ajax({
              url: '/admin/siakad/transaksi/show',
              type: 'GET',
              data: {
                field: selectedField,
                value: selectedValue,
                angkatan: selectedAngkatan
              },
              dataType: 'json',
              success: function(response) {
                window.location.href = "/admin/siakad/transaksi";

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