

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
                        <a href="<?php echo base_url() ?>pegawai/absen">
                            <i class="menu-icon fa fa-pencil"></i>
                            <span class="menu-text"> Absen </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="<?php if (isset($active_transaksi)) { echo 'active'; } ?>">
                        <a href="<?php echo base_url() ?>pegawai/transaksi">
                            <i class="menu-icon fa fa-exchange"></i>
                            <span class="menu-text"> Transaksi </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="<?php if (isset($active_tugas)) { echo 'active'; } ?>">
                        <a href="<?php echo base_url() ?>pegawai/tugas">
                            <i class="menu-icon fa fa-list"></i>
                            <span class="menu-text"> 
                                Tugas 
                                <span class="badge badge-warning" id="t_tugas"></span>
                            </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="<?php if (isset($active_info)) { echo 'active'; } ?>">
                        <a href="<?php echo base_url() ?>pegawai/info">
                            <i class="menu-icon fa fa-info"></i>
                            <span class="menu-text"> Info </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                </ul><!-- /.nav-list -->

                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>
            </div>