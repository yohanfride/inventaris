<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class barangkeluar_m extends My_Model{
	public function __construct(){
		parent ::__construct();
	}

	
	function get_data_all($s,$barang="",$idjenis="",$date_start='',$date_end='',$lim='',$off=''){
		$sql = "SELECT * FROM barang_keluar a join barang b on b.idbarang = a.idbarang 
		join jenis c on c.idjenis = b.idjenis 
		WHERE(barang LIKE '%$s%' OR kode_barang LIKE '%$s%') ";
		if(!empty($barang)){
			$sql.=" AND (idbarang = $barang OR kode_barang LIKE '%$barang%') ";
		}
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND a.tanggal_keluar  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59'";
		}
		if(!empty($idjenis)){
			$sql.=" AND idjenis = $idjenis ";
		}
		$sql.= " ORDER BY tanggal_keluar DESC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function count_data_all($s,$barang="",$idjenis="",$date_start='',$date_end=''){
		$sql = "SELECT * FROM barang_keluar a join barang b on b.idbarang = a.idbarang 
		join jenis c on c.idjenis = b.idjenis 
		WHERE (barang LIKE '%$s%' OR kode_barang LIKE '%$s%') ";
		if(!empty($barang)){
			$sql.=" AND (idbarang = $barang OR kode_barang LIKE '%$barang%') ";
		}
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND a.tanggal_keluar  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59'";
		}
		if(!empty($idjenis)){
			$sql.=" AND idjenis = $idjenis ";
		}
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function get_detail($id){
		$sql = "SELECT * FROM barang_keluar a join barang b on b.idbarang = a.idbarang 
		join jenis c on c.idjenis = b.idjenis WHERE idbarang_keluar = '$id' ";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}
	
}
