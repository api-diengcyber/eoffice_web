<link rel="stylesheet" href="<?php echo base_url('assets/clockpicker/jquery-clockpicker.min.css') ?>">

<div class="row">
    <div class="col-12">
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Jadwal monitor</h2>
            </div>
            <div class="col-md-4 text-center">
                <!-- <div style="margin-top: 4px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div> -->
            </div>
        </div>
        <div class="card card-body">
            <form action="<?php echo $url ?>" method="post">
                <div id="listJadwal"></div>
                <div class="row" style="margin-top: 32px;margin-bottom: 24px;">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Simpan jadwal</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->

<script src="<?php echo base_url('assets/clockpicker/jquery-clockpicker.min.js') ?>"></script>

<script>
    $(document).ready(function() {

        let id = 0;
        var iJadwal = 0;
        var datas = <?php echo json_encode($data_jadwal) ?>;

        console.log(datas);

        function generateJadwal() {
            iJadwal++;

            var dt = null;
            datas.map(function(e) {
                if (e.indeks == iJadwal) {
                    dt = e;
                   
                }
            });
            if(dt!=null){
                id = dt.id;
                // console.log("isi" +id);
            }else{
                id=0;
                // console.log("kosong");
            }
             console.log(dt.created_date);

            var html = `
                <div class="row" style="margin-bottom:12px;">
                        <div class="col-md-1">
                            <div style="margin-top:5px;">
                                ${iJadwal}.
                                <input type="hidden" name="id[]" value="${id}" />
                                <input type="hidden" name="indeks[]" value="${iJadwal}" />
                                ${ dt!=null ? (dt['status']=="1" ? '<i class="fa fa-check-circle" style="color:green;"></i>' : '<i class="fa fa-remove" style="color:red;"></i>') : '' }
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control jam" name="jam[]" value="${dt!=null ? dt['jam'] : ""}" placeholder="Jam" autocomplete="off" />
                        </div>
                        <div class="col-md-3 text-center">
                            <select name="status[]" class="form-control">
                                <option value="">- Status -</option>
                                <option value="1" ${dt!=null ? (dt['status']=="1" ? "selected" : "") : ""}>Aktif</option>
                                <option value="2" ${dt!=null ? (dt['status']=="2" ? "selected" : "") : ""}>Non-aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-center">
                            <div style="margin-top:8px;font-size:12px;">
                            ${dt!=null ? (dt['updated_date']!=null ? dt['updated_date'] : dt.created_date) : ""}
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div style="margin-top:8px;font-size:12px;">
                            Ke: Semua perangkat
                            </div>
                        </div>
                    </div>`;
            $("#listJadwal").append(html);
            $('.jam').clockpicker({
                placement: 'bottom',
                align: 'left',
                autoclose: true,
                'default': 'now'
            });
        }

        for (let i = 0; i < 4; i++) {
            generateJadwal();
        }
    });
</script>