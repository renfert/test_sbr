<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Widgets extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model("Widgets_Model");
    }

  
	public function getTotalNumberOfUsers(){   
        $result = $this->Widgets_Model->getTotalNumberOfUsers();
        echo json_encode($result);
    }

    public function getTotalNumberOfCourses(){   
        $result = $this->Widgets_Model->getTotalNumberOfCourses();
        echo json_encode($result);
    }

    public function getStorage(){
        $result = $this->Widgets_Model->getStorage();
        echo json_encode($result);
    }

}
?>
