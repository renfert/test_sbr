<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Corrections_Model extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->load->model('Instructors_Model');
    }
    
    
    public function listing($instructorId){
        $courses = $this->Instructors_Model->getInstructorCourses(getUserId());
        $coursesArray = array();
        foreach($courses as $row){
            $courseId = $row->mycourse_id;  
            array_push($coursesArray, $courseId);
        }

        $this->db->select("T1.title as exam, T2.title as course, T3.name as student, T3.id as studentId, T1.id , T1.approval, T0.status as status,T0.retest,(SELECT COUNT(DISTINCT T4.question_id) as lessonsToEvaluate  FROM users_answers T4 INNER JOIN relationship T5 ON T4.question_id = T5.question_id
        WHERE T4.myuser_id = T3.id AND T5.mylesson_id = T1.id AND T4.score IS NULL ) as questionsToEvaluate");
        $this->db->distinct();
        $this->db->from("lesson_status T0");
        $this->db->join("mylesson T1", "T0.mylesson_id = T1.id");
        $this->db->join("mycourse T2 ", "T0.mycourse_id = T2.id");
        $this->db->join("myuser T3", "T0.myuser_id = T3.id");
        $this->db->where("T1.type_mylesson_id", 8);
        $this->db->where("T3.myrole_id", 3);
        $this->db->where("T0.retest !=", 0);
        $this->db->where_in("T0.mycourse_id", $coursesArray);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function listingQuestions($examId, $studentId){  
        $this->db->select("T1.id,T1.feedback, T1.weight, T1.position, T1.question, T1.question, T1.image, T1.type_question_id, T2.score");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("question T1", "T0.question_id = T1.id");
        $this->db->join("users_answers T2", "T1.id = T2.question_id", "left");
        $this->db->where("T0.mylesson_id", $examId);
        $this->db->where("T1.id !=", 1);
        $this->db->where("T1.status !=", "temporary");
        $this->db->where("T2.myuser_id", $studentId);
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

}