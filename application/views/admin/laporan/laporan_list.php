            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
                            <h3>
                                Laporan Gaji
                            </h3>
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="margin-top: 4px"  id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="<?php echo base_url('admin/laporan/print_gaji/').$bulan_tahun ?>" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</a>
                        </div>
                    </div>
                    <?php 

                    ?>
                    <div class="row" style="margin-bottom: 10px">
                        <form action="" method="post" class="col-md-8">
                            <div class="form-group">
                                <div class="col-sm-12 input-group">
                                    <span class="input-group-append">
                                        <i class="fa fa-users bigger-110"></i>
                                    </span>
                                    <select class="form-control input-lg" name="id_pegawai" id="id_pegawai" onchange="this.form.submit()">
                                      <option value="semua">-- Semua Pegawai --</option>
                                      <?php foreach ($data_pegawai as $key): ?>
                                        <?php if ($key->id_users == $id_pegawai) { ?>
                                          <option selected value="<?php echo $key->id ?>"><?php echo $key->nama_pegawai ?></option>
                                        <?php } else { ?>
                                          <option value="<?php echo $key->id ?>"><?php echo $key->nama_pegawai ?></option>
                                        <?php } ?>
                                      <?php endforeach ?>
                                    </select>
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
                        </form>
                    </div>
                    <div class="table-responsive card card-body">
                    
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Gaji Pokok <br> Gaji Kotor</th>
                                    <th>Masuk</th>
                                    <th>Potongan Absen</th>
                                    <th>Bonus</th>
                                    <th>Gaji Bersih</th>
                                    <th width="200px">Ubah data</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <script type="text/javascript">
                       
                        $(document).ready(function() {
                            var data_gajian = <?php echo json_encode($gajian_pegawai);?>;
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
                                ajax: {"url": "<?php echo base_url() ?>admin/laporan/json/<?php echo $id_pegawai ?>/<?php echo $bulan ?>/<?php echo $tahun ?>", "type": "POST"},
                                columns: [
                                    {
                                        "data": "id",
                                        "orderable": false
                                    },
                                    {"data": "nama_pegawai","orderable": false},
                                    {"data": "gaji_pokok",





                                        render:function(data,type,row){
                                            console.log(row);
                                            var id = data;
                                            var total = 100;
                                            if(row.id_pegawai[id] != null){
                                                var total = row.id_pegawai[id].gaji_kotor;
                                                console.log(row);
                                            }
                                            total = Math.round(total / 1000) * 1000;
                                            if(total==null){
                                                return data;
                                            }else{
                                                return data+'<br>'+total;
                                            }
                                            
                                        },"orderable": false
                                    },
                                    {"data": "id_pegawai",
                                        render:function(data){
                                            console.log(data);
                                            var id = data;
                                            var hari_masuk = 0;
                                            if(data.data != null){
                                                hari_masuk = data.data.masuk;
                                            }
                                            return hari_masuk+' Hari';
                                        },"orderable": false
                                    },
                                    /*
                                    {"data": "gaji_pokok",
                                        render:function(data,type,row,meta){
                                            var id = meta.row;
                                            var gaji_pokok = data;
                                            var msk = row['masuk'];
                                            var ha  = <?php echo $hari_aktif;?>;
                                            var gj  = gaji_pokok*1 / ha*1 * msk*1; 
                                            var tunjangan = <?php echo json_encode($tunjangan);?>;
                                            var tunj  = tunjangan[id];
                                            return gj*1 + tunj*1;
                                        },"orderable": false
                                    },
                                    {"data": "gaji_pokok",
                                        render:function(data,type,row,meta){
                                            var id = meta.row;
                                            var gaji_pokok = data;
                                            var msk = row['masuk'];
                                            var ha  = <?php echo $hari_aktif;?>;
                                            var gj  = gaji_pokok*1 / ha*1 * msk*1; 
                                            var potongan = <?php echo json_encode($potongan);?>;
                                            var pot  = potongan[id];
                                            var tunjangan = <?php echo json_encode($tunjangan);?>;
                                            var tunj  = tunjangan[id];

                                            return gj*1 + tunj*1 - pot*1;
                                        },"orderable": false
                                    },
                                    */
                                    {"data": "id_pegawai",//potongan absen
                                        render:function(data){
                                            var id = data;
                                            var total = 0;
                                            if(data.data != null){
                                                var total = data.data.potongan_absen;
                                            }                                       
                                            return Math.round(total / 1000) * 1000;
                                        },"orderable": false
                                    },
                                    {"data": "bonus_gaji","orderable": false},
                                    {"data": "id_pegawai",//gaji bersih
                                        render:function(data,type,row,meta){
                                            var id = data;
                                            var total = 0;
                                            if(row.id_pegawai[id] != null){
                                                var total = row.id_pegawai[id].gaji_bersih;
                                            }                                        
                                            return Math.round(total / 1000) * 1000;
                                        },"orderable": false
                                    },
                                    {"data":"id",
                                        render:function(data){
                                            return "<a href='<?php echo base_url();?>admin/laporan/cetak_gaji/"+data+"/<?php echo $bulan;?>/<?php echo $tahun;?>' class='btn btn-primary btn-sm'><i class='mdi mdi-clipboard-check'></i> Ubah data</a>";
                                        },"orderable": false
                                    }
                                ],
                                order: [[0, 'desc']],
                                rowCallback: function(row, data, iDisplayIndex) {
                                    var info = this.fnPagingInfo();
                                    var page = info.iPage;
                                    var length = info.iLength;
                                    var index = page * length + (iDisplayIndex + 1);
                                    $('td:eq(0)', row).html(index);

                                }
                            });
                        });
                    </script>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->