<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>AIPOS Email Activation</title>
    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            padding-bottom: 0;
            font-family: 'Open Sans';
            font-size: 13px;
            color: white;
            line-height: 1.5;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        h3 {
            font-size: 24px;
            margin: 5px;
        }

        h4 {
            font-size: 18px;
            margin: 5px;
        }

        .center {
            text-align: center;
        }

        #main {
            padding-top: 5px;
            padding-bottom: 5px;
            min-height: 100%;
            min-width: 100%;
            width: 100%;
            color: black;
        }

        .well {
            min-height: 300px;
            border-radius: 10px;
            margin: 20px;
            padding: 30px;
            margin-left: 50px;
            margin-right: 50px;
        }

        .table {
            width: 100%;
            border: solid 1px black;
            border-collapse: collapse;
        }

        @media(max-width: 800px) {
            .well {
                min-height: 300px;
                border-radius: 10px;
                margin: 2px;
                padding: 5px;
                margin-left: 5px;
                margin-right: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="main-container" id="main" style="background-color:#67df08;padding:20px">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="well white" style="background-color:white;padding:0px">
                        <div style="background-color:#f2ffd6;padding:10px">
                            <div class="">
                                <h1 style="font-family:fantasy;margin-bottom:0px;">
                                    <img src="<?php echo base_url(); ?>assets/images/dc.png" style="height:75px;margin-left: 20px;margin-top: -10px;">
                                </h1>
                            </div>
                        </div>
                        <div style="padding:20px">
                            <br>
                            <h3 style="margin-left:0px">INVOICE #<?php echo $no_faktur ?></h3>
                            <table class="table" border="1">
                                <tr>
                                    <td style='vertical-align:middle!important;padding:20px;width:70%'>
                                        Silahkan Transfer paling lambat sampai
                                        <span>
                                            <h3><?php echo $exp_date; ?></h3>
                                        </span>
                                    </td>
                                    <td style="width:50%;text-align:center!important;text-transform:uppercase;font-weight:bold">
                                        <p>Status <?php if ($status == 1) {
                                                        echo 'PAID';
                                                    } else {
                                                        echo 'UNPAID';
                                                    } ?></p>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size: 14px; ">
                                Detail invoice
                            </p>
                            <table class="table" border='1'>
                                <thead style="background-color: #337400;color: white;">
                                    <th style="width:60%">Item</th>
                                    <th style="width:10%">Qty</th>
                                    <th style="width:30%">Harga</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $barang; ?></td>
                                        <td><?php echo $jumlah ?></td>
                                        <td>Rp.<?php echo number_format($harga, '0', ',', '.') ?></td>
                                    </tr>
                                    <tr style="text-align: right">
                                        <td></td>
                                        <td></td>
                                        <td>Subtotal Rp.<?php echo number_format($jumlah * $harga, '0', ',', '.') ?></td>
                                    </tr>
                                    <tr style="text-align: right">
                                        <td></td>
                                        <td></td>
                                        <td>DP Rp.<?php echo number_format($dp, '0', ',', '.') ?></td>
                                    </tr>
                                    <tr style="text-align: right">
                                        <td></td>
                                        <td></td>
                                        <td>Total Rp.<?php echo number_format($jumlah * $harga - $dp, '0', ',', '.') ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <p>
                                Best Regards.
                            </p>
                            <br>
                        </div>
                        <br>
                        <div style="background-color:#161819;color:white;padding:20px">
                            <p>
                            <h4 style="margin-left:0px">CV. DIENG CYBER</h4>
                            Your IT Solutions Partner
                            <br>
                            Jl. S Parman Wonosobo - Jawa Tengah - Indonesia<br>
                            0286 3304739
                            <a href="https://www.diengcyber.com" title="Dieng Cyber" style="color:#00BCD4">www.diengcyber.com</a>
                            <br>
                            </p>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->
</body>

</html>