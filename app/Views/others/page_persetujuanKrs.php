<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Persetujuan</title>
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
          <h1>Data</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Data</a></div>
            <div class="breadcrumb-item">Data Persetujuan KRS</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Data Persetujuan KRS</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Mahasiswa</th>
                          <th scope="col">NIM</th>
                          <th scope="col">Semester</th>
                          <th scope="col">Status Aproved</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($dataKRS as $key => $value) : ?>
                          <tr>
                            <th scope="row"><?= ++$key ?></th>
                            <td><?= $value->NamaLengkap ?></td>
                            <td><?= $value->Nim ?></td>
                            <td><?= $value->semester ?></td>
                            <td><?= $value->approval_status ?></td>
                            <td style="white-space: nowrap;">
                              <a class="btn btn-primary btn-action mr-1" id="btn-show"  data-toggle="modal" data-target="#editModal"  data-id="<?= $value->krs_id ?>">
                                <i class="fas fa-pencil-alt"></i>
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
          </div>
        </div>
    </div>
    </section>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Use modal-lg for larger width -->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Detail KRS Mahasiswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="detail-content">
            <!-- Data detail KRS akan ditampilkan di sini -->
        </div>
        </div>
    </div>
    </div>




    <!-- Footer -->
    <?php include '../app/Views/others/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Event ketika tombol dengan id btn-show diklik
            $(document).on('click', '#btn-show', function() {
                const krsId = $(this).data('id'); // Mengambil nilai krs_id dari data-id

                $.ajax({
    url: '/admin/siakad/persetujuan-krs/detail', // Ganti dengan URL endpoint PHP Anda
    type: 'GET',
    data: { krs_id: krsId },
    dataType: 'json',
    success: function(response) {
        console.log(response);
        // Membuat konten detail dari response
        let content = `
            <p><strong>Nama:</strong> ${response.NamaLengkap}</p>
            <p><strong>NIM:</strong> ${response.Nim}</p>
            <p><strong>Semester:</strong> ${response.semester}</p>
            <p><strong>Mata Kuliah yang Dipilih:</strong></p>
            <ul>`;

        let totalSKS = 0; // Inisialisasi total SKS

        response.courses.forEach(course => {
            content += `<li>${course.course_name} (${course.course_code}) - ${course.credits} SKS</li>`;
            totalSKS += parseInt(course.credits); // Tambahkan SKS ke total
        });

        content += `</ul>`;
        content += `<p><strong>Total SKS:</strong> ${totalSKS} SKS</p>`; // Tampilkan total SKS

        // Menambahkan button untuk status approval
        content += `
        <div class="form-group">
                <p><strong>Komentar (opsional):</strong></p>
                <input type="text" id="comment" class="form-control" placeholder="Masukkan komentar...">
        </div>    
        <div class="form-group">
                <button id="approve-btn" class="btn btn-primary " onclick="updateApprovalStatus('Approved', ${krsId})">Approved</button>
                <button id="reject-btn" class="btn btn-danger" onclick="updateApprovalStatus('Rejected', ${krsId})">Rejected</button>
            </div>
            `
            ;

        // Menampilkan konten detail ke dalam modal
        $('#detail-content').html(content);
    },
    error: function(xhr, status, error) {
        console.error('Error:', error);
        $('#detail-content').html('<p class="text-danger">Gagal mengambil data detail KRS mahasiswa.</p>');
    }
});


            });
        });

      </script>

      <script>
        function updateApprovalStatus(status, krsId) {

          console.log(krsId)
            $.ajax({
                url: '/admin/siakad/persetujuan-krs/update', // Ganti dengan URL endpoint PHP Anda untuk update
                type: 'POST',
                data: { krs_id: krsId, approval_status: status },
                dataType: 'json',
                success: function(response) {
                  console.log(response)
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            text: `Status has been updated to ${status}.`,
                        });
                        // Optionally refresh or update the displayed data here
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update status.',
                    });
                }
            });
        }

      </script>
  </body>

</html>