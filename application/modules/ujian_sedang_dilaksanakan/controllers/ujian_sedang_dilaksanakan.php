<?php

class Ujian_sedang_dilaksanakan extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'ujian_sedang_dilaksanakan';
 }

 public function getTableName() {
  return 'ujian';
 }

 public function getHeaderJSandCSS() {
  $data = array(
      '<script src="' . base_url() . 'assets/js/message.js"></script>',
      '<script src="' . base_url() . 'assets/js/validation.js"></script>',
      '<script src="' . base_url() . 'assets/js/url.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/' . $this->getModuleName() . '_v1.js"></script>',
      '<script src="' . base_url() . 'assets/js/controllers/nilai.js"></script>',
  );

  return $data;
 }

 public function index() {
  $data['view_file'] = 'ujian_sedang_dilaksanakan_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_ujian_sedang'] = $this->getDataUjianSedang();
  $data['jumlah_data_ujian_siap'] = count(Modules::run('ujian_siap_dilaksanakan/getDataUjianBelum')) > 0 ? count(Modules::run('ujian_siap_dilaksanakan/getDataUjianBelum')) : '';
  $data['jumlah_data_ujian_sedang'] = count($this->getDataUjianSedang()) > 0 ? count($this->getDataUjianSedang()) : '';
  echo Modules::run('template', $data);
 }

 public function getDataUjianSedang() {
  $keyword = $this->input->post('keyword');
  $query['table'] = $this->getTableName() . ' uj';
  $query['field'] = array('uj.id', 'uj.nama_ujian', 'uj.kode_ujian',
      'g.nama as guru', 'ku.kategori_ujian', 'uj.tanggal_ujian',
      'uj.createddate as tanggal_dibuat', 'g.nip', 'uj.waktu_ujian',
      'uj.token', 'upl.poin nilai_kelulusan');
  $query['join'] = array(
      array('guru g', 'uj.guru = g.id'),
      array('kategori_ujian ku', 'uj.kategori_ujian = ku.id'),
      array('(select max(id) id, ujian from ujian_poin_lulus group by ujian) upll', 'uj.id = upll.ujian', 'left'),
      array('ujian_poin_lulus upl', 'upl.id = upll.id', 'left'),
  );
  $query['where'] = array(
      'uj.status' => 'In Progress',
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
    $soal = Modules::run('ujian_siap_dilaksanakan/getDataSoal', ($value['id']));
    $value['total_soal'] = count($soal);
    $value['pengawas_ujian'] = Modules::run('ujian_siap_dilaksanakan/getDataPengawasUjian', $value['id']);
    $value['has_soal'] = Modules::run('ujian_siap_dilaksanakan/hasSoalUjian', $value['id']);
    $value['kategori_soal'] = Modules::run('ujian_siap_dilaksanakan/getDataKategoriUjian', $value['id']);
    $value['peserta_ujian'] = count(Modules::run('ujian_siap_dilaksanakan/getAllPesertaUjian', $value['id']));
    $value['limit_waktu_ujian'] = Modules::run('ujian_siap_dilaksanakan/getLimitWaktuUjian', $value['id']);
    if ($value['has_soal']) {
     array_push($result, $value);
    }
   }
  }

  return $result;
 }

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_ujian_sedang'] = $this->getDataUjianSedang();
  echo $this->load->view('ujian_sedang_dilaksanakan_search_view', $data, true);
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
              'table' => 'kategori_soal',
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

 public function detailUjian($ujian) {
  $data = $this->getDataUjian($ujian);
  $data['view_file'] = 'ujian_sedang_dilaksanakan_detailUjian_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['ujian'] = $ujian;
  $data['list_kategori_soal'] = Modules::run('ujian_siap_dilaksanakan/getListKategoriSoal', $ujian);
  $data['list_soal'] = Modules::run('ujian_siap_dilaksanakan/getDataSoal', $ujian);
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['jumlah_data_ujian_siap'] = count(Modules::run('ujian_siap_dilaksanakan/getDataUjianBelum')) > 0 ? count(Modules::run('ujian_siap_dilaksanakan/getDataUjianBelum')) : '';
  $data['jumlah_data_ujian_sedang'] = count($this->getDataUjianSedang()) > 0 ? count($this->getDataUjianSedang()) : '';
  echo Modules::run('template', $data);
 }

}
