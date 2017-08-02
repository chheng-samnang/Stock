<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permission
{	
	public function __construct()
	{				
		$CI = & get_instance();				
		if(isset($CI->session->userType))
		{
			$this->check_page('add',$CI->session->userType);
			$this->check_page('edit',$CI->session->userType);
			$this->check_page('delete',$CI->session->userType);
		}		
	}
	public function check_page($page='',$type='')
	{
		for($i=0;$i<4;$i++)
			{
				if($this->get_data($i,'type')==$type)
				{					
					if(strpos(current_url(),$page)==TRUE)
					{
						if($this->get_data($i,$page)==0)
						{													
							redirect(base_url('Permissionmsg'));														
						}
					}					
				}				
			}			
	}
	public function get_data($index='',$type='')
	{
		return $this->data()[$index][$type];	
	}
	public function data()
	{
		return array(
						array('type'=>'Administrator','select'=>1,'add'=>1,'edit'=>1,'delete'=>1),
						array('type'=>'Editor','select'=>1,'add'=>0,'edit'=>1,'delete'=>0),
						array('type'=>'Inputer','select'=>1,'add'=>1,'edit'=>0,'delete'=>0),
						array('type'=>'Seller','select'=>0,'add'=>0,'edit'=>0,'delete'=>0)
					);		
	}
	public function seller()
	{
		$CI = & get_instance();		
		if(isset($CI->session->userType))
		{
			if($CI->session->userType!='Seller' && $CI->session->userType!='Administrator'){redirect(base_url('Permissionmsg'));}	
		}		
	}
}