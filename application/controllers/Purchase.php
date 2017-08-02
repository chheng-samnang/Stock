<?php
class Purchase extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Purchase';
		$this->page_redirect="Purchase";								
		$this->load->model("Purchase_m");
		$this->load->model("Product_m");
		$this->load->model("Supplyer_m");
	}
	public function index($pro_id="")
	{				
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add/{$pro_id}",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Purchase Quantity","Purchase Price in USD","Purchase Price in Riel","Purchase Price out USD","Purchase Price out Riel","Purchase Date","User create","Date create","User update","Date update");		
		
		if($pro_id!=""){$data["product"]=$this->Product_m->index($pro_id);}//the type of product		
		$row=$this->Purchase_m->index($pro_id);		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(										
										$value->pch_qty,
										$value->pch_price_in_usd,
										$value->pch_price_in_riel,
										$value->pch_price_out_usd,
										$value->pch_price_out_riel,
										date("d-m-Y h:i:s a",strtotime($value->pch_hdr_date)),																																					
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->pch_id
									);
			$i=$i+1;
		endforeach;
		}	
		if(!empty($this->session->flashdata('msg'))){$data['msg']=$this->message->success_msg($this->session->flashdata('msg'));}																		
		$this->load->view('purchase_v',$data);
		$this->load->view('template/footer');
	}
	public function validation()
	{		
		$this->form_validation->set_rules('ddlSupplyerName','Supplyer Name','trim|required');
		$this->form_validation->set_rules('txtPchQty','Purhcase Quantity','trim|required|numeric');
		$this->form_validation->set_rules('txtPchPriceInUSD','Purhcase Price In USD','trim|numeric');
		$this->form_validation->set_rules('txtPchPriceInRiel','Purhcase Price In Riel','trim|numeric');
		$this->form_validation->set_rules('txtPchPriceOutUSD','Purhcase Price Our USD','trim|numeric');
		$this->form_validation->set_rules('txtPchPriceOutRiel','Purhcase Price Out Riel','trim|numeric');		
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add($pro_id="")
	{					
		$data['supplyer']=$this->Supplyer_m->index();
		if($pro_id!=''){$data['pro_id']=$pro_id;}else{$data['pro_id']="";}								
		$data['action'] = "{$this->page_redirect}/add_value";
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->page_redirect."/index/"."{$pro_id}";				
		$this->load->view('template/header');
		$this->load->view('template/left');
		$this->load->view('purchase_add',$data);
		$this->load->view('template/footer');		
	}
	public function add_value()
	{	
		if(isset($_POST["btnSubmit"]))
		{			
			if($this->validation()==TRUE)
			{																													             
                if($this->Purchase_m->add()==TRUE)
                {	       
                	$this->session->set_flashdata('msg','Save successfully !');       	
					redirect("{$this->page_redirect}/index/{$this->input->post('txtProId')}");
					exit;	
                }	                                																			
			}
			else
			{				
				$this->add($this->input->post('txtProId'));
			}		
		}
	}
	public function edit($pch_id="")
	{			
		if($pch_id!="")
		{				
			$row=$this->Supplyer_m->index();					
			if($row==TRUE)
			{
			$option1[NULL]	=	"Choose One";
			foreach($row as $value):						
				$option1[$value->per_id]=$value->per_name;								
			endforeach;
			}
			else{$option1[NULL]=NULL;}
			$option= array('1'=>'Enable','0'=>'Disable');
			$row=$this->Purchase_m->get_edit($pch_id);				
			if($row==TRUE)
			{									
				$data['ctrl'] = $this->createCtrl($row,$pro_id1=$row->pro_id,$option,$option1);			
				$data['action'] = "{$this->page_redirect}/edit_value/{$pch_id}";
				$data['pageHeader'] = $this->pageHeader;
				$data['cancel'] = $this->page_redirect."/index/"."{$pro_id1}";						
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
				$row=$this->Purchase_m->edit($id);	
				if($row==TRUE)
	            {		            	
	            	$this->session->set_flashdata('msg','Change successfully !');                		                						
					redirect("{$this->page_redirect}/index/{$this->input->post('txtProId')}");
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
			$row=$this->Purchase_m->delete($id);
			redirect("{$this->page_redirect}/index/{$id}");
			exit;
		}		
		else{return FALSE;}
	}
	public function createCtrl($row="",$pro_id1="",$option="",$option1="")
		{	
			if($row!="")
			{		
				$row1=$row->per_id;
				$row2=$row->pch_qty;
				$row3=$row->pch_price_in_usd;
				$row4=$row->pch_price_in_riel;
				$row5=$row->pch_price_out_usd;
				$row6=$row->pch_price_out_riel;
				$row7=$row->pch_status;
				$row8=$row->pch_valid;
				$row9=$row->pch_expire;					
				$row10=$row->pch_desc;																												
			}											
			//$ctrl = array();
			$ctrl = array(		
							array(
								'type'=>'hidden',
								'name'=>'txtProId',
								'id'=>'txtProId',									
								'value'=>$pro_id1==""?"" : $pro_id1,																																					
							),
							//hidden textbox the pro_id												
							array(
									'type'=>'dropdown',
									'name'=>'ddlSupplyerName',
									'option'=>$option1,
									'selected'=>$row==""? set_value("ddlSupplyerName") : $row1,
									'class'=>'class="form-control"',
									'label'=>'Supplyer name'
								),							
							array(
								'type'=>'text',
								'name'=>'txtPchQty',
								'id'=>'txtPchQty',									
								'value'=>$row==""? set_value("txtPchQty") : $row2,					
								'placeholder'=>'Enter Purchase Quantity',									
								'class'=>'form-control',
								'label'=>'Purchase Quantity'																								
							),
							array(
								'type'=>'text',
								'name'=>'txtPchPriceInUSD',
								'id'=>'txtPchPriceInUSD',									
								'value'=>$row==""? set_value("txtPchPriceInUSD") : $row3,					
								'placeholder'=>'Enter Purchase Price in USD',									
								'class'=>'form-control',
								'label'=>'Purchase Price in USD',
								$row3==NULL?'disabled':NULL=>''																								
							),
							array(
								'type'=>'text',
								'name'=>'txtPchPriceInRiel',
								'id'=>'txtPchPriceInRiel',									
								'value'=>$row==""? set_value("txtPchPriceInRiel") : $row4,					
								'placeholder'=>'Enter Purchase Price in Riel',									
								'class'=>'form-control',
								'label'=>'Purchase Price in Riel',
								$row4==NULL?'disabled':NULL=>''																								
							),
							array(
								'type'=>'text',
								'name'=>'txtPchPriceOutUSD',
								'id'=>'txtPchPriceOutUSD',									
								'value'=>$row==""? set_value("txtPchPriceOutUSD") : $row5,					
								'placeholder'=>'Enter Purchase Price out USD',									
								'class'=>'form-control',
								'label'=>'Purchase Price out USD',
								$row5==NULL?'disabled':NULL=>''																								
							),
							array(
								'type'=>'text',
								'name'=>'txtPchPriceOutRiel',
								'id'=>'txtPchPriceOutRiel',									
								'value'=>$row==""? set_value("txtPchPriceOutRiel") : $row6,					
								'placeholder'=>'Enter Purchase Price out Riel',									
								'class'=>'form-control',
								'label'=>'Purchase Price out Riel',
								$row6==NULL?'disabled':NULL=>''
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
									'type'=>'text',
									'name'=>'txtValid',
									'id'=>'txtValid',
									'value'=>$row==""? set_value("txtValid") : $row8,
									'placeholder'=>'Enter Valid Date',																																																			
									'class'=>'form-control datetimepicker',
									'label'=>'Valid Date',									
								),														
								array(
									'type'=>'text',
									'name'=>'txtExpire',
									'id'=>'txtExpire',
									'value'=>$row==""? set_value("txtExpire") : $row9,
									'placeholder'=>'Enter Expire Date',																																																			
									'class'=>'form-control datetimepicker',
									'label'=>'Expire Date',									
								),
							array(
								'type'=>'textarea',
								'name'=>'txtDesc',
								'value'=>$row==""? set_value("txtDesc") : $row10,
								'label'=>'Description'
								),																											
							);
			return $ctrl;
		}
}
?>