<?php
class Balance_m extends CI_Model
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
			$query=$this->db->query("SELECT bal.*,user_name FROM tbl_balance AS bal INNER JOIN tbl_user AS user ON bal.user_id=user.user_id ORDER BY bal.bal_id");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$query=$this->db->query("SELECT bal.*,user_name FROM tbl_balance AS bal INNER JOIN tbl_user AS user ON bal.user_id=user.user_id WHERE bal_id='{$id}'");
			if($query->num_rows()>0){return $query->row();}
		}
	}
	public function exchange_rate()
	{
		$query=$this->db->query("SELECT key_code FROM tbl_sysdata WHERE key_type='exrate' ORDER BY key_id DESC LIMIT 1");
		if($query->num_rows()>0){return $query->row();}
	}
	public function get_user()
	{		
		$query=$this->db->query("SELECT user_id,user_code,user_name,CONCAT('code:',user_code,' ',user_name) AS user_name1 FROM tbl_user WHERE user_status=1");
		if($query->num_rows()>0){return $query->result();}
	}
	public function add()
	{
		$row=$this->exchange_rate();		
		if($row){ $rate=$row->key_code;}else{$rate=4000;}			
		$data= array(		
						"user_id" => $this->input->post("ddlCashierName"),				
						"open_bal_usd" => $this->input->post("txtBalUSD"),
						"open_bal_riel" => $this->input->post("txtBalRiel"),
						"exchange_rate" =>$rate,
						"open_bal_desc" => $this->input->post("txtDesc"),						
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_balance",$data);		
		if($query==TURE){return TRUE;}
	}
	public function edit($id)
	{
		if($id==TRUE)
		{			
			
			$data= array(					
					"user_id" => $this->input->post("ddlCashierName"),				
					"open_bal_usd" => $this->input->post("txtBalUSD"),
					"open_bal_riel" => $this->input->post("txtBalRiel"),					
					"open_bal_desc" => $this->input->post("txtDesc"),						
					"user_updt" => $this->userCrea,
					"date_updt" => date('Y-m-d')
					 );				
			$this->db->where("bal_id",$id);
			$query=$this->db->update("tbl_balance",$data);
			if($query==TRUE){return TURE;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{						
			$this->db->where("bal_id",$id);
			$query=$this->db->delete("tbl_balance");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>