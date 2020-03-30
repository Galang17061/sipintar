<!--<nav> sdasdasdasd </nav>-->

<ul id="slide-out" class="sidenav">
 <li><div class="user-view">
   <div class="background" style="background-color: #08c">
<!--    <img src="<?php echo base_url() ?>files/images/office.jpg">-->

   </div>
   <br/>
   <a href="#user"><img class="circle" src="<?php echo base_url() ?>files/img/avatar5.png"></a>
   <a href="#name"><span class="white-text name">Username : <?php echo strtoupper($this->session->userdata('username')); ?></span></a>
   <a href="#hak_akses"><span class="white-text email">Hak Akses : <?php echo strtoupper($this->session->userdata('access')); ?></span></a>
  </div></li>
 <li>
  <a href="<?php echo base_url() . 'dashboard' ?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
 </li>
 <!-- <li><a href="#!">Second Link</a></li>-->
 <li><div class="divider"></div></li>
 <?php if ($this->session->userdata('access') == 'admin') { ?>       
  <li><a class="subheader">Master</a></li>
  <li>  
   <a class="waves-effect" href="<?php echo base_url() . 'siswa' ?>"><i class="mdi mdi-database"></i></i>Siswa</a>
  <li>
   <a class="waves-effect" href="<?php echo base_url() . 'guru' ?>"><i class="mdi mdi-database"></i></i>Guru</a>
  </li>
  <li>
   <a class="waves-effect" href="<?php echo base_url() . 'pelajaran' ?>"><i class="mdi mdi-database"></i></i>Mata Pelajaran</a>
  </li>
  <li>
   <a class="waves-effect" href="<?php echo base_url() . 'jurusan' ?>"><i class="mdi mdi-database"></i></i>Jurusan</a>
  </li>
  <li>
   <a class="waves-effect" href="<?php echo base_url() . 'waktu_ujian' ?>"><i class="mdi mdi-database"></i></i>Batas Waktu Ujian</a>
  </li> 
 </li>
<?php } ?> 

<?php if ($this->session->userdata('access') == 'guru') { ?>
 <li><a class="subheader">Data Pengajar</a></li>
 <li class="<?php echo isset($active) ? 'active' : '' ?>">
  <a class="waves-effect" href="<?php echo base_url() . 'bank_soal' ?>"><i class="mdi mdi-database"></i></i>Bank Soal</a>
 </li>           
 <?php if (strtolower($this->session->userdata('mapel')) == 'bahasa inggris') { ?>
  <li class="">
   <a class="waves-effect" href="<?php echo base_url() . 'bank_soal_listening' ?>"><i class="mdi mdi-database"></i></i>Bank Soal Listening</a>
  </li>     
 <?php } ?>
 <li class="">
  <a class="waves-effect" href="<?php echo base_url() . 'pengaturan_nilai' ?>"><i class="mdi mdi-database"></i></i>Pengaturan Nilai</a>
 </li>
 <li class="">
  <a class="waves-effect" href="<?php echo base_url() . 'membuat_ujian' ?>"><i class="mdi mdi-database"></i></i>Membuat Ujian</a>
 </li>


 <li><a class="subheader">Data Persiapan Ujian</a></li>
 <li class="">
  <a class="waves-effect" href="<?php echo base_url() . 'ujian_siap_dilaksanakan' ?>"> 
   &nbsp;&nbsp;&nbsp;<span class="badge badge-warning pull-right"><?php echo isset($jumlah_data_ujian_siap) ? $jumlah_data_ujian_siap : '' ?></span><i class="mdi mdi-database"></i></i>Ujian Siap Dilaksanakan
  </a>
 </li>
 <li class="">
  <a class="waves-effect" href="<?php echo base_url() . 'ujian_sedang_dilaksanakan' ?>"> 
   &nbsp;&nbsp;&nbsp;<span class="badge badge-info pull-right"><?php echo isset($jumlah_data_ujian_sedang) ? $jumlah_data_ujian_sedang : '' ?></span><i class="mdi mdi-database"></i></i>Ujian Sedang Dilaksanakan
  </a>
 </li>
 <li class="">
  <a class="waves-effect" href="<?php echo base_url() . 'ujian_selesai_dilaksanakan' ?>"> 
   &nbsp;&nbsp;&nbsp;<span class="badge badge-success pull-right"><?php echo isset($jumlah_data_ujian_selesai) ? $jumlah_data_ujian_selesai : '' ?></span><i class="mdi mdi-database"></i>Ujian Selesai Dilaksanakan
  </a>
 </li>
<?php } ?>

<?php if ($this->session->userdata('access') == 'siswa') { ?>       
 <li><a class="subheader">Data Ujian</a></li>
 <li>  
  <a class="waves-effect" href="<?php echo base_url() . 'daftar_ujian' ?>"><i class="mdi mdi-menu"></i>Daftar Ujian
   <span class="badge badge-success pull-right"><?php echo isset($jumlah_data_daftar) ? $jumlah_data_daftar : '' ?></span>
  </a>
 <li>
  <a class="waves-effect" href="<?php echo base_url() . 'daftar_ujian_ready' ?>"><i class="mdi mdi-menu"></i>Daftar Ujian Ready
   <span class="badge badge-success pull-right"><?php echo isset($jumlah_data_daftar_ready) ? $jumlah_data_daftar_ready : '' ?></span>
  </a>
 </li>
 <li>
  <a class="waves-effect" href="<?php echo base_url() . 'histori_ujian' ?>"><i class="mdi mdi-menu"></i>Histori Ujian
   <span class="badge badge-success pull-right"><?php echo isset($jumlah_data_histori) ? $jumlah_data_histori : '' ?></span>
  </a>
 </li>
 <?php if ($this->session->userdata('nilai_active')) { ?>
  <li>  
   <a class="waves-effect" href="<?php echo base_url() . 'nilai' ?>"><i class="mdi mdi-menu"></i>Nilai Ujian
    <span class="badge badge-success pull-right"><?php echo isset($jumlah_data_nilai) ? $jumlah_data_nilai : '' ?></span>
   </a>
  </li>
 <?php } ?>
 </li>
<?php } ?> 

<li><div class="divider"></div></li>
<li><a class="subheader">
  <img class="" src="<?php echo base_url() ?>files/img/dapps.png" width="20" height="20"/> &nbsp; Powered by &copy;DAppSolutions</a>
</li>
</ul>