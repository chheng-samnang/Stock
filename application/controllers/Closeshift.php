<?php
class Closeshift extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Closeshift';
		$this->page_redirect="Closeshift";								
		$this->load->model("Closeshift_m");				
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		//$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Cashier","Exch rate","Cash($)","Cash(R)","Exch($)","Exch(R)","OpenBal($)","OpenBal(R)","EndBal($)","EndBal(R)","Total($)","Total(R)","Date");		
		$row=$this->Closeshift_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(										
										$value->user_name,
										"R ".number_format($value->exchange_rate),																			
										"$".number_format($value->cash_usd,2),																			
										"R ".number_format($value->cash_riel),
										'$'.number_format($value->exchange_usd,2),
										'R '.number_format($value->exchange_riel),
										'$'.number_format($value->open_bal_usd,2),
										'R '.number_format($value->open_bal_riel),										
										'$'.number_format($value->ending_bal_usd,2),
										'R '.number_format($value->ending_bal_riel),
										'$'.number_format(
															($value->open_bal_usd + ($value->cash_usd - $value->exchange_usd)) + 
															(($value->open_bal_riel + ($value->cash_riel - $value->exchange_riel)) / $value->exchange_rate)
														,2),
										'R '.number_format(
															(($value->open_bal_usd + ($value->cash_usd - $value->exchange_usd)) * $value->exchange_rate) +
															($value->open_bal_riel + ($value->cash_riel - $value->exchange_riel))
															),
										date("d-m-Y H:i:s a",strtotime($value->clsft_date)),																																																																					
									);
			$i=$i+1;
		endforeach;
		}			
		$this->load->view('close_shift_report',$data);
		$this->load->view('template/footer');
	}				
}
?>