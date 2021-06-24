<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Rekap extends REST_Controller {

    function __construct(){
        parent::__construct();        
		$this->load->model('lingkungan_m');
		$this->load->model('rekaplingkungan_m');
		$this->load->model('rekapamplop_m');
		$this->load->model('umat_m');
		$this->load->model('user_m');
    }
   	
   	public function all_post(){
		$awal = $this->input->post('awal');
		$akhir = $this->input->post('akhir');
		$status = $this->input->post('status');
		$rekap = $this->rekapamplop_m->get_data_all($awal,$akhir,$status);
		if(empty($rekap)){
			$message = array(					
				'status' => 'false',
				'message' => 'No Service'
			);
		} else {
			$message = array(					
				'status' => 'true',
				'umat' => $rekap
			);
		}
		$data['data']=$rekap;		
		$data['status'] = $status;		
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}   

 	public function add_post(){
		$user_id = $this->input->post('user_id');
		$tanggal = $this->input->post('tanggal');
		$nama =  $this->input->post('nama'); 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_id', 'User Id', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$rekap = $this->rekapamplop_m->get_data_all($tanggal,$tanggal,0,$user_id);
			if($rekap){
				$message = array(					
					'status' => 'false',
					'message' => 'Selesaikan rekap amplop sebelumnya terlebih dahulu'
				);
			} else {
				$input=array(
					'date_add' => $tanggal,			
					'nama_rekap' => $nama,			
					'user_id' => $user_id			
				);
				$insert=$this->rekapamplop_m->insert('rekap_amplop',$input);
				if($insert){
					$rekap = $this->rekapamplop_m->get_detail($insert);
					$message = array(					
						'status' => 'true',
						'rekap' => $rekap
					);
					$data['data']=$rekap;
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

   	function get_rekap($id){
   		$rekapsql = $this->rekapamplop_m->get_relasi($id);
   		$pecahan = array(
			'100k' => 0,
			'50k' => 0,
			'20k' => 0,
			'10k' => 0,
			'5k' => 0,
			'2k' => 0,
			'1k' => 0,
			'1000r' => 0,
			'500r' => 0,
			'200r' => 0,
			'100r' => 0
		);
		$total=0;$jumlah_amplop=0;
		$key_pecahan = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
		foreach($rekapsql as $list) {
			$total+=$list->total;
			$jumlah_amplop+=$list->jumlah_amplop;
			$list_pecahan =  $list->{'pecahan_amplop'};
			if($list_pecahan){
				$list_pecahan = json_decode($list_pecahan);
				for($n=0; $n<=10; $n++){
					$pecahan[$key_pecahan[$n]] += $list_pecahan->{$key_pecahan[$n]};
				}
			}
		}
		$rekap = array(
			'total' => $total,
			'pecahan' => $pecahan,
			'jumlah_amplop' => $jumlah_amplop
		);
		return $rekap; 		
   	}

   	public function add_lingkungan_post(){
		$rekapid = $this->input->post('rekapid');
		$rekapid_lingkungan = $this->input->post('rekaplingkungan');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rekapid', 'Rekap ID', 'required');
		$this->form_validation->set_rules('rekaplingkungan', 'Rekap Amplop Lingkungan', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$rekapdata = $this->rekaplingkungan_m->get_detail($rekapid_lingkungan);
			if($rekapdata->status_pakai){
				$message = array(					
					'status' => 'false',
					'message' => 'Data Rekap Lingkungan telah digunakan'
				);
			} else {
				$input=array(
					'idrekap_amplop' => $rekapid,			
					'idrekap_lingkungan' => $rekapid_lingkungan			
				);
				$insert=$this->rekapamplop_m->insert('relasi_amplop_coklat',$input);
				if($insert){
					$input = array(
						'status_pakai' => 1
					);
					$update=$this->rekapamplop_m->update('rekap_lingkungan','idrekap_lingkungan',$rekapid_lingkungan,$input);
					$rekap = $this->get_rekap($rekapid);

					//////////////////////////////////////////
					$input = array(
						'jumlah_amplop' => $rekap['jumlah_amplop'],
						'pecahan' => json_encode($rekap['pecahan']),
						'total' => $rekap['total']
					);
					$update2=$this->rekapamplop_m->update('rekap_amplop','idrekap_amplop',$rekapid,$input);
					////////////////////////////////////////
					$message = array(					
						'status' => 'true',
						'rekap' => $rekap
					);
					$data['data']=$rekap;
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

   	public function delete_lingkungan_post(){
		$rekapid = $this->input->post('rekapid');
		$rekapid_lingkungan = $this->input->post('rekaplingkungan');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rekapid', 'Rekap ID', 'required');
		$this->form_validation->set_rules('rekaplingkungan', 'Rekap Amplop Lingkungan', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$relasidata = $this->rekapamplop_m->check_relasi($rekapid,$rekapid_lingkungan);
			if(empty($relasidata)){
				$message = array(					
					'status' => 'false',
					'message' => 'Data tidak ada'
				);
			} else {
				$delete=$this->rekapamplop_m->delete('relasi_amplop_coklat','id_relasi',$relasidata->id_relasi);
				if($delete){
					$input = array(
						'status_pakai' => 0
					);
					$update=$this->umat_m->update('rekap_lingkungan','idrekap_lingkungan',$rekapid_lingkungan,$input);
					$rekap = $this->get_rekap($rekapid);
					//////////////////////////////////////////
					$input = array(
						'jumlah_amplop' => $rekap['jumlah_amplop'],
						'pecahan' => json_encode($rekap['pecahan']),
						'total' => $rekap['total']
					);
					$update2=$this->rekapamplop_m->update('rekap_amplop','idrekap_amplop',$rekapid,$input);
					////////////////////////////////////////
					$message = array(					
						'status' => 'true',
						'rekap' => $rekap
					);
					$data['data']=$rekap;
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

   	public function update_post($id){
		$penghitung =  $this->input->post('penghitung'); 
		$tanggal = $this->input->post('tanggal');
		$status_simpan = $this->input->post('simpan');		
		$nama =  $this->input->post('nama'); 
		$user_id = $this->input->post('user_id');
		$tanggal = $this->input->post('tanggal');
		$catatan = $this->input->post('catatan');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('penghitung', 'Penghitung', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$input=array(
				'penghitung' => $penghitung,
				'catatan' => $catatan,		
				'status_simpan' => $status_simpan,			
				'date_add' => $tanggal,			
				'nama_rekap' => $nama,			
				'user_id' => $user_id		
			);
			if(!empty($_FILES['foto']['name'])){				
				$pict = 'assets/upload/rekap-amplop-coklat/'.$this->_doupload_file('foto','assets/upload/rekap-amplop-coklat/',"(".$tanggal.")-".$id);
				// $pict = $this->config->item('base_url').'assets/upload/rekap-amplop-coklat/'.$this->_doupload_file('foto','assets/upload/rekap-amplop-coklat/',"(".$tanggal.")-".$id);
				$input['foto'] =  $pict;
			}
			$update=$this->umat_m->update('rekap_amplop','idrekap_amplop',$id,$input);
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
		$rekap_data = $this->rekapamplop_m->get_detail($id);
		if(empty($rekap_data)){
			$message = array(					
				'status' => 'false',
				'message' => 'No Service'
			);
		} else {
			$list_rekap_data = $this->rekapamplop_m->get_relasi($id);
			$message = array(					
				'status' => 'true',
				'rekap' => $rekap_data,
				'list_rekap' => $list_rekap_data,
			);
			$data['data']=$rekap_data;	
			$data['list_rekap']=$list_rekap_data;	
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function add_lingkungan_html_post(){
		$rekapid = $this->input->post('rekapid');
		$rekapid_lingkungan = $this->input->post('rekaplingkungan');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rekapid', 'Rekap ID', 'required');
		$this->form_validation->set_rules('rekaplingkungan', 'Rekap Amplop Lingkungan', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
			echo "error";
		} else {
			$rekapdata = $this->rekaplingkungan_m->get_detail($rekapid_lingkungan);
			if($rekapdata->status_pakai){
				$message = array(					
					'status' => 'false',
					'message' => 'Data Rekap Lingkungan telah digunakan'
				);
				echo "error";
			} else {
				$input=array(
					'idrekap_amplop' => $rekapid,			
					'idrekap_lingkungan' => $rekapid_lingkungan			
				);
				$insert=$this->rekapamplop_m->insert('relasi_amplop_coklat',$input);
				if($insert){
					$input = array(
						'status_pakai' => 1
					);
					$update=$this->rekapamplop_m->update('rekap_lingkungan','idrekap_lingkungan',$rekapid_lingkungan,$input);
					$rekap = $this->get_rekap($rekapid);

					//////////////////////////////////////////
					$input = array(
						'jumlah_amplop' => $rekap['jumlah_amplop'],
						'pecahan' => json_encode($rekap['pecahan']),
						'total' => $rekap['total']
					);
					$update2=$this->rekapamplop_m->update('rekap_amplop','idrekap_amplop',$rekapid,$input);
					////////////////////////////////////////
					$message = array(					
						'status' => 'true',
						'rekap' => $rekap
					);
					$data['rekap'] = $this->rekapamplop_m->get_detail($rekapid);
					$data['rekap']->pecahan = json_decode($data['rekap']->pecahan);
					$data['list'] = $this->rekapamplop_m->get_relasi($rekapid);
					$data['pecahan'] = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
					$data['label_pecahan'] = ['Rp. 100.000','Rp. 50.000','Rp. 20.000','Rp. 10.000','Rp. 5.000','Rp. 2.000','Rp. 1.000','Rp. 1.000 (KOIN)','Rp. 500 (KOIN)','Rp. 200 (KOIN)','Rp. 100 (KOIN)'];
					$data['nilai_pecahan'] = [100000,50000,20000,10000,5000,2000,1000,1000,500,200,100];
					$this->load->view('rekap_items_v', $data);
				} else{
					$message = array(					
						'status' => 'false',
						'message' => 'Failed'
					);
					echo "error";
				} 	
			}
		}
   	}

   	public function delete_lingkungan_html_post(){
		$rekapid = $this->input->post('rekapid');
		$rekapid_lingkungan = $this->input->post('rekaplingkungan');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rekapid', 'Rekap ID', 'required');
		$this->form_validation->set_rules('rekaplingkungan', 'Rekap Amplop Lingkungan', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
			echo "error";
		} else {
			$relasidata = $this->rekapamplop_m->check_relasi($rekapid,$rekapid_lingkungan);
			if(empty($relasidata)){
				$message = array(					
					'status' => 'false',
					'message' => 'Data tidak ada'
				);
				echo "error";
			} else {
				$delete=$this->rekapamplop_m->delete('relasi_amplop_coklat','id_relasi',$relasidata->id_relasi);
				if($delete){
					$input = array(
						'status_pakai' => 0
					);
					$update=$this->umat_m->update('rekap_lingkungan','idrekap_lingkungan',$rekapid_lingkungan,$input);
					$rekap = $this->get_rekap($rekapid);
					//////////////////////////////////////////
					$input = array(
						'jumlah_amplop' => $rekap['jumlah_amplop'],
						'pecahan' => json_encode($rekap['pecahan']),
						'total' => $rekap['total']
					);
					$update2=$this->rekapamplop_m->update('rekap_amplop','idrekap_amplop',$rekapid,$input);
					////////////////////////////////////////
					$message = array(					
						'status' => 'true',
						'rekap' => $rekap
					);
					$data['rekap'] = $this->rekapamplop_m->get_detail($rekapid);
					$data['rekap']->pecahan = json_decode($data['rekap']->pecahan);
					$data['list'] = $this->rekapamplop_m->get_relasi($rekapid);
					$data['pecahan'] = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
					$data['label_pecahan'] = ['Rp. 100.000','Rp. 50.000','Rp. 20.000','Rp. 10.000','Rp. 5.000','Rp. 2.000','Rp. 1.000','Rp. 1.000 (KOIN)','Rp. 500 (KOIN)','Rp. 200 (KOIN)','Rp. 100 (KOIN)'];
					$data['nilai_pecahan'] = [100000,50000,20000,10000,5000,2000,1000,1000,500,200,100];
					$this->load->view('rekap_items_v', $data);
				} else{
					$message = array(					
						'status' => 'false',
						'message' => 'Failed'
					);
					echo "error";
				} 	
			}
		}
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
