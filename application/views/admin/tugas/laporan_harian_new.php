<link rel="stylesheet" href="<?php echo base_url('assets/magn/magnific-popup.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>">
<style>
    * {
        word-wrap: break-word;
    }

    li {
        white-space: normal;
        max-width: 400px;
    }

    @media print {
        .navbar {
            display: none !important;
        }

        .sidebar {
            display: none !important;
        }

        .footer {
            display: none;
        }

        * {
            background-color: white !important;
            color: black !important;
        }

        .no-print {
            display: none;
        }

        * {
            padding: 0px;
        }

        .card-body {
            padding: 0px !important;
        }

        .page-body-wrapper:not(.auth-page) {
            padding-top: 0px !important;
        }
    }
</style>
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
                <h2 style="margin-top:0px">Laporan Harian</h2>
            </div>
            <div class="col-md-4 text-center">
                <!-- <div style="margin-top: 4px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div> -->
            </div>
        </div>
        <form action="" method="post">
            <div class="row no-print" style="margin-bottom: 10px">
                <div class="col-sm-7 input-group mb-1">
                    <span class="input-group-append">
                        <i class="fa fa-user bigger-110"></i>
                    </span>
                    <select name="id_pegawai" id="id_pegawai" class="form-control input-lg" onchange="this.form.submit()">
                        <option value="SEMUA">Semua Pegawai</option>
                        <?php foreach ($data_pegawai as $dp) : ?>
                            <option value="<?php echo $dp->id ?>" <?php if ($dp->id == $id_pegawai) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $dp->nama_pegawai ?></option>
                        <?php endforeach ?>
                    </select>
                    <span class="input-group-append">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    <input type="text" class="form-control" name="start" id="datepicker1" value="<?php echo $start ?>" autocomplete="off">
                    <span class="input-group-append">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    <input type="text" class="form-control" name="end" id="datepicker2" value="<?php echo $end ?>" autocomplete="off">
                    <span class="input-group-append">
                        <i class="fa fa-calendar bigger-110"></i>
                    </span>
                    <button type="submit" class="btn btn-default">Proses</button>
                </div>
                <div class="col-sm-5">
                    <?php
                    if ($id_pegawai != '') {
                        $id_pegawai = $id_pegawai;
                    } else if (empty($id_pegawai)) {
                        $id_pegawai = 'SEMUA';
                    }
                    ?>
                    <div class="pull-right">
                        <a href="<?php echo base_url('admin/tugas/prints2/') ?><?php echo $id_pegawai ?>/<?php echo $start ?>/<?php echo $end ?>" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Print</a>
                        <!-- <a href="<?php echo base_url('admin/tugas/export_harian/') ?><?php echo $id_pegawai ?>/<?php echo $start ?>/<?php echo $end ?>" class="btn btn-primary no-print"><i class="fa fa-file-excel-o"></i> Export Excel</a> -->
                        <a target="_blank" href="<?php echo base_url('admin/tugas/galeri/') ?><?php echo $id_pegawai ?>/<?php echo $start ?>/<?php echo $end ?>" class="btn btn-warning no-print"><i class="fa fa-image"></i> Galeri laporan</a>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped capitalize print" id="myTable">
                            <thead class="table-dark" style="border:solid 1px #212529">
                                <tr>
                                    <th width="150px" rowspan="3" style="vertical-align:middle">Nama</th>
                                    <th rowspan="3">Tanggal</th>
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
                                <?php
                                foreach ($laporan as $l) : ?>
                                    <?php
                                        $totalChld = count($l->laporan);
                                        if ($totalChld > 1) {
                                            ?>
                                        <tr>
                                            <td width="200px" rowspan="<?php echo $totalChld; ?>"><?php echo $l->nama ?></td>
                                            <?php $r = 0;
                                                    foreach ($l->laporan as $lap) {
                                                        $r++; ?>
                                                <?php if ($r > 1) {
                                                                echo "</hr>";
                                                            } ?>
                                                <td><?php echo $lap->tgl; ?></td>
                                                <td>
                                                    <ul class="mlist">
                                                        <?php if (!empty($lap->pagi[0]->tgl)) { ?>
                                                            <?php foreach ($lap->pagi as $lp) : ?>
                                                                <li>
                                                                    <span>Tugas &nbsp;&nbsp;: <?php echo $lp->judul; ?></span><br>
                                                                    <span>Keterangan : </span> <br>
                                                                    <?php echo ($lp->ket) ? $lp->ket : 'Tidak ada keterangan'; ?> <br>
                                                                    <a href="<?php echo base_url('assets/tugas/upload/') . $lp->file ?>" class="no-print badge badge-primary img"><i class="fa fa-eye"></i> Lihat</a>
                                                                </li>
                                                            <?php endforeach ?>
                                                        <?php } else { ?>
                                                            Belum upload tugas
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="mlist">
                                                        <?php if (!empty($lap->siang[0]->tgl)) { ?>
                                                            <?php foreach ($lap->siang as $ls) : ?>
                                                                <li>
                                                                    <span>Tugas &nbsp;&nbsp;: <?php echo $ls->judul; ?></span><br>
                                                                    <span>Keterangan : </span> <br>
                                                                    <?php echo ($ls->ket) ? $ls->ket : 'Tidak ada keterangan'; ?> <br>
                                                                    <a href="<?php echo base_url('assets/tugas/upload/') . $ls->file ?>" class="no-print badge badge-primary img"><i class="fa fa-eye"></i> Lihat</a>
                                                                </li>
                                                            <?php endforeach ?>
                                                        <?php } else { ?>
                                                            Belum upload tugas
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td><?php echo $l->nama ?></td>
                                        <?php
                                                if (!empty($l->laporan)) {
                                                    foreach ($l->laporan as $lap) { ?>
                                                <td><?php echo $lap->tgl; ?></td>
                                                <td>
                                                    <ul class="mlist">
                                                        <?php if (!empty($lap->pagi[0]->tgl)) { ?>
                                                            <?php foreach ($lap->pagi as $lp) : ?>
                                                                <li>
                                                                    <span>Tugas &nbsp;&nbsp;: <?php echo $lp->judul; ?></span><br>
                                                                    <span>Keterangan : </span> <br>
                                                                    <?php echo ($lp->ket) ? $lp->ket : 'Tidak ada keterangan'; ?> <br>
                                                                    <a href="<?php echo base_url('assets/tugas/upload/') . $lp->file ?>" class="no-print badge badge-primary img"><i class="fa fa-eye"></i> Lihat</a>
                                                                </li>
                                                            <?php endforeach ?>
                                                        <?php } else { ?>
                                                            Belum upload tugas
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="mlist">
                                                        <?php if (!empty($lap->siang[0]->tgl)) { ?>
                                                            <?php foreach ($lap->siang as $ls) : ?>
                                                                <li>
                                                                    <span>Tugas &nbsp;&nbsp;: <?php echo $ls->judul; ?></span><br>
                                                                    <span>Keterangan : </span> <br>
                                                                    <?php echo ($ls->ket) ? $ls->ket : 'Tidak ada keterangan'; ?> <br>
                                                                    <a href="<?php echo base_url('assets/tugas/upload/') . $ls->file ?>" class="no-print badge badge-primary img"><i class="fa fa-eye"></i> Lihat</a>
                                                                </li>
                                                            <?php endforeach ?>
                                                        <?php } else { ?>
                                                            Belum upload tugas
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                            <?php }
                                                    } else { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#datepicker1').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('#datepicker2').datepicker({
        format: 'dd-mm-yyyy'
    });
</script>