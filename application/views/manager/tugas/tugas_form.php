<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/chosen.css">
<style>
    .input-group-append, .input-group-prepend {
        padding:0px!important;
    }
</style>
    <script src="<?php echo base_url();?>assets/tinymce/tinymce.min.js"></script>
    <script>
    $(document).ready(function(){
      tinymce.init({
        selector: 'textarea',
        height: 500,
        theme: 'modern',
        plugins: 'code print preview media searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
        toolbar1: 'code formatselect media | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        image_advtab: true,
        relative_urls: false,
        remove_script_host: false,
        image_class_list: [
            {title: 'None', value: ''},
            {title: 'Zoomable images', value: 'content-images'},
        ],
        templates: [
          { title: 'Test template 1', content: 'Test 1' },
          { title: 'Test template 2', content: 'Test 2' }
        ],
        images_upload_handler: function (blobInfo, success, failure) {
          var xhr, formData;
          xhr = new XMLHttpRequest();
          xhr.withCredentials = false;
          xhr.open('POST', "<?php echo base_url() ?>admin/post/upload_gambar");
          xhr.onload = function() {
              var json;
              if (xhr.status != 200) {
                  failure("HTTP Error: " + xhr.status);
                  return;
              }
              json = JSON.parse(xhr.responseText);
              if (!json || typeof json.location != "string") {
                  failure("Invalid JSON: " + xhr.responseText);
                  return;
              }
              success(json.location);
          };
          formData = new FormData();
          formData.append('file', blobInfo.blob(), blobInfo.filename());
          xhr.send(formData);
        },
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
    });
    </script>
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    Tugas
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-12 card card-body">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="varchar">Tgl <?php echo form_error('tgl') ?></label>
                            <input type="text" class="form-control" name="tgl" id="datepicker" placeholder="Tgl" value="<?php echo $tgl; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="">Project</label>
                            <select name="id_project" id="id_project" class="form-control" required>
                                <option value="">Pilih</option>
                                <?php foreach ($project as $p): ?>
                                <option value="<?php echo $p->id ?>" <?php if($p->id == $id_project) { echo 'selected'; } ?>><?php echo $p->project ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tugas">Pegawai <?php echo form_error('id_pegawai') ?></label>
                            <?php if ($button == "Update") { ?>
                            <select class="form-control" name="id_pegawai" id="id_pegawai" required >
                            <?php } else { ?>
                            <select multiple="" class="chosen-select form-control" name="id_pegawai[]" id="id_pegawai" required data-placeholder="Pegawai">
                            <?php } ?>
                              <?php foreach ($data_pegawai as $key): ?>
                                  <option value="<?php echo $key->id ?>" <?php if($key->id == $id_pegawai){ echo 'selected'; } ?>><?php echo $key->nama_pegawai ?></option>
                              <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" name="judul" value="<?php echo $judul ?>">
                        </div>
                        <div class="form-group">
                            <label for="tugas">Tugas <?php echo form_error('tugas') ?></label>
                            <textarea class="form-control" rows="3" name="tugas" id="tugas" placeholder="Tugas"><?php echo $tugas; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tugas">File Tugas </label>
                            <input type="file" class="form-control" name="file_tugas" id="id-input-file-3" placeholder="File Tugas" />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Tgl Selesai <?php echo form_error('tgl_selesai') ?></label>
                            <input type="text" class="form-control" name="tgl_selesai" id="datepicker" placeholder="Tgl Selesai" value="<?php echo $tgl_selesai; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="int">Selesai <?php echo form_error('selesai') ?></label>
                            <div class="radio">
                                <label>
                                    <input name="selesai" type="radio" value="1" class="ace" <?php echo ($selesai=='1' ? 'checked' : ''); ?> />
                                    <span class="lbl"> Selesai</span>
                                </label>
                                <label>
                                    <input name="selesai" type="radio" value="0" class="ace" <?php echo ($selesai=='0' ? 'checked' : ''); ?> />
                                    <span class="lbl"> Belum Selesai</span>
                                </label>
                            </div>
                        </div>
                        <br>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                        <a href="<?php echo site_url('admin/tugas') ?>" class="btn btn-default">Cancel</a>
                    </form>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<script src="<?php echo base_url() ?>assets/js/chosen.jquery.min.js"></script>
<!-- ace scripts -->
<script src="<?php echo base_url() ?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/ace.min.js"></script>
<script>
  $('[id*=datepicker]').datepicker({
    format:'dd-mm-yyyy'
  });
  if(!ace.vars['touch']) {
      $('.chosen-select').chosen({allow_single_deselect:true});
  }

</script>