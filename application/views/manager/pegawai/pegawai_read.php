
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Pegawai
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                        <table class="table">
                            <tr><td>Nama Pegawai</td><td><?php echo $nama_pegawai; ?></td></tr>
                            <tr><td>Tgl Masuk</td><td><?php echo $tgl_masuk; ?></td></tr>
                            <tr><td>Rekening</td><td><?php echo $rekening; ?></td></tr>
                            <tr><td>Level</td><td><?php echo $level; ?></td></tr>
                            <tr><td>Gaji Pokok</td><td><?php echo $gaji_pokok; ?></td></tr>
                            <tr><td></td><td><a href="<?php echo site_url('admin/pegawai') ?>" class="btn btn-default">Cancel</a></td></tr>
                        </table>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->