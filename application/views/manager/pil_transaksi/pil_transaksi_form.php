
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Pilihan Transaksi
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                        <form action="<?php echo $action; ?>" method="post">
                            <div class="form-group">
                                <label for="varchar">Nama Transaksi <?php echo form_error('nm_transaksi') ?></label>
                                <input type="text" class="form-control" name="nm_transaksi" id="nm_transaksi" placeholder="Nama Transaksi" value="<?php echo $nm_transaksi; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="int">Akun Debet <?php echo form_error('id_akun_debet') ?></label>
                                <select class="form-control" name="id_akun_debet" id="id_akun_debet">
                                <?php foreach ($data_akun as $key): ?>
                                  <?php if ($key->id == $id_akun_debet) { ?>
                                    <option selected value="<?php echo $key->id ?>"><?php echo $key->kode ?> - <?php echo $key->akun ?></option>
                                  <?php } else { ?>
                                    <option value="<?php echo $key->id ?>"><?php echo $key->kode ?> - <?php echo $key->akun ?></option>
                                  <?php } ?>
                                <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="int">Akun Kredit <?php echo form_error('id_akun_kredit') ?></label>
                                <select class="form-control" name="id_akun_kredit" id="id_akun_kredit">
                                <?php foreach ($data_akun as $key): ?>
                                  <?php if ($key->id == $id_akun_kredit) { ?>
                                    <option selected value="<?php echo $key->id ?>"><?php echo $key->kode ?> - <?php echo $key->akun ?></option>
                                  <?php } else { ?>
                                    <option value="<?php echo $key->id ?>"><?php echo $key->kode ?> - <?php echo $key->akun ?></option>
                                  <?php } ?>
                                <?php endforeach ?>
                                </select>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                            <a href="<?php echo site_url('admin/pil_transaksi') ?>" class="btn btn-default">Cancel</a>
                        </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->