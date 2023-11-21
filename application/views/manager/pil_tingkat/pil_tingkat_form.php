
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Pilihan Tingkat
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                        <form action="<?php echo $action; ?>" method="post">
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select name="id_jabatan" id="jabatan" class="form-control">
                                    <?php foreach ($jabatan as $j): ?>
                                        <option value="<?php echo $j->id ?>" <?php if($id_jabatan == $j->id){ echo 'selected'; } ?>><?php echo $j->jabatan ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="varchar">Tingkat <?php echo form_error('tingkat') ?></label>
                                <input type="text" class="form-control" name="tingkat" id="tingkat" placeholder="Tingkat" value="<?php echo $tingkat; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="varchar">Ket <?php echo form_error('ket') ?></label>
                                <input type="text" class="form-control" name="ket" id="ket" placeholder="Ket" value="<?php echo $ket; ?>" />
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                            <a href="<?php echo site_url('admin/pil_tingkat') ?>" class="btn btn-default">Cancel</a>
                        </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->