<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Corrections extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Corrections_Model');
    }


    public function listing(){
        $instructorId = getUserId();
        $result = $this->Corrections_Model->listing($instructorId);
        echo json_encode($result);
    }

    public function listingQuestions(){
        $examId = $this->input->post("examId");
        $studentId = $this->input->post("studentId");
        $questionList = $this->Corrections_Model->listingQuestions($examId,$studentId);
        echo json_encode($questionList);
    }


}
