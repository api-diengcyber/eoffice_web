
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Info
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <style>
                        .table * {
                            border-color:transparent!important;
                        }
                    </style>
                    <table class="table" style="">
                        <tr>
                            <td>Tanggal <?php echo $tgl; ?><br><br>
                                <?php echo $info; ?>
                            </td>
                        </tr>
                        <tr><td></td><td><a href="<?php echo site_url('admin/info') ?>" class="btn btn-default">Cancel</a></td></tr>
                    </table>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->