<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lingkungan extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");        
		$this->load->model('lingkungan_m');
		$this->load->model('user_m');
    }

	public function index(){        
		$data=array();
		$data['menu']='lingkungan';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Lingkungan';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data lingkungan berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data lingkungan gagal dihapus";	
		$data['data'] = $this->lingkungan_m->get_lingkungan('','');
		$data['user_now'] = $this->session->userdata('amplop_session');		        
		$this->load->view('lingkungan_v', $data);
	}

	public function tambah(){       
		$data=array();
		$data['menu']='lingkungan';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Tambah Data Lingkungan';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){        	
        	$input = array(
        		"kode_lingkungan" => $this->input->post('kode_lingkungan'),
        		"lingkungan" => strtoupper($this->input->post('lingkungan')),
        		"kode_wilayah" => $this->input->post('kode_wilayah'),
				"wilayah" => strtoupper($this->input->post('wilayah'))
        	);
        	$respo = $this->lingkungan_m->insert('lingkungan',$input);
            if($this->db->affected_rows()){            
                $data['success']='Data berhasil ditambahkan';                  
            } else {                
                $data['error']='Data gagal ditambahkan';
            } 
        }
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		$this->load->view('lingkungan_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['menu']='lingkungan';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Edit Data Lingkungan';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data berhasil diubah';	
		if($this->input->get('alert')=='failed') $data['error']="Data berhasil diubah";		
		if($this->input->post('save')){        	
        	$input = array(
        		"kode_lingkungan" => $this->input->post('kode_lingkungan'),
        		"lingkungan" => strtoupper($this->input->post('lingkungan')),
        		"kode_wilayah" => $this->input->post('kode_wilayah'),
				"wilayah" => strtoupper($this->input->post('wilayah'))
        	);
        	$respo = $this->lingkungan_m->update('lingkungan','kode_lingkungan',$id,$input);
            if($respo){             
				$data['error']='';
                $data['success']='Data berhasil diubah'; 
                if($id != $this->input->post('kode_lingkungan') ) 
					redirect(base_url().'lingkungan/edit/'.$this->input->post('kode_lingkungan').'/?alert=success') ; 			
            } else {                
				$data['success']='';
                $data['error']='Data gagal diubah';
                if($id != $this->input->post('kode_lingkungan') ) 
					redirect(base_url().'lingkungan/edit/'.$this->input->post('kode_lingkungan').'/?alert=failed') ; 			
            }                       
        }
        $data['data'] = $this->lingkungan_m->get_detail($id);        
		$data['id'] = $id;
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		$this->load->view('lingkungan_edit_v', $data);
	}
	public function delete($id){					
		if(!$this->lingkungan_m->cek_hapus($id)){
			$del=$this->lingkungan_m->delete('lingkungan','kode_lingkungan',$id);
			if($del){
				redirect(base_url().'lingkungan/?alert=success') ; 			
			} 
		}
		redirect(base_url().'lingkungan/?alert=failed') ; 			
	}

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
