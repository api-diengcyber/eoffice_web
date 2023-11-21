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
    border-radius: 5px;
    color: white;
    cursor: pointer;
  }
  html>body #sortable li { height: 1.5em; line-height: 1.2em; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
</style>
<h3>Ubah Urutan</h3>
<div class="card card-body mb-2">
	<div class="form-group">
		<label for="pgname">Pilih Jabatan</label>
		<form action="<?php echo base_url('admin/pil_tingkat/urutkan') ?>" method="post" id="changeID">
			<select name="id_jabatan" id="jabatan" class="form-control">
        <option value="">Pilih jabatan</option>
				<?php foreach ($jabatan as $p): ?>
					<option value="<?php echo $p->id ?>" <?php if($p->id == $id){ echo 'selected'; } ?>><?php echo $p->jabatan ?></option>
				<?php endforeach ?>
			</select>
		</form>
	</div>
</div>
<div class="card card-body">
	<ul id="sortable" class="mb-2">
	<?php if(!empty($level)){ $i=1;foreach ($level as $t) { ?>
		<li class="ui-state-default bg-success" id="item-<?php echo $t->id ?>"><?php echo $i++.'.'.$t->tingkat ?></li>
	<?php }} ?>
	</ul>
	<button class="btn btn-dark <?php if(empty($id)) { echo 'd-none'; } ?>" id="sorted"><i class="mdi mdi-clipboard-check"></i> Urutkan</button>
</div>
<script>
	$(document).ready(function(){
		$('#jabatan').change(function(){
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
            url:'<?php echo base_url("admin/pil_tingkat/set_orders");?>',
            type:'post',
            data:data+'&id='+id,
            success:function(response){
                alert('Perubahan berhasil.');
            }
        });
    });
  } );
</script>
