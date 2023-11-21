<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<style>
		@page{
			margin: 0px;
			size: 210mm 330mm;
		}
		@media print{
			@page{
				margin-left: 0px;
				size: 210mm 330mm;
			}
		}
		body{
			font-family:sans-serif;
			font-size:12px;
		}
		h2{
			margin:0px;
		}
		.container{
			position:absolute;
			top:0;
			left:0;
			width:100%;
			height:100%;
		}
		.content{
			margin-top: 5px;
			margin-right: 5px;
			margin-left: 5px;
			margin-bottom: 5px;
		}
		.box{
			background-color: white;
			border:1px solid black;
			padding:3px 3px 3px 3px;
			overflow: hidden;
			margin-top:8px;
			margin-bottom:8px;
			border-radius: 3px 3px 3px 3px;
		}
		.box table{
			border:0px solid black;
			border-collapse: collapse;
			width:100%;
		}
		.box table tr th{
			border:1px solid black;
			padding:4px;
		}
		.box table tr td{
			border:1px solid black;
			padding:4px;
		}
		.box .no-border{
			border-top:1px solid white!important;
			border-bottom:1px solid white!important;
			border-left:1px solid white!important;
			border-right:0px solid white!important;
		}
	</style>
	<script>
		//setTimeout(function(){ window.close() }, 3000);
	</script>
</head>
<body onload="print()">

  <div class="container">
  	<div class="content">
  	  <?php foreach ($data_gaji as $key): ?>
  		<div class="box">
  			<table>
  			  <tr>
  			  	<td><?php echo $key->nama_pegawai ?></td>
  			  	<td><?php echo $key->nama_pegawai ?></td>
  			  	<td><?php echo $key->nama_pegawai ?></td>
  			  </tr>
  			  <tr>
  			  	<td><?php echo $key->nama_pegawai ?></td>
  			  	<td><?php echo $key->nama_pegawai ?></td>
  			  	<td><?php echo $key->nama_pegawai ?></td>
  			  </tr>
  			</table>
  		</div>
  	  <?php endforeach ?>
    </div>
  </div>

</body>
</html>