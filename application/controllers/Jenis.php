<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jenis extends CI_Controller {

    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('jenis_m');
		$this->load->model('user_m');
    }
   	
   	public function index(){
   		$data=array();
		$data['menu']='jenis';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Jenis';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data jenis berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data jenis gagal dihapus";
		$data['s'] = $this->input->get('s');
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->jenis_m->count_data_all($data['s']);
        $data['paginator'] = $this->jenis_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->jenis_m->get_data_all($data['s'],$dataPerhalaman,$off);
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
		$this->load->view('jenis_v', $data);
   	}

   	public function tambah(){
		$data=array();
		$data['menu']='jenis';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Tambah Data Jenis';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){
			$jenis = $this->input->post('jenis');
			$keterangan = $this->input->post('keterangan');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			if ($this->form_validation->run($this) == FALSE) {
				$data['error'] = validation_errors();
			} else {
				$input=array(
					'jenis' => $jenis,			
					'keterangan_jenis' => $keterangan,			
				);
				$insert=$this->jenis_m->insert('jenis',$input);
				if($this->db->affected_rows()){            
	                $data['success']='Data berhasil ditambahkan';                  
	            } else {                
	                $data['error']='Data gagal ditambahkan';
	            }
			}
		}
		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('jenis_add_v', $data);
   	}

   	public function edit($id){
		$data=array();
		$data['menu']='jenis';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Ubah Data Jenis';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data berhasil diubah';	
		if($this->input->get('alert')=='failed') $data['error']="Data berhasil diubah";		
		if($this->input->post('save')){
			$jenis = $this->input->post('jenis');
			$keterangan = $this->input->post('keterangan');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			if ($this->form_validation->run($this) == FALSE) {
				$data['error'] = validation_errors();
			} else {
				$input=array(
					'jenis' => $jenis,			
					'keterangan_jenis' => $keterangan,			
				);
				$update=$this->jenis_m->update('jenis','idjenis',$id,$input);				
				if($update){             
					$data['error']='';
	                $data['success']='Data berhasil diubah'; 
	            } else {                
					$data['success']='';
	                $data['error']='Data gagal diubah';
	            }
			}
		}
        $data['data'] = $this->jenis_m->get_detail($id);        
		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('jenis_edit_v', $data);
   	}

   	public function delete($id){		
   		$params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'jenis'){
			$params = '&'.$lastparams->params;
		}
   				
		if(!$this->jenis_m->cek_hapus($id)){
			$del=$this->jenis_m->delete('jenis','idjenis',$id);
			if($del){
				redirect(base_url().'jenis/?alert=success'.$params) ; 			
			} 
		}
		redirect(base_url().'jenis/?alert=failed'.$params) ; 			
	}

}
