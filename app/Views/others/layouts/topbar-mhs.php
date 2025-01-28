<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">

  <ul class="navbar-nav navbar-right justify-content-between w-100">
    <a href="index.html" class="navbar-brand sidebar-gone-hide">SIAKAD - UNIVERSITAS ALMARISAH MADANI</a>
    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
    <div class="nav-collapse">
      <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
        <i class="fas fa-ellipsis-v"></i>
      </a>
    </div>
  </ul>

  <ul class="navbar-nav navbar-right d-flex align-items-center">
    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex align-items-center">
        <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-2">
        <div class="d-sm-none d-lg-inline-block"><?= $_SESSION['user_loged'] ?></div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a id="logoutButton" href="javascript:void(0);" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>
  </ul>

</nav>


<nav class="navbar navbar-secondary navbar-expand-lg">
  <div class="container">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a href="#" class="nav-link"><span>Pembayaran</span></a>
      </li>
    </ul>
  </div>
</nav>">

</ul>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('logoutButton').addEventListener('click', function() {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, logout!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/admin/logout',
          type: 'POST',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Success!',
                text: 'You have been logged out.',
                icon: 'success',
                timer: 1000,
                showConfirmButton: false
              }).then((result) => {
                window.location.href = '/admin';
              });
            } else {
              Swal.fire(
                'Error!',
                'There was a problem logging you out.',
                'error'
              );
            }
          },
          error: function() {
            Swal.fire(
              'Error!',
              'There was a problem logging you out.',
              'error'
            );
          }
        });
      }
    });
  });
</script>