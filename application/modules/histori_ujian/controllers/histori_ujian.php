<?php

class Histori_ujian extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'histori_ujian';
 }

 public function getTableName() {
  return 'siswa_has_ujian';
 }

 public function getHeaderJSandCSS() {
  $data = array(
      '<script src="' . base_url() . 'assets/js/message.js"></script>',
      '<script src="' . base_url() . 'assets/js/validation.js"></script>',
      '<script src="' . base_url() . 'assets/js/url.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/nilai.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/' . $this->getModuleName() . '_v1.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/ujian_selesai_dilaksanakan_v1.js"></script>'
  );

  return $data;
 }

 public function index() {
  $data['ujian'] = $this->session->userdata('ujian');
  $data['nilai_active'] = $this->session->userdata('nilai_active');
  $data['view_file'] = 'histori_ujian_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_histori_ujian'] = $this->getDataHistoriUjian();
  $data['jumlah_data_nilai'] = count(Modules::run('nilai/getDataNilai'));
  $data['jumlah_data_daftar'] = count(Modules::run('daftar_ujian/getDataUjianDaftar'));
  $data['jumlah_data_histori'] = count($this->getDataHistoriUjian());
  echo Modules::run('template', $data);
 }

 public function search() {
  $data['nilai_active'] = $this->session->userdata('nilai_active');
  $data['module'] = $this->getModuleName();
  $data['data_histori_ujian'] = $this->getDataHistoriUjian();
  echo $this->load->view('histori_ujian_search_view', $data, true);
 }

 public function getDataHistoriUjian() {
  $keyword = $this->input->post('keyword');
  $siswa = $this->session->userdata('id');

  $query['table'] = $this->getTableName() . ' shu';
  $query['field'] = array('shu.id', 's.nis', 's.nama as siswa',
      'j.jurusan', 'g.nama as guru', 'mp.mata_pelajaran',
      'uj.kode_ujian',
      'uj.nama_ujian',
      'shu.nilai', 'uj.tanggal_ujian', 'uj.waktu_ujian', 
      'uj.id as ujian_id', 'upl.poin nilai_kelulusan');
  $query['join'] = array(
      array('ujian uj', 'shu.ujian = uj.id'),
      array('siswa s', 'shu.siswa = s.id'),
      array('jurusan j', 's.jurusan = j.id'),
      array('guru g', 'uj.guru = g.id'),
      array('mata_pelajaran mp', 'g.mata_pelajaran = mp.id'),
      array('(select max(id) id, ujian from ujian_poin_lulus group by ujian) upll', 'uj.id = upll.ujian', 'left'),
      array('ujian_poin_lulus upl', 'upl.id = upll.id', 'left'),
  );
  $query['where'] = array(
      's.id' => $siswa,
      'uj.status' => 'Done',
      'uj.deleted'=> 0
  );
  $query['orderby'] = "uj.tanggal_ujian desc";

  if ($keyword != '') {
   $query['is_or_like'] = true;
   $query['inside_brackets'] = true;
   $query['like'] = array(
       array('shu.id', $keyword),
       array('s.nis', $keyword),
       array('s.nama', $keyword),
       array('j.jurusan', $keyword),
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

 public function detailUjian($ujian) {
  $data = Modules::run('ujian_selesai_dilaksanakan/getDataUjian', $ujian);
  $data['view_file'] = 'histori_ujian_detailUjian_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['ujian'] = $ujian;
  $data['list_kategori_soal'] = Modules::run('ujian_siap_dilaksanakan/getListKategoriSoal', $ujian);
  $data['list_soal'] = Modules::run('ujian_siap_dilaksanakan/getDataSoal', $ujian);
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['jumlah_data_nilai'] = count(Modules::run('nilai/getDataNilai'));
  $data['jumlah_data_daftar'] = count(Modules::run('daftar_ujian/getDataUjianDaftar'));
  $data['jumlah_data_histori'] = count($this->getDataHistoriUjian());
  echo Modules::run('template', $data);
 }

}
