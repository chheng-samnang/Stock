<?php
class Expense_m extends CI_Model
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
			$this->db->order_by('exp_id', 'DESC');
			$query=$this->db->get("tbl_expense");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$this->db->where("exp_id",$id);
			$query=$this->db->get("tbl_expense");
			if($query->num_rows()>0){return $query->row();}
		}
	}
	public function add()
	{
		$data= array(						
						"exp_type" => $this->input->post("txtExpType"),
						"exp_amount_usd" => $this->input->post("txtAmountUSD"),
						"exp_amount_riel" => $this->input->post("txtAmountRiel"),
						"exp_desc" => $this->input->post("txtDesc"),						
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_expense",$data);		
		if($query==TURE){return TRUE;}
	}
	public function edit($id)
	{
		if($id==TRUE)
		{			
			
			$data= array(					
					"exp_type" => $this->input->post("txtExpType"),
					"exp_amount_usd" => $this->input->post("txtAmountUSD"),
					"exp_amount_riel" => $this->input->post("txtAmountRiel"),
					"exp_desc" => $this->input->post("txtDesc"),						
					"user_updt" => $this->userCrea,
					"date_updt" => date('Y-m-d')
					 );				
			$this->db->where("exp_id",$id);
			$query=$this->db->update("tbl_expense",$data);
			if($query==TRUE){return TURE;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{						
			$this->db->where("exp_id",$id);
			$query=$this->db->delete("tbl_expense");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>