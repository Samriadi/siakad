<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Master Tagihan</title>
  <?php include '../app/Views/others/layouts/header.php'; ?>
  <style>
    input[disabled] {
      background-color: #fff !important;
      /* Warna latar belakang normal */
      color: #495057 !important;
      /* Warna teks normal */
      opacity: 1 !important;
      /* Menghilangkan efek transparan */
      border: 1px solid #ced4da !important;
      /* Border normal */
    }
  </style>

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
            <div class="breadcrumb-item">Master Tagihan</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Multi Tagihan</h4>
                </div>
                <div class="card-body">
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label>Fakultas</label>
                      <select class="form-control" id="fakultas" name="fakultas">
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Program Studi</label>
                      <select class="form-control" id="prodi" name="prodi">
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Angkatan</label>
                      <select class="form-control" id="angkatan" name="angkatan">
                      </select>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label>Periode</label>
                      <select class="form-control" id="periode" name="periode">
                        <option value="2023/2024">2023/2024</option>
                        <option value="2024/2025">2024/2025</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>From</label>
                      <input type="date" class="form-control" id="from" name="from">
                    </div>
                    <div class="form-group col-md-4">
                      <label>To</label>
                      <input type="date" class="form-control" id="to" name="to">
                    </div>
                  </div>

                  <div class="form-group">
                    <label>NIM</label>
                    <input type="text" class="form-control" id="nim" nama="nim">
                  </div>
                  <div class="form-group">
                    <label class="d-block">Jenis Tagihan</label>
                    <div id="checkbox-container"></div>
                    <div id="info-container">
                      <div class="alert alert-info py-2 px-3" role="alert" id="info-alert">
                        Silakan pilih opsi Fakultas, Program Studi dan Angkatan terlebih dahulu!
                      </div>
                    </div>


                  </div>
                  <div class="form-group">
                    <label>Nominal</label>
                    <input type="number" class="form-control" id="nominal" name="nominal" disabled>
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" nama="keterangan">
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit" id="submit">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Footer -->
      <?php include '../app/Views/others/layouts/footer.php'; ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <script>
        $(document).ready(function() {
          var dataPaytype = <?php echo json_encode($dataPaytype); ?>;
          var dataProdi = <?php echo json_encode($dataProdi); ?>;
          var dataAngkatan = <?php echo json_encode($dataAngkatan); ?>;
          var dataFakultas = <?php echo json_encode($dataFakultas); ?>;



          $('#fakultas').empty().append('<option value="" selected disabled></option>');
          $.each(dataFakultas, function(index, value) {
            $('#fakultas').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
          });
          $('#fakultas').on('change', function() {
            let selectedFakultas = $(this).val();
            $('#prodi').empty();
            $.each(dataProdi, function(index, value) {
              if (value.name == 'ALL') {
                $('#prodi').append('<option value="' + value.ID + '" selected>' + value.deskripsi + '</option>');
              }
            });
            $.each(dataProdi, function(index, value) {
              if (value.fakultas == selectedFakultas && value.name != 'ALL') {
                $('#prodi').append('<option value="' + value.ID + '">' + value.deskripsi + '</option>');
              }
            });
          });

          $('#angkatan').empty().append('<option value="" selected disabled></option>');
          $('#angkatan').append('<option value="Semua Angkatan">Semua Angkatan</option>');
          $.each(dataAngkatan, function(index, value) {
            $('#angkatan').append('<option value="' + value.ID_angkatan + '">' + value.nama + '</option>');
          });


          $('#fakultas').on('change', handleJenisTagihan);
          $('#prodi').on('change', handleJenisTagihan);
          $('#angkatan').on('change', handleJenisTagihan);

          function handleJenisTagihan() {
            var selectedFakultas = $('#fakultas').val();
            var selectedProdi = $('#prodi').val();
            var selectedAngkatan = $('#angkatan').val();

            $.ajax({
              url: '/admin/siakad/multi-transaksi/getPaytype',
              type: 'GET',
              data: {
                fakultas: selectedFakultas,
                prodi: selectedProdi,
                angkatan: selectedAngkatan
              },
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success == true) {
                  $('#info-alert').hide();
                  $('#warning-alert').hide();
                  $('#checkbox-container').empty().append();
                  response.data.forEach(item => {
                    const checkboxHTML = `
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="checkbox${item.jenis_tagihan}" value="${item.jenis_tagihan}">
                          <label class="form-check-label" for="checkbox${item.jenis_tagihan}">
                              ${item.nama_tagihan}
                          </label>
                      </div>
                  `;
                    $('#checkbox-container').append(checkboxHTML);

                  });
                } else {
                  $('#checkbox-container').empty().append();
                  $('#info-container').empty().append();
                  $('#info-alert').hide();
                  const infoHTML = `
                      <div class="alert alert-warning py-2 px-3" role="alert" id="warning-alert">
                        Tidak ada jenis tagihan ditemukan!
                      </div>
                  `;
                  $('#info-container').append(infoHTML);
                }
              },
              error: function(xhr, status, error) {
                console.log('Error:', error);
              }
            });
          }

          let selectedCheckboxValues = [];
          let selectedPaytypes = [];

          $('#checkbox-container').on('change', '.form-check-input', function() {
            selectedCheckboxValues = [];

            $('.form-check-input:checked').each(function() {
              selectedCheckboxValues.push($(this).val());
            });

            $.ajax({
              url: '/admin/siakad/multi-transaksi/getTotalNominal',
              type: 'GET',
              data: {
                selectedPaytype: selectedCheckboxValues,
                fakultas: $('#fakultas').val(),
                prodi: $('#prodi').val(),
                angkatan: $('#angkatan').val()
              },
              dataType: 'json',
              success: function(response) {
                $('#nominal').val(response.totalNominal);
                selectedPaytypes = response.data;

              },
              error: function(xhr, status, error) {
                console.log('Error:', error);
              }
            });


          });

          $('#submit').on('click', async function(event) {
            event.preventDefault();
            let lastCheckedNIM = [];

            var nim = $('#nim').val();
            var prodi = $('#prodi').val();
            var angkatan = $('#angkatan').val();

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
                    prodi: prodi,
                    angkatan: angkatan
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
                fakultas: $('#fakultas').val(),
                prodi: $('#prodi').val(),
                tagihan: selectedPaytypes,
                angkatan: $('#angkatan').val(),
                keterangan: $('#keterangan').val(),
                nim: validNIM.join(","),
                adjust: 0,
                periode_pembayaran: $('#periode').val(),
                awal_pembayaran: $('#from').val(),
                akhir_pembayaran: $('#to').val()

              }];

              try {
                let response = await $.ajax({
                  url: '/admin/siakad/multi-transaksi/add',
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
            }
          });
        });
      </script>

</body>

</html>