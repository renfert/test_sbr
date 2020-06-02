<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify_Model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

    public function userIsInCourse($userId, $courseId){
        $this->db->select("myuser_id");
        $this->db->distinct();
        $this->db->from("relationship");
        $this->db->where("myuser_id", $userId);
        $this->db->where("mycourse_id", $courseId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function correctAnswerExist($questionId){
        $this->db->select("T0.id");
        $this->db->distinct();
        $this->db->from("answer T0");
        $this->db->join("relationship T1", "T1.answer_id = T0.id");
        $this->db->where("T1.question_id", $questionId);
        $this->db->where("T0.id !=", 1);
        $this->db->where("T0.correct IS NOT NULL", NULL, FALSE);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


}