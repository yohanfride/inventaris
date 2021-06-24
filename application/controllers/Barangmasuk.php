<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class barangmasuk extends CI_Controller {

	public $prefix = "KD";

    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('jenis_m');
		$this->load->model('barangmasuk_m');
		$this->load->model('barang_m');
		$this->load->model('user_m');
    }
   	
   	public function index(){
   		$data=array();
		$data['menu']='barang masuk';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Barang Masuk';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data barang masuk berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data barang masuk gagal dihapus";
   		
   		$data['jns'] = $this->input->get('jenis');
		$data['s'] = $this->input->get('s');
		$data['lks'] = $this->input->get('lokasi');
		$data['brng'] = $this->input->get('barang');
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}

		$data['jenis'] = $this->jenis_m->get_data_all('');
		$data['lokasi'] = $this->barang_m->get_lokasi('','');
		$data['barang'] = $this->barang_m->get_data_all('',$data['jns']);
		
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->barangmasuk_m->count_data_all($data['s'],$data['brng'],$data['jns'],$data['str_date'],$data['end_date']);
        $data['paginator'] = $this->barangmasuk_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->barangmasuk_m->get_data_all($data['s'],$data['brng'],$data['jns'],$data['str_date'],$data['end_date'],$dataPerhalaman,$off);
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
		$this->load->view('barang_masuk_v', $data);
   	}

   	public function tambah(){
		$data=array();
		$data['menu']='barang masuk';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Tambah Data Barang Masuk';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('barang', 'Barang', 'required');
			$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			if ($this->form_validation->run($this) == FALSE) {
				$data['error'] = validation_errors();
			} else {
				$input=array(
					'idbarang' => $this->input->post('barang'),			
					'tanggal_masuk' => $this->input->post('tanggal'),			
					'keterangan' => $this->input->post('keterangan'),	
					'jumlah_masuk' => $this->input->post('jumlah'),	
					'user_id' => $data['user_now']->id,			
				);
				$insert=$this->barangmasuk_m->insert('barang_masuk',$input);
				if($this->db->affected_rows()){
					$barang = $this->barang_m->get_detail($this->input->post('barang'));
					$input2 = array(
						'jumlah' => $barang->jumlah + $this->input->post('jumlah')
					);
					$update=$this->barang_m->update('barang','idbarang',$this->input->post('barang'),$input2);
	                $data['success']='Data berhasil ditambahkan';                  
	            } else {                
	                $data['error']='Data gagal ditambahkan';
	            }
			}
		}
		$data['barang'] = $this->barang_m->get_data_all('','','',1);
		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('barang_masuk_add_v', $data);
   	}

   	public function edit($id){
		$data=array();
		$data['menu']='barang masuk';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Ubah Data Barang Masuk';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data berhasil diubah';	
		if($this->input->get('alert')=='failed') $data['error']="Data berhasil diubah";		
		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('barang', 'Barang', 'required');
			$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			if ($this->form_validation->run($this) == FALSE) {
				$data['error'] = validation_errors();
			} else {
				$input=array(
					'idbarang' => $this->input->post('barang'),			
					'tanggal_masuk' => $this->input->post('tanggal'),			
					'keterangan' => $this->input->post('keterangan'),	
					'jumlah_masuk' => $this->input->post('jumlah'),	
					'user_id' => $data['user_now']->id,			
				);
				$update=$this->barangmasuk_m->update('barang_masuk','idbarang_masuk',$id,$input);
				if($update){      
					if($this->input->post('barang') == $this->input->post('barang_old')){
						$barang = $this->barang_m->get_detail($this->input->post('barang'));
						$input2 = array(
							'jumlah' => $barang->jumlah + $this->input->post('jumlah') - $this->input->post('jumlah_old')
						);      
						$update=$this->barang_m->update('barang','idbarang',$this->input->post('barang'),$input2);	
					} else {
						$barang = $this->barang_m->get_detail($this->input->post('barang_old'));
						$input2 = array(
							'jumlah' => $barang->jumlah - $this->input->post('jumlah_old') 
						);      
						$update=$this->barang_m->update('barang','idbarang',$this->input->post('barang_old'),$input2);	

						$barang = $this->barang_m->get_detail($this->input->post('barang'));
						$input2 = array(
							'jumlah' => $barang->jumlah + $this->input->post('jumlah') 
						);      
						$update=$this->barang_m->update('barang','idbarang',$this->input->post('barang'),$input2);	
					}
					

	                $data['success']='Data berhasil diubah';                  
	            } else {                
	                $data['error']='Data gagal diubah';
	            }
			}
		}
        $data['data'] = $this->barangmasuk_m->get_detail($id);        
		$data['barang'] = $this->barang_m->get_data_all('','','',1);
		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('barang_masuk_edit_v', $data);
   	}

   	public function delete($id){		
   		$params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'barang masuk'){
			$params = '&'.$lastparams->params;
		}
		$data = $this->barangmasuk_m->get_detail($id);
		$del=$this->barangmasuk_m->delete('barang_masuk','idbarang_masuk',$id);
		if($del){		
			$input2 = array(
				'jumlah' => $data->jumlah - $data->jumlah_masuk
			);      
			$update=$this->barang_m->update('barang','idbarang',$data->idbarang,$input2);
			redirect(base_url().'barangmasuk/?alert=success'.$params) ; 	
		} 
		redirect(base_url().'barangmasuk/?alert=failed'.$params) ; 			
	}

	public function _doupload_file($name,$target,$filename){
		$img						= $name;
		$config['file_name']  		= $filename;
		$config['upload_path'] 		= $target;
		$config['overwrite'] 		= FALSE;
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000000';
		$config['remove_spaces']  	= TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($img)){
			// $return['message'] 	 = $this->upload->display_messages();
			$return['file_name'] = '';
		}else{
			$data = array('upload_data' => $this->upload->data());
			$return['message'] 	 = '-';
			$return['file_name'] = $data['upload_data']['file_name'];
			$file_name = $data['upload_data']['file_name'];
            // process resize image before upload
            $this->load->library('image_lib'); 
            $configer = array(
                    'image_library' => 'gd2',
                    'source_image' => $data['upload_data']['full_path'],
                    'create_thumb' => FALSE,//tell the CI do not create thumbnail on image
                    'maintain_ratio' => TRUE,
                    'quality' => '100%', //tell CI to reduce the image quality and affect the image size
                    'width' => 640,//new size of image
                    'height' => 480,//new size of image
                );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
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
