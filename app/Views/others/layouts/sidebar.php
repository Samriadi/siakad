<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">SIAKAD</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/">General</a></li>
        </ul>
      </li>
      <li class="menu-header">SIAKAD</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data Master</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/mahasiswa">Mahasiswa</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/ortu">Orang Tua</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/dosen">Dosen</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/staff">Staff</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/matkul">Mata Kuliah</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/perkuliahan">Perkuliahan</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>KRS</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/krs">Kartu Rencana Studi</a></li>
          <li class="nav-item"><a class="nav-link" href="">Detail Mata Kuliah KRS</a></li>
          <li class="nav-item"><a class="nav-link" href="">Persetujuan KRS</a></li>
          <li class="nav-item"><a class="nav-link" href="">Kartu Hasil Studi</a></li>
          <li class="nav-item"><a class="nav-link" href="">Detail Mata Kuliah KHS</a></li>
        </ul>
      </li>

      <li class="menu-header">Pages</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Auth</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a href="/admin/siakad/login">Login</a></li>
        </ul>
      </li>
    </ul>
  </aside>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.sidebar-menu .nav-link');

    menuItems.forEach(item => {
      if (item.getAttribute('href') === currentPath) {
        item.closest('.nav-item').classList.add('active');
        item.closest('.dropdown').classList.add('active');
        item.classList.add('active');
      }
    });
  });
</script>