
            <div class="row">
                <div class="col-12">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
                            <h2 style="margin-top:0px">Pegawai</h2>
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="margin-top: 4px"  id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <?php echo anchor(site_url('admin/pegawai/create'), 'Create', 'class="btn btn-primary"'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <form action="<?php echo base_url('admin/pegawai') ?>" id="formStatus" method="post">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" <?php if($status == 1){ echo 'selected'; } ?>>Aktif</option>
                                    <option value="0" <?php if($status == 0){ echo 'selected'; } ?>>Tidak Aktif</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive card card-body">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5px">No</th>
                                    <th>Nama Pegawai <br> Tgl Masuk</th>
                                    <th>Rekening</th>
                                    <th>Level <br> Jabatan <br> Tingkat</th>
                                    <th>Gaji Pokok</th>
                                    <th width="200px">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#status').change(function(){
                                $('#formStatus').submit();
                            });
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
                                ajax: {"url": "<?php echo base_url() ?>admin/pegawai/json/<?php echo $status;?>", "type": "POST"},
                                columns: [
                                    {
                                        "data": "id",
                                        "orderable": false
                                    },{"data": "nama_pegawai",
                                        render:function(data,type,row){
                                            return data+'<br>'+row['tgl_masuk'];
                                        }
                                    },
                                    {"data": "rekening"},
                                    {"data": "nm_level",
                                        render:function(data,type,row){
                                            return '<span class="mb-1 badge badge-danger">'+data+'</span><br><span class="mb-1 badge badge-success">'+row['jabatan']+'</span><br><span class="mb-1 badge badge-primary">'+row['tingkat']+'</span>';
                                        }
                                    },{"data": "gaji_pokok"},
                                    {
                                        "data" : "action",
                                        "orderable": false,
                                        "className" : "text-center"
                                    }
                                ],
                                order: [[0, 'desc']],
                                rowCallback: function(row, data, iDisplayIndex) {
                                    var info = this.fnPagingInfo();
                                    var page = info.iPage;
                                    var length = info.iLength;
                                    var index = page * length + (iDisplayIndex + 1);
                                    $('td:eq(0)', row).html(index);
                                    var gapok = $('td:eq(7)', row).text();
                                    var sgapok = number_format(gapok*1,0,',','.');
                                    $('td:eq(7)', row).html(sgapok);
                                }
                            });
                        });
                    </script>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->