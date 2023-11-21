<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Ijin Tidak Masuk
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?=$id_users?>" name="id_users">
                        <div class="form-group">
                            <label for="varchar">Tgl <?php echo form_error('tgl') ?></label>
                            <input type="date" class="datepicker form-control" name="tgl" placeholder="Tgl" value="<?php echo $tgl; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="int">Tidak Masuk <?php echo form_error('tidak_masuk') ?></label>
                            <select class="form-control" name="tidak_masuk" id="tidak_masuk">
                              <?php foreach ($data_pil_tidak_masuk as $key): ?>
                                <?php if ($key->id == $tidak_masuk) { ?>
                                  <option selected value="<?php echo $key->id ?>"><?php echo $key->ket_tidak_masuk ?></option>
                                <?php } else { ?>
                                  <option value="<?php echo $key->id ?>"><?php echo $key->ket_tidak_masuk ?></option>
                                <?php } ?>
                              <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">File</label>
                            <input type="file" name="surat" id="" class="form-control" <?php if(empty($surat_ijin)){ echo 'required';}?> >
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control"><?php echo $keterangan;?></textarea>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('pegawai/tidak_masuk') ?>" class="btn btn-danger">Cancel</a>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
