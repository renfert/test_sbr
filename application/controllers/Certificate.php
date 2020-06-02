<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Certificate extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Certificate_Model');
    }


    public function get(){
        $courseId = $this->input->post("courseId");
        $userId = getUserId();
        $result = $this->Certificate_Model->get($courseId,$userId);
        echo json_encode($result);
    }
    
    public function listing(){
        $userId = getUserId();
        $result = $this->Certificate_Model->listing($userId);
        echo json_encode($result);
    }


}
