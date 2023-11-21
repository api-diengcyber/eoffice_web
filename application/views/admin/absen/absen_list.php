<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h3>
                    Absen Pegawai
                </h3>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4 text-center">
                            <!-- <div style="margin-top: 4px" id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div> -->
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="<?php echo base_url('admin/absen/excel/') . $bulan_tahun ?>" class="btn btn-primary"><i class="fa fa-excel"></i> Export Excel</a>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <form action="" method="post">
                            <div class="col-md-12" style="padding:0px">
                                <div class="form-group">
                                    <div class="col-sm-12 input-group">
                                        <span class="input-group-append">
                                            <i class="fa fa-users bigger-110"></i>
                                        </span>
                                        <select class="form-control input-lg" name="id_users" id="id_users" onchange="this.form.submit()">
                                            <option value="semua">-- Semua Pegawai --</option>
                                            <?php foreach ($data_pegawai as $key) : ?>
                                                <?php if ($key->id_users == $id_users) { ?>
                                                    <option selected value="<?php echo $key->id_users ?>"><?php echo $key->nama_pegawai ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $key->id_users ?>"><?php echo $key->nama_pegawai ?></option>
                                                <?php } ?>
                                            <?php endforeach ?>
                                        </select>
                                        <span class="input-group-append">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                        <select class="form-control input-lg" name="tahun" id="tahun" onchange="this.form.submit()">
                                            <option value="semua">-- Semua Tahun --</option>
                                            <?php foreach ($data_tahun as $key) : ?>
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
                                            <?php foreach ($data_bulan as $key) : ?>
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
                    <div class="table-responsive card card-body">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="table-dark">
                                <tr>
                                    <th width="80px">No</th>
                                    <th>Tgl</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jam Masuk <br> Pulang</th>
                                    <th>Total Jam</th>
                                    <th width="100px">Lokasi Masuk <br> Pulang</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th width="200px">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->


<div id="modal_show_screen" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Foto presensi</h4>
            </div>
            <div class="modal-body">
                <div class="row row-foto-presensi">
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
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
                "url": "<?php echo base_url() ?>admin/absen/json/<?php echo $id_users ?>/<?php echo $bulan ?>/<?php echo $tahun ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "id",
                    "orderable": false
                }, {
                    "data": "tgl"
                }, {
                    "data": "nama_pegawai"
                },
                {
                    "data": "jam_masuk",
                    render: function(data, type, row) {
                        return data + '<br>' + row['jam_pulang'];
                    }
                },
                {
                    "data": "jam_pulang",
                    render: function(data, type, row) {
                        var jam_pulang = new Date("1970-1-1 " + data);
                        var jam_masuk = new Date("1970-1-1 " + row['jam_masuk']);

                        var diff = Math.abs(new Date(jam_pulang) - new Date(jam_masuk));
                        var seconds = Math.floor(diff / 1000); //ignore any left over units smaller than a second
                        var minutes = Math.floor(seconds / 60);
                        seconds = seconds % 60;
                        var hours = Math.floor(minutes / 60);
                        minutes = minutes % 60;

                        return hours + ',' + minutes + ' jam';
                    }
                },
                {
                    "data": "lokasi_masuk",
                    render: function(data, type, row) {
                        return data + '<br>' + row['lokasi_pulang'];
                    }
                },
                {
                    "data": "nm_status"
                }, {
                    "data": "keterangan"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center",
                    render: function(data, x, row) {
                        return data + `&nbsp;&nbsp;<button class="btn btn-xs btn-success btn-foto-presensi" data-foto-masuk="${row['foto_masuk']}" data-foto-pulang="${row['foto_pulang']}"><i class="ace-icon fa fa-eye bigger-120"></i></button>`;
                    }
                }
            ],
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        $('#mytable').on('draw.dt', function(e) {
            e.stopImmediatePropagation();

            $('.btn-foto-presensi').on('click', function(e) {
                e.stopImmediatePropagation();
                var foto_masuk = $(this).attr("data-foto-masuk");
                var foto_pulang = $(this).attr("data-foto-pulang");
                var html = ``;
                if (foto_masuk != "") {
                    html += `
                    <div class="col text-center">
                        <div><b>Foto masuk</b></div>
                        <img src="<?php echo base_url('assets/absen/upload/') ?>${foto_masuk}" width="200px" />
                    </div>`;
                }
                if (foto_pulang != "") {
                    html += `
                    <div class="col text-center">
                        <div><b>Foto pulang</b></div>
                        <img src="<?php echo base_url('assets/absen/upload/') ?>${foto_pulang}" width="200px" />
                    </div>`;
                }
                $('.row-foto-presensi').html(html);
                $('#modal_show_screen').modal("show");
            });
        });
    });
</script>