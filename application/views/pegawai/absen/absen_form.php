<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h3>
                    Absen
                </h3>
            </div><!-- /.page-header -->

            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <!-- <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?> -->
               
                    <p  class="text-danger">
                        <span class="mdi mdi-map-marker"></span>
                        <span id="alert-text"></span>
                    </p>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
            </div>

            <div class="row hidden-sm hidden-xs">
                <div class="col-12">
              
                </div>
                <div class="col-md-8">
                    <!-- PAGE CONTENT BEGINS -->
                  <div class="row">
                      <?php 
                            if($cekIjin==null){?>
                            
                        <div class="col-md-6 col-6">
                            <form action="<?php echo base_url() ?>pegawai/absen/absen_action" method="post">
                            <input type="hidden" name="lokasi" id="alamat" class="alamat" value="">
                                <button type="submit" name="absen" id="masuk" value="1"  class="btn btn-rounded <?php if ($status=='1' || $status=='2') { echo 'btn-default disabled'; } else { echo 'btn-success'; } ?>  no-radius btn-block " disabled='disabled'>
                                    <i class="ace-icon fa fa-download bigger-230" ></i>
                                    MASUK
                                </button>
                                <input type="hidden" name="status" value="<?php echo $status ?>">
                            </form>
                        </div>
                        <div class="col-md-6 col-6">
                          <form action="<?php echo base_url() ?>pegawai/absen/absen_action" method="post" id="absen">
                            <input type="hidden" name="lokasi" id="alamat" class="alamat" value="">
                                <button type="button" id="pulang" name="absen" value="2" <?php if ($status=='0') { echo 'disabled'; } ?> class="btn no-border <?php if ($status=='2') { echo 'btn-warning'; } else if($status == '1') { echo 'btn-danger'; } else{ echo 'btn-default'; } if($jam_pulang!=null){echo 'disabled';} ?> no-radius btn-block btn-rounded"  <?php if($jam_pulang!=null){echo 'disabled';} ?>>
                                    <i class="ace-icon fa fa-upload bigger-230"></i>
                                    PULANG
                                </button>
                            <input type="hidden" name="absen" value="2" id="val">
                            <input type="hidden" name="status" value="<?php echo $status ?>">
                        </div>

                    <?php    }else{?>
                            <div class="col-4">
                                <?php 
                                    if($cekIjin->ket_tidak_masuk=='Sakit'){?>
                                        <p class="badge bg-danger text-white p-2"> <i class="fa-solid fa-temperature-three-quarters"></i> <?=$cekIjin->ket_tidak_masuk?></p>
                                        
                                        <?php }elseif($cekIjin->ket_tidak_masuk=='Cuti'){?>
                                            <p class="badge bg-primary p-2"> <i class="fa-solid fa-briefcase"></i> <?=$cekIjin->ket_tidak_masuk?></p>
                                       
                                    <?php }elseif($cekIjin->ket_tidak_masuk=='Alpha'){?>
                                        <p class="badge bg-info text-white p-2"> <i class="fa-solid fa-circle-info"></i> <?=$cekIjin->ket_tidak_masuk?></p>                                       
                                    <?php }elseif($cekIjin->ket_tidak_masuk=='Ijin'){?>
                                        <p class="badge bg-warning p-2"> <i class="fa-solid fa-car"></i> <?=$cekIjin->ket_tidak_masuk?></p>                                       
                                    <?php }elseif($cekIjin->ket_tidak_masuk=='Setengah Hari'){?>
                                        <p class="badge bg-secondary p-2"> <i class="fa-solid fa-clock"></i> <?=$cekIjin->ket_tidak_masuk?></p>
                                    <?php }else{?>
                                        <p class="badge bg-warning p-2"> <i class="fa-solid fa-car"></i> <?=$cekIjin->ket_tidak_masuk?></p>
                               <?php     } ?>
                                
                               
                                
                            </div>
                        
                        
                        <?php }
                    ?>
                  
                  </div>
                  </form>
                
                <!-- Modal -->
                <div class="modal fade" id="modalPagi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog bg-danger" role="document">
                        <div class="modal-content border-danger bg-danger">
                            <div class="modal-body bg-danger text-white">
                                Anda harus upload laporan pekerjaan hari ini terlebih dahulu.
                                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalSiang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog bg-danger" role="document">
                        <div class="modal-content border-danger bg-danger">
                            <div class="modal-body bg-danger text-white">
                                Anda harus upload laporan sore terlebih dahulu.
                                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                  <script>
                    $(document).ready(function(){
                        $('#pulang').click(function(){
                            console.log(<?php print_r($status_laporan);?>);
                            var status_laporan = <?php echo $status_laporan;?>;
                            if(status_laporan == 0){
                                $('#modalPagi').modal('show');
                            }else if(status_laporan == 1){
                                $('#modalSiang').modal('show');
                            }else{
                                $('#absen').submit();
                            }
                        });
                    });
                  </script>

                  <div class="space"></div>

                  <div class="row mb-3">
                    <div class="col-12">
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-dark mt-3" id="mytable">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th width="150px">Tanggal</th>
                                    <th width="50px">Status</th>
                                    <th width="300px">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; foreach ($data_absen as $key): 
                            $nm_status = '';
                            if ($key->status == '1') { // MASUK
                                $nm_status = "<label class='badge badge-primary'>MASUK</label>";
                            } else if ($key->status == '2') { // PULANG
                                $nm_status = "<label class='badge badge-danger'>PULANG</label>";
                            }
                            ?>
                                <tr>
                                    <td><?php echo $no ?></td>
                                    <td>
                                        <p class="mb-2"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $key->tgl; ?></p>
                                        <p class="mb-2"><?php echo '<i class="fa fa-clock-o"></i> Masuk &nbsp;: '.$key->jam_masuk;?></p>
                                        <p class="mb-2"><?php echo '<i class="fa fa-clock-o"></i> Pulang : '.$key->jam_pulang ?></p>
                                    </td>
                                    <td>
                                        <?php
                                            if($key->jam_pulang != ''){
                                                $start = new \DateTime($key->tgl.' '.$key->jam_masuk);
                                                $end   = new \DateTime($key->tgl.' '.$key->jam_pulang);

                                                $interval  = $end->diff($start);
                                                $jam_masuk =  $interval->format('%h,%i Jam');
                                                echo $jam_masuk.'<br><br>';

                                                if($jam_masuk >= 7){
                                                    echo "<label class='badge badge-primary'>FULL TIME</label>";
                                                }else if($jam_masuk > 4 AND $jam_masuk < 7){
                                                    echo "<label class='badge badge-warning'>PART TIME</label>";
                                                }
                                                else if($jam_masuk < 5){
                                                   
                                                }
                                            }
                                            
                                        ?>
                                    </td>
                                    <td>
                                        <?php if(empty($key->keterangan)){?>
                                        <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalKet">Tambah Keterangan</a>
                                        <?php } else { 
                                        echo '<div class="mb-1">'.$key->keterangan.'</div><br><a class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#modalKet">Ubah Keterangan</a>';
                                        } ?>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalKet" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <form action="<?php echo base_url('pegawai/absen/add_keterangan');?>" method="post">
                                            <div class="modal-dialog text-black" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                           <div class="form-group">
                                                             <label for="">Keterangan</label>
                                                             <textarea name="keterangan" id="" cols="30" rows="10" class="form-control"><?php echo $key->keterangan;?></textarea>
                                                           </div>
                                                           <div class="form-group">
                                                              <input type="hidden" name="id" id="input" class="form-control" value="<?php echo $key->id;?>">
                                                              <input type="checkbox" name="pulang" id="" checked>
                                                              <label for="">Pulang</label>
                                                           </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php $no++; endforeach ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                  </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->

                <div class="col-md-4">

                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white mb-3 card-header-flat">
                            <h4 class="smaller">
                                <i class="normal-icon ace-icon fa fa-bell red bigger-130"></i>
                                Tugas Belum Selesai
                            </h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="card-main">
                                <ol class="mlist">
                                    <?php foreach ($data_tugas as $dt): ?>
                                    <li class="dd-item dd2-item item-red row" data-id="1">
                                        <div class="col-9"><?php echo $dt->judul ?></div>
                                        <div class="col-3"><a href="<?php echo base_url('marketing/tugas/read/').$dt->id ?>" class="btn btn-primary btn-xs pull-right">Detail</a></a>
                                    </li>
                                    <?php endforeach ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary text-white mb-3 card-header-flat">
                            <h4 class="smaller">
                                <i class="normal-icon ace-icon fa fa-calendar orange2 bigger-130"></i>
                                Riwayat Masuk
                            </h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="card-main">
                                <?php if (count($data_rekap_tahun) < 1 && count($data_rekap_bulan) < 1) { ?>
                                    <div class="alert alert-info">
                                        Rekap Kosong!
                                    </div>
                                <?php } else { ?>
                                    <div style="display:flex;overflow-y:scroll;" class="scroll-onhover">
                                    <?php foreach ($data_rekap_tahun as $key): ?>
                                        <a href="<?php echo base_url('marketing/absen/index/').date('m').'/'.$key->tahun;?>" class="btn btn-primary btn-xs no-radius" style="margin: 2px;">
                                            <i class="ace-icon fa fa-calendar bigger-110"></i>
                                            <?php echo $key->tahun ?>
                                            <span class="badge bg-white text-black"><?php echo $key->jml ?></span>
                                        </a>
                                    <?php endforeach ?>
                                    </div>
                                    <div class="hr hr-double hr10"></div>
                                    <div class="dd dd-draghandle">
                                        <ol class="mlist">
                                          <?php foreach ($data_rekap_bulan as $key): ?>
                                            <li class="dd-item dd2-item item-orange p-2" style="cursor:pointer" data-id="1" onclick="location.href='<?php echo base_url().'marketing/absen/index/'.$key->id_bulan.'/'.$this->uri->segment(5);?>'">
                                                <div class="dd2-content">
                                                    <?php echo $key->bulan ?> <?php echo $tahun ?> 
                                                    <span class="badge badge-warning pull-right"><?php echo $key->jml ?></span>
                                                </div>
                                            </li>
                                          <?php endforeach ?>
                                        </ol>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
    
   
    <input type="hidden" id="lok" value="<?=$nama_kantor?>">
    <!-- <input type="text" id="kelurahan_instansi" value=""> -->
</div><!-- /.main-content -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry"></script>
<script>
    var nama_kantor = 'Lokasi '+$('#lok').val();
    // console.log(nama_kantor);
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
           
            
            var posisi_1 = new google.maps.LatLng(<?=$lat?>,  <?=$long?>);
            // var posisi_1 = new google.maps.LatLng( -7.3602216063503425, 109.9143248209049);

            //lokasi kedua

            var posisi_2 = new google.maps.LatLng(lat, lng);

            var posisi_fix = Number((google.maps.geometry.spherical.computeDistanceBetween(posisi_1, posisi_2)).toFixed(2));
            // console.log(posisi_fix);

            if(posisi_fix>20){

                $('#alert-text').html('Lokasi Tidak Diketahui');
                $('#masuk').attr('disabled','disabled');
                $('#pulang').attr('disabled','disabled');
                
            }else{
                
                $('#masuk').removeAttr('disabled','disabled');
                $('#pulang').removeAttr('disabled','disabled');
                $('#alert-text').html(nama_kantor);
                // $('.lat').val(lat);
                // $('.long').val(lng);
                
            

            }



            // $("#lokasi").val(lat + ', ' + lng);

            fetch('http://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=true')
            .then(response => response.json())
            .then(data => {
                // console.log('iki');
                console.log(data);
                if (data && data.results && data.results.length > 0) {
                    var results = data.results[0];
                    console.log(results.address_components);
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
                    console.log("cek");
                } else {
                    console.error("Error in retrieving address information.");
                }
            })
            .catch(error => {
                console.error("Fetch error: ", error);
            });


            $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng+'&sensor=true', function(data){
                var results = data.results[0];
                // console.log('IKU');
                // console.log(data);
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
                console.log("cek");
            });
        }
        getLocation();
        $("#btn_get_location").click(function(e){
            e.stopImmediatePropagation();
            getLocation();
        });
    });
    
    </script>
   
      <script>
        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // var mymap = L.map('mapid').setView([latitude, longitude], 13);

            // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            //     maxZoom: 18,
            // }).addTo(mymap);

            fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + latitude + '&lon=' + longitude)
                .then(response => response.json())
                .then(data => {
                    var locationDetails = latitude+','+longitude+ ' '+data.address.city+ " " + data.address.state + " " + data.address.country+' '+data.address.postcode;

                    // console.log(locationDetails);
                
                    // L.marker([latitude, longitude]).addTo(mymap)
                    //     .bindPopup(locationDetails)
                    //     .openPopup();
                        $('.alamat').val(locationDetails);
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        }

        function showError(error) {
            // Handle error
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            // Handle unsupported geolocation
        }
    </script>
    

