
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Transaksi
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="varchar">Tanggal</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('tgl') ?>
                                        <div class="input-group">
                                            <span class="input-group-append">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                            <input type="text" class="form-control" name="tgl" id="datepicker1" placeholder="Tanggal" value="<?php echo $tgl; ?>" readonly />
                                            <span class="input-group-append">
                                                <i class="fa fa-clock-o bigger-110"></i>
                                            </span>
                                            <input type="text" class="form-control" name="jam" id="timepicker1" placeholder="Tanggal" value="<?php echo $jam; ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="varchar">No Faktur</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('no_faktur') ?>
                                        <input type="text" class="form-control" name="no_faktur" id="no_faktur" placeholder="No Faktur" value="<?php echo $no_faktur; ?>" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="varchar">Nama</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('kepada_nama') ?>
                                        <input type="text" class="form-control" name="kepada_nama" id="kepada_nama" placeholder="Nama" value="<?php echo $kepada_nama; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="varchar">Hp</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('kepada_hp') ?>
                                        <input type="text" class="form-control" name="kepada_hp" id="kepada_hp" placeholder="Hp" value="<?php echo $kepada_hp; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="varchar">Alamat</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('kepada_alamat') ?>
                                        <input type="text" class="form-control" name="kepada_alamat" id="kepada_alamat" placeholder="Alamat" value="<?php echo $kepada_alamat; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="varchar">DP</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('dp') ?>
                                        <input type="text" class="form-control" name="dp" id="dp" placeholder="DP" value="<?php echo $dp; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="varchar">Ket</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('ket') ?>
                                        <textarea class="form-control" name="ket" id="ket" placeholder="Keterangan"><?php echo $ket; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr hr-dotted hr10"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="varchar">Barang</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('barang') ?>
                                        <input type="text" class="form-control" name="barang" id="barang" placeholder="Barang" value="<?php echo $barang; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label no-padding-right" style="text-align:left;" for="double">Harga</label>
                                    <div class="col-md-10">
                                        <?php echo form_error('harga') ?>
                                        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <center> 
                                <button id="btn_simpan_barang" type="button" class="btn btn-inverse btn-sm btn-round no-border">Simpan Barang</button>
                                </center>
                            </div>
                        </div>
                        <div class="hr hr-dotted hr10"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped" id="mytable">
                                    <thead>
                                        <tr>
                                            <th width="2">No</th>
                                            <th>Barang</th>
                                            <th>Harga</th>
                                            <th>Diskon</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                                <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                                <a href="<?php echo site_url('admin/transaksi') ?>" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->


<script src="<?php echo base_url() ?>assets/tinymce/jquery.tinymce.min.js"></script>
<script src="<?php echo base_url() ?>assets/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
jQuery(function($){
    /*
    tinymce.init({
      selector: 'textarea',
      height: 500,
      theme: 'modern',
      plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
      toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
      image_advtab: true,
      templates: [
        { title: 'Test template 1', content: 'Test 1' },
        { title: 'Test template 2', content: 'Test 2' }
      ],
        valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang],"
        + "a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
        + "name|href|target|title|class],strong/b,em/i,strike,u,"
        + "#p[style],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
        + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
        + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
        + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
        + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
        + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
        + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
        + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
        + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
        + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
        + "|height|src|*],map[name],area[shape|coords|href|alt|target],bdo,"
        + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
        + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
        + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
        + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
        + "q[cite],samp,select[disabled|multiple|name|size],small,"
        + "textarea[cols|rows|disabled|name|readonly],tt,var,big",
        extended_valid_elements : "p[style]",
        inline_styles : true,
        verify_html : false
    });
    */

    $("#ket").on('keyup', function(){
        var ket = $(this).val();
        alert(ket);
    });

    $("#harga").on('keyup', function(){
        var harga = $(this).val().replace(/\./g,'');
        if (isNaN(harga)) {
            harga = 0;
        }
        $(this).val(number_format(harga*1,0,',','.'));
    });

    $("#dp").on('keyup', function(){
        var dp = $(this).val().replace(/\./g,'');
        if (isNaN(dp)) {
            dp = 0;
        }
        $(this).val(number_format(dp*1,0,',','.'));
    });

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
        paging:   false,
        ordering: false,
        info:     false,
        searching: false,
        oLanguage: {
            sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "<?php echo base_url() ?>admin/transaksi/json_barang_temp", "type": "POST"},
        columns: [
            {
                "data": "id",
                "orderable": false
            },{"data": "barang"},{"data": "harga"},{"data": "diskon"},{"data": "jumlah"},{"data": "total"},{"data": "id"},
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
            $('td:eq(2)', row).html(number_format(data.harga*1,0,',','.'));
            $('td:eq(3)', row).html('<input type="number" class="input-small" id="diskon" data-id="'+data.id+'" value="'+data.diskon+'">%');
            $('td:eq(4)', row).html('<input type="number" class="input-small" id="jumlah" data-id="'+data.id+'" value="'+data.jumlah+'">');
            $('td:eq(5)', row).html(number_format(data.total*1,0,',','.'));
            $('td:eq(6)', row).html('<button type="button" id="btn_hapus_temp" data-id="'+data.id+'" class="btn btn-danger btn-xs btn-round no-border"><i class="ace-icon fa fa-trash"></i></button>');
        }
    });

    var t_api = t.api();

    $("#mytable").on('draw.dt', function(){
        $("button[id*=btn_hapus_temp]").click(function(){
            var data_id = $(this).attr('data-id');
            var c = confirm('Anda akan menghapus data?');
            if (c) {
                $.ajax({
                    url: '<?php echo base_url() ?>admin/transaksi/hapus_barang_temp',
                    type: 'post',
                    data: 'id='+data_id,
                }).done(function(data){
                    t_api.draw(); 
                });
            }
        });
        $("input[id*=diskon]").on('keyup', function(){
            var diskon = $(this).val();
            if (diskon*1 > 100) {
                $(this).val(100);
            }
        });
        $("input[id*=jumlah], input[id*=diskon]").change(function(e){
            var data_id = $(this).attr('data-id');
            var jumlah = $("input[id=jumlah][data-id="+data_id+"]").val();
            var diskon = $("input[id=diskon][data-id="+data_id+"]").val();
            $.ajax({
                url: '<?php echo base_url() ?>admin/transaksi/update_barang_temp',
                type: 'post',
                data: 'id='+data_id+'&jumlah='+jumlah+'&diskon='+diskon,
            }).done(function(data){
                t_api.draw();
            });
        });
    });

    $("#btn_simpan_barang").click(function(){
        var barang = $("#barang").val();
        var harga = $("#harga").val().replace(/\./g,'');
        $.ajax({
            url: '<?php echo base_url() ?>admin/transaksi/simpan_barang_temp',
            type: 'post',
            data: 'barang='+barang+'&harga='+harga,
        }).done(function(data){
            t_api.draw();
            $("#barang").val(''); 
            $("#harga").val(''); 
        });
    });

});
</script>