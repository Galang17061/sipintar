<?php

class Guru extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'guru';
 }

 public function getTableName() {
  return 'guru';
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
  $total_rows = count($this->getDataGuru());
  $offset = $this->uri->segment(3);
  
  $data['view_file'] = 'guru_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_guru'] = $this->getDataGuru(5, $offset);
  
  $data['pagination'] = Modules::run('pagination/set_paging', $base_url, base_url().$this->getModuleName() , 
   $total_rows, 5);
  echo Modules::run('template', $data);
 }

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_guru'] = $this->getDataGuru();
  echo $this->load->view('guru_search_view', $data, true);
 }

 public function getDataGuru($limit = '', $offset = '') {
  $keyword = $this->input->post('keyword');
  $query['table'] = $this->getTableName() . ' g';
  $query['field'] = array('g.id', 'g.nama', 'g.nip', 
  'g.password', 'mp.mata_pelajaran');
  $query['join'] = array(
   array('mata_pelajaran mp', 'g.mata_pelajaran = mp.id'),
  );

  if ($limit != '') {
   $query['limit'] = $limit;
   $query['offset'] = $offset;
  }
  
  if ($keyword != '') {
   $query['is_or_like'] = true;
   $query['like'] = array(
    array('g.id', $keyword),
    array('g.nama', $keyword),
    array('g.nip', $keyword),
    array('g.password', $keyword),
    array('mp.mata_pelajaran', $keyword)
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
  $data['view_file'] = 'guru_add_view';
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['list_mapel'] = $this->getListMataPelajaran();
  echo Modules::run('template', $data);
 }

 public function edit($id) {
  $data = Modules::run('database/get', array(
    'table' => $this->getTableName() . ' g',
    'field' => array('g.*'),
    'join' => array(
     array('mata_pelajaran mp', 'g.mata_pelajaran = mp.id'),
    ),
    'where' => array('g.id' => $id)
   ))->row_array();
  $data['view_file'] = 'guru_add_view';
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['list_mapel'] = $this->getListMataPelajaran();
  echo Modules::run('template', $data);
 }

 public function getListMataPelajaran() {
  $data = Modules::run('database/get', array(
    'table' => 'mata_pelajaran'
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function get_post_data($value) {
  $data['id'] = $value->id;
  $data['nama'] = $value->nama;
  $data['nip'] = $value->nip;
  $data['password'] = $value->password;
  $data['mata_pelajaran'] = $value->mata_pelajaran;

  return $data;
 }

 public function save() {
  $data = json_decode($this->input->post('data'));
  $id = $data->id;

  $is_valid = false;

  $this->db->trans_begin();
  try {
   $data_jurusan = $this->get_post_data($data);
   if (is_numeric($id)) {
    Modules::run('database/_update', $this->getTableName(), $data_jurusan, array('id' => $id));
   } else {
    $jurusan = Modules::run('database/_insert', $this->getTableName(), $data_jurusan);
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }
  echo json_encode(array('is_valid' => $is_valid));
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
