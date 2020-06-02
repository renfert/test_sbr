<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->helper('auth'); 
        $this->load->library("pagination");
    }


    /* 
    =============================================
        Index
    ============================================== 
    */
	public function login(){
        create_cookie();
        if($this->input->get("url")){
            $data['url'] = $this->input->get("url");
            $this->load->view("auth", $data);
        }
    }

}
