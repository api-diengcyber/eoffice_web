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
        <h2 style="margin-top:0px">Jam_kerja Read</h2>
        <table class="table">
	    <tr><td>Id Users</td><td><?php echo $id_users; ?></td></tr>
	    <tr><td>Tgl</td><td><?php echo $tgl; ?></td></tr>
	    <tr><td>Jam Masuk</td><td><?php echo $jam_masuk; ?></td></tr>
	    <tr><td>Jam Pulang</td><td><?php echo $jam_pulang; ?></td></tr>
	    <tr><td>Lembur</td><td><?php echo $lembur; ?></td></tr>
	    <tr><td>Tidak Masuk</td><td><?php echo $tidak_masuk; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('jams_kerja') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>