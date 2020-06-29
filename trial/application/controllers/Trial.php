<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Trial extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Trial_Model'); 
    }

	public function verifySubdomainAvaiable(){
        $subDomainName = $this->input->post("subDomainName");
        $result = $this->Trial_Model->verifySubdomainAvaiable($subDomainName);
        echo json_encode($result);
    }

    public function createTrial(){
        $userName = $this->input->post("name");
        $userPhone = $this->input->post("phone");
        $userEmail = $this->input->post("email");
        $userPassword = $this->input->post("password");
        $subDomainName = $this->input->post("subDomainName");
        $step = $this->input->post("step");
        $goal = $this->input->post("goal");
        $token = $this->input->post("token");
      
        $result = $this->Trial_Model->CreateTrial($userName,$userPhone,$userEmail,$userPassword,$subDomainName,$step,$goal,$token);

        echo json_encode($result);
    }
}
