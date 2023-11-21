<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header bg-success  text-white">
                <i class="fa fa-file-pdf-o"></i> <?php echo $detail_tugas->judul; ?>
                <a href="<?php echo base_url('manager/tugas/my_read/'.$this->uri->segment(4));?>" class="btn btn-xs btn-light pull-right"><i class="fa fa-check"></i> Upload Tugas</a>
            </div>
            <div class="card-body">
                <?php echo $detail_tugas->tugas ?>
                <br>
                <?php 
                    if(file_exists('assets/tugas/my_upload/'.$detail_tugas->file_tugas))
                    { ?>
                <a href="<?php echo base_url('assets/tugas/my_upload/'.$detail_tugas->file_tugas);?>" class="badge badge-primary" onclick="return confirm('Download ?')" download><i class="fa fa-download"></i> Download Lampiran</a>   
                <?php
                    }
                ?>
            </div>
        </div>
        <a href="<?php echo base_url(); ?>" class="btn btn-danger btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>
    </div>
</div>