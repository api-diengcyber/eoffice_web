<link rel="stylesheet" href="<?php echo base_url('assets/magn/magnific-popup.css') ?>">
<script src="<?php echo base_url('assets/magn/jquery.magnific-popup.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('.img').magnificPopup({
            type: 'image'
        });
    });
</script>
<div class="row">
    <div class="col-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Laporan Harian </h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>
        <form action="" method="post">
            <div class="row" style="margin-bottom: 10px">
                <div class="col-sm-8 input-group mb-1">
                    <span class="input-group-append">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    <select class="form-control input-lg" name="tahun" id="tahun" onchange="this.form.submit()">
                        <option value="">Pilih Tahun</option>
                        <?php foreach ($data_tahun as $key) : ?>
                            <option value="<?php echo $key->tahun ?>" <?php if ($key->tahun == $tahun) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $key->tahun ?></option>
                        <?php endforeach ?>
                    </select>
                    <span class="input-group-append">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    <select class="form-control input-lg" name="bulan" id="bulan" onchange="this.form.submit()">
                        <option value="">Pilih Bulan</option>
                        <?php foreach ($data_bulan as $key) : ?>
                            <option value="<?php echo $key->id ?>" <?php if ($key->id == $bulan) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $key->bulan ?></option> <?php endforeach ?>
                    </select>
                    <select class="form-control input-lg" name="hari" id="hari" onchange="this.form.submit()">
                        <option value="SEMUA">Semua Hari</option>
                        <?php
                        for ($i = 1; $i <= date('t'); $i++) {
                            if ($i == $hari) {
                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                            } else {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <?php
                    if ($id_pegawai != '') {
                        $id_pegawai = $id_pegawai;
                    } else {
                        $id_pegawai = 'SEMUA';
                    }
                    ?>
                    <a href="<?php echo base_url('admin/tugas/export_harian/' . $id_pegawai . '/' . $tahun . '/' . $bulan . '/' . $hari) ?>" class="btn btn-primary pull-right"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                </div>
            </div>
        </form>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped capitalize" id="myTable">
                            <thead class="table-dark" style="border:solid 1px #212529">
                                <tr>
                                    <th width="150px" rowspan="3" style="vertical-align:middle">Nama</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;border: 1px solid #212529" colspan="2" class="mb-d-none">Laporan</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center;background-color:#CDDC39" width="50%">Pagi</th>
                                    <th style="text-align:center;background-color:#897b14;" width="50%">Siang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($laporan as $l) : ?>
                                    <tr>
                                        <td><?php echo $l->nama ?></td>
                                        <td>
                                            <ul class="mlist">
                                                <?php if (!empty($l->laporan_pagi[0]->tgl)) { ?>
                                                    <?php foreach ($l->laporan_pagi as $lp) : ?>
                                                        <li>
                                                            <span>Keterangan : </span> <br>
                                                            <?php echo ($lp->ket) ? $lp->ket : 'Tidak ada keterangan'; ?> <br>
                                                            <a href="<?php echo base_url('assets/tugas/upload/') . $lp->file ?>" class="badge badge-primary img"><i class="fa fa-eye"></i> Lihat</a>
                                                        </li>
                                                    <?php endforeach ?>
                                                <?php } else { ?>
                                                    Belum upload tugas
                                                <?php } ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="mlist">
                                                <?php if (!empty($l->laporan_siang[0]->tgl)) { ?>
                                                    <?php foreach ($l->laporan_siang as $ls) : ?>
                                                        <li>
                                                            <span>Keterangan : </span> <br>
                                                            <?php echo ($ls->ket) ? $ls->ket : 'Tidak ada keterangan'; ?> <br>
                                                            <a href="<?php echo base_url('assets/tugas/upload/') . $ls->file ?>" class="badge badge-primary img"><i class="fa fa-eye"></i> Lihat</a>
                                                        </li>
                                                    <?php endforeach ?>
                                                <?php } else { ?>
                                                    Belum upload tugas
                                                <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true,
        });
    });
</script>