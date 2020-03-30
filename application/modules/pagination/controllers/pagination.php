<?php

class Pagination extends MX_Controller {

 public function set_paging($base_url, $first_url, 
  $total_rows, $per_page) {
  $this->load->library('pagination');
  $config['base_url'] = $base_url;
  $config['total_rows'] = $total_rows;
  $config['per_page'] = $per_page;
  $config['first_url'] = $first_url;
  $this->pagination->initialize($config);

  return $this->pagination->create_links();
 }

}
