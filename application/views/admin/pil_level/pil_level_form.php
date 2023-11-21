
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Pilihan Level
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                        <form action="<?php echo $action; ?>" method="post">
                            <input type="hidden" name="level" value="<?=$level?>" id="level">
                            <div class="form-group">
                                <label for="varchar">Level <?php echo form_error('level') ?></label>
                                <select name="level_number" id="level_number" class="form-control" required>
                                <option value="" selected disabled>--Pilih--</option>
                                <?php 
                                    $level_name = [
                                        [
                                            'id' => 1,
                                            'level' => 'STAF',
                                            'level_number' =>1,

                                        ],
                                        [
                                            'id' => 2,
                                            'level' => 'MARKETING',
                                            'level_number' =>2, 
                                        ],
                                        [
                                            'id' => 3,
                                            'level' => 'ADMIN',
                                            'level_number' =>3, 
                                        ],
                                        [
                                            'id' => 3,
                                            'level' => 'ADMIN',
                                            'level_number' =>3, 
                                        ],
                                        [
                                            'id' => 4,
                                            'level' => 'FREELANCE',
                                            'level_number' =>4, 
                                        ],
                                        [
                                            'id' => 5,
                                            'level' => 'TRAINING',
                                            'level_number' =>5, 
                                        ],
                                        [
                                            'id' => 6,
                                            'level' => 'MANAGER',
                                            'level_number' =>6, 
                                        ],
                                        [
                                            'id' => 7,
                                            'level' => 'KEUANGAN',
                                            'level_number' =>7, 
                                        ],
                                        [
                                            'id' => 8,
                                            'level' => 'SEKRETARIS',
                                            'level_number' =>8, 
                                        ],
                                    ];
                                    ?>

                                        <?php  foreach ($level_name as $key => $value){ ?>
                                        <option value="<?php echo $value['level_number'] ?>" <?php if($value['level_number'] == $level_number) { echo 'selected'; } ?>><?php echo $value['level'] ?></option>
                                        <?php 
                                        } ?>
                                </select>
                                <!-- <input type="text" class="form-control" name="level" id="level" placeholder="Level" value="<?php echo $level; ?>" /> -->
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                            <a href="<?php echo site_url('admin/pil_level') ?>" class="btn btn-default">Cancel</a>
                        </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<script>
    $("#level_number").change(function(){
        let text =$( "#level_number option:selected" ).text();
        $('#level').val(text);
           
        });
</script>