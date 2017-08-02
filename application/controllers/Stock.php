<?php
class Stock extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Stock';										
		$this->load->model("Stock_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;								
		$data["action_url"]=array(/*0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete","{$this->page_redirect}/change_password"*/4=>"Purchase/index");							
		$data["tbl_hdr"]=array("Image","Product name","Remaining Product");		
		$row=$this->Stock_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(
										"<img class='img-thumbnail' src='".base_url("assets/uploads/".$value->pro_image)."' style='width:70px;' />",										
										$value->pro_name,
										$value->qty,																														
										$value->pro_id
									);
			$i=$i+1;
		endforeach;
		}	
		if(!empty($this->session->flashdata('msg'))){$data['msg']=$this->message->success_msg($this->session->flashdata('msg'));}																		
		$this->load->view('page_view',$data);
		$this->load->view('template/footer');
	}		
}
?>