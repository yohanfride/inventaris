<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Umat extends REST_Controller {

    function __construct(){
        parent::__construct();        
		$this->load->model('lingkungan_m');
		$this->load->model('umat_m');
		$this->load->model('user_m');
    }
   	
   	public function all_post(){
   		$wil = $this->input->post('wilayah');
		$ling = $this->input->post('lingkungan');
		$awal = $this->input->post('awal');
		$akhir = $this->input->post('akhir');
		$status = $this->input->post('status');
		$s = $this->input->post('s');
		$umat = $this->umat_m->get_data_all($s,$wil,$ling,$status,$awal,$akhir);
		if(empty($umat)){
			$message = array(					
				'status' => 'false',
				'message' => 'No Service'
			);
		} else {
			$message = array(					
				'status' => 'true',
				'umat' => $umat
			);
		}
		$data['data']=$umat;
		$data['wilayah'] = $wil;
		$data['lingkungan'] = $ling;		
		$data['status'] = $status;		
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function detail_post(){
		$kk_id = $this->input->post('kk_id');
		$amplop = $this->input->post('amplop');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('kk_id', 'KK ID', 'required');
		$this->form_validation->set_rules('amplop', 'Amplop', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$umat = $this->umat_m->get_detail($kk_id);
			if(empty($umat)){
				$message = array(					
					'status' => 'false',
					'message' => 'No Service'
				);
			} else {
				$message = array(					
					'status' => 'true',
					'umat' => $umat
				);
			}
			$data['data']=$umat;	
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function add_post(){
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
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$input=array(
				'kk_id' => $kk_id_baru,			
				'nama' => $nama,			
				'kode_lingkungan' => $kode_lingkungan,			
			);
			$insert=$this->umat_m->insert('amplop_umat',$input);
			if($this->db->affected_rows()){
				$umat = $this->umat_m->get_detail($kk_id_baru);
				$message = array(					
					'status' => 'true',
					'umat' => $umat
				);
				$data['data']=$umat;
			} else{
				$message = array(					
					'status' => 'false',
					'message' => 'Failed'
				);
			} 
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function update_post($kk_id){
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
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$input=array(
				'kk_id' => $kk_id_baru,			
				'nama' => $nama,			
				'kode_lingkungan' => $kode_lingkungan,			
			);
			$update=$this->umat_m->update('amplop_umat','kk_id',$kk_id,$input);				
			if($update){
				$umat = $this->umat_m->get_detail($kk_id_baru);
				$message = array(					
					'status' => 'true',
					'umat' => $umat
				);
				$data['data']=$umat;
			} else{
				$message = array(					
					'status' => 'false',
					'message' => 'Failed'
				);
			} 
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function delete_post($kk_id){
		$umat = $this->umat_m->get_detail($kk_id);
		if(empty($umat)){
			$message = array(					
				'status' => 'false',
				'message' => 'No Service'
			);
		} else {		
			$status = true;	
			for($i=1;$i<=7;$i++){
				if($umat->{'status_amplop'.$i} == 7){
					$status = false;
					break;
				}
			}
			if($status){
				$delete=$this->umat_m->delete('amplop_umat','kk_id',$kk_id);				
				if($delete){			
					$message = array(					
						'status' => 'true',
						'message' => 'Success'
					);
				} else{
					$message = array(					
						'status' => 'false',
						'message' => 'Failed'
					);
				} 
			} else {
				$message = array(					
					'status' => 'false',
					'message' => 'Hapus data pengisian amplop dahulu'
				);
			}
		}		
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function detail_amplop_post(){
		$kk_id = $this->input->post('kk_id');
		$amplop = $this->input->post('amplop');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('kk_id', 'KK ID', 'required');
		$this->form_validation->set_rules('amplop', 'Amplop', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$umat = $this->umat_m->get_detail($kk_id);
			if(empty($umat)){
				$message = array(					
					'status' => 'false',
					'message' => 'No Service'
				);
			} else {
				$pecahan = $umat->{'pecahan_amplop'.$amplop};
				if($pecahan){
					$pecahan = json_decode($pecahan);
				} else {
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
				}
				$detail = array(
					'kk_id' => $umat->kk_id,
					'nama' => $umat->nama,
					'tanggal' => $umat->{'timestamp'.$amplop},
					'wilayah' => $umat->wilayah,
					'lingkungan' => $umat->lingkungan,
					'amplop' =>  $amplop,
					'nominal' =>  $umat->{'amplop'.$amplop},
					'status_amplop' => $umat->{'status_amplop'.$amplop},
					'user_id' => $umat->{'user_id'.$amplop},
					'pecahan' => $pecahan,
					'totalamplop' => $umat->totalamplop
				);
				$message = array(					
					'status' => 'true',
					'umat' => $detail
				);
			}
			$data['data']=$umat;	
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}
	
	public function update_amplop_post(){
		$kk_id = $this->input->post('kk_id');
		$amplop = $this->input->post('amplop');
		$user_id = $this->input->post('user_id');
		$total = $this->input->post('total');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kk_id', 'KK ID', 'required');
		$this->form_validation->set_rules('user_id', 'User ID', 'required');
		$this->form_validation->set_rules('amplop', 'Amplop', 'required');
		$this->form_validation->set_rules('100k', 'Pecahan 100K', 'required');
		$this->form_validation->set_rules('50k', 'Pecahan 50K', 'required');
		$this->form_validation->set_rules('20k', 'Pecahan 20K', 'required');
		$this->form_validation->set_rules('10k', 'Pecahan 10K', 'required');
		$this->form_validation->set_rules('5k', 'Pecahan 5K', 'required');
		$this->form_validation->set_rules('2k', 'Pecahan 2K', 'required');
		$this->form_validation->set_rules('1k', 'Pecahan 1K', 'required');
		$this->form_validation->set_rules('1000r', 'Pecahan 1000 Koin', 'required');
		$this->form_validation->set_rules('500r', 'Pecahan 500 Koin', 'required');
		$this->form_validation->set_rules('200r', 'Pecahan 200 Koin', 'required');
		$this->form_validation->set_rules('100r', 'Pecahan 100 Koin', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$pecahan = array(
				'100k' => $this->input->post('100k'),
				'50k' => $this->input->post('50k'),
				'20k' => $this->input->post('20k'),
				'10k' => $this->input->post('10k'),
				'5k' => $this->input->post('5k'),
				'2k' => $this->input->post('2k'),
				'1k' => $this->input->post('1k'),
				'1000r' => $this->input->post('1000r'),
				'500r' => $this->input->post('500r'),
				'200r' => $this->input->post('200r'),
				'100r' => $this->input->post('100r')
			);

			if($total == '' || $total == null){	
				$total = 100000 * $pecahan['100k'] +  50000 * $pecahan['50k'] +  20000 * $pecahan['20k'] +
						 10000 * $pecahan['10k'] +  5000 * $pecahan['5k'] +  2000 * $pecahan['2k'] + 1000 * $pecahan['1k'] +
						 1000 * $pecahan['1000r'] +  500 * $pecahan['500r'] + 200 * $pecahan['200r'] + 100 * $pecahan['200r'];
			}
			$input=array(
				'amplop'.$amplop => $total,				
				'status_amplop'.$amplop =>7,				
				'user_id'.$amplop =>$user_id,				
				'pecahan_amplop'.$amplop =>json_encode($pecahan),				
				'timestamp'.$amplop =>	date('Y-m-d H:i:s')			
			);
			$update=$this->umat_m->update('amplop_umat','kk_id',$kk_id,$input);				
			if($update){
				$umat = $this->umat_m->get_detail($kk_id);
				$detail = array(
					'kk_id' => $umat->kk_id,
					'amplop' =>  $amplop,
					'nominal' =>  $umat->{'amplop'.$amplop},
					'status_amplop' => $umat->{'status_amplop'.$amplop},
					'user_id' => $umat->{'user_id'.$amplop},
					'pecahan' => json_decode($umat->{'pecahan_amplop'.$amplop})
				);
				$message = array(					
					'status' => 'true',
					'umat' => $detail
				);
				$data['data']=$detail;
			} else{
				$message = array(					
					'status' => 'false',
					'message' => 'Failed'
				);
			} 
		}
		$this->response($message, REST_Controller::HTTP_CREATED);

// 		<div class="input-group mb-3"><div class="input-group-append">
//                           <button class="btn btn-primary" type="button" style="
//     border-top-left-radius: .25rem;
//     border-bottom-left-radius: .25rem;
// ">Button</button>
//                         </div>
                        
//                         <input type="text" class="form-control" placeholder="" aria-label="">
//                         <div class="input-group-append">
//                           <button class="btn btn-primary" type="button">Button</button>
//                         </div>
//                       </div>
   	}

   	public function batal_amplop_post(){
		$kk_id = $this->input->post('kk_id');
		$amplop = $this->input->post('amplop');
		$user_id = $this->input->post('user_id');
		$total = $this->input->post('total');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kk_id', 'KK ID', 'required');
		$this->form_validation->set_rules('user_id', 'User ID', 'required');
		$this->form_validation->set_rules('amplop', 'Amplop', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
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
			$input=array(
				'amplop'.$amplop => 0,				
				'status_amplop'.$amplop => 0,				
				'user_id'.$amplop =>$user_id,				
				'pecahan_amplop'.$amplop =>json_encode($pecahan),				
				'timestamp'.$amplop =>	null//date('Y-m-d H:i:s')			
			);
			$update=$this->umat_m->update('amplop_umat','kk_id',$kk_id,$input);				
			if($update){
				$umat = $this->umat_m->get_detail($kk_id);
				$detail = array(
					'kk_id' => $umat->kk_id,
					'amplop' =>  $amplop,
					'nominal' =>  $umat->{'amplop'.$amplop},
					'status_amplop' => $umat->{'status_amplop'.$amplop},
					'user_id' => $umat->{'user_id'.$amplop},
					'pecahan' => json_decode($umat->{'pecahan_amplop'.$amplop})
				);
				$message = array(					
					'status' => 'true',
					'umat' => $detail
				);
				$data['data']=$umat;
			} else{
				$message = array(					
					'status' => 'false',
					'message' => 'Failed'
				);
			} 
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
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
