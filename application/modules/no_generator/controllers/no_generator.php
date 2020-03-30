<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class No_generator extends MX_Controller {

  public function __construct() {
    parent::__construct();
  }
  
  private function digit_count($length, $value){
    while(strlen($value) < $length)
      $value = '0'. $value;
    return $value;
  }    
  
  public function generateKodeUjian() {
   $no_ujian = 'U'.date('d').date('m').date('Y');
   $data = Modules::run('database/get', array(
   'table' => 'ujian',
   'like' => array(
    array('kode_ujian', $no_ujian)
   ),
   'orderby'=> 'id desc'
   ));
   
   $seq = 1;
   if(!empty($data)){
    $data = $data->row_array();
    $seq = intval(str_replace($no_ujian, '', $data['kode_ujian']));
    $seq +=1;
   }
   
   $seq = $this->digit_count(3, $seq);
   $no_ujian .= $seq;
   return $no_ujian;
  }
}
