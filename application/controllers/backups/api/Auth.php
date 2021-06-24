<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
       $this->load->model('auth_m');
    }
   
    public function login_post(){               
        $username = $this->input->post("username");
        $pass = $this->input->post('password');

        $this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$user = $this->auth_m->cek_login($username, md5($pass));
			if(!empty ($user)){
				$input = array(
					"last_login" => date("Y-m-d h:i:s")
				);
				$insert=$this->auth_m->update('users','id',$user->id, $input);
				$message = [					
					'status' => 'true',
					'user' =>$user
				];
	        }else{
	        	$message = [					
					'status' => 'false',
					'message' => 'Cek Username & Password anda'					
				];			
	        }
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
    }

    public function register_post(){               
        $username = $this->input->post("username");
        $pass = $this->input->post('password');

        $this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[6]');
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
			$input = array(
				'username' => $username,
				'password' => md5($pass)
			);
			$insert1 = $this->auth_m->insert('users',$input);
			if ($insert1){
                $data['success'] = 'success';
                $message = [					
					'status' => 'true',
					'message' => $data['success']
				];
			} else {
                $data['error'] = 'failed';
                $message = [					
					'status' => 'false',
					'message' => $data['error']
				];
            }
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
    }

	function RandomString($j){
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < $j; $i++) {			
			$randstring.= $characters[rand(0, strlen($characters)-1)];			
		}
		return $randstring;
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
}
