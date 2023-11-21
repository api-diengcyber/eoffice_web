<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login | e-Office</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, follow">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="<?php echo base_url(); ?>assets/js/optimize.js"></script>
  <style type="text/css">
    body {
      background-color: white !important;
      color: black !important;
    }

    .login-step-wrapper .login-form-wrapper .login-form .login-form-button {
      color: #fff !important;
      cursor: pointer !important;
      border: 1px solid #03A9F4 !important;
      background-color: #03A9F4 !important;
    }

    a {
      color: #00ce68!important;
    }

    .login-step-wrapper .login-form-wrapper .login-form .login-form-button {
      background-color: #00ce68 !important;
      border: none !important;
      color: white !important;
    }
    .bgdc{
      background-color:  #00ce68;
    }
  </style>
  <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-login.css">

  <!--[if lte IE 8]>
    <link type="text/css" media="screen" rel="stylesheet" href="https://fb-<?php echo base_url(); ?>assets.com/cache/css/responsive-login-ie8-fix.v1536156304.css" />
    <script type="text/javascript" src="/cache/javascript/vendor/html5shiv.v1536156141.js"></script>
  <![endif]-->
</head>

<body>
  <main role="main" class="responsive-page">
    <header role="banner">
      <!-- <img src="<?php echo base_url('assets/images/img_logo.png') ?>" alt="" style="height:150px;margin-top:100px"> -->
      <img src="https://office.diengcyber.com/assets/images/logo%20eoffice%20dieng%20cyber.png" alt="" style="height:100px;width:200px;margin-top:70px;margin-bottom:10px">
    </header>
    <div class="login-step-wrapper">
      <section id="login-step-login-form" class="login-step">
        <?php if (!empty($this->session->flashdata('message'))) { ?>
          <center>
            <div style="padding:10px;background-color:white;border-radius:10px;color:black;width:200px">
              <?php echo $this->session->flashdata('message'); ?>
            </div>
          </center>
        <?php } ?>
        <div class="login-form-wrapper">
          <form id="login-form" name="form" action="<?php echo base_url('auth/login'); ?>" class="login-form" method="post">
            <div class="error-message" style="display: none;">Oops something went wrong, please try again.</div>
            <h3>LOGIN</h3>
            <input name="identity" placeholder="username" type="text" class="input-email login-field" autofocus="autofocus">
            <input name="password" placeholder="Password" type="password" class="input-password login-field">
            <button class="button large inline green login-form-button" type="submit" name="submit" value="submit">
              <span class="login-button-text">
                Log In
              </span>
              <span class="loading" style="display: none;">
              </span>
            </button>
            <div style="margin-top:16px;">
              Belum punya akun? <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Daftar</a>
            </div>
            <!--  -->
            <!-- Button trigger modal -->
          </form>

              <!-- Modal -->
              <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Cek ID Kantor</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?php echo base_url('auth/register') ?>" method="POST">
                        <input type="hidden" name="id_kantor" id="id_kantor" value="">
                          <div class="modal-body">
                              <div class="row">
                                <div class="col-12">
                                  <div class="mb-2">
                                    <label for="" class="text-start">Masukkan ID Kantor Anda</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" id="id" placeholder="" aria-label="Example text with button addon" aria-describedby="cek-btn">
                                      <button class="btn bgdc text-white" type="button" id="cek-btn">CEK</button>
                                    </div>
                                  </div>
                                  <div class="mb-2" id="keterangan">
                                    
                                  </div>
                                  <div class="col-12">
                                    <div class="d-grid gap-2">
                                      <button class="btn bgdc disabled text-white" id="btn-next" type="submit">Lanjutkan</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>


        </div>
      </section>
    </div>
    <footer>
      <div>
        <a href="https://kenerja.saktidesain.com">&copy; diengcyber 2016 - <?php echo date('Y') ?></a>
      </div>
    </footer>
  </main>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-combine.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/responsive-login.js"></script>
<<<<<<< HEAD
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    $(document).ready(function(){
      $("#cek-btn").click(function(){
        let id =$("#id").val();
        $("#id_kantor").val(id);


        $.ajax({
                url: '<?php echo base_url('api/Kantor/cek_kantor/') ?>'+id,
                type: 'get',
                success: function(response) {
                        var no = 1;
                        var html = '';
                       
                        console.log(response);
                        if(response.data==null){
                          $("#btn-next").addClass("disabled");
                          $("#ada").remove();
                          $("#tidak-ada").remove();
                          html=`
                              <p class="text-left text-danger" id="tidak-ada">Kantor tidak ditemukan!</p>
                              `;
                          $("#keterangan").append(html);

                        }else{
                          $("#btn-next").removeClass("disabled");
                          $("#ada").remove();
                          $("#tidak-ada").remove();
                          html=`
                              <p class="text-left text-success" id="ada">Daftar Ke Kantor ${response.data['nama_kantor']} ?</p>
                              `;
                          $("#keterangan").append(html);
                        }
        
                    }
                });

        // end ajax

      });
    });
</script>


</body>
=======
</body>

</html>
>>>>>>> 08c9475877b049b0f250f66d4eeaf9a8deb6ae05
