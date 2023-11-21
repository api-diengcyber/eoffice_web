
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
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="varchar">Tgl <?php echo form_error('tgl') ?></label>
                            <input type="text" class="form-control" name="tgl" id="datepicker1" placeholder="Tgl" value="<?php echo $tgl; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="info">Info <?php echo form_error('info') ?></label>
                            <textarea class="form-control" rows="3" name="info" id="info" placeholder="Info"><?php echo $info; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Tujuan Pegawai</label>
                            <select name="tujuan" id="" class="form-control">
                                <option value="0">Semua</option>
                                <?php foreach ($data_level as $l): ?>
                                    <option value="<?php echo $l->id ?>" <?php if($tujuan == $l->id){ echo 'selected'; } ?>><?php echo $l->level ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('admin/info') ?>" class="btn btn-default">Cancel</a>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->