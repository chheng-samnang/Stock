<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Riels
{
	public function __construct(){}
	public function riel($value="")
	{
		if($value!="")
		{
			$n = substr($value,-2);
			(int)$n;
			if($n!=00)
			{				
				echo (100 - $n) + $value;
			}
			else{return $value;}			
		}
	}
}