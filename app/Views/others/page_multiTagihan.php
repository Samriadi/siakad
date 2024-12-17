<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Master Tagihan</title>
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
                  <div class="form-group">
                    <label>Fakultas</label>
                    <select class="form-control" id="fakultas" name="fakultas">
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Program Studi</label>
                    <select class="form-control" id="prodi" name="prodi">
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Angkatan</label>
                    <select class="form-control" id="angkatan" name="angkatan">
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Periode</label>
                    <select class="form-control" id="periode" name="periode">
                      <option value="2023/2024">2023/2024</option>
                      <option value="2024/2025">2024/2025</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>From</label>
                    <input type="date" class="form-control" id="from" nama="from">
                  </div>
                  <div class="form-group">
                    <label>To</label>
                    <input type="date" class="form-control" id="to" nama="to">
                  </div>
                  <div class="form-group">
                    <label>NIM</label>
                    <input type="text" class="form-control" id="nim" nama="nim">
                  </div>
                  <div class="form-group">
                    <label class="d-block">Jenis Tagihan</label>
                    <div id="checkbox-container"></div>
                  </div>
                  <div class="form-group">
                    <label>Nominal</label>
                    <input type="number" class="form-control" id="nominal" nama="nominal">
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" nama="keterangan">
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button class="btn btn-primary mr-1" type="submit" id="submit">Submit</button>
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

            var arrayData = [{
              fakultas: $('#fakultas').val(),
              prodi: $('#prodi').val(),
              tagihan: selectedPaytypes,
              angkatan: $('#angkatan').val(),
              keterangan: $('#keterangan').val(),
              nim: $('#nim').val(),
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
          });





        });
      </script>

</body>

</html>