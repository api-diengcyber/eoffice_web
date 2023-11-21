            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
                            <h2 style="margin-top:0px">Tugas List</h2>
                        </div>
                        <div class="col-md-2 text-center">
                            <div style="margin-top: 4px"  id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?php echo base_url('manager/tugas/rekap') ?>" class="btn btn-dark">Rekap Tugas</a>
                            <!--
                            <a href="<?php echo base_url('manager/tugas/priority') ?>" class="btn btn-primary"><i class="mdi mdi-list"></i> Ubah Prioritas</a>
                            <?php echo anchor(site_url('manager/tugas/create'), 'Create', 'class="btn btn-primary"'); ?>
                            -->
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <form action="" method="post">
                          <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12 input-group" style="padding:0px">
                                    <div class="input-group-append">
                                        <i class="fa fa-users bigger-110"></i>
                                    </div>
                                    <select class="form-control" name="id_pegawai" id="id_pegawai" onchange="this.form.submit()">
                                      <option value="semua">Semua Pegawai</option>
                                      <?php foreach ($data_pegawai as $key): ?>
                                        <?php if ($key->id == $id_pegawai) { ?>
                                          <option selected value="<?php echo $key->id ?>"><?php echo $key->nama_pegawai ?></option>
                                        <?php } else { ?>
                                          <option value="<?php echo $key->id ?>"><?php echo $key->nama_pegawai ?></option>
                                        <?php } ?>
                                      <?php endforeach ?>
                                    </select>
                                    <div class="input-group-append">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </div>
                                    <select class="form-control" name="tahun" id="tahun" onchange="this.form.submit()">
                                      <option value="semua">Semua Tahun</option>
                                      <?php foreach ($data_tahun as $key): ?>
                                        <?php if ($key->tahun == $tahun) { ?>
                                          <option selected value="<?php echo $key->tahun ?>"><?php echo $key->tahun ?></option>
                                        <?php } else { ?>
                                          <option value="<?php echo $key->tahun ?>"><?php echo $key->tahun ?></option>
                                        <?php } ?>
                                      <?php endforeach ?>
                                    </select>
                                    <div class="input-group-append">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </div>
                                    <select class="form-control" name="bulan" id="bulan" onchange="this.form.submit()">
                                      <option value="semua">Semua Bulan</option>
                                      <?php foreach ($data_bulan as $key): ?>
                                        <?php if ($key->id == $bulan) { ?>
                                          <option selected value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                        <?php } else { ?>
                                          <option value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                        <?php } ?>
                                      <?php endforeach ?>
                                    </select>
                                    <div class="input-group-append">
                                        <i class="fa fa-check bigger-110"></i>
                                    </div>
                                    <select class="form-control" name="status" id="status" onchange="this.form.submit()">
                                          <option value="semua">Pilih</option>
                                          <option value="1" <?php if($status == 1){ echo 'selected'; } ?>>Selesai</option>
                                          <option value="3" <?php if($status == 3){ echo 'selected'; } ?>>Butuh Konfirmasi</option>
                                          <option value="2" <?php if($status == 2){ echo 'selected'; } ?>>Belum Selesai</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </form>
                    </div>
                    <div class="table-responsive card card-body">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="table-dark">
                                <tr>
                                    <th width="80px">No</th>
                                    <th>Status</th>
                                    <th>Project</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
                            {
                                return {
                                    "iStart": oSettings._iDisplayStart,
                                    "iEnd": oSettings.fnDisplayEnd(),
                                    "iLength": oSettings._iDisplayLength,
                                    "iTotal": oSettings.fnRecordsTotal(),
                                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                                };
                            };

                            var t = $("#mytable").dataTable({
                                initComplete: function() {
                                    var api = this.api();
                                    $('#mytable_filter input')
                                            .off('.DT')
                                            .on('keyup.DT', function(e) {
                                                if (e.keyCode == 13) {
                                                    api.search(this.value).draw();
                                        }
                                    });
                                },
                                oLanguage: {
                                    sProcessing: "loading..."
                                },
                                processing: true,
                                serverSide: true,
                                ajax: {"url": "<?php echo base_url() ?>manager/tugas/json/<?php echo $id_pegawai ?>/<?php echo $bulan ?>/<?php echo $tahun ?>/<?php echo $status ?>", "type": "POST"},
                                columns: [
                                    {
                                        "data": "id",
                                        "orderable": false
                                    },{"data": "tgl",
                                    render:function(data,type,row){
                                        var output = '<span class="mb-1">'+data+'</span><br>';
                                        var upload = row['upload'];
                                        if (upload == '1') {
                                            output += "<span class='badge  mb-1 badge-success'>Sudah Upload</span><br>";
                                        } else {
                                            output += "<span class='badge  mb-1 badge-danger'>Belum Upload</span><br>";
                                        }
                                        var selesai = row['selesai'];
                                        if (selesai == '1') {
                                            output += "<span class='badge  mb-1 badge-success'>Selesai</span><br>";
                                        } else {
                                            if(row['progress'] == 100){
                                                output += "<span class='badge  mb-1 badge-info'>Menunggu Konfirmasi</span><br>";
                                            }else{
                                                output += "<span class='badge  mb-1 badge-danger'>Belum Selesai</span><br>";
                                            }
                                            
                                        }
                                        return output;

                                    }
                                    },{"data": "project",
                                    render:function(data,type,row){
                                        var output = data+'<br>'+row['nama_pegawai'];
                                        return output;
                                    }
                                    },
                                    //{"data": "nama_pegawai"},
                                    {"data": "judul",
                                    render:function(data,type,row){
                                        var status = '';
                                        if(row['is_update'] == 1){
                                            status += '<br><span class="badge badge-primary">Ada update</span>';
                                        }
                                        var output = data+'<br>'+row['tgl_selesai']+status;
                                        return output;
                                    }
                                    }
                                ],
                                order: [[0, 'desc']],
                                rowCallback: function(row, data, iDisplayIndex) {
                                    var info = this.fnPagingInfo();
                                    var page = info.iPage;
                                    var length = info.iLength;
                                    var index = page * length + (iDisplayIndex + 1);
                                    $('td:eq(0)', row).html(index);
                                    var ket_upload = "";
                                    if (data.upload == '1') {
                                        ket_upload = "<span class='badge badge-success'>Sudah</span>";
                                    } else {
                                        ket_upload = "<span class='badge badge-warning'>Belum</span>";
                                    }
                                }
                            });
                        });
                    </script>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->