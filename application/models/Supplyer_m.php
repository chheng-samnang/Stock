<?php
class Supplyer_m extends CI_Model
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
			$this->db->where('per_type', 'supplyer');
			$this->db->order_by('per_id', 'DESC');
			$query=$this->db->get("tbl_person");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$this->db->where("per_id",$id);
			$query=$this->db->get("tbl_person");
			if($query->num_rows()>0){return $query->row();}
		}
	}
	public function add()
	{
		$data= array(	
						"per_type" => 'supplyer',
						"per_name" => $this->input->post("txtSupplyerName"),
						"per_email" => $this->input->post("txtEmail"),
						"per_phone" => $this->input->post("txtPhone"),
						"per_address" => $this->input->post("txtAddress"),
						"per_status" => $this->input->post("ddlStatus"),
						"per_desc" => $this->input->post("txtDesc"),						
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_person",$data);		
		if($query==TURE){return TRUE;}
	}
	public function edit($id)
	{
		if($id==TRUE)
		{			
			
			$data= array(															
					"per_email" => $this->input->post("txtEmail"),
					"per_phone" => $this->input->post("txtPhone"),
					"per_address" => $this->input->post("txtAddress"),
					"per_status" => $this->input->post("ddlStatus"),
					"per_desc" => $this->input->post("txtDesc"),						
					"user_updt" => $this->userCrea,
					"date_updt" => date('Y-m-d')
					 );				
			$this->db->where("per_id",$id);
			$query=$this->db->update("tbl_person",$data);
			if($query==TRUE){return TURE;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{						
			$this->db->where("per_id",$id);
			$query=$this->db->delete("tbl_person");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>