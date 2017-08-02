<?php
class Exchangerate_m extends CI_Model
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
			$query=$this->db->where("key_type",'exrate');
			$this->db->order_by('key_id', 'DESC');
			$query=$this->db->get("tbl_sysdata");
			if($query->num_rows()>0){return $query->result();}						
		}
		else
		{
			$this->db->where("key_id",$id);
			$query=$this->db->get("tbl_sysdata");
			if($query->num_rows()>0){return $query->row();}
		}
	}
	public function use_exchange_rate()
	{
		$query = $this->db->query("SELECT key_code FROM tbl_sysdata WHERE key_type='exrate'");
		if($query->num_rows()>0){return $query->row()->key_code;}
		else{return 4000;}
	}
	public function add()
	{
		$data= array(	
						"key_type" => 'exrate',
						"key_code" => $this->input->post("txtRate"),						
						"key_desc" => $this->input->post("txtDesc"),						
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_sysdata",$data);		
		if($query==TURE){return TRUE;}
	}
	public function edit($id)
	{
		if($id==TRUE)
		{			
			
			$data= array(					
					"key_code" => $this->input->post("txtRate"),						
					"key_desc" => $this->input->post("txtDesc"),						
					"user_updt" => $this->userCrea,
					"date_updt" => date('Y-m-d')
					 );				
			$this->db->where("key_id",$id);			
			$query=$this->db->update("tbl_sysdata",$data);
			if($query==TRUE){return TURE;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{						
			$this->db->where("key_id",$id);
			$query=$this->db->delete("tbl_sysdata");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>