<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("Authentication_Model");
    }

    
	public function doLogin(){
        $dataReceiveFromPost = array(
            'email' => $this->input->post("email"),
            'password' => $this->input->post("password"),
        );
        $resultLogin = $this->Authentication_Model->doAuthentication($dataReceiveFromPost);
        echo json_encode($resultLogin);
    }


    public function recoverPassword(){
        $email = $this->input->post("email");
        $result = $this->Authentication_Model->recoverPassword($email);
        echo json_encode($result);
    }
}
?>