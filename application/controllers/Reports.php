<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') or exit('No direct script access allowed');
class Reports extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Reports_Model');
  }


  /*--------------------------
  Exams report by group id
  ---------------------------*/
  public function getExamsReportsByGroup()
  {
    $groupId = $this->input->post("groupId");
    $result = $this->Reports_Model->getExamsReportsByGroup($groupId);
    echo json_encode($result);
  }
}
