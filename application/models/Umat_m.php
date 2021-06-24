<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class umat_m extends My_Model{
	public function __construct(){
		parent ::__construct();
	}

	function rp($r){
		return 'Rp. '.number_format($r,'0','.','.');
	}
	
	function get_data_all($s,$wil="",$ling="",$status='',$date_start='',$date_end='',$lim='',$off=''){
		$sql = "SELECT * FROM amplop_umat a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan				
				WHERE (nama LIKE '%$s%' OR kk_id = '$s') ";
		if(!empty($wil)){
			$sql.=" AND (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}
		if(!empty($ling)){
			$sql.=" AND (a.kode_lingkungan = '$ling' OR lingkungan LIKE '%$ling%') ";
		}
		if($status != '' || $status == '0'){
			$sql.=" AND status_amplop1=$status ";
		}
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND timestamp1  BETWEEN '$date_start 00:00:01' AND '$date_end 23:59:59'";
		}

		$sql.= " ORDER BY kk_id ASC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function count_data_all($s,$wil="",$ling="",$status='',$date_start='',$date_end=''){
		$sql = "SELECT * FROM amplop_umat a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				WHERE (nama LIKE '%$s%' OR kk_id = '$s') ";
		if(!empty($wil)){
			$sql.=" AND (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}
		if(!empty($ling)){
			$sql.=" AND (a.kode_lingkungan = '$ling' OR lingkungan LIKE '%$ling%') ";
		}
		if($status != '' || $status == '0'){
			$sql.=" AND status_amplop1=$status ";
		}
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND timestamp1  BETWEEN '$date_start 00:00:01' AND '$date_end 23:59:59'";
		}
		$sql.= " ORDER BY kk_id ASC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function get_detail($kk_id){
		$sql = "SELECT *, (amplop1 + amplop2 + amplop3 + amplop4 + amplop5 + amplop6 + amplop7) as totalamplop FROM amplop_umat a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				WHERE kk_id = '$kk_id' ";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}

	function get_total_all($s,$wil="",$ling="",$status='',$date_start='',$date_end='',$lim='',$off=''){
		$sql = "SELECT nama, lingkungan, wilayah, (amplop1 + amplop2 + amplop3 + amplop4 + amplop5 + amplop6 + amplop7) as total,
				amplop1, amplop2, amplop3, amplop4, amplop5, amplop6, amplop7,
				pecahan_amplop1, pecahan_amplop2, pecahan_amplop3, pecahan_amplop4, pecahan_amplop5, pecahan_amplop6, pecahan_amplop7,
				timestamp1, timestamp2, timestamp3, timestamp4, timestamp5, timestamp7, timestamp6, timestamp7
				FROM amplop_umat a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				WHERE (nama LIKE '%$s%' OR kk_id = '$s') ";
		if(!empty($wil)){
			$sql.=" AND (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}
		if(!empty($ling)){
			$sql.=" AND (a.kode_lingkungan = '$ling' OR lingkungan LIKE '%$ling%') ";
		}
		// if($status != ''){
		// 	$sql.=" AND status_amplop1=$status ";
		// }
		if(!empty($date_start) && !empty($date_end)){
			$sql.=" AND ( (timestamp1 BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') OR (timestamp2 BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') OR 
						  (timestamp3 BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') OR (timestamp4 BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') OR
						  (timestamp5 BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') OR (timestamp6 BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') OR
						  (timestamp7 BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59') ) ";
		}		
		$sql.= " ORDER BY kk_id ASC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);
		// echo $sql;
		// exit();

		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function get_total_all_notactive($s,$wil="",$ling="",$status='',$date_start='',$date_end='',$lim='',$off=''){
		$sql = "SELECT * FROM amplop_umat a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				WHERE (nama LIKE '%$s%' OR kk_id = '$s') ";
		if(!empty($wil)){
			$sql.=" AND (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}
		if(!empty($ling)){
			$sql.=" AND (a.kode_lingkungan = '$ling' OR lingkungan LIKE '%$ling%') ";
		}
		if($status != '' || $status == '0'){
			$sql.=" AND ( status_amplop1=$status OR  status_amplop2=$status OR  status_amplop3=$status OR  status_amplop4=$status OR 
						  status_amplop5=$status OR  status_amplop6=$status OR  status_amplop7=$status )";
		}
		$sql.= " ORDER BY kk_id ASC";
		if(!empty($lim)){
			$sql.= " LIMIT $off, $lim";
		}
		$q   = $this->db->query($sql);

		$data = $q->result();
        $q->free_result();
        return $data;
	}
	
	function cek_hapus($kk_id,$status=0){
		$sql = "SELECT * FROM amplop_umat a join lingkungan b on a.kode_lingkungan = b.kode_lingkungan
				WHERE kk_id = '$kk_id' AND ( status_amplop1<>$status OR  status_amplop2<>$status OR  status_amplop3<>$status OR  status_amplop4<>$status OR 
				status_amplop5<>$status OR  status_amplop6<>$status OR  status_amplop7<>$status )";
		$q   = $this->db->query($sql);
		$data = $q->num_rows();
        $q->free_result();
        return $data;
	}

	function total_rekap_lingkungan($wil=""){
		$sql = "SELECT a.*, IFNULL(b.total, 0) AS total FROM lingkungan a left join 
				(SELECT kode_lingkungan, SUM(amplop1 + amplop2 + amplop3 + amplop4 + amplop5 + amplop6 + amplop7) as total
				FROM amplop_umat GROUP BY kode_lingkungan ) b on a.kode_lingkungan = b.kode_lingkungan ";
		if(!empty($wil)){
			$sql.=" WHERE (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}		
		$sql.= "ORDER BY kode_lingkungan ASC";
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function jumlah_rekap_lingkungan($wil=""){
		$sql = "SELECT a.*, (SELECT COUNT(kk_id) * 7 FROM amplop_umat c WHERE c.kode_lingkungan = a.kode_lingkungan ) as jumlah_amplop,
				IFNULL(b.jumlah_amplop, 0) AS jumlah_terhitung, IFNULL(d.jumlah_amplop, 0) AS jumlah_kembali FROM lingkungan a left join 
				( SELECT kode_lingkungan,timestamp1, SUM(amplop1 + amplop2 + amplop3 + amplop4 + amplop5 + amplop6 + amplop7) AS jumlah_amplop FROM 
					( SELECT kode_lingkungan, timestamp1, IF(status_amplop1 = 7,1,0) AS amplop1, IF(status_amplop2 = 7,1,0) AS amplop2,
					IF(status_amplop3 = 7,1,0) AS amplop3, IF(status_amplop4 = 7,1,0) AS amplop4,  IF(status_amplop5 = 7,1,0) AS amplop5,
					IF(status_amplop6 = 7,1,0) AS amplop6, IF(status_amplop7 = 7,1,0) AS amplop7 FROM amplop_umat ) a 
				GROUP BY kode_lingkungan) b on a.kode_lingkungan = b.kode_lingkungan 
				left join ( SELECT kode_lingkungan, sum(jumlah_amplop) as jumlah_amplop FROM pengembalian_amplop GROUP BY kode_lingkungan ) 
				d on a.kode_lingkungan = d.kode_lingkungan
				";
		
		if(!empty($wil)){
			$sql.=" WHERE (kode_wilayah = '$wil' OR wilayah LIKE '%$wil%') ";
		}		
		$sql.= "ORDER BY kode_lingkungan ASC";
		$q   = $this->db->query($sql);
		$data = $q->result();
        $q->free_result();
        return $data;
	}

	function jumlah_rekap_terhitung(){
		$sql = " SELECT SUM(amplop1 + amplop2 + amplop3 + amplop4 + amplop5 + amplop6 + amplop7) AS jumlah_amplop FROM 
					( SELECT kode_lingkungan, timestamp1, IF(status_amplop1 = 7,1,0) AS amplop1, IF(status_amplop2 = 7,1,0) AS amplop2,
					IF(status_amplop3 = 7,1,0) AS amplop3, IF(status_amplop4 = 7,1,0) AS amplop4,  IF(status_amplop5 = 7,1,0) AS amplop5,
					IF(status_amplop6 = 7,1,0) AS amplop6, IF(status_amplop7 = 7,1,0) AS amplop7 FROM amplop_umat ) a ";
		$q   = $this->db->query($sql);
		$data = $q->row();
        $q->free_result();
        return $data;
	}
}
