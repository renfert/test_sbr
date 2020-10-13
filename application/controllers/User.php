<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper("email");
    $this->load->model("User_Model");
    $this->load->model("Course_Model");
    $this->load->model("Program_Model");
    $this->load->model("Verify_Model");
  }

  /* ---------------------
        Create a new user
    -----------------------*/
  public function create()
  {

    /*-------------------
            verifyUserCreate method will check
            within the customer plan if there are users
            available for registration
        -------------------*/
    if ($this->Verify_Model->verifyUserCreate($this->input->post("role"))) {
      $dataReceiveFromPost = array(
        'name' => applySecurityFunctions($this->input->post("name")),
        'email' => applySecurityFunctions($this->input->post("email")),
        'role' => $this->input->post("role"),
        'password' => $this->input->post("password"),
        'template-email' => 'register',
        'subject' => 'email-account-created'
      );
      $resultUserCreate = $this->User_Model->create($dataReceiveFromPost);
      echo json_encode($resultUserCreate);
    } else {
      echo json_encode("upgrade-plan");
    }
  }



  /* ---------------------
        Delete a user
    -----------------------*/
  public function delete()
  {
    $userId = $this->input->post("id");
    $resultUserDelete = $this->User_Model->delete($userId);
    echo json_encode($resultUserDelete);
  }


  /* -----------------------
        Import massively users
    ------------------------*/
  public function massivelyCreateUsers()
  {
    if (isset($_FILES['file'])) {
      $excelFileWithUsers = $_FILES['file'];
      $this->User_Model->massivelyCreateUsers($excelFileWithUsers);
    } else {
      return false;
    }
  }


  /* ---------------------
        Listing all users
    -----------------------*/
  public function listing()
  {
    $userList = $this->User_Model->listing();
    echo json_encode($userList);
  }




  /* ---------------------
        Get a specific user
    -----------------------*/
  public function get()
  {
    $userId = $this->input->post("userId");
    $result = $this->User_Model->get($userId);
    echo json_encode($result);
  }


  /* ---------------------
        Get all exams from specific user
    -----------------------*/
  public function getUserExams()
  {
    $userId = $this->input->post("userId");
    $result = $this->User_Model->getUserExams($userId);
    echo json_encode($result);
  }

  /* -----------------------------------------
    Get all students from specific instructor
    -------------------------------------------*/
  public function getStudents()
  {
    $result = $this->User_Model->getStudents(getUserId());
    echo json_encode($result);
  }


  public function getUserCourseProgress()
  {
    $userId = $this->input->post("userId");
    $courseId = $this->input->post("courseId");
    $result = $this->Course_Model->userProgress($courseId, $userId);
    echo json_encode($result);
  }

  /* ---------------------
      Get user profile
    -----------------------*/
  public function getUserProfile()
  {
    $result = $this->User_Model->getUserProfile();
    echo json_encode($result);
  }


  /* -----------------------------------------
        Get all instructors from specific course
    -------------------------------------------*/
  public function getInstructors()
  {
    $courseId = $this->input->post("courseId");
    $result = $this->User_Model->getInstructors($courseId);
    echo json_encode($result);
  }


  /* -------------------------------------------------
        Get all courses that a specific user is enrolled
    --------------------------------------------------*/
  public function getEnrolledCourses()
  {
    $userId = $this->input->post("userId");
    $result = $this->User_Model->getEnrolledCourses($userId);
    echo json_encode($result);
  }




  /* -------------------------------------------------
        Get all programs that a specific user is enrolled
    --------------------------------------------------*/
  public function getEnrolledPrograms()
  {
    $userId = $this->input->post("userId");
    $result = $this->User_Model->getEnrolledPrograms($userId);
    echo json_encode($result);
  }


  /* ------------------------------------------------------------
        Get all courses that a specific user is not yet enrolled in
    -------------------------------------------------------------*/
  public function getNotEnrolledCourses()
  {
    $userId = $this->input->post("userId");
    $result = $this->User_Model->getNotEnrolledCourses($userId);
    echo json_encode($result);
  }


  /* ------------------------------------------------------------
        Get all programs that a specific user is not yet enrolled in
    -------------------------------------------------------------*/
  public function getNotEnrolledPrograms()
  {
    $userId = $this->input->post("userId");
    $result = $this->User_Model->getNotEnrolledPrograms($userId);
    echo json_encode($result);
  }


  /* ------------------------------------------------------------
        Enroll a specific user into a multiple courses
    -------------------------------------------------------------*/
  public function enrollUserIntoCourses()
  {
    $userId = $this->input->post("userId");
    $courses = $this->input->post("courses");
    $arrayCourses = explode(",", $courses);
    $result = $this->User_Model->enrollUserIntoCourses($userId, $arrayCourses);
  }


  /* ------------------------------------------------------------
        Enroll a specific user into a multiple programs
    -------------------------------------------------------------*/
  public function enrollUserIntoPrograms()
  {
    $userId = $this->input->post("userId");
    $programs = $this->input->post("programs");
    $arrayPrograms = explode(",", $programs);
    $result = $this->User_Model->enrollUserIntoPrograms($userId, $arrayPrograms);
  }

  /* ------------------------------------------------------------
        Remove user from course
    -------------------------------------------------------------*/
  public function removeCourseFromUser()
  {
    $userId = $this->input->post("userId");
    $courseId = $this->input->post("courseId");
    $result = $this->Course_Model->removeUserFromCourse($userId, $courseId);
    echo json_encode($result);
  }

  /* ------------------------------------------------------------
        Remove user from program
    -------------------------------------------------------------*/
  public function removeProgramFromUser()
  {
    $userId = $this->input->post("userId");
    $courseId = $this->input->post("programId");
    $result = $this->Program_Model->removeUserFromProgram($userId, $courseId);
    echo json_encode($result);
  }

  /* ------------------------------------------------------------
        Edit user profile
    -------------------------------------------------------------*/
  public function editProfile()
  {
    if ($this->input->post("password")) {
      $data = array(
        'name' => applySecurityFunctions($this->input->post("name")),
        'description' => $this->input->post("description"),
        'avatar' => $this->input->post("avatar"),
        'password' => md5($this->input->post("password"))
      );
    } else {
      $data = array(
        'name' => applySecurityFunctions($this->input->post("name")),
        'description' => $this->input->post("description"),
        'avatar' => $this->input->post("avatar"),
      );
    }

    $resultEdit = $this->User_Model->editProfile(getUserId(), $data);
    echo json_encode($resultEdit);
  }

  public function updateStatus()
  {
    echo json_encode($this->User_Model->statusUpdate(getUserId(), "on"));
  }


  /* ------------------------------------------------------------
          Logoff
      -------------------------------------------------------------*/
  public function logoff()
  {
    $logoff = $this->User_Model->logoff();
    echo json_encode($logoff);
  }
}
