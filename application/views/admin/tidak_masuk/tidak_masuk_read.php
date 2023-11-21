
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Tidak Masuk
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <table class="table">
                        <tr><td>Tgl</td><td><?php echo $tgl; ?></td></tr>
                        <tr><td>Nama Pegawai</td><td><?php echo $nama_pegawai; ?></td></tr>
                        <!-- <tr><td>Id Users</td><td><?php echo $id_users; ?></td></tr> -->
                        <tr><td>Tidak Masuk</td><td><?php echo $ket_tidak_masuk; ?></td></tr>
                        <tr><td>Surat Ijin</td><td>
                            <?php 
                                if ($surat_ijin != null) {?>
                                    <a href="<?=base_url('./assets/ijin/file/'.$surat_ijin)?>" target="_blank">
                                        File
                                    </a>                               
                                <?php }else{?>
                                    -                                    
                                <?php
                                    }
                                ?>
                            </td></tr>
                        <tr><td></td><td><a href="<?php echo site_url('admin/tidak_masuk') ?>" class="btn btn-default">Cancel</a></td></tr>
                    </table>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->