<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_m');
    }

    public function login() {
        if ($this->session->userdata('amplop_session')) {
            redirect(base_url('dashboard'));
        }
        $data['error'] = FALSE;
        $data['title'] = 'Login';
        $this->load->view('user_login_v',$data);        
    }

    public function dologin() {
        if ($this->session->userdata('amplop_session')) {
            redirect(base_url('dashboard'));
        }
        $data['title'] = 'Login';
        
        $this->load->library('form_validation');
        $data['error'] = FALSE;
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
            $username = $this->input->post("username");
            $pass = $this->input->post('password');
            $user = $this->auth_m->cek_login($username, md5($pass));
            if(!empty ($user)){
                if($user->status != 1){
                    $data['error'] = 'Akun anda tidak aktif, silahkan menghubungi administrator';                
                } else {
                    $input = array(
                        "last_login" => date("Y-m-d H:i:s")
                    );
                    $insert=$this->auth_m->update('users','id',$user->id, $input);
                    $this->session->set_userdata('amplop_session',$user);
                    redirect(base_url('dashboard'));
                }
            }else{
                $data['error'] = 'Username & Password tidak terdaftar';                
            }
        }
        $this->load->view('user_login_v', $data);
    }

    function RandomString($j){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $j; $i++) {           
            $randstring.= $characters[rand(0, strlen($characters)-1)];          
        }
        return $randstring;
    }
    
    public function logout(){
        $this->session->unset_userdata('amplop_session');
        $this->session->unset_userdata('cart');
        redirect(base_url('auth/login'));
    }
}

/* End of file  */
/* Location: ./application/controllers/ */
