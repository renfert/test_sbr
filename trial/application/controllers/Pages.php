<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->library("pagination");
    }

	public function index(){
        $this->load->view('index.html');	    
    }
}
