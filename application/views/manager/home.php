
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Dashboard
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                          <div class="card card-statistics">
                            <div class="card-body">
                              <div class="clearfix">
                                <div class="float-left">
                                  <i class="mdi mdi-account-multiple text-danger icon-lg"></i>
                                </div>
                                <div class="float-right">
                                  <p class="mb-0 text-right">Jumlah Pegawai</p>
                                  <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0"><?php echo count($data_pegawai) ?></h3>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                          <div class="card card-statistics">
                            <div class="card-body">
                              <div class="clearfix">
                                <div class="float-left">
                                  <i class="mdi mdi-calendar-check text-warning icon-lg"></i>
                                </div>
                                <div class="float-right">
                                  <p class="mb-0 text-right">Masuk Hari Ini</p>
                                  <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0"><?php echo count($data_masuk) ?></h3>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                          <div class="card card-statistics">
                            <div class="card-body">
                              <div class="clearfix">
                                <div class="float-left">
                                  <i class="mdi mdi-exit-to-app text-success icon-lg"></i>
                                </div>
                                <div class="float-right">
                                  <p class="mb-0 text-right">Pulang Hari Ini</p>
                                  <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0"><?php echo count($data_pulang) ?></h3>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                          <div class="card card-statistics" style="cursor:pointer" onclick="window.location.href='<?php echo base_url('admin/tugas');?>'">
                            <div class="card-body">
                              <div class="clearfix">
                                <div class="float-left">
                                  <i class="mdi mdi-clipboard-check text-info icon-lg"></i>
                                </div>
                                <div class="float-right">
                                  <p class="mb-0 text-right">Konfirmasi Tugas</p>
                                  <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0"><?php echo count($tugas_pending) ?></h3>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="space"></div>

                    <h2 class="capitalize"><?php echo $data_bulan_ini->bulan ?> <?php echo $tahun ?></h2>
                    <div class="row mb-3">
                        <div class="col-md-12" style="overflow:auto;margin:auto;">
                            <table class="table table-bordered bg-white">
                                <thead class="table-dark">
                                    <th>Nama</th>
                                    <?php for ($i=1; $i <= $batas_hari_bulan; $i++) : ?>
                                    <?php if ($i == $hari) { ?>
                                    <th style="background-color: orange;"><?php echo $i ?></th>
                                    <?php } else { ?>
                                    <th><?php echo $i ?></th>
                                    <?php } ?>
                                    <?php endfor ?>
                                </thead>
                                <?php foreach ($data_pegawai_kerja as $key): ?>
                                <tr>
                                    <td><?php echo $key->nama_pegawai ?></td>
                                    <?php 
                                    for ($i=1; $i <= $batas_hari_bulan; $i++) : 
                                        $row_absen = $this->db->select('j.*')
                                                        ->from('jam_kerja AS j')
                                                        ->where('j.id_users', $key->id_users)
                                                        ->where('RIGHT(j.tgl,4) = "'.$tahun.'"')
                                                        ->where('SUBSTRING(j.tgl,4,2) = "'.sprintf('%02d', $bulan).'"')
                                                        ->where('LEFT(j.tgl,2) = "'.sprintf('%02d', $i).'"')
                                                        ->get()->row();
                                    ?>
                                    <?php if ($row_absen) { ?>
                                      <th class="bg-success">
                                        <?php if($row_absen->status == 2){
                                          echo "<b style='color:yellow'>P</b>";
                                        }else{
                                          echo "<b class='text-white'>M</b>";
                                        } ?>
                                      </th>
                                    <?php } else { 
                                        $row_tidak_masuk = $this->db->select('j.*, p.ket_tidak_masuk')
                                                        ->from('tidak_masuk AS j')
                                                        ->join('pil_tidak_masuk AS p', 'j.tidak_masuk = p.id')
                                                        ->where('j.id_users', $key->id_users)
                                                        ->where('RIGHT(j.tgl,4) = "'.$tahun.'"')
                                                        ->where('SUBSTRING(j.tgl,4,2) = "'.sprintf('%02d', $bulan).'"')
                                                        ->where('LEFT(j.tgl,2) = "'.sprintf('%02d', $i).'"')
                                                        ->get()->row();
                                    ?> 
                                        <?php if ($row_tidak_masuk) { ?>
                                        <th class="alert alert-warning orange"><span><?php echo $row_tidak_masuk->ket_tidak_masuk[0] ?></span></th>
                                        <?php } else { ?>
                                        <th><span>-</span></th>
                                        <?php } ?>
                                    <?php }; endfor; ?>
                                </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                    </div>
                    
                    <h2>Absen Harian</h2>
                    <div class="row">
                      <div class="col-12">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered capitalize">
                            <thead class="table-dark">
                              <th width="5%">No</th>
                              <th width="30%">Nama</th>
                              <th width="20%">Jam Masuk</th>
                              <th width="20%">Jam Pulang</th>
                              <th>IP Address</th>
                            </thead>
                            <tbody class="bg-light">
                              <?php $no = 1;foreach ($absen_hari_ini as $ahi): ?>
                              <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $ahi->nama_pegawai ?></td>
                                <td><?php echo $ahi->jam_masuk ?></td>
                                <td><?php echo $ahi->jam_pulang ?></td>
                                <td><?php echo $ahi->ip_address ?></td>
                              </tr>
                              <?php endforeach ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->