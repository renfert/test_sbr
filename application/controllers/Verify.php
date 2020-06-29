<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Verify extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library("upload");
        $this->load->model("Verify_Model");
    }

  
	public function groupName(){   
        $name = $this->input->post("name");  
        $this->toverify->Verify_Model($name);
    }

    public function userIsInCourse(){
        $courseId = $this->input->post("courseId");
        $userId = getUserId();
        $result = $this->Verify_Model->userIsInCourse($userId,$courseId);
        echo json_encode($result);
    }


    public function correctAnswerExist(){
        $questionId = $this->input->post("questionId");
        $result = $this->Verify_Model->correctAnswerExist($questionId);
        echo json_encode($result);
    }

    public function getCurrentDate(){
        $result = getCurrentDate("Y-m-d H:i:s");
        echo json_encode($result);
    }

    public function getSubDomainName(){
        $result = $this->Verify_Model->getSubDomainName();
        echo json_encode($result);
    }
    

}
?>
