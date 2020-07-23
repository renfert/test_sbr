<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Course extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("Course_Model");
        $this->load->model("Filters_Model");
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
            'reviews' => $this->input->post("reviews"),
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
        $categories = $this->input->post("categories");
        $categoriesArray = explode (",", $categories); 

        $title = $this->input->post("title");

        $price = $this->input->post("price");
        $courseList = $this->Course_Model->listingAll($categoriesArray, $price, $title);
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
    
        $dataReceiveFromPost = array(
            'title' => applySecurityFunctions($this->input->post("title")),
            'mycategory_id' => $this->input->post("mycategory_id"),
            'release_date' => $this->Filters_Model->filterEmptyFields($this->input->post("release_date"), array("")),
            'expiration_date' => $this->Filters_Model->filterEmptyFields($this->input->post("expiration_date"), array("")),
            'validity' => $this->Filters_Model->filterEmptyFields($this->input->post("validity"), array("")),
            'reviews' => $this->input->post("reviews"),
            'spotlight' => $this->input->post("spotlight"),
            'photo' =>  $this->Filters_Model->filterEmptyFields($this->input->post("photo"), array("")),
            'preview' =>  $this->Filters_Model->filterEmptyFields($this->input->post("preview"), array("")),
            'certificate' => $this->input->post("certificate"),
            'price' => $this->Filters_Model->filterEmptyFields($this->input->post("price"), array(" 0,00 ")),
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

    public function getCourseCreator(){
        $courseId = $this->input->post("courseId");
        $result = $this->Course_Model->getCourseCreator($courseId);
        echo json_encode($result);
    }
}
