<h2 style="margin-top:0px">Kantor <?php echo $button ?></h2>
<div class="card">
    <div class="card-body">
        <form action="<?php echo $action; ?>" method="post">
            <input type="hidden" name="id_registrasi_kantor" value="<?php echo $id_registrasi_kantor; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="varchar">Kode Kantor <?php echo form_error('kode') ?></label>
                        <input type="text" class="form-control" name="kode" id="kode" placeholder="Kode" value="<?php echo $kode; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Nama Kantor <?php echo form_error('nama_kantor') ?></label>
                        <input type="text" class="form-control" name="nama_kantor" id="nama_kantor" placeholder="Nama Kantor" value="<?php echo $nama_kantor; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Alamat Kantor <?php echo form_error('alamat_kantor') ?></label>
                        <input type="text" class="form-control" name="alamat_kantor" id="alamat_kantor" placeholder="Alamat Kantor" value="<?php echo $alamat_kantor; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Nomor Telp Kantor <?php echo form_error('no_telp_kantor') ?></label>
                        <input type="text" class="form-control" name="no_telp_kantor" id="no_telp_kantor" placeholder="Nomor Telp Kantor" value="<?php echo $no_telp_kantor; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Bidang Bisnis <?php echo form_error('bidang_bisnis') ?></label>
                        <input type="text" class="form-control" name="bidang_bisnis" id="bidang_bisnis" placeholder="Bidang Bisnis" value="<?php echo $bidang_bisnis; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Jumlah Karyawan <?php echo form_error('jumlah_karyawan') ?></label>
                        <input type="text" class="form-control" name="jumlah_karyawan" id="jumlah_karyawan" placeholder="Jumlah Karyawan" value="<?php echo $jumlah_karyawan; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Nama Pemohon <?php echo form_error('nama_pemohon') ?></label>
                        <input type="text" class="form-control" name="nama_pemohon" id="nama_pemohon" placeholder="Nama Pemohon" value="<?php echo $nama_pemohon; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Nomor Telp Pemohon <?php echo form_error('no_telp_pemohon') ?></label>
                        <input type="text" class="form-control" name="no_telp_pemohon" id="no_telp_pemohon" placeholder="Nomor Telp Pemohon" value="<?php echo $no_telp_pemohon; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Jabatan Pemohon <?php echo form_error('jabatan_pemohon') ?></label>
                        <input type="text" class="form-control" name="jabatan_pemohon" id="jabatan_pemohon" placeholder="Jabatan Pemohon" value="<?php echo $jabatan_pemohon; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Email <?php echo form_error('email') ?></label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Kode WhatsApp <?php echo form_error('kode_whatsapp') ?></label>
                        <input type="text" class="form-control" name="kode_whatsapp" id="kode_whatsapp" placeholder="Kode WhatsApp" value="<?php echo $kode_whatsapp; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Lat <?php echo form_error('kantor') ?></label>
                        <input type="text" class="form-control" name="lat" id="lat" placeholder="Latitude" value="<?php echo $lat; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Long <?php echo form_error('kantor') ?></label>
                        <input type="text" class="form-control" name="long" id="long" placeholder="Longitude" value="<?php echo $long; ?>" />
                    </div>
                    <button type="button" class="btn btn-success btn-block" id="btn_get_location">Ambil lokasi</button>
                </div>
                <div class="col-md-3"></div>
            </div>
            <br><br>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" id="btn-update"><?php echo $button ?></button>
                <a href="<?php echo site_url('admin/kantor') ?>" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    jQuery(function($) {
        var getLocation = function() {
            $("#btn_get_location").removeClass('btn-success');
            $("#btn_get_location").addClass('btn-danger');
            $("#btn_get_location").attr('disabled', 'disabled');
            navigator.geolocation.getCurrentPosition(foundLocation, noLocation);
        }
        var noLocation = function() {
            $("#btn_get_location").removeClass('btn-danger');
            $("#btn_get_location").addClass('btn-success');
            $("#btn_get_location").removeAttr('disabled');
            $("#lokasi").val('Tidak Bisa Mendapatkan Lokasi');
            $("#lat").val('Tidak Bisa Mendapatkan Lokasi');
            $("#long").val('Tidak Bisa Mendapatkan Lokasi');
            alert('Tidak bisa mendapatkan lokasi kantor anda, spertinya ada kendala dengan GPS atau jaringan anda!');
            $("#btn-update").attr('disabled', 'disabled');

        }
        var foundLocation = function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            $("#lokasi").val(lat + ', ' + lng);
            $("#lat").val(lat);
            $("#long").val(lng);
            $("#lat").attr('readonly', 'readonly');
            $("#long").attr('readonly', 'readonly');
            $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=true', function(data) {
                var results = data.results[0];
                var ac = results.address_components;
                var alamat_instansi = results.formatted_address;
                for (var i = 0; i < ac.length; i++) {
                    if (ac[i].types[0] == 'administrative_area_level_4') { // Kelurahan
                        $("#kelurahan_instansi").val(ac[i].short_name);
                    } else if (ac[i].types[0] == 'administrative_area_level_3') { // Kecamatan
                        $("#kecamatan_instansi").val(ac[i].short_name);
                    }
                }
                $("#alamat_instansi").val(alamat_instansi);
                $("#btn_get_location").removeClass('btn-danger');
                $("#btn_get_location").addClass('btn-success');
                $("#btn_get_location").removeAttr('disabled');
            });
        }

        <?php if (empty($id)) { ?>
            getLocation();
        <?php } ?>

        $("#btn_get_location").click(function(e) {
            e.stopImmediatePropagation();
            getLocation();
        });
    });
</script>