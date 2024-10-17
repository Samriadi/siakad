<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - SETTING</title>
  <?php include '../app/Views/others/layouts/header.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
          <h1>Setting</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Setting</a></div>
          </div>
        </div>

        <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Table List</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>Table</th>
                          <th>Keterangan</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
  <?php foreach($AllTable as $key => $value) : ?>
  <tr>
    <td><?= ++$key ?></td>
    <td><?= $value->page ?></td>
    <td><?= $value->status ?></td>
    <td>
      <button class="btn <?= $value->status === 'Open' ? 'btn-danger' : 'btn-success' ?> toggle-btn" 
              data-id="<?= $value->id ?>" 
              data-status="<?= $value->status ?>" 
              onclick="confirmToggle(this)">
        <?= $value->status === 'Open' ? 'Close' : 'Open' ?>
      </button>
    </td>
  </tr>
  <?php endforeach; ?>
</tbody>


                    </table>
                  </div>
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
  function confirmToggle(button) {
    const id = button.getAttribute('data-id');
    const currentStatus = button.getAttribute('data-status');
    const newStatus = currentStatus === "Open" ? "Closed" : "Open"; // Toggle between 'Open' and 'Closed'
    const newClass = newStatus === "Closed" ? "btn-success" : "btn-danger"; // Adjust button class
    const newText = newStatus === "Closed" ? "Open" : "Close"; // Change button text

    Swal.fire({
      title: 'Are you sure?',
      text: `You are about to ${newText.toLowerCase()} this page!`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, change it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Update button status
        button.innerText = newText;
        button.className = `btn ${newClass} toggle-btn`;
        button.setAttribute('data-status', newStatus); // Update data-status attribute

        $.ajax({
          url: '/admin/siakad/setting/update',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({ id: id, status: newStatus }), // Send newStatus instead of old status
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              Swal.fire({
                text: 'Your data has been updated.',
                icon: 'success',
                showConfirmButton: false,
                willClose: () => {
                  window.location.reload(); // Reload the page after modal is closed
                }
              });
            } else {
              Swal.fire({
                text: 'An error occurred during update.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
          }
        });
      }
    });
  }
</script>


</body>

</html>
