<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Reviews extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Reviews_Model');
    }

    
    /*-------------------------- 
        Save a new review   
    ---------------------------*/
	public function saveReview(){
        $data = array(
            "mycourse_id" => $this->input->post("courseId"),
            "comment" => $this->input->post("comment"),
            "rate" => $this->input->post("rate"),
            "date" => date("Y-m-d"),
            "status" => "pending",
            "myuser_id" => getUserId(),
        );
        $result = $this->Reviews_Model->saveReview($data);
        echo json_encode($result);
    }
}
