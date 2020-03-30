<?php

class Pengaturan_nilai extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'pengaturan_nilai';
 }

 public function getTableName() {
  return 'pengaturan_nilai';
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
  $data['view_file'] = 'pengaturan_nilai_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_pengaturan_nilai'] = $this->getDataPengaturanNilai();
  echo Modules::run('template', $data);
 }

 public function getDataPengaturanNilai() {
  $query['table'] = $this->getTableName() . ' pn';
  $data = Modules::run('database/get', $query);
  
  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function tampilkan($id) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
   Modules::run('database/_update', $this->getTableName(), 
   array('show'=> true), array('id'=> $id));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }
  
  echo json_encode(array('is_valid' => $is_valid));
 }
 
 public function tidakTampilkan($id) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
   Modules::run('database/_update', $this->getTableName(), 
   array('show'=> false), array('id'=> $id));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }
  
  echo json_encode(array('is_valid' => $is_valid));
 }
}
