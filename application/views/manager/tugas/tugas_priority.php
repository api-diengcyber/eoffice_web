<style>
  .d-none {
  	display: none;
  } 
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li {     
    height: auto!important;
    line-height: 1.2em;
    padding: 10px;
    border: solid 1px white;
    background-color: #2196F3;
    color: white;
    cursor: pointer;
  }
  html>body #sortable li { height: 1.5em; line-height: 1.2em; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
</style>
<h3>Ubah Prioritas</h3>
<div class="card card-body mb-2">
	<div class="form-group">
		<label for="pgname">Pilih Pegawai</label>
		<form action="<?php echo base_url('admin/tugas/priority') ?>" method="post" id="changeID">
			<select name="id_pegawai" id="pgname" class="form-control">
				<?php foreach ($pegawai as $p): ?>
					<option value="<?php echo $p->id ?>" <?php if($p->id == $id){ echo 'selected'; } ?>><?php echo $p->nama_pegawai ?></option>
				<?php endforeach ?>
			</select>
		</form>
		<input type="hidden" id="id" value="<?php echo $id ?>">
	</div>
</div>
<div class="card card-body">
	<ul id="sortable" class="mb-2">
	<?php if(!empty($tugas)){ $i = 1;foreach ($tugas as $t) { ?>
		<li class="ui-state-default" id="item-<?php echo $t->id ?>"><?php echo $i.'.'.$t->judul ?></li>
	<?php $i++;}} ?>
	</ul>
	<button class="btn btn-primary <?php if(empty($id)) { echo 'd-none'; } ?>" id="sorted"><i class="mdi mdi-clipboard-check"></i> Urutkan</button>
</div>
<script>
	$(document).ready(function(){
		$('#pgname').change(function(){
			$('#changeID').submit();
		});	
	});
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
  	var id = $('#id').val();
    $( "#sortable" ).sortable({
      placeholder: "ui-state-highlight",
    });
    $( "#sortable" ).disableSelection();
    $('#sorted').click(function(){
        var data = $('#sortable').sortable('serialize');
        $.ajax({
            url:'<?php echo base_url("admin/tugas/set_priority");?>',
            type:'post',
            data:data+'&id='+id,
            success:function(response){
                alert('Perubahan berhasil.');
            }
        });
    });
  } );
</script>
