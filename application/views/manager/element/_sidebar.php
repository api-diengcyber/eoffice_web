      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() ?>">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active_absen)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>manager/absen/absen">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              <span class="menu-title">Presensi</span>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active_tugas)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>manager/tugas/my_index">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              <span class="menu-title">Kegiatan Harian</span>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active_kegiatan_harian)) {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>manager/tugas/my_laporan_harian">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              <span class="menu-title">Riwayat Kegiatan</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() ?>manager/tidak_masuk/my_index">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              <span class="menu-title">Ijin Tidak Masuk</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#project" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-airplay"></i>
              <span class="menu-title">Project</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="project">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_project') {
                                      echo 'active';
                                    } ?>">
                  <a class="nav-link" href="<?php echo base_url() ?>manager/project">
                    <i class="menu-icon mdi mdi-briefcase-check"></i>
                    Project
                  </a>
                </li>
                <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_tugas') {
                                      echo 'active';
                                    } ?>">
                  <a class="nav-link" href="<?php echo base_url() ?>manager/tugas">
                    <i class="menu-icon mdi mdi-clipboard-check"></i>
                    Tugas
                  </a>
                </li>
                <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_laporan_harian') {
                                      echo 'active';
                                    } ?>">
                  <a class="nav-link" href="<?php echo base_url() ?>manager/tugas/laporan_harian">
                    <i class="menu-icon mdi mdi-clipboard-check"></i>
                    Laporan Harian
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-settings-box"></i>
              <span class="menu-title">Utilities</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_absen') {
                                      echo 'active';
                                    } ?>">
                  <a class="nav-link" href="<?php echo base_url() ?>manager/absen">
                    <i class="menu-icon mdi mdi-calendar-check"></i>
                    Absen Pegawai
                  </a>
                </li>
                <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_tidak_masuk') {
                                      echo 'active';
                                    } ?>">
                  <a class="nav-link" href="<?php echo base_url() ?>manager/tidak_masuk">
                    <i class="menu-icon mdi mdi-calendar-check"></i>
                    Tidak Masuk
                  </a>
                </li>
              </ul>
            </div>
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