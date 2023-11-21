
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Transaksi
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <table class="table">
                        <tr><td>Tgl</td><td><?php echo $tgl; ?></td></tr>
                        <tr><td>No Faktur</td><td><img src="<?php echo base_url() ?>admin/transaksi/barcode/<?php echo $no_faktur; ?>" width="200" alt=""><br><?php echo $no_faktur; ?></td></tr>
                        <tr><td><h4>Kepada :</h4></td><td></td></tr>
                        <tr><td>Nama</td><td><?php echo $kepada_nama; ?></td></tr>
                        <tr><td>Hp</td><td><?php echo $kepada_hp; ?></td></tr>
                        <tr><td>Alamat</td><td><?php echo $kepada_alamat; ?></td></tr>
                        <tr><td>Keterangan</td><td><?php echo $ket; ?></td></tr>
                    </table>

                    <div class="space"></div>

                    <table class="table table-stripped table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th width="10">No</th>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_barang as $key): ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $key->barang ?></td>
                                <td>Rp.<?php echo number_format($key->harga,0,',','.') ?></td>
                                <td class="center"><?php echo $key->diskon ?>%</td>
                                <td class="center"><?php echo $key->jumlah ?></td>
                                <td>Rp.<?php echo number_format($key->total,0,',','.') ?></td>
                            </tr>
                            <?php $no++; endforeach ?>
                        </tbody>
                    </table>

                    <div class="space"></div>

                    <div class="well">
                        <h4 style="margin-bottom:0px;margin-top:0px;" class="green"><b>TOTAL : Rp. <?php echo number_format($harga,0,',','.') ?></b></h4>
                        <h4 style="margin-bottom:0px;margin-top:5px;" class="red"><b>DP : Rp. <?php echo number_format($dp,0,',','.') ?></b></h4>
                        <h4 style="margin-bottom:0px;margin-top:5px;" class="blue"><b>TOTAL SISA : Rp. <?php echo number_format($harga-$dp,0,',','.') ?></b></h4>
                    </div>

                    <div class="hr hr-double hr32"></div>
                    
                    <center>
                        <a href="<?php echo site_url('admin/transaksi') ?>" class="btn btn-default">Cancel</a>
                    </center>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->