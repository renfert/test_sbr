<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answer_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
    }
    
    
	public function create($dataReceiveFromPost){
        $position = $this->getPositionForThisAnswer($dataReceiveFromPost["questionId"]);
        $relationShipInformation = $this->getRelationshipInformation($dataReceiveFromPost["questionId"]);
        

        $data = array(
            'answer' => $dataReceiveFromPost["answer"],
            'position' => $position,
        );

        $this->db->insert("answer", $data);
        $answerId = $this->db->insert_id();

        $data = array(
            'myuser_id' => 1,
            'mycourse_id' => $relationShipInformation["mycourse_id"],
            'mymodule_id' => $relationShipInformation["mymodule_id"],
            'mylesson_id' => $relationShipInformation["mylesson_id"],
            'mygroup_id' => 1,
            'question_id' => $dataReceiveFromPost["questionId"],
            'answer_id' => $answerId,
            'program_id' => 1
        );
        $this->db->insert("relationship", $data);
        return $answerId;
    }

    private function getPositionForThisAnswer($questionId){
        $this->db->select("count(T0.answer_id) as totalAnswers");
        $this->db->from("relationship T0");
        $this->db->where("T0.question_id", $questionId);
        $this->db->where("T0.answer_id !=", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            $numberOfAnswers = $result[0]->totalAnswers;
        }

        return $numberOfAnswers + 1;
    }

    private function getRelationshipInformation($questionId){
        $this->db->select("*");
        $this->db->from("relationship");
        $this->db->where("question_id", $questionId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $ar = array();
            $result = $query->result();
            $ar["mycourse_id"] = $result[0]->mycourse_id;
            $ar["mymodule_id"] =  $result[0]->mymodule_id;
            $ar["mylesson_id"] = $result[0]->mylesson_id;
            return $ar;
        }
    }

   
	public function reorder($answers){
        foreach($answers as $key=>$val){
            $answerId = $key;
            $position = $val + 1;

            $data = array(
                'position' => $position
            );

            $this->db->where("id", $answerId);
            $this->db->update("answer", $data);
        }
    }

    
   
	public function edit($dataReceiveFromPost){
        $answerId = $dataReceiveFromPost["answerId"];
        $answer = $dataReceiveFromPost["answer"];
    
        $data = array(
            'answer' => $answer,
        );
        $this->db->where("id", $answerId);
        if($this->db->update("answer", $data)){
            return true;
        }else{
            return false;
        }
        
    }

    
   
	public function delete($answerId){
        /* Delete from relationship */
        $this->db->where('answer_id',$answerId);
        $this->db->delete("relationship");
        
        /* Delete from answer table */
        $this->db->where('id',$answerId);
        $this->db->delete("answer");
        return true;
    }
    
    
    
    public function listing($questionId){
        $this->db->select("T1.id,T1.answer, T1.correct, T1.position");
        $this->db->from("relationship T0");
        $this->db->join('answer T1', 'T0.answer_id = T1.id');
        $this->db->where("T0.question_id", $questionId);
        $this->db->where("T1.id !=", 1);
        $this->db->order_by('position', 'ASC');
      
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function getStudentAnswer($questionId, $studentId){
        $this->db->select("T0.myuser_id,T0.question_id,T0.answer,T0.score,T0.feedback,T0.feedback_useful,T0.feedback_user,T1.feedback as automaticFeedback");
        $this->db->from("users_answers T0");
        $this->db->join("question T1", "T0.question_id = T1.id");
        $this->db->where("myuser_id", $studentId);
        $this->db->where("question_id", $questionId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function changeStatus($answerId, $status){
        $data = array(
            'correct' => $status
        );
        $this->db->where("id", $answerId);
        if($this->db->update("answer", $data)){
            return true;
        }else{
            return false;
        }
        
    }
}