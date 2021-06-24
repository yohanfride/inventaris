<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Pengembalian extends REST_Controller {

    function __construct(){
        parent::__construct();               
		$this->load->model('lingkungan_m');
		$this->load->model('kembaliamplop_m');
		$this->load->model('umat_m');
		$this->load->model('user_m');
    }
   	
   	public function all_post(){
   		$wil = $this->input->post('wilayah');
		$ling = $this->input->post('lingkungan');
		$awal = $this->input->post('awal');
		$akhir = $this->input->post('akhir');
		$status = $this->input->post('status');
		$rekap = $this->kembaliamplop_m->get_data_all($awal,$akhir,$wil,$ling,$status);
		if(empty($rekap)){
			$message = array(					
				'status' => 'falses',
				'message' => 'No Service'
			);
		} else {
			$message = array(					
				'status' => 'true',
				'umat' => $rekap
			);
		}
		$data['data']=$rekap;
		$data['wilayah'] = $wil;
		$data['lingkungan'] = $ling;		
		$data['status'] = $status;		
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}   

   	public function add_post(){
		$kode_lingkungan = $this->input->post('lingkungan');
		$user_id = $this->input->post('user_id');
		$tanggal = $this->input->post('tanggal');
		$penerima =  $this->input->post('penerima'); 
		$jumlah =  $this->input->post('jumlah'); 
		$status_simpan = $this->input->post('simpan');		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
		$this->form_validation->set_rules('user_id', 'User Id', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('penerima', 'Penerima', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$pict = "";
			if(!empty($_FILES['foto']['name'])){				
				$pict = 'assets/upload/pengembalian-amplop/'.$this->_doupload_file('foto','assets/upload/pengembalian-amplop/',"(".$tanggal.")-".$kode_lingkungan);
			}			
			$input=array(
				'kode_lingkungan' => $kode_lingkungan,			
				'user_id' => $user_id,					
				'tanggal_pengembalian' => $tanggal,		
				'jumlah_amplop' => $jumlah,		
				'penerima' => $penerima,		
				'foto' => $pict		
			);
			$insert=$this->umat_m->insert('pengembalian_amplop',$input);
			if($this->db->affected_rows()){
				$message = array(					
					'status' => 'true',
					'message' => 'Success'
				);
				$data['data']=$input;
			} else{
				$message = array(					
					'status' => 'false',
					'message' => 'Failed'
				);
			}
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function update_post($id){
		$kode_lingkungan = $this->input->post('lingkungan');
		$user_id = $this->input->post('user_id');
		$tanggal = $this->input->post('tanggal');
		$penerima =  $this->input->post('penerima'); 
		$jumlah =  $this->input->post('jumlah'); 
		$status_simpan = $this->input->post('simpan');		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
		$this->form_validation->set_rules('user_id', 'User Id', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('penerima', 'Penerima', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$input=array(
				'kode_lingkungan' => $kode_lingkungan,			
				'user_id' => $user_id,					
				'tanggal_pengembalian' => $tanggal,		
				'jumlah_amplop' => $jumlah,		
				'penerima' => $penerima		
			);
			if(!empty($_FILES['foto']['name'])){				
				$pict = 'assets/upload/pengembalian-amplop/'.$this->_doupload_file('foto','assets/upload/pengembalian-amplop/',"(".$tanggal.")-".$kode_lingkungan);
				$input['foto'] =  $pict;
			}			
			$update=$this->umat_m->update('pengembalian_amplop','idpengembalian_amplop',$id,$input);
			if($update){
				$message = array(					
					'status' => 'true',
					'message' => 'Success'
				);
				$data['data']=$input;
			} else{
				$message = array(					
					'status' => 'false',
					'message' => 'Failed'
				);
			}
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function detail_post($id){
		$rekap_data = $this->kembaliamplop_m->get_detail($id);
		if(empty($rekap_data)){
			$message = array(					
				'status' => 'false',
				'message' => 'No Service'
			);
		} else {
			$message = array(					
				'status' => 'true',
				'data' => $rekap_data
			);
			$data['data']=$rekap_data;		
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

	public function _doupload_file($name,$target,$file_name="",$i=0){
		if(empty($file_name))
			$file_name = date('dmYHis').'_'.preg_replace("/[^0-9a-zA-Z ]/", "", $_FILES[$img]['name']);
		$img						= $name;
		$config['file_name']  		= $file_name;
		$config['upload_path'] 		= $target;
		$config['overwrite'] 		= FALSE;
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000000';
		$config['remove_spaces']  	= TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($img)){
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
