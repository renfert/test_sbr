<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Course extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Course_Model');
    }

   
	public function create(){
        $this->input->post("mycategory_id") == '' ? $category = 1 : $category =  $this->input->post("mycategory_id");
        $dateCreate = getCurrentDate("Y-m-d");
        
        /* Empty image */
        if($this->input->post("photo") == ''){
            $coursePhoto = null;
        }else{
            $coursePhoto  = $this->input->post("photo");
        }

        /* Empty video preview */
         if($this->input->post("preview") == ''){
            $coursePreview = null;
        }else{
            $coursePreview  = $this->input->post("preview");
        }


    

        $dataReceiveFromPost = array(
            'title' => applySecurityFunctions($this->input->post("title")),
            'mycategory_id' => $category,
            'release_date' => $this->input->post("release_date"),
            'expiration_date' => $this->input->post("expiration_date"),
            'validity' => $this->input->post("validity"),
            'comments' => $this->input->post("comments"),
            'spotlight' => $this->input->post("spotlight"),
            'photo' =>  $coursePhoto,
            'preview' =>  $coursePreview,
            'certificate' => $this->input->post("certificate"),
            'price' => $this->input->post("price"),
            'creation_date' => $dateCreate,
            'creation_user' => getUserId(),
            'description' => $this->input->post("description"),
        );
        $idOfLastRegisteredCourse = $this->Course_Model->create($dataReceiveFromPost);
        echo json_encode($idOfLastRegisteredCourse);
    }

    
    public function listing(){
        $courseList = $this->Course_Model->listing();
        echo json_encode($courseList);
    }

    public function listingAll(){
        $category = $this->input->post("category");
        $courseList = $this->Course_Model->listingAll($category);
        echo json_encode($courseList);
    }

    
    public function get(){
        $courseId = $this->input->post("courseId");
        $course = $this->Course_Model->get($courseId);
        echo json_encode($course);
    }

  
    public function progress(){
        $courseId = $this->input->post("courseId");
        $courseProgress = $this->Course_Model->progress($courseId);
        echo json_encode($courseProgress);
    }

    
	public function edit(){    

        $this->input->post("release_date") == '' ? $releaseDate = null : $releaseDate =  $this->input->post("release_date");

        $this->input->post("expiration_date") == '' ? $expirationDate = null : $expirationDate =  $this->input->post("expiration_date");

        $this->input->post("validity") == '' ? $validity = null : $validity =  $this->input->post("validity");

        $this->input->post("photo") == '' ? $photo = null : $photo =  $this->input->post("photo");

        $this->input->post("preview") == '' ? $preview = null : $preview =  $this->input->post("preview");

        $dataReceiveFromPost = array(
            'title' => applySecurityFunctions($this->input->post("title")),
            'mycategory_id' => $this->input->post("mycategory_id"),
            'release_date' => $releaseDate,
            'expiration_date' => $expirationDate,
            'validity' => $validity,
            'comments' => $this->input->post("comments"),
            'spotlight' => $this->input->post("spotlight"),
            'photo' =>  $photo,
            'preview' =>  $preview,
            'certificate' => $this->input->post("certificate"),
            'price' => $this->input->post("price"),
            'description' => $this->input->post("description"),
            'id' => $this->input->post("id")
        );
        $resultCourseEdit = $this->Course_Model->edit($dataReceiveFromPost);
        echo json_encode($resultCourseEdit);
    }

    public function delete(){
        $courseId = $this->input->post("courseId");
        $result = $this->Course_Model->delete($courseId);
        echo json_encode($result);
    }

    public function getPersonsOutsideTheCourse(){
        $courseId  = $this->input->post("courseId");
        $persons = $this->Course_Model->getPersonsOutsideTheCourse($courseId);
        echo json_encode($persons);
    }

    public function enrollUsersIntoCourse(){
        $users = $this->input->post("users");
        $usersArray = explode (",", $users); 
        $courseId = $this->input->post("courseId");
        $result = $this->Course_Model->enrollUsersIntoCourse($courseId,$usersArray);
        echo json_encode($result);
    }

    public function enrollUserIntoCourse(){
        $courseId = $this->input->post("courseId");
        $userId = $this->input->post("userId");
        $result = $this->Course_Model->enrollUserIntoCourse($courseId,$userId);
        echo json_encode($result);
    }
}
