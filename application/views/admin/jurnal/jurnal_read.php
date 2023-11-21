
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Jurnal
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                        <table class="table">
                            <tr><td>Tgl</td><td><?php echo $tgl; ?></td></tr>
                            <tr><td>Id Akun</td><td><?php echo $id_akun; ?></td></tr>
                            <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
                            <tr><td>Debet</td><td><?php echo $debet; ?></td></tr>
                            <tr><td>Kredit</td><td><?php echo $kredit; ?></td></tr>
                            <tr><td></td><td><a href="<?php echo site_url('admin/jurnal') ?>" class="btn btn-default">Cancel</a></td></tr>
                        </table>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->