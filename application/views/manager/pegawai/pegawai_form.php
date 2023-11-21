
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Pegawai
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                  <form action="<?php echo $action; ?>" method="post">
                    <div class="row">
                        <?php if($status != ''){ ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0" <?php if($status == 0){ echo 'selected'; } ?>>Tidak Aktif</option>
                                    <option value="1" <?php if($status == 1){ echo 'selected'; } ?>>Aktif</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="varchar">Username <?php echo form_error('username') ?></label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" maxlength="50" />
                            </div>
                            <div class="form-group">
                                <label for="varchar">Nama Pegawai <?php echo form_error('nama_pegawai') ?></label>
                                <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" placeholder="Nama Pegawai" value="<?php echo $nama_pegawai; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="varchar">Tgl Masuk <?php echo form_error('tgl_masuk') ?></label>
                                <input type="text" class="form-control" name="tgl_masuk" id="datepicker1" placeholder="Tgl Masuk" value="<?php echo $tgl_masuk; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="varchar">Rekening <?php echo form_error('rekening') ?></label>
                                <input type="text" class="form-control" name="rekening" id="rekening" placeholder="Rekening" value="<?php echo $rekening; ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="int">Level <?php echo form_error('level') ?></label>
                                <select class="form-control" name="level" id="level">
                                    <option value="">-- Pilih Level --</option>
                                    <?php foreach ($data_pil_level as $key): ?>
                                      <?php if ($key->id == $level) { ?>
                                        <option selected value="<?php echo $key->id ?>"><?php echo $key->level ?></option>
                                      <?php } else { ?>
                                        <option value="<?php echo $key->id ?>"><?php echo $key->level ?></option>
                                      <?php } ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Pilih Jabatan</label>
                                <select name="id_jabatan" id="jabatan" class="form-control">
                                    <option value="">-- Pilih Jabatan --</option>
                                    <?php foreach ($jabatan as $j): ?>
                                        <option value="<?php echo $j->id ?>" <?php if($j->id == $id_jabatan){ echo 'selected'; } ?>><?php echo $j->jabatan ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="int">Tingkat <?php echo form_error('tingkat') ?></label>
                                <select class="form-control" name="tingkat" id="tingkat">
                                    <?php if(empty($id_tingkat)){ ?>
                                    <option value="">Silahkan Pilih Jabatan Terlebih Dahulu</option>
                                    <?php }else{ ?>
                                    <?php foreach ($data_tingkat as $dt): ?>
                                    <option value="<?php echo $dt->id ?>" <?php if($dt->id == $id_tingkat){ echo 'selected'; } ?>><?php echo $dt->tingkat ?></option>
                                    <?php endforeach ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="double">Gaji Pokok <?php echo form_error('gaji_pokok') ?></label>
                                <input type="text" class="form-control" name="gaji_pokok" id="gaji_pokok" placeholder="Gaji Pokok" value="<?php echo $gaji_pokok; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="varchar">Password <?php echo form_error('password') ?></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="space"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                            <a href="<?php echo site_url('admin/pegawai') ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                  </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->


<script type="text/javascript">
$(document).ready(function(){
    $("#username").on('keyup', function(){
        var username = $(this).val().replace(/\ /g,'_');
        $(this).val(username.trim());
    });
    $("#gaji_pokok").on('keyup', function(){
        var gaji_pokok = $(this).val().replace(/\./g,'');
        var sgaji_pokok = number_format(gaji_pokok*1,0,',','.');
        $(this).val(sgaji_pokok);
    });
    $('#jabatan').change(function(){
        var id = $(this).val();
        $.ajax({
            url:'<?php echo base_url();?>admin/pegawai/json_tingkat',
            type:'post',
            data:{id:id},
            success:function(response){
                var data = JSON.parse(response);
                var output = '<option>-- Pilih Jabatan --</option>';
                $.each(data,function(index , val){
                    output += '<option value='+val.id;
                    if(val.id == <?php echo $tingkat;?>){
                        output += 'selected';
                    }
                    output += '>'+val.tingkat+'</option>';
                });
                $('#tingkat').html(output);
            }
        });
    });
});
</script>