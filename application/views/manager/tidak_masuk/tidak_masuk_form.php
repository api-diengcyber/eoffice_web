
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Tidak Masuk
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="varchar">Tgl <?php echo form_error('tgl') ?></label>
                            <input type="text" class="form-control" name="tgl" id="sdatepicker1" placeholder="Tgl" value="<?php echo $tgl; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="int">Pegawai <?php echo form_error('id_users') ?></label>
                            <select class="form-control" name="id_users" id="id_users">
                              <?php foreach ($data_pegawai as $key): ?>
                                <?php if ($key->id_users == $id_users) { ?>
                                  <option selected value="<?php echo $key->id_users ?>"><?php echo $key->nama_pegawai ?></option>
                                <?php } else { ?>
                                  <option value="<?php echo $key->id_users ?>"><?php echo $key->nama_pegawai ?></option>
                                <?php } ?>
                              <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="int">Tidak Masuk <?php echo form_error('tidak_masuk') ?></label>
                            <select class="form-control" name="tidak_masuk" id="tidak_masuk">
                              <?php foreach ($data_pil_tidak_masuk as $key): ?>
                                <?php if ($key->id == $tidak_masuk) { ?>
                                  <option selected value="<?php echo $key->id ?>"><?php echo $key->ket_tidak_masuk ?></option>
                                <?php } else { ?>
                                  <option value="<?php echo $key->id ?>"><?php echo $key->ket_tidak_masuk ?></option>
                                <?php } ?>
                              <?php endforeach ?>
                            </select>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('manager/tidak_masuk') ?>" class="btn btn-default">Cancel</a>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->