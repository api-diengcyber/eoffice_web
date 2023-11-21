<!DOCTYPE html>
<html lang="en">

<head>
  <title>Register | e-Office</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, follow">

  <script src="<?php echo base_url(); ?>assets/js/optimize.js"></script>
  <style type="text/css">
    body {
      background-color: white !important;
      color: black!important;
    }

    .login-step-wrapper .login-form-wrapper .login-form .login-form-button {
      color: white !important;
      cursor: pointer !important;
      border: 1px solid #00ce68 !important;
      background-color: #00ce68!important;
    }

    a {
      color: #00ce68!important;
    }

    .login-button-text {
      font-size: 20px;
    }

    .login-step-wrapper .login-form-wrapper {
      max-width: 400px !important;
    }

    .login-step-wrapper .login-form-wrapper .login-form .login-form-button {
      background-color: #ffee00 !important;
      border: none !important;
      color: #000000 !important;
    }

    #ui-datepicker-div {
      background-color: grey !important;
    }
    .bgdc{
      background-color:  #00ce68;
    }
  </style>
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css" />
  <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-login.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.min.css" /> -->
  <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.custom.min.css" /> -->
</head>

<body>
  <div style="overflow:hidden;padding-left:24px;padding-right:24px;">
    <?php if (!empty($this->session->flashdata('message'))) { ?>
      <center>
        <div style="padding:10px;background-color:white;border-radius:10px;color:black;width:200px">
          <?php echo $this->session->flashdata('message'); ?>
        </div>
      </center>
    <?php } ?>
    <?php if (!empty($message)) { ?>
      <center>
        <div style="padding:10px;background-color:white;border-radius:10px;color:black;width:200px">
          <?php echo $message; ?>
        </div>
      </center>
    <?php } ?>
    <form name="form" action="<?php echo base_url('auth/register'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_kantor" id="id_kantor" value="<?php echo $id_kantor ?>">
      <div class="row">
        <div class="col-md-12">
          <img src="https://office.diengcyber.com/assets/images/logo%20eoffice%20dieng%20cyber.png" alt="" style="height:5s0px;width:160px;margin-top:70px;margin-bottom:10px">
        <h3 class="">DAFTAR <?php echo $nama_kantor ?></h3>
        <div class="row">
          <div class="col-md-6">
            <div class="login-step-wrapper" style="margin-top:60px;width:100%;">
              <section id="login-step-login-form">
                <div class="login-form-wrapper">
                  <div id="login-form" class="login-form">
                    <div class="form-group text-left">
                      <label for="varchar">Email <?php echo form_error('username') ?></label>
                      <input type="text" class="form-control" name="username" id="username" placeholder="Email" value="<?php echo $username; ?>" maxlength="50" />
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Nama Pegawai<?php echo form_error('nama_pegawai') ?></label>
                      <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" placeholder="Nama Pegawai" value="<?php echo $nama_pegawai; ?>" />
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Tgl Lahir <?php echo form_error('tgl_lahir') ?></label>
                      <input type="text" class="form-control" name="tgl_lahir" id="datepicker1" placeholder="Tgl Lahir" value="<?php echo $tgl_lahir; ?>" />
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Alamat <?php echo form_error("alamat") ?></label>
                      <textarea name="alamat" class="form-control" id="alamat"><?= $alamat ?></textarea>
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Tgl Masuk <?php echo form_error('tgl_masuk') ?></label>
                      <input type="text" class="form-control" name="tgl_masuk" id="datepicker2" placeholder="Tgl Masuk" value="<?php echo $tgl_masuk; ?>" />
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Foto (max 2MB)</label>
                      <input type="file" class="form-control" name="foto" id="foto" />
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Hybrid / WFH <?php echo form_error('wfh') ?></label>
                      <select name="wfh" id="wfh" class="form-control">
                        <option value="0" <?php echo $wfh == '0' ? 'selected' : ''; ?>>Tidak</option>
                        <option value="1" <?php echo $wfh == '1' ? 'selected' : ''; ?>>Ya</option>
                      </select>
                    </div>
                  </div>
              </section>
            </div>
          </div>
          <div class="col-md-6">
            <div class="login-step-wrapper" style="margin-top:60px;width:100%;">
              <section id="login-step-login-form">
                <div class="login-form-wrapper">
                  <div id="login-form" class="login-form">
                    <div class="form-group text-left">
                      <label for="varchar">No. WA</label>
                      <input type="text" name="no_wa" id="no_wa" class="form-control" value="<?= $no_wa ?>" />
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Jenis Kelamin</label>
                      <select name="jk" id="jk" class="form-control">
                        <?php if (empty($jk)) { ?>
                          <option selected disabled>--- Pilih Jenis Kelamin ---</option>
                        <?php } ?>
                        <option <?= $jk == 'Laki - Laki' ? 'selected' : '' ?> value="Laki - Laki">Laki - Laki</option>
                        <option <?= $jk == 'Perempuan' ? 'selected' : '' ?> value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Status Pernikahan</label>
                      <select name="sp" id="sp" class="form-control">
                        <?php if (empty($sp)) { ?>
                          <option selected disabled>--- Pilih Status Pernikahan ---</option>
                        <?php } ?>
                        <option <?= $sp == 'Belum Nikah' ? 'selected' : '' ?> value="Belum Nikah">Belum Nikah</option>
                        <option <?= $sp == 'Sudah Menikah' ? 'selected' : '' ?> value="Sudah Menikah">Sudah Menikah</option>
                        <option <?= $sp == 'Janda / Duda' ? 'selected' : '' ?> value="Janda / Duda">Janda / Duda</option>
                      </select>
                    </div>
                    <div class="form-group text-left">
                      <label for="int">Level <?php echo form_error('level') ?></label>
                      <select class="form-control" name="level" id="level">
                        <option value="">-- Pilih Level --</option>
                        <?php foreach ($data_pil_level as $key) : ?>
                          <?php if ($key->level_number == $level) { ?>
                            <option selected value="<?php echo $key->level_number ?>"><?php echo $key->level ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $key->level_number ?>"><?php echo $key->level ?></option>
                          <?php } ?>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group text-left">
                      <label for="jabatan">Pilih Jabatan</label>
                      <select name="id_jabatan" id="jabatan" class="form-control">
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatan as $j) : ?>
                          <option value="<?php echo $j->id ?>" <?php if ($j->id == $id_jabatan) {
                                                                    echo 'selected';
                                                                  } ?>><?php echo $j->jabatan ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group text-left">
                      <label for="int">Tingkat <?php echo form_error('tingkat') ?></label>
                      <select class="form-control" name="tingkat" id="tingkat">
                        <?php if (empty($id_tingkat)) { ?>
                          <option value="">Silahkan Pilih Jabatan Terlebih Dahulu</option>
                        <?php } else { ?>
                          <?php foreach ($data_tingkat as $dt) : ?>
                            <option value="<?php echo $dt->id ?>" <?php if ($dt->id == $id_tingkat) {
                                                                        echo 'selected';
                                                                      } ?>><?php echo $dt->tingkat ?></option>
                          <?php endforeach ?>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group text-left">
                      <label for="varchar">Password <?php echo form_error('password') ?></label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="login-step-wrapper" style="margin:0 auto 20px auto !important;width:100%;">
          <section id="login-step-login-form">
            <div class="login-form-wrapper">
              <div id="login-form" class="login-form" style="margin-top:0px;">
                <div class="col-md-12 text-center">
                  <button class="button large inline green bgdc login-form-button" type="submit" name="submit" value="submit">
                    <span class="login-button-text">
                      Daftar
                    </span>
                    <span class="loading" style="display: none;">
                    </span>
                  </button>
                  <div style="margin-top:16px;">
                    Sudah punya akun? <a href="<?php echo base_url('auth/login') ?>" class="text-success" class="">Login</a>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
  </div>
  </form>
  <footer>
    <div>
      <a href="https://kenerja.saktidesain.com">&copy; diengcyber 2016 - <?php echo date('Y') ?></a>
    </div>
  </footer>
  </div>
  <script src="<?php echo base_url() ?>assets/js/jquery-2.1.4.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- <script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script> -->
  <script src="<?php echo base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/responsive-login.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#datepicker1").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd-mm-yy",
      });
      $("#datepicker2").datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        dateFormat: "dd-mm-yy",
      });
      $("#username").on('keyup', function() {
        var username = $(this).val().replace(/\ /g, '_');
        $(this).val(username.trim());
      });
      $("#gaji_pokok").on('keyup', function() {
        var gaji_pokok = $(this).val().replace(/\./g, '');
        var sgaji_pokok = number_format(gaji_pokok * 1, 0, ',', '.');
        $(this).val(sgaji_pokok);
      });
      $('#jabatan').change(function() {
        var id = $(this).val();
        $.ajax({
          url: '<?php echo base_url(); ?>admin/pegawai/json_tingkat',
          type: 'post',
          data: {
            id: id
          },
          success: function(response) {
            var data = JSON.parse(response);
            var output = '<option>-- Pilih Jabatan --</option>';
            $.each(data, function(index, val) {
              output += '<option value=' + val.id;
              if (val.id == <?php echo $tingkat; ?>) {
                output += 'selected';
              }
              output += '>' + val.tingkat + '</option>';
            });
            $('#tingkat').html(output);
          }
        });
      });
    });
  </script>
</body>

</html>