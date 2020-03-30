<?php

class Upload extends MX_Controller{
	public function __construct(){
		parent::__construct();		
	}
	
	public function index(){
		$get_image = Modules::run('database/get', array(
			'table'=>'tes_gambar',
			'orderby'=>'id desc'
		))->row_array();
		$data['src'] = $get_image['value'];
		$data['module'] = 'upload';
		$data['view_file'] = 'upload_view';		
		echo Modules::run('template', $data);
	}
	
	public function insertImage(){
		$value = $this->input->post('value');		
		$id = Modules::run('database/_insert', 'tes_gambar', array(
			'value'=> $value
		));
		echo $id;
	}
	public function upload_data(){
		$file = json_decode($this->input->post('file'));
  echo '<pre>';
  print_r($_FILES);die;
		foreach($file as $value){
			echo $value->name.'<br/>';
			echo $value->sha1.'<br/>';
			echo base64_encode($value->value).'<br/>';
   echo base64_decode(base64_encode($value->value));
		}
		
	}
	
	public function getFileSha1(){
		$sha1 = sha1($_FILES['file']['name']);  
  echo '<pre>';
  print_r($_FILES);die;
		echo $sha1;
	}
	
	public function contoh(){
		echo 'hallo';
	}
}

?>