

            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                             &copy; 2017
                        </span>
                    </div>
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->
        <!--[if !IE]> -->
        <!-- <![endif]-->


        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
        </script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        
        <!-- page specific plugin scripts -->
        <script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>


        <!-- page specific plugin scripts -->
        <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>

        <!-- ace scripts -->
        <script src="<?php echo base_url() ?>assets/js/ace-elements.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/ace.min.js"></script>

        <script>
        jQuery(function($){
            $("#datepicker1").datepicker({
                showOtherMonths: true,
                selectOtherMonths: false,
                dateFormat: "dd-mm-yy",
            });
            $("#datepicker2").datepicker({
                showOtherMonths: true,
                selectOtherMonths: false,
                dateFormat: "dd-mm-yy",
            });
            $("#datepicker3").datepicker({
                showOtherMonths: true,
                selectOtherMonths: false,
                dateFormat: "dd-mm-yy",
            });
            $("#datepicker-1").datepicker({
                showOtherMonths: true,
                selectOtherMonths: false,
                dateFormat: "dd-mm-yy"
            });
            $("#datepicker-1-submit").datepicker({
                showOtherMonths: true,
                selectOtherMonths: false,
                dateFormat: "dd-mm-yy",
                onSelect: function(){
                  this.form.submit();
                }
            });
            $('#id-input-file-3').ace_file_input({
              style: 'well',
              btn_choose: 'Drop files here or click to choose',
              btn_change: null,
              no_icon: 'ace-icon fa fa-cloud-upload',
              droppable: true,
              thumbnail: 'large'//large | fit
              //,icon_remove:null//set null, to hide remove/reset button
              /**,before_change:function(files, dropped) {
                //Check an example below
                //or examples/file-upload.html
                return true;
              }*/
              /**,before_remove : function() {
                return true;
              }*/
              ,
              preview_error : function(filename, error_code) {
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
              }
          
            }).on('change', function(){
              //console.log($(this).data('ace_input_files'));
              //console.log($(this).data('ace_input_method'));
            });
        });
        </script>
    </body>
</html>
