
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Hari Kerja
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                        <table class="table">
                            <tr><td>Tahun</td><td><?php echo $tahun; ?></td></tr>
                            <tr><td>Bulan</td><td><?php echo $bulan; ?></td></tr>
                            <tr><td>Jam Kerja</td><td><?php echo $jam_kerja; ?></td></tr>
                            <tr><td></td><td><a href="<?php echo site_url('admin/hari_kerja') ?>" class="btn btn-default">Cancel</a></td></tr>
                        </table>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->