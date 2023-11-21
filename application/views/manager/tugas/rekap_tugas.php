<div class="row">
	<div class="col-12">
			<div class="row">
				<div class="col-md-8">
					<form action="" method="post">
                        <div class="form-group ">
                            <div class="col-sm-12 input-group">
                                <span class="input-group-append">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                                <select class="form-control input-lg" name="tahun" id="tahun" onchange="this.form.submit()">
                                  <option value="">Pilih Tahun</option>
                                  <?php foreach ($data_tahun as $key): ?>
                                      <option value="<?php echo $key->tahun ?>" <?php if($key->tahun == $tahun){ echo 'selected'; } ?>><?php echo $key->tahun ?></option>
                                  <?php endforeach ?>
                                </select>
                                <span class="input-group-append">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                                <select class="form-control input-lg" name="bulan" id="bulan" onchange="this.form.submit()">
                                  <option value="">Pilih Bulan</option>
                                  <?php foreach ($data_bulan as $key): ?>
                                      <option value="<?php echo $key->id ?>" <?php if($key->id == $bulan){ echo 'selected'; } ?>><?php echo $key->bulan ?></option>                                  <?php endforeach ?>
                                </select>
                                <select class="form-control input-lg" name="hari" id="hari" onchange="this.form.submit()">
                                	<option value="">Semua Hari</option>
                                	<?php if(!empty($data_hari)){
                                		for ($i=1; $i < $data_hari->hari_kerja; $i++) {
                                			if($i == $hari){
                                				echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                			}else{
                                				echo '<option value="'.$i.'">'.$i.'</option>';
                                			}
                                		}
                                	} ?>
                                </select>
                                <select name="id_pegawai" id="id_pegawai" class="form-control input-lg" onchange="this.form.submit()">
                                	<option value="">Semua Pegawai</option>
                                	<?php foreach ($data_pegawai as $dp): ?>
                                	<option value="<?php echo $dp->id ?>" <?php if($dp->id == $id_pegawai){ echo 'selected'; } ?>><?php echo $dp->nama_pegawai ?></option>
                                	<?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </form>
				</div>
				<div class="col-md-4">
					<?php 
						if(!empty($message)){
							echo '<div class="alert alert-primary">'.$message.'</div>';
						}
					?>
					<a href="<?php echo base_url('admin/tugas/cetak_rekap/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$id_pegawai) ?>" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Cetak Rekap</a>
				</div>
			</div>
			<div class="table-responsive capitalize">
				<table class="table table-light table-bordered">
					<thead class="table-dark">
						<th>No</th>
						<th>Nama Pegawai</th>
						<th>Rekap Tugas</th>
					</thead>
					<tbody>
						<?php $i = 1;foreach ($data_tugas as $dt): ?>
						<tr>
							<td width="50px"><?php echo $i ?></td>
							<td width="150px"><?php echo $dt->nama_pegawai ?></td>
							<td style="padding:0px!important">
								<table class="w-100">
								<?php 
								if(!empty($dt->data_tugas)){
								foreach ($dt->data_tugas as $rt)://rekap tugas ?>
									<tr>
										<th class="p-1 pl-3" style="width:150px">Tugas <br>
											<label for="" style="vertical-align:top" class="badge badge-success mt-1"><?php echo $rt->tgl ?></label>
										</th>
										<td class="p-0">
											<style>
												.list-task {
													list-style: none;
													padding-left: 0px;
												}
												.list-task > li {
													border-bottom: solid 1px #32383e;
												}
												.list-task > li:last-child{
													border-bottom: 0px!important;
												}
											</style>
											<ul class="list-task">
											<?php $i = 1;foreach ($rt->data_tugas as $dr): ?>
												<li class="p-1">
												<?php 
													echo $i.'. '.$dr->judul;
													if(!empty($dr->project)){
														echo '<br>'.'<label class="badge badge-primary">'.$dr->project.'</label>';
													}
												?>
													<ul>
														<li>Progress : <?php echo $dr->progress ?> %</li>
														<li>Status   : 
															<?php 
																if($dr->selesai == 0){
																	echo 'Belum selesai';
																}else{
																	echo 'Selesai';
																}
															?>
														</li>
													</ul>
												</li>
											<?php $i++;endforeach ?>
											</ul>
										</td>
									</tr>
								<?php endforeach;
								} else { ?>
									<span class="p-2">Belum ada tugas</span>
								<?php } ?>
								</table>
							</td>
						</tr>
						<?php $i++;endforeach ?>
					</tbody>
				</table>
			</div>
	</div>
</div>