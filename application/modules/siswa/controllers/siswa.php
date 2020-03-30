<?php

class Siswa extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'siswa';
 }

 public function getTableName() {
  return 'siswa';
 }

 public function getHeaderJSandCSS() {
  $data = array(
      '<script src="' . base_url() . 'assets/js/message.js"></script>',
      '<script src="' . base_url() . 'assets/js/validation.js"></script>',
      '<script src="' . base_url() . 'assets/js/url.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/' . $this->getModuleName() . '_v1.js"></script>'
  );

  return $data;
 }

 public function index() {
  $base_url = base_url() . $this->getModuleName() . '/index/';
  $total_rows = count($this->getDataSiswa());
  $offset = $this->uri->segment(3);
  $data['view_file'] = 'siswa_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_siswa'] = $this->getDataSiswa(5, $offset);

  $data['pagination'] = Modules::run('pagination/set_paging', $base_url, base_url() . $this->getModuleName(),
                  $total_rows, 5);
  echo Modules::run('template', $data);
 }

 public function search() {
//  $keyword = $this->input->post('keyword');
//  $base_url = base_url(). $this->getModuleName().'/search/';
//  $first_url = base_url(). $this->getModuleName().'/search';
//  $total_rows = count($this->getDataSiswa());
//  $offset = $this->uri->segment(4);
  $data['module'] = $this->getModuleName();
  $data['data_siswa'] = $this->getDataSiswa(5);
//  $data['pagination'] = Modules::run('pagination/set_paging', $base_url, $first_url, 
//   $total_rows, 5);
  echo $this->load->view('siswa_search_view', $data, true);
 }

 public function getDataSiswa($limit = '', $offset = '') {
  $keyword = $this->input->post('keyword');
  $query['table'] = $this->getTableName() . ' s';
  $query['field'] = array('s.id', 's.nama',
      's.nis', 's.password', 'j.jurusan', 's.is_login');
  $query['join'] = array(
      array('jurusan j', 's.jurusan = j.id'),
  );
  if ($limit != '') {
   $query['limit'] = $limit;
   $query['offset'] = $offset;
  }

  $query['where'] = array('deleted' => 0);

  if ($keyword != '') {
   $query['is_or_like'] = true;
   $query['like'] = array(
       array('s.id', $keyword),
       array('s.nama', $keyword),
       array('s.nis', $keyword),
       array('s.password', $keyword),
       array('j.jurusan', $keyword)
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
  $data['view_file'] = 'siswa_add_view';
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['list_jurusan'] = $this->getListJurusan();
  echo Modules::run('template', $data);
 }

 public function edit($id) {
  $data = Modules::run('database/get', array(
              'table' => $this->getTableName() . ' s',
              'field' => array('s.*'),
              'join' => array(
                  array('jurusan j', 's.jurusan = j.id'),
              ),
              'where' => array('s.id' => $id)
          ))->row_array();
  $data['view_file'] = 'siswa_add_view';
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['list_jurusan'] = $this->getListJurusan();
  echo Modules::run('template', $data);
 }

 public function getListJurusan() {
  $data = Modules::run('database/get', array(
              'table' => 'jurusan'
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
  $data['kelas'] = $value->kelas;
  $data['nis'] = $value->nis;
  $data['password'] = $value->password;
  $data['jurusan'] = $value->jurusan;

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
//   Modules::run('database/_delete', 'siswa_has_kategori_random_soal', array('siswa' => $id));
//   Modules::run('database/_delete', 'siswa_has_jawaban', array('siswa' => $id));
//   Modules::run('database/_delete', 'siswa_has_ujian', array('siswa' => $id));
//   Modules::run('database/_delete', $this->getTableName(), array('id' => $id));
   Modules::run('database/_update', $this->getTableName(), array('deleted' => 1), array('id' => $id));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function resetLogin($siswa) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
   Modules::run('database/_update', $this->getTableName(), array('is_login' => false), array('id' => $siswa));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function importSiswa() {
  $data = array();
  // echo 'asdasd';die;
  echo $this->load->view($this->getModuleName() . '_importSiswa_view', $data, true);
 }

 public function getDataJurusan($jurusan) {
  $data = Modules::run('database/get', array(
              'table' => 'jurusan',
              'like' => array(
                  array('jurusan', $jurusan)
              )
  ));

  $id = 0;
  if (!empty($data)) {
   $data = $data->row_array();
   $id = $data['id'];
  } else {
   //insert
   $id = Modules::run('database/_insert', 'jurusan',
                   array(
                       'jurusan' => $jurusan
   ));
  }

  return $id;
 }

 public function execUploadFileSiswa() {
  $data = json_decode($this->input->post('data'));
  $is_valid = false;
  $this->db->trans_begin();
  try {
   foreach ($data as $value) {
    if (strtolower($value[0]) != 'no' && strtolower($value[0]) != 'no.' && $value[0] != '') {
     $jurusan = $value[4];
     $jurusan_id = $this->getDataJurusan($jurusan);
     $data_siswa['nama'] = $value[1];
     $data_siswa['kelas'] = $value[2];
     $data_siswa['nis'] = $value[3];
     $data_siswa['jurusan'] = $jurusan_id;
     $data_siswa['password'] = $value[5];
     Modules::run('database/_insert', 'siswa', $data_siswa);
    }
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function removeAll() {
  $data = json_decode($_POST['data']);
//  echo '<pre>';
//  print_r($data);
  $is_valid = false;

  if (!empty($data)) {
   foreach ($data as $value) {
    $this->db->trans_begin();
    try {
     $id = $value->id;
     Modules::run('database/_update', $this->getTableName(), array('deleted' => 1), array('id' => $id));
//     Modules::run('database/_delete', 'siswa_has_kategori_random_soal', array('siswa' => $id));
//     Modules::run('database/_delete', 'siswa_has_jawaban', array('siswa' => $id));
//     Modules::run('database/_delete', 'siswa_has_ujian', array('siswa' => $id));
//     Modules::run('database/_delete', $this->getTableName(), array('id' => $id));
     $this->db->trans_commit();
     $is_valid = true;
    } catch (Exception $ex) {
     $this->db->trans_rollback();
    }
   }
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

}