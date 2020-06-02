<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Model {

    function __construct(){
        parent::__construct();  
    }
 
    /* 
    =============================================
     Authentication
    ============================================== 
    */
	public function authentication($email,$password,$time){
        $this->db->select("*");
        $this->db->from("mycompany");       
        $result = $this->db->get();
        $row = $result->row_array();
        $data["company"] = $row['name'];
        $data["plan"] = $row['plan'];
      
        $this->db->select("*");
        $this->db->from("myuser");
        $this->db->where("email",$email);
        $this->db->where("password", $password);
        $this->db->where("mode", "enable");
        $resultSec = $this->db->get();
        $rowSec =$resultSec->row_array();
            if($rowSec > 0){
               $grupo = $rowSec["group_id"];
               $this->db->select("*");
               $this->db->from("mygroup");
               $this->db->where("id",$grupo);
               $resultTer = $this->db->get();
               $rowTer = $resultTer->row_array();
               $data["group"] = $rowTer["name"];
               $data["username"] = $rowSec["name"]; 
               $data["avatar"] = $rowSec["avatar"];
               $data["id"] = $rowSec["id"];
    
               // Last login/
               $time = date('Y-m-d H:i');
               $info = array(
                'last_login' => $time,
                'status' => "on",
                );
               $this->db->where('id',$data["id"]);
               $this->db->update("myuser",$info);



               $sessionData = array(
                'username' => $rowSec['name'],
                'id' => $rowSec['id'],
                'email' => $rowSec['email'],
                'avatar' => $rowSec['avatar'],
                'group' => $rowTer['name'],
                'company'=> $row['name'],
                'plan' => $row['plan']
               );

               $this->session->set_userdata($sessionData);
               return $data;
            }else{
               return FALSE;    
           }
	}
}
