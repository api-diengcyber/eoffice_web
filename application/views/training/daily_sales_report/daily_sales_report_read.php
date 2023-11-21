

      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <h1>Daily Sales Report</h1>
            </div><!-- /.page-header -->

            <div class="row">
              <div class="col-12 card card-body">
                <!-- PAGE CONTENT BEGINS -->
                <?php foreach ($res as $key): ?>
					<div class="widget-box">
						<div class="widget-header widget-header-flat">
							<h4 class="widget-title smaller"><?php echo $key->nama_instansi; ?> <?php echo $key->telp_instansi; ?></h4>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								<dl id="dt-list-1" class="dl-horizontal">
									<dt>Tgl Kunjungan</dt>
									<dd><?php echo $key->tgl_kunjungan; ?></dd>
									<dt>Nama Instansi</dt>
									<dd><?php echo $key->nama_instansi; ?></dd>
									<dt>Alamat Instansi</dt>
									<dd><?php echo $key->alamat_instansi; ?></dd>
									<dt>Kelurahan Instansi</dt>
									<dd><?php echo $key->kelurahan_instansi; ?></dd>
									<dt>Kecamatan Instansi</dt>
									<dd><?php echo $key->kecamatan_instansi; ?></dd>
									<dt>Telp Instansi</dt>
									<dd><?php echo $key->telp_instansi; ?></dd>
									<dt>Telp2 Instansi</dt>
									<dd><?php echo $key->telp2_instansi; ?></dd>
									<dt>Atas Nama</dt>
									<dd><?php echo $key->atas_nama; ?></dd>
									<dt>Alamat Atas Nama</dt>
									<dd><?php echo $key->alamat_atas_nama; ?></dd>
									<dt>Keterangan</dt>
									<dd><?php echo $key->keterangan; ?></dd>
									<dt>Lokasi</dt>
									<dd><?php echo $key->lokasi; ?></dd>
									<dt>Status</dt>
									<dd><?php echo $key->nm_status; ?></dd>
									<dt>Prioritas</dt>
									<dd>
									<?php
									if ($key->prioritas == '0') {
										echo "Belum";
									} else if ($key->prioritas == '1') {
										echo "Bulan Ini";
									} else if ($key->prioritas == '2') {
										echo "Bulan Depan";
									}
									?>
									</dd>
								</dl>
								<?php 
								$selisih_hari = strtotime($key->tgl_kunjungan) - strtotime(date('d-m-Y'));
								if ($selisih_hari >= 0) {
									echo anchor(site_url('training/daily_sales_report/update/'.$key->id), 'Edit', 'class="btn btn-warning"');
								}
								?>
							</div>
						</div>
					</div>
                	
                <?php endforeach ?>

				<br>
				<center>
				<a href="<?php echo site_url('training/daily_sales_report') ?>" class="btn btn-default">Cancel</a>
				</center>
                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div>
      </div><!-- /.main-content -->