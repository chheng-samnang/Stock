<?php
class Staff_m extends CI_Model
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
			$this->db->order_by('staff_id', 'DESC');
			$query=$this->db->get("tbl_staff");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$this->db->where("staff_id",$id);
			$query=$this->db->get("tbl_staff");
			if($query->num_rows()>0){return $query->row();}
		}
	}
	public function add()
	{
		$data= array(							
						"staff_name" => $this->input->post("txtName"),
						"staff_email" => $this->input->post("txtEmail"),
						"staff_phone" => $this->input->post("txtPhone"),
						"staff_gender" => $this->input->post("ddlGender"),						
						"staff_address" => $this->input->post("txtAddress"),
						"staff_photo" => $this->input->post("txtUpload"),
						"staff_status" => $this->input->post("ddlStatus"),
						"staff_desc" => $this->input->post("txtDesc"),						
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_staff",$data);		
		if($query==TURE){return TRUE;}
	}
	public function edit($id)
	{		
		if($id==TRUE)
		{
			if(!empty($this->input->post('txtUpload')))
			{		
				$row=$this->index($id);			
				unlink("assets/uploads/".$row->slide_path);	
				$data=array(
								"staff_name" => $this->input->post("txtName"),
								"staff_email" => $this->input->post("txtEmail"),
								"staff_phone" => $this->input->post("txtPhone"),
								"staff_gender" => $this->input->post("ddlGender"),						
								"staff_address" => $this->input->post("txtAddress"),
								"staff_photo" =>!empty($this->input->post('txtUpload'))?$this->input->post('txtUpload'):"",							
								"staff_status" => $this->input->post("ddlStatus"),
								"staff_desc" => $this->input->post("txtDesc"),												
								"user_updt"=>$this->userCrea,
								"date_updt"=>date("Y-m-d")
							);
			}
			else
			{
				$data=array(
							"staff_name" => $this->input->post("txtName"),
							"staff_email" => $this->input->post("txtEmail"),
							"staff_phone" => $this->input->post("txtPhone"),
							"staff_gender" => $this->input->post("ddlGender"),						
							"staff_address" => $this->input->post("txtAddress"),							
							"staff_status" => $this->input->post("ddlStatus"),
							"staff_desc" => $this->input->post("txtDesc"),
							"user_updt"=>$this->userCrea,
							"date_updt"=>date("Y-m-d")
							);
			}	
			$this->db->where("staff_id",$id);
			$query=$this->db->update("tbl_staff",$data);
			if($query==TRUE){return $query;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{	
			$row=$this->index($id);			
			unlink("assets/uploads/".$row->staff_photo);					
			$this->db->where("staff_id",$id);
			$query=$this->db->delete("tbl_staff");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>