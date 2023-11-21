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
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h3>
                    Tugas
                </h3>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="card card-body mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-user"></i>   <span style="text-transform:capitalize"><?php echo $username; ?></span><br>
                                <label for="" class="badge badge-primary">Tanggal <?php echo $tgl; ?></label>
                                <label for="" class="badge badge-success">Tanggal Selesai <?php echo $tgl_selesai; ?></label>
                                <?php if ($selesai == '1') { ?>
                                <span class="badge badge-success">Selesai</span>
                                <?php } else { ?>
                                <span class="badge badge-warning">Belum Selesai</span>
                                <?php } ?>
                                <label for="" class="badge badge-info" data-toggle="modal" data-target="#modalLampiran" style="cursor:pointer"><i class="mdi mdi-file"></i> Lampiran</label>
                                <br><br>
                                <h5 style="margin-bottom:5px;">Tugas</h5>
                                <?php echo $tugas; ?>

                              <div class="wrapper mt-1">
                                <div class="d-flex justify-content-between">
                                  <h5 class="mb-2">Progress</h5>
                                  <p class="mb-2 text-primary"><?php echo $progress ?>%</p>
                                </div>
                                <div class="progress">
                                  <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $progress ?>%" aria-valuenow="<?php echo $progress ?>"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </div>
                            <div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="mdi mdi-file"></i> File</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <?php if(!empty($file_tugas)){ ?>
                                        <embed src="<?php echo base_url() ?>assets/tugas/<?php echo $file_tugas; ?>" type="" width="200"></embed><br>
                                        <a href="<?php echo base_url() ?>assets/tugas/<?php echo $file_tugas; ?>" download="" class="btn btn-primary btn-xs no-border btn-round">Unduh</a>
                                        <?php } ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="space"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dd dd-draghandle">
                                
                                <ol class="list-unstyled">
                                  <h3 class="title">Laporan</h3>
                                  <div class="row">
                                    <?php foreach ($data_upload as $key): ?>
                                      <div class="col-md-4">
                                          <li class="dd-item dd2-item item-orange2 card bg-white mb-1">
                                            <div class="card-header bg-white">
                                              <button class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#modalMessage<?php echo $key->id ?>" type="button"><i class="mdi mdi-message-text"></i> Pesan</button>
                                              <!-- Modal -->
                                              <div id="modalMessage<?php echo $key->id ?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">

                                                  <!-- Modal content-->
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <div class="card bg-transparent">
                                                          <div class="p-3">
                                                              <?php $ms = $this->db->where('id_upload_tugas',$key->id)->get('message_tugas')->result(); ?>
                                                              <?php foreach($ms as $message) { ?>
                                                                  <div class="box3 <?php if(!empty($message->id_user)){ echo 'sb14'; }else{ echo 'sb13'; } ?> mb-3"><?php echo $message->message; ?></div>
                                                              <?php } ?>
                                                          </div>
                                                          <div class="card-footer" style="border-top:0px">
                                                              <div class="row">
                                                                  <div class="col-9">
                                                                    <input type="text" class="form-control" id="mMessage<?php echo $key->id ?>" name="message">
                                                                    <input type="hidden" id="mTugas<?php echo $key->id ?>" name="id_tugas" value="<?php echo $key->id ?>">
                                                                  </div>
                                                                  <div class="col-3"><button class="btn btn-primary btn-xs" type="button" id="btnMessage" data-id="<?php echo $key->id ?>"><i class="mdi mdi-message"></i> Kirim</button></div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                    </div>
                                                  </div>

                                                </div>
                                              </div>
                                            </div>
                                              <div class="dd2-content p-2">
                                                  <div class="row">
                                                      <div class="col-12" style="overflow:hidden">
                                                          <span class="badge badge-success mb-2"><?php echo $key->tgl ?></span>
                                                          <?php if(!empty($key->file)){ ?>
                                                          <a href="<?php echo base_url() ?>assets/tugas/upload/<?php echo $key->file; ?>" download="" class="badge badge-primary no-border btn-round"><i class="fa fa-download"></i> Lampiran</a>
                                                          <?php } ?>
                                                      </div>
                                                      <div class="col-12">
                                                          <div class="alert alert-light mb-0"><p><?php echo $key->ket ?></p></div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="card-footer" style="display:none">
                                                  <div class="row">
                                                      <div class="col-9">
                                                        <input type="text" class="form-control" id="mMessage<?php echo $key->id ?>" name="message">
                                                        <input type="hidden" id="mTugas<?php echo $key->id ?>" name="id_tugas" value="<?php echo $key->id ?>">
                                                      </div>
                                                      <div class="col-3"><button class="btn btn-primary btn-xs" type="button" id="btnMessage" data-id="<?php echo $key->id ?>"><i class="mdi mdi-message"></i> Reply</button></div>
                                                  </div>
                                              </div>
                                          </li>
                                      </div>
                                    <?php endforeach ?>
                                  </div>
                                </ol>
                            </div>
                            <div class="space"></div>
                            <?php if ($selesai=='1') { ?>
                            <a onclick="return cBatal()" href="<?php echo base_url() ?>admin/tugas/selesai/<?php echo $id ?>/0" class="btn btn-warning"><i class="ace-icon fa fa-times"></i> Batal Selesai</a>
                            <?php } else { if($progress == 100) { ?>
                            <a onclick="return cSelesai()" href="<?php echo base_url() ?>admin/tugas/selesai/<?php echo $id ?>" class="btn btn-danger"><i class="ace-icon fa fa-check"></i> Konfirmasi Selesai</a>
                            <?php } } ?>
                        </div>
                    </div>
                    <br>
                    <a href="<?php echo site_url('admin/tugas') ?>" class="btn btn-default">Kembali</a>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script>
function cBatal(){
    var t = confirm("Anda yakin akan membatalkan konfirmasi selesai ?");
    if (t) {
        return true;
    } else {
        return false;
    }
}
function cSelesai(){
    var t = confirm("Anda yakin akan menyelesaikan tugas ?");
    if (t) {
        return true;
    } else {
        return false;
    }
}
</script>
<script>
  $(document).ready(function(){
    $('[id*=btnMessage]').click(function(){
      var id_btn   = $(this).attr('data-id');
      var message  = $('#mMessage'+id_btn).val();
      var id_upload_tugas = $('#mTugas'+id_btn).val();
      var id_tugas = '<?php echo $id;?>';
      $.ajax({
        url :'<?php echo base_url();?>admin/tugas/reply_message',
        type:'post',
        data:'id_tugas='+id_tugas+'&message='+message+'&id_upload_tugas='+id_upload_tugas,
        success:function(response){
            //console.log(response);
          window.location.reload(true);
        }
      });
    });
  });
</script>