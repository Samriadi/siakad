<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - KRS</title>
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
            <div class="breadcrumb-item">Kartu Rencana Studi</div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Kartu Rencana Studi</h4>
                </div>
                <div class="card-body">
                <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <form id="myForm" method="POST" action="#">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                        <label for="name">Nama</label>
                        <input type="hidden" class="form-control" id="student_id" value="6662">
                        <input type="text" class="form-control" id="name" value="tester 2">
                        </div>
                        <div class="form-group col-md-4">
                        <label for="semester">Semester</label>
                        <input type="number" class="form-control" id="semester" value="7">
                        </div>
                        <div class="form-group col-md-4">
                        <label for="academic_year">Tahun Akademik</label>
                        <input type="text" class="form-control" id="academic_year" value="2024/2025">
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>

          <?php
            $currentSemester = isset($_GET['semester']) ? intval($_GET['semester']) : 1;
            $currentSemester = max(1, min(8, $currentSemester)); // Ensure the semester is between 1 and 8

            $dataMatkul = ${"dataMatkul" . $currentSemester};
            ?>

            <div class="row">
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">Mata Kuliah Semester <?= $currentSemester ?></h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                <?php foreach ($dataMatkul as $key => $value) : ?>
                                    <li class="media d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" id="cbx-<?= $currentSemester ?>-<?= $key ?>" 
                                                onchange="updateSelectedCourses(this,'<?= $value->course_id ?>', '<?= $value->course_name ?>', '<?= $value->course_code ?>', <?= $value->credits ?>)">
                                            <label for="cbx-<?= $currentSemester ?>-<?= $key ?>" class="ml-1"></label>
                                            <span class="font-weight-bold fs-5 ml-1 mr-3"><?= $value->course_name ?></span>
                                            <span><?= $value->course_code ?></span>
                                            <span class="bullet mx-1"></span>
                                            <span class="font-weight-bold text-danger"><?= $value->credits ?> SKS</span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">Mata Kuliah Yang Dipilih</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <ul class="list-unstyled list-unstyled-border" id="selected-courses-left">
                                        <!-- Selected courses will be displayed here -->
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-unstyled list-unstyled-border" id="selected-courses-right">
                                        <!-- Additional courses will be displayed here -->
                                    </ul>
                                </div>
                            </div>
                            <br>
                            <h6>Total SKS: <span class="text-danger" id="total-sks">0</span> <span class="text-danger">SKS</span></h6>
                            <br>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                            <button type="button" class="btn btn-danger" onclick="clearLocalStorage()">Hapus Semua</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pagination Controls -->
            <div class="row">
                <div class="col-12 text-center">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item <?= ($currentSemester == 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?semester=<?= $currentSemester - 1 ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= 8; $i++) : ?>
                                <li class="page-item <?= ($i == $currentSemester) ? 'active' : '' ?>">
                                    <a class="page-link" href="?semester=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($currentSemester == 8) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?semester=<?= $currentSemester + 1 ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        </form>
        </div>
                </div>


                <div class="card">
    <div class="card-header">
        <h4>Data KRS</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Kode</th>
                        <th>SKS</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="krsData">
                    <?php if (!empty($DetailKRS)) : ?>
                        
                        <?php foreach ($DetailKRS as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value->course_name ?></td>
                            <td><?= $value->course_code ?></td>
                            <td><?= $value->credits ?></td>
                            <td>
                                <a class="btn btn-danger btn-action mr-1" data-course-id="<?= $value->course_id ?>" data-id="<?= $value->krs_course_id ?>" onclick="confirmDelete(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total SKS</th>
                        <th colspan="2" id="totalSKS">0</th>
                    </tr>
                    <?php if (!empty($DetailKRS)) : 
                        
                        
                        ?>
                        <?php if($approval['approval_status'] === 'Pending') { ?>
                            <tr>
                                <td colspan="5" style="padding: 0;">
                                    <div class="alert alert-warning mb-0" role="alert" style="margin: 0;">
                                        <p style="margin: 0;">Pengisian KRS Anda masih dalam proses. Silakan tunggu konfirmasi dari pihak administrasi.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php } elseif($approval['approval_status'] === 'Approved') { ?>
                            <tr>
                                <td colspan="5" style="padding: 0;">
                                    <div class="alert alert-success mb-0" role="alert" style="margin: 0;">
                                        <p style="margin: 0;">KRS disetujui. <?=$approval['comments']?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php } elseif($approval['approval_status'] === 'Rejected') { ?>
                            <tr>
                                <td colspan="5" style="padding: 0;">
                                    <div class="alert alert-danger mb-0" role="alert" style="margin: 0;">
                                        <p style="margin: 0;">KRS ditolak. <?=$approval['comments']?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php endif; ?>
                </tfoot>

            </table>
            <div id="noDataMessage" class="alert alert-info d-none">Tidak ada data KRS, lakukan penginputan KRS terlebih dahulu!.</div>
        </div>
    </div>
</div>
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
            // Event ketika tombol dengan id btn-show diklik


            $(document).on('click', '#btn-show', function() {
                const krsId = $(this).data('id'); // Mengambil nilai krs_id dari data-id

                $.ajax({
                    url: '/admin/siakad/persetujuan-krs/detail', 
                    type: 'GET',
                    data: { krs_id: krsId },
                    dataType: 'json',
                    success: function(response) {
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
          var comment = $('#comment').val();
    

            $.ajax({
                url: '/admin/siakad/persetujuan-krs/update', 
                type: 'POST',
                data: { krs_id: krsId, approval_status: status, comments: comment },
                dataType: 'json',
                success: function(response) {
                  console.log(response)
                  if (response.success) {
                    Swal.fire({
                          icon: 'success',
                          title: 'Status Updated',
                          text: `Status has been updated to ${status}.`,
                      }).then(() => {
                          location.reload();
                      });
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


      <script>
        // JavaScript code to handle checkbox selection
      document.addEventListener('DOMContentLoaded', function () {
        // Select all checkboxes with the name 'selected_krs[]'
        const checkboxes = document.querySelectorAll('input[name="selected_krs[]"]');
        
        // Add an event listener for each checkbox
        checkboxes.forEach(checkbox => {
          checkbox.addEventListener('change', () => {
            // Collect all selected values
            const selectedValues = Array.from(checkboxes)
              .filter(checkbox => checkbox.checked) // Filter checked checkboxes
              .map(checkbox => checkbox.value);     // Extract the values
            
            // Display the selected values in the console
            console.log('Selected KRS IDs:', selectedValues);
          });
        });
      });

    $(document).ready(function () {
        $('#confirmKRS').click(function () {
            // Collect all selected KRS IDs
            let selectedKRS = [];
            $('input[name="selected_krs[]"]:checked').each(function () {
                selectedKRS.push($(this).val());
            });

            let status = "Approved";

            if (selectedKRS.length > 0) {
                // Show confirmation alert
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to confirm the selected KRS.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, confirm it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/siakad/persetujuan-krs/update-general', 
                            type: 'POST',
                            data: { krs_id: selectedKRS, approval_status: status },
                            dataType: 'json',
                            success: function(response) {
                              console.log(response)
                                if (response.success) {
                                  Swal.fire({
                                      icon: 'success',
                                      title: 'Status Updated',
                                      text: `Status has been updated to ${status}.`,
                                  }).then(() => {
                                      location.reload();
                                  });
                                }else {
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
                        // console.log(selectedKRS);
                    }
                });
            } else {
                Swal.fire(
                    'No Selection!',
                    'Please select at least one KRS to confirm.',
                    'info'
                );
            }
        });
    });

      </script>

<script>
// JavaScript to handle the Check All functionality
document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.checkItem');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
  </body>

</html>