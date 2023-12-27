<style>
  @media screen and (mac-width:768px) {
    xs-none {
      display: none;
    }
  }
</style>
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
    <li class="nav-item <?php
                        if (!empty($active_utilities) && $active_utilities == 'active_project') {
                          echo 'active';
                        }

                        ?>">
      <a class="nav-link" data-toggle="collapse" href="#project" aria-expanded="false" aria-controls="ui-basic">
        <i class="menu-icon mdi mdi-airplay"></i>
        <span class="menu-title">Projects</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse 
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_project') {
                                echo 'show';
                              } elseif (!empty($active_task) && $active_task == 'active_task') {
                                echo 'show';
                              } elseif (!empty($active_utilities) && $active_utilities == 'active_tugas') {
                                echo 'show';
                              } else { } ?>
      " id="project">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_project') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/project">
              <i class="menu-icon mdi mdi-briefcase-check"></i>
              Project
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_project_board) && $active_project_board == 'active_project') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/project-board">
              <i class="menu-icon mdi mdi-briefcase-check"></i>
              Project Board
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_task) && $active_task == 'active_task') {
                                echo 'active';
                              } ?>">

            <a class="nav-link" href="<?php echo base_url() ?>admin/tasks">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              <span class="menu-title">Tugas Project Board </span>
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_tugas') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/tugas">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              Tugas
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_laporan_harian') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/tugas/laporan_harian">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              Laporan Harian
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_kpi') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/KPI">
              <i class="menu-icon mdi mdi-chart-bar"></i>
              KPI
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
            <a class="nav-link" href="<?php echo base_url() ?>admin/absen">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              Presensi Pegawai
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_tidak_masuk') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/tidak_masuk">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              Tidak Masuk
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#monitor" aria-expanded="false" aria-controls="ui-basic">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Monitor WFH</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="monitor">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_monitor_layar') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/monitor_layar">
              <i class="menu-icon mdi mdi-television"></i>
              Monitor kerja
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_jadwal_monitor') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/jadwal_monitor">
              <i class="menu-icon mdi mdi-tag"></i>
              Penjadwalan
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#sosmed" aria-expanded="false" aria-controls="ui-basic">
        <i class="menu-icon mdi mdi-message"></i>
        <span class="menu-title">Social Media</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="sosmed">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item <?php if (!empty($active_sosmed) && $active_sosmed == 'active_sosmed_wa') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/sosmed/whatsapp">
              <i class="menu-icon mdi mdi-whatsapp"></i>
              WhatsApp
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_sosmed) && $active_sosmed == 'active_sosmed_ig') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/sosmed/instagram">
              <i class="menu-icon mdi mdi-instagram"></i>
              Instagram
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item  <?php if (!empty($active_utilities) && $active_utilities == 'active_register_kantor') {
                            echo 'active';
                          } ?>
                          <?php if (!empty($active_utilities) && $active_utilities == 'active_kantor') {
                            echo 'active';
                          } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_pegawai') {
                                echo 'active';
                              } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_hari_kerja') {
                                echo 'active';
                              } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_level') {
                                echo 'active';
                              } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_tingkat') {
                                echo 'active';
                              } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_jabatan') {
                                echo 'active';
                              } ?>">
      <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="menu-icon mdi mdi-briefcase"></i>
        <span class="menu-title">Master</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse <?php if (!empty($active_utilities) && $active_utilities == 'active_register_kantor') {
                              echo 'show';
                            } ?>
                            <?php if (!empty($active_utilities) && $active_utilities == 'active_kantor') {
                              echo 'show';
                            } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_pegawai') {
                                echo 'show';
                              } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_hari_kerja') {
                                echo 'show';
                              } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_level') {
                                echo 'show';
                              } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_tingkat') {
                                echo 'show';
                              } ?>
                              <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_jabatan') {
                                echo 'show';
                              } ?>
                              
                              " id="auth">
        <ul class="nav flex-column sub-menu">
          <?php if ($users_id == "4") { ?>
            <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_register_kantor') {
                                    echo 'active';
                                  } ?>">
              <a class="nav-link" href="<?php echo base_url() ?>admin/register_kantor">
                <i class="menu-icon mdi mdi-home-modern"></i>
                Register Kantor
              </a>
            </li>
          <?php } ?>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_kantor') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/kantor">
              <i class="menu-icon mdi mdi-home-modern"></i>
              Kantor
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_pegawai') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/pegawai">
              <i class="menu-icon mdi mdi-account-multiple"></i>
              Pegawai
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_hari_kerja') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/hari_kerja">
              <i class="menu-icon mdi mdi-calendar"></i>
              Hari Kerja
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_master) && $active_master == 'active_jam_kerja') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/hari_kerja/jam_kerja_aktif">
              <i class="menu-icon fa fa-calendar"></i>
              Jam Kerja
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_level') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/pil_level">
              <i class="menu-icon mdi mdi-star"></i>
              Pilihan Level
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_jabatan') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/pil_jabatan">
              <i class="menu-icon mdi mdi-star"></i>
              Pilihan Jabatan
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_pil_tingkat') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/pil_tingkat">
              <i class="menu-icon mdi mdi-star"></i>
              Pilihan Tingkat
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_presensi') {
                          echo 'active';
                        } ?>">
      <a class="nav-link" data-toggle="collapse" href="#upgrade" aria-expanded="false" aria-controls="upgrade">
        <i class="menu-icon mdi mdi-package-up"></i>
        <span class="menu-title">Perbarui data absen</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse <?php if (!empty($active_utilities) && $active_utilities == 'active_presensi') {
                              echo 'show';
                            } ?>" id="upgrade">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_presensi') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/presensi">
              <i class="menu-icon mdi mdi-calendar-check"></i>
              Presensi
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_kisar') {
                          echo 'active';
                        } ?>">
      <a class="nav-link" href="<?php echo base_url() ?>admin/kritik_saran">
        <i class="menu-icon mdi mdi-package-down"></i>
        <span class="menu-title">Kritik & Saran</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#inputdata" aria-expanded="false" aria-controls="ui-basic">
        <i class="menu-icon mdi mdi-airplay"></i>
        <span class="menu-title">Input data</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse <?php if (!empty($active_utilities) && $active_utilities == 'daily_sales_report_active') {
                              echo 'show';
                            } ?>" id="inputdata">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'daily_sales_report_active') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/daily_sales_report">
              <i class="menu-icon mdi mdi-briefcase-check"></i>
              Daily Sales Report
            </a>
          </li>
          <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_spk_report') {
                                echo 'active';
                              } ?>">
            <a class="nav-link" href="<?php echo base_url() ?>admin/spk_report">
              <i class="menu-icon mdi mdi-clipboard-check"></i>
              SPK Report
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_materi') {
                          echo 'active';
                        } ?>">
      <a class="nav-link" href="<?php echo base_url() ?>admin/materi">
        <i class="menu-icon mdi mdi-clipboard-text"></i>
        <span class="menu-title">Materi</span>
      </a>
    </li>
    <li class="nav-item <?php if (!empty($active_utilities) && $active_utilities == 'active_info') {
                          echo 'active';
                        } ?>">
      <a class="nav-link" href="<?php echo base_url() ?>admin/info">
        <i class="menu-icon mdi mdi-information"></i>
        <span class="menu-title">Info</span>
      </a>
    </li>
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