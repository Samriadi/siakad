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
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <form method="POST" action="#">
                    <div class="form-group">
                      <label for="name">Nama</label>
                      <input type="text" class="form-control" id="name" value="bass">
                    </div>
                    <div class="form-group">
                      <label for="semester">Semester</label>
                      <input type="number" class="form-control" id="semester" value="7">
                    </div>
                    <div class="form-group">
                      <label for="academic_year">Tahun Akademik</label>
                      <input type="text" class="form-control" id="academic_year" value="2024/2025">
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
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">Mata Kuliah Semester <?= $currentSemester ?></h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                <?php foreach ($dataMatkul as $key => $value) : ?>
                                    <li class="media">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cbx-<?= $currentSemester ?>-<?= $key ?>"
                                                onchange="updateSelectedCourses(this,'<?= $value->course_id ?>', '<?= $value->course_name ?>', '<?= $value->course_code ?>', <?= $value->credits ?>)">
                                            <label class="custom-control-label" for="cbx-<?= $currentSemester ?>-<?= $key ?>"></label>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-title"><a href="#"><?= $value->course_name ?></a></h6>
                                            <div class="text-small text-muted"><?= $value->course_code ?><div class="bullet"></div> 
                                                <span class="text-primary"><?= $value->credits ?> SKS</span></div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
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

          <div class="row">
              <div class="col-lg-12 col-md-6 col-12">
                  <div class="card">
                      <div class="card-header">
                          <h4 class="d-inline">Mata Kuliah Yang Dipilih</h4>
                      </div>
                      <div class="card-body">
                          <ul class="list-unstyled list-unstyled-border" id="selected-courses">
                              <!-- Selected courses will be displayed here -->
                          </ul>
                          <br>
                          <h6>Total SKS: <span id="total-sks">0</span> SKS</h6>
                          <br>
                          <button class="btn btn-primary">Input</button>
                          <button class="btn btn-danger" onclick="clearLocalStorage()">Hapus Semua</button>
                      </div>
                  </div>
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

  <script>
   let selectedCourses = JSON.parse(localStorage.getItem('selectedCourses')) || [];

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
                <h6 class="media-title"><a href="#">${course.name}</a></h6>
                <div class="text-small text-muted">${course.code} <div class="bullet"></div> <span class="text-primary">${course.credits} SKS</span></div>
            </div>`;
        
        selectedCoursesList.appendChild(courseItem);
        totalCredits += course.credits;

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
</body>

</html>