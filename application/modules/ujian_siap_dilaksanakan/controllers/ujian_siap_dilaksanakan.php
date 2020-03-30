<?php

class Ujian_siap_dilaksanakan extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'ujian_siap_dilaksanakan';
 }

 public function getTableName() {
  return 'ujian';
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
  $data['view_file'] = 'ujian_siap_dilaksanakan_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_ujian_belum'] = $this->getDataUjianBelum();
  $data['jumlah_data_ujian_siap'] = count($this->getDataUjianBelum()) > 0 ? count($this->getDataUjianBelum()) : '';
  $data['jumlah_data_ujian_sedang'] = count(Modules::run('ujian_sedang_dilaksanakan/getDataUjianSedang')) > 0 ? count(Modules::run('ujian_sedang_dilaksanakan/getDataUjianSedang')) : '';
  echo Modules::run('template', $data);
 }

 public function getDataUjianBelum() {
  $keyword = $this->input->post('keyword');
  $query['table'] = $this->getTableName() . ' uj';
  $query['field'] = array('uj.id', 'uj.nama_ujian', 'uj.kode_ujian',
      'g.nama as guru', 'ku.kategori_ujian', 'uj.tanggal_ujian',
      'uj.createddate as tanggal_dibuat', 'g.nip',
      'uj.waktu_ujian', 'uj.token', 'upl.poin nilai_kelulusan');
  $query['join'] = array(
      array('guru g', 'uj.guru = g.id'),
      array('kategori_ujian ku', 'uj.kategori_ujian = ku.id'),
      array('(select max(id) id, ujian from ujian_poin_lulus group by ujian) upll', 'uj.id = upll.ujian', 'left'),
      array('ujian_poin_lulus upl', 'upl.id = upll.id', 'left'),
  );
  $query['where'] = array(
      'uj.status' => 'Ready',
      'uj.guru' => $this->session->userdata('id')
  );
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
    $soal = $this->getDataSoal($value['id']);
    $value['total_soal'] = count($soal);
    $value['pengawas_ujian'] = $this->getDataPengawasUjian($value['id']);
    $value['has_soal'] = $this->hasSoalUjian($value['id']);
    $value['kategori_soal'] = $this->getDataKategoriUjian($value['id']);
    $value['peserta_ujian'] = count($this->getAllPesertaUjian($value['id']));
    $value['limit_waktu_ujian'] = $this->getLimitWaktuUjian($value['id']);
    if ($value['has_soal']) {
     array_push($result, $value);
    }
   }
  }

  return $result;
 }

 public function checkHasSoalDikeluarkan($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian_has_soal_limit_keluar',
              'where' => array('ujian' => $ujian)
  ));

  $is_exist = false;
  if (!empty($data)) {
   $is_exist = true;
  }

  return $is_exist;
 }

 public function execStartUjian($ujian) {
  $is_valid = false;
  $message = '';
  if ($this->checkHasSoalDikeluarkan($ujian)) {
   $this->db->trans_begin();
   try {
    Modules::run('database/_update', 'ujian', array('status' => 'In Progress'), array('id' => $ujian));
    Modules::run('database/_update', 'start_ujian', array('status' => true), array('ujian' => $ujian));
    $this->db->trans_commit();
    $is_valid = true;
   } catch (Exception $ex) {
    $this->db->trans_rollback();
    $message = 'Gagal';
   }
  } else {
   $message = 'Belum Ada Soal yang Dikeluarkan';
  }

  echo json_encode(array('is_valid' => $is_valid, 'message' => $message));
 }

 public function getDataSoal($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian_has_soal uhs',
              'field' => array('s.id as id_soal',
                  's.soal', 'ks.kategori', 's.file_soal'),
              'join' => array(
                  array('soal s', 'uhs.soal = s.id'),
                  array('kategori_soal ks', 's.kategori_soal = ks.id'),
              ),
              'where' => array('uhs.ujian' => $ujian)
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['jawaban_benar'] = $this->getJawabanBenar($value['id_soal']);
    $value['file_jawaban'] = $this->getFileJawaban($value['id_soal']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getFileJawaban($soal) {
  $data = Modules::run('database/get', array(
              'table' => 'soal_has_jawaban',
              'where' => array('soal' => $soal, 'true_or_false' => 1)
  ));

  $file_jawaban = "";
  if (!empty($data)) {
   $data = $data->row_array();
   $file_jawaban = $data['file_jawaban'];
  }

  return $file_jawaban;
 }

 public function getJawabanBenar($soal) {
  $data = Modules::run('database/get', array(
              'table' => 'soal_has_jawaban',
              'where' => array('soal' => $soal, 'true_or_false' => 1)
  ));

  $jawaban = "";
  if (!empty($data)) {
   $data = $data->row_array();
   $jawaban = $data['jawaban'];
  }

  return $jawaban;
 }

 public function getDataKategoriUjian($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'kategori_soal ks',
              'join' => array(
                  array('soal s', 'ks.id = s.kategori_soal'),
                  array('ujian_has_soal uhs', 's.id = uhs.soal'),
              ),
              'where' => array('uhs.ujian' => $ujian)
  ));

  $str_kategori = "";
  if (!empty($data)) {
   $result = array();
   $temp = array();
   foreach ($data->result_array() as $value) {
    if (!in_array($value['kategori'], $temp)) {
     array_push($result, $value['kategori']);
     $temp[] = $value['kategori'];
    }
   }

   $str_kategori = implode(',', $result);
  }

  return $str_kategori;
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
  $data['data_ujian_belum'] = $this->getDataUjianBelum();
  echo $this->load->view('ujian_siap_dilaksanakan_search_view', $data, true);
 }

 public function chooseSiswa($ujian) {
  $data['ujian'] = $ujian;
  $data['data_siswa'] = $this->getListAllSiswa();
  $data['list_jurusan'] = $this->getListJurusan();
  echo $this->load->view('ujian_siap_dilaksanakan_chooseSiswa_view', $data, true);
 }

 public function getListAllSiswa($jurusan = '') {
  $query['table'] = 'siswa s';
  $query['field'] = array('s.id', 's.nama', 's.nis', 'j.jurusan');
  $query['join'] = array(
      array('jurusan j', 's.jurusan = j.id'),
  );

  $query['where'] = "s.deleted = 0";
  if ($jurusan != '') {
   $query['where'] = "j.id = " . $jurusan . " and s.deleted = 0";
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
  $jurusan_id = $jurusan_id == '0' ? '' : $jurusan_id;
  $data['data_siswa'] = $this->getListAllSiswa($jurusan_id);
  echo $this->load->view('ujian_siap_dilaksanakan_filterSiswaByJurusan_view', $data, true);
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
              'where' => array('deleted' => 0)
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
//  echo '<pre>';
//  print_r($data);die;
  echo $this->load->view('ujian_siap_dilaksanakan_aturWaktuUjian_view', $data, true);
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

 public function simpanNilaiLulus() {
  $ujian = $this->input->post('ujian');
  $nilai = $this->input->post('nilai');

  $is_valid = false;

  $this->db->trans_begin();
  try {
   $data_poin_ujian['poin'] = $nilai;
   $data_poin_ujian['ujian'] = $ujian;
   $poin_ujian = Modules::run('database/_insert', 'ujian_poin_lulus', $data_poin_ujian);
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
    $data_siswa_has_ujian['status'] = 'In Progress';
    $data_siswa_has_ujian['siswa'] = $value->id;
    $siswa_has_ujian = Modules::run('database/_insert', 'siswa_has_ujian', $data_siswa_has_ujian);
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
              'field' => array('distinct(ks.id) as kategori_soal', 'uhs.ujian', 'ks.kategori'),
              'join' => array(
                  array('soal s', 'ks.id = s.kategori_soal'),
                  array('ujian_has_soal uhs', 's.id = uhs.soal'),
//     array('ujian_has_soal_limit_keluar uhslk', 'uhs.ujian = uhslk.ujian', 'left'),
//     array('ujian_has_soal_limit_keluar uhslk2', 'ks.id = uhslk2.kategori_soal', 'left'),
              ),
              'where' => array('uhs.ujian' => $ujian)
  ));
//  echo '<pre>';
//  echo $this->db->last_query();
//  die;
  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['limit_soal_keluar'] = $this->getLimitKeluarSoal($value['ujian'], $value['kategori_soal']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getLimitKeluarSoal($ujian, $kategori_soal) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian_has_soal_limit_keluar',
              'where' => array('ujian' => $ujian, 'kategori_soal' => $kategori_soal)
  ));

  $limit_soal_keluar = 0;
  if (!empty($data)) {
   $data = $data->row_array();
   $limit_soal_keluar = $data['limit_soal_keluar'];
  }

  return $limit_soal_keluar;
 }

 public function detailUjian($ujian) {
  $data = $this->getDataUjian($ujian);
  $data['view_file'] = 'ujian_siap_dilaksanakan_detailUjian_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['ujian'] = $ujian;
  $data['list_kategori_soal'] = $this->getListKategoriSoal($ujian);
  $data['list_soal'] = $this->getDataSoal($ujian);
  $data['jumlah_data_ujian_siap'] = count($this->getDataUjianBelum()) > 0 ? count($this->getDataUjianBelum()) : '';
  $data['jumlah_data_ujian_sedang'] = count(Modules::run('ujian_sedang_dilaksanakan/getDataUjianSedang')) > 0 ? count(Modules::run('ujian_sedang_dilaksanakan/getDataUjianSedang')) : '';
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function tentukanSoalKeluar($ujian) {
  $data = $this->getDataUjian($ujian);
  $data['view_file'] = 'ujian_siap_dilaksanakan_tentukanSoalKeluar_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['ujian'] = $ujian;
  $data['list_kategori_soal'] = $this->getListKategoriSoal($ujian);

  $data['list_soal'] = $this->getDataSoal($ujian);
  $data['jumlah_data_ujian_siap'] = count($this->getDataUjianBelum()) > 0 ? count($this->getDataUjianBelum()) : '';
  $data['jumlah_data_ujian_sedang'] = count(Modules::run('ujian_sedang_dilaksanakan/getDataUjianSedang')) > 0 ? count(Modules::run('ujian_sedang_dilaksanakan/getDataUjianSedang')) : '';
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function tentukanSoalKeluarView($kategori_soal, $ujian, $soal_keluar) {
  $data['kategori_soal'] = $kategori_soal;
  $data['ujian'] = $ujian;
  $data['soal_keluar'] = $soal_keluar;
//  echo '<pre>';
//  print_r($data);
//  die;
  echo $this->load->view('membuat_soal/membuat_soal_setLimitSoal_view', $data, true);
 }

}
