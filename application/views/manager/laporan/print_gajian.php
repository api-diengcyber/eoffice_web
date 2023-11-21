<style>
	* {
		font-size: 12px!important;
	}
	table {
		width: 100%;
		border-collapse: collapse;
	}
	table th,td {
		padding:3px;
		text-align: left!important;
	}
</style>
<?php foreach ($gajian_pegawai as $index => $value): ?>
<?php foreach ($value as $c): ?>
<strong style="text-transform:uppercase">SLIP GAJI <?php echo $c['nama_pegawai'] ?></strong><br><br>
<table border="1" style="margin-bottom:30px">
	<tr>
		<th width="25%">Bulan</th>
		<td>
		<?php 
			$this->db->where('id = left("'.$c['bulan_tahun'].'",2)*1');
			$bulan = $this->db->get('bulan')->row()->bulan;
			echo $bulan + date('Y');
		?>
		</td>
		<td>Hari Aktif</td>
		<td><?php echo $c['hari_aktif'] ?></td>
		<td>Tidak Masuk</td>
		<td><?php if($c['tidak_masuk'] > 0){ echo $c['tidak_masuk']; } ?></td>
	</tr>
	<tr>
		<th width="25%">Jabatan</th>
		<td><?php echo $c['jabatan'] ?></td>
		<td>Masuk</td>
		<td><?php echo $c['masuk'] ?></td>
		<td>Potongan Absen</td>
		<td>Rp. <span style="float:right"><?php echo number_format($c['potongan_absen'],0,',','.'); ?></span></td>
	</tr>
	<tr>
		<th width="25%">Gaji Pokok</th>
		<td>Rp. <span style="float:right"><?php echo number_format($c['gaji_pokok'],0,',','.'); ?></span></td>
		<td>Transport</td>
		<td>Rp. <span style="float:right">100.000</span></td>
		<td>Tunj.Kesehatan</td>
		<td>Rp. <span style="float:right">50.000</span></td>
	</tr>
	<tr>
		<th width="25%">Bonus Gaji</th>
		<td><?php echo number_format($c['bonus_gaji'],0,',','.'); ?></td>
		<td>Keterangan</td>
		<td colspan="3">
			Potongan absen: gaji pokok : hari aktif * tdk masuk + potongan telat
			<?php
				if(!empty($c['bonus_gaji'])){
					echo '<br> Bonus Gaji : '.$c['keterangan_bonus'];
				}
			?>
		</td>
	</tr>
	<tr>
		<th>Potongan Transport</th>
		<td>Rp. <span style="float:right">100.000</span></td>
		<td>Keterangan</td>
		<td colspan="3">Transport di bayar mingguan</td>
	</tr>
	<?php foreach ($c['data_potongan'] as $p):
	?>
	<tr>
		<th>Potongan <?php echo $p->nama_potongan ?></th>
		<td>Rp. <span style="float:right"><?php echo number_format($p->nominal,0,',','.'); ?></span></td>
		<td>Keterangan</td>
		<td colspan="3"><?php echo $p->keterangan ?></td>
	</tr>
	<?php endforeach ?>
	<?php foreach ($c['data_tunjangan'] as $p):
	?>
	<tr>
		<th>Tunjangan <?php echo $p->nama_tunjangan ?></th>
		<td>Rp. <span style="float:right"><?php echo number_format($p->nominal,0,',','.'); ?></span></td>
		<td>Keterangan</td>
		<td colspan="3"><?php echo $p->keterangan ?></td>
	</tr>
	<?php endforeach ?>
	<tr>
		<th><strong>TOTAL GAJI KOTOR</strong></th>
		<td><strong>Rp. <span style="float:right"><?php echo number_format($c['gaji_kotor'],0,',','.'); ?></span></strong></td>
		<td colspan="2"><strong>TOTAL GAJI DITERIMA</strong></td>
		<td colspan="2"><strong>Rp. <span style="float:right"><?php echo number_format($c['gaji_bersih'],0,',','.'); ?></span></strong></td>
	</tr>
</table>
<?php endforeach ?>
<?php endforeach ?>
<script>
	//window.print();
</script>