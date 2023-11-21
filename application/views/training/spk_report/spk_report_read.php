

      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <h1>SPK Report</h1>
            </div><!-- /.page-header -->

            <div class="row">
              <div class="col-12 card card-body">
                <!-- PAGE CONTENT BEGINS -->
			        <table class="table">
						<tr><td>Tgl Spk</td><td><?php echo $data->tgl_spk; ?></td></tr>
						<tr><td>No Spk</td><td><?php echo $data->no_spk; ?></td></tr>
						<tr><td>Nama Instansi</td><td><?php echo $data->nama_instansi; ?></td></tr>
						<tr><td>Alamat Instansi</td><td><?php echo $data->alamat_instansi; ?></td></tr>
						<tr><td>Kelurahan Instansi</td><td><?php echo $data->kelurahan_instansi; ?></td></tr>
						<tr><td>Kecamatan Instansi</td><td><?php echo $data->kecamatan_instansi; ?></td></tr>
						<tr><td>Telp Instansi</td><td><?php echo $data->telp_instansi; ?></td></tr>
						<tr><td>Telp 2 Instansi</td><td><?php echo $data->telp2_instansi; ?></td></tr>
						<tr><td>Atas Nama</td><td><?php echo $data->atas_nama; ?></td></tr>
						<tr><td>Alamat Atas Nama</td><td><?php echo $data->alamat_atas_nama; ?></td></tr>
						<tr><td>Keterangan</td><td><?php echo $data->keterangan; ?></td></tr>
						<tr><td>Lokasi</td><td><?php echo $data->lokasi; ?></td></tr>
						<tr><td>Pembayaran</td><td><?php echo $data->pembayaran; ?></td></tr>
						<tr><td>Diskon</td><td><?php echo $data->diskon; ?></td></tr>
						<tr><td>Status</td><td><?php echo $data_status->status; ?></td></tr>
						<tr><td>Prioritas</td><td>
									<?php
									if ($data->prioritas == '0') {
										echo "Belum";
									} else if ($data->prioritas == '1') {
										echo "Bulan Ini";
									} else if ($data->prioritas == '2') {
										echo "Bulan Depan";
									}
									?></td></tr>
					</table>
					<a href="<?php echo site_url('marketing/spk_report/update/'.$data->id.'') ?>" class="btn btn-warning">Edit</a>
					<a href="<?php echo site_url('marketing/spk_report') ?>" class="btn btn-default">Cancel</a>
                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div>
      </div><!-- /.main-content -->