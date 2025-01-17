<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  /*
  =============================================
  Returns: Array with only one object
  ==============================================
  */
  public function getCompanyInformation()
  {
    $this->db->select("*");
    $result = $this->db->get("mycompany");
    if ($result->num_rows() > 0) {
      return $result->row();
    } else {
      return false;
    }
  }



  public function updateCompanyInformation($step,$goal,$phone){

    $this->db->select("*");
    $this->db->from("mycompany");
    $query = $this->db->get();
    $result = $query->result()[0];
    $subdomain = $result->subdomain;
    $country = $result->country;
   
    // Update mycompany
    $data = array(
      "type_project" => $goal,
      "step_project" => $step,
    );
    $this->db->update("mycompany", $data);

    // Update on sbr_admin
    $con = $this->openDataBaseConnection("admin");
    $stmt = $con->prepare('UPDATE trials SET  step_project = :step, type_project = :goal, phone = :userphone WHERE domain = :subdomain');
    $stmt->execute(array(
      ':subdomain'   => $subdomain,
      ':step' => $step,
      ':goal' => $goal,
      ':userphone' => $phone,
    ));

    // Send trial email
    $this->db->select("*");
    $this->db->from("myuser");
    $this->db->where("id",1);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      $result= $query->result()[0];
      $userName = $result->name;
      $userEmail = $result->email;
    }

  

    $params = array(
      'email' => 'trial@sabiorealm.com',
      'userName' => $userName,
      'userEmail' => $userEmail,
      'userPhone' => $phone,
      'subdomainName' => $subdomain,
      'country' => $country,
      'step' => $step,
      'goal' => $goal,
      'date' => getCurrentDate("Y-m-d"),
      'template-email' => 'new_trial',
      'subject' => 'new-trial'
    );
    sendEmail($params);
 
    return $stmt->rowCount();   
  }


  private function openDataBaseConnection($domain)
  {
    /* RDS SERVER */
    $serverNameRds = "sabiorealm.cvazuf0euqlw.us-east-1.rds.amazonaws.com";
    $userNameRds = "admin";
    $passwordRds = "k4=IO#d33Sb2";
    $dbName = "sbr_{$domain}";
    try {
      $conn = new PDO("mysql:host=$serverNameRds;dbname=$dbName", $userNameRds, $passwordRds);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (Exception $e) {
      echo 'Exception -> ';
      var_dump($e->getMessage());
    }

    return $conn;
  }
  

  
}
