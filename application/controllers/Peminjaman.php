<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class peminjaman extends CI_Controller {
	
	public $prefix = "PJ";
    
    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('jenis_m');
		$this->load->model('barangmasuk_m');
		$this->load->model('barang_m');
		$this->load->model('peminjaman_m');
		$this->load->model('user_m');
    }

    public function index(){
   		$data=array();
		$data['menu']='peminjaman';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Peminjaman';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data peminjaman berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data peminjaman gagal dihapus";
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		$data['status'] = $this->input->get('status');
		$data['s'] = $this->input->get('s');

		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->peminjaman_m->count_data_all($data['s'],$data['status'],$data['str_date'],$data['end_date']);
        $data['paginator'] = $this->peminjaman_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->peminjaman_m->get_data_all($data['s'],$data['status'],$data['str_date'],$data['end_date'],$dataPerhalaman,$off);
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
		$this->load->view('peminjaman_v', $data);
   	}
   	
    public function tambah(){
    	$data=array();
		$data['menu']='peminjaman';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Tambah Data Peminjaman';
		$data['success']='';
		$data['error']='';
		$data['str_date'] = date("Y-m-d");
		$data['barang'] = $this->barang_m->get_data_all('','','',1);
		$lastid = $this->peminjaman_m->get_last_id();
		if(empty($lastid)){
			$data['kode'] = $this->prefix."00001";
		} else {
			$lastid = $lastid->kode_peminjaman;
			$lastid = str_replace($this->prefix,'',$lastid);
			$lastid = intval($lastid);
			$lastid++;
			$lastid = sprintf('%05d',$lastid);
			$data['kode'] = $this->prefix.$lastid;
		}
		$this->load->view('peminjaman_add_v', $data);
    }

    public function edit($id){
		$data=array();
		$data['menu']='peminjaman';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Ubah Data Peminjaman';
		$data['success']='';
		$data['error']='';
		$peminjaman_data = $this->peminjaman_m->get_detail($id);
		if(empty($peminjaman_data)){
			$params = '';
			$lastparams = (object)$this->session->userdata('lastparams');
			if($lastparams->menu == 'peminjaman'){
				$params = $lastparams->params;
			}
			redirect(base_url().'peminjaman/?'.$params) ; 			
		} else {
			$data['data'] = $peminjaman_data;	
			$data['list'] = $this->peminjaman_m->get_item($id);
		}
		$data['barang'] = $this->barang_m->get_data_all('','','',1);
		$this->load->view('peminjaman_edit_v', $data);
   	}

    public function delete($id){		
   		$params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'peminjaman'){
			$params = '&'.$lastparams->params;
		}
		$peminjaman_data = $this->peminjaman_m->get_detail($id);
		if($peminjaman_data){
			$list = $this->peminjaman_m->get_item($id);
			foreach ($list as $d) {
				$input2 = array(
					'jumlah' => $d->jumlah + $d->jumlah_pinjam
				);      
				$update=$this->barang_m->update('barang','idbarang',$data->idbarang,$input2);
			}
			$del=$this->peminjaman_m->delete('peminjaman_item','idpeminjaman',$id);
			$del=$this->peminjaman_m->delete('peminjaman','idpeminjaman',$id);
			if($del){
				redirect(base_url().'peminjaman/?alert=success'.$params) ; 			
			} 
		}
		redirect(base_url().'peminjaman/?alert=failed'.$params) ; 			
	}

	public function kembali($id){
		$data=array();
		$data['menu']='peminjaman';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Pengembalian Barang';
		$data['success']='';
		$data['error']='';
		$peminjaman_data = $this->peminjaman_m->get_detail($id);
		if(empty($peminjaman_data)){
			$params = '';
			$lastparams = (object)$this->session->userdata('lastparams');
			if($lastparams->menu == 'peminjaman'){
				$params = $lastparams->params;
			}
			redirect(base_url().'peminjaman/?'.$params) ; 			
		} else {
			$data['data'] = $peminjaman_data;	
			$data['list'] = $this->peminjaman_m->get_item($id);
		}
		$data['barang'] = $this->barang_m->get_data_all('','','',1);
		$this->load->view('peminjaman_kembali_v', $data);
   	}

	public function buat_billing(){
    	$data=array();
    	$data['user_now'] =  $this->session->userdata('amplop_session');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kode', 'Kode', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			echo 'error';
		} else {
			$input=array(
				'kode_peminjaman' => $this->input->post('kode'),			
				'tgl_pinjam' => $this->input->post('tanggal'),	
				'user_id' => $data['user_now']->id,			
			);
			$insert=$this->peminjaman_m->insert('peminjaman',$input);
			if($this->db->affected_rows()){
				echo $insert;
	        } else {                
	            echo 'error';
	        }
		}
    }

    public function update_billing($id){
    	$data=array();
    	$data['user_now'] =  $this->session->userdata('amplop_session');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kode', 'Kode', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('peminjam', 'Peminjam', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			echo 'error';
		} else {
			$input=array(
				'kode_peminjaman' => $this->input->post('kode'),			
				'tgl_pinjam' => $this->input->post('tanggal'),	
				'peminjam' => $this->input->post('peminjam'),	
				'tgl_update' => date("Y-m-d h-i-s"),
				'keterangan_pinjam' => $this->input->post('keterangan'),	
				'user_id' => $data['user_now']->id,			
			);
			$update=$this->peminjaman_m->update('peminjaman','idpeminjaman',$id,$input);
			if($update){
				echo 'success';
            } else {                
                echo 'error';
            }
		}
    }
	
	public function tambah_item(){
    	$data=array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('barang', 'Barang', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			// echo 'error';
			echo validation_errors();
		} else {
			$barang = $this->barang_m->get_detail($this->input->post('barang'));
			$jml = $this->input->post('jumlah');
			if($barang->jumlah<$jml){
				echo 'Jumlah lebih dari stok';	
			} else {
				$input=array(
					'idbarang' => $this->input->post('barang'),			
					'idpeminjaman' => $this->input->post('peminjaman'),			
					'jumlah_pinjam' => $this->input->post('jumlah')	
				);
				$insert=$this->peminjaman_m->insert('peminjaman_item',$input);
				if($this->db->affected_rows()){
					$input2 = array(
						'jumlah' => $barang->jumlah - $this->input->post('jumlah')
					);
					$update=$this->barang_m->update('barang','idbarang',$this->input->post('barang'),$input2);
	                $data['success']='Data berhasil ditambahkan';
	                $id = $this->input->post('peminjaman');
	                $data['data'] = $this->peminjaman_m->get_item($id);
					$this->load->view('peminjaman_item_v', $data);
	            } else {                
	                echo 'Data gagal ditambahkan';
	            }
			}
		}
    }

    public function hapus_item($id){
    	$data = array();
    	$item = $this->peminjaman_m->get_detail_item($id);
		$del=$this->peminjaman_m->delete('peminjaman_item','id_peminjaman_item',$id);
		if($del){		
			$input2 = array(
				'jumlah' => $item->jumlah + $item->jumlah_pinjam
			);      
			$update=$this->barang_m->update('barang','idbarang',$item->idbarang,$input2);
			$data['data'] = $this->peminjaman_m->get_item($item->idpeminjaman);
			$this->load->view('peminjaman_item_v', $data);
		} else {
			echo 'error';
		}
    }
    
    public function kembali_form($id){
		$data=array();
		$data['data'] = $this->peminjaman_m->get_detail_item($id);
		if(empty($data['data'])){
			echo "error";
		} else {
			$this->load->view('kembali_form_v', $data);
		}
   	}

    public function kembali_item(){
    	$data=array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('barang', 'Barang', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run($this) == FALSE) {
			// echo 'error';
			echo validation_errors();
		} else {
			$item_peminjaman = $this->peminjaman_m->get_detail_item($this->input->post('item_peminjaman'));
			$jml = $this->input->post('jumlah');
			$jmlpinjam = $item_peminjaman->jumlah_pinjam;
			$jmlkembali =  $item_peminjaman->jumlah_kembali;
			if($jmlpinjam<$jml){
				echo 'Jumlah lebih dari peminjaman';	
			} else {
				$input=array(
					'jumlah_kembali' => $this->input->post('jumlah'),	
					'tgl_kembali' => $this->input->post('tanggal')	
				);
				if($jmlpinjam == $jml){
					$input['status_kembali'] = 1;
				} else {
					$input['status_kembali'] = 0;
				}
				$update=$this->peminjaman_m->update('peminjaman_item','id_peminjaman_item',$this->input->post('item_peminjaman'),$input);
				if($update){
					$input2 = array(
						'jumlah' => $item_peminjaman->jumlah + ( $this->input->post('jumlah') - $jmlkembali )  
					);
					$update=$this->barang_m->update('barang','idbarang',$this->input->post('barang'),$input2);	                	                
	                $id = $item_peminjaman->idpeminjaman;
	                $data['list'] = $this->peminjaman_m->get_item($id);

	                if($this->peminjaman_m->check_item_kembali($id) == 0){
	                	$cek = 0;	
	                } else {
						$cek = 1;
	                }
	                if($item_peminjaman->status_pinjam !=  $cek ){
	                	$input2 = array(
							'status_pinjam' => $cek
						);
						$update=$this->barang_m->update('peminjaman','idpeminjaman',$item_peminjaman->idpeminjaman,$input2);
	                }

					$this->load->view('pengembalian_item_v', $data);
	            } else {                
	                echo 'Data gagal ditambahkan';
	            }
			}
		}
    }

    public function item(){
   		$data=array();
		$data['menu']='barang masuk';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Barang Masuk';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data barang masuk berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data barang masuk gagal dihapus";
   		
		$data['s'] = $this->input->get('s');
		$data['brng'] = $this->input->get('barang');
		$data['status'] = $this->input->get('status');
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}

		$data['barang'] = $this->barang_m->get_data_all('');
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->peminjaman_m->count_search_item($data['s'],$data['brng'],$data['status'],$data['str_date'],$data['end_date']);
        $data['paginator'] = $this->peminjaman_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->peminjaman_m->search_item($data['s'],$data['brng'],$data['status'],$data['str_date'],$data['end_date'],$dataPerhalaman,$off);
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
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('peminjaman_list_item_v', $data);
   	}
}
