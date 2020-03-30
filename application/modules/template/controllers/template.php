<?php

class Template extends MX_Controller {

 public function index($data) {
  echo $this->load->view('template_view', $data, true);
 }
}
