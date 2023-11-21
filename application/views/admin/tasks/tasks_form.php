<div class="jumbotron-content" style="height:200px">
    <div class="px-3 xs-p-0">
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <h3 class="font-weight-bolder justify">Tasks</h3>
            </div>
        </div>
        <div class="card card-body border-0 text-black shadow" style="border-radius:20px">
            <!-- <?php if (!empty($message)) { ?>
                <div class="alert alert-danger"><?php echo $message; ?></div>
            <?php } ?> -->
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="int">Project <?php echo form_error('id_project') ?></label>
                    <select name="id_project" id="" class="form-control">
                        <?php foreach ($data_project as $project) { ?>
                            <option value="<?php echo $project->id; ?>" 
                                    <?php if ($id_project == $project->id) {
                                    echo "selected";
                                     } ?>><?php echo $project->project; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="varchar">Task <?php echo form_error('task') ?></label>
                    <input type="text" class="form-control" name="task" id="task" placeholder="Task" value="<?php echo $task; ?>" required/>
                </div>
                <div class="form-group">
                    <label for="description">Description <?php echo form_error('description') ?></label>
                    <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description" required><?php echo $description; ?></textarea>
                </div>
                <input type="hidden" name="id_status" value="1">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                <a href="<?php echo site_url('admin/tasks') ?>" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
</div>