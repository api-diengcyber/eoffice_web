<div class="card card-body">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-3">Pengaturan Jam</h3>
        </div>

    </div>
    
<!-- 
    <?php if(!empty($message)){ ?>

    <div class="alert alert-info"><?php echo $message;?></div>

    <?php } ?> -->
    
    <form action="<?php echo base_url(); ?>admin/hari_kerja/simpan_jam_kerja" method="post">
        <div class="row">
        <div class="col-md-6">
            <div class="form-group">

                <label for="">Jam Masuk</label>

                <input type="time" name="jam_masuk" class="form-control" id="datepicker" value="<?php 
                if($jam_kerja==null){
                    
                }else{
                    echo $jam_kerja->jam_masuk;
                };
                ?>" required>

            </div>
            
        </div>
        <div class="col-md-6">

            <div class="form-group">
    
                <label for="">Jam Pulang</label>
    
                <input type="time" name="jam_pulang" class="form-control" id="datepicker" value="<?php if($jam_kerja==null){
                     
                    }else{
                        echo $jam_kerja->jam_pulang;
                    };
                    ?>" required>
            </div>
        </div>


        <div class="form-group"><button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button></div>

    </div>
    </form>

</div>