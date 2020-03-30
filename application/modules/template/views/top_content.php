<div class="navbar navbar-fixed-top top-menu">
 <div class="navbar-inner top-menu">
  <div class="container-fluid">
   <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
   </a>   
   <a class="brand"  href="<?php echo base_url() . 'dashboard' ?>">
    <img src="<?php echo base_url() ?>files/img/tut-wuri.png" alt="IMG" width="25" height="25">    
    <label class="" id="">Ujian Online SMK Negeri 2 Blitar</label>
   </a>   
   <div class="nav-collapse collapse">
    <ul class="nav pull-right">
     <li class="dropdown">
      <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 16px;"> <i class="icon-user">       
       </i> <?php echo $this->session->userdata('username'); ?> <i class="caret"></i>

      </a>
      <ul class="dropdown-menu">
       <li>
        <a tabindex="-1" href="<?php echo base_url() . 'login/sign_out' ?>">Logout</a>
       </li>
      </ul>
     </li>
    </ul>
    <ul class="nav">
     <?php if ($this->session->userdata('access_pengawas')) { ?>
<!--      <li class="">
       <a href="<?php echo base_url() . 'dashboard' ?>">Dashboard</a>
      </li>     -->
     <?php } ?>     
    </ul>
   </div>
   <!--/.nav-collapse -->
  </div>
 </div>
</div>