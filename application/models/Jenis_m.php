<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class jenis_m extends My_Model{
	public function __construct(){
		parent ::__construct();
	}

	function get_data_all($s,$lim='',$off=''){
		$sql = "SELECT * FROM jenis WHERE (jenis LIKE '%$s%') ";
		$sql.= " ORDER BY jenis ASC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function count_data_all($s){
		$sql = "SELECT * FROM jenis WHERE (jenis LIKE '%$s%') ";
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}
	
	function get_detail($id){
		$sql = "SELECT * FROM jenis WHERE idjenis = $id ";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function cek_hapus($id){
		$sql = "SELECT * FROM barang WHERE  idjenis= $id ";
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

}
