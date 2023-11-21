

      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <h1>Daily Sales Report</h1>
            </div><!-- /.page-header -->

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <form action="<?php echo $action; ?>" method="post">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label for="varchar">Tgl Kunjungan <?php echo form_error('tgl_kunjungan') ?></label>
                        <input type="text" class="form-control" name="tgl_kunjungan" id="datepicker1" placeholder="Tgl Kunjungan" value="<?php echo $tgl_kunjungan; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Nama Instansi <?php echo form_error('nama_instansi') ?></label>
                        <input type="text" class="form-control" name="nama_instansi" id="nama_instansi" placeholder="Nama Instansi" value="<?php echo $nama_instansi; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Lokasi <?php echo form_error('lokasi') ?> </label>
                        <button type="button" class="btn btn-success btn-minier pull-right" id="btn_get_location">Ambil Lokasi Ini</button>
                        <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Lokasi" value="<?php echo $lokasi; ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Alamat Instansi <?php echo form_error('alamat_instansi') ?></label>
                        <input type="text" class="form-control" name="alamat_instansi" id="alamat_instansi" placeholder="Alamat Instansi" value="<?php echo $alamat_instansi; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Kelurahan Instansi <?php echo form_error('kelurahan_instansi') ?></label>
                        <input type="text" class="form-control" name="kelurahan_instansi" id="kelurahan_instansi" placeholder="Kelurahan Instansi" value="<?php echo $kelurahan_instansi; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Kecamatan Instansi <?php echo form_error('kecamatan_instansi') ?></label>
                        <input type="text" class="form-control" name="kecamatan_instansi" id="kecamatan_instansi" placeholder="Kecamatan Instansi" value="<?php echo $kecamatan_instansi; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Telp Instansi <?php echo form_error('telp_instansi') ?></label>
                        <input type="text" class="form-control" name="telp_instansi" id="telp_instansi" placeholder="Telp Instansi" value="<?php echo $telp_instansi; ?>" />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label for="varchar">Telp 2 Instansi <?php echo form_error('telp2_instansi') ?></label>
                        <input type="text" class="form-control" name="telp2_instansi" id="telp2_instansi" placeholder="Telp 2 Instansi" value="<?php echo $telp2_instansi; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Atas Nama <?php echo form_error('atas_nama') ?></label>
                        <input type="text" class="form-control" name="atas_nama" id="atas_nama" placeholder="Atas Nama" value="<?php echo $atas_nama; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Alamat Atas Nama <?php echo form_error('alamat_atas_nama') ?></label>
                        <input type="text" class="form-control" name="alamat_atas_nama" id="alamat_atas_nama" placeholder="Alamat Atas Nama" value="<?php echo $alamat_atas_nama; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Keterangan <?php echo form_error('keterangan') ?></label>
                        <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="varchar">Status <?php echo form_error('status') ?></label>
                        <select class="form-control" name="status" id="status">
                          <?php foreach ($data_pil_status as $key): ?>
                            <?php if ($key->id == $status) { ?> 
                              <option selected value="<?php echo $key->id ?>"><?php echo $key->status ?></option>
                            <?php } else { ?>
                              <option value="<?php echo $key->id ?>"><?php echo $key->status ?></option>
                            <?php } ?>
                          <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="varchar">Prioritas <?php echo form_error('prioritas') ?></label>
                        <select class="form-control" name="prioritas" id="prioritas">
                            <option <?php echo ($prioritas=='0') ? 'selected' : '' ?> value="0">Belum</option>
                            <option <?php echo ($prioritas=='1') ? 'selected' : '' ?> value="1">Bulan Ini</option>
                            <option <?php echo ($prioritas=='2') ? 'selected' : '' ?> value="2">Bulan Depan</option>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <br>
                    <center>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('admin/daily_sales_report') ?>" class="btn btn-default">Cancel</a>
                    </center>
                  </div>
                </div>
                </form>
                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div>
      </div><!-- /.main-content -->

    <script>
    jQuery(function($){
        var getLocation = function(){
            $("#btn_get_location").removeClass('btn-success');
            $("#btn_get_location").addClass('btn-danger');
            $("#btn_get_location").attr('disabled','disabled');
            navigator.geolocation.getCurrentPosition(foundLocation, noLocation);
        }
        var noLocation = function() {
            $("#btn_get_location").removeClass('btn-danger');
            $("#btn_get_location").addClass('btn-success');
            $("#btn_get_location").removeAttr('disabled');
            $("#lokasi").val('[CANNOT_DETECT_LOCATION]');
        }
        var foundLocation = function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            $("#lokasi").val(lat + ', ' + lng);
            $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&sensor=true', function(data){
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
        $("#btn_get_location").click(function(e){
            e.stopImmediatePropagation();
            getLocation();
        });
    });
    </script>