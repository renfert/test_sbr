<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Chart extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Chart_Model');
    }


	public function getRegisteredUsersPerMonth(){
        $chart = $this->Chart_Model->getRegisteredUsersPerMonth();
        echo json_encode($chart);
    }



    public function getCourses(){
        $chart = $this->Chart_Model->getCourses();
        echo json_encode($chart); 
    }


    public function getStudentCourses(){
        $studentId = $this->input->post("studentId");
        $chart = $this->Chart_Model->getStudentCourses($studentId);
        echo json_encode($chart); 
    }

}
