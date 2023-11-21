      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item <?php 
                            if (!empty($active_utilities) && $active_utilities == 'active_home') {
                                echo 'active';
                              } 
                            
                              ?>">
            <a class="nav-link" href="<?php echo base_url() ?>">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item  <?php 
                            if (!empty($active_utilities) && $active_utilities == 'active_absen') {
                                echo 'active';
                              } 
                            
                              ?>">
            <a class="nav-link" href="<?php echo base_url() ?>training/absen">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              <span class="menu-title">Presensi</span>
            </a>
          </li>
          <li class="nav-item  <?php 
                            if (!empty($active_utilities) && $active_utilities == 'active_tugas') {
                                echo 'active';
                              } 
                            
                              ?>">
            <a class="nav-link" href="<?php echo base_url() ?>training/tugas">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              <span class="menu-title">Kegiatan harian</span>
            </a>
          </li>
          <li class="nav-item  <?php 
                            if (!empty($active_utilities) && $active_utilities == 'active_laporan') {
                                echo 'active';
                              } 
                            
                              ?>">
            <a class="nav-link" href="<?php echo base_url() ?>training/tugas/laporan_harian">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              <span class="menu-title">Riwayat Kegiatan</span>
            </a>
          </li>
          <li class="nav-item  <?php 
                            if (!empty($active_utilities) && $active_utilities == 'active_tidak_masuk') {
                                echo 'active';
                              } 
                            
                              ?>">
            <a class="nav-link" href="<?php echo base_url() ?>training/tidak_masuk">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              <span class="menu-title">Ijin Tidak Masuk</span>
            </a>
          </li>
          <li class="nav-item <?php 
                            if (!empty($active_utilities) && $active_utilities == 'active_info') {
                                echo 'active';
                              } 
                            
                              ?>">
            <a class="nav-link" href="<?php echo base_url() ?>training/info">
              <i class="menu-icon mdi mdi-information"></i>
              <span class="menu-title">Info</span>
            </a>
          </li>
          <li class="nav-item <?php 
                            if (!empty($active_utilities) && $active_utilities == 'active_materi') {
                                echo 'active';
                              } 
                            
                              ?>">
            <a class="nav-link" href="<?php echo base_url() ?>training/materi">
              <i class="menu-icon mdi mdi-clipboard-text"></i>
              <span class="menu-title">Materi</span>
            </a>
          </li>
          <li class="nav-item  <?php 
                            if (!empty($active_utilities) && $active_utilities == 'active_kisar') {
                                echo 'active';
                              } 
                            
                              ?>">
            <a class="nav-link" href="<?php echo base_url() ?>training/kritik_saran/create">
              <i class="menu-icon mdi mdi-package-down"></i>
              <span class="menu-title">Kritik & Saran</span>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#inputdata" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-airplay"></i>
              <span class="menu-title">Input data</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?php if (!empty($active_utilities) && $active_utilities == 'daily_sales_report_active') { echo 'show'; } ?>" id="inputdata">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'daily_sales_report_active') { echo 'active'; } ?>">
                    <a class="nav-link" href="<?php echo base_url() ?>training/daily_sales_report">
                        <i class="menu-icon mdi mdi-briefcase-check"></i>
                        Daily Sales Report
                    </a>
                </li>
                <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_spk_report') { echo 'active'; } ?>">
                    <a class="nav-link" href="<?php echo base_url() ?>training/spk_report">
                        <i class="menu-icon mdi mdi-clipboard-check"></i>
                        SPK Report
                    </a>
                </li>
              </ul>
            </div>
          </li> -->
          <li class="nav-item xs-none">
      <a class="nav-link" href="<?php echo base_url('auth/logout') ?>">
        <i class="menu-icon mdi mdi-logout"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
        </ul>
      </nav>
      <div class="main-panel" style="max-width:100%">
        <div class="content-wrapper">