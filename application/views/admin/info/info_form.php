<!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css" /> -->
  <!-- <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-login.css"> -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Info
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="varchar">Tgl <?php echo form_error('tgl') ?></label>
                            <input type="date" class="form-control" name="tgl" id="datepicker1" placeholder="Tgl" value="<?php echo $tgl; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="info">Info <?php echo form_error('info') ?></label>
                            <textarea class="form-control" rows="3" name="info" id="info" placeholder="Info"><?php echo $info; ?></textarea>
                        </div>
                        <!-- <div class="form-group">
                            <label for="">Tujuan Pegawai</label>
                            <select name="tujuan" id="" class="form-control">
                                <option value="0">Semua</option>
                                <?php foreach ($data_level as $l): ?>
                                    <option value="<?php echo $l->id ?>" <?php if($tujuan == $l->id){ echo 'selected'; } ?>><?php echo $l->level ?></option>
                                <?php endforeach ?>
                            </select>
                        </div> -->
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('admin/info') ?>" class="btn btn-default">Cancel</a>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<!-- <script src="<?php echo base_url() ?>assets/js/jquery-2.1.4.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/responsive-login.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#datepicker1").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        format: "dd-mm-yy",
      });
    });
</script> -->