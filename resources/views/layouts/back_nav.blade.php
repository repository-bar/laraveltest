<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
    <div class="sidebar-brand-icon">
        <i class="fas fa-home"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SAMPLE CRUD</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - home -->
    <li class="nav-item">
    <a class="nav-link" href="{{ url('/home') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
    Konten
    </div>

    <!-- Nav Item - Banner -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/banners') }}">
        <i class="fas fa-images"></i>
        <span>Gambar Banner</span></a>
    </li>

    <!-- Nav Item - Berita -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/news') }}">
        <i class="fas fa-newspaper"></i>
        <span>Berita</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Profil -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/categories') }}">
        <i class="fas fa-database    "></i>
        <span>Daftar Menu</span></a>
    </li>

    <!-- Nav Item - Organinsasi -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/submenus') }}">
        <i class="fas fa-book    "></i>
        <span>Konten Sub Menu</span></a>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

   <!-- Nav Item - Admin -->
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/users') }}">
        <i class="fas fa-chalkboard-teacher"></i>
      <span>Manajemen Akun Admin</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>