<?php

class Role_access extends MX_Controller{
 public function getAccess($access) { 
  return $access;
 }
 
 public function hasAccessPengawas($id) {
  $data = Modules::run('database/get', array(
  'table' => 'ujian uj',
  'join'=> array(
   array('ujian_has_pengawas uhp', 'uj.id = uhp.ujian'),
   array('pengawas_ujian pu', 'uhp.pengawas_ujian = pu.id')
  ),
  'where' => array('pu.guru'=> $id, 'status'=> 'In Progress')
  ));
  
  $is_has = false;
  if(!empty($data)){
   $is_has = true;
  }
  
  return $is_has;
 }
}

