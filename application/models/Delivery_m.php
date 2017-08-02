<?php
class Delivery_m extends CI_Model
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
			$query=$this->db->query("SELECT del.*,per_name FROM tbl_delivery AS del INNER JOIN tbl_person AS per ON del.per_id=per.per_id ORDER BY del.del_id");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$query=$this->db->query("SELECT del.*,per_name FROM tbl_delivery AS del INNER JOIN tbl_person AS per ON del.per_id=per.per_id WHERE del_id='{$id}'");
			if($query->num_rows()>0){return $query->row();}
		}
	}	
	public function add()
	{					
		$data= array(		
						"per_id" => $this->input->post("ddlCustomerName"),				
						"del_status" => $this->input->post("ddlStatus"),
						"del_addr1" => $this->input->post("txtAddr1"),																	
						"del_desc" => $this->input->post("txtDesc"),					
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
					);
		$query=$this->db->insert("tbl_delivery",$data);		
		if($query==TURE){return TRUE;}
	}
	public function edit($id)
	{
		if($id==TRUE)
		{			
			
			$data= array(					
					"per_id" => $this->input->post("ddlCustomerName"),				
					"del_status" => $this->input->post("ddlStatus"),
					"del_addr1" => $this->input->post("txtAddr1"),										
					"del_desc" => $this->input->post("txtDesc"),						
					"user_updt" => $this->userCrea,
					"date_updt" => date('Y-m-d')
					 );				
			$this->db->where("del_id",$id);
			$query=$this->db->update("tbl_delivery",$data);
			if($query==TRUE){return TURE;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{						
			$this->db->where("del_id",$id);
			$query=$this->db->delete("tbl_delivery");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>