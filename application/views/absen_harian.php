<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
        <style>
        body {
            font-family: 'Lato', sans-serif;
        }
        .h-2 {
            font-size: 16px!important; 
        }
        .divider-bottom {
            border-bottom: 1px solid #000;
        }
        .note-sm {
            font-size: 11px;
        }
        .text-center {
            text-align: center;
        }
        .pn-table {
            padding-top: 10px;
            padding-bottom: 20px;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 20px;
            background-color: #e9f9d6;
        }
        .th-cus {
            background-color: #a8df68;
            border-radius: 8px;
            padding-top: 4px;
            padding-bottom: 6px;
            padding-left: 7px;
            padding-right: 7px;
        }
        .table {
            border-collapse: collapse;
            border: 0px solid #000;
        }
        .table td {
            border: 0px solid #000;
        }
        .table th {
            border: 0px solid #000;
        }
        .table tr:nth-child(1) th {
            padding: 3px!important;
            font-size: 14px!important;
            font-weight: bold;
        }
        .table td {
            font-size: 14px!important;
        }
        </style>
    </head>
    <body>
    
    <div class="pn-table">
        <table class="table" style='width:100%;'>
            <tr>
                <th width='10'><div class="th-cus">No</div></th>
                <th align='center'><div class="th-cus">Tgl</div></th>
                <th align='center'><div class="th-cus">Masuk</div></th>
                <th align='center'><div class="th-cus">Pulang</div></th>
            </tr>
            <?php 
            $no = 1;
            foreach ($data as $key) { ?>
    
            <tr>
                <td align="center"><?php echo $no++ ?></td>
                <td align='center'><?php echo $key->tgl ?></td>
                <td align='center'><?php echo $key->jam_masuk ?></td>
                <td align='center'><?php echo $key->jam_pulang ?></td>
            </tr>
            
            <?php } ?>
            
        </table>
    </div>
    
    </body>
</html>