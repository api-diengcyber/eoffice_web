
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Pilihan Level
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                        <form action="<?php echo $action; ?>" method="post">
                            <div class="form-group">
                                <label for="varchar">Level <?php echo form_error('level') ?></label>
                                <input type="text" class="form-control" name="level" id="level" placeholder="Level" value="<?php echo $level; ?>" />
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                            <a href="<?php echo site_url('admin/pil_level') ?>" class="btn btn-default">Cancel</a>
                        </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->