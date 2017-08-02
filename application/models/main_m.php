<?php
	class Main_m extends CI_Model
	{
		
		function __construct()
		{
			parent::__construct();			
		}

		function get_menu_count_by_category()
		{
			$query = $this->db->query("SELECT cat_name AS name,(100/(SELECT SUM(qty) FROM tbl_invoice_detail d 
				INNER JOIN tbl_invoice_hdr h ON d.`inv_hdr_id`=h.`inv_hdr_id` WHERE date_crea = SUBSTRING(NOW(),1,10)))*SUM(qty) AS y FROM tbl_invoice_detail d INNER JOIN tbl_product pro ON d.`pro_id`=pro.`pro_id` INNER JOIN tbl_invoice_hdr h ON h.inv_hdr_id=d.`inv_hdr_id` INNER JOIN tbl_receipt rec on h.inv_hdr_id=rec.inv_hdr_id INNER JOIN tbl_category c ON pro.cat_id=c.cat_id WHERE h.`date_crea`=SUBSTRING(NOW(),1,10) AND rec_status=1 GROUP BY pro.`cat_id`,h.`date_crea`");
			return $query;
		}
		public function get_stock_remaining()
		{
			$query = $this->db->query("SELECT pro_name as label,SUM(pch_qty) as y FROM tbl_purchase_det AS pch 
				INNER JOIN tbl_product AS pro ON pch.pro_id=pro.pro_id
				INNER JOIN tbl_purchase_hdr AS hdr ON pch.pch_id=hdr.pch_id 
				WHERE pch_status=1 GROUP BY pro.pro_id");
			if($query==TRUE){return $query->result();}			
		}
		public function get_product_sale()
		{
			$from = $this->input->post('txtFrom');
			$to = $this->input->post('txtTo');
			if($from!='' && $to!='')
			{				
				$query = $this->db->query("SELECT pro_name AS label,SUM(qty) AS y 
					FROM tbl_product AS pro INNER JOIN tbl_invoice_detail AS det ON pro.pro_id=det.pro_id 
					INNER JOIN tbl_invoice_hdr AS hdr ON det.inv_hdr_id=hdr.inv_hdr_id
					INNER JOIN tbl_receipt AS rec ON hdr.inv_hdr_id=rec.inv_hdr_id 
					WHERE (hdr.date_crea BETWEEN '{$from}' AND '{$to}') AND rec_status=1
					GROUP BY pro.pro_id");
			}
			else
			{
				$date=date('Y-m-d');
				$query = $this->db->query("SELECT pro_name AS label,SUM(qty) AS y FROM tbl_product AS pro 
					INNER JOIN tbl_invoice_detail AS det ON pro.pro_id=det.pro_id 
					INNER JOIN tbl_invoice_hdr AS hdr ON det.inv_hdr_id=hdr.inv_hdr_id
					INNER JOIN tbl_receipt AS rec ON hdr.inv_hdr_id=rec.inv_hdr_id 
					WHERE hdr.date_crea='{$date}' AND rec_status=1 
					GROUP BY pro.pro_id");				
			}
			if($query==TRUE){return $query->result();}						
		}
		public function get_total()
		{
			$from = $this->input->post('txtFrom');
			$to = $this->input->post('txtTo');
			if($from!='' && $to!='')
			{				
				$query = $this->db->query("SELECT SUM(ttl_usd) AS total_usd,SUM(ttl_riel) AS total_riel,SUM(cash_usd) AS cash_usd1,SUM(cash_riel) AS cash_riel1,SUM(exchange_usd) AS exchange_usd1,SUM(exchange_riel) AS exchange_riel1, ex_rate FROM tbl_receipt WHERE (date_crea BETWEEN '{$from}' AND '{$to}') AND rec_status=1");
			}
			else
			{
				$date=date('Y-m-d');
				$query = $this->db->query("SELECT SUM(ttl_usd) AS total_usd,SUM(ttl_riel) AS total_riel,SUM(cash_usd) AS cash_usd1,SUM(cash_riel) AS cash_riel1,SUM(exchange_usd) AS exchange_usd1,SUM(exchange_riel) AS exchange_riel1, ex_rate FROM tbl_receipt WHERE date_crea='{$date}'  AND rec_status=1");
			}			
			if($query==TRUE){return $query->row();}			
		}

		function get_opening_balance()
		{
			$query = $this->db->query("SELECT open_bal_usd + (open_bal_riel/exchange_rate) AS opening_balance FROM tbl_balance WHERE date_crea=SUBSTRING(NOW(),1,10) and user_id='".$this->session->userLogin."'");
			if($query->num_rows()>0)
			{
				return $query;
			}else
			{				
				return $query;
			}
		}
		function get_ending_balance()
		{
			$query = $this->db->query("SELECT IFNULL(SUM(ttl_usd),0) AS ending_balance FROM tbl_receipt WHERE date_crea=SUBSTRING(NOW(),1,10)");
			if($query->num_rows()>0)
			{
				return $query->row();
			}else
			{
				return $query;
			}
		}

		function get_expense()
		{
			$query = $this->db->query("SELECT IFNULL(SUM(key_data2)+SUM(key_desc)/(SELECT key_data FROM tbl_sysdata WHERE key_type='exrate' ORDER BY key_code DESC LIMIT 1),0) AS expense FROM tbl_sysdata WHERE key_type='expense' AND date_crea=SUBSTRING(NOW(),1,10)");
			if($query->num_rows()>0)
			{
				return $query->row();
			}else
			{
				return 0;
			}
		}
	}
?>