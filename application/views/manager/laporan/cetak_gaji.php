<style>
	.d-none {
		display: none;
	}
</style>
<h3>Ubah Data</h3>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="">Potongan</label>
			<select name="potongan" id="pil_potongan" class="form-control">
				<option value="">Pilih</option>
				<?php foreach ($potongan as $p): ?>
				<option value="<?php echo $p->id ?>"><?php echo $p->nama_potongan ?></option>
				<?php endforeach ?>
			</select>
			<div id="addpotongan" class="d-none card bg-primary p-2 text-white mt-2">
				<form action="" id="formPot">
					<input type="hidden" name="id" id="id_pot" value="">
					<input type="hidden" name="bulan_tahun" value="<?php echo $bulan_tahun ?>">
					<input type="hidden" name="id_pegawai" value="<?php echo $data_laporan->id_pegawai;?>">
					<div class="form-group">
						<label for="">Masukan Nominal</label>
						<input type="number" class="form-control" name="nominal">
					</div>
					<div class="form-group">
						<label for="">Keterangan</label>
						<textarea name="keterangan" id="" cols="30" rows="3" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-light" type="button" id="btnPotongan"><i class="fa fa-plus"></i> Tambah</button>
					</div>
				</form>
			</div>
			<div id="potongan">
				
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="">Tunjangan</label>
			<select name="tunjangan" id="pil_tunjangan" class="form-control">
				<option value="">Pilih</option>
				<?php foreach ($tunjangan as $p): ?>
				<option value="<?php echo $p->id ?>"><?php echo $p->nama_tunjangan ?></option>
				<?php endforeach ?>
			</select>
			<div id="addtunjangan" class="d-none card bg-primary p-2 text-white mt-2">
				<form action="" id="formTunj">
					<input type="hidden" name="id" id="id_tunj" value="">
					<input type="hidden" name="bulan_tahun" value="<?php echo $bulan_tahun ?>">
					<input type="hidden" name="id_pegawai" value="<?php echo $data_laporan->id_pegawai;?>">
					<div class="form-group">
						<label for="">Masukan Nominal</label>
						<input type="number" class="form-control" name="nominal">
					</div>
					<div class="form-group">
						<label for="">Keterangan</label>
						<textarea name="keterangan" id="" cols="30" rows="3" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-light" type="button" id="btnTunjangan"><i class="fa fa-plus"></i> Tambah</button>
					</div>
				</form>
			</div>
			<div id="tunjangan">
				
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="card bg-primary p-2 text-white mb-2">
			<form action="" id="formBns">
			<div class="form-group">
				<label for="">Bonus</label>
				<input type="text" class="form-control" name="bonus_gaji" value="<?php echo $data_laporan->bonus_gaji ?>">
			</div>
			<div class="form-group">
				<label for="">Keterangan</label>
				<textarea name="keterangan_bonus" id="" cols="30" rows="3" class="form-control"><?php echo $data_laporan->keterangan_bonus ?></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-light" id="btnBns"><i class="fa fa-check"></i> Simpan</button>
			</div>
			</form>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<button class="btn btn-primary" onclick="window.history.back()"><i class="fa fa check"></i> Kembali</button>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		var id;

		// Function potongan
		ajx('<?php echo base_url();?>admin/laporan/list_potongan/<?php echo $data_laporan->id_pegawai;?>/<?php echo $bulan_tahun ?>','','#potongan');
		$('#pil_potongan').change(function(){
			id = $(this).val();
			if(id!=0){
				$('#id_pot').val(id);
				$('#addpotongan').removeClass('d-none');
			}
			else{
				$('#addpotongan').addClass('d-none');	
			}
		});
		$('#btnPotongan').click(function(){
			var data = $('#formPot').serialize();
			ajx('<?php echo base_url();?>admin/laporan/add_potongan',data,'#potongan');
		});

		//Function Tunjangan
		ajx('<?php echo base_url();?>admin/laporan/list_tunjangan/<?php echo $data_laporan->id_pegawai;?>/<?php echo $bulan_tahun ?>','','#tunjangan');
		$('#pil_tunjangan').change(function(){
			id = $(this).val();
			if(id!=0){
				$('#id_tunj').val(id);
				$('#addtunjangan').removeClass('d-none');
			}
			else{
				$('#addtunjangan').addClass('d-none');	
			}
		});
		$('#btnTunjangan').click(function(){
			var data = $('#formTunj').serialize();
			ajx('<?php echo base_url();?>admin/laporan/add_tunjangan',data,'#tunjangan');
		});
		$('#btnBns').click(function(){
			var data = $('#formBns').serialize()+'&id_pegawai='+<?php echo $data_laporan->id_pegawai;?>;
			ajx('<?php echo base_url();?>admin/laporan/update_bonus/<?php echo $bulan_tahun ?>',data,'');
			if(ajx){
				alert('Berhasil di update');
			}
		});

	});
	function remove(id,jenis){
		var Confirm = confirm('are you sure?');
		if(Confirm){
			if(jenis == 1){
				ajx('<?php echo base_url();?>admin/laporan/remove_potongan/<?php echo $data_laporan->id_pegawai;?>/<?php echo $bulan_tahun ?>','id='+id,'#potongan');
			}else{
				ajx('<?php echo base_url();?>admin/laporan/remove_tunjangan/<?php echo $data_laporan->id_pegawai;?>/<?php echo $bulan_tahun ?>','id='+id,'#tunjangan');
			}
		}
	}
	function ajx(url,data,element){
		$.ajax({
			url :url,
			type:'post',
			data:data,
			success:function(response){
				$(element).html(response);
			}
		});
	}
</script>