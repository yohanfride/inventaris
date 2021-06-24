<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class peminjaman_m extends My_Model{
	public function __construct(){
		parent ::__construct();
	}

	
	function get_data_all($s,$status="",$date_start='',$date_end='',$lim='',$off=''){
		$sql = "SELECT * FROM peminjaman a WHERE (peminjam LIKE '%$s%' or kode_peminjaman LIKE '%$s%' ) ";
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND a.tgl_pinjam  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59'";
		}
		if(!empty($status)){
			$sql.=" AND status_pinjam = $status ";
		}
		$sql.= " ORDER BY tgl_pinjam DESC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function count_data_all($s,$status="",$date_start='',$date_end=''){
		$sql = "SELECT * FROM peminjaman a WHERE (peminjam LIKE '%$s%' or kode_peminjaman LIKE '%$s%' ) ";
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND a.tgl_pinjam  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59'";
		}
		if(!empty($status)){
			$sql.=" AND status_pinjam = $status ";
		}
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function get_detail($id){
		$sql = "SELECT * FROM peminjaman a WHERE idpeminjaman = $id ";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function get_item($id){
		$sql = "SELECT * FROM peminjaman_item a join peminjaman d on a.idpeminjaman = d.idpeminjaman 
		join barang b on b.idbarang = a.idbarang 
		join jenis c on c.idjenis = b.idjenis WHERE ( a.idpeminjaman = $id or kode_peminjaman = '$id' )";
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}
	
	function search_item($s,$barang="",$status="",$date_start="",$date_end="",$lim='',$off=''){
		$sql = "SELECT * FROM peminjaman_item a join peminjaman d on a.idpeminjaman = d.idpeminjaman 
		join barang b on b.idbarang = a.idbarang join jenis c on c.idjenis = b.idjenis 
		WHERE (peminjam LIKE '%$s%' or kode_peminjaman LIKE '%$s%' )";
		if(!empty($status)){
			$sql.=" AND a.status_kembali = $status ";
		}
		if(!empty($barang)){
			$sql.=" AND (idbarang = $barang or kode_barang='$barang' )";
		}
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND (d.tgl_pinjam  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') ";
		}
		$sql.= " ORDER BY d.tgl_pinjam DESC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}
	
	function count_search_item($s,$barang="",$status="",$date_start="",$date_end=""){
		$sql = "SELECT * FROM peminjaman_item a join peminjaman d on a.idpeminjaman = d.idpeminjaman 
		join barang b on b.idbarang = a.idbarang join jenis c on c.idjenis = b.idjenis 
		WHERE (peminjam LIKE '%$s%' or kode_peminjaman LIKE '%$s%' )";
		if(!empty($status)){
			$sql.=" AND a.status_kembali = $status ";
		}
		if(!empty($barang)){
			$sql.=" AND (idbarang = $barang or kode_barang='$barang' )";
		}
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND (d.tgl_pinjam  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') ";
		}
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function get_last_id(){
		$sql = "SELECT * FROM peminjaman order by idpeminjaman DESC LIMIT 1";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function get_detail_item($id){
		$sql = "SELECT * FROM peminjaman_item a join peminjaman d on a.idpeminjaman = d.idpeminjaman 
		join barang b on b.idbarang = a.idbarang 
		join jenis c on c.idjenis = b.idjenis WHERE id_peminjaman_item = $id";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function check_item_kembali($id){
		$sql = "SELECT * FROM peminjaman_item  WHERE ( idpeminjaman = $id ) and status_kembali = 0";
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}
}
