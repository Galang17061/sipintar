<?php

class Mpdf extends MX_Controller{
 public function getInitPdf() {
  require_once APPPATH . '/third_party/vendor/autoload.php'; //php 7
  $mpdf = new \Mpdf\Mpdf();
//   echo 'asasd';die;
//   echo '<pre>';
//   print_r(get_class_methods($mpdf));die;
  return $mpdf;
 }
}