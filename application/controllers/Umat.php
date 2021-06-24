<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class umat extends CI_Controller {

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
		$data['menu']='umat';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Umat';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data umat berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data umat gagal dihapus";
   		$data['ling'] = $this->input->get('lingkungan');
		$data['s'] = $this->input->get('s');
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');
		if(!$data['ling']){
			$data['ling'] = $data['lingkungan'][0]->kode_lingkungan;
		}
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->umat_m->count_data_all($data['s'],'',$data['ling']);
        $data['paginator'] = $this->umat_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->umat_m->get_data_all($data['s'],'',$data['ling'],'','','',$dataPerhalaman,$off);
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
		$this->load->view('umat_v', $data);
   	}

   	public function tambah(){
		$data=array();
		$data['menu']='umat';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Tambah Data Umat';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){
			$kk_id_baru = $this->input->post('kk_id');
			$kode_lingkungan = $this->input->post('lingkungan');
			$nama = $this->input->post('nama');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('kk_id', 'KK ID', 'required');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			if ($this->form_validation->run($this) == FALSE) {
				$data['error'] = validation_errors();
			} else {
				$input=array(
					'kk_id' => $kk_id_baru,			
					'nama' => strtoupper($nama),			
					'kode_lingkungan' => $kode_lingkungan,			
				);
				$insert=$this->umat_m->insert('amplop_umat',$input);
				if($this->db->affected_rows()){            
	                $data['success']='Data berhasil ditambahkan';                  
	            } else {                
	                $data['error']='Data gagal ditambahkan';
	            }
			}
		}
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');

		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('umat_add_v', $data);
   	}

   	public function edit($kk_id){
		$data=array();
		$data['menu']='umat';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Ubah Data Umat';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data berhasil diubah';	
		if($this->input->get('alert')=='failed') $data['error']="Data berhasil diubah";		
		if($this->input->post('save')){
			$kk_id_baru = $this->input->post('kk_id');
			$kode_lingkungan = $this->input->post('lingkungan');
			$nama = $this->input->post('nama');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('kk_id', 'KK ID', 'required');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			if ($this->form_validation->run($this) == FALSE) {
				$data['error'] = validation_errors();
			} else {
				$input=array(
					'kk_id' => $kk_id_baru,			
					'nama' => strtoupper($nama),			
					'kode_lingkungan' => $kode_lingkungan,			
				);
				$update=$this->umat_m->update('amplop_umat','kk_id',$kk_id,$input);				
				if($update){             
					$data['error']='';
	                $data['success']='Data berhasil diubah'; 
	                if($kk_id != $this->input->post('kk_id') ) 
						redirect(base_url().'umat/edit/'.$kk_id_baru.'/?alert=success') ; 			
	            } else {                
					$data['success']='';
	                $data['error']='Data gagal diubah';
	                if($kk_id != $this->input->post('kk_id') ) 
						redirect(base_url().'umat/edit/'.$kk_id_baru.'/?alert=failed') ; 			
	            } 
			}
		}
        $data['data'] = $this->umat_m->get_detail($kk_id);        
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');

		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('umat_edit_v', $data);
   	}

   	public function delete($id){		
   		$params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'umat'){
			$params = '&'.$lastparams->params;
		}
   				
		if(!$this->umat_m->cek_hapus($id)){
			$del=$this->umat_m->delete('amplop_umat','kk_id',$id);
			if($del){
				redirect(base_url().'umat/?alert=success'.$params) ; 			
			} 
		}
		redirect(base_url().'umat/?alert=failed'.$params) ; 			
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
