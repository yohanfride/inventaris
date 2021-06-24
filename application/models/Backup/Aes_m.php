<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/aes.php';
class aes_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();
		$this->aes = new AES('aa','WeCodeWithLove15', 128);
	}	
	
	function encrypt($text){
		$this->aes->setData($text);
		return $this->aes->encrypt();
	}
	
	function decrypt($text){
		$this->aes->setData($text);
		return $this->aes->decrypt();
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
