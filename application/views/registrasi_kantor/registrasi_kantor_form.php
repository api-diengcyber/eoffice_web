<div class="main-content" style="width:100%;">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="row" style="margin-top:50px;">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Permohonan Registrasi Kantor</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $action; ?>" method="post">
                                <div class="form-group">
                                    <label for="varchar">Nama Perusahaan <?php echo form_error('perusahaan') ?></label>
                                    <input type="text" class="form-control" name="perusahaan" id="perusahaan" placeholder="" value="<?php echo $perusahaan; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="varchar">Alamat Perusahaan<?php echo form_error('alamat') ?></label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="" value="<?php echo $alamat; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="varchar">No Telp Perusahaan <?php echo form_error('no_telp_perusahaan') ?></label>
                                    <input type="text" class="form-control" name="no_telp_perusahaan" id="no_telp_perusahaan" placeholder="" value="<?php echo $no_telp_perusahaan; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="varchar">Bidang Bisnis <?php echo form_error('bidang_bisnis') ?></label>
                                    <input type="text" class="form-control" name="bidang_bisnis" id="bidang_bisnis" placeholder="" value="<?php echo $bidang_bisnis; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="varchar">Jumlah Karyawan <?php echo form_error('jml_karyawan') ?></label>
                                    <input type="text" class="form-control" name="jml_karyawan" id="jml_karyawan" placeholder="" value="<?php echo $jml_karyawan; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="varchar">Nama Pemohon <?php echo form_error('nama_pemohon') ?></label>
                                    <input type="text" class="form-control" name="nama_pemohon" id="nama_pemohon" placeholder="" value="<?php echo $nama_pemohon; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="varchar">No Telp Pemohon (WA) <?php echo form_error('no_telp_pemohon') ?></label>
                                    <input type="text" class="form-control" name="no_telp_pemohon" id="no_telp_pemohon" placeholder="" value="<?php echo $no_telp_pemohon; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="varchar">Jabatan Pemohon <?php echo form_error('jabatan_pemohon') ?></label>
                                    <input type="text" class="form-control" name="jabatan_pemohon" id="jabatan_pemohon" placeholder="" value="<?php echo $jabatan_pemohon; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="varchar">Email <?php echo form_error('email') ?></label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?php echo $email; ?>" />
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                <button type="submit" class="btn btn-primary">KIRIM FORMULIR</button>
                                <a href="<?php echo site_url('registrasi_kantor') ?>" class="btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</div>