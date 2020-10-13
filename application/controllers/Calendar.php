<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') or exit('No direct script access allowed');
class Calendar extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Calendar_Model');
  }


  public function get()
  {
    $userId = getUserId();
    $result = $this->Calendar_Model->get($userId);
    echo json_encode($result);
  }
}
