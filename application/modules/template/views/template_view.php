<!DOCTYPE html>
<html lang="en">

 <?php echo $this->load->view('head_content') ?>

 <body>
  <!-- Pre-loader start -->
  <div class="theme-loader">
   <div class="loader-track">
    <div class="loader-bar"></div>
   </div>
  </div>
  <div class="loader">

  </div>
  <!-- Pre-loader end -->
  <div id="pcoded" class="pcoded">
   <div class="pcoded-overlay-box"></div>
   <div class="pcoded-container navbar-wrapper">

    <?php echo $this->load->view('navbar_content') ?>
    <div class="pcoded-main-container">
     <div class="pcoded-wrapper">
      <?php echo $this->load->view('left_content') ?>
      <div class="pcoded-content">
       <div class="pcoded-inner-content">
        <div class="main-body">
         <div class="page-wrapper">
          <div class="page-body">
           <?php echo $this->load->view($module . '/' . $view_file); ?>
          </div>
          <div id="styleSelector">

          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
   <!-- Warning Section Ends -->
   <!-- Required Jquery -->
   <?php echo $this->load->view('script_content') ?>
 </body>

</html>

<?php
if (isset($header_data)) {
 foreach ($header_data as $v_head) {
  echo $v_head;
 }
}
?>