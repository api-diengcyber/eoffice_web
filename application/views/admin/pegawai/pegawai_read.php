<style>
    .ft-p{
        width:200px;
        height:200px;
        border-radius:100%;
        background-image: url('<?=base_url('assets/photos/'.$foto)?>');
        background-size:cover;
        border:1px solid  #00ce68
    }
    .ft-p-2{
        width:200px;
        height:200px;
        border-radius:100%;
        background-image: url('https://cdn-icons-png.flaticon.com/512/3177/3177440.png');
        background-size:cover;
        border:1px solid  #00ce68
    }
    .card-foto{
        height:260px;
    }
    @media only screen and (max-width: 768px) {
       .ft-p{
        width:130px;
        height:130px;
       }
       .ft-p-2{
        width:130px;
        height:130px;
       }
       .card-foto{
        height:190px;
    }
    }
</style>
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Pegawai
                </h1>
                <div class="cek"></div>
            </div><!-- /.page-header -->
            <div class="row pt-5">

                <div class="col-md-4 d-flex justify-content-center mb-5">
                    <div class="card card-foto">
                        <div class="card-body">
                            <?php 
                            
                            if($foto!=null){?>

                                <div class="ft-p" style="">

                                </div>
                            <?php
                            }else{
                            ?>
                            <div class="ft-p-2" style="">

                            </div>
                            <?php
                            }                    
                            ?>

                        </div>
                    </div>
                  
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                               
                                <tr><td>Nama Pegawai</td><td><?php echo $nama_pegawai; ?></td></tr>
                                <tr>
                                    <td>Status</td>
                                    <td><?php 
                                        if($status=1){?>

                                            <b class="text-success">Aktif</b>
                                        <?php }else { ?>
                                            <b class="text-danger">Tidak Aktif</b>
                                        
                                        <?php }?>
                                    
                                    </td>
                                </tr>
                                <tr><td>Email</td><td><?php echo $email; ?></td></tr>
                                <tr><td>No Telp/Hp/WhatsApp</td><td><?php echo $no_wa; ?></td></tr>
                                <tr><td>Tgl Lahir</td><td><?php echo $tgl_lahir; ?></td></tr>
                                <tr><td>Jenis Kelamin</td><td><?php echo $jenis_kelamin; ?></td></tr>
                                <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
                                <tr><td>Tgl Masuk</td><td><?php echo $tgl_masuk; ?></td></tr>
                                <tr><td>Level</td><td><?php echo $level; ?></td></tr>
                                <tr><td>Jabatan</td><td><?php echo $jabatan; ?></td></tr>
                                <tr><td>Tingkat</td><td><?php echo $tingkat; ?></td></tr>
                                <tr><td>Gaji Pokok</td><td><?php echo $gaji_pokok; ?></td></tr>
                                <tr><td>Rekening</td><td><?php echo $rekening; ?></td></tr>
                                
                                <tr><td></td><td><a href="<?php echo site_url('admin/pegawai') ?>" class="btn btn-default">Cancel</a></td></tr>
                            </table>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->