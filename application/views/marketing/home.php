<style>
    .steps>li.active { 
        background-color: transparent!important;
    }
    .steps>li.active > .step {
        border-color: #00BCD4!important;
    }
</style>
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                                <ul class="steps">
                                  <?php $i=0;foreach ($data_pil_tingkat as $key):?>
                                    <li class="list <?php if ($key->id < $tingkat) { echo 'complete'; } ?> <?php if ($key->id == $tingkat) { echo 'active'; } ?>" data-step="<?php echo $key->id ?>">
                                        <span class="step"><?php echo $i++ ?></span>
                                        <span class="title"><?php echo $key->tingkat ?></span>
                                    </li>
                                  <?php endforeach ?>
                                </ul>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12" style="padding:20px">
                          <div class="card card-statistics" data-step="<?php echo $jabatan->id ?>">
                            <div class="card-body">
                              <div class="clearfix">
                                <div class="float-left">
                                  <i class="mdi mdi-calendar-check text-warning icon-lg"></i>
                                </div>
                                <div class="float-right">
                                  <p class="mb-0 text-right"><?php echo $jabatan->level ?></p>
                                  <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0"><?php echo $jabatan->jabatan ?></h3>
                                  </div>
                                  <span class="pull-right"><?php echo $jabatan->tingkat ?></span>
                                  <!--<p><?php echo $jabatan->ket ?></p>-->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-body">
                                <h3>Tugas</h3>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <th>No</th>
                                            <th>Tugas</th>
                                            <td>Pesan</td>
                                            <th style="width:200px">Aksi</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data_tugas as $dt): ?>
                                            <tr>
                                                <td><?php echo $dt->id ?></td>
                                                <td><?php echo $dt->judul ?></td>
                                                <td>
                                                    <?php 
                                                        if(!empty($dt->detail)){
                                                         echo '<i class="mdi mdi-message-text"></i> Ada '.$dt->detail.' pesan baru';
                                                        }else{
                                                         echo 'Belum ada pesan';
                                                        }
                                                    ?>
                                                </td>
                                                <td><a href="<?php echo base_url() ?>pegawai/tugas/read/<?php echo $dt->id ?>" class="btn btn-xs btn-primary"><i class="mdi mdi-eye"></i> Detail</a></td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script type="text/javascript">
jQuery(function($){

    $(".complete, .active").click(function(){
        var id = $(this).data('step');
        tTingkat(id);
    });
    
    <?php if (!empty($tingkat)) { ?>
        tTingkat(<?php echo $tingkat ?>);
    <?php } ?>

    function tTingkat(id){
        $("div[id*=tingkat]").hide();
        $("div[id=tingkat][data-step="+id+"]").show();
    }

});    
</script>