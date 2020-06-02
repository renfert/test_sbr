<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program_Model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('Verify_Model');
        $this->load->model('Lesson_Model');
        $this->load->model('Course_Model');
    }


    
	public function create($dataReceiveFromPost, $courses){
        $this->db->insert("program", $dataReceiveFromPost);
        $programId =  $this->db->insert_id();

    
        /* Save courses into a program */
        $this->saveCoursesIntoProgram($programId, $courses);

        /* Enroll adm into this program */
        $this->enrollUserIntoProgram($programId, 1);

        /* Eroll user creator into this program */
        $this->enrollUserIntoProgram($programId, getUserId());


        return $programId;
    }

    public function saveCoursesIntoProgram($programId, $courses){
        foreach($courses as $index => $course){
            $data = array(
                'program_id' => $programId,
                'mycourse_id' => $course,
                'position' => $index
            );
            $this->db->insert("program_has_mycourse", $data);
        }
    }

    public function enrollUserIntoProgram($programId, $userId){
        $data = array(
            'myuser_id' => $userId,
            'mycourse_id' => 1,
            'mymodule_id' => 1,
            'mylesson_id' => 1,
            'mygroup_id' => 1,
            'question_id' => 1,
            'answer_id' => 1,
            'program_id' => $programId
        );
        $this->db->insert("relationship", $data);

        $this->db->select("T1.id");
        $this->db->distinct();
        $this->db->from("program_has_mycourse T0");
        $this->db->join("mycourse T1" , "T0.mycourse_id = T1.id");
        $this->db->where("T0.program_id", $programId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $courseId = $row->id;
                $this->Course_Model->enrollUserIntoCourse($courseId,$userId);
            }
        }
   }

  
    public function listing(){
        $this->db->select("
            T1.id,
            T1.title,
            T1.photo, 
            T1.release_date, 
            T1.expiration_date, 
            (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons,
            (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("program T1", "T0.program_id = T1.id");
        $this->db->where("T0.myuser_id", getUserId());
        $this->db->where("T1.id !=",1);
        $this->db->order_by("T1.id", "DESC");
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }
    }

   
    public function viewProgram($programId){
        $this->db->select("*");
        $this->db->from("mycourse");
        $this->db->where("id" , $courseId );
        $query = $this->db->get();
       
        if($query->num_rows() > 0){
            return $query->row();
        }
    }

    public function getCourses(){
        $this->db->select("T0.id as key, T0.title as label");
        $this->db->distinct();
        $this->db->from("mycourse T0 ");
        $this->db->join("relationship T1", "T0.id = T1.mycourse_id");
        $this->db->where("T1.myuser_id ", getUserId());
        $this->db->where("T1.mycourse_id !=", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    private function getAllUsersIntoThisProgram($programId){
        $this->db->select("T1.id");
        $this->db->distinct();
        $this->db->from("relationship T0");
        $this->db->join("myuser T1", "T0.myuser_id = T1.id ");
        $this->db->where("T0.program_id", $programId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    private function getAllCoursesIntoProgram($programId){
        $this->db->select("T0.mycourse_id");
        $this->db->distinct();
        $this->db->from("program_has_mycourse T0");
        $this->db->where("T0.program_id", $programId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function delete($programId){
        /* Get all users and courses into this program */
        $users = $this->getAllUsersIntoThisProgram($programId);
        foreach($users as $user){
            $courses = $this->getAllCoursesIntoProgram($programId);
            foreach($courses as $course){
                $this->Course_Model->removeUserFromCourse($user->id, $course->mycourse_id);
            }
        }

        /* Delete from relationship */
        $this->db->where("program_id", $programId);
        $this->db->delete("relationship");

        /* Delete from program_has_mycourse */
        $this->db->where("program_id", $programId);
        $this->db->delete("program_has_mycourse");

        /* Delete program */
        $this->db->where("id", $programId);
        $this->db->delete("program");
    }

    public function getPersonsOutsideTheProgram($programId){
        $this->db->select("T0.id as key, T0.name as label");
        $this->db->distinct();
        $this->db->from("myuser T0");
        $this->db->where("T0.id not in (SELECT myuser_id FROM relationship WHERE program_id = $programId)");
        $query = $this->db->get(); 
        if($query->num_rows() > 0 ){
            return $query->result();
        }

    }

  

}