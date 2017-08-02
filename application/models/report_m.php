<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_m extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }
  public function exchange()
  {
    $query = $this->db->query("SELECT key_code FROM tbl_sysdata WHERE key_type='exrate' ORDER BY key_id DESC LIMIT 1");
    return $query->row();
  }
  public function get_receipt($date_f="",$date_t="",$key_word="")
  {
    if($date_f=="" && $date_t=="")
    {
      $key_word = trim($key_word);
      if($key_word==""){$query = $this->db->query("SELECT * FROM tbl_receipt");}
      else{$query = $this->db->query("SELECT * FROM tbl_receipt WHERE rec_no like '%".$key_word."%' OR user_crea like '%".$key_word."%'");}
      if($query->num_rows()>0){return $query->result();}
      else { return array();}
    }       
    else
    {
      $date_f1=$date_f." "."00:00:00";
      $date_t1=$date_t." "."00:00:00";
      if($key_word==""){$query = $this->db->query("SELECT * FROM tbl_receipt where rec_date  between '$date_f1' and '$date_t1'");}   
      else
      {
          $query = $this->db->query("SELECT * FROM tbl_receipt WHERE rec_no like '%".$key_word."%' OR user_crea like '%".$key_word."%' and rec_date  between '$date_f1' and '$date_t1'");
      }
      if($query->num_rows()>0){return $query->result();}
      else{return array();}                    
    }
  }
  public function get_invoice()
  {
      $query = $this->db->query("SELECT distinct inv_no,inv_hdr_id FROM tbl_invoice_hdr ORDER BY inv_no");
      if($query->num_rows()>0){
        return $query->result();
      }else {
        return array();
      }
  }
  public function get_inv_hdr_id($inv_no="")
  {
    $this->db->where('inv_no',$inv_no);
    $query=$this->db->get('tbl_invoice_hdr');
    if($query){return $query->row();}
  }  
}
