<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') or exit('No direct script access allowed');

class Mysessions extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->helper('url');
    $this->load->model("Authentication_Model");
  }


  public function activeSession()
  {
    echo json_encode(activeSession());
  }

  public function getSession()
  {
    echo json_encode(getSession());
  }
}

?>