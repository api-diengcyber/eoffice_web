<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tangan Angie WA</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <!-- css -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <style>
        body {
            width: 100%;
            height: 100%;
            padding: 0px;
            margin: 0px;
            font-family: 'Open Sans', sans-serif;
        }

        .app {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: 'Open Sans', sans-serif;
            background-color: #fff;
            display: none;
        }

        .loading-app {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999999;
            width: 100%;
            height: 24px;
            background-color: white;
            padding: 2px 3px;
            text-align: center;
            color: #27915a;
            font-size: 14px;
        }

        .absolute-center {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .input-control {
            border: 1px solid #cfcfcf;
            border-radius: 10px;
            padding: 12px 14px;
            outline: none;
            width: 100%;
            min-width: 100%;
            max-width: 100%;
            font-size: 16px;
        }

        .header {
            width: 100%;
            height: 70px;
            text-align: left;
            background-color: #27915a;
            padding: 10px 20px 10px 20px;
        }

        .header h2 {
            margin-top: 14px;
            font-size: 21px;
            color: #fff;
        }

        .list-contacts {
            height: calc(100vh - 70px);
            overflow-y: auto;
            width: 100vw;
            max-width: 100vw;
            z-index: -1;
        }

        .item-contact {
            border-bottom: 1px solid #cfcfcf;
            padding: 18px 10px 18px 10px;
            cursor: pointer;
        }

        .item-contact-flex {
            display: flex;
        }

        .item-contact-img {
            text-align: center;
        }

        .item-contact-img img {
            object-fit: cover;
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .item-contact .item-contact-name {
            font-size: 18px;
            font-weight: 600;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: calc(100vw - 60px - 30px);
        }

        .item-contact .item-contact-number {
            font-size: 16px;
            font-weight: 300;
            color: grey;
        }

        .fab-plus {
            position: fixed;
            bottom: 0;
            right: 0;
            z-index: 9999;
            height: 58px;
            width: 58px;
            border-radius: 50%;
            border: 0px;
            outline: none;
            margin-bottom: 10px;
            margin-right: 10px;
            background-color: #27915a;
            box-shadow: 2px 4px 10px 2px grey;
        }

        .fab-plus i {
            font-size: 29px;
            color: #fff;
        }

        .app-conversation {
            background-image: url('<?php echo base_url('assets/images/bg_chat.png') ?>');
        }

        .header-profil {
            width: 100%;
            height: 60px;
            max-height: 60px;
            text-align: left;
            background-color: #27915a;
            padding: 10px 20px 10px 20px;
            z-index: 402;
        }

        .header-profil-flex {
            display: flex;
        }

        .header-profil-img {
            text-align: center;
        }

        .header-profil-img img {
            object-fit: cover;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .profil-img img {
            object-fit: cover;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .header-profil-name {
            font-size: 19px;
            font-weight: 600;
            color: #fff;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .list-messages {
            height: calc(100vh - 60px - 60px);
            overflow: hidden;
            width: 100vw;
            max-width: 100vw;
            z-index: -1;
            bottom: calc(0px + 60px);
        }

        .list-messages-container {
            height: 100%;
            padding: 10px;
            display: flex;
            flex-direction: column-reverse;
            flex-flow: column-reverse;
            overflow-y: auto;
            /* position: absolute;
            width: 100%;
            max-height: 200px; */
        }

        .chatbox {
            height: 60px;
            width: 100%;
            overflow: hidden;
            padding-left: 7px;
            padding-right: 7px;
            padding-top: 7px;
        }

        .chatbox-flex {
            display: flex;
        }

        .chatbox .chatbox-input-group {
            background-color: white;
            padding: 10px 16px;
            border-radius: 20px;
            height: auto;
            flex: 1;
        }

        .chatbox .chatbox-input-text {
            outline: none;
            background-color: #fff;
            border: 0px;
            padding: 0px;
            margin: 0px;
            font-size: 18px;
            width: 100%;
            max-width: 100%;
            min-width: 100%;
        }

        .chatbox .chatbox-btn-send {
            height: 45px;
            width: 45px;
            border-radius: 50%;
            border: 0px;
            outline: none;
            margin-left: 7px;
            background-color: #27915a;
        }

        .chatbox-btn-send:disabled,
        .chatbox-btn-send[disabled] {
            background-color: #6b9780;
        }

        .chatbox .chatbox-btn-send i {
            font-size: 26px;
            color: #fff;
        }

        .chatbox .chatbox-btn-send-file {
            height: 45px;
            width: 45px;
            border-radius: 50%;
            border: 0px;
            outline: none;
            margin-left: 7px;
            background-color: #27915a;
        }

        .chatbox-btn-send-file:disabled,
        .chatbox-btn-send-file[disabled] {
            background-color: #6b9780;
        }

        .chatbox .chatbox-btn-send-file i {
            font-size: 26px;
            color: #fff;
        }

        .item-chat {
            width: 100%;
            margin-top: 8px;
            display: flex;
            flex-direction: row;
        }

        .item-chat-me {
            justify-content: end;
        }

        .item-chat-guest {
            justify-content: start;
        }

        .item-chat-inner {
            padding: 6px 12px;
            border-radius: 14px;
            font-size: 16px;
            min-width: 40px;
            max-width: 80%;
        }

        .item-chat-me>.item-chat-inner {
            background-color: #f1ffd4;
            box-shadow: 0px 0px 2px 0px #edffa3;
        }

        .item-chat-guest>.item-chat-inner {
            background-color: #fff;
            box-shadow: 0px 0px 2px 0px #b9b9b9;
        }

        .item-chat-inner>.item-chat-body {}

        .item-chat-inner>.item-chat-time {
            margin-top: 0px;
            font-size: 11px;
            color: grey;
        }

        .item-chat-me>.item-chat-inner>.item-chat-time {
            text-align: right;
        }

        .item-chat-guest>.item-chat-inner>.item-chat-time {
            text-align: right;
        }

        .btn-action {
            width: 100%;
            border-radius: 10px;
            border: 0px;
            outline: none;
            background-color: #27915a;
            color: #fff;
            padding: 16px;
            font-size: 17px;
            font-weight: bold;
        }

        .btn-action:disabled,
        .btn-action[disabled] {
            background-color: #6b9780;
        }

        .msg-check {
            font-size: 17px;
        }

        .msg-check-blue {
            color: blue;
        }

        audio {
            max-width: 100%;
        }

        audio::-webkit-media-controls-panel {
            background-color: #27915a;
            color: #fff;
        }

        audio::-webkit-media-controls-current-time-display {
            color: #fff;
        }

        .unread-count {
            background-color: #27915a;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 1px 4px;
            border-radius: 20px;
            text-align: center;
            max-width: 60px;
            margin-left: 8px;
            margin-top: 10px;
        }
    </style>
    <!-- js -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
</head>

<body>
    <div class="app app-splash" style="background-color:#27915a;">
        <div class="absolute-center">
            <div style="color:#fff;">
                <div style="margin-bottom:20px;">
                    <i class="mdi mdi-whatsapp" style="font-size: 90px;"></i>
                </div>
                <div>
                    <h2>Tangan Angie WA</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="app app-not-connected">
        <div class="absolute-center">
            <div>
                <div style="margin-top:12px;color:#e31515;">
                    <div style="margin-bottom:20px;">
                        <i class="mdi mdi-radio-tower" style="font-size: 60px;"></i>
                    </div>
                    <div style="font-size:24px;">Tidak terhubung dengan WhatsApp
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="app app-contacts">
        <div class="header">
            <h2>Tangan Angie WA</h2>
        </div>
        <div class="list-contacts">
        </div>
        <button type="button" class="fab-plus">
            <i class="mdi mdi-pencil"></i></a>
        </button>
    </div>

    <div class="app app-new-msg">
        <div class="header">
            <h2>Pesan baru</h2>
        </div>
        <div class="container-fluid">
            <div class="row" style="margin-top: 14px;margin-bottom: 14px;">
                <div class="col-md-12">
                    <input type="text" class="input-control" name="new_input_wa" placeholder="Nomor WA (contoh: 628XXXXXX)" style="margin-bottom:6px;" autocomplete="off" />
                    <textarea class="input-control" name="new_input_msg" rows="6" placeholder="Ketikan pesan..." autocomplete="off" style="margin-bottom:6px;"></textarea>
                    <button type="button" class="btn-action btn-new-send">Kirim pesan baru</button>
                </div>
            </div>
        </div>
    </div>

    <div class="app app-conversation">
        <div class="header-profil">
            <div class="header-profil-flex">
                <div class="header-profil-img">
                </div>
                <div style="margin-left:18px;padding-top:6px">
                    <div class="header-profil-name"></div>
                </div>
            </div>
        </div>
        <div class="list-messages">
            <div class="list-messages-container"></div>
        </div>
        <div class="chatbox">
            <div class="chatbox-flex">
                <div class="chatbox-input-group">
                    <input name="chat" class="chatbox-input-text" placeholder="Ketik pesan.." autocomplete="off" />
                </div>
                <button type="button" class="chatbox-btn-send-file">
                    <i class="mdi mdi-file"></i></a>
                </button>
                <button type="button" class="chatbox-btn-send">
                    <i class="mdi mdi-send"></i></a>
                </button>
            </div>
        </div>
    </div>

    <div class="app app-send-file">
        <div class="header" style="background-color: #fff;">
            <h2 style="color:#27915a;">Kirim file ke</h2>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div style="text-align:center;margin-bottom:14px;">
                        <div style="text-align:center;margin-bottom:14px;">
                            <div class="profil-img"></div>
                        </div>
                        <div class="profil-name" style="font-size:20px;"></div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 14px;margin-bottom: 14px;">
                <div class="col-md-12">
                    <input type="file" class="input-control" name="file" style="margin-bottom:6px;" autocomplete="off" />
                    <textarea class="input-control" name="caption" rows="3" placeholder="Caption..." autocomplete="off" style="margin-bottom:6px;"></textarea>
                    <button type="button" class="btn-action btn-send-file">Kirim file</button>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-app">
    </div>
</body>

<script>
    $(document).ready(function() {
        var app_page = "";
        var iapp = 0;

        function openAppSplash() {
            app_page = "splash";
            $('.app').hide();
            $('.app.app-splash').show();
            // checkClient(function(sr) {
            //     if (sr == "ok") {
            //         setTimeout(function() {
            //             openAppContacts();
            //         }, 500);
            //         getContacts();
            //     } else {
            //         setTimeout(function() {
            //             openAppNotConnected();
            //         }, 1000);
            //     }
            // });
            getContacts();
            setTimeout(function() {
                openAppContacts();
            }, 500);
        }

        function openAppNotConnected() {
            app_page = "not-connected";
            $('.app').hide();
            $('.app.app-not-connected').show();
            if (navigator.vibrate) {
                navigator.vibrate(1000);
            }
        }

        function openAppContacts() {
            app_page = "contacts";
            $('.app').hide();
            $('.app.app-contacts').show();
            $('.fab-plus').on('click', function(e) {
                e.stopImmediatePropagation();
                navigateApp('new_msg');
            });
        }

        function openAppNewMsg() {
            app_page = "new_msg";
            $('.app').hide();
            $('.app-new-msg').show();

            $('input[name="new_input_wa"]').val('');
            $('textarea[name="new_input_msg"]').val('')
            $('.btn-new-send').on('click', function(e) {
                e.stopImmediatePropagation();
                $('.btn-new-send').html('Mengirim...');
                $('.btn-new-send').attr('disabled', 'disabled');
                send($('input[name="new_input_wa"]').val(), $('textarea[name="new_input_msg"]').val(), function(r) {
                    $('input[name="new_input_wa"]').val('');
                    $('textarea[name="new_input_msg"]').val('')
                    $('.btn-new-send').removeAttr('disabled');
                    $('.btn-new-send').html('Kirim pesan baru');
                    getContacts();
                    openAppContacts();
                });
            });
        }

        function openAppConversation(data) {
            $('.app').hide();
            $('.app.app-conversation').show();
            $('.header-profil-img').html(`<img src="${data['profilePicThumbObj']['img']}" onerror="this.onerror=null; this.src='<?php echo base_url('assets/images/blank-profile.png') ?>'" alt="" />`);
            var name = data['name'];
            if (typeof(name) === "undefined" || name == "") {
                name = data['id']['user'];
            }
            $('.header-profil-name').html(name);
            $('.profil-name').html(name);
            $('.profil-img').html(`<img src="${data['profilePicThumbObj']['img']}" onerror="this.onerror=null; this.src='<?php echo base_url('assets/images/blank-profile.png') ?>'" alt="" />`);
            $('.header-profil-img').on('click', function(e) {
                e.stopImmediatePropagation();
                navigateApp('');
            });
            if (app_page != 'send_file') {
                $('input[name="chat"]').val('');
                $('.list-messages .list-messages-container').html('');
                getMessages(data['id']['_serialized']);
            }
            app_page = "conversation";

            $('.chatbox-btn-send').attr('data-idu', data['id']['user']);
            $('.chatbox-btn-send').attr('data-idu-sz', data['id']['_serialized']);

            $('.chatbox-btn-send').on('click', function(e) {
                e.stopImmediatePropagation();
                $('.chatbox-btn-send').attr('disabled', 'disabled');
                $('.chatbox-btn-send').html('<i class="mdi mdi-dots-horizontal-circle"></i></a>');
                var idu = $(this).attr('data-idu');
                var idusz = $(this).attr('data-idu-sz');
                showLoad("Mengirim pesan...");
                var msg = $('input[name="chat"]').val();
                send(idu, msg, function(r) {
                    $('.chatbox-btn-send').removeAttr('disabled');
                    $('input[name="chat"]').val('');
                    $('.chatbox-btn-send').html('<i class="mdi mdi-send"></i></a>');
                    dismissLoad();
                    if (r == "ok") {
                        passMeGetMessage(msg);
                    }
                    // getMessages(idusz);
                });
            });

            $('.chatbox-btn-send-file').on('click', function(e) {
                e.stopImmediatePropagation();
                navigateApp('send_file');
            });
        }

        function openAppSendFile(data) {
            app_page = "send_file";
            $('.app').hide();
            $('.app-send-file').show();

            $('input[name="file"]').val('');
            $('textarea[name="caption"]').val('');

            var chatId = data['id']['_serialized'];
            $('.btn-send-file').on('click', function(e) {
                e.stopImmediatePropagation();
                var file = $('input[name="file"]').prop('files')[0];
                var caption = $('textarea[name="caption"]').val();
                $('.btn-send-file').attr('disabled', 'disabled');
                $('.btn-send-file').html('Mengupload file...');
                showLoad("Mengupload file...");
                sendFile(chatId, file, caption, function(r) {
                    $('.btn-send-file').removeAttr('disabled');
                    $('.btn-send-file').html('Kirim file');
                    dismissLoad();
                    if (r == "ok") {
                        window.history.back();
                        setTimeout(function() {
                            getMessages(chatId);
                        }, 500);
                    }
                });
            });
        }

        function checkClient(callback) {
            $.ajax({
                url: '<?php echo base_url('android/whatsapp/check_whatsapp_client') ?>',
                type: 'get',
                success: function(response) {
                    if (response['status']) {
                        callback("ok");
                    } else {
                        callback("error");
                    }
                },
                error: function() {
                    callback("error");
                }
            });
        }

        function getContacts() {
            var storageName = "CONTACTS_<?php echo $session_name ?>";
            var dataExistContacts = localStorage.getItem(storageName);
            if (typeof(dataExistContacts) === "string") {
                try {
                    generateContacts(JSON.parse(dataExistContacts));
                } catch (err) {}
            }
            showLoad("Memuat kontak...");
            $.ajax({
                url: '<?php echo $api_url . 'api/whatsapp/get_all_chat' ?>',
                type: 'get',
                dataType: 'json',
                cache: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer <?php echo $bearer_wa ?>');
                },
                success: function(response) {
                    dismissLoad();
                    if (response != null) {
                        var data = response['data'];
                        var contacts = [];
                        data.map(function(v) {
                            contacts.push(v);
                        });
                        try {
                            localStorage.setItem(storageName, JSON.stringify(contacts.length > 20 ? contacts.slice(0, 20) : contacts));
                        } catch (err) {}
                        generateContacts(contacts);
                    }
                },
                error: function() {
                    dismissLoad();
                }
            });
        }

        function generateContacts(response) {
            var html = '';
            for (var item in response) {
                var data = response[item]['contact'];
                var name = data['name'];
                var unread = response[item]['unreadCount'];
                if (typeof(name) === "undefined" || name == "") {
                    name = data['id']['user'];
                }
                var unreadCountHtml = ``;
                if (unread > 0) {
                    unreadCountHtml = `
                    <div style="flex:0.1;">
                        <div class="unread-count">${unread}</div>
                    </div>
                    `;
                }
                html += `<div>
                            <div class="item-contact" data-uid="${data['id']['user']}">
                                <div class="item-contact-flex">
                                    <div class="item-contact-img">
                                        <img src="${data['profilePicThumbObj']['img']}" onerror="this.onerror=null; this.src='<?php echo base_url('assets/images/blank-profile.png') ?>'" alt="" />
                                    </div>
                                    <div style="margin-left:18px;padding-top:6px;flex:1;overflow:hidden;">
                                        <div class="item-contact-name">${name}</div>
                                        <div class="item-contact-number">${data['id']['user']}</div>
                                    </div>
                                    ${unreadCountHtml}
                                </div>
                            </div>
                        </div>`;
            }
            $(".list-contacts").html(html);
            actionContacts(response);
        }

        var conversationData = null;

        function actionContacts(response) {
            $('.item-contact').on('click', function(e) {
                e.stopImmediatePropagation();
                var uid = $(this).attr('data-uid');
                var f = response.find(function(v) {
                    return v['contact']['id']['user'] == uid;
                });
                if (typeof(f.contact) === "object") {
                    conversationData = f.contact;
                    navigateApp('conversation');
                }
            });
        }

        var doneGetMessage = false;
        var ajaxGetMessage = null;

        function getMessages(chatId, isService = false) {
            if (!isService) {
                showLoad("Memuat pesan...");
            }
            if (ajaxGetMessage != null) {
                ajaxGetMessage.abort();
            }
            doneGetMessage = false;
            var storageMsg = "MSG_<?php echo $session_name ?>_" + chatId;
            var dataExistMsg = localStorage.getItem(storageMsg);
            if (typeof(dataExistMsg) === "string") {
                try {
                    generateConversationData(JSON.parse(dataExistMsg));
                } catch (err) {}
            }
            ajaxGetMessage = $.ajax({
                url: '<?php echo $api_url . 'api/whatsapp/get_messages' ?>',
                type: 'post',
                data: {
                    'chatId': chatId,
                },
                dataType: 'json',
                cache: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer <?php echo $bearer_wa ?>');
                },
                success: function(response) {
                    dismissLoad();
                    doneGetMessage = true;
                    if (typeof(response['data']) !== "null") {
                        generateConversationData(response['data']);
                        try {
                            var fgd = response['data'].reverse();
                            localStorage.setItem(storageMsg, JSON.stringify(fgd.slice(-2)));
                        } catch (err) {
                            console.log(err);
                        }
                    }
                },
                error: function() {
                    dismissLoad();
                    doneGetMessage = true;
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.addEventListener("progress", function(evt) {
                        var loadKb = Math.round(evt.loaded / 100000);
                        if (loadKb > 0) {
                            showLoad("Memuat (" + loadKb + ")");
                        }
                    }, false);
                    return xhr;
                },
            });
        }

        function passMeGetMessage(msg) {
            var html = genMsgChat({
                'content': msg,
                't': Date.now().toString().substring(0, 10),
                'ack': 1,
            }, true);
            $('.list-messages .list-messages-container').prepend(html);
        }

        function generateConversationData(data1) {
            var data = data1.reverse();
            var html = '';
            var lastDateShow = '';
            for (var item in data) {
                var fromMe = false;
                if (typeof(data[item]['fromMe']) !== 'undefined') {
                    fromMe = data[item]['fromMe'];
                }
                var dateFormat = new Date(Number(data[item]['t'] + '' + '000'));
                var fDate = formatDate(dateFormat);
                if (lastDateShow != '' && lastDateShow != fDate) {
                    html += genMsgDate(lastDateShow);
                }
                lastDateShow = fDate;
                var type = data[item]['type'];
                if (type == 'chat') {
                    html += genMsgChat(data[item], fromMe);

                } else if (type == 'image') {
                    html += genMsgImage(data[item], fromMe);

                } else if (type == 'ptt') {
                    html += genMsgPTT(data[item], fromMe);

                } else if (type == 'video') {
                    html += genMsgVideo(data[item], fromMe);

                } else if (type == 'revoked') {
                    html += genMsgRevoked(data[item], fromMe);

                } else if (type == 'e2e_notification') {
                    html += genMsgE2E(data[item], fromMe);

                } else {
                    console.log(type);
                }
            }
            if (lastDateShow != '') {
                html += genMsgDate(lastDateShow);
            }
            $('.list-messages .list-messages-container').html(html);
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }

        function genMsgDate(msg) {
            var html = `
                    <div style="
                        font-weight: 900;
                        text-align: center;
                        background: rgb(227 218 147);
                        padding: 6px 10px;
                        border-radius: 20px;
                        margin-top: 12px;
                        color: #5d5d5d;
                    ">
                    ${msg}
                    </div>`;
            return html;
        }

        function genMsgChat(data, fromMe) {
            var dateFormat = new Date(Number(data['t'] + '' + '000'));
            var msgDate = dateFormat.getHours() + ":" + dateFormat.getMinutes();
            var msg = data['content'];
            msg = msg.replace(/\n/g, "<br />");
            var html = `
                    <div class="item-chat ${fromMe ? 'item-chat-me' : 'item-chat-guest'}">
                        <div class="item-chat-inner">
                            <div class="item-chat-body">${msg}</div>
                            <div class="item-chat-time">${msgDate}${fromMe ? ('&nbsp;' + ackStatus(data)) : ''}</div>
                        </div>
                    </div>`;
            return html;
        }

        function genMsgImage(data, fromMe) {
            var dateFormat = new Date(Number(data['t'] + '' + '000'));
            var msgDate = dateFormat.getHours() + ":" + dateFormat.getMinutes();
            var msg = `<img src="${data['mediaBase64']}" style="max-width: 70%;" />`;
            var html = `
                    <div class="item-chat ${fromMe ? 'item-chat-me' : 'item-chat-guest'}">
                        <div class="item-chat-inner">
                            <div class="item-chat-body" style="text-align: center;">${msg}</div>
                            <div class="item-chat-time">${msgDate}${fromMe ? ('&nbsp;' + ackStatus(data)) : ''}</div>
                        </div>
                    </div>`;
            return html;
        }

        function genMsgPTT(data, fromMe) {
            var dateFormat = new Date(Number(data['t'] + '' + '000'));
            var msgDate = dateFormat.getHours() + ":" + dateFormat.getMinutes();
            var msg = `
            <audio controls>
                <source src="${data['mediaBase64']}" />
            </audio>`;
            var html = `
                    <div class="item-chat ${fromMe ? 'item-chat-me' : 'item-chat-guest'}">
                        <div class="item-chat-inner">
                            <div class="item-chat-body" style="text-align: center;">${msg}</div>
                            <div class="item-chat-time">${msgDate}${fromMe ? ('&nbsp;' + ackStatus(data)) : ''}</div>
                        </div>
                    </div>`;
            return html;
        }

        function genMsgVideo(data, fromMe) {
            var dateFormat = new Date(Number(data['t'] + '' + '000'));
            var msgDate = dateFormat.getHours() + ":" + dateFormat.getMinutes();
            var msg = `
            <video controls>
                <source src="${data['mediaBase64']}" />
            </video>`;
            var html = `
                    <div class="item-chat ${fromMe ? 'item-chat-me' : 'item-chat-guest'}">
                        <div class="item-chat-inner">
                            <div class="item-chat-body" style="text-align: center;">${msg}</div>
                            <div class="item-chat-time">${msgDate}${fromMe ? ('&nbsp;' + ackStatus(data)) : ''}</div>
                        </div>
                    </div>`;
            return html;
        }

        function genMsgRevoked(data, fromMe) {
            var dateFormat = new Date(Number(data['t'] + '' + '000'));
            var msgDate = dateFormat.getHours() + ":" + dateFormat.getMinutes();
            var msg = ``;
            var html = `
                    <div class="item-chat ${fromMe ? 'item-chat-me' : 'item-chat-guest'}">
                        <div class="item-chat-inner">
                            <div class="item-chat-body" style="text-align: center;">${msg}</div>
                            <div class="item-chat-time">${msgDate}${fromMe ? ('&nbsp;' + ackStatus(data)) : ''}</div>
                        </div>
                    </div>`;
            return html;
        }

        function genMsgE2E(data, fromMe) {
            var dateFormat = new Date(Number(data['t'] + '' + '000'));
            var msgDate = dateFormat.getHours() + ":" + dateFormat.getMinutes();
            var msg = ``;
            var html = `
                    <div class="item-chat ${fromMe ? 'item-chat-me' : 'item-chat-guest'}">
                        <div class="item-chat-inner">
                            <div class="item-chat-body" style="text-align: center;">${msg}</div>
                            <div class="item-chat-time">${msgDate}${fromMe ? ('&nbsp;' + ackStatus(data)) : ''}</div>
                        </div>
                    </div>`;
            return html;
        }

        function ackStatus(d) {
            var ack = '';
            if (d['ack'] == 1) {
                ack = 'mdi mdi-check';
            } else if (d['ack'] == 2) {
                ack = 'mdi mdi-check-all';
            } else if (d['ack'] == 3) {
                ack = 'mdi mdi-check-all msg-check-blue';
            }
            return `<i class="msg-check ${ack}"></i>`;
        }

        function send(no, msg, callback) {
            if (msg == '' || msg == null) {
                showLoad("Pesan kosong!");
                setTimeout(function() {
                    dismissLoad();
                    callback("error");
                }, 250);
                return;
            }
            $.ajax({
                url: '<?php echo $api_url . 'api/whatsapp/sendMessage/' . $session_name ?>',
                type: 'post',
                data: {
                    'tujuan': no,
                    'message': msg,
                },
                dataType: 'json',
                cache: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer <?php echo $bearer_wa ?>');
                },
                success: function(response) {
                    callback("ok");
                },
                error: function() {
                    callback("error");
                }
            });
        }

        function sendFile(chatId, file, caption, callback) {
            if (typeof(file) === 'undefined') {
                showLoad("Gambar tidak ada!");
                setTimeout(function() {
                    dismissLoad();
                    callback("error");
                }, 250);
                return;
            }
            var fd = new FormData();
            fd.append('tujuan', chatId);
            fd.append('message', caption);
            fd.append('allFiles[]', file);
            $.ajax({
                url: '<?php echo $api_url . 'api/whatsapp/send_file_message' ?>',
                type: 'post',
                data: fd,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer <?php echo $bearer_wa ?>');
                },
                success: function(response) {
                    callback("ok");
                },
                error: function() {
                    callback("error");
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.addEventListener("progress", function(evt) {
                        var loadKb = Math.round(evt.loaded / evt.total);
                        if (loadKb > 0) {
                            showLoad("Upload " + loadKb + "%");
                        }
                    }, false);
                    return xhr;
                },
            });
        }

        var showLoadSt = false;

        function showLoad(txt = '') {
            showLoadSt = true;
            $('.loading-app').show();
            $('.loading-app').html(txt);
        }

        function dismissLoad() {
            if (showLoadSt) {
                $('.loading-app').fadeOut();
            }
        }

        function navigateApp(name) {
            if (name == '') {
                window.history.back();
            } else {
                window.location.href = '#' + name;
            }
        }

        function router(evt) {
            let url = window.location.hash.slice(1) || '/';
            if (url == '' || url == '/') {
                if (iapp == 0) {
                    openAppSplash();
                } else {
                    openAppContacts();
                    iapp = 0;
                }
                if (ajaxGetMessage != null) {
                    ajaxGetMessage.abort();
                }
            } else if (url == 'new_msg') {
                openAppNewMsg();
            } else if (url == 'conversation') {
                if (app_page != 'send_file') {
                    setTimeout(function() {
                        openAppConversation(conversationData);
                    }, 120);
                } else {
                    openAppConversation(conversationData);
                }
            } else if (url == 'send_file') {
                openAppSendFile(conversationData);
            }
            iapp++;
        }

        window.addEventListener('load', router);
        window.addEventListener('hashchange', router);

        // function WorkerOnTheGo() {
        //     if (app_page == "conversation") {
        //         if (doneGetMessage) {
        //             var idusz = $('.chatbox-btn-send').attr('data-idu-sz');
        //             getMessages(idusz, true);
        //         }
        //     }
        //     setTimeout(function() {
        //         // WorkerOnTheGo();
        //     }, 30000);
        // }
        // WorkerOnTheGo();
    });
</script>

</html>