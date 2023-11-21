

      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <h1>Daily Sales Report</h1>
            </div><!-- /.page-header -->

            <div class="row">
              <div class="col-12 card card-body">
                <!-- PAGE CONTENT BEGINS -->

                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
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
                                    <span class="input-group-addon">
                                        <i class="fa fa-filter bigger-110"></i>
                                    </span>
                                    <select class="form-control input-md" name="pil_tanggal" id="pil_tanggal" onchange="this.form.submit()">
                                        <option <?php echo ($pil_tanggal == '1' ? 'selected' : ''); ?> value="1">PER TANGGAL</option>
                                        <option <?php echo ($pil_tanggal == '2' ? 'selected' : ''); ?> value="2">PERIODE</option>
                                        <option <?php echo ($pil_tanggal == '3' ? 'selected' : ''); ?> value="3">SEMUA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 input-group">
                                    <?php if ($pil_tanggal == '1') { ?>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-100"></i>
                                    </span>
                                    <input type="text" class="form-control input-md" name="tanggal" id="datepicker-1-submit" value="<?php echo $tanggal ?>">
                                    <?php } else if ($pil_tanggal == '2') { ?>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-100"></i>
                                    </span>
                                    <input type="text" class="form-control input-md" id="date-range-picker-submit" value="<?php echo $tanggal ?>">
                                    <input type="hidden" name="tanggal_periode" value="<?php echo $tanggal ?>">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-car bigger-100" style="font-size: 11px;"></i>
                                    </span>
                                    <select class="form-control input-md" name="id_merk" id="id_merk" onchange="this.form.submit()">
                                        <option value="0">Semua Merk</option>
                                        <?php foreach ($data_pil_merk as $key): ?>
                                          <?php if ($key->id == $id_merk) { ?>
                                            <option selected value="<?php echo $key->id ?>"><?php echo $key->merk ?></option>
                                          <?php } else { ?>
                                            <option value="<?php echo $key->id ?>"><?php echo $key->merk ?></option>
                                          <?php } ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </form>
                    </div>
                    <div class="table-responsive">
	                    <table class="table table-bordered table-striped" id="mytable">
	                        <thead>
	                            <tr>
	                                <th width="5px">No</th>
	                                <th width="100">Tgl Kunjungan</th>
	                                <th>Nama</th>
	                                <th>Merk</th>
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

                                /* ENABLE / DISABLE */
                                paging:   false,
                                ordering: false,
                                info:     false,
                                searching: false,
                                /* ENABLE / DISABLE */

                                processing: true,
                                serverSide: true,
                                ajax: {"url": "<?php echo base_url() ?>marketing/daily_sales_report/json_report/<?php echo $pil_tanggal ?>/<?php echo $tanggal ?>/<?php echo $id_merk ?>", "type": "POST"},
                                columns: [
                                    {
                                        "data": "id",
                                        "orderable": false
                                    },{"data": "tgl_kunjungan"},{"data": "nama"},{"data": "nm_merk"},
                                ],
                                order: [[0, 'desc']],
                                rowCallback: function(row, data, iDisplayIndex) {
                                    var info = this.fnPagingInfo();
                                    var page = info.iPage;
                                    var length = info.iLength;
                                    var index = page * length + (iDisplayIndex + 1);
                                    $('td:eq(0)', row).html(index);

                                    if (data.prioritas == '1') {
                                        $('td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5), td:eq(6), td:eq(7), td:eq(8), td:eq(9)', row).css({'background-color':'yellow'});
                                    } else if (data.prioritas == '2') {
                                        $('td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5), td:eq(6), td:eq(7), td:eq(8), td:eq(9)', row).css({'background-color':'green','color':'white'});
                                    }
                                    
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