<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("report_m","rm");
    //$this->permission->seller();
  }

  public function sale_report_daily()
  {
    $date_f = $this->input->post("txtDateF");
    $date_t = $this->input->post("txtDateT");
    $invID = $this->input->post("txtSearch");
    $invID = $invID != "" ? $invID : "";
    $date_f = $date_f!= "" ? $date_f : "";
    $date_t = $date_t!= "" ? $date_t : "";  
    $data["receipt"] = $this->rm->get_receipt($date_f,$date_t,$invID);
    $this->load->view("template/header");
    $this->load->view("template/left");
    $this->load->view("sale_report_daily",$data);
    $this->load->view("template/footer");
  }

  public function sale_report_detail()
  {
      $data['invoice'] = $this->rm->get_invoice();                           
      $this->load->view("template/header");
      $this->load->view("template/left");
      $this->load->view("sale_report_detail",$data);
      $this->load->view("template/footer");
  }
}
