

      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <h1>SPK Report</h1>
            </div><!-- /.page-header -->

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <form action="<?php echo $action; ?>" method="post">
                  <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="varchar">Nama Instansi <?php echo form_error('nama_instansi') ?></label>
                            <input type="text" class="form-control" name="nama_instansi" id="nama_instansi" placeholder="Nama Instansi" value="<?php echo $nama_instansi; ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Lokasi <?php echo form_error('lokasi') ?></label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Lokasi" value="<?php echo $lokasi; ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Alamat Instansi <?php echo form_error('alamat_instansi') ?></label>
                            <input type="text" class="form-control" name="alamat_instansi" id="alamat_instansi" placeholder="Alamat Instansi" value="<?php echo $alamat_instansi; ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Kelurahan Instansi <?php echo form_error('kelurahan_instansi') ?></label>
                            <input type="text" class="form-control" name="kelurahan_instansi" id="kelurahan_instansi" placeholder="Kelurahan Instansi" value="<?php echo $kelurahan_instansi; ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Kecamatan Instansi <?php echo form_error('kecamatan_instansi') ?></label>
                            <input type="text" class="form-control" name="kecamatan_instansi" id="kecamatan_instansi" placeholder="Kecamatan Instansi" value="<?php echo $kecamatan_instansi; ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Telp Instansi <?php echo form_error('telp_instansi') ?></label>
                            <input type="text" class="form-control" name="telp_instansi" id="telp_instansi" placeholder="Telp Instansi" value="<?php echo $telp_instansi; ?>" readonly />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Telp 2 Instansi <?php echo form_error('telp2_instansi') ?></label>
                            <input type="text" class="form-control" name="telp2_instansi" id="telp2_instansi" placeholder="Telp 2 Instansi" value="<?php echo $telp2_instansi; ?>" readonly />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="varchar">Tgl Spk <?php echo form_error('tgl_spk') ?></label>
                            <input type="text" class="form-control" name="tgl_spk" id="datepicker1" placeholder="Tgl Spk" value="<?php echo $tgl_spk; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="varchar">No Spk <?php echo form_error('no_spk') ?></label>
                            <input type="text" class="form-control" name="no_spk" id="no_spk" placeholder="No Spk" value="<?php echo $no_spk; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Pembayaran <?php echo form_error('pembayaran') ?></label>
                            <input type="text" class="form-control" name="pembayaran" id="pembayaran" placeholder="Pembayaran" value="<?php echo $pembayaran; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Diskon <?php echo form_error('diskon') ?></label>
                            <input type="text" class="form-control" name="diskon" id="diskon" placeholder="Diskon" value="<?php echo $diskon; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Keterangan <?php echo form_error('keterangan') ?></label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="<?php echo $keterangan; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Status <?php echo form_error('status') ?></label>
                            <select class="form-control" name="status" id="status" disabled>
                              <?php foreach ($data_pil_status as $key): ?>
                                <?php if ($key->id == $status) { ?>
                                  <option selected value="<?php echo $key->id ?>"><?php echo $key->status ?></option>
                                <?php } else { ?>
                                  <option value="<?php echo $key->id ?>"><?php echo $key->status ?></option>
                                <?php } ?>      
                              <?php endforeach ?>
                            </select>
                            <input type="hidden" name="status" value="<?php echo $status ?>">
                        </div>
                        <input type="hidden" name="prioritas" value="<?php echo $prioritas ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <center>
                            <br>
                          <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                          <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                          <a href="<?php echo site_url('admin/spk_report') ?>" class="btn btn-default">Cancel</a>
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