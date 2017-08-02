<?php
class Closeshift_m extends CI_Model
{			
	var $userCrea;		
	public function __construct()
	{
		parent::__construct();
		$this->userCrea = isset($this->session->userLogin)?$this->session->userLogin:"N/A";				
	}
	public function index()
	{
		$query=$this->db->query("SELECT clsft.*,user_name FROM tbl_closeshift AS clsft INNER JOIN tbl_user AS user ON clsft.user_id=user.user_id ORDER BY clsft.clsft_id DESC");
			if($query->num_rows()>0){return $query->result();}				
	}	
}
?>