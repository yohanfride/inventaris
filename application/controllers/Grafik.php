<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class grafik extends CI_Controller {

    function __construct(){
        parent::__construct();        
        if(!$this->session->userdata('amplop_session')) 
			redirect(base_url() . "auth/login");
		$this->load->model('lingkungan_m');
		$this->load->model('umat_m');
		$this->load->model('rekaplingkungan_m');
		$this->load->model('kembaliamplop_m');
		$this->load->model('user_m');

    }

    function round($var,$max = 1000000) {
	    return ceil( ($var + 9) / $max ) * $max;
	}

    public function perhitungan($cetak=""){
   		$data=array();
		$data['menu']='grafik-perhitungan';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Grafik Perhitungan Amplop';
		$data['opt'] = $this->input->get('option');
   		$data['wil'] = $this->input->get('wilayah');
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		if($data['opt']=='umat'){
			$data['data'] = $this->umat_m->total_rekap_lingkungan($data['wil']);
		} else {
			$data['data'] = $this->rekaplingkungan_m->total_rekap_lingkungan($data['wil']);
		}
		
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
		$data['list'] = array();
		$data['item'] = array();
		$max = 20;
		$item = 
		$maxitem = ceil( count($data['data']) / ceil(count($data['data']) / 20) );
		$i=0;$n=0;$max=0;
		foreach ($data['data'] as $d) {
			if($n == $maxitem){
				$i++;
				$n=0;
			}
			$data['list'][$i][] = '['.$d->kode_lingkungan.'] '.$d->lingkungan;	 
			$data['item'][$i][] = $d->total;
			if($max<$d->total) $max = $d->total;	 
			$n++;
		} 
		$data['max'] = $this->round($max); 
		if(!$cetak){
			$this->load->view('grafik_perhitungan_v', $data);
		} else {
			$data['wilayah'] = $this->lingkungan_m->get_lingkungan($data['wil'])[0];
			$this->load->view('pdf/grafik_perhitungan_v', $data);
		}
   	}

   	public function jumlah($cetak=""){
   		$data=array();
		$data['menu']='grafik-jumlah';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Grafik Jumlah Amplop';
		$data['opt'] = $this->input->get('option');
		$data['opt2'] = $this->input->get('option2');
   		$data['wil'] = $this->input->get('wilayah');
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		if($data['opt']=='umat'){
			$data['data'] = $this->umat_m->jumlah_rekap_lingkungan($data['wil']);
		} else {
			$data['data'] = $this->rekaplingkungan_m->jumlah_rekap_lingkungan($data['wil']);
		}

		
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
		$data['list'] = array();
		$data['item'] = array();
		$max = 20;
		$item = 
		$maxitem = ceil( count($data['data']) / ceil(count($data['data']) / 15) );
		$i=0;$n=0;$max=0;
		foreach ($data['data'] as $d) {
			if($n == $maxitem){
				$i++;
				$n=0;
			}
			if($data['opt2']=='umat'){
				$data['list'][$i][] = '['.$d->kode_lingkungan.'] '.$d->lingkungan;	 
				$data['item_terhitung'][$i][] = ceil($d->jumlah_terhitung / 7);
				$data['item_belum_terhitung'][$i][] = ceil($d->jumlah_amplop / 7);
				$data['item_kembali'][$i][] = ceil($d->jumlah_kembali / 7);
				if($max<ceil($d->jumlah_amplop / 7) ) $max = ceil($d->jumlah_amplop / 7);
			}else{
				$data['list'][$i][] = '['.$d->kode_lingkungan.'] '.$d->lingkungan;	 
				$data['item_terhitung'][$i][] = $d->jumlah_terhitung;
				$data['item_belum_terhitung'][$i][] = $d->jumlah_amplop;
				$data['item_kembali'][$i][] = $d->jumlah_kembali;
				if($max<$d->jumlah_amplop) $max = $d->jumlah_amplop;	
			}
				 

			$n++;
		} 
		if($data['opt2']=='umat'){
			$data['max'] = $this->round($max,10); 
		} else {
			$data['max'] = $this->round($max,100); 
		} 
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();

		if(!$cetak){
			$this->load->view('grafik_jumlah_v', $data);
		} else {
			$data['wilayah'] = $this->lingkungan_m->get_lingkungan($data['wil'])[0];
			$this->load->view('pdf/grafik_jumlah_v', $data);
		}
   	}

   	public function pengembalian($cetak=""){
   		$data=array();
		$data['menu']='grafik-kembali';
		$data['user_now'] =  $this->session->userdata('amplop_session');
		$data['title'] = 'Grafik Penerimaan Amplop';
		$data['opt'] = $this->input->get('option');
   		$data['wil'] = $this->input->get('wilayah');
		$data['wilayah'] = $this->lingkungan_m->get_wilayah();
		$data['data'] = $this->kembaliamplop_m->jumlah_pengembalian_amplop($data['wil']);
		
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
		$data['list'] = array();
		$data['item'] = array();
		$max = 0;
		$item = 
		$maxitem = ceil( count($data['data']) / ceil(count($data['data']) / 20) );
		$i=0;$n=0;$max=0;
		foreach ($data['data'] as $d) {
			if($n == $maxitem){
				$i++;
				$n=0;
			}
			$data['list'][$i][] = '['.$d->kode_lingkungan.'] '.$d->lingkungan;	 
			if($data['opt']=='umat'){
				$data['item_terhitung'][$i][] = ceil($d->jumlah_pengembalian / 7);
				$data['item_belum_terhitung'][$i][] = ceil($d->jumlah_amplop / 7) - ceil($d->jumlah_pengembalian / 7);
				if($max<ceil($d->jumlah_pengembalian / 7)) $max = ceil($d->jumlah_pengembalian / 7);
				if($max<( ceil($d->jumlah_amplop / 7) - ceil($d->jumlah_pengembalian / 7) ) ) $max =  ceil($d->jumlah_amplop / 7) - ceil($d->jumlah_pengembalian / 7);
			} else {
				$data['item_terhitung'][$i][] = $d->jumlah_pengembalian;
				$data['item_belum_terhitung'][$i][] = $d->jumlah_amplop - $d->jumlah_pengembalian;	
				if($max<$d->jumlah_pengembalian) $max = $d->jumlah_pengembalian ;
				if($max<($d->jumlah_amplop - $d->jumlah_pengembalian ) ) $max =  $d->jumlah_amplop - $d->jumlah_pengembalian;	
			}
			$n++;
		} 
		if($data['opt']=='umat'){
			$data['max'] = $this->round($max,10); 
		} else {
			$data['max'] = $this->round($max,100); 
		}
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		if(!$cetak){
			$this->load->view('grafik_kembali_v', $data);
		} else {
			$data['wilayah'] = $this->lingkungan_m->get_lingkungan($data['wil'])[0];
			$this->load->view('pdf/grafik_kembali_v', $data);
		}
   	}

}
