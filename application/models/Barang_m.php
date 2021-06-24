<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class barang_m extends My_Model{
	public function __construct(){
		parent ::__construct();
	}

	function get_data_all($s,$idjenis="",$lokasi="",$status="",$lim='',$off=''){
		$sql = "SELECT * FROM barang a join jenis b on a.idjenis = b.idjenis 
		WHERE (barang LIKE '%$s%' OR kode_barang LIKE '%$s%') ";
		if(!empty($lokasi)){
			$sql.=" AND lokasi LIKE '%$lokasi%' ";
		}
		if(!empty($idjenis)){
			$sql.=" AND a.idjenis = $idjenis ";
		}
		if(!empty($status)){
			$sql.=" AND status = $status ";
		}
		$sql.= " ORDER BY kode_barang ASC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function count_data_all($s,$idjenis="",$lokasi="",$status=""){
		$sql = "SELECT * FROM barang a join jenis b on a.idjenis = b.idjenis 
		WHERE (barang LIKE '%$s%' OR kode_barang LIKE '%$s%') ";
		if(!empty($lokasi)){
			$sql.=" AND lokasi LIKE '%$lokasi%' ";
		}
		if(!empty($idjenis)){
			$sql.=" AND a.idjenis = $idjenis ";
		}
		if(!empty($status)){
			$sql.=" AND status = $status ";
		}
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function get_detail($id){
		$sql = "SELECT * FROM barang WHERE ( idbarang = $id or kode_barang='$id')";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function cek_hapus($id){
		$sql = "SELECT * FROM barang_masuk WHERE idbarang = $id ";
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function cek_hapus2($id){
		$sql = "SELECT * FROM barang_keluar WHERE idbarang = $id ";
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function cek_hapus3($id){
		$sql = "SELECT * FROM peminjaman_item WHERE idbarang = $id ";
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function get_lokasi(){
		$sql = "SELECT DISTINCT lokasi FROM barang";
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function get_last_id(){
		$sql = "SELECT * FROM barang order by idbarang DESC LIMIT 1";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}
}
