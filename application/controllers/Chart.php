<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Chart extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Chart_Model');
    }


	public function getRegisteredStuentsPerMonth(){
        $chart = $this->Chart_Model->getRegisteredStuentsPerMonth();
        echo json_encode($chart);
    }

    public function getRegisteredInstructorsPerMonth(){
        $chart = $this->Chart_Model->getRegisteredInstructorsPerMonth();
        echo json_encode($chart);
    }

    public function getAdminCourses(){
        $chart = $this->Chart_Model->getAdminCourses();
        echo json_encode($chart); 
    }

}
