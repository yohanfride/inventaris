<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class barang extends CI_Controller {

	public $prefix = "KD";

    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('jenis_m');
		$this->load->model('barang_m');
		$this->load->model('user_m');
    }
   	
   	public function index(){
   		$data=array();
		$data['menu']='barang';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Barang';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data barang berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data barang gagal dihapus";
   		
   		$data['jns'] = $this->input->get('jenis');
		$data['s'] = $this->input->get('s');
		$data['lks'] = $this->input->get('lokasi');
		$data['status'] = $this->input->get('status');
		
		$data['jenis'] = $this->jenis_m->get_data_all('');
		$data['lokasi'] = $this->barang_m->get_lokasi('','');
		
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->barang_m->count_data_all($data['s'],$data['jns'],$data['lks'],$data['status']);
        $data['paginator'] = $this->barang_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->barang_m->get_data_all($data['s'],$data['jns'],$data['lks'],$data['status'],$dataPerhalaman,$off);
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
		$this->load->view('barang_v', $data);
   	}

   	public function tambah(){
		$data=array();
		$data['menu']='barang';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Tambah Data Barang';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
			$this->form_validation->set_rules('nama', 'Nama Barang', 'required');
			$this->form_validation->set_rules('jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
			$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			if ($this->form_validation->run($this) == FALSE) {
				$data['error'] = validation_errors();
			} else {
				$input=array(
					'kode_barang' => $this->input->post('kode_barang'),			
					'barang' => $this->input->post('nama'),			
					'idjenis' => $this->input->post('jenis'),
					'date_add' => $this->input->post('tanggal'),			
					'keterangan_barang' => $this->input->post('keterangan'),	
					'jumlah' => $this->input->post('jumlah'),	
					'satuan' => $this->input->post('satuan'),	
					'lokasi' => $this->input->post('lokasi'),	
					'user_id' => $data['user_now']->id,			
				);
				$tanggal = date("Y-m-d");
				$kode = $this->input->post('kode_barang');
				if(!empty($_FILES['foto']['name'])){				
					$pict = 'assets/upload/barang/'.$this->_doupload_file('foto','assets/upload/barang/',"(".$tanggal.")-".$kode);
					$input['foto'] =  $pict;
				}
				$insert=$this->barang_m->insert('barang',$input);
				if($this->db->affected_rows()){            
	                $data['success']='Data berhasil ditambahkan';                  
	            } else {                
	                $data['error']='Data gagal ditambahkan';
	            }
			}
		}
		$lastid = $this->barang_m->get_last_id();
		if(empty($lastid)){
			$data['kode'] = $this->prefix."00001";
		} else {
			$lastid = $lastid->kode_barang;
			$lastid = str_replace($this->prefix,'',$lastid);
			$lastid = intval($lastid);
			$lastid++;
			$lastid = sprintf('%05d',$lastid);
			$data['kode'] = $this->prefix.$lastid;
		}
		$data['jenis'] = $this->jenis_m->get_data_all('');
		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('barang_add_v', $data);
   	}

   	public function edit($id){
		$data=array();
		$data['menu']='barang';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Ubah Data Barang';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data berhasil diubah';	
		if($this->input->get('alert')=='failed') $data['error']="Data berhasil diubah";		
		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
			$this->form_validation->set_rules('nama', 'Nama Barang', 'required');
			$this->form_validation->set_rules('jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
			$this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			if ($this->form_validation->run($this) == FALSE) {
				$data['error'] = validation_errors();
			} else {
				$input=array(
					'kode_barang' => $this->input->post('kode_barang'),			
					'barang' => $this->input->post('nama'),			
					'idjenis' => $this->input->post('jenis'),
					'date_add' => $this->input->post('tanggal'),			
					'keterangan_barang' => $this->input->post('keterangan'),	
					'jumlah' => $this->input->post('jumlah'),	
					'satuan' => $this->input->post('satuan'),	
					'lokasi' => $this->input->post('lokasi'),
					'status' => 	$this->input->post('status'),
					'user_id' => $data['user_now']->id,			
				);
				$tanggal = date("Y-m-d h-i-s");
				$kode = $this->input->post('kode_barang');
				$pict = $this->input->post('imgcurr');
				if(!empty($_FILES['foto']['name'])){				
					if(!empty($pict))
						unlink($pict);

					$pict = 'assets/upload/barang/'.$this->_doupload_file('foto','assets/upload/barang/',"(".$tanggal.")-".$kode);
					$input['foto'] =  $pict;
				}
				$update=$this->barang_m->update('barang','idbarang',$id,$input);
				if($update){            
	                $data['success']='Data berhasil diubah';                  
	            } else {                
	                $data['error']='Data gagal diubah';
	            }
			}
		}
        $data['data'] = $this->barang_m->get_detail($id);        
		$data['jenis'] = $this->jenis_m->get_data_all('');
		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('barang_edit_v', $data);
   	}

   	public function delete($id){		
   		$params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'barang'){
			$params = '&'.$lastparams->params;
		}
		$data = $this->barang_m->get_detail($id);
		if(!$this->barang_m->cek_hapus($id)){
			$del=$this->barang_m->delete('barang','idbarang',$id);
			if($del){		
				if($data->foto){					
					unlink($data->foto);	
				}
				redirect(base_url().'barang/?alert=success'.$params) ; 	
			} 
		}
		redirect(base_url().'barang/?alert=failed'.$params) ; 			
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
