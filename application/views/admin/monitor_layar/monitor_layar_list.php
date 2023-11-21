<div class="row">
    <div class="col-12">
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Monitor layar</h2>
            </div>
            <div class="col-md-4 text-center">
                <!-- <div style="margin-top: 4px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div> -->
            </div>
        </div>
        <div class="table-responsive card card-body">
            <table class="table table-bordered table-striped" id="mytable">
                <thead class="table-dark">
                    <tr>
                        <th width="5px">No</th>
                        <th>Nama Pegawai</th>
                        <th>Level <br> Jabatan <br> Tingkat</th>
                        <th width="200px">Action</th>
                        <th>Status kerja</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->

<div id="modal_show_screen" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hasil tangkapan layar</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script>
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
            // initComplete: function() {
            //     var api = this.api();
            //     $('#mytable_filter input')
            //         .off('.DT')
            //         .on('keyup.DT', function(e) {
            //             if (e.keyCode == 13) {
            //                 api.search(this.value).draw();
            //             }
            //         });
            // },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?php echo base_url() ?>admin/monitor_layar/json",
                "type": "POST"
            },
            columns: [{
                    "data": "id",
                    "orderable": false
                }, {
                    "data": "nama_pegawai",
                },
                {
                    "data": "nm_level",
                    render: function(data, type, row) {
                        return '<span class="mb-1 badge badge-danger">' + data + '</span><br><span class="mb-1 badge badge-success">' + row['jabatan'] + '</span><br><span class="mb-1 badge badge-primary">' + row['tingkat'] + '</span>';
                    }
                },
                {
                    "data": "id_user",
                    "orderable": false,
                    "className": "text-center",
                    render: function(data, x, row) {
                        return `
                        <div>
                            <button type="button" class="btn btn-primary btn-block btn-get-screen" data-id="${data}">LIHAT LAYAR</button>
                        </div>
                        <div style="margin-top:6px;">
                            <a target="_blank" href="<?php echo base_url('admin/monitor_layar/galeri_user/') ?>${data}" class="btn btn-warning btn-block" data-id="${data}">GALERI</a>
                        </div>`;
                    }
                }, {
                    "data": "sk_group",
                    render: function(data, z, row) {
                        var html = ``;
                        if (data != null) {
                            var spl_sk = data.split("#");
                            var spl_i = 0;
                            var spl_sk_sort = spl_sk.sort(function(a, b) {
                                var a_sk = a.split("|");
                                var b_sk = b.split("|");
                                return new Date(b_sk[1]) - new Date(a_sk[1]);
                            });
                            spl_sk_sort.map(function(v) {
                                if (spl_i < 4) {
                                    var v_sk = v.split("|");
                                    html += `<div style="margin-bottom:6px;">`;
                                    html += v_sk[1];
                                    html += `&nbsp;(${v_sk[2] == "1" ? "Aktif" : v_sk[2] == "2" ? "Tidak aktif" : "-"})`;
                                    html += `</div>`;
                                }
                                spl_i++;
                            });
                        }
                        html += `<div>
                            <b>Total jam kerja hari ini: ${row['total_jam']}</b> 
                        </div>`;
                        html += `<div>
                            <a href="<?php echo base_url('admin/monitor_layar/status_kerja/') ?>${row['id_user']}" class="btn btn-primary btn-block">Detail</a>
                        </div>`;
                        return html;
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

        $("#mytable").on('draw.dt', function() {
            $('.btn-get-screen').on('click', function(e) {
                e.stopImmediatePropagation();
                $('#modal_show_screen').modal('show');
                $('#modal_show_screen .modal-title').html("Meminta gambar...");
                $('#modal_show_screen .modal-body').html('');
                var elBtn = $(this);
                elBtn.attr('disabled', 'disabled');
                elBtn.html('Meminta gambar...');
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '<?php echo base_url('admin/monitor_layar/request_screen') ?>',
                    type: 'post',
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        elBtn.removeAttr('disabled');
                        elBtn.html('LIHAT LAYAR');
                        if (typeof(response) === "null" || response == 'null') {
                            $('#modal_show_screen').modal("hide");
                        } else {
                            if (typeof(response['id']) !== "null") {
                                loadRequestImage(response);
                            } else {
                                $('#modal_show_screen').modal("hide");
                            }
                        }
                    },
                    error: function() {
                        elBtn.removeAttr('disabled');
                        elBtn.html('LIHAT LAYAR');
                        $('#modal_show_screen').modal("hide");
                    }
                });
            });
        });

        function loadRequestImage(data) {
            $('#modal_show_screen .modal-title').html("Tunggu sebentar...");
            $.ajax({
                url: '<?php echo base_url('admin/monitor_layar/preview_request_screen') ?>',
                type: 'post',
                data: {
                    'id': data['id'],
                    'date': data['date'],
                },
                success: function(response) {
                    if (response['exists'] == "1") {
                        $('#modal_show_screen .modal-title').html("Hasil tangkapan layar");
                        var html = `
                        <div>
                            <img src="${response['url']}" style="width: 300px;" />
                        </div>`;
                        $('#modal_show_screen .modal-body').html(html);
                    } else {
                        setTimeout(function() {
                            loadRequestImage(data);
                        }, 2000);
                    }
                },
                error: function() {
                    setTimeout(function() {
                        loadRequestImage(data);
                    }, 2000);
                }
            });
        }
    });
</script>