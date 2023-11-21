            <div class="page-header">
                <h1>
                    Transaksi
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
                            <?php echo anchor(site_url('admin/transaksi/create'), 'Tambah', 'class="btn btn-primary"'); ?>
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="margin-top: 4px"  id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                        </div>
                    </div>
                    <div class="table-responsive card card-body">
                    <table class="table table-striped" id="mytable">
                        <thead class="table-dark">
                            <th>No</th>
                            <th>Tgl</th>
                            <th>No Faktur</th>
                            <th>Harga</th>
                            <th>Nama</th>
                            <th>Hp</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                            <th width="50px">Invoice</th>
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
                                ajax: {"url": "<?php echo base_url() ?>admin/transaksi/json", "type": "POST"},
                                columns: [
                                    {
                                        "data": "id",
                                        "orderable": false
                                    },{"data": "tgl"},{"data": "no_faktur"},{"data": "harga"},{"data": "kepada_nama"},{"data": "kepada_hp"},{"data": "kepada_alamat"},
                                    {
                                        "data" : "action",
                                        "orderable": false,
                                        "className" : "text-center"
                                    },{
                                        "data": "id",
                                        "orderable": false,
                                        "className" : "text-center"
                                    },
                                ],
                                order: [[0, 'desc']],
                                rowCallback: function(row, data, iDisplayIndex) {
                                    var info = this.fnPagingInfo();
                                    var page = info.iPage;
                                    var length = info.iLength;
                                    var index = page * length + (iDisplayIndex + 1);
                                    $('td:eq(0)', row).html(index);
                                    $('td:eq(3)', row).html('Rp.'+number_format(data.harga*1,0,',','.'));
                                    $('td:eq(8)', row).html('<a href="<?php echo base_url() ?>admin/transaksi/invoice_print/'+data.id+'" target="_blank" class="btn btn-xs btn-inverse"><i class="ace-icon fa fa-print"></i></a> <a href="#" id="btn_email" data-id="'+data.id+'" class="btn btn-xs btn-purple"><i class="ace-icon fa fa-envelope"></i></a> <a target="_blank" href="<?php echo base_url() ?>admin/transaksi/invoice_pdf/'+data.id+'" data-id="'+data.id+'" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-file"></i></a>');
                                }
                            });

                            $("#mytable").on('draw.dt', function(){
                                $("a[id*=btn_email]").click(function(){
                                    var data_id = $(this).attr('data-id');
                                    $("input[name=id]").val(data_id);
                                    $("#myModal").modal('show');
                                });
                            });

                        });
                    </script>
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form class="form-horizontal" action="<?php echo base_url() ?>admin/transaksi/invoice_email" method="post">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Kirim Email</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <label class="control-label col-md-3 no-padding-right" for="">Email</label>
                                <div class="col-md-9">
                                  <input type="text" class="form-control" name="email" id="email" placeholder="Email" required />
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <input type="hidden" name="id" value="">
                              <button type="submit" class="btn btn-primary">Kirim</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            </div>
                          </form>
                        </div>
                      </div>