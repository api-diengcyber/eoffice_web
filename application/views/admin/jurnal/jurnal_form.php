
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Jurnal
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                        <form action="<?php echo $action; ?>" method="post">
                            <div class="form-group">
                                <label for="varchar">Tgl <?php echo form_error('tgl') ?></label>
                                <input type="text" class="form-control" name="tgl" id="datepicker1" placeholder="Tgl" value="<?php echo $tgl; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="double">Pilihan Transaksi <?php echo form_error('id_transaksi') ?></label>
                                <select class="form-control" name="id_transaksi" id="id_transaksi">
                                  <?php foreach ($data_pil_transaksi as $key): ?>
                                    <?php if ($key->id == $id_transaksi) { ?>
                                        <option selected value="<?php echo $key->id ?>"><?php echo $key->nm_transaksi ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $key->id ?>"><?php echo $key->nm_transaksi ?></option>
                                    <?php } ?>
                                  <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="varchar">Nominal <?php echo form_error('nominal') ?></label>
                                <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Nominal" value="<?php echo $nominal; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="varchar">Keterangan <?php echo form_error('keterangan') ?></label>
                                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="<?php echo $keterangan; ?>" />
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                            <a href="<?php echo site_url('admin/jurnal') ?>" class="btn btn-default">Cancel</a>
                        </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script type="text/javascript">
jQuery(function($){
    $("#nominal").on('keyup', function(){
        var nominal = $(this).val().trim().replace(/\./g,'');
        var snominal = number_format(nominal*1,0,',','.');
        $(this).val(snominal);
    });
});
</script>