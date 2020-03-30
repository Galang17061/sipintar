<?php

class Header extends MX_Controller{
 public function index() {
  $data['data'] = "";
  echo $this->load->view('index', $data, true);
 }
}