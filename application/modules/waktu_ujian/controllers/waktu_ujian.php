<?php

class Waktu_ujian extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'waktu_ujian';
 }

 public function getTableName() {
  return 'time_limit';
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
  $base_url = base_url() . $this->getModuleName() . '/index/';
  $total_rows = count($this->getDataWaktuUjian());
  $offset = $this->uri->segment(3);
  
  $data['view_file'] = 'waktu_ujian_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_waktu_ujian'] = $this->getDataWaktuUjian(5, $offset);
  $data['pagination'] = Modules::run('pagination/set_paging', $base_url, base_url() . $this->getModuleName(), 
   $total_rows, 5);
  echo Modules::run('template', $data);
 }

 public function getDataWaktuUjian($limit = '', $offset = '') {
  $keyword = $this->input->post('keyword');
  $query['table'] = $this->getTableName();
  $query['field'] = array();

  if ($limit != '') {
   $query['limit'] = $limit;
   $query['offset'] = $offset;
  }
  
  if ($keyword != '') {
   $query['like'] = array(
    array('time_limit', $keyword)
   );
  }
  
  $query['where'] = array('deleted'=> 0);

  $data = Modules::run('database/get', $query);

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function add() {
  $data['view_file'] = 'waktu_ujian_add_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function get_post_data($value) {
  $data['id'] = $value->id;
  $data['time_limit'] = $value->time_limit;
  return $data;
 }

 public function save() {
  $data = json_decode($this->input->post('data'));
  $id = $data->id;

  $is_valid = false;

  $this->db->trans_begin();
  try {
   $data_waktu_ujian = $this->get_post_data($data);
   if (is_numeric($id)) {
    Modules::run('database/_update', $this->getTableName(), $data_waktu_ujian, array('id' => $id));
   } else {
    $waktu_ujian = Modules::run('database/_insert', $this->getTableName(), $data_waktu_ujian);
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }
  echo json_encode(array('is_valid' => $is_valid));
 }

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_waktu_ujian'] = $this->getDataWaktuUjian();
  echo $this->load->view('waktu_ujian_search_view', $data, true);
 }

 public function checkWaktuDipakaiUjian($waktu) {
  
 }
 
 public function remove($id) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
//   Modules::run('database/_delete', $this->getTableName(), array('id' => $id));
   Modules::run('database/_update', $this->getTableName(), array('deleted'=> 1), array('id' => $id));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

}
