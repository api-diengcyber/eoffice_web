<div class="card p-4">
	<h4><?php echo $data_materi->nama_materi ?></h4>
	<hr>
	<p>
		<?php echo $data_materi->isi ?>
	</p>

	<?php if(file_exists('assets/materi/'.$data_materi->lampiran)){ ?>
	<span>	<a href="<?php echo base_url('assets/materi/'.$data_materi->lampiran) ?>" class="badge badge-primary" onclick="return confirm('Download ?')"><i class="fa fa-download" download></i> Download</a></span>
	<?php } ?>
</div>