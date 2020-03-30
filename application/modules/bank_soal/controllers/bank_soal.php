<?php

class Bank_soal extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'bank_soal';
 }

 public function getTableName() {
  return 'soal';
 }

 public function getHeaderJSandCSS() {
  $data = array(
      '<script src="' . base_url() . 'assets/js/message.js"></script>',
      '<script src="' . base_url() . 'assets/js/validation.js"></script>',
      '<script src="' . base_url() . 'assets/js/url.js"></script>',
      '<script src="' . base_url() . 'assets/js/tinymce/js/tinymce/tinymce.min.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/' . $this->getModuleName() . '_v1.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/membuat_soal_v1.js"></script>'
  );

  return $data;
 }

 public function index() {
  $base_url = base_url() . $this->getModuleName() . '/index/';
  $total_rows = count($this->getDataBankSoal());
  $offset = $this->uri->segment(3);

  $data['view_file'] = 'bank_soal_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['active'] = 'active';
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_bank_soal'] = $this->getDataBankSoal(5, $offset);
  $data['pagination'] = Modules::run('pagination/set_paging', $base_url, base_url() . $this->getModuleName(),
                  $total_rows, 5);
//  $data['data_bank_soal'] = array();
  echo Modules::run('template', $data);
 }

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_bank_soal'] = $this->getDataBankSoal();
  echo $this->load->view('bank_soal_search_view', $data, true);
 }

 public function getDataBankSoal($limit = '', $offset = '') {
  $keyword = $this->input->post('keyword');
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');

  $query['table'] = $this->getTableName() . ' s';
  $query['field'] = array('s.id', 's.soal',
      's.file_soal', 'mp.mata_pelajaran', 'ks.kategori');
  $query['join'] = array(
      array('kategori_soal ks', 's.kategori_soal = ks.id'),
      array('mata_pelajaran mp', 'ks.mata_pelajaran = mp.id'),
      array('type_soal ts', 's.type_soal = ts.id'),
  );
  $query['where'] = array(
      'ks.mata_pelajaran' => $mata_pelajaran,
      'ts.type' => 'S',
      's.deleted' => 0
  );
  $query['orderby'] = "s.id desc";

  if ($limit != '') {
   $query['limit'] = $limit;
   $query['offset'] = $offset;
  }

  if ($keyword != '') {
   $query['inside_brackets'] = true;
   $query['is_or_like'] = true;
   $query['like'] = array(
       array('s.id', $keyword),
       array('s.soal', $keyword),
       array('s.file_soal', $keyword),
       array('ks.kategori', $keyword),
       array('mp.mata_pelajaran', $keyword)
   );
  }

  $query['orderby'] = 's.id desc';
  $data = Modules::run('database/get', $query);
  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['jawaban_benar'] = Modules::run('membuat_soal/getJawabanBenar', $value['id']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getDataBankSoalbyKategoriSoal($kategori_soal) {
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');

  $query['table'] = $this->getTableName() . ' s';
  $query['field'] = array('s.id', 's.soal',
      's.file_soal', 'mp.mata_pelajaran', 'ks.kategori');
  $query['join'] = array(
      array('kategori_soal ks', 's.kategori_soal = ks.id'),
      array('mata_pelajaran mp', 'ks.mata_pelajaran = mp.id'),
      array('type_soal ts', 's.type_soal = ts.id'),
  );
  if ($kategori_soal != '0') {
   $query['where'] = array(
       'ks.id' => $kategori_soal,
       'ts.type' => 'S'
   );
  } else {
   $query['where'] = array(
       'ks.mata_pelajaran' => $mata_pelajaran,
       'ts.type' => 'S'
   );
  }

  $data = Modules::run('database/get', $query);
  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['jawaban_benar'] = Modules::run('membuat_soal/getJawabanBenar', $value['id']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getDataSoal($soal) {
  $data = Modules::run('database/get', array(
              'table' => 'soal',
              'where' => array('id' => $soal)
  ));

  $result = array();
  if (!empty($data)) {
   $result = $data->row_array();
  }

  return $result;
 }

 public function getDataJawabanSoal($soal) {
  $data = Modules::run('database/get', array(
              'table' => 'soal s',
              'field' => array('s.*', 'shj.id as soal_has_jawaban_id',
                  'shj.jawaban', 'shj.true_or_false', 'shj.file_jawaban'),
              'join' => array(
                  array('soal_has_jawaban shj', 's.id = shj.soal')
              ),
              'where' => array('s.id' => $soal)
  ));

  $result = array();
  if (!empty($data)) {
   $result = $data->result_array();
  }

  return $result;
 }

 public function edit($soal) {
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');

  $data = $this->getDataSoal($soal);
  $data['title'] = 'Form Edit Soal';
  $data['soal_id'] = $soal;
  $data['jawaban'] = $this->getDataJawabanSoal($soal);
  $data['list_kategori_soal'] = Modules::run('membuat_soal/getListKategoriSoal', $mata_pelajaran);
  $data['list_soal'] = Modules::run('membuat_soal/getDataSoal', $mata_pelajaran);
  echo $this->load->view($this->getModuleName() . '_edit_view', $data);
 }

 public function exec_editSoal() {
  $data = json_decode($this->input->post('data'));
  $soal_id = $data->id;
  $is_valid = false;

  $this->db->trans_begin();
  try {
   $data_soal = Modules::run('membuat_soal/get_post_data_soal', $data);
   $soal = Modules::run('database/_update', 'soal', $data_soal, array('id' => $soal_id));

   foreach ($data->jawaban as $key_jawaban => $value_jawaban) {
    foreach ($data->file as $key_file => $value_file) {
     if ($key_file == $key_jawaban) {
      $data_jawaban = Modules::run('membuat_soal/get_post_data_jawaban', $value_jawaban, $soal_id);
      if ($value_file->fileName != '') {
       $data_jawaban['file_jawaban'] = $value_file->fileName;
      }
      $soal_has_jawaban = Modules::run('database/_update', 'soal_has_jawaban', $data_jawaban, array('id' => $value_jawaban->jawaban_id));
     }
    }
   }
   $this->db->trans_commit();
   Modules::run('membuat_soal/uploadDataSoal');
   Modules::run('membuat_soal/uploadDataJawaban');
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function showFileAnswerBefore() {
  $data['title'] = 'Form Detail File';
  $data['nama_file'] = $this->input->post('nama_file');
  $data['jawaban_id'] = $this->input->post('jawaban_id');
  echo $this->load->view($this->getModuleName() . '_showFileAnswerBefore_view', $data, true);
 }

 public function importSoal() {
  $data = array();
  echo $this->load->view($this->getModuleName() . '_importSoal_view', $data, true);
 }

 public function getDataKategoriSoal($kategori) {
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');
  $data = Modules::run('database/get', array(
              'table' => 'kategori_soal',
              'where' => array('kategori' => $kategori,
                  'mata_pelajaran' => $mata_pelajaran)
  ));

  $id = 0;
  if (!empty($data)) {
   $data = $data->row_array();
   $id = $data['id'];
  } else {
   //insert
   $id = Modules::run('database/_insert', 'kategori_soal', array('kategori' => $kategori, 'mata_pelajaran' => $mata_pelajaran));
  }

  return $id;
 }

 public function getKategoriSoal($kategori, $mapel_id) {
  $data = Modules::run('database/get', array(
              'table' => "kategori_soal ks",
              'field' => array('ks.*'),
              'where' => "ks.kategori = '" . $kategori . "' "
              . "and ks.mata_pelajaran = '" . $mapel_id . "'"
  ));

  $id = 0;
  if (!empty($data)) {
   $data = $data->row_array();
   $id = $data['id'];
  } else {
   $post['mata_pelajaran'] = $mapel_id;
   $post['kategori'] = $kategori;
   $id = Modules::run('database/_insert', "kategori_soal", $post);
  }

  return $id;
 }

 public function getMapel($mapel) {
  $data = Modules::run('database/get', array(
              'table' => "mata_pelajaran mp",
              'field' => array('mp.*'),
              'where' => "mp.mata_pelajaran = '" . $mapel . "'"
  ));

  $id = 0;
  if (!empty($data)) {
   $data = $data->row_array();
   $id = $data['id'];
  } else {
   $post['mata_pelajaran'] = $mapel;
   $id = Modules::run('database/_insert', "mata_pelajaran", $post);
  }

  return $id;
 }

 public function execUploadFileSoal() {
  $data = json_decode($this->input->post('data'));
//  echo '<pre>';
//  print_r($data);
//  die;
  $is_valid = false;
  $this->db->trans_begin();
  try {
   $mapel_id_temp = '';
   $kategori_id_temp = '';
   $soal_id = "";
   foreach ($data as $value) {
//    echo count($value);die;
    if (count($value) > 0) {
     $kategori_soal = trim($value[0]);
     $mapel = trim($value[1]);

     if ($mapel != '') {
      //get mapel 
      $mapel_id = $this->getMapel($mapel);
      $mapel_id_temp = $mapel_id;
     }
     if ($kategori_soal != '') {
      //get kategori soal 
      $kategori_id = $this->getKategoriSoal($kategori_soal, $mapel_id);
      $kategori_id_temp = $kategori_id;
     }

     if ($kategori_id_temp != '' && $mapel_id_temp != '') {
      $ket_soal = trim($value[2]);
      $data_soal['kategori_soal'] = $kategori_id_temp;
      $data_soal['soal'] = $ket_soal;
      if ($ket_soal != '') {
       $soal = Modules::run('database/_insert', 'soal', $data_soal);
       $soal_id = $soal;
      }

      //jawaban
      $data_jawaban['soal'] = $soal_id;
      if (strtolower(trim($kategori_soal)) == 'tkp') {
       $data_jawaban['true_or_false'] = 0;
       $data_jawaban['poin'] = trim($value[5]);
      } else {
       if (trim($kategori_soal) != '') {
        $data_jawaban['true_or_false'] = trim($value[5]);
       }
      }
      $data_jawaban['jawaban'] = trim($value[4]);
      $soal_has_jawaban = Modules::run('database/_insert', 'soal_has_jawaban', $data_jawaban);
     }
    }
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function ambilSimbol() {
  echo $this->load->view($this->getModuleName() . '_ambilSimbol_view', array(), true);
 }

 public function tesAmbilWord() {
  $files = file_get_contents('D:/coba.docx');
  echo '<pre>';
  print_r($files);
  die;
 }

 public function removeAll() {
  $data = json_decode($_POST['data']);

  $is_valid = false;

  if (!empty($data)) {
   foreach ($data as $value) {
    $this->db->trans_begin();
    try {
     $id_soal = $value->id;
     Modules::run('database/_update', 'soal', array('deleted' => 1), array('id' => $id_soal));
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
