<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class POS_m extends CI_Model
{
  var $userCrea;
  function __construct()
  {
    parent::__construct();
    $this->userCrea = isset($this->session->userLogin)?$this->session->userLogin:"N/A";
  }
  public function get_product($cat_id="")
  {
    if($cat_id=="")
    {
      $query = $this->db->get("tbl_product");
      if($query->num_rows()>0)
      {
        return $query->result();
      }else {
        return array();
      }
    }else {
      $query = $this->db->get_where("tbl_menu",array("cat_id"=>$cat_id));
      if($query->num_rows()>0)
      {
        return $query->result();
      }else {
        return array();
      }
    }
  }
  public function get_invoice($inv_id="")
  {
    if($inv_id=="")
    {
      $query = $this->db->get_where("tbl_invoice_hdr",array("inv_hdr_status"=>1));
      if($query->num_rows()>0)
      {
        return $query->result();
      }else {
        return array();
      }
    }   
  }  
  public function get_last_invoice_hdr()
  {
    $this->db->select_max('inv_hdr_id');
    $query = $this->db->get('tbl_invoice_hdr');         
    if($query->num_rows()>0)return $query->row();
  }
  public function get_last_purchase_hdr()
  {
    $this->db->select_max('pch_id');
    $query = $this->db->get('tbl_purchase_hdr');         
    if($query->num_rows()>0)return $query->row();
  }
  public function generateInvID()
  {
    $query = $this->db->query("SELECT IFNULL(MAX(inv_no),0) AS inv_no FROM tbl_invoice_hdr");
    if($query->num_rows()>0 && $query->row()->inv_no!="0")
    {
      $InvPrefix1 = substr($query->row()->inv_no,0,6);
      $InvPrefix2 = date("ymd");
      if($InvPrefix1!==$InvPrefix2)
      {
        return $tmp = $InvPrefix2."-0001";
      }
      else {
        $tmp = intVal(substr($query->row()->inv_no,strlen($query->row()->inv_no)-4,4));
        $num = str_pad($tmp+1,4,"0",STR_PAD_LEFT);
        return $result = date("ymd")."-".$num;
      }

    }
    else {

      return date("ymd")."-"."0001";
    }
  }
  public function generateReceiptID()
  {
    $query = $this->db->query("SELECT IFNULL(MAX(rec_no),0) AS inv_id FROM tbl_receipt");
    if($query->num_rows()>0 && $query->row()->inv_id!="0")
    {
      $InvPrefix1 = substr($query->row()->inv_id,0,6);
      $InvPrefix2 = date("ymd");
      if($InvPrefix1!==$InvPrefix2)
      {
        return $tmp = $InvPrefix2."-0001";
      }else {
        $tmp = intVal(substr($query->row()->inv_id,strlen($query->row()->inv_id)-4,4));
        $num = str_pad($tmp+1,4,"0",STR_PAD_LEFT);
        return $result = date("ymd")."-".$num;
      }

    }else {
      return date("ymd")."-"."0001";
    }
  } 
  public function checkout($json)
  {                                                               
      $data = array(                                        
                    "per_id"  => $this->input->post('cust'),
                    "inv_no"  =>  $this->input->post("inv_num"),
                    "inv_hdr_status" => 1,
                    "credit"  => 0,
                    "user_crea"  =>  $this->userCrea,
                    "date_crea"  =>  date("Y-m-d")
                    );
    $query=$this->db->insert("tbl_invoice_hdr",$data);    
    if($query)
    {
      // insert to purchase hdr....while befor insert into tbl_invoice
      $inv_hdr_id=$this->get_last_invoice_hdr()->inv_hdr_id;
      $data = array(
                    'pch_type' => 'o',  
                    "pch_status"  => 1,                    
                    "inv_hdr_id"  => $inv_hdr_id,                                                                 
                    "user_crea"  =>  $this->userCrea,  
                    "date_crea"  => date("Y-m-d")
                    );
          $this->db->insert("tbl_purchase_hdr",$data);
      //start to insert to invoice
      
      foreach ($json as $key => $value)
      {        
        $data = array(
                      "inv_hdr_id"  =>  $inv_hdr_id,
                      "pro_id"  =>  $value[0],                    
                      "price_usd"  =>  $value[2]!='' ? $value[2] : $value[3] / $this->exchange(),
                      "price_riel"  =>  $value[3]!=''?$value[3] : $this->riels->riel($value[2] * $this->exchange()),
                      "qty"  =>  $value[4],                      
                    );
        $query=$this->db->insert("tbl_invoice_detail",$data);
        //inserto purhase details
        $pch_hdr_id=$this->get_last_purchase_hdr()->pch_id;
        $data = array(                      
                      "pch_id"  =>  $pch_hdr_id,
                      "pro_id"  => $value[0],                      
                      "pch_qty"  => $value[4]*(-1)                     
                      );
          $this->db->insert("tbl_purchase_det",$data);
      }
      if($query){return TRUE;}

    }
    else{return FALSE;}             
  }

  public function get_invoice_hdr($status="")
  {
    if($status=="")
    {

      $query=$this->db->query("SELECT hdr.*,cus.per_name FROM tbl_invoice_hdr AS hdr       
                        INNER JOIN tbl_person AS cus ON hdr.per_id=cus.per_id                   
                        WHERE inv_hdr_status=1 AND cus.per_type='customer'    
                        ORDER BY hdr.inv_hdr_id DESC");            
      if($query->num_rows()>0)
      {
        return $query->result();
      }else {
        return array();
      }
    }
    else {
      $query=$this->db->query("SELECT hdr.*,cus.per_name FROM tbl_invoice_hdr AS hdr       
                        INNER JOIN tbl_person AS cus ON hdr.per_id=cus.per_id                   
                        WHERE inv_hdr_status=1 AND cus.per_type='customer'    
                        ORDER BY hdr.inv_hdr_id DESC");            
      if($query->num_rows()>0)
      {
        return $query->result();
      }else {
        return array();
      }
    }
  }  
  public function get_product_by_invID($invID="")
  {
    if($invID!="")
    {
      $query = $this->db->query("SELECT det.*,pro.pro_name FROM tbl_invoice_detail AS det             
      INNER JOIN tbl_product AS pro ON det.pro_id=pro.pro_id
      WHERE inv_hdr_id='{$invID}' ORDER BY inv_det_id;
      ");         
      if($query->num_rows()>0)
      {
        return $query->result();
      }else {
        return array();
      }
    }
  }  
  public function InsertReceipt($inv_id)
  {        
     $recNo = $this->generateReceiptID();              
      $data = array(
        "rec_no"=>$recNo,
        "inv_hdr_id"=>$inv_id,
        "user_id"=>$this->session->userID,
        "ttl_usd"=>$this->input->post('txtGrandTtlUsd'),       
        "ttl_riel"=>$this->input->post('txtGrandTtlRiel'),
        "cash_usd"=>$this->input->post('txtCashInUsd'),
        "cash_riel"=>$this->input->post('txtCashInRiel'),
        "exchange_usd"=>$this->input->post('exUsd'),
        "exchange_riel"=>$this->input->post('exRiel'),
        "ex_rate"=>$this->exchange(),
        "rec_status"=>1,                       
        "user_crea"=>$this->userCrea,
        "date_crea"=>date('Y-m-d')
        );
      $query=$this->db->insert("tbl_receipt" ,$data);
      if($query)
      {
          $data = array("credit"  => 1,"inv_hdr_status" => 2);
          $this->db->where("inv_hdr_id",$inv_id);
          $query=$this->db->update("tbl_invoice_hdr",$data);
          if($query==TRUE){return TRUE;}
      }                      
  }
  public function exchange()
  {
    $query = $this->db->query("SELECT key_code FROM tbl_sysdata WHERE key_type='exrate' ORDER BY key_id DESC LIMIT 1");
    if($query->num_rows()>0){return $query->row()->key_code;}
    else{return 4000;}    
  }
  public function update_invoice($data)
  {
    if(!empty($data))
    {       
        $invID = $data["ddlInvoice"];
        //update status of invoice hdr
        $arr = array("inv_hdr_status"  =>  1);
        $this->db->where('inv_hdr_id',$invID);                                                          
        $query=$this->db->update("tbl_invoice_hdr",$arr);

        $this->db->where("inv_hdr_id",$invID);
        $this->db->delete("tbl_invoice_detail");
        //select purchase hdr id to delete at purchase detail follow by invID
        $query=$this->db->query("SELECT pch_id FROM tbl_purchase_hdr WHERE inv_hdr_id='{$invID}'");
        if($query->num_rows()>0)
        {
          $pch_id=$query->row()->pch_id;
          $this->db->where("pch_id",$pch_id);
          $this->db->delete("tbl_purchase_det");
        }

        $i = 0;
        $n = (count($data)-3)/4;        
        for($i=0;$i<$n;$i++)
        {
          $arr = array(
                        "inv_hdr_id"  =>  $invID,
                        "pro_id"  =>  $data["txtProID$i"],
                        "qty"  =>  $data["txtQty$i"],
                        "price_usd"  =>  $data["txtPriceUSD$i"],
                        "price_riel"  => $data["txtPriceRiel$i"]
          );
          $query=$this->db->insert("tbl_invoice_detail",$arr);
          //insert into purchase too.
          $arr = array(
                        "pch_id"  =>  $pch_id,
                        "pro_id"  =>  $data["txtProID$i"],
                        "pch_qty"  =>  $data["txtQty$i"]*(-1)                        
          );
          $query=$this->db->insert("tbl_purchase_det",$arr);
        }       
        if($query){return TRUE;}        
    }
  }
  public function get_delivery($id='')
  {
    if($id=='')
    {
      $query=$this->db->query("
        SELECT per_name,del_addr1,inv_no,staff_name,del_tr_date,tr.user_crea,tr.date_crea,tr.user_updt,tr.date_updt,tr.del_tr_id,tr.status FROM tbl_delivery_transaction AS tr
        INNER JOIN tbl_delivery AS del ON tr.del_id=del.del_id
        INNER JOIN tbl_person AS per ON del.per_id=per.per_id
        INNER JOIN tbl_invoice_hdr AS hdr ON tr.inv_hdr_id=hdr.inv_hdr_id
        INNER JOIN tbl_staff AS st ON tr.staff_id=st.staff_id
        ORDER BY tr.del_tr_id DESC
        ");
      if($query->num_rows()>0){return $query->result();}
    }
    else
    {
      $query=$this->db->query("SELECT * FROM tbl_delivery_transaction WHERE del_tr_id='{$id}'");              
      if($query->num_rows()>0){return $query->row();}
    }
  }
  public function get_delivery_customer()
  {
    $query=$this->db->query("
       SELECT CONCAT(per.per_name,' address=',del.del_addr1) AS customer,del.del_id 
       FROM tbl_person AS per INNER JOIN tbl_delivery AS del ON per.per_id=del.per_id
        ");
      if($query->num_rows()>0){return $query->result();}
  }
  public function get_invoice_number()
  {
    $query=$this->db->query("SELECT * FROM tbl_invoice_hdr WHERE inv_hdr_status=1 OR inv_hdr_status=2 ORDER BY inv_hdr_date DESC");               
      if($query->num_rows()>0){return $query->result();}
  }
  public function staff()
  {
    $query=$this->db->query("SELECT * FROM tbl_staff WHERE staff_status=1");               
      if($query->num_rows()>0){return $query->result();}
  }
  public function add_delivery()
  {
     $data= array(
                  "del_id"  => $this->input->post('ddlCustomName'),
                  "inv_hdr_id"  => $this->input->post('ddlInvoiceNo'),
                  "staff_id"  => $this->input->post('ddlStaffName'),
                  "status"  => $this->input->post('ddlStatus'),
                  "user_crea"  =>  $this->userCrea,  
                  "date_crea"  => date("Y-m-d")
          );
      $query=$this->db->insert("tbl_delivery_transaction",$data);
      if($query){return TRUE;}
  }
  public function edit_delivery($id='')
  {    
    if($id!='')
    {
        $data= array(
                    "del_id"  => $this->input->post('ddlCustomName'),
                    "inv_hdr_id"  => $this->input->post('ddlInvoiceNo'),
                    "staff_id"  => $this->input->post('ddlStaffName'),
                    "status"  => $this->input->post('ddlStatus'),
                    "user_updt"  =>  $this->userCrea,  
                    "date_updt"  => date("Y-m-d")
            );
       $this->db->where("del_tr_id",$id);
        $query=$this->db->update("tbl_delivery_transaction",$data);
        if($query){return TRUE;}
    }     
  }
  public function delete_delivery($id='')
  {
    if($id!='')
    {
      $this->db->where('del_tr_id',$id);
      $query=$this->db->delete('tbl_delivery_transaction');
      if($query){return TRUE;}
    }
  }
  public function get_balance()
  {
      $query=$this->db->query
      ("
        SELECT bal.open_bal_usd,bal.open_bal_riel,bal.exchange_rate,
        SUM(rec.ttl_usd) AS total_usd,
        SUM(rec.ttl_riel) AS total_riel,
        SUM(rec.cash_usd) AS cash_usd,
        SUM(rec.cash_riel) AS cash_riel,
        SUM(rec.exchange_usd) AS ex_usd,
        SUM(rec.exchange_riel) AS ex_riel
        FROM tbl_receipt AS rec
        INNER JOIN tbl_balance AS bal ON rec.user_id=bal.user_id
        WHERE (clsft_status=1 AND bal_status=1) AND rec.user_id='{$this->session->userID}'
      ");
      if(
          ($query->num_rows()>0)
          && ($query->row()->total_usd!=NULL 
          || $query->row()->total_riel!=NULL 
          || $query->row()->cash_usd!=NULL 
          || $query->row()->cash_riel!=NULL 
          || $query->row()->ex_usd!=NULL 
          || $query->row()->ex_riel!=NULL)
        ){return $query->row();}
  }
  public function add_closeshift()
  {
    $row=$this->get_balance();
    if($row)
    {
      $data= array(
                  "user_id"  => $this->session->userID,
                  "ttl_usd" => $row->total_usd,
                  "ttl_riel" => $row->total_riel,
                  "cash_usd"  => $row->cash_usd,
                  "cash_riel"  => $row->cash_riel,
                  "exchange_usd"  => $row->ex_usd,
                  "exchange_riel"  => $row->ex_riel,
                  "open_bal_usd"  => $row->open_bal_usd,
                  "open_bal_riel"  => $row->open_bal_riel,
                  "ending_bal_usd"  => $row->open_bal_usd + $row->total_usd,
                  "ending_bal_riel"  => $this->riels->riel($row->open_bal_riel + $row->total_riel),
                  "exchange_rate" => $row->exchange_rate                                    
            );
      $query=$this->db->insert("tbl_closeshift",$data);
      if($query)
      {
          $data= array("clsft_status"  => 0);
          $this->db->where('user_id',$this->session->userID);
          $this->db->update('tbl_receipt',$data);                  
      }
      if($query)
      {
          $data= array("bal_status"  => 0);
          $this->db->where('user_id',$this->session->userID);
          $this->db->update('tbl_balance',$data);                  
      }
      if($query){return TRUE;}
    }    
  }
}
