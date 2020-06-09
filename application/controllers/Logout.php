<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("Logout_Model");
        $this->load->model('Activity_Model');
    }

    
	public function doLogout(){
        $this->Logout_Model->doLogout();
    }
}
?>