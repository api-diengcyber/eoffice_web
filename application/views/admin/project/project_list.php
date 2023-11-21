<!-- <link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css'); ?>"> -->
   <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Project List</h2>
            </div>
        
            <div class="col-md-4 text-center">
                <!-- <div style="margin-top: 4px"  id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div> -->
            </div>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('admin/project/create'), 'Create', 'class="btn btn-primary"'); ?>
	        </div>
        </div>
        <div class="table-responsive card card-body" style="border-radius:20px">
            <table class="table table-bordered table-striped" id="mytable">
                <thead class="table-dark">
                    <tr>
                        <th width="80px">No</th>
            		    <th>Project</th>
            		    <th>Description</th>
            		    <th class="text-center">File</th>
            		    <th width="200px" class="text-center">Action</th>
                    </tr>
                  
                </thead>
                <tbody>
                <?php 
                    $no=1;
                    foreach($project as $p){
                ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$p->project?></td>
                        <td>

                            <?=substr($p->description, 0, 50) . '...' ;?>
                        </td>
                        <td class="text-center">
                            <?php if($p->file==null)
                                {?>
                                Tidak Ada File
                                <?php

                                }else{?>
                                
                                <a href="<?=base_url('./assets/project/file/'.$p->file)?>" target="_blank">
                                File
                                </a>
                                
                                <?php

                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <a href="<?=base_url('admin/project/read/').$p->id?>" class="btn btn-success btn-sm"><i class="ace-icon fa fa-check bigger-120"></i></a>
                            <a href="<?=base_url('admin/project/update/').$p->id?>" class="btn btn-info btn-sm"> <i class="ace-icon fa fa-pencil bigger-120"></i></a>
                            <a  onclick="return confirm('Are you sure you want to delete this item?');" href="<?=base_url('admin/project/delete/').$p->id?>" class="btn btn-danger btn-sm"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>
                        </td>
                    </tr>
                <?php 
                    } ;
                 ?>
                </tbody>
    	    
            </table>
            <!-- <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
            <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap4.min.js') ?>"></script> -->
        </div>
        <script>
            let table = new DataTable('#mytable');
              
        </script>
        <!-- <script type="text/javascript">
            $(document).ready(function() {
                $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
                {
                    return {
                        "iStart": oSettings._iDisplayStart,
                        "iEnd": oSettings.fnDisplayEnd(),
                        "iLength": oSettings._iDisplayLength,
                        "iTotal": oSettings.fnRecordsTotal(),
                        "iFilteredTotal": oSettings.fnRecordsDisplay(),
                        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                    };
                };

                var t = $("#mytable").dataTable({
                    // initComplete: function() {
                        // var api = this.api();
                        // $('#mytable_filter input')
                        //         .off('.DT')
                        //         .on('keyup.DT', function(e) {
                        //             if (e.keyCode == 13) {
                        //                 api.search(this.value).draw();
                        //     }
                        // });
                        
                // console.log("ini"+api);
                    // }
                    // ,
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {"url": "project/json", "type": "POST"},
                    columns: [
                        {
                            "data": "id",
                            "orderable": false
                        },{"data": "project"},{"data": "description"},{"data": "file"},
                        {
                            "data" : "file",
                            "data" : "action",
                            "orderable": false,
                            "className" : "text-center"
                        }
                    ],
                    
                    order: [[0, 'desc']],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                        console.log(row);
                    }
                });
            });
        </script> -->