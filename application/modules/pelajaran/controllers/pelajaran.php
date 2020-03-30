<?php

class Pelajaran extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'pelajaran';
 }

 public function getTableName() {
  return 'mata_pelajaran';
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
  $total_rows = count($this->getDataPelajaran());
  $offset = $this->uri->segment(3);
  
  $data['view_file'] = 'pelajaran_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_pelajaran'] = $this->getDataPelajaran(5, $offset);
  
  $data['pagination'] = Modules::run('pagination/set_paging', $base_url, base_url() . $this->getModuleName(), 
   $total_rows, 5);
  echo Modules::run('template', $data);
 }

 public function getDataPelajaran($limit= '', $offset='') {
  $keyword = $this->input->post('keyword');
  $query['table'] = $this->getTableName();
  $query['field'] = array();

  if ($limit != '') {
   $query['limit'] = $limit;
   $query['offset'] = $offset;
  }
  
  if ($keyword != '') {
   $query['like'] = array(
    array('mata_pelajaran', $keyword)
   );
  }

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
  $data['view_file'] = 'pelajaran_add_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function edit($id) {
  $data = Modules::run('database/get', array(
    'table' => $this->getTableName(),
    'where' => array('id' => $id)
   ))->row_array();
  $data['view_file'] = 'pelajaran_add_view';
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  echo Modules::run('template', $data);
 }

 public function get_post_data($value) {
  $data['id'] = $value->id;
  $data['mata_pelajaran'] = $value->mata_pelajaran;

  return $data;
 }

 public function save() {
  $data = json_decode($this->input->post('data'));
  $id = $data->id;

  $is_valid = false;

  $this->db->trans_begin();
  try {
   $data_pelajaran = $this->get_post_data($data);
   if (is_numeric($id)) {
    Modules::run('database/_update', $this->getTableName(), $data_pelajaran, array('id' => $id));
   } else {
    $pelajaran = Modules::run('database/_insert', $this->getTableName(), $data_pelajaran);
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
  $data['data_pelajaran'] = $this->getDataPelajaran();
  echo $this->load->view('pelajaran_search_view', $data, true);
 }

 public function remove($id) {
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

}
