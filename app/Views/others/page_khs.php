<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - KHS</title>
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
          <h1>KHS</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Kartu Rencana Studi</a></div>
          </div>
        </div>
        <div class="section-body">
          <div class="row">
            <div class="col-lg-5 col-md-6 col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="d-inline">Kartu Hasil Studi</h4>
                </div>
                <div class="card-body">
                  <form action="process_khs.php" method="POST">
                    <div class="form-group">
                      <label for="student_id">ID Mahasiswa</label>
                      <input type="text" class="form-control" name="student_id" required>
                    </div>
                    <div class="form-group">
                      <label for="semester">Semester</label>
                      <input type="text" class="form-control" name="semester" required>
                    </div>
                    <div class="form-group">
                      <label for="academic_year">Tahun Akademik</label>
                      <input type="text" class="form-control" name="academic_year" required>
                    </div>
                    <div class="form-group">
                      <label for="gpa">IPK</label>
                      <input type="number" step="0.01" class="form-control" name="gpa" required>
                    </div>
                    <div class="form-group">
                      <label for="total_credits_earned">SKS Diperoleh</label>
                      <input type="number" class="form-control" name="total_credits_earned" required>
                    </div>
                    <div class="form-group">
                      <label for="total_credits_attempted">SKS Diambil</label>
                      <input type="number" class="form-control" name="total_credits_attempted" required>
                    </div>
                    <h4>Daftar Nilai Mata Kuliah</h4>
                    <div id="course-list">
                      <div class="form-group">
                        <input type="text" class="form-control" name="course_id[]" placeholder="ID Mata Kuliah" required>
                        <input type="text" class="form-control" name="grade[]" placeholder="Nilai" required>
                        <input type="number" class="form-control" name="credits[]" placeholder="SKS" required>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                      <button type="button" class="btn btn-secondary" onclick="addCourse()">Tambah Mata Kuliah</button>
                      <button type="submit" class="btn btn-primary">Simpan KHS</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <!-- Footer -->
  <?php include '../app/Views/others/layouts/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function addCourse() {
      const courseList = document.getElementById('course-list');
      const newCourse = `
        <div class="form-group">
          <input type="text" class="form-control" name="course_id[]" placeholder="ID Mata Kuliah" required>
          <input type="text" class="form-control" name="grade[]" placeholder="Nilai" required>
          <input type="number" class="form-control" name="credits[]" placeholder="SKS" required>
        </div>
      `;
      courseList.insertAdjacentHTML('beforeend', newCourse);
    }
  </script>
</body>
</html>