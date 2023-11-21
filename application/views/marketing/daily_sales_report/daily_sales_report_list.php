

      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <h1>Daily Sales Report</h1>
            </div><!-- /.page-header -->

            <div class="row">
              <div class="col-12 card card-body">
                <!-- PAGE CONTENT BEGINS -->

                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="margin-top: 4px"  id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-lg-2">
                            <?php echo anchor(site_url('marketing/daily_sales_report/create'), 'Tambah Baru', 'class="btn btn-primary"'); ?>
                        </div> 
                        <div class="col-lg-5">
                            <form action="" method="post" autocomplete="off">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-append">
                                    <i class="fa fa-search bigger-110"></i>
                                </span>
                                <input type="text" class="form-control input-lg" name="cari" id="cari" placeholder="Nama / No HP / No HP 2">
                              </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="5">No</th>
                                    <th width="100">Tgl Kunjungan</th>
                                    <th>Instansi</th>
                                    <th style="display:none;"></th>
                                    <th style="display:none;"></th>
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
                                initComplete: function() {
                                    var api = this.api();
                                    $("#cari").on('keyup.DT', function(){
                                        var cari = $(this).val();
                                        api.search(cari).draw();
                                    });
                                },
                                oLanguage: {
                                    sProcessing: "loading..."
                                },

                                /* ENABLE / DISABLE */
                                paging:   false,
                                ordering: false,
                                info:     false,
                                /* ENABLE / DISABLE */

                                processing: true,
                                serverSide: true,
                                ajax: {"url": "<?php echo base_url() ?>marketing/daily_sales_report/json", "type": "POST"},
                                columns: [
                                    {
                                        "data": "id",
                                        "orderable": false
                                    },{"data": "tgl_kunjungan"},{"data": "nama_instansi"},{"data": "telp_instansi"},{"data": "telp2_instansi"},
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
                                    $('td:eq(2)', row).html(data.nama_instansi + '<br>' + data.alamat_instansi);
                                    $('td:eq(3)', row).css({'display':'none'});
                                    $('td:eq(4)', row).css({'display':'none'});

                                    if (data.prioritas == '1') {
                                        $('td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5)', row).css({'background-color':'yellow'});
                                    } else if (data.prioritas == '2') {
                                        $('td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5)', row).css({'background-color':'green','color':'white'});
                                    }

                                    var btn_status = "";
                                        btn_status = '&nbsp;<a href="<?php echo base_url() ?>marketing/daily_sales_report/follow_up/'+data.id+'" class="btn btn-danger btn-minier">FOLLOW UP</a>';
                                    $('td:eq(5)', row).append(btn_status);
                                }
                            });
                            $("#mytable_filter").hide();
                        });
                    </script>
                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div>
      </div><!-- /.main-content -->

<script type="text/javascript">
</script>