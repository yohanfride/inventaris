<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class rekapamplop_m extends My_Model{
	public function __construct(){
		parent ::__construct();
	}

	function rp($r){
		return 'Rp. '.number_format($r,'0','.','.');
	}
	
	function get_data_all($date_start='',$date_end='',$status='',$user_id='',$lim='',$off=''){
		$sql = "SELECT  a.*, IFNULL(e.lingkungan, '') as lingkungan ,f.username FROM rekap_amplop a join users f on a.user_id = f.id
				LEFT JOIN ( SELECT b.idrekap_amplop,GROUP_CONCAT(lingkungan SEPARATOR ', ') AS lingkungan FROM relasi_amplop_coklat b 
					   JOIN rekap_lingkungan c ON b.idrekap_lingkungan = c.idrekap_lingkungan JOIN lingkungan d ON c.kode_lingkungan = d.kode_lingkungan 
					   GROUP BY b.idrekap_amplop ) e ON e.idrekap_amplop = a.idrekap_amplop 
				WHERE date_add  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59' ";
		if($status != '' || $status == '0'){
			$sql.=" AND status_simpan=$status ";
		}
		if($user_id != ''){
			$sql.=" AND user_id=$user_id ";
		}
		$sql.= " ORDER BY date_add DESC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function count_data_all($date_start='',$date_end='',$status='',$user_id=''){
		$sql = "SELECT * FROM rekap_amplop WHERE date_add  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59' ";
		if($status != ''){
			$sql.=" AND status_simpan = $status ";
		}
		if($user_id != '' || $status == '0'){
			$sql.=" AND user_id=$user_id ";
		}
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function get_detail($id){
		$sql = "SELECT a.*,b.username FROM rekap_amplop a join users b on a.user_id = b.id
				WHERE idrekap_amplop = $id ";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function get_relasi($id){
		$sql = "SELECT  * FROM relasi_amplop_coklat a join rekap_lingkungan b on a.idrekap_lingkungan = b.idrekap_lingkungan
				join lingkungan c on c.kode_lingkungan = b.kode_lingkungan 
				WHERE idrekap_amplop = $id ORDER BY a.date_add DESC";
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function check_relasi($id,$idling){
		$sql = "SELECT * FROM relasi_amplop_coklat WHERE idrekap_amplop = $id AND idrekap_lingkungan = $idling ";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function get_last($id){
		$sql = "SELECT * FROM rekap_amplop a WHERE a.user_id = $id AND status_simpan = 0";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function rekap_per_tanggal($lim=''){
		$sql = "SELECT a.date_add,SUM(total) as total FROM rekap_amplop a 
				WHERE status_simpan = 1 GROUP BY a.date_add ORDER BY a.date_add DESC";
		$q   = $this->db->query($sql);
		if(!empty($lim)){
			$sql.= " LIMIT 0, $lim";
		}
		$data = $q->result();
        $q->free_result();
        return $data;
	}
}
