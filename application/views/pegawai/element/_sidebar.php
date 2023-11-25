      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() ?>">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

          <li class="nav-item <?php if (isset($active_project_board)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/project-board">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              <span class="menu-title">Project Board</span>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active_absen)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/absen">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              <span class="menu-title">Presensi</span>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active_status_kerja)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/status_kerja">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              <span class="menu-title">Jam WFH</span>
            </a>
          </li>
          <!--
          <li class="nav-item <?php if (isset($active_transaksi)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/transaksi">
              <i class="menu-icon mdi mdi-swap-vertical"></i>
              <span class="menu-title">Transaksi</span>
            </a>
          </li>
         -->
          <li class="nav-item <?php if (isset($active_tugas) && $active_tugas == 'harian') {

                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/tugas">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              <span class="menu-title">Kegiatan Harian </span>
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_tugas) && $active_tugas != 'harian') {

                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/tugas/laporan_harian">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              <span class="menu-title">Riwayat Kegiatan </span>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active_tidak_masuk)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/tidak_masuk">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              <span class="menu-title">Ijin Tidak Masuk</span>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active_info)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/info">
              <i class="menu-icon mdi mdi-information"></i>
              <span class="menu-title">Info</span>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active_saran)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>pegawai/kritik_saran/create">
              <i class="menu-icon mdi mdi-package-down"></i>
              <span class="menu-title">Kritik & Saran</span>
            </a>
          </li>
          <style>
            @media screen and (mac-width:768px) {
              xs-none {
                display: none;
              }
            }
          </style>
          <li class="nav-item xs-none">
            <a class="nav-link " href="<?php echo base_url('auth/logout') ?>">
              <i class="menu-icon mdi mdi-logout"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
        </ul>
      </nav>
      <div class="main-panel" style="max-width:100%">
        <div class="content-wrapper">