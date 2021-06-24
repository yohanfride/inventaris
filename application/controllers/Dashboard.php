<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

	public function __construct() {
        parent::__construct();   
		if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('user_m');
    }

	public function index()
	{        
		$data=array();
		$data['menu']='dashboard';
		$data['chart']=true;
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] ='Dashboard Page';
		
        $this->load->view('dashboard_v', $data);
	}	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
