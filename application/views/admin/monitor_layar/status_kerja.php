<div class="row">
    <div class="col-12">
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Status kerja</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>
        <form action="" method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Pilih Tanggal</label>
                        <input type="text" name="tgl" id="datepicker1" class="form-control" value="<?php echo $tgl ?>" placeholder="Tgl" />
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-success" style="margin-top:20px">Proses</button>
                    <button type="button" class="btn btn-sm btn-primary btn-export" style="margin-top:20px">Export</button>
                </div>
                <div class="col-md-6">
                    <div style="margin-top:20px">
                        Total jam kerja: <?php echo $data_total_jam->total ?>
                    </div>
                    <div style="font-size:12px;margin-bottom:5px;">
                        <?php
                        foreach ($data_total_jam->data as $row) : ?>
                            <div>
                                <?php echo $row['start'] ?> -> <?php echo $row['end'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive card card-body">
            <table class="table table-bordered table-striped" id="mytable">
                <thead class="table-dark">
                    <tr>
                        <th width="5px">No</th>
                        <th>Nama Pegawai</th>
                        <th>Tgl</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->


<div id="modal_export" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Export Excel</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo $action_export ?>" method="post" target="_blank">
                    <div class="form-group">
                        <label for="">Pilih Bulan</label>
                        <select name="bulan" class="form-control">
                            <?php foreach ($data_bulan as $i => $bulan) :
                                if ($i > 0) {
                                    ?>
                                    <option value="<?php echo $i ?>" <?php echo $i == (date('m') * 1) ? "selected" : "" ?>><?php echo $bulan ?></option>
                            <?php };
                            endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="id_user" value="<?php echo $id_user ?>" />
                    <button type="submit" class="btn btn-success btn-block">Proses</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $("#datepicker1").datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        format: 'dd-mm-yyyy'
    });
    $(document).ready(function() {

        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
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
            ajax: {
                "url": "<?php echo base_url() ?>admin/monitor_layar/status_kerja_json/<?php echo $id_user ?>/<?php echo $tgl ?>",
                "type": "POST"
            },
            columns: [{
                "data": "id",
                "orderable": false
            }, {
                "data": "nama_pegawai",
            }, {
                "data": "created_on",
            }, {
                "data": "status",
                render: function(data) {
                    return `${data=='1' ? "Aktif" : data=='2' ? "Tidak aktif" : ""}`;
                }
            }, ],
            order: [
                [2, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        $('.btn-export').on('click', function() {
            $('#modal_export').modal("show");
        });

        $('form').on('submit', function() {
            $('#modal_export').modal("hide");
        });
    });
</script>