<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>E OFFICE</title>
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
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logoeoffice.ico" />
  <script src="<?php echo base_url(); ?>assets/vendors/js/vendor.bundle.base.js"></script>
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

    .steps {
      position: relative;
      top: 50%;
      -webkit-transform: translateY(-50%);
      transform: translateY(-50%);
    }

    .steps {
      list-style: none;
      display: table;
      width: 100%;
      padding: 0;
      margin: 0;
      position: relative
    }

    .steps>li {
      display: table-cell;
      text-align: center;
      width: 1%
    }

    .steps>li .step {
      border: 5px solid #CED1D6;
      color: #546474;
      font-size: 15px;
      border-radius: 100%;
      position: relative;
      z-index: 2;
      display: inline-block;
      width: 40px;
      height: 40px;
      background-color: white !important;
    }

    .steps>li:before {
      display: block;
      content: "";
      width: 100%;
      height: 1px;
      font-size: 0;
      overflow: hidden;
      border-top: 4px solid #CED1D6;
      position: relative;
      top: 21px;
      z-index: 1
    }

    .steps>li.last-child:before {
      max-width: 50%;
      width: 50%
    }

    .steps>li:last-child:before {
      max-width: 50%;
      width: 50%
    }

    .steps>li:first-child:before {
      max-width: 51%;
      left: 50%
    }

    .steps>li.active {
      border-color: #5293C4;
      background-color: blue;
    }

    .steps>li.active .step,
    .steps>li.active:before,
    .steps>li.complete .step,
    .steps>li.complete:before {
      border-color: #5293C4;
      background-color: blue;
    }

    .steps>li.complete .step {
      cursor: default;
      color: #FFF;
      -webkit-transition: transform ease .1s;
      -o-transition: transform ease .1s;
      transition: transform ease .1s
    }

    .steps>li.complete .step:before {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      border-radius: 100%;
      content: "\f00c";
      z-index: 3;
      font-family: FontAwesome;
      font-size: 17px;
      color: #87BA21
    }

    .step-content,
    .tree {
      position: relative
    }

    .steps>li.complete:hover .step {
      -moz-transform: scale(1.1);
      -webkit-transform: scale(1.1);
      -o-transform: scale(1.1);
      -ms-transform: scale(1.1);
      transform: scale(1.1);
      border-color: #80afd4
    }

    .steps>li.complete:hover:before {
      border-color: #80afd4
    }

    .steps>li .title {
      display: block;
      margin-top: 4px;
      max-width: 100%;
      color: #949EA7;
      font-size: 14px;
      z-index: 104;
      text-align: center;
      table-layout: fixed;
      word-wrap: break-word
    }

    .steps>li.active .title,
    .steps>li.complete .title {
      color: #2B3D53
    }

    .step-content .step-pane {
      display: none;
      min-height: 200px;
      padding: 4px 8px 12px
    }

    .step-content .step-pane.active {
      display: block
    }

    .wizard-actions {
      text-align: right
    }

    @media only screen and (max-width:767px) {

      .steps li .step,
      .steps li:after,
      .steps li:before {
        border-width: 3px
      }

      .steps li .step {
        width: 30px;
        height: 30px;
        line-height: 24px
      }

      .steps li.complete .step:before {
        line-height: 24px;
        font-size: 13px
      }

      .steps li:before {
        top: 16px
      }

      .step-content .step-pane {
        padding: 4px 4px 6px;
        min-height: 150px
      }
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
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>

  <script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
      appId: "<?php echo APPID; ?>",
      subdomainName: 'push',
      autoRegister: true,
      allowLocalhostAsSecureOrigin: true,
      promptOptions: {
        /* These prompt options values configure both the HTTP prompt and the HTTP popup. */
        /* actionMessage limited to 90 characters */
        actionMessage: "<?php echo ACTIONMESSAGE; ?>",
        /* acceptButtonText limited to 15 characters */
        acceptButtonText: "<?php echo ACCEPTBUTTONTEXT; ?>",
        /* cancelButtonText limited to 15 characters */
        cancelButtonText: "<?php echo CANCELBUTTONTEXT; ?>"
      }
    }]);
  </script>
  <script>
    function subscribe() {
      // OneSignal.push(["registerForPushNotifications"]);
      OneSignal.push(["registerForPushNotifications"]);
      event.preventDefault();
    }

    function unsubscribe() {
      OneSignal.setSubscription(true);
    }

    var OneSignal = OneSignal || [];
    OneSignal.push(function() {
      OneSignal.sendTag("user_id", "<?php echo $users_id_pegawai; ?>", function(tagsSent) {
        // Callback called when tags have finished sending
        console.log("Tags have finished sending!");
      });
      /* These examples are all valid */
      // Occurs when the user's subscription changes to a new value.
      OneSignal.on('subscriptionChange', function(isSubscribed) {
        console.log("The user's subscription state is now:", isSubscribed);
        OneSignal.sendTag("user_id", "<?php echo $users_id_pegawai; ?>", function(tagsSent) {
          // Callback called when tags have finished sending
          console.log("Tags have finished sending!");
        });
      });

      var isPushSupported = OneSignal.isPushNotificationsSupported();
      if (isPushSupported) {
        // Push notifications are supported
        OneSignal.isPushNotificationsEnabled().then(function(isEnabled) {
          if (isEnabled) {
            console.log("Push notifications are enabled!");

          } else {
            OneSignal.showHttpPrompt();
            console.log("Push notifications are not enabled yet.");
          }
        });

      } else {
        console.log("Push notifications are not supported.");
      }
    });
  </script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php if (empty($no_nav)) { ?>
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="<?php echo base_url() ?>">
            <img src="<?php echo base_url(); ?>assets/images/logoe-office.png" alt="logo" style="object-fit:contain;" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="<?php echo base_url() ?>">
            <img src="<?php echo base_url(); ?>assets/images/logoeoffice.png" alt="logo" style="width:auto" />
          </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-xl-inline-block">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <span class="profile-text">Hello, <?php echo $users_username ?> !</span>
                <img class="img-xs rounded-circle" src="<?php echo base_url(); ?>assets/images/logoeoffice.png" alt="Profile image">
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
                <a href="<?php echo base_url() ?>deleteaccount" class="dropdown-item" style="color:red!important;">
                  Permohonan hapus akun
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

    <?php } ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper" <?php if (!empty($no_nav)) {
                                                      echo 'style="padding-top:0px;"';
                                                    } ?>>