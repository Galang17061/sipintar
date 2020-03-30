<!DOCTYPE html>
<html class="no-js">
 <?php echo Modules::run('header'); ?>
 <?php if (isset($css)) { ?>
  <?php foreach ($css as $vcs) { ?>
   <script src="<?php echo $vcs ?>"></script>
  <?php } ?>
 <?php } ?>

 <?php if (isset($js)) { ?>
  <?php foreach ($js as $vjs) { ?>
   <script src="<?php echo $vjs ?>"></script>
  <?php } ?>
 <?php } ?>
 <body>  
  <?php echo $this->load->view('top_content'); ?>
  <br/>
  <div class="container-fluid">
   <div class="row-fluid">
    <!--<button data-target="modal1" class="btn modal-trigger" onclick="Template.showModal()">Modal</button>-->
    <?php echo $this->load->view('left_content'); ?>
    <!--/span-->
    <div class="span9" id="content">
     <?php
     if (isset($header_data)) {
      foreach ($header_data as $v_head) {
       echo $v_head;
      }
     }
     ?>
     <br/>
     <?php echo $this->load->view($module . '/' . $view_file); ?>
    </div> 
   </div>
   <hr>
   <?php echo $this->load->view('navbar_content'); ?>
   <?php echo $this->load->view('modal_content'); ?>
   <?php echo $this->load->view('footer_content'); ?>
  </div>  
 </body>

</html>