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

  public function getPublications()
  {
    $pubs = $this->Social_Network_Model->getPublications();
    echo json_encode($pubs);
  }

  public function getCommentsByPublication()
  {
    $data = $this->input->post();

    $res = $this->Social_Network_Model->getCommentsByPublicationId($data['publication_id']);
    echo json_encode($res);
  }

  public function getLikesByPublication()
  {
    $data = $this->input->post();
    $res = $this->Social_Network_Model->getLikes($data['publication_id']);
    echo json_encode($res);
  }

  public function savePublication() // Pass Id in array for edit register  and nothing if is a new register
  {

    $data = $this->input->post();

    if (strlen($data['description']) > 0) {

      $this->User_Model->getUserProfile();
      $data['prev_description'] = substr($data['description'], 0, 97) . '...';
      $res = $this->Social_Network_Model->savePublication($data);
      echo json_encode($res);
    } else
      echo json_encode(false);

  }

  public function saveComment()
  {
    $data = $this->input->post();
    if (strlen($data['comment']) > 0) {
      $data['prev_comment'] = substr($data['comment'], 0, 97) . '...';
      echo json_encode($this->Social_Network_Model->saveComment($data));
    } else {
      echo json_encode(false);

    }
  }

  public function doLike()
  {
    $data = $this->input->post();
    echo json_encode($this->Social_Network_Model->saveLike($data));
  }

  public function checkIfLike()
  {

    $data = $this->input->post();
    echo json_encode($this->Social_Network_Model->getLikeByPublicationId($data['social_publication_id'], $data['myuser_id']));
  }

  public function getOnlineUsers()
  {

    echo json_encode($this->Social_Network_Model->getUsersWithStatusOn());
  }

  public function getCommentsByPub()
  {
    $data = $this->input->post();

    echo json_encode($this->Social_Network_Model->getCommentByPublicationId($data['social_publication_id']));

  }

  public function deletePost()
  {
    $data = $this->input->post();

    echo json_encode($this->Social_Network_Model->deletePostByPublicationId($data['social_publication_id']));
  }

  public function getAllGroups()
  {

    echo json_encode($this->Social_Network_Model->getAllGroups());

  }
}