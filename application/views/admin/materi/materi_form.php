<h2 style="margin-top:0px"><?php echo $button ?></h2>

<div class="card p-3">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="varchar">Nama Materi <?php echo form_error('nama_materi') ?></label>
            <input type="text" class="form-control" name="nama_materi" id="nama_materi" placeholder="Nama Materi" value="<?php echo $nama_materi; ?>" />
        </div>
        <div class="form-group">
            <label for="isi">Isi <?php echo form_error('isi') ?></label>
            <textarea class="form-control" rows="3" name="isi" id="isi" placeholder="Isi"><?php echo $isi; ?></textarea>
        </div>
        <div class="form-group">
            <label for="varchar">Lampiran <?php echo form_error('lampiran') ?></label>
            <?php if(!empty($lampiran)){ ?> <br>
            <span class="badge badge-primary mb-2"><?php echo $lampiran ?></span>
            <!-- <input type="hidden" name="old" value="<?php echo $lampiran ?>"> -->
            <?php } ?>
            <input type="file" name="lampiran" class="form-control dropify" data-height="130">
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
        <a href="<?php echo site_url('admin/materi') ?>" class="btn btn-default">Cancel</a>
    </form>
</div>