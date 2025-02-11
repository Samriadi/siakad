<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD</title>
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
  <!-- header -->
  <?php include '../app/Views/others/layouts/header-mhs.php'; ?>


<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">

      <?php include '../app/Views/others/layouts/topbar-mhs.php'; ?>


      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Data Tagihan</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">Tagihan</a></div>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label>NIM</label>
                        <input type="number" class="form-control" id="nim" name="nim" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" disabled>
                      </div>
                    </div>
                    <div class="row">
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


                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Virtual Account</th>
                          <th>Periode</th>
                          <th>Tagihan Baru</th>
                          <th>Total Pembayaran</th>
                          <th>Awal Pembayaran</th>
                          <th>Batas Akhir Pembayaran</th>
                          <th>Keterangan</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $value) :
                          $status = ($value->total_pembayaran >= $value->tagihan) ? "Lunas" : "Belum Lunas";
                        ?>
                          <tr>
                            <td>
                              <a href="#" class="va-info"
                                data-va="<?= $value->va_number ?>"
                                data-jenis_tagihan="<?= $value->nama_tagihan ?>"
                                data-nominal="<?= $value->nominal ?>">
                                <?= $value->va_number ?>
                              </a>
                            </td>
                            <td><?= $value->periode ?></td>
                            <td>Rp. <?= number_format($value->nominal, 0) ?></td>
                            <td>Rp. <?= number_format($value->total_pembayaran, 0) ?></td>
                            <td><?= $value->from_date ?></td>
                            <td><?= $value->to_date ?></td>
                            <td><?= $value->keterangan ?></td>
                            <td class="font-weight-bold"><?= $status ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>



                  </div>
                </div>


              </div>
            </div>
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <?php include '../app/Views/others/layouts/footer-mhs.php'; ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
<script>
  var data = <?php echo json_encode($data); ?>;

  console.log(data);

  $(document).ready(function() {
    $('#nim').val(data[0].nim);
    $('#nama').val(data[0].nama);
    $('#fakultas').val(data[0].nama_fakultas);
    $('#prodi').val(data[0].nama_prodi);
    $('#angkatan').val(data[0].nama_angkatan);
  });
</script>

<script>
  $(document).ready(function() {
    $(".va-info").on("click", function(e) {
      e.preventDefault();

      let clickedVA = $(this).data("va"); // Ambil VA yang diklik
      let tableRows = ""; // Simpan baris tabel
      let totalNominal = 0; // Total semua nominal

      // Loop semua elemen yang memiliki VA yang sama
      $(".va-info").each(function() {
        if ($(this).data("va") === clickedVA) {
          let jenis_tagihan = $(this).data("jenis_tagihan");
          let nominal = parseFloat($(this).data("nominal")); // Konversi ke float

          totalNominal += nominal; // Tambahkan ke total

          tableRows += `
            <tr>
              <td style="border: 1px solid #ddd; padding: 8px;">${jenis_tagihan}</td>
              <td style="border: 1px solid #ddd; padding: 8px;">Rp. ${new Intl.NumberFormat().format(nominal)}</td>
            </tr>
          `;
        }
      });

      // Menambahkan baris untuk jenis tagihan admin bank dengan nominal 3000
      let adminBankNominal = 3000;
      totalNominal += adminBankNominal; // Tambahkan ke total nominal
      tableRows += `
        <tr>
          <td style="border: 1px solid #ddd; padding: 8px;">Admin Bank</td>
          <td style="border: 1px solid #ddd; padding: 8px;">Rp. ${new Intl.NumberFormat().format(adminBankNominal)}</td>
        </tr>
      `;

      // Tambahkan baris total ke dalam tabel
      tableRows += `
        <tr>
          <td style="border: 1px solid #ddd; padding: 8px; font-weight: bold; background: #f2f2f2;">Total Tagihan</td>
          <td style="border: 1px solid #ddd; padding: 8px; font-weight: bold; background: #f2f2f2;">Rp. ${new Intl.NumberFormat().format(totalNominal)}</td>
        </tr>
      `;

      let tableContent = `
        <table style="width:100%; border-collapse: collapse; text-align: left;">
          <tr>
            <th style="border: 1px solid #ddd; padding: 8px; background: #f2f2f2;">Jenis Tagihan</th>
            <th style="border: 1px solid #ddd; padding: 8px; background: #f2f2f2;">Nominal</th>
          </tr>
          ${tableRows}
        </table>
      `;

      Swal.fire({
        title: "Detail Virtual Account",
        html: tableContent,
        icon: "info",
        width: '500px',
        showConfirmButton: false
      });

    });
  });
</script>


</html>