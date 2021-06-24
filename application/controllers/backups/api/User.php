<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class user extends REST_Controller {

    function __construct()
    {
        parent::__construct();        
		$this->load->model('user_m');
    }
	
	public function myprofile_post(){											
		$user = $this->user_m->get_user_id($this->input->post('id'));		
		if($user){		
			$message = array(					
				'status' => 'true',
				'identitas' => $user
			);
		} else {
			$message = array(					
				'status' => 'false',
				'message' => 'Failed'
			);
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
	}        
	
	public function update_post(){
		$username = $this->input->post("username");
        $this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$user = $this->user_m->get_user_id($this->input->post('id'));
			if(!$user){
				$message = array(					
					'status' => 'false',
					'message' => 'Token Wrong'
				);
			} else {			
				$input=array(
					'username' => $this->input->post('username'),				
				);
				$insert=$this->user_m->update('users','id',$user->id,$input);				
				if($insert){
					$message = array(					
						'status' => 'true',
						'user' => $this->user_m->get_user_id($user->id)
					);
				} else{
					$message = array(					
						'status' => 'false',
						'message' => 'Failed'
					);
				} 
			}
		}
		
		$this->response($message, REST_Controller::HTTP_CREATED);
	}

	public function updatepass_post(){
        $this->load->library('form_validation');
		$this->form_validation->set_rules('passold', 'Old Password', 'required');
		$this->form_validation->set_rules('passconf', 'Konfirmasi Password Confirmation', 'required');
		$this->form_validation->set_rules('passnew', 'Password Baru', 'required|matches[passconf]|min_length[6]');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('is_unique', '%s sudah terdaftar');
		$this->form_validation->set_message('matches', '%s tidak sama');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$user = $this->user_m->get_user_id($this->input->post('id'));		
			if(!$user){
				$message = array(					
					'status' => 'false',
					'message' => 'Token Wrong'
				);
			} else if(!$this->user_m->cek_pass(md5($this->input->post('passold')),$user->id)){
				$message = array(					
						'status' => 'false',
						'message' => 'Old Password  Wrong'
				);	
			} else {
				$input=array(
					'password' => md5($this->input->post('passnew')),										
				);
				$insert=$this->user_m->update('users','id',$user->id ,$input);				
				if($insert){
					$message = array(					
						'status' => 'true',
						'message' => 'Pembaharuan password berhasil'					
					);
				} else{
					$message = array(					
						'status' => 'false',
						'message' => 'Failed'
					);
				} 
			}
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
	}
	
	public function _doupload_file($name,$target)
	{
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
	
	// function _mail_win()
 //    {
 //        $config = array(
 //            'protocol' => $this->config->item('protocol'),
 //            'smtp_host' => $this->config->item('smtp_host'),
 //            'smtp_port' => $this->config->item('smtp_port'),
 //            'smtp_user' => $this->config->item('smtp_user'),
 //            'smtp_pass' => $this->config->item('smtp_pass'),
 //            'mailtype' => $this->config->item('mailtype'),
 //            'charset' => $this->config->item('charset'),
 //            'smtp_crypto' => $this->config->item('smtp_crypto')
 //        );
 //        return $config;
 //    }
}

	