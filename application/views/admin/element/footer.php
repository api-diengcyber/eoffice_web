

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
        <script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/buttons.flash.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/buttons.colVis.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/dataTables.select.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.easypiechart.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.sparkline.index.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.flot.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.flot.pie.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.flot.resize.min.js"></script>
        
        <script src="<?php echo base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/chosen.jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/spinbox.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/daterangepicker.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.knob.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/autosize.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.inputlimiter.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.maskedinput.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap-tag.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/markdown.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap-markdown.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.hotkeys.index.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap-wysiwyg.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootbox.js"></script>

        <script src="<?php echo base_url() ?>assets/js/tree.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.nestable.min.js"></script>

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

          $("#sdatepicker1").datepicker({
              showOtherMonths: true,
              selectOtherMonths: false,
              dateFormat: "yy-mm-dd",
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
          $('#date-range-picker').daterangepicker({
              'applyClass' : 'btn-sm btn-success',
              'cancelClass' : 'btn-sm btn-default',
              locale: {
                format: 'DD-MM-YYYY',
                applyLabel: 'Proses',
                cancelLabel: 'Batal',
              }
          })
          .prev().on(ace.click_event, function(){
              $(this).next().focus();
          });
          $('#timepicker1').timepicker({
              minuteStep: 1,
              showSeconds: true,
              showMeridian: false,
              disableFocus: true,
              icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down'
              }
          }).on('focus', function() {
              $('#timepicker1').timepicker('showWidget');
          }).next().on(ace.click_event, function(){
              $(this).prev().focus();
          });
      
          $('#timepicker2').timepicker({
              minuteStep: 1,
              showSeconds: true,
              showMeridian: false,
              disableFocus: true,
              icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down'
              }
          }).on('focus', function() {
              $('#timepicker2').timepicker('showWidget');
          }).next().on(ace.click_event, function(){
              $(this).prev().focus();
          });
      
          $('#id-input-file-3').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small'//large | fit
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
        <script>
          function number_format(num, decimal_places, decimal_separator, thousand_separator) {    
             var result = num.toFixed(decimal_places);    
             var snum = result.split(".");
             var fnum = "";
             for (i=0; i<snum[0].length; i++) {
               if ((snum[0].length-i)%3==0) {
                 if(i!=0){
                   //alert(i);
                   fnum += thousand_separator;
                 }     
               }
               fnum += snum[0].charAt(i);
             }
             var rnum = fnum ;
             return rnum;
          }
        </script>

    </body>
</html>
