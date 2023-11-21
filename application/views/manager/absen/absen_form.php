
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h3>
                    Absen
                </h3>
            </div><!-- /.page-header -->

            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
            </div>

            <div class="row hidden-sm hidden-xs">
                <div class="col-md-8">
                    <!-- PAGE CONTENT BEGINS -->
                  <div class="row">
                      <div class="col-md-6 col-6">
                       <form action="<?php echo base_url() ?>manager/absen/absen_action" method="post">
                            <button type="submit" name="absen" id="masuk" value="1"  class="btn btn-rounded <?php if ($status=='1' || $status=='2') { echo 'btn-default disabled'; } else { echo 'btn-success'; } ?>  no-radius btn-block " id="btnMasuk">
                                <i class="ace-icon fa fa-download bigger-230"></i>
                                MASUK
                            </button>
                            <input type="hidden" name="status" value="<?php echo $status ?>">
                        </form>
                      </div>
                      <div class="col-md-6 col-6">
                          <form action="<?php echo base_url() ?>manager/absen/absen_action" method="post" id="absen">
                                <button type="button" id="pulang" name="absen" value="2" <?php if ($status=='0') { echo 'disabled'; } ?> class="btn no-border <?php if ($status=='2') { echo 'btn-warning'; } else if($status == '1') { echo 'btn-danger'; } else{ echo 'btn-default'; } ?> no-radius btn-block btn-rounded" id="btnPulang">
                                    <i class="ace-icon fa fa-upload bigger-230"></i>
                                    PULANG
                                </button>
                            <input type="hidden" name="absen" value="2" id="val">
                            <input type="hidden" name="status" value="<?php echo $status ?>">
                      </div>
                  </div>
                  </form>
                
                <!-- Modal -->
                <div class="modal fade" id="modalPagi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog bg-danger" role="document">
                        <div class="modal-content border-danger bg-danger">
                            <div class="modal-body bg-danger text-white">
                                Anda harus upload laporan pekerjaan hari ini terlebih dahulu.
                                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalSiang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog bg-danger" role="document">
                        <div class="modal-content border-danger bg-danger">
                            <div class="modal-body bg-danger text-white">
                                Anda harus upload laporan sore terlebih dahulu.
                                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                  <script>
                    $(document).ready(function(){
                        $('#pulang').click(function(){
                            console.log(<?php print_r($status_laporan);?>);
                            var status_laporan = <?php echo $status_laporan;?>;
                            if(status_laporan == 0){
                                $('#modalPagi').modal('show');
                            }else if(status_laporan == 1){
                                $('#modalSiang').modal('show');
                            }else{
                                $('#absen').submit();
                            }
                        });
                    });
                  </script>

                  <div class="space"></div>

                  <div class="row mb-3">
                    <div class="col-12">
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-dark mt-3" id="mytable">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th width="150px">Tanggal</th>
                                    <th width="50px">Status</th>
                                    <th width="300px">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; foreach ($data_absen as $key): 
                            $nm_status = '';
                            if ($key->status == '1') { // MASUK
                                $nm_status = "<label class='badge badge-primary'>MASUK</label>";
                            } else if ($key->status == '2') { // PULANG
                                $nm_status = "<label class='badge badge-danger'>PULANG</label>";
                            }
                            ?>
                                <tr>
                                    <td><?php echo $no ?></td>
                                    <td>
                                        <p class="mb-2"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $key->tgl; ?></p>
                                        <p class="mb-2"><?php echo '<i class="fa fa-clock-o"></i> Masuk &nbsp;: '.$key->jam_masuk;?></p>
                                        <p class="mb-2"><?php echo '<i class="fa fa-clock-o"></i> Pulang : '.$key->jam_pulang ?></p>
                                    </td>
                                    <td>
                                        <?php
                                            if($key->jam_pulang != ''){
                                                $start = new \DateTime($key->tgl.' '.$key->jam_masuk);
                                                $end   = new \DateTime($key->tgl.' '.$key->jam_pulang);

                                                $interval  = $end->diff($start);
                                                $jam_masuk =  $interval->format('%h,%i Jam');
                                                echo $jam_masuk.'<br><br>';

                                                if($jam_masuk >= 7){
                                                    echo "<label class='badge badge-primary'>FULL TIME</label>";
                                                }else if($jam_masuk > 4 AND $jam_masuk < 7){
                                                    echo "<label class='badge badge-warning'>PART TIME</label>";
                                                }
                                                else if($jam_masuk < 5){
                                                   
                                                }
                                            }
                                            
                                        ?>
                                    </td>
                                    <td>
                                        <?php if(empty($key->keterangan)){?>
                                        <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalKet">Tambah Keterangan</a>
                                        <?php } else { ?>
                                        <?php
                                        echo '<div class="mb-1">'.$key->keterangan.'</div><br><a class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#modalKet">Ubah Keterangan</a>';
                                        } ?>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalKet" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <form action="<?php echo base_url('manager/absen/add_keterangan');?>" method="post">
                                            <div class="modal-dialog text-black" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                           <div class="form-group">
                                                             <label for="">Keterangan</label>
                                                             <textarea name="keterangan" id="" cols="30" rows="10" class="form-control"><?php echo $key->keterangan;?></textarea>
                                                           </div>
                                                           <div class="form-group">
                                                              <input type="hidden" name="id" id="input" class="form-control" value="<?php echo $key->id;?>">
                                                              <input type="checkbox" name="pulang" id="" checked>
                                                              <label for="">Pulang</label>
                                                           </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        
                                        <script>
                                            $('#exampleModal').on('show.bs.modal', event => {
                                                var button = $(event.relatedTarget);
                                                var modal = $(this);
                                                // Use above variables to manipulate the DOM
                                                
                                            });
                                        </script>
                                    </td>
                                </tr>
                            <?php $no++; endforeach ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                  </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->

                <div class="col-md-4">

                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white mb-3 card-header-flat">
                            <h4 class="smaller">
                                <i class="normal-icon ace-icon fa fa-bell red bigger-130"></i>
                                Tugas Belum Selesai
                            </h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="card-main">
                                <ol class="mlist">
                                    <?php foreach ($data_tugas as $dt): ?>
                                    <li class="dd-item dd2-item item-red row" data-id="1">
                                        <div class="col-9"><?php echo $dt->judul ?></div>
                                        <div class="col-3"><a href="<?php echo base_url('manager/tugas/my_detail/').$dt->id ?>" class="btn btn-primary btn-xs pull-right">Detail</a></a>
                                    </li>
                                    <?php endforeach ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary text-white mb-3 card-header-flat">
                            <h4 class="smaller">
                                <i class="normal-icon ace-icon fa fa-calendar orange2 bigger-130"></i>
                                Riwayat Masuk
                            </h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="card-main">
                                <?php if (count($data_rekap_tahun) < 1 && count($data_rekap_bulan) < 1) { ?>
                                    <div class="alert alert-info">
                                        Rekap Kosong!
                                    </div>
                                <?php } else { ?>
                                    <div style="display:flex;overflow-y:scroll;" class="scroll-onhover">
                                    <?php foreach ($data_rekap_tahun as $key): ?>
                                        <a href="<?php echo base_url('manager/absen/index/').date('m').'/'.$key->tahun;?>" class="btn btn-primary btn-xs no-radius" style="margin: 2px;">
                                            <i class="ace-icon fa fa-calendar bigger-110"></i>
                                            <?php echo $key->tahun ?>
                                            <span class="badge bg-white text-black"><?php echo $key->jml ?></span>
                                        </a>
                                    <?php endforeach ?>
                                    </div>
                                    <div class="hr hr-double hr10"></div>
                                    <div class="dd dd-draghandle">
                                        <ol class="mlist">
                                          <?php foreach ($data_rekap_bulan as $key): ?>
                                            <li class="dd-item dd2-item item-orange p-2" style="cursor:pointer" data-id="1" onclick="location.href='<?php echo base_url().'manager/absen/index/'.$key->id_bulan.'/'.$this->uri->segment(5);?>'">
                                                <div class="dd2-content">
                                                    <?php echo $key->bulan ?> <?php echo $tahun ?> 
                                                    <span class="badge badge-warning pull-right"><?php echo $key->jml ?></span>
                                                </div>
                                            </li>
                                          <?php endforeach ?>
                                        </ol>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->