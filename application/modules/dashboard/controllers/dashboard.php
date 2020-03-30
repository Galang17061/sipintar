<?php

class Dashboard extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'dashboard';
 }
 
 public function getHeaderJSandCSS() {
  $data = array(
      '<script src="' . base_url() . 'assets/js/message.js"></script>',
      '<script src="' . base_url() . 'assets/js/validation.js"></script>',
      '<script src="' . base_url() . 'assets/js/url.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/' . $this->getModuleName() . '.js"></script>',
  );

  return $data;
 
 }
 
 public function index() {
//  echo '<pre>';
//  print_r($this->session->all_userdata());die;
  $guru = $this->session->userdata('id');
  $data['view_file'] = 'dashboard_index_view';
  $data['module'] = $this->getModuleName();
  $data['header_data'] = $this->getHeaderJSandCSS();
//  $data['peserta_ujian'] = $this->getDataPesertaUjian();
  $data['peserta_ujian'] = array();
//  $data['peserta_submit'] = $this->getDataPesertaUjianSubmit();
  $data['peserta_submit'] = array();
  $data['data_ujian'] = $this->getDataUjian($guru);  
//  echo '<pre>';
//  print_r($data);die;
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function getDataUjian() {
  $data = Modules::run('database/get', array(
  'table' => 'ujian uj',
  'field'=> array('uj.id', 
  'uj.guru', 'uj.kode_ujian', 'mp.mata_pelajaran', 
  'uj.tanggal_ujian', 'uj.waktu_ujian', 'uj.nama_ujian'),
  'join'=> array(
   array('guru g', 'uj.guru = g.id'),
   array('mata_pelajaran mp', 'g.mata_pelajaran = mp.id')
  ),
  'where'=> array('uj.status'=> 'In Progress', 'uj.deleted'=> 0)
  ));
  
//  echo "<pre>";
//  echo $this->db->last_query();
//  die;
  $result = array();
  if(!empty($data)){
   foreach ($data->result_array() as $value) {
    $is_pengawas = Modules::run('role_access/hasAccessPengawas', $value['guru']);
    $is_exist_ujian = Modules::run('rule_ujian/isDateUjian', $value['id']);        
    if($is_pengawas && $is_exist_ujian){
     array_push($result, $value);
    }    
   }
  }
  
  return $result;
 }
 
 public function getDataPeserta($ujian) {
  $data['peserta_ujian'] = $this->getDataPesertaUjian($ujian);
  $jumlah_peserta_ujian = count($this->getDataPesertaUjian($ujian));
  $data['peserta_submit'] = $this->getDataPesertaUjianSubmit($ujian);
  $jumlah_peserta_submit = count($this->getDataPesertaUjianSubmit($ujian));
  $view_peserta_ujian = $this->load->view($this->getModuleName().'_getDataPesertaUjian_view', $data, true);
  $view_peserta_submit = $this->load->view($this->getModuleName().'_getDataPesertaUjianSubmit_view', $data, true);  
  echo json_encode(
   array(
   'view_peserta_ujian' => $view_peserta_ujian,
   'view_peserta_submit' => $view_peserta_submit,
   'jumlah_peserta_ujian' => $jumlah_peserta_ujian,
   'jumlah_peserta_submit' => $jumlah_peserta_submit
   )
  );
 }
 
 public function getDataPesertaUjian($ujian) {
  $data = Modules::run('database/get', array(
    'table' => 'siswa_has_ujian shu',
    'field' => array('s.nama as siswa', 's.nis', 's.is_login'),
    'join' => array(
     array('siswa s', 'shu.siswa = s.id'),
     array('ujian uj', 'shu.ujian = uj.id'),
    ),
    'where' => "uj.status = 'In Progress' and uj.id = '".$ujian."'",
    'orderby'=> 'uj.tanggal_ujian asc, uj.waktu_ujian asc'
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getDataPesertaUjianSubmit($ujian) {
  $data = Modules::run('database/get', array(
    'table' => 'siswa_has_ujian shu',
    'field' => array(
     'shu.id as shu_id', 'uj.id as ujian',
     's.nama as siswa', 's.nis',
     'shu.status'
    ),
    'join' => array(
     array('ujian uj', 'shu.ujian = uj.id'),
     array('siswa s', 'shu.siswa = s.id'),
    ),
    'where' => "shu.status = 'Done' and shu.ujian = '".$ujian."'"
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }


  return $result;
 }

}
