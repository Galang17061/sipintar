<?php

class Daftar_ujian extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'daftar_ujian';
 }

 public function getTableName() {
  return 'siswa_has_ujian';
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
  $data['ujian'] = $this->session->userdata('ujian');
  $data['view_file'] = 'daftar_ujian_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_daftar_ujian'] = $this->getDataUjianDaftar();
  $data['jumlah_data_daftar'] = count($this->getDataUjianDaftar());
  $data['jumlah_data_nilai'] = count(Modules::run('nilai/getDataNilai'));
  $data['jumlah_data_histori'] = count(Modules::run('histori_ujian/getDataHistoriUjian'));
  echo Modules::run('template', $data);
 }

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_daftar_ujian'] = $this->getDataUjianDaftar();
  echo $this->load->view('daftar_ujian_search_view', $data, true);
 }

 public function getDataUjianDaftar() {
  $keyword = $this->input->post('keyword');
  $siswa = $this->session->userdata('id');

  $query['table'] = 'ujian uj';
  $query['field'] = array('g.nama as guru', 'mp.mata_pelajaran',
   'uj.kode_ujian',
   'uj.nama_ujian', 'uj.tanggal_ujian', 'uj.waktu_ujian');
  $query['join'] = array(
   array('guru g', 'uj.guru = g.id'),
   array('mata_pelajaran mp', 'g.mata_pelajaran = mp.id'),
  );
  $query['where'] = array(
   'uj.status' => 'Ready',
   'uj.deleted'=> 0
  );
  $query['orderby'] = "uj.tanggal_ujian desc";

  if ($keyword != '') {
   $query['is_or_like'] = true;
   $query['inside_brackets'] = true;
   $query['like'] = array(
    array('g.nama', $keyword),
    array('uj.kode_ujian', $keyword),
    array('uj.nama_ujian', $keyword),
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

}
