<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pengembalian extends CI_Controller {

    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('lingkungan_m');
		$this->load->model('kembaliamplop_m');
		$this->load->model('user_m');
    }

    public function index(){
   		$data=array();
		$data['menu']='kembali';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Pengembalian Amplop Lingkungan';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data pengembalian amplop berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data pengembalian amplop gagal dihapus";
		$data['s'] = $this->input->get('s');
		$data['opt'] = $this->input->get('option');
   		$data['ling'] = $this->input->get('lingkungan');
   		$data['wil'] = $this->input->get('wilayah');
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		if(!$data['opt']) $data['opt'] = 1;
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->kembaliamplop_m->count_data_all($data['str_date'],$data['end_date'],$data['wil'],$data['ling']);
        $data['paginator'] = $this->kembaliamplop_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->kembaliamplop_m->get_data_all($data['str_date'],$data['end_date'],$data['wil'],$data['ling'],'',$dataPerhalaman,$off);
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
		$this->load->view('pengembalian_v', $data);
   	}
   	
    public function tambah(){
    	$data=array();
		$data['menu']='kembali';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Tambah Pengembalian Amplop Lingkungan';
		$data['success']='';
		$data['error']='';
		$data['str_date'] = date("Y-m-d");
		$data['ling'] = $this->input->get('lingkungan');
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');
		if(!$data['ling']){
			$data['ling'] = $data['lingkungan'][0]->kode_lingkungan;
		}
		$this->load->view('pengembalian_add_v', $data);
    }

    public function edit($id){
		$data=array();
		$data['menu']='kembali';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Edit Pengembalian Amplop Lingkungan';
		$data['success']='';
		$data['error']='';
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');
		$pengembalian_data = $this->kembaliamplop_m->get_detail($id);
		if(empty($pengembalian_data)){
			$params = '';
			$lastparams = (object)$this->session->userdata('lastparams');
			if($lastparams->menu == 'kembali'){
				$params = $lastparams->params;
			}
			redirect(base_url().'pengembalian/?'.$params) ; 			
		} else {
			$data['data']=$pengembalian_data;	
		}
		$this->load->view('pengembalian_edit_v', $data);
   	}

    public function delete($id){		
   		$params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'kembali'){
			$params = '&'.$lastparams->params;
		}
		$del=$this->kembaliamplop_m->delete('pengembalian_amplop','idpengembalian_amplop',$id);
		if($del){
			redirect(base_url().'pengembalian/?alert=success'.$params) ; 			
		} 
		redirect(base_url().'pengembalian/?alert=failed'.$params) ; 			
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
