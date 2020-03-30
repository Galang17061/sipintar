<?php

class Tes_read extends MX_Controller {

 public function getModuleName() {
  return 'tes_read';
 }

 public function getHeaderJSandCSS() {
  $data = array(
   '<script src="' . base_url() . 'assets/js/message.js"></script>',
   '<script src="' . base_url() . 'assets/js/validation.js"></script>',
   '<script src="' . base_url() . 'assets/js/url.js"></script>',
//   '<script src="' . base_url() . 'assets/js/jszip.min.js"></script>',
   '<script src="' . base_url() . 'assets/js/jszip.js"></script>',
   '<script src="' . base_url() . 'assets/js/controllers/' . $this->getModuleName() . '.js"></script>'
  );

  return $data;
 }

 public function index() {
  $data['view_file'] = 'index';
  $data['header_data'] = $this->getHeaderJSandCSS();
  $data['module'] = $this->getModuleName();
  echo Modules::run('template', $data);
 }

}
