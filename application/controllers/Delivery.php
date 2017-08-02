<?php
class Delivery extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Delivery';
		$this->page_redirect="Delivery";								
		$this->load->model("Delivery_m");
		$this->load->model("Customer_m");		
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Customer name","Status","Address","Description","User create","Date create","User update","Date update");		
		$row=$this->Delivery_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(										
										$value->per_name,
										$value->del_status==1?'Enable':'Disable',																			
										$value->del_addr1,
																																																														
										$value->del_desc,																																																					
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->del_id
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
		$this->form_validation->set_rules('ddlCustomerName','Customer Name','trim|required');							
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{			
		$row=$this->Customer_m->index();					
		if($row==TRUE)
		{
		$option[NULL]	=	"Choose One";
		foreach($row as $value):						
			$option[$value->per_id]=$value->per_name;								
		endforeach;
		}
		else{$option[NULL]=NULL;}
		$option1= array('1'=>'Enable','0'=>'Disable');			
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
	                if($this->Delivery_m->add()==TRUE)
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
		$row=$this->Customer_m->index();					
		if($row==TRUE)
		{
		$option[NULL]	=	"Choose One";
		foreach($row as $value):						
			$option[$value->per_id]=$value->per_name;								
		endforeach;
		}
		else{$option[NULL]=NULL;}
		//get the balance info
		$option1= array('1'=>'Enable','0'=>'Disable');
		$row=$this->Delivery_m->index($id);				
		if($row==TRUE)
		{					
			$data['ctrl'] = $this->createCtrl($row,$option,$option1);			
			$data['action'] = "{$this->page_redirect}/edit_value/{$id}";
			$data['pageHeader'] = $this->pageHeader;		
			$data['cancel'] = $this->page_redirect;
			$this->load->view('template/header');
			$this->load->view('template/left');
			$this->load->view("page_edit",$data);
			$this->load->view('template/footer');
		}		
		else{return FALSE;}
	}
	public function edit_value($id="")
	{		
		if(isset($_POST["btnSubmit"]))
		{						
			if($this->validation()==TRUE)
			{	
				$row=$this->Delivery_m->edit($id);	
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
			$row=$this->Delivery_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");exit;}
		}
		else{return FALSE;}
	}
	public function createCtrl($row="",$option="",$option1="")
		{	
			if($row!="")
			{		
				$row1=$row->per_id;
				$row2=$row->del_status;
				$row3=$row->del_addr1;
				
				$row5=$row->del_desc;				
			}											
			//$ctrl = array();
			$ctrl = array(	
							array(
									'type'=>'dropdown',
									'name'=>'ddlCustomerName',
									'option'=>$option,
									'selected'=>$row==""? set_value("ddlCustomerName") : $row1,
									'class'=>'class="form-control"',
									'label'=>'Customer name'
								),
							array(
									'type'=>'dropdown',
									'name'=>'ddlStatus',
									'option'=>$option1,
									'selected'=>$row==""? set_value("ddlStatus") : $row2,
									'class'=>'class="form-control"',
									'label'=>'Status'
								),
							array(
								'type'=>'text',
								'name'=>'txtAddr1',
								'id'=>'txtAddr1',									
								'value'=>$row==""? set_value("txtAddr1") : $row3,					
								'placeholder'=>'Enter Address1',									
								'class'=>'form-control',
								'label'=>'Address1'																								
							),							
							array(
								'type'=>'textarea',
								'name'=>'txtDesc',
								'value'=>$row==""? set_value("txtDesc") : $row5,
								'label'=>'Description'
							),																											
						);
			return $ctrl;
		}
}
?>