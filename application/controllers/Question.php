<?php
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Question extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Question_Model');
    }

   
	public function create(){
        $dataReceiveFromPost = array(
            'examId' => $this->input->post("examId"),
            'question' => $this->input->post("question"),
            'questionImageName' => $this->input->post("questionImageName"),
            'type' => $this->input->post("type"),
            'weight' => $this->input->post("weight"),
            'feedback' => $this->input->post("feedback"),
        );
        $resultQuestionCreate = $this->Question_Model->create($dataReceiveFromPost);
        echo json_encode($resultQuestionCreate);
    }

    public function correction(){
        $dataReceiveFromPost = array(
            "feedback" => $this->input->post("feedback"),
            "score" => $this->input->post("score"),
            "questionId" => $this->input->post("questionId"),
            "studentId" => $this->input->post("studentId"),
        );

        $result = $this->Question_Model->correction($dataReceiveFromPost);
        echo json_encode($result);
    }

    
	public function createTemporary(){
        $dataReceiveFromPost = array(
            'examId' => $this->input->post("examId"),
        );
        $resultQuestionCreate = $this->Question_Model->createTemporary($dataReceiveFromPost);
        echo json_encode($resultQuestionCreate);
    }

    
	public function reorder(){
        $this->Module_Model->reorder($this->input->post("module"));
    }

   
    public function edit(){
        $dataReceiveFromPost = array(
            'questionId' => $this->input->post("questionId"),
            'question' => $this->input->post("question"),
            'questionImageName' => $this->input->post("questionImageName"),
            'type' => $this->input->post("type"),
            'weight' => $this->input->post("weight"),
            'feedback' => $this->input->post("feedback"),
            'status' => "definitive"
        );
        $resultQuestionEdit = $this->Question_Model->edit($dataReceiveFromPost);
        echo json_encode($resultQuestionEdit);
    }

   
    public function listing(){
        $examId = $this->input->post("examId");
        $questionList = $this->Question_Model->listing($examId);
        echo json_encode($questionList);
    }

    
    
    public function delete(){
        $questionId = $this->input->post("questionId");
        $resultQuestionDelete = $this->Question_Model->delete($questionId);
        echo json_encode($resultQuestionDelete);
    }

    public function avaliateFeedback(){
        $questionId = $this->input->post("questionId");
        $avaliation = $this->input->post("avaliation");
        $result = $this->Question_Model->avaliateFeedback($questionId, $avaliation);
        echo json_encode($result);
    }
}
