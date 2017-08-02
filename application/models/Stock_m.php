<?php
class Stock_m extends CI_Model
{			
	var $userCrea;		
	public function __construct()
	{
		parent::__construct();
		$this->userCrea = isset($this->session->userLogin)?$this->session->userLogin:"N/A";				
	}
	public function index($id="")
	{		
		if($id=="")
		{
			$query=$this->db->query("SELECT pch.*,pro.pro_name,pro.pro_image,SUM(pch_qty) AS qty
			FROM  tbl_product AS pro INNER JOIN tbl_purchase_det AS pch ON pro.pro_id=pch.pro_id GROUP BY pch.pro_id");
		return $query->result();
		}				
	}	
}
?>