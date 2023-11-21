<style>
  th,
  td {
    padding: 10px !important;
  }

  #myTable_wrapper {
    padding: 0px !important;
  }

  table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before,
  table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
    top: 2px !important;
  }

  .th-today {
    border-left: 1px solid orange !important;
    border-right: 1px solid orange !important;
  }
</style>
<div class="main-content">
  <div class="main-content-inner">
    <div class="page-content">
      <div class="page-header d-flex justify-content-between">
        <h1>
          Dashboard
        </h1>
        <h2>
          <?=$nama_kantor->nama_kantor?>
        </h2>
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
                        <h3 class="font-weight-medium text-right mb-0"><?php echo $jumlah_pegawai ?></h3>
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
                        <h3 class="font-weight-medium text-right mb-0"><?php echo $jumlah_masuk ?></h3>
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
                      <i class="mdi mdi-email-outline text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Izin Hari Ini</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0"><?php echo $jumlah_izin ?></h3>
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
                      <i class="mdi mdi-email-outline text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">WFH Hari Ini</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0"><?php echo $jumlah_wfh ?></h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics" style="cursor:pointer" onclick="window.location.href='<?php echo base_url('admin/tugas'); ?>'">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-clipboard-check text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Konfirmasi Tugas</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0"><?php echo $jumlah_tugas_pending ?></h3>
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
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered bg-white w-100" id="tablePresensiPeriode">
                  <thead class="table-dark">
                   
                    <th width=""><i class="fa fa-plus-circle" aria-hidden="true"></i></th>
                    <th>Nama</th>
                    <?php for ($i = 1; $i <= $batas_hari_bulan; $i++) : ?>
                      <?php if ($i == $hari) { ?>
                        <th style="background-color: orange;"><?php echo $i ?></th>
                      <?php } else { ?>
                        <th><?php echo $i ?></th>
                      <?php } ?>
                    <?php endfor ?>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table class="table table-bordered capitalize bg-white w-100" id="tablePresensi">
                  <thead class="table-dark">
                    <th width="5%"><i class="fa fa-plus-circle" aria-hidden="true"></i></th>
                    <th width="30%">Nama</th>
                    <th width="20%">Jam Masuk</th>
                    <th width="20%">Lokasi Masuk</th>
                    <th width="20%">Jam Pulang</th>
                    <th width="20%">Lokasi Pulang</th>
                  </thead>
                  <tbody>
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
<script>
  $(document).ready(function() {
    $('[id*=myTable]').DataTable({
      responsive: true,
      paging: false,
      ordering: false,
      info: false,
      searching: false
    });
    getDataAbsensiPeriode(1, 20);

   
    function getDataAbsensiPeriode(page = 1, limit = 20) {
      
      $.ajax({
        url: '<?php echo base_url() ?>api/dashboard/get_presensi',
        type: "POST",
        data: {
          'limit': limit,
          'page': page,
          'date': '<?php echo date('Y-m-d') ?>',
        },
        success: function(response) {
          console.log(response);
          var totalPage = response['data']['total_page'] * 1;
          var data = response['data']['data'];
          var html = '';
          var startNo = (limit * page) - limit;
          for (var i = 0; i < data.length; i++) {
            var item = data[i];
            var no = startNo + i + 1;
            html += `<tr>`;
            html += `
            <th>${no}</th>
            <th><style:data-toggle='tooltip' data-placement='right' title='${item['asal']}'> ${item['nama_pegawai']}</style><br><font size='1'>${item['asal']}</font>
              <a href='https://wa.me/${item['phone_wa']}'><i class="fa fa-whatsapp" aria-hidden="true"></i></a></th>`;
            for (var i2 = 0; i2 < item['dates'].length; i2++) {
              var val = item['dates'][i2];
              if (val['status'] != null) {
                html += `<th class="bg-success ${val['today'] == 1 ? 'th-today' : ''}">
                ${ val['status'] == '2' ? "<b style='color:yellow'>P</b>" : "<b style='color:white'>M</b>" }
                </th>`;
              } else {
                html += `<th class="${val['today'] == 1 ? 'th-today' : ''}">-</th>`;
              }
            }
            html += `</tr>`;
          }
          if (page > 1) {
            $("#tablePresensiPeriode tbody").append(html);
          } else {
            $("#tablePresensiPeriode tbody").html(html);
          }
          if (page < totalPage) {
            getDataAbsensiPeriode(page + 1, 20);
          }
        }
      });
    }
    getDataAbsensi(1, 20);

    function getDataAbsensi(page = 1, limit = 20) {
      $.ajax({
        url: '<?php echo base_url() ?>api/dashboard/get_presensi_list_by_date',
        type: "POST",
        data: {
          'limit': limit,
          'page': page,
          'date': '<?php echo date('Y-m-d') ?>',
        },
        success: function(response) {
          var totalPage = response['data']['total_page'] * 1;
          var data = response['data']['data'];
          var html = '';
          var startNo = (limit * page) - limit;
          for (var i = 0; i < data.length; i++) {
            var item = data[i];
            var no = startNo + i + 1;
            html += `<tr>`;
            html += `
            <th>${no}</th>
            <th>${item['nama_pegawai']}</th>
            <th>${item['jam_masuk']}</th>
            <th>${item['lokasi_masuk']}</th>
            <th>${item['jam_pulang']}</th>
            <th>${item['lokasi_pulang']}</th>
            `;
            html += `</tr>`;
          }
          if (page > 1) {
            $("#tablePresensi tbody").append(html);
          } else {
            $("#tablePresensi tbody").html(html);
          }
          if (page < totalPage) {
            getDataAbsensi(page + 1, 20);
          }
        }
      });
    }
  });
</script>