<div class="row">
    <div class="col-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">KPI</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-sm-12 input-group mb-1">
                                <span class="input-group-append">
                                    <i class="fa fa-user bigger-110"></i>
                                </span>
                                <select name="id_pegawai" id="id_pegawai" class="form-control input-lg">
                                    <option value="">Semua Pegawai</option>
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
                        </div>
                    </form>
                    <div style="margin-top:21px;">
                        <canvas id="chart_kpi"></canvas>
                    </div>
                </div>
                <div class="card" style="margin-top:12px;">
                    <div class="card-header">
                        <h2>Laporan performa</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-pegawai-performa">
                            <thead>
                                <th>Nama</th>
                                <th>Penugasan</th>
                                <th>Total jam kerja</th>
                                <th>Rata-rata jam kerja</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $('#datepicker1').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('#datepicker2').datepicker({
        format: 'dd-mm-yyyy'
    });

    var data_pegawai = [];
    var labels = [];

    var data_tugas = <?php echo json_encode($tugas_pegawai) ?>;
    labels = data_tugas['data_tgl'];

    $(document).ready(function() {
        new Chart($('#chart_kpi')[0], {
            type: 'line',
            data: {
                labels: labels,
                datasets: data_tugas['data_tugas_pegawai'].map(function(v) {
                    return {
                        label: v.nama_pegawai,
                        data: v.progress.map(function(v2) {
                            return v2.progress;
                        }),
                        borderColor: v.color,
                        backgroundColor: 'rgba(0,0,0,0)',
                    };
                }),
            },
            options: {
                responsive: true,
            },
        });

        var html = '';
        data_tugas['data_tugas_pegawai'].map(function(v) {
            html += `<tr>
                <td>${v.nama_pegawai}</td>
                <td>${v.average_progress}</td>
                <td>${v.total_jam_kerja}</td>
                <td>${v.average_jam_kerja}</td>
            </tr>`;
        });
        $('.table-pegawai-performa tbody').html(html);
    });
</script>