
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Cetak
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="<?php echo $action ?>" method="post" target="_blank">
                      <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12 input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-users bigger-110"></i>
                                </span>
                                <select class="form-control input-lg" name="id_pegawai" id="id_pegawai">
                                  <option value="semua">-- Semua Pegawai --</option>
                                  <?php foreach ($data_pegawai as $key): ?>
                                    <option value="<?php echo $key->id ?>"><?php echo $key->nama_pegawai ?></option>
                                  <?php endforeach ?>
                                </select>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                                <select class="form-control input-lg" name="tahun" id="tahun">
                                  <?php foreach ($data_tahun as $key): ?>
                                    <?php if ($key->tahun == date('Y')) { ?>
                                      <option selected value="<?php echo $key->tahun ?>"><?php echo $key->tahun ?></option>
                                    <?php } else { ?>
                                      <option value="<?php echo $key->tahun ?>"><?php echo $key->tahun ?></option>
                                    <?php } ?>
                                  <?php endforeach ?>
                                </select>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                                <select class="form-control input-lg" name="bulan" id="bulan">
                                  <?php foreach ($data_bulan as $key): ?>
                                    <?php if (sprintf('%02d',$key->id) == date('m')) { ?>
                                      <option selected value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                    <?php } else { ?>
                                      <option value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                    <?php } ?>
                                  <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <button type="submit" class="btn btn-primary btn-block"><i class="ace-icon fa fa-print"></i> Cetak</button>
                      </div>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->