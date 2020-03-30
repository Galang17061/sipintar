<?php

class Task_soal extends MX_Controller {

 public function __construct() {
  parent::__construct();
  date_default_timezone_set("Asia/Jakarta");
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'task_soal';
 }

 public function getTableName() {
  return 'ujian_has_soal';
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

 public function kerjakanUjian($ujian) {  
//  echo $ujian;die;
  $data['view_file'] = 'task_soal_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_soal_ujian'] = $this->getDataSoalUjian($ujian);
//  echo '<pre>';
//  print_r($data['data_soal_ujian']);
//  die;
//  $data['data_kategori'] = $this->getListKategoriSoal($ujian);
//  echo '<pre>';
//  print_r($data['data_kategori']);
//  die;
  $data['ujian'] = $ujian;
  $data['total_soal'] = $this->getTotalSoal($ujian);
//  echo '<pre>';
//  print_r($data);die;
  $data['is_start_ujian'] = Modules::run('rule_ujian/isStartUjian', $ujian); 
  $data['siswa_is_submit'] = $this->siswaIsSubmit($ujian);
  $data['is_exist_ujian'] = Modules::run('rule_ujian/isDateUjian', $ujian);
  $data['jumlah_data_daftar'] = count(Modules::run('daftar_ujian/getDataUjianDaftar'));
  $data['jumlah_data_nilai'] = count(Modules::run('nilai/getDataNilai'));
  $data['jumlah_data_histori'] = count(Modules::run('histori_ujian/getDataHistoriUjian'));
//   echo '<pre>';
//  print_r($data);die;
  echo Modules::run('template', $data);
 }

 public function siswaIsSubmit($ujian) {
  $siswa = $this->session->userdata('id');
  $data = Modules::run('database/get', array(
  'table' => 'siswa_has_ujian',
  'where' => array(
  'siswa' => $siswa,
  'ujian' => $ujian,
  'status' => 'Done'
  )
  ));

  $is_submit = false;
  if (!empty($data)) {
   $is_submit = true;
  }

  return $is_submit;
 }

 public function getDataSoalUjian($ujian) {
  $kategori_soal = $this->getListKategoriSoal($ujian);  
  $result = array();
  foreach ($kategori_soal as $v_kategori) {   
   $soal_keluar = $this->getSoalKeluarKategori($v_kategori['kategori_soal'], $v_kategori['limit_soal_keluar'], $ujian);
   $v_kategori['data_soal'] = $this->getDataSoalKeluar($soal_keluar, $v_kategori['kategori_soal'], $ujian);
   array_push($result, $v_kategori);
  }

  $soal = array();
  if (!empty($result)) {
   for($i = 0; $i< count($result); $i++){
    $data_soal = $result[$i]['data_soal'];
    for($j = 0; $j < count($data_soal); $j++){
     array_push($soal, $data_soal[$j]);
    }
   }
  }
    
  return $soal;
 }

 public function getExistDataSiswaHasKategoriRandomSoal($siswa, $kategori_soal, $ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'siswa_has_kategori_random_soal shkr',
  'join' => array(
  array('ujian u', 'shkr.ujian = u.id'),
  array('soal s', 'shkr.soal = s.id'),
  ),
  'where' => array('shkr.siswa' => $siswa,
  'shkr.kategori_soal' => $kategori_soal,
  'shkr.ujian' => $ujian
  )
  ));
//  echo "<pre>";
//  echo $this->db->last_query();
//  die;
//  $data = Modules::run('database/get', array(
//  'table' => 'siswa_has_kategori_random_soal shkr',
//  'join' => array(
//  array('ujian_has_soal uhs', 'shkr.ujian_has_soal = uhs.id')
//  ),
//  'where' => array('shkr.siswa' => $siswa,
//  'shkr.kategori_soal' => $kategori_soal,
//  'uhs.ujian' => $ujian
//  )
//  ));
  
  $is_exist = false;
  if (!empty($data)) {
   $is_exist = true;
  }

  return $is_exist;
 }

 public function getDataSoalKeluar($soal_keluar, $kategori_soal, $ujian) {
  $siswa = $this->session->userdata('id');
  $is_exist_data = $this->getExistDataSiswaHasKategoriRandomSoal($siswa, $kategori_soal, $ujian);
//  echo '<pre>';
//  echo $this->db->last_query();
//  die;
//  echo '<pre>';
//  print_r($soal_keluar);
//  die;  
//  echo '<pre>';
//  echo $this->db->last_query();
//  die;
//  echo '<pre>';
//  echo $this->db->last_query();
//  die;
//  if($kategori_soal == 14){
//   echo '<pre>';
//   echo $this->db->last_query();
//   die;
//  }
//echo $is_exist_data;die;
  
//  echo '<pre>';
//  print_r($soal_keluar);die;
  if (!$is_exist_data) {
   foreach ($soal_keluar as $value) {
    $data['siswa'] = $siswa;
    $data['soal'] = $value;
    $data['ujian'] = $ujian;
    $data['kategori_soal'] = $kategori_soal;
    Modules::run('database/_insert', 'siswa_has_kategori_random_soal', $data);
//    echo "<pre>";
//    echo $this->db->last_query();
//    die;
   }
  }

  $data_siswa_has_kategori = Modules::run('database/get', array(
    'table' => 'siswa_has_kategori_random_soal shkr',
    'field' => array('shkr.*', 's.soal as soal', 's.id as soal_id', 's.type_soal', 's.file_soal'),
    'join' => array(
     array('ujian u', 'shkr.ujian = u.id'),
     array('soal s', 'shkr.soal = s.id'),
//     array('type_soal ts', 's.type_soal = ts.id'),
    ),
    'where' => array('shkr.siswa' => $siswa,
     'shkr.kategori_soal' => $kategori_soal, 'shkr.ujian' => $ujian)
   ));
  
  $dt_soal = array();
  if (!empty($data_siswa_has_kategori)) {
   foreach ($data_siswa_has_kategori->result_array() as $value) {
    $value['jawaban_benar'] = $this->getJawabanBenar($value['soal_id']);
    $value['list_jawaban'] = $this->getAllJawabanSoal($value['soal_id'], $ujian);
    array_push($dt_soal, $value);
   }
  }
//  echo '<pre>';
// print_r($dt_soal);
// die;
//  if($kategori_soal == 14){
//   echo '<pre>';
//   print_r($data_siswa_has_kategori);
//   die;
//  }
// echo '<pre>';
// print_r($data_siswa_has_kategori);
// die;
  $result = array();
  foreach ($dt_soal as $v_keluar) {
//   foreach ($data_soal as $v_soal) {
//    if ($v_soal['id_soal'] == $v_keluar['ujian_has_soal']) {
     $v_keluar['jenis_file'] = '';
     if ($v_keluar['file_soal'] != '') {
      $file_tipe = explode('.', $v_keluar['file_soal']);
      $file_tipe = end($file_tipe);
      if ($file_tipe == 'mp3') {
       $v_keluar['jenis_file'] = 'listening';
      }
     }
     array_push($result, $v_keluar);
//    }
//   }
  }
//  echo '<pre>';
//  print_r($result);
//  die;
  return $result;
 }

 public function getSoalKeluarKategori($kategori_soal, $soal_keluar, $ujian) {
  $id_soal = array();
  $data = $this->getDataSoal($kategori_soal, $ujian, $soal_keluar);
//  echo '<pre>';
//  print_r($data);
//  die;
//  $data = Modules::run('database/get', array(
//    'table' => 'soal',
//    'field' => array('id as id_soal'),
//    'where' => array('kategori_soal'=> $kategori_soal),
//    'orderby'=> "rand()",
//    'limit'=> intval($soal_keluar)
//  ))->result_array();
  
  foreach ($data as $value) {
   array_push($id_soal, $value['soal_id']);
  }
////  echo '<pre>';
////  print_r($id_soal);
////  die;
//  $ambil_soal = array_rand($id_soal, intval($soal_keluar));
//  $soal_keluar = array();
//  if (is_array($ambil_soal)) {
//   foreach ($ambil_soal as $key => $v_soal) {
//    foreach ($id_soal as $key_soal => $v_data_soal) {
//     if ($v_soal == $key_soal) {
//      array_push($soal_keluar, $v_data_soal);
//     }
//    }
//   }
//  } else {  
//   foreach ($id_soal as $key_soal => $v_data_soal) {
//    array_push($soal_keluar, $v_data_soal);
//   }
//  }
//
//  echo '<pre>';
////  echo $kategori_soal;die;
//  print_r($soal_keluar);
//  die;
//  echo '<pre>';
//  print_r($id_soal);
//  die;
  return $id_soal;
 }

 public function getAllJawabanSoal($soal, $ujian) {
  $siswa = $this->session->userdata('id');
  $data = Modules::run('database/get', array(
  'table' => 'soal_has_jawaban',
  'where' => array('soal' => $soal)
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    if ($ujian != '') {
     $value['jawaban_siswa'] = $this->getJawabanSiswa($ujian, $siswa, $value['id']);
    } else {
     $value['jawaban_siswa'] = false;
    }
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getJawabanSiswa($ujian, $siswa, $soal_has_jawaban) {
  $data = Modules::run('database/get', array(
  'table' => 'siswa_has_jawaban',
  'where' => array('ujian' => $ujian,
  'siswa' => $siswa,
  'soal_has_jawaban' => $soal_has_jawaban)
  ));

  $is_exist = false;
  if (!empty($data)) {
   $is_exist = true;
  }

  return $is_exist;
 }

 public function getDataSoal($kategori_soal, $ujian = '', $soal_keluar) {
//  $data = Modules::run('database/get', array(
//  'table' => 'ujian_has_soal uhs',
//  'field' => array('uhs.id as id_soal', 's.id as soal_id',
//  's.soal', 'ks.kategori', 's.file_soal'),
//  'join' => array(
//  array('soal s', 'uhs.soal = s.id'),
//  array('kategori_soal ks', 's.kategori_soal = ks.id'),
//  ),
//  'where' => array('ks.id' => $kategori_soal, 'uhs.ujian' => $ujian),
//   'orderby'=> "rand()",
//    'limit'=> intval($soal_keluar)
//  ));
  $data = Modules::run('database/get', array(
  'table' => 'soal s',
  'field' => array('s.id as soal_id',
  's.soal', 'ks.kategori', 's.file_soal'),
  'join' => array(
  array('kategori_soal ks', 's.kategori_soal = ks.id'),
  ),
  'where' => array('ks.id' => $kategori_soal),
   'orderby'=> "rand()",
    'limit'=> intval($soal_keluar)
  ));
//  echo '<pre>';
//  echo $this->db->last_query();
//  die;
//  echo '<pre>';
//  print_r($data->result_array());
//  die;
  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['jawaban_benar'] = $this->getJawabanBenar($value['soal_id']);
    $value['list_jawaban'] = $this->getAllJawabanSoal($value['soal_id'], $ujian);
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

  return $jawaban;
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

 public function getAllJumlahSoal($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian_has_soal',
  'where' => array('ujian' => $ujian)
  ));

  $total = 0;
  if (!empty($data)) {
   $total = count($data->result_array());
  }

  return $total;
 }

 public function getSiswaIkutUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'siswa_has_ujian',
  'where' => "ujian = " . $ujian . ""
  ));

  return count($data->result_array());
 }

 public function getSiswaSubmitUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'siswa_has_ujian',
  'where' => "ujian = " . $ujian . " and status = 'Done'"
  ));

  $result = array();
  if (!empty($data)) {
   $result = $data->result_array();
  }

  return count($result);
 }

 public function isHasJawaban($ujian, $siswa, $soal) {
  $data = Modules::run('database/get', array(
  'table' => 'siswa_has_jawaban',
  'where' => array('ujian' => $ujian,
  'siswa' => $siswa, 'soal' => $soal)
  ));

  $is_exist = false;
  if (!empty($data)) {
   $is_exist = true;
  }

  return $is_exist;
 }

 public function execSubmitJawaban($ujian) {
  $data = json_decode($this->input->post('data'));
//  echo '<pre>';
//  print_r($data);
//  die;
  $total_soal = $this->getAllJumlahSoal($ujian);
//  echo '<pre>';
//  print_r($total_soal);
//  die;
  $siswa = $this->session->userdata('id');
  $jawaban_benar = $this->getAllUjianJawabanBenar($ujian);
  
//  echo '<pre>';
//  print_r($jawaban_benar);
//  die;  
  $is_valid = false;
  $this->db->trans_begin();
  try {
   $counter_benar = 0;
   foreach ($data->jawaban as $v_jawaban) {
    $jawaban = $v_jawaban->jawaban_id;
    $soal = $v_jawaban->soal;
    if (!$this->isHasJawaban($ujian, $siswa, $soal)) {
     $data_siswa_has_jawaban['siswa'] = $siswa;
     $data_siswa_has_jawaban['soal'] = $soal;
     $data_siswa_has_jawaban['soal_has_jawaban'] = $jawaban;
     $data_siswa_has_jawaban['status_jawaban'] = 1;
     $siswa_has_jawaban = Modules::run('database/_insert', 'siswa_has_jawaban', $data_siswa_has_jawaban);
    }
    foreach ($jawaban_benar as $v_benar) {
     $jawaban_benar_data = $v_benar['jawaban_id'];
     if ($jawaban_benar_data == $jawaban) {
      $counter_benar += 1;
     }
    }
   }

   //perhitungan nilai
//   $total_jawaban_salah = $total_soal - $counter_benar;
//   $nilai_per_soal = 100 / $total_soal;
//   $total_nilai_jawaban_salah = $total_jawaban_salah * $nilai_per_soal;
//   $nilai = 100 - $total_nilai_jawaban_salah;

   $nilai = Modules::run('nilai/getTotalNilaiSalSiswa', $ujian, $siswa);
//   echo $nilai;die;
   Modules::run('database/_update', 'siswa_has_ujian', array(
   'nilai' => $nilai,
   'status' => 'Done'
   ), array('siswa' => $siswa, 'ujian' => $ujian));

   $total_siswa_ikut_ujian = $this->getSiswaIkutUjian($ujian);
   $siswa_sudah_submit = $this->getSiswaSubmitUjian($ujian);

   if ($total_siswa_ikut_ujian == $siswa_sudah_submit) {
    Modules::run('database/_update', 'ujian', array('status' => 'Done'), array('id' => $ujian));
    Modules::run('database/_update', 'start_ujian', array('status' => 0), array('ujian' => $ujian));
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function execAnsweredSoal($ujian) {
  $siswa = $this->session->userdata('id');
  $soal = $this->input->post('soal');
  $jawaban = $this->input->post('jawaban');
  $status_jawaban = $this->input->post('status_jawaban');
//  echo '<pre>';
//  print_r($_POST);
//  die;
  $is_valid = false;
  $this->db->trans_begin();
  try {
   if (!$this->isHasJawaban($ujian, $siswa, $soal)) {
    Modules::run('database/_insert', 'siswa_has_jawaban', array(
    'siswa' => $siswa,
    'ujian' => $ujian,
    'soal' => $soal,
    'soal_has_jawaban' => $jawaban,
    'status_jawaban' => $status_jawaban
    ));
   } else {
    Modules::run('database/_update', 'siswa_has_jawaban', array(
    'soal_has_jawaban' => $jawaban,
    'status_jawaban' => $status_jawaban
    ), array('ujian' => $ujian,
    'siswa' => $siswa, 'soal' => $soal));
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function getAllUjianJawabanBenar() {
//  $data = Modules::run('database/get', array(
//  'table' => 'ujian_has_soal uhs',
//  'field' => array(
//  'shj.id as jawaban_id'
//  ),
//  'join' => array(
//  array('soal s', 'uhs.soal = s.id'),
//  array('soal_has_jawaban shj', 's.id = shj.soal'),
//  ),
//  'where' => array('uhs.ujian' => $ujian, 'shj.true_or_false' => 1)
//  ));
  $data = Modules::run('database/get', array(
  'table' => 'soal s',
  'field' => array(
  'shj.id as jawaban_id'
  ),
  'join' => array(
  array('soal_has_jawaban shj', 's.id = shj.soal'),
  ),
  'where' => array('shj.true_or_false' => 1)
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
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
  'where' => array('uhp.ujian' => $ujian)
  ));

  $pengawas = "";
  if (!empty($data)) {
   $result = array();
   foreach ($data->result_array() as $value) {
    array_push($result, $value['pengawas_ujian']);
   }
   $pengawas = implode(',', $result);
  }

  return $pengawas;
 }

 public function hasSoalUjian($ujian) {
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

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_ujian_belum'] = $this->getDataUjian();
  echo $this->load->view('task_soal_search_view', $data, true);
 }

 public function chooseSiswa($ujian) {
  $data['ujian'] = $ujian;
  $data['data_siswa'] = $this->getListAllSiswa();
  $data['list_jurusan'] = $this->getListJurusan();
  echo $this->load->view('task_soal_chooseSiswa_view', $data, true);
 }

 public function getListAllSiswa($jurusan = '') {
  $query['table'] = 'siswa s';
  $query['field'] = array('s.id', 's.nama', 's.nis', 's.status', 'j.jurusan');
  $query['join'] = array(
  array('jurusan j', 's.jurusan = j.id'),
  );

  if ($jurusan != '') {
   $query['where'] = "(s.status is null or s.status = 'A') and j.id = " . $jurusan . "";
  } else {
   $query['where'] = "(s.status is null or s.status = 'A')";
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

 public function getListJurusan() {
  $data = Modules::run('database/get', array(
  'table' => 'jurusan',
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function filterSiswaByJurusan($jurusan_id) {
  $data['data_siswa'] = $this->getListAllSiswa($jurusan_id);
  echo $this->load->view('task_soal_filterSiswaByJurusan_view', $data, true);
 }

 public function getAllPesertaUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'siswa_has_ujian',
  'where' => array('ujian' => $ujian)
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getLimitWaktuUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'start_ujian su',
  'field' => array('tl.time_limit'),
  'join' => array(
  array('time_limit tl', 'su.time_limit = tl.id'),
  ),
  'where' => array('su.ujian' => $ujian)
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getListTimeLimit() {
  $data = Modules::run('database/get', array(
  'table' => 'time_limit',
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function aturWaktuUjian($ujian) {
  $data['ujian'] = $ujian;
  $data['list_waktu'] = $this->getListTimeLimit();
  echo $this->load->view('task_soal_aturWaktuUjian_view', $data, true);
 }

 public function execAturWatuUjian() {
  $ujian = $this->input->post('ujian');
  $time_limit = $this->input->post('time_limit');
  $is_valid = false;

  $this->db->trans_begin();
  try {
   $data_start_ujian['time_limit'] = $time_limit;
   $data_start_ujian['ujian'] = $ujian;
   $start_ujian = Modules::run('database/_insert', 'start_ujian', $data_start_ujian);
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function execSimpanSiswaHasUjian() {
  $data = json_decode($this->input->post('data'));
  $ujian = $data->ujian;
  $is_valid = false;

  $this->db->trans_begin();
  try {
   foreach ($data->siswa as $value) {
    $data_siswa_has_ujian['ujian'] = $ujian;
    $data_siswa_has_ujian['siswa'] = $value->id;
    $siswa_has_ujian = Modules::run('database/_insert', 'siswa_has_ujian', $data_siswa_has_ujian);
    Modules::run('database/_update', 'siswa', array('status' => 'NA'), array('id' => $value->id));
   }
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function getDataUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian',
  'where' => array('id' => $ujian)
  ))->row_array();

  return $data;
 }

 public function getListKategoriSoal($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'kategori_soal ks',
  'join' => array(
  array('ujian_has_soal_limit_keluar uhslk',
  'ks.id = uhslk.kategori_soal')
  ),
  'where' => array('uhslk.ujian' => $ujian)
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function detailUjian($ujian) {
  $data = $this->getDataUjian($ujian);
  $data['view_file'] = 'task_soal_detailUjian_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['ujian'] = $ujian;
  $data['list_kategori_soal'] = $this->getListKategoriSoal($ujian);
  $data['list_soal'] = $this->getDataSoal($ujian);
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function getAllSoalUjian($ujian) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian_has_soal_limit_keluar',
  'where' => array('ujian' => $ujian)
  ));

//  echo '<pre>';
//  echo $this->db->last_query();
//  die;
  $total = 0;
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $total += intval($value['limit_soal_keluar']);
   }
  }

  return $total;
 }

 public function getTotalSoal($ujian) {
  $data['siswa_is_submit'] = $this->siswaIsSubmit($ujian);
  $data['is_exist_ujian'] = Modules::run('rule_ujian/isDateUjian', $ujian);
  $data['is_start_ujian'] = Modules::run('rule_ujian/isStartUjian', $ujian);
  $data['data_total_soal'] = $this->getAllSoalUjian($ujian);
//  echo '<pre>';
//  print_r($data['data_total_soal']);
//  die;
  $view = $this->load->view('task_soal_getTotalSoal_view', $data, true);

  return $view;
 }

 public function getTimeLimit($ujian) {
  $siswa = $this->session->userdata('id');
  $data = Modules::run('database/get', array(
  'table' => 'start_ujian su',
  'field' => array('ti.time_limit', 'uj.waktu_ujian', 'shu.sisa_waktu'),
  'join' => array(
  array('time_limit ti', 'su.time_limit = ti.id'),
  array('ujian uj', 'su.ujian = uj.id'),
  array('siswa_has_ujian shu', 'su.ujian = shu.ujian'),
  ),
  'where' => array('su.ujian' => $ujian, 'shu.siswa' => $siswa)
  ))->row_array();

  return $data;
 }

 public function getTimerUjian($ujian) {
  $waktu = $this->getTimeLimit($ujian);  
  $waktu_now = date('H:i:s');
  $time_limit = $waktu['sisa_waktu'] == -1 ? $waktu['time_limit'] : $waktu['sisa_waktu'];
//  echo $time_limit;die;
  $endTime = date('H:i:s', strtotime($waktu_now . ' +' . $time_limit . ' minutes'));
//  echo $endTime;die;

  $date_now = date('H:i:s');
//  echo $date_now;die;
  $jammulai = new Datetime($date_now);
  $jamselesai = new Datetime($endTime);
  

//  echo '<pre>';
//  print_r($jamselesai);die;
  $selisih = $jammulai->diff($jamselesai);
  
  $hours = $selisih->h * 3600;
//  echo '<pre>';
//  print_r($selisih);  die;
  $minute = $selisih->i == 0 ? ($hours * 60) : $selisih->i * 60;
//  echo $minute;die;
  $second = $selisih->s;
//  $total_all = $hours + $minute + $second;
  $total_all = $hours+$minute + $second;
//  echo $total_all;die;

  $is_valid = true;
  $is_exist_ujian = Modules::run('rule_ujian/isDateUjian', $ujian);
  $is_start_ujian = Modules::run('rule_ujian/isStartUjian', $ujian);
  if ($this->siswaIsSubmit($ujian) || !$is_exist_ujian || !$is_start_ujian) {
   $is_valid = false;
  }

  echo json_encode(array(
  'is_valid' => $is_valid,
  'total_all' => $total_all
  ));
 }

 public function updateSisaWaktu($ujian, $minute) {
  $siswa = $this->session->userdata('id');
  Modules::run('database/_update', 'siswa_has_ujian', array('sisa_waktu' => $minute), array('siswa' => $siswa, 'ujian' => $ujian));
 }

 public function getPlayTimesSoalListening($ujian, $soal_id) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian_has_soal',
  'where' => array('ujian' => $ujian, 'soal' => $soal_id)
  ))->row_array();

  $times = $data['is_played'];

  return $times;
 }

 public function playAudioListening($ujian, $soal_id) {
  $play_times = $this->getPlayTimesSoalListening($ujian, $soal_id);

  $is_valid = false;
  $message = '';
  if ($play_times < 2) {
   $this->db->trans_begin();
   try {
    Modules::run('database/_update', 'ujian_has_soal', array('is_played' => ($play_times + 1)), array('ujian' => $ujian, 'soal' => $soal_id));
    $this->db->trans_commit();
    $is_valid = true;
    $message = 'Berhasil DiUpdate';
   } catch (Exception $ex) {
    $this->db->trans_rollback();
    $message = 'Gagal';
   }
  } else {
   $is_valid = false;
   $message = 'Audio Maksimal Dimainkan 2 Kali';
  }
  
  echo json_encode(array('is_valid'=> $is_valid, 'message'=> $message));
 }

}
