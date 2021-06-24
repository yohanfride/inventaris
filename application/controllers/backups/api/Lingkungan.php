<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Lingkungan extends REST_Controller {

    function __construct(){
        parent::__construct();        
		$this->load->model('lingkungan_m');
		$this->load->model('user_m');
    }
   	
	function wilayah_get(){				
		$wilayah = $this->lingkungan_m->get_wilayah();
		if(empty($wilayah)){
			$message = array(					
				'status' => 'false',
				'message' => 'No Category'
			);
		} else {
			$message = array(					
				'status' => 'true',
				'wilayah' => $wilayah
			);
		}
		$data['data']=$wilayah;
		$this->response($message, REST_Controller::HTTP_CREATED);
	}	
	
	function all_post(){				
		$wil = $this->input->post('wilayah');
		$ling = $this->input->post('nama');
		$lingkungan = $this->lingkungan_m->get_lingkungan($wil,$ling);
		if(empty($lingkungan)){
			$message = array(					
				'status' => 'false',
				'message' => 'No Service'
			);
		} else {
			$message = array(					
				'status' => 'true',
				'lingkungan' => $lingkungan
			);
		}
		$data['data']=$lingkungan;
		$data['wilayah'] = $wil;
		$data['nama'] = $ling;
		$this->response($message, REST_Controller::HTTP_CREATED);
	}
	
	public function _doupload_file($name,$target,$i=0){
		$img						= $name;
		$config['file_name']  		= date('dmYHis').'_'.preg_replace("/[^0-9a-zA-Z ]/", "", $_FILES[$img]['name']);
		$config['upload_path'] 		= $target;
		$config['overwrite'] 		= FALSE;
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000000';
		$config['remove_spaces']  	= TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($img)){
			$return['message'] 	 = $this->upload->display_messages();
			$return['file_name'] = '';
		}else{
			$data = array('upload_data' => $this->upload->data());
			$return['message'] 	 = '-';
			$return['file_name'] = $data['upload_data']['file_name'];
		}

		$this->upload->file_name = '';
		if($return['file_name']==''){
			//return $return['message'];
			return '-';
		}else{
			return $return['file_name'];
		}
	}

}
