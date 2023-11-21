    <style>
      .box3 {
        width: auto; 
        border-radius: 11px;
        color: #2c2c2c;
        padding: 10px;
        text-align: left;
        font-weight: 400;
        font-family: arial;
        position: relative;
        font-size: 14px;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.33);
      }
      .sb13 {
        background: #dcf8c6;
      }
      .sb14 {
        background: #fff;
        padding-left: 20px!important;
      }
      .sb13:before {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-left: 15px solid #dcf8c6;
        border-right: 15px solid transparent;
        border-top: 15px solid #dcf8c6;
        border-bottom: 15px solid transparent;
        right: -16px;
        top: 0px;
      }
      .sb14 .shadow, .sb13 .shadow {
        position: absolute;
        display: block;
        overflow: hidden;
        z-index: -1;
        width: 20px;
        height: 20px;
        transform: rotate(270deg);
        right: -20px;
        top: 0;
      }
      .sb14 .shadow {
        left:-20px;
        transform: rotate(0deg);
      }
      .sb14 .shadow:after, .sb13 .shadow:after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background: #999;
        transform: rotate(45deg);
        top: -10px;
        right: -10px;
        box-shadow: 1px 1px 4px 0 rgba(0,0,0,0.5);
      }
      .sb14 .shadow:after {
          box-shadow: 1px 2px 3px 0 rgba(0,0,0,0.33);
      }
      .sb14:before {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-left: 15px solid transparent;
        border-right: 15px solid #fff;
        border-top: 15px solid #fff;
        border-bottom: 15px solid transparent;
        left: -16px;
        top: 0px;
      }
    </style>
            <div class="page-header">
                <h3>
                    Tugas 
                </h3>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-md-7">
                            <?php if(!empty($message)){ ?>
                              <div class="alert alert-danger"><?php echo $message ?></div>
                            <?php } ?>
                            <div class="card card-body">
                                <form action="<?php echo base_url() ?>training/tugas/create_action" method="post" enctype="multipart/form-data">
                                    <?php if (count($data_upload_tugas_gb) > 0) {  ?>
                                        <div class="tabbable table-responsive">
                                            <ul class="nav nav-pills padding-12 tab-color-blue background-blue mb-3" id="myTab4">
                                              <?php 
                                              foreach ($data_upload_tugas_gb as $key): 
                                                if ($key->tgl == $row_upload_tugas->tgl) {
                                                    $active = "active";
                                                } else {
                                                    $active = "";
                                                }
                                              ?>
                                                <li class="nav-item ">
                                                    <a class="nav-link <?php echo $active ?>" data-toggle="tab" href="#<?php echo $key->tgl ?>"><?php echo date('d M Y',strtotime($key->tgl)); ?></a>
                                                </li>
                                              <?php endforeach ?>
                                            </ul>
                                            <div class="tab-content">
                                              <?php 
                                              foreach ($data_upload_tugas_gb as $key): 
                                                if ($key->tgl == $row_upload_tugas->tgl) {
                                                    $active = "active";
                                                } else {
                                                    $active = "";
                                                }
                                              ?>
                                                <div id="<?php echo $key->tgl ?>" class="tab-pane in <?php echo $active ?>">
                                                    <div class="dd dd-draghandle ">
                                                        <ul class="list-unstyled">
                                                            <?php
                                                            $res = $this->db->select('*')
                                                                            ->from('upload_tugas')
                                                                            ->where('id_tugas', $data_tugas->id)
                                                                            ->where('tgl', $key->tgl)
                                                                            ->get()->result();
                                                            foreach ($res as $key_data) :
                                                            ?>
                                                            <li class="dd-item dd2-item item-blue card p-2 bg-primary text-white mb-1 rounded">
                                                                <div class="dd2-content">
                                                                    <?php if (!empty($key_data->file)) { ?>
                                                                    <img src="<?php echo base_url() ?>assets/tugas/upload/<?php echo $key_data->file ?>" width="16" height="16"></img> <?php echo $key_data->file ?>
                                                                    <?php } ?>
                                                                    <p><?php echo $key_data->ket ?></p>
                                                                    <?php $ms = $this->db->where('id_upload_tugas',$key_data->id)->get('message_tugas')->result();
                                                                    if(!empty($ms)){ ?>
                                                                    <div class="card bg-light p-2 text-black" style="cursor:pointer">
                                                                      <span data-toggle="collapse" data-target="#<?php echo $key_data->id; ?>" onclick="readMsg(<?php echo $key_data->id; ?>)"><i class="mdi mdi-message-text"></i> There is a message</span>
                                                                      <div class="collapse" id="<?php echo $key_data->id ?>">
                                                                        <div class="card p-1 bg-light">
                                                                          <?php foreach($ms as $message) { ?>
                                                                              <div class="card card-body pb-2 bg-light text-black">
                                                                                <div class="box3 <?php if(!empty($message->id_user)){ echo 'sb13'; }else{ echo 'sb14'; } ?>"><?php echo $message->message; ?></div>
                                                                              </div>
                                                                          <?php } ?>
                                                                          <div class="card card-footer">
                                                                            <div class="row">
                                                                                <div class="col-9">
                                                                                  <input type="text" class="form-control" id="mMessage" name="message">
                                                                                  <input type="hidden" id="mUser" name="id_user" value="<?php echo $key_data->id_pegawai ?>">
                                                                                  <input type="hidden" id="mTugas" name="id_tugas" value="<?php echo $key_data->id ?>">
                                                                                </div>
                                                                                <div class="col-3"><button class="btn btn-primary btn-xs" type="button" id="btnMessage"><i class="mdi mdi-message"></i> Reply</button></div>
                                                                            </div>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </li>
                                                            <?php endforeach ?>
                                                        </ol>
                                                    </div>
                                                </div>
                                              <?php endforeach ?>
                                            </div>
                                        </div>
                                        <div class="hr hr-double hr18"></div>
                                    <?php } else { ?>
                                        <div class="alert alert-info">
                                        <strong>Belum ada tugas yang di Upload</strong>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label for="int">File <?php echo form_error('file') ?></label>
                                        <input type="file" class="form-control" name="file" id="id-input-file-3" placeholder="File" required />
                                    </div>
                                    <?php if($data_tugas->progress!=null){?>
                                      
                                      <div class="form-group">
                                        <label for="">Progress</label>
                                        <div class="row">
                                          <div class="col-6 col-md-3">
                                            <div class="form-group form-inline">
                                              <input type="radio" class="form-control" name="progress" id="progress" value="25" <?php if($data_tugas->progress==25){ echo 'checked';}?>>
                                              <label for="progress"> &nbsp;25 %</label>  
                                            </div>
                                          </div>
                                          <div class="col-6 col-md-3">
                                            <div class="form-group form-inline">
                                              <input type="radio" class="form-control" name="progress" id="progress2" value="50" <?php if($data_tugas->progress==50){ echo 'checked';}?>>
                                              <label for="progress2"> &nbsp;50 %</label>  
                                            </div>
                                          </div>
                                          <div class="col-6 col-md-3">
                                            <div class="form-group form-inline">
                                              <input type="radio" class="form-control" name="progress" id="progress3" value="75" <?php if($data_tugas->progress==75){ echo 'checked';}?>>
                                              <label for="progress3"> &nbsp;75 %</label>  
                                            </div>
                                          </div>
                                          <div class="col-6 col-md-3">
                                            <div class="form-group form-inline">
                                              <input type="radio" class="form-control" name="progress" id="progress4" value="100" <?php if($data_tugas->progress==100){ echo 'checked';}?>>
                                              <label for="progress4"> &nbsp;100 %</label>  
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                      
                                      <?php }else{ ?>

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
                                        <?php }?>
                                   
                                    <div class="form-group">
                                        <label for="int">Keterangan </label>
                                        <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Waktu</label>
                                        <select name="waktu" id="waktu" class="form-control">
                                           <option value="1">Pagi</option>
                                           <option value="2">Siang</option>
                                        </select>
                                    </div>
                                    <div class="space"></div>
                                    <input type="hidden" name="id" value="<?php echo $data_tugas->id ?>">
                                    <?php if (count($data_upload_tugas_gb) > 0) {  ?>
                                    <button type="submit" class="btn btn-warning btn-block">Kirim Ulang</button>
                                    <?php } else { ?>
                                    <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header card-header-flat bg-primary text-white">
                                    <h4 class="smaller">
                                        <i class="normal-icon ace-icon fa fa-clock-o green bigger-130"></i>
                                        Tugas
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-main">
                                        <strong>
                                        <div class="pull-right">
                                            <?php if ($data_tugas->selesai == '0') { ?>
                                                <?php if ($data_tugas->upload == '1') { ?>
                                                    <span class="badge badge-purple">Menunggu konfirmasi selesai</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-warning">Belum Dikerjakan</span>
                                                <?php } ?>
                                            <?php } else if ($data_tugas->selesai == '1') { ?>
                                            <span class="badge badge-primary">Dikerjakan</span>
                                            <?php } ?>
                                        </div>
                                        <span class="badge badge-primary">Tanggal : <?php echo $data_tugas->tgl ?></span> <br> 
                                        <span class="badge badge-primary">Selesai : <?php echo $data_tugas->tgl_selesai ?></span> <br> 
                                        </strong>
                                        <hr>
                                        <h5>Project    : <?php echo $data_tugas->project ?></h5>
                                        <hr>
                                        <h5>Nama Tugas : <?php echo $data_tugas->judul ?></h5>
                                        <hr>
                                        <p>Keterangan : <?php echo $data_tugas->tugas ?></p>
                                        <?php if (!empty($data_tugas->file_tugas)) { ?>
                                        <img src="<?php echo base_url() ?>assets/tugas/<?php echo $data_tugas->file_tugas ?>" width="50"></img> <br> <?php echo $data_tugas->file_tugas ?> >> <a href="<?php echo base_url() ?>assets/tugas/<?php echo $data_tugas->file_tugas ?>" class="btn btn-primary btn-minier" download>Unduh</a>
                                        <div class="hr hr-dotted hr-10"></div>
                                        <?php } ?>
                                    </div>
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
<script>
  $(document).ready(function(){
    $('#btnMessage').click(function(){
      var message  = $('#mMessage').val();
      var id_user  = $('#mUser').val();
      var id_upload_tugas = $('#mTugas').val();
      $.ajax({
        url :'<?php echo base_url();?>training/tugas/reply_message',
        type:'post',
        data:'message='+message+'&id_user='+id_user+'&id_upload_tugas='+id_upload_tugas,
        success:function(response){
          window.location.reload(true);
        }
      });
    });
  });
  function readMsg(id)
  {
    $.ajax({
      url:'<?php echo base_url();?>training/tugas/read_message',
      type:'post',
      data:{id:id},
      success:function(response){
        console.log('sukses');
      }
    });
  }
</script>