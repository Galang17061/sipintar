<div class="span3" id="sidebar">
 <div class="content_data-left">
  <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
   <?php if ($this->session->userdata('access_pengawas')) { ?>
    <li class="active">
     <a data-target="slide-out" class="sidenav-trigger" 
        href="#" onclick="Template.getSideMenu(this, event)"><i class="mdi mdi-menu mdi-18px">
       &nbsp;
      </i><?php echo isset($ujian) ? 'Menu' : 'Menu' ?></a>
    </li>
   <?php } else { ?>
    <li class="active">
     <!--<a href="<?php echo isset($ujian) ? '#' : base_url() . 'dashboard' ?>"><?php echo isset($ujian) ? 'Menu' : 'Menu' ?></a>-->     
     <a data-target="slide-out" class="sidenav-trigger" 
        href="#" onclick="Template.getSideMenu(this, event)"><i class="mdi mdi-menu mdi-18px">
       &nbsp;
      </i><?php echo isset($ujian) ? 'Menu' : 'Menu' ?></a>
    </li>
   <?php } ?>
   <?php if ($this->session->userdata('access') == 'guru') { ?>
    <li>
     <a href="<?php echo base_url() . 'nilai' ?>">Nilai Ujian Siswa
      <span class="badge badge-warning pull-right"><?php echo isset($jumlah_data_nilai) ? $jumlah_data_nilai : '' ?></span>
     </a>
    </li>
   <?php } ?>

  </ul>
 </div> 
 <br/>
 <?php if ($this->session->userdata('ujian') != '') { ?>
  <?php if (isset($total_soal)) { ?>
   <?php echo $total_soal ?>
  <?php } ?>
 <?php } ?>

 <!--<a class="btn-floating btn-large waves-effect waves-light green" onclick=""><i class="mdi mdi-menu"></i></a>-->
</div>
