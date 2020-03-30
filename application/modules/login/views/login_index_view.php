<!DOCTYPE html>
<html>
 <head>
  <title>Login Page</title>
  <!-- Bootstrap -->
  <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url() ?>assets/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url() ?>assets/css/mdi/css/materialdesignicons.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url() ?>assets/css/styles.css" rel="stylesheet" media="screen">
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script src="<?php echo base_url() ?>assets/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
 </head>
 <body id="login">
  <div class="container">   

   <form class="form-signin">
    <div class="message">

    </div>
    <br/>
    <h2 class="form-signin-heading">Silakan Masuk</h2>
    <input type="text" class="input-block-level required" 
           placeholder="Username" id="username" error="Username">
    <input type="password" class="input-block-level required" 
           placeholder="Password" id="password" error="Password">
    <div class="btn-group">
     <button class="btn btn-large btn-primary" type="button" onclick="login.sign_in()">Sign in
      <i class="mdi mdi-login mdi-18px"></i> 
     </button>
    </div>
   </form>

  </div> <!-- /container -->
  <script src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/message.js"></script>
  <script src="<?php echo base_url() ?>assets/js/validation.js"></script>
  <script src="<?php echo base_url() ?>assets/js/controllers/login.js"></script>
  <script src="<?php echo base_url() ?>assets/js/controllers/dashboard.js"></script>
 </body>
</html>