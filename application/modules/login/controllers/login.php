<?php

class Login extends MX_Controller {

 public function index() {
//  echo $this->load->view('login_index_view', array(), true);
  
    echo $this->load->view('login_new', array(), true);
 }

 public function getDataUserAdmin($username, $password) {
  $data = Modules::run('database/get', array(
    'table' => 'admin',
    'where' => array('username' => $username, 'password' => $password)
  ));

  return $data;
 }

 public function checkisNilaiActive() {
  $data = Modules::run('database/get', array(
  'table' => 'pengaturan_nilai'
  ))->row_array();
  return $data['show'];  
 }
 
 public function sign_in() {
  $username = $this->input->post('username');
  $password = $this->input->post('password');  
  
  $is_valid = false;
  $is_siswa = false;
  try {
   $data = $this->getDataUserAdmin($username, $password);     
   if (!empty($data)) {
    $data = $data->row_array();
    $data['access'] = Modules::run('role_access/getAccess', 'admin');
    $data['access_pengawas'] = false;
    $is_valid = true;
   } else {
    //cek di guru
    $data = $this->getDataUserGuru($username, $password);
    if (!empty($data)) {     
      // Return only the first row
     $data = $data->row_array();
     $data['access'] = Modules::run('role_access/getAccess', 'guru');
     $data['access_pengawas'] = Modules::run('role_access/hasAccessPengawas', $data['id']);
     $is_valid = true;
    } else {
     $data = $this->getDataSiswa($username, $password);
     if (!empty($data)) {
      $data = $data->row_array();
      $data['access'] = Modules::run('role_access/getAccess', 'siswa');
      $data['access_pengawas'] = false;
      $message =$this->updateStatusSiswaLogin($username);
      $is_siswa = true;
      $is_valid = true;
     }
    }
   }
  } catch (Exception $exc) {
   $is_valid = false;
  }

  if ($is_valid) {   
   $this->setSessionData($data);
  }
  echo json_encode(array('is_valid' => $is_valid, 'is_siswa'=> $is_siswa));
 }

 public function getDataUserGuru($username, $password) {
  $data = Modules::run('database/get', array(
    'table' => 'guru g',
    'field' => array('g.nip as username', 'g.id', 'mp.mata_pelajaran as mapel', 'g.mata_pelajaran'),
    'join' => array(
     array('mata_pelajaran mp', 'g.mata_pelajaran = mp.id')
    ),
    'where' => array('g.nip' => $username, 'g.password' => $password)
  ));

  return $data;
 }

 public function getDataSiswa($username, $password) {
  $data = Modules::run('database/get', array(
    'table' => 'siswa s',
    'field' => array('s.id', 's.nis as username', 'shu.ujian'),
    'join' => array(
     array('siswa_has_ujian shu', 's.id = shu.siswa', 'left'),
     array('ujian uj', 'shu.ujian = uj.id', 'left'),
    ),
    'where' => "(s.nis = '" . $username . "' and s.password = '" . $password . "') "
    . "and (s.is_login = 0 or s.is_login is null)",
    'orderby'=> 'uj.id desc'
  ));

  return $data;
 }

 public function setSessionData($data) {
  $session['id'] = $data['id'];
  $session['username'] = $data['username'];
  $session['access'] = $data['access'];
  $session['access_pengawas'] = $data['access_pengawas'];
  $session['ujian'] = isset($data['ujian']) ? $data['ujian'] : '';
  $session['mata_pelajaran'] = isset($data['mata_pelajaran']) ? $data['mata_pelajaran'] : '';
  $session['mapel'] = isset($data['mapel']) ? $data['mapel'] : '';
  $session['nilai_active'] = $this->checkisNilaiActive();
  $this->session->set_userdata($session);
 }
 
 public function updateStatusSiswaLogin($username) {
  $ujian = $this->session->userdata('ujian');
  $is_login = $ujian != '' ? 0 : 1;
  Modules::run('database/_update', 'siswa', array('is_login'=> $is_login), array('nis'=> $username));
 }
 
 public function getNisSiswa($id) {
  $data = Modules::run('database/get', array(
    'table' => 'siswa',
    'where' => array('id'=> $id)
  ));
  $data = $data->row_array();
  return $data['nis'];
 }
 
 public function sign_out() {
  $ujian = $this->session->userdata('ujian');
  $id = $this->session->userdata('id');
  if($ujian != ''){
   $username = $this->getNisSiswa($id);
   $this->updateStatusSiswaLogin($username);
  }

  $this->session->sess_destroy();
  redirect(base_url());
 }

}