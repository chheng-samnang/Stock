<?php
class Staff extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Staff';
		$this->page_redirect="Staff";								
		$this->load->model("Staff_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Photo","Staff name","Email","Phone","Gender","Address","Status","Description","User create","Date create","User update","Date update");		
		$row=$this->Staff_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(	
										"<img class='img-thumbnail' src='".base_url("assets/uploads/".$value->staff_photo)."' style='width:70px;' />",									
										$value->staff_name,
										$value->staff_email,																			
										$value->staff_phone,
										$value->staff_gender=='m'?'Male':'Female',										
										$value->staff_address,
										$value->staff_status==1?'Enable':'Disable',
										$value->staff_desc,																			
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->staff_id
									);
			$i=$i+1;
		endforeach;
		}	
		if(!empty($this->session->flashdata('msg'))){$data['msg']=$this->message->success_msg($this->session->flashdata('msg'));}																		
		$this->load->view('page_view',$data);
		$this->load->view('template/footer');
	}
	public function validation()
	{		
		$this->form_validation->set_rules('txtName','Staff Name','trim|required');
		$this->form_validation->set_rules('txtPhone','Phone','trim|required|numeric');
		$this->form_validation->set_rules('txtEmail','Email','trim|valid_email');
		$this->form_validation->set_rules('ddlGender','Gender','trim|required');
		$this->form_validation->set_rules('txtAddress','Address','trim');
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{	
		$option= array('1'=>'Enable','0'=>'Disable');			
		$option1= array(''=>'Choose one','m'=>'Male','f'=>'Female');
		$data['ctrl'] = $this->createCtrl($row="",$option,$option1);		
		$data['action'] = "{$this->page_redirect}/add_value";
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->page_redirect;
		$this->load->view('template/header');
		$this->load->view('template/left');
		$this->load->view('page_add',$data);
		$this->load->view('template/footer');		
	}
	public function add_value()
	{
		if(isset($_POST["btnSubmit"]))
		{			
			if($this->validation()==TRUE)
				{																													             
	                if($this->Staff_m->add()==TRUE)
	                {	       
	                	$this->session->set_flashdata('msg','Save successfully !');       	
						redirect("{$this->page_redirect}/");
						exit;	
	                }	                                																			
				}
			else{$this->add();}		
		}
	}
	public function edit($id="")
	{		
		if($id!="")
		{		
			$row=$this->Staff_m->index($id);				
			if($row==TRUE)
			{	
				$option= array('1'=>'Enable','0'=>'Disable');
				$option1= array(''=>'Choose one','m'=>'Male','f'=>'Female');
				$data['ctrl'] = $this->createCtrl($row,$option,$option1);			
				$data['action'] = "{$this->page_redirect}/edit_value/{$id}";
				$data['pageHeader'] = $this->pageHeader;		
				$data['cancel'] = $this->page_redirect;
				$this->load->view('template/header');
				$this->load->view('template/left');
				$this->load->view("page_edit",$data);
				$this->load->view('template/footer');
			}
		}
		else{return FALSE;}
	}
	public function edit_value($id="")
	{		
		if(isset($_POST["btnSubmit"]))
		{						
			if($this->validation()==TRUE)
			{	
				$row=$this->Staff_m->edit($id);	
				if($row==TRUE)
	            {	
	            	$this->session->set_flashdata('msg','Change successfully !');                		                	
					redirect("{$this->page_redirect}/");
					exit;	
	            }																												 																				            	                	                                												
			}
			else 
			{	
				$this->edit($id);													
			}			
		}
	}	

	public function delete($id="")
	{
		if($id!="")
		{
			$row=$this->Staff_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");exit;}
		}
		else{return FALSE;}
	}
	public function createCtrl($row="",$option="",$option1)
		{	
			if($row!="")
			{		
					$row1=$row->staff_name;
					$row2=$row->staff_email;
					$row3=$row->staff_phone;
					$row4=$row->staff_gender;
					$row5=$row->staff_address;
					$row6=$row->staff_photo;
					$row7=$row->staff_status;
					$row8=$row->staff_desc;																																	
			}											
			//$ctrl = array();
			$ctrl = array(							
							array(
									'type'=>'text',
									'name'=>'txtName',
									'id'=>'txtName',									
									'value'=>$row==""? set_value("txtName") : $row1,					
									'placeholder'=>'Enter Staff name',									
									'class'=>'form-control',
									'label'=>'Staff name'																								
								),
							array(
									'type'=>'text',
									'name'=>'txtEmail',
									'id'=>'txtEmail',									
									'value'=>$row==""? set_value("txtEmail") : $row2,					
									'placeholder'=>'Enter Email',									
									'class'=>'form-control',
									'label'=>'Email'																								
								),
								array(
									'type'=>'text',
									'name'=>'txtPhone',
									'id'=>'txtPhone',									
									'value'=>$row==""? set_value("txtPhone") : $row3,					
									'placeholder'=>'Enter Phone',									
									'class'=>'form-control',
									'label'=>'Phone'																								
								),
								array(
									'type'=>'dropdown',
									'name'=>'ddlGender',
									'option'=>$option1,
									'selected'=>$row==""? set_value("ddlGender") : $row4,
									'class'=>'class="form-control"',
									'label'=>'Gender'
								),
								array(
									'type'=>'text',
									'name'=>'txtAddress',
									'id'=>'txtAddress',									
									'value'=>$row==""? set_value("txtAddress") : $row5,					
									'placeholder'=>'Enter Address',									
									'class'=>'form-control',
									'label'=>'Address'																								
								),								
								array(
									'type'=>'dropdown',
									'name'=>'ddlStatus',
									'option'=>$option,
									'selected'=>$row==""? set_value("ddlStatus") : $row7,
									'class'=>'class="form-control"',
									'label'=>'Status'
								),
								array(
									'type'=>'upload',
									'name'=>'txtUpload',
									'id'=>'txtUpload',
									'value'=>$row==""? set_value("txtUpload") : $row6,																		
									'class'=>'form-control',
									'label'=>'Chose Image',
									"img"=>$row==""? set_value("txtUpload") :"<img class='img-thumbnail' src='".base_url("assets/uploads/".$row6)."' style='width:70px;' />",										
								),														
							array(
									'type'=>'textarea',
									'name'=>'txtDesc',
									'value'=>$row==""? set_value("txtDesc") : $row8,
									'label'=>'Description'
								),
							);
			return $ctrl;
		}
}
?>