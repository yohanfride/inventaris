<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class amplop extends CI_Controller {

    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('lingkungan_m');
		$this->load->model('umat_m');
		$this->load->model('user_m');
    }

    public function index(){
   		$data=array();
		$data['menu']='ampop';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Perhitungan Amplop';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data perhitungan amplop berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data perhitungan amplop gagal dihapus";
		$data['s'] = $this->input->get('s');
   		$data['ling'] = $this->input->get('lingkungan');
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');
		if(!$data['ling']){
			$data['ling'] = $data['lingkungan'][0]->kode_lingkungan;
		}
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->umat_m->count_data_all($data['s'],'',$data['ling'],'',$data['str_date'],$data['end_date']);
        $data['paginator'] = $this->umat_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->umat_m->get_data_all($data['s'],'',$data['ling'],'',$data['str_date'],$data['end_date'],$dataPerhalaman,$off);
		////
		$params = $_GET;
		unset($params['alert']);
		$data['params'] = http_build_query($params);
		$last_params = array(
			'params' => $data['params'],
			'menu' => $data['menu']
		);
		$this->session->set_userdata('lastparams',$last_params);
		/////
		$this->load->view('amplop_v', $data);
   	}
   	
    public function update(){
    	$data=array();
		$data['menu']='update-amplop';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Perhitungan Amplop';
		$data['success']='';
		$data['error']='';
		$data['pecahan'] = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
		$data['label_pecahan'] = ['Rp. 100.000','Rp. 50.000','Rp. 20.000','Rp. 10.000','Rp. 5.000','Rp. 2.000','Rp. 1.000','Rp. 1.000 (KOIN)','Rp. 500 (KOIN)','Rp. 200 (KOIN)','Rp. 100 (KOIN)'];
		$this->load->view('amplop_update_v', $data);
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
