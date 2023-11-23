<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>TANGAN ANGIE OFFICE</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" />
  <script src="<?php echo base_url(); ?>assets/vendors/js/vendor.bundle.base.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/css/datepicker.css">
  <script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.js"></script>

  <!-- Dropify -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dropify/dropify.min.css">
  <script src="<?php echo base_url(); ?>assets/dropify/dropify.min.js"></script>
  <!-- End Dropify -->

  <style>
    table.dataTable {
      border-collapse: collapse !important;
    }

    .input-group-append,
    .input-group-prepend {
      background: #ffffff;
      color: black;
      width: auto;
      padding: 10px;
      box-shadow: 0 0 1px white;
    }

    .sidebar .nav .nav-item .nav-link {
      color: black !important;
    }

    body {
      color: black;
    }

    /* width */
    ::-webkit-scrollbar {
      width: 10px;
      height: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    .navbar.default-layout {
      font-family: "Poppins", sans-serif;
      background: -webkit-linear-gradient(30deg, #897b14, #000000);
      background: -o-linear-gradient(30deg, #897b14, #000000);
      background: linear-gradient(120deg, #897b14, #000000);
      linear-gradient(120deg, #897b14, #000000)
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo base_url() ?>">
          <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url() ?>">
          <img src="<?php echo base_url(); ?>assets/images/logo-mini.png" alt="logo" style="width:auto" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Hello, <?php echo $users_username ?> !</span>
              <img class="img-xs rounded-circle" src="<?php echo base_url(); ?>assets/images/logo-mini.png" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <a class="dropdown-item p-0">
                <div class="d-flex border-bottom">
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                    <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                  </div>
                </div>
              </a>
              <a href="<?php echo base_url() ?>admin/users/ganti_password" class="dropdown-item">
                Change Password
              </a>
              <a href="<?php echo base_url() ?>/auth/logout" class="dropdown-item">
                Sign Out
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">