<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Pelunasan Tagihan</title>
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
          <h1>Pembayaran Tunai</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Pembayaran Tunai</a></div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Tagihan Mahasiswa</h4>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label>NIM</label>
                    <div class="d-flex align-items-center">
                      <input type="text" class="form-control mr-2" id="nim" name="nim" style="flex: 1;">
                      <button class="btn btn-info py-2" type="button" id="cari">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label>Fakultas</label>
                      <input type="text" class="form-control" id="fakultas" name="fakultas" disabled>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Program Studi</label>
                      <input type="text" class="form-control" id="prodi" name="prodi" disabled>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Angkatan</label>
                      <input type="text" class="form-control" id="angkatan" name="angkatan" disabled>
                    </div>

                  </div>
                  <div class="form-group">
                    <label class="d-block">Jenis Tagihan</label>
                    <div id="checkbox-container"></div>
                    <div id="info-container">
                      <div class="alert alert-info py-2 px-3" role="alert" id="info-alert">
                        Masukkan NIM terlebih dahulu untuk menampilkan jenis tagihan!
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Nominal Tagihan</label>
                      <input type="number" class="form-control" id="nominal" name="nominal" disabled>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Nominal Pembayaran</label>
                      <input type="number" class="form-control" id="nominal_pembayaran" name="nominal_pembayaran">
                    </div>
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
          $('#cari').click(function() {
            var nim = $('#nim').val();
            $.ajax({
              url: '/admin/siakad/pelunasan/search',
              method: 'GET',

              data: {
                nim: nim
              },
              dataType: 'json',
              success: function(response) {
                var data = response.data;
                $('#fakultas').val(data[0].nama_fakultas);
                $('#prodi').val(data[0].nama_prodi);
                $('#angkatan').val(data[0].tahun_angkatan);
                console.log(response);
                $('#info-alert').hide();
                $('#checkbox-container').empty().append();
                let totalNominal = 0;

                function updateTotalNominal() {
                  totalNominal = 0;
                  $('.form-check-input:checked').each(function() {
                    const jenisTagihan = parseInt($(this).val());
                    const item = response.data.find(item => item.jenis_tagihan === jenisTagihan);
                    if (item && item.nominal) {
                      totalNominal += parseFloat(item.nominal);
                    }
                  });
                  $('#nominal').val(totalNominal);
                }

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

                $('#checkbox-container').on('change', '.form-check-input', function() {
                  updateTotalNominal();
                });


              },
              error: function(xhr, status, error) {
                console.log('Error:', error);
              }
            });
          });

          let selectedCheckboxValues = [];

          $('#checkbox-container').on('change', '.form-check-input', function() {
            selectedCheckboxValues = [];

            $('.form-check-input:checked').each(function() {
              selectedCheckboxValues.push($(this).val());
            });
          });

          $('#submit').on('click', async function(event) {
            event.preventDefault();

            var arrayData = [{
              nim: $('#nim').val(),
              tgl_transaksi: new Date().toISOString().slice(0, 10),
              nominal_pembayaran: $('#nominal_pembayaran').val(),
              tagihan: selectedCheckboxValues,

            }];

            try {
              let response = await $.ajax({
                url: '/admin/siakad/pelunasan/save',
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