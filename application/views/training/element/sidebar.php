

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try{ace.settings.loadState('main-container')}catch(e){}
            </script>

            <div id="sidebar" class="sidebar responsive ace-save-state">
                <script type="text/javascript">
                    try{ace.settings.loadState('sidebar')}catch(e){}
                </script>

                <ul class="nav nav-list">

                    <li class="<?php if (isset($active_home)) { echo 'active'; } ?>">
                        <a href="<?php echo base_url() ?>">
                            <i class="menu-icon fa fa-home"></i>
                            <span class="menu-text"> Beranda </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="<?php if (isset($active_absen)) { echo 'active'; } ?>">
                        <a href="<?php echo base_url() ?>marketing/absen">
                            <i class="menu-icon fa fa-pencil"></i>
                            <span class="menu-text"> Absen </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="<?php if (isset($active_tugas)) { echo 'active'; } ?>">
                        <a href="<?php echo base_url() ?>marketing/tugas">
                            <i class="menu-icon fa fa-list"></i>
                            <span class="menu-text"> 
                                Tugas 
                                <span class="badge badge-warning" id="t_tugas"></span>
                            </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="<?php if (!empty($active_daily_sales_report) || (!empty($active_spk_report)) || (!empty($active_do_report)) || (!empty($active_happy_call))) { echo 'active open'; } ?>">
                      <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-pencil"></i>
                        <span class="menu-text">Input Data</span>
                        <b class="arrow fa fa-angle-down"></b>
                      </a>
                      <b class="arrow"></b>
                      <ul class="submenu">

                        <li class="<?php if (isset($active_daily_sales_report)) { echo 'active'; } ?>">
                            <a href="<?php echo base_url() ?>marketing/daily_sales_report">
                                <i class="menu-icon fa fa-book"></i>
                                <span class="menu-text"> Daily Sales Report </span>
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="<?php if (isset($active_spk_report)) { echo 'active'; } ?>">
                            <a href="<?php echo base_url() ?>marketing/spk_report">
                                <i class="menu-icon fa fa-book"></i>
                                <span class="menu-text"> SPK Report </span>
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