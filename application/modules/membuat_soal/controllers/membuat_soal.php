<?php

class Membuat_soal extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'membuat_soal';
 }

 public function getTableName() {
  return 'ujian_has_soal';
 }

 public function getHeaderJSandCSS() {
  $data = array(
      '<script src="' . base_url() . 'assets/js/message.js"></script>',
      '<script src="' . base_url() . 'assets/js/validation.js"></script>',
      '<script src="' . base_url() . 'assets/js/url.js"></script>',
      '<script src="' . base_url() . 'assets/js/tinymce/js/tinymce/tinymce.min.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/' . $this->getModuleName() . '_v1.js"></script>'
  );

  return $data;
 }

 public function index() {
  $data['view_file'] = 'membuat_soal_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_soal'] = $this->getDataSoalUjian();
  echo Modules::run('template', $data);
 }

 public function getDataSoalUjian() {
  $keyword = $this->input->post('keyword');
  $query['table'] = 'ujian uj';
  $query['field'] = array();
  $query['where'] = array(
      'uj.status' => 'New'
  );
  if ($keyword != '') {
   $query['inside_brackets'] = true;
   $query['like'] = array(
       array('uj.kode_ujian', $keyword)
   );
  }

  $data = Modules::run('database/get', $query);

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $has_soal = $this->getDataSoal($value['id']);
    if (!empty($has_soal)) {
     $value['total_soal'] = count($has_soal);
     $value['kategori_soal'] = $this->getDataKategoriUjian($value['id']);
     array_push($result, $value);
    }
   }
  }

  return $result;
 }

 public function getDataKategoriUjian($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'kategori_soal',
              'where' => array('ujian' => $ujian)
  ));

  $str_kategori = "";
  if (!empty($data)) {
   $result = array();
   foreach ($data->result_array() as $value) {
    array_push($result, $value['kategori']);
   }

   $str_kategori = implode(',', $result);
  }

  return $str_kategori;
 }

 public function getDataUjian($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian',
              'where' => array('id' => $ujian)
          ))->row_array();

  return $data;
 }

 public function makeSoal() {
//  $data = $this->getDataUjian($ujian);
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');
  $data['view_file'] = 'membuat_soal_makeSoal_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['list_kategori_soal'] = $this->getListKategoriSoal($mata_pelajaran);
  $data['list_soal'] = $this->getDataSoal($mata_pelajaran);
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function getDetailDataSoal($soal) {
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

 public function getListJawaban($soal_id) {
  $data = Modules::run('database/get', array(
              'table' => "soal_has_jawaban shj",
              'field' => array('shj.*'),
              'where' => "shj.soal = '" . $soal_id . "'"
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }


  return $result;
 }

 public function editSoal($soal_id) {
//  $data = $this->getDataUjian($ujian);
  $data = $this->getDetailDataSoal($soal_id);
  $data['data_jawaban'] = $this->getListJawaban($soal_id);
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');
  $data['view_file'] = 'membuat_soal_makeSoal_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['list_kategori_soal'] = $this->getListKategoriSoal($mata_pelajaran);
  $data['list_soal'] = $this->getDataSoal($mata_pelajaran);
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function makeSoalListening() {
//  $data = $this->getDataUjian($ujian);
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');
  $data['view_file'] = 'membuat_soal_makeSoalListening_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['list_kategori_soal'] = $this->getListKategoriSoal($mata_pelajaran);
  $data['list_soal'] = $this->getDataSoalListening($mata_pelajaran);
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function getDataSoal($mata_pelajaran) {
  $data = Modules::run('database/get', array(
              'table' => 'soal s',
              'field' => array('s.id as id_soal', 's.soal', 'ks.kategori', 's.file_soal'),
              'join' => array(
                  array('kategori_soal ks', 's.kategori_soal = ks.id'),
                  array('type_soal ts', 's.type_soal = ts.id')
              ),
              'where' => array('ks.mata_pelajaran' => $mata_pelajaran, 'ts.type' => 'S'),
              'orderby' => 's.id desc'
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['jawaban_benar'] = $this->getJawabanBenar($value['id_soal']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getDataSoalListening($mata_pelajaran) {
  $data = Modules::run('database/get', array(
              'table' => 'soal s',
              'field' => array('s.id as id_soal', 's.soal', 'ks.kategori'),
              'join' => array(
                  array('kategori_soal ks', 's.kategori_soal = ks.id'),
                  array('type_soal ts', 's.type_soal = ts.id'),
              ),
              'where' => array('ks.mata_pelajaran' => $mata_pelajaran, 'ts.type' => 'L')
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['jawaban_benar'] = $this->getJawabanBenar($value['id_soal']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getJawabanBenar($soal) {
  $data = Modules::run('database/get', array(
              'table' => 'soal_has_jawaban',
              'where' => array('soal' => $soal, 'true_or_false' => 1)
          ));
        
    $jawaban = "";
    if(!empty($data)){
      $data = $data->row_array();
      $jawaban = $data['jawaban'];
    }
//  echo '<pre>';
//  echo $this->db->last_query();
//  die;

  return $jawaban;
 }

 public function getListKategoriSoal($mata_pelajaran) {
  $data = Modules::run('database/get', array(
              'table' => 'kategori_soal',
              'where' => array('mata_pelajaran' => $mata_pelajaran, 'deleted'=> 0)
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function addKategoriSoal() {
  $mata_pelajaran = $this->session->userdata('mata_pelajaran');
  $data['module'] = $this->getModuleName();
  $data['mata_pelajaran'] = $mata_pelajaran;
  echo $this->load->view('membuat_soal_addKategoriSoal_view', $data, true);
 }

 public function editKategoriSoal($kategori) {
  $data = Modules::run('database/get', array(
              'table' => 'kategori_soal ks',
              'field' => array('ks.id as id_kategori', 'ks.kategori', 'ks.mata_pelajaran', 'ks.poin_by'),
              'where' => array('ks.id' => $kategori)
          ))->row_array();
  echo $this->load->view('membuat_soal_addKategoriSoal_view', $data, true);
 }

 public function simpanKategori() {
  $data = json_decode($this->input->post('data'));
  $id = $data->id;
  $data_kategori['kategori'] = $data->kategori;
  $data_kategori['mata_pelajaran'] = $data->mata_pelajaran;
  $data_kategori['poin_by'] = $data->poin_by == '' ? 'SOAL' : $data->poin_by;

  $is_valid = false;
  $this->db->trans_begin();
  try {
   if (is_numeric($id)) {
    //update kategori
    Modules::run('database/_update', 'kategori_soal', $data_kategori, array('id' => $id));
   } else {
    //insert kategori    
    $kategori_soal = Modules::run('database/_insert', 'kategori_soal', $data_kategori);
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function add() {
  $data['view_file'] = 'membuat_soal_add_view';
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
  $data['view_file'] = 'membuat_soal_add_view';
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  echo Modules::run('template', $data);
 }

 public function get_post_data($value) {
  $data['id'] = $value->id;
  $data['membuat_soal'] = $value->membuat_soal;

  return $data;
 }

// public function save() {
//  $data = json_decode($this->input->post('data'));
//  $id = $data->id;
//
//  $is_valid = false;
//
//  $this->db->trans_begin();
//  try {
//   $data_membuat_soal = $this->get_post_data($data);
//   if (is_numeric($id)) {
//    Modules::run('database/_update', $this->getTableName(), $data_membuat_soal, array('id' => $id));
//   } else {
//    $membuat_soal = Modules::run('database/_insert', $this->getTableName(), $data_membuat_soal);
//   }
//   $this->db->trans_commit();
//   $is_valid = true;
//  } catch (Exception $ex) {
//   $this->db->trans_rollback();
//  }
//  echo json_encode(array('is_valid' => $is_valid));
// }

 public function get_post_data_soal($value) {
  $data['kategori_soal'] = $value->kategori_soal;
  $data['soal'] = $value->soal;
  return $data;
 }

 public function get_post_data_soal_listening($value) {
  $data['kategori_soal'] = $value->kategori_soal;
  $data['file_soal'] = $value->soalFile;
  $data['type_soal'] = 2;
  if ($value->soalFile == '') {
   unset($data['file_soal']);
  }
  return $data;
 }

 public function get_post_data_jawaban($value, $soal) {
  $data['soal'] = $soal;
  $data['jawaban'] = $value->jawaban;
  $data['true_or_false'] = $value->benar;
  $data['poin'] = $value->poin;

  return $data;
 }

 public function simpanSoal() {
  $data = json_decode($this->input->post('data'));
  $is_valid = false;
  $id = $data->id;
//  echo '<pre>';
//  print_r($data);die;
  $this->db->trans_begin();
  try {

   if ($id == '') {
    $data_soal = $this->get_post_data_soal($data);
    $soal = Modules::run('database/_insert', 'soal', $data_soal);

    if (!empty($data->jawaban)) {
     foreach ($data->jawaban as $value_jawaban) {
      $data_jawaban = $this->get_post_data_jawaban($value_jawaban, $soal);
      $soal_has_jawaban = Modules::run('database/_insert', 'soal_has_jawaban', $data_jawaban);
     }
    }
   } else {
    //update
    $data_soal = $this->get_post_data_soal($data);
    Modules::run('database/_update', "soal", $data_soal, array('id' => $id));

    $soal = $id;
    if (!empty($data->jawaban)) {
     foreach ($data->jawaban as $value_jawaban) {
      $data_jawaban = $this->get_post_data_jawaban($value_jawaban, $soal);
      if ($value_jawaban->jawaban_id == '0') {
       $soal_has_jawaban = Modules::run('database/_insert', 'soal_has_jawaban', $data_jawaban);
      } else {
       if($value_jawaban->deleted == '1'){
        Modules::run('database/_delete', 'soal_has_jawaban', 
                array('id'=> $value_jawaban->jawaban_id));
       }else{
        Modules::run('database/_update', 'soal_has_jawaban', $data_jawaban, 
                array('id' => $value_jawaban->jawaban_id));
       }
      }
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

 public function simpanSoalListening() {
  $data = json_decode($this->input->post('data'));
  $is_valid = false;
  $this->db->trans_begin();
  try {
   $data_soal = $this->get_post_data_soal_listening($data);
   $soal = Modules::run('database/_insert', 'soal', $data_soal);

   foreach ($data->jawaban as $key_jawaban => $value_jawaban) {
    foreach ($data->file as $key_file => $value_file) {
     if ($key_file == $key_jawaban) {
      $data_jawaban = $this->get_post_data_jawaban($value_jawaban, $soal);
      $data_jawaban['file_jawaban'] = $value_file->fileName;
      $soal_has_jawaban = Modules::run('database/_insert', 'soal_has_jawaban', $data_jawaban);
     }
    }
   }
   $this->db->trans_commit();
   $this->uploadDataSoal();
   $this->uploadDataJawaban();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_soal'] = $this->getDataSoalUjian();
  echo $this->load->view('membuat_soal_search_view', $data, true);
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

 public function removeKategori($id) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
  //  Modules::run('database/_delete', 'kategori_soal', array('id' => $id));
   Modules::run('database/_update', 'kategori_soal', array('deleted'=> 1), array('id' => $id));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function removeSoal($id_soal) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
//   Modules::run('database/_delete', 'soal_has_jawaban', array('soal' => $id_soal));
//   Modules::run('database/_delete', 'soal', array('id' => $id_soal));
   Modules::run('database/_update', 'soal', array('deleted'=>1),array('id' => $id_soal));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function listUjianView() {
  $data['data_ujian'] = $this->getListUjian();
  echo $this->load->view('membuat_soal_listUjianView_view', $data, true);
 }

 public function getListUjian() {
  $data = Modules::run('database/get', array(
              'table' => 'ujian',
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    if (!$this->ujianHasSoal($value['id'])) {
     array_push($result, $value);
    }
   }
  }
  return $result;
 }

 public function ujianHasSoal($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian_has_soal',
              'where' => array('ujian' => $ujian)
  ));

  $is_exist = false;
  if (!empty($data)) {
   $is_exist = true;
  }

  return $is_exist;
 }

 public function uploadDataJawaban() {
  $file_path = "files/jawaban/";
  foreach ($_FILES as $key => $value) {
   $file = $key;
   if ($file != 'soalFile') {
    $file_path = $file_path . basename($_FILES[$file]['name']);
    move_uploaded_file($_FILES[$file]['tmp_name'], $file_path);
   }
  }
 }

 public function uploadDataSoal() {
  $file_path = "files/soal/";
  if (isset($_FILES['soalFile'])) {
   $file_path = $file_path . basename($_FILES['soalFile']['name']);
   move_uploaded_file($_FILES['soalFile']['tmp_name'], $file_path);
  }
 }

 public function setLimitSoal($kategori) {
  $data = Modules::run('database/get', array(
              'table' => 'kategori_soal',
              'where' => array('id' => $kategori)
          ))->row_array();
  $data['kategori_id'] = $kategori;
  echo $this->load->view('membuat_soal_setLimitSoal_view', $data, true);
 }

 public function checkSoalKeluarLebihdariTotalSoal($kategori_soal, $limit_soal_keluar) {
  $data = Modules::run('database/get', array(
              'table' => 'soal',
              'where' => array('kategori_soal' => $kategori_soal)
  ));

  $is_more_than = false;
  $soal_existing = 0;
  if (!empty($data)) {
   $soal_existing = count($data->result_array());
   if (intval($soal_existing < $limit_soal_keluar)) {
    $is_more_than = true;
   }
  }

  return $is_more_than;
 }

 public function isExistDataLimitKeluar($kategori_soal, $ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian_has_soal_limit_keluar',
              'where' => array('kategori_soal' => $kategori_soal, 'ujian' => $ujian)
  ));

  $is_exist = false;
  if (!empty($data)) {
   $is_exist = true;
  }

  return $is_exist;
 }

 public function aturLimitSoal() {
  $kategori_soal = $this->input->post('kategori_soal');
  $ujian = $this->input->post('ujian');
  $limit_soal_keluar = $this->input->post('limit_soal_keluar');

  $out_of_jumlah_soal = $this->checkSoalKeluarLebihdariTotalSoal($kategori_soal, $limit_soal_keluar);
  $is_valid = false;
  $message = '';

  if (!$out_of_jumlah_soal) {
   $this->db->trans_begin();
   try {
    $data['kategori_soal'] = $kategori_soal;
    $data['ujian'] = $ujian;
    $data['limit_soal_keluar'] = $limit_soal_keluar;
    if ($this->isExistDataLimitKeluar($kategori_soal, $ujian)) {
     Modules::run('database/_update', 'ujian_has_soal_limit_keluar', array(
         'limit_soal_keluar' => $limit_soal_keluar
             ), array('kategori_soal' => $kategori_soal, 'ujian' => $ujian));
    } else {
     Modules::run('database/_insert', 'ujian_has_soal_limit_keluar', $data);
    }
    $this->db->trans_commit();
    $is_valid = true;
   } catch (Exception $ex) {
    $this->db->trans_rollback();
    $message = 'Data Gagal Disimpan';
   }
  } else {
   $message = 'Limit Soal Melebihi Data Jumlah Soal di Kategori Ini';
  }

  echo json_encode(array('is_valid' => $is_valid, 'message' => $message));
 }

 public function submitSoal($ujian) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
   Modules::run('database/_update', 'ujian', array(
       'status' => 'Ready'
           ), array('id' => $ujian));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function read_file_docx($filename) {
  $striped_content = '';
  $content = '';

  if (!$filename || !file_exists($filename))
   return false;

  $zip = zip_open($filename);

  if (!$zip || is_numeric($zip))
   return false;

  while ($zip_entry = zip_read($zip)) {

   if (zip_entry_open($zip, $zip_entry) == FALSE)
    continue;

   if (zip_entry_name($zip_entry) != "word/document.xml")
    continue;

   $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

   zip_entry_close($zip_entry);
  }// end while

  zip_close($zip);

//file_put_contents('1.xml', $content);
  $content = str_replace('', " ", $content);
  $content = str_replace('', "\r\n", $content);
  $striped_content = strip_tags($content);

  return $striped_content;
 }

 public function readFileDoc() {
//  $myfile = fopen("D:/tes.html", "r") or die("Unable to open file!");
//echo fread($myfile,filesize("D:/tes.html"));
////fclose($myfile);
//  $document = file_get_contents("D:/tes.html");
//  $document = file("D:/tes.html");
//  echo '<pre>';
//  print_r($document);
//  die;
//  $myfile = fopen("D:\tes.htm", "r");
////  echo fread($myfile, filesize("D:\coba.xml"));
////  echo fgets($myfile);
//  while (!feof($myfile)) {
//   echo fgets($myfile) . "<br>";
//  }
  fclose($myfile);
 }

 public function tesRead() {
  $filename = "D:/coba.docx"; //Add file with folder

  $content = $this->read_file_docx($filename);
  if ($content !== false) {

   echo nl2br($content);
  } else {
   echo 'Couldn\'t the file. Please check that file.';
  }
 }

 function readZippedImages($filename) {


  /* Create a new ZIP archive object */
  $zip = new ZipArchive;

  /* Open the received archive file */
  if (true === $zip->open($filename)) {
   for ($i = 0; $i < $zip->numFiles; $i++) {


    /* Loop via all the files to check for image files */
    $zip_element = $zip->statIndex($i);


    /* Check for images */
    if (preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|gif|bmp))$)", $zip_element['name'])) {


     /* Display images if present by using display.php */
     echo "<image src='display.php?filename=" . $filename . "&index=" . $i . "' /><hr />";
    }
   }
  }
 }

 public function readFileWord() {
  $document = "D:\coba.doc";
//  echo $this->readWord($document);
  echo $this->parseWord($document);
 }

 public function readWord($filename) {
//  echo '<pre>';
//  print_r($filename);
//  die;
  if (file_exists($filename)) {
   if (($fh = fopen($filename, 'r')) !== false) {
    $headers = fread($fh, 0xA00);

    // 1 = (ord(n)*1) ; Document has from 0 to 255 characters
    $n1 = ( ord($headers[0x21C]) - 1 );

    // 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
    $n2 = ( ( ord($headers[0x21D]) - 8 ) * 256 );

    // 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
    $n3 = ( ( ord($headers[0x21E]) * 256 ) * 256 );

    // 1 = (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
    $n4 = ( ( ( ord($headers[0x21F]) * 256 ) * 256 ) * 256 );

    // Total length of text in the document
    $textLength = ($n1 + $n2 + $n3 + $n4);

    $extracted_plaintext = fread($fh, $textLength);

    // if you want to see your paragraphs in a new line, do this
    // return nl2br($extracted_plaintext);
    return $extracted_plaintext;
   } else {
    return false;
   }
  } else {
   return false;
  }
 }

 public function parseWord($userDoc) {
  $fileHandle = fopen($userDoc, "r");
  $line = @fread($fileHandle, filesize($userDoc));
  $lines = explode(chr(0x0D), $line);
  $outtext = "";
  foreach ($lines as $thisline) {
   $pos = strpos($thisline, chr(0x00));
   if (($pos !== FALSE) || (strlen($thisline) == 0)) {
    
   } else {
    $outtext .= $thisline . " ";
   }
  }
  $outtext = preg_replace("/[^a-zA-Z0-9\s\,.\
\r\	@\/_()]/", "", $outtext);
  return $outtext;
 }

 public function getDetailBobotNilai($kategori_id) {
  $data = Modules::run('database/get', array(
              'table' => 'bobot_nilai_kategori bnk',
              'field' => array('bnk.*'),
              'where' => "bnk.kategori_soal = '" . $kategori_id . "'"
  ));

  $result = array();
  if (!empty($data)) {
   $result = $data->row_array();
  }


  return $result;
 }

 public function nilaiBobot() {
  $data = $this->getDetailBobotNilai($_POST['kategori_id']);
  $data['kategori_id'] = $_POST['kategori_id'];

  echo $this->load->view('bobot_nilai', $data, true);
 }

 public function simpanBobot() {
  $params = $_POST;
  $is_valid = true;

  $post['kategori_soal'] = $params['kategori_id'];
  $post['nilai_benar'] = $params['nilai_benar'];
  $post['nilai_salah'] = $params['nilai_salah'];
  $post['nilai_kosong'] = $params['nilai_kosong'];
  if ($params['bobot_id'] == '') {
   Modules::run('database/_insert', "bobot_nilai_kategori", $post);
  } else {
   Modules::run('database/_update', 'bobot_nilai_kategori', $post,
           array('id' => $params['bobot_id']));
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function addItemJawaban() {
  $data['index'] = $_POST['index'];
  echo $this->load->view('tr_jawaban', $data, true);
 }

// readZippedImages($document);
}
