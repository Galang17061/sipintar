<?php

class Membuat_ujian extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'membuat_ujian';
 }

 public function getTableName() {
  return 'ujian';
 }

 public function getHeaderJSandCSS() {
  $data = array(
   '<script src="' . base_url() . 'assets/js/message.js"></script>',
   '<script src="' . base_url() . 'assets/js/validation.js"></script>',
   '<script src="' . base_url() . 'assets/js/url.js"></script>',
   '<script src="' . base_url() . 'assets/js/controllers/' . $this->getModuleName() . '.js"></script>'
  );

  return $data;
 }

 public function index() {
  $data['view_file'] = 'membuat_ujian_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_membuat_ujian'] = $this->getDataUjian();
  echo Modules::run('template', $data);
 }

 public function getDataUjian() {
  $keyword = $this->input->post('keyword');
  $guru = $this->session->userdata('id');

  $query['table'] = $this->getTableName().' uj';
  $query['field'] = array('uj.id', 'uj.nama_ujian', 'uj.kode_ujian',
  'g.nama as guru', 'ku.kategori_ujian', 'uj.tanggal_ujian', 
  'uj.createddate as tanggal_dibuat', 'g.nip', 'uj.waktu_ujian', 'uj.token');
  $query['join'] = array(
   array('guru g', 'uj.guru = g.id'),
   array('kategori_ujian ku', 'uj.kategori_ujian = ku.id'),
  );
  $query['where'] = "(uj.status != 'Ready' and uj.status != 'In Progress' and uj.status != 'Done') and uj.guru = '".$guru."'";
  if ($keyword != '') {
   $query['is_or_like'] = true;
   $query['like'] = array(
    array('uj.nama_ujian', $keyword),
    array('uj.kode_ujian', $keyword),
    array('uj.tanggal_ujian', $keyword),
    array('uj.waktu_ujian', $keyword),
    array('uj.createddate', $keyword),
    array('g.nama', $keyword),
    array('g.nip', $keyword),
    array('ku.kategori_ujian', $keyword),
   );
  }

  $data = Modules::run('database/get', $query);

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['pengawas_ujian'] = $this->getDataPengawasUjian($value['id']);
    $value['has_soal'] = $this->hasSoalUjian($value['id']);
    $value['jumlah_soal'] = $this->getDataJumlahSoalUjian($value['id']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getDataJumlahSoalUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian_has_soal',
  'where' => array('ujian'=> $ujian)
  ));
  
  $jumlah = 0;
  if(!empty($data)){
   $jumlah = count($data->result_array());
  }
  
  return $jumlah;
 }
 
 public function hasSoalUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian_has_soal',
  'where' => array('ujian'=> $ujian)
  ));
  
  $is_exist = false;
  if(!empty($data)){
   $is_exist = true;
  }
  
  return $is_exist;
 }
 
 public function getDataPengawasUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian_has_pengawas uhp',
  'field' => array('uhp.id', 'g.nama as pengawas_ujian'),
  'join' => array(
  array('ujian uj', 'uhp.ujian = uj.id'),
  array('pengawas_ujian pu', 'uhp.pengawas_ujian = pu.id'),  
  array('guru g', 'pu.guru = g.id')  
  ),
  'where' => array('uhp.ujian'=> $ujian)
  ));
  
  $pengawas = "";
  if(!empty($data)){
   $result = array();
   foreach ($data->result_array() as $value) {
    array_push($result, $value['pengawas_ujian']);
   }
   $pengawas = implode(',', $result);
  }
  
  return $pengawas;
 }
 
 public function getListKategoriUjian() {
  $data = Modules::run('database/get', array(
  'table' => 'kategori_ujian'
  ));
  
  $result =array();
  if(!empty($data)){
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }
  
  return $result;
 }

 public function getListDataPengawasUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian_has_pengawas uhp',
  'field' => array('uhp.id', 'gr.id as guru'),
  'join' => array(
   array('pengawas_ujian pu', 'uhp.pengawas_ujian = pu.id'),
   array('guru gr', 'pu.guru = gr.id')
  ),
  'where' => array('uhp.ujian'=> $ujian)
  ));
  return $data->result_array();
 }
 
 public function edit($id) {
  $data = Modules::run('database/get', array(
    'table' => $this->getTableName().' uj', 
    'where' => array('uj.id' => $id)
   ))->row_array();

  list($jam_ujian, $menit_ujian) = explode(':', $data['waktu_ujian']);
  $data['pengawas_ujian'] = $this->getListDataPengawasUjian($data['id']);
  $data['jam_ujian'] = $jam_ujian;
  $data['menit_ujian'] = $menit_ujian;
  $data['view_file'] = 'membuat_ujian_add_view';
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['list_kategori_ujian'] = $this->getListKategoriUjian();
  $data['list_pengawas'] = $this->getListPengawas();
  $data['list_jam'] = $this->getListJam();
  $data['list_menit'] = $this->getListMenit();
  echo Modules::run('template', $data);
 }
 
 public function add() {
  $data['view_file'] = 'membuat_ujian_add_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['list_kategori_ujian'] = $this->getListKategoriUjian();
  $data['list_pengawas'] = $this->getListPengawas();
  $data['list_jam'] = $this->getListJam();
  $data['list_menit'] = $this->getListMenit();
  echo Modules::run('template', $data);
 }

 public function getListJam() {
  return array(
   '01','02','03','04','05','06','07','08','09','10',
   '11','12','13','14','15','16','17','18','19','20',
   '21','22','23','24'
  );
 }
 
 public function getListMenit() {
  return array(
   '00','01','02','03','04','05','06','07','08','09','10',
   '11','12','13','14','15','16','17','18','19','20',
   '21','22','23','24', '25','26','27','28', '29', '30',
   '31','32','33','34', '35','36','37','38', '39', '40',
   '41','42','43','44', '45','46','47','48', '49', '50',
   '51','52','53','54', '55','56','57','58', '59'
  );
 }  
 
 public function generateTokenUjian() {
  $token = "abcdefghijklmnopqrstuvwxyz0123456789";
  $token = str_shuffle($token);
  $token = substr($token, 0, 5);
  
  $data = Modules::run('database/get', array(
    'table' => 'ujian',
    'where' => array('token'=> $token)
  ));
  
  while (!empty($data)) {
   $token = $this->generateTokenUjian();
  }
  
  return $token;
 }
 
 public function get_post_data($value) {
  $data['id'] = $value->id;
  $data['kode_ujian'] = Modules::run('no_generator/generateKodeUjian');
  $data['token'] = $this->generateTokenUjian();
  $data['guru'] = $this->session->userdata('id');
  $data['nama_ujian'] = $value->nama_ujian;
  $data['tanggal_ujian'] = $value->tanggal_ujian;
  $data['kategori_ujian'] = $value->kategori_ujian;
  $data['waktu_ujian'] = $value->jam_ujian.':'.$value->menit_ujian;
  $data['status'] = 'New';
  
  if($value->id != ''){
   unset($data['status']);
   unset($data['kode_ujian']);
  }
  return $data;
 }

 public function get_post_pengawas($value) {
  $data['guru'] = $value->pengawas_ujian;
  
  return $data;
 }
 
 public function isExistPengawas($guru) {
  $data = Modules::run('database/get', array(
  'table' => 'pengawas_ujian',
  'where' => array('guru'=> $guru)
  ));
  
  $is_exist = false;
  if(!empty($data)){
   $is_exist = true;
  }
  
  return $is_exist;
 }
 
 public function getIdPengawas($guru) {
  $data = Modules::run('database/get', array(
  'table' => 'pengawas_ujian',
  'where' => array('guru'=> $guru)
  ))->row_array();
  
  return $data['id'];
 }
 
 public function get_post_ujian_has_pengawas($pengawas_ujian, $ujian) {
  $data['pengawas_ujian'] = $pengawas_ujian;
  $data['ujian'] = $ujian;
  
  return $data;
 }
 
 public function existUjianHasPengawas($pengawas, $ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian_has_pengawas',
  'where' => array('pengawas_ujian'=> $pengawas, 'ujian'=> $ujian)
  ));
  
  $is_exist = false;
  if(!empty($data)){
   $is_exist = true;
  }
  
  return $is_exist;
 }
 
 public function save() {
  $data = json_decode($this->input->post('data'));
  $data_membuat_ujian = $this->get_post_data($data);
  $id = $data->id;
  
  $is_valid = false;

  $this->db->trans_begin();
  try {   
   if (is_numeric($id)) {    
    foreach ($data->pengawas_ujian as $v_pengawas) {
     if (!$this->isExistPengawas($v_pengawas->pengawas_ujian)) {
      $data_pengawas = $this->get_post_pengawas($v_pengawas);
      $pengawas_ujian = Modules::run('database/_insert', 'pengawas_ujian', $data_pengawas);
     }
    }
    
    $ujian = $id;
    Modules::run('database/_update', $this->getTableName(), $data_membuat_ujian, array('id' => $id));
    foreach ($data->pengawas_ujian as $v_pengawas) {
     $pengawas_ujian = $this->getIdPengawas($v_pengawas->pengawas_ujian);
     $data_ujian_has_pengawas = $this->get_post_ujian_has_pengawas($pengawas_ujian, $ujian);
     $is_exist_ujian_has_pengawas = $this->existUjianHasPengawas($pengawas_ujian, $ujian);
     if($is_exist_ujian_has_pengawas){
      Modules::run('database/_update', 'ujian_has_pengawas', $data_ujian_has_pengawas, 
      array('pengawas_ujian'=> $pengawas_ujian, 'ujian'=> $ujian));
     }else{
      $ujian_has_pengawas = Modules::run('database/_insert', 'ujian_has_pengawas', $data_ujian_has_pengawas);
     }     
    }
   } else {
    foreach ($data->pengawas_ujian as $v_pengawas) {
     if (!$this->isExistPengawas($v_pengawas->pengawas_ujian)) {
      $data_pengawas = $this->get_post_pengawas($v_pengawas);
      $pengawas_ujian = Modules::run('database/_insert', 'pengawas_ujian', $data_pengawas);
     }
    }
    
    $ujian = Modules::run('database/_insert', 'ujian', $data_membuat_ujian);
    foreach ($data->pengawas_ujian as $v_pengawas) {
     $pengawas_ujian = $this->getIdPengawas($v_pengawas->pengawas_ujian);
     $data_ujian_has_pengawas = $this->get_post_ujian_has_pengawas($pengawas_ujian, $ujian);
     $ujian_has_pengawas = Modules::run('database/_insert', 'ujian_has_pengawas', $data_ujian_has_pengawas);
    }
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }
  echo json_encode(array('is_valid' => $is_valid));
 }

 public function getListPengawas() {
  $data = Modules::run('database/get', array(
  'table' => 'guru'
  ));
  
  $result = array();
  if(!empty($data)){
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }
  return $result;
 }
 
 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_membuat_ujian'] = $this->getDataUjian();
  echo $this->load->view('membuat_ujian_search_view', $data, true);
 }

 
 public function remove($id) {
  echo $id;die;
  $is_valid = false;
  $this->db->trans_begin();
  try {
   Modules::run('database/_delete', $this->getTableName(), array('id' => $id));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function masukkanSoal($ujian) {
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');
  $data['title'] = 'Pilih Soal';
  $data['ujian'] = $ujian;
  $data['data_ujian'] = $this->getDataUjianbyUjian($ujian);
  $data['list_kategori'] = $this->getListKategoriSoal($mata_pelajaran);
  $data['data_bank_soal'] = Modules::run('bank_soal/getDataBankSoal');
//  echo '<pre>';
//  print_r($data);die;
  echo $this->load->view($this->getModuleName() . '_masukkanSoal_view', $data, true);
 }
 
 public function masukkanSoalListening($ujian) {
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');
  $data['title'] = 'Pilih Soal';
  $data['ujian'] = $ujian;
  $data['data_ujian'] = $this->getDataUjianbyUjian($ujian);
  $data['list_kategori'] = $this->getListKategoriSoal($mata_pelajaran);
  $data['data_bank_soal'] = Modules::run('bank_soal_listening/getDataBankSoal');
  echo $this->load->view($this->getModuleName() . '_masukkanSoalListening_view', $data, true);
 }
 
 public function getDataUjianbyUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian',
  'where' => array('id'=> $ujian)
  ));
  
  $result = array();
  if(!empty($data)){
   $result = $data->row_array();
  }
  
  return $result;
 }
 
 public function getListKategoriSoal($mata_pelajaran) {
  $data = Modules::run('database/get', array(
  'table' => 'kategori_soal',
  'where' => array('mata_pelajaran'=> $mata_pelajaran)
  ));
  
  $result = array();
  if(!empty($data)){
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }
  
  return $result;
 }
 
 public function filterSiswaByKategoriSoal($kategori_soal = '') {
  $data['data_bank_soal'] = Modules::run('bank_soal/getDataBankSoalbyKategoriSoal', $kategori_soal);  
  echo $this->load->view($this->getModuleName() . '_filterSiswaByKategoriSoal_view', $data, true);
 }
 
 public function filterSiswaByKategoriSoalListening($kategori_soal = '') {
  $data['data_bank_soal'] = Modules::run('bank_soal_listening/getDataBankSoalbyKategoriSoal', $kategori_soal);  
  echo $this->load->view($this->getModuleName() . '_filterSiswaByKategoriSoalListening_view', $data, true);
 }
 
 public function execSimpanSoalHasUjian() {
  $data = json_decode($this->input->post('data'));
  $ujian = $data->ujian;

  $is_valid = false;
  $this->db->trans_begin();
  try {
   foreach ($data->soal as $value) {
    $data_ujian_has_soal['ujian'] = $ujian;
    $data_ujian_has_soal['soal'] = $value->id;    
    $ujian_has_soal = Modules::run('database/_insert', 'ujian_has_soal', $data_ujian_has_soal);
   }   
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }
  
  echo json_encode(array('is_valid' => $is_valid));
 }
 
 public function submitDataUjian($ujian) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
   Modules::run('database/_update', 'ujian', array('status'=> 'Ready'), array('id'=> $ujian));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }
  
  echo json_encode(array('is_valid' => $is_valid));
 }
}
