<?php
class Expense extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Expense';
		$this->page_redirect="Expense";								
		$this->load->model("Expense_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Expense Type","Expense Amount USD","Expense Amount Riel","Date","Description","User create","Date create","User update","Date update");		
		$row=$this->Expense_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(										
										$value->exp_type,																				
										'$'.number_format($value->exp_amount_usd,2),
										'R '.number_format($value->exp_amount_riel),
										date("d-m-Y h:i:s a",strtotime($value->exp_date)),																			
										$value->exp_desc,																				
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->exp_id
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
		$this->form_validation->set_rules('txtExpType','Expense Type','trim|required');
		$this->form_validation->set_rules('txtAmountUSD','Amount USD','trim|required|numeric');
		$this->form_validation->set_rules('txtAmountRiel','Amount Riel','trim|numeric');
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{				
		$data['ctrl'] = $this->createCtrl($row="");		
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
	                if($this->Expense_m->add()==TRUE)
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
			$row=$this->Expense_m->index($id);				
			if($row==TRUE)
			{	
				$data['ctrl'] = $this->createCtrl($row);			
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
				$row=$this->Expense_m->edit($id);	
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
			$row=$this->Expense_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");exit;}
		}
		else{return FALSE;}
	}
	public function createCtrl($row="")
		{	
			if($row!="")
			{		
					$row1=$row->exp_type;
					$row2=$row->exp_amount_usd;
					$row3=$row->exp_amount_riel;
					$row4=$row->exp_desc;																												
			}											
			//$ctrl = array();
			$ctrl = array(							
							array(
									'type'=>'text',
									'name'=>'txtExpType',
									'id'=>'txtExpType',									
									'value'=>$row==""? set_value("txtExpType") : $row1,					
									'placeholder'=>'Enter Expense Type',									
									'class'=>'form-control',
									'label'=>'Expense Type'																								
								),
							array(
									'type'=>'text',
									'name'=>'txtAmountUSD',
									'id'=>'txtAmountUSD',									
									'value'=>$row==""? set_value("txtAmountUSD") : $row2,					
									'placeholder'=>'Enter Amount USD',									
									'class'=>'form-control',
									'label'=>'Amount USD'																								
								),
								array(
									'type'=>'text',
									'name'=>'txtAmountRiel',
									'id'=>'txtAmount',									
									'value'=>$row==""? set_value("txtAmountRiel") : $row3,					
									'placeholder'=>'Enter Amount Riel',									
									'class'=>'form-control',
									'label'=>'Amount Riel'																								
								),														
							array(
									'type'=>'textarea',
									'name'=>'txtDesc',
									'value'=>$row==""? set_value("txtDesc") : $row4,
									'label'=>'Description'
								),
							);
			return $ctrl;
		}
}
?>