<?php
class Customer extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Customer';
		$this->page_redirect="Customer";								
		$this->load->model("Customer_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Customer name","Email","Phone","Address","Status","Description","User create","Date create","User update","Date update");		
		$row=$this->Customer_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(										
										$value->per_name,
										$value->per_email,																			
										$value->per_phone,										
										$value->per_address,
										$value->per_status==1?'Enable':'Disable',
										$value->per_desc,																			
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->per_id
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
		$this->form_validation->set_rules('txtCustomerName','Customer Name','trim|required');
		$this->form_validation->set_rules('txtPhone','Phone','trim|required|numeric');
		$this->form_validation->set_rules('txtEmail','Email','trim|valid_email');
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{				
		$option= array('1'=>'Enable','0'=>'Disable');
		$data['ctrl'] = $this->createCtrl($row="",$option);		
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
	                if($this->Customer_m->add()==TRUE)
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
			$row=$this->Customer_m->index($id);				
			if($row==TRUE)
			{	
				$option= array('1'=>'Enable','0'=>'Disable');
				$data['ctrl'] = $this->createCtrl($row,$option);			
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
				$row=$this->Customer_m->edit($id);	
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
			$row=$this->Customer_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");exit;}
		}
		else{return FALSE;}
	}
	public function createCtrl($row="",$option="")
		{	
			if($row!="")
			{		
					$row1=$row->per_name;
					$row2=$row->per_email;
					$row3=$row->per_phone;
					$row4=$row->per_address;
					$row5=$row->per_status;
					$row6=$row->per_desc;																																	
			}											
			//$ctrl = array();
			$ctrl = array(							
							array(
									'type'=>'text',
									'name'=>'txtCustomerName',
									'id'=>'txtCustomerName',									
									'value'=>$row==""? set_value("txtCustomerName") : $row1,					
									'placeholder'=>'Enter Customer name',									
									'class'=>'form-control',
									'label'=>'Customer name'																								
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
									'type'=>'text',
									'name'=>'txtAddress',
									'id'=>'txtAddress',									
									'value'=>$row==""? set_value("txtAddress") : $row4,					
									'placeholder'=>'Enter Address',									
									'class'=>'form-control',
									'label'=>'Address'																								
								),
								array(
									'type'=>'dropdown',
									'name'=>'ddlStatus',
									'option'=>$option,
									'selected'=>$row==""? set_value("ddlStatus") : $row5,
									'class'=>'class="form-control"',
									'label'=>'Status'
								),														
							array(
									'type'=>'textarea',
									'name'=>'txtDesc',
									'value'=>$row==""? set_value("txtDesc") : $row6,
									'label'=>'Description'
								),
							);
			return $ctrl;
		}
}
?>