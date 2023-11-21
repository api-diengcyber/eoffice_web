<style>
    .modal {
        text-align: center;
    }

    @media screen and (min-width: 768px) {
        .modal:before {
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }

    #preview_list_files {
        display: grid;
        grid-template-columns: auto auto auto;
        gap: 15px;
        background-color: #2196F3;
        padding: 10px;
    }

    #preview_list_files_loading {
        width: 100%;
        text-align: center;
        padding: 32px;
        display: none;
    }

    #preview_list_files_more {
        width: 100%;
        text-align: center;
        padding: 32px;
    }

    .item_image_preview {
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.8);
        padding: 20px;
        font-size: 12px;
        text-align: center;
        cursor: pointer;
    }

    .item_image_preview img {
        object-fit: cover;
        width: 100px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-12">
                <h2 style="margin-top:0px">Galeri tangkapan layar</h2>
                <h4><?php echo $data_pegawai->nama_pegawai ?></h4>
                <div>
                    <button type="button" class="btn btn-primary btn-get-screen" data-id="<?php echo $data_pegawai->id_users * 1 ?>">LIHAT LAYAR</button>
                </div>
            </div>
        </div>

        <form action="" method="post">
            <div class="row no-print" style="margin-bottom: 10px">
                <div class="col-sm-7 input-group mb-1">
                    <span class="input-group-append">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    <input type="text" class="form-control" name="start" id="datepicker1" value="<?php echo $start ?>" autocomplete="off">
                    <span class="input-group-append">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    <input type="text" class="form-control" name="end" id="datepicker2" value="<?php echo $end ?>" autocomplete="off">
                    <span class="input-group-append">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    <button type="submit" class="btn btn-default">Proses</button>
                </div>
            </div>
        </form>

        <div class="card card-body" style="padding-bottom:0px;">
            <div id="preview_list_files"></div>
            <div id="preview_list_files_loading">Memuat file...</div>
            <div id="preview_list_files_more">
                <button type="button" class="btn btn-info btn-more">Lihat lagi</button>
            </div>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->


<div id="modal_preview_image" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <img src="" width="600px" />
        </div>
    </div>
</div>

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
    $('#datepicker1').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#datepicker2').datepicker({
        format: 'yyyy-mm-dd'
    });

    $(document).ready(function() {

        var limit = 6;
        var nextPage = 1;

        getFiles(1);

        function getFiles(p) {
            page = p;
            $('#preview_list_files_loading').show();
            $('#preview_list_files_more>button').hide();
            $.ajax({
                url: '<?php echo base_url('admin/monitor_layar/get_user_files_screenshot') ?>',
                type: 'post',
                data: {
                    'id': <?php echo $data_pegawai->id_users * 1 ?>,
                    'limit': limit,
                    'page': p,
                    'start_date': "<?php echo $start ?>",
                    'end_date': "<?php echo $end ?>",
                },
                success: function(response) {
                    generateToView(response);
                    generateInfiniteMore(response);
                },
                error() {
                    $('#preview_list_files_loading').hide();
                    $('#preview_list_files_more>button').show();
                }
            });
        }

        function generateToView(data) {
            var html = '';

            var dir = data['dir'];
            var pg = data['files']['page'] * 1;
            var files = data['files']['data'];

            for (var item in files) {
                var itemDetail = files[item];
                html += `
                <div class="item_image_preview" data-url="${dir}/${itemDetail['nama_file']}">
                    <img src="${dir}/${itemDetail['nama_file']}" />
                    <div style="margin-top:10px;">${itemDetail['nama_file']}</div>
                    <div style="margin-top:5px;">${itemDetail['tgl']}</div>
                </div>
                `;
            }

            if (pg == 1) {
                $('#preview_list_files').html(html);
            } else {
                $('#preview_list_files').append(html);
            }

            $('#preview_list_files_loading').hide();
            $('#preview_list_files_more>button').show();

            actionPreview();
        }

        function actionPreview() {
            $('.item_image_preview').on('click', function(e) {
                e.stopImmediatePropagation();
                var url = $(this).attr('data-url');
                $('#modal_preview_image img').attr('src', '');
                $('#modal_preview_image img').attr('src', url);
                $('#modal_preview_image').modal("show");
            })
        }

        function generateInfiniteMore(data) {
            var total_pg = data['files']['total_page'] * 1;
            var pg = data['files']['page'] * 1;
            if (pg >= total_pg) {
                $('#preview_list_files_more>button').hide();
            } else {
                nextPage = pg + 1;
                $('#preview_list_files_more>button').show();
            }
        }

        $('.btn-more').on('click', function() {
            getFiles(nextPage);
        });

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
                    if (typeof(response) === "null" || response == 'null' || response == null) {
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