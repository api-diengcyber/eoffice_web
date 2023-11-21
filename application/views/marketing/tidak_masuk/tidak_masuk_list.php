
            <div class="row">
                <div class="col-12">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
                            <h2 style="margin-top:0px">Tidak Masuk</h2>
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="margin-top: 4px"  id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <?php echo anchor(site_url('marketing/tidak_masuk/create'), 'Create', 'class="btn btn-primary"'); ?>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <form action="" method="post">
                          <div class="col-md-12" style="padding:0px">
                            <div class="form-group">
                                <div class="col-sm-12 input-group">
                                    <span class="input-group-append">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <select class="form-control input-lg" name="tahun" id="tahun" onchange="this.form.submit()">
                                      <option value="semua">-- Semua Tahun --</option>
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
                                      <option value="semua">-- Semua Bulan --</option>
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
                    <div class="card card-body mb-p-0">
                        <table class="table table-bordered table-striped" id="mytable" style="width:100%!important">
                            <thead class="table-dark">
                                <tr>
                                    <th width="80px">No</th>
                                    <th>Tanggal</th>
                                    <th>Tidak Masuk</th>
                                    <th>Keterangan</th>
                                    <th width="200px">Action</th>
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
                                responsive:true,
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
                                ajax: {"url": "<?php echo base_url() ?>marketing/tidak_masuk/json/<?php echo $bulan ?>/<?php echo $tahun ?>", "type": "POST"},
                                columns: [
                                    {
                                        "data": "id",
                                        "orderable": false
                                    },{"data": "tgl"},{"data": "ket_tidak_masuk"},{"data": "keterangan"},
                                    {
                                        "data" : "id",
                                        "orderable": false,
                                        "className" : "text-center",
                                        render:function(data){
                                            return '<a href="<?php echo base_url()?>marketing/tidak_masuk/update/'+data+'" class="btn btn-primary btn-xs">Edit</a>';
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
                                }
                            });
                        });
                    </script>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->