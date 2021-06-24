<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class auth_m extends My_Model{

	function __construct() {
		parent::__construct();
	}
	function cek_login($user,$pass){
		$sql = "SELECT * FROM users WHERE (username='$user' AND password = '$pass' )";
		$res = $this->db->query($sql);
		$r='';
		if ($res->num_rows() > 0) {
            $r = $res->row();
        }else {
        	$r = false;
        }
		return $r;
	}
	
	function cek_user($user){
		$sql = "SELECT id FROM users WHERE (username ='$user')";
		$res = $this->db->query($sql);
		$r=$res->num_rows();
		return $r;
	}
	
	function get_user($id){
		$res = $this->db->query("SELECT * FROM users WHERE id=$id");
		$r = $res->row();
		$res->free_result();
		return $r;
	}
	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
