<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class lingkungan_m extends My_Model{

	function __construct() {
		parent::__construct();
	}	
		
	function get_wilayah(){		
		$sql = "SELECT distinct kode_wilayah,wilayah FROM lingkungan ORDER by kode_wilayah ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
	
	function get_lingkungan($wil="",$ling=""){		
		$sql = "SELECT a.*,(SELECT COUNT(kk_id) FROM amplop_umat b WHERE b.kode_lingkungan = a.kode_lingkungan ) AS jumlah_kk FROM lingkungan a";
		if(!empty($wil)){
			$sql.=" WHERE (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}

		if(!empty($ling)){
			if(!empty($wil)){
				$sql.=" AND ";
			} else {
				$sql.=" WHERE ";
			}
			$sql.=" (kode_lingkungan = '$ling' OR lingkungan LIKE '%$ling%') ";
		}
		$sql .= " ORDER by kode_lingkungan ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function get_detail($kode){		
		$sql = "SELECT * FROM lingkungan WHERE kode_lingkungan = '$kode' ";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function cek_hapus($kode){		
		$sql = "SELECT * FROM amplop_umat b WHERE b.kode_lingkungan = '$kode' ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
	
	function get_detail_bynama($ling){		
		$sql = "SELECT * FROM lingkungan WHERE lingkungan = '$ling' ";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

