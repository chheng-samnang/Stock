<?php
class POS extends CI_Controller
{	
	public function __construct()
	{
		parent::__construct();	
		$this->load->helper('security');	
		$this->load->model("POS_m");
		$this->load->model("Category_m");
		$this->load->model("Customer_m");
		$this->load->model("Login_m");
		$this->permission->seller();			
	}
	public function index()
	{			
		$arr = array();
		$arr1 = array();		
		$data["invoice"] = $this->POS_m->get_invoice_hdr();
		foreach ($data["invoice"] as $key => $value)
		{
			$arr[] = $this->POS_m->get_product_by_invID($value->inv_hdr_id);
		}
		$data["product"] = $arr;
		$data["exchange"] = $this->POS_m->exchange();
		//POS
		$data['category']=$this->Category_m->index();
		$data['customer']=$this->Customer_m->index();
		$this->load->view('template/header');
		$this->load->view('template/left');	
		if(!empty($this->session->flashdata('msg'))){$data['msg']=$this->message->success_msg($this->session->flashdata('msg'));}																			
		$this->load->view('POS_v',$data);		
		$this->load->view('template/footer');
	}
	public function angular_inv_number()
	{
		echo $this->POS_m->generateInvID();
	}
	public function printReceipt($inv_id="")
	{
		if($inv_id=="")
		{
			$arr = array();			
			$data["exchange"] = $this->POS_m->exchange();
			$data["receipt"] = $this->POS_m->get_invoice_hdr(1);
			foreach ($data["receipt"] as $key => $value)
			{
				$arr[] = $this->POS_m->get_product_by_invID($value->inv_hdr_id);				
			}						
			$data["product_rec"] = $arr;								
			$this->load->view("template/header");
			$this->load->view("template/left");
			$this->load->view("print_receipt_v",$data);
			$this->load->view("template/footer");
		}
		else
		{			
			if($this->POS_m->InsertReceipt($inv_id)==TRUE)
			{
				$this->session->set_flashdata('msg','Print Receipt was successfully !');
				redirect(base_url()."POS");
				exit;
			}       
		}
	}	
	public function checkout()
	{													
		if($this->input->post('str')!='[]')
		{
			$jsonData = json_decode($this->input->post('str'));
			if($this->POS_m->checkout($jsonData))
			{
				$this->session->set_flashdata('msg','Checkout successfully !');
				redirect(base_url()."POS");
				exit;
			}
		}
		else
		{
			$data['require_msg']='Please choose the product !';
			$data['customer']=$this->Customer_m->index();
			$data['category']=$this->Category_m->index();
			$this->load->view('template/header');
			$this->load->view('template/left');																				
			$this->load->view('POS_v',$data);
			$this->load->view('template/footer');
		}										
	}		
	public function print_invoice()
	{								
		$this->session->set_flashdata('msg','Print invoice successfully !');
		redirect(base_url()."POS");
		exit;  			
	}
	public function updateInvoice()
	  {	    
	    $data['product_edit'] = $this->POS_m->get_product();
		$data['invoice_edit'] = $this->POS_m->get_invoice();
		$this->form_validation->set_rules('ddlInvoice','Invoice number','trim|required');					
	    if(isset($_POST["btnSubmit"]) && $this->form_validation->run()==TRUE)
	    {		    	  	    		    	
	        if($this->POS_m->update_invoice($_POST)==TRUE)
	        {
	          $this->session->set_flashdata('msg','Save change was successfully !');
	          redirect(base_url()."POS");
	          exit;
	        }        
	    }
	    else
	    {
	      $this->load->view("template/header");
	      $this->load->view("template/left");
	      $this->load->view("edit_invoice_v",$data);
	      $this->load->view("template/footer");
	    }
	  }			
	public function delivery_transaction()
	{
		$data['delivery']=$this->POS_m->get_delivery();
		$this->load->view('template/header');
		$this->load->view('template/left');					
		$this->load->view('delivery_transaction_v',$data);		
		$this->load->view('template/footer');
	}
	public function validation_delivery()
	{				
		$this->form_validation->set_rules('ddlCustomName','Customer Name','trim|required');
		$this->form_validation->set_rules('ddlInvoiceNo','Invoice number','trim|required');
		$this->form_validation->set_rules('ddlStaffName','Deliver name','trim|required');		
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}
	public function insert_del()
	{
		if($this->validation_delivery()==TRUE)
		{
			if($this->POS_m->add_delivery())
	  		{
	  			$this->session->set_flashdata('msg','Save Delivery Transaction successfully !');
	    		redirect(base_url()."POS");
	    		exit;
	  		}
		}
		else
		{
			$data['customer']=$this->POS_m->get_delivery_customer();
			$data['invoice']=$this->POS_m->get_invoice_number();
			$data['staff']=$this->POS_m->staff();
			$this->load->view('template/header');
			$this->load->view('template/left');					
			$this->load->view('delivery_transaction_add',$data);		
			$this->load->view('template/footer');
		}		
	}
	public function update_del($id='')
	{
		if($id!='')
		{
			if($this->validation_delivery()==TRUE)
			{
				if($this->POS_m->edit_delivery($id))
		  		{
		  			$this->session->set_flashdata('msg','Save Change Delivery Transaction successfully !');
		    		redirect(base_url()."POS");
		    		exit;
		  		}
			}
			else
			{
				$data['delivery']=$this->POS_m->get_delivery($id);
				$data['customer']=$this->POS_m->get_delivery_customer();
				$data['invoice']=$this->POS_m->get_invoice_number();
				$data['staff']=$this->POS_m->staff();
				$this->load->view('template/header');
				$this->load->view('template/left');					
				$this->load->view('delivery_transaction_edit',$data);		
				$this->load->view('template/footer');
			}
		}			
	}
	public function omit_del($id="")
	{
		if($id!="")
		{
			$row=$this->POS_m->delete_delivery($id);			
			if($row==TRUE)
			{
				$this->session->set_flashdata('msg','Delete Delivery Transaction successfully !');
				redirect(base_url()."POS");
				exit;
			}
		}
		else{return FALSE;}
	}
	public function confirm_user()
	{
		if($this->input->post('btnLogin'))
		{
			$this->form_validation->set_rules('txtUsername','Username','trim|required');
			$this->form_validation->set_rules('txtPassword','Password','trim|required');
			if($this->form_validation->run()==TRUE)
			{				
				if($this->session->userLogin == $this->input->post("txtUsername") && $this->session->userPassword == do_hash($this->input->post("txtPassword")))
				{	
					$this->session->log_success=TRUE;				
					$data['balance'] = $this->POS_m->get_balance();
					$this->load->view('template/header');
					$this->load->view('template/left');					
					$this->load->view('closeshift_v',$data);		
					$this->load->view('template/footer');	
				}
				else
				{
					$data['error_msg'] = "Incorect Username Password!";
					$this->load->view('template/header');
					$this->load->view('template/left');					
					$this->load->view('confirm_user_v',$data);		
					$this->load->view('template/footer');	
				}				
			}
			else
			{
				$this->load->view('template/header');
				$this->load->view('template/left');					
				$this->load->view('confirm_user_v');		
				$this->load->view('template/footer');
			}
		}
		else
		{
			$this->load->view('template/header');
			$this->load->view('template/left');					
			$this->load->view('confirm_user_v');		
			$this->load->view('template/footer');
		}		
						
	}
	public function insert_closeshift()
	{
		if($this->session->log_success)
		{
			$this->session->unset_userdata('log_success');					
			if($this->POS_m->add_closeshift()==TRUE)
			{
				$this->session->set_flashdata('msg','Print Closeshift report successfully !');
				redirect(base_url()."POS");
				exit;
			}			
		}	
		else
		{
			redirect(base_url().'POS/confirm_user');exit;
		}
	}	
}
?>