<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		td{
			text-align: left;
		}
	</style>
</head>
<body>
	<table cellpadding="4" style="width:100%;">
		<tr>
			<td width="33.33333333%"><img src="<?php echo base_url().'assets/images/dc.png' ?>" style="width: 350px;"></td>
			<td width="33.33333333%"></td>
			<td width="33.33333333%"><img src="<?php echo base_url().'assets/barcode/'.$no_faktur.'.png' ?>" style="height:80px"></td>
		</tr>
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td><b><?php echo $office_alamat ?></b></td>
			<th><b style="font-size: 25px">INVOICE</b></th>
			<td><b>Kepada : <br><?php echo $kepada_nama ?><br><?php echo $kepada_hp ?><br><?php echo $kepada_alamat ?></b></td>
		</tr>
	</table>
	<br><br><br>
	<img src="<?php echo base_url() ?>assets/images/bg.png">
	<br><br><br>
	<table cellpadding="4" style="width:100%;">
		<tr>
			<td width="50%">
				<div style="text-align:right;">
					<b>Total Biaya(<i>Total Charge</i>)</b>
				</div>
				<br>
				<?php foreach ($data_barang as $key): ?>
				<b><?php echo $key->barang ?></b><br>
				<?php /*Diskon (<i>Discount</i>) : <?php echo $key->diskon ?>%<br>*/ ?>
				(<?php echo $key->jumlah ?>) X (Rp.<?php echo number_format($key->harga,0,',','.') ?>) : <span>Rp.<?php echo number_format($key->total,0,',','.') ?></span>
				<div style="width:100%;border-bottom: 1px dotted grey;margin-bottom: 10px;"></div>
				<br>
				<?php endforeach ?>
				<?php if ($dp > 0) { ?>
				<b>Total</b> : <b><span>Rp.<?php echo number_format($harga,0,',','.') ?></span></b><br>
				<b>DP</b> : <b><span>Rp.<?php echo number_format($dp,0,',','.') ?></span></b><br>
				<b>Total Sisa</b> : <b><span>Rp.<?php echo number_format($harga-$dp,0,',','.') ?></span></b><br>
				<?php } else { ?>
				<b>Total</b> : <b><span>Rp.<?php echo number_format($harga,0,',','.') ?></span></b><br>
				<?php } ?>
			</td>
			<td width="50%">
				<div style="height:280px;border:1px solid black;">
					<div style="text-align:center;"><br>
						<b>PEMBAYARAN KE <br> (<i>Payment To</i>)</b>
						<p>Pembayaran dapat ditransfer ke rekening berikut. (<i>Please transfer your payment to Account Number Below</i>) :</p>
					</div>
					<div style="text-align:left;"><br>
						<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANDIRI</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $office_rek_mandiri ?><br>
						<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BRI</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $office_rek_bri1 ?><br>
						<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BRI</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $office_rek_bri2 ?><br>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<br><br>
	<div style="border:1px solid black;min-height:200px;text-align:left;">
		<br>
		<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KETERANGAN</b>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo str_replace('<br>','<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$ket) ?></p>
	</div>
	<div></div>
	<div></div>
	<center><h3><b><?php echo $office_footer_s ?></b></h3></center>
</body>
</html>