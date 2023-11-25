<div class="main-content" style="width:100%;">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="row" style="margin-top:50px;">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <?php if (!isset($login)) { ?>
                        <form action="<?php echo $action ?>" method="post">
                            <div class="card">
                                <div class="card-header">
                                    <h4 style="color:red;">Permohonan hapus akun</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Email <?php echo form_error('email') ?></label>
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password <?php echo form_error('password') ?></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Alasan penghapusan akun <?php echo form_error('alasan') ?></label>
                                        <textarea class="form-control" name="alasan" id="alasan" cols="30" rows="10" placeholder="Tulis alasan..." required></textarea>
                                    </div>
                                </div>
                                <div class="footer text-right">
                                    <button type="submit" class="btn btn-danger">Permohonan hapus</button>
                                </div>
                            </div>
                        </form>
                    <?php } else { ?>
                        <?php if (!empty($data)) { ?>
                            <div class="card">
                                <div class="card-header">
                                    <h4 style="color:red;">Permohonan hapus akun</h4>
                                </div>
                                <div class="card-body">
                                    <p>Anda mengajukan permohonan hapus akun pada <?php echo $data->waktu ?> <br>mohon ditunggu atau <a href="http://wa.me/6285729670954" target="_blank" class="btn btn-success btn-sm">Kontak admin</a>.</p>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-header">
                                    <h4 style="color:red;">User tidak ditemukan</h4>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #eee;
    }
</style>