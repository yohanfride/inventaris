<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class kembaliamplop_m extends My_Model{
	public function __construct(){
		parent ::__construct();
	}

	function rp($r){
		return 'Rp. '.number_format($r,'0','.','.');
	}
	
	function get_data_all($date_start='',$date_end='',$wil="",$ling="",$status='',$lim='',$off=''){
		$sql = "SELECT a.*,b.*,c.username FROM pengembalian_amplop a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				join users c on a.user_id = c.id
				WHERE tanggal_pengembalian  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59' ";
		if(!empty($wil)){
			$sql.=" AND (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}
		if(!empty($ling)){
			$sql.=" AND (a.kode_lingkungan = '$ling' OR lingkungan LIKE '%$ling%') ";
		}
		if($status != '' || $status == '0'){
			$sql.=" AND status_pakai=$status ";
		}
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" ";
		}

		$sql.= " ORDER BY tanggal_pengembalian DESC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function count_data_all($date_start='',$date_end='',$wil="",$ling="",$status=''){
		$sql = "SELECT * FROM pengembalian_amplop a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				WHERE tanggal_pengembalian  BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59' ";
		if(!empty($wil)){
			$sql.=" AND (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}
		if(!empty($ling)){
			$sql.=" AND (a.kode_lingkungan = '$ling' OR lingkungan LIKE '%$ling%') ";
		}
		if($status != '' || $status == '0'){
			$sql.=" AND status_pakai=$status ";
		}
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" ";
		}
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function get_detail($id){
		$sql = "SELECT a.*,b.*,c.username FROM pengembalian_amplop a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				join users c on a.user_id = c.id
				WHERE idpengembalian_amplop = $id ";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}	
	

	function cek_hapus($id){
		$sql = "SELECT * FROM relasi_amplop_coklat WHERE idpengembalian_amplop=$id";
		$res = $this->db->query($sql);
		$r=$res->num_rows();
		$res->free_result();
		return $r;
	}

	function get_data_by_tanggal($date_start='',$ling="",$status_simpan='',$status_pakai=''){
		$sql = "SELECT a.*,b.*,c.username FROM pengembalian_amplop a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				join users c on a.user_id = c.id
				WHERE tanggal_pengembalian = '$date_start'";
		if(!empty($ling)){
			$sql.=" AND (a.kode_lingkungan = '$ling' OR lingkungan LIKE '%$ling%') ";
		}
		if($status_simpan != '' || $status_simpan == '0'){
			$sql.=" AND status_simpan=$status_simpan ";
		}
		if($status_pakai != '' || $status_pakai == '0'){
			$sql.=" AND status_pakai=$status_pakai ";
		}
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function total_pengembalian_amplop($wil=""){
		$sql = "SELECT a.*, IFNULL(b.jumlah_amplop, 0) AS total FROM lingkungan a left join 
				(SELECT kode_lingkungan, sum(jumlah_amplop) as total FROM pengembalian_amplop GROUP BY kode_lingkungan ) b on a.kode_lingkungan = b.kode_lingkungan ";
		if(!empty($wil)){
			$sql.=" WHERE (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}		
		$sql.= "ORDER BY kode_lingkungan ASC";
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function jumlah_pengembalian_amplop($wil=""){
		$sql = "SELECT a.*, (SELECT COUNT(kk_id) * 7 FROM amplop_umat c WHERE c.kode_lingkungan = a.kode_lingkungan ) as jumlah_amplop,
				IFNULL(b.jumlah_amplop, 0) AS jumlah_pengembalian FROM lingkungan a left join 
				( SELECT kode_lingkungan, sum(jumlah_amplop) as jumlah_amplop FROM pengembalian_amplop GROUP BY kode_lingkungan ) b on a.kode_lingkungan = b.kode_lingkungan ";
		if(!empty($wil)){
			$sql.=" WHERE (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}		
		$sql.= "ORDER BY kode_lingkungan ASC";
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function total_pengembalian_amplop_excel($wil=""){
		$sql = "SELECT a.*, IFNULL(b.jumlah_amplop, 0) AS total 
				FROM lingkungan a left join (SELECT kode_lingkungan, sum(jumlah_amplop) as jumlah_amplop
				FROM pengembalian_amplop GROUP BY kode_lingkungan ) b on a.kode_lingkungan = b.kode_lingkungan ";
		if(!empty($wil)){
			$sql.=" WHERE (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}		
		$sql.= "ORDER BY kode_lingkungan ASC";
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}


	function jumlah_pengembalian_amplop_dashboard($orderby="jumlah_pengembalian DESC",$lim=""){
		$sql = "SELECT a.*, (SELECT COUNT(kk_id) * 7 FROM amplop_umat c WHERE c.kode_lingkungan = a.kode_lingkungan ) as jumlah_amplop,
				IFNULL(b.jumlah_amplop, 0) AS jumlah_pengembalian, IFNULL(b.total, 0) AS total FROM lingkungan a left join 
				( SELECT kode_lingkungan, sum(jumlah_amplop) as jumlah_amplop FROM pengembalian_amplop 
				GROUP BY kode_lingkungan ) b on a.kode_lingkungan = b.kode_lingkungan ";
		$sql.= " ORDER BY $orderby";
		if(!empty($lim)){
			$sql.= " LIMIT 0, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}
}
