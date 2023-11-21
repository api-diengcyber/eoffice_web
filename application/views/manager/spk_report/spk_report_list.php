

      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <h1>SPK Report</h1>
            </div><!-- /.page-header -->

            <div class="row">
              <div class="col-xs-12">
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
                                    <span class="input-group-addon">
                                        <i class="fa fa-filter"></i>
                                    </span>
                                    <select class="form-control input-md" name="pil_tanggal" id="pil_tanggal" onchange="this.form.submit()">
                                        <option <?php echo ($pil_tanggal == '1' ? 'selected' : ''); ?> value="1">PER TANGGAL</option>
                                        <option <?php echo ($pil_tanggal == '2' ? 'selected' : ''); ?> value="2">PERIODE</option>
                                        <option <?php echo ($pil_tanggal == '3' ? 'selected' : ''); ?> value="3">SEMUA</option>
                                    </select>
                                    <?php if ($pil_tanggal == '1') { ?>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control input-md" name="tanggal" id="datepicker-1-submit" value="<?php echo $tanggal ?>" style="text-align: center;">
                                    <?php } else if ($pil_tanggal == '2') { ?>
                                   <span class="input-group-addon">
                                         <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control input-md" id="date-range-picker-submit" value="<?php echo $tanggal ?>" style="text-align: center;">
                                    <input type="hidden" name="tanggal_periode" value="<?php echo $tanggal ?>">
                                    <?php } ?>
                                    <span class="input-group-addon">
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

                    <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                                <th width="5">No</th>
                                <th width="100">Tgl SPK</th>
                                <th>Instansi</th>
                                <th>Atas Nama</th>
                                <th>Alamat Atas Nama</th>
                                <th>Keterangan</th>
                                <th>Lokasi</th>
                                <th>Pembayaran</th>
                                <th>Diskon</th>
                                <th width="200px">Action</th>
                            </tr>
                        </thead>
                    </table>
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
                                ajax: {"url": "<?php echo base_url() ?>admin/spk_report/json/<?php echo $pil_tanggal ?>/<?php echo $tanggal ?>/<?php echo $id_marketing ?>", "type": "POST"},
                                columns: [
                                    {
                                        "data": "id",
                                        "orderable": true
                                    },{"data": "tgl_spk"},{"data": "nama_instansi"},{"data" : "atas_nama"},{"data" : "alamat_atas_nama"},{"data" : "keterangan"},{"data" : "lokasi"},{"data" : "pembayaran"},{"data" : "diskon"},
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
                                    if (data.prioritas == '1') {
                                        $('td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5), td:eq(6), td:eq(7), td:eq(8), td:eq(9)', row).css({'background-color':'yellow'});
                                    } else if (data.prioritas == '2') {
                                        $('td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4), td:eq(5), td:eq(6), td:eq(7), td:eq(8), td:eq(9)', row).css({'background-color':'green','color':'white'});
                                    }

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
jQuery(function($){
    $("#cari").on('keyup', function(){
        onTable();
    });
    function onTable() {
        var cari = $("#cari").val();
        if (cari.length > 0) {
        } else {
        }
    }
});
</script>