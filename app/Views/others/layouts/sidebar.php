<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">SIAKAD</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header">Admin Area</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/">General Information</a></li>
          <?php if ($_SESSION['user_loged'] == 'kaprodi' || $_SESSION['user_loged'] == 'superadmin') : ?>
            <li class="nav-item"><a class="nav-link" href="/admin/siakad/setting">Setup</a></li>
          <?php endif ?>

        </ul>
      </li>
    </ul>

    <ul class="sidebar-menu">

      <li class="menu-header">Setup</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Master Data</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/matkul">Mata Kuliah</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/mahasiswa">Mahasiswa</a></li>
          <!-- <li class="nav-item"><a class="nav-link" href="/admin/siakad/ortu">Orang Tua</a></li> -->
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/dosen">Dosen</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/prodi">Program Studi</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/fakultas">Fakultas</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/angkatan">Angkatan</a></li>
          <?php if ($_SESSION['user_loged'] == 'kaprodi' || $_SESSION['user_loged'] == 'superadmin') : ?>
            <!-- <li class="nav-item"><a class="nav-link" href="/admin/siakad/staff">Staff</a></li> -->
          <?php endif ?>
        </ul>
      </li>

    </ul>


    <ul class="sidebar-menu">
      <li class="menu-header">SIAKAD</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Administrasi</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/pembayaran">Payment Type</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/tagihan">Master Tagihan</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/adjustment">Setup Tagihan</a></li>
          <!-- <li class="nav-item"><a class="nav-link" href="/admin/siakad/tagihan-mhs">Tagihan Mahasiswa</a></li> -->
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/invoice">Tagihan Mahasiswa</a></li>

        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Akademik</span></a>
        <ul class="dropdown-menu">
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/krs">Kartu Rencana Studi</a></li>
          <li class="nav-item"><a class="nav-link" href="">Detail Mata Kuliah KRS</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/persetujuan-krs">Persetujuan KRS</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/siakad/khs">Kartu Hasil Studi</a></li>
          <li class="nav-item"><a class="nav-link" href="">Detail Mata Kuliah KHS</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Kurikulum</span></a>
        <ul class="dropdown-menu">


          <li class="nav-item"><a class="nav-link" href="/admin/siakad/perkuliahan">Perkuliahan</a></li>
        </ul>
      </li>

    </ul>


  </aside>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname.replace(/\/$/, ""); // Hapus trailing slash jika ada
    const pathAfterSiakad = currentPath.split('/siakad')[1]; // Ambil bagian setelah '/siakad'
    const menuItems = document.querySelectorAll('.sidebar-menu .nav-link');

    menuItems.forEach(item => {
      // Ambil href dari item dan pastikan tidak ada trailing slash
      const href = item.getAttribute('href').replace(/\/$/, "");

      // Ambil bagian setelah '/siakad' di href
      const pathAfterSiakadMenu = href.split('/siakad')[1];

      // Periksa apakah bagian dari currentPath mengandung bagian dari pathAfterSiakadMenu
      if (pathAfterSiakadMenu && currentPath.includes(pathAfterSiakadMenu)) {
        item.closest('.nav-item').classList.add('active');
        item.closest('.dropdown').classList.add('active');
        item.classList.add('active');
      }
    });
  });
</script>