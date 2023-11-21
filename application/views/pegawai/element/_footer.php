		</div>
		<!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
              <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
              <i class="mdi mdi-heart text-danger"></i>
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="<?php echo base_url();?>assets/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url();?>assets/js/off-canvas.js"></script>
  <script src="<?php echo base_url();?>assets/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo base_url();?>assets/js/dashboard.js"></script>
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
  <!-- End custom js for this page-->
</body>

</html>