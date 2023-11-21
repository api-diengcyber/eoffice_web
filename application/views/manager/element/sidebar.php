
        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try{ace.settings.loadState('main-container')}catch(e){}
            </script>

            <div id="sidebar" class="sidebar responsive ace-save-state">
                <script type="text/javascript">
                    try{ace.settings.loadState('sidebar')}catch(e){}
                </script>

                <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                        <button class="btn btn-success">
                            <i class="ace-icon fa fa-signal"></i>
                        </button>

                        <button class="btn btn-info">
                            <i class="ace-icon fa fa-pencil"></i>
                        </button>

                        <button class="btn btn-warning">
                            <i class="ace-icon fa fa-users"></i>
                        </button>

                        <button class="btn btn-danger">
                            <i class="ace-icon fa fa-cogs"></i>
                        </button>
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="btn btn-success"></span>

                        <span class="btn btn-info"></span>

                        <span class="btn btn-warning"></span>

                        <span class="btn btn-danger"></span>
                    </div>
                </div><!-- /.sidebar-shortcuts -->

                <ul class="nav nav-list">

                    <li class="<?php if (isset($active_home)) { echo 'active'; } ?>">
                        <a href="<?php echo base_url() ?>">
                            <i class="menu-icon fa fa-tachometer"></i>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="<?php if (isset($active_utilities)) { echo 'active open'; } ?>">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-cog"></i>
                            <span class="menu-text">
                                Utilities
                            </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="<?php if (!empty($active_utilities) && $active_utilities == 'active_absen') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/absen">
                                    <i class="menu-icon fa fa-pencil"></i>
                                    Absen Pegawai
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_utilities) && $active_utilities == 'active_tidak_masuk') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/tidak_masuk">
                                    <i class="menu-icon fa fa-check-square-o"></i>
                                    Tidak Masuk
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_utilities) && $active_utilities == 'active_jurnal') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/jurnal">
                                    <i class="menu-icon fa fa-pencil"></i>
                                    Jurnal
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_utilities) && $active_utilities == 'active_tugas') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/tugas">
                                    <i class="menu-icon fa fa-arrow-circle-o-down"></i>
                                    Tugas
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_utilities) && $active_utilities == 'active_info') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/info">
                                    <i class="menu-icon fa fa-info"></i>
                                    Info
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_utilities) && $active_utilities == 'active_transaksi') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/transaksi">
                                    <i class="menu-icon fa fa-exchange"></i>
                                    Transaksi
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>

                    <li class="<?php if (isset($active_master)) { echo 'active open'; } ?>">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-list"></i>
                            <span class="menu-text">
                                Master
                            </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="<?php if (!empty($active_master) && $active_master == 'active_pegawai') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/pegawai">
                                    <i class="menu-icon fa fa-users"></i>
                                    Pegawai
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_master) && $active_master == 'active_hari_kerja') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/hari_kerja">
                                    <i class="menu-icon fa fa-calendar"></i>
                                    Hari Kerja
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_master) && $active_master == 'active_pil_level') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/pil_level">
                                    <i class="menu-icon fa fa-upload"></i>
                                    Pilihan Level
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_master) && $active_master == 'active_pil_tingkat') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/pil_tingkat">
                                    <i class="menu-icon fa fa-upload"></i>
                                    Pilihan Tingkat
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_master) && $active_master == 'active_akun') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/akun">
                                    <i class="menu-icon fa fa-list"></i>
                                    Akun
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_master) && $active_master == 'active_pil_transaksi') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/pil_transaksi">
                                    <i class="menu-icon fa fa-exchange"></i>
                                    Pilihan Transaksi
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>

                    <li class="<?php if (isset($active_upgrade)) { echo 'active open'; } ?>">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-upload"></i>
                            <span class="menu-text">
                                Upgrade
                            </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="<?php if (!empty($active_upgrade) && $active_upgrade == 'active_presensi') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/presensi">
                                    <i class="menu-icon fa fa-users"></i>
                                    Presensi
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>

                    <li class="<?php if (isset($active_report)) { echo 'active open'; } ?>">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-book"></i>
                            <span class="menu-text">
                                Report
                            </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">

                            <li class="<?php if (!empty($active_report) && $active_report == 'active_daily_sales_report') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/daily_sales_report">
                                    <i class="menu-icon fa fa-book"></i>
                                    <span class="menu-text"> Daily Sales Report </span>
                                </a>
                                <b class="arrow"></b>
                            </li>

                            <li class="<?php if (!empty($active_report) && $active_report == 'active_spk_report') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/spk_report">
                                    <i class="menu-icon fa fa-book"></i>
                                    <span class="menu-text"> SPK Report </span>
                                </a>
                                <b class="arrow"></b>
                            </li>

                            <li class="<?php if (!empty($active_report) && $active_report == 'active_laporan_gaji') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/laporan">
                                    <i class="menu-icon fa fa-book"></i>
                                    Laporan Gaji
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="<?php if (!empty($active_report) && $active_report == 'active_cetak_gaji') { echo 'active'; } ?>">
                                <a href="<?php echo base_url() ?>admin/absen/cetak">
                                    <i class="menu-icon fa fa-file"></i>
                                    Cetak Gaji
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>

                </ul><!-- /.nav-list -->

                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>
            </div>