<?php

class Rule_ujian extends MX_Controller {

 public function __construct() {
  parent::__construct();
  date_default_timezone_set("Asia/Jakarta");
 }
 
 public function isDateUjian($ujian) {
  $date_now = intval(date('Ymd'));
  $data = Modules::run('database/get', array(
    'table' => 'ujian',
    'where' => "id = '" . $ujian . "' and status = 'In Progress'"
  ));
  
  $is_exist = false;
  $data_date_ujian = array();
  if (!empty($data)) {
   $data = $data->row_array();
   $data_date_ujian = explode('-', $data['tanggal_ujian']);
   $date_ujian = intval($data_date_ujian[0].$data_date_ujian[1].$data_date_ujian[2]);
   
   if($date_now >= $date_ujian){
    $is_exist = true;
   }   
  }

  return $is_exist;
 }

 public function functionName($param) {
  
 }
 
 public function getUjianIdByDate() {
  $date_now = date('Y-m-d');
  $data = Modules::run('database/get', array(
    'table' => 'ujian',
    'where' => "tanggal_ujian = '" . $date_now . "'"
  ));

  $id = '';
  if (!empty($data)) {
   $data = $data->row_array();
   $id = $data['id'];
  }


  return $id;
 }

 public function isStartUjian($ujian) {
  $hours = intval(date('Hi'));  
//  echo $hours;die;
  $data = Modules::run('database/get', array(
    'table' => 'ujian',
    'where' => array('id'=> $ujian)
  ))->row_array();
  
  $waktu_mulai_ujian = intval(str_replace(':', '', $data['waktu_ujian']));
//  echo $waktu_mulai_ujian;die;
  $is_start = false;
//  echo $hours;die;
//  echo $waktu_mulai_ujian;die;
  if($hours >= $waktu_mulai_ujian){
   $is_start = true;
  }
  return $is_start;
 }
}
