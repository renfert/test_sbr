<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Program extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Program_Model');
    }

   

	public function create(){
        $creationDate = getCurrentDate("Y-m-d");
        $courses = $this->input->post("courses");
        $coursesArray = explode (",", $courses); 
        $dataReceiveFromPost = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'photo' => $this->input->post('photo'),
            'release_date' => $this->input->post('release_date'),
            'expiration_date' => $this->input->post('expiration_date'),
            'creation_date' => $creationDate,
            'creation_user' => getUserId()
        );
        $result = $this->Program_Model->create($dataReceiveFromPost, $coursesArray);
        echo json_encode($result);
    }
    

    public function listing(){
        $programList = $this->Program_Model->listing();
        echo json_encode($programList);
    }

    
    public function listingCoursesToViewProgram(){
        $programId = $this->input->post("programId");
        $userId = getUserId();
        $result = $this->Program_Model->listingCoursesToViewProgram($programId, $userId);
        echo json_encode($result);
    }

    public function getCourses(){
        $courses = $this->Program_Model->getCourses();
        echo json_encode($courses);
    }

    public function delete(){
        $programId = $this->input->post("programId");
        $result = $this->Program_Model->delete($programId);
        echo json_encode($result);
    }

    public function getPersonsOutsideTheProgram(){
        $programId = $this->input->post("programId");
        $result  = $this->Program_Model->getPersonsOutsideTheProgram($programId);
        echo json_encode($result);
    }

    public function enrollUsersIntoProgram(){
        $users = $this->input->post("users");
        $usersArray = explode (",", $users); 
        $programId = $this->input->post("programId");
        $result = $this->Program_Model->enrollUsersIntoProgram($programId,$usersArray);
        echo json_encode($result);
    }
	
}
