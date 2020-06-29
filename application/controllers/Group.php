<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Group extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Group_Model');
    }

    /* 
    =============================================
    General group section
    ============================================== 
    */
    
	public function create(){
        $groupName = applySecurityFunctions($this->input->post("name"));
        $resultGroupCreate = $this->Group_Model->create($groupName);
        echo json_encode($resultGroupCreate);
    }

  
    public function edit(){
        $dataReceiveFromPost = array(
            'name' => applySecurityFunctions($this->input->post("name")),
            'id' => $this->input->post("id")
        );
        $resultGroupEdit = $this->Group_Model->edit($dataReceiveFromPost);
        echo json_encode($resultGroupEdit);
    }

   
    public function listing(){
        $groupList = $this->Group_Model->listing();
        echo json_encode($groupList);
    }

    public function get(){
        $groupId = $this->input->post("groupId");
        $group = $this->Group_Model->get($groupId);
        echo json_encode($group);
    }

    
    public function delete(){
        $groupId = $this->input->post("id");
        $resultGroupDelete = $this->Group_Model->delete($groupId);
        echo json_encode($resultGroupDelete);
    }

    


    /* 
    =============================================
    This section is related to students administration into group 
    ============================================== 
    */
   
    public function getStudentsInsideGroup(){
        $groupId = $this->input->post("groupId");
        $students = $this->Group_Model->getStudentsInsideGroup($groupId);
        echo json_encode($students);
    }

    public function getStudentsOutsideGroup(){
        $groupId = $this->input->post("groupId");
        $students = $this->Group_Model->getStudentsOutsideGroup($groupId);
        echo json_encode($students);
    }


    /* 
    =============================================
    This section is related to instructors administration into group 
    ============================================== 
    */

    
    public function getInstructorsInsideGroup(){
        $groupId = $this->input->post("groupId");
        $instructors = $this->Group_Model->getInstructorsInsideGroup($groupId);
        echo json_encode($instructors);
    }

    public function getInstructorsOutsideGroup(){
        $groupId = $this->input->post("groupId");
        $instructors = $this->Group_Model->getInstructorsOutsideGroup($groupId);
        echo json_encode($instructors);
    }




    /* 
    =============================================
    This section is related to remove and enroll users into a group
    ============================================== 
    */

    public function saveUsersIntoGroup(){
        $groupId = $this->input->post("groupId");
        $users = $this->input->post("users");
        $str_arr = explode (",", $users); 
        $users = $this->Group_Model->saveUsersIntoGroup($groupId,$str_arr);
        echo json_encode($users);
    }

    public function removeUserFromGroup(){
        $userId = $this->input->post("userId");
        $groupId = $this->input->post("groupId");
        $resultRemoveUser = $this->Group_Model->removeUserFromGroup($userId, $groupId);
        echo json_encode($resultRemoveUser);
    }

    


    /* 
    =============================================
    This section is related to courses administration into group 
    ============================================== 
    */

    public function getCoursesInsideGroup(){
        $groupId = $this->input->post("groupId");
        $courses = $this->Group_Model->getCoursesInsideGroup($groupId);
        echo json_encode($courses);
    }


   
    public function getCoursesOutsideGroup(){
        $groupId = $this->input->post("groupId");
        $courses = $this->Group_Model->getCoursesOutsideGroup($groupId);
        echo json_encode($courses);
    }



    public function removeCourseFromGroup(){
        $courseId = $this->input->post("courseId");
        $groupId = $this->input->post("groupId");
        $resultRemoveCourse = $this->Group_Model->removeCourseFromGroup($courseId, $groupId);
        echo json_encode($resultRemoveCourse);
    }



    public function saveCoursesIntoGroup(){
        $groupId = $this->input->post("groupId");
        $courses = $this->input->post("courses");
        $str_arr = explode (",", $courses); 
        $courses = $this->Group_Model->saveCoursesIntoGroup($groupId,$str_arr);
        echo json_encode($courses);
    }


    /* 
    =============================================
    This section is related to programs administration into group 
    ============================================== 
    */

    public function getProgramsInsideGroup(){
        $groupId = $this->input->post("groupId");
        $programs = $this->Group_Model->getProgramsInsideGroup($groupId);
        echo json_encode($programs);
    }


   
    public function getProgramsOutsideGroup(){
        $groupId = $this->input->post("groupId");
        $programs = $this->Group_Model->getProgramsOutsideGroup($groupId);
        echo json_encode($programs);
    }



    public function removeProgramFromGroup(){
        $courseId = $this->input->post("courseId");
        $groupId = $this->input->post("groupId");
        $resultRemoveCourse = $this->Group_Model->removeCourseFromGroup($courseId, $groupId);
        echo json_encode($resultRemoveCourse);
    }


    public function saveProgramsIntoGroup(){
        $groupId = $this->input->post("groupId");
        $programs = $this->input->post("programs");
        $str_arr = explode (",", $programs); 
        $result = $this->Group_Model->saveProgramsIntoGroup($groupId,$str_arr);
        echo json_encode($result);
    }

}
