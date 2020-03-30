<!DOCTYPE html>
<html lang="en">
 <head>
  <title>SiPintar - Bimbel Active Education</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->	
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>files/images/logo_depan.png"/>
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/login/vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/login/vendor/animate/animate.css">
  <!--===============================================================================================-->	
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/login/vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/login/vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/login/util.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/login/main.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/toastr.min.css">
  <!--===============================================================================================-->
 </head>
 <body>    

  <div class="limiter">
   <div class="container-login100">        
    <div class="wrap-login100">
     <div class="login100-pic js-tilt" data-tilt>
      <h4>SiPintar (Computer Assisted Test Management System)</h4>
      <!--<img src="<?php echo base_url() ?>files/images/img-01.png" alt="IMG">-->
      <img src="<?php echo base_url() ?>files/images/logo_atas.png" alt="IMG" style="margin-top: 16px;">
     </div>

     <form class="login100-form validate-form">
      <span class="login100-form-title">
       Login Area
      </span>

      <div class="wrap-input100 validate-input" data-validate = "Valid Username is required">
       <input class="input100 required" type="text" id="username" name="user" error="Username" placeholder="Username">
       <span class="focus-input100"></span>
       <span class="symbol-input100">
        <i class="fa fa-envelope" aria-hidden="true"></i>
       </span>
      </div>

      <div class="wrap-input100 validate-input" data-validate = "Password is required">
       <input class="input100 required" type="password" id="password" error="Password" name="pass" placeholder="Password">
       <span class="focus-input100"></span>
       <span class="symbol-input100">
        <i class="fa fa-lock" aria-hidden="true"></i>
       </span>
      </div>

      <div class="container-login100-form-btn">
          <!-- To login controller sign in -->
       <button class="login100-form-btn" onclick="login.sign_in(this, event)">
        Login
       </button>
      </div>

      <div class="text-center p-t-12">
       <span class="txt1">
        &nbsp;
       </span>
       <a class="txt2" href="#">
        &nbsp;
       </a>
      </div>

      <div class="text-center p-t-136">
       <a class="txt2" href="#">
        &nbsp;
        <!--Create your Account-->
        <!--<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>-->
       </a>
      </div>
     </form>
    </div>
   </div>
  </div>




  <!--===============================================================================================-->	
  <script src="<?php echo base_url() ?>assets/css/login/vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo base_url() ?>assets/css/login/vendor/bootstrap/js/popper.js"></script>
  <script src="<?php echo base_url() ?>assets/css/login/vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo base_url() ?>assets/css/login/vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo base_url() ?>assets/css/login/vendor/tilt/tilt.jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/toastr.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/message.js"></script>
  <script src="<?php echo base_url() ?>assets/js/validation.js"></script>
  <script src="<?php echo base_url() ?>assets/js/controllers/login.js"></script>
  <script src="<?php echo base_url() ?>assets/js/controllers/dashboard.js"></script>
  <script >
   $('.js-tilt').tilt({
    scale: 1.1
   })
  </script>
  <!--===============================================================================================-->
  <script src="<?php echo base_url() ?>assets/js/login/main.js"></script>

 </body>
</html>