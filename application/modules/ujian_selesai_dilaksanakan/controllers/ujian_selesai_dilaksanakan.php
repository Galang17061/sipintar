<?php

class Ujian_selesai_dilaksanakan extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'ujian_selesai_dilaksanakan';
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
      '<script src="' . base_url() . 'assets/js/controllers/nilai.js"></script>'
  );

  return $data;
 }

 public function index() {
  $data['view_file'] = 'ujian_selesai_dilaksanakan_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_ujian_selesai'] = $this->getDataUjianSelesai();
  echo Modules::run('template', $data);
 }

 public function getDataUjianSelesai() {
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
      'uj.status' => 'Done',
      'uj.guru' => $this->session->userdata('id'),
      'uj.deleted' => 0
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

//  echo '<pre>';
//  print_r($result);die;
  return $result;
 }

 public function getDataSoal($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian_has_soal uhs',
              'field' => array('uhs.id as id_soal', 'uhs.soal', 'ks.kategori'),
              'join' => array(
                  array('kategori_soal ks', 'uhs.kategori_soal = ks.id'),
              ),
              'where' => array('uhs.ujian' => $ujian)
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
              'where' => array('ujian_has_soal' => $soal, 'true_or_false' => 1)
          ))->row_array();

  return $data['jawaban'];
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
  $data['data_ujian_selesai'] = $this->getDataUjianSelesai();
  echo $this->load->view('ujian_selesai_dilaksanakan_search_view', $data, true);
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
  $data['view_file'] = 'ujian_selesai_dilaksanakan_detailUjian_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['ujian'] = $ujian;
  $data['list_kategori_soal'] = Modules::run('ujian_siap_dilaksanakan/getListKategoriSoal', $ujian);
  $data['list_soal'] = Modules::run('ujian_siap_dilaksanakan/getDataSoal', $ujian);
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  echo Modules::run('template', $data);
 }

 public function downloadPDF($ujian) {
//  $this->load->library('m_pdf');
//  $pdf = $this->m_pdf->load();
//  $pdf = new mPDF('A4');
  require_once APPPATH . '/third_party/vendor/autoload.php'; //php 7
  $pdf = new \Mpdf\Mpdf();

  $data['ujian'] = $this->getDataUjian($ujian);
  $data['list_soal'] = Modules::run('ujian_siap_dilaksanakan/getDataSoal', $ujian);
  $view = $this->load->view($this->getModuleName() . '_downloadPDF_view', $data, true);
  $pdf->WriteHTML($view);
  $pdf->Output('Soal UJIAN - ' . $data['ujian']['kode_ujian'] . '.pdf', 'I');
 }

 public function getDataUjianHasSoal($ujian) {
  $data = Modules::run('database/get', array(
              'table' => 'ujian_has_soal',
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

 public function remove($ujian) {
  $is_valid = false;
  $this->db->trans_begin();
  try {
//   Modules::run('database/_delete', 'siswa_has_jawaban', array('ujian' => $ujian));
//   Modules::run('database/_delete', 'siswa_has_ujian', array('ujian' => $ujian));
//   Modules::run('database/_delete', 'ujian_has_soal_limit_keluar', array('ujian' => $ujian));
//   $ujian_has_soal = $this->getDataUjianHasSoal($ujian);
//   foreach ($ujian_has_soal as $value) {
//    //delete
//    Modules::run('database/_delete', 'siswa_has_kategori_random_soal', array('ujian_has_soal' => $value['id']));
//   }
//   Modules::run('database/_delete', 'ujian_has_soal', array('ujian' => $ujian));
//   Modules::run('database/_delete', 'ujian_has_pengawas', array('ujian' => $ujian));
//   Modules::run('database/_delete', 'start_ujian', array('ujian' => $ujian));
//   Modules::run('database/_delete', 'ujian', array('id' => $ujian));
   Modules::run('database/_update', 'ujian', array('deleted' => 1), array('id' => $ujian));
   $this->db->trans_commit();
   $is_valid = true;
  } catch (Exception $ex) {
   $this->db->trans_rollback();
  }

  echo json_encode(array('is_valid' => $is_valid));
 }

 public function downloadExcel($ujian, $kode_ujian) {
  $this->load->library('PHPExcel', array());
  $this->load->library('PHPExcel/IOFactory', array());
  $excel = new PHPExcel();
  //set border     
  $bStyle = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );
  $bStyle_out = array(
      'borders' => array(
          'top' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          ),
          'left' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          ),
          'right' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          ),
      ),
      'fill' => array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
//  'color' => array('rgb' => 'E1E0F7'),
      )
  );
  $bStyle_left_right = array(
      'borders' => array(
          'left' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          ),
          'right' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      ),
      'fill' => array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
//  'color' => array('rgb' => 'E1E0F7'),
      )
  );

  $excel->getActiveSheet()->getStyle()->applyFromArray($bStyle_out);
  $excel->getActiveSheet()->setCellValue('A1', 'No');
  $excel->getActiveSheet()->setCellValue('B1', 'Kategori Soal');
  $excel->getActiveSheet()->setCellValue('C1', 'Soal');
  $excel->getActiveSheet()->setCellValue('D1', 'Jawaban Benar');

  $list_soal = Modules::run('ujian_siap_dilaksanakan/getDataSoal', $ujian);
  if (count($list_soal) > 0) {
   $no = 1;
   $counter = 2;
   foreach ($list_soal as $value) {
    $excel->getActiveSheet()->setCellValue('A' . $counter, $no++);
    $excel->getActiveSheet()->setCellValue('B' . $counter, $value['kategori']);
    $excel->getActiveSheet()->setCellValue('C' . $counter, $value['soal']);
    $excel->getActiveSheet()->setCellValue('D' . $counter, $value['jawaban_benar']);
    $counter += 1;
   }
  }
  header('Content-Disposition: attachment;filename="Ujian_' . $kode_ujian . '.xlsx"');
//  $objWrite = IOFactory::createWriter($excel, 'Excel2007');
  $objWrite = IOFactory::createWriter($excel, 'Excel2007');
  $objWrite->save('php://output');
 }

}
