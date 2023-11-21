    <h2 style="margin-top:0px"><?php echo $button ?></h2>
    <div class="card card-body">
        <form action="<?php echo $action; ?>" method="post">
    	    <div class="form-group">
                <label for="varchar">Jabatan <?php echo form_error('jabatan') ?></label>
                <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan" value="<?php echo $jabatan; ?>" />
            </div>
    	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
    	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    	    <a href="<?php echo site_url('admin/pil_jabatan') ?>" class="btn btn-default">Cancel</a>
    	</form>
    </div>