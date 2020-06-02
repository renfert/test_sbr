<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Chart extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Chart_Model');
    }



	public function getStudentsChart(){
        $chart = $this->Chart_Model->getStudentsChart();
        echo json_encode($chart);
    }

    public function getSalesChart(){
        $chart = $this->Chart_Model->getSalesChart();
        echo json_encode($chart);
    }
}
