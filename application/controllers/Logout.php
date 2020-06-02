<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    
	public function doLogout(){
        $this->session->sess_destroy();
        $this->load->view('index.html');
    }
}
?>