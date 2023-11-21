
    <h2 style="margin-top:0px"><?php echo $button ?></h2>
    <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama Potongan <?php echo form_error('nama_potongan') ?></label>
            <input type="text" class="form-control" name="nama_potongan" id="nama_potongan" placeholder="Nama Potongan" value="<?php echo $nama_potongan; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin/pil_potongan') ?>" class="btn btn-default">Cancel</a>
	</form>