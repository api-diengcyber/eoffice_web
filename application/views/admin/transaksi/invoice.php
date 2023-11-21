<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body {
			background-color: white;
			color:black;
		}
		* {
		    box-sizing: border-box;
		}
		.header {
		    border: 1px solid blue;
		    padding: 15px;
		}


		/* 
		  memberikan ukuran pada 
		  masing-masing kolom grid 
		*/
		.col-1 {
			width: 8.33%;
			float: left;
		    padding: 15px;
		}
		.col-2 {
			width: 16.66%;
			float: left;
		    padding: 15px;
		}
		.col-3 {
			width: 25%;
			float: left;
		    padding: 15px;
		}
		.col-4 {
			width: 33.33%;
			float: left;
		    padding: 15px;
		}
		.col-5 {
			width: 41.66%;
			float: left;
		    padding: 15px;
		}
		.col-6 {
			width: 50%;
			float: left;
		    padding: 15px;
		}
		.col-7 {
			width: 58.33%;
			float: left;
		    padding: 15px;
		}
		.col-8 {
			width: 66.66%;
			float: left;
		    padding: 15px;
		}
		.col-9 {
			width: 75%;
			float: left;
		    padding: 15px;
		}
		.col-10 {
			width: 83.33%;
			float: left;
		    padding: 15px;
		}
		.col-11 {
			width: 91.66%;
			float: left;
		    padding: 15px;
		}
		.col-12 {
			width: 100%;
			float: left;
		    padding: 15px;
		}
		/* custom css */
		.row {
		}
		.list > li {
			list-style: none;
		}
		.li > li {
			margin-bottom: 10px;
		}
		.pull-right{
			float: right;
		}
		.box {
			border : 1px solid black;
			padding:20px;
		}
		.invoice {
			margin-top:100px;
		}

		/* 
		  membuat grid menjadi tersusun kebawah
		  ketika lebar layar kurang dari 700px 
		*/
		@media screen and (max-width: 700px) {
			body {
				background-color: #e0ffbe;
			}
			* {
				height:auto!important;
			}
			.clearfix {
				clear:left;
			}
			.invoice {
				margin-top: none;
			}
			.col-1 {
				width: 8.33%;
		        display:block;
		        width:100%
			}
			.col-2 {
				width: 16.66%;
		        display:block;
		        width:100%
			}
			.col-3 {
				width: 25%;
		        display:block;
		        width:100%
			}
			.col-4 {
				width: 33.33%;
		        display:block;
		        width:100%;
			}
			.col-5 {
				width: 41.66%;
		        display:block;
		        width:100%
			}
			.col-6 {
				width: 50%;
		        display:block;
		        width:100%
			}
			.col-7 {
				width: 58.33%;
		        display:block;
		        width:100%
			}
			.col-8 {
				width: 66.66%;
		        display:block;
		        width:100%
			}
			.col-9 {
				width: 75%;
		        display:block;
		        width:100%
			}
			.col-10 {
				width: 83.33%;
		        display:block;
		        width:100%
			}
			.col-11 {
				width: 91.66%;
		        display:block;
		        width:100%
			}
			.col-12 {
				width: 100%;
		        display:block;
		        width:100%
			}
			.col-sm-6 {
				width: 50%!important;
		        display:block;
		        float:left!important;
			}
			.col-sm-8 {
				width: 66.66%!important;
		        display:block;
		        float:left!important;
			}
			.tengah {
				margin-left:-100px;
			}
			.head {
				background-color:green;
				color:white;
			}
			.container {
				padding: 0px;
			}
			.ls {
				margin-left:-30px;
			}
			.ls > li {
				font-size: 12px
			}
		}

		@page {
		  size: A4;
		  margin: 0;
		}
		@media print {
		  html, body {
		    width: 210mm;
		    height: 297mm;
		  }
		}
	</style>
</head>
<body onload="<?php echo $onload ?>">
	<div class="container">
		<header>
			<div class="row">
				<div class="clearfix col-4 head" style="height: 250px">
					<ul class="list" style="margin-left:0px;padding-left:0px;">
						<li style=""><img src="<?php echo base_url().'assets/images/dc.png' ?>" style="width: 350px;"></li>
						<li><br><b><?php echo $office_alamat ?></b></li>
					</ul>
				</div>
				<div class="col-4" style="height:250px"><center class="invoice"><br><b style="font-size: 25px">INVOICE</b></center></div>
				<div class="col-4" style="height: 250px">
					<ul class="list" style="margin-left:0px;padding-left:0px;">
						<li class="tengah"><img src="<?php echo base_url() ?>assets/barcode/<?php echo $no_faktur ?>.png" style="height:80px"></li><br>
						<li><b>Kepada : <br><?php echo $kepada_nama ?><br><?php echo $kepada_hp ?><br><?php echo $kepada_alamat ?></b></li>
					</ul>
				</div>
			</div>
		</header>
			<div class="row">
				<img src="<?php echo base_url()?>assets/images/bg.jpg" style="width:100%;" alt="">
			</div>
			<div class="row">
				<div class="clearfix col-7" style="height:280px">
					<div class="pull-right">
						<b>Total Biaya(<i>Total Charge</i>)</b>
					</div>
					<br>
					<ul class="list li" style="margin-left:0px;padding-left:0px;">
						<?php foreach ($data_barang as $key): ?>
						<li><b><?php echo $key->barang ?></b></li>
						<?php /*
						<li>Diskon (<i>Discount</i>) : <?php echo $key->diskon ?>%</li>
						*/ ?>
						<li>(<?php echo $key->jumlah ?>) X (Rp.<?php echo number_format($key->harga,0,',','.') ?>) : <span class="pull-right">Rp.<?php echo number_format($key->total,0,',','.') ?></span></li>
						<div style="width:100%;border-bottom: 1px dotted grey;margin-bottom: 10px;"></div>
						<?php endforeach ?>
						<?php if ($dp > 0) { ?>
						<li><b>Total</b> : <b><span class="pull-right">Rp.<?php echo number_format($harga,0,',','.') ?></span></b></li>
						<li><b>DP</b> : <b><span class="pull-right">Rp.<?php echo number_format($dp,0,',','.') ?></span></b></li>
						<li><b>Total Sisa</b> : <b><span class="pull-right">Rp.<?php echo number_format($harga-$dp,0,',','.') ?></span></b></li>
						<?php } else { ?>
						<li><b>Total</b> : <b><span class="pull-right">Rp.<?php echo number_format($harga,0,',','.') ?></span></b></li>
						<?php } ?>
					</ul>
				</div>
				<div class="clearfix col-5">
					<div class="box" style="height:280px">
						<center><b>PEMBAYARAN KE <br> (<i>Payment To</i>)</b></center>
						<p>Pembayaran dapat ditransfer ke rekening berikut. (<i>Please transfer your payment to Account Number Below</i>) :</p>
						<div>
							<li style="list-style: none;"><b>MANDIRI</b><br><?php echo $office_rek_mandiri ?></li>
							<li style="list-style: none;"><b>BRI</b><br><?php echo $office_rek_bri1 ?></li>
							<li style="list-style: none;"><b>BRI</b><br><?php echo $office_rek_bri2 ?></li>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="clearfix col-12">
					<div class="box" style="min-height:200px">
						<center><b>KETERANGAN</b></center>
						<p><?php echo $ket ?></p>
					</div>
				</div>
			</div>
			<div class="row">
				<center><h3><b><?php echo $office_footer_s ?></b></h3></center>
			</div>
	</div>
</body>
</html>