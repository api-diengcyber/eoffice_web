<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    WhatsApp
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12">
                    <div id="client_message" style="padding:20px;display:none;"></div>
                    <button type="button" class="form-control btn btn-primary btn-lg input-lg btn-status" style="width:200px;display:none;">
                        <div style="margin-top:12px;margin-bottom:8px;"><i class="mdi mdi-account-check" style="font-size: 40px;"></i></div>
                        CONNECTED
                    </button>
                    <iframe id="frame_whatsapp" frameborder="0" width="400px" height="630px" style="display:none;"></iframe>
                    <button type="button" class="form-control btn btn-success btn-lg input-lg btn-scan" style="width:200px;display:none;">
                        <div style="margin-top:12px;margin-bottom:8px;"><i class="mdi mdi-qrcode" style="font-size: 40px;"></i></div>
                        SCAN QR
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_scan_qr" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Memuat kode QR...</h4>
            </div>
            <div class="modal-body text-center">
                <div class="text-center loading-qr" style="display:none;">
                    <i class="fa fa-spin fa-spinner" style="font-size: 40px;"></i>
                </div>
                <img id="qr_img" width="320px" />
                <div class="qr_message"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/socketio/socket.io.min.js') ?>"></script>
<script>
    const socket = io("<?php echo $socket_io ?>", {
        "extraHeaders": {
            "Authorization": "Bearer <?php echo $bearer_wa ?>"
        }
    });

    $(document).ready(function() {
        function checkClient() {
            // $('.btn-scan').show();
            // $('.btn-status').hide();
            $('#frame_whatsapp').removeAttr('src');
            $("#client_message").show();
            $("#client_message").html("Memuat session...");
            $.ajax({
                url: '<?php echo base_url('admin/sosmed/check_whatsapp_client') ?>',
                type: 'get',
                success: function(response) {
                    if (response['status']) {
                        $('.btn-scan').hide();
                        $('.btn-status').show();
                        // $('#frame_whatsapp').attr('src', "<?php echo $view_whatsapp ?>");
                    } else {
                        $('.btn-scan').show();
                        $('.btn-status').hide();
                    }
                    $("#client_message").hide();
                },
                error: function() {
                    $("#client_message").hide();
                }
            });
        }

        checkClient();

        socket.on('init-res', function(data) {
            if (data['status'] == 'scan') {
                $('#modal_scan_qr .modal-title').html('SCAN QR');
                $('#qr_img').attr('src', '<?php echo $qr_url ?>');
                $('.qr_message').html(`<div style="margin-top:24px;">Silahkan SCAN QR ini pada Aplikasi WhatsApp di menu perangkat tertaut.</div>`);
                $('.loading-qr').hide();

            } else if (data['status'] == 'qrExpired') {
                $('#modal_scan_qr').modal("hide");

            } else if (data['status'] == 'connected') {
                $('#modal_scan_qr').modal("hide");
                window.location.reload();

            } else if (data['status'] == 'ok') {
                alert("Device sudah terkoneksi");
                $('#modal_scan_qr').modal("hide");
                window.location.reload();

            } else if (data['status'] == 'conflict') {
                alert("Sesi konflik, akan ditakeover");
                $('#modal_scan_qr').modal("hide");
                window.location.reload();

            } else if (data['status'] == 'error-server') {
                setTimeout(function() {
                    alert("Kendala!");
                    $('#modal_scan_qr').modal("hide");
                }, 1200);
            }
        });

        function scanQr() {
            $('#modal_scan_qr').modal("show");
            $('#modal_scan_qr .modal-title').html('Memuat kode QR...');
            $('.loading-qr').show();
            $('.qr_message').html('');
            $('#qr_img').removeAttr('src');

            socket.emit('init-client', {
                'sessionName': '<?php echo $session_name ?>',
            });
        }

        $('.btn-scan').on('click', function() {
            scanQr();
        });
    });
</script>