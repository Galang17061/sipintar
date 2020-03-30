<?php

class Daftar_ujian_ready extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'daftar_ujian_ready';
 }

 public function getTableName() {
  return 'siswa_has_ujian';
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
  $data['view_file'] = 'daftar_ujian_ready_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_daftar_ujian_ready'] = $this->getDataUjianReady();
  echo Modules::run('template', $data);
 }

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_daftar_ujian_ready'] = $this->getDataUjianReady();
  echo $this->load->view('daftar_ujian_ready_search_view', $data, true);
 }

 public function getDataUjianReady() {
  $keyword = $this->input->post('keyword');
  $siswa = $this->session->userdata('id');
  $query['table'] = $this->getTableName() . ' shu';
  $query['field'] = array('shu.id', 'uj.id as ujian',
      'mp.mata_pelajaran', 'uj.nama_ujian',
      'uj.tanggal_ujian',
      'uj.kode_ujian',
      'uj.waktu_ujian',
      'uj.token',
      'shu.sisa_waktu', 'tl.time_limit', 'upl.poin nilai_kelulusan');
  $query['join'] = array(
      array('ujian uj', 'shu.ujian = uj.id'),
      array('guru g', 'uj.guru = g.id'),
      array('mata_pelajaran mp', 'g.mata_pelajaran = mp.id'),
      array('siswa s', 'shu.siswa = s.id'),
      array('start_ujian su', 'uj.id = su.ujian'),
      array('time_limit tl', 'su.time_limit = tl.id'),
      array('(select max(id) id, ujian from ujian_poin_lulus group by ujian) upll', 'uj.id = upll.ujian', 'left'),
      array('ujian_poin_lulus upl', 'upl.id = upll.id', 'left'),
  );
  $query['where'] = array(
      'shu.siswa' => $siswa,
      'uj.deleted'=> 0
  );
  $query['orderby'] = "uj.id desc";
  if ($keyword != '') {
   $query['is_or_like'] = true;
   $query['inside_brackets'] = true;
   $query['like'] = array(
       array('shu.id', $keyword),
       array('uj.tanggal_ujian', $keyword),
       array('uj.waktu_ujian', $keyword),
       array('uj.kode_ujian', $keyword),
       array('g.nama', $keyword),
       array('mp.mata_pelajaran', $keyword)
   );
  }

  $data = Modules::run('database/get', $query);
  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['total_soal'] = $this->getJumlahSoalKeluar($value['ujian']);
    $value['total_dijawab'] = $this->getJumlahSoalDijawab($value['ujian']);
    $value['total_soal_belum'] = intval($value['total_soal']) - intval($value['total_dijawab']);
    $value['is_submit'] = $this->siswaIsSubmit($value['ujian']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function siswaIsSubmit($ujian) {
  $siswa = $this->session->userdata('id');
  $data = Modules::run('database/get', array(
              'table' => 'siswa_has_ujian',
              'where' => "ujian = " . $ujian . " and status = 'Done' "
              . "and siswa = '" . $siswa . "'"
  ));

  $is_submit = false;
  if (!empty($data)) {
   $is_submit = true;
  }

  return $is_submit;
 }

 public function getJumlahSoalDijawab($ujian) {
  $siswa = $this->session->userdata('id');
  $data = Modules::run('database/get', array(
              'table' => 'siswa_has_jawaban',
              'where' => array('ujian' => $ujian, 'siswa' => $siswa)
  ));

  $total = 0;
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $total += 1;
   }
  }
  return $total;
 }

 public function getJumlahSoalKeluar($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian_has_soal_limit_keluar',
              'where' => array('ujian' => $ujian)
  ));

  $total = 0;
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $keluar_soal = intval($value['limit_soal_keluar']);
    $total += $keluar_soal;
   }
  }

  return $total;
 }

 public function checkTokenUjian($ujian, $token) {
  $token_input = $this->input->post('token_input');
  $is_valid = false;
  if ($token_input == $token) {
   $is_valid = true;
  }

  echo json_encode(array(
      'is_valid' => $is_valid,
      'ujian' => $ujian
  ));
 }

}
