<?php
class Purchase_m extends CI_Model
{			
	var $userCrea;		
	public function __construct()
	{
		parent::__construct();
		$this->userCrea = isset($this->session->userLogin)?$this->session->userLogin:"N/A";				
	}
	public function index($id="")
	{
		if($id!="")
		{
			$query=$this->db->query
			("
				SELECT pro_name,pro_image,hdr.pch_hdr_date,hdr.user_crea,hdr.date_crea,hdr.user_updt,hdr.date_updt,pch.*
				FROM tbl_purchase_det AS pch 
				INNER JOIN tbl_product AS pro ON pch.pro_id=pro.pro_id
				INNER JOIN tbl_purchase_hdr AS hdr ON pch.pch_id=hdr.pch_id
				WHERE pch.pro_id='{$id}' AND pch_type='i'
				ORDER BY pch.pch_det_id DESC
			");
			if($query->num_rows()>0){return $query->result();}			
		}		
	}
	public function get_edit($id='')
	{
		if($id!="")
		{
			$query=$this->db->query
			("
				SELECT pro_name,pro_image,hdr.*,pch.*
				FROM tbl_purchase_det AS pch 
				INNER JOIN tbl_product AS pro ON pch.pro_id=pro.pro_id
				INNER JOIN tbl_purchase_hdr AS hdr ON pch.pch_id=hdr.pch_id
				WHERE pch.pch_id='{$id}'				
			");
			if($query->num_rows()>0){return $query->row();}			
		}
	}
	public function add()
	{
		$data= array(						
						"per_id" => $this->input->post("ddlSupplyerName"),
						"pch_type" =>'i',
						"pch_desc" =>$this->input->post("txtDesc"),
						"pch_status" => $this->input->post("ddlStatus"),						
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_purchase_hdr",$data);		
		if($query)
		{
			$this->db->select_max('pch_id');
			$query = $this->db->get('tbl_purchase_hdr');					
			$row=$query->row();
			$data= array(						
						"pch_id" => $row->pch_id,
						"pro_id" =>$this->input->post("txtProId"),
						"pch_qty" =>$this->input->post("txtPchQty"),
						"pch_price_in_usd" =>$this->input->post("txtPchPriceInUSD"),
						"pch_price_in_riel" =>$this->input->post("txtPchPriceInRiel"),
						"pch_price_out_usd" =>$this->input->post("txtPchPriceOutUSD"),
						"pch_price_out_riel" =>$this->input->post("txtPchPriceOutRiel"),
						"pch_valid" =>$this->input->post("txtValid"),
						"pch_expire" => $this->input->post("txtExpire"),										
						 );
			$query=$this->db->insert("tbl_purchase_det",$data);
			if($query){return TRUE;}
		}
	}
	public function edit($id="")
	{
		if($id==TRUE)
		{						
			$data= array(						
						"per_id" => $this->input->post("ddlSupplyerName"),						
						"pch_desc" =>$this->input->post("txtDesc"),
						"pch_status" => $this->input->post("ddlStatus"),						
						"user_updt" => $this->userCrea,
						"date_updt" => date('Y-m-d')
						 );
			$this->db->where("pch_id",$id);
			$query=$this->db->update("tbl_purchase_hdr",$data);
			if($query)
			{
				$data= array(																		
						"pch_qty" =>$this->input->post("txtPchQty"),
						"pch_price_in_usd" =>$this->input->post("txtPchPriceInUSD"),
						"pch_price_in_riel" =>$this->input->post("txtPchPriceInRiel"),
						"pch_price_out_usd" =>$this->input->post("txtPchPriceOutUSD"),
						"pch_price_out_riel" =>$this->input->post("txtPchPriceOutRiel"),
						"pch_valid" =>$this->input->post("txtValid"),
						"pch_expire" => $this->input->post("txtExpire"),										
						 );
			$query=$this->db->where("pch_id",$id);
			$query=$this->db->update("tbl_purchase_det",$data);
			if($query){return TRUE;}
			}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{						
			$this->db->where("pch_id",$id);
			$query=$this->db->delete("tbl_purchase_det");
			$this->db->where("pch_id",$id);
			$query=$this->db->delete("tbl_purchase_hdr");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>