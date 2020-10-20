<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') or exit('No direct script access allowed');

class SocialNetwork extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Social_Network_Model");
    $this->load->model("User_Model");
  }


  /*
  =============================================
  Get all publications
  ==============================================
  */
  public function getPublications()
  {
    $data = $this->input->post();
    if ($data["channel_name"] == "public") {
      $pubs = $this->Social_Network_Model->getPublications();
    } elseif ($data["channel_name"] == "group") {
      $pubs = $this->Social_Network_Model->getPublicationsByGroupId($data["channel_id"]);
    } else {
      $pubs = $this->Social_Network_Model->getPublicationsByCourseId($data["channel_id"]);
    }

    echo json_encode($pubs);
  }

  /*
  =============================================
  Save publication
  ==============================================
  */
  public function savePublication()
  {

    $data = $this->input->post();

    if (strlen($data['description']) > 0) {

      $this->User_Model->getUserProfile();
      $res = $this->Social_Network_Model->savePublication($data);
      echo json_encode($res);
    } else
      echo json_encode(false);
  }

  /*
  =============================================
  Delete publication
  ==============================================
  */
  public function deletePost()
  {
    $data = $this->input->post();

    echo json_encode($this->Social_Network_Model->deletePostByPublicationId($data['social_publication_id']));
  }

  /*
  =============================================
  Edit publication
  ==============================================
  */
  public function editPublication()
  {
    $data = $this->input->post();
    echo json_encode($this->Social_Network_Model->editPublication($data));
  }


  /*
  =============================================
  Get comments by publication
  ==============================================
  */
  public function getCommentsByPub()
  {
    $data = $this->input->post();

    echo json_encode($this->Social_Network_Model->getCommentsByPublicationId($data['social_publication_id'], $data['myuser_id']));
  }


  /*
  =============================================
  Delete commentary
  ==============================================
  */
  public function deleteComment()
  {

    $data = $this->input->post();

    echo json_encode($this->Social_Network_Model->deleteCommentById($data['social_comment_id']));
  }

  /*
  =============================================
  Get all comments from specific publication
  ==============================================
  */
  public function getCommentsByPublication()
  {
    $data = $this->input->post();

    $res = $this->Social_Network_Model->getCommentsByPublicationId($data['publication_id']);
    echo json_encode($res);
  }

  /*
  =============================================
  Save comment
  ==============================================
  */
  public function saveComment()
  {
    $data = $this->input->post();
    if (strlen($data['comment']) > 0) {
      echo json_encode($this->Social_Network_Model->saveComment($data));
    } else {
      echo json_encode(false);
    }
  }



  /*
  =============================================
  Get all likes from specific publication
  ==============================================
  */
  public function getLikesByPublication()
  {
    $data = $this->input->post();
    $res = $this->Social_Network_Model->getLikes($data['publication_id']);
    echo json_encode($res);
  }



  /*
  =============================================
  Do publication like
  ==============================================
  */
  public function doPublicationLike()
  {
    $data = $this->input->post();
    echo json_encode($this->Social_Network_Model->savePublicationLike($data));
  }


  /*
  =============================================
  Do commentary like
  ==============================================
  */
  public function doCommentaryLike()
  {
    $data = $this->input->post();
    echo json_encode($this->Social_Network_Model->saveCommentaryLike($data));
  }


  /*
  =============================================
  Get all courses available on social
  ==============================================
  */
  public function getCoursesInsideSocial()
  {
    $courses = $this->Social_Network_Model->getCoursesInsideSocial();
    echo json_encode($courses);
  }

  /*
  =============================================
  Get all groups available on social
  ==============================================
  */
  public function getGroupsInsideSocial()
  {
    $groups = $this->Social_Network_Model->getGroupsInsideSocial();
    echo json_encode($groups);
  }

  /*
  =============================================
  Get all courses that no available on social
  ==============================================
  */
  public function getCoursesOutsideSocial()
  {
    $courses = $this->Social_Network_Model->getCoursesOutsideSocial();
    echo json_encode($courses);
  }



  /*
  =============================================
  Get all groups that no available on social
  ==============================================
  */
  public function getGroupsOutsideSocial()
  {
    $groups = $this->Social_Network_Model->getGroupsOutsideSocial();
    echo json_encode($groups);
  }


  /*
  =============================================
  Save courses into social feature
  ==============================================
  */
  public function saveCoursesIntoSocial()
  {
    $courses = $this->input->post("courses");
    $str_arr = explode(",", $courses);
    $courses = $this->Social_Network_Model->saveCoursesIntoSocial($str_arr);
    echo json_encode($courses);
  }

  /*
  =============================================
  Save groups into social feature
  ==============================================
  */
  public function saveGroupsIntoSocial()
  {
    $groups = $this->input->post("groups");
    $str_arr = explode(",", $groups);
    $result = $this->Social_Network_Model->saveGroupsIntoSocial($str_arr);
    echo json_encode($result);
  }

  /*
  =============================================
  Remove course from social feature
  ==============================================
  */
  public function removeCourseFromSocial()
  {
    $courseId = $this->input->post("courseId");
    $resultRemoveCourse = $this->Social_Network_Model->removeCourseFromSocial($courseId);
    echo json_encode($resultRemoveCourse);
  }

  /*
  =============================================
  Remove group from social feature
  ==============================================
  */
  public function removeGroupFromSocial()
  {
    $groupId = $this->input->post("groupId");
    $result = $this->Social_Network_Model->removeGroupFromSocial($groupId);
    echo json_encode($result);
  }

  /*
  =============================================
  Listing all courses
  ==============================================
  */
  public function listingCourses()
  {
    $result = $this->Social_Network_Model->listingCourses();
    echo json_encode($result);
  }

  /*
  =============================================
  Listing all groups
  ==============================================
  */
  public function listingGroups()
  {
    $result = $this->Social_Network_Model->listingGroups();
    echo json_encode($result);
  }

  /*
  =============================================
  Get public network status
  ==============================================
  */
  public function getPublicNetworkStatus()
  {
    $result = $this->Social_Network_Model->getPublicNetworkStatus();
    echo json_encode($result);
  }

  /*
  =============================================
  Update social network status
  ==============================================
  */
  public function updatePublicNetworkStatus()
  {
    $currentStatus = $this->input->post("status");
    $result = $this->Social_Network_Model->updatePublicNetworkStatus($currentStatus);
    echo json_encode($result);
  }
}
