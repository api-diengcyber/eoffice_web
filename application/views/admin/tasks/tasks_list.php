<link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css'); ?>">
<div class="jumbotron-content" style="height:200px">
    <div class="px-3 xs-p-0">
        <div class="row mb-4">
            <div class="col-md-4">
                <h3 class="font-weight-bolder justify">Tasks </h3>
            </div>
            <div class="col-md-4 text-center">
                    <!-- <div style="margin-top: 4px" id="message">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div> -->
                </div>
                <div class="col-md-4 text-right">
                    <?php echo anchor(site_url('admin/tasks/create'), 'Create', 'class="btn btn-primary"'); ?>
                </div>
        </div>
        <div class="card card-body border-0 text-black shadow" style="border-radius:20px">
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                </div>
              
            </div>
            
            <table class="table table-bordered table-striped" id="mytable">
                <thead class="table-dark">
                    <tr >
                        <th width="20px">No</th>
                        <th>Date Created</th>
                        <th>Task</th>
                        <th>Description</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                

            </table>
            <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
            <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap4.min.js') ?>"></script>
        </div>
    </div>
</div>
<!-- <script>
            let table = new DataTable('#mytable');
              
        </script> -->
        <script type="text/javascript">
            $(document).ready(function() {
                $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
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
                    //     var api = this.api();
                    //     $('#mytable_filter input')
                    //         .off('.DT')
                    //         .on('keyup.DT', function(e) {
                    //             if (e.keyCode == 13) {
                    //                 api.search(this.value).draw();
                    //             }
                    //         });
                    // },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "<?php echo base_url(); ?>admin/tasks/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id",
                            "orderable": false
                        },
                        {
                            "data": "date_created"
                        },
                        {
                            "data": "task"
                        },
                        {
                            "data": "description"
                        },
                        {
                            "data": "action",
                            "orderable": false,
                            "className": "text-center"
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            });
        </script>