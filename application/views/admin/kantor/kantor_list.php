<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4">
        <h2 style="margin-top:0px">Kantor</h2>
    </div>
    <div class="col-md-4 text-center">
        <!-- <div style="margin-top: 4px" id="message">
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
        </div> -->
    </div>
    <div class="col-md-4 text-right">
        <?php echo anchor(site_url('admin/kantor/create'), 'Create', 'class="btn btn-success"'); ?>
    </div>
</div>
<div class="card table-responsive">
    <div class="card-body">
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="5px">No</th>
                    <th>Kode</th>
                    <th>Kantor</th>
                    <th>Kode Whatsapp</th>
                    <th>Koordinat</th>
                    <th>Total User</th>
                    <th>Created date</th>
                    <th width="200px">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
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
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode == 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?php echo base_url('admin/kantor/json') ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "id",
                    "orderable": false
                }, {
                    "data": "kode"
                }, {
                    "data": "nama_kantor"
                }, {
                    "data": "kode_whatsapp"
                },
                {
                    "data": "lat",
                    render: function(data, z, row) {
                        return data + '<br>' + row['long'];
                    }
                },
                {
                    "data": "total_users"
                },
                {
                    "data": "created_date"
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