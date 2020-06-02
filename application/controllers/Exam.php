<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Exam_Model');
    }

    public function finish(){
        $answers = $this->input->post("answer");
        $examId = $this->input->post("examId");
        $result = $this->Exam_Model->finish($answers, $examId);
        echo json_encode($result);
    }

    public function getExamOverview(){
        $studentId = $this->input->post("studentId");
        $examId = $this->input->post("examId");
        $result = $this->Exam_Model->getExamOverview($examId, $studentId);
        echo json_encode($result);
    }

    public function get(){
        $examId = $this->input->post("examId");
        $result = $this->Exam_Model->get($examId);
        echo json_encode($result);
    }

}
