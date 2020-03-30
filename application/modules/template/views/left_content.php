
<nav class="pcoded-navbar">
  <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
  <div class="pcoded-inner-navbar main-menu">

    <div class="pcoded-navigatio-lavel pscode-upper" data-i18n="nav.category.navigation">Menu</div>
    <ul class="pcoded-item pcoded-left-item">
      <li class="">
        <a href="<?php echo base_url().'dashboard' ?>">
          <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
          <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
          <span class="pcoded-mcaret"></span>
        </a>
      </li>

      <?php if ($this->session->userdata('access') == 'admin') { ?>
        <li class="pcoded-hasmenu">
          <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Administrator</span>
            <span class="pcoded-mcaret"></span>
          </a>
          <ul class="pcoded-submenu">
            <li class=" ">
              <a href="<?php echo base_url() . 'siswa' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Siswa</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'guru' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Guru</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'pelajaran' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Mata Pelajaran</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'jurusan' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Jurusan</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'waktu_ujian' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Batas Waktu Ujian</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
          </ul>
        </li>
      <?php } ?>
    </ul>
    <div class="pcoded-navigatio-lavel pscode-upper" data-i18n="nav.category.forms">Pengajar</div>

    <ul class="pcoded-item pcoded-left-item">
      <?php if ($this->session->userdata('access') == 'guru' ||
      $this->session->userdata('access') == 'admin') { ?>
        <li class="pcoded-hasmenu">
          <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Pengajar</span>
            <span class="pcoded-mcaret"></span>
          </a>
          <ul class="pcoded-submenu">
            <li class=" ">
              <a href="<?php echo base_url() . 'bank_soal' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Bank Soal</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <?php if (strtolower($this->session->userdata('mapel')) == 'bahasa inggris') { ?>
              <li class=" ">
                <a href="<?php echo base_url() . 'bank_soal_listening' ?>">
                  <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                  <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Bank Soal Listening</span>
                  <span class="pcoded-mcaret"></span>
                </a>
              </li>
            <?php } ?>
            <li class=" ">
              <a href="<?php echo base_url() . 'pengaturan_nilai' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Pengaturan Nilai</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'membuat_ujian' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Membuat Ujian</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'waktu_ujian' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Batas Waktu Ujian</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
          </ul>
        </li>

        <li class="pcoded-hasmenu">
          <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Data Persiapan Ujian</span>
            <span class="pcoded-mcaret"></span>
          </a>
          <ul class="pcoded-submenu">
            <li class=" ">
              <a href="<?php echo base_url() . 'ujian_siap_dilaksanakan' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Ujian Siap Dilaksanakan</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'ujian_sedang_dilaksanakan' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Ujian Sedang Dilaksanakan</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'ujian_selesai_dilaksanakan' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Ujian Selesai Dilaksanakan</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
          </ul>
        </li>
      <?php } ?>
    </ul>

    <div class="pcoded-navigatio-lavel pscode-upper" data-i18n="nav.category.forms">Siswa</div>
    <ul class="pcoded-item pcoded-left-item">
      <?php if ($this->session->userdata('access') == 'siswa' ||
      $this->session->userdata('access') == 'admin') { ?>
        <li class="pcoded-hasmenu">
          <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Data Ujian</span>
            <span class="pcoded-mcaret"></span>
          </a>
          <ul class="pcoded-submenu">
            <li class=" ">
              <a href="<?php echo base_url() . 'daftar_ujian' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Daftar Ujian</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'daftar_ujian_ready' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Daftar Ujian Ready</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <li class=" ">
              <a href="<?php echo base_url() . 'histori_ujian' ?>">
                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Histori Ujian</span>
                <span class="pcoded-mcaret"></span>
              </a>
            </li>
            <?php if ($this->session->userdata('nilai_active')) { ?>
              <li class=" ">
                <a href="<?php echo base_url() . 'nilai' ?>">
                  <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                  <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Nilai Ujian</span>
                  <span class="pcoded-mcaret"></span>
                </a>
              </li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>
    </ul>
    
    <?php if ($this->session->userdata('ujian') != '') { ?>
      <?php if (isset($total_soal)) { ?>    
      <?php echo $total_soal ?>
      <?php } ?>
    <?php } ?>
     

  </div>
</nav>