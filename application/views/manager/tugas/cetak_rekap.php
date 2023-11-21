		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
		</head>
		<style>
			.p-1 {
				padding: 1rem;
			}
			.p-2 {
				padding: 2rem;
			}
			.p-0{
				padding: 0rem;
			}
		</style>
		<body onload="window.print()">
			<div class="table-responsive" >
				<table class="table table-dark table-hover table-bordered" style="width:100%;border-collapse:collapse" border="1">
					<thead>
						<th>No</th>
						<th>Nama Pegawai</th>
						<th>Rekap Tugas</th>
					</thead>
					<tbody>
						<?php $i = 1;foreach ($data_tugas as $dt): ?>
						<tr>
							<td width="50px" style="text-align:center"><?php echo $i ?></td>
							<td width="150px" style="text-align:center"><?php echo $dt->nama_pegawai ?></td>
							<td style="padding:0px!important">
								<table class="w-100" style="width:100%;border-collapse:collapse;border:0px" border="1">
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
													border-bottom: solid 1px black;
												}
												.list-task > li:last-child{
													border-bottom: 0px!important;
												}
											</style>
											<ul class="list-task">
											<?php $i = 1;foreach ($rt->data_tugas as $dr): ?>
												<li class="p-1">
												<?php 
													echo $i.'. '.$dr->tugas;
													if(!empty($dr->project)){
														echo '<br>'.'<label class="badge badge-primary">'.$dr->project.'</label>';
													}
												?>
													<ul>
														<li>Progress : <?php echo $dr->progress ?> %</li>
														<li>Status   : 
															<?php 
																if($dr->selesai == 0){
																	echo '<label class="badge badge-danger">Belum selesai</a>';
																}else{
																	echo '<label class="badge badge-primary">Selesai</a>';
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
									<i class="p-2">Belum ada tugas</i>
								<?php } ?>
								</table>
							</td>
						</tr>
						<?php $i++;endforeach ?>
					</tbody>
				</table>
</body>
		</html>