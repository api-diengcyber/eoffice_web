<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Pegawai List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Id Users</th>
		<th>Nama Pegawai</th>
		<th>Tgl Masuk</th>
		<th>Rekening</th>
		<th>Level</th>
		<th>Gaji Pokok</th>
		
            </tr><?php
            foreach ($pegawai_data as $pegawai)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $pegawai->id_users ?></td>
		      <td><?php echo $pegawai->nama_pegawai ?></td>
		      <td><?php echo $pegawai->tgl_masuk ?></td>
		      <td><?php echo $pegawai->rekening ?></td>
		      <td><?php echo $pegawai->level ?></td>
		      <td><?php echo $pegawai->gaji_pokok ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>