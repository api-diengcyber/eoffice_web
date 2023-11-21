<div class="jumbotron-content" style="height:200px">
    <div class="px-3 xs-p-0">
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <h3 class="font-weight-bolder justify">Detail Tasks</h3>
            </div>
        </div>
        <div class="card card-body border-0 text-black shadow" style="border-radius:20px">
            <table class="table">
                <tr>
                    <td>Project</td>
                    <td>
                        
                        <a href="<?=base_url('admin/project/read/').$id_project?>" class="text-decoration-none"><?php echo $project; ?>
                    </a>
                    </td>
                </tr>
                <tr>
                    <td>Date Created</td>
                    <td><?php echo $date_created; ?></td>
                </tr>
                <tr>
                    <td>Task</td>
                    <td><?php echo $task; ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo $description; ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <a href="<?php echo base_url() ?>admin/project-board">
                            <?php 
                            if($id_status==1){
                                echo 'todo';
                            }elseif($id_status== 2){
                                echo 'on progress';
                            }else{
                                echo 'finish';
                            }?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="<?php echo site_url('admin/tasks') ?>" class="btn btn-default">Cancel</a>
                    </td>
                </tr>
            </table>
        </div>
   </div>
</div>