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
        <h2>Jurnal List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tgl</th>
		<th>Id Akun</th>
		<th>Keterangan</th>
		<th>Debet</th>
		<th>Kredit</th>
		
            </tr><?php
            foreach ($jurnal_data as $jurnal)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $jurnal->tgl ?></td>
		      <td><?php echo $jurnal->id_akun ?></td>
		      <td><?php echo $jurnal->keterangan ?></td>
		      <td><?php echo $jurnal->debet ?></td>
		      <td><?php echo $jurnal->kredit ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>