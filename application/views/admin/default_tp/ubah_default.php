<style>
	.d-none {
		display: none;
	}
	.showOnLevel{
		display: none;
	}
</style>
<h3>Ubah default</h3>
<p>Default tunjangan dan potongan, otomatis di masukan ke laporan gaji.</p>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="">Pilih Level</label>
			<select name="id_level" id="level" class="form-control">
				<option value="">Pilih</option>
				<?php foreach ($pil_level as $level): ?>
				<option value="<?php echo $level->id ?>"><?php echo $level->level ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-6" class="showOnLevel">
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
	<div class="col-md-6" class="showOnLevel">
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
		<div class="form-group">
			<button class="btn btn-primary" onclick="window.history.back()"><i class="fa fa check"></i> Kembali</button>
		</div>
	</div>
</div>
<script>
	var id;
	var level;
	$(document).ready(function(){
		$('#level').change(function(){
			level = $(this).val();
			ajx('<?php echo base_url();?>admin/default_tp/list_potongan/'+level,'','#potongan');
			ajx('<?php echo base_url();?>admin/default_tp/list_tunjangan/'+level,'','#tunjangan');
		});
		// Function potongan
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
			ajx('<?php echo base_url();?>admin/default_tp/add_potongan/'+level,data,'#potongan');
		});

		//Function Tunjangan
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
			ajx('<?php echo base_url();?>admin/default_tp/add_tunjangan/'+level,data,'#tunjangan');
		});


	});
	function remove(id,jenis){
		var Confirm = confirm('are you sure?');
		if(Confirm){
			if(jenis == 1){
				ajx('<?php echo base_url();?>admin/default_tp/remove_potongan/'+level,{id:id},'#potongan');
			}else{
				ajx('<?php echo base_url();?>admin/default_tp/remove_tunjangan/'+level,{id:id},'#tunjangan');
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