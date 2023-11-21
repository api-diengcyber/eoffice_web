
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Absen Pegawai
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="int">Tgl <?php echo form_error('tgl') ?></label>
                            <input type="text" class="form-control" name="tgl" id="tgl" placeholder="Tgl" value="<?php echo $tgl; ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label for="int">Nama Pegawai</label>
                            <input type="text" class="form-control" placeholder="Nama Pegawai" value="<?php echo $nama_pegawai; ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label for="int">Jam Masuk <?php echo form_error('jam_masuk') ?></label>
                            <input type="text" class="form-control" name="jam_masuk" id="timepicker1" placeholder="Jam Masuk" value="<?php echo $jam_masuk; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="int">Jam Pulang <?php echo form_error('jam_pulang') ?></label>
                            <input type="text" class="form-control" name="jam_pulang" id="timepicker2" placeholder="Jam Pulang" value="<?php echo $jam_pulang; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="int">Status <?php echo form_error('status') ?></label>
                            <select class="form-control" name="status" id="status">
                                <option <?php echo ($status == '1' ? 'selected' : '') ?> value="1">MASUK</option>
                                <option <?php echo ($status == '2' ? 'selected' : '') ?> value="2">PULANG</option>
                            </select>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('admin/absen') ?>" class="btn btn-default">Cancel</a>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->