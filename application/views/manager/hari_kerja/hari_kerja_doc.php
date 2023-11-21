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
        <h2>Hari_kerja List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tahun</th>
		<th>Bulan</th>
		<th>Hari Kerja</th>
		<th>Hari Masuk</th>
		
            </tr><?php
            foreach ($hari_kerja_data as $hari_kerja)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $hari_kerja->tahun ?></td>
		      <td><?php echo $hari_kerja->bulan ?></td>
		      <td><?php echo $hari_kerja->hari_kerja ?></td>
		      <td><?php echo $hari_kerja->hari_masuk ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>