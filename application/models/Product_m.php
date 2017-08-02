<?php
class Product_m extends CI_Model
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
			$query=$this->db->query("SELECT pro.*,cat_name FROM tbl_product AS pro INNER JOIN tbl_category AS cat ON pro.cat_id=cat.cat_id ORDER BY pro.pro_id");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$query=$this->db->query("SELECT pro.*,cat_name FROM tbl_product AS pro INNER JOIN tbl_category AS cat ON pro.cat_id=cat.cat_id WHERE pro.pro_id='{$id}'");
			if($query->num_rows()>0){return $query->row();}
		}
	}	
	public function add()
	{					
		$data= array(		
						"cat_id" => $this->input->post("ddlCategoryName"),
						"pro_name" => $this->input->post("txtProductName"),
						"pro_image" => $this->input->post("txtImgName"),
						"pro_status" => $this->input->post("ddlProStatus"),
						"pro_desc" => $this->input->post("txtProDesc"),									
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
					);
		$query=$this->db->insert("tbl_product",$data);						
		if($query)
		{								
			$data= array(		
						"per_id" => $this->input->post("ddlSupplyerName"),
						"pch_type" => 'i',
						"pch_status" => $this->input->post("ddlPchStatus"),
						"pch_desc" => $this->input->post("txtPchDesc"),
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
					);
			$query=$this->db->insert("tbl_purchase_hdr",$data);
			if($query)
			{
				$this->db->select_max('pro_id');
				$query = $this->db->get('tbl_product');					
				$row=$query->row();
				//purchase header
				$this->db->select_max('pch_id');
				$query1 = $this->db->get('tbl_purchase_hdr');					
				$row1=$query1->row();
				$data= array(		
						"pch_id" => $row1->pch_id,
						"pro_id" => $row->pro_id,						
						"pch_qty" => $this->input->post("txtPchQty"),						
						"pch_price_in_usd" => $this->input->post("txtPchPriceInUSD"),
						"pch_price_in_riel" => $this->input->post("txtPchPriceInRiel"),
						"pch_price_out_usd" => $this->input->post("txtPchPriceOutUSD"),
						"pch_price_out_riel" => $this->input->post("txtPchPriceOutRiel"),
						"pch_valid" => $this->input->post("txtValid"),
						"pch_expire" => $this->input->post("txtExpire"),												
					);
				$query=$this->db->insert("tbl_purchase_det",$data);
				if($query){return TRUE;}	
			}

		}
	}
	public function edit($id)
	{		
		if($id==TRUE)
		{
			if(!empty($this->input->post('txtImgName')))
			{		
				$row=$this->index($id);			
				unlink("assets/uploads/".$row->slide_path);	
				$data=array(
								"cat_id" => $this->input->post("ddlCategoryName"),
								"pro_name" => $this->input->post("txtProductName"),
								"pro_image" =>!empty($this->input->post('txtImgName'))?$this->input->post('txtImgName'):"",														
								"pro_status" => $this->input->post("ddlProStatus"),
								"pro_desc" => $this->input->post("txtProDesc"),																	
								"user_updt"=>$this->userCrea,
								"date_updt"=>date("Y-m-d")
							);
			}
			else
			{
				$data=array(
								"cat_id" => $this->input->post("ddlCategoryName"),
								"pro_name" => $this->input->post("txtProductName"),
								//"pro_image" =>!empty($this->input->post('txtImgName'))?$this->input->post('txtImgName'):"",														
								"pro_status" => $this->input->post("ddlProStatus"),
								"pro_desc" => $this->input->post("txtProDesc"),																	
								"user_updt"=>$this->userCrea,
								"date_updt"=>date("Y-m-d")
							);
			}	
			$this->db->where("pro_id",$id);
			$query=$this->db->update("tbl_product",$data);
			if($query==TRUE){return $query;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{	
			$row=$this->index($id);			
			unlink("assets/uploads/".$row->pro_image);					
			$this->db->where("pro_id",$id);
			$query=$this->db->delete("tbl_product");
			if($query)
			{
				$this->db->where("pro_id",$id);
				$query=$this->db->delete("tbl_purchase_det");
				if($query){return TRUE;}
			}
		}
	}
	
}
?>