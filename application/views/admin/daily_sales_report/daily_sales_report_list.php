
      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <h1>Daily Sales Report</h1>
            </div><!-- /.page-header -->

            <div class="row">
              <div class="col-md-12">
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
                        <form id="fG" action="" method="post" autocomplete="off">
                          <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12 input-group">
                                    <span class="input-group-append">
                                        <i class="fa fa-filter"></i>
                                    </span>
                                    <select class="form-control input-md" name="pil_tanggal" id="pil_tanggal" onchange="this.form.submit()">
                                        <option <?php echo ($pil_tanggal == '1' ? 'selected' : ''); ?> value="1">PER TANGGAL</option>
                                        <option <?php echo ($pil_tanggal == '2' ? 'selected' : ''); ?> value="2">PERIODE</option>
                                        <option <?php echo ($pil_tanggal == '3' ? 'selected' : ''); ?> value="3">SEMUA</option>
                                    </select>
                                    <?php if ($pil_tanggal == '1') { ?>
                                    <span class="input-group-append">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control input-md" name="tanggal" id="datepicker-1-submit" value="<?php echo $tanggal ?>" style="text-align: center;">
                                    <?php } else if ($pil_tanggal == '2') { ?>
                                    <span class="input-group-append">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control input-md" id="date-range-picker-submit" value="<?php echo $tanggal ?>" style="text-align: center;">
                                    <input type="hidden" name="tanggal_periode" value="<?php echo $tanggal ?>">
                                    <?php } ?>
                                    <span class="input-group-append">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <select class="form-control input-md" name="id_marketing" id="id_marketing" onchange="this.form.submit()">
                                        <option value="0">Semua Sales</option>
                                        <?php foreach ($data_marketing as $key): ?>
                                          <?php if ($key->id_users == $id_marketing) { ?>
                                            <option selected value="<?php echo $key->id_users ?>"><?php echo $key->nama_pegawai ?></option>
                                          <?php } else { ?>
                                            <option value="<?php echo $key->id_users ?>"><?php echo $key->nama_pegawai ?></option>
                                          <?php } ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="mytable">
                                        <thead class="table-dark">
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
                            </div>
                        </div>
                    </div>

                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div>
      </div><!-- /.main-content -->

             
  <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/responsive-login.js"></script> -->
                    <script>
                        $('#date-range-picker-submit').datepicker({
                            format: 'dd-mm-yyyy'
                        });
                        $('#datepicker2').datepicker({
                            format: 'dd-mm-yyyy'
                        });
                    </script>
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
                                ajax: {"url": "<?php echo base_url() ?>admin/daily_sales_report/json/<?php echo $pil_tanggal ?>/<?php echo $tanggal ?>/<?php echo $id_marketing ?>", "type": "POST"},
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
                                    if (data.id_spk*1 > 0) {
                                        $(row).hide();
                                    }
                                    $('td:eq(0)', row).html(index);
                                    $('td:eq(2)', row).html(data.nama_instansi + '<br>' + data.alamat_instansi);
                                    $('td:eq(3)', row).css({'display':'none'});
                                    $('td:eq(4)', row).css({'display':'none'});
                                    if (data.prioritas == '1') {
                                        $('td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5)', row).css({'background-color':'yellow'});
                                    } else if (data.prioritas == '2') {
                                        $('td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5)', row).css({'background-color':'green','color':'white'});
                                    }
                                }
                            });
                            $("#mytable_filter").hide();
                        });
                    </script>
<script type="text/javascript">
jQuery(function($){
    $('#date-range-picker-submit').daterangepicker({
        'applyClass' : 'btn-sm btn-success',
        'cancelClass' : 'btn-sm btn-default',
        locale: {
          format: 'DD-MM-YYYY',
          applyLabel: 'Proses',
          cancelLabel: 'Batal',
        }
    }, 
    function(start, end, label) {
        $("input[name='tanggal_periode']").val(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        $("#fG").submit();
    })
    .prev().on(ace.click_event, function(){
        $(this).next().focus();
    });
});
</script>