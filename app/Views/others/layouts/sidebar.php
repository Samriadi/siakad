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
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/persetujuan-krs">Persetujuan KRS</a></li> 
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/khs">Kartu Hasil Studi</a></li>
          <li class="nav-item"><a class="nav-link" href="">Detail Mata Kuliah KHS</a></li>
        </ul>
      </li>
      
      <li class="menu-header">Pages</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Pengaturan</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/setting">Setting</a></li>
        </ul>
      </li> 
    </ul>
  </aside>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
  const currentPath = window.location.pathname.replace(/\/$/, ""); // Hapus trailing slash jika ada
  const menuItems = document.querySelectorAll('.sidebar-menu .nav-link');

  menuItems.forEach(item => {
    // Periksa apakah href item sama dengan path saat ini
    const href = item.getAttribute('href').replace(/\/$/, ""); // Hapus trailing slash juga pada href
    if (href === currentPath) {
      item.closest('.nav-item').classList.add('active');
      item.closest('.dropdown').classList.add('active');
      item.classList.add('active');
    }
  });
});

</script>