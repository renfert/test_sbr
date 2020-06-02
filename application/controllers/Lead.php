<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Lead extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('Course_Model');
        $this->load->model('Lead_Model');
        $this->load->model('Authentication_Model');
    }

    
	public function create(){
        $courseId = $this->input->post("courseId");
        $dataReceiveFromPost = array(
            'name' => $this->input->post("name"),
            'email' => $this->input->post("email"),
            'role' => "Student",
            'password' => $this->input->post("password"),
            'template-email' => 'register',
            'subject' => 'email-account-created'
        );
        $userId = $this->User_Model->create($dataReceiveFromPost);
        $data = array(
            "lead" => "yes"
        );
        $this->db->where("id", $userId);
        $this->db->update("myuser", $data);
        if($userId == false){
            echo json_encode(false);
        }else{
            $this->Course_Model->enrollUserIntoCourse($courseId,$userId);
            $data = array(
                "email" => $this->input->post("email"),
                "password" => $this->input->post("password")
            );
            $this->Authentication_Model->doAuthentication($data);
            echo json_encode(true);
        }

    }

    public function listing(){
        $result = $this->Lead_Model->listing();
        echo json_encode($result);
    }
}
