
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Hari Kerja
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="int">Tahun <?php echo form_error('tahun') ?></label>
                            <input type="text" class="form-control" name="tahun" id="tahun" placeholder="Tahun" value="<?php echo $tahun; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="int">Bulan <?php echo form_error('bulan') ?></label>
                            <select class="form-control" name="bulan" id="bulan">
                                <?php foreach ($data_bulan as $key): ?>
                                  <?php if ($key->id == $bulan) { ?>
                                    <option selected value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                  <?php } else { ?>
                                    <option value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                  <?php } ?>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="int">Hari Kerja <?php echo form_error('hari_kerja') ?></label>
                            <input type="text" class="form-control" name="hari_kerja" id="hari_kerja" placeholder="Hari Kerja" value="<?php echo $hari_kerja; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="int">Hari Masuk <?php echo form_error('hari_masuk') ?></label>
                            <input type="text" class="form-control" name="hari_masuk" id="hari_masuk" placeholder="Hari Masuk" value="<?php echo $hari_masuk; ?>" />
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('admin/hari_kerja') ?>" class="btn btn-default">Cancel</a>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->