<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Activity extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Activity_Model');
    }

    
	public function save(){
        $post = array(
            "type" => $this->input->post("type"),
            "course_name" => $this->input->post("course_name"),
            "lesson_name" => $this->input->post("lesson_name"),
            "lead_name" => $this->input->post("lesson_name"),
            "date" => getCurrentDate("Y-m-d H:i:s"),
            "create_user" => getUserId()
        );
        
        $result = $this->Activity_Model->save($post);
        echo json_encode($result);
    }

    public function listingAll(){
        $result = $this->Activity_Model->listingAll();
        echo json_encode($result);
    }

    public function listingUserActivities(){
        $userId = $this->input->post("userId");
        $result = $this->Activity_Model->listingUserActivities($userId);
        echo json_encode($result);
    }
}
