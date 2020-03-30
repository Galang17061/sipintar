<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database_model
 *
 * @author Botax
 */
class Database_model extends CI_Model{

  // CRUD
  public function _insert($table_name, $data){
    $this->db->insert($table_name, $data);
    // insert into query log
    return $this->db->insert_id();
  }
//  public function get($table_name, $order_by, $limit, $offset){
//    $this->db->order_by($order_by);
//    return $this->db->get($table_name, $limit, $offset);
//  }
  public function get_where($table_name, $data, $order_by, $limit, $offset){
    $this->db->order_by($order_by);
    return $this->db->get_where($table_name, $data, $limit, $offset);
  }
  public function _update($table_name, $data, $id, $is_increment){
    $this->db->where($id);
    if($is_increment){
      foreach($data as $key => $value)
        $this->db->set($key, $value, false);
      return $this->db->update($table_name);
    } else
    // insert into query log
      return $this->db->update($table_name, $data);
  }
  public function _delete($table_name, $condition){
    $this->db->where($condition);
    // insert into query log
    if($this->db->delete($table_name))
      return true;
    return false;
  }
  // get all in one
  public function get($query)
  {
    if(isset($query['where'])){
      if(isset($query['is_or_where']))
        $this->db->or_where($query['where']);
      else
        $this->db->where($query['where']);
    }

    if(isset($query['join'])){
      foreach($query['join'] as $row)
        // $this->db->join('comments', 'comments.id = blogs.id');
        $this->db->join($row[0], $row[1], $row[2]);
    }
    
    $like_counter = 0;
    if(isset($query['like'])){
      $inside_bracket = '';
      $is_or_like = isset($query['is_or_like']);
      foreach($query['like'] as $row){
        if(isset($query['inside_brackets'])){
          if($inside_bracket == '')
            $inside_bracket .= $row[0] .' LIKE "%'. $row[1] .'%"';
          else
            $inside_bracket .= ' OR '. $row[0] .' LIKE "%'. $row[1] .'%"';
        } else{
          // $this->db->like('title', 'match');
          if($like_counter == 0 || !$is_or_like)
            $this->db->like($row[0], $row[1]);
          else
            $this->db->or_like($row[0], $row[1]);
            #$this->db->or_like($row);

          $like_counter++;
        }
      }
      if(isset($query['inside_brackets'])){
        $this->db->where('('. $inside_bracket .')', null, false);
      }
    }

    if(isset($query['orderby']))
      $this->db->order_by($query['orderby']);
    
    if(isset($query['field']))
        $this->db->select($query['field']);
    
    if(isset($query['groupby']))
      $this->db->group_by($query['groupby']);

    $offet = 0;
    $limit = 1000;
    if(isset($query['limit']))
      $limit = $query['limit'];
    if(isset($query['offset']))
      $offset = $query['offset'];
    $this->db->limit($limit, $offset);

    $result = $this->db->get($query['table']);
    if ($result->num_rows() == 0)
    {
        $result->free_result();
        return false;
    }

    return $result;
  }

  function count_all($query)
  {
    if(isset($query['where']))
        $this->db->where($query['where']);

    if(isset($query['join']))
      foreach($query['join'] as $row)
        // $this->db->join('comments', 'comments.id = blogs.id');
        $this->db->join($row[0], $row[1], $row[2]);

    $like_counter = 0;

    if(isset($query['like'])){
      $is_or_like = isset($query['is_or_like']);
      $inside_bracket = '';
      foreach($query['like'] as $row)
      {
        if(isset($query['inside_brackets'])){
          if($inside_bracket == '')
            $inside_bracket .= $row[0] .' LIKE "%'. $row[1] .'%"';
          else
            $inside_bracket .= ' OR '. $row[0] .' LIKE "%'. $row[1] .'%"';
          continue;
        }
        // $this->db->like('title', 'match');
        if($like_counter == 0 || !$is_or_like)
          $this->db->like($row[0], $row[1]);
        else
          $this->db->or_like($row[0], $row[1]);

        $like_counter++;
      }

      if(isset($query['inside_brackets'])){
        $this->db->where('('. $inside_bracket .')', null, false);
      }
    }

    if(isset($query['groupby']))
      $this->db->group_by($query['groupby']);

    $result = $this->db->from($query['table']);
    return $this->db->count_all_results();
  }
  
  public function get_last_query(){
    return $this->db->last_query();
  }
  public function get_like($table_name, $data, $foreign_table_keys, $exception_array, $order_by, $limit, $offset){
    $this->db->order_by($order_by);
    $this->db->select($table_name .'.*');
    foreach($exception_array as $exception)
      $this->db->select('NULL AS '. $table_name .'.'. $exception);
    $this->db->from($table_name);
    foreach($foreign_table_keys as $key => $foreign_table_key){
      $this->db->join($key . ($foreign_table_key[3] ? ' '.$foreign_table_key[3] : ''),
              $table_name .'.'. $foreign_table_key[0] .'='. ($foreign_table_key[3] ? $foreign_table_key[3] : $key) .'.'. $foreign_table_key[1],
              'left');
    }
    if(count($data) > 0){
      $start = TRUE;
      $likes_query = '';
      foreach($data as $key => $like){
        if($start){
//          $this->db->like($key, $like);
          $likes_query .= $key .' LIKE "%'. $like .'%"';
          $start = FALSE;
          continue;
        }
//        $this->db->or_like($key, $like);
        $likes_query .= ' OR '. $key .' LIKE "%'. $like .'%"';
      }
      $this->db->where('('. $likes_query .')');
    }
    $this->db->limit($limit, $offset);
    return $this->db->get();
  }
  public function get_like_custom($query, $condition){
    return $this->db->query($query, $condition);
  }
  public function get_exist_where($table_name, $data){
    $result = $this->db->get_where($table_name, $data);
    if($result->num_rows() > 0)
      return true;
    return false;
  }
  public function get_fields_where($table_name, $fields, $where, $order_by, $limit, $offset){
    $this->db->select($fields);
    $this->db->where($where);
    $this->db->order_by($order_by);
    return $this->db->get($table_name, $limit, $offset);
  }
  public function get_custom($query, $limit, $offset){
    $result = $this->db->query($query .' LIMIT '. $limit .' OFFSET '. $offset);
    if ($result->num_rows() == 0)
    {
        $result->free_result();
        return FALSE;
    }
    return $result;
  }
  public function count_custom($query){
    return $this->db->query($query)->num_rows();
  }
  public function sum_field_where($table_name, $field, $where){
    $this->db->select_sum($field);
    $this->db->where($where);
    return $this->db->get($table_name)->row_array();
  }
}
?>
