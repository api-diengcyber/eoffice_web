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
        <h2 style="margin-top:0px">Kantor Read</h2>
        <table class="table">
	    <tr><td>Kantor</td><td><?php echo $kantor; ?></td></tr>
	    <tr><td>Lat</td><td><?php echo $lat; ?></td></tr>
	    <tr><td>lang</td><td><?php echo $lang; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('kantor') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>