<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Rekaplingkungan extends REST_Controller {

    function __construct(){
        parent::__construct();        
		$this->load->model('lingkungan_m');
		$this->load->model('rekaplingkungan_m');
		$this->load->model('umat_m');
		$this->load->model('user_m');
    }
   	
   	public function all_post(){
   		$wil = $this->input->post('wilayah');
		$ling = $this->input->post('lingkungan');
		$awal = $this->input->post('awal');
		$akhir = $this->input->post('akhir');
		$status = $this->input->post('status');
		$rekap = $this->rekaplingkungan_m->get_data_all($awal,$akhir,$wil,$ling,$status);
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
		$data['wilayah'] = $wil;
		$data['lingkungan'] = $ling;		
		$data['status'] = $status;		
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}   

   	function rekap_lingkungan($kode_lingkungan,$tanggal,$umat){
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
		$amplop = array(
			'amplop1' => 0,
			'amplop2' => 0,
			'amplop3' => 0,
			'amplop4' => 0,
			'amplop5' => 0,
			'amplop6' => 0,
			'amplop7' => 0
		);	
		$total=0;
		$total_amplop=0;
		$key_pecahan = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
		foreach($umat as $list) {
			$list_total = 0;
			for($i=1; $i<=7; $i++){
				if(date("Y-m-d",strtotime($tanggal)) == date("Y-m-d",strtotime($list->{'timestamp'.$i}))){
					$list_total += $list->{'amplop'.$i};
					$total_amplop++; 
					$amplop['amplop'.$i] += $list->{'amplop'.$i};
					$list_pecahan =  $list->{'pecahan_amplop'.$i};
					if($list_pecahan){
						$list_pecahan = json_decode($list_pecahan);
						for($n=0; $n<=10; $n++){
							$pecahan[$key_pecahan[$n]] += $list_pecahan->{$key_pecahan[$n]};
						}
					}	
				}
			}	
			$total+=$list_total;
		}
		// Code LAMA
		// foreach($umat as $list) {
		// 	$total+=$list->total;
		// 	for($i=1; $i<=7; $i++){
				
		// 		$amplop['amplop'.$i] += $list->{'amplop'.$i};
		// 		$list_pecahan =  $list->{'pecahan_amplop'.$i};
		// 		if($list_pecahan){
		// 			$list_pecahan = json_decode($list_pecahan);
		// 			for($n=0; $n<=10; $n++){
		// 				$pecahan[$key_pecahan[$n]] += $list_pecahan->{$key_pecahan[$n]};
		// 			}
		// 		}

		// 	}		
		// }

		$rekap = array(
			'kode_lingkungan' => $kode_lingkungan,
			'lingkungan' => $list->lingkungan,
			'wilayah' => $list->wilayah, 
			'total' => $total,
			'amplop' => $amplop,
			'tanggal' => $tanggal,
			'pecahan' => $pecahan,
			'jumlah_amplop' => $total_amplop //count($umat) * 7
		);
		return $rekap;
   	}

   	public function cek_rekap_post(){
   		$kode_lingkungan = $this->input->post('lingkungan');
		$tanggal = $this->input->post('tanggal');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$umat = $this->umat_m->get_total_all('','',$kode_lingkungan,7,$tanggal,$tanggal);
			if(empty($umat)){
				$message = array(					
					'status' => 'false',
					'message' => 'No Service'
				);
			} else {	
				$rekap = $this->rekap_lingkungan($kode_lingkungan,$tanggal,$umat);
				$message = array(					
					'status' => 'true',
					'umat' => $rekap
				);
				$data['data']=$rekap;	
			}
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function cek_rekap_html_post(){
    	$data=array();
		$data['error'] = '';
   		$kode_lingkungan = $this->input->post('lingkungan');
		$tanggal = $this->input->post('tanggal');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$umat = $this->umat_m->get_total_all('','',$kode_lingkungan,7,$tanggal,$tanggal);
			if(empty($umat)){
				$message = array(					
					'status' => 'false',
					'message' => 'No Service'
				);
				$data['error'] = 'Data Tidak Ada';
			} else {	
				$rekap = $this->rekap_lingkungan($kode_lingkungan,$tanggal,$umat);
				$message = array(					
					'status' => 'true',
					'umat' => $rekap
				);
				$data['data']=(object) $rekap;	
			}
		}
		$data['pecahan'] = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
		$data['label_pecahan'] = ['Rp. 100.000','Rp. 50.000','Rp. 20.000','Rp. 10.000','Rp. 5.000','Rp. 2.000','Rp. 1.000','Rp. 1.000 (KOIN)','Rp. 500 (KOIN)','Rp. 200 (KOIN)','Rp. 100 (KOIN)'];
		$data['nilai_pecahan'] = [100000,50000,20000,10000,5000,2000,1000,1000,500,200,100];
		if(empty($this->input->post('update'))){
			$this->load->view('rekaplingkungan_ajax_v', $data);
		} else {
			$this->load->view('rekaplingkungan_ajax2_v', $data);
		}
   	}

   	public function add_post(){
		$kode_lingkungan = $this->input->post('lingkungan');
		$user_id = $this->input->post('user_id');
		$tanggal = $this->input->post('tanggal');
		$penghitung =  $this->input->post('penghitung'); 
		$status_simpan = $this->input->post('simpan');		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
		$this->form_validation->set_rules('user_id', 'User Id', 'required');
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
			$rekapdata = $this->rekaplingkungan_m->get_data_all($tanggal,$tanggal,'',$kode_lingkungan,'');
			if(empty($rekapdata)){
				$umat = $this->umat_m->get_total_all('','',$kode_lingkungan,7,$tanggal,$tanggal);
				if(empty($umat)){
					$message = array(					
						'status' => 'false',
						'message' => 'No Service'
					);
				} else {	
					$rekap = $this->rekap_lingkungan($kode_lingkungan,$tanggal,$umat);
					$pict = "";

					if(!empty($_FILES['foto']['name'])){				
						$pict = 'assets/upload/rekap-lingkungan/'.$this->_doupload_file('foto','assets/upload/rekap-lingkungan/',"(".$tanggal.")-".$rekap['wilayah']."-".$rekap['lingkungan']);
						// $pict = $this->config->item('base_url').'assets/upload/rekap-lingkungan/'.$this->_doupload_file('foto','assets/upload/rekap-lingkungan/',"(".$tanggal.")-".$rekap['wilayah']."-".$rekap['lingkungan']);
					}			
					$input=array(
						'kode_lingkungan' => $kode_lingkungan,			
						'user_id' => $user_id,			
						'amplop1' => $rekap['amplop']['amplop1'],			
						'amplop2' => $rekap['amplop']['amplop2'],			
						'amplop3' => $rekap['amplop']['amplop3'],			
						'amplop4' => $rekap['amplop']['amplop4'],			
						'amplop5' => $rekap['amplop']['amplop5'],			
						'amplop6' => $rekap['amplop']['amplop6'],			
						'amplop7' => $rekap['amplop']['amplop7'],			
						'pecahan_amplop' => json_encode($rekap['pecahan']),		
						'total' => $rekap['total'],		
						'date_add' => $tanggal,		
						'jumlah_amplop' => $rekap['jumlah_amplop'],		
						'penghitung' => $penghitung,		
						'foto' => $pict,		
						'status_simpan' => $status_simpan,		
					);
					$insert=$this->umat_m->insert('rekap_lingkungan',$input);
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
			} else {
				$message = array(					
					'status' => 'false',
					'message' => 'Duplicate Data'
				);
			}					 
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function update_post($id){
		$kode_lingkungan = $this->input->post('lingkungan');
		$user_id = $this->input->post('user_id');
		$tanggal = $this->input->post('tanggal');
		$penghitung =  $this->input->post('penghitung'); 
		$status_simpan = $this->input->post('simpan');		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
		$this->form_validation->set_rules('user_id', 'User Id', 'required');
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
			$rekapdata = $this->rekaplingkungan_m->get_data_all($tanggal,$tanggal,'',$kode_lingkungan,1);
			if(empty($rekapdata)){
				$umat = $this->umat_m->get_total_all('','',$kode_lingkungan,7,$tanggal,$tanggal);
				if(empty($umat)){
					$message = array(					
						'status' => 'false',
						'message' => 'No Service'
					);
				} else {	
					$rekap = $this->rekap_lingkungan($kode_lingkungan,$tanggal,$umat);
					
					$input=array(
						'kode_lingkungan' => $kode_lingkungan,			
						'user_id' => $user_id,			
						'amplop1' => $rekap['amplop']['amplop1'],			
						'amplop2' => $rekap['amplop']['amplop2'],			
						'amplop3' => $rekap['amplop']['amplop3'],			
						'amplop4' => $rekap['amplop']['amplop4'],			
						'amplop5' => $rekap['amplop']['amplop5'],			
						'amplop6' => $rekap['amplop']['amplop6'],			
						'amplop7' => $rekap['amplop']['amplop7'],			
						'pecahan_amplop' => json_encode($rekap['pecahan']),		
						'total' => $rekap['total'],		
						'date_add' => $tanggal,		
						'jumlah_amplop' => $rekap['jumlah_amplop'],		
						'penghitung' => $penghitung,		
						'status_simpan' => $status_simpan,		
					);
					if(!empty($_FILES['foto']['name'])){				
						$pict = 'assets/upload/rekap-lingkungan/'.$this->_doupload_file('foto','assets/upload/rekap-lingkungan/',"(".$tanggal.")-".$rekap['wilayah']."-".$rekap['lingkungan']);
						// $pict = $this->config->item('base_url').'assets/upload/rekap-lingkungan/'.$this->_doupload_file('foto','assets/upload/rekap-lingkungan/',"(".$tanggal.")-".$rekap['wilayah']."-".$rekap['lingkungan']);
						$input['foto'] =  $pict;
					}			
					$update=$this->umat_m->update('rekap_lingkungan','idrekap_lingkungan',$id,$input);
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
			} else {
				$message = array(					
					'status' => 'false',
					'message' => 'Hapus data rekap lingungan dari data Amplop Coklat terlebih dahulu'
				);
			}					 
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function detail_post($id){
		$rekap_data = $this->rekaplingkungan_m->get_detail($id);
		if(empty($rekap_data)){
			$message = array(					
				'status' => 'false',
				'message' => 'No Service'
			);
		} else {
			$umat = $this->umat_m->get_total_all('','',$rekap_data->kode_lingkungan,7,$rekap_data->date_add,$rekap_data->date_add);
			$rekap = $this->rekap_lingkungan($rekap_data->kode_lingkungan,$rekap_data->date_add,$umat);
			$message = array(					
				'status' => 'true',
				'rekap' => $rekap_data,
				'rekap_terbaru' => $rekap
			);
			$data['data']=$rekap_data;	
			$data['rekap_terbaru']=$rekap;	
		}
		$this->response($message, REST_Controller::HTTP_CREATED);
   	}

   	public function get_rekap_html_post(){
    	$data=array();
		$data['error'] = '';
   		$kode_lingkungan = $this->input->post('lingkungan');
		$tanggal = $this->input->post('tanggal');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lingkungan', 'Lingkungan', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = validation_errors();
			$message = [					
				'status' => 'false',
				'error' => $data['error']
			];
		} else {
			$rekaplingkungan = $this->rekaplingkungan_m->get_data_by_tanggal($tanggal,$kode_lingkungan,1,0);
			if(empty($rekaplingkungan)){
				$data['error'] = 'Data Tidak Ada';
			} else {	
				$data['data']=(object) $rekaplingkungan;	
			}
		}
		$data['pecahan'] = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
		$data['label_pecahan'] = ['Rp. 100.000','Rp. 50.000','Rp. 20.000','Rp. 10.000','Rp. 5.000','Rp. 2.000','Rp. 1.000','Rp. 1.000 (KOIN)','Rp. 500 (KOIN)','Rp. 200 (KOIN)','Rp. 100 (KOIN)'];
		$data['nilai_pecahan'] = [100000,50000,20000,10000,5000,2000,1000,1000,500,200,100];
		// $this->response($data, REST_Controller::HTTP_CREATED);
		$this->load->view('rekaplingkungan_check_ajax_v', $data);
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
