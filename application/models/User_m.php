<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_m extends My_Model{

	function __construct() {
		parent::__construct();
	}	
	
	
	function cek_email($email,$id){
		$sql = "SELECT * FROM users WHERE (email='$email' ) AND id <> $id";
		$res = $this->db->query($sql);
		$r=$res->num_rows();
		return $r;
	}
	
	function cek_username($id,$user){
		$sql = "SELECT * FROM users WHERE (username='$user') AND id <> $id";
		$res = $this->db->query($sql);
		$r=$res->num_rows();
		return $r;
	}
	
	function cek_pass($id,$pass){
		$sql = "SELECT * FROM users WHERE password='$pass' AND id = '$id'";
		$res = $this->db->query($sql);
		$r=$res->num_rows();
		return $r;
	}
	
	function get_user($email){
		$sql = "SELECT * FROM users WHERE id ='$email'";
		$res = $this->db->query($sql);
		$r='';
		if ($res->num_rows() > 0) {
            $r = $res->row();
        }else {
        	$r = false;
        }
		return $r;
	}
	
	function get_id($id){
		$sql = "SELECT * FROM users WHERE id = $id";
		$res = $this->db->query($sql);
		$r='';
		if ($res->num_rows() > 0) {
            $r = $res->row();
        }else {
        	$r = false;
        }
		return $r;
	}
	
	function search($s,$role="",$status=""){
		$sql = "SELECT * FROM users WHERE  ( username LIKE '%$s%' or nama LIKE '%$s%' )";
		if($role){
			$sql.= " AND role = '$role' ";
		}
		if($status != '' || $status == '0'){
			$sql.= " AND status = $status ";
		}
		$sql.= " ORDER by id ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s,$role="",$status=""){
		$sql = "SELECT * FROM users WHERE  ( username LIKE '%$s%' or nama LIKE '%$s%' )";
		if($kat){
			$sql.= " AND role = '$role' ";
		}
		if($status != '' || $status == '0'){
			$sql.= " AND status = $status ";
		}
		$sql.= " ORDER by id ASC";
		$res = $this->db->query($sql);
		$r = $res->num_rows;
		$res->free_result();
		return $r;
	}

	function get_detail($id){
		$sql = "SELECT * FROM users WHERE id= $id";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

}


/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
