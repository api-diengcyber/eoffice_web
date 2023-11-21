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
                <h2 style="margin-top:0px">Galeri tugas</h2>
                <h4><?php echo $nama_pegawai ?></h4>
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
                url: '<?php echo base_url('admin/tugas/get_tugas_files') ?>',
                type: 'post',
                data: {
                    'id': "<?php echo $id_pegawai ?>",
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
                <div class="item_image_preview" data-url="${dir}/${itemDetail['file']}">
                    <img src="${dir}/${itemDetail['file']}" />
                    <div style="margin-top:10px;">${itemDetail['file']}</div>
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
    });
</script>