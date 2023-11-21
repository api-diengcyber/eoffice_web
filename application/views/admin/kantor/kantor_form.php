<h2 style="margin-top:0px">Kantor <?php echo $button ?></h2>
<div class="card">
    <div class="card-body">
        <form action="<?php echo $action; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <div class="row">
            <div class="col-md-4">
            <!-- <input type="text" id="lokasi" value=""> -->
                <div class="form-group">
                    <label for="varchar">Nama Kantor <?php echo form_error('kantor') ?></label>
                    <input type="text" class="form-control" name="kantor" id="kantor" placeholder="Kantor" value="<?php echo $nama_kantor; ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="varchar">Lat <?php echo form_error('kantor') ?></label>
                    <input type="text" class="form-control" name="lat" id="lat" placeholder="Latitude" value="<?php echo $lat; ?>" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="varchar">Long <?php echo form_error('kantor') ?></label>
                    <input type="text" class="form-control" name="long" id="long" placeholder="Longitude" value="<?php echo $long; ?>" />
                </div>
        
            </div>
        </div>
        
            
            
            <button type="submit" class="btn btn-primary" id="btn-update"><?php echo $button ?></button>
            <a href="<?php echo site_url('admin/kantor') ?>" class="btn btn-default">Cancel</a>
        </form>
      
    </div>
</div>
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
            $("#lokasi").val('Tidak Bisa Mendadapatkan Lokasi');
            $("#lat").val('Tidak Bisa Mendadapatkan Lokasi');
            $("#long").val('Tidak Bisa Mendadapatkan Lokasi');
            alert('Tidak bisa mendapatkan lokasi kantor anda, spertinya ada kendala dengan GPS atau jaringan anda!');
            $("#btn-update").attr('disabled','disabled');

        }
        var foundLocation = function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            $("#lokasi").val(lat + ', ' + lng);
            $("#lat").val(lat);
            $("#long").val(lng);
            $("#lat").attr('readonly','readonly');
            $("#long").attr('readonly','readonly');
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
        getLocation();
        $("#btn_get_location").click(function(e){
            e.stopImmediatePropagation();
            getLocation();
        });
    });
    </script>