<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SeoDash Free Bootstrap Admin Template by Adminmart</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/seodashlogo.png'); ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/libs/simplebar/dist/simplebar.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/sweetalert2/sweetalert2.min.css') ?>">
  <script src="<?= base_url('assets/sweetalert2/sweetalert2.min.js') ?>"></script>
  <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/libs/apexcharts/dist/apexcharts.min.js'); ?>"></script>
  <script src="<?= base_url('assets/libs/simplebar/dist/simplebar.js'); ?>"></script>
  <script src="<?= base_url('assets/js/sidebarmenu.js'); ?>"></script>
  <script src="<?= base_url('assets/js/app.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/dashboard.js'); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</head>
  
  <body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
      data-sidebar-position="fixed" data-header-position="fixed">
      <!-- Sidebar Start -->
      <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html">
              <h1>Kelompok 3</h1>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
          </div>
          
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">Home</span>
            </li>

        <!-- IYEU SIDEBAR -->
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('admin'); ?>" aria-expanded="false">
            <span>
            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Home</span>
        </a>
        </li>
        <li class="sidebar-item">
        <a class="sidebar-link" href="<?= base_url('outlet'); ?>" aria-expanded="false">
            <span>
            <iconify-icon  class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">My Outlet</span>
        </a>
        </li>
        <li class="sidebar-item">
        <a class="sidebar-link" href="./product.html" aria-expanded="false">
            <span>
            <iconify-icon class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Product</span>
        </a>
        </li>
        <li class="sidebar-item">
        <a class="sidebar-link" href="./admin.html" aria-expanded="false">
            <span>
            <iconify-icon class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">Admin</span>
        </a>
        </li>
        <li class="sidebar-item">
        <a class="sidebar-link" href="./about.html" aria-expanded="false">
            <span>
            <iconify-icon class="fs-6"></iconify-icon>
            </span>
            <span class="hide-menu">About Me</span>
        </a>
        </li>
    

            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6" class="fs-6"></iconify-icon>
              <span class="hide-menu">AUTH</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:login-3-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Login</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:user-plus-rounded-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Register</span>
              </a>
            </li>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="<?= base_url('assets/images/profile/user-1.jpg'); ?>" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="<?= base_url('login/logout'); ?>" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->