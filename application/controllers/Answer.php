<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Answer extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Answer_Model');
    }

    
	public function create(){
        $dataReceiveFromPost = array(
            'questionId' => $this->input->post("questionId"),
            'answer' => $this->input->post("answer"),
        );
        $resultAnswerCreate = $this->Answer_Model->create($dataReceiveFromPost);
        echo json_encode($resultAnswerCreate);
    }


	public function reorder(){
        $this->Answer_Model->reorder($this->input->post("answer"));
    }

    
    public function edit(){
        $dataReceiveFromPost = array(
            'answerId' => $this->input->post("answerId"),
            'answer' => $this->input->post("answer"),
        );
        $resultAnswerEdit = $this->Answer_Model->edit($dataReceiveFromPost);
        echo json_encode($resultAnswerEdit);
    }


    public function listing(){
        $questionId = $this->input->post("questionId");
        $answerList = $this->Answer_Model->listing($questionId);
        echo json_encode($answerList);
    }

    public function getStudentAnswer(){
        $studentId = $this->input->post("studentId");
        $questionId = $this->input->post("questionId");
        $result = $this->Answer_Model->getStudentAnswer($questionId, $studentId);
        echo json_encode($result);
    }

    
    
    public function delete(){
        $answerId = $this->input->post("answerId");
        $resultAnswerDelete = $this->Answer_Model->delete($answerId);
        echo json_encode($resultAnswerDelete);
    }

    public function changeStatus(){
        $answerId = $this->input->post("answerId");
        $this->input->post("status") == "null" ? $status = null : $status = $this->input->post("status"); 
        $result = $this->Answer_Model->changeStatus($answerId, $status);
        echo json_encode($result);
    }
}
