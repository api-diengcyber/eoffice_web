<style>
    .steps>li.active {
        background-color: transparent !important;
    }

    .steps>li.active>.step {
        border-color: #00BCD4 !important;
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
                                <?php
                                $id = 1;
                                foreach ($data_pil_tingkat as $key) : ?>
                                    <li class="list <?php if ($key->id < $tingkat) {
                                                            echo 'complete';
                                                        } ?> <?php if ($key->id == $tingkat) {
                                                                        echo 'active';
                                                                    } ?>" data-step="<?php echo $key->id ?>">
                                        <span class="step"><?php echo $id++; ?></span>
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
                                <h3>
                                    <b>
                                        <?=$kantor?>
                                    </b>
                                </h3>
                                <hr>
                              <div class="clearfix">
                                <div class="float-left">
                                  <i class="mdi mdi-calendar-check text-warning icon-lg"></i>
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
                                            <?php $i = 1;
                                            foreach ($data_tugas as $dt) : ?>
                                                <tr>
                                                    <td><?php echo $i++ ?></td>
                                                    <td><?php echo $dt->judul ?></td>
                                                    <td>
                                                        <?php
                                                            if (!empty($dt->detail)) {
                                                                echo '<i class="mdi mdi-message-text"></i> Ada ' . $dt->detail . ' pesan baru';
                                                            } else {
                                                                echo 'Belum ada pesan';
                                                            }
                                                            ?>
                                                    </td>
                                                    <td><a href="<?php echo base_url() ?>pegawai/tugas/detail/<?php echo $dt->id ?>" class="btn btn-xs btn-primary"><i class="mdi mdi-eye"></i> Detail</a></td>
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
    jQuery(function($) {

        $(".complete, .active").click(function() {
            var id = $(this).data('step');
            tTingkat(id);
        });

        <?php if (!empty($tingkat)) { ?>
            tTingkat(<?php echo $tingkat ?>);
        <?php } ?>

        function tTingkat(id) {
            $("div[id*=tingkat]").hide();
            $("div[id=tingkat][data-step=" + id + "]").show();
        }

    });
</script>