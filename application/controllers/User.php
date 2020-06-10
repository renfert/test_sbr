<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper("email");
        $this->load->model('User_Model');
        $this->load->model('Course_Model');
    }

    
	public function create(){
        $dataReceiveFromPost = array(
            'name' => $this->input->post("name"),
            'email' => $this->input->post("email"),
            'role' => $this->input->post("role"),
            'password' => $this->input->post("password"),
            'template-email' => 'register',
            'subject' => 'email-account-created'
        );
        $resultUserCreate = $this->User_Model->create($dataReceiveFromPost);
        echo json_encode($resultUserCreate);
    }

   
      public function delete(){
        $userId = $this->input->post("id");
        $resultUserDelete = $this->User_Model->delete($userId);
        echo json_encode($resultUserDelete);
    }
    

	public function massivelyCreateUsers(){
        if(isset($_FILES['file'])){
            $excelFileWithUsers = $_FILES['file'];
            $this->User_Model->massivelyCreateUsers($excelFileWithUsers);
        }else{
            return false;
        }
    }

    
    public function listing(){
        $userList = $this->User_Model->listing();
        echo json_encode($userList);
    }

    public function get(){
        $userId = $this->input->post("userId");
        $result = $this->User_Model->get($userId);
        echo json_encode($result);
    }

    public function getUserExams(){
        $userId = $this->input->post("userId");
        $result = $this->User_Model->getUserExams($userId);
        echo json_encode($result);
    }

    
	public function getUserProfile(){
        $result = $this->User_Model->getUserProfile();
        echo json_encode($result);
    }

    public function getInstructors(){
        $courseId = $this->input->post("courseId");
        $result = $this->User_Model->getInstructors($courseId);
        echo json_encode($result);
    }

    public function getEnrolledCourses(){
        $userId = $this->input->post("userId");
        $result = $this->User_Model->getEnrolledCourses($userId);
        echo json_encode($result);
    }

    public function getEnrolledPrograms(){
        $userId = $this->input->post("userId");
        $result = $this->User_Model->getEnrolledPrograms($userId);
        echo json_encode($result);
    }

    public function getNotEnrolledCourses(){
        $userId = $this->input->post("userId");
        $result = $this->User_Model->getNotEnrolledCourses($userId);
        echo json_encode($result);
    }

    public function getNotEnrolledPrograms(){
        $userId = $this->input->post("userId");
        $result = $this->User_Model->getNotEnrolledPrograms($userId);
        echo json_encode($result);
    }

    public function enrollUserIntoCourses(){
        $userId = $this->input->post("userId");
        $courses = $this->input->post("courses");
        $arrayCourses = explode (",", $courses); 
        $result = $this->User_Model->enrollUserIntoCourses($userId,$arrayCourses);
    }

    public function enrollUserIntoPrograms(){
        $userId = $this->input->post("userId");
        $programs = $this->input->post("programs");
        $arrayPrograms = explode (",", $programs); 
        $result = $this->User_Model->enrollUserIntoPrograms($userId,$arrayPrograms);
    }

    public function removeCourseFromUser(){
        $userId = $this->input->post("userId");
        $courseId = $this->input->post("courseId");
        $result = $this->Course_Model->removeUserFromCourse($userId,$courseId);
        echo json_encode($result);
    }

    public function removeProgramFromUser(){
        $userId = $this->input->post("userId");
        $courseId = $this->input->post("programId");
        $result = $this->Program_Model->removeUserFromCourse($userId,$courseId);
        echo json_encode($result);
    }

    public function editProfile(){
        if($this->input->post("password")){
            $data = array(
                'name' => $this->input->post("name"), 
                'description' => $this->input->post("description"),
                'avatar' => $this->input->post("avatar"),
                'password' => md5($this->input->post("password"))
            );
        }else{
            $data = array(
                'name' => $this->input->post("name"), 
                'description' => $this->input->post("description"),
                'avatar' => $this->input->post("avatar"),
            );
        }
        
        $resultEdit = $this->User_Model->editProfile($this->input->post("userId"), $data);
        echo json_encode($resultEdit);
        
    }

   
	public function logoff(){
        $logoff = $this->User_Model->logoff();
        echo json_encode($logoff);
    }

    
}
