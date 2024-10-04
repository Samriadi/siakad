<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
       
        </form>
        <ul class="navbar-nav navbar-right">
        
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block"><?= $_SESSION['user_loged']?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="features-profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a id="logoutButton"  href="javascript:void(0);" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
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