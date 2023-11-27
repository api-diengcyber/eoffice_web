<div class="card">
    <div class="card-body">
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Registrasi Kantor List</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('registrasi_kantor/create'), 'Create', 'class="btn btn-primary"'); ?>
            </div>
        </div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Perusahaan</th>
                    <th>Alamat</th>
                    <th>No Telp Perusahaan</th>
                    <th>Bidang Bisnis</th>
                    <th>Jml Karyawan</th>
                    <th>Nama Pemohon</th>
                    <th>No Telp Pemohon</th>
                    <th>Jabatan Pemohon</th>
                    <th>Email</th>
                    <th>Created Date</th>
                    <th>Status</th>
                    <th width="200px">Action</th>
                </tr>
            </thead>

        </table>
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
                        "url": "registrasi_kantor/json",
                        "type": "POST"
                    },
                    columns: [{
                            "data": "id",
                            "orderable": false
                        }, {
                            "data": "perusahaan"
                        }, {
                            "data": "alamat"
                        }, {
                            "data": "no_telp_perusahaan"
                        }, {
                            "data": "bidang_bisnis"
                        }, {
                            "data": "jml_karyawan"
                        }, {
                            "data": "nama_pemohon"
                        }, {
                            "data": "no_telp_pemohon"
                        }, {
                            "data": "jabatan_pemohon"
                        }, {
                            "data": "email"
                        }, {
                            "data": "created_date"
                        }, {
                            "data": "status"
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
    </div>
</div>