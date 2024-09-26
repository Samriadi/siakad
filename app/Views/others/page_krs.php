<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Mahasiswa</title>
  <?php include '../app/Views/others/layouts/header.php'; ?>
</head>

<body>
  <div id="app">
    <!-- navbar -->
    <?php include '../app/Views/others/layouts/topbar.php'; ?>

    <!-- sidebar -->
    <?php include '../app/Views/others/layouts/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>Data</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Kartu Rencana Studi</a></div>
          </div>
        </div>

        <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <form id="myForm" method="POST" action="#">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                        <label for="name">Nama</label>
                        <input type="hidden" class="form-control" id="student_id" value="6661">
                        <input type="text" class="form-control" id="name" value="bass">
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
// Get the current semester from the query string or default to 1
            $currentSemester = isset($_GET['semester']) ? intval($_GET['semester']) : 1;
            $currentSemester = max(1, min(8, $currentSemester)); // Ensure the semester is between 1 and 8

            // Determine the data source for the current semester
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
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total SKS</th>
                        <th colspan="2" id="totalSKS">0</th>
                    </tr>
                    <tr>
                    <td colspan="5" style="padding: 0;">
                        <div class="alert alert-warning mb-0" role="alert" style="margin: 0;">
                            <strong>Pending...</strong>
                            <p style="margin: 0;">Pengisian KRS Anda masih dalam proses. Silakan tunggu konfirmasi dari pihak administrasi.</p>
                            <!-- Ubah status di atas sesuai dengan data Anda -->
                        </div>
                    </td>


                    </tr>
                </tfoot>
            </table>
            <div id="noDataMessage" class="alert alert-info d-none">Tidak ada data KRS, lakukan penginputan KRS terlebih dahulu!.</div>
        </div>
    </div>
</div>


      </section>
    </div>
  </div>

  <!-- Footer -->
  <?php include '../app/Views/others/layouts/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
   let selectedCourses = JSON.parse(localStorage.getItem('selectedCourses')) || [];
   let valcredits = 0;



    document.addEventListener('DOMContentLoaded', () => {
        displaySelectedCourses();

    // Check already selected courses when the page loads
    selectedCourses.forEach(course => {
        const checkbox = document.getElementById(`cbx-${course.semester}-${course.key}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        });

function updateSelectedCourses(checkbox, courseId, courseName, courseCode, credits) {
    const courseData = {
        semester: <?= $currentSemester ?>, // Add the current semester
        key: checkbox.id.split('-').pop(), // Store the key for checkbox identification
        id: courseId,
        name: courseName,
        code: courseCode,
        credits: credits
    };

    if (checkbox.checked) {
        selectedCourses.push(courseData);
    } else {
        selectedCourses = selectedCourses.filter(course => !(course.id === courseId && course.semester === <?= $currentSemester ?>));
    }

    // Save to localStorage
    localStorage.setItem('selectedCourses', JSON.stringify(selectedCourses));
    displaySelectedCourses();
}

function displaySelectedCourses() {
    const selectedCoursesListLeft = document.getElementById('selected-courses-left');
    const selectedCoursesListRight = document.getElementById('selected-courses-right');
    
    // Clear previous content
    selectedCoursesListLeft.innerHTML = '';
    selectedCoursesListRight.innerHTML = '';
    
    let totalCredits = 0;
    
    selectedCourses.forEach((course, index) => {
        const courseItem = document.createElement('li');
        courseItem.className = 'media';
        courseItem.innerHTML = `
            <div class="media-body">
                <li class="media d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="font-weight-bold fs-5 ml-1 mr-3">${index + 1}. ${course.name}</span>
                        <span>${course.code}</span>
                        <span class="bullet mx-1"></span>
                        <span class="font-weight-bold text-danger">${course.credits} SKS</span>
                    </div>
                </li>
            </div>
        `;

        // Append to the left column if index < 6, otherwise to the right column
        if (index < 6) {
            selectedCoursesListLeft.appendChild(courseItem);
        } else {
            selectedCoursesListRight.appendChild(courseItem);
        }

        totalCredits += course.credits;
    });
    
    // Update the total credits
    document.getElementById('total-sks').textContent = totalCredits;
}


function clearLocalStorage() {
    localStorage.removeItem('selectedCourses');
    selectedCourses = {};
    location.reload();
    displaySelectedCourses();

}


// Clear the localStorage when the form is submitted
document.querySelector('form').addEventListener('submit', () => {
    localStorage.removeItem('selectedCourses');
});

</script>


<script>
    $(document).ready(function() {
        $('#myForm').on('submit', function(event) {
            event.preventDefault(); // Mencegah pengiriman form default

            // Mengambil data dari form
            var name = $('#name').val();

            var student_id = $('#student_id').val();
            var semester = $('#semester').val();
            var academic_year = $('#academic_year').val();

            const selectedCourseIds = selectedCourses.map(course => course.id);
            
            var studentData = [];

            // Membuat objek untuk menyimpan data
            var studentObject = {
                student_id: student_id,
                semester: semester,
                academic_year: academic_year,
                total_credits: valcredits,
                selected_course_ids: selectedCourseIds
            };

            // Menambahkan objek ke dalam array
            studentData.push(studentObject);

            // Contoh untuk menampilkan isi array
            console.log('student data' , studentData);

          
        Swal.fire({
            title: "Konfirmasi Pengiriman",
            text: "Apakah Anda yakin ingin?",
            icon: "question", // Icon for the confirmation prompt
            showCancelButton: true,
            confirmButtonText: 'Kirim',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/siakad/krs/add',
                    type: 'POST',
                    contentType: 'application/json', // Ensure JSON is correctly set
                    data: JSON.stringify(studentData), // Send data as JSON string
                    success: function(response) {
                        Swal.fire({
                            text: 'Data berhasil dikirim.',
                            icon: 'success',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        Swal.fire({
                            title: 'Kesalahan',
                            text: 'Terjadi kesalahan: ' + errorThrown + ' (' + jqXHR.status + ')',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                Swal.fire({
                    text: 'Pengiriman krs dibatalkan',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    showCancelButton: false
                });
            }
        });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Function to calculate total SKS
        function updateTotalSKS() {
            let totalSKS = 0;
            $('tbody tr').each(function() {
                const sks = parseInt($(this).find('td:eq(3)').text());
                totalSKS += sks;
            });
            $('#totalSKS').text(totalSKS);
        }

        // Check if there are any KRS data and update total SKS
        if ($('tbody tr').length === 0) {
            $('#noDataMessage').removeClass('d-none'); // Show no data message
            $('#totalSKS').text(0); // Set total SKS to 0
        } else {
            $('#noDataMessage').addClass('d-none'); // Hide no data message
            updateTotalSKS(); // Update total SKS if there are rows
        }

        // Handle delete button click
        $('.btn-delete').on('click', function() {
            const row = $(this).closest('tr');

            // Confirm deletion
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data mata kuliah ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove the row
                    row.remove();

                    // Update total SKS
                    updateTotalSKS();

                    // Check if there are any rows left
                    if ($('tbody tr').length === 0) {
                        $('#noDataMessage').removeClass('d-none'); // Show no data message
                    }

                    // Show success notification
                    Swal.fire(
                        'Terhapus!',
                        'Data mata kuliah telah dihapus.',
                        'success'
                    );
                }
            });
        });
    });
</script>

<script>
    
    function confirmDelete(element) {
        const id = element.getAttribute('data-id');
        const course_id = element.getAttribute('data-course-id');

       

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
              url: '/admin/siakad/krs/delete',
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
                            let selectedCourses = JSON.parse(localStorage.getItem('selectedCourses')) || [];

                            // Filter array untuk menghapus item dengan ID tertentu
                            const updatedCourses = selectedCourses.filter(course => course.id !== course_id);

                            // Simpan kembali ke localStorage
                            localStorage.setItem('selectedCourses', JSON.stringify(updatedCourses));

                            console.log(id)

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

</body>

</html>