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
        <h2>Tidak_masuk List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tgl</th>
		<th>Id Users</th>
		<th>Tidak Masuk</th>
		
            </tr><?php
            foreach ($tidak_masuk_data as $tidak_masuk)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $tidak_masuk->tgl ?></td>
		      <td><?php echo $tidak_masuk->id_users ?></td>
		      <td><?php echo $tidak_masuk->tidak_masuk ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>