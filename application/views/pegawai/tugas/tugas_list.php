
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h3>
                    LAPORAN PEKERJAAN
                </h3>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-md-7">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-8">    
                        <form action="" method="post">
                          <div class="col-md-12" style="padding:0px">
                            <div class="form-group">
                                <div class="col-12 input-group" style="width:100%">
                                    <span class="input-group-append">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <select class="form-control input-lg" name="tahun" id="tahun" onchange="this.form.submit()">
                                      <?php foreach ($data_tahun as $key): ?>
                                        <?php if ($key->tahun == $tahun) { ?>
                                          <option selected value="<?php echo $key->tahun ?>"><?php echo $key->tahun ?></option>
                                        <?php } else { ?>
                                          <option value="<?php echo $key->tahun ?>"><?php echo $key->tahun ?></option>
                                        <?php } ?>
                                      <?php endforeach ?>
                                    </select>
                                    <span class="input-group-append">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <select class="form-control input-lg" name="bulan" id="bulan" onchange="this.form.submit()">
                                      <?php foreach ($data_bulan as $key): ?>
                                        <?php if ($key->id == $bulan) { ?>
                                          <option selected value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                        <?php } else { ?>
                                          <option value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                        <?php } ?>
                                      <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </form>
                        </div>
                        <div class="col-md-4">
                        <?php if(!empty($message)){ ?>
                        <div class="alert alert-info w-100"><?php echo $message ?></div>
                        <?php } ?>
                        <button class="btn btn-primary pull-right float-right btn-block" data-toggle="modal" data-target="#modalSusulan"><i class="mdi mdi-clipboard-check"></i> Input Tugas hari ini</button>
                        <!-- Modal -->
                        </div>
                        <div id="modalSusulan" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">  
                                  <!--<li class="nav-item">-->
                                  <!--  <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Tugas Belum Di Laporkan</a>-->
                                  <!--</li>-->
                                  <li class="nav-item">
                                    <a class="nav-link active " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Laporan</a>
                                  </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active card card-body border" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <form action="<?php echo base_url('pegawai/tugas/susulan') ?>" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Judul</label>
                                                        <input type="text" class="form-control" name="judul" placeholder="Judul tugas anda">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Deskripsi</label>
                                                        <textarea name="tugas" id="" cols="30" rows="4" class="form-control" placeholder="Deskripsi tugas anda"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Lampiran</label>
                                                        <input type="file" class="form-control" name="lampiran">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Progress</label>
                                                        <div class="row">
                                                          <div class="col-6 col-md-3">
                                                            <div class="form-group form-inline">
                                                              <input type="radio" class="form-control" name="progress" id="progress" value="25">
                                                              <label for="progress"> &nbsp;25 %</label>  
                                                            </div>
                                                          </div>
                                                          <div class="col-6 col-md-3">
                                                            <div class="form-group form-inline">
                                                              <input type="radio" class="form-control" name="progress" id="progress2" value="50">
                                                              <label for="progress2"> &nbsp;50 %</label>  
                                                            </div>
                                                          </div>
                                                          <div class="col-6 col-md-3">
                                                            <div class="form-group form-inline">
                                                              <input type="radio" class="form-control" name="progress" id="progress3" value="75">
                                                              <label for="progress3"> &nbsp;75 %</label>  
                                                            </div>
                                                          </div>
                                                          <div class="col-6 col-md-3">
                                                            <div class="form-group form-inline">
                                                              <input type="radio" class="form-control" name="progress" id="progress4" value="100">
                                                              <label for="progress4"> &nbsp;100 %</label>  
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="">Waktu</label>
                                                        <select name="waktu" id="waktu" class="form-control">
                                                            <option value="1">Pekerjaan Pagi</option>
                                                            <option value="2">Pekerjaan Siang</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Keterangan Tambahan</label>
                                                        <textarea name="keterangan" id="" cols="30" rows="3" class="form-control" placeholder="Keterangan tambahan misal keluhan dll"></textarea>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            
                                            <button class="btn btn-primary" type="submit">Selesai</button>
                                        </form>
                                  </div>
                                  
                                </div>
                                </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                
                              </div>
                            </div>

                          </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card card-header bg-success text-white">
                                    <span style="position:absolute;right:10px;top:10px;cursor:pointer" data-toggle="collapse" data-target="#collapsepagi"><i class="fa fa-chevron-down"></i></span>
                                    Pekerjaan Pagi
                                </div>
                                <div class="collapse show" id="collapsepagi">
                                    <div class="card card-body">
                                        <div class="dd dd-draghandle">
                                            <ol class="dd-list unstyled" style="padding-left:0px">
                                                <?php 
                                                if(!empty($tugas_pagi)){
                                                foreach ($tugas_pagi as $key):
                                                    $warna_item = "";
                                                    $warna = "";
                                                    $icon = "";
                                                    $btn = "btn-primary";
                                                    if ($key->selesai == '1') {
                                                        $warna_item = "blue";
                                                        $warna = "blue";
                                                        $icon = "fa-bars";
                                                        $btn = "btn-primary";
                                                        $a = '<a class="badge badge-success text-white arrowed-in arrowed-in-right" href="#">Sudah Dikerjakan</a>';
                                                    } else if ($key->selesai == '0') {
                                                        if ($key->upload == '1') {
                                                            if($key->progress < 100){
                                                                $warna_item = "purple";
                                                                $warna = "purple";
                                                                $icon = "fa-clock-o";
                                                                $btn = "btn-info";
                                                                $a = '<span class="badge badge-info" href="#">Menunggu progress selesai</span>';
                                                            }else{
                                                                $warna_item = "purple";
                                                                $warna = "purple";
                                                                $icon = "fa-clock-o";
                                                                $btn = "btn-info";
                                                                $a = '<span class="badge badge-info" href="#">Menunggu konfirmasi selesai</span>';
                                                            }
                                                        } else {
                                                            $warna_item = "orange";
                                                            $warna = "orange";
                                                            $icon = "fa-clock-o";
                                                            $btn = "btn-warning";
                                                            $a = '<span class="badge badge-warning" href="#">Belum Dikerjakan</span>';   
                                                        }
                                                    }
                                                ?>
                                                <li class="dd-item card p-2 mb-2 border-bottom dd2-item item-<?php echo $warna_item;?>">
                                                    <div class="dd2-content">
                                                        <div class="pull-right action-buttons">
                                                            <a class="green badge badge-primary" href="#">Tanggal : <?php echo $key->tgl ?></a> <br>
                                                            <a class="blue badge badge-dark" href="#">Selesai : <?php echo $key->tgl_selesai ?></a> <br> 
                                                            <span><?php echo $a; ?></span> <br>
                                                        </div>
                                                        <h4 style="text-transform:capitalize!important"><?php echo $key->judul ?></h4>
                                                        
                                                        <span class="badge badge-success" style="cursor:pointer" data-toggle="modal" data-target="#md<?php echo $key->id ?>"><i class="mdi mdi-file"></i> Lampiran</span>
                                                        <div class="modal fade" id="md<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                          <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"><i class="mdi mdi-file"></i> Lampiran</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                                </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                <img src="<?php echo base_url('assets/tugas/upload/').$key->file ?>" alt="" class="mt-2 mb-2" style="width:100%">
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <p class="">
                                                            <?php echo (strlen($key->ket) >= 255 ? substr($key->ket,0,255) : $key->ket) ?> 
                                                        </p>
                                                        <!--<a class="btn <?php echo $btn ?> btn-xs" href="<?php echo base_url() ?>pegawai/tugas/read/<?php echo $key->id ?>"> Buka Tugas</a>-->
                                                    </div>
                                                </li>
                                                <?php endforeach;
                                                }else{
                                                    echo '<span class="alert alert-danger">Anda belum upload tugas pagi</span>';
                                                } ?>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card card-header bg-success text-white">
                                    <span style="position:absolute;right:10px;top:10px;cursor:pointer" data-toggle="collapse" data-target="#collapsesiang"><i class="fa fa-chevron-down"></i></span>
                                    Pekerjaan Siang
                                </div>
                                <div class="collapse show" id="collapsesiang">
                                    <div class="card card-body">
                                        <div class="dd dd-draghandle">
                                            <ol class="dd-list unstyled" style="padding-left:0px">
                                                <?php 
                                                if(!empty($tugas_siang)){
                                                foreach ($tugas_siang as $key):
                                                    $warna_item = "";
                                                    $warna = "";
                                                    $icon = "";
                                                    $btn = "btn-primary";
                                                    if ($key->selesai == '1') {
                                                        $warna_item = "blue";
                                                        $warna = "blue";
                                                        $icon = "fa-bars";
                                                        $btn = "btn-primary";
                                                        $a = '<a class="badge badge-primary arrowed-in arrowed-in-right" href="#">Sudah Dikerjakan</a>';
                                                    } else if ($key->selesai == '0') {
                                                        if ($key->upload == '1') {
                                                            if($key->progress < 100){
                                                                $warna_item = "purple";
                                                                $warna = "purple";
                                                                $icon = "fa-clock-o";
                                                                $btn = "btn-info";
                                                                $a = '<span class="badge badge-info" href="#">Menunggu progress selesai</span>';
                                                            }else{
                                                                $warna_item = "purple";
                                                                $warna = "purple";
                                                                $icon = "fa-clock-o";
                                                                $btn = "btn-info";
                                                                $a = '<span class="badge badge-info" href="#">Menunggu konfirmasi selesai</span>';
                                                            }
                                                        } else {
                                                            $warna_item = "orange";
                                                            $warna = "orange";
                                                            $icon = "fa-clock-o";
                                                            $btn = "btn-warning";
                                                            $a = '<span class="badge badge-warning" href="#">Belum Dikerjakan</span>';   
                                                        }
                                                    }
                                                ?>
                                                <li class="dd-item card p-2 mb-2 border-bottom dd2-item item-<?php echo $warna_item;?>">
                                                    <div class="dd2-content">
                                                        <div class="pull-right action-buttons">
                                                            <a class="green badge badge-primary" href="#">Tanggal : <?php echo $key->tgl ?></a> <br>
                                                            <a class="blue badge badge-dark" href="#">Selesai : <?php echo $key->tgl_selesai ?></a> <br> 
                                                            <span><?php echo $a; ?></span> <br>
                                                        </div>
                                                        <h4 style="text-transform:capitalize!important"><?php echo $key->judul ?></h4>
                                                        
                                                        <span class="badge badge-success" style="cursor:pointer" data-toggle="modal" data-target="#md<?php echo $key->id ?>"><i class="mdi mdi-file"></i> Lampiran</span>
                                                        <div class="modal fade" id="md<?php echo $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                          <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"><i class="mdi mdi-file"></i> Lampiran</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                                </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                <img src="<?php echo base_url('assets/tugas/upload/').$key->file ?>" alt="" class="mt-2 mb-2" style="width:100%">
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <p class="">
                                                            <?php echo (strlen($key->ket) >= 255 ? substr($key->ket,0,255) : $key->ket) ?> 
                                                        </p>
                                                        <!--<a class="btn <?php echo $btn ?> btn-xs" href="<?php echo base_url() ?>pegawai/tugas/read/<?php echo $key->id ?>"> Buka Tugas</a>-->
                                                    </div>
                                                </li>
                                                <?php endforeach;
                                                }else{
                                                    echo '<span class="alert alert-danger">Anda belum upload tugas siang</span>';
                                                } ?>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
                <div class="col-md-5">
                    <div class="card card-header bg-success text-white">
                        <span style="position:absolute;right:10px;top:10px;cursor:pointer" data-toggle="collapse" data-target="#taskCollapse"><i class="fa fa-chevron-down"></i></span>
                        Daftar Tugas
                    </div>
                    <div class="collapse bg-white" id="taskCollapse">
                        <div class="card-body ">
                            <?php if(count($data_tugas) > 0) { ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="dd dd-draghandle">
                                        <ol class="dd-list unstyled" style="padding-left:0px">
                                            <?php 
                                            foreach ($data_tugas as $key):
                                                $warna_item = "";
                                                $warna = "";
                                                $icon = "";
                                                $btn = "btn-primary";
                                                if ($key->selesai == '1') {
                                                    $warna_item = "blue";
                                                    $warna = "blue";
                                                    $icon = "fa-bars";
                                                    $btn = "btn-primary";
                                                    $a = '<a class="badge badge-success text-white arrowed-in arrowed-in-right" href="#">Sudah Dikerjakan</a>';
                                                } else if ($key->selesai == '0') {
                                                    if ($key->upload == '1') {
                                                        if($key->progress < 100){
                                                            $warna_item = "purple";
                                                            $warna = "purple";
                                                            $icon = "fa-clock-o";
                                                            $btn = "btn-info";
                                                            $a = '<span class="badge badge-info text-white" href="#">Menunggu progress selesai</span>';
                                                        }else{
                                                            $warna_item = "purple";
                                                            $warna = "purple";
                                                            $icon = "fa-clock-o";
                                                            $btn = "btn-info";
                                                            $a = '<span class="badge badge-info text-white" href="#">Menunggu konfirmasi selesai</span>';
                                                        }
                                                    } else {
                                                        $warna_item = "orange";
                                                        $warna = "orange";
                                                        $icon = "fa-clock-o";
                                                        $btn = "btn-warning";
                                                        $a = '<span class="badge badge-warning" href="#">Belum Dikerjakan</span>';   
                                                    }
                                                }
                                            ?>
                                            <li class="dd-item card card-body mb-2 dd2-item item-<?php echo $warna_item;?>">
                                                <div class="dd2-content">
                                                    <div class="pull-right action-buttons">
                                                        <a class="green badge badge-primary" href="#">Tanggal : <?php echo $key->tgl ?></a> <br>
                                                        <a class="blue badge badge-dark" href="#">Selesai : <?php echo $key->tgl_selesai ?></a> <br> 
                                                        <span><?php echo $a; ?></span> <br>
                                                    </div>
                                                    <h4 style="text-transform:capitalize!important"><?php echo $key->judul ?></h4>
                                                    <p class="">
                                                        <?php echo (strlen($key->tugas) >= 255 ? substr($key->tugas,0,255) : $key->tugas) ?> 
                                                    </p>
                                                    <a class="btn <?php echo $btn ?> btn-xs" href="<?php echo base_url() ?>pegawai/tugas/read/<?php echo $key->id ?>"> Buka Tugas</a>
                                                </div>
                                            </li>
                                            <hr>
                                            <?php endforeach ?>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="alert alert-info">
                                <strong>Tidak Ada Tugas</strong>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header card-header-flat bg-info text-white">
                            <h4 class="smaller">
                                <i class="normal-icon ace-icon fa fa-external-link green bigger-130"></i>
                                Riwayat Upload Tugas
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="card-main">
                                <?php foreach ($data_riwayat_upload as $key): ?>
                                    <div class="card card-statistics bg-light mb-1 p-3" style="width:100%;">
                                        <div class="row">
                                            <div class="col-2">
                                                <i class="mdi mdi-clipboard-check text-blue" style="font-size:30px"></i>
                                            </div>
                                            <div class="col-10">
                                                <span class="card-data-number"><?php echo $key->file ?></span>
                                                <div class="card-content"><?php echo $key->ket ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->