<?php
class Balance extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Balance';
		$this->page_redirect="Balance";								
		$this->load->model("Balance_m");			
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Cashier","OpenBal($)","OpenBal(R)","Status","ExchRate","Description","User create","Date create","User update","Date update");		
		$row=$this->Balance_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(										
										$value->user_name,
										'$'.number_format($value->open_bal_usd,2),																			
										'R '.number_format($value->open_bal_riel),
										$value->bal_status==1 ? 'Active' : 'Inactive',										
										'R '.number_format($value->exchange_rate),
										$value->open_bal_desc,																																							
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->bal_id
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
		$this->form_validation->set_rules('ddlCashierName','Cashier Name','trim|required');
		$this->form_validation->set_rules('txtBalUSD','Open Balance USD','trim|required|numeric');
		$this->form_validation->set_rules('txtBalRiel','Open Balance Riel','trim|numeric');		
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{			
		$row=$this->Balance_m->get_user();					
		if($row==TRUE)
		{
		$option[NULL]	=	"Choose One";
		foreach($row as $value):						
			$option[$value->user_id]=$value->user_name1;								
		endforeach;
		}
		else{$option[NULL]=NULL;}			
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
	                if($this->Balance_m->add()==TRUE)
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
			$row=$this->Balance_m->get_user();					
			if($row==TRUE)
			{
			$option[NULL]	=	"Choose One";
			foreach($row as $value):						
				$option[$value->user_id]=$value->user_name1;								
			endforeach;
			}
			else{$option[NULL]=NULL;}
			//get the balance info
			$row=$this->Balance_m->index($id);				
			if($row==TRUE)
			{					
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
				$row=$this->Balance_m->edit($id);	
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
			$row=$this->Balance_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");exit;}
		}
		else{return FALSE;}
	}
	public function createCtrl($row="",$option="")
		{	
			if($row!="")
			{		
				$row1=$row->user_id;
				$row2=$row->open_bal_usd;
				$row3=$row->open_bal_riel;																																											
				$row4=$row->open_bal_desc;
			}											
			//$ctrl = array();
			$ctrl = array(	
							array(
									'type'=>'dropdown',
									'name'=>'ddlCashierName',
									'option'=>$option,
									'selected'=>$row==""? set_value("ddlCashierName") : $row1,
									'class'=>'class="form-control"',
									'label'=>'Cashier name'
								),						
							array(
									'type'=>'text',
									'name'=>'txtBalUSD',
									'id'=>'txtBalUSD',									
									'value'=>$row==""? set_value("txtBalUSD") : $row2,					
									'placeholder'=>'Enter Open Balance USD',									
									'class'=>'form-control',
									'label'=>'Open Balance USD'																								
								),
								array(
									'type'=>'text',
									'name'=>'txtBalRiel',
									'id'=>'txtBalRiel',									
									'value'=>$row==""? set_value("txtBalRiel") : $row3,					
									'placeholder'=>'Enter Open Balance Riel',									
									'class'=>'form-control',
									'label'=>'Open Balance Riel'																								
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