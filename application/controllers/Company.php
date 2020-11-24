<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Company_Model');
    }

    /* 
    =============================================
    Returns: Array with only one object
    ============================================== 
    */    
	public function getCompanyInformation(){
        $result = $this->Company_Model->getCompanyInformation();
        echo json_encode($result);
    }

    public function updateCompanyInformation(){
        $step = $this->input->post("step");
        $goal = $this->input->post("goal");
        $phone = $this->input->post("phone");

        $result = $this->Company_Model->updateCompanyInformation($step,$goal,$phone);
        echo json_encode($result);
    }
}
