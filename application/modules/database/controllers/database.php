<?php

if (!defined('BASEPATH'))
 exit('No direct script access allowed');

class Database extends MX_Controller {

 public function __construct() {
  parent::__construct();
  $this->load->model('database_model');
 }

 public function index() {
  echo '1';
 }

 // CRUD
 public function _insert($table_name, $data, $is_m_n_table = false) {
  if (!$is_m_n_table)
   $data = array_merge($data, array(
    'createddate' => date('Y-m-d H:i:s'),
    'createdby' => $this->session->userdata('id')
   ));
  return $this->database_model->_insert($table_name, $data);
 }

//  public function get($table_name, $order_by, $limit = 1000, $offset = 0){
//    return $this->database_model->get($table_name, $order_by, $limit, $offset);
//  }
 public function get_where($table_name, $data, $order_by = 'id', $limit = 1000, $offset = 0) {
  return $this->database_model->get_where($table_name, $data, $order_by, $limit, $offset);
 }

 public function get_fields_where($table_name, $fields, $data, $order_by = 'id', $limit = 1000, $offset = 0) {
  return $this->database_model->get_fields_where($table_name, $fields, $data, $order_by, $limit, $offset);
 }

 public function get_custom($query, $limit = 1000, $offset = 0) {
  return $this->database_model->get_custom($query, $limit, $offset);
 }

 public function _update($table_name, $data, $id, $is_increment = false, $is_m_n_table = false) {
  if (!$is_m_n_table) {
   $data = array_merge($data, array(
    'updateddate' => date('Y-m-d H:i:s'),
    'updatedby' => $this->session->userdata('id')
   ));
  }
  return $this->database_model->_update($table_name, $data, $id, $is_increment);
 }

 public function _delete($table_name, $condition) {
  return $this->database_model->_delete($table_name, $condition);
 }

 public function get_like($table_name, $data, $foreign_table_keys = array(), $exception_array = array(), $order_by = 'id', $limit = 1000, $offset = 0) {
  return $this->database_model->get_like($table_name, $data, $foreign_table_keys, $exception_array, $order_by, $limit, $offset);
 }

 public function get_like_custom($query, $condition) {
  return $this->database_model->get_custom($query, $condition);
 }

 // get all in one
 public function get($query) {
  return $this->database_model->get($query);
 }

 // ELSE
 public function count_all($query) {
  return $this->database_model->count_all($query);
 }

 public function count_custom($query) {
  return $this->database_model->count_custom($query);
 }

 public function get_last_query() {
  return $this->database_model->last_query();
 }

 public function get_adjusted_headings($table_name, $hidden_fields = array(), $replaced_fields = array(), $adds_array = array(), $is_main_table = true) {
  $fields = $this->db->field_data($table_name);
  $headings = array();
  if ($is_main_table)
   $headings[] = 'no';
  foreach ($fields as $field) {
   if ((strpos($field->name, 'is_') == 1) || in_array($field->name, $hidden_fields) ||
    (strpos($field->name, 'ated_') !== false))
    continue;
   if (array_key_exists($field->name, $replaced_fields))
    $headings[] = $replaced_fields[$field->name];
   else {
    $headings[] = str_replace('_', ' ', $field->name);
   }
  }
  foreach ($adds_array as $add)
   $headings[] = $add;
  if ($is_main_table)
   $headings[] = 'action';
  return $headings;
 }

 public function get_like_fields($table_name, $keyword, $foreign_table_keys = array(), $hidden_fields = array(), $special_fields = array()) {
  $fields = $this->db->field_data($table_name);
  $date_type = $this->get_date_type();
  $like_fields = array();
  foreach ($fields as $field) {
   if (in_array($field->name, $hidden_fields))
    continue;

   if ((!$field->primary_key && (strpos($field->name, 'is_') === false) && (strpos($field->name, 'created') === false)) || in_array($field->name, $special_fields)) {
    if (in_array($field->type, $date_type))
     $like_fields[] = array('DATE_FORMAT(' . $table_name . '.' . $field->name . ', "%d %b %Y")', $keyword);
    else if ($field->name == 'bulan')
     $like_fields[] = array('MONTHNAME(STR_TO_DATE(' . $table_name . '.' . $field->name . ', "%m"))', $keyword);
    else if ($field->type == 'tinyint') {
     switch ($field->name) {
      case 'status_pesan':
       if (strpos('pesan', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 0);
       else if (strpos('terima', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 1);
       break;
      case 'status_lunas':
       if (strpos('belum', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 0);
       else if (strpos('lunas', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 1);
       break;
      case 'status_terima':
       if (strpos('belum', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 0);
       else if (strpos('terima', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 1);
       break;
      case 'status':
       if (strpos('tutup', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 0);
       else if (strpos('aktif', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 1);
       break;
      case 'thr':
      case 'lembur_lebaran_khusus':
       if (strpos('tidak', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 0);
       else if (strpos('ya', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 1);
       break;
      case 'status_gaji':
       if (strpos('pending', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 1);
       else if (strpos('bayar', strtolower($keyword)) !== false)
        $like_fields[] = array($table_name . '.' . $field->name, 2);
       else if ($keyword == '-')
        $like_fields[] = array($table_name . '.' . $field->name, 0);
       break;
     }
    } else
     $like_fields[] = array($table_name . '.' . $field->name, $keyword);
   }
  }

  if (!empty($foreign_table_keys)) {
   foreach ($foreign_table_keys as $row) {
    if ($row[1] == 'bulan')
     $like_fields[] = array('MONTHNAME(STR_TO_DATE(' . $row[0] . '.' . $row[1] . ', "%m"))', $keyword);
    else
     $like_fields[] = array($row[0] . '.' . $row[1], $keyword);
   }
  }
  return $like_fields;
 }

 public function get_exist_where($table_name, $data) {
  return $this->database_model->get_exist_where($table_name, $data);
 }

 private function get_date_type() {
  return array(
   'date',
   'datetime',
   'timestamp'
  );
 }

 public function sum_field_where($table_name, $field, $where) {
  return $this->database_model->sum_field_where($table_name, $field, $where);
 }

}
