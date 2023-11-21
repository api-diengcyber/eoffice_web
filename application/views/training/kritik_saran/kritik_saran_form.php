
    <h2 style="margin-top:0px">Kritik & Saran</h2>
    <p>Silahkan masukan kritik dan saran di bawah, identitas anda tidak akan diketahui(anonym).</p>
    <?php if(!empty($message)){ ?>
    <div class="alert alert-primary"><?php echo $message ?></div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="isi">Isi <?php echo form_error('isi') ?></label>
            <textarea class="form-control" rows="3" name="isi" id="isi" placeholder="Isi"><?php echo $isi; ?></textarea>
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Kirim</button> 
	</form>
