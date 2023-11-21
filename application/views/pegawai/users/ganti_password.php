
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Ganti Password
                </h1>
            </div><!-- /.page-header -->

            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="int">Password Baru <?php echo form_error('password_baru') ?></label>
                            <input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Password Baru" />
                        </div>
                        <div class="form-group">
                            <label for="int">Ulangi Password Baru <?php echo form_error('ulangi_password_baru') ?></label>
                            <input type="password" class="form-control" name="ulangi_password_baru" id="ulangi_password_baru" placeholder="Ulangi Password Baru" />
                        </div>
                        <div id="tpassword"></div>
                        <button type="submit" class="btn btn-primary" id="btnSimpan" disabled>Simpan</button> 
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script type="text/javascript">
jQuery(function($){
    $("#password_baru, #ulangi_password_baru").on('keyup', function(){
        cek_password();
    });

    function cek_password() {
        $("#tpassword").html("");
        $("#btnSimpan").attr('disabled', 'disabled');
        var password_baru = $("#password_baru").val().trim();
        var ulangi_password_baru = $("#ulangi_password_baru").val().trim();
        if (password_baru != '' && ulangi_password_baru != '') {
            if (password_baru == ulangi_password_baru) {
                $("#tpassword").html(" <div class='alert alert-success'> Password Sesuai ! </div>");
                $("#btnSimpan").removeAttr('disabled');
            }
        }
    }

});
</script>