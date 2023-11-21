
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Pilihan Transaksi
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                        <table class="table">
                            <tr><td>Nm Transaksi</td><td><?php echo $nm_transaksi; ?></td></tr>
                            <tr><td>Id Akun Debet</td><td><?php echo $id_akun_debet; ?></td></tr>
                            <tr><td>Id Akun Kredit</td><td><?php echo $id_akun_kredit; ?></td></tr>
                            <tr><td></td><td><a href="<?php echo site_url('admin/pil_transaksi') ?>" class="btn btn-default">Cancel</a></td></tr>
                        </table>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->