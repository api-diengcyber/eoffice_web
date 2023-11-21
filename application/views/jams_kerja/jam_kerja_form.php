<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Jam_kerja <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Users <?php echo form_error('id_users') ?></label>
            <input type="text" class="form-control" name="id_users" id="id_users" placeholder="Id Users" value="<?php echo $id_users; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Tgl <?php echo form_error('tgl') ?></label>
            <input type="text" class="form-control" name="tgl" id="tgl" placeholder="Tgl" value="<?php echo $tgl; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Jam Masuk <?php echo form_error('jam_masuk') ?></label>
            <input type="text" class="form-control" name="jam_masuk" id="jam_masuk" placeholder="Jam Masuk" value="<?php echo $jam_masuk; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Jam Pulang <?php echo form_error('jam_pulang') ?></label>
            <input type="text" class="form-control" name="jam_pulang" id="jam_pulang" placeholder="Jam Pulang" value="<?php echo $jam_pulang; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Lembur <?php echo form_error('lembur') ?></label>
            <input type="text" class="form-control" name="lembur" id="lembur" placeholder="Lembur" value="<?php echo $lembur; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Tidak Masuk <?php echo form_error('tidak_masuk') ?></label>
            <input type="text" class="form-control" name="tidak_masuk" id="tidak_masuk" placeholder="Tidak Masuk" value="<?php echo $tidak_masuk; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Status <?php echo form_error('status') ?></label>
            <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('jams_kerja') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>