
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login | e-Office</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, follow">

  <script src="<?php echo base_url();?>assets/js/optimize.js"></script>
  <style type="text/css">
    body {
      background-color: #85c51f!important;
    }
    .login-step-wrapper .login-form-wrapper .login-form .login-form-button {
        color: #fff!important;
        cursor: pointer!important;
        border: 1px solid #03A9F4!important;
        background-color: #03A9F4!important;
    }
    a {
      color:white!important;
    }
  </style>
  <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/style-login.css">

  <!--[if lte IE 8]>
    <link type="text/css" media="screen" rel="stylesheet" href="https://fb-<?php echo base_url();?>assets.com/cache/css/responsive-login-ie8-fix.v1536156304.css" />
    <script type="text/javascript" src="/cache/javascript/vendor/html5shiv.v1536156141.js"></script>
  <![endif]-->
</head>

<body>
<main role="main" class="responsive-page">
  <header role="banner">
    <a href="/">
      <div class="fb-logo">
        <span class="a11y-hidden">FreshBooks</span>
      </div>
    </a>
  </header>
  <div class="login-step-wrapper">
    <section id="login-step-login-form" class="login-step">
      <div class=" login-callout-wrapper">
        <div class="login-callout-header callout-header">Log In e-Office</div>
        <div>To log in, enter your email address below:</div>
        <div id="infoMessage"><?php echo $message;?></div>
      </div>
      <div class="login-form-wrapper">
        <form id="login-form" name="form" action="<?php echo base_url('auth/forgot_password');?>" class="login-form" method="post">
          <div class="error-message" style="display: none;">Oops something went wrong, please try again.</div>
          <input name="identity" placeholder="Email Address" type="text" class="input-email login-field" autofocus="autofocus">
          <button class="button large inline green login-form-button" type="submit" name="submit" value="submit">
          <span class="login-button-text">
            Forgot Password
          </span>
          <span class="loading" style="display: none;">
          </span>
          </button>
        </form>
        <div class="login-form-sub-links-wrapper">
          <div class="forgot-password">
            <a href="<?php echo base_url('auth/login') ?>" id="forgot-password-link">Back to login page.</a>
          </div>
        </div>
      </div>
    </section>
  </div>
  <footer>
    <div>
      <a href="#" target="_blank" class="">Security Safeguards</a>
      |
      <a href="#" class="footer-link">Terms of Service</a>
      |
      <a href="#" class="footer-link">Privacy Policy</a>
    </div>
  </footer>
</main>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-combine.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/responsive-login.js"></script>
</body>
</html>