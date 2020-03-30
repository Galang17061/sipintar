<?php

class Nilai extends MX_Controller {

 public function __construct() {
  parent::__construct();
  if ($this->session->userdata('id') == '') {
   redirect(base_url());
  }
 }

 public function getModuleName() {
  return 'nilai';
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
  $base_url = base_url() . $this->getModuleName() . '/index/';
  $total_rows = count($this->getDataNilai());
  $offset = $this->uri->segment(3);

  $data['ujian'] = $this->session->userdata('ujian');
  $data['view_file'] = 'nilai_index_view';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  $data['jumlah_data_nilai'] = count($this->getDataNilai());
  $data['title'] = ucwords(str_replace('_', ' ', $this->getModuleName()));
  $data['data_nilai'] = $this->getDataNilai("", 5, $offset);
  $data['jumlah_data_daftar'] = count(Modules::run('daftar_ujian/getDataUjianDaftar'));
  $data['jumlah_data_histori'] = count(Modules::run('histori_ujian/getDataHistoriUjian'));

  $data['pagination'] = Modules::run('pagination/set_paging', $base_url, base_url() . $this->getModuleName(),
                  $total_rows, 5);
  echo Modules::run('template', $data);
 }

 public function search() {
  $data['module'] = $this->getModuleName();
  $data['data_nilai'] = $this->getDataNilai();
  echo $this->load->view('nilai_search_view', $data, true);
 }

 public function detailAllNilai($ujian, $limit = '', $offset = '') {
  $data['ujian'] = $ujian;
  $data['module'] = $this->getModuleName();
  $data['data_nilai'] = $this->getDataNilai($ujian);
  echo $this->load->view('nilai_detailAllNilai_view', $data, true);
 }

 public function getTotalNilaiSalSiswa($ujian, $siswa) {
  $data = Modules::run('database/get', array(
              'table' => "siswa_has_jawaban shj",
              'field' => array('shj.*', 'bnk.nilai_benar', 'bnk.nilai_salah',
                  'bnk.nilai_kosong',
                  'soaj.true_or_false', 'ks.poin_by', 'soaj.poin'),
              'join' => array(
                  array('soal s', 'shj.soal = s.id'),
                  array('kategori_soal ks', 's.kategori_soal = ks.id'),
                  array('bobot_nilai_kategori bnk', 'bnk.kategori_soal = ks.id', 'left'),
                  array('soal_has_jawaban soaj', 'soaj.id = shj.soal_has_jawaban'),
              ),
              'where' => "shj.ujian = '" . $ujian . "' and shj.siswa = '" . $siswa . "'"
  ));

//  echo "<pre>";
//  echo $this->db->last_query();
//  die;
  $nilai = 0;
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $nilai_benar = $value['nilai_benar'] == '' ? 1 : $value['nilai_benar'];
    $nilai_salah = $value['nilai_salah'] == '' ? 0 : $value['nilai_salah'];
    $nilai_kosong = $value['nilai_kosong'] == '' ? 0 : $value['nilai_kosong'];

    if ($value['poin_by'] == 'SOAL') {
     if ($value['true_or_false'] == '0') {
      $nilai += $nilai_salah;
     } else {
      $nilai += $nilai_benar;
     }
    }else{
     $nilai += $value['poin'];
    }
   }
  }

  return $nilai;
 }

 public function getDataNilai($ujian = "", $limit = '', $offset = '') {
  $keyword = $this->input->post('keyword');
  $siswa = $this->session->userdata('id');
  $access = $this->session->userdata('access');

  $query['table'] = $this->getTableName() . ' shu';
  $query['field'] = array('shu.id', 's.nis',
      's.nama as siswa', 's.id as siswa_id',
      'j.jurusan', 'g.nama as guru', 'mp.mata_pelajaran',
      'uj.kode_ujian',
      'uj.nama_ujian',
      'shu.nilai', 'uj.tanggal_ujian', 'uj.waktu_ujian', 'uj.id as ujian_id');
  $query['join'] = array(
      array('ujian uj', 'shu.ujian = uj.id'),
      array('siswa s', 'shu.siswa = s.id'),
      array('jurusan j', 's.jurusan = j.id'),
      array('guru g', 'uj.guru = g.id'),
      array('mata_pelajaran mp', 'g.mata_pelajaran = mp.id'),
  );

  if ($limit != '') {
   $query['limit'] = $limit;
   $query['offset'] = $offset;
  }

  if ($ujian == '' && $access != 'guru') {
   $query['where'] = array(
       's.id' => $siswa,
//    'uj.id'=> $ujian,
//       'uj.status' => 'Done',
       'uj.deleted'=> 0
   );
  } else {
   if ($ujian != '') {
    $query['where'] = array(
//        'uj.status' => 'Done',
        'uj.id' => $ujian
    );
   } else {
    $query['where'] = array(
//        'uj.status' => 'Done',
        'mp.id' => $this->session->userdata('mata_pelajaran')
    );
   }
  }
  $query['orderby'] = "uj.tanggal_ujian desc, shu.nilai desc";

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
//  echo '<pre>';
//  print_r($data->result_array());
//  die;
//  echo '<pre>';
//  echo $this->db->last_query();
//  die;
  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
//    echo '<pre>';
//    print_r($value);die;
    array_push($result, $value);
   }
  }


  return $result;
 }

 public function getJawabanSiswa($ujian, $siswa) {
//  $siswa = $this->session->userdata('id');
  $data = Modules::run('database/get', array(
              'table' => 'siswa_has_jawaban shj',
              'field' => array('shj.id', 'so_hj.true_or_false as status_jawaban',
                  'uhs.soal', 'so_hj.jawaban', 'uhs.id as soal_id',
                  'so_hj.file_jawaban', 's.file_soal'),
              'join' => array(
                  array('soal_has_jawaban so_hj', 'shj.soal_has_jawaban = so_hj.id'),
                  array('soal s', 'so_hj.soal = s.id'),
                  array('ujian_has_soal uhs', 's.id = uhs.soal')
              ),
              'where' => array('shj.siswa' => $siswa, 'uhs.ujian' => $ujian)
  ));

  $result = array();
  if (!empty($data)) {
   foreach ($data->result_array() as $value) {
    $value['jawaban_benar'] = $this->getTrueAnswerSoal($value['soal']);
    array_push($result, $value);
   }
  }

  return $result;
 }

 public function getTrueAnswerSoal($soal) {
  $data = Modules::run('database/get', array(
              'table' => 'soal_has_jawaban',
              'where' => array('soal' => $soal, 'true_or_false' => true)
  ));

  $answer = "";
  if (!empty($data)) {
   $data = $data->row_array();
   $answer = $data['jawaban'];
  }

  return $answer;
 }

 public function detailJawaban($ujian, $siswa) {
  $data['data_jawaban'] = $this->getJawabanSiswa($ujian, $siswa);
  echo $this->load->view('nilai_detailJawaban_view', $data, true);
 }

 public function downloadPDFNilai($ujian) {
  // $this->load->library('m_pdf');
  // $pdf = $this->m_pdf->load();
  require_once APPPATH . '/third_party/vendor/autoload.php'; //php 7
  $pdf = new \Mpdf\Mpdf();
  // echo '<pre>';
  // print_r(get_class_methods($pdf));die;
  $data['ujian'] = Modules::run('ujian_selesai_dilaksanakan/getDataUjian', $ujian);
  $data['data_nilai'] = $this->getDataNilai($ujian);
  $view = $this->load->view('nilai_downloadPDFNilai_view', $data, true);
  $pdf->WriteHTML($view);
  $pdf->Output('Nilai - ' . $data['ujian']['kode_ujian'] . '.pdf', 'I');
 }

 public function downloadExcel($ujian) {
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
  $excel->getActiveSheet()->setCellValue('B1', 'Nama');
  $excel->getActiveSheet()->setCellValue('C1', 'Nis');
  $excel->getActiveSheet()->setCellValue('D1', 'Jurusan');
  $excel->getActiveSheet()->setCellValue('E1', 'Nilai');

  $list_nilai = $this->getDataNilai($ujian);
  $kode_ujian = '';
  if (count($list_nilai) > 0) {
   $no = 1;
   $counter = 2;
   foreach ($list_nilai as $value) {
    $kode_ujian = $value['kode_ujian'];
    $excel->getActiveSheet()->setCellValue('A' . $counter, $no++);
    $excel->getActiveSheet()->setCellValue('B' . $counter, $value['siswa']);
    $excel->getActiveSheet()->setCellValue('C' . $counter, $value['nis']);
    $excel->getActiveSheet()->setCellValue('D' . $counter, $value['jurusan']);
    $excel->getActiveSheet()->setCellValue('E' . $counter, number_format($value['nilai'], 2));
    $counter += 1;
   }
  }
  header('Content-Disposition: attachment;filename="DaftarNilaiUjian_' . $kode_ujian . '.xlsx"');
//  $objWrite = IOFactory::createWriter($excel, 'Excel2007');
  $objWrite = IOFactory::createWriter($excel, 'Excel2007');
  $objWrite->save('php://output');
 }

}
