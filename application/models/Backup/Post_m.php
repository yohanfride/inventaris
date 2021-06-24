<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class post_m extends My_Model{

	function __construct() {
		parent::__construct();
	}	
	
	function get_post($id){		
		$sql = "SELECT a.*,f.idgroups,f.username,f.name as name_user, f.picture as picture_user,(SELECT count(*) from comment b where a.idpost = b.idpost) as total_coment
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1) as total_love
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0) as total_dislike
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost) as total_bookmark
		from post a join user f on a.iduser = f.id WHERE a.idpost=$id GROUP BY a.idpost";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function my_post($id,$lastid=0,$lim=5){		
		if(empty($lim)) $lim = 5;
		$sql = "SELECT a.*,f.idgroups,f.username,f.name as name_user, f.picture as picture_user,(SELECT count(*) from comment b where a.idpost = b.idpost) as total_coment
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1) as total_love
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0) as total_dislike
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost) as total_bookmark
		from post a join user f on a.iduser = f.id WHERE f.username='$id'";
		if(!empty($lastid)){
			$sql.=" and idpost < $lastid";
		}
		$sql.="  GROUP BY a.idpost Order By a.idpost DESC LIMIT $lim";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
	
	function all_post($id,$lastid=0,$lim=5){		
		if(empty($lim)) $lim = 5;		
		$sql = "SELECT a.*,f.idgroups,f.username,f.name as name_user, f.picture as picture_user
		,(SELECT count(*) from comment b where a.idpost = b.idpost) as total_coment
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1) as total_love
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0) as total_dislike
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost) as total_bookmark
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost and iduser = $id) as bookmark_status
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1 and iduser = $id) as love_status
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0 and iduser = $id) as dislike_status
		from post a join user f on a.iduser = f.id ";
		if(!empty($lastid)){
			$sql.=" WHERE idpost < $lastid AND ";
		} else {
			$sql.= "  WHERE ";
		}
		$hot  = $this->get_most_comment_post($id);
		$like = $this->get_most_like_post($id,$hot->idpost);			
		$sql.= " (a.idpost <> $hot->idpost AND a.idpost <> $like->idpost)";
		$sql.="  GROUP BY a.idpost Order By a.idpost DESC LIMIT $lim";
		$res = $this->db->query($sql);
		$r=$res->result();		
		if(empty($lastid)) array_unshift($r,$hot,$like);
		$res->free_result();
		return $r;
	}
		
	function cekpost($user,$group){
		$res = $this->db->query("SELECT * FROM post a join user b on a.iduser = b.id WHERE idpost=$group AND username='$user'");
		$r = $res->num_rows();
		$res->free_result();
		return $r;
	}
	
	function get_most_like_post($user,$id){
		$sql = "SELECT a.*,f.idgroups,f.username,f.name as name_user, f.picture as picture_user
		,(SELECT count(*) from comment b where a.idpost = b.idpost) as total_coment
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1) as total_love
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0) as total_dislike
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost) as total_bookmark		
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost and iduser = $user) as bookmark_status
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1 and iduser = $user) as love_status
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0 and iduser = $user) as dislike_status
		from post a join user f on a.iduser = f.id  WHERE idpost<>$id GROUP BY a.idpost ORDER BY total_love DESC, dateadd DESC ";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}
	
	function get_most_comment_post($id){
		$sql = "SELECT a.*,f.idgroups,f.username,f.name as name_user, f.picture as picture_user
		,(SELECT count(*) from comment b where a.idpost = b.idpost) as total_coment
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1) as total_love
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0) as total_dislike
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost) as total_bookmark		
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost and iduser = $id) as bookmark_status
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1 and iduser = $id) as love_status
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0 and iduser = $id) as dislike_status
		from post a join user f on a.iduser = f.id GROUP BY a.idpost ORDER BY total_coment DESC, dateadd DESC";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}
	
	function del($group){
		return  $this->db->query("DELETE  FROM post WHERE idpost=$group");		
	}

	function detail($id){		
		if(empty($lim)) $lim = 5;
		$sql = "SELECT a.*,f.username,f.name,(SELECT count(*) from comment b where a.idpost = b.idpost) as total_coment
		,(SELECT count(*) from love c where a.idpost = c.idpost and status=1) as total_love
		,(SELECT count(*) from love d where a.idpost = d.idpost and status=0) as total_dislike
		,(SELECT count(*) from bookmark e where a.idpost = e.idpost) as total_bookmark
		from post a join user f on a.iduser = f.id WHERE a.idpost='$id'";		
		$sql.="  GROUP BY a.idpost";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}
	
	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
