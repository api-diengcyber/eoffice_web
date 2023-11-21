
    <h2 style="margin-top:0px"><?php echo $button ?></h2>
    <div class="card card-body">
	    <form action="<?php echo $action; ?>" method="post">
		    <div class="form-group">
	            <label for="varchar">Nama Tunjangan <?php echo form_error('nama_tunjangan') ?></label>
	            <input type="text" class="form-control" name="nama_tunjangan" id="nama_tunjangan" placeholder="Nama Tunjangan" value="<?php echo $nama_tunjangan; ?>" />
	        </div>
		    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
		    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
		    <a href="<?php echo site_url('admin/pil_tunjangan') ?>" class="btn btn-default">Cancel</a>
		</form>
	</div>