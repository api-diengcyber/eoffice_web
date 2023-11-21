
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Presensi
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div class="row" style="margin-bottom: 10px">
                        <form action="" method="post" class="col-12">
                            <div class="form-group ">
                                <div class="col-sm-8 input-group">
                                    <span class="input-group-append">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <select class="form-control input-lg" name="tahun" id="tahun" onchange="this.form.submit()">
                                      <?php foreach ($data_tahun as $key): ?>
                                        <?php if ($key->tahun == $tahun) { ?>
                                          <option selected value="<?php echo $key->tahun ?>"><?php echo $key->tahun ?></option>
                                        <?php } else { ?>
                                          <option value="<?php echo $key->tahun ?>"><?php echo $key->tahun ?></option>
                                        <?php } ?>
                                      <?php endforeach ?>
                                    </select>
                                    <span class="input-group-append">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                    <select class="form-control input-lg" name="bulan" id="bulan" onchange="this.form.submit()">
                                      <?php foreach ($data_bulan as $key): ?>
                                        <?php if ($key->id == $bulan) { ?>
                                          <option selected value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                        <?php } else { ?>
                                          <option value="<?php echo $key->id ?>"><?php echo $key->bulan ?></option>
                                        <?php } ?>
                                      <?php endforeach ?>
                                    </select>
                                    <button type="submit" name="proses" value="1" class="form-control btn btn-success btn-lg input-lg" style="width:200px">PROSES</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <table border="1" class="table table-striped table-dark table-bordered">
                                        <tr>
                                            <th>Nama</th>
                                            <?php for ($i=1; $i <= $batas_hari_bulan; $i++) : ?>
                                            <?php if ($i == $hari) { ?>
                                            <th style="background-color: #FF9800;"><?php echo $i ?></th>
                                            <?php } else { ?>
                                            <th><?php echo $i ?></th>
                                            <?php } ?>
                                            <?php endfor; ?>
                                        </tr>
                                        <?php foreach ($data_pegawai_kerja as $key): ?>
                                        <tr>
                                            <td><?php echo $key->nama_pegawai ?></td>
                                            <?php 
                                            for ($i=1; $i <= $batas_hari_bulan; $i++) : 
                                                $row_absen = $this->db->select('j.*')
                                                                ->from('jam_kerja AS j')
                                                                ->where('j.id_users', $key->id_users)
                                                                ->where('SUBSTRING(j.tgl,7,4) = "'.$tahun.'"')
                                                                ->where('SUBSTRING(j.tgl,4,2) = "'.sprintf('%02d', $bulan).'"')
                                                                ->where('LEFT(j.tgl,2) = "'.sprintf('%02d', $i).'"')
                                                                ->get()->row();
                                                                //print_r($row_absen);
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
                                                                ->where('SUBSTRING(j.tgl,7,4) = "'.$tahun.'"')
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
                        </div>
                    </div>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->