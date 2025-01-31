<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SIAKAD - Profile</title>
  <?php include '../app/Views/others/layouts/header.php'; ?>
  <style>
    input[disabled] {
      background-color: #fff !important;
      color: rgb(149, 152, 155) !important;
      opacity: 1 !important;
      border: 1px solidrgb(198, 202, 206) !important;
    }
  </style>

<body>
  <div id="app">
    <?php include '../app/Views/others/layouts/topbar.php'; ?>
    <?php include '../app/Views/others/layouts/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1>Profile</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
          </div>
        </div>
        <div class="section-body">
          <div class="row mt-sm-4">
            <div class="col-12">
              <div class="card">
                <form method="post" class="needs-validation" novalidate="">
                  <div class="card-header">
                    <h4>Edit Profile</h4>
                  </div>
                  <?php if ($_SESSION['user_type'] == 'mahasiswa') : ?>
                    <?php foreach ($data as $item) : ?>
                      <div class="card-body">
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?php echo $item->ID; ?>">
                            <label>Full Name</label>
                            <input type="text" class="form-control" value="<?php echo $item->NamaLengkap; ?>" disabled>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>User Name</label>
                            <input type="text" class="form-control" value="<?php echo $item->UserName; ?>" disabled>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>User Email</label>
                            <input type="email" class="form-control" value="<?php echo $item->Email; ?>" disabled>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Reset User Pass</label>
                            <input type="tel" class="form-control" name="user_pass" id="user_pass" value="">
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <?php foreach ($data as $item) : ?>
                      <div class="card-body">
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?php echo $item->userid; ?>">
                            <label>Full Name</label>
                            <input type="text" class="form-control" value="<?php echo $item->full_name; ?>" disabled>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>User Name</label>
                            <input type="text" class="form-control" value="<?php echo $item->username; ?>" disabled>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>User Email</label>
                            <input type="email" class="form-control" value="<?php echo $item->useremail; ?>" disabled>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>User Pass</label>
                            <input type="tel" class="form-control" name="user_pass" id="user_pass" value="">
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  <div class="card-footer text-right">
                    <button class="btn btn-primary btn-changes" type="button">Save Changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </section>
    </div>
    </section>

    <!-- Footer -->
    <?php include '../app/Views/others/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $('.btn-changes').on('click', function() {
        Swal.fire({
          title: 'Are you sure?',
          text: 'Do you want to apply these changes?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, change it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            var arrayData = [{
              userid: $('#user_id').val(),
              userpass: $('#user_pass').val(),
            }];

            $.ajax({
              url: '/admin/siakad/profile/changes',
              type: 'POST',
              contentType: 'application/json',
              data: JSON.stringify(arrayData),
              dataType: 'json',
              success: function(response) {
                if (response.success) {
                  Swal.fire({
                    text: 'Your data has been changed.',
                    icon: 'success',
                    showConfirmButton: false,
                    willClose: () => {
                      window.location.reload();
                    }
                  });
                } else {
                  Swal.fire({
                    text: 'An error occurred during the changes.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                Swal.fire({
                  text: 'An unexpected error occurred.',
                  icon: 'error',
                  confirmButtonText: 'OK'
                });
              }
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              text: 'Your changes were not applied.',
              icon: 'info',
              confirmButtonText: 'OK'
            });
          }
        });
      });
    </script>


</body>

</html>