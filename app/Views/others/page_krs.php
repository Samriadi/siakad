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
                <div class="col-lg-6 col-md-6 col-12">
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

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">Mata Kuliah Yang Dipilih</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border" id="selected-courses">
                                <!-- Selected courses will be displayed here -->
                            </ul>
                            <br>
                            <h6>Total SKS: <span class="text-danger" id="total-sks">0</span> <span class="text-danger">SKS</span></h6>
                            <br>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                            <button  type="button" class="btn btn-danger" onclick="clearLocalStorage()">Hapus Semua</button>
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
    const selectedCoursesList = document.getElementById('selected-courses');
    selectedCoursesList.innerHTML = '';
    
    let totalCredits = 0;
    
    selectedCourses.forEach(course => {
        const courseItem = document.createElement('li');
        courseItem.className = 'media';
        courseItem.innerHTML = `
            <div class="media-body">
                <li class="media d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="font-weight-bold  fs-5 ml-1 mr-3">${course.name}</span>
                        <span>${course.code}</span>
                        <span class="bullet mx-1"></span>
                        <span class="font-weight-bold text-danger">${course.credits} SKS</span>
                    </div>
                </li>
            </div>
            `;
        
        selectedCoursesList.appendChild(courseItem);
        totalCredits += course.credits;

        valcredits=totalCredits;
        

    });
    
    document.getElementById('total-sks').textContent = totalCredits;
}

function clearLocalStorage() {
    localStorage.removeItem('selectedCourses');
    selectedCourses = {};
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
                        console.log('Response from server:', response);
                        Swal.fire({
                            text: 'Data berhasil dikirim.',
                            icon: 'success',
                            confirmButtonText: 'OK'
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
</body>

</html>