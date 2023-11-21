    <h2 style="margin-top:0px">Project Read</h2>
        <table class="table">
	    <tr>
			<td>Project</td>
			<td><?php echo $project; ?></td>
		</tr>
	    <tr>
			<td>Description</td>
			<td><?php echo $description; ?></td>
		</tr>
	    <tr>
			<td>File</td>
			<td>
			<?php if($file==null){?>
                    -
            <?php
                }else{?>
                	<a href="<?=base_url('./assets/project/file/'.$file)?>" target="_blank">
                        File
              	</a>            
               <?php
			   	}
				?>
			</td>
		</tr>
	    <tr>
			<td></td>
			<td>
				<a href="<?php echo site_url('admin/project') ?>" class="btn btn-default">Cancel</a>
			</td>
		</tr>
	</table>