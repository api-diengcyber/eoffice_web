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
        <h2 style="margin-top:0px">Registrasi_kantor Read</h2>
        <table class="table">
	    <tr><td>Perusahaan</td><td><?php echo $perusahaan; ?></td></tr>
	    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>No Telp Perusahaan</td><td><?php echo $no_telp_perusahaan; ?></td></tr>
	    <tr><td>Bidang Bisnis</td><td><?php echo $bidang_bisnis; ?></td></tr>
	    <tr><td>Jml Karyawan</td><td><?php echo $jml_karyawan; ?></td></tr>
	    <tr><td>Nama Pemohon</td><td><?php echo $nama_pemohon; ?></td></tr>
	    <tr><td>No Telp Pemohon</td><td><?php echo $no_telp_pemohon; ?></td></tr>
	    <tr><td>Jabatan Pemohon</td><td><?php echo $jabatan_pemohon; ?></td></tr>
	    <tr><td>Email</td><td><?php echo $email; ?></td></tr>
	    <tr><td>Created Date</td><td><?php echo $created_date; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('registrasi_kantor') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>