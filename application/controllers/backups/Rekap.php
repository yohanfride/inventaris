<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rekap extends CI_Controller {

    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('lingkungan_m');
		$this->load->model('rekapamplop_m');
		$this->load->model('rekaplingkungan_m');
		$this->load->model('user_m');
    }

    public function index(){
   		$data=array();
		$data['menu']='rekap';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Data Rekap Amplop Coklat';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data rekap amplop berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data rekap amplop gagal dihapus";
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata = $this->rekapamplop_m->count_data_all($data['str_date'],$data['end_date']);
        $data['paginator'] = $this->rekapamplop_m->page($jmldata, $dataPerhalaman, $hal);
        $data['jmldata'] = $jmldata;
		////End Paginator////
		$data['data'] = $this->rekapamplop_m->get_data_all($data['str_date'],$data['end_date'],'','',$dataPerhalaman,$off);
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
		$this->load->view('rekapamplop_v', $data);
   	}
   	
    public function tambah(){
    	$data=array();
		$data['menu']='rekap';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$lastid = $this->rekapamplop_m->get_last($data['user_now']->id);
		if($lastid){
			redirect(base_url().'rekap/edit/'.$lastid->idrekap_amplop) ; 			
		}
		$data['title'] = 'Tambah Rekap Amplop Coklat';
		$data['success']='';
		$data['error']='';
		$data['str_date'] = date("Y-m-d");
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');
		$data['pecahan'] = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
		$data['label_pecahan'] = ['Rp. 100.000','Rp. 50.000','Rp. 20.000','Rp. 10.000','Rp. 5.000','Rp. 2.000','Rp. 1.000','Rp. 1.000 (KOIN)','Rp. 500 (KOIN)','Rp. 200 (KOIN)','Rp. 100 (KOIN)'];
		$data['nilai_pecahan'] = [100000,50000,20000,10000,5000,2000,1000,1000,500,200,100];
		$this->load->view('rekapamplop_add_v', $data);
    }

    public function edit($id){
		$data=array();
		$data['menu']='rekap';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Edit Rekap Amplop Coklat';
		$data['success']='';
		$data['error']='';
		$rekap_data = $this->rekapamplop_m->get_detail($id);
		if(empty($rekap_data)){
			$params = '';
			$lastparams = (object)$this->session->userdata('lastparams');
			if($lastparams->menu == 'rekap'){
				$params = $lastparams->params;
			}
			redirect(base_url().'rekapamplop/?'.$params) ; 			
		} else {
			$rekap_data->pecahan = json_decode($rekap_data->pecahan);
			$data['data'] = $rekap_data;	
			$data['list'] = $this->rekapamplop_m->get_relasi($id);
		}
		$data['pecahan'] = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
		$data['label_pecahan'] = ['Rp. 100.000','Rp. 50.000','Rp. 20.000','Rp. 10.000','Rp. 5.000','Rp. 2.000','Rp. 1.000','Rp. 1.000 (KOIN)','Rp. 500 (KOIN)','Rp. 200 (KOIN)','Rp. 100 (KOIN)'];
		$data['nilai_pecahan'] = [100000,50000,20000,10000,5000,2000,1000,1000,500,200,100];
		$data['lingkungan'] = $this->lingkungan_m->get_lingkungan('','');
		$this->load->view('rekapamplop_edit_v', $data);
   	}

    public function delete($id){		
   		$params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'rekap'){
			$params = '&'.$lastparams->params;
		}
		$rekap_data = $this->rekapamplop_m->get_detail($id);
		if($rekap_data){
			$list = $this->rekapamplop_m->get_relasi($id);
			foreach ($list as $d) {
				$input = array(
					'status_pakai' => 0
				);
				$update=$this->rekaplingkungan_m->update('rekap_lingkungan','idrekap_lingkungan',$d->idrekap_lingkungan,$input);
			}
			$del=$this->rekapamplop_m->delete('relasi_amplop_coklat','idrekap_amplop',$id);
			$del=$this->rekapamplop_m->delete('rekap_amplop','idrekap_amplop',$id);
			if($del){
				redirect(base_url().'rekap/?alert=success'.$params) ; 			
			} 
		}
		redirect(base_url().'rekap/?alert=failed'.$params) ; 			
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
