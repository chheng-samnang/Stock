<?php
class Product extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Product';
		$this->page_redirect="Product";								
		$this->load->model("Product_m");
		$this->load->model("Category_m");
		$this->load->model("Supplyer_m");
		$this->load->model("Exchangerate_m","ex");		
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Image","Category name","Product name","Status","User create","Date create","User update","Date update");		
		$row=$this->Product_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(	
										"<a href=".base_url($this->page_redirect.'/Productdetail/'.$value->pro_id)." title='User Detail'><img class='img-thumbnail' src='".base_url("assets/uploads/".$value->pro_image)."' style='width:70px;' /></a>",																
										$value->cat_name,
										$value->pro_name,										
										$value->pro_status==1?'Enable':'Disable',																																																																																		
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->pro_id
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
		$this->form_validation->set_rules('ddlCategoryName','Category Name','trim|required');
		$this->form_validation->set_rules('txtProductName','Product Name','trim|required');
		$this->form_validation->set_rules('ddlSupplyerName','Supplyer Name','trim|required');
		$this->form_validation->set_rules('txtPchQty','Purchase Quantity','trim|required|numeric');											
		$this->form_validation->set_rules('txtPchPriceInUSD','Purchase Price in USD','trim|numeric');
		$this->form_validation->set_rules('txtPchPriceInRiel','Purchase Price in Riel','trim|numeric');
		$this->form_validation->set_rules('txtPchPriceOutUSD','Purchase Price out USD','trim|numeric');
		$this->form_validation->set_rules('txtPchPriceOutRiel','Purchase Price out Riel','trim|numeric');
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}
	public function validation1()
	{				
		$this->form_validation->set_rules('ddlCategoryName','Category Name','trim|required');
		$this->form_validation->set_rules('txtProductName','Product Name','trim|required');		
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{	
		$data['exchange_rate']=$this->ex->use_exchange_rate();									
		$data['category']=$this->Category_m->index();					
		$data['customer']=$this->Supplyer_m->index();						
		$data['action'] = "{$this->page_redirect}/add_value";
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->page_redirect;
		$this->load->view('template/header');
		$this->load->view('template/left');
		$this->load->view('product_add',$data);
		$this->load->view('template/footer');		
	}
	public function add_value()
	{
		if(isset($_POST["btnSubmit"]))
		{			
			if($this->validation()==TRUE)
				{																													             
	                if($this->Product_m->add()==TRUE)
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
						
		$data['category']=$this->Category_m->index();							
		$row=$this->Product_m->index($id);				
		if($row==TRUE)
		{				
			$data['product']=$row;				
			$data['action'] = "{$this->page_redirect}/edit_value/{$id}";
			$data['pageHeader'] = $this->pageHeader;		
			$data['cancel'] = $this->page_redirect;
			$this->load->view('template/header');
			$this->load->view('template/left');
			$this->load->view("product_edit",$data);
			$this->load->view('template/footer');
		}		
		else{return FALSE;}
	}
	public function edit_value($id="")
	{		
		if(isset($_POST["btnSubmit"]))
		{						
			if($this->validation1()==TRUE)
			{	
				$row=$this->Product_m->edit($id);	
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
			$row=$this->Product_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");exit;}
		}
		else{return FALSE;}
	}	
}
?>