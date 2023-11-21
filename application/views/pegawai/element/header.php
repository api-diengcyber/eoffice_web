<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>e-Office Dieng Cyber</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />

    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.custom.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/chosen.min.css" />
    <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-datepicker3.min.css" /> -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/daterangepicker.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-colorpicker.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/css/datepicker.css">
    <script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.js"></script>

    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/colorbox.min.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ace-rtl.min.css" />

    <script src="<?php echo base_url() ?>assets/js/ace-extra.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-2.1.4.min.js"></script>
    <!-- <![endif]-->
    <script type="text/javascript">
        jQuery(function($) {
            if (typeof(EventSource) !== "undefined") {
                var source = new EventSource("<?php echo base_url() ?>home/sse_pegawai");
                source.onmessage = function(event) {
                    var parsed_data = JSON.parse(event.data);
                    var tugas = parsed_data.tugas.toString();
                    if (tugas * 1 > 0) {
                        $("#t_tugas").text(tugas);
                    }
                };
            } else {}
        });
    </script>
</head>

<body class="skin-3 no-skin">
    <div id="navbar" class="navbar navbar-default ace-save-state">
        <div class="navbar-container ace-save-state" id="navbar-container">
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="navbar-header pull-left">
                <a href="index.html" class="navbar-brand">
                    <small>
                        [E] - Office
                    </small>
                </a>
            </div>

            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">

                    <li class="light-10 dropdown-modal">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <img class="nav-user-photo" src="<?php echo base_url() ?>assets/images/avatars/user.jpg" alt="Jason's Photo" />
                            <span class="user-info">
                                <small>Welcome,</small>
                                <?php echo $users_username ?>
                            </span>
                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="<?php echo base_url() ?>pegawai/users/ganti_password">
                                    <i class="ace-icon fa fa-user"></i>
                                    Ganti Password
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="<?php echo base_url() ?>/auth/logout">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div><!-- /.navbar-container -->
    </div>